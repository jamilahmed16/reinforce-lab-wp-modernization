# REINFORCE LAB — INDEXATION DIAGNOSIS v2

**Project:** SEO-Safe WordPress Modernization
**Phase:** DISCOVER — complete
**Version:** 2.0 — **supersedes v1.0 (same date). v1 reached the wrong conclusion; see §1.**
**Date:** 20 August 2026
**Companion file:** `Reinforce_Lab_URL_Decision_Register_v3.xlsx` — 787 URLs

**Sources:** GSC Page Indexing + **all six issue drilldowns**, exported 21 Aug 2026 · GSC Performance 16 months · Screaming Frog 21 Aug 2026 · live read-only verification `[VERIFIED]`

**Production status: UNTOUCHED.**

---

## 1. CORRECTION — I READ THIS WRONG TWICE

The drilldown lists change the diagnosis, so both of my earlier readings need withdrawing:

**Withdrawn #1 — "the 38 noindex pages are the priority."** They are **23 RSS `/feed/` URLs, `/cart/`, `/product-category/uncategorized/`, `/sitemap_index.xml`, 7 parameter URLs and 6 paged archives.** Every one is intentional, correct WordPress and Yoast behaviour. **Zero clicks affected. Not a defect. Nothing to recover.** (My follow-up guess that they were date archives was also wrong — they're feeds.)

**Withdrawn #2 — "178 crawled-not-indexed is the signature of a site-quality demotion."** Too broad. **126 of the 178 are junk URLs, not content:**

| What's actually in "Crawled — currently not indexed" | Count |
|---|---|
| Paginated archives (mostly malformed `/paged-N/`) | 77 |
| Author archives (mostly malformed paged) | 22 |
| Parameter URLs (7 are PayPal `?wc-ajax=ppc-*`) | 10 |
| RSS feeds | 6 |
| WooCommerce | 4 |
| Truncated/broken service URLs | 4 |
| Asset file | 1 |
| **Real content pages** | **52** |

**And the whole 178-URL category holds just 26 clicks.** This is not where the traffic went.

---

## 2. THE ACTUAL DIAGNOSIS: CRAWL-BUDGET STARVATION

Put the two "not indexed by Google systems" categories side by side and the picture resolves:

| Category | URLs | What's in it | Clicks held |
|---|---|---|---|
| **Crawled — currently not indexed** | 178 | **126 junk URLs** + 52 weak content pages | **26** |
| **Discovered — currently not indexed** | 67 | **58 real content pages** | **383** |

**"Discovered — currently not indexed" means Google found the URL and has never crawled it.**

So: Google is spending its crawl allocation on malformed pagination, author archive permutations, PayPal AJAX endpoints and RSS feeds — while **58 real content pages holding 383 clicks sit in a queue Google has never got to.**

Count the junk across all categories:

- **77** malformed `/paged-N/` URLs in *Alternate page with proper canonical tag*
- **77** more paginated archives in *Crawled — currently not indexed*
- **22** author archive permutations
- **10** parameter URLs including 7 PayPal endpoints
- **6** feeds

**Roughly 190 junk URLs** competing for crawl budget on a site with about 200 real pages. **Close to half of everything Google crawls here is machine-generated noise from one rewrite bug and one plugin.**

**This is technical, it is ours, and it is fixable.** That is a materially better diagnosis than "Google decided your content isn't good enough" — and it is better supported by the evidence. `[INFERENCE — well supported]`

**The honest caveat stands:** GSC retains Page Indexing data for ~90 days, so this describes **the present state** and cannot prove what happened in September–October 2025.

---

## 3. ONE FINDING THAT DIRECTLY AFFECTS AN APPROVED DECISION

**`/services/website-maintenance-services/` — 66 clicks, your only service page with real organic traffic — is `Discovered — currently not indexed`. Google has never crawled it.**

It is one of the 17 URLs you approved as `APPROVED — PRESERVE` under D-005. The other 16 are fine — none appear in any not-indexed list.

**PRESERVE alone will not save this page**, because there is nothing to preserve while Google won't index it. It needs recovery — internal links and a re-crawl request — not just protection. **I have not acted.** Flagged for your decision.

---

## 4. THE 58 CONTENT PAGES GOOGLE HAS NEVER CRAWLED

These hold 383 clicks and over 1.25 million impressions between them. The largest:

| URL | Clicks | Impressions |
|---|---|---|
| `/services/website-maintenance-services/` | **66** | 277,583 |
| `/writesonic-review/` | 34 | 42,500 |
| `/20-content-marketing-ideas-for-restaurants/` | 33 | 47,095 |
| `/a2-wordpress-hosting/` | 30 | 27,510 |
| `/how-to-avoid-zero-click-searches/` | 27 | 10,805 |
| `/youtube-seo/` | 24 | 206,032 |
| `/real-estate-social-media-posts-ideas/` | 21 | 28,368 |
| `/seo-mistakes-to-avoid/` | 13 | 80,749 |
| `/jasper-review/` | 11 | 19,339 |
| **`/what-does-an-seo-consultant-do/`** | 4 | **617,544** |

**Nine are Tier 2 URLs in the register.** Every one of these is also **orphaned** — zero internal links. The two facts are almost certainly the same fact: **Google can't prioritise crawling a page nothing links to, on a site whose crawl budget is being eaten by junk.**

---

## 5. THE 52 CONTENT PAGES GOOGLE CRAWLED AND REFUSED

Different problem, different answer. A clear pattern runs through them:

**The category archives are duplicate boilerplate.** `/business/`, `/b2b-marketing/`, `/clothing-brand-marketing/`, `/digital-marketing/content-marketing/`, `/digital-marketing/search-engine-optimization/`, `/business/small-business/`, `/video-marketing/` — **every one is exactly 670 words.** Identical template text with a post list. Google declined all of them.

**`/business/` has 1,581 internal inlinks and is not indexed.** More internal link equity flows into that one page than any other URL on the site, and Google won't have it. That is a straight architectural loss.

**Also here:** `/shop/` (which renders blog posts), 4 WooCommerce product URLs, and truncated URLs — `/services/content-`, `/services/ecommerce-`, `/get-a-` — which indicate broken links being emitted somewhere in the templates or content.

**These need rebuilding or removing. Preserving them achieves nothing** — Google has already refused them.

---

## 6. NEW DEFECTS FOUND IN THE DRILLDOWNS

| Defect | Detail |
|---|---|
| **PayPal AJAX endpoints crawled** | 7 URLs — `/?wc-ajax=ppc-create-order`, `ppc-save-checkout-form`, `ppc-vault-paypal`, `ppc-create-payment-token` and others. Payment-flow endpoints should never be crawlable. |
| **Truncated URLs being emitted** | `/services/content-`, `/services/ecommerce-`, `/get-a-` — broken links in templates or content. |
| **Malformed redirect URLs** | `/successful-digital-marketing-campaign-examples//1000` and `/1000` — on a Tier 1 page (135 clicks). |
| **404 with clicks** | `/author/shammi/` (2 clicks) and `/wp-content/uploads/2020/03/Reinforce-Lab-Digital-Pricing-List-2020.pdf` (1 click). |
| **Robots patterns reported as 404 URLs** | `/wp-*.php`, `/wp-content/*`, `/wp-content/plugins/*` — something is emitting robots.txt patterns as crawlable URLs. |
| **Empty indexable tag archives** | 3 tag archives, zero posts each, all `index, follow`. |

---

## 7. WHAT THIS MEANS

**1. There is a recoverable asset, and it is bigger than the "protect" list.** 383 clicks sit in pages Google has never crawled. If the crawl-budget problem is fixed and those pages are linked, some of that is recoverable — without changing a single URL. That is the most valuable finding in this report.

**2. The fix sequence is now evidence-led, and it inverts the usual order.** Clear the crawl waste first (~190 junk URLs from one rewrite bug and one plugin). Then relink the orphans. Only then worry about content quality. Rebuilding content while Google is still spending its crawl budget on `/author/farihaanika/paged-3/8/` would waste the effort.

**3. Content quality is a real but secondary problem.** 52 declined content pages is meaningful — particularly the 670-word duplicate category archives — but it is not the primary cause and it is not where the traffic went.

**4. §31 is reinforced.** The declined pages are boilerplate and thin archives. More volume would make this worse. Content needs a role, not a word count.

---

## 8. REGISTER v3 — 787 URLs

The index report exposed **249 URLs that neither the crawl nor the sitemaps revealed.** The register now covers **787 URLs**, each carrying its actual Google indexation status.

| Recommendation | URLs |
|---|---|
| FIX — crawl waste (rewrite bug) | 218 |
| REMOVE / CONSOLIDATE candidate | 133 |
| DECLINED BY GOOGLE — rebuild or remove | 88 |
| EXCLUDE — not a page | 76 |
| RECOVER — never crawled | 42 |
| OK — intentionally noindexed | 38 |
| LOW VALUE — review | 34 |
| **RECOVER — never crawled, earns clicks** | **25** |
| FIX — broken URL | 24 |
| PRESERVE — TIER 3 | 23 |
| FIX — parameter indexed | 15 |
| PROTECT — TIER 1 | 13 |
| PROTECT — TIER 2 | 13 |
| ARCHITECTURE DECISION | 12 |
| PRESERVE — TIER 3 + RELINK | 11 |
| REBUILD (no organic value) | 9 |
| PROTECT — TIER 2 + RELINK | 6 |
| PROTECT — TIER 1 + RELINK | 3 |
| FIX — malformed URL | 3 |
| HIGH IMPRESSION / ZERO CLICK | 1 |

**17 URLs are `APPROVED — PRESERVE` (D-005). 5 are `APPROVED — NEW URL` (D-006). The remaining 765 are `PENDING`.**

---

## 9. NEXT TASK

### Authorize the crawl-waste fix — investigated on `.online` first.

This is the root cause, and it is the one thing that unblocks everything downstream.

**What I am asking permission to do:**

1. **Diagnose the `/paged-N/` rewrite bug on reinforcelab.online**, using a copy of production's rewrite rules — not by touching production. Identify what generates `/blog/paged-3/18/` and `/author/farihaanika/paged-2/17/`.
2. **Produce a tested fix** with a documented rollback path (§23), verified on `.online`.
3. **Bring you a written change proposal** covering: what changes, why, the evidence, the SEO risk, what could be lost, how it's tested, how it rolls back (§38).

**What I am not asking for and will not do:** any change to production. No rewrite rule, robots directive, plugin setting or redirect touches reinforcelab.com without a separate, explicit approval from you on that specific change.

**Why this before content work.** Roughly 190 junk URLs — nearly half of Google's crawl surface here — come from one rewrite bug and one plugin's AJAX endpoints. Until that is cleared, 58 real content pages holding 383 clicks stay in a queue Google never reaches, and any content we rebuild joins the same queue.

**Two smaller items I'd fold into the same investigation, all diagnosis-only on `.online`:** the source of the truncated URLs (`/services/content-`, `/get-a-`), and whether the PayPal `?wc-ajax=` endpoints can be excluded from crawling without breaking checkout — which matters more now that D-002 keeps the store.

---

**Still open:** GA4 landing pages (O-011) · production footer 404s (O-009) · orphan relinking authorization (O-002) · Beaver Builder + Themer licences (O-003) · `/services/website-maintenance-services/` recovery (§3 above).

**Production status: UNTOUCHED. 765 URLs PENDING · 17 APPROVED — PRESERVE · 5 APPROVED — NEW URL.**
