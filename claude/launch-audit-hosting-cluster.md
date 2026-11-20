# Final launch audit: hosting cluster (14 URLs)

Owner: Jamil Ahmed. Prepared 20 Nov 2026. Deadline for all hosting pages: 28 Nov 2026.
Scope: the 14 hosting URLs on **reinforcelab.online** (dev, noindex). Nothing here touches reinforcelab.com.
Rule: a page that fails any **GATE** is not done. Label every finding VERIFIED, INFERENCE or RECOMMENDATION.

Run the automated part first, then the manual part:

```bash
python3 claude/tools/hosting-audit.py --json claude/research/hosting/audit-2026-11-28.json
python3 claude/tools/copy-check.py <draft files>          # 0 issues
python3 claude/tools/readability.py <draft file>          # grade 8.0 or lower
```

## The 14 URLs

| # | URL | Post ID | Role | Focus keyword (Semrush, US) |
|---|---|---|---|---|
| 1 | /best-web-hosting-services/ | 378 | Pillar list, 14 picks | best web hosting services |
| 2 | /best-cloud-web-hosting-services/ | 368 | Cloud list, 7 picks | best cloud hosting |
| 3 | /black-friday-web-hosting-deals/ | 676 | Deals page (new) | black friday web hosting deals |
| 4 | /reviews/best-wordpress-hosting/ | page 69 | WordPress hub, 10 picks | best hosting for wordpress |
| 5 | /hostinger-web-hosting/ | 422 | Review | hostinger review |
| 6 | /bluehost-wordpress-hosting/ | 382 | Review | bluehost review |
| 7 | /dreamhost-wordpress-hosting/ | 409 | Review | dreamhost review |
| 8 | /namecheap-wordpress-hosting/ | 449 | Review | namecheap wordpress hosting |
| 9 | /cloudways-hosting/ | 388 | Review | cloudways review |
| 10 | /kinsta-wordpress-hosting/ | 443 | Review | kinsta review |
| 11 | /flywheel-wordpress-hosting/ | 416 | Review | flywheel hosting |
| 12 | /a2-wordpress-hosting/ | 356 | Review | a2 hosting review |
| 13 | /nexcess-wordpress-hosting/ | 450 | Review | nexcess review |

(13 rows: the 12 posts plus the hub. Count of "14" in older notes included the WP Engine partner page, which is not part of this audit.)

## 1. Technical gates (per URL, automated by `hosting-audit.py`)

- [ ] **GATE** HTTP 200, no redirect chain
- [ ] **GATE** Exactly one H1, logical H2 and H3 order
- [ ] **GATE** Title 30 to 60 characters, unique, keyword near the front
- [ ] **GATE** Meta description 135 to 160 characters, unique
- [ ] **GATE** Canonical is self-referencing and absolute
- [ ] **GATE** `noindex` still on while the site is `.online` (`blog_public = 0`)
- [ ] **GATE** JSON-LD parses; FAQPage present; ItemList on lists; Review or Article node matches visible content
- [ ] Every internal link answers 200 (no 404, no `/paged-N/`)
- [ ] Author is Jamil Ahmed; "Updated" date is a real edit date between 20 and 28 Nov; post date unchanged
- [ ] Cover image is the new `cover-*.jpg` with the new title; alt text present
- [ ] 390 px width: no horizontal page scroll (`node claude/tools/shot.mjs width <paths>` prints 390)
- [ ] Compare tables render in full (no blank "Renews at" column, no "From From")
- [ ] HTML under about 150 KB; LCP image not lazy-loaded (standard section 2)

## 2. Copy gates (per URL)

- [ ] **GATE** `copy-check.py` reports 0 issues (no em or en dashes, no emoji, no banned words)
- [ ] **GATE** Reading grade 8.0 or lower
- [ ] Brand written "Reinforce Lab"; no "Reinforce Lab Limited" outside schema
- [ ] Answer-first: the first paragraph or "Short answer" panel answers the page's main question
- [ ] Number ranges written with "to", dates unambiguous ("20 Nov 2026")

## 3. Truth and trust gates (manual, the most important part)

Hosting pages are YMYL-adjacent money pages. A wrong price is the fastest way to lose trust.

- [ ] **GATE** Every price, renewal price, refund window and offer end date was read on the host's own page within 7 days of launch, and the "price checked" date on the page matches.
- [ ] **GATE** Offers that end before 28 Nov are removed or marked ended (Bluehost 30 Nov, Kinsta first month free 1 Dec, Cloudways BFCM802 4 Dec, Namecheap 4 Dec, Hostinger 14 Dec, hosting.com 1 or 14 Dec: settle the conflict).
- [ ] **GATE** Every claim about speed, uptime or load names its source and date. No invented scores, no "we tested" unless Reinforce Lab ran the test. Only Hostinger may be claimed first-hand (D-321), and only after Jamil's notes are added.
- [ ] **GATE** FTC and affiliate disclosure shown near the top; links to hosts are marked "Ad", use `rel="sponsored nofollow noopener"`, and match the approved affiliate URLs (O-028).
- [ ] When sources disagree, the page says so and states which source it used.
- [ ] Known weak facts are flagged on the page, not hidden: Flywheel renewal (third party), Nexcess renewal and refund not stated, DreamHost nonprofit terms, kinsta.com/pricing two plan lists, the six hosts read on 16 Nov (ScalaHosting, InMotion, BigScoots, Spaceship, DigitalOcean, Network Solutions).
- [ ] No statement that a host paid us or ranks higher because of commission.

## 4. SEO, GEO, AEO and AI-search gates

- [ ] FAQ block with 10 to 14 questions from Semrush and competitor headings; FAQ answers are 1 to 3 sentences, self-contained, with the figure in them
- [ ] Short facts table or "at a glance" strip that an AI answer can quote (price, renewal, refund, best for)
- [ ] Entities named plainly: WP Engine, Liquid Web, hosting.com, Local by Flywheel, Kinsta, Cloudways and the like, each once with its relation
- [ ] "Last updated" visible and equal to the schema `dateModified`
- [ ] Sources panel lists every page read, with read dates
- [ ] AI crawlers allowed in robots.txt on the launch site (Googlebot, Bingbot, GPTBot, ClaudeBot, PerplexityBot) and `llms.txt` decision recorded
- [ ] Spot-check 5 questions in an AI search tool after launch and record whether we are cited (RECOMMENDATION, no promise of results)

## 5. Cluster gates (across the 13 URLs)

- [ ] **GATE** No keyword cannibalisation: each URL has one focus keyword and no two titles target the same query (378 "best web hosting services", 4 "best hosting for wordpress", 368 "best cloud hosting")
- [ ] **GATE** Every host review is linked from the pillar list, the hub and at least two other reviews; no orphan; each review links up to its list
- [ ] The Black Friday page links to all 9 reviews and is linked from the pillar and the lists
- [ ] Hub (page 69) picks match the live review pages (price, renewal, refund)
- [ ] Same price shown for the same plan on every page (check Hostinger, Bluehost, Kinsta across 3 pages)
- [ ] Breadcrumbs consistent (Home, Blog, Web Hosting, page)
- [ ] Redirect map: all hosting URLs are `KEEP` (no slug changed), and the redirect test still reports 0 failures

## 6. Rule and process gates

- [ ] **GATE** Rule 1: nothing in this audit was run against reinforcelab.com
- [ ] **GATE** Rule 2: no production URL changes beyond Jamil's per-URL approval. These pages change by approved migration only
- [ ] **GATE** F-003: no bulk publish, no bulk redate; the pace log shows 3 a day or fewer after 20 Nov, and 20 Nov is recorded as a one-off at Jamil's instruction
- [ ] F-001: no new archive template; `/blog/` pagination still `/blog/page/2/`
- [ ] Every apply has a backup in `claude/data/backups/hosting-rewrite-<date>/`; every cover change has a zip
- [ ] Decision log updated; Notion Business OS updated; `site-map.md` regenerated (`rl.py snapshot` was returning no data on 20 Nov: fix first)
- [ ] `rl.py parity` shows only the three known vendor JS files

## 7. Launch day (only after the `.online` to `.com` migration is approved)

Do not schedule until `claude/migration-checklist.md` Part A is done.

- [ ] Backups of production taken and rollback tested
- [ ] Novamira and AI Abilities removed from the copy that becomes production (Rule 1)
- [ ] Indexing turned on, canonicals correct on the `.com` host, sitemap submitted
- [ ] All 13 hosting URLs answer 200 on `.com` with the same slugs; redirect test 0 failures within the first hour
- [ ] Re-read every offer on the day of launch; remove anything expired
- [ ] Request indexing for the pillar list, Black Friday page (if the sale is still on) and top reviews

## 8. After launch (monitor, do not edit)

- [ ] Search Console: watch clicks, impressions and position for the 13 URLs daily for 2 weeks, weekly for 6 weeks. Flywheel and Namecheap first (most impressions). Compare with the 20 Nov baseline (GSC Pages.csv)
- [ ] Do not change titles or content in the first 14 days unless something is wrong; one change at a time after that
- [ ] Re-read prices and offers monthly, and before every known sale (Cyber Monday, January, summer)
- [ ] Record each change in the decision log with its date

## Known open items (20 Nov 2026)

1. Affiliate URLs and "Ad" wording (O-028 item 1). Nexcess and Liquid Web may be two programmes.
2. Jamil's first-hand Hostinger notes (O-028 item 2).
3. Hostinger price recheck before 14 Dec (O-028 item 3).
4. Search Console Pages and Queries export, needed before judging Flywheel and Namecheap headings.
5. A2 "a2 hosting review" Semrush screenshot (A2 page used competitor semantics instead).
6. hosting.com end date conflict (1 Dec or 14 Dec).
7. `rl.py snapshot` returns no data; `site-map.md` is stale.
8. Old cover attachments are kept (not deleted) after the covers were replaced.
