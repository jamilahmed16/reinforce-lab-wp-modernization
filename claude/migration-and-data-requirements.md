# REINFORCE LAB — MIGRATION SAFETY & DATA REQUIREMENTS

**Status:** ACTIVE — the plan for replacing production (`reinforcelab.com`) with the fresh build (`reinforcelab.online`) **without losing SEO value, breaking links, or dropping redirects.**
**Date:** 10 September 2026
**Companion:** [seo-geo-aeo-standard.md](seo-geo-aeo-standard.md) · [decision-log.md](decision-log.md) · `Reinforce_Lab_URL_Decision_Register_v3.xlsx`

> The build is the easy part. This document is the part that keeps the rankings.

---

## 1. The migration model (how `.online` becomes `.com` safely)

The site is being **rebuilt fresh** (D-001), so the migration is a **content + URL cutover**, not a database clone. Safe cutover = three guarantees:

1. **URL preservation** — every existing production URL that holds equity resolves to the right place (same URL kept, or 301 to its successor). No 404s for any URL Google/humans/backlinks know.
2. **Signal parity** — titles, canonicals, schema, internal links, and sitemaps are correct on day one.
3. **Reversibility** — the 2 GB production backup (`.wpress`, D-001) is the rollback point; DNS/cutover is planned and monitored.

**Every existing production URL is `PENDING` until it has an explicit disposition** (Rule 2). The dispositions are:

| Disposition | Meaning | Redirect |
|---|---|---|
| `PRESERVE` | URL unchanged, content carried across | none (self-canonical) |
| `PRESERVE + RELINK` | preserved + gets internal links | none |
| `301 → new` | replaced by a new/better URL | **301 required** |
| `CONSOLIDATE → target` | merged into another page | **301 required** |
| `RETIRE → parent/301` | removed | **301 to nearest relevant** (not to home by default) |
| `KEEP (noindex)` | kept but not indexed (e.g. thin utility) | none |

**The redirect map = the disposition of all 787 URLs.** Today: **17 PRESERVE, 5 NEW, 765 PENDING.** The redirect map cannot be finished until the 765 are decided — and that needs the data in §3.

---

## 2. The redirect / URL map (the deliverable)

Built as a column set extending the existing **URL Decision Register** (787 URLs):

`old_url | status_code | GSC_clicks | GSC_impr | backlinks | disposition | destination_url | redirect_type | canonical | notes`

**Rules for the map:**
- Any URL with **clicks, impressions, or backlinks** defaults to PRESERVE or 301 — never RETIRE-to-404.
- **301 (permanent)**, never 302, for equity transfer. One hop only (no redirect chains).
- Redirect **to the closest relevant page**, not the homepage (homepage redirects leak equity and confuse Google).
- The `//get-a-free-quote/` double-slash + 76 inlinks issue and the 5 trailing-slash 301 service URLs (crawl §5) get fixed at source, not left as hops.
- Retire the `/paged-N/` junk and `?wc-ajax=` endpoints via robots + no internal links (F-002 proven safe).
- Test **every** redirect post-launch (status 301, correct target, no chain, no loop).

**Status:** framework defined; awaiting §3 data + per-URL approvals to populate the 765.

---

## 3. Data we still need (blocks a safe migration)

Ranked by how much it protects equity. Items marked **(you)** only you can export.

| # | Data | Why it's critical | How to get it |
|---|---|---|---|
| 1 | **Backlink export, URL-level** **(you)** | Tells us which URLs have external authority that **must** be preserved/301'd. Migrating blind here is the #1 way to silently lose rankings. | Semrush/Ahrefs → Backlinks → export "by target URL" (referring domains + target URL). CSV. |
| 2 | **GSC full performance export** **(you)** | Confirms which URLs + queries actually earn, beyond the anonymised 15%. Drives PRESERVE decisions + keyword map. | GSC → Search results → last 16 months → export Pages **and** Queries (or the API for un-capped rows). |
| 3 | **GSC Page Indexing report** **(you)** | Diagnoses the Sept-2025 decline so we don't rebuild on its cause (O-010). | GSC → Indexing → Pages → export each status ("Crawled – not indexed", "Discovered – not indexed", etc.). |
| 4 | **GA4 landing-page + conversion export** **(you)** | Which pages produce business, not just clicks — prioritises what to protect/build. | GA4 → Reports → Landing page + Conversions → export. |
| 5 | **WPCode / Code Snippets inventory** **(you, read-only)** | Custom rewrite rules / injected tags on production could affect URLs, schema, or redirects. Needed before touching production robots/redirects. | Production wp-admin → WPCode + Code Snippets → list every active snippet (screenshot/export). Do **not** connect me to production. |
| 6 | Screaming Frog **list/sitemap-mode** crawl | Confirms the true indexable-URL count vs the orphan estimate (crawl §1 caveat). | Re-crawl in list mode against the sitemaps. |
| 7 | Beaver Builder Pro + Themer **licence keys** (O-003) | Operational — unblocks updates/support for the build. | Existing keys or purchase. |

Until items 1–5 land, the redirect map and keyword map stay partial, and **migration must not be scheduled.**

---

## 4. Keyword / topical map (next strategy deliverable)

Built from GSC (item 2) + the locked positioning. Structure:
- **Money pages:** the 5 approved services + the flagship Pharmaceutical/Healthcare industry, each mapped to a primary head term + supporting long-tail + question set (for AEO/FAQ).
- **Preserve-and-improve:** the 17 Tier-1 URLs — keep the URL, protect the ranking, only optimise on separate approval (D-005).
- **Topic clusters:** each hub (service/industry) + its supporting blog posts, interlinked.
- **AI/GEO angle per cluster:** the questions LLMs get asked in that space, answered on-page.
- **Do NOT** bulk-publish the 76 drafts (F-003) — the pattern that preceded the collapse.

**Status:** framework defined; population needs item 2 (full GSC data).

---

## 5. Launch / cutover QA gate (before DNS flips)

- [ ] Redirect map complete for all 787 URLs; every 301 tested (status, target, no chain/loop)
- [ ] All 17 PRESERVE URLs: 200, indexable, canonical, title, content parity vs old
- [ ] New service/industry URLs live at approved slugs, indexable, schema valid
- [ ] XML sitemap = only indexable canonicals; submitted; old junk excluded
- [ ] robots.txt correct (waste blocked, content allowed, AI-crawler posture set)
- [ ] Schema validates sitewide; Organization/entity consistent
- [ ] Internal links: orphans relinked; no links to retired URLs
- [ ] CWV pass (mobile); no plugin-bloat regression
- [ ] Analytics + GSC verified on the new production; property/settings carried over
- [ ] Rollback ready (`.wpress` backup); monitoring plan (GSC coverage + rankings, weekly, 6+ weeks)
- [ ] Production changes only via per-URL approval (Rules 1 & 2 hold to the last minute)
- [ ] **Legal pages (D-120 to D-122):** Reinforce Lab Limited's RJSC registration number and VAT/BIN number added to Terms and Privacy (Jamil supplies before launch); payment provider named in the Privacy Policy before the store opens; cookie consent banner and "Cookie settings" footer link live, with GA4 loading only after consent; GA4 data retention set to 14 months; Hostinger and Google data processing terms accepted
- [ ] **Affiliate links (D-122):** real Semrush and WP Engine affiliate link formats checked against `rl_aff_partner()` in `core/reinforce-affiliate.php` (labelled "Ad", `rel="sponsored"`)

---

**Bottom line: building pages can proceed now under the SEO/GEO/AEO standard. The migration cannot be scheduled until §3 items 1–5 are in hand and the §2 redirect map is complete and tested.**
