# Day 1: SEO and GEO check against the search results, 11 Nov 2026 (F-057)

**Asked by Jamil:** Day 1 of the 7-day plan to 17 Nov: SEO and GEO check of the AI Growth Systems pillar, Home and all the service pages against the top 10 results per keyword. `.online` only; production was not touched or fetched.

## Method and limits

- **Pages checked:** Home, the `/services/` hub and the 19 service pages (21 pages). On-page facts come from `claude/tools/seo-audit.py` on the live HTML (`day1-seo-audit.json`). `[VERIFIED]`
- **Competitors:** for each of 19 keywords, up to 12 result URLs from the session's web search (US), one per domain; the `.online` server fetched them (`serp-semantics.py`). **153 of 227 competitor pages were read**; the rest blocked the fetch or render with scripts. Reports per keyword: `claude/research/serp/<slug>/report.md`; comparison: `day1-compare.json` (`claude/tools/serp-compare.py`, new).
- **Limit 1, ranking order:** these are search results for the keyword, **not Google's verified top 10 in order**. This session cannot open Google, and Exa or web search cannot reproduce Google's ranking (same limit as in `blog-post-procedure.md`). Treat "competitors" as pages that rank for the term, not as positions 1 to 10. A Semrush SERP export or screenshots per keyword would close this.
- **Limit 2, keywords:** only 3 pages have an approved primary keyword (Home "reinforce lab", pillar "ai growth systems", AI Search Optimization "ai search optimization services": D-130, D-135). For the other 17 pages I used the head term of the page's SEO title as a working keyword. `[INFERENCE]` No volumes are claimed.
- **Limit 3, proof elements** are found by pattern (a `$` figure, "case study", a percentage, "Clutch", and so on). A match says the element is on the page, not that the claim is true.

## Verdict

1. **Technical and answer-engine gates still pass on all 21 pages** `[VERIFIED]`: one H1, no skipped levels, titles 41 to 60 characters, meta 143 to 160, FAQ on the page equals FAQPage schema, Service or ItemList schema, answer-first opening, noindex on.
2. **The pages lose to the search results on three things, in this order:** proof (case studies, numbers, reviews), the service name in the H1, and buying questions (cost, how long, how to choose). Length is a smaller gap.
3. **The pillar is under-linked** `[VERIFIED]`: only 4 pages link to `/services/ai-growth-systems/` in their content (Home, Services, Search Authority OS, the blog post). None of the 19 service pages does; they reach it only through the menu and footer.

## Findings

### 1. Service name missing from the H1 on 16 of 19 service pages `[VERIFIED]`

Across the 153 competitor pages read, **95 (62%) put the service name in the H1**. Ours does on 3 pages (AI Growth Systems, AI Search Optimization, Website Maintenance). The other 16 open with a benefit line ("Fix what stops search engines and AI crawlers.") and carry the service name in the small label above it ("[ Services / Technical SEO ]") and in the title tag. On 13 of them the exact service phrase (for example "technical seo services") does not appear anywhere in the body text.

Where nearly every competitor does it: SEO audit 9 of 9, technical SEO 10 of 10, AI workflow automation 10 of 11, GEO 9 of 10, local SEO 8 of 9, enterprise SEO 7 of 9, digital PR 5 of 6.

`[RECOMMENDATION]` Keep the benefit line, add the service name to the H1, as AI Search Optimization already does ("AI Search Optimization Services. Be named in AI answers."). Example: "Technical SEO services. Fix what stops search engines and AI crawlers." This changes H1s on `.online` pages that are new URLs or rebuilt pages; it needs your approval per page (Day 4 mockup shows it).

### 2. Proof is the largest gap `[VERIFIED]`

| Element | Competitor pages showing it | Our 19 service pages showing it |
|---|---|---|
| price shown ($ figure) | 60 of 153 (39%) | 3 of 19 |
| case study or named client result | 82 of 153 (54%) | 3 of 19 |
| percent or multiple result claim | 99 of 153 (65%) | 9 of 19 |
| reviews or ratings (Clutch, G2, stars) | 53 of 153 (35%) | 0 of 19 |
| testimonial | 34 of 153 (22%) | 1 of 19 |
| process or steps | 38 of 153 (25%) | 4 of 19 |
| FAQ | 112 of 153 (73%) | 19 of 19 |
| deliverables list | 59 of 153 (39%) | 19 of 19 |
| timeline (weeks or months to results) | 29 of 153 (19%) | 1 of 19 |
| named tools (Semrush, Ahrefs, GA4, HubSpot ...) | 71 of 153 (46%) | 9 of 19 |
| team or named expert | 123 of 153 (80%) | 14 of 19 |
| comparison (vs, versus, different from) | 72 of 153 (47%) | 10 of 19 |

Two rows undercount us: every service page has a process section, but under a question heading ("How does a ... engagement run?") the pattern does not match; and the percentage row matches any percentage (ours are thresholds and cited statistics, not client results). Read with that in mind, our pages are strong on process, deliverables and FAQs, and weak on **case studies, client result numbers, reviews and testimonials**. This is not a writing problem: the rule is no invented numbers or clients (BRAND.md), so the gap closes only with real material from you: client results you can name, the Clutch, GoodFirms or DesignRush review profiles already linked from Home, the HackerNoon award, the 46 named clients and the 3 portfolio projects. `[RECOMMENDATION]` A short proof band on each service page, built only from those verified items.

### 3. Buying questions competitors answer and we do not `[VERIFIED]`

| Page | Question types missing (competitor headings asking it) |
|---|---|
| `/services/ai-growth-systems/` | time (2 competitor headings), definition (4 competitor headings) |
| `/services/generative-engine-optimization/` | time (2 competitor headings) |
| `/services/seo-ai-search-audit/` | choose (3 competitor headings) |
| `/services/seo-content-systems/` | cost (6 competitor headings), time (2 competitor headings) |
| `/services/ai-workflow-automation/` | choose (2 competitor headings) |
| `/services/enterprise-seo-strategy/` | cost (4 competitor headings), time (3 competitor headings), choose (2 competitor headings) |
| `/services/technical-seo-services/` | cost (2 competitor headings), time (2 competitor headings), choose (7 competitor headings) |
| `/services/llm-optimization/` | cost (6 competitor headings) |
| `/services/executive-ai-consulting/` | cost (2 competitor headings) |
| `/services/local-seo/` | cost (5 competitor headings), time (3 competitor headings) |
| `/services/press-release-services/` | cost (3 competitor headings) |
| `/services/best-search-engine-optimization-services/` | cost (2 competitor headings), choose (3 competitor headings) |
| `/services/wordpress-website-design-service/` | definition (2 competitor headings) |
| `/services/ecommerce-website-design-service/` | time (2 competitor headings), definition (4 competitor headings), choose (3 competitor headings) |
| `/services/website-maintenance-services/` | definition (7 competitor headings) |

Cost is the most common: SEO content (6 competitor headings), LLM optimization (6), local SEO (5), enterprise SEO (4), digital PR (3). The AI Search Optimization page already answers cost with the Search Authority OS price (D-135); the same pattern is the fix. "How to choose a provider" is asked on technical SEO (7), SEO audit (3), core SEO (3), e-commerce design (3). `[RECOMMENDATION]` Add one cost FAQ and one timeline FAQ where missing; prices only as you approve them.

### 4. Length and depth by page `[VERIFIED]`

| Page | Working keyword | Our words | Competitor median (range) | Read | Service name in H1: competitors / ours | Outside sources | Pages linking in |
|---|---|---|---|---|---|---|---|
| `/services/ai-growth-systems/` | ai growth systems | 1604 | 1221 (339 to 4236) | 8 of 12 | 5 of 8 / yes | 2 | 4 |
| `/services/ai-search-optimization/` | ai search optimization services | 2650 | 2466 (1052 to 4629) | 9 of 12 | 2 of 9 / yes | 5 | 25 |
| `/services/generative-engine-optimization/` | generative engine optimization services | 1741 | 2934 (1211 to 3666) | 10 of 12 | 9 of 10 / no | 1 | 7 |
| `/services/seo-ai-search-audit/` | seo audit services | 1923 | 2953 (1163 to 4958) | 9 of 12 | 9 of 9 / no | 3 | 13 |
| `/services/seo-content-systems/` | seo content writing services | 1917 | 2260 (151 to 3632) | 10 of 12 | 6 of 10 / no | 2 | 50 |
| `/services/marketing-automation/` | marketing automation services | 1688 | 1757 (537 to 5044) | 7 of 12 | 5 of 7 / no | 4 | 42 |
| `/services/ai-workflow-automation/` | ai workflow automation services | 1776 | 2109 (389 to 5794) | 11 of 12 | 10 of 11 / no | 3 | 9 |
| `/services/enterprise-seo-strategy/` | enterprise seo services | 2179 | 3080 (954 to 4631) | 9 of 12 | 7 of 9 / no | 1 | 6 |
| `/services/technical-seo-services/` | technical seo services | 2143 | 1883 (533 to 3729) | 10 of 12 | 10 of 10 / no | 2 | 19 |
| `/services/international-seo/` | international seo services | 2070 | 2794 (541 to 3938) | 7 of 12 | 3 of 7 / no | 2 | 8 |
| `/services/llm-optimization/` | llm optimization services | 2025 | 1412 (707 to 2025) | 7 of 12 | 3 of 7 / no | 4 | 12 |
| `/services/lead-generation-systems/` | b2b lead generation services | 1745 | 3674 (1428 to 9977) | 7 of 12 | 3 of 7 / no | 2 | 14 |
| `/services/executive-ai-consulting/` | executive ai consulting / ai strategy consulting services | 1888 | 1320 (227 to 5459) | 9 of 11 | 0 of 9 / no | 3 | 8 |
| `/services/local-seo/` | local seo services | 1887 | 1503 (816 to 3495) | 9 of 12 | 8 of 9 / no | 2 | 18 |
| `/services/press-release-services/` | digital pr services | 1995 | 1549 (707 to 3468) | 6 of 12 | 5 of 6 / no | 2 | 13 |
| `/services/best-search-engine-optimization-services/` | search engine optimization services | 2217 | 3506 (629 to 5395) | 8 of 12 | 3 of 8 / no | 1 | 37 |
| `/services/wordpress-website-design-service/` | wordpress website design services | 1547 | 2371 (348 to 3329) | 7 of 12 | 2 of 7 / no | 5 | 16 |
| `/services/ecommerce-website-design-service/` | ecommerce website design services | 1529 | 3285 (510 to 3479) | 5 of 12 | 1 of 5 / no | 2 | 9 |
| `/services/website-maintenance-services/` | website maintenance services | 1752 | 3102 (1475 to 3420) | 5 of 12 | 4 of 5 / yes | 3 | 8 |

Clearly shorter than the field (under 65% of the median): **B2B lead generation** (1,745 vs 3,674), **e-commerce design** (1,529 vs 3,285), **website maintenance** (1,752 vs 3,102), **GEO** (1,741 vs 2,934), **core SEO** (2,217 vs 3,506), **SEO audit** (1,923 vs 2,953), **WordPress design** (1,547 vs 2,371). Longer than the field: pillar, AI Search Optimization, technical SEO, LLM optimization, executive AI consulting, local SEO, digital PR. `[RECOMMENDATION]` Do not pad. Add the missing sections from findings 2 and 3 (proof, cost, timeline, how to choose); that closes most of the difference with useful content.

Outside sources: 1 to 5 per page. GEO, enterprise SEO and core SEO cite 1 outside domain each. Cited facts are what AI engines lift (Day 2 looks at this).

### 5. The pillar: `/services/ai-growth-systems/` (keyword "ai growth systems", D-130)

- **Who holds the term** `[VERIFIED from the results read]`: no authority owns it. The results are small agencies' service pages (Automation Studios, OwlClaw), agency blog posts (Jetfuel, Data-Mania, GitNexa, Groovy Web), a course community and tool directories. No Wikipedia entry, no analyst definition, no large-brand page. Word counts 339 to 4,236, median 1,221; ours 1,604. `[INFERENCE]` This is a winnable category term, which supports D-130.
- **How they define it:** AI agents and automation for acquisition: lead scoring and qualification, outbound, paid media, personalisation, retention, "runs 24 hours". Reinforce Lab's meaning (website, content and organic search visibility connected into one engine) is different and narrower. Terms 3 or more of them use that our page does not: lead qualification, AI agents, machine learning, real time, paid media, conversion rates.
- **Gaps on our page:** (a) no plain one-sentence "An AI Growth System is ..." definition near the top (the H1 and opening describe what Reinforce Lab does; the definition lives on the blog post); 4 competitor headings ask "what is"; (b) no timeline answer ("How long does implementation take?"); (c) no "How is it different from marketing automation?" answer (our comparison is with agencies and tools); (d) no worked example or result; (e) 2 outside sources; (f) 4 pages link to it in content.
- `[RECOMMENDATION]` Add a 40 to 50 word definition block under the hero with a link to the blog post, the two FAQs, and a contextual link to the pillar from each of the 19 service pages ("part of an AI Growth System").

### 6. Home (keyword "reinforce lab", D-130)

- `[VERIFIED]` 1710 words, 12 H2 (3 questions), FAQ 6 equals schema, title 50 characters ("Reinforce Lab | AI Growth Systems, AI Search & SEO"), meta 156, 8 outside domains, no skipped headings.
- A brand keyword has no competitor set to compare with, and Google's results for "reinforce lab" could not be opened from here. The known risk stays: "reinforce labs" (with an s) is the largest query by impressions and looks like a different company (D-130). Home's entity FAQs (what is, who founded, where based) are the right answer to that.
- Home's blog section shows two carried 2025 posts ("20 Real Estate Social Media Posts Ideas 2025", "10 Most Common SEO Mistakes To Avoid 2025") beside the AI Growth System post. `[RECOMMENDATION]` Feature posts that support the category; your call, Day 4 will show it.

### 7. Services hub `/services/`

- `[VERIFIED]` 1170 words, ItemList schema, links to every service, 0 outside sources (fine for a hub). No change proposed.

## What I could not check today

- Google's real top 10 order and SERP features (AI Overview, People Also Ask) per keyword: needs a Google results screenshot or a Semrush SERP export.
- Search volume and difficulty for the 17 working keywords: needs Semrush (the Ahrefs and Similarweb connectors did not connect in this session).
- 74 competitor pages that blocked the fetch (listed at the top of each keyword report).

## Proposed fixes carried to Day 4 (nothing changed today)

1. Service name in the H1 on 16 service pages (benefit line kept).
2. Proof band on service pages from verified items only (needs your input on what may be shown).
3. Cost, timeline and "how to choose" FAQs where missing (prices need your approval).
4. Pillar: definition block, two FAQs, and a contextual link from every service page.
5. Approve a primary keyword for each of the 17 service pages (keyword map v3), so no two pages compete.
