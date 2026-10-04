#!/usr/bin/env python3
"""Copy rules check (D-072, O-025): no em or en dashes, no emoji, no banned AI-style words in website copy.
Usage: python3 claude/tools/copy-check.py [files...]   (default: wp/novamira-sandbox/*.php *.css)
Exit code 1 if anything is found. Code comments and <style> blocks are skipped for the word check;
em dashes are checked everywhere (comments included) so a grep stays at zero."""
import re, sys, glob

EM = re.compile(r'—|&mdash;|&#8212;|&#x2014;')
EN = re.compile(r'\u2013|&ndash;|&#8211;|&#x2013;')  # O-025: ranges are written with "to" ("20 to 30")
EMOJI = re.compile('[\U0001F000-\U0001FAFF☀-➿️⭐✅❌✓✔✕✖↳]|&#(9989|10003|10004|10005|10006|10060);')
# Banned AI-style words and phrases (D-072). Extend only with Jamil's approval.
BANNED = [r'delv\w*', r'leverag\w*', r'seamless\w*', r'unlock\w*', r'elevat\w*', r'robust', r'cutting[- ]edge',
          r'game[- ]chang\w*', r'landscape', r'realm', r'tapestry', r'empower\w*', r'harness\w*', r'supercharg\w*',
          r'revolutioni[sz]\w*', r'transformative', r'synerg\w*', r'holistic\w*', r'streamlin\w*', r'foster\w*',
          r'embark\w*', r'pivotal', r'testament', r'ever[- ]evolving', r"in today'?s", r'fast[- ]paced',
          r'important to note', r'deep[- ]dive', r'dive into', r'unleash\w*', r'paramount', r'myriad', r'plethora',
          r'bespoke', r'meticulous\w*', r'intricate', r'boast\w*', r'showcas\w*', r'underscor\w*',
          r'more than ever', r'genuinely', r'truly', r'world[- ]class', r'next[- ]level', r'state[- ]of[- ]the[- ]art',
          r'best[- ]in[- ]class', r'effortless\w*', r'unparalleled', r'look no further', r'table stakes',
          r'operationali[sz]\w*', r'quietly', r'compound\w*', r'not just', r'navigate the', r'in the world of', r'whether you\'?re a']
WORDS = re.compile(r'\b(' + '|'.join(BANNED) + r')\b', re.I)

files = sys.argv[1:] or sorted(glob.glob('wp/novamira-sandbox/**/*.php', recursive=True) + glob.glob('wp/novamira-sandbox/**/*.css', recursive=True))
found = 0
for f in files:
    raw = open(f, encoding='utf8').read()
    copy = re.sub(r'/\*.*?\*/', lambda m: ' ' * len(m.group()), raw, flags=re.S)
    copy = re.sub(r'<style.*?</style>', lambda m: ' ' * len(m.group()), copy, flags=re.S)
    for rx, txt, label in ((EM, raw, 'em dash'), (EN, raw, 'en dash'), (EMOJI, raw, 'emoji/symbol'), (WORDS, copy, 'AI word')):
        for m in rx.finditer(txt):
            line = raw.count('\n', 0, m.start()) + 1
            print(f'{f}:{line}: {label}: {m.group()!r}')
            found += 1
print(f'{found} issue(s) in {len(files)} file(s)')
sys.exit(1 if found else 0)
