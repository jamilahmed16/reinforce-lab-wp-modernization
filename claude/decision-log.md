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

**Open (SAOS page, awaiting Jamil):** design source = `claude/design-previews/search-authority-os-landing.html` (chosen 28 Sep). **(1) Industries — DECIDED (Jamil, 28 Sep):** **all 8 locked industries (D-022)**, 4×2 grid matching the homepage — Pharma & Life Sciences · Healthcare · B2B SaaS · E-commerce · Manufacturing · Technology · Professional Services · Education (the mock-up's 6-card set is superseded); **Finance is kept, folded into Professional Services** (card copy + hero line: "Professional Services (incl. Finance)"), not deleted. Still pending: (2) show package prices on `/search-authority-os/`? (3) publish page 64 on `.online` or keep draft?

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
| off-page-seo-services (47,499) | /services/enterprise-seo-strategy/ |
| best-affordable-seo-link-building-services (34,775) | /services/enterprise-seo-strategy/ |
| technical-seo-services (27,457) | /services/technical-seo/ |
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
