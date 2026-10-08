# Redirect map: 14 decisions needed from Jamil (8 Oct 2026)

**APPROVED 8 Oct 2026 (D-146):** Jamil approved every recommendation below ("go ahead"). Recorded in `claude/data/approved-redirects-2026-10.csv`.

Draft map: `claude/data/redirect-map-draft.csv` (802 old URLs from every source). Every URL that is live on production, has Search Console clicks or has backlinks already has an approved fate. These 14 remain.

## A. September decisions that name a different address (6)

The September sheet says "keep", but its note names another slug. Keeping both is not possible, so each needs one answer.

| # | Old URL | Search Console (16 months) | September note | Recommendation |
|---|---|---|---|---|
| 1 | `/healthcare/` (old blog category) | 0 clicks | build as industry landing page | **301 to `/industries/healthcare/`** (built) |
| 2 | `/digital-marketing/search-engine-optimization/local-seo/` | 0 clicks | build as `/services/local-seo/` | **301 to `/services/local-seo/`** (built) |
| 3 | `/google-my-business-optimization-service/` | 0 clicks | `/services/google-business-profile-optimization/` | **301 to `/services/local-seo/`** (Google Business Profile is part of Local SEO; no separate page built) |
| 4 | `/seo-website-design/` | 0 clicks, 617 internal links on production | consider a /services/ placement | **301 to `/services/wordpress-website-design-service/`** |
| 5 | `/b2b-marketing/` (old blog category) | 0 clicks, 133 internal links | B2B hub or noindex | **301 to `/industries/b2b-saas/`** (built) |
| 6 | `/seo-content-creator-2/` | 0 clicks, 20,000 impressions | build as `/seo-content-creator/` | **301 to `/services/seo-content-systems/`** unless a `/seo-content-creator/` post is planned |

## B. Pages already dead on production (7)

Production itself returns 404 for these, and its own pages still link to them. No clicks, no backlinks in our data.

| # | Old URL | Production pages linking to it | Recommendation |
|---|---|---|---|
| 7 | `/basic-on-page-seo-checklist/` | 12 | **410** (gone) |
| 8 | `/liquidweb-wordpress-hosting/` | 12 | **410**, or 301 to `/reviews/best-wordpress-hosting/` once built |
| 9 | `/food-content-marketing/` | 2 | **410** |
| 10 | `/benefits-of-digital-marketing-for-small-businesses/` | 1 | **410** |
| 11 | `/link-building-tools/` | 1 | **410** |
| 12 | `/linkedin-content-ideas-for-businesses/` | 1 | **410** |
| 13 | `/project/uiu/` | 1 | **301 to `/clients/`** (United International University is listed there) |

The links pointing at these from old posts are removed or repointed when the posts are carried across (link scan, 0 broken links required).

## C. One image (1)

| # | File | Recommendation |
|---|---|---|
| 14 | `/wp-content/uploads/2024/11/Beyond-Borders-client-of-reinforce-lab-limited.png` | **Keep** (copied with the media library at the switch, same path) |
