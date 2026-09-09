# REINFORCE LAB — SEO / GEO / AEO / AI-SEARCH BUILD STANDARD

**Status:** BINDING. Every page, template, and component built on `.online` must meet this before it is considered done.
**Date:** 10 September 2026
**Applies to:** the fresh build on reinforcelab.online, and by extension the eventual production site after migration.
**Companion docs:** [migration-and-data-requirements.md](migration-and-data-requirements.md) · [decision-log.md](decision-log.md) · [phase-1-gsc-baseline.md](phase-1-gsc-baseline.md)

> One line: build pages a search engine can crawl perfectly, a human can convert on, and an LLM can quote verbatim.

---

## 0. Non-negotiables (the gates)

A page does not ship until ALL of these pass:

1. **Semantic HTML** — exactly one `<h1>`; logical `<h2>`/`<h3>` order; real landmarks (`<header>`,`<main>`,`<nav>`,`<footer>`); no heading levels used for styling. (Beaver Builder HTML modules must output real tags, not `<div>` soup.)
2. **Unique title + meta description** — written per page, not templated; primary entity/keyword near the front of the title; brand suffix "Reinforce Lab".
3. **Self-referencing canonical**, correct and absolute.
4. **Indexability correct** — `.online` stays `noindex` sitewide until launch (`blog_public = 0`, verified). Production pages ship `index,follow` unless a specific URL is approved otherwise.
5. **Structured data** valid (see §3) — passes Rich Results / schema validation with zero errors.
6. **Core Web Vitals budget** met (see §2).
7. **Answer-first** — the page's core question is answered in the first sentence/þ block (see §4).
8. **Internal links** — every new page links out to relevant pages AND is linked to from relevant pages (no orphans — this is the single biggest fix from DISCOVER).
9. **Design pre-flight** (`novamira/check-design`) passes, and the F-001 archive rule holds (one Posts module per Themer archive template — never regenerate `/paged-N/` junk).

---

## 1. Technical SEO baseline (every page)

- **URLs:** lowercase, hyphenated, short, no dates, no stop-word stuffing, no `/paged-N/`. New URLs only at approved slugs. Never change an existing production URL without per-URL approval (Rule 2).
- **Headings:** one H1 = the page's promise; H2s = the scannable sections; question-shaped H2/H3 where a query exists.
- **Titles:** ≤ 60 chars where possible (crawl found 49 pages over 60 — do not repeat). Pattern: `Primary Topic | Reinforce Lab`.
- **Meta descriptions:** 140–160 chars, benefit + differentiator + soft CTA. No page ships without one (crawl found 36 missing).
- **Images:** descriptive `alt`, lazy-loaded, modern format (WebP/AVIF), explicit width/height, compressed. No layout shift.
- **XML sitemap:** Yoast-generated, only indexable canonical URLs, submitted at launch. No junk/paged URLs.
- **robots.txt:** allow crawl of real content; disallow the known waste patterns proven safe in F-002 (`/*/paged-*`, `/*wc-ajax=`) — production only, on approval.
- **Breadcrumbs:** visible + `BreadcrumbList` schema on all non-home pages.
- **Pagination (archives):** standard `/page/N/` only. Themer archive templates: exactly ONE Posts module (F-001). Never expose `/paged-N/M/`.
- **Hreflang:** not needed (single-locale) unless we deliberately target markets — do not add speculatively.

## 2. Performance / Core Web Vitals (build budget)

Production's problem was a heavy stack (mean response 1.92s, 739 KB homepage HTML). The fresh build must not inherit it.

- **LCP < 2.5s**, **INP < 200ms**, **CLS < 0.1** (field, mobile).
- HTML weight budget per page: **< 150 KB** pre-asset where feasible.
- LiteSpeed cache on; critical CSS; defer non-critical JS; no render-blocking web-font FOIT (font-display: swap — already used).
- No new plugins without approval (locked stack). Audit every plugin's front-end cost.
- Fonts: self-host or preconnect; subset if possible. (Currently Google Fonts via `@import` — revisit to `<link rel=preconnect>` + `preload` at optimisation pass.)

## 3. Structured data / schema (by template)

All JSON-LD, validated, matching visible content (no schema-only claims).

| Template | Required schema |
|---|---|
| **Sitewide** | `Organization` (name "Reinforce Lab", `legalName` "Reinforce Lab Limited", logo, `sameAs` [LinkedIn, Crunchbase, socials], `contactPoint`), `WebSite` (+ `SearchAction` if search kept) |
| **Home** | Organization + WebSite + (optional) `Service` summary |
| **Service pages** | `Service` (name, description, provider→Organization, areaServed, serviceType) + `BreadcrumbList` + `FAQPage` |
| **Industry pages** | `Service`/`WebPage` + `FAQPage` + `BreadcrumbList` |
| **Blog posts** | `BlogPosting`/`Article` (headline, author→`Person` Jamil Ahmed, datePublished/Modified — REAL dates, no bulk redating per F-003, publisher→Organization, image) + `BreadcrumbList` + `FAQPage` where relevant |
| **About** | `AboutPage` + `Person` (Jamil Ahmed: jobTitle, sameAs LinkedIn, credentials — Pharmacist, Semrush Ambassador) |
| **Contact** | `ContactPage` + `Organization.contactPoint` |
| **Author** | `ProfilePage` + `Person` (founder authority, §32) |

**Entity discipline (E-E-A-T):** the brand string is **"Reinforce Lab"** everywhere (the crawl found "Reinforce Lab / Ltd / Ltd. / Limited" mixed — a real entity-resolution weakness). One name, one logo, one Organization node, consistent `sameAs`. Author = real Person (Jamil) with verifiable credentials and profiles.

## 4. GEO / AEO / AI-search / LLM layer (the differentiator)

This is what most SEO builds skip. It is mandatory here.

- **Answer-first structure:** the H1's implied question is answered in the first 1–2 sentences, in plain, extractable language. AI engines lift the first clear answer.
- **Question-shaped headings:** use real user questions as H2/H3 ("What is an AI Growth System?", "How does SEO for pharmaceutical companies differ?") so the page maps to prompts.
- **FAQ blocks** on every commercial page: 3–6 genuine Q&As, marked up with `FAQPage`, each answer self-contained (quotable without the question).
- **Extractable facts:** definitions, steps, comparisons and specifics stated as clean declarative sentences and, where useful, as tables/lists — the formats AI Overviews, Perplexity and ChatGPT cite. **Real facts only** (charter: never invent metrics/results).
- **Entity clarity:** define who Reinforce Lab is, what it does, and for whom, in machine-parseable prose near the top of key pages (feeds knowledge-graph/LLM grounding).
- **`llms.txt`** at site root: a curated map of the most important pages + a one-paragraph description of the company, for LLM crawlers. Plus a sane AI-crawler policy in robots (allow reputable AI crawlers to the content we want cited; decide GPTBot/CCBot/PerplexityBot/Google-Extended posture with Jamil).
- **Freshness signals:** genuine `dateModified` when content is actually updated (never bulk — F-003).
- **Citations/authority:** link out to authoritative sources where it strengthens a claim; earn mentions. AI engines weight corroborated entities.
- **Clean, JS-light rendering:** content in the initial HTML (server-rendered), not injected by script — LLM crawlers often don't execute JS.

## 5. Internal linking (fixes the #1 DISCOVER problem)

- 337 of 438 GSC URLs had **zero internal links**; 58 real pages holding 383 clicks were never crawled. The new architecture must not repeat this.
- Every page: contextual links to related services/industries/posts; a sensible nav + footer; a breadcrumb.
- The 3 orphaned Tier-1 URLs (D-005 `+ RELINK`) get internal links at migration.
- Topic clusters: each service/industry hub links to its supporting posts and vice-versa.

## 6. Per-template QA checklist (paste into each build)

- [ ] One H1; heading order valid; landmarks present
- [ ] Title ≤60 + unique meta description
- [ ] Canonical correct; indexability correct (noindex on `.online`)
- [ ] Schema present + validates (per §3); matches visible content
- [ ] Answer-first opening; ≥1 FAQ block with `FAQPage`
- [ ] Internal links in + out; breadcrumb
- [ ] Images alt + sized + compressed
- [ ] CWV budget (§2); HTML < ~150 KB
- [ ] No `/paged-N/`; archive = 1 Posts module
- [ ] Design pre-flight passes; on-token
- [ ] Real content, real numbers (no invented metrics)

---

**This standard is locked (see decision-log D-012). Any page that skips a gate is not done.**
