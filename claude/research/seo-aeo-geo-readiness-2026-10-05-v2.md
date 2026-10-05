# SEO, AEO, GEO and LLM readiness, second pass: all 53 published pages on `.online` (5 Oct 2026)

**Asked by Jamil:** "go ahead check all the seo, GEO, LLMs, AI Searches, AEO readiness".
**Measured against:** the build standard `claude/seo-geo-aeo-standard.md` (D-012), same method as the first pass (F-025, `seo-aeo-geo-readiness-2026-10-05.md`).
**Method (VERIFIED unless marked):** `claude/tools/seo-audit.py` read the live HTML of all 53 published pages (45 from F-025 plus Privacy, Terms, FTC Disclosure, Portfolio, Clients and the 3 project pages). The tool was extended for this pass: project pages, `og:image` / `og:site_name` / Twitter card, `html lang`, schema `@id` references, and a wider answer-first check. Site-wide files (`llms.txt`, `robots.txt`, sitemaps), the Organization entity, and a lab run at phone size (390 px) on 7 pages. Finding F-026.

## Verdict

**Every page now passes the technical, schema and answer-engine gates.** The F-025 site-wide gaps are closed, except the decisions that belong to launch. **What remains is content, not code:** outside citations on 16 commercial pages, question-shaped H2s on 3 pages, and blog posts (none published yet).

## Results (53 pages)

| Gate | Result |
|---|---|
| One H1, no skipped heading levels | 53 of 53 |
| Title 60 characters or less, brand at the end, unique | 53 of 53 |
| Meta description 140 to 160 characters, unique | 53 of 53 |
| `noindex` while on `.online` | 53 of 53; uploaded files (PDF, images) now also send `X-Robots-Tag: noindex` (D-128) |
| Schema parses, no broken `@id` references | 53 of 53 |
| FAQ: visible questions equal `FAQPage` questions | 46 of 46 pages with FAQs (no FAQ by design: Privacy, Terms, FTC, Blog index, 3 project pages) |
| Answer-first opening | 53 of 53 (Terms opens with "The terms for ...", which the heuristic misses; it is a direct statement) |
| Reinforce Lab named in the first 200 words | **53 of 53 (was 36 of 45)**: fixed on the 8 agent pages, Audit, Packages, FTC |
| Share image (`og:image` 1200 x 630) | **53 of 53 (was 0)**: default card, Home included |
| `og:site_name` "Reinforce Lab", `lang="en-US"`, Twitter large card | 53 of 53 |
| Images with alt text and size | 53 of 53 |
| Breadcrumb | 52 of 53 (Home has none, correct) |
| Contextual inbound links | 51 of 53; Terms and FTC Disclosure are linked from the footer and the legal pages only (fine for legal pages); Clients now linked from About and Portfolio |
| HTML size (150 KB budget) | **all 53 under, 93 to 135 KB (13 were 151 to 161 KB)** after removing unused WordPress block and emoji code |
| Copy rules | 0 issues on every page changed in this pass |

## Entity and AI layer

- **Organization (every page):** name, `legalName` Reinforce Lab Limited, `foundingDate` 2022-04-19, RJSC `identifier` C-180618/2022, Dhaka `address`, `email`, 2 `contactPoint`, 9 `sameAs` profiles. WebSite name "Reinforce Lab" with search action.
- **`/llms.txt`:** 54 links (was 45): adds Portfolio, Clients, the 3 project pages, Privacy, Terms, FTC Disclosure and the Certificate of Incorporation; the company line gives the founding date and RJSC number.
- **Sitemaps:** pages and projects (`rl_project-sitemap.xml`) both listed.
- **Rendering:** all text is in the server HTML.

## Performance (lab, phone 390 px, 7 pages)

| Page | Layout shift (CLS) | Requests | Google Fonts requests |
|---|---|---|---|
| Home | **0.005 (was 0.154)** | 18 | 0 |
| About | 0.000 | 19 | 0 |
| Search Authority OS | 0.000 | 18 | 0 |
| Technical SEO | 0.000 | 19 | 0 |
| Healthcare | 0.000 | 19 | 0 |
| Clients | 0.000 | 65 (46 logos) | 0 |
| Inpace Shop project | 0.000 | 19 | 0 |

The self-hosted, preloaded fonts (D-123) removed the font-swap shift. Lab readings only: field data (Core Web Vitals) only exists once the site is live and has traffic.

## Fixed in this pass (F-026)

1. Brand named in the opening of the 8 agent pages ("Reinforce Lab's ... Agent"), the SEO & AI Search Audit, Packages ("Reinforce Lab's flagship system") and FTC Disclosure.
2. Default share image `reinforce-lab-ai-growth-systems-og.png` (attachment 328, made from `claude/design-previews/og-default/og-default-card.html`, the locked core message) set as Yoast's default and the front-page image (backup `claude/data/backups/yoast-social-og-before-2026-10-05.json`).
3. `llms.txt` additions (above).
4. On pages built from `[reinforce_*]` shortcodes: WordPress block-library CSS and global styles removed (about 21 KB inline per page; blog posts keep them). Emoji detection script and styles removed site-wide (no emojis under D-072).
5. Clients linked from About ("46 named clients") and Portfolio.
6. Audit tool: project pages, social tags, schema references, wider answer-first verbs.

## Still open

| Item | Pages | Owner / next step |
|---|---|---|
| ~~Outside citations~~ **DONE same day** | Sources added to the 8 agent pages, Home, Search Authority OS, Diagnostic, AI Search Optimization and the Audit: 42 of 53 pages now cite primary sources. Packages and the two hubs make no outside claims and link to sourced pages | See F-026 in `claude/decision-log.md` |
| Question-shaped H2s | Home, Search Authority OS, Diagnostic | Claude drafts, Jamil approves (Home copy is approved design) |
| Blog posts | 0 published | Content phase; topic clusters per D-012 |
| `dateModified` in schema | 47 of 53 have none | Appears when a page is edited after publishing; never by a bulk pass (F-003) |
| `<main>` element | Theme uses `div role="main"` | Works as a landmark; optional theme template change |
| Canonical tags | Not output while noindex (Yoast) | Verify on launch day |
| AI-crawler policy in `robots.txt` | Site-wide | Jamil decides before launch (production-only change) |
| VAT/BIN number | Terms, Privacy | Jamil supplies before launch |
