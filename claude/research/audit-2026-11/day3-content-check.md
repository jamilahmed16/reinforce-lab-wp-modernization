# Day 3: content check of Home, the pillar and the 19 service pages, 13 Nov 2026 (F-064)

Scheduled task of the 7-day plan (fired 13 Nov). `.online` only; nothing changed. Tools: `seo-audit.py`, `readability.py` (grade on article text only), copy-check, and a scan of every page's numbers and superlatives. `[VERIFIED]` unless marked. Raw data: `day3-seo-audit.json`, `day3-readability.json`, `day3-claims.json`.

## Verdict

1. **Answer-first: 21 of 21 pages pass.** Each opens with a definition or direct answer in 33 to 70 words and names Reinforce Lab early.
2. **Reading level: 15 of 21 pages are grade 8.0 or lower.** The grade 8 rule is written for posts (D-134); pages are held to it as a guide. Six are above: Home 8.8, Services hub 8.8, International SEO 8.7, Marketing Automation 8.2, Local SEO 8.2, Website Maintenance 8.0 (borderline). The hardest sentences are headings and list items (for example "Generative Engine Optimization." 28.8), which the formula over-scores, plus a few 30-word sentences on Home and International SEO.
3. **Proof: the statistics on the service pages are attributed to outside sources** (named in the text for Google, McKinsey, Gartner, Litmus, Patchstack and W3Techs; the others carry a description of the study and the page's Sources line, which I did not open one by one today). **But there is no result of Reinforce Lab's own on any service page.** Named clients and testimonials appear only on Home; case studies appear as a word on 3 pages (Content Systems, Marketing Automation, Lead Generation) and the only proof elements are testimonials on Local SEO and Home. This is the gap found on Day 1 and it needs Jamil's material.
4. **Internal links: no orphan.** Every service page has at least 6 content links in (pillar 22). Weakest: Enterprise SEO 6, GEO 7, AI Consulting 8, International SEO 8, Website Maintenance 8, AI Workflow 9, E-commerce design 9. Every service page links out to 17 to 24 pages (Core SEO 23, Home 25).
5. **Copy-check: 0 issues** in the 21 page files.

## Page by page

| Page | Grade | Words (article) | Opening (words) | FAQs | Outside sources | Pages linking in | Links out |
|---|---|---|---|---|---|---|---|
| `/` | 8.8 | 1,586 | 33 | 6 | 8 | 142 | 25 |
| `services` | 8.8 | 848 | 34 | 6 | 0 | 38 | 32 |
| `services/ai-growth-systems` | 7.3 | 1,384 | 54 | 9 | 2 | 22 | 19 |
| `services/ai-search-optimization` | 7.4 | 2,060 | 56 | 10 | 5 | 26 | 24 |
| `services/generative-engine-optimization` | 7.3 | 1,578 | 54 | 9 | 1 | 7 | 18 |
| `services/seo-ai-search-audit` | 7.0 | 1,507 | 52 | 9 | 3 | 13 | 18 |
| `services/seo-content-systems` | 7.0 | 1,629 | 58 | 9 | 2 | 50 | 18 |
| `services/marketing-automation` | 8.2 | 1,349 | 58 | 8 | 4 | 41 | 18 |
| `services/ai-workflow-automation` | 7.1 | 1,555 | 70 | 9 | 3 | 9 | 18 |
| `services/enterprise-seo-strategy` | 7.9 | 1,899 | 57 | 9 | 1 | 6 | 18 |
| `services/technical-seo-services` | 7.3 | 1,869 | 47 | 9 | 2 | 20 | 18 |
| `services/international-seo` | 8.7 | 1,673 | 51 | 9 | 2 | 8 | 18 |
| `services/llm-optimization` | 7.1 | 1,608 | 46 | 8 | 4 | 12 | 18 |
| `services/lead-generation-systems` | 7.4 | 1,448 | 69 | 8 | 2 | 14 | 18 |
| `services/ai-consulting-services` | 7.7 | 1,496 | 61 | 8 | 3 | 8 | 18 |
| `services/local-seo` | 8.2 | 1,627 | 55 | 9 | 2 | 18 | 18 |
| `services/press-release-services` | 7.2 | 1,669 | 56 | 8 | 2 | 13 | 18 |
| `services/best-search-engine-optimization-services` | 7.0 | 1,860 | 56 | 8 | 1 | 38 | 23 |
| `services/wordpress-website-design-service` | 7.4 | 1,290 | 49 | 8 | 5 | 16 | 18 |
| `services/ecommerce-website-design-service` | 7.4 | 1,267 | 52 | 8 | 2 | 9 | 18 |
| `services/website-maintenance-services` | 8.0 | 1,363 | 52 | 8 | 3 | 8 | 18 |

## Claims and proof `[VERIFIED from the live text]`

- **Prices:** "from $5,000 setup, plus $1,500 to $2,500 a month" appears on Home, the hub, the pillar, AI Search Optimization and six other pages; the Audit says "from $2,500". All match the Packages page.
- **Pages that carry statistics:** Content Systems (content marketing survey), AI Workflow Automation and AI Consulting (McKinsey, Gartner named), Lead Generation (B2B buyer survey), Press Release (journalist survey), E-commerce design (cart abandonment studies), Website Maintenance (Patchstack named), WordPress Design (W3Techs 40.2%, September 2026, named), Marketing Automation (Litmus and Gmail rules named), GEO (a research paper's 40% figure). A full source-by-source link check is still to do.
- **Superlatives and guarantees:** none about Reinforce Lab. "Best" appears only in Core SEO's "Best when ..." advice lines and Website Maintenance's title (kept from production, D-222). The words "guarantee" and "proven" appear only in warnings ("no one can guarantee ...") or in "each launch is proven before the next one" (International SEO), which is a process claim.
- **Reinforce Lab results, client names, case studies, ratings:** none on any service page. Home has 2 testimonials, a client logo row (46 named clients on `/clients/`) and award badges, each linked to a confirming page.

## Recommended fixes (not applied)

1. **Proof band on each service page** from verified items only: 2 testimonials, 6 client logos, the awards line and a link to `/clients/` and `/portfolio/`. Needs Jamil's yes per page; real case results need his material.
2. **Reading level on 6 pages:** shorten the 30-word sentences on Home and International SEO and turn two lists of noun phrases on Marketing Automation into short sentences. Headings stay.
3. **More links in to the 6 least linked service pages:** add a "related" sentence from the pillar and from the industry pages (the industry pages already link out to 6 services each).
4. **Posts now carry contextual links to services** (robots.txt to Technical SEO, digital marketing strategies to core SEO, B2B SEO agencies to core SEO and four industry pages); keep adding one per rewritten post.

## Not checked

Google's real ranking order and AI-answer behaviour (Day 2), and the 18 company pages and 8 agent pages (not in this scope).
