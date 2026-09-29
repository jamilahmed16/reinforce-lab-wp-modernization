# Technical SEO — competitor & primary-source research (29 Sep 2026)

**Method:** Exa Agent run `agent_run_5c3bdd098b284e65ac680f4905256b0d` (medium effort, 12 searches). Labels: VERIFIED = quoted from Google / web.dev / vendor docs; SECONDARY = third-party study; INFERENCE.

## A. Competitors (page claims)
- **Vezadigital:** technical SEO audit "optimized for LLMs & Google AI". Audit-led; no public proof or pricing.
- **Percepture:** audit for Google and AI search. Recommendations only; little post-fix verification.
- **RankZero:** crawl, render, index, schema, AI-crawler access, llms.txt; tracks AI surfaces separately. Crawler claims not sourced.
- **FactoryJet:** broad audit plus implementation support. Generic; little AI angle.
- **Foundgrove:** crawlability-first audits. Little AI governance or proof.
- **Seer Interactive:** consulting partnership with log files, CWV and migrations, plus launch-day support and QA. Strongest migration model; AI not central.
- **Omega Function (white-label):** developer-ready tickets, verification pass, before/after reports, fixed scope and price.

**INFERENCE — our openings:**
- implementation plus a **post-release verification crawl**, not just an audit;
- **root causes** (template-level) rather than symptom lists;
- **"protect what already ranks"** (URL preservation, redirect maps, approvals);
- an AI-crawler access layer that is **honestly sourced**;
- Google-documented facts stated precisely (the myth-busting section).

## B. Primary-source facts (VERIFIED)
1. **Core Web Vitals** — https://web.dev/articles/vitals
   - LCP "within 2.5 seconds"; INP "200 milliseconds or less"; CLS "0.1 or less".
   - "75th percentile of page loads, segmented across mobile and desktop".
   - INP replaced FID on 12 March 2024 — https://web.dev/blog/inp-cwv-march-12
2. **How Search works:** "three stages, and not all pages make it through each stage": crawling, indexing, serving — https://developers.google.com/search/docs/fundamentals/how-search-works
3. **JavaScript:** Google processes JS "in three main phases: Crawling, Rendering, Indexing". Headless Chromium renders "once Google's resources allow". It "won't render JavaScript from blocked files or on blocked pages". Server-side or pre-rendering "is still a great idea… not all bots can run JavaScript". — https://developers.google.com/search/docs/crawling-indexing/javascript/javascript-seo-basics
4. **Canonical:** redirects and rel=canonical are "a strong signal"; sitemap inclusion is "a weak signal". "Don't specify different URLs as canonical for the same page using different canonicalization techniques." — https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls
5. **robots.txt vs noindex:** "If a page is disallowed from crawling through the robots.txt file, then any information about indexing or serving rules will not be found and will therefore be ignored." — https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag
6. **Sitemaps:** help discovery, "but it doesn't guarantee that all the items in your sitemap will be crawled and indexed." — https://developers.google.com/search/docs/crawling-indexing/sitemaps/overview
7. **hreflang:** "Each language version must list itself as well as all other language versions." — https://developers.google.com/search/docs/specialty/international/localized-versions
8. **Crawl budget:** relevant for "Large sites (1 million+ unique pages)…", "Medium or larger sites (10,000+ unique pages) with very rapidly changing content (daily)", and sites with a large share of "Discovered – currently not indexed". — https://developers.google.com/crawling/docs/crawl-budget
9. **AI crawlers and JavaScript:** **no primary vendor statement found.** SECONDARY: Vercel observed that OpenAI, Anthropic and Perplexity crawlers did not execute JS in its tests (Gemini and AppleBot did) — https://vercel.com/blog/the-rise-of-the-ai-crawler. Do not state this as a universal fact.
10. **Structured data:** "The structured data must represent the content of the page." — https://developers.google.com/search/docs/appearance/structured-data/sd-policies

Note: Exa returned developers.google.cn mirrors; the page links the developers.google.com equivalents (same paths).
