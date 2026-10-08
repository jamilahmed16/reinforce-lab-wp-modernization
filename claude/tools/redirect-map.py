#!/usr/bin/env python3
"""Draft redirect map: every known old reinforcelab.com URL, from every source, with its approved fate (D-144).

    python3 claude/tools/redirect-map.py <production-inventory-dir>

Sources merged (path-level, query strings kept separately):
  register   claude/preserve-disposition-sheet-pagelevel-2026-09-10.csv  (631 pages, approved decisions D-014/015/023)
  gsc        claude/data/gsc-2026-09/performance/Pages.csv               (clicks, impressions, 16 months)
  backlinks  claude/data/gsc-2026-09/links/external-top-target-pages.csv (Search Console's linked pages)
  yoast      claude/data/production-config/yoast-redirects-2026-09-10.csv
  sitemap / crawl-page / crawl-link   the read-only production inventory (prod-inventory.py)
Overrides (later decisions win): claude/data/approved-redirects-2026-10.csv (D-126, D-139, D-144).
Output: claude/data/redirect-map-draft.csv and redirect-map-gaps.md next to it.
Actions: KEEP (same URL, 200), KEEP-NOINDEX, 301 (target), 410, CONFIG (robots/sitemaps, no redirect), UNDECIDED.
"""
import sys, os, re, csv, json, collections
from urllib.parse import urlparse
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
P = lambda *a: os.path.join(ROOT, *a)

def path_of(u):
    u = u.strip()
    if not u or ' ' in u.strip(): return None
    if u.startswith('http'):
        p = urlparse(u)
        if p.netloc.lower().replace('www.', '') not in ('reinforcelab.com', ''): return None
        path, q = p.path or '/', p.query
    else:
        path, _, q = u.partition('?'); path = '/' + path.lstrip('/')
    path = re.sub(r'/{2,}', '/', path)
    if not re.search(r'\.[a-z0-9]{2,5}$', path, re.I) and not path.endswith('/'): path += '/'
    return path + ('?' + q if q else '')

def parse_decision(d):
    d = d.strip()
    m = re.search(r'301\s*(?:->|→)\s*(/[^\s;,)\]]*)', d)
    if m: return '301', path_of(m.group(1))
    if re.search(r'\b410\b', d): return '410', ''
    if 'KEEP-noindex' in d: return 'KEEP-NOINDEX', ''
    if 'config-managed' in d: return 'CONFIG', ''
    if re.search(r'PRESERVE|keep URL|BUILD|REBUILD|rebuild', d, re.I): return 'KEEP', ''
    return 'UNDECIDED', ''

def main():
    inv = sys.argv[1]
    rows = collections.OrderedDict()
    def row(p):
        if p not in rows: rows[p] = {'path': p, 'sources': set(), 'prod_status': '', 'prod_redirect': '', 'clicks': '', 'impr': '', 'backlink_target': '', 'action': 'UNDECIDED', 'target': '', 'decision_source': '', 'decision_text': '', 'inlinks_prod': 0}
        return rows[p]
    # register
    for x in csv.DictReader(open(P('claude', 'preserve-disposition-sheet-pagelevel-2026-09-10.csv'))):
        p = path_of(x['url_path'])
        if not p: continue
        r = row(p); r['sources'].add('register')
        a, t = parse_decision(x['decision'])
        r.update(action=a, target=t, decision_source='register (D-014/015/023)', decision_text=x['decision'][:160])
        r['clicks'], r['impr'] = x['gsc_clicks'], x['gsc_impr']
    # gsc pages
    for x in csv.DictReader(open(P('claude', 'data', 'gsc-2026-09', 'performance', 'Pages.csv'))):
        p = path_of(x['Top pages'])
        if not p: continue
        r = row(p); r['sources'].add('gsc'); r['clicks'], r['impr'] = x['Clicks'], x['Impressions']
    # backlinks (Search Console top linked pages)
    f = P('claude', 'data', 'gsc-2026-09', 'links', 'external-top-target-pages.csv')
    if os.path.exists(f):
        rd = csv.reader(open(f)); head = next(rd)
        for x in rd:
            p = path_of(x[0])
            if not p: continue
            r = row(p); r['sources'].add('backlinks'); r['backlink_target'] = x[1] if len(x) > 1 else 'yes'
    # yoast redirects on production
    for x in csv.DictReader(open(P('claude', 'data', 'production-config', 'yoast-redirects-2026-09-10.csv'))):
        p = path_of(x['old_url'])
        if not p: continue
        r = row(p); r['sources'].add('yoast-redirect')
        if r['action'] == 'UNDECIDED':
            if x['type'] == '410': r.update(action='410', decision_source='production Yoast redirect')
            elif x['new_url'].startswith('/'): r.update(action='301', target=path_of(x['new_url']), decision_source='production Yoast redirect (target to re-check)')
    # inventory
    for x in csv.DictReader(open(os.path.join(inv, 'sitemap-urls.csv'))):
        p = path_of(x['url']); row(p)['sources'].add('sitemap')
    for x in csv.DictReader(open(os.path.join(inv, 'pages.csv'))):
        p = path_of(x['url'])
        if not p: continue
        r = row(p); r['sources'].add('crawl'); r['prod_status'] = x['status']; r['prod_redirect'] = path_of(x['redirect_to']) or '' if x['redirect_to'] else ''
    inl = collections.Counter()
    for x in csv.DictReader(open(os.path.join(inv, 'links.csv'))):
        p = path_of(x['target'])
        if p: row(p)['sources'].add('linked-from-production'); inl[p] += 1
    for p, n in inl.items(): rows[p]['inlinks_prod'] = n
    # overrides: later approvals
    for x in csv.DictReader(open(P('claude', 'data', 'approved-redirects-2026-10.csv'))):
        p = path_of(x['old_url'])
        if not p: continue
        r = row(p); r['sources'].add('approved-2026-10')
        r.update(action='301' if x['redirect_type'] == '301' else x['redirect_type'], target=path_of(x['destination_url']), decision_source='approved-redirects-2026-10 (' + x['notes'][:30] + ')')
    # rules approved later as patterns (D-139/D-144): every /author/ path except /paged-N/ junk -> /blog/
    for p, r in rows.items():
        if p.startswith('/author/') and '/paged-' not in p and r['decision_source'].startswith('register'):
            r.update(action='301', target='/blog/', decision_source='D-139/D-144 author pattern (supersedes register)')
    # approved new URLs (D-003/D-006/D-016): pages that exist on the new site
    for x in csv.DictReader(open(P('claude', 'data', 'approved-new-urls-2026-09.csv'))):
        p = path_of(x['url'])
        if p and p in rows and rows[p]['action'] == 'UNDECIDED':
            rows[p].update(action='KEEP', decision_source='approved new URL (' + x['notes'][:30] + ')')
    # F-001: every Beaver Builder /paged-N/M/ junk URL is 410 (approved RETIRE-410)
    for p, r in rows.items():
        if re.search(r'/paged-\d+/', p) and r['action'] == 'UNDECIDED':
            r.update(action='410', decision_source='F-001 paged junk rule')
    # archive pagination /X/page/N/ follows its archive X (301 to the same target, 410, or noindex if X is kept)
    for p, r in rows.items():
        m = re.match(r'^(.*/)page/\d+/$', p)
        if m and r['action'] == 'UNDECIDED' and m.group(1) in rows:
            b = rows[m.group(1)]
            a = {'KEEP': 'KEEP-NOINDEX'}.get(b['action'], b['action'])
            if a != 'UNDECIDED': r.update(action=a, target=b['target'], decision_source='pagination follows ' + m.group(1))
    # query-string variants inherit their page's fate unless decided themselves
    for p, r in rows.items():
        if '?' in p and r['action'] == 'UNDECIDED':
            base = p.split('?')[0]
            if base in rows and rows[base]['action'] != 'UNDECIDED':
                r.update(action=rows[base]['action'] + ' (as page)', target=rows[base]['target'], decision_source='inherits ' + base)
    # chains: a 301 whose target is itself redirected
    for p, r in rows.items():
        t = r['target']; hops = 0; seen = {p}
        while t and t in rows and rows[t]['action'].startswith('301') and rows[t]['target'] and hops < 5:
            if t in seen: r['decision_source'] += ' | LOOP'; break
            seen.add(t); t = rows[t]['target']; hops += 1
        if hops: r['target'] = t; r['decision_source'] += ' | chain flattened (%d)' % hops
    out = P('claude', 'data', 'redirect-map-draft.csv')
    with open(out, 'w', newline='') as f:
        w = csv.writer(f)
        w.writerow(['old_path', 'action', 'target', 'decision_source', 'prod_status', 'prod_redirect', 'gsc_clicks', 'gsc_impr', 'backlink_target', 'linked_from_prod', 'sources', 'decision_text'])
        for p, r in sorted(rows.items()):
            w.writerow([p, r['action'], r['target'], r['decision_source'], r['prod_status'], r['prod_redirect'], r['clicks'], r['impr'], r['backlink_target'], r['inlinks_prod'], ' '.join(sorted(r['sources'])), r['decision_text']])
    c = collections.Counter(r['action'] for r in rows.values())
    und = [r for r in rows.values() if r['action'] == 'UNDECIDED']
    live_und = [r for r in und if r['prod_status'] == '200' or r['clicks'] not in ('', '0') or r['backlink_target']]
    L = ['# Redirect map draft: gaps', '', f'{len(rows)} old URLs from all sources. Actions: ' + ', '.join(f'{k} {v}' for k, v in c.most_common()), '',
         f'## Undecided URLs that matter ({len(live_und)}): live on production, or with clicks, or with backlinks', '', '| Path | Prod status | Clicks | Impressions | Linked from prod | Sources |', '|---|---|---|---|---|---|']
    for r in sorted(live_und, key=lambda r: (-int(r['clicks'] or 0), r['path'])):
        L.append(f"| `{r['path']}` | {r['prod_status']} | {r['clicks']} | {r['impr']} | {r['inlinks_prod']} | {' '.join(sorted(r['sources']))} |")
    L += ['', f'## Other undecided URLs ({len(und) - len(live_und)}): not live, no clicks, no backlinks', '', ', '.join('`' + r['path'] + '`' for r in und if r not in live_und)[:20000]]
    open(P('claude', 'data', 'redirect-map-gaps.md'), 'w').write('\n'.join(L) + '\n')
    print(json.dumps({'urls': len(rows), 'actions': c, 'undecided_that_matter': len(live_und)}, default=str))

if __name__ == '__main__':
    main()
