# Full re-check of all 60 pages on `.online`, 12 Nov 2026 (F-058)

**Asked by Jamil:** "go ahead, run the full re-check", after the week's changes to service, industry, agent, Packages and Diagnostic pages (D-225 to D-233). `.online` only.

## Results `[VERIFIED]`

| Check | Tool | Result |
|---|---|---|
| Live code equals git | `rl.py parity` | 81 files, 0 unexpected differences (the 3 GSAP vendor files are kept out of git by design) |
| Copy rules in the theme code | `copy-check.py` | 0 issues in 69 files |
| Site crawl, 143 addresses | `rl.py crawl` | 0 PHP errors, noindex on every page, 0 of the 60 pages flagged; 72 carried blog posts flagged for dashes in their old text (known, rewritten after launch, D-218) |
| One H1, no skipped heading levels | `seo-audit.py` | 60 of 60 |
| Title 60 characters or less, unique | `seo-audit.py` | 60 of 60 |
| FAQ on the page equals FAQPage schema | `seo-audit.py` | 60 of 60 |
| Share image, noindex, schema parses | `seo-audit.py` | 60 of 60 |
| Internal links | `link-scan.py` | 148 pages scanned, 569 link targets, 0 bad links, 0 links to the live domain or written-out `.online` |
| Redirect map | `redirect-test.py` | 2,107 requests over 807 old addresses, 0 failures (43 old `/wp-content/` files answer 404 until the server 410 rule exists in the rebuild) |
| Phone width, 390 px | `shot.mjs width` | 60 of 60 at 390, no sideways scroll |

## Small flags, all present before this week's work

| Page | Flag | Note |
|---|---|---|
| `/reviews/` | meta description 129 characters; brand not in the first 200 words | below the 140 to 160 target |
| `/reviews/best-seo-ai-tools/` | meta description 139; brand not in the first 200 words | 1 character short |
| `/reviews/best-wordpress-hosting/` | brand not in the first 200 words | |
| `/agency-partner-program-wp-engine-landing/` | meta description 131 | |
| `/careers/`, `/legal-statement/` | meta description 170 | 10 over |
| `/terms-conditions/` | opening not detected as answer-first | opens "The terms for ...", a direct statement the check misses |
| Home, Blog index | 24 and 11 images with empty alt text | decorative repeats inside `aria-hidden` rows (client logo strip); correct as built |
| 57 of 60 pages | HTML above the 150 KB guide (141 to 225 KB) | from the inlined styles of the lean setup (D-174 to D-176), a deliberate trade for speed; this week's changes added 1 to 3 KB per page |

## Not covered by this re-check

- Blog posts (82): next stage, after the pages (Jamil).
- Accessibility (axe) and speed (Lighthouse): last run in October; no layout or script changed this week except the small H1 line.
- Meta descriptions on the 6 retitled pages still match their pages but were written for the old titles.
