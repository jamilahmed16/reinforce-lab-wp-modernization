# Local SEO — competitor & primary-source research (29 Sep 2026)

**Method:** Exa Agent run `agent_run_00c3bff17f6e402197ef16470fe6fcb5` (medium, 12 searches). Plus repo GSC data (10 Sep export).

## Demand we already have (GSC, 16 months, reinforcelab.com — VERIFIED)
| Query | Impressions | Position |
|---|---|---|
| "local search engine optimization company" | 9,720 | 73 |
| "local search engine optimization service" | 9,581 | 70 |
| "local search engine optimization services" | 8,631 | 64 |
| "local seo audit" | 5,289 | 66 |
| "local search optimization services" | 4,764 | 49 |

- The legacy post **`/best-local-search-engine-optimization-service/`** has 95,538 impressions (102,060 on the crawl sheet), 0 clicks, position ≈ 60, 0 internal and 0 external links. The disposition sheet says "APPROVED (HOLD): BUILD fresh…"; the redirect map says 301 → `/services/local-seo/`.
- **`/how-to-do-local-seo-audit-11-easy-steps/`** has 8,340 impressions and has never been crawled. It is approved for a fresh rebuild and is supporting content for both Local SEO and the Audit.

## A. Competitors
TechnSEO, B2BSEO.io, The Business Rover (from $750/mo), Local SEO Services NYC (from $599/mo), Taskcover, LocalGaps (claims a 90-day guarantee), THAT Agency.
- **Table stakes:** Google Business Profile, citations, reviews, location pages, schema, reporting.
- **Gaps (INFERENCE):** mostly consumer-focused; unverified guarantees and AI-ranking claims; little on review-policy compliance.

## B. VERIFIED (primary sources)
1. **Local ranking:** "Local results are mainly based on relevance, distance, and popularity/prominence… There's no way to request or pay for a better local ranking on Google." — support.google.com/business/answer/7091
2. **Google Business Profile guidelines** — support.google.com/business/answer/3038177
   - Name must "reflect your business's real-world name"; "Including unnecessary information in your business name isn't permitted, and could result in the suspension".
   - Service-area businesses: "one profile for the central office or location with a designated service area".
   - "can't list a 'virtual' office unless that office is staffed during business hours".
3. **Reviews:** incentives to post, change or remove reviews are "strictly prohibited" (support.google.com/business/answer/3474122). Merchants may not "Discourage or prohibit negative reviews, or selectively solicit positive reviews" (support.google.com/contributionpolicy/answer/7400114).
4. **FTC final rule on fake reviews and testimonials:** announced 14 Aug 2024; bans the sale or purchase of fake reviews, including AI-generated ones. — ftc.gov press release, 2024-08
5. **LocalBusiness structured data:** required properties are `name` and `address`. — developers.google.com/search/docs/appearance/structured-data/local-business
6. **Responding to reviews:** "Helpful and positive replies to reviews can show that you're responsive to your customers." Not stated as a ranking factor. — support.google.com/business/answer/3474050
7. **Apple Business Connect** place cards appear "from Maps to Siri…". **Bing Places for Business** manages Bing Maps listings.
8. **AI:** ChatGPT Search can use location and "sometimes partners with other search providers" (help.openai.com/en/articles/9237897). Gemini API Grounding with Google Maps (ai.google.dev/gemini-api/docs/maps-grounding). Perplexity's local data source is **UNVERIFIED**.
