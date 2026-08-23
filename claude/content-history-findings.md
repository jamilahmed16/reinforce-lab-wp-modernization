# CONTENT INVENTORY & SITE HISTORY — WXR EXPORT ANALYSIS

**Project:** SEO-Safe WordPress Modernization
**Date:** 20 August 2026
**Source:** WordPress WXR export `reinforcelabltd.WordPress.20260820 1.xml`, 23 MB, WXR 1.2, base site `https://reinforcelab.com` `[VERIFIED]`
**Contents:** 854 items — 187 posts (111 published, 76 drafts) + 667 attachments

**Production status: UNTOUCHED.**

---

## 0. FIRST — THIS DOES NOT ANSWER THE BEAVER THEMER QUESTION

The export contains **posts and attachments only.** No pages, no `fl-theme-layout` (Themer layouts), no `fl-builder-template`, no WooCommerce products, no `projects` CPT.

**F-001 stands as confirmed by Beaver Builder's own forum, but the count of Posts modules per Themer archive template on production is still unverified.** That check is still outstanding.

It does, however, answer several questions we had not asked yet — and one of them is the most important finding in this project so far.

---

## 1. THE FINDING: THE ENTIRE PUBLISHED BLOG WAS BULK-DATED INTO A 9-WEEK WINDOW

**All 111 published posts carry a `post_date` between 1 January and 4 March 2025.**

| post_date | Posts |
|---|---|
| January 2025 | 50 |
| February 2025 | 56 |
| March 2025 | 5 |

**And 99 of the 111 were last modified in a single month — April 2025.**

| post_modified | Posts |
|---|---|
| **April 2025** | **99** |
| March 2025 | 6 |
| All other months (Jan, May, Jul, Nov, Dec 2025; May 2026) | 6 |

**This is not organic publishing history.** A site that has been operating for years, with hosting reviews of 2020-era products and reviews of tools like Copy.ai and Jasper, does not have every post first published in a nine-week window and then 89% of them modified in one month.

**What it means:** a **bulk content operation** was performed in early 2025 — a mass redate, republish, or rewrite of the entire blog, followed by a mass modification pass in April 2025.

---

## 2. THE TIMELINE — CORRELATION, NOT PROOF

| When | What |
|---|---|
| Jan – Mar 2025 | All 111 published posts dated into this window |
| **April 2025** | **99 of 111 posts bulk-modified** |
| 19 Apr 2025 | GSC data begins — 16,511 impressions on day one |
| Jul 2025 | **Peak: 525 clicks, 1,115,834 impressions** |
| **Sep – Oct 2025** | **Collapse begins: impressions 630,590 → 226,041 in one month** |
| Aug 2026 | 27 clicks, 45,120 impressions. 53% of published posts not indexed |

**Bulk content operation → strong initial performance → collapse roughly five months later → mass de-indexing.**

`[INFERENCE — strongly supported by correlation. NOT proven.]` Google's Page Indexing data only retains ~90 days, so we cannot observe indexation in September 2025 and cannot demonstrate causation. What we can say is that the pattern — a bulk refresh producing a short-lived lift followed by a site-level reassessment and demotion — is consistent with every piece of evidence we hold, and no competing explanation fits as well.

**The operational implication is the actionable part, and it does not depend on proving causation:** whatever produced this, **repeating a bulk content operation on the new site carries real risk.** This directly reinforces §31 — content must have a role, not add page count.

---

## 3. 53% OF THE PUBLISHED BLOG IS NOT IN GOOGLE'S INDEX

Cross-referencing all 111 published posts against the GSC Page Indexing drilldowns:

| Status | Posts | Share |
|---|---|---|
| Presumed indexed | **52** | 47% |
| **Discovered — never crawled** | **40** | **36%** |
| **Crawled — declined** | **19** | **17%** |

**59 of 111 published posts — 53% — are not indexed.**

These are not thin pages. Published posts average **3,270 words** (median 2,967, max 8,723), and **every one of the 111 has a Yoast focus keyword set.** This was actively managed SEO content.

**Never crawled, with real earnings:**

| Post | Words | Clicks | Impressions |
|---|---|---|---|
| 20 Content Marketing Ideas for Restaurants 2025 | 4,830 | 33 | 47,095 |
| How to avoid Zero Click Searches 2025 | 1,943 | 27 | 10,805 |
| Content Marketing vs Social Media Marketing | 2,706 | 8 | 53,218 |
| 10 Best Blog Promotion Ideas | 3,308 | 2 | 48,421 |
| How To Find Your Target Audience on Instagram | 2,168 | 2 | 11,661 |

**Crawled and declined:**

| Post | Words | Impressions |
|---|---|---|
| E-Commerce Retargeting Strategies to Boost Sales | 2,597 | 5,534 |
| How to use keywords in Content | 1,880 | 2,223 |
| What Are The Best Social Media Platforms For Business? | 4,169 | 490 |
| What Is Content Marketing… Step-by-Step Guide | 4,472 | 56 |

---

## 4. GOOD NEWS FOR THE MIGRATION (D-001)

**The published post content is clean and portable.**

| Check | Result |
|---|---|
| Divi shortcodes (`[et_pb_...]`) in published content | **0 of 111** |
| `_et_pb_use_builder = on` | **0 of 111** |
| `_fl_builder_enabled = 1` (Beaver Builder) | **3 of 111** |
| Yoast `noindex` set on a post | **0 of 111** |

**108 of 111 published posts are plain, portable content.** Migrating them under D-001 is low-risk and low-effort — no builder conversion, no shortcode cleanup.

---

## 5. LEGACY BUILDER RESIDUE — A MIGRATION HAZARD

The post metadata carries layers from **at least two previous page builders and several retired plugins**:

| Meta prefix | Items | Origin |
|---|---|---|
| `_et_pb_*`, `_et_post_*`, `_et_monarch_override` | ~650 | **Divi Builder + Monarch** (Elegant Themes) |
| `_et_pb_old_content` | 642 | Divi's stored pre-Divi content |
| `_fl_builder_*` | 4 | Beaver Builder |
| `litespeed-optimize-*` | ~780 | LiteSpeed Cache |
| `resmushed_*` | ~660 | reSmush.it |
| `_mi_skip_tracking` | 605 | MonsterInsights |

**The site previously ran Divi.** That explains the `?et_blog` parameter URLs found in the crawl-waste analysis (F-002).

The content itself is clean — this is **residue, not active markup** — but it confirms the site has been through at least one prior builder migration, and it means **any database-level migration would carry thousands of dead meta rows across.** D-001's build-fresh decision avoids this entirely. Another point in its favour.

---

## 6. 76 DRAFTS — AN UNUSED ASSET, AND A TRAP

**61 of 76 drafts exceed 1,000 words.** Average 2,003 words, largest 5,147.

By date: 2018 (1) · 2022 (10) · **2023 (63)** · 2024 (1) · 2025 (1)

**There is a coherent topical cluster sitting in there.** At least seven dental/local-SEO drafts:

- 10 Local SEO Strategies for Dentists to Attract More Patients (4,233 words)
- The Ultimate Guide to Choosing the Right Dental Marketing Firm (3,929)
- How to Drive More Traffic to Your Website with Dental SEO Services (3,698)
- 10 Best Dental SEO Marketing Tips to Grow Your Practice (3,615)
- How To Choose the Best Dental SEO Company (3,468)
- Dental Marketing Agency: How SEO Agency Can Help You Get More Patients (3,404)
- 10 Reasons Why Your Business Needs SEO Consulting Services (3,268)

Plus hosting and tool reviews: Namecheap, Stablehost, Name.com, AWeber, Buffer, ContentStudio.

**Two honest observations, pulling in opposite directions:**

**The opportunity.** This is roughly 122,000 words of drafted content that cost real money to produce and is earning nothing. The dental cluster is healthcare-adjacent, which brushes one of the six locked industries (§5).

**The trap — and it is the bigger of the two.** Publishing 61 drafts in a batch would repeat **precisely the pattern that appears to have preceded the collapse.** On a site where Google is already declining to index 53% of published posts, a bulk publish is the single most dangerous content action available.

**These drafts also target consumer local-SEO buyers — dentists — not enterprise Pharma, Healthcare, B2B SaaS, Manufacturing, Professional Services or Technology.** Against the locked positioning (§2, §5), they point the wrong way.

**My recommendation: leave them unpublished for now.** Revisit individually at the CONTENT phase, if at all. **No action taken, no decision made — this is yours (§40).**

---

## 7. DATA COMPLETENESS (§12)

- The export contains **111 published posts**. The production `post-sitemap.xml` listed **~128 URLs** (including `/blog/`). A gap of roughly 16 URLs is unexplained — the export may be partial, or the sitemap may include posts outside this export's scope. **Do not treat 111 as the complete published-post count without confirming.**
- **No pages, no Themer layouts, no products, no `projects` CPT** are in this file. The page inventory is still only known from the crawl and sitemaps.
- Category and tag term definitions are absent from the export header (`<wp:category>` and `<wp:tag>` blocks are empty), so category structure cannot be confirmed from this file.

---

## 8. WHAT CHANGES

**1. We now have a plausible, evidence-backed account of the decline** — a bulk content operation in early 2025, a short-lived lift, then a site-level reassessment. Not proven, but coherent and consistent with everything else we hold.

**2. The content migration is easier than feared.** 108 of 111 published posts are clean, portable content with no builder markup.

**3. The rebuild must not repeat the pattern.** No bulk publishing, no bulk redating, no mass modification passes. Content ships deliberately, with a role, and is measured.

**4. The 40 never-crawled published posts are the recovery target.** Substantial content, already written, already earning impressions, invisible because nothing links to it and Google's crawl budget is being spent on `/paged-N/` junk. **This is the same problem as F-001 and F-002, viewed from the content side.**

---

## 9. NEXT TASK

### Confirm the Themer archive layouts — two minutes, closes F-001 outright.

The WXR export could not answer this. It remains the last open item in the crawl-waste diagnosis.

**On production: Beaver Builder → Themer Layouts → filter to Archive layouts.** For each one, tell me:

1. How many **Posts modules** it contains
2. Whether any two layouts target the **same location** (e.g. both set to "All Archives", or one on "All Archives" and another on "Blog")

If any archive layout has **two or more Posts modules**, or two layouts overlap on one location, that confirms F-001 outright and I can write the production change proposal immediately — the risk testing in F-002 is already complete.

A screenshot of the Themer Layouts list plus one archive layout open in the builder would answer both questions.

---

**Still open:** GA4 (O-011) · production footer 404s (O-009) · orphan relinking (O-002) · Beaver Builder licences (O-003) · `/services/website-maintenance-services/` recovery · WPCode + Code Snippets inventory.

**Production status: UNTOUCHED. 765 URLs PENDING · 17 APPROVED — PRESERVE · 5 APPROVED — NEW URL.**
