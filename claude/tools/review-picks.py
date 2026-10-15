#!/usr/bin/env python3
"""Build the pick data for the two /reviews/ pillars (D-195) from Jamil's own list posts, as saved from production
(claude/data/production-posts/<slug>.json). Writes wp/novamira-sandbox/pages/reinforce-reviews-picks.json.
Text is kept as written; only headings are split into name and "best for"."""
import html, json, os, re, sys

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
SRC = os.path.join(ROOT, 'claude', 'data', 'production-posts')
OUT = os.path.join(ROOT, 'wp', 'novamira-sandbox', 'pages', 'reinforce-reviews-picks.json')

NAMES = {'Liquid': 'Liquid Web', 'Dreamhost': 'DreamHost', 'Inmotion': 'InMotion Hosting', 'Siteground': 'SiteGround', 'A2': 'A2 Hosting'}
# copy rules (D-072): banned words in the source text get the plainest equivalent; nothing else is reworded
SWAP = [(r'\bcutting[- ]edge\b', 'latest'), (r'\brobust\b', 'strong'), (r'\bseamless(ly)?\b', 'smooth'), (r'\bleverag(e|es|ing)\b', 'use'), (r'[\u2013\u2014]', ',')]
def clean(t):
    for a, b in SWAP: t = re.sub(a, b, t, flags=re.I)
    return t

def txt(x): return clean(re.sub(r'\s+', ' ', html.unescape(re.sub(r'<[^>]+>', '', x))).strip())
def paras(h): return [t for t in (txt(p) for p in re.findall(r'<p[^>]*>(.*?)</p>', h, re.S)) if t and not re.match(r'^(read more|read customer reviews|try .* free|get started)!?$', t, re.I)]
def items(h): return [t for t in (txt(l) for l in re.findall(r'<li[^>]*>(.*?)</li>', h, re.S)) if t]
def links(h): return [html.unescape(u) for u in re.findall(r'href="(https?://[^"]+)"', h) if 'reinforcelab' not in u]
def h2_sections(c): return [(txt(m.group(1)), c[m.end():(nx.start() if nx else len(c))]) for m, nx in ((m, re.compile(r'<h2[^>]*>').search(c, m.end())) for m in re.finditer(r'<h2[^>]*>(.*?)</h2>', c, re.S))]
def sub(h, pat):
    m = re.search(r'<h[34][^>]*>\s*' + pat + r'.*?</h[34]>(.*?)(?=<h[234][^>]*>|$)', h, re.S | re.I)
    return m.group(1) if m else ''

def ai_tools():
    c = json.load(open(os.path.join(SRC, 'ai-content-writing-tools.json')))['content']['rendered']
    out = []
    for head, body in h2_sections(c):
        name, _, badge = head.partition(' , ')  # txt() turned the heading's dash into ' , '
        if not re.match(r'^(Writesonic|Jasper|Rytr|Copy AI|Anyword)$', name.strip()): continue
        lead = re.split(r'<h[34]', body, 1)[0]
        out.append({'name': name.strip(), 'badge': badge.strip(), 'best': '', 'intro': paras(lead)[:2],
                    'why': paras(sub(body, r'Why We Picked'))[:3], 'who': paras(sub(body, r'Who.{1,8}s it for'))[:3],
                    'pros': items(sub(body, r'Pros')), 'cons': items(sub(body, r'Cons')), 'url': (links(body) or [''])[0]})
    return out

def hosting():
    c = json.load(open(os.path.join(SRC, 'best-web-hosting-services.json')))['content']['rendered']
    out = []
    for head, body in h2_sections(c):
        m = re.match(r'^(.*?) Web Hosting:\s*(.*)$', head)
        if not m: continue
        name = NAMES.get(m.group(1).strip(), m.group(1).strip())
        cons = sub(body, r'Cons')
        out.append({'name': name, 'badge': m.group(2).strip(), 'best': '', 'intro': paras(re.split(r'<h[34]', body, 1)[0])[:2],
                    'why': [], 'who': [], 'pros': items(sub(body, r'Pros')), 'cons': items(cons), 'verdict': paras(cons)[:1], 'url': (links(body) or [''])[0]})
    return out

def lead(slug):
    c = json.load(open(os.path.join(SRC, slug + '.json')))['content']['rendered']
    first = h2_sections(c)
    return paras(re.split(r'<h[34]', first[0][1], 1)[0])[:2] if first else []

data = {'_source': 'Jamil Ahmed list posts, production text saved 8 Oct 2026; built by claude/tools/review-picks.py (D-195)',
        'tools': {'from': 'ai-content-writing-tools', 'intro': lead('ai-content-writing-tools'), 'picks': ai_tools()},
        'hosting': {'from': 'best-web-hosting-services', 'intro': lead('best-web-hosting-services'), 'picks': hosting()}}
json.dump(data, open(OUT, 'w'), indent=1, ensure_ascii=False)
print(OUT, len(data['tools']['picks']), 'tools,', len(data['hosting']['picks']), 'hosts')
