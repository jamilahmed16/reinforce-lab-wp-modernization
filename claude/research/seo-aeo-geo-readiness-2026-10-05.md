# SEO, AEO, GEO and LLM readiness: all 45 published pages on `.online` (5 Oct 2026)

**Asked by Jamil:** "Check how much the all the pages created are ready for SEO, AEO, GEO, AI Searches, LLMs".
**Measured against:** the binding build standard `claude/seo-geo-aeo-standard.md` (D-012): the 10 gates, schema by template, the GEO/AEO layer, internal linking.
**Method (VERIFIED unless marked):** `claude/tools/seo-audit.py` read the live HTML of all 45 published pages (what Google and LLM crawlers receive) and checked titles, meta, headings, schema, answer-first openings, FAQs, links, citations, images and size. Site-wide files (`robots.txt`, `llms.txt`, sitemap), Yoast settings, and a lab performance run at phone size on 6 pages. Google PageSpeed could not be used (the shared API quota was exhausted), and this sandbox's network makes load times unreliable, so Core Web Vitals here are lab readings, not field data. No blog posts are published yet, so post pages were not audited (the 13 post templates were checked when built). Finding F-025.

## Verdict

**The pages themselves are close to ready.** Every page passes the structural gates that matter most for search and AI answers: one H1, clean heading order, an answer-first opening, FAQs marked up with schema, the right schema type per template, server-rendered text, and copy that passes the house rules. **What is not ready is mostly site-wide settings and off-page entity signals**, which are quick to fix, plus **content depth**: no blog posts exist yet, so the topic clusters the standard asks for have no supporting pages.

| Area | Ready | Main gaps |
|---|---|---|
| Technical SEO | 45 of 45 pages pass the core gates | 8 titles over 60 characters; 18 meta descriptions over 160; no canonical tags while noindex (expected on dev, re-check at launch); 26 placeholder `#` links in the header and footer |
| Structured data | 45 of 45 have the schema their template requires | Organization has no `sameAs` profiles and no `contactPoint`; 41 of 45 pages have no `dateModified` |
| AEO (answer engines) | 45 of 45 answer-first; 44 of 44 commercial pages have FAQs with matching `FAQPage` schema; 41 of 45 use question-shaped H2s | Home, Search Authority OS and Diagnostic have no question-shaped H2s |
| GEO and LLMs | Text is in the initial HTML; entity facts consistent (name, founding date, offices) | `llms.txt` is broken (empty links); no AI-crawler policy in `robots.txt`; WordPress site name is "reinforcelab.online"; 18 pages cite no outside source; agent pages do not name Reinforce Lab near the top |
| Performance | Light pages: 108 to 158 KB transferred, 17 to 18 requests | Home layout shift 0.154 in the lab (web font swap); 3 pages just over the 150 KB HTML budget; jQuery, emoji and Bootstrap scripts load on every page |
| Content depth | Service pages 1,460 to 2,120 words; About about 1,900 | 0 blog posts published; Contact (391 words) and Blog index (71) are thin by design |

## 1. Gate by gate (all 45 pages)

| Gate (D-012) | Result |
|---|---|
| 1. Semantic HTML | One H1 on 45 of 45; 0 skipped heading levels; header, nav and footer present. The main area is a `div role="main"` from the theme, not a `<main>` element (works as a landmark; a real `<main>` is cleaner). |
| 2. Title and meta | 45 unique titles, all end with the brand. **8 over 60 characters:** Pharma industry (64), Evidence Verification (65), AEO / GEO (66), Competitor Intelligence (67), Search Performance (62), SEO Content Systems (62), Marketing Automation (63), Lead Generation (61). 45 unique meta descriptions; **18 over 160 characters** (161 to 193, mostly service pages, so Google will cut them) and 2 under 140 (Evidence Verification 131, Social Sentiment 139). |
| 3. Canonical | None output. Yoast leaves out the canonical while a page is noindex, so this is expected on `.online`; it must be verified on launch day. |
| 4. Indexability | `noindex, nofollow` on 45 of 45, as required for the dev site. |
| 5. Structured data | Every page has the types its template needs (Service + FAQPage + BreadcrumbList on service, industry and agent pages; AboutPage + Person on About; ContactPage on Contact; ItemList on hubs). JSON parses on all pages. Service nodes carry name, description, provider, serviceType and areaServed. Gaps below. |
| 6. Core Web Vitals | Lab only (see section 4). |
| 7. Answer-first | 45 of 45: each page opens with a direct definition or answer ("Local SEO makes a business visible when...", "The Search Authority Diagnostic is a free, data-backed review..."). |
| 8. Internal links | Every page links out to related pages (3 to 31 contextual links). Contextual links in: lowest are Contact (0, reached from the menu and footer), Blog (1) and Awards (1, plus the footer). No orphans. |
| 10. Copy rules | `copy-check.py` 0 issues across the visible text of all 45 pages. |

## 2. Schema and entity gaps (what AI engines use to identify the company)

- **Organization `sameAs` is empty.** The standard asks for LinkedIn, Crunchbase and social profiles. Without them, Google and LLMs cannot tie this site to the company's other profiles. Profiles already verified in F-023 could be listed: Clutch, GoodFirms, DesignRush, HackerNoon, Semrush Agency Partners; LinkedIn, Crunchbase and the social accounts need their URLs from Jamil.
- **No `contactPoint`** on the Organization (the standard requires it; Contact page has the details in text).
- **`award`** appears on the Organization only on About and Awards; it could be site-wide.
- **`dateModified` missing on 41 of 45 pages.** Yoast adds it only once a page has been edited after publishing. It is a freshness signal for AI answers; it will appear naturally as pages are updated (never by a bulk pass, F-003).
- **No `og:image`** anywhere (no default social image set), and `og:site_name` reads "reinforcelab.online" because the WordPress site title is the domain. Shared links and some AI previews show no image and the wrong name.

## 3. GEO / LLM layer

- **`llms.txt` is broken.** Yoast generates it automatically, but its 5 page links are empty (`[About]()`), its heading is "reinforcelab.online", and it lists 5 pages out of 45. It should list the key pages (Home, About, Search Authority OS, Services hub, the core services, Industries) with working links and a one-paragraph company description.
- **`robots.txt` has no AI-crawler policy.** It is Yoast's default ("allow all"). The standard asks for a deliberate policy (allow reputable AI crawlers such as GPTBot, ClaudeBot, PerplexityBot, Google-Extended). Decide before launch; production-only change under Rule 1.
- **Citations:** 27 pages link to authoritative outside sources (Google Search Central 17 times, Gartner, FTC, NIST, W3C, EU AI Act, Baymard and others). **18 pages cite nothing**, including the AI Search Optimization and Audit service pages, all 8 agent pages, Home, Search Authority OS and Packages. AI engines weight claims that are corroborated.
- **Entity clarity:** 36 of 45 pages name Reinforce Lab in the first 200 words. The 8 agent pages, Packages and the Audit page do not; their openings name the product ("The Content QA Auditor...") but not the company.
- **Structure for extraction:** every page uses lists; 9 use tables; FAQs answer in self-contained sentences.
- **Rendering:** all text is in the initial server-rendered HTML; hero diagrams carry SVG titles (Home, Search Authority OS, Packages and Awards have some decorative SVGs without titles, which is fine for decoration).

## 4. Performance (lab, phone size, 6 pages)

| Page | Transferred | Requests | CLS | Note |
|---|---|---|---|---|
| Home | 108 KB | 17 | **0.154** | H1 rewraps when the Oswald web font arrives late; everything below shifts 61 px |
| Local SEO | 124 KB | 18 | 0.027 | |
| Search Authority OS | 149 KB | 17 | 0.044 | |
| Healthcare | 158 KB | 18 | 0.022 | |
| About | 134 KB | 18 | 0.279 first load, 0 on reload | Same web-font cause, network dependent |

- LCP and TTFB readings here (2 to 17 s) reflect this sandbox's slow network and a cache-busting parameter, not the real site; they need PageSpeed or field data at launch.
- **Scripts on every page:** jQuery + jQuery Migrate, the WordPress emoji script (pointless under the no-emoji rule), Bootstrap 4, Magnific Popup, FitVids and the theme script, about 45 to 63 KB. Our pages use almost none of this.
- **HTML size:** 3 pages just over the 150 KB budget: Home 150, Search Authority OS 152, Enterprise SEO Strategy 153.
- **Fix for the layout shift (RECOMMENDATION):** preload the Oswald heading font and give the fallback font matching metrics (`size-adjust`), as the standard's font note already plans.

## 5. Content depth

- **0 blog posts published.** The 13 post templates are built and tested, but the standard's topic clusters (each service and industry page linked to supporting posts and back) have nothing to link to yet. This is the largest remaining gap for both Google and AI answers, and it is a content task, not a build task.
- Contact (391 words) and the Blog index (71 words) are short by design.

## 6. Recommended fix list (one at a time, in this order)

| # | Fix | Effort | Needs Jamil? |
|---|---|---|---|
| 1 | Set the WordPress site title to "Reinforce Lab" and a tagline | 1 setting | Approve |
| 2 | Rebuild `llms.txt`: manual page list with working links and a company paragraph | Small | Approve the page list |
| 3 | Organization `sameAs` and `contactPoint` | Small | LinkedIn, Crunchbase, Facebook, X, Instagram URLs (the verified directory profiles can go in now) |
| 4 | Replace the 26 `#` placeholder links in the header and footer (social icons, Portfolio, Clients, Careers, Privacy, Terms, Sitemap and others): real URLs, or remove the link until the page exists | Small | Which pages exist; the social URLs |
| 5 | Shorten 18 meta descriptions to 150 to 160 characters and 8 titles to 60 or fewer | Small (copy) | Approve the wording |
| 6 | Default social image (`og:image`) | Small | Approve the image |
| 7 | Name Reinforce Lab in the opening of the 8 agent pages, Packages and the Audit page | Small (copy) | Approve |
| 8 | Add 1 to 3 authoritative citations to the 18 pages that have none, where they support a claim | Medium | No (sources only, never invented) |
| 9 | Preload the heading font and add a size-matched fallback (fixes the Home layout shift) | Small | No |
| 10 | Stop loading the emoji script and other unused theme scripts on our pages | Medium, test carefully | Approve |
| 11 | AI-crawler policy for `robots.txt` at launch | Decision | Yes, production change under Rule 1 |
| 12 | Start the blog: first posts per service and industry cluster | Ongoing | Topics and approval |

**Update 5 Oct (D-117):** fixes 1 to 3 done: site name is "Reinforce Lab"; Organization has 5 verified profile links (`sameAs`) and 2 contact points; `/llms.txt` rebuilt from the live pages (all 45, working links). LinkedIn, Crunchbase and social URLs still to come from Jamil.
