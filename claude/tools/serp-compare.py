#!/usr/bin/env python3
"""Day-1 comparison of our pages with the competitor pages already fetched by serp-semantics.py.

    python3 claude/tools/serp-compare.py claude/research/audit-2026-11/day1-serp-urls.json out.json

For each keyword: competitor word counts (median, range), heading counts, which proof and buying elements
competitors show (prices, case studies, numbers, reviews, process, FAQ), whether our page shows them, the
multi-word topic terms 40%+ of competitors use that our page does not, and competitor heading questions.
Reads claude/research/serp/<slug>/pages.json; fetches only our own page from .online. Writes nothing to the site.
"""
import sys, os, re, json, statistics, subprocess, importlib.util
HERE = os.path.dirname(os.path.abspath(__file__)); ROOT = os.path.dirname(os.path.dirname(HERE))
spec = importlib.util.spec_from_file_location('ss', os.path.join(HERE, 'serp-semantics.py')); ss = importlib.util.module_from_spec(spec); spec.loader.exec_module(ss)

ELEMENTS = {
 'price shown ($ figure)': r'\$\s?\d[\d,]{2,}',
 'case study or named client result': r'case stud|success stor',
 'percent or multiple result claim': r'\b\d{2,4}\s?%|\b\d+(\.\d+)?x\b',
 'reviews or ratings (Clutch, G2, stars)': r'clutch|g2\b|trustpilot|google reviews|5-star|five-star|\b4\.\d\b',
 'testimonial': r'testimonial|what our clients say|clients say',
 'process or steps': r'our process|how it works|step 1|phase 1|how we work',
 'FAQ': r'frequently asked|faq',
 'deliverables list': r'deliverable|what you get|what.s included|what is included',
 'timeline (weeks or months to results)': r'\b\d+\s?(to|-|–)\s?\d+\s(weeks|months)|within \d+ (days|weeks|months)',
 'named tools (Semrush, Ahrefs, GA4, HubSpot ...)': r'semrush|ahrefs|screaming frog|ga4|google analytics|hubspot|search console|n8n|zapier|salesforce',
 'team or named expert': r'our team|years of experience|meet the|founder|certified',
 'comparison (vs, versus, different from)': r'\bvs\.?\b|versus|different from|difference between',
}
def has(text, pat): return bool(re.search(pat, text, re.I))

def main():
    cfg = json.load(open(sys.argv[1])); out = {}
    for slug, v in cfg.items():
        if slug.startswith('_'): continue
        pages = json.load(open(os.path.join(ROOT, 'claude/research/serp', slug, 'pages.json')))
        html = subprocess.run(['curl', '-sL', '--max-time', '60', 'https://reinforcelab.online/' + v['page'] + '?nc=cmp'], capture_output=True, text=True).stdout
        title, heads, text = ss.extract(html)
        words = [p['words'] for p in pages]
        el = {}
        for name, pat in ELEMENTS.items():
            n = sum(has(p['text'], pat) for p in pages)
            el[name] = {'competitors': n, 'of': len(pages), 'ours': has(text, pat)}
        df = {}
        for p in pages:
            for t in ss.terms(p['text']): df[t] = df.get(t, 0) + 1
        mine = ss.terms(text); need = max(3, round(len(pages) * 0.4))
        multi = sorted([(c, t) for t, c in df.items() if c >= need and ' ' in t and t not in mine], reverse=True)
        keep = [(c, t) for c, t in multi if not any(t != t2 and f' {t} ' in f' {t2} ' and c2 == c for c2, t2 in multi)]
        qs = sorted({h for p in pages for _, h in p['headings'] if h.strip().endswith('?') and len(h) > 14})
        ourq = [h for _, h in heads if h.strip().endswith('?')]
        out[slug] = {'page': v['page'], 'keyword': v['keyword'], 'keyword_status': v['approved'], 'analysed': len(pages), 'listed': len(set(v['urls'])),
                     'our_words': len(text.split()), 'comp_median_words': int(statistics.median(words)), 'comp_min': min(words), 'comp_max': max(words),
                     'our_headings': len(heads), 'comp_median_headings': int(statistics.median([len(p['headings']) for p in pages])),
                     'kw_in_title': v['keyword'].split(' / ')[0] in title.lower(), 'kw_in_h1': any(n == 'h1' and v['keyword'].split(' / ')[0] in h.lower() for n, h in heads),
                     'kw_in_text': text.lower().count(v['keyword'].split(' / ')[0]), 'our_title': title, 'our_h1': next((h for n, h in heads if n == 'h1'), ''),
                     'elements': el, 'missing_terms': [f'{t} ({c})' for c, t in keep[:40]], 'competitor_questions': qs, 'our_questions': ourq,
                     'competitors': [{'url': p['url'], 'title': p['title'][:90], 'words': p['words']} for p in pages]}
    json.dump(out, open(sys.argv[2], 'w'), indent=1)
    for s, r in out.items():
        gaps = [k for k, e in r['elements'].items() if not e['ours'] and e['competitors'] >= r['analysed'] / 2]
        print(f"{s}: ours {r['our_words']}w vs median {r['comp_median_words']} ({r['comp_min']}-{r['comp_max']}); kw title/h1/text {r['kw_in_title']}/{r['kw_in_h1']}/{r['kw_in_text']}; gaps: {gaps}")
if __name__ == '__main__': main()
