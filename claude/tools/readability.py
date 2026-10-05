#!/usr/bin/env python3
"""Reading-level check for blog posts (D-134: every post at US grade 8 or below).

    python3 claude/tools/readability.py <url-or-file> [--max-grade 8] [--show 15]

Measures the article text only (the post body and the post fields a reader sees), not the menu,
footer, tables or code. Reports Flesch-Kincaid grade, Flesch reading ease, average sentence length,
the share of long words (3+ syllables), and lists the hardest sentences to rewrite first.
Exit code 1 when the grade is above the limit, so it can gate publishing.
"""
import re, sys, subprocess, html

def syllables(word):
    w = word.lower().strip("'")
    if not w: return 0
    if len(w) <= 3: return 1
    w = re.sub(r'(?:[^laeiouy]es|ed|[^laeiouy]e)$', '', w)
    w = re.sub(r'^y', '', w)
    n = len(re.findall(r'[aeiouy]{1,2}', w))
    return max(1, n)

def article_text(raw):
    """Text a reader of the post sees in the article itself."""
    try:
        from bs4 import BeautifulSoup
    except ImportError:
        return html.unescape(re.sub(r'<[^>]+>', ' ', raw))
    s = BeautifulSoup(raw, 'lxml')
    root = s.select_one('.rl-post') or s.select_one('.rl-page') or s.body or s
    for sel in ['script', 'style', 'noscript', 'svg', 'table', 'nav', '.toc', '.toc-m', '.rel', '#related', '#related-reading',
                '#start', '.author', '.srcs', '#sources', '.rl-ph', 'figcaption', '.copy', 'button', '.m', '.crumbs', '.meta', '.byline']:
        for e in root.select(sel): e.decompose()
    parts = []
    for e in root.find_all(['h1', 'h2', 'h3', 'p', 'li', 'summary', 'dd', 'blockquote']):
        if e.find(['p', 'li']) and e.name in ('li', 'blockquote'): continue
        t = e.get_text(' ', strip=True)
        if len(t.split()) >= 3: parts.append(t if re.search(r'[.!?]$', t) else t + '.')
    return '\n'.join(parts)

def measure(text):
    text = re.sub(r'\s+', ' ', text).strip()
    sents = [x for x in re.split(r'(?<=[.!?])\s+(?=[A-Z0-9"“(])', text) if len(re.findall(r"[A-Za-z']+", x)) >= 3]
    words = re.findall(r"[A-Za-z][A-Za-z'\-]*", ' '.join(sents))
    if not sents or not words: return None
    syl = [syllables(w) for w in words]
    wps = len(words) / len(sents); spw = sum(syl) / len(words)
    grade = 0.39 * wps + 11.8 * spw - 15.59
    ease = 206.835 - 1.015 * wps - 84.6 * spw
    long_share = sum(1 for n in syl if n >= 3) / len(words)
    scored = []
    for x in sents:
        ws = re.findall(r"[A-Za-z][A-Za-z'\-]*", x)
        if not ws: continue
        g = 0.39 * len(ws) + 11.8 * (sum(syllables(w) for w in ws) / len(ws)) - 15.59
        scored.append((round(g, 1), len(ws), x))
    scored.sort(reverse=True)
    return {'grade': round(grade, 1), 'ease': round(ease), 'sentences': len(sents), 'words': len(words),
            'words_per_sentence': round(wps, 1), 'long_word_share': round(100 * long_share, 1), 'hardest': scored}

def load(src):
    if src.startswith('http'):
        sep = '&' if '?' in src else '?'
        return subprocess.run(['curl', '-sL', '--max-time', '60', src + sep + 'nc=readability'], capture_output=True, text=True).stdout
    return open(src, encoding='utf-8').read()

def main():
    if len(sys.argv) < 2: print(__doc__); sys.exit(2)
    src = sys.argv[1]; args = sys.argv[2:]
    maxg = float(args[args.index('--max-grade') + 1]) if '--max-grade' in args else 8.0
    show = int(args[args.index('--show') + 1]) if '--show' in args else 15
    raw = load(src)
    text = article_text(raw) if '<' in raw[:2000] else raw
    m = measure(text)
    if not m: print('no text found'); sys.exit(2)
    ok = m['grade'] <= maxg
    print(f"{'PASS' if ok else 'FAIL'}  grade {m['grade']} (limit {maxg})  ease {m['ease']}  "
          f"{m['words']} words, {m['sentences']} sentences, {m['words_per_sentence']} words/sentence, {m['long_word_share']}% long words")
    if not ok or show:
        print('\nHardest sentences (grade, words):')
        for g, n, x in m['hardest'][:show]:
            if g <= maxg: break
            print(f'  {g:5} {n:3}  {x[:220]}')
    sys.exit(0 if ok else 1)

if __name__ == '__main__':
    main()
