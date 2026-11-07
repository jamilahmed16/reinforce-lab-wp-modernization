#!/usr/bin/env python3
"""Checklist A3 gate: every post carried from production passes before launch.

  python3 claude/tools/post-check.py [base]      # default https://reinforcelab.online

For every post in claude/data/production-posts/ (the read-only production copies, D-178) it checks on the site:
  * the post answers 200 at the same address, with a title and noindex while on .online
  * every image in the post body (and srcset) on this site answers 200
  * every JSON-LD block parses, and the page has exactly one H1
Report: claude/research/post-check/<date>-<host>.json and a printed summary.
"""
import concurrent.futures as cf
import datetime
import glob
import html as htmllib
import json
import os
import re
import sys
import urllib.error
import urllib.parse
import urllib.request

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
BASE = (sys.argv[1] if len(sys.argv) > 1 else 'https://reinforcelab.online').rstrip('/')
HOST = urllib.parse.urlparse(BASE).netloc


def get(url, body=True):
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0 (rl-post-check)'}, method='GET' if body else 'HEAD')
    for _ in range(3):
        try:
            r = urllib.request.urlopen(req, timeout=60)
            return r.status, (r.read().decode('utf8', 'replace') if body else '')
        except urllib.error.HTTPError as e:
            return e.code, ''
        except Exception as e:
            err = e.__class__.__name__
    return 'ERR:' + err, ''


def slugs():
    return sorted(os.path.basename(f)[:-5] for f in glob.glob(os.path.join(ROOT, 'claude', 'data', 'production-posts', '*.json'))
                  if not os.path.basename(f).startswith('_'))


def check(slug):
    url = '%s/%s/' % (BASE, slug)
    code, h = get(url)
    out = {'slug': slug, 'status': code, 'problems': []}
    if code != 200:
        out['problems'].append('page answers %s' % code)
        return out
    if not re.search(r'<title>[^<]{5,}</title>', h):
        out['problems'].append('no title')
    if HOST.endswith('reinforcelab.online') and 'noindex' not in h:
        out['problems'].append('not noindex on the dev site')
    h1 = len(re.findall(r'<h1\b', h, re.I))
    if h1 != 1:
        out['problems'].append('%d H1 headings' % h1)
    for i, block in enumerate(re.findall(r'<script[^>]+application/ld\+json[^>]*>(.*?)</script>', h, re.S)):
        try:
            json.loads(block)
        except Exception:
            out['problems'].append('JSON-LD block %d does not parse' % (i + 1))
    body = re.search(r'<article\b.*?</article>', h, re.S)
    body = body.group(0) if body else h
    imgs = set()
    for m in re.finditer(r'<img\b[^>]*>', body, re.I):
        tag = m.group(0)
        for attr in ('src', 'data-src'):
            a = re.search(r'\s%s=["\']([^"\']+)["\']' % attr, tag)
            if a:
                imgs.add(a.group(1))
        s = re.search(r'\ssrcset=["\']([^"\']+)["\']', tag)
        if s:
            imgs.update(p.strip().split(' ')[0] for p in s.group(1).split(',') if p.strip())
    own = []
    for src in imgs:
        u = urllib.parse.urlparse(urllib.parse.urljoin(url, htmllib.unescape(src)))
        if u.netloc in (HOST, 'www.' + HOST) and u.path.startswith('/wp-content/'):
            own.append(u.geturl())
    out['images'] = len(own)
    for u in sorted(own):
        c, _ = get(u, body=False)
        if c != 200:
            out['problems'].append('image %s answers %s' % (urllib.parse.urlparse(u).path, c))
    return out


def main():
    res = []
    with cf.ThreadPoolExecutor(max_workers=4) as ex:
        for r in ex.map(check, slugs()):
            res.append(r)
    bad = [r for r in res if r['problems']]
    day = datetime.date.today().isoformat()
    out = os.path.join(ROOT, 'claude', 'research', 'post-check')
    os.makedirs(out, exist_ok=True)
    json.dump({'base': BASE, 'posts': len(res), 'with_problems': len(bad), 'results': res}, open(os.path.join(out, '%s-%s.json' % (day, HOST)), 'w'), indent=1)
    print('posts checked', len(res), '| images checked', sum(r.get('images', 0) for r in res), '| posts with problems', len(bad))
    for r in bad:
        print('  ', r['slug'], '|', '; '.join(r['problems'][:6]))


if __name__ == '__main__':
    main()
