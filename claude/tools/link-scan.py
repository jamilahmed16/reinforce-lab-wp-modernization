#!/usr/bin/env python3
"""A4 gate: internal link scan of every published page, post and project on reinforcelab.online.

  python3 claude/tools/link-scan.py                       # reinforcelab.online (page list from WordPress, via Novamira)
  python3 claude/tools/link-scan.py https://staging.example  # any other copy (page list from its XML sitemaps)

For every published page, post and project (plus /blog/ pages) it reads the HTML, collects every <a href> and
<img src> that points inside the site (relative, reinforcelab.online, or reinforcelab.com written out in full),
then requests each target once without following redirects. Pass mark (migration checklist A4):
  0 links to a 404, 410 or redirect; 0 links written out as reinforcelab.online in the database.
Links to reinforcelab.com written out in full are listed too: after the switch they are internal links.
Report: claude/research/link-scan/<date>.json and a printed summary.
"""
import collections
import concurrent.futures as cf
import datetime
import html as htmllib
import json
import os
import re
import sys
import urllib.error
import urllib.parse
import urllib.request

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import rl  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
SITE = (sys.argv[1] if len(sys.argv) > 1 else 'https://reinforcelab.online').rstrip('/')
DEV = SITE == 'https://reinforcelab.online'
HOSTS = ('reinforcelab.online', 'www.reinforcelab.online', urllib.parse.urlparse(SITE).netloc)
PROD = ('reinforcelab.com', 'www.reinforcelab.com')
SKIP = re.compile(r'^/(wp-admin|wp-login\.php|wp-json|xmlrpc\.php|feed|comments/feed)\b|^/\?|^/cdn-cgi/')


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *a, **k):
        return None


OPENER = urllib.request.build_opener(NoRedirect)


def get(url, body=False):
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0 (rl-link-scan)'})
    for _ in range(3):
        try:
            r = OPENER.open(req, timeout=60)
            return r.status, r.headers.get('Location', ''), (r.read().decode('utf8', 'replace') if body else '')
        except urllib.error.HTTPError as e:
            return e.code, e.headers.get('Location', ''), ''
        except Exception as e:
            err = e.__class__.__name__
    return 'ERR:' + err, '', ''


def internal_path(href, page):
    href = htmllib.unescape(href.strip())
    if not href or href.startswith(('#', 'mailto:', 'tel:', 'javascript:', 'data:', 'sms:', 'whatsapp:')):
        return None, None
    u = urllib.parse.urlparse(urllib.parse.urljoin(page, href))
    if u.scheme not in ('http', 'https'):
        return None, None
    host = u.netloc.lower()
    if host in HOSTS:
        kind = 'site'
    elif host in PROD:
        kind = 'production'
    else:
        return None, None
    path = u.path or '/'
    q = urllib.parse.parse_qsl(u.query, keep_blank_values=True)
    q = [(k, v) for k, v in q if k not in ('bg', 'nc')]  # preview switches added by our own code
    return (path + ('?' + urllib.parse.urlencode(q) if q else '')), kind


def sitemap_urls():
    """Every page, post and project listed in Yoast's sitemaps (staging and live copies; they have no Novamira)."""
    c, loc, idx = get(SITE + '/sitemap_index.xml', True)
    maps = [m for m in re.findall(r'<loc>([^<]+)</loc>', idx) if re.search(r'/(page|post|rl_project)-sitemap\d*\.xml', m)]
    urls = []
    for m in maps:
        urls += re.findall(r'<loc>([^<]+)</loc>', get(htmllib.unescape(m), True)[2])
    if not urls:
        raise SystemExit('no URLs found in %s/sitemap_index.xml' % SITE)
    return [htmllib.unescape(u) for u in urls if not re.search(r'\.(jpe?g|png|webp|gif)$', u)]


def main():
    if DEV:
        urls, _ = rl.php('return array_values(array_map("get_permalink", get_posts(["post_type" => ["page","post","rl_project"], "post_status" => "publish", "numberposts" => -1, "fields" => "ids"])));', 120)
    else:
        urls = sitemap_urls()
    urls = sorted(set(urls) | {SITE + '/blog/'})
    pages = {}
    with cf.ThreadPoolExecutor(max_workers=6) as ex:
        for u, (c, loc, h) in zip(urls, ex.map(lambda u: get(u, True), urls)):
            pages[u] = (c, h)
    # blog pagination pages
    m = re.findall(r'href="[^"]*/blog/page/(\d+)/"', pages.get(SITE + '/blog/', (0, ''))[1])
    for n in range(2, max([int(x) for x in m] or [1]) + 1):
        u = '%s/blog/page/%d/' % (SITE, n)
        c, loc, h = get(u, True)
        pages[u] = (c, h)
    links = collections.defaultdict(lambda: {'from': set(), 'kind': set(), 'tag': set()})
    for u, (c, h) in pages.items():
        h = re.sub(r'<script\b.*?</script>|<!--.*?-->', '', h, flags=re.S)
        for tag, attr in (('a', 'href'), ('img', 'src'), ('link', 'href')):
            for m in re.finditer(r'<%s\b[^>]*?\s%s=["\']([^"\']+)["\']' % (tag, attr), h, flags=re.I):
                if tag == 'link' and not re.search(r'rel=["\'](canonical|prev|next|alternate)["\']', m.group(0)):
                    continue
                p, kind = internal_path(m.group(1), u)
                if not p or SKIP.search(p):
                    continue
                path = urllib.parse.urlparse(u).path
                links[p]['from'].add(path)
                links[p]['kind'].add(kind)
                links[p]['tag'].add(tag)
    targets = sorted(links)
    status = {}
    with cf.ThreadPoolExecutor(max_workers=6) as ex:
        for p, (c, loc, _) in zip(targets, ex.map(lambda p: get(SITE + urllib.parse.quote(p, safe="/?=&%:+~@!$'()*,;")), targets)):
            status[p] = (str(c), urllib.parse.urlparse(urllib.parse.urljoin(SITE + '/', loc)).path if loc else '')
    bad, prod = [], []
    for p in targets:
        c, loc = status[p]
        rec = {'link': p, 'status': c, 'location': loc, 'tags': sorted(links[p]['tag']), 'pages': len(links[p]['from']), 'from': sorted(links[p]['from'])[:15]}
        if c != '200':
            bad.append(rec)
        if 'production' in links[p]['kind']:
            prod.append(rec)
    # links written out as reinforcelab.online inside stored content (they would point at the dev site after the switch)
    dev = {'posts': [], 'meta_rows': 0, 'note': 'checked on reinforcelab.online only'}
    if DEV:
        dev, _ = rl.php(r'''global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_type, post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post','rl_project') AND post_content LIKE '%reinforcelab.online%'");
$meta = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID=pm.post_id WHERE p.post_status='publish' AND pm.meta_value LIKE '%reinforcelab.online%' AND pm.meta_key NOT LIKE '\_%'");
return ['posts' => $rows, 'meta_rows' => (int) $meta];''', 120)
    else:  # on another copy, any reinforcelab.online link left in a page is a bad link
        for u, (c, h) in pages.items():
            if 'reinforcelab.online' in h and urllib.parse.urlparse(SITE).netloc != 'reinforcelab.online':
                dev['posts'].append({'page': u, 'count': h.count('reinforcelab.online')})
    day = datetime.date.today().isoformat() + ('' if DEV else '-' + urllib.parse.urlparse(SITE).netloc)
    out = os.path.join(ROOT, 'claude', 'research', 'link-scan')
    os.makedirs(out, exist_ok=True)
    pages_bad = {u: c for u, (c, h) in pages.items() if str(c) != '200'}
    json.dump({'pages_scanned': len(pages), 'pages_not_200': pages_bad, 'targets': len(targets), 'bad_links': bad, 'production_links_written_out': prod, 'dev_domain_in_content': dev},
              open(os.path.join(out, day + '.json'), 'w'), indent=1)
    by = collections.Counter(r['status'] for r in bad)
    print('pages scanned', len(pages), '| pages not 200:', len(pages_bad), '| internal link targets', len(targets))
    print('BAD LINKS:', len(bad), dict(by), '| links written as reinforcelab.com:', len(prod), '| content with reinforcelab.online written out:', len(dev['posts']), 'posts,', dev['meta_rows'], 'meta rows')
    for r in sorted(bad, key=lambda r: (-r['pages'], r['link']))[:120]:
        print('  ', r['status'], r['link'], ('-> ' + r['location']) if r['location'] else '', '| on', r['pages'], 'pages, e.g.', r['from'][0])


if __name__ == '__main__':
    main()
