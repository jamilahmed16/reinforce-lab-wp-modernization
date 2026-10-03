# REINFORCE LAB — APPROVED DECISION LOG

Decisions explicitly made by Jamil Ahmed. Per Master Project Instructions §40 and §42, these override recommendations, historical documents, and tool output. They are not to be silently changed.

---

## D-001 — Development environment build strategy
**Date:** 20 August 2026
**Decision:** **BUILD FRESH on reinforcelab.online, migrate content selectively.**
**Status:** APPROVED — ACTIVE

The 2 GB All-in-One WP Migration export of production (`reinforcelab-com-20260821-012909-xsikt4zv7p9w.wpress`) is **NOT** to be imported into reinforcelab.online. It is retained as:
- the §37 BACKUP step and the project's rollback point
- a reference/forensic copy for inspecting production configuration

**Consequences:**
- `.online` keeps its clean Beaver Builder Theme + Beaver Themer install
- Production's plugin bloat, broken pagination rewrites, misconfigured store, and stale configuration are **not** inherited
- The production customer database (WooCommerce orders, user accounts, WPForms submissions, PayPal configuration) never lands on a publicly reachable staging site
- Content moves across **selectively and only after per-URL approval** (§10)
- Existing Beaver Builder page layouts on production must be re-created rather than copied — accepted cost of this decision

---

## D-002 — WooCommerce
**Date:** 20 August 2026
**Decision:** **KEEP AND FIX.** The store stays in the new architecture and gets rebuilt properly.
**Status:** APPROVED — ACTIVE

**Consequences:**
- The **11 existing product URLs are existing production URLs** and fall under the §10 absolute protection rule. They remain `PENDING` and must be preserved unless individually approved otherwise.
- `/shop/` currently renders blog posts instead of products — a live defect to be fixed, not carried across.
- `/cart/`, `/checkout/`, `/my-account/` are transactional URLs and enter the QA scope (§36 CONVERSION).
- WooCommerce, PayPal and WooCommerce POS must be re-established on `.online` as part of the fresh build.
- Store URLs are currently orphaned — zero internal links. The new information architecture must give the store a real navigation and conversion path (§35).
- Migration QA now includes a commerce layer: product URL preservation, checkout flow, payment configuration, order data integrity.

---

## D-003 — The six missing AI-first service pages
**Date:** 20 August 2026
**Decision:** **BUILD THE PAGES — on reinforcelab.online, not on production.**
**Status:** APPROVED — ACTIVE

The six services currently linked from the production footer that return 404 will be built as new pages in the development environment and go live with the redesign. No page will be created directly on production.

**Consequences:**
- These are **new URLs** under §27, not protected existing URLs. Slugs require approval before building (see O-008).
- `/services/ai-search-optimization-services/` and `/services/creative/ai-search-optimization-services/` are two paths for the same service. **Only one may be built** or we create cannibalisation on day one.
- **Production continues to serve six sitewide footer 404s until launch.** See O-009 — this needs a separate, explicit decision.

---

## D-004 — ACF edition
**Date:** 20 August 2026
**Decision:** **ACF Free installed on reinforcelab.online now. ACF Pro to be purchased later.**
**Status:** APPROVED — ACTIVE

**Consequences:**
- Unblocks the start of ARCHITECT. Basic field types, Beaver Themer field connections, and simple dynamic content all work on Free.
- **Repeater, Flexible Content, Options Pages, Gallery and Clone are Pro-only.** The §18–19 design direction — system diagrams, methodology steps, structured proof blocks, service system cards — is built on repeatable structured content. Those components cannot be built maintainably on Free.
- **Pro becomes blocking at content-model design**, not before. Flagged so the purchase is not a surprise mid-build.

### SUPERSEDED 20 Aug 2026 — **ACF PRO 6.8.8 is now installed and active on reinforcelab.online** `[VERIFIED]`
Repeater, Flexible Content, Options Pages, Gallery and Clone are all available. **R11 is closed.** The §18–19 design direction — system diagrams, methodology steps, structured proof blocks, service system cards — can now be built as structured, maintainable content. **ARCHITECT is unblocked on the field-model side.**

---

## D-005 — Tier 1 URL protection list
**Date:** 20 August 2026
**Decision:** **APPROVED — PRESERVE for all 17 Tier 1 URLs.**
**Status:** APPROVED — ACTIVE
**Evidence:** Google Search Console, 16 months (19 Apr 2025 – 18 Aug 2026). These 17 URLs carry **3,735 of 4,618 clicks — 81% of all measured organic traffic.**

| # | URL | GSC Clicks | GSC Avg Pos | Orphaned |
|---|---|---|---|---|
| 1 | `/social-media-content-ideas-for-clothing-brand/` | 713 | 11.2 | |
| 2 | `/best-examples-of-great-food-copywriting/` | 688 | 13.4 | |
| 3 | `/social-media-content-ideas-for-churches/` | 286 | 21.1 | |
| 4 | `/` (homepage) | 273 | 8.5 | |
| 5 | `/social-media-content-ideas-for-restaurants/` | 256 | 25.2 | |
| 6 | `/snapchat-content-ideas/` | 255 | 10.4 | |
| 7 | `/content-marketing-for-banks/` | 219 | 36.0 | |
| 8 | `/social-media-content-ideas-for-hotels/` | 202 | 40.2 | |
| 9 | `/successful-digital-marketing-campaign-examples/` | 135 | 43.4 | **YES** |
| 10 | `/social-media-content-ideas-for-photographers/` | 115 | 27.6 | |
| 11 | `/top-advantages-and-disadvantages-of-using-social-media/` | 112 | 28.8 | |
| 12 | `/social-media-content-ideas-for-nonprofits/` | 95 | 29.2 | |
| 13 | `/content-marketing-ideas-for-healthcare-industry/` | 93 | 43.9 | **YES** |
| 14 | `/sensory-marketing-know-how-5-senses-marketing-works-best-for-businesses/` | 90 | 21.9 | |
| 15 | `/creative-content-marketing-ideas/` | 75 | 39.6 | |
| 16 | `/services/website-maintenance-services/` | 66 | 32.6 | |
| 17 | `/copy-ai-review/` | 62 | 25.1 | **YES** |

**What APPROVED — PRESERVE binds us to, for each of these 17 URLs:**
- The **URL does not change.** No slug change, no permalink change, no folder move.
- **No redirect, no consolidation, no removal, no de-indexation.**
- The **canonical stays self-referencing** and unchanged.
- **Title tag and meta description are preserved** unless separately approved.
- **Content is preserved.** Substance, headings, structure and internal anchors carry across the redesign intact.
- **Existing internal links into these pages are preserved.**
- Visual/template modernization is permitted, since it changes presentation and not the indexed asset.
- **Improvement is explicitly NOT authorised by this decision.** Rewriting, expanding, re-targeting or re-optimising any of these 17 requires a separate approval.

**Homepage note:** `/` is Tier 1 with the site's best CTR (2.42% at position 8.5). PRESERVE here protects the URL, its canonical and its indexed status — it does **not** freeze the homepage redesign, which is the core of this project. The §2 locked headline and the §17 architecture proceed as planned. The open H1 wording conflict (Baseline v2 §E2, R8) is still unresolved and unaffected by this approval.

**Verification requirement at launch (§36):** all 17 must be checked for URL preservation, status 200, indexability, canonical, title, and content parity before production cutover.

---

## D-006 — Slugs for the five new service pages
**Date:** 20 August 2026
**Decision:** **APPROVED as proposed.**
**Status:** APPROVED — ACTIVE

| Footer label | Approved slug |
|---|---|
| AI-First Business Systems | `/services/ai-first-business-systems/` |
| AI Search Optimization | `/services/ai-search-optimization/` |
| GEO Services | `/services/generative-engine-optimization/` |
| SEO & AI Search Audit | `/services/seo-ai-search-audit/` |
| Pharmaceutical SEO | `/services/pharmaceutical-seo/` |

**Six broken footer links resolve to five pages.** `/services/ai-search-optimization-services/` and `/services/creative/ai-search-optimization-services/` were two paths for one service; only one is built.

**Retired paths — no redirect required.** These returned 404 and never existed, so they hold no equity and there is nothing to redirect. The footer links are simply removed:
- `/services/creative/ai-search-optimization-services/`
- `/services/creative/pharmaceutical-seo-services/`
- `/services/ai-search-optimization-services/`
- `/services/generative-engine-optimization-service/`

**Implied by this approval, recorded so it is explicit:**
- The `/creative/` folder is **not** used for the new services. It stays a legacy container for graphic design.
- The `best-…-services` keyword-stuffed naming convention is **not** carried into new URLs. Existing URLs using it are unaffected and remain PENDING.
- **Pharmaceutical SEO is built as a service page, not an industry page.** See the note below.

**Open architectural consequence — revisitable at no cost until build starts.** `/services/pharmaceutical-seo/` places the flagship locked industry inside the services folder. If industry pages are later built for the other five locked industries (§5), an `/industries/` architecture would scale more cleanly and `/services/pharmaceutical-seo/` will sit awkwardly beside it. Nothing has been created, so this can still be changed. Raise at ARCHITECT if the industry-page direction is wanted.

**Build constraint:** these pages are built on **reinforcelab.online only** (D-003). They go live at launch. No page is created directly on production.

---

## D-007 — Crawl-waste investigation authorised
**Date:** 20 August 2026
**Decision:** **APPROVED** — proceed with steps 1–5 of the Crawl Waste Fix Plan: diagnosis and testing on reinforcelab.online, plus read-only inspection of production.
**Status:** APPROVED — ACTIVE

**Explicitly NOT authorised by this decision:** any change to reinforcelab.com. Robots.txt edits, rewrite-rule changes, plugin settings and redirects on production each require a separate written proposal and a separate approval (step 6 of the plan).

---

## F-001 — ROOT CAUSE CONFIRMED: Beaver Builder multi-module pagination
**Date:** 20 August 2026
**Status:** `[VERIFIED — independent source]`

The `/paged-N/M/` URL pattern is a **documented Beaver Builder / Beaver Themer defect**, confirmed on Beaver Builder's own community forum: when **two or more Posts modules appear on a single Beaver Themer archive template**, pagination generates `/blog/paged-2/2/` instead of `/blog/page/2/`. A secondary trigger reported in the same thread is **two Themer layouts targeting the same location**.

The forum thread shows the issue **unresolved by Beaver Builder staff**. The only confirmed workaround is removing the additional Posts module.

Source: https://community.wpbeaverbuilder.com/t/pagination-issue-with-archive-when-2-posts-modules-are-used/12962

**Scale on reinforcelab.com:** **229 malformed `/paged-N/` URLs**, across 8+ archive templates.

**Why this is critical to the rebuild:** the locked stack (§21) is Beaver Builder Pro + Beaver Themer. **This defect will reproduce on the new site** unless archive templates are designed to prevent it.

### ARCHITECTURAL RULE — binding on the new build

> **Every Beaver Themer archive template must contain exactly ONE Posts module, bound to the main query. No archive location may be targeted by more than one Themer layout.**

This is the permanent fix. It costs nothing if applied before templates are built.

**Residual uncertainty:** WPCode and Code Snippets on production have not yet been inspected, so a contributing custom rewrite rule cannot be fully excluded. It is no longer the leading explanation.

### Evidence added 20 Aug 2026 — production Themer Layouts inspected `[VERIFIED]`

Production has **5 Themer layouts**:

| Layout | Type | Location |
|---|---|---|
| 5 Best AI Content Writing Tools 2023 | Singular | Post: *5 Best AI Content Writing Tools 2025* |
| **Blog** | **Archive** | **All Archives** |
| Blog Single Post | Singular | Post |
| Footer | Footer | Entire Site |
| Header | Header | Entire Site |

**Secondary trigger CONFIRMED — two layouts target the same location.** "Blog Single Post" targets *Post* (every post); "5 Best AI Content Writing Tools 2023" targets one specific post. On that post, **two singular Themer layouts both apply** — the exact overlap condition named in the Beaver Builder forum thread.

**Explains a separate finding:** a **single** Archive layout ("Blog") is set to **All Archives**, so it renders `/blog/`, every category archive, and every author archive. This is why the crawl found `/business/`, `/b2b-marketing/`, `/clothing-brand-marketing/`, `/digital-marketing/*`, `/business/small-business/` and others all containing **exactly 670 words** of identical text. One layout, one block of static content, many URLs. Google declined all of them as duplicates.

**Incidental:** the layout titled "…Tools **2023**" targets a post titled "…Tools **2025**" — a further trace of the bulk redating in F-003.

**Still outstanding to close F-001:** the number of **Posts modules inside the "Blog" archive layout**. The layout list cannot show this; the layout must be opened in the builder.

### Confirmed on reinforcelab.online 24 Aug 2026 — real stack `[VERIFIED]`

Read-only inspection of `.online` (full locked stack active: Beaver Builder Pro, **Beaver Themer**, ACF PRO, PowerPack, Jetpack, LiteSpeed, Yoast Premium) confirms **11 `paged-N`→`flpaged` rewrite rules registered**, identical in shape to production and to the clean uniposh install. This closes the rewrite-rule half of F-001 on the actual rebuild environment: **Beaver Builder registers these rules unconditionally the moment the plugin is active** — they are not the trigger. The trigger is the **front end emitting** `/paged-N/M/` links, which occurs when an archive template carries 2+ Posts modules or two Themer layouts overlap a location.

**Empirical seed-and-teardown reproduction on `.online` was offered and deliberately declined (Jamil, 24 Aug 2026).** The evidence is already sufficient on three independent fronts (Beaver Builder forum; production Themer layouts inspected; rewrite rules confirmed on the real `.online` stack). `.online` also has **0 published posts**, so a faithful reproduction would require seeding temporary content — rejected to keep the fresh build clean (consistent with F-003).

**F-001 is CONFIRMED for rebuild purposes. Binding architectural rule stands:** every Beaver Themer archive template contains exactly ONE Posts module bound to the main query; no archive location is targeted by more than one layout. Only production-side gap remaining is **O-013** (count of Posts modules in production's "Blog" archive layout) — needed to explain production's existing 229 junk URLs, but **not blocking the rebuild**.

---

## F-002 — Robots.txt patterns validated against all 787 URLs
**Date:** 20 August 2026
**Status:** `[VERIFIED — tested against the full register]`

| Pattern | URLs matched | Composition | Clicks | Impressions |
|---|---|---|---|---|
| `Disallow: /*/paged-*` | 223 | 100% malformed `/paged-N/` — **no real pagination matched** | **0** | 104 |
| `Disallow: /*wc-ajax=` | 7 | 100% PayPal AJAX endpoints | **0** | 0 |

**Real `/page/N/` pagination — 29 URLs, 5 clicks, 395 impressions — is NOT matched by either pattern.** This was the main risk in the proposal and it is now excluded by test.

**Combined blocking impact: 0 clicks and 0.00% of site impressions.**

**Incidental finding:** 4 URLs carry `?et_blog`, a **Divi Builder** AJAX parameter — evidence of a previous page builder leaving artefacts behind. Logged for the migration inventory.

---

## F-003 — Bulk content operation in early 2025
**Date:** 20 August 2026
**Status:** `[VERIFIED fact / INFERRED cause]`
**Source:** WordPress WXR export, 20 Aug 2026

**Verified fact:** all **111 published posts** carry a `post_date` between **1 Jan and 4 Mar 2025**, and **99 of 111** were last modified in **April 2025**.

**Inferred:** a bulk redate / republish / rewrite operation was performed on the entire blog in early 2025. Timeline correlates with the traffic curve — peak July 2025, collapse from September 2025, 53% of published posts now unindexed. **Correlation, not proven causation** (GSC index data only reaches back 90 days).

**Binding operational consequence for the rebuild:**
> **No bulk publishing, no bulk redating, no mass modification passes on the new site.** Content ships deliberately, with a defined role (§31), and is measured.

**Related:** 76 drafts exist, 61 over 1,000 words, including a 7-post dental/local-SEO cluster. **Recommendation: leave unpublished.** Publishing them in a batch would repeat the exact pattern that preceded the collapse, and they target consumer local-SEO buyers rather than the six locked industries (§5). No decision made — Jamil's call at CONTENT phase.

---

## F-004 — Content is clean and portable; legacy builder residue confirmed
**Date:** 20 August 2026
**Status:** `[VERIFIED]`

**Good for D-001:** **108 of 111 published posts are plain, portable content.** Zero Divi shortcodes in content, zero `_et_pb_use_builder` active, only 3 posts use Beaver Builder, zero posts carry a Yoast noindex. Content migration is low-risk and low-effort.

**Migration hazard:** post metadata carries residue from **Divi Builder + Monarch** (~650 items, incl. `_et_pb_old_content` on 642), LiteSpeed, reSmush.it and MonsterInsights. **The site previously ran Divi** — which explains the `?et_blog` parameter URLs found in F-002. A database-level migration would carry thousands of dead meta rows across; D-001's build-fresh decision avoids this entirely.

---

## D-008 — Primary positioning category changed to "AI GROWTH SYSTEMS"
**Date:** 20 August 2026 · **Status:** APPROVED — ACTIVE
**Supersedes:** Master Project Instructions §2, §3 and §43.

**New locked core message:** *Build AI Growth Systems To Automate Operations, Improve Search Visibility, and Increase Revenue.*

**New locked positioning:** *Reinforce Lab builds AI Growth Systems that connect your website, content, and organic search visibility into one growth engine. We design and implement data-driven SEO, AI Search automation, and content systems for growth-stage founders and B2B companies who want measurable revenue.*

**Jamil's personal positioning — LOCKED, DO NOT REWRITE:**
- LinkedIn headline: *I build AI Growth Systems for businesses with AI Automation, AI Search & SEO | SEO & AI Search Consultant | Semrush Ambassador | Pharmacist | CEO, Reinforce Lab Ltd*
- LinkedIn About opening: *I am the Founder and CEO of Reinforce Lab Ltd, where I help design and implement AI Growth Systems for businesses using AI automation, AI Search Optimization, SEO, and intelligent workflows.*

**Historical, preserved, not current:** "AI-first business systems" · "AI-first business consultancy" · "AI-first growth consultancy".

**Search-demand evidence (Semrush, US, 23 Aug 2026):** "ai growth systems" = **20 US / 40 global searches per month**, KD n/a, CPC $9.23, SERP analysis returns *"Nothing found"*. **This is a category-creation play, not a search-demand play.** Strong as a brand category; near-zero as a traffic target. It must NOT carry the commercial acquisition load for the 45-day revenue objective.

**Adjacent opportunity:** *"ai systems for professional services firms law finance consulting growth"* — 260 volume, KD 8, touching Professional Services (locked industry).

---

## D-009 — Crunchbase description to be rewritten for "AI Growth Systems"
**Date:** 20 August 2026 · **Status:** APPROVED — ACTIVE · **Supersedes** the earlier "keep Crunchbase as-is" lock.

Replace "AI-powered growth consultancy" and both instances of "AI-first business systems" with **AI Growth Systems**. Retain the pharmaceutical specialization detail (manufacturers, exporters, CROs, CDMOs). **Draft required; Jamil approves before publication. Not yet drafted.**

---

## D-006a — Service slug amended
**Date:** 20 August 2026 · **Status:** APPROVED — ACTIVE · **Amends D-006.**

`/services/ai-first-business-systems/` → **`/services/ai-growth-systems/`**

Final five approved new service URLs: `/services/ai-growth-systems/` · `/services/ai-search-optimization/` · `/services/generative-engine-optimization/` · `/services/seo-ai-search-audit/` · `/services/pharmaceutical-seo/`

**⚠️ SUPERSEDED in part (D-022, 28 Sep 2026):** `/services/pharmaceutical-seo/` is **not built**. Pharmaceutical moved out of Solutions into the new Industries axis as **`/industries/pharmaceutical/`** (plain slug). The other four stand; D-023 then expanded the Solutions set well beyond five. Kept here as the record of what was approved on 20 Aug.

---

## D-010 — Production homepage H1 and intro change AUTHORISED
**Date:** 20 August 2026 · **Status:** APPROVED — **NOT YET EXECUTED**

**First authorised production content change of this project.** Scope: H1 and intro paragraph on `/` only.

**H1 to become:** *Build AI Growth Systems To Automate Operations, Improve Search Visibility, and Increase Revenue.*
**Intro to become:** the D-008 positioning paragraph verbatim.

**Explicitly NOT changed:** URL · canonical · title tag · meta description · navigation · footer · CTA · form.

**Risk: LOW.** The homepage earns primarily on brand queries — "reinforce lab" (109 clicks, pos 2.27) and "reinforce labs" (36 clicks) are ~145 of its 273 clicks. Brand rankings are driven by entity signals, not H1 keywords, and the retired term has no search demand.
**At stake:** the homepage is the only page growing — +96% clicks in three months, 2.42% CTR at position 8.5 (33× site average).
**Rollback:** Beaver Builder + WordPress revisions; both wordings recorded verbatim.
**Monitoring:** GSC homepage only — clicks, impressions, position, CTR, brand queries — at 14 and 28 days.

**VERIFIED 20 Aug 2026: NOT yet live.** Homepage still serves the old H1 and intro.

---

## D-011 — Footer updated to "AI Growth Systems" (PARTIAL)
**Date:** 20 August 2026 · **Status:** PARTIALLY EXECUTED — verified live

Executed by Jamil in the Beaver Themer **Footer** layout (Entire Site).

**✅ Completed — footer blurb, sitewide.** Now reads: *"Reinforce Lab builds AI Growth Systems that connect your website, content, and organic search visibility into one growth engine. We design and implement data-driven SEO, AI Search automation, and content systems for growth-stage founders and B2B companies who want measurable revenue."* This removes the retired "AI-first business consultancy" line from **every page on the site**. Significant positioning win.

**✅ Completed — Solutions link 1.** Label "AI-First Business Systems" → **"AI Growth Systems"**, href → `/services/ai-growth-systems/`, matching the D-006a approved slug.

**❌ Outstanding — the link targets are still broken.** Verified live 20 Aug 2026:

| # | Label | href | Status |
|---|---|---|---|
| 1 | AI Growth Systems | `/services/ai-growth-systems/` | **404 — page not built** |
| 2 | SEO & AI Search Audit | `/services/seo-ai-search-audit/` | **404** |
| 3 | AI Search Optimization | `/services/wordpress-website-design-service/` | **200 — WRONG PAGE** |
| 4 | GEO Services | `/services/generative-engine-optimization-service/` | **404** |
| 5 | Automated SEO Content Systems | `/services/ai-search-optimization-services/` | **404** |
| 6 | Pharmaceutical SEO Services | `/services/creative/pharmaceutical-seo-services/` | **404** |
| 7 | Marketing Automation | `/services/creative/ai-search-optimization-services/` | **404** |

**Net effect on the link problem: unchanged.** Six 404s plus one mislabel, sitewide, ~182 internal links each. Link 1 moved from one 404 to a different 404 — now at least the *correct* future URL.

**O-009 remains open.**

---

## F-006 — Novamira MCP was mis-pointed at `uniposh-ah.com`; corrected to `.online`
**Date:** 24 August 2026
**Status:** `[VERIFIED — resolved]`

**What was wrong.** The Novamira MCP connection wired into the AI client was bound to an **unrelated WordPress site** — `https://uniposh-ah.com` (site title "uniposh-ah.com", admin `rafiqulposhbd@gmail.com`, theme UniPosh Child), **not** `reinforcelab.online` as CLAUDE.md assumed. It was a Claude Desktop "Local dev" connector, so it did not appear in `claude mcp list`; it is being removed from the desktop app's Connectors UI.

**No production risk.** Only read-only inspection ran against the wrong site before the mismatch was caught (`home_url()`, rewrite-rules read). `reinforcelab.com` was never touched. Rule 1 held.

**The fix.** Removed the uniposh connector and registered `novamira-reinforcelab-onl` in Claude Code **user config** via the `@automattic/mcp-wordpress-remote` **application-password bridge** (Hostinger-recommended; OAuth from cloud clients can be blocked by Hostinger's firewall). Credentials passed only as env vars (`WP_API_URL`, `WP_API_USERNAME`, `WP_API_PASSWORD`); app password stored in plaintext in `~/.claude.json` — rotate via wp-admin → Users → Application Passwords if needed.

**Verified in-session** through the new server: `home_url = site_url = https://reinforcelab.online`, `blog_public = 0` (noindex — correct for dev), WordPress 7.1.

**Tooling note.** WP-CLI shell execution is unavailable on this host — `proc_open`/`exec` are disabled in PHP (Hostinger managed). So `novamira/run-wp-cli` fails; use **`novamira/execute-php`** for diagnostics (e.g. reading the `rewrite_rules` option instead of `wp rewrite list`).

**Incidental evidence for F-001** (gathered on `uniposh-ah.com`, a clean Beaver Builder Pro install — transferable because it is the same locked-stack builder): the `paged-N` → `flpaged` rewrite rules are registered **unconditionally by Beaver Builder Pro** the moment the plugin is active (13 such rules present with no Themer, ACF, PowerPack, content, or archive templates). This refines F-001: the multi-Posts-module / overlapping-layout condition is what causes the front end to **emit and expose** `/paged-N/M/` links for Google to crawl — it is **not** what creates the rewrite rules. Standard `page/N/` pagination coexists correctly. O-013 (count of Posts modules in production's "Blog" archive layout) still stands as the item that closes F-001 outright.

---

## D-012 — SEO / GEO / AEO / AI-search build standard is BINDING
**Date:** 10 September 2026 · **Status:** APPROVED — ACTIVE

Every page, template, and component built on `.online` (and carried to production) must meet the standard in [seo-geo-aeo-standard.md](seo-geo-aeo-standard.md): semantic HTML + one H1, unique title/meta, self-canonical, correct indexability (`.online` stays noindex until launch), valid schema per template (Organization/Service/FAQPage/BreadcrumbList/Article/Person), consistent brand **entity** ("Reinforce Lab" everywhere — fixes the crawl's entity-inconsistency finding), Core Web Vitals budget, answer-first content with FAQ/Q&A blocks, `llms.txt` + AI-crawler policy, internal-link in/out (no orphans), and the F-001 archive rule (no `/paged-N/`). A page that skips a gate is not done.

**Migration safety** is governed by [migration-and-data-requirements.md](migration-and-data-requirements.md): the `.online → .com` cutover is a content + URL migration, safe only when every one of the 787 URLs has an explicit disposition (PRESERVE / 301 / CONSOLIDATE / RETIRE→301 / KEEP-noindex) and a tested redirect map. **Migration must not be scheduled** until the blocking data lands (backlinks URL-level, full GSC pages+queries, GSC Page Indexing, GA4, WPCode inventory) and the redirect map is complete. 765 of 787 URLs are still PENDING.

---

## D-013 — Design direction locked: dark "Systems Grid" (frontal-calibrated)
**Date:** 10 Sep 2026 · **Status:** APPROVED — ACTIVE · supersedes the earlier light draft

Active design system `reinforce-lab-systems-grid` (stored on `.online` via Novamira): **dark** ground `#121011`, deep brand red **`#990000`** as the single accent (glow reserved for shapes, never text), **Oswald** headings + buttons (uppercase, Medium), **IBM Plex Sans** body, **IBM Plex Mono** bracketed eyebrows, **zero rounded corners**, full-bleed bands at 1280 inner width, encoded type scale. Calibrated against frontal.so (adapted, not cloned — red not orange).

**Built so far on `.online`:** Home **hero** (locked H1/positioning, animated "SEO ENGINE" systems diagram — inputs → engine → priority-article output, red data-flow pulses, reduced-motion safe) and a **dark glassmorphism header** (native bb-theme header restyled: wordmark logo, Oswald uppercase nav assigned to the `header` location, red CTA button, transparent at top → frosted glass on scroll, content-aligned full-width). Site background set to `#121011`. Pages/nav link to `#` placeholders pending build. All output passes `novamira/check-design` and D-012.

---

## GSC PRIMARY DATA RECEIVED — closes O-005 + O-010
**Date:** 10 September 2026 · **Status:** `[VERIFIED — from GSC exports]`

Jamil delivered the full Search Console evidence base in one batch (21 files, raw in [claude/data/gsc-2026-09/raw/](data/gsc-2026-09/raw/)): **Performance** (16 months, Web, **global** — not US-only SEMrush), **Page Indexing / Coverage** + 3 drilldowns + post-sitemap, and the **Links** report (external backlinks + 11 internal-link drilldowns). This supersedes every prior traffic figure, which was SEMrush estimate. **O-005, O-010 and O-011 (GA4) are closed** (GA4 answered for diagnosis — full landing-page CSV still ideal for per-URL register work). Remaining DISCOVER gap at the time: the **WPCode inventory** (O-014, since closed — see F-014). New item raised: **O-015** (production shows two homepage titles incl. the "AI Growth Systems" positioning — confirm which page and trace to an approval).

### F-007 — Real global traffic: peak Jul 2025, impressions cliff Sep–Oct 2025
16-month totals: **4,319 clicks / 5,951,488 impressions** (global). Monthly clicks/impressions:

| | Jul'25 | Aug'25 | Sep'25 | Oct'25 | … | Aug'26 | Sep'26(part) |
|---|---|---|---|---|---|---|---|
| Clicks | 525 | 454 | 544 | 389 | | 41 | 8 |
| Impressions | 1.12M | 1.03M | 630K | 226K | | 71K | 9K |

The defining event is an **impressions cliff** — 1.03M (Aug'25) → 630K → **226K (Oct'25), ~−78% in two months** — while average position barely moved (~48–50). Clicks held ~2 more months, then bled out through 2026. Pages losing impressions while rank holds = loss of eligibility, not a ranking drop. Refines the earlier SEMrush-based "525→27" (real Aug'26 = 41). Devices: desktop 2,593 / mobile 1,689 / tablet 37 clicks. 395 clicks came via Google **Translated results** (international surfacing).

### F-008 — The collapse is crawl-budget starvation + a small quality-rejection set (CORRECTS earlier framing)
Coverage as of ~4 Sep 2026: **93 indexed / 346 not indexed** (439 known — confirms the "19.4% indexed" figure from GSC itself). Not-indexed reasons: Crawled–not-indexed **140**, Alternate w/ canonical **75**, Discovered–not-indexed **74**, noindex 38, 404 **13**, robots 3, redirect 3.

**Correction to my first read of this data:** the 140 "Crawled – currently not indexed" is **not** mostly a sitewide quality verdict. The full 139-row list breaks down as ~**113 technical junk** Google is right to skip — **63 `/paged-N/M/` junk (F-001)**, 18 author archives, 11 `/page/N/`, 8 `wc-ajax`/`wp-json`, 7 `/feed/`, 6 sitemap `.xml` — and only **~20–25 real articles/services** genuinely crawled-and-rejected. So the dominant mechanism is **crawl budget consumed by junk**, which starves real pages (below), plus a smaller thin-content rejection set. This is a more fixable diagnosis than a blanket demotion.

### F-009 — 58-pages-never-crawled claim proven at URL level (`Last crawled: 1970-01-01`)
The "Discovered – not indexed" drilldown shows every URL with **`Last crawled: 1970-01-01`** — the epoch date = **Google has never fetched them**. Hard proof behind the "58 real pages never crawled" finding. The never-crawled set is exactly the commercial inventory the business needs: `/dental-seo/`, `/youtube-seo/`, `/a-complete-woocommerce-seo-guide/`, `/what-is-technical-seo…/`, `/how-to-do-local-seo-audit/`, plus review pages (kinsta, cloudways, semrush, jasper, …). Caveat: the discovered drilldown is a 39-row **sample** of the 74; the crawled 139-row export is complete.

### F-010 — External link equity is ~93% concentrated on the homepage
Only ~13 URLs have any external link. **Homepage: 261 incoming links from 50 sites**; every other page has 1–3. Total ≈ 281, so the homepage holds ~93%. Referring profile is thin and **directory-heavy** (jadirectives 91 — likely one sitewide link, designrush 24, ecommercefastlane 21, goodfirms 18, inpaceshop.com 16 = own project, advocategazi 15; long tail of single-link profile listings). **Migration implication:** retiring deep blog/junk pages costs almost no backlink equity; the homepage is the crown jewel and is preserved by default. De-risks the RETIRE decisions F-008/F-009 point to.

### F-011 — Internal linking is nav/footer-dominated; content is orphaned
Eleven pages sit at **104–107 internal links** (menu + footer: privacy, contact, terms, homepage, get-a-free-quote, 3 service pages, blog, our-team, portfolio), then a cliff — nonprofits-content 34, banks 27, small-business 18, rest in single digits or zero. Mechanism behind "337 URLs with zero internal links," and validates **O-002**. The `/paged-N/` junk sits *inside* the internal link graph (it appears as linking pages), which is how Google keeps rediscovering it; the least-linked content pages get their only inbound links from that junk, so removing junk also strips their thin linking — linking must be rebuilt deliberately.

### F-012 — Backlink profile is branded/navigational, ~zero topical anchor equity (clean but weak)
Site-level Links report: **~60 referring domains** (vs 50 for the homepage alone — ~10 more reach inner pages). Anchor-text distribution is dominated by **branded/navigational** terms — ranks 1–13 are "reinforce lab", "reinforce lab ltd", "visit website", "reinforcelab com", "reinforce lab limited", "visit / view website / source", followed by ~15 machine-**translated** brand variants (directory listings: "laboratorio de refuerzo", "güçlendirme laboratuvarı", "강화 연구소", …). **Topical anchors barely exist** and rank 17+: "content marketing", "digital marketing agency", "social media marketing service", "content writing service", "branding", "b2b". No spam/over-optimized anchors — the profile is **clean but thin**: there is no keyword-anchor authority to preserve or lose in migration. New/low-quality domains noted (t.co social shares across 7 targets; a bare IP `101.133.230.96` = likely scraper mirror). Reinforces F-010.

### F-013 — GA4 (90 days): zero tracked business, bot-inflated traffic, real audience is Bangladesh; a 404 page is the #3 most-viewed
GA4 property "Reinforce Lab Limited" (production), 12 Jun–9 Sep 2026, delivered as 7 screenshots + 1 PDF (in [data/gsc-2026-09/ga4/](data/gsc-2026-09/ga4/) — clean CSV exports would still be better for per-URL register work).

- **No measurable conversion.** Total revenue **$0.00**, transactions **0**; Lead-acquisition report shows New / Qualified / Converted leads all **0**. Only **31 "key events"** fire in 90 days — **21 (68%) from Organic Search**, 8 Direct, 2 Referral. So "which pages produce business" (the O-011 question) ≈ **none trackable**; what little intent exists comes through Organic Search.
- **Traffic is bot/low-engagement-inflated.** 751 users / 906 sessions, but by country: US 244 (12s avg, 4 key events), **China 102 (3s, 0)**, **Singapore 83 (1s, 0)** — China+Singapore = 185 users at near-zero engagement, almost certainly bot/spam. The genuinely engaged, converting audience is **Bangladesh: 50 users, 60% engagement, 4m44s, 20 of 31 key events (65%)** — i.e. the team + local leads. The 751 headcount is not 751 prospects.
- **Direct = 61% of sessions** (556/906) — abnormally high; consistent with untagged/bot/brand traffic. Organic Search 30% but carries the engagement (56% rate, 1m07s) and the conversions.
- **A 404 page is the #3 most-viewed page** — "Error 404 Page not found" = 73 views / 70 users (**5.6% of all pageviews**). Real users are hitting dead ends (the six footer 404s + junk), corroborating F-008/F-009 from the user side.
- GSC-linked landing pages in GA4 match GSC Pages.csv (social-media-management guide, campaign-examples, seo-services on top) — cross-validates F-007. New **"AI Assistant" channel** appears (2 users) — GA4 now attributing some visits to AI assistants.

**Production already surfaces the new positioning (O-015).** The property shows **two distinct homepage-style titles**: "Reinforce Lab Limited | Your Digital Growth Partner" (433 views) **and** "Reinforce Lab | AI Growth Systems, AI Search & SEO" (139 views). Jamil confirmed **all of this is `reinforcelab.com` (production) data** — so the "AI Growth Systems" title is production's own, not `.online` leaking in (an earlier contamination hypothesis, now retracted). Open question: is the second title the approved D-010 homepage change (and did the title flip mid-window, hence two rows), or a separate/unlogged production edit? Confirm which page carries it and trace it to an approval — connects to O-006/O-007 (production changing outside the chain). Recorded as O-015.

**Also surfaced (record only — no production change):** malformed production slugs — `/services/content-` (truncated), `/video-marekting/` (typo, has its own `/feed/`), `/services/ppc-management-services` (no trailing slash), `/digital-marketing-competitor/` vs `/…-analysis/` (near-duplicate). Production already uses `/services/` (e.g. `/services/technical-seo-services/`), so the 5 approved new `/services/…` URLs must be checked against existing slugs at migration — no collision seen, but track it.

**Data caveats:** Coverage chart retains only from 2026-06-11 (the Sep–Oct 2025 transition is visible in Performance, not Coverage); the 11 internal-link drilldowns are not labelled by target page in the export.

---

## F-014 — WPCode inventory (production): 2 active sample snippets, none SEO-relevant — closes O-014
**Date:** 10 September 2026 · **Status:** `[VERIFIED — from WPCode Lite export]`

Production runs **WPCode Lite v7.1** with exactly **two snippets, both active** (`auto_insert: 1`), both leftover WPCode **sample** snippets dated 2022-07-20 (export saved at [data/production-config/wpcode-snippets-2026-09-10.json](data/production-config/wpcode-snippets-2026-09-10.json)):

1. **"Display a message after the 1st paragraph of posts"** (text, `after_paragraph`) — injects the literal string *"Thank you for reading this post, don't forget to subscribe!"* after paragraph 1 of **every post**. Harmless but low-value boilerplate on all post content. **Do not carry across at migration.**
2. **"Completely Disable Comments"** (PHP, `everywhere`) — disables comments site-wide (removes comment support from all post types, closes comments/pings, hides existing comments, removes the admin menu). Its one `wp_safe_redirect` targets only the admin `edit-comments.php` screen — **not a front-end/SEO redirect.**

**SEO verdict:** neither snippet touches rewrite rules, redirects, canonical, schema/JSON-LD, `robots`/noindex, or analytics. **WPCode is NOT a source of the `/paged-N/` junk, the indexation loss, or any hidden tracking.** One SEO-relevant negative ruled out.

**Caveat:** this covers **WPCode-managed** code only. Code in the theme `functions.php`, mu-plugins, or other managers is not in this export (no separate "Code Snippets" plugin was present — the menu labelled "Code Snippets" *is* WPCode). Analytics/Search Console are wired via **Google Site Kit** (seen in the admin), not a WPCode snippet — relevant to O-015.

**With F-014, DISCOVER data is complete:** GSC (Performance/Coverage/Links), GA4, and the production code inventory are all in hand. Only **O-015** (confirm the production homepage-title state) remains as a loose end, and it is not migration-blocking.

---

## F-015 — Production already runs 37 Yoast redirects, with multi-hop chains to flatten
**Date:** 10 September 2026 · **Status:** `[VERIFIED — transcribed from Yoast Redirects screenshots]`

Production has an existing redirect map in **Yoast SEO Premium → Redirects**: **37 rules** (36× 301, 1× 410 on an old project PNG). Full transcription: [data/production-config/yoast-redirects-2026-09-10.csv](data/production-config/yoast-redirects-2026-09-10.csv). (Transcribed from 4 screenshots — a Yoast CSV export would be authoritative if we want to be exact.) Confirms **Yoast Premium** is active (Redirects is a paid feature).

**Why it matters:** the migration redirect map is **not starting from zero** — it must incorporate and not conflict with these 37, and Yoast Premium is the mechanism already in place to serve the new map.

**⚠ Redirect chains present (SEO issue to flatten).** Several old URLs 301 to a target that itself 301s onward — Google discourages chains (equity loss, crawl waste):
- `management-team-3` → `management-team-2` → `team-leads` → `/our-team` (**3 hops**)
- `graphics-designing-services` → `/services/graphic-design-services` → `/services/creative/graphic-design-services`
- `services/best-search-engine-optimization-services/link-building-seo-services` → `/services/link-building-seo-services` → `/services/best-affordable-seo-link-building-services`
- `product/search-engine-optimization-services` → `…-starter-monthly` → `…-service-starter-monthly`

When we build the migration map, **flatten every chain** so each old URL points directly to its final destination.

**Also useful — current canonical service/product slugs** (the redirect *targets* reveal what production treats as live): `/services/best-search-engine-optimization-services`, `/services/best-on-page-seo-services`, `/services/off-page-seo-services`, `/services/best-affordable-seo-link-building-services`, `/services/creative/graphic-design-services`, `/services/content-marketing-services`, `/services/email-marketing-services`, `/services/ppc-management-services`, `/services/ecommerce-website-design-service`. Note the existing `/services/` and nested `/services/creative/` paths (cf. F-011) — the 5 approved new `/services/…` slugs (D-003) must be checked against these at migration to avoid collisions/new chains.

---

## D-014 — PRESERVE URL disposition rules APPROVED
**Date:** 10 September 2026 · **Status:** APPROVED — ACTIVE

The disposition framework in [preserve-disposition-rules.md](preserve-disposition-rules.md) is approved and governs how the 765 pending URLs are classified. Nine dispositions (PRESERVE / PRESERVE-URL+REWRITE / 301 / CONSOLIDATE / REBUILD / RETIRE→301 / RETIRE→410 / KEEP-noindex / HOLD), assigned by 10 first-match rules (R1–R10) driven by primary data (F-007→F-015). **Approved parameters:** equity = **≥8 clicks/16mo or indexed-and-ranking**; off-brand top earners **kept + rewritten/consolidated**; retire = **410 junk / 301 real**; money & position-1 pages **mandatory HOLD** for individual sign-off. Classification may now run into a proposed-disposition sheet; **application to any URL/redirect/site still requires per-URL or per-batch approval, executed only at the approved migration cutover.** No bulk ops (F-003); `.online` stays noindex (D-012).

---

## D-014b + F-016 — Full register classified (793 URLs); affiliate pages → HUB-REVIEW
**Date:** 10 September 2026 · **Status:** D-014b APPROVED (affiliate hub) · classification `PROPOSED — awaiting batch review`

**D-014b — affiliate hub.** Jamil directed that the hosting/tool **review (affiliate) pages** be **kept and consolidated under a siloed hub** (new **HUB-REVIEW** disposition), not RETIRE→301. Their value is affiliate commission, invisible to organic-click data. Trade-off flagged: topical dilution / entity inconsistency (F-008) — conditions to keep it SEO-safe recorded in [preserve-disposition-rules.md](preserve-disposition-rules.md) §6 D-e (silo path, consolidate thin ones, `rel="sponsored"`, FTC disclosure, deliberate indexation).

**F-016 — full-register classification.** D-014 applied to all **793 rows** of the URL Decision Register (sheet 3 of `Reinforce_Lab_URL_Decision_Register_v3.xlsx`), using its per-row indexation status, clicks, impressions, position, type, and inlinks. Output: [preserve-disposition-sheet-proposed-2026-09-10.csv](preserve-disposition-sheet-proposed-2026-09-10.csv) (row-level, 793) and the **review artifact** [preserve-disposition-sheet-pagelevel-2026-09-10.csv](preserve-disposition-sheet-pagelevel-2026-09-10.csv) (**631 unique pages**, anchor fragments collapsed). Both carry the register's prior recommendation + approval state alongside the new D-014 disposition + rule fired.

Proposed counts (fragment/anchor rows inflate totals — they collapse to their parent page at execution):

| Disposition | Rows |
|---|---|
| RETIRE-410 (junk/media/404) | 377 |
| HOLD (money/pos-1 + uncertain) | 116 |
| PRESERVE (core/service/product) | 80 |
| HUB-REVIEW (affiliate) | 59 |
| PRESERVE+REBUILD (on-strategy earners) | 51 |
| REBUILD-new (on-strategy, never-crawled) | 40 |
| PRESERVE-URL+REWRITE (off-brand earners) | 32 |
| KEEP-noindex (pagination/transactional) | 20 |
| CONSOLIDATE (thin clusters) | 18 |

**Status:** proposal only. Nothing applied. Next: Jamil reviews per batch; HOLD + money pages decided individually; approved rows → `APPROVED` state + tested redirect map (chains flattened, F-015); migration not scheduled until the map is complete.

---

## D-015 — URL disposition review (batch approvals, per D-014)
**Date:** 12 September 2026 · **Status:** APPROVED — PLANNING (applied at migration cutover, not on production now)

Bucket-by-bucket approval of the page-level sheet ([preserve-disposition-sheet-pagelevel-2026-09-10.csv](preserve-disposition-sheet-pagelevel-2026-09-10.csv), 631 pages), recorded in its `decision` column. Standing QA rule reaffirmed by Jamil: **the new site must ship error-free — no broken internal links, no dead redirects, no 404s** (extends D-012); the new IA links to none of the retired URLs, and every redirect must resolve single-hop.

**✅ RETIRE-410 bucket — approved 12 Sep 2026.** Of 377 pages routed to 410, after review:
- **353 → 410** (225 paged-N/junk, 71 disposable images, 56 author-archive pagination, 1 outdated 2020 pricing PDF).
- **Carve-outs corrected out of 410:**
  - **2 → PRESERVE** — real business docs to migrate: `Reinforce-Lab-Company-Profile.pdf` (525 impressions) and `Certificate-of-Incorporation-Reinforce-Lab-Limited.pdf`.
  - **11 → CONFIG** (no redirect) — 6 sitemap `.xml` (Yoast-generated) + 5 `wp-*` wildcard/system patterns (robots.txt). Not redirect targets.
  - **9 → 301 → /our-team** — base author archives (`/author/<name>/`), catching ~29 clicks; author *pagination* stays 410.
  - **1 → FIX-REDIRECT** — `/ideas-for-personal-branding/` is a live Yoast redirect target that 404s (broken redirect); repoint the inbound redirect to a live page, retire the dead target.
  - **1 → REBUILD-new** — `/generate-leads-for-business/` held as an on-strategy lead-gen rebuild candidate.

**✅ PRESERVE bucket — approved 14 Sep 2026.** Of 78 auto-preserved, after review: **54 confirmed PRESERVE** (homepage, core pages, real service/product/project pages, 2 rescued PDFs). Corrected out: **7 duplicate slugs → 301** (no-trailing-slash twins), **9 `?add-to-cart=` → KEEP-noindex**, **2 empty taxonomies → KEEP-noindex**, **1 malformed → 410**. **AI-service slug reconciliation (D-003 cannibalization resolved):** kept the 4 approved slugs present (`ai-search-optimization`, `generative-engine-optimization`, `seo-ai-search-audit`, `pharmaceutical-seo`); **`ai-first-business-systems` → 301 → new `/services/ai-growth-systems/`** (build as 5th approved URL); 4 redundant variants (`*-services`, `creative/*`) → 301 to their canonical. Net: the 5 approved service URLs survive, no two live URLs compete.

**✅ ALL BUCKETS COMPLETE — 631/631 pages decided (20 Sep 2026).** Every bucket reviewed and approved: PRESERVE+REBUILD (on-strategy earners), REBUILD-new (high-impression pages Google never ranked; 3 corrected out), HUB-REVIEW (Approach A — 20 affiliate reviews kept at slug under a new `/reviews/` hub with rel=sponsored + disclosure; 5 dead consolidated), KEEP-noindex (pagination + transactional), PRESERVE-URL+REWRITE (off-brand earners re-angled; 2 → industry pillars), CONSOLIDATE (thin/dup clusters), HOLD (66 → money pages PRESERVE+REBUILD, legacy categories 301'd to nearest new hub rather than recreated, on-strategy pages rebuilt, thin 0/0 → 410; ~12 junk items cleaned out).

**Final disposition tally (631 pages):** RETIRE-410 369 · 301 47 · PRESERVE 44 · PRESERVE+REBUILD 39 · KEEP-noindex 31 · CONSOLIDATE 30 · REBUILD-new 28 · HUB-REVIEW 20 · CONFIG 12 · PRESERVE-URL+REWRITE 9 · FIX-REDIRECT 1 · DROP 1. Full per-URL detail (disposition + rule + decision) in [preserve-disposition-sheet-pagelevel-2026-09-10.csv](preserve-disposition-sheet-pagelevel-2026-09-10.csv).

**Next after this:** build the tested single-hop redirect map from these dispositions (301/CONSOLIDATE targets flattened, deconflicted against the 37 existing Yoast redirects — F-015), and add the approved-new URLs (D-016) to the register. Nothing executes until the approved migration cutover.

---

## D-016 — "Search Authority OS" initiative + IA decisions
**Date:** 15 September 2026 · **Status:** APPROVED — ACTIVE

Reinforce Lab is productizing an AI content/SEO intelligence system, **Search Authority OS** — a productized **"Operating System" under the locked primary category "AI Growth Systems"** (one of several OS products planned under that umbrella; AI Growth Systems stays the parent brand/category). Strategy source: [reference/search-authority-os-strategy-2026-09-15.md](reference/search-authority-os-strategy-2026-09-15.md).

**The product (summary).** Claude Code (brain/orchestrator) + Neon (memory) + GitHub (versioning) + Langfuse, with a research stack (Jina, Exa, Firecrawl, SEMrush, DataForSEO, SerpApi, social sentiment), an evidence/verification layer, QA gates, GSC/GA4/GTM 7-day reporting, a self-healing loop, and Pharma/Life-Sciences evidence connectors (PubMed, Europe PMC, PubChem, ClinicalTrials.gov, FDA/openFDA, patents). Sold as **3 packages** (Foundation / Growth OS / Enterprise, ~$5k→$35k+ setup, ~$1.5k→$15k/mo) plus **8–9 individual agents**, with the **Diagnostic Engine as Agent #1 / free lead magnet**. Reinforce Lab = R&D lab + agency case study; Accfintax (finance), JA Directives (education), Pharma as verticals. **Build order: site front-end first, then the OS MVP.**

**Decisions locked (15 Sep 2026):**
- **Brand:** governed by **D-013 dark "Systems Grid"** — the strategy doc's light/editorial/serif direction is **rejected/superseded**.
- **Positioning:** Search Authority OS is **an OS product under AI Growth Systems** (not a rename, not a competitor to it).
- **New URLs — `APPROVED — NEW URL`:**
  - `/search-authority-os/` — the OS product page
  - `/packages/` — pricing/packages
  - **Agents hub `/services/agents/`** + 8 agent selling pages beneath it (grouped, Option 1 — decided 15 Sep, avoids collision with the AI service pages): `/services/agents/seo-intelligence/`, `/content-research/`, `/evidence-verification/`, `/aeo-geo-optimization/`, `/social-sentiment/`, `/competitor-intelligence/`, `/content-qa/`, `/search-performance/`
  - **20-post content cluster** — on-strategy blog posts (feed the REBUILD-new / new-content pipeline)
  - `/search-authority-diagnostic/` — **free** automated diagnostic (lead magnet, Agent #1) ✅ decided 15 Sep
- These new URLs must be **added to the URL Decision Register** as approved-new before the IA is locked.

**Funnel decided (O-016 CLOSED, 15 Sep):** keep BOTH the free diagnostic and the paid audit as distinct products — **`/search-authority-diagnostic/` (free, automated, lead capture) → `/services/seo-ai-search-audit/` (paid one-time deep audit) → `/packages/` (monthly OS retainer)**. Increasing commitment at each step; the free diagnostic feeds the paid offers; no cannibalization.

**Packages & store decided (17 Sep):** high-ticket ($5k–$35k) sells consultatively, not via cart. So — **`/packages/` = a pricing/comparison page, CTA → free diagnostic / book a call, NO add-to-cart.** **WooCommerce stays (D-002) only for genuinely self-serve fixed-price items** (e.g. the paid audit as an optional buyable product); it is not used for the OS packages. **Legacy `/product/` tiers (SEO monthly/yearly, web-design — ~0 traffic) → CONSOLIDATE:** 301 the SEO tiers → `/packages/`, the web-design tiers → `/services/wordpress-website-design-service/` (single-hop). This supersedes their earlier PRESERVE in the D-015 review (10 rows updated on the disposition sheet). Store infrastructure kept: `/shop/` PRESERVE, `/cart` `/checkout` `/my-account` KEEP-noindex.

**Still to decide one-by-one:** which of the 20-post cluster map to REBUILD-new vs brand-new (content planning, later).

---

## F-016 — Migration redirect map built & validated
**Date:** 20 September 2026 · **Status:** `[VERIFIED — planning artifact; not applied to production]`

Built from the 631 approved dispositions + the 37 existing Yoast redirects (F-015): [redirect-map-2026-09.csv](redirect-map-2026-09.csv).

- **118 × 301** redirects, **all single-hop, all targets confirmed live** (a surviving PRESERVE/REBUILD/HUB/new URL) — **9 chains flattened** so no redirect points at another redirect; deconflicted against the existing Yoast rules.
- **370 × 410** (Gone) — junk, media, dead 0/0 pages; no redirect, clean removal.
- **0 unresolved / 0 broken targets** — satisfies the "new site ships error-free" rule (D-015): no dead redirects, and the new IA links to none of the retired URLs.

Columns: `old_url, new_url, code, source, status`. **Applies only at the approved migration cutover** (§10). Before cutover, this map is the tested input; the approved-new URLs (D-016) still need building on `.online`.

---

## D-017 — Build kickoff on `.online` (approved-new URLs)
**Date:** 20 September 2026 · **Status:** IN PROGRESS

Confirmed `.online` live and safe (home_url=reinforcelab.online, `blog_public=0` noindex, full locked stack present; was near-greenfield — only `/home/` hero + a draft privacy page). **Step 1 done: 21 pages scaffolded as drafts** with correct hierarchy — `/search-authority-os/`, `/search-authority-diagnostic/`, `/packages/`, `/services/` + 5 approved service pages + `/services/agents/` + 8 agent pages, `/reviews/` + 2 pillars. Idempotent; content to follow.

**UPDATE 27 Sep 2026 — Novamira `.online` reconnected + 2 new service drafts added.** After the CONNECT_TIMEOUT outage, Novamira is stable again (doctor: OAuth fresh, WP 7.1.2, plugin 1.12.4, 112 abilities, mgmt permission intact; the only doctor "fail" is local Windows credential-file hygiene, not the site). Re-verified `blog_public=0` (noindex still ON). Scaffolded the 2 D-019-approved Solutions as drafts under `/services/` (parent page ID 68): **`seo-content-systems` (ID 85)** and **`marketing-automation` (ID 86)**. `/services/` now holds 8 children = 6 Solutions + the `ai-growth-systems` pillar + the `agents` hub. Total scaffolded drafts now **23**. Content still to follow.

**Build order:** Home (below hero) → SAOS flagship (`/search-authority-os/`, `/packages/`, `/search-authority-diagnostic/`) → services + agents → `/reviews/` → REBUILD-new content (28, in F-003-safe batches). Each page to D-013 (Systems Grid) + D-012 (SEO standard), passing `check-design`. Nav menu wired once key pages have content.

---

## D-018 — Design system v2: "Systems Grid" evolved (square-glass) — APPROVED
**Date:** 24 September 2026 · **Status:** APPROVED — ACTIVE · extends D-013

After building the Search Authority OS landing preview and reviewing against reference designs Jamil supplied, the visual system evolved (still dark, still red `#990000`, still Oswald/IBM Plex, still **zero radius** — he explicitly chose square over rounded). New, approved elements:
- **Frosted-glass cards** (blur + `rgba` fills + top highlight) on a soft red-black glow — replaces the flat hairline-grid cards. Soothing, per reference ③.
- **Buttons:** dark **glass with a red glow bleed + a red `+` mark** (ref ④) — Jamil "loves it." Zero-radius (square) confirmed.
- **Visible Systems Grid background** (~10% brighter) with a second larger red grid, **parallax** (drifts on scroll + mouse) and a **cursor-follow red glow** (softened; reduced-motion safe).
- **CTA section:** red **portal/door** motif (ref ②).
- **Footer:** **Aurora** treatment — giant `REINFORCE LAB` wordmark in a red→black gradient over a faint repeating-text texture, no imagery (ref ①).
- **Hero:** three-line headline ("Stop publishing content. / Start building / search authority.") sized so the **entire hero + CTAs + engine animation fit one laptop/desktop screen**.

**Preview artifact (look-and-feel, not live):** the Search Authority OS landing page. Long-form, sales-style, ICP pain-points, multiple CTAs, honest placeholders (no invented metrics).

**Still to redesign (Jamil flagged):** the **header and footer** get reworked before pages are mass-produced (they are global chrome). Build blocker: **Novamira `.online` connection is down** (CONNECT_TIMEOUT) — must be reconnected before translating designs to Beaver Builder.

---

## D-019 — Information architecture hierarchy (confirmed)
**Date:** 24 September 2026 · **Status:** APPROVED — ACTIVE

**AI Growth Systems** is the brand/category umbrella. **Search Authority OS** is the flagship **product ("an OS") beneath it** — one of potentially several OS products under the umbrella.

```
AI Growth Systems  (umbrella / positioning)
├─ Search Authority OS        /search-authority-os/      (flagship product)
│    ├─ Diagnostic (free)     /search-authority-diagnostic/
│    ├─ Packages (buy)        /packages/
│    └─ Agents (OS modules)   /services/agents/…  (8)
├─ Solutions / Services       /services/…
│    (AI Search Optimization · GEO · SEO & AI Search Audit · Pharmaceutical SEO ·
│     Automated SEO Content Systems · Marketing Automation)
└─ (future OS products under the same umbrella)
```

- **`/services/ai-growth-systems/`** = the umbrella **pillar/overview** page ("what AI Growth Systems is") → links down to `/search-authority-os/` and the individual services. Not a peer service.
- **`/search-authority-os/`** = the flagship **product** page beneath the pillar; sold via Packages, entered via the Diagnostic, built from the 8 Agents.

**Service set — UPDATE 27 Sep 2026:** Two new Solutions **`APPROVED — NEW URL`** by Jamil: **`/services/seo-content-systems/`** (slug shortened from the proposed `automated-seo-content-systems`) and **`/services/marketing-automation/`**. Added to the approved-new register. The 6 Solutions are now locked: AI Search Optimization · GEO · SEO & AI Search Audit · Pharmaceutical SEO · **SEO Content Systems** · **Marketing Automation**.

**Still open (service set):** decide keep-vs-consolidate for the ~19 legacy production `/services/*` pages (recommendation: consolidate into the 6 Solutions above, keep only actively-sold legacy services).

---

## D-076 · Type-specific sections built for all 11 post types (plus Case Study rule change)
**Date:** 3 October 2026 · **Status:** DONE (Jamil: "Go ahead"; Case Study "should it wait for a named client?": "No"; Product & Service subtypes "okay").

**Case Study rule (amends D-074):** a case study no longer needs a *named* client. The client may be anonymised ("A UK pharmaceutical manufacturer"), but:
- **the client must approve the case study**;
- **every result must be real and measured** (CLAUDE.md: never invent client results).

Enforced in code: a Case Study saved as Published without the "Client approved" box ticked is put back to Draft.

**Product & Service subtype label:** Jamil approved "Deep dive", but "deep dive" is on the banned AI-word list (D-072). The visible label is **"How it works"** (internal key `deepdive`), pending Jamil's choice.

**File:** `wp/novamira-sandbox/reinforce-post-types.php`, live md5 = repo `62c81dff…` (guarded create). It plugs into the base template's hooks (D-075) and adds an ACF local group whose fields show only for the selected type. Simple one-per-line inputs ("A | B") keep editing quick.

| Type | Before the article | After the article | Extra schema |
|---|---|---|---|
| Guide | Start here paths (who it is for → section or URL) | Glossary; "Go deeper" supporting articles | — |
| How-To | Before you start (time, level, what you need); Steps at a glance (anchored `#step-n`) | Common mistakes; Troubleshooting | HowTo (steps, totalTime, tools) |
| Explainer | Definition box (term + quotable definition) | Related terms | DefinedTerm; Article `about` the term |
| Best / List | At-a-glance table (rank, name, best for, verdict); How we chose | The list (ranked items, anchored `#item-n`) | ItemList (ascending) |
| Review | Affiliate disclosure (if ticked); verdict box with score / 10, pros and cons | Pricing with the "checked on" date; Who it is for; Alternatives | Review of a third-party Product (rating /10, positive/negative notes). The field says never our own services |
| Comparison | Side-by-side table (2 to 4 options) | Winner by use case; Verdict | ItemList of options |
| Industry | Industry box (summary + link to `/industries/x/`) | Sector rules to know; Services for that industry (from `rl_ind_data`) | Article `about` the industry |
| Updates | The update in brief (what changed / what it means / what to do) + official source | Update log (dated) | — |
| Case Study | Client and industry, challenge, measured results tiles; Our approach | Approved client quote | — (no Review/rating) |
| Research | Key findings; Method and sample, dataset download | "Cite this research" box | Article + Report; Dataset when a dataset URL is set |
| Product & Service | "Reinforce Lab makes this" disclosure; product box (subtype, service, status label, links to the service page and diagnostic) | What it does not do; Changelog | Article `about` the Service (`…/#service`); never Review or ratings |

Opinion and Checklist use the base only, as agreed (added later).

**Verified (in memory, no posts written, F-003):**
- All 11 types rendered through the live template with sample fields: no template errors (the only warnings came from the in-memory query object).
- The expected schema nodes appear for each type.
- **Every type is exactly 390 px wide on phones.** Desktop screenshots checked for Review, Product & Service, Best/List and Case Study.
- `copy-check.py`: 0 issues.

**At the first real post of each type:** validate the schema in Google's Rich Results Test and check the live layout.

---

## D-075 · Single post template: shared long-form base built on `.online`
**Date:** 3 October 2026 · **Status:** DONE (Jamil: "go ahead with the long-form base"). Type-specific sections come next, one type at a time.

**File:** `wp/novamira-sandbox/reinforce-post.php`, live md5 = repo `24b637e3…`. It is **the one template for every post** (D-074) and renders via `template_redirect` like the archive template (D-071).
- There is **no Beaver Themer singular layout**, so no post can be targeted twice (the production overlap trigger in F-001).
- The create call aborted if a singular layout existed, if the file existed, or if the site was not noindex.

**Editor fields** (ACF local group, defined in code, in the post editor sidebar):
- Article type (the 13 types from D-074; default Guide);
- Status label (shown only for Product & Service: Available / Early access / In development);
- Short answer; Key takeaways (one per line);
- Last substantive update (date: set only for real content changes, F-003);
- FAQs ("Question? | Answer" per line); Sources ("Title | URL" per line).

**What every post renders:**
- Breadcrumb Home › Blog › Category › Title.
- Type tag (plus the status tag for Product & Service) and a category tag; H1 = the post title.
- Byline linking Jamil to `/about-us/#founder`; published date; "Updated" only when the update field is later than publication; reading time (230 wpm).
- Featured image (eager, high priority).
- Short-answer box, then Key takeaways, then the article body. Ids are added to every H2/H3; wide tables scroll inside the article on phones (kit `.tscroll`).
- **Sticky contents list** built from the H2s (sidebar on desktop, collapsible "Contents" on phones).
- FAQs, then a numbered Sources list (external, `noopener`).
- **Author box:** Jamil, Founder and CEO, with the confirmed bio (pharmacist, SEO and AI search consultant, Semrush Ambassador), About and LinkedIn links. The WP author bio is empty, so it uses the D-068 facts.
- **Related articles:** 3 from the same category; a secondary query with no pagination, so the F-001 archive rule is unaffected.
- Diagnostic CTA.
- Hooks `rl_post_type_sections_before/after` are where each type's own sections will plug in.

**Schema:**
- Yoast's Article becomes `['Article','BlogPosting']`, with real `datePublished`; `dateModified` = the update field, or publication when unset (never the WP modified time, F-003). It adds `genre` (type), `abstract` (short answer) and `citation` (sources).
- Jamil's Yoast `Person` gains jobTitle, description, knowsAbout, LinkedIn `sameAs`, worksFor and `url` → About.
- `FAQPage` when FAQs exist.

**Entity fix:** the About page's Person `@id` now equals Yoast's own `@id` for Jamil (`…/#/schema/person/ecf64c…`), so the About page and every post describe one person. `reinforce-about.php`: backup `.bak-20261003-085121`, live md5 = repo `d85bd87b…`.

**Verified (no post written to the database, per F-003):** a sample How-To article was rendered **in memory** through the live template. Yoast indexable saving was switched off for that run.
- Desktop and 390 px screenshots checked: 1 H1, 5-item contents list, answer, takeaways, table, FAQ, sources, author box, CTA.
- At 390 px the page is exactly 390 wide; the first render overflowed because of the kit's 760 px table minimum, which was fixed with the `.tscroll` wrap.
- The schema output was checked as described above. `copy-check.py`: 0 issues.

**At the first real post:** recheck the template live (schema in Rich Results Test, robots, `sw390`), and add a style-fingerprint entry once a post URL exists.

---

## D-074 · Blog post types: one single-post template, 11 types (plus 2 later)
**Date:** 3 October 2026 · **Status:** APPROVED (Jamil: "yes to all"). Not built yet; the shared long-form base is next.

**Context (Jamil):** "we write long SEO posts not generic short bullshits... majority of our articles will be long", with a separate format per type.

**Build rule:** **one** single-post template, not one Themer layout per type. Each post has an "Article type" field, and the template adds that type's sections.
- **Why:** on production, two singular Themer layouts overlapped on one post (the F-001 overlap trigger), and separate layouts would repeat that.
- One template also means a design change happens once.

**Shared long-form base (every type):**
- answer-first opening plus key takeaways;
- sticky table of contents; reading time;
- author box (Jamil Ahmed, credentials, LinkedIn);
- real published and "last updated" dates (F-003: never bulk redated);
- sources list; FAQs; related posts; CTA;
- `BlogPosting` schema with author `Person` (D-012 §3);
- must pass `copy-check.py` (D-072).

**Types:**
| # | Type | Sections only this type gets | Extra schema |
|---|---|---|---|
| 1 | Guide (pillar) | chapters, "start here" paths, glossary, links to supporting posts | — |
| 2 | How-To | before-you-start box (tools, time, level), numbered steps with screenshots, mistakes, troubleshooting | HowTo markup allowed; no rich result expected (Google retired How-to rich results in 2023) |
| 3 | Explainer ("What is…") | quotable definition box, how it works, examples, related terms | — |
| 4 | Best / List | summary table first, "how we chose", item cards, best by use case | ItemList |
| 5 | Review | verdict box and score, pros and cons, dated pricing, who it is for, alternatives, affiliate disclosure | Review (third-party products only) |
| 6 | Comparison ("X vs Y") | side-by-side table, winner by use case, verdict | ItemList |
| 7 | Industry | industry box linking `/industries/x/`, sector rules, sector services | — |
| 8 | Updates | prominent date, what changed / what it means / what to do, official source, update log | — |
| 9 | Case Study | challenge, approach, measured results, client quote. **Published only with a named, consenting client and real data** | — |
| 10 | Research / Data | method, charts, dataset, "cite this" box | Dataset where it fits |
| 11 | Product & Service | subtypes: deep dive, use case / playbook, launch / changelog. **Status label required** (Available / Early access / In development) on agent and Search Authority OS posts until O-022 is settled; "we make this" disclosure; "what it doesn't do"; product box linking the service page and diagnostic; must target a different query than its service page (no cannibalisation, as D-035) | `about` → the service node; **never** Review or star ratings on our own services; no Product/Offer markup in posts |
| later | Opinion; Checklist / Template | founder byline up front / printable checklist and download | — |

**Not allowed:** "Best agencies" lists that rank Reinforce Lab first.

---

## D-073 · Copy answers (closes O-025 items 1 to 3)
**Date:** 3 October 2026 · **Status:** APPROVED and APPLIED on `.online` (Jamil: "1 to 30, remove compound, replace example")

1. **Ranges use "to", never an en dash:** "20 to 30 assets", "$1,500 to $2,500 / month", "$20k to $35k+", "12 to 14 form elements", "P1 to P3", "August to September 2024", "January to February 2026". The Diagnostic form's volume options are now "1 to 10", "11 to 30", "31 to 50" and "50+" (the handler validates against the same list).
   - The open-FAQ icon was an en dash and is now a true minus sign (`\2212`), in the kit and on 4 page styles.
   - The quoted Search Console status uses a plain hyphen: "Discovered - currently not indexed".
   - **0 en dashes remain.**
2. **"Compound/compounding" removed (9 places):**
   - SEO H1 → "SEO services / that build / lasting authority.";
   - header → "one growth engine.";
   - Packages: "a system that builds search authority month after month", "search authority builds over months", H2 "From diagnostic to lasting authority.";
   - Services: "one system where each part strengthens the others";
   - Local: "the work that builds on them";
   - Home: "growth systems that keep improving";
   - SEO FAQ: "build over time";
   - Agents tag "Compounding" → "Fully connected".
   - Added to the banned list.
3. **GEO "Before" example replaced:** "We help brands grow online with smart, results-driven strategies tailored to every business." It is still vague, but contains no banned words. The checker exception was removed.

**"Engine" as a metaphor: KEEP** (Jamil, 3 Oct: "Keep it"). Uses such as "intelligence engine" and "opportunity engine" stay, alongside the locked "growth engine".
**"Not just": REMOVED** (Jamil, 3 Oct: "remove not just"). 12 uses rewritten in 10 files, e.g. "cited as well as ranked", "a researched brief with sources instead of a bare keyword", "Every map, Google included". The phrase was added to the banned list in `copy-check.py`. Deployed guarded (backups `.bak-20261003-084809`), live md5 = repo, live pages checked with 0 left. **O-025 is closed.**

**Deploy:** 16 files, guarded (backups `.bak-20261003-083522`), live md5 = repo. **Verified:** 45 pages crawled, with 0 em dashes, 0 en dashes, 0 "compound", 0 emoji and 0 PHP errors; `copy-check.py` reports 0 issues (it now also flags en dashes and "compound").

---

## D-072 · Copy rules: no em dashes, no emojis, no AI words, anywhere on the website
**Date:** 1 October 2026 · **Status:** APPROVED and APPLIED on `.online` (Jamil: "make sure we use no em dashes throughout reinforcelab.online website... no em dashes at all anywhere in the website content copy blog or whatsoever. Also, Never use any emojis anywhere. NO AI Slope and AI Words 100% avoid. If there is any confusion always ask.")

**Rule (permanent, also in CLAUDE.md and build-standard gate 10):** every word on the site, including pages, blog posts, titles, meta descriptions, schema, alt text, menus and the emails the site sends:
- no em dashes;
- no emojis or emoji-like symbols;
- no AI-style words.

Ask Jamil when something is unclear. Check: `python3 claude/tools/copy-check.py` must report 0 issues.

**Applied (1 Oct):**
- **Em dashes, files:** 752 in visible copy across 32 sandbox files were replaced one by one, judged in context (comma, colon, semicolon, full stop or parentheses). Examples: "Two offices (Dhaka and Katy, Texas) and clients around the world", "Where AI should (and shouldn't) go". The 84 em dashes in code comments became hyphens.
  - Quote attributions ("... — Google Search Central") became a line break.
  - Package tier labels became "01 · Foundation".
  - The mega-menu heading became "X: Who We Serve"; the mobile sub-label became "Parent · Child".
  - Form email subjects became "Contact message: …" and "Diagnostic request: …".
  - Admin entry titles became "Company | Name"; empty email fields became "not given".
- **Em dashes, database:** 8 Yoast meta descriptions (pages 68, 72, 74, 99, 100, 101, 104, 189). Backup option `rl_metadesc_backup_20261001`. No other titles, content, menus or terms contained em dashes. The Yoast title separator is a plain hyphen.
- **Emoji / symbols:** there were no true emojis. The ✓, ✕ and "not included" marks (Packages comparison table, SAOS and Home problem lists) and the ↳ bullet (Packages cards) were replaced with drawn SVG/CSS icons, so no device can render them as emoji.
- **AI words removed:**
  - "genuinely" (7), "quietly" (2);
  - Home blog teasers rewritten (removed "more than ever", "table stakes", "operationalize").
- **Deploy:** one guarded call for all 32 files (md5 check against the repo, parse check, backups `.bak-20261001-160705`); live md5 = repo for all.
- **Verified:**
  - all 44 published pages plus a category archive crawled: **0 em dashes, 0 emoji, 0 PHP errors** in the rendered HTML;
  - icons checked by screenshot;
  - `copy-check.py` reports 0 issues.

**Open (O-025), asked 1 Oct:**
1. **En dashes in number ranges** ("20–30 assets", "$1,500–$2,500"): keep them, or switch to "to" / a hyphen?
2. **Borderline words** still on the site:
   - "compound" / "compounding" (including the SEO H1 "SEO services that compound into authority" and the header's "one compounding growth engine");
   - "engine" used as a metaphor ("intelligence engine", "opportunity engine") outside the locked "growth engine";
   - "not just".
3. **GEO page:** the deliberate bad-copy example ("Our cutting-edge approach leverages synergies...") in the "Before · hard to cite" box. Keep it as an illustration, or rewrite?

---

## D-071 — Blog archive template built on `.online` (F-001 by design); `/blog/` page 220 set as the posts page
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "yes, go ahead with the Blog archive template")

**State before (VERIFIED, read-only):**
- 0 posts; only the default "Uncategorized" category; no `/blog/` page; `page_for_posts` = 0.
- One Themer layout exists: 44 "Site Header", a draft, with no archive layouts.
- Permalinks are `/%postname%/`; category base is the default `/category/`.
- 12 Beaver Builder `…/paged-N/M/` → `flpaged` rewrite rules are registered (as F-001 found).

**Decision (implementation):** the archive template is **code, not a Beaver Themer layout**. This is the same approach as every other page on `.online` (sandbox file + kit). It meets the F-001 rule in its strictest form:
- there is **one loop, and it is the main query**;
- pagination is core `the_posts_pagination()` → `/blog/page/N/`, `/category/x/page/N/`;
- there are **zero Themer archive layouts**, so no location can be targeted twice and no Posts module exists to emit `/paged-N/`.

The deploy aborts if a Themer archive layout exists. **Rule going forward: do not create a Beaver Themer archive layout.** This file is the single archive template.

**File:** `wp/novamira-sandbox/reinforce-blog.php`, live md5 = repo `008a65a9…`. It renders via `template_redirect` (`get_header()` … `get_footer()`) for `is_home`, category, tag, author and date archives.
- **Each archive type gets its own H1 and intro:**
  - category and tag archives use the term description;
  - author archives use the user bio;
  - date archives use the date label;
  - there is never a shared text block (the production failure: one layout with 670 identical words on every archive, F-001 evidence).
- **Card per post:**
  - featured image, if set;
  - the real published date (F-003);
  - primary category;
  - H2 title, a 28-word excerpt, and "Read article".
- There is a category filter bar (non-empty categories only; Uncategorized hidden). With no posts, an empty state with diagnostic and services CTAs shows.
- **No hero animation** (Blog is excluded, D-039).

**Protections:**
1. Any request carrying `flpaged` (e.g. `/blog/paged-2/2/`) → **410**, matching the disposition sheet's approved RETIRE-410 for all `/paged-N/` URLs.
2. **Robots:** page 2+ of any archive → `noindex, follow` (disposition sheet: `/blog/page/N/` = APPROVED KEEP-noindex). **Any empty archive** → `noindex, follow` (thin-page guard; RECOMMENDATION applied on `.online`).
3. **Schema:** Yoast already emits `CollectionPage` + `BreadcrumbList` for `/blog/`. The template adds an `ItemList` of the articles on the page when posts exist.

**Settings changed on `.online`:**
- new page 220 "Blog", slug `blog` (production `/blog/` is APPROVED — PRESERVE);
- `page_for_posts` 0 → 220 (backup option `rl_reading_backup_20260930`);
- Yoast title "Blog | SEO, AI Search and Growth Systems | Reinforce Lab" plus a meta description;
- Primary menu "Blog" item (150): `#` → page 220 (backup `rl_menu_backup_20260930_blog`);
- footer "Blog" now uses `rl_url_by_path('blog')` (`reinforce-header.php` backup `.bak-20260930-120430`, live md5 = repo `ace683e8…`).

**Verified:**
- `/blog/`: 200, 1 H1 (3 lines), empty state, kit + page CSS, no PHP errors, 0 `href="#"` in content; CollectionPage schema.
- Menu and footer links resolve.
- `/blog/paged-2/2/` and `/category/uncategorized/paged-2/2/` return **410**; `/blog/page/2/` returns 404 (no posts yet).
- `get_pagenum_link()` returns `/blog/page/2/`, `/blog/page/3/` and `/category/news/page/2/`, with no `paged-`.
- 390 px with no overflow on `/blog/` and a category archive; screenshot checked.

**Not verifiable yet (launch QA gate):**
- **Post cards and pagination with real posts:** checking them would mean seeding test posts, which Jamil declined on 24 Aug (F-003).
- **Archive robots rules:** the `.online` sitewide noindex (`blog_public` = 0) overrides them in output. Recheck both right after the first posts are migrated and again at launch.

**Open for Jamil:**
- **O-023 — category URL base.** Production category archives live at the root (e.g. `/business/`, `/digital-marketing/`), while `.online` uses the default `/category/x/`. The 20 HUB-REVIEW category rows need a decision before any category is created: keep root URLs (Yoast "strip category base") or map to `/category/x/`.
- **O-024 — tag, date and author archive policy.** Author archives are mapped 301 → `/our-team/` on production. The crawl plan recommends one author page for Jamil. Tags and dates have no decision (Yoast currently: date archives noindex; tags index).
- **The single post template** (`BlogPosting` + author `Person` + real dates) is not built yet. It is needed before the first post migrates.

---

## D-070 — Contact page built on `.online` (page 219, `/contact-us/`, published) with a working form
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "go ahead with Contact")

- **URL:** `/contact-us/`, the production URL, which is **APPROVED — PRESERVE, rebuild to D-012 standard** in the disposition sheet. The same slug means no redirect is needed.
- **Created:** in one guarded call. It aborted if the file existed, if `blog_public` ≠ 0, if a page existed at `contact-us` or `contact`, or if the `rl_diag_request` post type was missing. Title "Contact", content `[reinforce_contact]`.
- **Yoast:** title "Contact Reinforce Lab | Dhaka & Katy, Texas"; meta "Contact Reinforce Lab: email hello@reinforcelab.com, call our Dhaka or Katy, Texas office, or send a message about SEO, AI search and AI Growth Systems."
- **File:** `wp/novamira-sandbox/reinforce-contact.php`, live md5 = repo `9d05ea5b…`. Uses the shared kit. **No hero animation** (Contact is excluded, D-039).
- **Sections:**
  - crumbs; 3-line H1 ("Contact / Reinforce Lab. / Let's talk growth."); answer-first lede;
  - direct email and both phones; the form (hero right);
  - offices (2); what happens next (3 steps); 4 FAQs; CTA to the diagnostic.
  - **No response-time promise:** none has been supplied, so the page says only "we reply by email".
  - No industry or service grids: this is a utility page, and the footer already links both.
- **Facts:** the offices, phones and email are identical to the approved footer and the production `/contact-us/` page (read-only, 30 Sep). No new facts.
- **Form (no new plugin):** it reuses the Diagnostic pipeline (D-034):
  - `admin-post.php` action `rl_contact_msg`;
  - honeypot, a <3 s bot check, 5 per hour per IP;
  - fields: name*, email*, company, website, topic (5 fixed choices), message* (max 3,000 characters);
  - stored as a private `rl_diag_request` entry with `request_type` "Contact message" and title "[Contact] …";
  - emails hello@reinforcelab.com with Reply-To set to the sender;
  - forwards `type: contact_message` JSON to `rl_diag_webhook_url` when that is set (currently empty = off);
  - the consent line links the privacy policy (page 3, **still a draft**: it must be published before real data is collected, same as D-034).
- **Schema:**
  - WebPage becomes `['WebPage','ContactPage']`;
  - on this page the Organization gains `email`, 2 `contactPoint` entries (BD, US) and 2 `location` Places with PostalAddress;
  - `FAQPage` (4).
- **Nav:** the Primary menu "Contact" item (152) changed from custom `#` to page 219 (backup option `rl_menu_backup_20260930_contact`). The footer "Contact Us" now uses `rl_url_by_path('contact-us')` (`reinforce-header.php` backup `.bak-20260930-113334`, live md5 = repo `c96e34ee…`).
- **Verified:**
  - 1 H1, 4 H2, kit loaded; noindex; no PHP errors; 0 `href="#"` in content;
  - schema as above; menu and footer links resolve;
  - form tests:
    - a missing message redirects to `?sent=invalid` and shows the alert;
    - the honeypot redirects to `?sent=ok` and stores nothing (0 contact entries);
    - the success state renders.
  - **A full end-to-end submission (stored entry + email) was not run**, to avoid sending a test email to the company inbox. Jamil can send one test message.
  - 390 px with no overflow; desktop and mobile screenshots checked; the steps grid was set to 3 columns on desktop after the screenshot review.
- Style fingerprint entry `contact` added.

---

## D-069 — Founding year confirmed: 2020
**Date:** 30 September 2026 · **Status:** APPROVED (Jamil: "yes, 2020 is correct")

Reinforce Lab began in Bangladesh in 2020. The About page keeps the year. Organization schema on About now carries `foundingDate: 2020` and `foundingLocation` Bangladesh (`reinforce-about.php` guarded update, backup `.bak-20260930-113334`, live md5 = repo `fb9beb8d…`).

---

## D-068 — About page built on `.online` (page 218, `/about-us/`, published)
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "plain slugs, then go ahead with About")

- **URL:** `/about-us/`, the production URL, which is **APPROVED — PRESERVE, rebuild to D-012 standard** in the disposition sheet. The same slug on `.online` means no redirect is needed at migration.
- **Created:** a new page in one guarded call. It aborted if the file existed, if `blog_public` ≠ 0, or if a page already existed at `about-us` or `about`. Title "About", content `[reinforce_about]`.
- **Yoast:** title "About Reinforce Lab | AI Growth Systems Company"; meta "Reinforce Lab builds AI Growth Systems that connect your website, content and search visibility. Founded by pharmacist and Semrush Ambassador Jamil Ahmed."
- **File:** `wp/novamira-sandbox/reinforce-about.php`, live md5 = repo `c15a4bb4…`. Uses the shared kit (D-044). **No hero animation:** About is excluded by D-039. The hero's right-hand side is a static "At a glance" panel instead.
- **Sections:**
  - crumbs Home › About; 3-line H1; answer-first lede;
  - What is an AI Growth System? (the 3 outcomes of the locked core message);
  - Who founded Reinforce Lab? (founder card + LinkedIn);
  - How does Reinforce Lab work? (the locked 9-stage methodology);
  - What do we stand for? (4 working principles);
  - 6 services; 8 industry cards (2 points each, from `rl_ind_data()`);
  - offices; straight answer (why there are no logos or results); 6 FAQs; CTA.
- **Facts used, and where they come from:**
  - positioning and core message: D-008, locked;
  - Jamil is Founder and CEO, a pharmacist, an SEO & AI search consultant and a Semrush Ambassador; LinkedIn `ahmedjamil16`; quote from the locked LinkedIn headline (D-008);
  - offices in Dhaka and Katy TX, and clients worldwide worked with remotely: confirmed by Jamil 28 Sep; addresses and phones from the approved footer (D-011/D-021);
  - **"began in Bangladesh in 2020":** from the current production About page (read-only). **Confirmed by Jamil on 30 Sep (D-069)**; `foundingDate` added to schema.
  - The brand is "Reinforce Lab" throughout. The footer's "Ltd"/"Inc" entity names are not repeated on the page. No team size, clients, results or awards (none supplied).
- **Schema (D-012 §3):**
  - Yoast's WebPage node becomes `['WebPage','AboutPage']`, with `about`/`mainEntity` pointing to the Organization;
  - new `Person` Jamil Ahmed (jobTitle, worksFor, description, knowsAbout, sameAs LinkedIn);
  - the Organization node gets `founder` → Person;
  - `FAQPage` (6).
- **Nav:** the Primary menu "About" item (151) changed from custom `#` to page 218 (backup option `rl_menu_backup_20260930_about`). The footer "About Us" now uses `rl_url_by_path('about-us')` (`reinforce-header.php` guarded update, backup `.bak-20260930-112213`, live md5 = repo `69ee5b85…`).
- **Verified:**
  - 1 H1, 10 H2, 8 industry cards, `rl-kit-css`;
  - noindex, no PHP errors, 0 `href="#"` in page content;
  - schema graph as above; menu and footer links resolve;
  - 390 px with no overflow; desktop full-page and mobile screenshots checked.
- Style fingerprint entry `about` added.

---

## D-067 — Industry slugs are plain
**Date:** 30 September 2026 · **Status:** APPROVED (Jamil: "plain slugs")

Settles the D-022 open question: `/industries/{pharmaceutical, healthcare, b2b-saas, ecommerce, manufacturing, technology, professional-services, education}/`, as built in D-066. The keywords go in the title, H1 and content, not the slug. No production URL is affected (these are new URLs).

---

## D-066 — Industries hub + 8 industry pages built on `.online` (pages 87, 75, 90–96, published)
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "First Agents … Then Industries Hub and its pages")

- **URLs (D-022 axis, plain slugs as drafted):** `/industries/` and `/industries/{pharmaceutical, healthcare, b2b-saas, ecommerce, manufacturing, technology, professional-services, education}/`. Slug style settled as plain by D-067.
- **Deploy:** one guarded call. It aborted if the file existed, if `blog_public` ≠ 0, if the hub was not an empty draft at root with slug `industries`, or if any of the 8 pages was not an empty draft under 87 with its slug. Then: file written → opcache invalidated → 9 pages published → Yoast title and meta set.
- **File:** `wp/novamira-sandbox/reinforce-industries.php`, live md5 = repo `fc10f8ab…`. It is one file: single source `rl_ind_data()`, shortcodes `[reinforce_industries]` (hub) and `[reinforce_industry]` (pages). `rl_ind_current()` only matches a child of the root `industries` page whose slug is in the data. Uses the shared kit (D-044).
- **Hub:**
  - hero "Eight industries · one system" animation (8 sectors feed the AI Growth System core, lit in turn, 10 s loop);
  - 8 industry cards;
  - "Why does industry matter" (3 sourced points);
  - how the system adapts (4 steps);
  - 4 FAQs; CTA.
  - Schema: ItemList (8) + FAQPage + breadcrumb.
  - Yoast: "Industries | AI Growth Systems by Sector | Reinforce Lab".
- **Each industry page:**
  - 3-line H1; answer-first lede;
  - hero animation (sector inputs → AI Growth System with its guardrail → growth line, 10 s loop, soft reset);
  - the challenge (3); the evidence (2 sourced facts);
  - 6 fitting services; 2 agents + Search Authority OS;
  - a straight answer; 4 FAQs; CTA.
  - Schema: Service ("AI Growth Systems for {sector}", BusinessAudience) + FAQPage + breadcrumb Home › Industries › {sector}.
- **Sources:** `claude/research/industries-research-2026-09-30.md`. There are no client, result or sector-experience claims.
- **Verified (all 9):**
  - 1 H1; H2s: hub 5, pages 7; hub 8 industry cards;
  - schema types present; noindex; no PHP errors; `rl-kit-css` loaded;
  - 0 `href="#"` inside page content. The 41 in the header are the site-wide mega-menu column headers and unbuilt items, the same count on `/services/`;
  - 390 px with no overflow on all 9 (2 after a proxy retry);
  - full-page screenshots checked (hub, pharmaceutical, manufacturing).
- **F-021 effect:** the Industries menu and every service page's industry cards now resolve to published pages. The remaining draft link in the menu is `?page_id=71` (AI Growth Systems overview, built last per plan).
- Style fingerprint entries added: `ag`, `indhub`, `ind`.

---

## D-065 — The 8 agent pages built on `.online` (pages 77–84, published) from one shared template
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "First Agents … Then Industries Hub and its pages")

- **URLs:** `/services/agents/{seo-intelligence, content-research, evidence-verification, aeo-geo-optimization, social-sentiment, competitor-intelligence, content-qa, search-performance}/` (D-016 approved-new).
- **Pages 77–84:** draft → publish in one guarded call. Every page had to be an empty draft under hub 76 with the expected slug, and the call aborts entirely if any fails.
- **Yoast:** each page's title is "{Name} Agent | Search Authority OS | Reinforce Lab" (A-07 "Content QA Auditor") with its own meta.
- **Post titles aligned:** "AEO / GEO Optimization Agent" and "Content QA Auditor".
- **File:** `wp/novamira-sandbox/reinforce-agent-pages.php`, live md5 = repo `31e8fc7f…`. It is **one template** with per-agent data in `rl_ag_data()`, shortcode `[reinforce_agent]`, and `rl_ag_current()` resolving the agent from the slug plus the parent `agents`. Editing an agent means editing one array entry.
- **Content source:** the strategy doc ("8 Agent Selling Pages … each page should sell one specific business outcome, not technology") and the hub's existing agent definitions (outcomes, capabilities, best-for). No results, prices, clients or tool brand-claims beyond the hub's own (PubMed / ClinicalTrials.gov; ChatGPT, Perplexity, Gemini, AI Overviews).
- **Honesty guard (see O-022):** every page states that a person reviews the output before it is delivered, and step 05 of the process is "Human review". No "fully automated", "24/7" or result claims.
- **Hero animation "Agent loop"** (one family, labels per agent):
  - The agent's 3 inputs feed the agent box (id + name); its 3 steps light in turn.
  - Results pass a "Human review" diamond, then 3 outputs are delivered.
  - Caption "Search Authority OS · Stage: …"; input · analyse · review · deliver light in turn. 10 s loop, soft fade, reset.
- **Sections per page:**
  - answer-first lede;
  - the problem (3); how it works (4 steps + human review);
  - deliverables (6);
  - where it fits in Search Authority OS (stage plus 2 neighbour agents linked plus SAOS);
  - straight answer (the agent's limits);
  - 8 industry cards (2 points each, D-047);
  - 4 FAQs; final CTA (diagnostic + packages).
- **Schema:** `Service` (isRelatedTo Search Authority OS) + `FAQPage`; breadcrumb Home › Services › Agents › {Agent}.
- **Hub alignment:** `reinforce-agents.php` A-01 renamed "Search Intelligence" → "SEO Intelligence" to match the menu, strategy doc and page (backup `.bak-20260930-091412`, live md5 `d7658cbe…`).
- **Verified (all 8):** 1 H1 (three lines), 8 H2, 8 industry cards, Service + FAQPage (4), breadcrumb, no PHP errors, noindex, no `href="#"`; 390 px with no overflow (4 sampled, 1 after proxy retry); screenshots checked. The agent menu items now resolve to published pages, clearing 8 of the F-021 draft links.

---

## O-022 — The agent pages sell agents whose software is not recorded as built — confirm before launch
**Date:** 30 September 2026 · **Status:** OPEN (content on `.online` only)

**Finding (VERIFIED from the record):**
- The 28 Sep note (Diagnostic section) says the Search Authority OS software (agents, Neon, research stack) "is not recorded as built", and "copy must not describe an automated system that doesn't exist yet".
- The D-017 order is "site front-end first, then the OS MVP".
- The strategy doc's MVP plan starts with 5 core agents for Reinforce Lab's own content, with commercial packaging only after 30–60 days of measurement.

**What the pages do now:** they describe each agent's outcome and deliverables, state that a person reviews every output, and make no claims of full automation, results or clients. The hub (built earlier) and these pages still present the agents as **available to buy**.

**Options before migration (RECOMMENDATION = A until the MVP is running):**
- **A.** Keep the pages. The work is delivered as a service by the Reinforce Lab team with AI assistance while the software is built. Jamil confirms this is true today.
- **B.** Add an "Early access" label and a waitlist CTA on each agent page (one line in the template).
- **C.** Keep the pages unpublished until the matching agent exists.

---

## D-064 — Website Maintenance page built on `.online` (page 198, published) — Solutions menu complete
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "yes, go ahead with Website Maintenance")

- **URL:** `/services/website-maintenance-services/` — production URL **kept** (D-023; 66 clicks, 277,583 imp, avg pos 32.6). No redirect for this page.
- **New page 198:** guarded create (file absent, no page at that path, parent 68, `blog_public = 0`). Menu item 129 "Website Maintenance" was converted from `#` to page 198 in the same call (backup option `rl_menu_backup_20260930_mt`). **All 19 Solutions menu items now link to built, published pages.**
- **Yoast:** title "Website Maintenance Services | Reinforce Lab" (drops production's "Best"); meta "Website maintenance services for WordPress: tested updates, off-site backups, security and uptime monitoring, speed and SEO health checks, support and a monthly report."
- **File:** `wp/novamira-sandbox/reinforce-maintenance.php` on the shared kit (D-044). After the quote fix, live md5 = repo `0636496d…`.
- **Correction after publishing** (backup `.bak-20260930-051243`):
  - The WordPress.org quote is now verbatim.
  - The host myth is re-tagged "The evidence", because it combines WordPress.org and Patchstack.
- **Research:** `claude/research/website-maintenance-research-2026-09-30.md`. Patchstack and WordPress.org were read directly.
- **Hero animation "A month of care":**
  - 28 days tick over (daily backups), with weekly "UPD" days.
  - The status panel lights: uptime, backups, updates, security, speed.
  - A plugin-vulnerability alert then runs alert → check → patch → verify, and Security goes back to "Patched".
  - Backup · update · protect · report light in turn. 10 s loop, soft fade, reset.
- **Sections:**
  - answer-first lede;
  - What's included (9);
  - Why WordPress needs maintenance (Patchstack: 11,334 / 91% / 5 hrs; WordPress.org quote);
  - **Schedule table** (continuously / daily / weekly / monthly / quarterly);
  - Myths (4: auto-updates, host security, untested backups, premium plugins);
  - Process (5); Deliverables (8); Monthly report (6);
  - Straight answer ("No one can promise a site will never be hacked");
  - 8 industry cards; 6 related; 6 FAQs; final CTA.
- **Verified:** 1 H1 (three lines), 12 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, menu link rendered, 390 px with no overflow; screenshots checked. Fingerprint tool now includes `mt`.

---

## O-021 — Maintenance service commitments stated on page 198 need Jamil's confirmation — OPEN
**Date:** 30 September 2026 · **Status:** OPEN (content on `.online` only; nothing on production)

The page describes a delivery routine that Jamil has not yet confirmed as the actual service standard:

| When | What the page commits to |
|---|---|
| Continuously | Uptime monitoring, vulnerability alerts and protection rules |
| Daily | Off-site backups |
| Weekly | Updates tested on a staging site, then applied; forms and checkout tested |
| Monthly | Core Web Vitals review, SEO health check, backup restore test, report |
| Quarterly | User and access review, plugin audit |
| Always | A "named team" for support; a change log; a monthly report |

**No** prices, response-time SLAs or uptime guarantees are stated.

**RECOMMENDATION:** confirm the routine, or give the real one, and state which tools deliver it (staging, backups, monitoring). The same applies to the "onboarding audit" for sites we didn't build. The schedule table is one section in `reinforce-maintenance.php` and can be changed in minutes.

---

## D-063 — E-commerce Website Design page built on `.online` (page 197, published)
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "B, then go ahead with E-commerce Website Design")

- **URL:** `/services/ecommerce-website-design-service/` — production URL **kept** (D-023). Sheet row 141 shows 0 impressions (no measurable search equity), so it is effectively a fresh build.
- **New page 197:** guarded create (file absent, no page at that path, parent 68, `blog_public = 0`). Menu item 128 "E-commerce Website Design" was converted from custom `#` to page 197 in the same guarded call. Backup option: `rl_menu_backup_20260930_ecd`.
- **Yoast:** title "E-commerce Website Design Services | Reinforce Lab"; meta "E-commerce website design that gets stores found and bought from: product data for Google, easy browsing, a shorter checkout, fast pages and WCAG 2.2 AA accessibility, on WooCommerce."
- **File:** `wp/novamira-sandbox/reinforce-ecomdesign.php` on the shared kit (D-044). Live md5 = repo `4a63e685…`.
- **Correction after publishing** (backup `.bak-20260930-050542`): the accessibility card said WCAG 2.2 AA is "as EU e-commerce now requires". The EAA's harmonised standard maps to WCAG 2.1 AA, so the card now reads "with the European Accessibility Act in mind".
- **Research:** `claude/research/ecommerce-design-research-2026-09-30.md`. Baymard and Google were read directly.
- **Hero animation "Found to ordered":**
  - A search result shows price, stock and rating; the store grid appears and one product is picked.
  - The checkout drops 4 of 8 fields ("Fewer fields"), then ticks total up front, guest checkout and payment options.
  - "Place order" becomes "Order placed".
  - Found · browse · checkout · order light in turn. 10 s loop, soft fade, reset.
- **Sections:**
  - answer-first lede;
  - What's included (9);
  - **Why shoppers abandon carts** (Baymard: 70.22% average; 40 / 20 / 19 / 18 / 17%; 12–14 vs 23.48 form elements);
  - How products get found in Google (merchant listings, Merchant Center, filter crawl control);
  - Process (5); Deliverables (8);
  - Straight answer ("Most lost sales happen at checkout");
  - 8 industry cards; 6 related; 6 FAQs; final CTA.
- **Pricing:** production sells the same three packages here as on the WordPress page, so **O-020 (B) applies to both pages**. No price is shown until Jamil sets X.
- **Verified:** 1 H1 (three lines), 10 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, menu link rendered, 390 px with no overflow; screenshots checked. Fingerprint tool now includes `ecd`.

---

## D-062 — Menu wiring fixed; WordPress Website Design page built on `.online` (page 196, published)
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "yes, fix the menu then go ahead with WordPress Website Design")

**Menu (Primary, `.online` only):** three menu items were custom `#` links. Each was converted to a page link, with parent and position unchanged. Guarded: each item had to be custom with url `#`, and its page had to be published.

| Item id | Menu item | Now links to |
|---|---|---|
| 110 | "Search Engine Optimization" | page 190 |
| 121 | "Digital PR / Press Release" | page 189 |
| 127 | "WordPress Website Design" | page 196 (done with this page's create) |

Previous state is saved in options `rl_menu_backup_20260930` and `rl_menu_backup_20260930_wpd`. Verified in the rendered header (desktop and mobile menu).

**Page:**
- **URL:** `/services/wordpress-website-design-service/` — production URL **kept** (D-023; 281,585 imp, pos 53.6). No redirect for this page. It is the approved CONSOLIDATE 301 target for the WooCommerce web-design product URLs.
- **New page 196:** guarded create (file absent, no page at that path, parent 68 = services, `blog_public = 0`).
- **Yoast:** title "WordPress Website Design Services | Reinforce Lab"; meta "WordPress website design services for B2B brands: custom design, editor-friendly builds, Core Web Vitals speed, WCAG 2.2 AA accessibility and redesigns that keep your rankings."
- **File:** `wp/novamira-sandbox/reinforce-wpdesign.php` on the shared kit (D-044). Live md5 = repo `ba551611…`.
- **Research:** `claude/research/wordpress-design-research-2026-09-30.md`. W3Techs 40.2% replaces production's outdated "38%".
- **Hero animation "Wireframe to launch":**
  - A browser frame's wireframe draws in, then the design fills: nav, hero, button, cards, footer.
  - Six launch checks tick in turn: LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1, WCAG 2.2 AA, redirect map, schema & SEO.
  - Plan · design · build · launch light in turn. 10 s loop, soft fade, reset.
- **Sections:**
  - answer-first lede;
  - What's included (9);
  - Standards (Core Web Vitals thresholds, WCAG 2.2 AA, EAA note, "Not legal advice");
  - **Redesigns without losing rankings** (5 steps plus Google's "at least 1 year" quote);
  - Process (5); Deliverables (8);
  - Straight answer ("A beautiful site that loses its rankings is a failed redesign");
  - 8 industry cards; 6 related; 6 FAQs; final CTA.
- **Not claimed:** no prices, hosting, delivery times or page counts (O-020).
- **Verified:** 1 H1 (three lines), 10 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, 390 px with no overflow; screenshots checked. Fingerprint tool now includes `wpd`.

---

## O-020 — Production WordPress design packages ($2,597 / $4,597 / $8,597, WooCommerce, "free hosting") — RESOLVED: Option B
**Date:** 30 September 2026 · **Status:** RESOLVED 30 Sep 2026 (Jamil: "B, then go ahead with E-commerce Website Design")

**Resolution:** the cart packages are retired at migration, for both the WordPress and the E-commerce design pages (they sell the same three packages). Woo products are unpublished, not deleted; existing orders are untouched. The pages will show "Projects from $X" plus a written scope and quote after discovery. **Still needed from Jamil:** (1) the value of X, and (2) whether "free hosting for 1 year" and the 7/15-day delivery times are still offered. Until both are answered the page shows no price, hosting or delivery claim. Production stays untouched until the migration.

**Finding (VERIFIED, read-only):** production's WordPress design page sells three WooCommerce packages:

| Package | Price | Pages | Free hosting (1 yr) | Ready in | Support |
|---|---|---|---|---|---|
| Starter | $2,597 | 5 | 5 GB | 7 days | 1 month |
| Growth | $4,597 | 10 | 10 GB | 15 days | 3 months |
| Enterprise | $8,597 | unlimited | 15 GB | 1 month | 6 months |

Their product URLs already 301 here (CONSOLIDATE). The rebuilt page shows **no prices** until Jamil decides.

**Differs from O-019 (INFERENCE):** fixed "from" prices are normal for web-design projects. Competitors range from productised ~$2k sites to $75k+ enterprise builds. So publishing a starting price is a reasonable choice here, unlike the monthly SEO retainers.

**Open questions:**
- Is "free hosting for 1 year" still offered? If not, it must not appear.
- Are "7 days / 15 days" delivery times still true?

**Options (RECOMMENDATION = B):**
- **A.** Keep the three packages and the cart.
- **B.** Retire the cart and publish "Projects from $X", with a written scope and quote after discovery. Woo products are unpublished (not deleted) at migration; existing orders are untouched.
- **C.** Quote only, with no published price.

---

## D-061 — Executive AI Consulting page built on `.online` (page 103, published)
**Date:** 30 September 2026 · **Status:** DONE (Jamil: "yes, go ahead with Executive AI Consulting")

- **URL:** `/services/executive-ai-consulting/` (D-023 new URL). It is the 301 target for `/services/business-consultancy-service/` (2 clicks, 2,555 imp; low equity). Page 103: draft → publish, content `[reinforce_execai]`. Guarded create: file absent, page 103 empty draft under 68, `blog_public = 0`. With this, every service-page related card now resolves to a published page; the remaining F-021 draft links are the industry cards and the menu.
- **Yoast:** title "Executive AI Consulting & AI Strategy | Reinforce Lab"; meta "Executive AI consulting for leadership teams: prioritised AI use cases, business cases, governance, EU AI Act mapping and AI literacy, with a roadmap supported through the first pilots."
- **File:** `wp/novamira-sandbox/reinforce-execai.php` on the shared kit (D-044). After the Article 4 correction (backup `.bak-20260930-043810`), live md5 = repo `c00da429…`.
- **Research:** `claude/research/executive-ai-consulting-research-2026-09-30.md`. Gartner, McKinsey and the AI Act Service Desk timeline were read directly.
- **Correction before sign-off (see F-022):** the first version paraphrased the original Article 4 AI-literacy duty. The Digital Omnibus replaced it on 27 Jul 2026. The FAQ, timeline table and training card now state the amended duty ("take measures to support… no guaranteed individual level"), and a 27 Jul 2026 row was added.
- **Hero animation "Matrix to roadmap":**
  - 8 use cases appear on a value × feasibility matrix, and the "Do first" quadrant lights.
  - A dashed "Risk check" flags one case.
  - The chosen cases flow into a Q1–Q4 roadmap (Governance → Pilot → Scale → Review).
  - Assess · prioritise · govern · roadmap light in turn. 10 s loop, soft fade, reset.
- **Sections:**
  - answer-first lede;
  - Why AI initiatives fail (Gartner 30% / 40%+, McKinsey 39%);
  - What it covers (9);
  - **EU AI Act timeline table** (6 rows, Service Desk, "Not legal advice");
  - Process (5); Deliverables (8); Measurement (6, incl. "projects stopped early");
  - Straight answer ("Sometimes the answer is 'not yet'");
  - 8 industry cards; 6 related; 6 FAQs; final CTA.
- **Not claimed:** no prices, fixed durations, clients or results; "we are not resellers" is a positioning statement.
- **Verified:** 1 H1 (three lines), 11 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, 390 px with no overflow (after one proxy retry); screenshots checked. Fingerprint tool now includes `ex`.

---

## F-022 — EU AI Act Article 4 (AI literacy) was amended by the Digital Omnibus on 27 Jul 2026
**Date:** 30 September 2026 · **Status:** RECORDED (applied to page 103; nothing else affected)

- **VERIFIED:** Regulation (EU) 2026/1744 (Digital Omnibus on AI; OJ 24 Jul 2026, in force 27 Jul 2026) replaced Article 4. It moves from "ensure, to their best extent, a sufficient level" to "take measures to support the development of AI literacy", and states that no specific individual level has to be guaranteed. The AI Act Service Desk's Article 4 page still shows the old text, under an "amended — not yet updated" disclaimer.
- **Also from the Service Desk timeline (post-Omnibus):** high-risk Annex III rules apply from **2 Dec 2027**; Annex I from 2 Aug 2028; new prohibitions from 2 Dec 2026.
- **Checked:** the AI Workflow Automation page (D-060) makes no literacy claim, and its dates (prohibitions Feb 2025, high-risk Dec 2027, chatbot disclosure) match the post-Omnibus timeline. No change needed.
- **Rule for future pages:** quote AI Act duties from the Service Desk timeline plus the amended text, not from pre-July-2026 summaries.

---

## D-060 — AI Workflow Automation page built on `.online` (page 97, published)
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "yes, go ahead with AI Workflow Automation")

- **URL:** `/services/ai-workflow-automation/` (D-023 new URL; no legacy redirects). Page 97: draft → publish, content `[reinforce_aiwork]`. Guarded create: file absent, page 97 empty draft under 68, `blog_public = 0`. Publishing it also clears 1 of the F-021 draft links (the Marketing Automation and Lead Gen related cards now resolve).
- **Yoast:** title "AI Workflow Automation Services | Reinforce Lab"; meta "AI workflow automation for triage, document extraction, drafting and system updates, built on your tools with human review, logging and testing, so AI does the busywork and people keep control."
- **File:** `wp/novamira-sandbox/reinforce-aiwork.php` on the shared kit (D-044). Live md5 = repo `fe0599cb…`.
- **Research:** `claude/research/ai-workflow-automation-research-2026-09-29.md`. The Commission AI Act page, NIST and McKinsey were read directly.
  - **Date caution recorded:** the Commission now gives 2 December 2027 for high-risk obligations (AI Omnibus). The older August 2026 dates in secondary sources were not used.
- **Hero animation "Human in the loop":**
  - Emails, tickets, invoices and forms feed an AI step (classify · extract · draft), then a "Sure?" check.
  - YES cases go to "Your systems" (CRM · ERP · Helpdesk). NO cases go to Human review, then "Approved", then the systems.
  - An audit-log strip fills as each step happens.
  - Capture · process · check · act light in turn. 10 s loop, soft fade, reset.
- **Sections:**
  - answer-first lede;
  - What we automate (9);
  - Why AI projects stall (McKinsey 2025: 88% / 62% / 39%, plus workflow redesign);
  - **Guardrails** (6 controls; NIST AI RMF as checklist; EU AI Act chatbot-disclosure quote; "Not legal advice");
  - Process (5, pilot with human review on every case); Deliverables (8);
  - Measurement against baseline (6);
  - Straight answer ("Not every process should be automated");
  - 8 industry cards; 6 related; 6 FAQs (incl. "Does the EU AI Act apply to us?"); final CTA.
- **Not claimed:** no prices, tools/partnerships, hours-saved figures or results.
- **Verified:** 1 H1 (three lines), 11 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, 390 px with no overflow; screenshots checked. Fingerprint tool now includes `aw`.

---

## D-059 — Lead Generation Systems page built on `.online` (page 102, published)
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "yes, go ahead with Lead Generation Systems")

- **URL:** `/services/lead-generation-systems/` (D-023 new URL). Page 102: draft → publish, content `[reinforce_leadgen]`. Guarded create: file absent, page 102 empty draft under 68, `blog_public = 0`.
- **Yoast:** title "B2B Lead Generation & PPC Management Services | Reinforce Lab"; meta "Lead generation systems that turn demand into qualified pipeline: channels, PPC, landing pages, qualification, routing and closed-loop CRM data that tells your ads which leads became revenue."
- **Why this framing:** it is the D-023 301 target for `/services/ppc-management-services/` (6,576 imp, pos 85.3 — low equity), so it carries a full "What does our PPC management include?" section. Service `alternateName` = B2B lead generation / PPC management services / Google Ads management.
- **File:** `wp/novamira-sandbox/reinforce-leadgen.php` on the shared kit (D-044). Live md5 = repo `5f3d00b5…`.
- **Post-publish correction** (backup `.bak-20260929-192858`), because two lines weren't backed by fact or by a decision of Jamil's:
  - "Four we still see in most accounts we audit" became "Four common habits" (no audit history to cite).
  - FAQ "We don't charge per lead" became neutral: pricing is agreed after an audit, and media spend is reported separately. No pricing policy is set until Jamil decides one.
- **Research:** `claude/research/lead-generation-research-2026-09-29.md`. Google Ads Help and Gartner were read directly; 6sense figures are not used because they could not be verified.
- **Hero animation "Closed loop":**
  - Search, paid ads, content and referrals flow into a landing page, then a form, then a "Fit?" check.
  - Qualified leads go to sales, then a closed deal; the rest go to nurture.
  - The closed deal is fed back as "conversion data → ad bidding", and Paid Ads lights up.
  - Attract · convert · qualify · close the loop light in turn. 10 s loop, soft fade, reset.
- **Sections:**
  - answer-first lede;
  - The system (6);
  - How B2B buyers want to be found (Gartner 2025: 61% / 73% / 69%);
  - PPC management (6);
  - PPC myths (4, from Google Ads Help: Quality Score, landing page experience, offline conversions, EEA consent);
  - Process (5); Deliverables (8); Measurement (6);
  - Straight answer ("Cheap leads are expensive");
  - 8 industry cards; 6 related; 6 FAQs; final CTA.
- **Verified:** 1 H1 (three lines), 12 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, 390 px with no overflow; screenshots checked. Fingerprint tool now includes `lg`.

---

## D-058 — Marketing Automation page built on `.online` (page 86, published)
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "yes, D-023 wins, then go ahead with Marketing Automation")

- **URL:** `/services/marketing-automation/` (approved new URL, 27 Sep 2026). Page 86: draft → publish, content `[reinforce_automation]`. Guarded create: file absent, page 86 empty draft under 68, `blog_public = 0`.
- **Yoast:** title "Marketing Automation & Email Marketing Services | Reinforce Lab"; meta "Marketing automation that follows up every lead: nurture emails, lead scoring, CRM workflows and sales handoff, built on your platform, compliant with Gmail, CAN-SPAM and PECR rules."
- **Why this framing:** under D-023 it is the 301 target for the email-marketing page (19,316 imp) and the two social-media pages. It therefore covers email marketing campaigns (Service `alternateName`) and social publishing workflows as part of automation.
- **File:** `wp/novamira-sandbox/reinforce-automation.php` on the shared kit (D-044). Live md5 = repo `0a4f9775…`.
- **Research:** `claude/research/marketing-automation-research-2026-09-29.md`. Gmail, FTC, ICO and Litmus pages were read directly.
- **Hero animation "Nurture to handoff":**
  - A form fill triggers a guide email and a "Clicked?" branch.
  - YES leads get a case study and their lead score rises past the MQL line; NO leads wait for a new angle.
  - Sales is alerted and a CRM deal is created.
  - Trigger · nurture · score · handoff light in turn. 10 s loop, soft fade, reset.
- **Sections:**
  - answer-first lede;
  - What it covers (9);
  - **Email rules** — 5 myth/fact pairs from Gmail, FTC and ICO, marked "Not legal advice";
  - Process (5); Deliverables (8);
  - Measurement — why not open rates (Litmus: MPP 55% of opens, March 2024);
  - Straight answer ("Automation makes bad follow-up faster");
  - 8 industry cards; 6 related; 6 FAQs; final CTA.
- **Not claimed:** no platform partnerships, prices, results or ROI multiples. The platform is "the one you already have".
- **Verified:** 1 H1 (three lines), 10 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, 390 px with no overflow; screenshots checked. Fingerprint tool now includes `ma`.

---

## F-021 — Built pages link to unpublished draft pages (`?page_id=N`) — launch QA item
**Date:** 29 September 2026 · **Status:** OPEN (no change made)

**Finding (VERIFIED):**
- `rl_url_by_path()` (`reinforce-header.php:180`) returns `get_permalink()` for any page found by path, including drafts. So links to unbuilt services render as `https://reinforcelab.online/?page_id=97` and similar, which 404 for visitors.
- On the built pages, most such links come from the **Primary menu**. It was intentionally wired to drafts during the build (D-024): ids 71, 75, 77–84, 87, 90–97, 102, 103.
- Some are **body links**, such as the related cards to Lead Gen (102), AI Workflow Automation (97) and Executive AI Consulting (103).

**Impact:** none while `.online` is noindex and in build. At launch these would be broken internal links.

**RECOMMENDATION (for Jamil, later):**
1. Add to the launch QA gate: "no link to a non-published page". It is checked by crawling for `?page_id=`.
2. Optionally make `rl_url_by_path()` return the fallback for non-published pages. The card code already renders a plain, unlinked card when the URL is empty. This is a one-line change in the shared header, so it affects every page and needs a regression pass.

---

## D-057 — SEO Content Systems page built on `.online` (page 85, published)
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "B, then go ahead with SEO Content Systems")

- **URL:** `/services/seo-content-systems/` (approved new URL, 27 Sep 2026). Page 85: draft → publish, content `[reinforce_content]`. Guarded create: file absent, page 85 empty draft under 68, `blog_public = 0`.
- **Yoast:** title "SEO Content Writing Services & Content Systems | Reinforce Lab"; meta "SEO content writing run as a system: research, topic maps, expert-led briefs, human-edited pages, internal links and refreshes. Content that ranks, gets cited and converts."
- **Why this framing:** under D-023 it is the 301 target for 4 legacy pages (~107k impressions in all), so it answers "seo content writing services", "seo blog writing services", "website copywriting services" and content-marketing searches in one place. The Service `alternateName` = SEO content writing services / SEO copywriting / Blog writing services.
- **File:** `wp/novamira-sandbox/reinforce-content.php` on the shared kit (D-044). Live md5 = repo `edd6ca00…`.
- **Research:** `claude/research/seo-content-systems-research-2026-09-29.md` — 6 competitors, Google's AI-content guidance, and the CMI 2026 B2B report (read directly).
- **Hero animation "Content system":**
  - A page moves through research → brief → draft → review → publish.
  - It then joins a topic cluster: the pillar page and 6 supporting pages light and link.
  - A refresh loop runs back to research.
  - 10 s loop, soft fade, reset.
- **Sections:** answer-first lede · What is an SEO content system (6 stages) · Why programmes stall (6 CMI 2026 stats) · **Does Google penalise AI content?** (5 myth/fact pairs, quoted from Google, plus our AI policy: people write, edit and fact-check; experts approve) · What we produce (9) · Process (5; "never in bulk", consistent with F-003) · Deliverables (8) · Measurement (6) · Straight answer ("More content is not a strategy") · 8 industry cards · 6 related · 6 FAQs · final CTA.
- **Not claimed:** no volumes, prices, turnaround or results.
- **Verified:** 1 H1 (three lines), 12 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, 390 px with no overflow; section screenshots checked. Fingerprint tool now includes `sc`.

---

## F-020 — Legacy content-service URLs: URL sheet says PRESERVE, D-023 says 301 → `/services/seo-content-systems/`
**Date:** 29 September 2026 · **Status:** RESOLVED 29 Sep 2026 (Jamil: "yes, D-023 wins")

**Resolution applied (records only; production untouched, redirects happen at the approved migration):**
- **URL sheet — 23 rows updated.**
  - The 10 legacy service pages now read `APPROVED: 301 -> <D-023 target> (D-023; confirmed F-020)`. Those rows are 90, 101, 122, 123, 163, 268, 269, 277, 280 and 287.
  - 13 dependent rows are flattened to the final target, each tagged `[flattened; was -> …]`. They are the HOLD category 301s (134, 144, 146, 147, 200, 201, 215, 233) and the dup-slug 301s (237, 272–275).
- **`redirect-map-2026-09.csv`:** 22 rows flattened to single-hop (`source` tagged `+flattened`). This includes the O-018 chains (rows 51, 84, 85, 97) and production's existing Yoast chains into these pages. 12 direct rows were added for the legacy URLs themselves: the 10 D-023 pages and the 2 O-018 pages. The map now has 500 rows; none of them redirects into another redirect for these URLs.
- **Out of scope, noted:** pre-existing multi-hop chains among `/product/…` WooCommerce URLs (SEO and WordPress-design products) remain. They belong with O-019 / the web-design pages and will be fixed when those are decided.

**Finding (VERIFIED):** in `preserve-disposition-sheet-pagelevel-2026-09-10.csv`, 4 rows still read `APPROVED: PRESERVE — rebuild to D-012 standard`:

| Row | Legacy URL |
|---|---|
| 101 | `/services/content-marketing-services/` |
| 122 | `/services/best-website-copywriting-services/` |
| 123 | `/services/best-blog-writing-services/` |
| 163 | `/services/best-seo-content-writing-services/` |

D-023 (28 Sep, later and explicit) maps all four to `301 → /services/seo-content-systems/`.

The same gap exists for the other D-023 redirects (VERIFIED — each row still reads `APPROVED: PRESERVE — rebuild`):
- row 280 `/services/best-on-page-seo-services/` → core SEO pillar;
- row 277 `/services/email-marketing-services/` → marketing-automation;
- row 287 `/services/ppc-management-services/` → lead-generation-systems;
- row 90 `/services/business-consultancy-service/` → executive-ai-consulting;
- rows 268 and 269, the social-media management and marketing pages → marketing-automation.

The O-018 rows were already updated.

The hold-301s that point at these legacy URLs would become chains:
- `/copywriting/` → best-website-copywriting;
- `/serv.../content-marketing-services/` → content-marketing-services.

**RECOMMENDATION:** confirm that D-023 supersedes the sheet. The sheet rows would then be updated to `APPROVED: 301 → <D-023 target>`, and the hold-301s flattened to the final target. I have not edited these approvals.

---

## D-056 — Core SEO pillar built on `.online` (page 190, published) at the kept production URL
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "yes, go ahead with the core SEO pillar")

- **URL:** `/services/best-search-engine-optimization-services/` — production URL **kept** (D-023; 420,385 impressions / 16 months, avg position 63.4). No redirect for this page. It is the 301 target for `/services/best-on-page-seo-services/` (D-023), so it carries a full on-page SEO section (`#onpage`).
- **New page 190** (no scaffold existed): guarded create checked the file was absent, no page at that path, parent 68 = `services`, `blog_public = 0`. Title "Search Engine Optimization Services", content `[reinforce_seo]`.
- **Yoast:** title "Search Engine Optimization (SEO) Services | Reinforce Lab"; meta "SEO services built on Google's guidelines: technical SEO, on-page, content and authority run as one system and extended to AI search, for B2B and specialist brands."
- **File:** `wp/novamira-sandbox/reinforce-seo.php` on the shared kit (D-044). After a caret-position fix (backup `.bak-20260929-185959`), live md5 = repo `74fad27b…`.
- **Research:** `claude/research/core-seo-pillar-research-2026-09-29.md`. Covers: the production page read-only (via Exa; the egress proxy blocks reinforcelab.com directly), GSC query families, Google primary docs, 6 competitor pages, and the Ahrefs 2024 pricing survey.
- **Pillar role:** a "What are SEO services, and what do they include?" section uses Google's own list of SEO services, then links down to 9 spokes: Technical, On-page (#onpage), SEO Content Systems, Digital PR, Local, International, Enterprise, AI Search Optimization, Audit. The `Service` schema has an `OfferCatalog` of the 7 spoke services.
- **Hero animation "Four pillars":**
  - The crawl · index · serve foundation lights up first.
  - The technical, on-page, content and authority pillars fill in turn.
  - Each finished pillar moves "YOUR PAGE" up one place in the results, until it ranks first.
  - A "Search authority" beam then lights, and the AI overview shows "CITED: YOUR PAGE".
  - 10 s loop, soft fade, reset.
- **Sections:** answer-first lede · What's included · How Google decides what to show (3 stages, "no payment" quote) · On-page SEO (6) · Myths (5, from Google: meta keywords, word count, E-E-A-T, duplicate content, #1 guarantee) · Method (the locked 9-stage DISCOVER→MONITOR methodology) · B2B SEO · Consultant or agency · Deliverables · Measurement · Straight answer ("No one can guarantee you the top spot") · 8 industry cards · AI-search extensions (GEO, LLM, Search Authority OS) · 6 FAQs · final CTA.
- **Not carried over from production:** the WooCommerce package prices and "Buy" buttons (see O-019), and the unsourced statistics. No prices, results or clients are claimed.
- **Verified:**
  - 1 H1 (three lines) and 14 H2.
  - 8 cards; 12 linked cells; no `href="#"`.
  - Kit loaded, no PHP errors, noindex.
  - 390 px with no overflow; screenshots checked.
  - Fingerprint tool now includes `seo`.

---

## O-019 — Production SEO packages ($2,000–$6,500/yr, WooCommerce "Buy") on the core SEO pillar — RESOLVED: Option B
**Date:** 29 September 2026 · **Status:** RESOLVED 29 Sep 2026 (Jamil: "B, then go ahead with SEO Content Systems")

**Resolution:** the cart packages are **retired at migration**. The rebuilt pillar leads to the free diagnostic, the SEO & AI Search Audit and the Search Authority OS packages. It shows "SEO programmes from $X/month" only once Jamil sets X (**still needed**). At migration the three Woo SEO products are **unpublished, not deleted**, and existing orders and subscriptions are left untouched. **Still needed before migration:** a read-only production check for active subscriptions to these products, which needs Jamil's OK because it is production. Production stays untouched until then.

**Finding (VERIFIED, read-only):** production's `/services/best-search-engine-optimization-services/` sells three WooCommerce SEO packages:

| Package | Price | Yearly-discount price |
|---|---|---|
| Starter | $2,000/yr ($167/mo) | $1,700 |
| Growth | $3,500/yr ($292/mo) | $2,800 |
| Enterprise | $6,500/yr ($542/mo) | $4,875 |

- Deliverables are 150/200/300 key phrases, 30/40/60 pages and 6/12/24 SEO contents.
- These quantities match WebFX's published tier quantities.
- The rebuilt page on `.online` carries **no prices** until Jamil decides.

**Why it matters (INFERENCE):**
- $167–$542/mo sits below Ahrefs' 2024 survey average of $2,917/mo (agencies $3,209/mo), and well below the $5,000 setup of the Search Authority OS packages.
- It also sits below the audit price set in D-053 (from $2,500).
- It conflicts with the consultative, no-cart model (D-016).
- Removing live "Buy" products also touches the WooCommerce store, which holds real customer data. Nothing on production changes without approval.

**Options (RECOMMENDATION = B):**
- **A.** Keep the packages as they are and republish them on the new page.
- **B.** Retire the cart packages at migration. The page leads to the free diagnostic, the SEO & AI Search Audit and the Search Authority OS packages, with an optional "SEO programmes from $X/month" once Jamil sets X. The Woo products are unpublished only at migration, and existing orders and subscriptions are left untouched.
- **C.** Keep a single entry-level SEO package, repriced and re-scoped (not WebFX-shaped).

Also needed: whether any customer currently holds an active subscription to these products. That is a read-only WooCommerce check on production, which needs Jamil's approval.

---

## D-055 — Digital PR & Link Building page built on `.online` (page 189, published) — carries the off-page / link-building intent (O-018 B)
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "B, then go ahead with Digital PR")

- **URL:** `/services/press-release-services/` — the production URL is **kept** (D-023, `APPROVED: PRESERVE — rebuild to D-012 standard`), so no redirect for this page. Its production slug stays; only the content is rebuilt on `.online`.
- **New page 189** (no scaffold existed): guarded create checked the file was absent, no page at that path, parent 68 = `services`, `blog_public = 0`. Title "Digital PR & Link Building", parent 68, content `[reinforce_pr]`.
- **Yoast:** title "Digital PR & Off-Page SEO Services | Reinforce Lab"; meta "Digital PR and link building that earns coverage, links and AI citations from relevant publications — original data, expert commentary, no bought links, within Google's link policies."
- **Why this framing:** it is now the 301 target for `/services/off-page-seo-services/` and `/services/best-affordable-seo-link-building-services/` (O-018 B). Their queries — "off page seo services" 8,969 imp, "affordable seo link building services" 3,862 imp at pos 16.5, "affordable link building services", "off page seo company" — are answered in the H2 "What is off-page SEO, and where does link building fit?", the link-rules section, and the FAQ "Is affordable link building safe?". No prices or link counts are offered (none approved).
- **File:** `wp/novamira-sandbox/reinforce-pr.php` on the shared kit (D-044). Live md5 = repo `533ef640…`.
- **Research:** `claude/research/digital-pr-research-2026-09-29.md` — Exa agent run (8 agency pages, Google sources) plus the **Cision 2026 State of the Media PDF read directly**: 1,899 journalists, 19 markets; 79% relevance, 82% reject irrelevant pitches, 47% want more data, 66% rely on PR content, 53% reject promotional pitches, 97% prefer email, 64% one follow-up.
- **Hero animation "Story to authority":** original-data bars build → pitches go to news site, trade press, industry blog and an AI answer → coverage lands with "LINK → YOUR SITE" (the AI answer shows "CITED: YOUR BRAND") → links flow to your site and its authority meter fills → pitch · coverage · links · citations light in turn. 10 s loop, soft fade, reset.
- **Sections:** answer-first lede · Off-page SEO (links / coverage / citations) · What journalists want (6 Cision stats) · What we cover (9) · Link rules (5 myth/fact pairs from Google: bought links, sponsored/nofollow, press-release anchors, scaled guest posting, exact-match anchors) · Process (5) · Deliverables (8) · Measurement (6) · Straight answer ("Nobody honest can guarantee coverage") · 8 industry cards · 6 related · 6 FAQs · final CTA.
- **Schema:** `Service` "Digital PR & Link Building" (alternateName Digital PR / Off-page SEO / Link building services) + `FAQPage` (6); breadcrumb Home › Services › Digital PR & Link Building.
- **Verified:** 1 H1 (three lines), 12 H2, 8 cards, kit loaded, no PHP errors, noindex, no `href="#"`, 390 px no overflow; Services hub card now links to the page; section screenshots checked. Fingerprint tool now includes `pr`.

---

## D-054 — Enterprise SEO Strategy page built on `.online` (page 98, published)
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "yes, go ahead with Enterprise SEO Strategy")

- **URL:** `/services/enterprise-seo-strategy/` (D-023 new URL). Page 98: draft → publish, content `[reinforce_enterprise]`.
- **Yoast:** title "Enterprise SEO Strategy Services | Reinforce Lab"; meta "Enterprise SEO strategy for large, complex sites: one SEO standard across teams, template fixes shipped through your sprints, safe migrations and authority built within Google's link policies."
- **File:** `wp/novamira-sandbox/reinforce-enterprise.php`, on the shared kit (D-044). Guarded create: file absent, page 98 empty draft under 68, `blog_public = 0` checked first. Live md5 = repo `a4f9f7a7…`.
- **Research:** `claude/research/enterprise-seo-research-2026-09-29.md` (Exa agent run + Google primary sources). Every Google claim on the page is quoted or paraphrased from those sources and linked.
- **Hero animation "One standard, every page":** four teams → one SEO-standards gate (templates · QA gate · releases) → an 8×9 page grid lights column by column → earned links from press, partners and industry. 10 s loop, soft fade, reset; paused off-screen and under reduced motion (header).
- **Sections:** answer-first lede · Why SEO breaks at scale (6) · What it covers (9 workstreams) · **Authority & off-page SEO** (Google's link-spam definition, 5 myth/fact pairs: bought links, sponsored/nofollow, press-release anchors, footer/template links, site reputation abuse; plus "what we do instead") · Migrations (5 steps, Google site-move quote) · Process (5) · Deliverables (8) · Measurement (6) · Straight answer · 8 industry cards (D-047) · 6 related services · 6 FAQs · final CTA.
- **Schema:** `Service` + `FAQPage` (6) added to Yoast's graph; breadcrumb Home › Services › Enterprise SEO Strategy.
- **Not claimed:** no prices, results, clients or case studies (none supplied); the F-001 case study is not used (permission pending); crawl-budget figures are given with Google's own "rough estimate" caveat.
- **Verified:** 1 H1 (three lines), 12 H2, 8 industry cards, kit loaded, no PHP errors, noindex, no `href="#"`, no horizontal overflow at 390 px; section screenshots checked. Fingerprint tool now includes `ent`.

---

## O-018 — Legacy off-page / link-building URLs → `/services/enterprise-seo-strategy/`: intent mismatch — RESOLVED: Option B
**Date:** 29 September 2026 · **Status:** RESOLVED 29 Sep 2026 (Jamil: "B, then go ahead with Digital PR")

**Resolution:** both legacy URLs are `APPROVED: 301 → /services/press-release-services/` (Digital PR, rebuilt to carry the off-page / link-building intent). Also flattened: `/off-page-seo/` → `/services/press-release-services/` directly. Production's existing Yoast chains that end at the two legacy URLs (`…/link-building-seo-services`, `…/off-page-seo-services` variants, `redirect-map-2026-09.csv` rows 84, 85, 97) must be re-pointed to the new target at migration, so there are no multi-hop chains (F-015). Production untouched: the redirects happen only in the approved migration. Records updated: page-level disposition sheet rows 82, 162, 265; `approved-new-urls-2026-09.csv`; D-023 map.

**Finding (VERIFIED, production GSC data, read-only):** D-023 maps two legacy production URLs to the enterprise page:
- `/services/off-page-seo-services/` — 12 clicks, 47,499 impressions, avg position 40.8 (top query "off page seo services", 8,969 imp).
- `/services/best-affordable-seo-link-building-services/` — 3 clicks, 34,775 impressions, avg position 37.2 ("affordable seo link building services" at avg position 16.5, 3,862 imp).

**The problem (INFERENCE):** these searchers want *off-page SEO / affordable link building*. The enterprise page is about governance for large organisations. A 301 to a page that doesn't match the query intent may not carry the rankings across.

**Mitigation already built:** the enterprise page has a substantial "Authority & off-page SEO" section (`#authority`) and an FAQ "Do you build links?", so the redirect target does answer the off-page question.

**Options (RECOMMENDATION = B):**
- **A.** Keep D-023 as is: 301 both to `/services/enterprise-seo-strategy/`.
- **B.** 301 both to the future **Digital PR** page (`/services/press-release-services/`, rebuilt per D-023) — the closest intent match for ethical off-page / link building — and link from it to Enterprise.
- **C.** Keep one legacy URL alive as an "Off-page SEO & link building" page (rebuilt, no paid-link offers).

Nothing changes on production until Jamil approves a specific option for each URL.

---

## D-053 — SEO & AI Search Audit pricing and terms set (delegated to Claude at industry standard)
**Date:** 29 September 2026 · **Status:** APPROVED by delegation (Jamil: "What should be the audit pricing as industry standard go ahead")

**Evidence:** the competitor research (D-051) shows paid audits at $197–$5,000.
- The cheap end ($197–$500) is typically tool-led.
- Human-led audits with AI-visibility testing sit at $1,500–$5,000: O8 $1,500, Edge £1,500, Clear Cited $2,500 Full / $4,500 Comprehensive, Avante $5,000.
- Turnaround 5–14 business days; fee credits 30–90 days are common; walkthroughs 15–60 minutes.
- Our packages start at $5,000 setup, so the audit must sit clearly below that.

**Terms set:**
- **Price: from $2,500** (USD, one-time) for a standard website. Large, multi-market or very large sites are **quoted after scoping**.
- **Turnaround: 10 business days** from confirmed access and scope.
- **Walkthrough: 60 minutes** with the client team.
- **Fee credit: 100 %** toward a Search Authority OS package started **within 60 days**.
- **How to buy:** a scoped request — consultative, matching D-016 (no cart). The audit page's "Request an audit" buttons open the diagnostic form with `?interest=audit`.
- **Sample report:** not offered until one exists. **Re-check:** not included.

**Implementation:**
- **`reinforce-diagnostic.php`:** in audit mode the form title becomes "Request your SEO & AI Search Audit" ("we reply with a scope and quote") and carries a hidden `interest=audit` field. The handler then:
  - prefixes the record title "[Audit]";
  - stores `request_type` post meta;
  - sends the email "Audit request — {company}" with the body "New SEO & AI Search Audit request";
  - sets the webhook type `seo_ai_search_audit_request`.
  - Normal diagnostic requests are unchanged (verified: the plain form has no `interest` field).
- **`reinforce-audit.php`:**
  - hero primary "Request an audit →";
  - comparison-table cost "From $2,500 — credited toward a package within 60 days";
  - **new Pricing section**: a "From $2,500" card plus 10 business days / 60-minute walkthrough / credited in full / quoted separately;
  - new FAQ "How much does the audit cost, and how long does it take?" (7 FAQs);
  - deliverable "60-minute walkthrough";
  - final CTA "Request an audit" plus "Start with the free diagnostic";
  - `Service.offers`: Offer USD 2500 with `PriceSpecification.minPrice` 2500;
  - section bands re-balanced.
- Deploy backup `.bak-20260929-182430`. Live md5s = repo: audit `bb6e00c0…`, diagnostic `118150ec…`.
- **Verified:** 3 "Request an audit" links to `?interest=audit#request`; Offer present; the audit-mode form renders its title and hidden field; the normal form is unchanged; no PHP errors; 390 px on mobile.
- **Not tested:** a live form submission. It would email hello@reinforcelab.com and create a record, so Jamil can test it.

**Changeable at any time:** all terms live in `reinforce-audit.php` (pricing section, FAQ, table, schema). A change of price is a one-file edit.

---

## D-052 — International SEO lines refined; legacy local post approved for 301 (O-017 → A)
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "Make the lines sleek then option A")

**1. International SEO hero — lines made sleek** (screenshot feedback: the completed hreflang network looked heavy):
- ring arcs 1.2 px solid red → **0.8 px, soft red (55 % opacity), round caps**;
- the two cross links (N–S, E–W) → **0.6 px at 28 % opacity**, so they read as secondary;
- base dashed guides → 0.8 px, very faint;
- node borders and lit states → 0.8 px, softer red;
- centre box stroke softened; serve pulses 1.8 → 1.3 px; globe lines fainter;
- **new:** a thin white highlight travels once around the four ring arcs after they draw (36–42 % of the loop).

Deploy backup `.bak-20260929-180003`; live md5 `fbe80d30…` = repo. The change is scoped to `rl_intl_css()`. Fingerprint: two fresh runs are identical (0). Differences against the older snapshot come only from the D-049 button labels. New baseline saved.

**2. O-017 resolved — Option A.** Production `/best-local-search-engine-optimization-service/` (95,538 impressions / 0 clicks, root-level "best-" post) will **301 → `/services/local-seo/`** at migration cutover.
- It already matches `redirect-map-2026-09.csv` row 15 (single-hop).
- The disposition sheet row was updated from "APPROVED (HOLD)" to "APPROVED: 301 → /services/local-seo/ (O-017 Option A)".
- Its `/feed/` stays 410.
- **Production is untouched until the approved migration** (Rule 2 satisfied: Jamil approved this specific URL).

---

## D-051 — SEO & AI Search Audit page built on `.online` (page 74, published)
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "…then SEO & AI Search Audit")

`/services/seo-ai-search-audit/` is an **APPROVED — NEW URL** (D-006). It is the paid one-time middle step of the D-016 funnel: free Diagnostic → **paid Audit** → Packages.
- New file `wp/novamira-sandbox/reinforce-audit.php` provides `[reinforce_audit]` and is built on the kit.
- Page **74** was published through the guarded create.
- Yoast title: "SEO & AI Search Audit Services | Reinforce Lab".
- Meta: "A one-time, human-led audit of your technical SEO, content, authority, competitors and AI search visibility — with evidence, a prioritised fix register and a roadmap."

**Research (Exa `agent_run_b3959909e53a4ac5b6905931ab98dd05`)** is saved in `claude/research/seo-ai-audit-research-2026-09-29.md`.
- **Competitors:** Sunny Patel, CW Brannan, O8, Edge Digital, Avante Visibility, Bradlee Bartlett, Clear Cited, Rankite.
- **Market norms (self-reported):** $197–$5,000; 5–14 business days; fee often credited toward retainers; walkthroughs; 30/60/90 roadmaps.
- **Buyer objections they answer:** "tool export", "no priorities", "disguised sales call", "pay twice", "guarantees".
- **Openings used:** a documented AI-test method, explicit is/isn't boundaries, a fix register with confirmation criteria, and no guarantees.

**Structure:**
- Hero, with a 3-line H1: "See everything / holding back your / search growth."
- **"Diagnostic, audit or package — which do you need?"** — a comparison table built from the D-016 funnel. Cost row: Free / "Quoted after scoping" / "From $5,000 setup" (the approved figure).
- "What does the audit cover?" — 9 areas.
- **"How do you measure AI search visibility properly?"** — a 4-step method (fixed questions, every engine, repeated runs, logged evidence) plus an example log line, **labelled "Illustrative example… not a real client result"**.
- 8 deliverables and a 5-step process (scope → read-only access → crawl and research → human analysis → report and walkthrough).
- **"What is — and isn't — in the audit?"** — boundaries: no tool export, no ranking or AI-citation promises, no implementation included, no disguised sales call.
- 8 industry cards; "Who can fix what the audit finds?" (5 services plus Packages).
- 6 FAQs and a final CTA that starts with the free diagnostic.

**Schema:** `Service` plus `FAQPage`; Yoast adds the breadcrumb.

**Hero animation "Audit sweep" (D-039 Step 3), 10 s loop:**
1. A magnifier sweeps a website wireframe and stops on 5 issues: 404, CWV, THIN, SCHEMA and AI.
2. They are written into a fix register, prioritised P1/P1/P2/P2/P3, with effort bars.
3. A 30 · 60 · 90-day roadmap lights, then "Found by people · backed by evidence · prioritised".
- Preview fix: the SCHEMA badge crossed the page edge and was moved left.

**Fix (site-wide):** Yoast's BreadcrumbList carried "SEO **&#038;** AI Search Audit", because WordPress texturizes "&" in titles. A `wpseo_schema_breadcrumb` filter in `reinforce-kit.php` now decodes entities in breadcrumb names. Verified: breadcrumb = Home › Services › SEO & AI Search Audit, no entities left. Home, Services, SAOS and Packages had none.

**Deploy and verification:**
- Live md5s = repo: audit `597442e1…`, kit.php `09e3d1d6…` (backup `.bak-20260929-175409`).
- HTTP 200, 1 H1 (3 lines), 10 H2, 8 cards, kit linked, noindex, no PHP errors, no `#` links. HTML 135.6 KB.
- 390 px wide on mobile. Added to the style-fingerprint tool.

**OPEN — facts only Jamil can set (not stated on the page):**
- price or price range;
- turnaround;
- whether the fee is credited toward packages (and within what window);
- a sample report;
- walkthrough length;
- whether a re-check is included;
- how clients buy: request a quote (currently via the diagnostic form), or a WooCommerce product per D-016.

The page currently says "Quoted after scoping" and "the price and delivery date are clear before any work starts". **Jamil to confirm that scoping-first process.**

---

## D-050 — Local SEO page built on `.online` (page 104, published)
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "yes, go ahead with Local SEO")

`/services/local-seo/` is a D-023 new slug.
- New file `wp/novamira-sandbox/reinforce-local.php` provides `[reinforce_local]` and is built on the kit.
- Page **104** was published through the guarded create.
- Yoast title: "Local Search Engine Optimization Services | Reinforce Lab" (57). It targets the GSC query family we already appear for: "local search engine optimization company / service / services", about 28k impressions over 16 months.
- Meta: "Local SEO from Reinforce Lab: Google Business Profile, consistent citations, compliant reviews and location pages — built on Google's own guidelines for local and AI search."

**Research:** Exa `agent_run_00c3bff17f6e402197ef16470fe6fcb5` plus the repo GSC export, saved in `claude/research/local-seo-research-2026-09-29.md`.
- **Competitors:** TechnSEO, B2BSEO.io, The Business Rover, Local SEO Services NYC, Taskcover, LocalGaps, THAT Agency. They are mostly consumer-focused, with unverified guarantees or "AI ranking" claims.
- **VERIFIED:**
  - Google: local results are based on relevance, distance and prominence ("popularity" in the current summary), and "no way to request or pay for a better local ranking";
  - Business Profile rules: real-world name only (keywords can mean suspension); service-area businesses get one profile; no unstaffed virtual offices;
  - reviews: incentives "strictly prohibited"; no selective asking;
  - FTC final rule on fake reviews, 14 Aug 2024;
  - LocalBusiness schema requires `name` and `address`;
  - Apple Business Connect and Bing Places manage map listings;
  - ChatGPT search uses location and partner providers; Gemini has Maps grounding.
- **UNVERIFIED and not claimed:** Perplexity's local data source; review-reply rate as a ranking factor.

**Structure:**
- Hero, with a 3-line H1: "Get found by / customers / near you." The lede contains "local search engine optimization".
- "How does Google rank local results?" — 3 factor cards, each with what we improve or can't change, plus Google's "no way to pay" quote and source.
- 9 coverage areas.
- **"Which local SEO tactics break the rules?"** — 5 myth vs "Google says" pairs plus the FTC source.
- 5-step process, 8 deliverables and 6 measures (grid visibility, profile actions, reviews, citation accuracy, location-page leads, AI local answers).
- Honesty panel: "Distance is the one thing no one can change".
- 8 industry cards and 6 related services.
- 6 FAQs and the final CTA.

**Schema:** `Service` (alternateName "Local search engine optimization") plus `FAQPage`; Yoast adds the breadcrumb.

**Hero animation "Local pack" (D-039 Step 3), 10 s loop:**
1. The query "Accountant near me" appears and ripples spread from the searcher across a street map.
2. Competitor pins and your red pin drop.
3. Google's factors light in turn: relevance, distance (a dashed line to your pin) and prominence (your pin's halo).
4. The local results list builds and "Your business" lights, with profile · reviews · citations checks.
5. Soft fade and reset.
- Preview fixes before deploy: the checks overlapped the next result (moved inside your row); a dashed line can't "draw", so it now fades in; the caption was reworded so it isn't presented as a verbatim Google quote.

**Deploy and verification:**
- Live md5 `0e94f7a4…` = repo.
- HTTP 200, 1 H1 (3 lines), 11 H2, 8 cards, kit linked, noindex, no PHP errors, no `#` links. HTML 136.7 KB.
- No overflow at 1440/390. Added to the style-fingerprint tool.

---

## O-017 — Legacy `/best-local-search-engine-optimization-service/` (production): 301 to `/services/local-seo/`, or keep the URL? — RESOLVED: Option A (301)
**Date:** 29 September 2026 · **Status:** RESOLVED 29 Sep — Jamil: "…then option A" · production untouched until the approved migration

**VERIFIED (repo data):**
- The production post has 95,538 impressions (GSC Pages export) / 102,060 (crawl sheet), **0 clicks**, average position ≈ 60, **0 internal and 0 external links**, and is presumed indexed.
- **Current records:** the disposition sheet says "APPROVED (HOLD): BUILD fresh on-strategy…"; `redirect-map-2026-09.csv` row 15 plans **301 → /services/local-seo/**.
- D-023 said Local SEO had "~0 existing page data". That undercounted this legacy post.

**Differences from the Technical SEO case (D-046):**
- this URL is a **blog post at the site root**, not a `/services/` page;
- its slug uses the keyword-stuffed "best-…" pattern that D-006 decided not to carry into new URLs.

**RECOMMENDATION:** **keep the planned 301 → `/services/local-seo/`** (Option A).
- A single-hop 301 carries its signals to the new service page.
- The service stays inside the `/services/` architecture, and "best-…" is not revived.
- Option B (keep the URL and publish Local SEO there) is possible but mixes a root-level "best-" post URL into the service structure.

**Related:** `/how-to-do-local-seo-audit-11-easy-steps/` (8,340 impressions, never crawled) is already APPROVED: BUILD fresh. It should become a cluster article linking to Local SEO and the Audit page.

---

## D-049 — Hero CTA buttons kept on one line (all pages)
**Date:** 29 September 2026 · **Status:** DONE (Jamil, with a screenshot of the International SEO hero: "Keep the buttons in one line")

**Measured first** (buttons' top offsets in the hero `.cta-row`, 10 pages × 1440 / 1280 / 1024 px):
- International SEO wrapped at every width. Its primary label, "Check your international setup — free diagnostic", was 453 px in a 647 px column.
- AISO, GEO, LLM and Technical SEO wrapped at 1280 and 1024. Services, Agents and SAOS wrapped at 1024.
- Home and Packages were already fine.

**Change:**
1. **One consistent primary label on every hero:** "Get your free diagnostic →" (270 px). It matches the header CTA ("Get Your Diagnostic") and replaces 8 long, page-specific labels, e.g. "See which pages AI can cite — free diagnostic". The page-specific intent stays in the lede and the secondary button. Pages: services, aiso, geo, llm, techseo, intl, agents, saos (hero only; final CTAs unchanged).
2. **International SEO secondary button:** "Choosing a structure" → "Site structures".
3. **Tablet tightening:** on kit pages and Agents, from 941 to 1180 px, hero CTA gap 14 → 10 px and button side padding 26 → 18 px. This clears the last ~16 px at 1024 px.

**Result:** all 10 pages keep both hero buttons on one line at 1440, 1280 and 1024 px. On phones (single-column layout) the buttons still stack, which is the intended mobile pattern.

**Deploy:** backups `.bak-20260929-173421` (8 page files) and `.bak-20260929-173516` (kit + agents). Live md5s = repo:
- services 70b79d7a…
- aiso cc3b546e…
- geo 25f6ef69…
- llm b1168684…
- techseo d1598d28…
- intl b880ef98…
- saos e5888c87…
- agents 9acca64f…
- kit 5736eca8…

---

## D-048 — International SEO page built on `.online` (page 100, published)
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "…then go straight on to International SEO")

`/services/international-seo/` is a D-023 new slug with no production equivalent, so nothing needs preserving.
- New file `wp/novamira-sandbox/reinforce-intl.php` provides `[reinforce_intl]` and is built on the shared kit.
- Page **100** was set to the shortcode and published; the publish was guarded (page empty, parent 68, `blog_public=0`).
- Yoast title: "International SEO Services | Reinforce Lab".
- Meta: "International SEO from Reinforce Lab: site structure, hreflang, native localization and market-by-market reporting — built on Google's own guidance."

**Research (Exa `agent_run_e14d64d08f804c7eb7a6d288dbb01d2b`)** is saved in `claude/research/international-seo-research-2026-09-29.md`.
- **Competitors:** 8 (SEOCOM, Progression, ThrillSEO, Pinnacli, LASEO, SEOCUTTS, ForzaSEO, SUSO). They rarely cite Google, and none separates documented Search behaviour from unverified AI-assistant behaviour.
- **VERIFIED (Google):**
  - 4 URL structures with Google's pros and cons (parameters "not recommended");
  - hreflang rules: 3 methods, reciprocal links, ISO 639-1 + ISO 3166-1 Alpha 2 codes, x-default;
  - Google ignores `lang` attributes and the URL for language detection;
  - avoid automatic locale redirects; Googlebot "usually originates from the USA";
  - Search Console International Targeting is deprecated and country targeting is no longer supported;
  - scaled content abuse includes low-value automated translation;
  - same-language regional versions: use canonical + hreflang.
- **UNVERIFIED and not claimed:** how ChatGPT, Perplexity or Gemini choose a regional version.

**Structure:**
- Hero, with a 3-line H1: "Reach every market / in its own / language."
- "Country domains, subdomains or subdirectories?" — Google's comparison table, plus our labelled default: subdirectories for most B2B sites.
- "How does hreflang work?" — 4 rules plus an HTML example block.
- "Which international SEO beliefs are wrong?" — 5 myth vs "Google says" pairs with sources.
- 9 workstreams, a 5-step market-by-market process, 8 deliverables and 6 measures (including "right version served" and AI answers per language).
- Honesty panel: "Translation isn't localization — and hreflang doesn't steer AI".
- **8 industry cards** with international points (D-047 pattern) and 6 related services (links to `/services/technical-seo-services/`).
- 6 FAQs and the final CTA.

**Schema:** `Service` plus `FAQPage`; Yoast adds the breadcrumb.

**Hero animation "Market routing" (D-039 Step 3):**
1. A slowly turning globe (meridians on a 12 s cycle) sits between 4 versions: EN · x-default `/`, DE `/de/`, FR-CA `/fr-ca/`, EN-GB `/uk/`.
2. The hreflang links draw between every pair: 4 ring arcs plus 2 cross links, labelled "hreflang · every version lists every other".
3. A search pulse from the centre is routed to each version, and each gets a "served" marker.
4. "Right language · right market · right page" lights.
5. 10 s loop with a soft fade.
- Preview fixes before deploy: the served marker overlapped "X-DEFAULT", and the label crossed a link line.

**Kit change:** the `.src` and `.myths` / `.myth` styles moved from the Technical SEO page into `reinforce-kit.css`, because two pages now use them.
- The regression test caught a side effect: GEO's research box also uses a `src` class, and its first line gained a 16 px top margin. Fixed with `.rl-geo .research .src:first-child{margin-top:0}`.
- **Final fingerprint: hub, AISO, GEO, LLM and Technical SEO all 0 diffs.** International SEO was added to the tool.

**Bug found and fixed before sign-off:** on mobile the page was **662 px wide at a 390 px viewport**. The hreflang code block (`white-space:pre`) stretched its `1fr` grid track, so the rules list widened with it. Fixed by setting the grid to `minmax(0,1fr)` and `min-width:0` on its children; the code block keeps its own scroll. The page now measures 390 px.

**Deploy and verification:**
- Backups `.bak-20260929-171553` (kit + techseo), `.bak-20260929-171642` (geo) and `.bak-20260929-172140` (intl).
- Live md5s = repo: kit `fde086c3…`, techseo `fbea4750…`, geo `9cada0f5…`, intl `fc6f20af…`.
- HTTP 200, 1 H1 (3 lines), 12 H2, 8 industry cards, kit linked, noindex, no PHP errors, no `#` links. HTML 137.7 KB.
- Reduced motion static; the structure table fits at 1440 px.

---

## D-047 — "Who it's for" = all 8 industries as detail cards (Technical SEO; pattern for every service page)
**Date:** 29 September 2026 · **Status:** DONE on Technical SEO (Jamil: "mention 8 cards as details with 2 to 3 points for each. you are only mentioning 7 industries but we have 8")

**Defect:** the Technical SEO page listed 7 industry chips and omitted **Professional Services**. The locked list has 8 (D-022). AISO, GEO and LLM show 6 chips each, the same kind of gap.

**Change:**
- The chip row was replaced by **8 industry cards**: number, industry name (linked), **3 industry-specific technical SEO points**, and "Explore →" (aria-label "Technical SEO for <industry>").
- Order follows the locked list: Pharmaceutical & Life Sciences · Healthcare · B2B SaaS · E-commerce · Manufacturing · Technology · Professional Services · Education.
- Data lives in `rl_techseo_industries()` (single source).
- The points are service capabilities, not claims or metrics. Examples: faceted-filter URL control (e-commerce), staging never indexed (SaaS), spec-sheet PDFs made indexable (manufacturing), hreflang for multi-campus sites (education).

**Reusable pattern:** the `.inds8` / `.ind` styles were **added to the shared kit** (new classes only). Every future service page uses the same component with its own points.
- Style fingerprint after the kit change: hub, AISO, GEO and LLM show **0 diffs**. Technical SEO changed only by the new section (+58 elements).
- Layout: 4 columns on desktop, 2 on tablet, 1 on mobile.
- Verified: 8 cards; no overflow at 390 px; no PHP errors.

**Deploy:** backups `.bak-20260929-165521` (kit + page) and `.bak-20260929-165611` (link label shortened). Live md5s = repo: kit `a661ea32…`, techseo `ef122431…`.

**Done 29 Sep (Jamil: "give them the same 8 cards next, with points written for each service"):** AISO, GEO and LLM now each show the 8 industry cards. Each has its own service-specific points (24 cards), stored in `rl_aiso_industries()`, `rl_geo_industries()` and `rl_llm_industries()`:
- **AISO** — visibility and accuracy in AI answers (e.g. SaaS: included in "best tool for…" shortlists).
- **GEO** — citable passages (e.g. pharma: sourced mechanism, dosing and trial passages with PubMed / ClinicalTrials.gov citations and MLR review).
- **LLM** — consistent entity facts (e.g. manufacturing: legacy brand and acquisition names mapped to the current company).

The old chip rows were removed.

**Deploy and verification:**
- Backup `.bak-20260929-170944`. Live md5s = repo: aiso `62d3f8c8…`, geo `1a4606fb…`, llm `9f97e7d1…`.
- Each page: 8 cards (Professional Services included), 0 chips, 1 H1, no PHP errors. HTML: AISO 134.8 KB, GEO 135.4 KB, LLM 141.9 KB.
- Style fingerprint: hub and Technical SEO **0 diffs**. The three pages changed only by +60 elements each (the new section).

All five service pages built so far now show the 8 industries.

---

## D-046 — Technical SEO keeps its production URL `/services/technical-seo-services/` (no redirect)
**Date:** 29 September 2026 · **Status:** APPROVED by Jamil ("B, keep the URL and rename the page") · resolves O-016 · **supersedes the D-023 row** "technical-seo-services → 301 /services/technical-seo/"

**Decision:** the rebuilt Technical SEO page launches at the existing production URL `/services/technical-seo-services/`. There is no redirect, so its 16-month indexing history (27,457 impressions on the "technical seo services" query family) stays attached to the same URL. This matches the 10 Sep page-level approval ("APPROVED: PRESERVE — rebuild to D-012 standard"). Register row changed to `APPROVED-PRESERVE` in `claude/data/approved-new-urls-2026-09.csv`. **Production is untouched**; the new content goes live there only at the approved migration.

**Done on `.online`:** one guarded call. It checked that page 99 was the expected page and that no post used the new slug, backed up and md5-checked the 6 files, then wrote them and renamed the slug.
- Page 99 slug `technical-seo` → **`technical-seo-services`**; it is live at https://reinforcelab.online/services/technical-seo-services/.
- Every internal reference was updated (8): footer Solutions list (`reinforce-header.php`); Services hub card and "Organic traffic is falling" router (`reinforce-services.php`); related-service cards on AISO (and its comparison-table fallback link), GEO and LLM; `rl_is_techseo()`; and the style-fingerprint tool.
- Backup suffix `.bak-20260929-165159`. Live md5s = repo:
  - header 7dff6c7e…
  - services 2558166f…
  - aiso ce9794aa…
  - geo 4173ddc8…
  - llm 6309e34f…
  - techseo f1171b19…

**Verified:**
- New URL: HTTP 200, 1 H1, page CSS and kit present, breadcrumb Home › Services › Technical SEO, no PHP errors.
- Hub, AISO, GEO and LLM now link to the new URL (8/7/6/6 occurrences), with 0 old links and 0 `?page_id=99`.
- Style fingerprint across hub/AISO/GEO/LLM: **0 diffs** vs the previous run. Technical SEO was added to the tool (481 elements).

**Finding (F-019) — Yoast Premium auto-creates redirects on slug change.** The old `.online` URL `/services/technical-seo/` now returns **301 → /services/technical-seo-services/** with `x-redirect-by: Yoast SEO Premium`. The redirect manager added this entry automatically.
- On `.online` that is harmless; it was a dev-only URL that nothing links to.
- **For migration:** Yoast's stored redirects on `.online` must be reviewed and **not carried to production blindly**. Every production redirect needs explicit approval (Rule 2). Add this to the launch QA gate.

---

## O-016 — `/services/technical-seo-services/` (production): keep the URL, or 301 it? — RESOLVED → D-046 (Option B)
**Date:** 29 September 2026 · **Status:** RESOLVED 29 Sep — Jamil: "B, keep the URL and rename the page" · **Production untouched** (analysis used repo data only)

Jamil asked how to keep the live .com page's SEO value and eventually rank in the top 5.

**VERIFIED (repo data; GSC export 10 Sep 2026, 16 months, global):**
- Page totals: **2 clicks, 27,457 impressions, avg position 51.5**; 12 internal links in. Crawl sheet: presumed indexed.
- **No external backlinks recorded.** The page is not among the 13 pages in GSC "Top target pages" (the homepage holds ~93 % of external links — F-010). GSC link data is sampled, so the full backlink export (still blocking migration) should confirm.
- Its queries:

| Query | Impressions | Position | Clicks |
|---|---|---|---|
| "technical seo services" | 7,706 | 42.3 | 0 |
| "technical seo service" | 7,132 | 49.8 | 0 |
| "technical seo consultancy" | 2,403 | 77.9 | 0 |
| "technical seo services company" | 1,389 | 32.0 | 0 |

- **Conflict in our own records:**
  - The page-level disposition sheet (10 Sep) marks it **"APPROVED: PRESERVE — rebuild to D-012 standard"**.
  - D-023 (28 Sep) lists it as **301 → `/services/technical-seo/`**.
  - Both cannot stand.

**INFERENCE:** the value to protect is Google's 16-month association of this URL with the "technical seo services" query family (indexing history, impressions). It is not link equity (none recorded) or traffic (≈ 0). A 301 would pass signals, but a URL move usually brings a temporary fluctuation. Keeping the URL carries no risk at all.

**RECOMMENDATION (for approval):** **Option B — keep the production URL** and publish the new Technical SEO page *at* `/services/technical-seo-services/`.
- On `.online`: change page 99's slug from `technical-seo` to `technical-seo-services`, and remove that row from the D-023 redirect map.
- Rationale: it honours the earlier PRESERVE approval, needs no redirect, and keeps the history intact. The "services" slug also mirrors the head query, though URL wording is a minor factor.
- Option A (the 301 per D-023) remains acceptable: low risk, given no backlinks and ≈ 0 clicks.

**Path to top 5 (RECOMMENDATION; no ranking can be guaranteed):**
1. **Fix the domain first** — at migration: junk URLs, 19 % indexation, orphaned pages (F-001/F-003). A strong page on a weak domain stalls.
2. **Page quality** — the new page, plus E-E-A-T: a named expert (Jamil), and real case studies with permission (awaiting Jamil).
3. **Topic cluster** — 8–10 supporting articles, e.g. technical SEO checklist, Core Web Vitals, JavaScript SEO, robots.txt vs noindex, crawl budget, site migration, WordPress technical SEO, AI-crawler access. Rebuild the never-crawled `/what-is-technical-seo-and-why-is-it-important/` (already APPROVED: BUILD fresh). All link to the service page.
4. **Internal links** — from home, the services hub, nav, related services and every cluster post, with descriptive anchors.
5. **External authority** — currently zero to this page. Earn topical links through original research (e.g. an AI-crawler access study), a free technical checker, digital PR, and expert contributions.
6. **Win closer queries first** — "technical seo services company" (pos 32), industry and platform variants (pharma, B2B SaaS, WordPress). Then climb the head term.
7. **Measure** — monthly GSC position per query after launch.

**Needs from Jamil:**
- Choose A or B.
- The live SERP top 10 for "technical seo services" (Semrush) for a gap analysis.
- The backlink export.
- Permission to use the F-001 story and any client results.

---

## D-045 — Technical SEO page built on `.online` (page 99, published) — first page built on the shared kit
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "yes, go ahead with Technical SEO")

`/services/technical-seo/` is a D-023 new slug. At cutover the legacy production URL `/services/technical-seo-services/` (27,457 impressions over 16 months) **301s here, per D-023**. That production redirect stays PENDING until the migration is approved.
- New file `wp/novamira-sandbox/reinforce-techseo.php` provides `[reinforce_techseo]`.
- Page **99** was set to the shortcode and published; the publish was guarded (page empty, parent 68, `blog_public=0`).
- Yoast title: "Technical SEO Services: Crawl, Index & Speed | Reinforce Lab" (60).
- Meta: "Technical SEO from Reinforce Lab: crawlability, indexation, Core Web Vitals, structured data and AI-crawler access — root causes fixed, verified and safe for what already ranks."
- **Built on the shared kit (D-044) from the start:** wrapper `rl-page rl-tseo` plus the `rl_kit_active` opt-in, with page-only CSS. The page is 140 KB with 12 sections; before the kit, an equivalent page would have been about 150 KB. It has been added to `claude/tools/style-fingerprint.mjs`.

**Research (Exa, `agent_run_5c3bdd098b284e65ac680f4905256b0d`)** is saved in `claude/research/technical-seo-research-2026-09-29.md`.
- **Competitors:** Vezadigital, Percepture, RankZero, FactoryJet, Foundgrove, Seer Interactive, Omega Function. Most are audit-led, with little post-fix verification and no "protect what ranks" promise.
- **VERIFIED from Google / web.dev:**
  - CWV thresholds: LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1, measured at p75; INP replaced FID on 12 Mar 2024;
  - Search's 3 stages (crawling, indexing, serving);
  - JS processing (crawl → render → index) and "not all bots can run JavaScript";
  - rel=canonical is a strong signal, not a command;
  - robots.txt blocks crawling, not indexing;
  - sitemaps don't guarantee indexing;
  - hreflang must be reciprocal;
  - crawl-budget thresholds (1M+ pages, or 10k+ pages changing daily);
  - structured data must represent the page.
- **Flagged:** no AI vendor documents JS rendering. Vercel's study is cited only as a study, not stated as fact.

**Structure:**
- Hero, with a 3-line H1: "Fix what stops / search engines / and AI crawlers."
- "Where can a page get stuck?" — crawl / render / index / serve, with what breaks at each, linked to Google sources.
- "What does a technical SEO review cover?" — 9 areas, including AI access and hreflang.
- "What are the Core Web Vitals thresholds?" — table with web.dev sources.
- **"Which technical SEO beliefs are wrong?"** — 5 myth vs "Google says" pairs, each linked to the Google doc (differentiator).
- A 5-step process ending in a verification crawl, and 8 deliverables (including a URL inventory, redirect map and developer-ready tickets).
- 6 measures (crawl waste, CWV pass rate…).
- **"We don't break what already ranks"** panel — the PRESERVE methodology, made public.
- "Who it's for" and "Related services" (incl. the Search Performance Agent) as separate sections.
- 6 FAQs and the final CTA.

**Schema:** `Service` plus `FAQPage`; Yoast adds the breadcrumb.

**Hero animation "Crawl, fix, index" (D-039 Step 3), 10 s loop:**
1. A crawler maps HOME → 3 sections → 6 pages.
2. Three faults surface: /POST-A **404**, /SAAS **SLOW**, and /GUIDE **ORPHAN** (dashed, unlinked).
3. The phase label reads "Fixing root causes…". The 404 becomes "200 OK", SLOW becomes "FAST", and a new internal link draws to /GUIDE, which becomes "LINKED".
4. Every page gets an indexed marker, and crawlable · renderable · indexable · fast light up.
5. Soft fade and reset.
- Preview fix: two child nodes overlapped by ~5 px; they were re-spaced before deploy.

**Deliberately NOT used (needs Jamil):** our own DISCOVER findings as a case study — e.g. the Beaver Builder pagination defect (F-001) that created junk `/paged-N/` URLs on reinforcelab.com. It is strong, real proof of root-cause work, but it discloses production's state, so Jamil decides.

**Deploy and verification:**
- Created new; live md5 `31feaeef…` = repo.
- HTTP 200, 1 H1 (3 lines), 12 H2, kit linked, noindex, no PHP errors, no `#` links, 9 Google / web.dev source links.
- No overflow at 1440/390; the CWV table fits without scrolling; reduced motion static.

---

## D-044 — Shared CSS kit: duplicated page CSS merged into one cached file
**Date:** 29 September 2026 · **Status:** DONE (Jamil: "yes, do the CSS merge first")

**Problem:** every page file inlined its own full copy of the layout CSS, so ~9.5 KB was identical across AISO, GEO and LLM (and ~4.7 KB also in the Services hub). The LLM page reached 147.5 KB, near the 150 KB budget (D-012 §2), and each new service page would repeat the same CSS again.

**What changed:**
- **`reinforce-kit.css` (new, 9.8 KB):** the 98 rule blocks that were **byte-identical** on all three service pages, re-scoped to `.rl-page`. It was generated by a parser, not rewritten by hand.
  - Served as a static file from the sandbox directory (its `.htaccess` allows `.css`), as `text/css` with `Cache-Control: public, max-age=604800`.
  - Versioned by content hash (`?ver=b96d827a`), so a redeploy busts the cache.
- **`reinforce-kit.php` (new):** prints the kit `<link>` only when a page opts in through the `rl_kit_active` filter.
  - It prints at **wp_head priority 21**: after the header's inline CSS (20) and before each page's own CSS (22).
  - This matters. A first version used `wp_enqueue_style`, which prints at priority 8. The header rule `.fl-page-content a{color:var(--red-3)}` then beat the kit's `a{color:inherit}`, and **links turned red** (breadcrumbs and hero tiles; colour only). The regression test caught it and priority 21 fixed it.
- **Pages now on the kit:** `/services/`, AISO, GEO and LLM.
  - Each wrapper gains the `rl-page` class and each file adds the opt-in filter.
  - Duplicated rules were removed: 98 each from AISO, GEO and LLM; 50 from the hub.
  - Page-specific CSS (hero animations, router, tables, etc.) stays in each file.
- **Not migrated:** Home, SAOS, Diagnostic, Packages and Agents. They predate the service template and use different class sets; they are untouched and do not load the kit (verified).
- **Future pages** (Technical SEO, industries, agents…) use the kit from the start: add `rl-page` to the wrapper, call the opt-in filter, and write only page-specific CSS.

**Verification — visual-regression test** (`claude/tools/style-fingerprint.mjs`):
- **What it checks:** the computed style and box of every element in each page wrapper — 1,606 elements across 4 pages × 2 widths.
- **Making it reliable:**
  - The naive runs were unusable: the flaky proxy randomly drops theme CSS and fonts, so two identical loads differed by 2,854 properties. This is also what caused the earlier "shifted left" screenshots.
  - The tool now caches and replays static assets. Two baseline runs then gave **0 diffs**.
- **Results:**
  - First deploy: 264 diffs, all link-colour (the priority issue above).
  - After the fix: **TOTAL 0 differences**. The pages look exactly as before.

**Result (HTML per page, before → after):**

| Page | Before | After |
|---|---|---|
| Services | 145.1 KB | 140.9 KB |
| AISO | 140.2 KB | 131.1 KB |
| GEO | 141.2 KB | 132.0 KB |
| LLM | 147.5 KB | 138.3 KB |

The kit is downloaded once and cached across pages. All four pages: HTTP 200, 1 H1, no PHP errors.

**Deploy:** one guarded call. The new files were required not to exist; the 4 updated files were md5-checked and backed up with suffix `.bak-20260929-163248`. The kit loader was then updated (backup `.bak-20260929-163338`). Live md5s = repo:
- `reinforce-kit.css` b96d827a…
- `reinforce-kit.php` b3ef22c0…
- `reinforce-services.php` 409e3b19…
- `reinforce-aiso.php` 60f78b6a…
- `reinforce-geo.php` 081aea06…
- `reinforce-llm.php` 3aef9950…

**Next weight savings found (RECOMMENDATION, not done):** in the remaining ~131–141 KB per page:
- WordPress `global-styles` inline CSS ≈ 17.9 KB. This is block-theme CSS, likely unused by bb-theme and Beaver Builder; check before dequeuing.
- The header's inline CSS ≈ 14.9 KB. It is the same on every page, so the same cached-file technique applies.
- `wp-block-library` ≈ 4.3 KB.
- Inline scripts ≈ 12.8 KB (e.g. emoji).

These are site-wide changes and need their own approval.

---

## D-043 — LLM Optimization page built on `.online` (page 101, published)
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "yes, go ahead with LLM Optimization and for you use exa ai when deep research required")

`/services/llm-optimization/` — a new slug from D-023, scaffolded 28 Sep; not a production URL. New sandbox file `wp/novamira-sandbox/reinforce-llm.php` provides `[reinforce_llm]`. Page **101** was set to the shortcode and **published**; the publish was guarded (page empty, parent 68, `blog_public=0`).
- Yoast title: "LLM Optimization Services | Reinforce Lab".
- Meta: "LLM Optimization from Reinforce Lab: make ChatGPT, Claude, Gemini and Perplexity describe your brand correctly — consistent facts, the right AI-crawler policy, tested answers."

**Working rule (Jamil):** use **Exa AI** (agent_run) for deep research. The first run was `agent_run_4142235cd7904b8d964846322dcf2433`. Findings are saved in `claude/research/llm-optimization-research-2026-09-29.md`.
- **Competitors:** 7 LLM-optimization pages (Proven ROI, UPLIFY, Zebora, Lureon, XLR8 AI, indexLLM.me, PrometixAI). Common gaps: measurement ambiguity, and no separation of training crawlers vs search crawlers.
- **Primary-source facts VERIFIED:**
  - llms.txt (Jeremy Howard, 3 Sep 2024; a proposal only);
  - crawler purposes documented by OpenAI (GPTBot / OAI-SearchBot / ChatGPT-User), Anthropic (ClaudeBot / Claude-SearchBot / Claude-User) and Perplexity (PerplexityBot / Perplexity-User);
  - Google-Extended does not affect Search inclusion or ranking;
  - models have a training cutoff plus live retrieval (OpenAI help, Anthropic model docs, Google grounding docs).
- **UNVERIFIED and deliberately not claimed:** that Wikidata is required by, or directly boosts, LLMs.

**Positioning in the trio:** AISO = the program. GEO = pages and passages. **LLM Optimization = the brand as an entity** — how models describe you, and why they get it wrong.

**Structure:**
- Hero, with a 3-line H1: "Make AI describe / your brand / correctly."
- "How does an AI model know about your brand?" — 2 routes (training memory vs live lookup), each with its fix, quoting OpenAI and Google.
- **"Which AI crawlers should you allow?"** — a 9-row table of company, user agent, purpose and a source link, dated "checked 29 September 2026". This is the page's differentiator.
- "Why do AI models get brands wrong?" — 6 causes, including name confusion (cf. F-018).
- 5-step process, 8 deliverables and 5 measures.
- Honesty panel: "Nobody can edit an AI model for you".
- "Who it's for" and "Related services" as separate sections.
- 6 FAQs and the final CTA.

**Schema:** `Service` plus `FAQPage`; Yoast adds the breadcrumb.

**Hero animation "Entity alignment" (D-039 Step 3), 10 s loop:**
1. Six sources describing the brand (website, schema, profiles, directories, reviews, press) start scattered and inconsistent (≠).
2. One by one they glide into place, connect to "Your brand · one entity" and turn consistent (=).
3. The entity glows and a pulse reaches the "Model answer" panel ("Who is your brand?"), whose lines write in.
4. "Consistent · correct · current" lights.
5. The nodes glide back to scattered and the loop resets.

**Deploy and verification:**
- Created new; live md5 `1066b5a4…` = repo.
- HTTP 200, 1 H1 (3 lines), 11 H2, noindex, no PHP errors, no `#` links; 9 crawler rows.
- No overflow at 1440/390 (table scrolls inside its own box on mobile); reduced motion static.
- HTML 147.5 KB — **close to the 150 KB budget (§2)**. The duplicated per-page CSS is the main weight, which strengthens the case for the CSS consolidation item.

**Open for Jamil:** our **own** AI-crawler policy for reinforcelab.com and .online (what to allow or block per crawler). The page now explains the trade-off; the site itself has not chosen.

---

## D-042 — GEO page built on `.online` (page 73, published)
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "yes, go ahead with GEO")

`/services/generative-engine-optimization/` — **APPROVED — NEW URL (D-006)**. New sandbox file `wp/novamira-sandbox/reinforce-geo.php` provides `[reinforce_geo]`. Page **73** was set to the shortcode and **published**; the publish was guarded (page empty, parent 68, `blog_public=0`).
- Yoast title: "GEO Services: Generative Engine Optimization | Reinforce Lab" (60).
- Meta: "Generative Engine Optimization from Reinforce Lab: pages structured, sourced and written so ChatGPT, Perplexity, Gemini and AI Overviews can quote and cite them."
- The shared layout CSS was copied from the AISO page (scoped `.rl-geo`); CSS consolidation is still an open item.

**Positioning vs AISO (no duplication):** AISO is the umbrella program (access, entity, authority, measurement). GEO is the **content / passage layer**: how engines choose what to cite, and how pages are written to be extracted and cited. The two pages cross-link, and each FAQ explains the difference.

**External facts used (VERIFIED at source, 29 Sep):**
1. **GEO paper:** Aggarwal et al., "GEO: Generative Engine Optimization", ACM SIGKDD 2024 (Princeton University, IIT Delhi), arXiv 2311.09735. The abstract states GEO "can boost visibility by up to 40% in generative engine responses" and that efficacy "varies across domains". The page cites it with a link.
   - The line "citations, quotations and statistics among the strongest methods; keyword stuffing was not" reflects the paper's method comparison (INFERENCE from the paper body; not in the abstract). **Jamil may want to re-check this wording.**
2. **Query fan-out:** Google's own blog (blog.google, "Expanding AI Overviews and introducing AI Mode", Mar 2025) says AI Mode "uses a 'query fan-out' technique, issuing multiple related searches concurrently…".

No Reinforce Lab metrics or results are claimed.

**Structure:**
- Hero, with a 3-line H1: "Write pages / AI engines / quote and cite."
- "How do generative engines choose what to cite?" — 4 steps (fan-out, retrieve, extract, cite) plus the research box.
- "What does a citable passage look like?" — before/after example.
- "What makes a page worth citing?" — 6-point checklist.
- "How does a GEO engagement run?" — 5 steps.
- "What you get" — 8 deliverables.
- "How do we measure GEO?" — 5 measures.
- "We don't game AI engines" — no hidden text, no planted instructions, no fake reviews, no mass pages.
- "Who is GEO for?" and "What works with GEO?" as **two separate sections**, per Jamil's AISO revision.
- 6 FAQs and the final CTA.

**Schema:** `Service` (alternateName GEO) plus `FAQPage`; Yoast adds the breadcrumb (Home › Services › Generative Engine Optimization).

**Hero animation "Fan-out to citation" (D-039 Step 3), 10 s loop:**
1. A buyer question fans out into 3 related searches.
2. Retrieval pulses reach "Your page".
3. Three passages are highlighted, lift across into the generated answer and are each cited [1].
4. "Retrieved · extracted · cited" lights.
5. Soft fade and reset.

**Deploy and verification:**
- Created new; live md5 `6f74b4e8…` = repo.
- HTTP 200, 1 H1 (3 lines), 11 H2, noindex, no PHP errors, no `#` links. HTML 141 KB (under budget).
- No overflow at 1440/390; reduced motion static.

---

## D-041 — AI Search Optimization page built on `.online` (page 72, published)
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "yes, go ahead with AI Search Optimization")

`/services/ai-search-optimization/` — **APPROVED — NEW URL (D-006)**, not a production URL. New sandbox file `wp/novamira-sandbox/reinforce-aiso.php` provides `[reinforce_aiso]`; page **72** set to the shortcode and **published** (guarded: page empty, parent 68, `blog_public=0`). Yoast title "AI Search Optimization Services (AISO) | Reinforce Lab" (54); meta "Get your brand found, cited and described accurately in ChatGPT, Perplexity, Gemini and Google AI Overviews — AI Search Optimization from Reinforce Lab."

**Competitor check (Exa, 29 Sep; VERIFIED on their pages):** Cite Solutions, Arobis AI, rank.ai, AEORanks, optimizeaisearch.com, pmax, Search Edge. The common standard is:
- an answer-first definition;
- a prompt set built from real buyer questions;
- a baseline per engine against named competitors;
- AI-crawler access (robots.txt, llms.txt, server-rendered pages);
- entity and schema work;
- third-party authority;
- metrics such as mention rate, citation rate and share of voice;
- an honest "no guarantees".

**Where we go further (INFERENCE):**
- a **description-accuracy** measure (does the AI describe you correctly?);
- **evidence verification** — claims tied to sources and human-reviewed, which suits regulated industries;
- a single **comparison table of SEO vs AISO vs GEO vs LLM Optimization**, linked to each service.

**No borrowed statistics:** competitor figures such as "citation half-life", "73 % of sites" and "4–6 weeks" were not reused, because none of them are our data.

**Structure** (content follows the D-012 standard: answer-first, question-shaped H2s):
- hero, with a 3-line H1: "Be found in Google. / Be named in / AI answers.";
- "What is AI Search Optimization — and how is it different?", with the comparison table;
- "Why do brands disappear from AI answers?" — 6 causes, each with its fix;
- "How does AI Search Optimization work?" — 5-step loop;
- "What you get" — 8 deliverables;
- "How do we measure AI visibility?" — 5 measures;
- "No one can guarantee what an AI will say" (honesty panel);
- "Built for" 6 industries and "Works with" 6 services plus the AEO/GEO Agent;
- 6 FAQs and the final CTA.

**Schema:** `Service` (alternateName AISO, provider → Organization, areaServed Worldwide) plus `FAQPage`. Yoast adds WebPage and BreadcrumbList (Home › Services › AI Search Optimization). HTML is 138 KB, under the §2 budget.

**Hero animation "Cited answer" (D-039 Step 3), 10 s loop:**
1. A buyer's prompt types in.
2. An AI answer writes itself, with citation markers.
3. Three sources appear. Source [1] "Your brand" lights, and a pulse links the marker to the source card.
4. The checks tick: crawlable · structured · verified.
5. The three measures light: mentioned · cited · described accurately.
6. Soft fade and reset.

Engine tabs (ChatGPT · Perplexity · Gemini · AI Overviews) step every 10 s on a 40 s cycle. The engine names match the already-published A-04 agent copy.

**Open (facts, not invented):** exact engines monitored and prompts per tier remain on Jamil's facts list (competitor analysis §5). The page names only the four engines already published and gives no counts. The **AI-crawler policy** (GPTBot/ClaudeBot/PerplexityBot/Google-Extended) is still a decision for Jamil (standard §4). The page promises to "agree your crawler policy" with clients; it does not state our own.

**Deploy and verification:**
- Created new (no prior file); live md5 `7fd15aa4…` = repo.
- HTTP 200, 1 H1 (3 lines), noindex, no PHP errors.
- No `#` links: unbuilt pages (e.g. Digital PR) render as plain chips.
- No overflow at 1440/390; reduced motion static.
- Preview fixes before deploy: the typed prompt was clipped, and the "Prompt" label crowded the tabs.

**Revision (29 Sep, Jamil: "make two different section for these on this landing page"):** the combined "Built for / Works with" chip block was split into two sections.
1. **"Who is AI Search Optimization for?"** — band section with a one-line qualifier and the 6 industry chips.
2. **"What works with AI Search Optimization?"** — 6 cards, each with a role tag, name, one-line description and link: GEO (passage level), LLM Optimization (entity level), Technical SEO (foundation), SEO Content Systems (content), SEO & AI Search Audit (starting point), AEO/GEO Optimization Agent (always on).

Digital PR was dropped from this list because it has no page yet; it is still covered in the "Authority" cause and step 05. The FAQ became a band section so backgrounds alternate. Backup `reinforce-aiso.php.bak-20260929-152727`; live md5 `53533432…` = repo. Verified: 1 H1, 10 H2, no PHP errors, no horizontal scroll after anchor clicks.

---

## D-040 — `/services/` hub built on `.online` (page 68, published)
**Date:** 29 September 2026 · **Status:** BUILT (Jamil: "yes, go ahead with the Services hub")

New sandbox file `wp/novamira-sandbox/reinforce-services.php` provides `[reinforce_services]`; page **68** (`/services/`) content set to the shortcode and **published** (site still `blog_public=0` / noindex, checked in the same call). Yoast title "Services: AI Search, SEO & Automation | Reinforce Lab"; meta "Reinforce Lab services: AI search optimization, GEO, SEO, content systems, marketing automation and AI consulting — built to work as one AI Growth System."

**Competitor check (Exa, 29 Sep; VERIFIED on their pages):** SCALZ.AI `/services/`, Fuel Online, Smarketa, ReachLLM, Loganix and AEO Engine list services by category (core AI search services vs supporting SEO/web), name the AI engines, and explain the process. **None routes a visitor by the problem they have** (INFERENCE) — that is the hub's differentiator here.

**Structure:** breadcrumb → hero (3-line H1 "Every service. / One connected / growth system.", definition-style lede for AEO) → **"Start with the problem"** router (8 problems → the service that solves each) → **All services** in 4 groups from the D-023/D-024 IA (Search Engine Optimization 6 · AI Search & Content 5 · Automation & Growth 3 · Advisory & Web 4 = 18 services) → **Three ways in** (AI Growth Systems umbrella · Search Authority OS · Agents) → the locked 9-stage method (Discover → Monitor) → 8 industries → 6 FAQs → final CTA. Schema: `ItemList` of 18 `Service` items (provider = Organization) + `FAQPage`; Yoast supplies WebPage + BreadcrumbList. Pricing line reuses the approved "from $5,000 setup"; no invented metrics.

**Hero animation "Capability grid" (D-039 Step 3):** the 4 groups light tile by tile, each group sends a pulse into its segment of the "AI Growth System" core, the core glows, then an output pulse lights "One system · measured on business impact". 10 s loop, soft fade and reset; reduced motion static; tiles are real links where the page exists.

**Links:** services not yet scaffolded on `.online` (core SEO pillar, Digital PR, the 3 web pages — "KEEP-EXISTING", per D-023/D-024) render as **unlinked** cards/tiles, never `#`. Draft service pages link as `?page_id=` until each is published (same as the nav). ItemList `url` is only set where a page exists.

**Fix during build:** the problem router squeezed long service names beside the problem text; changed to problem-above-links. Deploy backups: `reinforce-services.php.bak-20260929-150630`. Live md5 `576b11a8…` = repo. Verified: HTTP 200, 1 H1 (3 lines at 1440), noindex, no PHP errors, schema present (ItemList 18, FAQPage 6), no overflow at 1440/390, reduced motion static.

**Production note:** `/services/` is a KEEP URL on production (pos 4.2). This build changes `.online` only; any production title/content change stays **PENDING — NO CHANGE AUTHORIZED** until approved at migration.

---

## D-039 — Hero system + per-page hero animations; competitor-driven content upgrade (APPROVED)
**Date:** 29 September 2026 · **Status:** APPROVED by Jamil — executing one page at a time

Based on `claude/research/competitor-and-hero-analysis-2026-09-29.md`. Jamil approved all three steps: **Step 1** fix Packages alignment, remove the Agents hero chips, build a shared animation system + a unique hero animation for the 5 live pages (Home and SAOS currently share the same engine visual — must differ); **Step 2** upgrade live-page content with what competitors publish and we don't (needs Jamil's facts — never invented); **Step 3** every new page ships with its own hero animation. Rules: one hero pattern (copy left, visual right; visual below CTAs on mobile); SVG + CSS only, transform/opacity, `prefers-reduced-motion` = static, paused off-screen, no layout shift, aria-described; excluded: legal, About, Blog, Contact.

**Progress:**
- ✅ **1/5 — Shared animation system + SAOS "Authority loop" (29 Sep).** `reinforce-header.php`: `.rl-anim` wrapper CSS (pause class, reduced-motion = static) + IntersectionObserver that pauses hero animations off-screen (live md5 `1aaef308…`). `reinforce-saos.php`: engine diagram (shared with Home) **replaced** by the Authority loop — 5-node ring Research → Verify → Write → Audit → Monitor, a pulse travels the ring (10 s lap), each stage lights as it passes, the "authority" step-line rises each lap; inline SVG ~3.4 KB, `role="img"` + aria-label; mobile hides sub-labels and enlarges stage labels (live md5 `93c7330b…` = repo). Verified: animates (frames at 0 / 2.6 / 5.2 s), reduced motion → `animation: none`, no horizontal overflow 1440/390, no new JS errors. Deploy note: large payloads now go through `novamira run … --input @file` (command-line limit hit once; nothing was written that time).
- ✅ **2/5 — Packages: left-aligned hero + "Compounding staircase" (29 Sep).** Hero converted from the centred mock-up layout to the site pattern (copy left, visual right; stacked on mobile). Visual: Foundation → Growth OS → Enterprise blocks rise in sequence (Growth OS highlighted, capability rows = more included per tier, "$5k / $10k / $20k+ setup"), then a compounding curve draws across them to "Authority compounds"; 9 s loop; ~3 KB SVG; aria-label describes it. Live md5 `980223e3…` = repo. Verified: animates, reduced motion static, no overflow 1440/390; mobile labels resized to avoid collision.
  - **Rev 2 (Jamil: "sleek… always look professional"):** redrawn as a refined analytics chart — slim bars with gradient fills + hairline segments + hairline top edge (Growth OS in red), smooth Catmull-Rom curve 1.6px with gradient stroke and soft area fill, square markers where the curve meets each tier, pulsing "Authority" head. Motion changed from a 9 s reset loop to a **one-time build** (bars grow in sequence → curve draws → markers pop, ~2.5 s) then **subtle ambient motion only** (light shimmer travelling up the curve, head pulse). Reduced motion = final state. ~4.5 KB SVG. Live md5 `2a90fda4…` = repo. Rule for all future hero animations: **refined, professional; loops are fine but the reset must be a smooth glide-out, never a flash.**
  - **Rev 3 (Jamil: "reset… i want it"):** chart loops again on a 10 s cycle — build (bars → curve → markers, 0–30%) → hold with shimmer + head pulse → smooth fade-out (86–94%) → rebuild. Verified via the browser animation clock (drawn → faded at 9.9 s → redrawing at 11.4 s). Live md5 `cc827ece…` = repo.
- ✅ **3/5 — Agents: chips removed + "Agent pipeline" (29 Sep).** Hero now two-column (copy left, visual right). The A-01…A-08 chips are **deleted**; the agents live inside the visual instead — 4 stage columns (01 Understand: A-01/02/05/06 · 02 Verify: A-03 · 03 Optimize & QA: A-04/07 · 04 Measure & heal: A-08) joined by hairline curves; on an 8 s loop each stage lights in turn with pulses flowing to the next, then a pulse runs the dashed "Performance feeds the next lap" return path. **Every agent node is a real link** (SVG `<a>` with aria-label, hover/focus states) to its agent page; SVG has `<title>`. Mobile shows agent IDs only (names in the grid below). Live md5 `fa2a9565…` = repo. Verified: stage frames, reduced motion static, no overflow 1440/390.
- ↩️ **4/5 (REVERTED 29 Sep) — Diagnostic: "7-layer scan" (29 Sep).** Form stays right; a slim scan panel sits at the top of the form card (above "Request your diagnostic"). On a 10 s loop a red scan line sweeps the seven intelligence layers (01 Organic … 07 Technical, matching the "Seven intelligence layers" section); each bar fills as the line passes and the matching segment of a 7-part ring lights; when the ring completes, the centre "?" resolves ('your score' — the unknown the diagnostic answers) with a soft halo; hold, then a smooth fade and reset. **Bar lengths are illustrative only — no numbers or scores are shown** (never invent metrics). Per-row keyframes generated in PHP (`rl_diag_scan_css()`), transform/opacity only; `role="img"` + aria-label. Deployed with backup `reinforce-diagnostic.php.bak-20260929-122333`; live md5 `25b87ac2…` = repo. Verified: frames, reduced motion static, no overflow 1440/390, 1 H1, noindex intact, no PHP errors. Trade-off: the form card is ~150 px taller, so the hero copy centres slightly lower.
  - **Reverted by Jamil (29 Sep): "Revert the search-authority-diagnostic to previous design no animations."** The pre-D-039 file was restored from git (commit before d548229) and redeployed through the guarded deploy (backup of the animated version: `reinforce-diagnostic.php.bak-20260929-123659`). Live md5 `5be3acc8…` = repo (the original D-036 build). Verified: HTTP 200, no scan markup, 1 H1, form present, no PHP errors. **Decision: the Diagnostic page is excluded from the hero-animation rule** (alongside legal, About, Blog and Contact); its hero stays copy + form only. D-039 now has 4 items: SAOS, Packages, Agents done; Home remaining.
  - **Diagnostic H1 set to 3 lines (29 Sep, Jamil: "make three line … all the pages have 3 line").** The H1 wrapped to 2 lines on wide screens. Explicit breaks now match the SAOS pattern: "Find out what's / limiting your / search authority." Text unchanged. Deployed with backup `.bak-20260929-123954`; live md5 `dc19a78a…` = repo. Verified 3 lines at 1920, 1440 and 390 px. At 1024 px the narrow two-column hero wraps the red line to 4 lines total.
- ✅ **Home: "Growth engine" (29 Sep).** Replaces the old HTML nodes + flow-line diagram, which was the same kind of visual as the SAOS hero. Now an SVG engine: 5 inputs (same labels as before) → "AI Growth System" core → 5 outcomes, joined by hairline curves, plus a dashed return path "Outcomes feed the next cycle". **10 s loop:** inputs light in turn and pulse into the core (0–2 s); the core glows and runs its 5 stages, with segments filling and the stage name cross-fading Research → Verify → Build → Automate → Monitor (2–6 s); pulses flow out and the outcomes light in turn (6–7.6 s); a return pulse runs the feedback path (7.8–9 s); soft fade 9.2–9.7 s, then reset. SVG has `<title>` with the full text; keyframes generated per element in PHP (`rl_home_ge_kf()`); the old `.diagram/.col/.node/.flow` CSS was removed (`.engine`/`.core` kept for the SAOS teaser section). Deployed with backup `reinforce-home.php.bak-20260929-144021`; live md5 `2f307508…` = repo. Verified: animates, reduced motion static, no overflow 1440/390, 1 H1, FAQPage schema intact, noindex, no PHP errors. **D-039 Step 1 complete:** SAOS, Packages, Agents and Home each have their own hero animation; Diagnostic is excluded by decision.
- ✅ **SAOS loop polished to the refined standard (29 Sep, Jamil approved).** CSS only; markup and timing unchanged (10 s lap, node every 2 s). Comet tail 2 → 1.4 px with round caps and a white head with a softer glow. Lit nodes use a lighter fill (.22) and a 1 px red-2 stroke; halos now expand (scale .85 → 1.25) and fade instead of flashing. Node and label lights use eased timing (cubic-bezier) instead of linear. Core border softened to red-line. Authority step-line 2 → 1.5 px with round joins; it draws 0–80 %, holds, **fades out 90–97 % and resets while invisible** (previously it snapped back at the end of each lap). Deployed with backup `reinforce-saos.php.bak-20260929-145231`; live md5 `6b7d1417…` = repo. Verified: frames, reduced motion static, no overflow 1440/390, 1 H1, noindex, no PHP errors.

---

## D-038 — Agents hub `/services/agents/` (page 76) — BUILT & LIVE on `.online`
**Date:** 29 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified · Approved by Jamil ("yes, go ahead with the Agents page")

No mock-up existed — styled after the SAOS page; content from the strategy doc ("8 Agent Selling Pages … each page should sell one specific business outcome, not technology"). Sandbox file `reinforce-agents.php` (repo = live, md5 `bcb6014c…`), shortcode `[reinforce_agents]`; page 76 content set and **published**.
- **Sections:** breadcrumb (Home / Services / Agents) → hero (answer-first: "Search Authority OS agents are eight specialised AI agents from Reinforce Lab…", jump chips A-01…A-08) → 8 outcome-led agent cards (outcome line, 3 capabilities, "Best for", link to each agent page) → "Four stages. One loop." agent map (Understand A-01/02/05/06 · Verify A-03 · Optimize & QA A-04/07 · Measure & heal A-08) → single agent vs full OS (→ diagnostic / packages) → FAQ (5) → final CTA.
- **Not duplicated from SAOS:** SAOS keeps its one-line agent cards; the hub adds capabilities, best-for and the stage map. No agent prices invented ("scoped after the diagnostic").
- **Yoast:** title `AI SEO Agents for Search & AI Visibility | Reinforce Lab` (56), meta (153).
- **Schema:** Yoast WebPage + BreadcrumbList (Home > Services > Agents) + Organization, plus **ItemList (8 agent pages)** + **FAQPage (5)**.
- **Verified live:** HTTP 200 · 1 H1 · noindex · no PHP errors · no horizontal overflow at 1440/390.
- **Known:** parent `/services/` (page 68) is still an **empty draft** → breadcrumb "Services" link is dead for visitors until the Services hub is built; the 8 individual agent pages (77–84) are empty drafts (links render as `?page_id=`).

---

## D-037 — Packages & Pricing page `/packages/` (page 66) — BUILT & LIVE on `.online`
**Date:** 29 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified · Approved by Jamil (build order 29 Sep)

Built from `claude/design-previews/packages.html` as sandbox file `reinforce-packages.php` (repo = live, md5 `9163be2c…`), shortcode `[reinforce_packages]`; page 66 content set and **published**. Pricing page only — **no cart / self-checkout** (D-017 packages decision).
- **Sections:** breadcrumb → hero (answer-first: "Search Authority OS comes in three packages…", links SAOS) → 3 plans (Foundation $5,000 + $1,500–$2,500/mo · Growth OS $10,000 + $3,500–$5,000/mo · Enterprise $20k–$35k+ + $7,500–$15,000+/mo; full feature lists) → compare matrix (12 rows) → à la carte agents (A-01/03/04/08 linked + "See all 8 agents" → `/services/agents/`) → how it works (4) → FAQ (5) → final CTA → Diagnostic. All plan CTAs → `/search-authority-diagnostic/`.
- **Fixes vs mock-up:** "before you spend a **rupee**" → "before you commit to a retainer" (pricing is USD); H1→H3 jump fixed with a screen-reader H2; matrix row labels `<th scope=row>` + caption + "Included/Not included" text for ✓/—; dead `#` links wired; mobile overflow (absolute `.sr` labels escaping the table scroller → `.mx-scroll{position:relative}`).
- **Yoast:** title `Search Authority OS Packages & Pricing | Reinforce Lab` (54), meta (151).
- **Schema:** Yoast WebPage + BreadcrumbList (Home > Packages) + Organization, plus **Service "Search Authority OS" with OfferCatalog** (3 Offers, USD PriceSpecification: 5000 / 10000 / min 20000 — setup fee; retainer in description) + **FAQPage (5)**.
- **Verified live:** HTTP 200 · 1 H1 · noindex · no PHP errors · no horizontal overflow at 1440/390.
- **Confirm (Jamil):** FAQ "Is there a contract?" states "You own everything produced" (from the approved mock-up) — confirm this is your policy. **Migration note:** legacy `/product/` SEO tiers 301 → `/packages/` (D-017).

---

## D-036 — Search Authority Diagnostic page `/search-authority-diagnostic/` (page 65) — BUILT & LIVE on `.online`
**Date:** 28–29 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified · Approved by Jamil ("Custom form + webhook and others as recommended .. go ahead")

**Built (29 Sep):** sandbox file `reinforce-diagnostic.php` (repo `wp/novamira-sandbox/reinforce-diagnostic.php`, live md5 `6452b700…` = repo), shortcode `[reinforce_diagnostic]`; page 65 content set and **published**; Yoast title `Free Search Authority Diagnostic | Reinforce Lab` (48) + meta (144).
- **Form backend = custom form + webhook (Jamil).** Posts to `admin-post.php` (`rl_diag_request`). Each valid request → (a) private **ACF post type "Diagnostic Requests"** (`rl_diag_request`, ACF post-type ID 161, not public/queryable/REST) + **ACF field group "Diagnostic Request"** (ID 162, 12 fields); (b) email to **hello@reinforcelab.com** (Reply-To = requester); (c) JSON **webhook to option `rl_diag_webhook_url` — empty = OFF** (set it to the n8n URL later; no code change). Spam: honeypot, <3 s time trap, 5 requests/hour/IP. Validation: name + valid email + company required; selects whitelisted; 200-char caps.
- **Copy = "we analyze…"** (Jamil: switch to system wording when the OS software runs diagnostics). Eyebrow "Agent 01" removed. Industry dropdown = 8 locked industries + Other (Finance under Professional Services). Consent line links the **draft** privacy policy (page 3) — **publish it before launch**.
- **Added vs mock-up:** answer-first definition lede; breadcrumb; 4-question FAQ (free? · what happens next · confidential · vs paid SEO & AI Search Audit → `/services/seo-ai-search-audit/`); step headings h3; deliverables as a list; mock-up "preview / not live" text removed; ticks layout fix.
- **Schema:** Yoast WebPage + BreadcrumbList (Home > Search Authority Diagnostic) + Organization, plus **Service** with `Offer` price 0 USD and **FAQPage** (4 Q).
- **Verified live:** HTTP 200 · 1 H1 · noindex · no PHP errors · no horizontal overflow 1440/390 · success + error states render. **End-to-end test:** invalid → rejected (`?diag=invalid`); honeypot → silently dropped (no record); valid test → private record **ID 176 "TEST (Claude build check)"**, `email_sent = yes` (wp_mail accepted — **Jamil to confirm it arrived at hello@reinforcelab.com / check spam**). Test record can be deleted.
- **UPDATE 29 Sep — FAQ expanded 4 → 8 (Jamil's request; overrides the D-012 §4 "3–6" guideline for this page).** Added: What does the diagnostic include? · Does it cover AI search (ChatGPT, Perplexity, AI Overviews)? · Who is the diagnostic for? · Am I obligated to buy anything afterwards? ("no obligation"). Answers use only facts already on the page. FAQ links now keyed per question. FAQPage = 8 Q, matches visible FAQ. Live md5 `5be3acc8…` = repo. Candidate FAQs held back until Jamil supplies facts: turnaround time; whether GSC/GA4 access is needed.
- **Follow-ups:** Cloudflare Turnstile (needs keys) if spam appears; confirm mail deliverability from Hostinger (SMTP/sender domain) before launch; set `rl_diag_webhook_url` when n8n is ready.

**Original plan (28 Sep):**

Design source: `claude/design-previews/search-authority-diagnostic.html` (Hero + request form · 7 intelligence layers + Authority Score · What you receive (6) · How it works (5 steps) · Who it's for (3 tiers) · Final CTA). Same build method as SAOS (sandbox file `reinforce-diagnostic.php`, shortcode, scoped CSS, Yoast title/meta, Service/FAQ/Breadcrumb schema).

**VERIFIED (28 Sep, read-only):** mock-up form is **not connected** (JS fakes success, "Preview only" note). On `.online`: Jetpack connected, **`contact-form` module active**, `feedback` post type exists → a real form is possible **without a new plugin**. Akismet not installed (no spam filtering beyond Jetpack defaults). WP admin email = jadirectives@gmail.com. Privacy policy = page 3 (**draft**).

**Planned corrections vs mock-up:** industry dropdown → the 8 locked industries (D-022) + "Other", Finance under Professional Services; step headings h4 → h3; remove the "preview / not a live submission" text; add consent line linking the privacy policy.

**Answers (Jamil, 28 Sep):** notification email = **hello@reinforcelab.com**; privacy = **link the draft policy now, publish before launch**; form backend = **wants a long-term, scalable option — recommend before applying** (options + recommendation given in chat 28 Sep: custom on-brand form → WP REST endpoint → store entry (ACF) + email + webhook to n8n → GoHighLevel / Diagnostic agent; vs Jetpack Forms; vs GoHighLevel embed; vs Gravity Forms). **Clarification sent:** the SAOS *web page* is live on `.online` (D-032); the SAOS *software* (agents, Neon, research stack, Diagnostic agent #1) is not recorded as built — D-017 build order is "site front-end first, then the OS MVP". Awaiting Jamil's confirmation of how diagnostics are produced today.
**Open questions (original):** (1) form backend — Jetpack Forms (recommended) vs GoHighLevel embed; (2) notification email address; (3) how diagnostics are fulfilled today (OS MVP not yet built) — copy must not describe an automated system that doesn't exist yet; (4) privacy policy must be published before the form collects real data.

---

## D-035 — Home owns "AI Growth Systems" + Yoast title/meta LIVE on `.online`
**Date:** 28 September 2026 · **Status:** APPLIED & VERIFIED on `.online` · Approved by Jamil (title A, meta approved, Home owns the keyword)

**Applied:** page 33 Yoast title `AI Growth Systems for Search & Automation | Reinforce Lab`, meta as drafted below. Verified live: `<title>`, meta description and schema WebPage name all updated. **Decision locked: Home owns the head term "AI Growth Systems".** **`/services/ai-growth-systems/` — DECIDED (Jamil, 28 Sep):** keep and build as the **commercial "consulting & implementation" page** (how we build one: 4 layers in depth, deliverables, engagement flow, examples by use case → packages). Targets "ai growth systems consulting", "build an ai growth system", "ai growth systems examples". Must NOT repeat Home's definition/FAQ; Home links to it with descriptive (non-exact-match) anchor; it links back to Home and down to services + SAOS. **Build order (Jamil, 29 Sep): Diagnostic ✅ → Packages (`/packages/`, page 66) → Agents (`/services/agents/`, page 76) → AI Growth Systems service page LAST.**

**Audit of live Home (VERIFIED, 28 Sep):** keyword in H1 ✅ ("Build AI Growth Systems to automate…") · in first 100 words ✅ · 2 H2 + 2 H3 contain it ✅ · 11 mentions / 1,420 words (~2.3%, natural) ✅ · FAQ definition "What is an AI Growth System?" + FAQPage schema ✅ · **title ❌ "Home - reinforcelab.online"** · **meta description ❌ none** · **0 internal links to the pillar `/services/ai-growth-systems/`** ❌ · WebPage schema name inherits the bad title ❌.

**Draft title (pick one):** A `AI Growth Systems for Search & Automation | Reinforce Lab` (57) — recommended · B `AI Growth Systems | Reinforce Lab` (33).
**Draft meta (157):** `Reinforce Lab builds AI Growth Systems that automate operations, improve your visibility in Google and AI search, and increase revenue. Book a strategy call.`

**Decision needed — keyword ownership (cannibalization):** D-018 planned `/services/ai-growth-systems/` as the "what AI Growth Systems is" pillar, and Home now also defines the term. Recommendation: **Home owns the head term "AI Growth Systems"** (strongest page: 261 referring links from 50 sites per F-008 crawl data; term is 20/mo US so it is a brand/category play) and the pillar targets the deeper informational set ("how to build", components, examples — cf. "ai growth systems examples" in Google PAA), with Home ↔ pillar links both ways.
**Production note:** this is `.online` only. Changing the live `.com` homepage title is a separate production change needing its own approval (Rule 2).

---

## D-034 — Home copy v2 LIVE on `.online` (de-duplicated vs SAOS)
**Date:** 28 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified · Approved by Jamil ("all yes")

Applied `claude/drafts/home-copy-v2-2026-09-28.md` rev 2 to `reinforce-home.php` (v1.1). Server backup `reinforce-home.php.bak-20260928-pre-v2` (md5 `baa39587…`); live = repo (md5 `e5aedb62…`).
- **Problem / How it works / Industries** rewritten at the AI Growth Systems (umbrella) level; How-it-works names the 4 layers (data, AI models, automated workflows, revenue dashboard) per F-018; steps now `<ol>` + `h3` (was `h4`).
- **Packages** → teaser (Foundation / Growth OS / Enterprise, "Engagements start from $5,000 setup") → `/packages/` + diagnostic. Tier cards removed from Home.
- **FAQ** → 6 company/category Q&As (What is an AI Growth System? · vs agency/tools · What is Reinforce Lab? · Founder — Jamil Ahmed, pharmacist and Semrush Ambassador, linked to https://www.linkedin.com/in/ahmedjamil16/ · Based: Dhaka + Katy TX, works with clients remotely · How to start). Facts confirmed by Jamil 28 Sep. **Removed the unverified "60–90 days" results claim.**
- **Schema:** `FAQPage` (6 Q) added to Home via `wpseo_schema_graph` (same text as visible FAQ).
- **Verified:** HTTP 200 · 1 H1 · no PHP errors · graph = WebPage, BreadcrumbList, WebSite "Reinforce Lab", Organization "Reinforce Lab", FAQPage(6) · no horizontal overflow at 1440/390.
- **Overlap re-measured (F-017 method): SAOS text on Home 24.2% → 7.3%; Home text on SAOS 27.1% → 8.6%.**
- **ID correction:** the overlap and SERP findings were first logged as F-007 / F-008, which collided with existing findings (F-007 traffic, F-008 crawl-budget). Renumbered to **F-017 / F-018**; commit messages 828c9c3 and 5f15eba still say F-007/F-008.
- **Still open:** Home Yoast title/meta (title still "Home - reinforcelab.online"); Proof section still shared with SAOS; `Person` schema for the founder belongs on the About page (D-012 §3).

---

## F-018 — SERP research: "AI Growth Systems" (Bing, Google, Google AI Mode, Semrush — screenshots from Jamil)
**Date:** 28 September 2026 · **Status:** RECORDED — applied to Home copy draft rev 2

**VERIFIED (from screenshots):**
- **Semrush (US, desktop, 29 Sep 2026):** "AI Growth Systems" volume **20 US / 40 global**, KD n/a, competitive density 0.43, intent n/a. 32 variations (1.3K total): *"ai systems for professional services firms law finance consulting growth"* **210, KD 8**; *"ai operating systems for 10x business growth"* 50; *"ai features in crm systems driving growth for startups"* 30; a long *"…ecommerce dtc brands service agency 2025 2026"* string at 880 (looks like noise — low confidence). No questions / related keywords returned.
- **Google AI Overview** defines the term: *"an integrated network of AI tools, data layers, and automated workflows designed to handle business research, lead generation, and customer engagement 24/7"* (cites LinkedIn). Core components: Data Foundation · Signal Capture · Automation & Execution (n8n/Make).
- **Google AI Mode** definition cites rapidneuron.com; architecture = AI Brain (LLMs) · Data Foundation (CRM) · Automation Layer (Make/n8n) · Front end/Dashboard; functional table = lead capture, instant response, qualification/routing, follow-up, database reactivation; section "Why systems beat tools & agencies" (asset vs expense, unified RevOps, human focus).
- **Google organic (Dhaka, not personalised):** aigrowthsystems.blog, rapidneuron.com, Forsify (LinkedIn), swiftheadway.ai, blackwelldigital.com ("in 90 days"), csmgdigital.com, pumpmedya.com, HubSpot Community. Reinforce Lab not present.
- **Bing:** growthsystems.ai, **"AI-Powered Growth Systems | Dhaka" Facebook page (91,566 followers)**, aihumangrowthsystems.com, growth100x.com, growth-ai.io, gitnexa.com, theultimategrowth.com, futuremadeuseful.com, data-mania.com, zdgrowthsystems.com. Reinforce Lab not present.

**INFERENCE:**
- The head term is a **category/positioning term, not a traffic driver** (20/mo US). Its value is entity association + inclusion in AI answers, which lift a clear, extractable definition.
- Competitors frame it as **sales/lead automation for SMBs**; none lead with **search visibility (Google + AI search) + evidence** — that is Reinforce Lab's differentiator.
- **Name-collision risk:** a Dhaka Facebook page called "AI-Powered Growth Systems" (91.5K followers) plus several `*growthsystems*` domains. Pair the term with the brand ("Reinforce Lab's AI Growth Systems") in titles, schema and first sentences.
- Long-tail "ai systems for professional services firms law finance consulting growth" (210, KD 8) fits **`/industries/professional-services/`** (incl. Finance), not Home.

**RECOMMENDATION (applied to draft rev 2 only):** add an answer-first definition ("What is an AI Growth System?") using the 4 layers AI engines use (data, AI models, automation, dashboard); add a systems-vs-agencies/tools answer; name Make/n8n; do **not** copy competitor claims ("24/7", "in 90 days", "$100K saved"). Not yet applied to `.online`.

---

## D-033 — Yoast entity name fixed on `.online`: "Reinforce Lab" / legalName "Reinforce Lab Limited"
**Date:** 28 September 2026 · **Status:** LIVE on `.online` — verified · Approved by Jamil

Yoast `company_name` and `website_name` were empty, so schema fell back to the WP site title "reinforcelab.online". Set `wpseo_titles.company_name` = `website_name` = **"Reinforce Lab"**; added `legalName` **"Reinforce Lab Limited"** via `wpseo_schema_organization` filter in `reinforce-header.php` (Yoast 28.5 has no legal-name setting). Verified on `/` and `/search-authority-os/`: Organization name "Reinforce Lab", legalName "Reinforce Lab Limited"; WebSite name "Reinforce Lab"; no errors. Server backup `reinforce-header.php.bak-20260928-pre-legalname`.
- **Not changed:** WP `blogname` still "reinforcelab.online" (drives default `<title>` fallbacks like "Home - reinforcelab.online"); Yoast Organization `logo` still empty. Both need a decision.

---

## F-017 — Home ↔ Search Authority OS content overlap: ~24–27%
**Date:** 28 September 2026 · **Status:** RESOLVED by D-034 (overlap now 7.3% / 8.6%)

Main content only (header/footer excluded), live pages: Home 1,382 words, SAOS 1,539. 5-word-shingle overlap: **24.2% of SAOS text also appears on Home; 27.1% of Home text also appears on SAOS** (Jaccard 14.7%). 21 exact-duplicate blocks + 27 near-duplicates (≥75% similar). Concentrated in: Problem pains, the 4 process steps (3 identical), Packages (tiers, prices, features ~identical), FAQ (3 questions near-identical), Proof section, industry bullets (Pharma/B2B SaaS/Technology/Prof. Services identical), final-CTA microcopy, engine-diagram nodes. Unique to SAOS: System layers, Evidence layer, What-you-get, comparison table, 8 agents. Unique to Home: 3 outcomes, 6 capabilities, blog, flagship callout.
- **Inference:** internal duplication isn't a penalty, but it blurs which page answers which query (Home = AI Growth Systems umbrella; SAOS = the product) — cannibalization + weaker AI-citation signal for the flagship.
- **UPDATE 28 Sep — Jamil approved the direction** (Packages → teaser, company-level FAQ, umbrella-level Problem/Process/Industries). Draft copy: `claude/drafts/home-copy-v2-2026-09-28.md` (rev 2 after F-018 SERP research) — awaiting copy approval + 2 [VERIFY] facts. Projected overlap after change: ~7–9% (from 24–27%). Also flags the Home FAQ "How soon will we see results?" (60–90 day claim) as unverified — removed in the draft.
- **Recommendation (original):** keep the detail on SAOS; on Home replace duplicated blocks with shorter, distinct summaries that link down (packages → teaser to `/packages/`, FAQ → company-level questions, process/problem/industry copy rewritten at the umbrella level).

---

## D-032 — Search Authority OS page built & LIVE on `.online`
**Date:** 28 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified · Approved by Jamil ("yes all 8... and build the page properly")

Flagship product page `/search-authority-os/` (page ID 64) built from the approved design `claude/design-previews/search-authority-os-landing.html`.
- **Vehicle:** sandbox file `wp-content/novamira-sandbox/reinforce-saos.php` (repo: `wp/novamira-sandbox/reinforce-saos.php`), shortcode `[reinforce_saos]`, CSS scoped `.rl-saos`, loads only on this page. Page 64 `post_content` = `[reinforce_saos]`; **status draft → publish** (single page, site stays noindex; revert = set back to draft). Mock-up's own header/footer dropped (global chrome D-026/D-029 used).
- **Sections (13):** breadcrumb → Hero + engine diagram → Problem (6) → The System (6 intelligence layers) → Research/Verify/Produce/Measure → Evidence chain → Industries (**all 8 locked**, Finance folded into Professional Services) → What you get (8) → Traditional vs SAOS table → 8 Agents → Proof (honest placeholders) → 3 Packages (**prices shown, same figures as homepage**) → FAQ (5) → Final CTA.
- **Changes vs mock-up:** answer-first lede now opens "Search Authority OS is an AI-powered operating system from Reinforce Lab…"; industries 6 → 8 with new copy for E-commerce, Manufacturing, Technology, Education and Finance line in Professional Services; step/agent headings h4 → h3 (valid order); table row labels are `<th scope=row>` + hidden caption; industry/agent cards link to their pages; contextual up-link to `/services/ai-growth-systems/`; CTAs → `/search-authority-diagnostic/` and `/packages/`. Two mock-up mobile defects fixed (eyebrow wrap; vertical flow line rendered as a thick bar).
- **D-012 gates (verified live):** HTTP 200 · **1 H1** · Yoast title "Search Authority OS: Evidence-Led SEO | Reinforce Lab" (53) · meta description 159 chars · robots noindex (correct for `.online`) · schema = Yoast WebPage + BreadcrumbList (Home > Search Authority OS) + Organization, plus **Service** (provider → #organization) and **FAQPage** (5 Q, same text as visible FAQ) added via `wpseo_schema_graph` · 21 internal links out (8 industries, 8 agents, agents hub, pillar, diagnostic, packages, home) · visible breadcrumb · no PHP errors · no horizontal overflow at 1440 / 390 · content server-rendered, no page JS.
- **Known / follow-up:** links render as `?page_id=` until targets are published · no canonical while noindex (Yoast omits it; recheck at launch) · **site-wide: Yoast Organization/WebSite name = "reinforcelab.online", should be "Reinforce Lab" (legalName "Reinforce Lab Limited")** — Yoast Site Representation setting, needs approval · Home still needs Yoast title/meta · `rl-home`/`rl-saos` duplicate ~100 lines of component CSS — consolidate into a shared component sheet before the next page.

---

## D-031 — Theme markup cleanup in the global chrome (one H1, skip link, no theme footer)
**Date:** 28 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified · Approved by Jamil ("fix the header first")

A read of the live homepage showed the theme leaking markup that fails D-012 gates on every page. Fixed once in `wp-content/novamira-sandbox/reinforce-header.php` using bb-theme's own hooks (no theme files edited):
- **Duplicate H1** — bb-theme prints `<header class="fl-post-header"><h1 class="fl-post-title">` on every page; CSS only hid it. Now stripped from the HTML (buffered between `fl_before_post` → `fl_before_post_content`) **only on pages whose content is a `[reinforce_*]` shortcode** (they supply their own H1). Blog posts / other templates untouched. Home: 2 H1 → **1**.
- **Theme footer out of the HTML** — `fl_footer_enabled` → false. Removes the hidden footer widgets ("Archives"/"Categories" H2s) and the Beaver Builder credit link. `[reinforce_footer]` (D-029) unaffected.
- **Skip link** — was rendering as visible blue text under the header and sat 11th in tab order. Now visually hidden until focus, on-brand focus style, and moved to `fl_body_open:5` so it is the **1st** Tab stop.
- **Verified:** home HTTP 200, 1 H1, 0 widgets, 0 credit, 1 footer, no PHP errors; 404 page renders with chrome, no errors; skip link 1×1 before focus, visible on first Tab.
- **Backup on server:** `novamira-sandbox/reinforce-header.php.bak-20260928-pre-h1fix` (md5 `ea2b6d34…`; loader only includes `*.php`, so it is inert). Repo copy = live (md5 `ced18db8…`).
- **Still open:** Home has no Yoast title/meta (title is "Home - reinforcelab.online") — separate write, copy to be approved. 404 template has no H1 (pre-existing; address when a 404 page is designed). No canonical in HTML while noindex — recheck at launch.

---

## D-030 — Homepage (long-form landing) built & LIVE on `.online`
**Date:** 28 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified in browser

First real page content. Jamil chose a **long-form landing homepage**. Built as sandbox file `wp-content/novamira-sandbox/reinforce-home.php` (shortcode `[reinforce_home]`, CSS scoped `.rl-home`, only loads on front page). Home page (ID 33) `post_content` = `[reinforce_home]`; **static front page set** (`show_on_front=page`, `page_on_front=33` — Jamil set it in Reading Settings). Full-bleed breakout of the bb-theme container; content at `--maxw` 1440.
- **Sections:** Hero ("Build AI Growth Systems to automate operations, improve search visibility, and increase revenue" + engine diagram INPUTS→AI GROWTH SYSTEM→OUTCOMES + Book a Strategy Call / Explore Services) → 3 Outcomes (Automate · Improve visibility · Increase revenue) → What We Do (6 capability cards → deep pages) → Problem → How it works (Research/Verify/Build/Measure) → Industries (8, linked) → Flagship Search Authority OS callout → Proof (honest placeholders, no invented metrics) → Packages (3 tiers) → FAQ → Final CTA (portal). Verified hero, outcomes, flagship all render.
- Internal links resolve to `?page_id=` form because target pages are still drafts; become pretty permalinks once those pages are published.
- Hero engine diagram is a clean on-brand build (not the exact SEO-ENGINE/PRIORITY-ARTICLE version from Jamil's screenshots 16/17 — that artifact source wasn't available; swap in later if he provides the link).

**"Nothing Found" root is resolved — the site now has a real homepage.**

**UPDATE 28 Sep — fainter background grid VERIFIED live:** grid tokens reduced from the D-026 values (`--grid .14`, `--grid-red .26`, `--grid-fine .055`) to `--grid .035`, `--grid-red .06`, `--grid-fine .014`, plus `--grid-red2 .035`. Verified on the rendered homepage and by md5 of the live `reinforce-header.php` = repo copy (`ea2b6d34…`, before the D-031 edit).

**Open (SAOS page, awaiting Jamil):** design source = `claude/design-previews/search-authority-os-landing.html` (chosen 28 Sep). **(1) Industries — DECIDED (Jamil, 28 Sep):** **all 8 locked industries (D-022)**, 4×2 grid matching the homepage — Pharma & Life Sciences · Healthcare · B2B SaaS · E-commerce · Manufacturing · Technology · Professional Services · Education (the mock-up's 6-card set is superseded); **Finance is kept, folded into Professional Services** (card copy + hero line: "Professional Services (incl. Finance)"), not deleted. (2) Prices — shown (same figures already public on Home). (3) Page 64 published on `.online`. → Built: see **D-032**.

**FIX (28 Sep):** bb-theme's `.fl-page-content` had a white background (contrast issue — dark/invisible text, white bleed behind transparent sections). Added global rule in `reinforce-header.php`: `.fl-page,.fl-page-content,.fl-content,.fl-post-content,.fl-post{background:transparent!important;color:var(--ink)}` + content headings → `--ink`, content links → `--red-3`. Verified: content bg now transparent, **0 light blocks** on the page. Applies site-wide, so all future pages sit correctly on the dark base.

---

## D-029 — Live footer built & verified on `.online`
**Date:** 28 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified in browser

Added the square-glass footer (D-021 design) to the same sandbox chrome file (`reinforce-header.php`), rendered via `[reinforce_footer]` shortcode auto-hooked to `wp_footer` (priority 20); default bb-theme footer hidden (`.fl-page-footer-wrap` etc.).
- **Container = 1440px** (matches header per D-028).
- **Content:** 6 social icons; brand intro + 5 columns — **Search Authority OS** (OS/Diagnostic/Packages/Agents) · **Solutions** (the 12, links via `get_page_by_path` to `/services/*` where built) · **Industries** (8 plain names → `/industries/*`) · **Company** (Home/About/Services/Portfolio/Clients/Blog/Careers/Contact, `#` where unbuilt) · **Resources** (Free Quote/Sitemap/Privacy/Terms/FTC/Incorporation, `#`). Contact block: BD + USA offices + phones + hello@reinforcelab.com. Copyright bar (single — verified no duplicate). All original footer info preserved (D-011 intent).
- Verified in browser: socials, columns, offices, copyright all render; one footer only.

**Global chrome (header + footer) is now COMPLETE and live on `.online`.** Next: page content (homepage/hero) or the width-unification decision (Option A 1440-everything vs B wide-chrome) still pending.

---

## D-028 — Site container width = 1440px everywhere (Option A)
**Date:** 28 September 2026 · **Status:** APPLIED & LIVE (updated 28 Sep — Option A chosen)

**FINAL:** Jamil chose **Option A — 1440px everywhere** (header, footer, hero, all content sections). Single source of truth: `--maxw:1440px` in `reinforce-header.php`; `.rl-header .wrap` & `.rl-footer .wrap` use `var(--maxw)`; theme `fl-content-width` set to **1440**. So chrome and content share one container and always align (resolves the earlier header/hero mismatch permanently). Gutter stays `clamp(16px,4vw,64px)`. Text readability preserved via per-element `max-width` caps (~60–66ch).
*(Superseded the interim "1440 chrome / 1280 content" split.)*

Jamil's call: **header + footer use a wider 1440px container; page content stays 1280px.** Intentional "wide chrome / narrower content column" pattern — header/footer bands frame a narrower content column, so their edges deliberately sit ~80px outside the content (not the accidental mismatch from D-026 discussion). Applied: `.rl-header .wrap{max-width:1440px}` in `reinforce-header.php` (verified live: header wrap = 1440 at 1680 viewport). `--maxw` stays 1280 for content/sections. **Footer** (when built) uses 1440 to match the header. Theme Content Width in customizer stays 1280 for page content.

---

## D-027 — LiteSpeed Cache deactivated on `.online` for the build
**Date:** 28 September 2026 · **Status:** ACTIVE (dev only)

Jamil deactivated **LiteSpeed Cache** on `.online` for the duration of the build (it was masking front-end changes behind stale cache — see D-026). Effect: edits to sandbox code / pages now render immediately; no purge step needed during dev.
⚠️ **Re-enable + reconfigure LiteSpeed before/at the migration to `.com`** — it's part of the locked stack and matters for launch performance. (Production `.com` LiteSpeed is separate and untouched.)

---

## D-026 — Live header built & verified on `.online` (Systems Grid chrome)
**Date:** 28 September 2026 · **Status:** LIVE on `.online` (dev, noindex) — verified in browser

Translated the approved square-glass chrome (D-021 v9) into the live site header. Approach approved by Jamil: **faithful custom code** (not stock BB modules).
- **Vehicle:** a Novamira **sandbox PHP file** `wp-content/novamira-sandbox/reinforce-header.php` (PHP writes are restricted to the sandbox; Novamira's `sandbox-loader.php` auto-includes it every request, with `.crashed` safe-mode recovery). NOT a mu-plugin (blocked) and NOT BB-node injection (fragile).
- **What it does:** enqueues Oswald/IBM Plex + prints the chrome CSS/JS; adds body class `rl-dark` + fixed `#rl-grid` (parallax) & `#rl-glow` (cursor glow); registers `[reinforce_header]`, auto-renders at `wp_body_open`; hides old `.fl-page-header`.
- **Renders from live data:** logo = white logo (option `reinforcelab_logo_white` → 155); nav = the **Primary** menu (D-024), built generically — grouped **Solutions** mega (SEO / AI Search & Content / Automation·Advisory·Web / Agents + flagship strip), **Industries** dropdown, plain items; **CTA → /search-authority-diagnostic/**. Mobile: burger → grouped full-screen slide-in.
- **Fixes during build:** LiteSpeed cache masked first render (purge needed); bb-theme forced `flex-wrap:wrap` → set `nowrap` + raised mobile breakpoint to ≤1150px.
- **Verified in browser:** desktop nav (1440), Solutions mega, Industries, mobile menu (375) all correct.
- **Follow-up:** default page CONTENT is low-contrast on the new dark base (placeholder pages unstyled) — resolves as pages get built. Pre-existing Themer "Site Header" layout (ID 44) is superseded (output hidden); deletable later.
- **UPDATE 28 Sep — deeper background + parallax (Jamil):** grid tokens bumped (`--grid .14`, `--grid-red .26`, `--grid-fine .055`); added second grid layer `#rl-grid2` (132px red grid + corner radial, z-index -1) parallaxing faster than `#rl-grid` for depth; front-grid parallax increased (~42px mouse), mouse tilt eased. Parallax is rAF-driven → pauses when the browser window is hidden (normal); verify with tab focused.

---

## D-025 — Logo set on `.online`
**Date:** 28 September 2026 · **Status:** DONE

Site logo configured on `.online` using **Jamil's own Media Library uploads** (he uploaded them; my pasted-image copies 156/157 were deleted):
- **`custom_logo` = attachment 154** — "Official Reinforce Logo" (dark/color PNG). Renders via the theme/Beaver Themer site-logo.
- **White version = attachment 155** — stored in option **`reinforcelab_logo_white`** for use in the dark header (Beaver Themer header module / custom logic to swap on dark backgrounds).

---

## D-024 — Primary nav menu built on `.online`
**Date:** 28 September 2026 · **Status:** BUILT (drafts wired; content to follow)

Built the WordPress **"Primary" nav menu (term_id 4, 47 items)** on `.online` via Novamira, wired to the scaffolded page IDs and matching the locked IA (D-019/D-022/D-023). **Assigned to theme location `header`** (registered locations: bar / header / footer).
- **Top level:** Search Authority OS (64) · Solutions (68) · Industries (87) · Packages (66) · Portfolio # · Blog # · About # · Contact #
- **Solutions** children: AI Growth Systems Overview (71) + 4 grouped sub-headers (class `mega-col-header`, url `#`): **SEO** (Search Engine Optimization #, Technical SEO 99, Enterprise SEO Strategy 98, International SEO 100, Local SEO 104, SEO & AI Search Audit 74) · **AI Search & Content** (AI Search Optimization 72, GEO 73, LLM Optimization 101, SEO Content Systems 85, Digital PR/Press Release #) · **Automation, Advisory & Web** (AI Workflow Automation 97, Marketing Automation 86, Lead Gen 102, Executive AI Consulting 103, WordPress Website Design #, E-commerce Website Design #, Website Maintenance #) · **Agents** (76 → 8 agents 77–84).
- **Industries** children: pharmaceutical 75, healthcare 90, b2b-saas 91, ecommerce 92, manufacturing 93, technology 94, professional-services 95, education 96.
- `#` placeholders = KEEP-EXISTING pages not yet scaffolded (core SEO pillar, Digital PR, 3 web pages) + Portfolio/Blog/About/Contact. They auto-link once those pages exist.
- Idempotent (clears + rebuilds "Primary"). Mega grouping (3-level) to be rendered by the Beaver Themer/PowerPack header; sub-headers carry class `mega-col-header`.

---

## D-023 — Final service architecture (Solutions + Web + legacy redirect map)
**Date:** 28 September 2026 · **Status:** APPROVED (planning; production URLs apply only at migration cutover) · sources: [positioning-content-2026-09-28.md](reference/positioning-content-2026-09-28.md), GSC 16-mo Pages.csv

Reconciled the 12-item "What We Do" + legacy production services + earlier approved URLs into one de-duplicated set. **Data-backed** (16-mo GSC clicks/impressions/avg-position).

### SOLUTIONS — the 12 locked capabilities (Jamil: "it's locked")
`AI Growth Systems` (umbrella pillar, not a peer) · AI Workflow Automation · AI Search Optimization (AISO) · Enterprise SEO Strategy · Technical SEO · International SEO · **SEO Content Systems** (`/services/seo-content-systems/` — Jamil confirmed this NAME, not "Content Strategy"; the "Content Strategy" item from the What-We-Do list = this page) · GEO · LLM Optimization · Lead Generation Systems · Marketing Automation · Executive AI Consulting.

### KEPT in addition (Jamil explicit)
- **Search Engine Optimization (core SEO pillar)** — KEEP existing slug `/services/best-search-engine-optimization-services/` (**420,385 impressions**/16mo, pos 63 — biggest latent asset in /services/). Becomes the SEO pillar; Technical/Enterprise/International/Local sit under it and link up.
- **Local SEO** — standalone page `/services/local-seo/` (fresh build; ~0 existing page data — demand was keyword-level).
- **SEO & AI Search Audit** — `/services/seo-ai-search-audit/` stays (funnel/paid product, D-016).
- **Press Release → Digital PR** — KEEP `/services/press-release-services/` (39 imp; forward bet on GEO/authority, rebuilt as Digital PR, not equity rescue).
- **Web Design & Development group (KEEP):** `/services/wordpress-website-design-service/` (259,862 imp), `/services/ecommerce-website-design-service/`, `/services/website-maintenance-services/` (258,722 imp, 60 clicks).
- **/services/** hub — KEEP (pos 4.2).

### LEGACY REDIRECTS — 301 (data-backed; apply at cutover)
| Legacy (impressions) | 301 → |
|---|---|
| best-seo-content-writing-services (74,989) | /services/seo-content-systems/ |
| off-page-seo-services (47,499) | ~~/services/enterprise-seo-strategy/~~ → /services/press-release-services/ (O-018 B) |
| best-affordable-seo-link-building-services (34,775) | ~~/services/enterprise-seo-strategy/~~ → /services/press-release-services/ (O-018 B) |
| ~~technical-seo-services (27,457)~~ | ~~/services/technical-seo/~~ **SUPERSEDED by D-046: URL kept, no redirect** |
| email-marketing-services (19,339) | /services/marketing-automation/ |
| best-website-copywriting-services (18,729) | /services/seo-content-systems/ |
| best-on-page-seo-services (13,100) | /services/best-search-engine-optimization-services/ (core SEO) |
| best-blog-writing-services (10,155) | /services/seo-content-systems/ |
| ppc-management-services (6,572) | /services/lead-generation-systems/ |
| business-consultancy-service (2,803) | /services/executive-ai-consulting/ |
| content-marketing-services (1,756) | /services/seo-content-systems/ |
| social-media-management-service (279) | /services/marketing-automation/ |
| social-media-marketing-service (191) | /services/marketing-automation/ |

### LEGACY 410 (eliminate)
- `/services/creative/graphic-design-services/` (151 imp, off-strategy, no relevant target).

### NEW service slugs to add to register + scaffold
`/services/ai-workflow-automation/` · `/services/enterprise-seo-strategy/` · `/services/technical-seo/` · `/services/international-seo/` · `/services/llm-optimization/` · `/services/lead-generation-systems/` · `/services/executive-ai-consulting/` · `/services/local-seo/`. (Plus keep: core-SEO pillar slug, press-release-services, the 3 web slugs, seo-ai-search-audit, seo-content-systems, marketing-automation, ai-search-optimization, generative-engine-optimization, ai-growth-systems.)

**Supersedes** earlier D-015 dispositions for these legacy rows and the earlier "5 Solutions" set. Disposition sheet + redirect-map CSV to be regenerated from this table before cutover. Pharma → Industries (D-022).

**SCAFFOLDED on `.online` 28 Sep 2026 (drafts, idempotent):**
- **Industries hub** `/industries/` = page **ID 87**; 8 industry drafts under it: pharmaceutical **75** (re-parented from /services/, renamed from pharmaceutical-seo), healthcare **90**, b2b-saas **91**, ecommerce **92**, manufacturing **93**, technology **94**, professional-services **95**, education **96**.
- **8 new service drafts** under /services/ (parent 68): ai-workflow-automation **97**, enterprise-seo-strategy **98**, technical-seo **99**, international-seo **100**, llm-optimization **101**, lead-generation-systems **102**, executive-ai-consulting **103**, local-seo **104**.
- Note: the pass accidentally created a duplicate `pharmaceutical` (ID 89) racing the re-parent of 75; **89 trashed**, 75 kept. Verified: industries hub has exactly 8 children.
- **Not yet scaffolded (KEEP-EXISTING, come via rebuild/migration):** core SEO pillar, press-release/Digital PR, the 3 web pages. `blog_public=0` (noindex) verified before writes.

---

## D-022 — Industries axis added; Pharma moved Solutions → Industries
**Date:** 28 September 2026 · **Status:** DECIDED in preview; sub-items open (slug, list reconciliation, scaffolding)

Jamil raised the services-vs-industries taxonomy inconsistency (pharma was the only "X SEO" hybrid in Solutions). Resolved the pre-flagged architectural tension (see the earlier `/industries/` note): **AI Growth Systems umbrella now has THREE child axes — Search Authority OS (product) · Solutions (capabilities/WHAT) · Industries (verticals/WHO).**

- **Solutions (5, pure capabilities):** AI Search Optimization · Generative Engine Optimization · SEO & AI Search Audit · SEO Content Systems · Marketing Automation. (Pharma removed.)
- **Industries naming — REVERSED to plain vertical names (Jamil, 28 Sep, later same day):** drop "SEO" from every industry *label*. The brief "[Industry] SEO" labelling is superseded. Keyword capture happens on each page's H1/title/content, not the nav label. **Nav placement also changed: Industries is now its OWN top-nav dropdown (`Industries ▾`), removed from the Solutions mega** (chrome v9).
- **SLUG decision RESOLVED (28 Sep): PLAIN slugs** — `/industries/pharmaceutical/`, `/healthcare/`, `/b2b-saas/`, `/ecommerce/`, `/manufacturing/`, `/technology/`, `/professional-services/`, `/education/`. Rationale: URL keywords are a minor/declining classic-SEO factor and irrelevant to AEO/GEO/LLM; clean entity URLs are better understood by AI/knowledge systems and future-proof (pages are broader than SEO). Keyword capture moves to title/H1/schema (e.g. title "Pharmaceutical SEO & AI Search"). Consistent with plain labels.
- **Nav representation:** Option B — Industries shown as a column inside the existing **Solutions ▾** mega-menu (Solutions | Industries | Agents | Flagship), no new top-nav item. Footer got a matching Industries column. Built into the chrome preview (Header & Footer artifact v4).

**Open sub-items (need Jamil):**
1. ~~Pharma slug~~ — **RESOLVED 28 Sep 2026 (Jamil): `/industries/pharmaceutical/` — plain, no `-seo` suffix.** This supersedes the earlier "keyword kept" wording that sat here; the plain-slug decision recorded above is the one that stands, and the build followed it. Pharma leaves Solutions; draft page ID 75 re-parented and renamed under `/industries/` — **done**, see D-023.
2. ~~Growing Businesses~~ — RESOLVED 28 Sep: **OUT** (stage, not vertical).
3. ~~Healthcare~~ — RESOLVED 28 Sep: **IN**.

**Industries FINAL (8), confirmed 28 Sep 2026** — PLAIN labels (no "SEO" suffix):
**Pharmaceutical & Life Sciences · Healthcare · B2B SaaS · E-commerce · Manufacturing · Technology · Professional Services · Education.** (Education added; E-commerce kept; Healthcare back in; Growing Businesses out.) Own `Industries ▾` nav dropdown (chrome v9).

**🔒 LOCKED-LIST CHANGE APPROVED BY JAMIL — 28 September 2026.** Master Project Instructions §5 and §43 lock the target industries at **six** (Pharmaceutical & Life Sciences, Healthcare, B2B SaaS, Manufacturing, Professional Services, Technology). This decision **expands that locked list to eight** by adding **E-commerce** and **Education**. Jamil approved the change explicitly on 28 Sep 2026. The eight above are now the current locked list; §5/§43 are superseded on this point and should be updated at the next revision of the Master Instructions. Recorded here so the change is never treated as silent drift (§40, §43).

**Slugs RESOLVED 28 Sep 2026 (Jamil): PLAIN — no `-seo` suffix.** `/industries/pharmaceutical/` · `/industries/healthcare/` · `/industries/b2b-saas/` · `/industries/ecommerce/` · `/industries/manufacturing/` · `/industries/technology/` · `/industries/professional-services/` · `/industries/education/`. Keyword capture lives in each page's title, H1, content and schema — not the URL.

4. **Still open — SERVICES reconciliation (D-023).** The 12-item "What We Do" (positioning-content-2026-09-28.md) has not been mapped to Solutions pages yet. Until decided, Solutions stays at the current 5 in the chrome.
5. Services settled in **D-023**; `/industries/` hub + 8 vertical drafts **scaffolded on `.online` 28 Sep** (page ID 75 re-parented and renamed to the plain `pharmaceutical` slug) — see D-023. **Still to do:** add the 8 industry URLs + the D-023 service slugs to the approved-new URL register, and update `CLAUDE.md`'s locked-industries line to the eight above.

---

## D-021 — Global chrome (header + footer) reworked — APPROVED
**Date:** 27 September 2026 · **Status:** APPROVED 28 Sep 2026 (chrome locks; applies across every page in the live build)

**Amendment (28 Sep):** "Reviews" removed from the header nav, the mobile menu, AND the footer — Jamil: affiliate content stays out of global navigation. The `/reviews/` hub + 2 pillar drafts remain on `.online` but are unlinked from global chrome. Then **Portfolio + Blog added** after Packages (header + mobile). Final top nav: **Search Authority OS · Solutions ▾ · Packages · Portfolio · Blog · About · Contact** + CTA.

The D-018-flagged rework of header + footer (global chrome) built as a dedicated preview before mass-producing pages. Decisions Jamil made this session:
- **Header nav = mega-menu under "Solutions"** (chosen over a simple dropdown / flat minimal). Top bar: `Reinforce Lab` · **Search Authority OS · Solutions ▾ · Packages · Reviews · About · Contact** + CTA. The Solutions mega-panel = 3 cells: **AI Growth Systems** (pillar link + the 6 Solutions), **Agents** (8 OS modules), and a **Flagship promo** cell → Search Authority OS.
- **Header CTA = "Get Your Diagnostic" → `/search-authority-diagnostic/`** (the free lead-magnet / funnel entry).
- **Footer** kept ALL existing info intact (6 socials, brand blurb, BD+USA offices, phone/email, copyright, all legal links) but re-mapped columns to the IA: **Search Authority OS** / **Solutions** (locked 6, incl. new seo-content-systems + marketing-automation) / **Company** / **Resources**. Missing flagship links (OS, Diagnostic, Packages, Agents, Reviews) added.
- Mobile: hamburger → slide-in menu with Solutions + Agents grouped.

Preview artifact (look-and-feel, not live): "Header & Footer". Once approved, this becomes the global chrome applied across every page in the live `.online` build.

---

## D-020 — Daily GitHub auto-sync (Windows Scheduled Task)
**Date:** 26 September 2026 · **Status:** ACTIVE

Backlog since 10 Sep committed + pushed (`253c001 → 85db50e`), so GitHub (`github.com/jamilahmed16/reinforce-lab-wp-modernization`, branch `main`) is current. Automated daily sync installed:
- **Script:** [scripts/daily-git-sync.ps1](../scripts/daily-git-sync.ps1) — checks `git status`; if there are changes, `git add -A` + commit ("Daily sync <ts>") + `git push origin main`; logs to `scripts/git-sync.log` (gitignored). Prepends `D:\Git\cmd` to PATH (Task Scheduler's minimal PATH omits git).
- **Task:** Windows Scheduled Task **"ReinforceLab Git Sync"**, **daily 8:00 PM**, run as Jamil Ahmed (**Interactive only** — runs when logged on; to run when logged off, edit the task in Task Scheduler and supply the account password).
- Verified end-to-end: direct run committed+pushed (`85db50e → 1473db2`); scheduled trigger executes the script (logged "no changes" on a clean tree).

**Note:** the daily sync covers the **repo only**. The design-preview HTML (landing/diagnostic/packages) lives in the session scratchpad and is published as claude.ai Artifacts — not in git. Say the word to copy them into `claude/design-previews/` so they're versioned + auto-synced too.

---

## STILL OPEN — awaiting Jamil

| Ref | Item | Why it matters |
|---|---|---|
| O-002 | **17 orphaned ranked URLs** — approve internal linking? | Zero-risk, highest-leverage action available. Changes no URL, slug, canonical, or content. |
| O-003 | **Beaver Builder Pro + Beaver Themer licences** — existing keys, or purchase? | Both unlicensed on `.online`. Blocks updates and support. |
| O-009 | **Production footer: leave the six 404s live until launch, or remove the links now?** | A menu edit is reversible and changes no URL. Leaving them means every visitor clicking your flagship services hits a dead end for the whole build period. |
| O-015 | **Two homepage titles on production** (F-013) — "…Your Digital Growth Partner" (433 views) and "…AI Growth Systems, AI Search & SEO" (139 views) | All GA4 data confirmed as `.com`. Confirm which page carries the AI-Growth-Systems title and whether it's the approved D-010 change or an unlogged edit. Ties to O-006/O-007. |
| O-012 | **PowerPack for Beaver Builder 2.43.0** installed on `.online` — approve as part of the stack? | Not in the locked stack (§21), which requires a clear purpose and compatibility rationale per plugin. Also relevant to F-001: PowerPack ships its own Posts/Content modules with their own pagination behaviour, so it becomes a second variable in the archive-template design. |
| O-013 | **Count of Posts modules inside the "Blog" archive layout** on production | The last item needed to close F-001. Cannot be read from the Themer Layouts list — the layout must be opened in the builder. |
| O-006 | **`/content-marketing-for-plastic-surgeons/`** marked COMPLETE in the execution sheet — what changed, when, by whom? | Position-1 page. Need to know whether production changes have happened outside the approval chain. |
| O-007 | **Who added the six broken footer links, and when?** | Same reason as O-006. If the baseline is measuring a site that is being changed underneath us, it is not a baseline. |

---

**Production status: UNTOUCHED**, except the two approved and verified changes on record — D-010 (homepage H1/intro/title/meta, live 25 Aug 2026) and D-011 (footer blurb + one link label, live 20 Aug 2026). Every other production URL remains `PENDING — NO CHANGE AUTHORIZED`.

**URL register state:** all **631 unique pages** carry an approved *disposition* (D-014 / D-014b / D-015), and D-023 supersedes those dispositions for the legacy `/services/*` rows. A disposition is a **plan, not an authorisation** — nothing is applied to production until the approved migration cutover, which is not scheduled. *(The earlier line here read "All 216 URLs: PENDING", which matched neither the register nor this log. Corrected 28 Sep 2026.)*
