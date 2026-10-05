#!/usr/bin/env python3
"""SEO / AEO / GEO readiness audit of every published page on reinforcelab.online, against the
build standard (claude/seo-geo-aeo-standard.md, D-012). Reads the live HTML, i.e. what search
engines and LLM crawlers receive. Usage: python3 claude/tools/seo-audit.py out.json
"""
import json, re, sys, subprocess, concurrent.futures as cf
from urllib.parse import urljoin, urlparse
from bs4 import BeautifulSoup

SITE = 'https://reinforcelab.online'
ROOT = __file__.rsplit('/claude/', 1)[0]
pages = [p for p in json.load(open(ROOT + '/claude/data/online-snapshot/pages.json')) if p['status'] == 'publish']

def fetch(url):
    for _ in range(3):
        r = subprocess.run(['curl', '-s', '-L', '--max-time', '60', '-w', '\n__T%{time_starttransfer}', url], capture_output=True, text=True)
        if r.stdout and '__T' in r.stdout:
            body, t = r.stdout.rsplit('\n__T', 1)
            if len(body) > 1000: return body, float(t)
    return '', 0.0

def template(path):
    if path == '': return 'home'
    if path.startswith('services/agents/'): return 'agent'
    if path == 'services/agents': return 'hub'
    if path.startswith('services/'): return 'service'
    if path in ('services', 'industries'): return 'hub'
    if path.startswith('industries/'): return 'industry'
    return {'about-us': 'about', 'contact-us': 'contact', 'blog': 'blog', 'awards': 'company'}.get(path, 'product')

def types_of(n):
    t = n.get('@type', [])
    return t if isinstance(t, list) else [t]

def audit(p):
    path = (p['path'] or '').strip('/')
    url = SITE + '/' + (path + '/' if path else '')
    html, ttfb = fetch(url)
    s = BeautifulSoup(html, 'lxml')
    r = {'path': path or '/', 'id': p['id'], 'template': template(path), 'bytes': len(html.encode()), 'ttfb': round(ttfb, 2)}
    t = s.title.get_text(strip=True) if s.title else ''
    md = s.find('meta', attrs={'name': 'description'}); md = md['content'] if md else ''
    can = s.find('link', rel='canonical'); can = can['href'] if can else ''
    rob = s.find('meta', attrs={'name': 'robots'}); rob = rob['content'] if rob else ''
    r.update(title=t, title_len=len(t), title_brand='Reinforce Lab' in t, meta=md, meta_len=len(md), canonical_ok=(can == url), robots=rob)
    # landmarks
    r['landmarks'] = {k: bool(s.find(k)) for k in ('header', 'main', 'nav', 'footer')}
    # schema
    graph = []
    for sc in s.find_all('script', type='application/ld+json'):
        try:
            d = json.loads(sc.string or '{}')
            graph += d.get('@graph', [d]) if isinstance(d, dict) else d
        except Exception as e:
            r.setdefault('schema_errors', []).append(str(e)[:80])
    ts = sorted({x for n in graph for x in types_of(n)})
    r['schema_types'] = ts
    org = next((n for n in graph if 'Organization' in types_of(n)), {})
    r['org'] = {k: bool(org.get(k)) for k in ('name', 'legalName', 'logo', 'sameAs', 'contactPoint', 'foundingDate', 'award')}
    r['org_sameAs'] = org.get('sameAs', [])
    wp = next((n for n in graph if 'WebPage' in types_of(n)), {})
    r['dateModified'] = wp.get('dateModified', '')
    faq_schema = sum(len(n.get('mainEntity', [])) for n in graph if 'FAQPage' in types_of(n))
    r['faq_schema_q'] = faq_schema
    # content: drop chrome
    for sel in ['header', 'footer', '#rl-mobile', 'script', 'style', 'noscript', '.rl-footer', '.rl-header', '.rl-ph']:
        for e in s.select(sel): e.decompose()
    main = s.select_one('.rl-page') or s.select_one('[class^="rl-"]') or s.body or s
    hs = [(h.name, h.get_text(' ', strip=True)) for h in main.find_all(re.compile('^h[1-6]$'))]
    r['h1'] = sum(1 for h in hs if h[0] == 'h1')
    r['h1_text'] = next((h[1] for h in hs if h[0] == 'h1'), '')
    h2 = [h[1] for h in hs if h[0] == 'h2']
    r['h2'] = len(h2); r['h2_questions'] = sum(1 for x in h2 if x.strip().endswith('?'))
    lv = [int(h[0][1]) for h in hs]; r['heading_skips'] = sum(1 for a, b in zip(lv, lv[1:]) if b > a + 1)
    text = main.get_text(' ', strip=True); words = len(re.findall(r"[A-Za-z0-9'’]+", text))
    r['words'] = words
    h1 = main.find('h1'); lede = ''
    if h1:
        nx = h1.find_next('p')
        lede = nx.get_text(' ', strip=True) if nx else ''
    r['lede'] = lede[:240]; r['lede_words'] = len(lede.split())
    r['answer_first'] = bool(re.search(r'\b(is|are|helps?|makes?|builds?|gives?|means|turns?|connects?|runs?)\b', ' '.join(lede.split()[:30]), re.I))
    r['brand_early'] = 'Reinforce Lab' in ' '.join(text.split()[:200])
    r['faq_visible'] = len(main.select('.faq details, details'))
    r['lists'] = len(main.find_all(['ul', 'ol'])); r['tables'] = len(main.find_all('table'))
    r['breadcrumb_visible'] = bool(s.select_one('.crumbs, nav[aria-label=Breadcrumb]'))
    links = []; ext = []
    for a in main.find_all('a', href=True):
        h = urljoin(url, a['href'])
        u = urlparse(h)
        if u.netloc == 'reinforcelab.online':
            if u.path != urlparse(url).path or not u.fragment: links.append(u.path)
        elif u.scheme.startswith('http') and not re.search(r'linkedin|facebook|twitter|x\.com|instagram|tumblr|pinterest|youtube', u.netloc): ext.append(u.netloc)
    r['internal_out'] = sorted(set(l for l in links if l != urlparse(url).path)); r['external_domains'] = sorted(set(ext))
    imgs = main.find_all('img'); r['imgs'] = len(imgs)
    r['img_no_alt'] = sum(1 for i in imgs if not (i.get('alt') or '').strip()); r['img_no_size'] = sum(1 for i in imgs if not (i.get('width') and i.get('height')))
    r['svgs_titled'] = sum(1 for v in main.find_all('svg') if v.find('title')); r['svgs'] = len(main.find_all('svg'))
    r['copy_text'] = text
    return r

def main():
    out = sys.argv[1]
    with cf.ThreadPoolExecutor(6) as ex: res = list(ex.map(audit, pages))
    inbound = {}
    for r in res:
        for l in r['internal_out']: inbound.setdefault(l, set()).add(r['path'])
    for r in res:
        key = '/' if r['path'] == '/' else '/' + r['path'] + '/'
        r['internal_in'] = len(inbound.get(key, ()))
        r['internal_out_n'] = len(r['internal_out'])
    titles = {}; metas = {}
    for r in res: titles.setdefault(r['title'], []).append(r['path']); metas.setdefault(r['meta'], []).append(r['path'])
    for r in res: r['title_dup'] = len(titles[r['title']]) > 1; r['meta_dup'] = len(metas[r['meta']]) > 1 and r['meta'] != ''
    json.dump(res, open(out, 'w'), indent=1)
    print(len(res), 'pages')

main()
