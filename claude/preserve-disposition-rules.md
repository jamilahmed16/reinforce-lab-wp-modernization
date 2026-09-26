# PRESERVE — URL DISPOSITION RULES (D-014 — APPROVED)

**Date drafted:** 10 September 2026 · **Approved:** 10 September 2026 (Jamil)
**Status:** `APPROVED — ACTIVE` as **D-014**. The framework is locked; classification may run. **Application to any URL, redirect, or site still requires Jamil's per-URL/batch approval of the resulting sheet — nothing executes on production until the approved migration cutover (guardrails §4).**

**Approved parameters:**
- **Equity threshold = ≥8 clicks in 16 months, OR currently indexed-and-ranking** (D-a).
- **Off-brand top earners = keep URL + REWRITE / CONSOLIDATE** (D-b, R6) — never retire live equity.
- **Retire mechanism = 410 for pure junk, 301 for real pages with inbound value** (D-c, R1/R8).
- **Money / position-1 pages = mandatory HOLD, individual sign-off** (D-d, guardrail §4.2).

**Purpose:** turn the DISCOVER evidence (F-007→F-015) into a repeatable, auditable way to assign each of the 765 pending URLs a disposition — so classification is mechanical and defensible, not ad-hoc. Governed by [migration-and-data-requirements.md](data/../migration-and-data-requirements.md) and D-012.

---

## 1. Disposition vocabulary

| Disposition | Meaning | Content action |
|---|---|---|
| **PRESERVE** | Same slug survives on the new site | REBUILD page to D-012 standard |
| **PRESERVE-URL + REWRITE** | Keep slug (it holds equity) but re-angle content toward positioning | REWRITE |
| **301** | Slug retired; redirect old → a different surviving URL | REBUILD/REWRITE at new slug |
| **CONSOLIDATE** | Merge a cluster of thin/overlapping pages into one canonical; 301 the rest into it | MERGE |
| **REBUILD (new)** | On-strategy topic, page is unindexed/never-crawled — build fresh under new IA | BUILD NEW |
| **HUB-REVIEW** | Affiliate review/roundup pages — keep, but consolidated under a siloed hub (not retired) | CONSOLIDATE + REWRITE |
| **RETIRE → 301** | Remove; 301 to nearest relevant surviving hub (has some inbound signal) | DROP |
| **RETIRE → 410** | Remove; return 410 Gone (pure junk, no equity, no destination) | DROP |
| **KEEP-noindex** | Must exist but must not rank (transactional/utility) | REBUILD + noindex |
| **HOLD** | Do not auto-classify — needs Jamil's explicit per-URL decision | — |

First five extend the register's base vocabulary (PRESERVE / 301 / CONSOLIDATE / RETIRE→301 / KEEP-noindex) with **RETIRE→410**, **REBUILD**, and **HOLD**.

---

## 2. Signals (all from primary data already in hand)

- **Indexation** (Coverage, F-008): indexed / crawled-not-indexed / discovered-never-crawled (1970) / noindex / 404 / alternate-canonical
- **Organic earnings** (Performance Pages.csv, F-007): clicks + impressions over 16 months
- **External links** (Links, F-010): homepage holds ~93%; deep pages ≈ 0
- **Internal links** (Links, F-011): nav/footer-linked vs orphaned
- **On-strategy?** — matches the AI Growth Systems positioning + AI-search/SEO + the 6 industries (Pharma/Life-Sci, Healthcare, B2B SaaS, Manufacturing, Professional Services, Technology). Off-strategy = hosting/tool reviews, affiliate, generic "social-media-content-ideas-for-X".
- **Junk?** — `/paged-N/M/`, `/feed/`, `?wc-ajax=`, `/wp-json/`, `*sitemap.xml`, author archives, malformed/truncated slugs (F-008/F-009)
- **Existing redirect?** — one of the 37 live Yoast rules (F-015)

**Equity test (proposed):** a URL *has equity* if **≥10 clicks over 16 months OR currently indexed-and-ranking (avg pos ≤ ~30 with impressions)**. Otherwise *no meaningful equity*. ⟵ threshold is Jamil's to confirm.

---

## 3. Classification rules — FIRST MATCH WINS

Apply top-down; the first rule that matches sets the disposition.

- **R1 — Junk technical URL** → **RETIRE → 410** (and do-not-recreate). `/paged-N/`, feeds, `wc-ajax`/`wp-json`, sitemaps, author-archive junk, malformed slugs (`/services/content-`, `/video-marekting/`). `/paged-N/` is also prevented structurally by F-001, so it won't regenerate.
- **R2 — Already has a Yoast redirect (one of 37)** → **carry over, FLATTENED** to point directly at the final live target (kills the F-015 chains). Reconcile into the new map.
- **R3 — Transactional / functional** (cart, checkout, my-account, order-received, internal search) → **KEEP-noindex** (rebuilt in commerce scope, D-002).
- **R4 — Core site page** (home, about/our-team, contact, get-a-free-quote, portfolio, blog index, the live `/services/*` pages, live products) → **PRESERVE** (same slug where sound; rebuild to D-012). Home = crown jewel (F-010).
- **R5 — Real earner + on-strategy** → **PRESERVE + REBUILD** to standard.
- **R6 — Real earner + OFF-core-positioning** (e.g. `social-media-content-ideas-for-clothing-brand` = 699 clicks) → **PRESERVE-URL + REWRITE** toward positioning, or **CONSOLIDATE** if it's one of a thin cluster. **Never retire live equity.**
- **R7 — On-strategy but unindexed / never-crawled / crawled-rejected** (`/dental-seo/`, `/technical-seo/`, `/youtube-seo/`, `a-complete-woocommerce-seo-guide`, unindexed service pages) → **REBUILD (new)** under the new IA; old slug PRESERVE if clean, else 301 to the new equivalent (single hop).
- **R8 — Off-positioning + no meaningful equity** (hosting reviews, tool reviews, affiliate) → **RETIRE → 301** to the nearest relevant hub if it has inbound internal links; **RETIRE → 410** if it has none. (F-010: near-zero backlink loss either way.)
- **R9 — Thin / near-duplicate cluster** (e.g. `digital-marketing-competitor` vs `-analysis`; overlapping "content-marketing-for-X") → **CONSOLIDATE** into one canonical; 301 the rest.
- **R10 — Default / uncertain** → **HOLD** (manual review). Never guess.

---

## 4. Guardrails (non-negotiable)

1. **Evidence-required.** No disposition without a data signal. Unknown → HOLD, never a guess.
2. **Mandatory HOLD for money/position pages.** Any page that is position-1 or a top earner — e.g. `/content-marketing-for-plastic-surgeons/` (pos 1), `/social-media-content-ideas-for-clothing-brand/`, `/best-examples-of-great-food-copywriting/` — gets **explicit per-URL sign-off** regardless of rule. Ties to O-006 (was one changed off-chain?).
3. **Every 301 is single-hop.** Flatten all chains (F-015); no redirect points at a URL that itself redirects.
4. **Deconflict new slugs.** The 5 approved new `/services/…` slugs (D-003) checked against live `/services/*` and `/services/creative/*` targets (F-015) before use.
5. **No production execution here.** Dispositions are *planned* on the register and in the redirect map; they execute only at the approved migration cutover, per-URL approval still required (§10).
6. **No bulk operations (F-003).** Classification is desk work; any application happens in reviewed batches, never a mass redate/publish/redirect pass.
7. **`.online` stays noindex** until launch (D-012).

---

## 5. Workflow once approved

1. Join the register (765 pending) against the primary data (Pages.csv clicks, Coverage buckets, Links, the 37 redirects).
2. Auto-assign R1–R9 where a rule cleanly matches; everything else → HOLD.
3. Produce a **proposed-disposition sheet**: URL · disposition · content action · rule fired · evidence · (for 301/CONSOLIDATE) target.
4. Jamil reviews — approves in batches; HOLD + money pages decided individually.
5. Only approved rows move to `APPROVED` state and into the tested redirect map. **Migration is not scheduled until the map is complete and tested.**

---

## 6. Decisions — RESOLVED (10 Sep 2026)

- **D-a — Equity threshold:** ✅ **≥8 clicks/16mo OR indexed-and-ranking.**
- **D-b — Off-brand top earners:** ✅ **keep URL + REWRITE / CONSOLIDATE.**
- **D-c — Retire mechanism:** ✅ **410 pure junk, 301 real pages with inbound.**
- **D-d — Mandatory-HOLD list:** ✅ money/position-1 pages always require Jamil's individual sign-off.
- **D-e — Affiliate review pages → HUB-REVIEW** (Jamil, 10 Sep): the hosting/tool review cluster is **kept and consolidated under a siloed hub**, not RETIRE→301. Conditions (RECOMMENDATION, to keep it SEO-safe): silo the path (e.g. `/resources/` or `/reviews/`, separate from `/services/`); consolidate thin single-host reviews into comparison pages; `rel="sponsored"` on every affiliate link; FTC disclosure; meet D-012; decide indexation deliberately (topical dilution is the trade-off — see F-008 entity-consistency risk).
