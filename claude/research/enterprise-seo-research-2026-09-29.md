# Enterprise SEO Strategy — research brief (29 Sep 2026)

For: `/services/enterprise-seo-strategy/` (page 98, `.online`). Method: Exa agent run
(`agent_run_551416276d9747c5848e667fb46323ba`, 12 searches) plus direct fetches of the Google
primary sources. Competitor rows are **page-level observations**, not audited claims.

## A. Competitor service pages (what they say, what they leave out)

| Agency page | Scope | Process | Pricing signal | Gap visible on page |
|---|---|---|---|---|
| WebFX — enterprise SEO | Technical, content, keyword strategy, dev, analytics, AI search, enterprise reporting | Custom strategy; specialist team; quarterly strategy meetings, ROI forecasts | "Starting at $11,500/month" | No step-by-step implementation workflow; links only inside content marketing |
| Numarr — enterprise SEO | Technical, content, authority for 1,000s–millions of pages; international, multi-location, e-com, link building, reactive PR | Crawl/log/crawl-budget analysis, template + internal-link review, stakeholder interviews; impact/effort roadmap with owners; works in eng sprints | Scoped per engagement | No reporting cadence or published range |
| Ignite Visibility — enterprise SEO | Technical, content governance, digital PR, AI visibility, reporting | Baselines by page group; revenue-gap priority; dev tickets with acceptance criteria; tracks shipped vs stalled | "Engagements start at $2,000/month" | No package tiers or contract detail |
| Technical SEO Experts — enterprise technical SEO | Migrations, redirects, crawl monitoring, GSC API, alerting, sprint planning, PR review, dev training | Discovery → audit → advisory/implementation cadence | Not stated | No content or authority building |
| Winning SERP — enterprise SEO | Technical, content architecture/governance, template governance, internal links, schema, migrations | Roadmap with owner/dependency/acceptance criteria; post-release regression checks | Not stated | No link-building or international depth |
| SEO.com — enterprise SEO | Technical, content, off-page support, AI search, reporting | Consultative discovery → tailored plan | "$11,500/month or more" | No schedule, volumes, cadence |

**Pattern to beat:** everyone lists technical + content + governance + reporting. Authority/link work
is present but under-specified, and none publishes its link rules. Our page makes the operating
model explicit (governance → templates → migrations → international → authority → measurement) and
states the link rules we follow, sourced to Google.

## B. Verified Google facts (primary sources)

1. **Link spam** — "Link spam is the practice of creating links to or from a site primarily for the
   purpose of manipulating search rankings." Examples include buying/selling links for ranking
   purposes, excessive link exchanges, automated link programs, advertorials with links that pass
   ranking credit, optimized anchor-text links in guest posts or press releases distributed on other
   sites, low-quality directory/bookmark links, widely distributed footer/template links.
   Also: buying and selling links "is a normal part of the economy of the web for advertising and
   sponsorship purposes… not a violation… as long as they are qualified with a rel="nofollow" or
   rel="sponsored" attribute". — https://developers.google.com/search/docs/essentials/spam-policies
2. **Qualify outbound links** — `sponsored` for ads/paid placements (nofollow still acceptable,
   sponsored preferred); `ugc` for comments/forum posts; `nofollow` when the others don't apply. —
   https://developers.google.com/search/docs/crawling-indexing/qualify-outbound-links
3. **Site moves** — "Expect temporary fluctuation in site ranking during the move"; medium sites can
   take a few weeks or more, larger sites longer; "Keep the redirects for as long as possible,
   generally at least 1 year." —
   https://developers.google.com/search/docs/crawling-indexing/site-move-with-url-changes
4. **Site reputation abuse** — announced 5 Mar 2024, enforced from 5 May 2024; third-party content
   published on a host "mainly because of that host's already-established ranking signals";
   clarified 19 Nov 2024. — https://developers.google.com/search/blog/2024/11/site-reputation-abuse
5. **People-first content** — "created primarily for people, and not to manipulate search engine
   rankings." — https://developers.google.com/search/docs/fundamentals/creating-helpful-content
6. **Crawl budget** — guide is for "Large sites (1 million+ unique pages) with content that changes
   moderately often (once a week)" or "Medium or larger sites (10,000+ unique pages) with very
   rapidly changing content (daily)"; Google calls these "a rough estimate", "not exact thresholds".
   — https://developers.google.com/crawling/docs/crawl-budget
7. **Pagination / facets** — link pages sequentially with `<a>` tags, unique URL per page; if you
   don't need faceted URLs indexed, prevent crawling of them. —
   https://developers.google.com/search/docs/specialty/ecommerce/pagination-and-incremental-page-loading ·
   https://developers.google.com/crawling/docs/faceted-navigation

## C. Do not claim
- Crawl-budget numbers as hard thresholds.
- That AI-search optimisation is a Google ranking factor.
- Any competitor's results, awards or revenue lifts.
- Any Reinforce Lab enterprise result, client or price (none supplied by Jamil).
- The F-001 `/paged-N/` case study (permission pending).

## D. GSC context for the legacy URLs that D-023 maps here (production, read-only)
- `/services/off-page-seo-services/` — 12 clicks, 47,499 impressions, avg position 40.8.
- `/services/best-affordable-seo-link-building-services/` — 3 clicks, 34,775 impressions, avg pos 37.2;
  "affordable seo link building services" query at avg position 16.5.
- Intent is **off-page / link building (affordable)**, not enterprise → see O-018.
