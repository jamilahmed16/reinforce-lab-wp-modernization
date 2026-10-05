#!/usr/bin/env python3
"""Competitor semantics for a blog post (D-134). Run BEFORE writing a post, and again on the draft.

    python3 claude/tools/serp-semantics.py <slug> <our-url-or-draft-file|-> <competitor-url> [<competitor-url> ...]

Step 1 (with Exa, by hand in the session): find the top 10 results for the post's keyword. Google's own
ranking comes from a Google results screenshot or Jamil's check; Exa search supplies the URLs and its own
top results for the same query. Pass those URLs here.
Step 2 (this tool): the .online server fetches each page (this sandbox cannot reach most sites), strips
menus and footers, and records for every competitor: title, headings, questions in headings, word count.
It then finds the terms (1 to 3 words) that 3 or more competitors use, and checks which of them our
page or draft does not use yet. Output: claude/research/serp/<slug>/pages.json and report.md.
Pages the server cannot fetch (login walls, bot checks) are listed as failed; read them with Exa instead.
"""
import sys, os, re, json, base64, collections, subprocess
sys.path.insert(0, os.path.dirname(__file__))
import rl  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
STOP = set('''a about above after again against all also am an and any are as at be because been before being below between both but by can
could did do does doing down during each few for from further had has have having he her here hers herself him himself his how i if in into is
it its itself just me more most my myself no nor not now of off on once only or other our ours ourselves out over own same she should so some
such than that the their theirs them themselves then there these they this those through to too under until up very was we were what when
where which while who whom why will with would you your yours yourself yourselves one two three get gets got make makes made use used using
like even much many may might must way ways also well new every within without across per via etc us let lets it's that's don't can't won't
isn't aren't you're they're we're i'm read more click here learn see view next back home menu contact cookie cookies privacy policy terms
rights reserved copyright subscribe newsletter email login sign'''.split())

def fetch_remote(urls):
    """One PHP call per page: a single call carrying many full pages is too large for the transport."""
    out = {}
    for u in urls:
        code = """
$r = wp_remote_get(base64_decode('%s'), array('timeout' => 30, 'redirection' => 5, 'user-agent' => 'Mozilla/5.0 (compatible; content research)'));
if (is_wp_error($r)) return array('status' => 0, 'html' => '', 'err' => $r->get_error_message());
return array('status' => wp_remote_retrieve_response_code($r), 'html' => base64_encode(substr(wp_remote_retrieve_body($r), 0, 600000)));""" % base64.b64encode(u.encode()).decode()
        try:
            rv, errs = rl.php(code, timeout=120)
            out[u] = rv if isinstance(rv, dict) else {'status': 0, 'html': '', 'err': str(errs)[:120]}
        except Exception as e:
            out[u] = {'status': 0, 'html': '', 'err': str(e)[:120]}
    return out

def extract(html):
    from bs4 import BeautifulSoup
    s = BeautifulSoup(html, 'lxml')
    title = s.title.get_text(' ', strip=True) if s.title else ''
    for sel in ['script', 'style', 'noscript', 'svg', 'nav', 'header', 'footer', 'form', 'aside', 'iframe',
                '[role=navigation]', '[class*=cookie]', '[class*=menu]', '[id*=menu]', '[class*=footer]', '[class*=sidebar]']:
        for e in s.select(sel):
            if e.name in ('html', 'body') or e.select_one('.rl-page') or e.find_parent(class_='rl-page'): continue  # body classes like fl-has-sidebar must not remove the page; keep our own content intact
            e.decompose()
    main = s.select_one('.rl-page') or s.find('article') or s.find('main') or s.body or s
    heads = [(h.name, re.sub(r'\s+', ' ', h.get_text(' ', strip=True))) for h in main.find_all(re.compile('^h[1-4]$'))]
    heads = [h for h in heads if 2 <= len(h[1]) <= 160]
    text = re.sub(r'\s+', ' ', main.get_text(' ', strip=True))
    return title, heads, text

def terms(text):
    words = [w for w in re.findall(r"[a-z][a-z0-9'\-]*", text.lower()) if len(w) > 1]
    out = set()
    for n in (1, 2, 3):
        for i in range(len(words) - n + 1):
            g = words[i:i + n]
            if g[0] in STOP or g[-1] in STOP: continue
            if n == 1 and (len(g[0]) < 4 or g[0] in STOP): continue
            out.add(' '.join(g))
    return out

def our_text(src):
    if src == '-': return ''
    if src.startswith('http'):
        html = subprocess.run(['curl', '-sL', '--max-time', '60', src + ('&' if '?' in src else '?') + 'nc=serp'], capture_output=True, text=True).stdout
        return extract(html)[2]
    raw = open(src, encoding='utf-8').read()
    return extract(raw)[2] if '<' in raw[:2000] else raw

def main():
    if len(sys.argv) < 4: print(__doc__); sys.exit(2)
    slug, ours, urls = sys.argv[1], sys.argv[2], sys.argv[3:]
    outdir = os.path.join(ROOT, 'claude', 'research', 'serp', slug); os.makedirs(outdir, exist_ok=True)
    got = fetch_remote(urls)
    pages, failed = [], []
    for u in urls:
        r = got.get(u, {})
        html = base64.b64decode(r.get('html') or b'').decode('utf-8', 'replace') if r.get('html') else ''
        if r.get('status') != 200 or len(html) < 2000:
            failed.append((u, r.get('status'), r.get('err', ''))); continue
        title, heads, text = extract(html)
        if len(text.split()) < 150: failed.append((u, r.get('status'), 'too little text (script-rendered or blocked)')); continue
        pages.append({'url': u, 'title': title, 'words': len(text.split()), 'headings': heads, 'text': text})
    json.dump(pages, open(os.path.join(outdir, 'pages.json'), 'w'), indent=1)
    df = collections.Counter()
    for p in pages: df.update(terms(p['text']))
    mine = terms(our_text(ours)) if ours != '-' else set()
    need = max(3, round(len(pages) * 0.3))
    common = [(t, c) for t, c in df.most_common() if c >= need]
    # keep the most specific phrasing: drop a term if a longer common term contains it with the same count
    keep = []
    for t, c in common:
        if any(t != t2 and f' {t} ' in f' {t2} ' and c2 == c for t2, c2 in common): continue
        keep.append((t, c))
    gaps = [(t, c) for t, c in keep if t not in mine]
    covered = [(t, c) for t, c in keep if t in mine]
    qs = sorted({h for p in pages for _, h in p['headings'] if h.strip().endswith('?')})
    L = [f'# Competitor semantics: {slug}', '', f'Our page: {ours}', f'Competitors analysed: {len(pages)} of {len(urls)} (a term counts as common when {need}+ of them use it)', '',
         '| # | Page | Words | Headings |', '|---|---|---|---|']
    for i, p in enumerate(pages, 1): L.append(f"| {i} | [{p['title'][:70]}]({p['url']}) | {p['words']} | {len(p['headings'])} |")
    if failed:
        L += ['', '**Not fetched (read these with Exa):**'] + [f'- {u} ({s}) {e}' for u, s, e in failed]
    if ours != '-':
        L += ['', f'## Common terms our page does NOT use ({len(gaps)})', '', 'Use the ones that fit naturally; never stuff. Number = competitors using it.', '']
        L += [', '.join(f'{t} ({c})' for t, c in gaps[:150]) or 'none']
        L += ['', f'## Common terms our page already uses ({len(covered)})', '', ', '.join(f'{t} ({c})' for t, c in covered[:150]) or 'none']
    else:
        L += ['', f'## Common terms ({len(keep)})', '', ', '.join(f'{t} ({c})' for t, c in keep[:200])]
    L += ['', f'## Questions competitors answer in headings ({len(qs)})', ''] + [f'- {q}' for q in qs]
    L += ['', '## Headings by page', '']
    for p in pages:
        L.append(f"**{p['title'][:90]}**")
        L += [f"- {n.upper()} {h}" for n, h in p['headings'][:40]]
        L.append('')
    open(os.path.join(outdir, 'report.md'), 'w').write('\n'.join(L))
    print(f'{len(pages)} pages analysed, {len(failed)} failed; {len(keep)} common terms, {len(gaps)} missing from our page')
    print('report:', os.path.relpath(os.path.join(outdir, 'report.md'), ROOT))

if __name__ == '__main__':
    main()
