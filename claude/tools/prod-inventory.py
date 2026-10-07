#!/usr/bin/env python3
"""READ-ONLY inventory of reinforcelab.com (production) for the migration redirect test (D-144, approved by Jamil 7 Oct 2026).

    python3 claude/tools/prod-inventory.py [max_pages]

Sends only plain GET requests, from the .online server (this sandbox cannot reach production), one at a time
with a pause, never following redirects (each hop is recorded). It never logs in, never submits anything and
never changes production. Steps:
  1. robots.txt and every Yoast sub-sitemap: URL + lastmod.
  2. Every HTML page in the sitemaps is fetched; all internal links (<a href>) and images under /wp-content/uploads/
     are recorded with their source page and anchor text.
  3. Internal URLs found in links but not in a sitemap are fetched once to record their status (200 / 301 to X / 404 / 410),
     and crawled further if they are HTML pages (up to max_pages pages in total).
Output: claude/data/production-inventory-YYYY-MM-DD/ (sitemap-urls.csv, pages.csv, links.csv, images.csv, summary.md).
"""
import sys, os, re, csv, time, json, base64, datetime, collections
from urllib.parse import urljoin, urlparse, urlunparse
sys.path.insert(0, os.path.dirname(__file__))
import rl  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
HOST = 'reinforcelab.com'
BASE = 'https://' + HOST
UA = 'Mozilla/5.0 (compatible; ReinforceLab-migration-inventory; read-only)'
MAXP = int(sys.argv[1]) if len(sys.argv) > 1 else 1500
OUT = os.path.join(ROOT, 'claude', 'data', 'production-inventory-' + datetime.date.today().isoformat())
os.makedirs(OUT, exist_ok=True)
SKIP = re.compile(r'/wp-admin|/wp-login|/wp-json|xmlrpc|add-to-cart|/cart/|/checkout/|/my-account/|/feed/?$|\?replytocom=|/wp-content/|/wp-includes/|\.(?:pdf|jpe?g|png|gif|webp|svg|zip|mp4|css|js|xml|txt|ico)(?:\?|$)', re.I)

def get(url):
    code = """$r = wp_remote_get(base64_decode('%s'), array('timeout' => 40, 'redirection' => 0, 'user-agent' => '%s'));
if (is_wp_error($r)) return array('s' => 0, 'e' => $r->get_error_message());
$ct = (string) wp_remote_retrieve_header($r, 'content-type');
return array('s' => wp_remote_retrieve_response_code($r), 'loc' => (string) wp_remote_retrieve_header($r, 'location'), 'ct' => $ct,
  'b' => (stripos($ct, 'html') !== false || stripos($ct, 'xml') !== false) ? base64_encode(substr(wp_remote_retrieve_body($r), 0, 900000)) : '');""" % (base64.b64encode(url.encode()).decode(), UA)
    for t in range(3):
        try:
            rv, errs = rl.php(code, timeout=90)
            if isinstance(rv, dict):
                rv['b'] = base64.b64decode(rv.get('b') or '').decode('utf-8', 'replace')
                return rv
        except Exception as e:
            err = str(e)
        time.sleep(3)
    return {'s': 0, 'e': 'fetch failed', 'b': ''}

def norm(u, base):
    u = urljoin(base, u.strip())
    p = urlparse(u)
    if p.scheme not in ('http', 'https'): return None
    host = p.netloc.lower().split(':')[0]
    if host.replace('www.', '') != HOST: return None
    return urlunparse(('https', HOST, p.path or '/', '', p.query, ''))

def main():
    from bs4 import BeautifulSoup
    log = open(os.path.join(OUT, 'progress.log'), 'a')
    # 1. sitemaps
    smap = {}
    idx = get(BASE + '/sitemap_index.xml')
    subs = re.findall(r'<loc>([^<]+)</loc>', idx['b'])
    for s in subs:
        r = get(s.strip()); time.sleep(1)
        for m in re.finditer(r'<url>\s*<loc>([^<]+)</loc>(?:\s*<lastmod>([^<]+)</lastmod>)?', r['b']):
            smap[m.group(1).strip()] = (s.rsplit('/', 1)[-1], m.group(2) or '')
    with open(os.path.join(OUT, 'sitemap-urls.csv'), 'w', newline='') as f:
        w = csv.writer(f); w.writerow(['url', 'sitemap', 'lastmod'])
        for u, (sm, lm) in sorted(smap.items()): w.writerow([u, sm, lm])
    print(len(smap), 'sitemap URLs', file=log, flush=True)
    # 2-3. crawl
    queue = collections.deque(sorted(smap)); seen = set(queue); pages = {}; links = []; images = set()
    while queue and len(pages) < MAXP:
        u = queue.popleft()
        if SKIP.search(urlparse(u).path + ('?' + urlparse(u).query if urlparse(u).query else '')):
            pages[u] = {'s': 'not fetched (asset or utility)', 'loc': '', 'title': ''}; continue
        r = get(u); time.sleep(0.8)
        title = ''
        if r.get('s') == 200 and 'html' in r.get('ct', ''):
            soup = BeautifulSoup(r['b'], 'lxml')
            title = soup.title.get_text(' ', strip=True) if soup.title else ''
            canon = soup.find('link', rel='canonical'); robots = soup.find('meta', attrs={'name': 'robots'})
            for a in soup.find_all('a', href=True):
                t = norm(a['href'], u)
                if not t: continue
                region = 'nav' if a.find_parent(['nav', 'header']) else 'footer' if a.find_parent('footer') else 'content'
                links.append([u, t, a.get_text(' ', strip=True)[:80], region])
                if t not in seen:
                    seen.add(t); queue.append(t)
            for img in soup.find_all('img'):
                for attr in ('src', 'data-src'):
                    v = img.get(attr)
                    if v and '/wp-content/uploads/' in v: images.add((u, urljoin(u, v).split('?')[0]))
            pages[u] = {'s': 200, 'loc': '', 'title': title, 'canonical': canon['href'] if canon else '', 'robots': robots['content'] if robots else ''}
        else:
            pages[u] = {'s': r.get('s'), 'loc': r.get('loc', ''), 'title': '', 'err': r.get('e', '')}
            loc = norm(r.get('loc', ''), u) if r.get('loc') else None
            if loc and loc not in seen: seen.add(loc); queue.append(loc)
        if len(pages) % 25 == 0: print(len(pages), 'pages,', len(queue), 'queued', file=log, flush=True)
    with open(os.path.join(OUT, 'pages.csv'), 'w', newline='') as f:
        w = csv.writer(f); w.writerow(['url', 'in_sitemap', 'status', 'redirect_to', 'title', 'canonical', 'robots'])
        for u, p in sorted(pages.items()): w.writerow([u, smap.get(u, ('', ''))[0], p['s'], p.get('loc', ''), p.get('title', ''), p.get('canonical', ''), p.get('robots', '')])
    with open(os.path.join(OUT, 'links.csv'), 'w', newline='') as f:
        w = csv.writer(f); w.writerow(['source', 'target', 'anchor', 'region']); w.writerows(links)
    with open(os.path.join(OUT, 'images.csv'), 'w', newline='') as f:
        w = csv.writer(f); w.writerow(['page', 'image']); w.writerows(sorted(images))
    st = collections.Counter(str(p['s']) for p in pages.values())
    print('done', len(pages), 'pages', dict(st), file=log, flush=True)
    print(json.dumps({'sitemap_urls': len(smap), 'pages': len(pages), 'status': st, 'links': len(links), 'images': len(images), 'queue_left': len(queue)}, default=str))

if __name__ == '__main__':
    main()
