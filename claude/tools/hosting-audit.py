#!/usr/bin/env python3
"""Final audit of the 14 hosting URLs on reinforcelab.online (dev). Read only.
  python3 claude/tools/hosting-audit.py [--json out.json]
Prints PASS or FAIL per check per URL. Exit code 1 if anything fails.
"""
import re, sys, json, datetime, subprocess, concurrent.futures as cf
SITE = 'https://reinforcelab.online'
URLS = ['best-web-hosting-services', 'best-cloud-web-hosting-services', 'black-friday-web-hosting-deals', 'reviews/best-wordpress-hosting',
        'hostinger-web-hosting', 'bluehost-wordpress-hosting', 'dreamhost-wordpress-hosting', 'namecheap-wordpress-hosting', 'cloudways-hosting',
        'kinsta-wordpress-hosting', 'flywheel-wordpress-hosting', 'a2-wordpress-hosting', 'nexcess-wordpress-hosting']
BAD = r'\b(delve|leverage|seamless|unlock|elevate|robust|cutting-edge|game-changer|landscape|empower|harness|synergy|holistic|streamline|foster|genuinely|truly)\b'
def get(u):
    r = subprocess.run(['curl', '-s', '-L', '--max-time', '40', '-w', '\n%{http_code}', u], capture_output=True, text=True).stdout
    b, c = r.rsplit('\n', 1); return b, c
def audit(slug):
    h, code = get(f'{SITE}/{slug}/'); R = {}
    txt = re.sub(r'<(script|style)[^>]*>.*?</\1>', ' ', h, flags=re.S); txt = re.sub(r'<[^>]+>', ' ', txt)
    t = re.search(r'<title>(.*?)</title>', h, re.S); t = t.group(1).strip() if t else ''
    m = re.search(r'name="description" content="([^"]*)"', h); m = m.group(1) if m else ''
    h1 = re.findall(r'<h1[\s>]', h)
    can = re.search(r'rel="canonical" href="([^"]*)"', h)
    og = re.search(r'og:image" content="([^"]*)"', h)
    ld = re.findall(r'<script type="application/ld\+json"[^>]*>(.*?)</script>', h, re.S); types = set(); okjson = True
    for b in ld:
        try:
            def walk(x):
                if isinstance(x, dict):
                    ty = x.get('@type'); [types.add(z) for z in (ty if isinstance(ty, list) else [ty])] if ty else None
                    [walk(v) for v in x.values()]
                elif isinstance(x, list): [walk(v) for v in x]
            walk(json.loads(b))
        except Exception: okjson = False
    by = re.search(r'Jamil Ahmed', txt); upd = re.search(r'updated\s+(\d{1,2} \w{3} 20\d\d)', txt, re.I)
    R['200'] = code == '200'
    R['title 30-60'] = 30 <= len(t) <= 60
    R['meta 135-160'] = 135 <= len(m) <= 160
    R['one H1'] = len(h1) == 1
    # canonical is off on .online by design (migration-checklist A6); once indexing is on it must be self-referencing
    R['canonical self (or off on noindex dev)'] = (bool(can) and can.group(1).rstrip('/') == f'{SITE}/{slug}'.rstrip('/')) or (not can and 'noindex' in h)
    R['noindex (dev)'] = 'noindex' in h
    R['JSON-LD parses'] = okjson and bool(ld)
    R['FAQPage'] = 'FAQPage' in types
    R['no dashes'] = not re.search('[–—]', txt)
    R['no banned words'] = not re.search(BAD, txt, re.I)
    R['no emoji'] = not re.search('[\U0001F300-\U0001FAFF☀-➿]', txt)
    R['cover is new'] = bool(og) and 'cover-' in og.group(1) or slug.startswith('reviews/')
    R['author Jamil'] = bool(by) or slug.startswith('reviews/')
    R['no "From From"'] = 'From From' not in txt
    R['updated 20-28 Nov'] = bool(upd) or slug.startswith('reviews/')
    if upd:
        d = datetime.datetime.strptime(upd.group(1), '%d %b %Y').date(); R['updated 20-28 Nov'] = datetime.date(2026, 11, 20) <= d <= datetime.date(2026, 11, 28)
    links = sorted(set(re.findall(r'href="(?:https://reinforcelab\.online)?(/[^"#?]*)"', h)))
    links = [l for l in links if not re.search(r'wp-content|wp-json|feed|xmlrpc|\.(css|js|png|jpg|svg|ico|xml)$', l)]
    bad = [l for l in links if get(SITE + l)[1] != '200']
    R['internal links 200'] = not bad
    return slug, R, dict(title=t, meta=len(m), links=len(links), bad=bad, words=len(txt.split()), types=sorted(x for x in types if x))
def main():
    with cf.ThreadPoolExecutor(4) as ex: res = list(ex.map(audit, URLS))
    fails = 0; out = {}
    for s, R, info in res:
        f = [k for k, v in R.items() if not v]; fails += len(f); out[s] = dict(checks=R, info=info)
        print(('PASS ' if not f else 'FAIL ') + s, '| words', info['words'], '| links', info['links'], '| schema', ','.join(info['types'][:6]))
        for k in f: print('   x', k, info['bad'] if k == 'internal links 200' else '')
    print(f'\n{len(res)} URLs, {fails} failed checks')
    if '--json' in sys.argv: json.dump(out, open(sys.argv[sys.argv.index('--json') + 1], 'w'), indent=1)
    sys.exit(1 if fails else 0)
main()
