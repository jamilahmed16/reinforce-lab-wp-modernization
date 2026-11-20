# Hosting cluster decision: what stays, what changes, and why (20 Nov 2026)

Status: **PROPOSAL for Jamil's decision. Nothing has been changed on any site.** Every URL below is `KEEP` in the approved redirect map (D-146, D-181), so none of this touches a slug, redirect or deletion. Content rewrites follow the 2 a day rule (D-306, F-003), never in bulk.

Labels: VERIFIED = read from the live site, the redirect map, Search Console or Semrush on 19 to 20 Nov 2026. INFERENCE = my reading. RECOMMENDATION = what I advise.

## 1. The question and the answer

Question: keep the existing URLs and add a separate review for each host (Option B), or turn each existing URL into the review (Option A), or make new review URLs for everything?

**RECOMMENDATION: Option A. One URL per host, keep the existing slug, rewrite the page in place into a full review (pricing, WordPress hosting, who it suits, a short "how to set it up" section).** Not B, and not new URLs.

### Why (evidence)
1. **The search intent is the same entity, not two intents.** VERIFIED in Semrush: "[host] hosting", "[host] wordpress hosting", "[host] pricing" and "[host] review" are all brand searches. What ranks for them is the host's own page, then Reddit threads ("is hostinger a good web hosting provider", "why are bluehost reviews so bad"), Trustpilot and a few thin review sites. People want to know "is it good and what does it cost". INFERENCE: that is review intent.
2. **The "how to build a website on X" intent is tiny.** VERIFIED: "how to host wordpress website on bluehost" 20 a month, "how to host wordpress website on hostinger" 0, "how to host wordpress site with dreamhost domain" 0. The current titles target the smallest intent in the family.
3. **Two pages for one brand split links and rankings.** INFERENCE (standard cannibalisation risk): a tutorial and a review for the same host compete for the same brand queries, and every link and internal link is divided between them. One strong page per brand is what hub and spoke sites use.
4. **The current URLs already hold the equity.** VERIFIED (Search Console, 16 months, export of 19 Nov): the nine host URLs together hold about 170,000 impressions (table in section 3). New URLs start from zero.
5. **No redirect is needed.** The slug stays. A slug such as `/namecheap-wordpress-hosting/` is still accurate, and changing slugs only creates redirect risk (Rule 2).
6. **Option B doubles the maintenance.** Prices, renewals and offers change every few months. Two pages per host means twice the updates and twice the chance of a stale price. One page per host is easier to keep accurate.

### Why not "new review URLs for all"
It would send the pages that hold impressions to 301s, make nine new URLs that start with no history, and need your approval for each old URL (Rule 2). Nothing in the data says the old URLs are wrong, only that their titles and content target the wrong intent.

### The honest risks of Option A (INFERENCE)
- **Flywheel ranks position 1 for "flywheel hosting" (1,000 a month) and "flywheel web hosting"** with the current setup guide (Semrush 11 Nov). A rewrite can lose that. Mitigation: keep the headings and steps that rank, add review sections around them, rewrite it last, and watch Search Console for two weeks after.
- **Only Hostinger can be written first-hand (D-321).** The other eight must be labelled research-based and sourced. Google's review guidance favours first-hand experience, so these pages should lead with sourced facts (prices, renewals, offer end dates), not claims of testing.
- A rewrite is a "material content change" to a URL. It still needs your approval per URL before it goes live. The redirect map approval covers the URL, not the new content.

## 2. The cluster

```
PILLAR     /best-web-hosting-services/                    (post 378: best web hosting services 2026)
 |
 +-- LISTS (category pages that link to the pillar and to host pages)
 |     /best-cloud-web-hosting-services/                  (post 368: cloud hosting terms as sections)
 |     /reviews/best-wordpress-hosting/                   (page 69: best WordPress hosting list)
 |     Black Friday web hosting deals                     (new, seasonal, only if live by about 25 Nov)
 |
 +-- HOST PAGES (one per host, existing slugs, rewritten as reviews)
       Hostinger, Bluehost, Cloudways, Kinsta, Namecheap, DreamHost, Flywheel, A2 (hosting.com), Nexcess (Liquid Web)

SUPPORT   /reviews/ hub (page 67) lists host pages and SEO tool reviews
```

Linking rules (RECOMMENDATION):
- Every host page links up to the pillar and to the best list for its type (WordPress, cloud), and across to two close alternatives.
- The pillar and lists link down to each host page with the host's name as the anchor.
- Pricing, renewal and "is it good" content lives on the host page as sections with anchor links (the jump-to links Google already shows must stay).
- No new URL for a host unless a search exists that no page owns.

What I would NOT publish now: the seven hosts with no existing page (ScalaHosting, InMotion, Network Solutions, Domain.com, DigitalOcean, Spaceship, BigScoots) as separate review URLs. They are covered inside the pillar list. No keyword data exists for them yet and each page adds maintenance. Add one later only when Semrush shows demand.

## 3. Published URLs today (VERIFIED live on .online, status 200, all `KEEP` in the redirect map)

Search Console figures are the 19 Nov export (Last 16 months, web). The redirect map holds older, much lower figures for several rows (for example Flywheel 7 impressions there against 33,516 now), so use these. Clicks are very low everywhere (0 to 26 over 16 months) at average positions 15 to 38, so these pages hold impressions but almost no traffic.

| # | URL | Current title (post title) | Clicks | Impressions | Avg pos | Decision |
|---|---|---|---|---|---|---|
| 1 | `/best-web-hosting-services/` | Best Web Hosting Services 2026: 12 Hosts Compared on Price, Speed and Renewals | 1 | 2,639 | 25.9 | **Keep, upgrade** |
| 2 | `/best-cloud-web-hosting-services/` | Best Cloud Hosting 2026: 7 Hosts Compared on Price, Renewals and Who Manages the Server | 3 | 3,242 | 32.8 | **Keep, add sections** |
| 3 | `/reviews/best-wordpress-hosting/` (page 69) | Best Web Hosting for WordPress: 15 Picks (SEO title) | n/a | n/a | n/a | **Keep, build list** |
| 4 | `/hostinger-web-hosting/` | How to Build a Website with Hostinger Web Hosting: A Step by Step Guide | 2 | 1,810 | 18.4 | **Keep URL, rewrite as review** |
| 5 | `/bluehost-wordpress-hosting/` | How to Make A Website with Bluehost WordPress Hosting: A Step by Step Guide | 0 | 13,198 | 38.0 | **Keep URL, rewrite as review** |
| 6 | `/cloudways-hosting/` | How to Make a Website with Cloudways Hosting: A Step by Step Guide | 7 | 9,671 | 27.2 | **Keep URL, rewrite as review** |
| 7 | `/kinsta-wordpress-hosting/` | How to Make A Website with Kinsta WordPress Hosting: A Step by Step Guide | 1 | 7,134 | 36.7 | **Keep URL, rewrite as review** |
| 8 | `/namecheap-wordpress-hosting/` | How to Make A Website with Namecheap WordPress Hosting: A Step by Step Guide | 10 | 45,133 | 32.7 | **Keep URL, rewrite as review (add EasyWP)** |
| 9 | `/dreamhost-wordpress-hosting/` | How to Make A Website with DreamHost WordPress Hosting: A Step by Step Guide | 10 | 18,565 | 29.7 | **Keep URL, rewrite as review** |
| 10 | `/flywheel-wordpress-hosting/` | How to Make A Website with Flywheel WordPress Hosting: A Step by Step Guide | 26 | 33,516 | 17.3 | **Keep URL, rewrite last and carefully** |
| 11 | `/a2-wordpress-hosting/` | How to Make A Website with A2 WordPress Hosting: A Step by Step Guide | 22 | 20,577 | 14.8 | **Keep URL, rewrite as review (now hosting.com)** |
| 12 | `/nexcess-wordpress-hosting/` | How to Make A Website with Nexcess WordPress Hosting: A Step by Step Guide | 25 | 20,082 | 19.3 | **Keep URL, rewrite as review (now Liquid Web)** |
| 13 | `/reviews/` (page 67) | Reviews | n/a | n/a | n/a | **Keep** |

The SEO titles already shortened in the 19 Nov pass (for example "How to Build a Website with Hostinger Hosting") stay until each page is rewritten.

### Proposed review titles (working titles, 60 characters or less, copy-check pending)
| Host | Proposed SEO title | Chars |
|---|---|---|
| Hostinger | Hostinger Review 2026: Pricing, Plans and Real Experience | 57 |
| Bluehost | Bluehost Review 2026: Pricing, Renewals and WordPress Plans | 59 |
| Cloudways | Cloudways Review 2026: Pricing, Servers and Who It Suits | 56 |
| Kinsta | Kinsta Review 2026: Pricing, Speed and Who Should Pay for It | 60 |
| Namecheap | Namecheap Hosting Review 2026: Shared vs EasyWP Plans | 53 |
| DreamHost | DreamHost Review 2026: Pricing, WordPress Plans and Verdict | 59 |
| Flywheel | Flywheel Review 2026: Pricing, Plans and Who It Suits | 53 |
| A2 Hosting | A2 Hosting Review 2026: Now hosting.com, Pricing | 48 |
| Nexcess | Nexcess Review 2026: Now Liquid Web, Plans and Pricing | 54 |

"Real Experience" is only allowed for Hostinger (D-321).

## 4. What changes and why, in order

| Order | Page | Main target keywords (US volume, KD) | Why this order |
|---|---|---|---|
| 1 | Hostinger | hostinger hosting 12,100 (27); hostinger review 1,000 plus reviews 1,300; hostinger wordpress hosting 3,600 (55) | Biggest, easiest opening and the only first-hand host. Current page has only 1,810 impressions, so little to lose |
| 2 | Bluehost | bluehost pricing 720 (14); bluehost wordpress hosting 1,600; wordpress hosting on bluehost 1,300; bluehost review 480 (64) | 13,198 impressions at position 38 and 0 clicks, easy pricing term |
| 3 | DreamHost | dreamhost pricing 480 (55, 36 domains); dreamhost review 210; dreamhost wordpress hosting 210 | Pricing term reachable |
| 4 | Namecheap | namecheap wordpress hosting 480; namecheap review 390; easywp pricing 320 (51) | Most impressions (45,133). Must cover EasyWP |
| 5 | Cloudways | cloudways hosting 1,600; cloudways review 590; cloudways pricing 590 (56) | Pricing top 10 is weak |
| 6 | Kinsta | kinsta review 720 (50); kinsta wordpress hosting 480; pricing 1,900 (hard) | Pricing head term belongs to Kinsta, so lead with review |
| 7 | Nexcess (Liquid Web) | nexcess hosting 210 (15); nexcess review 140; wordpress hosting 50 | Small. Open with the rebrand |
| 8 | A2 (hosting.com) | a2 hosting pricing 70; a2 hosting review 260 (SERP not checked) | Small. Open with the rebrand. Missing the review SERP |
| 9 | Flywheel | flywheel hosting 1,000 (43); pricing 110 (16); review 110 (29) | Last: holds position 1 today. Keep its ranking headings |

Rewrites run 2 a day at most, each previewed with `rl.py preview-post` and approved by you before it is saved. Each page also gets: a first-term vs renewal price table (renewal rises are what Reddit readers complain about), the offer end date, and the Reinforce Lab author byline.

## 5. Affiliate scope (your instruction: hosting, Semrush and some other SEO tools; nothing else for now)

VERIFIED live SEO tool and other review posts, all `KEEP` in the redirect map:

| URL | Clicks | Impressions | Avg pos | Note |
|---|---|---|---|---|
| `/semrush-review/` | 1 | 4,862 | 65.8 | Keep. Candidate for a later rewrite |
| `/surfer-seo-review/` | 0 | 41,650 | 46.4 | Keep (SEO tool) |
| `/rank-tracker-review/` | 1 | 187,397 | 68.9 | Keep (SEO tool). Largest impression count on the site, but position 69 |
| `/copy-ai-review/` | 41 | 53,750 | 21.1 | Best-performing review. Not hosting or SEO. Keep |
| `/writesonic-review/` | 26 | 27,888 | 19.5 | Keep |
| `/jasper-review/` | 5 | 11,345 | 23.9 | Keep |
| `/clickup-review/` | 5 | 5,784 | 45.4 | Keep |
| `/beaver-builder-review/` | 0 | 292 | 24.4 | Keep |

RECOMMENDATION: do no affiliate work on the AI writing, ClickUp and Beaver Builder reviews for now, but do not remove them. All are approved `KEEP`, Copy.ai and Writesonic earn real clicks, and removal needs your per-URL approval (Rule 2). No affiliate programme terms have been checked: I have not verified which of these tools have an affiliate programme, so do not assume.

## 6. What is validated and what is not

VERIFIED: all 15 URLs above answer 200 on `.online`; titles and slugs read from the database; `KEEP` status read from `claude/data/redirect-map-draft.csv`; Search Console numbers from the 19 Nov export; Semrush numbers from your screenshots and CSV (35 of 36 host keywords; see `claude/data/semrush/semrush-36-host-keywords-all-details-2026-11-20.md`).

NOT validated (gaps):
1. **Search Console queries per page.** The export has page totals only, so I cannot see which queries each of the nine URLs earns today. This is the biggest gap and it decides how much risk each rewrite carries, especially Flywheel and Namecheap. Export Pages and Queries together, or filter one page at a time.
2. **"a2 hosting review" SERP** (only the CSV row).
3. **Why impressions are high but clicks near zero.** Positions are 15 to 38, so this is expected, but I have not checked whether the pages were de-indexed or never crawled on production. The migration data says 58 content pages holding clicks were never crawled.
4. **Prices, renewals and offer end dates** change by the week. Each rewrite re-checks them at the official pages the day it is written.
5. **Intent claims** (brand queries are review intent; two pages would cannibalise) are INFERENCE from the Semrush top results, not a controlled test.

## 7. Decisions needed from Jamil

1. **Option A in place (RECOMMENDED), Option B, or new review URLs.**
2. **Approve the order in section 4**, and confirm Flywheel last.
3. **Do not publish new URLs for the seven hosts without pages**: yes or no.
4. **Black Friday page**: start now or skip this year.
5. **Send the Search Console Pages and Queries export** so the rewrites are made with the real queries in front of us.
