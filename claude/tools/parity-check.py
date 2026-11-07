#!/usr/bin/env python3
"""Checklist A5 gate: the 17 pages kept at the same URL (D-005) still match production.

  python3 claude/tools/parity-check.py [new-base]     # default https://reinforcelab.online

Production is read with plain GET requests sent from the .online server through Novamira (read-only; the
container cannot reach reinforcelab.com). For each URL it compares production and the new site:
status, title tag, meta description, H1, section headings (H2/H3) and the word count of the main text.
"Headings kept" = share of production's section headings that also appear on the new page.
Report: claude/research/parity/<date>.json and a printed table.
"""
import base64
import datetime
import html as htmllib
import json
import os
import re
import sys
import urllib.request

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import rl  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
NEW = (sys.argv[1] if len(sys.argv) > 1 else 'https://reinforcelab.online').rstrip('/')
PROD = 'https://reinforcelab.com'
PATHS = ['/social-media-content-ideas-for-clothing-brand/', '/best-examples-of-great-food-copywriting/', '/social-media-content-ideas-for-churches/',
         '/', '/social-media-content-ideas-for-restaurants/', '/snapchat-content-ideas/', '/content-marketing-for-banks/',
         '/social-media-content-ideas-for-hotels/', '/successful-digital-marketing-campaign-examples/', '/social-media-content-ideas-for-photographers/',
         '/top-advantages-and-disadvantages-of-using-social-media/', '/social-media-content-ideas-for-nonprofits/',
         '/content-marketing-ideas-for-healthcare-industry/', '/sensory-marketing-know-how-5-senses-marketing-works-best-for-businesses/',
         '/creative-content-marketing-ideas/', '/services/website-maintenance-services/', '/copy-ai-review/']


def prod_html(path):
    r, err = rl.php(r'''$r = wp_remote_get('https://reinforcelab.com' . %s, ['timeout' => 40, 'redirection' => 0, 'user-agent' => 'Mozilla/5.0 (rl-parity-check, read-only)']);
if (is_wp_error($r)) return ['code' => 'ERR', 'body' => $r->get_error_message()];
return ['code' => wp_remote_retrieve_response_code($r), 'body' => base64_encode(gzcompress(wp_remote_retrieve_body($r)))];''' % json.dumps(path), 120)
    if r['code'] == 'ERR':
        return 'ERR', ''
    import zlib
    return r['code'], zlib.decompress(base64.b64decode(r['body'])).decode('utf8', 'replace')


def new_html(path):
    try:
        resp = urllib.request.urlopen(urllib.request.Request(NEW + path, headers={'User-Agent': 'Mozilla/5.0 (rl-parity-check)'}), timeout=60)
        return resp.status, resp.read().decode('utf8', 'replace')
    except urllib.error.HTTPError as e:
        return e.code, ''


def text(s):
    return re.sub(r'\s+', ' ', htmllib.unescape(re.sub(r'<[^>]+>', ' ', s))).strip()


def norm(s):
    return re.sub(r'[^a-z0-9]+', ' ', text(s).lower()).strip()


def facts(h):
    h = re.sub(r'<script\b.*?</script>|<style\b.*?</style>|<!--.*?-->', '', h, flags=re.S | re.I)
    title = re.search(r'<title[^>]*>(.*?)</title>', h, re.S | re.I)
    desc = re.search(r'<meta\s+name=["\']description["\']\s+content=["\']([^"\']*)', h, re.I)
    h1 = [text(x) for x in re.findall(r'<h1\b[^>]*>(.*?)</h1>', h, re.S | re.I) if text(x)]
    heads = [norm(x) for x in re.findall(r'<h[23]\b[^>]*>(.*?)</h[23]>', h, re.S | re.I) if norm(x)]
    main = re.search(r'<article\b.*?</article>', h, re.S | re.I) or re.search(r'<main\b.*?</main>', h, re.S | re.I)
    words = len(text(main.group(0) if main else h).split())
    return {'title': text(title.group(1)) if title else '', 'description': htmllib.unescape(desc.group(1)) if desc else '',
            'h1': h1, 'headings': heads, 'words': words}


def main():
    rows = []
    for p in PATHS:
        pc, ph = prod_html(p)
        nc, nh = new_html(p)
        pf, nf = (facts(ph) if ph else {}), (facts(nh) if nh else {})
        kept = [x for x in pf.get('headings', []) if x in set(nf.get('headings', []))]
        share = round(100 * len(kept) / len(pf['headings'])) if pf.get('headings') else None
        row = {'path': p, 'prod_status': pc, 'new_status': nc,
               'title_same': pf.get('title') == nf.get('title'), 'prod_title': pf.get('title'), 'new_title': nf.get('title'),
               'description_same': pf.get('description') == nf.get('description'),
               'prod_description': pf.get('description'), 'new_description': nf.get('description'),
               'prod_h1': pf.get('h1'), 'new_h1': nf.get('h1'),
               'headings_prod': len(pf.get('headings', [])), 'headings_kept_pct': share,
               'missing_headings': [x for x in pf.get('headings', []) if x not in set(nf.get('headings', []))][:15],
               'words_prod': pf.get('words'), 'words_new': nf.get('words')}
        rows.append(row)
        print('%-62s prod %s new %s | title %s | desc %s | headings kept %s%% of %s | words %s -> %s' % (
            p[:62], pc, nc, 'same' if row['title_same'] else 'DIFF', 'same' if row['description_same'] else 'DIFF',
            share, row['headings_prod'], row['words_prod'], row['words_new']))
    out = os.path.join(ROOT, 'claude', 'research', 'parity')
    os.makedirs(out, exist_ok=True)
    json.dump(rows, open(os.path.join(out, datetime.date.today().isoformat() + '.json'), 'w'), indent=1, ensure_ascii=False)


if __name__ == '__main__':
    main()
