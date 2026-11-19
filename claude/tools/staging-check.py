#!/usr/bin/env python3
"""Checks for a staging or live copy of the site (migration checklist A4, A6 and the first-hour gate).

  python3 claude/tools/staging-check.py https://new.example.com              # staging: must be noindex
  python3 claude/tools/staging-check.py https://reinforcelab.com --live       # after the switch: must be indexable
  python3 claude/tools/staging-check.py https://new.example.com --full        # also run redirect test, link scan, post check

Read-only GET requests only. Prints PASS, FAIL or INFO for each check. Runs from the sandbox, so it can only reach
public addresses. Never run it against reinforcelab.com before the approved switch (Rule 1).
"""
import json, re, subprocess, sys, urllib.request, urllib.error, ssl

base = sys.argv[1].rstrip('/') if len(sys.argv) > 1 else ''
live = '--live' in sys.argv
full = '--full' in sys.argv
if not base.startswith('http'):
    sys.exit(__doc__)
if 'reinforcelab.com' in base and not live:
    sys.exit('STOP: reinforcelab.com is production (Rule 1). Use --live only after the approved switch.')
UA_BROWSER = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124 Safari/537.36'
UA_GOOGLEBOT = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'
fails = 0


def get(path, ua=UA_BROWSER, follow=True):
    req = urllib.request.Request(base + path, headers={'User-Agent': ua})
    class NoRedirect(urllib.request.HTTPRedirectHandler):
        def redirect_request(self, *a, **k): return None
    op = urllib.request.build_opener() if follow else urllib.request.build_opener(NoRedirect)
    try:
        r = op.open(req, timeout=40)
        return r.status, dict(r.headers), r.read().decode('utf8', 'ignore')
    except urllib.error.HTTPError as e:
        return e.code, dict(e.headers), e.read().decode('utf8', 'ignore') if e.fp else ''
    except Exception as e:
        return 0, {}, str(e)


def out(ok, name, detail=''):
    global fails
    if ok is None: tag = 'INFO'
    elif ok: tag = 'PASS'
    else: tag = 'FAIL'; fails += 1
    print(f'{tag:4}  {name}  {detail}'.rstrip())


s, h, body = get('/')
out(s == 200, 'home answers 200', f'status {s}, {len(body)} bytes')
hl = {k.lower(): v for k, v in h.items()}
robots_meta = re.search(r'<meta[^>]+name=["\']robots["\'][^>]+content=["\']([^"\']+)', body, re.I)
noindex = 'noindex' in hl.get('x-robots-tag', '').lower() or bool(robots_meta and 'noindex' in robots_meta.group(1).lower())
rs, _, rtxt = get('/robots.txt')
if live:
    out(not noindex, 'live site is indexable (no noindex header or meta)')
    out(not re.search(r'(?im)^disallow:\s*/\s*$', rtxt), 'robots.txt does not block everything', f'status {rs}')
else:
    out(noindex, 'staging is noindex (header or meta)', f"x-robots-tag='{hl.get('x-robots-tag', '')}' meta='{robots_meta.group(1) if robots_meta else ''}'")

# crawlers get the real page (the empty-page problem seen on production, F-043)
for name, ua in (('Googlebot', UA_GOOGLEBOT), ('GPTBot', 'Mozilla/5.0 (compatible; GPTBot/1.1; +https://openai.com/gptbot)'),
                 ('ClaudeBot', 'Mozilla/5.0 (compatible; ClaudeBot/1.0; +claudebot@anthropic.com)'), ('PerplexityBot', 'Mozilla/5.0 (compatible; PerplexityBot/1.0)')):
    cs, _, cb = get('/', ua)
    out(cs == 200 and len(cb) > 0.8 * len(body), f'{name} gets the full home page', f'status {cs}, {len(cb)} bytes against {len(body)} for a browser')

# canonical and schema (meaningful when the site is indexable)
can = re.search(r'<link[^>]+rel=["\']canonical["\'][^>]+href=["\']([^"\']+)', body, re.I)
out(bool(can) if live else None, 'home has a canonical link', can.group(1) if can else 'none')
ids, refs = set(), set()
for blk in re.findall(r'<script[^>]+application/ld\+json[^>]*>(.*?)</script>', body, re.S):
    try: j = json.loads(blk)
    except Exception: out(False, 'JSON-LD parses'); continue
    nodes = j.get('@graph', [j]) if isinstance(j, dict) else j
    def walk(x):
        if isinstance(x, dict):
            if '@id' in x and len(x) > 1: ids.add(x['@id'])
            for v in x.values(): walk(v)
            if '@id' in x and len(x) == 1: refs.add(x['@id'])
        elif isinstance(x, list):
            for v in x: walk(v)
    walk(nodes)
dangling = sorted(r for r in refs - ids if r.startswith(base))
out(not dangling, 'schema: every referenced @id is defined', f'dangling {dangling[:3]}' if dangling else f'{len(ids)} nodes')

# sitemap
ss, _, sm = get('/sitemap_index.xml')
out(ss == 200, 'sitemap index answers 200', f'{len(re.findall("<loc>", sm))} sitemaps')

# headers
for hk, label in (('strict-transport-security', 'HSTS'), ('x-content-type-options', 'nosniff'), ('referrer-policy', 'referrer policy'), ('x-frame-options', 'frame protection')):
    out(bool(hl.get(hk)) if live else None, f'header {label}', hl.get(hk, 'missing'))

# security surface
s404, _, _ = get('/this-page-should-not-exist-9f3k2/')
out(s404 in (404, 410), 'unknown address answers 404', f'status {s404}')
sx, _, _ = get('/xmlrpc.php')
out(True if sx in (403, 404, 405) else None, 'xmlrpc.php (open is fine if Jetpack needs it)', f'status {sx}')
su, _, ub = get('/wp-json/wp/v2/users')
out(su in (401, 403, 404) or ub.strip() in ('[]', ''), 'user list is not public', f'status {su}')
sa, _, _ = get('/?author=1', follow=False)
out(sa in (301, 302, 403, 404), '?author=1 does not reveal the login', f'status {sa}')
for bad in ('novamira', 'novamira-pro', 'wp-file-manager', 'wp-console'):
    sb, _, _ = get(f'/wp-content/plugins/{bad}/')
    out(sb in (404, 410), f'plugin folder {bad} is absent', f'status {sb}')
sd, _, _ = get('/wp-content/uploads/.htaccess')
out(sd in (403, 404), 'uploads .htaccess is not readable', f'status {sd}')
ssh, _, _ = get('/readme.html')
out(ssh in (403, 404), 'readme.html is not exposed', f'status {ssh}')

if full:
    here = __file__.rsplit('/claude/', 1)[0]
    for tool in ('redirect-test.py', 'link-scan.py', 'post-check.py'):
        print(f'\n== {tool}')
        r = subprocess.run(['python3', f'{here}/claude/tools/{tool}', base], capture_output=True, text=True, timeout=1800)
        print('\n'.join((r.stdout or r.stderr).strip().split('\n')[-3:]))
print(f'\n{fails} check(s) failed' if fails else '\nall checks passed')
sys.exit(1 if fails else 0)
