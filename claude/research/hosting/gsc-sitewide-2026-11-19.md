# Search Console export, whole site, 19 Nov 2026 (VERIFIED from Jamil's export)

Files: `claude/data/gsc-2026-11-19/` (Chart, Pages, Queries, Countries, Devices, Search appearance). Window: 18 Jul 2025 to 17 Nov 2026 (16 months), web search. Limits: Pages and Queries are separate lists (no page and query pairs), 1,000 query rows, 442 page rows.

## Trend
- 16-month total: 3,358 clicks, 4,193,670 impressions.
- Monthly clicks: Sep 2025 544, Dec 2025 240, Mar 2026 201, May 2026 81, Aug 2026 41, Sep 2026 40, Oct 2026 27, Nov 2026 so far 90.
- **The November rise is two spike days, not a recovery:** 2 Nov 49 clicks and 14 Nov 16 clicks. Every other day in the last 20 is 0 to 4 clicks. Cause unknown (INFERENCE only: one-off events), do not report it as recovery.
- Countries: US 674 clicks and 2.67 million impressions; India 494 clicks and 185,413 impressions. Desktop 1,965 clicks, mobile 1,365.

## What earns clicks today
Top pages by clicks: social-media-content-ideas-for-clothing-brand 533, best-examples-of-great-food-copywriting 494, Home 224, social-media-content-ideas-for-restaurants 201, content-marketing-for-banks 176, churches 161, hotels 155, snapchat-content-ideas 135. Top queries: "reinforce lab" 87, "reinforce labs" 37, "20 advantages of social media" 13, food copywriting terms. **The hosting pages bring almost no clicks** (flywheel 26, nexcess 25, a2 22, namecheap 10, dreamhost 10, cloudways 7, hostinger 2, kinsta 1, bluehost 0).

## Hosting queries (sitewide list, so the mapping to a URL is by brand name)
| Brand | Queries and what they say | Position | Clicks |
|---|---|---|---|
| Flywheel | "flywheel hosting" 4,211 impressions, "flywheel web hosting" 3,412, "flywheel wordpress" 2,907, "flywheel wordpress hosting" 2,197, "flywheel website hosting" 1,584 | 9 to 17 | 0 to 3 |
| Namecheap | 20+ variants of "namecheap wordpress ..." (for, hosting, and, with, on, managed, woocommerce, shared) about 1,000 to 1,850 each | 24 to 37 | 0 |
| Nexcess | "**nexcess login**" 2,703 impressions at position 9; "nexcess review" 906 at position 64 | 9 and 64 | 1 and 0 |
| DreamHost | "dreamhost wordpress hosting" 1,491, "dreamhost web hosting" 931 | 12 and 26 | 0 |
| A2 | "a2 hosting wordpress" 975 at position 9, "a2 wordpress hosting" 87 | 9 | 0 to 1 |
| Cloudways | "cloudways" 360, "cloudways hosting" 305 | 24 to 38 | 1 |

Readings (INFERENCE): searchers for Flywheel, Nexcess login and Namecheap WordPress are mostly looking for the host or the right plan, not for a review, which is why the click rate is near 0. No review keyword (for example "kinsta review") appears in the top 1,000 for any of them except "nexcess review" and "flywheel wordpress hosting review" (121 impressions).
Semrush (US) puts "flywheel hosting" at position 1 while Search Console shows an average position of 15 across all countries. Both can be true: the average mixes countries.

## Jump-to section links
Pages.csv lists addresses with a section anchor, for example `a2-wordpress-hosting/#A2_Hosting_Pricing_How_much_is_A2_Hosting` (position 7.95), `#Is_A2_Hosting_reliable`, `#What_is_A2_Hosting`, `flywheel-wordpress-hosting/#Is_Flywheel_Good_for_Hosting`, `#Flywheel_Pricing_Are_the_Prices_Justified`, `nexcess-wordpress-hosting/#What_Is_Nexcess`, `#Nexcess_Pricing_Is_Nexcess_Good_for_Hosting`, and similar for Cloudways and Hostinger. Google shows these headings as jump links at positions 5 to 9. **Any update of these posts must keep those headings (and their anchors) or rename them with care,** or we lose those results.

## What this means for the plan
1. Keep the existing hosting URLs and their question headings. Add review content and a "login and rebrand" answer where searchers ask for it (Nexcess login, A2 now hosting.com).
2. Namecheap: the demand is "WordPress on Namecheap", so cover EasyWP vs shared and the setup path before the review verdict.
3. A new `/<host>-review/` page (initial plan, Option B) targets a keyword the old URL does not rank for, so it adds reach instead of competing, but each needs its own search data.
4. The site's clicks come from the social media idea posts and food copywriting posts and Home, so avoid risky changes to them (they are in the old-post rewrite queue).

## Still needed
Per-URL query lists (page filter, then Queries tab) to see which exact queries each hosting URL gets.
