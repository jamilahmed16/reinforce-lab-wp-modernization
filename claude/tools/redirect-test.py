#!/usr/bin/env python3
"""A4 gate: test every known old address against the approved map. Pass mark: 0 failures.

  python3 claude/tools/redirect-test.py                  # against https://reinforcelab.online
  python3 claude/tools/redirect-test.py https://reinforcelab.com   # after the switch (first hour)

For every row of claude/data/redirect-map-draft.csv it requests the address as it is, and (for page
addresses) without the trailing slash and with a query string, without following redirects, then checks:
  KEEP*            -> 200 (one canonical hop allowed for the variants); 200 or 404 where production answers 404
  301 / 301 (as page) -> one 301 straight to the approved target (variants: one hop to the same target)
  410              -> 410 (missing /wp-content/ files: 404 accepted until the server rule exists, reported)
  /author/...      -> 301 to /blog/ (D-144); /paged-N/ junk -> 410 (F-001)
  CONFIG           -> anything but a server error (Yoast sitemaps), reported
Every 301 target must answer 200.
Report: claude/research/redirect-test/<date>-<host>.json and a printed summary.
"""
import concurrent.futures as cf
import csv
import datetime
import json
import os
import re
import ssl
import sys
import urllib.error
import urllib.parse
import urllib.request

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
SRC = os.path.join(ROOT, 'claude', 'data', 'redirect-map-draft.csv')
BASE = (sys.argv[1] if len(sys.argv) > 1 else 'https://reinforcelab.online').rstrip('/')
HOST = urllib.parse.urlparse(BASE).netloc


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *a, **k):
        return None


CTX = ssl.create_default_context()
OPENER = urllib.request.build_opener(NoRedirect, urllib.request.HTTPSHandler(context=CTX))


def fetch(url):
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0 (rl-redirect-test)'}, method='GET')
    for attempt in range(3):
        try:
            r = OPENER.open(req, timeout=40)
            return r.status, r.headers.get('Location', '') or ''
        except urllib.error.HTTPError as e:
            return e.code, e.headers.get('Location', '') or ''
        except Exception as e:  # network hiccup through the proxy: retry
            err = e.__class__.__name__
    return 'ERR:' + err, ''


def path_of(loc):
    if not loc:
        return ''
    u = urllib.parse.urlparse(urllib.parse.urljoin(BASE + '/', loc))
    return u.path + (('?' + u.query) if u.query else '')


PATHRULE = {}
KEPT404 = set()


def expected(row):
    act, p = row['action'].strip(), row['old_path']
    # an address with a query part follows its path's rule (D-148), except old WooCommerce calls (?wc-ajax=)
    if '?' in p and 'wc-ajax=' not in p and p.split('?')[0] in PATHRULE:
        return expected(PATHRULE[p.split('?')[0]])
    if p.split('?')[0].startswith('/author/') or '/paged-' in p:
        return ('410', '') if '/paged-' in p else ('301', '/blog/')
    if act.startswith('KEEP'):
        # production already answers 404 (future posts not yet published, /project/inpace/): 200 or 404, never a redirect
        return ('200|404', '') if row['prod_status'].strip() == '404' and '?' not in p else ('200', '')
    if act.startswith('301'):
        t = row['target'].strip()
        return ('301', t) if t != p.split('?')[0] else ('200', '')
    if act == '410':
        return ('410', '')
    return ('CONFIG', '')


def flatten(target, r301):
    seen = set()
    while target in r301 and target not in seen:
        seen.add(target)
        target = r301[target]
    return target


def main():
    rows = list(csv.DictReader(open(SRC)))
    for r in rows:
        if '?' not in r['old_path']:
            PATHRULE[r['old_path']] = r
            if r['action'].startswith('KEEP') and r['prod_status'].strip() == '404':
                KEPT404.add(r['old_path'])
    r301 = {r['old_path']: r['target'].strip() for r in rows if r['action'].startswith('301') and '?' not in r['old_path']}
    jobs = []
    for r in rows:
        exp, tgt = expected(r)
        if exp == '301':
            tgt = flatten(tgt, r301)
        p = r['old_path']
        variants = [p]
        if '?' not in p and p.endswith('/') and p != '/' and not re.search(r'\.[a-z0-9]{2,5}/?$', p, re.I):
            variants += [p.rstrip('/'), p + '?utm_source=test']
        for v in variants:
            jobs.append((r, v, exp, tgt, v != p))
    results = []
    with cf.ThreadPoolExecutor(max_workers=6) as ex:
        futs = {ex.submit(fetch, BASE + urllib.parse.quote(v, safe='/?=&%:+')): (r, v, exp, tgt, var) for r, v, exp, tgt, var in jobs}
        for f in cf.as_completed(futs):
            r, v, exp, tgt, var = futs[f]
            code, loc = f.result()
            results.append({'path': v, 'variant': var, 'action': r['action'], 'expect': exp, 'target': tgt, 'code': code, 'location': path_of(loc)})
    # targets must answer 200
    targets = sorted({x['target'] for x in results if x['expect'] == '301' and x['target'].startswith('/')})
    tcode = {}
    with cf.ThreadPoolExecutor(max_workers=6) as ex:
        for t, (c, l) in zip(targets, ex.map(lambda t: fetch(BASE + t), targets)):
            tcode[t] = c
    fails, notes, kept = [], [], []
    for x in results:
        c, e, loc = str(x['code']), x['expect'], x['location'].split('?')[0]
        ok = True
        if e == '200|404':
            ok = c in ('200', '404') or (x['variant'] and c == '301' and loc.rstrip('/') == x['path'].split('?')[0].rstrip('/'))
        elif e == '200':
            ok = c == '200' or (x['variant'] and c == '301' and loc.rstrip('/') == x['path'].split('?')[0].rstrip('/'))
        elif e == '301':
            ok = c == '301' and loc == x['target']
            if ok and str(tcode.get(x['target'])) == '404' and x['target'] in KEPT404:
                pass  # same as production: the old redirect points at an address production answers 404
            elif ok and str(tcode.get(x['target'])) != '200':
                ok = False
                x['why'] = 'target answers %s' % tcode.get(x['target'])
        elif e == '410':
            if c == '404' and x['path'].startswith('/wp-content/'):
                notes.append(x)
                continue
            if c == '200' and x['path'].startswith('/wp-content/'):
                kept.append(x)  # copied on purpose because a kept post uses it (D-178)
                continue
            ok = c == '410' or (x['variant'] and c == '301' and loc.rstrip('/') == x['path'].split('?')[0].rstrip('/'))
        elif e == 'CONFIG':
            ok = not c.startswith('5') and not c.startswith('ERR')
        if not ok:
            fails.append(x)
    day = datetime.date.today().isoformat()
    out = os.path.join(ROOT, 'claude', 'research', 'redirect-test')
    os.makedirs(out, exist_ok=True)
    json.dump({'base': BASE, 'checked': len(results), 'targets': tcode, 'failures': fails, 'wp_content_404_not_410': notes, 'wp_content_kept_d178': kept},
              open(os.path.join(out, '%s-%s.json' % (day, HOST)), 'w'), indent=1)
    print('checked', len(results), 'requests over', len(rows), 'old addresses;', len(targets), 'targets')
    print('FAILURES:', len(fails), '| /wp-content/ files answering 404 instead of 410 (server rule pending):', len(notes), '| old files kept because kept posts use them (D-178):', len(kept))
    for x in sorted(fails, key=lambda x: x['path'])[:80]:
        print('  ', x['path'], '| expected', x['expect'], x['target'], '| got', x['code'], x['location'], x.get('why', ''))


if __name__ == '__main__':
    main()
