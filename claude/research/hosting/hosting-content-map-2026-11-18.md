# Hosting content map: who owns which search (18 Nov 2026)

Purpose: stop our own hosting pages from competing with each other. Data: clicks and impressions from the redirect map (Search Console, 16 months), keywords from `audit-2026-11/post-keyword-map.md`. VERIFIED unless marked. Prices and facts are not in this file.

## The rule
One URL per search intent. Old URLs keep their slug (Rule 2, checklist A3). A new URL is only made when no existing URL already owns that intent.

## Pages that exist today (live on `.online`, preserved from production)

| URL | Impressions / clicks | Primary keyword (volume, KD) | Intent today | Role |
|---|---|---|---|---|
| `/best-web-hosting-services/` | 2,463 / 1 | best web hosting (5,400, 81) | Best-of list, all hosts | **Hub for all hosts.** Rewritten 16 Nov (D-323) |
| `/best-cloud-web-hosting-services/` | 3,196 / 3 | best cloud hosting (1,600, 55) | Best-of list, cloud only | **Cloud list.** Draft rewrite 18 Nov, not live (this file's owner: F-074) |
| `/namecheap-wordpress-hosting/` | 61,839 / 10 | namecheap wordpress hosting (480, 58) | How to build a site on Namecheap | Overlaps the new Namecheap review |
| `/dreamhost-wordpress-hosting/` | 26,081 / 11 | dreamhost review (210, 60) | How to build a site on DreamHost | No new review drafted |
| `/bluehost-wordpress-hosting/` | 20,980 / 0 | bluehost wordpress hosting (1,600, 62) | How to build a site on Bluehost | No new review drafted |
| `/kinsta-wordpress-hosting/` | 12,735 / 5 | kinsta review (720, 50) | How to build a site on Kinsta | Overlaps the new Kinsta review |
| `/flywheel-wordpress-hosting/` | 7 / 0 | flywheel hosting (1,000, 43) | How to build a site on Flywheel | No new review drafted |
| `/cloudways-hosting/` | 14 / 0 | cloudways review (590, 52) | How to build a site on Cloudways | Overlaps the new Cloudways review |
| `/hostinger-web-hosting/` | 2 / 0 | hostinger wordpress hosting (3,600, 55) | How to build a site on Hostinger | Overlaps the new Hostinger review |
| `/a2-wordpress-hosting/` | 88 / 0 | a2 hosting review (260, 50) | How to build a site on A2 Hosting | A2 is now hosting.com: overlaps the new hosting.com review |
| `/nexcess-wordpress-hosting/` | 2 / 0 | nexcess review (140, 32) | How to build a site on Nexcess | Overlaps the new Liquid Web (Nexcess) review |
| `/reviews/` and `/reviews/best-wordpress-hosting/` | n/a | n/a | Hub pages built from shortcodes (D-191) | Page 69 is a hosting list view, not a copy of 378 |

## The overlap (INFERENCE: two pages for one search split rankings)
Six hosts have both an old "how to build a site on X" post and a new review drafted at a new URL: **Hostinger, Cloudways, Kinsta, Namecheap, hosting.com (A2) and Liquid Web (Nexcess)**. The old posts are the same keyword family ("namecheap review", "kinsta review") and some carry real impressions (Namecheap 61,839, Kinsta 12,735).

### Proposed fix (needs Jamil's approval for each of the 6 URLs, Rule 2)
**Option A (RECOMMENDED):** publish each review at the existing URL, keeping the slug, and fold the setup steps into the review as a "How to set up" section. One URL per intent, keeps the impressions, no redirect needed. The review drafts then move from `/<host>-review/` to the old slug.
**Option B:** keep the old post as the tutorial, publish the review at its new URL, link them both ways, and retitle neither. Two URLs, two intents. Slightly more work and a small risk the two still compete.

The 7 hosts with no old post (ScalaHosting, InMotion, Network Solutions, Domain.com, DigitalOcean, Spaceship, BigScoots) get new URLs as drafted.
Bluehost, DreamHost and Flywheel have old posts and no review drafted: leave them as they are until reviews are written at the same URLs.

## Links to add (no content changes elsewhere)
- `/best-web-hosting-services/` links to `/best-cloud-web-hosting-services/` (done 18 Nov).
- `/best-cloud-web-hosting-services/` links to `/best-web-hosting-services/` and to the existing setup guides for Cloudways, Kinsta and Hostinger (in the draft).
- Each review links to its list page and, if Option B, to its old setup guide.
