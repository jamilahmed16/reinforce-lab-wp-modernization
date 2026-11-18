# Full-site audit before launch, 18 Nov 2026 (F-073)

`.online` only, read-only. 167 published pages: 46 built pages (home, 19 services, 8 industries, 8 agents, hubs, About, Contact, company, projects) and 121 carried or new posts. Tools: `seo-audit.py`, `rl.py crawl`, `copy-check.py` rules on live text, `shot.mjs width` (390 px, all 168 pages), redirect test, link scan, post-check. VERIFIED unless marked.

## Result in one line
**The 46 built pages are clean. All real issues sit in the older posts.** Nothing found blocks the switch on its own, but one rule conflict needs your decision.

## Built pages (46): clean
- 0 banned words, dashes or emoji. One H1 each, no duplicate titles or meta, social image on every page, titles 60 or less, meta 140 to 160, no heading skips, no images without alt text, all pass at 390 px width.
- Redirect test 0 failures (2,107 requests). Link scan 0 bad links (633 targets). 81 carried posts: 0 problems.

## Posts (121): what is wrong
| Issue | Pages | Launch blocker? |
|---|---|---|
| Banned words or phrases from the copy-check list: 210 in total (the two most common phrases appear 29 and 28 times; full counts come from `copy-check.py` on each post) | 64 | Breaks the copy rule. See decision below |
| En dashes 331, em dashes 19, emoji 4 (worst: creative-content-marketing-ideas 24 en dashes) | 64 | Same |
| Title over 60 characters | 43 | No (SEO polish) |
| Meta description outside 140 to 160 | 48 | No |
| Heading levels skipped | 53 | No |
| Not answer-first, brand missing in the opening | 54 and 39 | No |
| Zero internal links in (orphans) | 16 | Fix before launch if time allows |
| Images without alt text | 10 (Home 1, Blog 1, 8 posts) | Small, quick fix |
| Images without size | 11 | No |
| FAQ schema differs from visible FAQ | 4 | Quick fix |

## Not a real fault on `.online` (will be tested on the new site)
- Canonical not OK on all 167, and "dangling" `#organization` schema reference on 158. Both were identical on Day 6. INFERENCE: `.online` is noindex, so Yoast leaves them out. Must be re-checked on the new copy; if the `#organization` reference is still missing there, it is a real schema fault.
- HTML above 150 KB on 164 pages: known and accepted (D-174 to D-176, inlined styles).

## Decision for Jamil
D-218 says carried posts **launch with their old text** and are rewritten after launch (2 a day from 17 Nov, D-306). The copy rule says no em or en dashes and no banned words on every word of the site. 64 posts break the rule today. Options:
1. **Keep D-218 (RECOMMENDED):** launch as is, rewrite 2 a day. No bulk edit, F-003 stays intact.
2. **Mechanical fix before launch:** replace dashes and emoji only in the 64 posts (banned phrases need human rewriting). Quick, but it is a mass modification pass of 64 posts, the pattern F-003 warns about.

## Not run
Accessibility (axe) and speed (Lighthouse) were last run in October. Style fingerprint against the design system. Image-level design review of each page by eye. Say if you want them before launch.
