# CRAWL WASTE — ROOT CAUSE ANALYSIS AND FIX PLAN

**Project:** SEO-Safe WordPress Modernization
**Status:** PROPOSAL — nothing authorised, nothing executed
**Date:** 20 August 2026
**Governs:** §23 (test before production), §38 (risk management), §46 (protect the live website)

**Production status: UNTOUCHED.**

---

## 1. WHAT WE ARE FIXING

Roughly 190 machine-generated URLs are consuming Google's crawl allocation on a site with about 200 real pages.

| Source | URLs | Where they appear in GSC |
|---|---|---|
| Malformed `/paged-N/M/` pagination | ~154 | 77 in *Alternate page with canonical*, 77 in *Crawled — not indexed* |
| Author archive permutations | 22 | *Crawled — not indexed* |
| PayPal `?wc-ajax=ppc-*` endpoints | 7 | *Crawled — not indexed* |
| RSS feeds | 6 | *Crawled — not indexed* + *Excluded by noindex* |
| Truncated/broken URLs | ~4 | *Crawled — not indexed* |

**Consequence:** 58 real content pages holding **383 clicks** sit in *Discovered — currently not indexed* — found by Google, never crawled.

---

## 2. ROOT CAUSE — `/paged-N/M/`

### The pattern

```
/blog/paged-2/2/          /blog/paged-3/18/
/business/paged-2/3/      /author/farihaanika/paged-3/8/
```

Two numbers. The **first** is only ever `2` or `3`. The **second** ranges from `2` to `18`.

Real WordPress pagination also exists on the site and works correctly: `/blog/page/2/`.

### Primary hypothesis `[INFERENCE — well supported, NOT yet verified]`

**This is Beaver Builder's multi-module pagination.**

When a page contains more than one Posts module, Beaver Builder needs to paginate each one independently. It registers rewrite rules of the form `paged-{module}/{page}` — the first number identifies *which* Posts module on the page, the second is *that module's* page number.

The shape of the data fits exactly:
- first number `2`/`3` = second and third Posts module instances
- second number `2`–`18` = page numbers within that module
- affects **8 archive templates** — `/blog/`, `/business/`, `/business/small-business/`, `/b2b-marketing/`, `/video-marketing/`, `/digital-marketing/content-marketing/`, `/author/jamilahmed/`, `/author/catherine/`

Production runs Beaver Builder (`fl-controls/v1` confirmed in the REST namespace index), which makes this mechanically plausible on top of being numerically consistent.

### Why this matters more than a normal bug

**We are rebuilding on Beaver Builder and Beaver Themer (locked stack, §21).** If this is what it looks like, **the same behaviour follows us into the new site** unless the archive templates are designed to avoid it. That is precisely why it gets solved on `.online` first, before any template is built — not patched on production and forgotten.

### Competing hypotheses — must be excluded, not assumed away

| Hypothesis | How to test |
|---|---|
| **WPCode / Code Snippets custom rewrite rule.** Production runs both plugins. Custom `add_rewrite_rule()` is invisible to a theme/plugin audit. | Inspect all active snippets in both plugins. |
| A pagination or infinite-scroll plugin | Full plugin inventory from production wp-admin. |
| Legacy theme function surviving a past migration | Search the active theme and child theme for `paged-`. |

**I will not propose a fix until the cause is confirmed.** Guessing here risks breaking working pagination on 8 archives.

### Diagnostic procedure — `.online` only, zero production impact

1. Read production's rewrite rules **read-only** — `wp rewrite list` via WP-CLI, or the `rewrite_rules` option — and export them. **No write.**
2. Inventory every active WPCode and Code Snippets entry on production, **read-only**.
3. Grep the active theme, child theme and plugin directory for `paged-` and `add_rewrite_rule`.
4. Reproduce on `.online`: build a Beaver Themer archive layout with two Posts modules, flush permalinks, and check whether `/paged-2/2/` becomes reachable.

Step 4 is the decisive one. If it reproduces on a clean install with no custom code, Beaver Builder is confirmed and the fix is architectural, not a patch.

---

## 3. FIX OPTIONS FOR `/paged-N/M/`

### Option A — Prevent generation (recommended for the new build)

Design the Beaver Themer archive templates so **each archive page contains exactly one Posts module bound to the main query.** Pagination then resolves to standard `/page/2/` and no `paged-N` rule is ever exercised.

- **Cost:** an archive-template design constraint. Not a limitation in practice — one post list per archive is the correct pattern anyway.
- **Risk:** none. Applies to a site that does not exist yet.
- **Scope:** `.online` only. Does nothing for production today.

**This is the permanent fix, and it is free if we decide it before building.**

### Option B — Block crawling on production via robots.txt

```
Disallow: /*/paged-*
```

- **What it does:** stops Googlebot spending crawl budget on ~154 URLs. This is the correct tool: Google's own guidance is robots.txt for crawl budget, `noindex` for index control.
- **Why it is safe here:** these URLs are already non-indexed and canonicalised to their parent archives. They carry **zero clicks and zero impressions**. Blocking loses nothing.
- **Real risk — pattern breadth.** `/*/paged-*` must be verified against the full 787-URL register so it cannot match a legitimate URL. Yoast writes robots.txt dynamically, so the edit path and its persistence must be confirmed.
- **Second-order effect:** blocked URLs stop reporting canonical signals. Acceptable, because they are already resolved and worthless.
- **Rollback:** delete the line. Immediate, complete, no residue.

### Option C — Remove or restrict the rewrite rules

Only viable once the cause is confirmed, and only if nothing legitimate depends on them. **Higher risk** — deregistering a rule the builder relies on can break pagination on 8 archives that currently work. Testing on `.online` first is mandatory.

### Recommended combination

**Option A for `.online` (permanent, free, decided now) + Option B for production (interim, reversible, recovers crawl budget while we build).**

---

## 4. PAYPAL `?wc-ajax=ppc-*` ENDPOINTS — 7 URLs

`/?wc-ajax=ppc-create-order` · `ppc-save-checkout-form` · `ppc-vault-paypal` · `ppc-create-payment-token` · `ppc-create-setup-token` · `ppc-change-cart` · `ppc-update-customer-id`

These are WooCommerce PayPal Payments internal AJAX endpoints. **They should never have been crawlable.**

**Fix:**
```
Disallow: /*wc-ajax=
```

**Why this is safe — the point that usually causes hesitation:** robots.txt governs **crawlers only**. It has no effect whatsoever on the site's own JavaScript. Checkout, cart updates and PayPal flows continue working exactly as they do now. This is standard WooCommerce practice.

- **Risk:** low. Must still be verified end-to-end on `.online` with a live checkout test — non-negotiable now that D-002 keeps the store.
- **Rollback:** delete the line.
- **Also worth finding:** *why* these appeared as crawlable URLs at all. Google found them somehow — likely an `<a href>` or a script-injected link. Worth locating rather than only suppressing.

---

## 5. AUTHOR ARCHIVES — 22 URLs

Five author archives plus paged permutations, several already 404ing (`/author/abusayed/page/2/`, `/author/shammi/`).

This is an **architecture decision, not a bug** (§17). Three options:

| Option | Effect | Note |
|---|---|---|
| Disable author archives in Yoast | 404 or redirect; removes ~22 URLs | `/author/catherine/` has 17 clicks — small but real loss |
| Noindex, keep accessible | Stops indexing; **does not save crawl budget** | Half a fix |
| Keep and build properly | Real author pages with bios | Supports §32 founder authority — Jamil's own archive already has traffic |

**My view:** for a consultancy whose strategy runs on **founder authority** (§32), deleting author archives is the wrong instinct. Build **one** proper author page for Jamil, retire the rest. But this is your call and it belongs in ARCHITECT, not in a crawl-budget fix.

---

## 6. THE THING NOBODY THINKS OF AS CRAWL BUDGET — SERVER SPEED

From the crawl: **mean response time 1.92s, median 2.01s, max 3.06s.** The homepage serves **739 KB of HTML** before assets.

**Google reduces crawl rate on slow servers.** Crawl budget is partly a function of how fast the host responds — a site answering in 2 seconds gets crawled materially less than one answering in 300ms.

So the heavy plugin stack (Baseline v2, R6) is not only a Core Web Vitals problem. **It is directly throttling how much of the site Google crawls**, which compounds the junk-URL problem.

The fresh build on `.online` (D-001) addresses this structurally — production's plugin bloat is not being inherited. Worth stating plainly as a benefit of a decision you have already made.

---

## 7. GETTING THE 58 PAGES ACTUALLY CRAWLED

Clearing waste is necessary but not sufficient. Full sequence:

1. **Clear the crawl waste** — sections 3 and 4.
2. **Relink the orphans** (O-002, still awaiting your approval). All 58 have **zero internal links**. Google will not prioritise crawling a page nothing links to. **This is the single highest-leverage action available and it changes no URL.**
3. **Verify sitemap coverage.** Many orphans may be missing from the XML sitemaps entirely. Requires checking, not assuming.
4. **Request indexing manually** for the highest-value 10–15 via URL Inspection — starting with `/services/website-maintenance-services/` (66 clicks, never crawled).
5. **Improve response time** — section 6.

---

## 8. SEQUENCE

| # | Action | Where | Risk | Approval |
|---|---|---|---|---|
| 1 | Confirm the `/paged-N/` cause | `.online` + read-only production inspection | None | **Requested** |
| 2 | Design archive templates to prevent recurrence | `.online` | None | Part of ARCHITECT |
| 3 | Test robots.txt patterns against the 787-URL register | `.online` | None | **Requested** |
| 4 | Verify checkout works with `wc-ajax` blocked | `.online` | None | **Requested** |
| 5 | Written change proposal per §38 | — | None | — |
| 6 | Apply robots.txt changes to production | **PRODUCTION** | Low, reversible | **Separate approval required** |
| 7 | Relink orphans | PRODUCTION | Very low | O-002 — pending |
| 8 | Request indexing for top orphans | PRODUCTION | None | Pending |

**Steps 1–5 touch nothing on production and are what I am asking to start.**
**Steps 6–8 each require their own explicit approval on the specific change.**

---

## 9. RISK REGISTER FOR THE PRODUCTION STEP (§38)

**What changes:** two `Disallow` lines in production's robots.txt.

**Why:** to stop Googlebot spending its crawl allocation on ~161 valueless URLs so it reaches 58 real pages holding 383 clicks.

**Evidence:** GSC Page Indexing drilldowns, 21 Aug 2026 — all six categories exported and analysed.

**SEO risk:** low. Every URL affected is already non-indexed, canonicalised, and has zero clicks and zero impressions across 16 months.

**What could be lost:** nothing measured. The residual risk is an **over-broad pattern** matching a legitimate URL — which is exactly why step 3 tests both patterns against all 787 URLs before anything is proposed.

**How it is tested:** patterns validated against the full register on `.online`; live checkout tested with `wc-ajax` blocked; robots.txt tester used before and after.

**How it rolls back:** delete the lines. Instant, complete, no residue. Googlebot resumes crawling those URLs on its next pass.

**Monitoring:** GSC Page Indexing weekly — watch *Discovered — currently not indexed* fall and *Indexed* rise. Expect movement over 2–6 weeks, not days.

---

## 10. WHAT I AM ASKING FOR

**Approval to run steps 1–5 — diagnosis and testing on `.online`, plus read-only inspection of production's rewrite rules and code snippets.**

To do step 1 properly I need from you:

1. **wp-admin access to production, read-only** — or export the rewrite rules yourself (`wp rewrite list --format=csv`, or the `rewrite_rules` row from `wp_options`).
2. **A list of every active snippet in WPCode and Code Snippets** on production.
3. **The full production plugin list** (Plugins → Installed Plugins, screenshot is fine).

**Nothing on reinforcelab.com changes until you approve a specific, written proposal.**

---

**Production status: UNTOUCHED. 765 URLs PENDING · 17 APPROVED — PRESERVE · 5 APPROVED — NEW URL.**
