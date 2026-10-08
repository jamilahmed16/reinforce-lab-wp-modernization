# REINFORCE LAB — APPROVED DECISION LOG

Decisions explicitly made by Jamil Ahmed. Per Master Project Instructions §40 and §42, these override recommendations, historical documents, and tool output. They are not to be silently changed.

---

## How this log is organised (D-080)

- This file: the index of every decision (D), finding (F) and open item (O); the **current month in full**; and the open items awaiting Jamil.
- Earlier months, unchanged: `claude/decisions/2026-08.md`, `claude/decisions/2026-09.md`.
- New entries go in this file, newest first under "Current month". At the start of a new month, move the previous month into `claude/decisions/YYYY-MM.md` and keep its rows in the index.

---

## Index of every entry

Newest month first; within a month, entries are in the order they appear in the log. Full text: October below, earlier months in `claude/decisions/`.

### October 2026

| ID | Entry | Date | Status | Where |
|---|---|---|---|---|
| F-029 | Read-only production inventory (8 Oct): 193 sitemap URLs, 509 URLs reached (223 live, 18 redirect, 19 broken links production itself points to), 18,791 internal links, 2,060 image uses; merged with register, Search Console, backlinks, Yoast redirects and later approvals into a draft map of 802 old URLs; every URL that is live, has clicks or backlinks has an approved fate; 14 decisions left | 8 Oct | OPEN (14 decisions, Jamil) | `claude/data/redirect-map-decisions-needed.md` |
| D-145 | Bylines: Jamil rewrites every old post (new content and images) and each rewritten post carries his name; titles may change, slugs only with per-URL approval; the 20 HUB-REVIEW posts are already decided (D-014b), `/reviews/` hub to build before launch | 7 Oct | APPROVED (Jamil) | `claude/research/review-posts-proposal-2026-10-07.md` |
| D-144 | Migration approach: one switch (new pages plus kept production posts copied unchanged at the same URLs and dates, new design), posts rewritten after launch; 16 author URLs 301 to /blog/ supersede the September plan (/our-team and 410); checklist in `claude/migration-checklist.md` | 7 Oct | APPROVED (Jamil: "1. Yes 2. today's decision (all 16 go to /blog/)"); bylines pending | `claude/migration-checklist.md` |
| D-143 | Button groups: wherever two or more buttons sit together they are the same size (desktop side by side at the longest label's width; phone stacked, full width, equal height) | 7 Oct | DONE (Jamil: "All the buttons size must be equal where ever there are two buttons") | this file |
| D-142 | Phone footer reorganised like Jamil's reference (Semrush): the five link columns collapse into rows with a chevron and open on tap; desktop unchanged | 7 Oct | DONE (Jamil: "Organize it for Mobile device like the reference image attached") | this file |
| D-141 | Last three axe items fixed: post entry headers are plain blocks in all 12 post templates, Services diagram role group, hidden labels for the empty first table headers (Audit page, post 330 body); axe 0 on every page | 7 Oct | DONE (Jamil: "Go ahead") | this file |
| D-140 | Accessibility fixes from F-028: link names start with the visible text (axe label mismatch 249 to 0), footer column titles no longer headings (heading order 57 to 0), tap targets padded to 24px (2,800 small targets to 24, all inline in lists or text), form checkboxes 24px | 7 Oct | DONE (Jamil: "Go ahead") | this file |
| D-139 | Jamil's design decisions on F-028: body text 16px, card titles 20px, 12px minimum, container 1440 (supersedes D-013's 1280), one button label "Get your free diagnostic", footer names kept, US office in schema, LiteSpeed Cache stays off, author/date/Uncategorized archives retired (301 to /blog/) | 7 Oct | DONE on `.online` | this file |
| D-138 | F-028 P1 fixes on `.online`: zero radius everywhere, accessible colour tokens, blog grid and post share image, kit-styled 404 and search, SMTP code (waits for mailbox), cookie choice bar with GPC and consent-gated GA4, privacy policy row | 7 Oct | DONE (Jamil: "Do it all") | this file |
| O-026 | Favicon and site icon: Jamil asked to be reminded later (reminder scheduled 8 Oct) | 7 Oct | OPEN | this file |
| O-027 | SMTP mailbox and password for form email; DMARC records for both domains; GA4 measurement ID and 14-month retention | 7 Oct | OPEN (Jamil) | this file |
| F-028 | Full site audit of `.online` (55 URLs, desktop and phone, axe-core, HTTP): 8 P1 items (zero-radius rule broken by theme buttons, colour contrast, no favicon, empty blog card image, unstyled 404 and search, form email without SMTP, consent/GA4); type-scale, CTA-label and footer-name inconsistencies for Jamil | 6 Oct | OPEN (Jamil: "Check again across entire website...") | `claude/research/site-audit-2026-10-06.md` |
| D-137 | AI Search Optimization page: SEO/GEO gaps closed (dateModified and visible last-updated date, price Offer in the Service schema, "Led by Jamil Ahmed" with reviewedBy, page-specific share image); main landmark already present, audit tool corrected | 6 Oct | DONE (Jamil: "Do all that required using a checklist") | this file |
| D-136 | AI Search Optimization page: six conversion points added (mid-page CTAs after How it works, deliverables with price, and the agency checklist; client logo strip; FAQ links; Talk to us and next-step line in the final CTA); no content removed | 6 Oct | DONE (Jamil: "Go ahead") | this file |
| D-135 | Keyword map v2: `/services/ai-search-optimization/` owns "ai search optimization services" with AI SEO secondaries; 4 new FAQs (cost FAQ shows Search Authority OS prices); 3 future posts; page tuned on `.online` | 6 Oct | DONE (Jamil approved the map and "keep it" for the price) | this file |
| D-134 | Blog post rules: 8th-grade reading level for every post; top-10 competitor analysis with Exa before writing, competitor semantics used in the post; first post reworked to both rules | 5 Oct | DONE (Jamil: "the reading difficulty should be 8th grader for all posts .... before writing any post must analyze top 10 results in google with exa ai...") | this file |
| D-133 | Related reading at the end of every post: posts first, topped up with the most relevant pages when there are fewer than 3 related posts (all post templates) | 5 Oct | DONE (Jamil: "There must an option for related post or something like that in the end of the post") | this file |
| F-027 | Review of the first post "What Is an AI Growth System?": strong structure, schema and sources; gaps are first-hand evidence, a body diagram, readability and the author photo | 5 Oct | FIXED except the author photo (awaiting Jamil) | this file |
| D-132 | First blog post published on `.online`: Explainer "What Is an AI Growth System?" (post 330, `/what-is-an-ai-growth-system/`); Home FAQ shortened to link to it | 5 Oct | DONE (Jamil: URL, definition and author yes; tools "keep as written"; no price; root URL like production posts) | this file |
| D-131 | AI Growth Systems pillar built and published on `.online` (page 71, `/services/ai-growth-systems/`), primary keyword "ai growth systems"; Home links to it | 5 Oct | DONE (Jamil: "/services/ai-growth-systems/ Yes") | this file |
| D-130 | Keyword map v1: Home "reinforce lab", About "about reinforce lab", `/services/ai-growth-systems/` "ai growth systems", first blog post "what is an ai growth system"; replaces D-035 keyword ownership | 5 Oct | APPROVED (Jamil: "Replace D-035 with today's plan"); Yoast focus keyphrases set | this file |
| F-026 | SEO/AEO/GEO/LLM readiness, second pass (53 pages): all technical, schema and answer-engine gates pass; fixed brand-early openings, share image, llms.txt, page weight; sources added to 13 pages (42 of 53 now cite); question H2s on Home, SAOS, Diagnostic; open: blog | 5 Oct | DONE | `claude/research/seo-aeo-geo-readiness-2026-10-05-v2.md` |
| D-129 | Founding date changed to 19 April 2022 everywhere (incorporation date on the RJSC certificate), replacing D-108's 1 April 2021 | 5 Oct | DONE (Jamil: "Change the founding date to 19 April 2022 everywhere.") | this file |
| D-128 | Certificate of Incorporation published at its production URL (same PDF path), footer linked; RJSC no. C-180618/2022 added to Organization schema, Terms and Privacy; uploads on `.online` now send `X-Robots-Tag: noindex` | 5 Oct | DONE (Jamil sent the PDF; "Public, I'll upload it") | this file |
| D-127 | Clients page built (page 277, `/clients/`) with the 46 client logos from production, imported into the `.online` media library; footer Clients linked | 5 Oct | DONE (Jamil: logos "Download from production"; "Yes, all are real clients") | this file |
| D-126 | Project pages moved from `/projects/<slug>/` to `/portfolio/<slug>/`; production `/projects/` URLs get 301s (tested on `.online`, in `claude/data/approved-redirects-2026-10.csv`) | 5 Oct | DONE (Jamil: "it should be under https://reinforcelab.online/portfolio/ no \"/projects\"") | this file |
| D-125 | Project pages rebuilt on `.online` at the production URLs `/projects/inpace-shop/`, `/projects/access-tutor/`, `/projects/iba-alumni-lottery/` (post type `rl_project`, no `/projects/` archive); Portfolio cards link to them | 5 Oct | DONE (Jamil: "Rebuild at same URLs") | this file |
| D-124 | Portfolio page built (page 227, `/portfolio/`) with the six projects already public on production as placeholders; menu and footer links set; Careers hidden | 5 Oct | DONE (Jamil: "build the page with dummy portfolio ... read the .com site for portfolio"; Careers "Hide for now") | this file |
| D-123 | Privacy Policy v2 on `.online` (page 3): country rules (EU, UK, Bangladesh PDPO 2025, US with GPC) built in; consent tick box on the Contact and Diagnostic forms; fonts self-hosted, no Google Fonts requests | 5 Oct | DONE (Jamil: "same way update privacy policy") | this file |
| D-122 | FTC and Affiliate Disclosure published (page 224, `/ftc-disclosure/`); affiliate links labelled "Ad" automatically site-wide | 5 Oct | DONE (Jamil: "Semrush and WP Engine affiliate links") | this file |
| D-121 | Terms & Conditions published on `.online` (page 223, `/terms-conditions/`), Bangladesh law, website and store, rules from BD, US, UK and EU built in | 5 Oct | DONE (Jamil: "USD, full payment up front, businesses only, rest okay ... Read other countries rules and implement as well") | this file |
| D-120 | Privacy Policy published on `.online` (page 3, `/privacy-policy/`) with a reusable legal-page template | 5 Oct | DONE (Jamil's six answers; review by Jamil with Claude as adviser) | this file |
| D-119 | Footer: Get a Free Quote, Sitemap and Privacy Policy wired | 5 Oct | DONE (Jamil: "First these 3") | this file |
| D-118 | Titles and meta on 26 pages within limits; all 8 agent titles on one pattern; LinkedIn, Crunchbase, Facebook, Instagram added; footer social icons live | 5 Oct | DONE (Jamil: "approve all, switch all 8 agents to the same pattern" + 4 profile URLs) | this file |
| D-117 | F-025 fixes 1 to 3: site name, Organization profiles and contact point, our own llms.txt | 5 Oct | DONE (Jamil: "yes, fix 1 to 3 and use the directory profiles") | this file |
| F-025 | SEO, AEO, GEO and LLM readiness of all 45 pages: page structure ready; site-wide entity settings and content depth are the gaps | 5 Oct | FINDING; fix list awaits Jamil | [research](research/seo-aeo-geo-readiness-2026-10-05.md) |
| D-116 | Phone versions of every other hero diagram (25 pages), shared `rl_ph()` component | 5 Oct | DONE (Jamil: "apply all", then "Phone versions on all heroes") | this file |
| D-115 | Each of the 8 agent pages gets its own hero visual | 5 Oct | DONE (Jamil: "all of the hero images look similar that's should not be like that") | this file |
| D-114 | Heroes brought to one standard: Search Authority OS, Home (capitals), Awards, Diagnostic, Packages, Agents hub | 5 Oct | DONE (Jamil: "use capitals") | this file |
| F-024 | Hero audit, 45 pages: 36 match the kit standard; Search Authority OS, Home and Awards heroes are out of line | 5 Oct | FINDING; fixes await Jamil | [research](research/hero-audit-2026-10-05.md) |
| D-113 | About page: Our story and Milestones aligned as two equal columns | 5 Oct | DONE (Jamil: "either separate it with section or make it aligned") | this file |
| D-112 | About page: "Why are there no client logos or results" section removed | 5 Oct | DONE (Jamil: "remove this") | this file |
| D-111 | About page founder profile rebuilt from the verified 2018 Onalytica career facts | 5 Oct | APPROVED (Jamil: "keep both sentences, keep all career details"); headshot to follow | this file |
| D-110 | About page rebuilt on `.online` to the v2 company-led copy (`/about-us/`, page 218) | 5 Oct | DONE (Jamil: "dates are right, no Estonia office, keep all, build it") | this file |
| D-109 | Origin story from Jamil: started in Tallinn, Estonia 2020; expanded to Bangladesh 2021; About draft v2 | 5 Oct | RECORDED; About copy in review | this file |
| D-108 | Founding date is 1 April 2021 everywhere (replaces 2020, D-069) | 5 Oct | SUPERSEDED by D-129 (19 April 2022); was DONE (Jamil: "1 April 2021 everywhere") | this file |
| D-107 | `/awards/` linked from the footer only (Company column, after About Us) | 5 Oct | DONE (Jamil: "it will be in the footer only for now") | this file |
| D-106 | Awards page built on `.online` at `/awards/` (page 221) | 4 Oct | DONE (Jamil: "use /awards/, drop the amber items, build it") | this file |
| D-105 | Separate Awards page (About stays separate): design mockup v1 for review | 4 Oct | APPROVED, built as D-106 | this file |
| F-023 | Reputation and recognition research: one independently verified award (HackerNoon, Dhaka 2024), conflicting public facts | 4 Oct | `[VERIFIED where marked; rest SELF-REPORTED]` | this file |
| D-104 | Founder bio for the author box: Jamil's own wording, applied on `.online` | 4 Oct | DONE (Jamil: "Like this now modify this") | this file |
| D-103 | Product / Service template built on `.online`: all blog templates done | 4 Oct | DONE (Jamil: "approved, build the Product / Service template") | this file |
| D-102 | Product / Service template: design mockup v1 (three subtypes) for review | 4 Oct | APPROVED, built as D-103 | this file |
| D-101 | Research template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Research template") | this file |
| D-100 | Research template: design mockup v1 for review | 4 Oct | APPROVED, built as D-101 | this file |
| D-099 | Case Study template built on `.online` from the approved mockup (v2) | 4 Oct | DONE (Jamil: "approved, build the Case Study template") | this file |
| D-098 | Case Study template: design mockup v1 and v2 (7 additions) for review | 4 Oct | APPROVED, built as D-099 | this file |
| D-097 | Updates template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Updates template") | this file |
| D-096 | Updates template: design mockup v1 for review | 4 Oct | APPROVED, built as D-097 | this file |
| D-095 | Industry template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Industry template") | this file |
| D-094 | Industry template: design mockup v1 for review | 4 Oct | APPROVED, built as D-095 | this file |
| D-093 | Explainer template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Explainer template") | this file |
| D-092 | Explainer template: design mockup v1 for review | 4 Oct | APPROVED, built as D-093 | this file |
| D-091 | Comparison template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Comparison template") | this file |
| D-090 | Comparison template: design mockup v1 for review | 4 Oct | APPROVED, built as D-091 | this file |
| D-089 | Review template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Review template") | this file |
| D-088 | Review template: design mockup v1 for review | 4 Oct | APPROVED, built as D-089 | this file |
| D-087 | Best / List template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Best/List template") | this file |
| D-086 | Best / List template: design mockup v1 for review | 4 Oct | APPROVED, built as D-087 | this file |
| D-085 | How-To template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the How-To template") | this file |
| D-084 | Founder bio: drafts for review | 4 Oct | DEFERRED until the blog templates are finished | this file |
| D-083 | GitHub navigation: README, folder guides, generated site map | 4 Oct | DONE | this file |
| D-082 | How-To template: design mockup v1 for review | 4 Oct | APPROVED, built as D-085 | this file |
| D-081 | Step B, part 2: decision log split into an index, the current month and monthly archives | 4 Oct | DONE | this file |
| D-080 | Step B, part 1: theme code in folders with one loader | 4 Oct | DONE (Jamil: "yes, do step A and step B one after another") | this file |
| D-079 | Step A: tools and a database snapshot in the repo | 4 Oct | DONE (Jamil: "yes, do step A and step B one after another") | this file |
| D-078 | Guide template built on `.online` from the approved mockup | 4 Oct | DONE (Jamil: "approved, build the Guide template") | this file |
| D-077 | Blog templates: one type at a time, own design per type, mockup before code | 3 Oct | APPROVED (Jamil: "Why every blog templates look and feel... | this file |
| D-076 | Type-specific sections built for all 11 post types (plus Case Study rule change) | 3 Oct | DONE (Jamil: "Go ahead"; Case Study "should it wait for a... | this file |
| D-075 | Single post template: shared long-form base built on `.online` | 3 Oct | DONE (Jamil: "go ahead with the long-form base"). Type-sp... | this file |
| D-074 | Blog post types: one single-post template, 11 types (plus 2 later) | 3 Oct | APPROVED (Jamil: "yes to all"). Not built yet; the shared... | this file |
| D-073 | Copy answers (closes O-025 items 1 to 3) | 3 Oct | APPROVED and APPLIED on `.online` (Jamil: "1 to 30, remov... | this file |
| D-072 | Copy rules: no em dashes, no emojis, no AI words, anywhere on the website | 1 Oct | APPROVED and APPLIED on `.online` (Jamil: "make sure we u... | this file |

### September 2026

| ID | Entry | Date | Status | Where |
|---|---|---|---|---|
| D-012 | SEO / GEO / AEO / AI-search build standard is BINDING | 10 Sep | APPROVED — ACTIVE | [2026-09](decisions/2026-09.md) |
| D-013 | Design direction locked: dark "Systems Grid" (frontal-calibrated) | 10 Sep | APPROVED — ACTIVE | [2026-09](decisions/2026-09.md) |
| · | GSC PRIMARY DATA RECEIVED — closes O-005 + O-010 | 10 Sep | `[VERIFIED — from GSC exports]` | [2026-09](decisions/2026-09.md) |
| F-014 | WPCode inventory (production): 2 active sample snippets, none SEO-relevant — closes O-014 | 10 Sep | `[VERIFIED — from WPCode Lite export]` | [2026-09](decisions/2026-09.md) |
| F-015 | Production already runs 37 Yoast redirects, with multi-hop chains to flatten | 10 Sep | `[VERIFIED — transcribed from Yoast Redirects screenshots]` | [2026-09](decisions/2026-09.md) |
| D-014 | PRESERVE URL disposition rules APPROVED | 10 Sep | APPROVED — ACTIVE | [2026-09](decisions/2026-09.md) |
| D-014b | + F-016 — Full register classified (793 URLs); affiliate pages → HUB-REVIEW | 10 Sep | D-014b APPROVED (affiliate hub) | [2026-09](decisions/2026-09.md) |
| D-015 | URL disposition review (batch approvals, per D-014) | 12 Sep | APPROVED — PLANNING (applied at migration cutover, not on... | [2026-09](decisions/2026-09.md) |
| D-016 | "Search Authority OS" initiative + IA decisions | 15 Sep | APPROVED — ACTIVE | [2026-09](decisions/2026-09.md) |
| F-016 | Migration redirect map built & validated | 20 Sep | `[VERIFIED — planning artifact; not applied to production]` | [2026-09](decisions/2026-09.md) |
| D-017 | Build kickoff on `.online` (approved-new URLs) | 20 Sep | IN PROGRESS | [2026-09](decisions/2026-09.md) |
| D-018 | Design system v2: "Systems Grid" evolved (square-glass) — APPROVED | 24 Sep | APPROVED — ACTIVE | [2026-09](decisions/2026-09.md) |
| D-019 | Information architecture hierarchy (confirmed) | 24 Sep | APPROVED — ACTIVE | [2026-09](decisions/2026-09.md) |
| D-071 | Blog archive template built on `.online` (F-001 by design); `/blog/` page 220 set as the pos... | 30 Sep | DONE (Jamil: "yes, go ahead with the Blog archive template") | [2026-09](decisions/2026-09.md) |
| D-070 | Contact page built on `.online` (page 219, `/contact-us/`, published) with a working form | 30 Sep | DONE (Jamil: "go ahead with Contact") | [2026-09](decisions/2026-09.md) |
| D-069 | Founding year confirmed: 2020 | 30 Sep | SUPERSEDED by D-108 (1 April 2021) | [2026-09](decisions/2026-09.md) |
| D-068 | About page built on `.online` (page 218, `/about-us/`, published) | 30 Sep | DONE (Jamil: "plain slugs, then go ahead with About") | [2026-09](decisions/2026-09.md) |
| D-067 | Industry slugs are plain | 30 Sep | APPROVED (Jamil: "plain slugs") | [2026-09](decisions/2026-09.md) |
| D-066 | Industries hub + 8 industry pages built on `.online` (pages 87, 75, 90–96, published) | 30 Sep | DONE (Jamil: "First Agents … Then Industries Hub and its... | [2026-09](decisions/2026-09.md) |
| D-065 | The 8 agent pages built on `.online` (pages 77–84, published) from one shared template | 30 Sep | DONE (Jamil: "First Agents … Then Industries Hub and its... | [2026-09](decisions/2026-09.md) |
| O-022 | The agent pages sell agents whose software is not recorded as built — confirm before launch | 30 Sep | OPEN (content on `.online` only) | [2026-09](decisions/2026-09.md) |
| D-064 | Website Maintenance page built on `.online` (page 198, published) — Solutions menu complete | 30 Sep | DONE (Jamil: "yes, go ahead with Website Maintenance") | [2026-09](decisions/2026-09.md) |
| O-021 | Maintenance service commitments stated on page 198 need Jamil's confirmation — OPEN | 30 Sep | OPEN (content on `.online` only; nothing on production) | [2026-09](decisions/2026-09.md) |
| D-063 | E-commerce Website Design page built on `.online` (page 197, published) | 30 Sep | DONE (Jamil: "B, then go ahead with E-commerce Website De... | [2026-09](decisions/2026-09.md) |
| D-062 | Menu wiring fixed; WordPress Website Design page built on `.online` (page 196, published) | 30 Sep | DONE (Jamil: "yes, fix the menu then go ahead with WordPr... | [2026-09](decisions/2026-09.md) |
| O-020 | Production WordPress design packages ($2,597 / $4,597 / $8,597, WooCommerce, "free hosting")... | 30 Sep | RESOLVED 30 Sep 2026 (Jamil: "B, then go ahead with E-com... | [2026-09](decisions/2026-09.md) |
| D-061 | Executive AI Consulting page built on `.online` (page 103, published) | 30 Sep | DONE (Jamil: "yes, go ahead with Executive AI Consulting") | [2026-09](decisions/2026-09.md) |
| F-022 | EU AI Act Article 4 (AI literacy) was amended by the Digital Omnibus on 27 Jul 2026 | 30 Sep | RECORDED (applied to page 103; nothing else affected) | [2026-09](decisions/2026-09.md) |
| D-060 | AI Workflow Automation page built on `.online` (page 97, published) | 29 Sep | DONE (Jamil: "yes, go ahead with AI Workflow Automation") | [2026-09](decisions/2026-09.md) |
| D-059 | Lead Generation Systems page built on `.online` (page 102, published) | 29 Sep | DONE (Jamil: "yes, go ahead with Lead Generation Systems") | [2026-09](decisions/2026-09.md) |
| D-058 | Marketing Automation page built on `.online` (page 86, published) | 29 Sep | DONE (Jamil: "yes, D-023 wins, then go ahead with Marketi... | [2026-09](decisions/2026-09.md) |
| F-021 | Built pages link to unpublished draft pages (`?page_id=N`) — launch QA item | 29 Sep | OPEN (no change made) | [2026-09](decisions/2026-09.md) |
| D-057 | SEO Content Systems page built on `.online` (page 85, published) | 29 Sep | DONE (Jamil: "B, then go ahead with SEO Content Systems") | [2026-09](decisions/2026-09.md) |
| F-020 | Legacy content-service URLs: URL sheet says PRESERVE, D-023 says 301 → `/services/seo-conten... | 29 Sep | RESOLVED 29 Sep 2026 (Jamil: "yes, D-023 wins") | [2026-09](decisions/2026-09.md) |
| D-056 | Core SEO pillar built on `.online` (page 190, published) at the kept production URL | 29 Sep | DONE (Jamil: "yes, go ahead with the core SEO pillar") | [2026-09](decisions/2026-09.md) |
| O-019 | Production SEO packages ($2,000–$6,500/yr, WooCommerce "Buy") on the core SEO pillar — RESOL... | 29 Sep | RESOLVED 29 Sep 2026 (Jamil: "B, then go ahead with SEO C... | [2026-09](decisions/2026-09.md) |
| D-055 | Digital PR & Link Building page built on `.online` (page 189, published) — carries the off-p... | 29 Sep | DONE (Jamil: "B, then go ahead with Digital PR") | [2026-09](decisions/2026-09.md) |
| D-054 | Enterprise SEO Strategy page built on `.online` (page 98, published) | 29 Sep | DONE (Jamil: "yes, go ahead with Enterprise SEO Strategy") | [2026-09](decisions/2026-09.md) |
| O-018 | Legacy off-page / link-building URLs → `/services/enterprise-seo-strategy/`: intent mismatch... | 29 Sep | RESOLVED 29 Sep 2026 (Jamil: "B, then go ahead with Digit... | [2026-09](decisions/2026-09.md) |
| D-053 | SEO & AI Search Audit pricing and terms set (delegated to Claude at industry standard) | 29 Sep | APPROVED by delegation (Jamil: "What should be the audit... | [2026-09](decisions/2026-09.md) |
| D-052 | International SEO lines refined; legacy local post approved for 301 (O-017 → A) | 29 Sep | DONE (Jamil: "Make the lines sleek then option A") | [2026-09](decisions/2026-09.md) |
| D-051 | SEO & AI Search Audit page built on `.online` (page 74, published) | 29 Sep | BUILT (Jamil: "…then SEO & AI Search Audit") | [2026-09](decisions/2026-09.md) |
| D-050 | Local SEO page built on `.online` (page 104, published) | 29 Sep | BUILT (Jamil: "yes, go ahead with Local SEO") | [2026-09](decisions/2026-09.md) |
| O-017 | Legacy `/best-local-search-engine-optimization-service/` (production): 301 to `/services/loc... | 29 Sep | RESOLVED 29 Sep — Jamil: "…then option A" | [2026-09](decisions/2026-09.md) |
| D-049 | Hero CTA buttons kept on one line (all pages) | 29 Sep | DONE (Jamil, with a screenshot of the International SEO h... | [2026-09](decisions/2026-09.md) |
| D-048 | International SEO page built on `.online` (page 100, published) | 29 Sep | BUILT (Jamil: "…then go straight on to International SEO") | [2026-09](decisions/2026-09.md) |
| D-047 | "Who it's for" = all 8 industries as detail cards (Technical SEO; pattern for every service... | 29 Sep | DONE on Technical SEO (Jamil: "mention 8 cards as details... | [2026-09](decisions/2026-09.md) |
| D-046 | Technical SEO keeps its production URL `/services/technical-seo-services/` (no redirect) | 29 Sep | APPROVED by Jamil ("B, keep the URL and rename the page") | [2026-09](decisions/2026-09.md) |
| O-016 | `/services/technical-seo-services/` (production): keep the URL, or 301 it? — RESOLVED → D-04... | 29 Sep | RESOLVED 29 Sep — Jamil: "B, keep the URL and rename the... | [2026-09](decisions/2026-09.md) |
| D-045 | Technical SEO page built on `.online` (page 99, published) — first page built on the shared kit | 29 Sep | BUILT (Jamil: "yes, go ahead with Technical SEO") | [2026-09](decisions/2026-09.md) |
| D-044 | Shared CSS kit: duplicated page CSS merged into one cached file | 29 Sep | DONE (Jamil: "yes, do the CSS merge first") | [2026-09](decisions/2026-09.md) |
| D-043 | LLM Optimization page built on `.online` (page 101, published) | 29 Sep | BUILT (Jamil: "yes, go ahead with LLM Optimization and fo... | [2026-09](decisions/2026-09.md) |
| D-042 | GEO page built on `.online` (page 73, published) | 29 Sep | BUILT (Jamil: "yes, go ahead with GEO") | [2026-09](decisions/2026-09.md) |
| D-041 | AI Search Optimization page built on `.online` (page 72, published) | 29 Sep | BUILT (Jamil: "yes, go ahead with AI Search Optimization") | [2026-09](decisions/2026-09.md) |
| D-040 | `/services/` hub built on `.online` (page 68, published) | 29 Sep | BUILT (Jamil: "yes, go ahead with the Services hub") | [2026-09](decisions/2026-09.md) |
| D-039 | Hero system + per-page hero animations; competitor-driven content upgrade (APPROVED) | 29 Sep | APPROVED by Jamil — executing one page at a time | [2026-09](decisions/2026-09.md) |
| D-038 | Agents hub `/services/agents/` (page 76) — BUILT & LIVE on `.online` | 29 Sep | LIVE on `.online` (dev, noindex) — verified | [2026-09](decisions/2026-09.md) |
| D-037 | Packages & Pricing page `/packages/` (page 66) — BUILT & LIVE on `.online` | 29 Sep | LIVE on `.online` (dev, noindex) — verified | [2026-09](decisions/2026-09.md) |
| D-036 | Search Authority Diagnostic page `/search-authority-diagnostic/` (page 65) — BUILT & LIVE on... | 28 Sep | LIVE on `.online` (dev, noindex) — verified | [2026-09](decisions/2026-09.md) |
| D-035 | Home owns "AI Growth Systems" + Yoast title/meta LIVE on `.online` | 28 Sep | APPLIED & VERIFIED on `.online` | [2026-09](decisions/2026-09.md) |
| D-034 | Home copy v2 LIVE on `.online` (de-duplicated vs SAOS) | 28 Sep | LIVE on `.online` (dev, noindex) — verified | [2026-09](decisions/2026-09.md) |
| F-018 | SERP research: "AI Growth Systems" (Bing, Google, Google AI Mode, Semrush — screenshots from... | 28 Sep | RECORDED — applied to Home copy draft rev 2 | [2026-09](decisions/2026-09.md) |
| D-033 | Yoast entity name fixed on `.online`: "Reinforce Lab" / legalName "Reinforce Lab Limited" | 28 Sep | LIVE on `.online` — verified | [2026-09](decisions/2026-09.md) |
| F-017 | Home ↔ Search Authority OS content overlap: ~24–27% | 28 Sep | RESOLVED by D-034 (overlap now 7.3% / 8.6%) | [2026-09](decisions/2026-09.md) |
| D-032 | Search Authority OS page built & LIVE on `.online` | 28 Sep | LIVE on `.online` (dev, noindex) — verified | [2026-09](decisions/2026-09.md) |
| D-031 | Theme markup cleanup in the global chrome (one H1, skip link, no theme footer) | 28 Sep | LIVE on `.online` (dev, noindex) — verified | [2026-09](decisions/2026-09.md) |
| D-030 | Homepage (long-form landing) built & LIVE on `.online` | 28 Sep | LIVE on `.online` (dev, noindex) — verified in browser | [2026-09](decisions/2026-09.md) |
| D-029 | Live footer built & verified on `.online` | 28 Sep | LIVE on `.online` (dev, noindex) — verified in browser | [2026-09](decisions/2026-09.md) |
| D-028 | Site container width = 1440px everywhere (Option A) | 28 Sep | APPLIED & LIVE (updated 28 Sep — Option A chosen) | [2026-09](decisions/2026-09.md) |
| D-027 | LiteSpeed Cache deactivated on `.online` for the build | 28 Sep | ACTIVE (dev only) | [2026-09](decisions/2026-09.md) |
| D-026 | Live header built & verified on `.online` (Systems Grid chrome) | 28 Sep | LIVE on `.online` (dev, noindex) — verified in browser | [2026-09](decisions/2026-09.md) |
| D-025 | Logo set on `.online` | 28 Sep | DONE | [2026-09](decisions/2026-09.md) |
| D-024 | Primary nav menu built on `.online` | 28 Sep | BUILT (drafts wired; content to follow) | [2026-09](decisions/2026-09.md) |
| D-023 | Final service architecture (Solutions + Web + legacy redirect map) | 28 Sep | APPROVED (planning; production URLs apply only at migrati... | [2026-09](decisions/2026-09.md) |
| D-022 | Industries axis added; Pharma moved Solutions → Industries | 28 Sep | DECIDED in preview; sub-items open (slug, list reconcilia... | [2026-09](decisions/2026-09.md) |
| D-021 | Global chrome (header + footer) reworked — APPROVED | 27 Sep | APPROVED 28 Sep 2026 (chrome locks; applies across every... | [2026-09](decisions/2026-09.md) |
| D-020 | Daily GitHub auto-sync (Windows Scheduled Task) | 26 Sep | ACTIVE | [2026-09](decisions/2026-09.md) |

### August 2026

| ID | Entry | Date | Status | Where |
|---|---|---|---|---|
| D-001 | Development environment build strategy | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-002 | WooCommerce | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-003 | The six missing AI-first service pages | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-004 | ACF edition | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-005 | Tier 1 URL protection list | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-006 | Slugs for the five new service pages | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-007 | Crawl-waste investigation authorised | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| F-001 | ROOT CAUSE CONFIRMED: Beaver Builder multi-module pagination | 20 Aug | `[VERIFIED — independent source]` | [2026-08](decisions/2026-08.md) |
| F-002 | Robots.txt patterns validated against all 787 URLs | 20 Aug | `[VERIFIED — tested against the full register]` | [2026-08](decisions/2026-08.md) |
| F-003 | Bulk content operation in early 2025 | 20 Aug | `[VERIFIED fact / INFERRED cause]` | [2026-08](decisions/2026-08.md) |
| F-004 | Content is clean and portable; legacy builder residue confirmed | 20 Aug | `[VERIFIED]` | [2026-08](decisions/2026-08.md) |
| D-008 | Primary positioning category changed to "AI GROWTH SYSTEMS" | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-009 | Crunchbase description to be rewritten for "AI Growth Systems" | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-006a | Service slug amended | 20 Aug | APPROVED — ACTIVE | [2026-08](decisions/2026-08.md) |
| D-010 | Production homepage H1 and intro change AUTHORISED | 20 Aug | APPROVED — **NOT YET EXECUTED** | [2026-08](decisions/2026-08.md) |
| D-011 | Footer updated to "AI Growth Systems" (PARTIAL) | 20 Aug | PARTIALLY EXECUTED — verified live | [2026-08](decisions/2026-08.md) |
| F-006 | Novamira MCP was mis-pointed at `uniposh-ah.com`; corrected to `.online` | 24 Aug | `[VERIFIED — resolved]` | [2026-08](decisions/2026-08.md) |

---

## Current month: October 2026

---

## F-029 · Production inventory and the draft redirect map
**Date:** 8 October 2026 · **Status:** OPEN, 14 decisions for Jamil (fetch approved: "GO AHEAD")

- **Inventory (read-only, `claude/tools/prod-inventory.py`):** plain GET requests from the `.online` server, one at a time with pauses, no redirects followed. 193 URLs in production's 6 Yoast sitemaps; 509 URLs reached through sitemaps and internal links: 223 return 200, 18 redirect, 19 are broken links production itself points to, 57 assets or utility pages and 192 parameter or `/paged-N/` junk URLs recorded without fetching. 18,791 internal links and 2,060 image uses recorded. Output: `claude/data/production-inventory-2026-10-08/`. A first run on 7 Oct stopped at 725 fetches on a transport timeout and lost its data; the tool now retries and checkpoints.
- **Draft map (`claude/tools/redirect-map.py`):** merges the September register (631 pages, approved decisions), Search Console pages, Search Console's linked pages, production's Yoast redirects, the inventory and later approvals (D-126, D-139, D-144, approved new URLs), plus the approved rules: `/paged-N/` = 410 (F-001), archive pagination follows its archive, query variants follow their page, chains flattened to one hop. Result: 802 old URLs: 440 return 410, 178 redirect (301), 128 keep their URL, 36 keep with noindex, 12 config (sitemaps, robots), 8 undecided. Output: `claude/data/redirect-map-draft.csv`.
- **Found:** a parser bug (decisions written with "→") was fixed before reporting; `/best-local-search-engine-optimization-service/` (95,538 impressions) is already decided, 301 to `/services/local-seo/`.
- **Left for Jamil (`claude/data/redirect-map-decisions-needed.md`):** 6 September rows whose note names a different slug, 7 pages already dead on production, 1 image.
- **Still missing for the gate:** the page-by-page backlink export from Semrush (Search Console's linked pages are in; Semrush may show more).

---

## D-145 · Bylines, review posts and page parity
**Date:** 7 October 2026 · **Status:** APPROVED (Jamil: "I will rewrite every single old post with new fresh contents with planned format and new images so I can put on my name to everyone post ....we will change some if the old titles as well.")

- **Bylines:** every old post is rewritten by Jamil with new content and images, then published under his name. Titles may change in a rewrite; a URL (slug) change needs approval for that URL and a 301. A post carried across before its rewrite shows "Reinforce Lab team" (confirmed by Jamil: "OKAY"). The three weakest reviews (WP Engine partner landing page, Beaver Builder, Bluehost) stay for now, to be redirected later (Jamil: "Keep FOR NOW LATER WE REDIRECT"). Read-only fetch of production sitemaps and internal links approved (Jamil: "GO AHEAD").
- **Correction (F):** I told Jamil there were "20 undecided posts". Wrong: the 20 HUB-REVIEW rows are the affiliate reviews, already decided in D-014b (keep at their URLs under a `/reviews/` hub). Every one of the 630 rows in the page-level sheet carries an approved decision; what remains is Jamil's sign-off of the final redirect map (Rule 2). Figures and three weak candidates to drop: `claude/research/review-posts-proposal-2026-10-07.md`.
- **New pre-launch task:** build `/reviews/` and its pillars `/reviews/best-wordpress-hosting/` and `/reviews/best-seo-ai-tools/` (approved new URLs, D-016).
- **Reviews under Jamil's name** must be first-hand (product used, test period, paid or not, affiliate link labelled); where a product was not used, the honest format is a comparison or overview.
- **Page parity explained to Jamil:** the 17 pages approved to keep their URL (Home, Website Maintenance, 15 posts) must each be live at the same address on the new site and still answer what people searched for, checked before the switch.

---

## D-144 · Migration approach: one switch, posts carried across unchanged
**Date:** 7 October 2026 · **Status:** APPROVED (Jamil: "1. Yes 2. today's decision (all 16 go to /blog/)"); byline question pending

- **Approach:** the new pages and the kept production posts go live together in one switch. Kept posts are copied to `.online` unchanged (same slug, title, words, images, publish date, category, Yoast title and meta) in the new design; rewrites happen one at a time after launch. The copy is one controlled import of existing posts, not new publishing: the agreed exception to F-003, with modified dates kept at production's values.
- **What the copy changes (stated to Jamil):** the design; links inside the text that point to redirected or retired URLs go straight to the final page (wording untouched); 3 Beaver Builder posts become plain content; old Divi and Monarch metadata (about 650 fields) not copied. Author: pending (recommendation: real writer or "Reinforce Lab team" as byline, Jamil only on his own posts, "Reviewed by" only after a real review).
- **Author archives:** the 16 production author URLs 301 to `/blog/` (D-139). This **supersedes** the September page-level plan, which had the main author pages 301 to `/our-team` and their `/page/N/` pages as 410.
- **Checklist:** `claude/migration-checklist.md` lists every task before the switch (data and decisions, read-only production inventory, post carry-over, redirect map in code with a zero-failure redirect test over every known old URL, internal link scan, page parity, launch inputs, the switch runbook including Novamira removed from production) and after it (rewrites one at a time, weekly monitoring for 6+ weeks, improvements). Jamil asked for "100% accuracy": the test covers every URL in the register, Search Console, backlinks, production sitemaps and internal links, and Yoast redirects, with 0 failures as the gate; URLs that appear in no source are caught after launch through the 404 log.
- **Migration still not scheduled:** it waits for the backlink export, the decisions in A1, the redirect map sign-off and a passing test.

---

## D-143 · Equal buttons in every button group
**Date:** 7 October 2026 · **Status:** DONE on `.online` (Jamil, with phone screenshots of the Home hero and a closing call to action: "All the buttons size must be equal where ever there are two buttons")

- **Rule (`core/reinforce-header.php`, applies to every page and to future ones):** any element in the main content that holds two or more `.btn` becomes a grid of equal columns (`:has(> .btn ~ .btn)`): side by side at the width of the longest label on desktop, labels centred; at 760 px and below the buttons stack, full width of their container and of equal height (a wrapped label makes its partner the same height). Centred groups (closing call to action) stay centred. The header button is not affected.
- **Checked (VERIFIED, all 57 URLs at 1440 and 390):** 212 button groups, all equal in width and height; no horizontal overflow; every group that should be centred is centred.

---

## D-142 · Phone footer: collapsible rows
**Date:** 7 October 2026 · **Status:** DONE on `.online` (Jamil, with phone screenshots and a Semrush footer reference: "Organize it for Mobile device like the reference image attached")

- **Before:** on phone the footer listed all five columns fully expanded (about 40 links), a very long scroll.
- **Now (`core/reinforce-header.php`):** each column is a `<details>` with the title as `<summary>`. At 680 px and below: one column, a hairline between rows, the title left and a drawn chevron right (no icon font, no emoji), rows closed on load, a tap opens one; the chevron turns up when open. Above 680 px the columns stay open and a click does not close them, so desktop looks as before. Rows are open in the HTML and closed by a few lines of script, so links still show without JavaScript; native `<details>` works with keyboard and screen readers, and the links stay in the page for crawlers.
- **Checked (VERIFIED):** phone 390 px: 5 rows closed on load, the second opens on tap, no horizontal scroll; desktop 1440: all open, unchanged after a click. The brand intro, social links, office block and bottom line are unchanged.
- **Note:** the video in Jamil's screenshots ("Midnight Echoes") is the phone's picture-in-picture player, not part of the site.

---

## D-141 · Last accessibility items: banner landmark, diagram group, table headers
**Date:** 7 October 2026 · **Status:** DONE on `.online` (Jamil: "Go ahead")

- **Banner landmark:** every post template (`blog/reinforce-post*.php`, 12 files) opened with a `<header>` outside the article, which assistive tech reads as a second page banner. Each is now a `<div>` with the same class; no CSS targets the element, the post looks the same (checked).
- **Services diagram:** the SVG holds links, so `role="img"` (which hides its content) became `role="group"`, still named by its title.
- **Empty table headers:** a visually hidden label for the first column: "Compared on" on the SEO & AI Search Audit page (`services/reinforce-audit.php`) and "Term" in the body of post 330 (one post, markup only; backup `claude/data/backups/post-330-before-th-label-2026-10-07.json`; its modified date is now 7 Oct).
- **Result (VERIFIED):** axe reports no violations on the affected pages; with D-140, axe is at 0 site-wide.

---

## D-140 · Accessibility fixes: link names, footer headings, tap targets
**Date:** 7 October 2026 · **Status:** DONE on `.online` (Jamil: "Go ahead")

- **Link names (WCAG 2.5.3):** every link's accessible name now starts with its visible words. "Explore →" links on the 8 industry cards of 21 service pages and the agent pages ("Explore: AI Search Optimization for Healthcare"); "Read more" and "Read article" links in the post templates and the blog; the Services diagram tiles ("SEO: Search Engine Optimization"); the Agents hub diagram (a space added between the agent number and name, and names such as "A-01 Search Intel: SEO Intelligence Agent") and its "Explore agent" links. axe label-content-name-mismatch: 249 to 0.
- **Footer headings:** the five footer column titles were `h4` straight after page `h2`s; now `<p class="f-h">` with the same computed style (Oswald 15px, weight 400). axe heading-order: 57 to 0.
- **Tap targets (WCAG 2.5.8):** padding on breadcrumbs, footer links (list gap reduced from 11 to 7px so the footer keeps its height), "Explore" and "Source" links, footer phone and email, legal contents links and standalone links; form checkboxes 24px on every form. Small targets on phone: about 2,800 to 24; the 24 left are 20 to 23px links inside lists and running text with space around them (INFERENCE: covered by the spacing exception; the crawler does not measure spacing).
- **Checks (VERIFIED, all 57 URLs at 1440 and 390):** no overflow, 0 rounded corners, 0 contrast failures, 0 text under 12px, no console errors. **Still flagged by axe (P3, not in this batch):** links inside the Services hub diagram SVG (nested interactive, 1), an empty first table header on 2 pages, and a banner landmark inside the post (1).

---

## D-139 · Design decisions on the audit: type scale, button label, US office, archives
**Date:** 7 October 2026 · **Status:** DONE on `.online` (Jamil: body "16", card titles "One", small text "12", width "1440 px", button label "Get your free diagnostic (Recommended)", footer names "No", US office "Yes", LiteSpeed Cache "No", archives "Yes")

- **Method for the type scale:** a browser scan of all 57 URLs (55 pages, 404, search) at 1440 and 390 px traced, for every visible text element, the CSS rule that wins its font size; only those rules were changed at source. SVG diagram text was excluded (it scales with the drawing). 286 declarations in 39 files.
  - **Body text 16px** (was 13 to 15.5px; 14.5px on most pages). Hero intros on Diagnostic and Packages now `clamp(16px, ...)`.
  - **12px minimum** for all text (was 10 to 11.5px for labels, breadcrumbs, sources, phone-hero labels, form labels).
  - **Card titles 20px** (was 11 sizes from 11 to 32px), plus a kit default `.rl-page h3` 20px. **Kept as they are:** FAQ questions (16px, they are the FAQ summary), and four section subheadings that sit above groups of cards (About "Career path" 26px, Services group headings 26px, Enterprise SEO "What we do instead" 22px, Awards feature 32px).
  - **Result (VERIFIED, re-scan):** 0 body-text elements under 16px, 0 elements under 12px, 0 card titles off 20px; no horizontal overflow at 390 or 1440 on any page.
- **Container width 1440 px** stays (it is what every page uses); this supersedes the "1280 content width" in D-013. `CLAUDE.md` updated.
- **One button label:** every button to the diagnostic reads "Get your free diagnostic" (header "Get Your Free Diagnostic"), replacing "Get My Search Authority Diagnostic" (31), "Book a Strategy Call" (Home), "Get a Free Quote" (footer), "Request My Search Authority Diagnostic" (form submit and SAOS), "Start with a diagnostic", "Start with the free diagnostic", "Find out where you stand", "Find your starting agent", "Get your diagnostic". 42 buttons in 33 files. The three package-tier buttons ("Start here", "Get the Growth OS", "Talk to us") stay, as they choose a plan.
- **Footer names:** unchanged (Jamil: "No").
- **US office:** Organization schema now has both addresses (Dhaka; 2511 Pines Pointe Dr, Katy, TX 77493) and `subOrganization` "Reinforce Lab (United States)", legalName "Reinforce Lab Inc", telephone +1-832-548-4553 (`core/reinforce-entity.php`).
- **LiteSpeed Cache:** stays inactive (Jamil: "No").
- **Archives retired:** author archives, date archives and the default "Uncategorized" category 301 to `/blog/` (`blog/reinforce-blog.php`, on `wp` before Yoast's own archive redirect); every `/author/...` path does the same, including production's former authors; `/paged-N/` junk keeps its approved 410 (F-001). Yoast author and date archives off; author sitemap gone; no category sitemap while only Uncategorized exists. **Found (VERIFIED, GSC 16 months):** 7 production author archives had impressions (`/author/catherine/` 16 clicks, 489 impressions; `/author/sabera/` 221; `/author/farihaanika/` 264). 16 production author URLs added to `claude/data/approved-redirects-2026-10.csv` as APPROVED-RETIRE, 301 to `/blog/`. **Target confirmed by Jamil for all 16 URLs** ("Confirm", 7 Oct 2026). No date or category archive URLs appear in the production data.

---

## D-138 · Site audit P1 fixes (F-028)
**Date:** 7 October 2026 · **Status:** DONE on `.online` (Jamil: "Do it all", for the P1 list; favicon: "Remind me later")

- **Zero radius (A1):** global rule in `core/reinforce-header.php` resets the Beaver Builder theme's 4 px radius on `.btn`, buttons, the menu button, cards and form fields (D-013).
- **Contrast (B1):** `--red-3` #e23b3b to **#e85050** and `--ink-faint` #877d75 to **#8f857d** (4.5:1 or better on #121011, #171314, #1a1516 and the red-tinted panels); small labels that used `--red-2` as text (`.tag`, `.tier`, `.ph`) now use `--red-3`; large step numbers `--red-3` at opacity .8 (3:1 for large text). Hard-coded copies of the old values in 14 files updated.
- **Blog card (A7):** the "empty grey box" was the grid's divider colour painted behind empty grid cells, not a missing image slot. Hairlines are now drawn per card. The post templates show the featured image as a large top image, so no featured image was added; the post got its own share image instead (attachment 336, source `claude/design-previews/og-post-330/`).
- **404 and search (A8):** new `pages/reinforce-system.php`. 404 and 410 keep their status codes; message, search box, six popular pages, diagnostic call to action. Search matches titles, meta descriptions and focus keyphrases as well as content (our pages store only a shortcode in `post_content`), one list with no pagination, noindex.
- **SMTP (C4):** found (VERIFIED, DNS from the server): both domains use Titan Email; SPF allows only `spf.titan.email`; `.com` has Titan DKIM (`titan1`), `.online` none; no DMARC on either; WordPress was sending from `wordpress@reinforcelab.online` through the web server's sendmail, which SPF does not cover. New `core/reinforce-mail.php` sends through `smtp.titan.email:465` as a `reinforcelab.com` mailbox, From name "Reinforce Lab", last failure kept in `rl_mail_last_error`. **Off until** `RL_SMTP_USER` and `RL_SMTP_PASS` are defined in `wp-config.php` (secrets never in git). Needs Jamil (O-027).
- **Consent and GA4 (C7):** new `core/reinforce-consent.php`, built to the existing Privacy Policy: bar on first visit, Decline and Accept with equal weight, nothing loads before Accept, Decline removes `_ga` cookies, Global Privacy Control counts as decline, "Cookie settings" in the footer reopens it, choice kept 6 months in local storage. GA4 loads only when option `rl_ga4_id` holds an ID (none yet, O-027). Tested in a browser with a temporary test ID (removed): no Google request before Accept or after Decline, one after Accept, GPC browser stores "denied". Jetpack Stats unchanged: verified it sets no cookies; the policy covers it under legitimate interest.
- **Privacy Policy (page 3):** one row added to the cookie table for the stored choice (`rl_consent`, local storage, 6 months) and GPC added to the decline sentence; "Last updated" 7 October 2026. Backup `claude/data/backups/privacy-page-3-before-consent-row-2026-10-07.json`.
- **Favicon (C1):** not built; Jamil asked to be reminded (O-026, reminder 8 Oct).
- **Tools:** `shot.mjs` joins its cache-buster with `&` when the path already has a query.

---

## F-028 · Full site audit: design consistency, accessibility, functions, performance
**Date:** 6 October 2026 · **Status:** OPEN, report delivered (Jamil: "Check again across entire website about what's missing and a complete audit for inconsistency in text size, design, UI, and whatsoever is required for a industry standard website functionalities and anything required for optimization")

- **Report:** `claude/research/site-audit-2026-10-06.md`. 55 URLs at 1440 and 390 px, axe-core on every page, HTTP checks, every internal link, one page per template reviewed visually. Read-only; nothing changed.
- **Passing (VERIFIED):** no horizontal scroll; CLS at most 0.003; H1, H2, lede, eyebrow, buttons, container and section spacing consistent on nearly all pages; 0 broken internal links; 0 images without alt; skip link and phone menu everywhere; forms labelled and protected.
- **P1:** 4 px rounded corners on every button, the menu button and some cards (Beaver Builder theme `.btn`, against D-013); colour contrast of `#e23b3b` and `#877d75` small text at 4.2 to 4.5:1 (841 elements, 51 pages); no favicon or site icon; empty grey image box on the blog card; 404 and search pages in the old default layout; form email sent without SMTP; consent banner and GA4 (launch list).
- **For Jamil:** body text size (14.5 px on most pages) and 11 card-title sizes; 12 px minimum; container 1440 vs 1280 in D-013; LiteSpeed Cache inactive; nine labels for the diagnostic button; footer legal names, duplicate phone number, US office not in schema; author, date and category archives (production URL patterns, Rule 2).
- **Correction to the audit method:** a first crawl reported JavaScript errors and Helvetica headings; they came from the sandbox proxy dropping assets and disappeared with cached assets. Not site defects.

---

## D-137 · AI Search Optimization page: SEO, GEO and AI search gaps closed
**Date:** 6 October 2026 · **Status:** DONE on `.online` (Jamil: "Do all that required using a checklist make sure everything is done properly")

- **Freshness:** page 72's modified date set to 6 Oct 2026 (one page, content unchanged; was 29 Sep), so Yoast now prints `dateModified` and the sitemap `lastmod` is 6 Oct. The hero shows "Last updated 6 October 2026" in a `<time>` element, read from the same date.
- **Price in schema:** Service `offers`: USD 5000, link to `/packages/`, description "Part of every Search Authority OS package: Foundation from $5,000 setup plus $1,500 to $2,500 a month." (matches the Packages page).
- **Named expert:** hero line "Led by Jamil Ahmed, founder", linked to About; WebPage `reviewedBy` Jamil (same Person `@id` as About and the posts) and `lastReviewed`. No photo until the headshot arrives.
- **Share image:** attachment 335, 1200 x 630, made from the default card (source `claude/design-previews/og-aiso/`); set as the page's Open Graph and X image through Yoast (`WPSEO_Meta::set_value`, because a plain `update_post_meta` on the `-id` keys did not save); width, height and type now printed.
- **Correction (F):** the earlier report that no page has a main landmark was wrong. Beaver Builder's content wrapper carries `role="main"` on every page; `seo-audit.py` only looked for the `<main>` tag. The audit now counts `role="main"`: 55 of 55 pages. No theme change made.
- **Checklist run (all pass):** PHP lint; copy-check 0 (file, share card and live HTML); reading grade 7.4; audit gates pass on all 55 pages (no broken schema references, FAQ 10 in schema and visible, title 54, meta 153, no duplicate title or meta); page 132 KB; no PHP log entries; desktop and phone (390) checked.
- **Still open (need Jamil or launch):** a real result or case study for AI search (none on file, none invented); founder headshot; canonical tags (absent while `.online` is noindex, launch list); actual AI citations can only be measured after launch.

---

## D-136 · AI Search Optimization page: conversion points
**Date:** 6 October 2026 · **Status:** DONE on `.online` (Jamil: "I don't want to change anything that is included. But there are less call to action for conversion", then "Go ahead" to all six additions)

- **Found (VERIFIED, live page before the change):** 2 places to act (hero and final section, both the diagnostic) with 10 sections and about 2,100 words between them; the price only inside a closed FAQ; no client proof; no contact or packages path.
- **Added to page 72 (`services/reinforce-aiso.php`), nothing removed:**
  1. After How it works: "Step 1 is free." with the diagnostic button.
  2. After the deliverables: price strip "From $5,000 setup" (Search Authority OS, $1,500 to $2,500 a month, as on Packages) with diagnostic and packages buttons.
  3. After the agency checklist: "Ask us these five questions." with a Talk to us button (`/contact-us/`).
  4. Client strip under the hero: 6 white logos (UIU, Beacon Pharmaceuticals, Bikroy.com, HP, Accesstel, Union Properties), "Businesses that have worked with Reinforce Lab", link to `/clients/`. Worded so it does not claim they bought AI search optimization.
  5. FAQ links (markup only, FAQ schema unchanged): cost answer links to Packages and the diagnostic; guarantee answer links to the diagnostic.
  6. Final section: Talk to us button and a "What happens next" line taken from the Diagnostic page's own FAQ (research, human check, diagnostic with a prioritized 90-day plan).
- **Result:** buttons on the page 4 to 9, plus 3 FAQ links and the clients link; visible words 2,356 to 2,515; 131 KB; audit gates pass; copy-check 0; desktop and phone (390) checked.

---

## D-135 · Keyword map v2: AI search optimization services
**Date:** 6 October 2026 · **Status:** DONE on `.online` (Jamil returned the map with "Continue from where you left off" and, on the cost FAQ, "Should it show the Search Authority OS price ($5,000 setup), keep it": read as approval of the map and of showing the price)

| Page | Primary keyword | Secondary keywords |
|---|---|---|
| `/services/ai-search-optimization/` (page 72) | ai search optimization services | ai seo services, ai seo service, ai search engine optimization services, ai powered / ai-powered search engine optimization services, ai search service (kept) |
| Future post | which citation analysis service is best for ai seo (90, KD 1) | |
| Future post | how is ai impacting the seo consulting services industry (30) | |
| Future post | how much do ai seo agency services cost pricing comparison (30) | ai seo content writing pricing per article (2,900, KD 17) |

Volumes: Semrush, Jamil's screenshots (`claude/data/semrush/keywords-2026-10-06.md`). "what is ai optimization aio for search engines services", "what is ai seo or aio services for agencies" and "how can ai seo services improve my website's visibility" are answered on page 72 (FAQs).

- **Competitor semantics (D-134 method on a service page):** 14 results from the Semrush SERP screenshots; 8 fetched and analysed, 6 read with Exa (Thrive x2, DareAISearch, Blueleaf, Trefoil, NP Digital). Report: `claude/research/serp/ai-search-optimization-services/report.md`. Ranking service pages are about 970 to 3,640 words; list pages ("best AI SEO agencies") 3,660 to 5,360 and often rank their own company first.
- **Page 72 changed:**
  - H1 "AI Search Optimization Services. Be named in AI answers."; lede opens with "Reinforce Lab's AI search optimization services (also called AI SEO services)" and names Copilot and AI Mode.
  - Definitions lede names the other labels buyers see: AI SEO, AIO, AEO, AI-powered search engine optimization. Deliverables H2 "What do our AI SEO services include?"
  - New section "How do you choose an AI SEO agency?" (5 questions: prompts, engines, site changes, sources for claims, what cannot be promised).
  - Measurement: cited versus recommended counted separately; GA4 and Search Console for AI referrals; AI visibility tools named as options (Semrush AI Visibility Toolkit, Ahrefs Brand Radar, Profound, Peec AI) without claiming we use them.
  - FAQs 6 to 10: "What are AI SEO services?", "How can AI SEO services improve my website's visibility?", "How much do AI search optimization services cost?" (Foundation $5,000 setup plus $1,500 to $2,500 a month; AI visibility monitoring from Growth OS $10,000 setup plus $3,500 to $5,000 a month; audit from $2,500; diagnostic free; matches the Packages page), "Do I need a separate AI SEO agency?" (also covers agency versus tool). First FAQ adds "also called AI optimization (AIO) or AI SEO".
  - Natural term additions: traditional SEO, large language models, search intent, link building, content roadmap, topical authority, search visibility.
  - Service schema name "AI Search Optimization Services" with alternate names; Yoast focus keyphrase "ai search optimization services"; meta "AI search optimization services from Reinforce Lab: get your brand found, cited and described accurately in ChatGPT, Perplexity, Gemini and AI Overviews." (153); title unchanged (54).
- **Checks:** copy-check 0; audit gates pass (55 pages, 10 FAQ in schema and visible, 9 question H2s, 125 KB); reading grade 7.5; desktop and phone (390) checked. Common competitor terms missing from the page: 460 to 415 (the rest are generic words or do not fit).

---

## D-134 · Blog post rules: grade 8 reading level and top-10 competitor semantics
**Date:** 5 October 2026 · **Status:** DONE; binding for every post (Jamil: "the reading difficulty should be 8th grader for all posts .... before writing any post must analyze top 10 results in google with exa ai and find out semantics and use with in the posts for outrank the competitors"; then "Talk about Claude Code, SEO Tools used in \"How does Reinforce Lab use one itself\". We followed a structured and data driven process for Reinforce Lab and started implantation of AI Growth Systems in Reinforce Lab")

- **Rules written into `CLAUDE.md`** (copy rules section) and the full steps into `claude/blog-post-procedure.md`.
- **New tools:** `claude/tools/readability.py` (Flesch-Kincaid grade of the article text; grade 8.0 or lower to pass) and `claude/tools/serp-semantics.py` (competitor pages fetched through the .online server one per call; common terms, heading questions, gaps against our page; report in `claude/research/serp/<slug>/`). Limitation stated in the procedure: Exa cannot reproduce Google's ranking, so Google's order comes from a Google results page; Exa supplies URLs, its own top results, and the text of pages the server cannot read.
- **Applied to "What Is an AI Growth System?" (post 330):**
  - Reading level: grade 5.8 (Flesch-Kincaid), reading ease 74, 11.3 words per sentence. Sentences still above grade 8 are the approved definition, the author bio and short labels.
  - Competitor set: 14 pages (Google results from Jamil's screenshot: Forsify on LinkedIn, Data-Mania, Novus Pathway, IB Solutions, Ikigai, Mervyn Chua; Bing's: Future Made Useful, SEnuke; Exa's: Pointer Strategy, GREX, GrowthX, Data-Mania AI-native, Digital Estate Media, GTM Labs). 12 fetched; SEnuke and Pointer Strategy read through Exa. AI Human Growth Systems (410) and aigrowthsystems.blog (404) no longer exist.
  - Added from the analysis: buyer signals and intent, clean data, lead scoring and routing, the full funnel (outreach, onboarding, retention), several AI agents with one job each, the alternative names (AI growth engine, growth operating system); 4 FAQs competitors answer in headings (same as an AI growth engine? what data? how long before results? privacy laws GDPR and CCPA); sources added: California Attorney General CCPA page, Google traffic-drop guidance. 10 FAQs, 9 sources. Common competitor terms missing from the post: 188 to 170 (the rest are generic words).
  - "How does Reinforce Lab use one itself?" rewritten as Jamil asked: the structured, data-driven process and the start of Reinforce Lab's own AI growth system, naming the tools the records show were used: Google Search Console (16 months), Google Analytics 4, Screaming Frog (21 Aug 2026 crawl), Semrush (search demand), Exa (research), Claude Code (Anthropic's AI coding agent, connected to WordPress), Yoast SEO; plus the automatic checks (writing rules, grade 8, 10-point standard), sources read on the day, founder approval with logged decisions, one post at a time. Ahrefs appears in old notes without confirmed use, so it is not named.
- **Page weight:** line-break whitespace between tags is now removed on every front-end page (`<script>`, `<pre>`, `<textarea>` untouched); 5 pages pixel-identical before and after on desktop and phone; about 3.5 KB saved per page. The post is 150,788 bytes, 0.5% over the "< 150 KB where feasible" budget because of added article content, not code: accepted as a content-driven exception.
- **Backups:** `claude/data/backups/post-330-before-d134-2026-10-05.json`; body v3 `claude/drafts/blog-what-is-an-ai-growth-system-body-v3-2026-10-05.html`.

---

## D-133 · Related reading on every post
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "There must an option for related post or something like that in the end of the post")

- **Found:** every post template already had a "Related articles" section, but it showed other posts only, so with one post published it was hidden.
- **Changed (`blog/reinforce-post.php` + the 8 type templates):** new helpers `rl_post_rel_pages()` and `rl_post_rel_section()`. When there are no related posts, a "Related reading" section (`#related-reading`) shows 3 pages; when there are 1 or 2, the list is topped up to 3. Page order: the post's own in-article CTA page, then AI Growth Systems, Search Authority OS and the Search Authority Diagnostic, then the post's related-term links, then Services; never the current page; each card shows its type, title, a short description (Yoast meta) and "Read more". Case Study and Research keep their own card designs and get the fallback section only when they have no related posts.
- **Live on the first post:** AI Growth Systems, Search Authority OS, Search Authority Diagnostic. Checked on desktop and phone; no PHP notices; one `id="related"` per page.

## F-027 · Review of the first post
**Date:** 5 October 2026 · **Status:** OPEN (Jamil: "now analyze the post and tell me how good the post is")

- **Measured (VERIFIED):** 2,593 visible words, 18 H2 (7 questions), 12 lists, 1 table, 0 images (10 SVG icons), 4 outside source domains (7 sources), 9 internal links out, 3 in; keyword "ai growth system" in title, H1 and first 100 words, 32 uses (about 1.2%); definition 38 words; average sentence 19 words, Flesch reading ease about 57 (fairly hard); schema BlogPosting, Person, FAQPage (6), DefinedTerm; 143 KB; author bio present (347 characters) but no photo.
- **Strong:** quotable definition and DefinedTerm schema (what AI answers lift); covers all four components in Google's AI Overview; worked example, comparison table, failure modes and self-test that the top results lack; primary sources only; no invented numbers; correct internal links both ways.
- **Fixed (Jamil: "fix all the things that can be fixed"):**
  - **First-hand evidence:** new section "How does Reinforce Lab use one itself?" describing only what is verifiably true of this site's rebuild: 16 months of GSC data and a crawl analysed first, AI for research and drafts, every page tested against the copy rules and the 10-gate standard ("At the time of writing, all 55 published pages pass"), outside claims linked and read on the day, the founder approves every page and URL with each decision logged, posts published singly. Links to `/services/ai-growth-systems/`.
  - **Diagram in the body:** new shortcode `[reinforce_ag_layers]` (`services/reinforce-aigrowth.php`) renders the same four-layer diagram as the service page, with the `rl_ph()` phone version and a caption; placed after "What are the four layers?".
  - **Readability:** 11 long sentences split (body, 1-minute summary, FAQ 4); average sentence 19.0 to 13.9 words, Flesch reading ease about 57 to 66. Body v2: `claude/drafts/blog-what-is-an-ai-growth-system-body-v2-2026-10-05.html` (backup of v1: `claude/data/backups/post-330-before-f027-2026-10-05.json`).
  - **Page weight (the diagram pushed the post to 151.5 KB):** the variable fonts now use one `@font-face` per subset (18 to 8 rules, inline font CSS 6.4 to 3.1 KB on every page); all inline `<style>` in `<head>` is minified on every page (Home, the post and the AI Growth Systems page pixel-identical before and after, desktop and phone); the diagram CSS lost unused colour fallbacks; caption shortened. Post 149,979 bytes, under the 150,000-byte budget with little margin: posts with heavier bodies will need the budget looked at again.
  - **Still open:** author photo (Jamil's headshot); low search demand for the term (not fixable; the value is AI citation and category ownership); links from future posts.
- **Weak:** (1) no first-hand evidence: the worked example is illustrative, and nothing shows a system Reinforce Lab has actually built or runs on itself (Home says "We run this system on ourselves"); (2) no diagram in the article body (the four-layer diagram exists on the service page); (3) readability is on the hard side for a definition page; (4) author box has no photo (headshot still awaited); (5) demand for the term is small (Semrush, D-008: 20 US / 40 global a month), so the value is AI citations and category ownership, not traffic; (6) no other posts link to it yet.

---

## D-132 · First blog post: "What Is an AI Growth System?"
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil approved the draft: URL "Yes", definition "Yes", author "Yes", tools "Keep as written", price in the post "No")

- **URL:** `/what-is-an-ai-growth-system/` (post 330), not `/blog/...`. Production's 111 posts all sit at the root (`/%postname%/`, VERIFIED in GSC Pages.csv; D-071), and changing the pattern would move every production post URL (Rule 2). Jamil chose the root pattern: "/what-is-an-ai-growth-system/ (Recommended)". Every future post follows the same rule; `/blog/` lists them.
- **Post:** Explainer template (D-077), author Jamil Ahmed, primary keyword "what is an ai growth system" (D-130, Yoast focus keyphrase), title "What Is an AI Growth System? | Reinforce Lab" (44), meta 152. Definition, key facts, 10-second and 1-minute versions, how it works (5 steps), it is / is not, before-and-after enquiry example, related terms, in-article CTA to `/services/ai-growth-systems/`, body of about 1,300 words (four layers incl. signal capture, an illustrative worked example clearly labelled as not a client case, comparison table, what to measure, what drives cost with no prices, failure modes and what stays human, five-question test, how to start), 6 FAQs, 7 sources. Draft and field data: `claude/drafts/blog-what-is-an-ai-growth-system-draft-2026-10-05.md`, `...-post-2026-10-05.json`.
- **SERP basis (Jamil's screenshots, 5 Oct):** Bing: futuremadeuseful.com #1 and first in the AI summary; SEnuke #2. Google: the AI Overview cites a LinkedIn (Forsify) article and lists data foundation, signal capture, automated workflows, continuous learning loop; the post covers all four by name. Gaps filled: worked example with real tools, cost drivers, failure modes, regulated-industry and data-protection points, a self-test.
- **Linked:** Home FAQ "What is an AI Growth System?" shortened to one sentence plus "Read the full explanation" (FAQ schema text updated to match); `/services/ai-growth-systems/` links to it ("Read what an AI growth system is"); `/blog/` lists it; post sitemap; `llms.txt` gains an "Articles" section (all published posts, automatic).
- **Also changed:** `blog/reinforce-post-types.php` adds AI Growth Systems as a CTA service; `core/reinforce-header.php` drops WordPress block CSS on posts with no block markup (this post 170 KB to 143 KB, screenshots identical); `claude/tools/seo-audit.py` no longer strips `<header>`/`<footer>` inside the content (post templates wrap the H1 in `<header>`).
- **Fixed after publishing:** the "Field" line showed "Text" (the converter read the draft table's header row); set to "Marketing operations, search and automation" and verified.
- **Verified:** 200, noindex, 1 H1, schema BlogPosting + Person + FAQPage (6) + DefinedTerm, no PHP notices, 143 KB, share image, 4 outside source domains, phone width 390, `copy-check.py` 0 issues; site-wide audit passes on all 55 pages.
- **F-003:** one post, published singly.

---

## D-131 · AI Growth Systems pillar page built
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "/services/ai-growth-systems/ Yes then Blog \"what is an ai growth system\"")

- **URL:** `/services/ai-growth-systems/` (approved new URL, D-003 / D-006a). Page 71 was an empty draft; now published with `[reinforce_aigrowth]`, new file `services/reinforce-aigrowth.php` (added to the loader). Primary keyword "ai growth systems" (D-130, Yoast focus keyphrase set). Yoast title "AI Growth Systems: Design, Build and Run | Reinforce Lab" (56), meta 159.
- **Content (facts consistent with Home and Packages):** hero with a four-layer diagram (data, AI models, workflows, dashboard, feeding hours saved, search visibility, qualified pipeline; phone version via `rl_ph`); the four layers in depth with an example each; six systems by use case linking to Search Authority OS, SEO Content Systems, AI Workflow Automation, Marketing Automation, Lead Generation Systems and Executive AI Consulting, each with what it is measured by; the engagement (Diagnose, Architect, Build and automate, Measure and improve); deliverables; price teaser ("From $5,000 setup", the Search Authority OS Foundation price from Packages); comparison with an agency retainer and buying AI tools; straight answer on oversight, sourced to the NIST AI Risk Management Framework and Google's AI-content guidance; the 8 industries; 6 FAQs; Diagnostic CTA. No client results or invented numbers.
- **Hero fix (Jamil: "seems a miss match with the other hero image size"):** the first diagram (viewBox 520 x 330) rendered 622 x 435 px and sat centred, shorter than the text column. Redrawn at 520 x 392 (taller layer blocks, larger labels, an approval line at the foot), it now measures 622 x 505 px starting at y 199 with a 665 px hero, identical to AI Search Optimization, Technical SEO and Marketing Automation (`claude/tools/hero-audit.mjs`).
- **Schema:** Service with an OfferCatalog of the six systems, FAQPage (6, matching the visible FAQ), WebPage `citation` (NIST, Google).
- **Links in:** menu "AI Growth Systems (Overview)", footer, Services hub, Search Authority OS, and a new contextual link in Home's "How is an AI Growth System built?" section ("See the systems we build").
- **Verified:** 200, 1 H1, no PHP notices, 119 KB, 7 of 9 H2s are questions, answer-first, brand early, share image, `copy-check.py` 0 issues, phone width 390, listed in `llms.txt`; site-wide audit still passes on all 54 pages.
- **Next (D-130):** the blog post "what is an ai growth system"; when it is published, Home's FAQ answer "What is an AI Growth System?" is shortened to a brief answer linking to it.

---

## D-130 · Keyword map v1 (replaces D-035's keyword ownership)
**Date:** 5 October 2026 · **Status:** APPROVED by Jamil ("ai growth system", then "/services/ai-growth-systems/ Yes then Blog \"what is an ai growth system\"", then, shown D-035 side by side, "Replace D-035 with today's plan")

| Page | Primary keyword | Why |
|---|---|---|
| Home `/` | reinforce lab | VERIFIED GSC (16 months, production): "reinforce lab" 100 clicks, 611 impressions, 16.4% CTR, position 2.5. Home keeps "AI Growth Systems" in its title and H1 as the category |
| About `/about-us/` | about reinforce lab | Entity page (founder, founding date, offices); production About: 1,961 impressions, 5 clicks |
| `/services/ai-growth-systems/` (page 71) | ai growth systems | The category's commercial pillar: what Reinforce Lab builds and how to engage. Semrush (D-008): "ai growth systems" 20 US / 40 global per month, a category play |
| Blog post (first) | what is an ai growth system | Informational definition; links to page 71 |

- **Replaces D-035** (28 Sep: Home owns "AI Growth Systems"; page 71 = "ai growth systems consulting"). **Consequence:** Home's FAQ "What is an AI Growth System?" (with FAQPage schema) would compete with the blog post; it is to be shortened to a brief answer linking to the post when the post is published.
- **Yoast focus keyphrases set:** page 33 "reinforce lab", page 218 "about reinforce lab", page 71 "ai growth systems".
- **Found (VERIFIED GSC):** "reinforce labs" (with an s) has 5,462 impressions at 0.57% CTR, position 6.1, the site's largest query by impressions; INFERENCE: searches for a different company with a similar name. Clear entity naming (schema, llms.txt) is the response; no action on production.
- **Rule from now on:** one primary keyword per page, recorded here before the page is built.

---

## F-026 · Readiness audit, second pass, and fixes
**Date:** 5 October 2026 · **Status:** FIXES DONE on `.online` (Jamil: "go ahead check all the seo, GEO, LLMs, AI Searches, AEO readiness")

- **Report:** `claude/research/seo-aeo-geo-readiness-2026-10-05-v2.md`. 53 published pages audited with the extended `claude/tools/seo-audit.py`.
- **Passing on 53 of 53:** one H1, heading order, titles and metas within limits and unique, noindex, schema parses with no broken references, FAQ schema matches visible FAQs, answer-first openings, brand named early, share image, alt text, HTML under 150 KB (93 to 135 KB). Organization entity complete (founding date, RJSC identifier, address, contacts, 9 profiles). Home CLS 0.005 in the lab (was 0.154), 0 Google Fonts requests.
- **Fixed:** "Reinforce Lab's" in the openings of the 8 agent pages, Audit and Packages, and the FTC lede (page 224, backup `claude/data/backups/ftc-page-224-before-lede-2026-10-05.json`); default share image (attachment 328, source `claude/design-previews/og-default/`) as Yoast default and front-page image; `llms.txt` now 54 links (Portfolio, Clients, projects, legal pages, certificate); block-library CSS and global styles removed on shortcode pages and the emoji script removed site-wide (`core/reinforce-header.php`); Clients linked from About and Portfolio.
- **Citations added (Jamil: "go ahead"):** every URL checked from the `.online` server (200) or, where Cloudflare blocks automated checks (Europe PMC), read through Exa; the claims attributed to Google were read in Google's own pages (traffic drops "could take several months", AI features have "no additional technical requirements", automation to manipulate rankings breaks the spam policies).
  - **8 agent pages** (`saos/reinforce-agent-pages.php`, new `src` key): one sourced sentence added to each "Straight answer" paragraph, a "Sources:" line under it, and the same list as `citation` on the WebPage schema. Sources: Search Console Performance report, Google helpful-content guidance, Search Quality Rater Guidelines, FTC Health Products Compliance Guidance, PubMed, ClinicalTrials.gov, Google AI features, OpenAI and Perplexity crawler docs, the GEO paper (arXiv 2311.09735), ICO legitimate interests, GDPR (EUR-Lex), Google spam policies, Google AI-content guidance, Google traffic-drop debugging, Google ranking updates.
  - **Home** (problem section: Google AI features, OpenAI, Perplexity), **Search Authority OS** (problem section: AI features, helpful content, spam policies; evidence layer: PubMed, Europe PMC, ClinicalTrials.gov, FDA), **Diagnostic** (Search Console, AI features, OpenAI), **AI Search Optimization** (robots.txt, Google common crawlers incl. Google-Extended, OpenAI, Perplexity; llms.txt, structured data, AI features, GEO paper), **SEO & AI Search Audit** (web.dev Web Vitals, hreflang, Search Console; AI features under the AI-testing method). A `.src` style was added to the Home, Search Authority OS and Diagnostic stylesheets.
  - **Result:** 42 of 53 pages cite outside sources (was 29). Not cited, by design: Packages (pricing), Services and Agents hubs (they link to sourced pages), Contact, Blog index, Clients, 2 project pages, Privacy, Terms, FTC.
- **Question-shaped H2s (Jamil: "apply these as written"):** Home: "Why does growth stall when marketing, search and operations run apart?", "How is an AI Growth System built?", "What should you know about AI Growth Systems?". Search Authority OS: "Why does search strategy break on disconnected systems?", "How is Search Authority OS different from a content team?", "What should you know before booking a diagnostic?". Diagnostic: "What does the diagnostic review?", "How does the diagnostic work?", "What do people ask about the diagnostic?". Each page now has 3 question H2s; layouts checked on desktop and phone (width 390).
- **Open:** blog posts; launch items (canonical check, AI-crawler policy, VAT/BIN).

---

## D-129 · Founding date is 19 April 2022
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "Change the founding date to 19 April 2022 everywhere."). Supersedes D-108 (1 April 2021).

- **Source:** the RJSC Certificate of Incorporation, No. C-180618/2022, dated 19 April 2022 (D-128).
- **Changed:** About page (`pages/reinforce-about.php`): Organization `foundingDate` 2022-04-19 and `foundingLocation` Dhaka, Bangladesh; "At a glance" Founded; story paragraph; route strip now 2020 Tallinn, 2021 Dhaka (our team in Bangladesh), 2022 Dhaka (Reinforce Lab Limited founded), Today (4 columns, 2 x 2 on phone); milestones (2021 expands to Bangladesh, 2022 Limited founded); founder career line; FAQ "When and where did Reinforce Lab start?". `/llms.txt` legal-name line (`core/reinforce-entity.php`) now gives the founding date and RJSC number. Yoast setting `org-founding-date` was also 2021-04-01 and fed the Organization schema on every page: now 2022-04-19 (backup `claude/data/backups/yoast-founding-date-before-2026-10-05.json`).
- **Kept (history, not the founding date):** started in Tallinn in 2020 and expanded to Bangladesh in 2021 (Jamil, D-109); the 2021 project dates in the portfolio (from production's project pages); Clients "Working with clients since 2021".
- **Verified:** `foundingDate` 2022-04-19 on Services, Contact, Awards, About, Clients and a project page (Home outputs none); no "April 2021" or "2021-04" left on any checked page; About story checked on desktop and phone; `copy-check.py` 0 issues.

---

## D-128 · Certificate of Incorporation; RJSC number on the site
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil uploaded `Certificate-of-Incorporation-Reinforce-Lab-Limited.pdf`; earlier: "Public, I'll upload it")

- **The certificate (VERIFIED, read from the PDF):** "REINFORCE LAB LTD." incorporated under the Companies Act (Act XVIII) of 1994, a limited company, **No. C-180618/2022**, given at Dhaka on **19 April 2022** by the Assistant Registrar, RJSC; Issue No. 292581; digitally signed (PDF metadata: author RJSC, created 19 Apr 2022).
- **URL kept:** production serves this PDF at `/wp-content/uploads/2023/09/Certificate-of-Incorporation-Reinforce-Lab-Limited.pdf` (GSC 16 months: 2 clicks, 52 impressions). The unmodified file (MD5 e47934a0..., 325,325 bytes, so the digital signature still verifies) is now at the same path on `.online` (attachment 324, option `rl_coi_attachment`). No HTML page was created (a new URL would need approval); the footer "Certificate of Incorporation" opens the PDF in a new tab, as on production.
- **Registration number used:** Organization schema `identifier` (PropertyValue, RJSC company registration number) and `address` (Dhaka office) in `core/reinforce-entity.php`; Terms & Conditions "Who we are" (with the incorporation date) and Privacy Policy "Who we are" (drafts updated too; page backup `claude/data/backups/terms-privacy-before-rjsc-2026-10-05.json`). This closes the RJSC part of the EU E-Commerce Directive art. 5 item (D-121); the VAT/BIN number is still pending.
- **Found and fixed, noindex gap:** `.online` sends noindex on pages (`blog_public` 0) but files in uploads (PDFs, images) had no robots header and robots.txt allows all. Added `wp-content/uploads/.htaccess` with `Header set X-Robots-Tag "noindex, nofollow"` (copy in `claude/data/online-config/uploads-htaccess.txt`); verified on the PDF and a logo. Marked in the file and on the launch gate: do NOT copy it to reinforcelab.com.
- **For Jamil to decide (not changed):** the site gives the founding date as 1 April 2021 everywhere (D-108, About schema `foundingDate`), while the legal company was incorporated on 19 April 2022. Both can be true (business start vs company registration); options are in the report.

---

## D-127 · Clients page with the 46 client logos
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil sent a screenshot of reinforcelab.com/clients/, then chose "Download from production (Recommended)" and "Yes, all are real clients")

- **URL:** `/clients/` (production URL kept; URL Register: PRESERVE, Jamil to mark). New page 277, `[reinforce_clients]`, new file `pages/reinforce-clients.php` (added to the loader). Yoast title "Clients: 46 Businesses We Have Worked With | Reinforce Lab" (58), meta 152.
- **Logos:** the `.online` server fetched production's `/clients/` HTML and the 46 logo images with plain GET requests (read-only; nothing changed on production). Imported as attachments 231 to 276 named `client-<slug>`, alt "<Client> logo", source URL in `_rl_source_url`; map in option `rl_client_logos`; list with sources in `claude/data/client-logos-2026-10.csv`. Names cleaned from production's alt text (e.g. "Micro International" is MRCO International per its logo, "Sofovel" is Sofosvel, "fbs" is the Faculty of Business Studies, University of Dhaka). Most files are 226 x 100 px, as on production.
- **Page:** hero with tally (46 clients, since 2021) and six logos; logo wall (6 columns, 4 on tablet, 2 on phone) on light tiles with each client's name in text; "Project" links on AccessTUTOR, IBA Alumni Association, INPACE and Inpace Shop to their `/portfolio/<slug>/` pages; project cards; FAQ; CTA. Schema: CollectionPage, ItemList of 46 Organization with logo, FAQPage.
- **v2 (Jamil: "It looks like you forcefully inserted the logos"):** the cream tiles with each client's own white logo box are gone. All logos are now drawn in one light tone straight on the dark background (CSS `grayscale(1) invert(1)` with `mix-blend-mode:screen`, which also drops each logo's white box; six light-coloured logos get a brightness lift so they match). They sit in a quiet 6-column grid (4 on tablet, 3 on phone) with hairline dividers, full brightness on hover. Client names moved out of the tiles into an "All 46 clients" text list in columns, with links on the four that have a project page. The hero's six logos use the same treatment. The original colour files are unchanged in the media library.
- **v3 (Jamil: "The logos are difficult to read. edit the logos and make it white"):** the CSS filter is gone. Each logo now has a real white PNG made from the original on the server (PHP GD): the background (white, or transparent read as white) drops out, and every other pixel becomes white with opacity in proportion to how far it is from that background, so anti-aliased edges stay smooth and white details inside a mark (the "hp", "PULSE", the knocked-out text) stay see-through instead of merging into a block. NZ Group (black letters on orange boxes) is made from its dark parts only. The white files are attachments 278 to 323 (`client-<slug>-white.png`; NZ Group `-white-v2.png`), mapped in option `rl_client_logos_white` and used on the page at 88% opacity, full on hover; originals 231 to 276 are unchanged and stay in the schema `logo`.
- **Links:** footer Clients links to the page (no menu item exists).
- **Verified:** 200, 1 H1, 46 logos load, no PHP notices, `copy-check.py` 0 issues, phone width 390.

---

## D-126 · Project pages moved under /portfolio/
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "it should be under https://reinforcelab.online/portfolio/ no \"/projects\"")

- **New URLs (APPROVED-NEW, added to `claude/data/approved-new-urls-2026-09.csv`):** `/portfolio/inpace-shop/`, `/portfolio/access-tutor/`, `/portfolio/iba-alumni-lottery/`. The `rl_project` rewrite slug is now `portfolio`, still with no archive, so `/portfolio/` remains the Portfolio page (200) and `/projects/` is 404.
- **Redirects (production URLs change at migration, approved by Jamil for these four):** `/projects/inpace-shop/`, `/projects/access-tutor/`, `/projects/iba-alumni-lottery/` 301 to the matching `/portfolio/<slug>/`; the old production Yoast redirect `/projects/access-tutor-copy` now goes straight to `/portfolio/inpace-shop/` (one hop, no chain). Recorded in the new `claude/data/approved-redirects-2026-10.csv` in the redirect-map columns from `claude/migration-and-data-requirements.md` §2. Already live on `.online` (a `template_redirect` in `pages/reinforce-portfolio.php`) so they can be tested: all four return 301 to the right page.
- **Yoast:** its stored indexables for posts 228 to 230 still had `/projects/` permalinks (og:url); they were deleted so Yoast rebuilt them. No `/projects/` left in the page HTML.
- **Verified:** 3 project pages 200 with 1 H1; Portfolio links to all three; `site-map.py` groups `/portfolio/<slug>/` as Projects.

---

## D-125 · Project pages rebuilt at the production URLs
**Date:** 5 October 2026 · **Status:** URLs SUPERSEDED by D-126 (now `/portfolio/<slug>/`); content and template stand. DONE on `.online` (Jamil sent the three production URLs, then chose "Rebuild at same URLs")

- **URLs (production kept; URL Register: mark PRESERVE, Jamil):** `/projects/inpace-shop/` (post 228), `/projects/access-tutor/` (229), `/projects/iba-alumni-lottery/` (230). GSC 16 months (VERIFIED, `claude/data/gsc-2026-09/performance/Pages.csv`): 2 clicks / 325 impressions, 1 / 512, 1 / 341. Production also has a Yoast 301 `projects/access-tutor-copy` to `/projects/inpace-shop` (`claude/data/production-config/yoast-redirects-2026-09-10.csv`); keep it in the migration redirect map.
- **How:** a public post type `rl_project` with rewrite slug `projects` and **no archive**, so `/projects/` itself does not exist (404, tested) and no unapproved URL is created. Original production publish dates kept (16 and 21 Mar 2023). Content `[reinforce_project]`, rendered from `rl_project_details()` in `pages/reinforce-portfolio.php`. The theme's blog sidebar is switched off for this type, and `rl_is_rl_page()` (header) now also strips the theme title on project pages.
- **Content:** rewritten from the production pages (read-only, Exa) to the copy rules (production used "seamless", "cutting-edge", "robust", "revolutionizing", "empowering"). Facts only: client, industry, period, team, work, the brief, what we built, stack, what the client got. Production's unsourced claims ("increase in student engagement", "a resounding success") are left out; each page says results are published only with a source and client approval.
- **Page:** hero with project facts panel; the brief; what we built (4 blocks) and stack; what the client got; other projects; CTA. Schema: WebPage with `mainEntity` CreativeWork (creator = Organization, client as `sourceOrganization`); Yoast breadcrumb Home > Portfolio > project. Yoast titles 54, 53, 51; metas 149, 145, 150.
- **Portfolio:** the three cards now show "Read the project" instead of the client-site link.
- **Tools:** `rl.py` snapshot and crawl, and `site-map.py`, now include `rl_project` (site map section "Projects").
- **Verified:** all three 200, 1 H1, no PHP notices, full width, phone width 390, `copy-check.py` 0 issues.

---

## D-124 · Portfolio page built with placeholder projects; Careers hidden
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "i will give the portfolio later now build the page with dummy posrtfolio you can read the .com site for portfolio"; Clients: "I'll send names and logos"; Careers: "Hide for now"; Certificate: "Public, I'll upload it")

- **URL:** `/portfolio/` (production URL kept; rule R4 core page, `claude/preserve-disposition-rules.md`). New page 227, `[reinforce_portfolio]`, new file `pages/reinforce-portfolio.php` (added to the loader). Yoast title "Portfolio: Websites, Stores and Web Apps | Reinforce Lab" (56), meta 157.
- **Placeholder content, not invented:** the six projects already shown on reinforcelab.com/portfolio/ (Inpace Shop, AccessTUTOR, IBA Alumni Lottery, Signature Jeans, Beyond Borders, Advocate Gazi). Facts read-only via Exa from production `/portfolio/` and `/projects/inpace-shop/`, `/projects/access-tutor/`, `/projects/iba-alumni-lottery/` (client names, project periods, tasks, stack); client sites inpaceshop.com, signaturejeansbd.com, advocategazi.com (footer credits Reinforce Lab, (c) 2022). No results, numbers or quotes: the page says case studies with results are on the way and that a number appears only with a source and client approval. All data in one array, `rl_portfolio_data()`, for Jamil's real list.
- **Confirmed by Jamil (5 Oct):** Signature Jeans 2024 (now shown); abusayeddev.com, which also lists the site, was a freelancer working for us; Advocate Gazi 2022 okay. **Still [CONFIRM]:** Beyond Borders client, industry, year and URL (shown as "Website, content and SEO" only).
- **Not created:** production's `/projects/<slug>/` detail pages (URLs PENDING); cards link to the client sites instead.
- **Page:** hero with a tally panel (projects, industries, first project 2021, offices) and types of work; project cards with a drawn frame per work type (store, app, site; screenshots later), client and industry link, what they needed, what we built, stack, site link; services strip (WordPress, E-commerce, SEO, Maintenance); FAQ; Diagnostic CTA. Schema: CollectionPage, ItemList of 6 CreativeWork (creator = Organization), FAQPage.
- **Links:** Primary menu items 48 and 149 "Portfolio" changed from `#` to page 227 (backup `claude/data/backups/portfolio-menu-items-before-2026-10-05.json`); footer Portfolio links to it; footer Careers removed until there is a page.
- **Verified:** HTTP 200, noindex, 1 H1, no PHP notices, `copy-check.py` 0 issues, phone width 390, parity 62 files 0 differences.
- **Waiting on Jamil:** real portfolio list (with screenshots and sourced results); client names and logos for `/clients/`; the Certificate of Incorporation file (to be public).

---

## D-123 · Privacy Policy v2: other countries' rules built in, consent on forms, fonts self-hosted
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "same way update privacy policy then e Portfolio, Clients, Careers, Certificate of Incorporation")

- **Rules read (not legal advice):**
  - Bangladesh Personal Data Protection Ordinance 2025 (gazetted 6 Nov 2025; 18-month window to comply): data belongs to the person, explicit consent, a notice when data is collected (purpose, retention, transfers, how to withdraw), access, correction and deletion rights (https://www.thedailystar.net/tech-startup/news/bangladeshs-personal-data-protection-ordinance-2025-key-takeaways-4015401 ; https://bd-scl.com/insights/personal-data-protection-ordinance-2025-compliance.html ; https://www.consentstack.io/regulations/bd-pdpo).
  - LG Munich, 20 Jan 2022: loading Google Fonts from Google's servers sends the visitor's IP to Google without a legal basis (https://www.activemind.legal/guides/ruling-google-fonts/). Beaver Builder documents the same fix: load fonts locally (https://docs.wpbeaverbuilder.com/beaver-builder/developer/how-to-tips/load-google-fonts-locally-gdpr).
  - EDPB Guidelines 05/2021: a person sending their own data to a company abroad is not a "transfer" (https://www.goodwinlaw.com/en/insights/blogs/2021/12/edpb-defines-a-transfer-under-the-gdpr), so the transfers section now says forms and email go directly to us, and providers use their own safeguards.
  - California (CCPA/CPRA): a Global Privacy Control browser signal must be treated as an opt-out (https://community.commandersact.com/consent-management/knowledge-base/ccpa-and-global-privacy-control).
- **Policy text v2** (`claude/drafts/privacy-policy-final-2026-10-05.html`; v1 kept as `privacy-policy-v1-2026-10-05.html`; page backup `claude/data/backups/privacy-page-3-before-2026-10-05.json`): fonts served from our own site; forms show the notice and ask for a tick before sending, and we record the consent; consent added as a legal basis for form replies; a "Depending on where you live" section (EU/EEA, UK, Bangladesh PDPO, US with GPC, everyone else); children under 18; 72-hour breach notice; transfers rewritten.
- **Forms** (`pages/reinforce-contact.php`, `saos/reinforce-diagnostic.php`): a required consent tick box; the notice says why, 24-month retention, Hostinger storage, never sold, how to withdraw or delete, with a Privacy Policy link; the server rejects a submission without the tick (`?sent=invalid`, tested) and stores `consent` (date and notice version) on the submission.
- **Fonts** (`core/reinforce-header.php`, `core/reinforce-fonts.css`, `core/fonts/*.woff2`, SIL Open Font License): the sandbox folder returns 403 for woff2, so the files are copied to `wp-content/uploads/reinforce-fonts/` and the `@font-face` rules are printed inline with preload for Oswald and IBM Plex Sans. Beaver Builder's Google Fonts stylesheet is blocked (`fl_builder_google_fonts_pre_enqueue`, `fl_enable_google_fonts_enqueue`, and a `style_loader_tag` filter, because the theme's Customizer font still came through), and Google font hints are removed. Customizer custom CSS (post 52) lost its first line, an `@import` of Google Fonts Oswald 300 to 700 (no 300 weight is used; backup `claude/data/backups/custom-css-post-52-before-2026-10-05.json`).
- **Verified:** Home, About, Privacy, Contact in Chromium: 0 requests to fonts.googleapis.com or fonts.gstatic.com, all woff2 200, Oswald on the H1, 8 faces loaded; curl on 8 more templates: 0 Google Fonts references; parity 61 files, 0 differences; `copy-check.py` 0 issues.
- **Launch items (on the QA gate):** the consent banner must honour GPC and offer a "Cookie settings" footer link before GA4 loads; GA4 retention set to 14 months; payment provider named in the policy.

---

## D-122 · FTC and Affiliate Disclosure; affiliate links labelled automatically
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "Semrush and WP Engine affiliate links. RJSC company registration number and VAT/BIN number as me later before ship to live")

- **Rules read (not legal advice):** FTC Endorsement Guides 2023: disclose clearly and next to the link, on the same page; a separate disclosure page alone is not enough (https://www.infolawgroup.com/insights/2023/7/31/ftc-releases-updated-endorsement-guides-10-key-takeaways). UK ASA/CAP: label affiliate content as "Ad"; "some links may earn us a commission" and "#aff" are not enough (https://www.asa.org.uk/static/790d2e01-e3f8-4fea-b3c99ef91a9f04dc/Influencerguidance2023v4-FINAL.pdf). Google: affiliate links need `rel="sponsored"` (https://developers.google.com/search/blog/2021/07/link-tagging-and-link-spam-update).
- **Page:** `/ftc-disclosure/` (production URL kept; Register: "declined by Google, rebuild or remove", now rebuilt). New page 224, legal template. Title "FTC and Affiliate Disclosure | Reinforce Lab"; meta 158. Content: the short version; relationships (Semrush affiliate programme and Agency Partners listing, Jamil a Semrush Ambassador; WP Engine affiliate programme and agency partner); how links are labelled; how we decide what to recommend; why we disclose; contact. Footer "FTC Disclosure" links to it.
- **Automatic labelling** (new `core/reinforce-affiliate.php`): in page and post content, links that match the Semrush or WP Engine affiliate formats (`semrush.sjv.io`, `semrush.com` with `ref`/`irclickid`-style parameters, `wpengine.com` with `w_agcid` or `partnerspecialoffer`, `wpengine.sjv.io`), or that an editor marks `rel="sponsored"` or class `aff`, get `rel="sponsored nofollow noopener"`, an "Ad" label next to the link, and a note at the top naming the partners and linking to the disclosure. Ordinary citation links to semrush.com or wpengine.com are untouched. Tested locally (7 URLs) and live.
- **Templates:** the List and Review post templates' vague "some links are affiliate links" wording replaced with a specific "Ad" note and link to the disclosure; their "Visit" buttons carry the "Ad" label when the post's affiliate switch is on.
- **Pending:** Jamil's real affiliate link formats (to confirm the patterns); RJSC registration number and VAT/BIN number before launch (now on the launch QA gate in `claude/migration-and-data-requirements.md`, with the other legal-page launch items).
- **`[CONFIRM]` wording:** "We recommend tools because we use them or have tested them for clients" and "We do not accept payment for reviews" are stated as policy; Jamil to confirm they are true.
- **Verified:** HTTP 200, 1 H1, no PHP notices, `copy-check.py` 0 issues, phone width 390; `#` links per page 15.

---

## D-121 · Terms & Conditions published on `.online`
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "Bangladesh law, cover website and store sales and Terms & Conditions"; then "USD, full payment up front, businesses only, rest okay" and "Read other countries rules and implement as well")

- **URL:** `/terms-conditions/` (production URL kept; URL Register: PRESERVE, Jamil to mark it). New page 223 on `.online`, author Jamil, legal-page template (D-120). Footer "Terms & Conditions" now links to it.
- **Production checked read-only (Exa):** the current terms are a generic template (mentions AARP and the American Automobile Association); the store sells service packages (e.g. SEO Enterprise-Yearly $407; WordPress Enterprise $8,597).
- **Content** (`claude/drafts/terms-conditions-final-2026-10-05.html`): website use, content and names, links, businesses only, packages, prices (USD, full payment up front) and tax by client country, contract start, onboarding within 2 business days, monthly auto-renewal (cancel by email) and yearly packages renewing only on confirmation after a 30-day notice, refunds (full within 14 days before work starts; pro-rata after; delivered work fixed not refunded; refunds within 7 days to the same method at our cost), client delays (30 days), no guaranteed results, signed agreements prevail, liability cap (12 months of fees) with death, personal injury and fraud carved out, Bangladesh law, BIAC arbitration in Dhaka with court relief for urgent matters.
- **Rules research:** Bangladesh (Consumer Rights Protection Act 2009, Digital Commerce Operation Guidelines 2021, VAT Act 2012, Arbitration Act 2001 and the New York Convention), US (New York GOL 5-903, ROSCA), UK (Unfair Contract Terms Act 1977), EU (VAT reverse charge, E-Commerce Directive art. 5). Sources and what each changed: `claude/drafts/terms-conditions-draft-2026-10-05.md`.
- **Pending from Jamil:** the RJSC company registration number and VAT/BIN number (EU E-Commerce Directive art. 5 asks for them on the site).
- **Not legal advice:** Claude is not a lawyer; a Bangladesh lawyer and an accountant should confirm the arbitration clause, the cap, and the VAT and US sales-tax points.
- **Verified:** HTTP 200, noindex, 1 H1, 19-item contents list, no PHP notices, `copy-check.py` 0 issues, phone width 390.

---

## D-120 · Privacy Policy published on `.online`
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "draft the privacy policy first one by one", then answers: Reinforce Lab Inc yes; Hostinger; 24 months okay; GA4 yes; the store moves here with a payment gateway to be chosen; review "me and you [as an advisor lawyar]")

- **URL:** `/privacy-policy/` (page 3, production URL kept; URL Register: PRESERVE). Published on `.online` only (noindex site). The old content (WordPress's default template, draft) saved in `claude/data/backups/privacy-page-3-before-2026-10-05.json`.
- **Template:** new `pages/reinforce-legal.php`, reusable for Terms and FTC Disclosure: the text stays editable in WordPress inside `[reinforce_legal updated="..." lede="..."] ... [/reinforce_legal]`; the file adds breadcrumb, hero (H1, lede, last updated), an automatic contents list from the H2s, and prose and table styles. Fixed during checks: the column and an inherited table `min-width: 760px` made the phone layout 776 px wide; now 390.
- **Content** (`claude/drafts/privacy-policy-final-2026-10-05.html`): built from what the site was checked to do (form fields, private records, email to hello@, hashed IP for one hour, no cookies today, Google Fonts and Jetpack Stats) plus Jamil's answers: Google Analytics only after consent (cookie table), Orders and payments for the store, Hostinger as host and mail provider, retention (24 months for enquiries, 14 months for analytics, tax rules for orders).
- **SEO:** title "Privacy Policy | Reinforce Lab"; meta 152 characters.
- **Review:** Claude is not a lawyer. The text was checked against GDPR Article 13, the UK and EU cookie rules and US state privacy basics; the checklist and open risks are in `claude/drafts/privacy-policy-draft-2026-10-05.md`. **Before launch:** cookie consent banner and "Cookie settings" footer link with GA4 behind consent; GA4 retention set to 14 months; payment provider named; Hostinger and Google data processing terms accepted. **For a lawyer:** EU or UK representative (Article 27), Bangladesh law, client agreements.
- **Effect:** the footer Privacy Policy item is now a link (D-119 wiring), and the Contact and Diagnostic "See our Privacy Policy" links now open the page instead of a 404.
- **Verified:** HTTP 200, noindex, 1 H1, contents list, 2 tables, no PHP notices, `copy-check.py` 0 issues, phone width 390, desktop and phone reviewed.

---

## D-119 · Footer: three placeholder links wired
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "Sitemap: point it at the sitemap. Get a Free Quote: point it at the Diagnostic page. Privacy Policy: point it at the privacy page ... First these 3")

- **Get a Free Quote** → `/search-authority-diagnostic/` (200). **Sitemap** → `/sitemap_index.xml` (200).
- **Privacy Policy:** page 3 is still a **draft** (a link would 404 for visitors) and holds WordPress's default template ("Suggested text: Our website address is: http://reinforcelab.online ..."). The footer now uses WordPress's privacy-page setting (`get_privacy_policy_url()`, page 3): plain text until the page is published, then a link automatically.
- **Found, not changed:** the Contact and Diagnostic form notes link to `get_permalink(3)` (`?page_id=3`), which visitors also get as a 404 while page 3 is a draft.
- `#` links on a page: 20 to 17. No PHP notices; `copy-check.py` 0 issues.

---

## D-118 · Titles and meta fixed; social profiles live
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "approve all, switch all 8 agents to the same pattern", with the LinkedIn, Instagram, Crunchbase and Facebook URLs)

- **Titles and meta (F-025 fix 5):** the approved draft (`claude/drafts/titles-meta-draft-2026-10-05.md`) applied to 26 pages as Yoast title and description: 8 titles shortened, 20 descriptions brought to 140 to 160 characters, and all 8 agent titles now "<Agent> AI Agent | Reinforce Lab" (incl. the 4 that were within 60: SEO Intelligence, Content Research, Social Sentiment, Content QA). Every old and new value saved in `claude/data/backups/titles-meta-before-after-2026-10-05.json`. Reference copies in the agent and industry files updated to match. Post dates not touched (F-003).
- **Re-audit:** 45 of 45 titles 60 or fewer characters, 45 of 45 descriptions 140 to 160, no duplicates.
- **Profiles:** Organization `sameAs` now 9: LinkedIn (company), Crunchbase, Facebook, Instagram (from Jamil) plus the 5 directory profiles. Awards page "Find us on" adds Crunchbase and LinkedIn.
- **Footer social icons:** Facebook, Instagram and LinkedIn now link to the real accounts (new tab, labelled "Reinforce Lab on ..."). X, Tumblr and Pinterest icons removed: no accounts given, and a `#` link is a dead end.
- **Still `#` (20 links, F-025 fix 4):** footer Portfolio, Clients, Careers, Get a Free Quote, Sitemap, Privacy Policy, Terms & Conditions, FTC Disclosure, Certificate of Incorporation, and the mega-menu group headings.
- **Verified:** no PHP notices; phone width 390; `copy-check.py` 0 issues; parity clean.

---

## D-117 · Entity fixes: site name, Organization profiles, llms.txt
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "yes, fix 1 to 3 and use the directory profiles")

- **Backup first:** the old `llms.txt`, site name and Yoast llms settings saved to `claude/data/backups/llms-txt-and-sitename-2026-10-05.json`.
- **1. Site name:** WordPress `blogname` "reinforcelab.online" changed to "Reinforce Lab". `og:site_name` and the WebSite schema now read "Reinforce Lab". No page title changed: all 45 pages have their own Yoast titles; only fallback templates (future posts, archives, 404) use the site name, and they now end in "Reinforce Lab". Tagline left empty (not asked).
- **2. Organization schema** (new `core/reinforce-entity.php`, loaded after the kit): `sameAs` with the 5 profiles verified in F-023 (Clutch, GoodFirms, DesignRush, HackerNoon, Semrush Agency Partners); `email`; two `contactPoint` entries (sales, Dhaka +880-1329-657096 for BD, Katy +1-832-548-4553 for US). LinkedIn, Crunchbase and social profiles to be added when Jamil sends the URLs.
- **3. llms.txt:** Yoast's generator switched off (`enable_llms_txt` false) and its static file removed (it had empty links and 5 pages). `/llms.txt` is now served by `rl_llms_txt()`, built from the live pages on each request: company summary, key facts (legal name and founding, founder, offices, contact, industries) and all 45 published pages with working links and their meta descriptions, grouped Company, Search Authority OS, Services, Industries, Optional (agents, blog). Plain text, `X-Robots-Tag: noindex`.
- **Verified:** `/llms.txt` 200, 45 links, no HTML entities, `copy-check.py` 0 issues; Organization on Home, Local SEO and About shows 5 `sameAs`, 2 `contactPoint`, email and legalName; titles unchanged; no PHP notices; parity clean.
- **At launch:** the llms.txt URLs follow the site URL automatically; `X-Robots-Tag: noindex` on it can stay.

---

## F-025 · SEO, AEO, GEO and LLM readiness audit (45 pages)
**Date:** 5 October 2026 · **Status:** FINDING (Jamil: "Check how much the all the pages created are ready for SEO, AEO, GEO, AI Searches, LLMs"); fixes need Jamil's go-ahead one at a time.

- **Method:** new `claude/tools/seo-audit.py` on the live HTML of all 45 published pages against the D-012 standard; site-wide files and Yoast settings; lab performance at phone size on 6 pages (PageSpeed API quota exhausted; sandbox network makes load times unreliable). Report: `claude/research/seo-aeo-geo-readiness-2026-10-05.md`.
- **Ready:** one H1 and clean heading order on 45 of 45; answer-first openings 45 of 45; FAQs with matching FAQPage schema on all 44 commercial pages; required schema per template on 45 of 45; question-shaped H2s on 41; text server-rendered; copy rules 0 issues; pages light (108 to 158 KB, 17 to 18 requests).
- **Gaps:** `llms.txt` broken (Yoast auto mode, empty links, 5 pages); WordPress site title is "reinforcelab.online"; Organization has no `sameAs` or `contactPoint`; no `og:image`; 26 `#` placeholder links in header and footer; 18 meta descriptions over 160 and 8 titles over 60 characters; 18 pages cite no outside source; agent pages, Packages and Audit do not name Reinforce Lab near the top; `dateModified` on 4 of 45; Home lab CLS 0.154 from the late web font; emoji, jQuery and Bootstrap scripts on every page; no AI-crawler policy in robots (launch decision); 0 blog posts.
- **Canonical:** none output while noindex (Yoast behaviour); verify at launch.

---

## D-116 · Phone versions of every hero diagram
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "apply all"; asked to confirm, chose "Phone versions on all heroes")

- **Measured first** (390 px phone): diagram labels on Home, the Services and Agents hubs, all 18 service pages and the industry template rendered at about 5 to 8 px; Search Authority OS and Packages at about 8 to 9 px. The 8 agent pages were already fixed (D-115).
- **Built:** `core/reinforce-phone-hero.php` (new, loaded after the kit) with `rl_ph($groups, $foot)`: the diagram's own content as real HTML text in boxes (12.5 px labels), with red highlights, ticks, step arrows, a core box, down arrows between groups, and the same 10 s step-by-step reveal (paused off-screen; static for reduced motion via `.rl-anim`). It sits inside each hero figure; at 560 px and below the figure's SVG is hidden and the phone version shows; above 560 px it is hidden, so desktop is unchanged.
- **Applied to 25 pages:** Home, Search Authority OS, Packages, Services hub, Agents hub, the 18 service pages, the Industries hub and the industry template (8 pages, filled from each industry's own context and guardrails). Each uses the labels of its own desktop drawing.
- **Verified:** every page has exactly one phone version and no PHP notices; at 390 px the SVG is hidden, labels are 12.5 px, and page width is 390; desktop hero audit unchanged (42 within the standard, Diagnostic and Contact by design); phone screenshots reviewed and fixed (Search Authority OS and Packages laid out in a row, labels repeating the panel caption, and arrows left behind when a step row wrapped). `copy-check.py` 0 issues.

---

## D-115 · One hero visual per agent page
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "for all the individual agents all of the hero images look similar that's should not be like that .. if required build one by one")

- **Before:** all 8 agent pages drew the same diagram (three inputs, the agent, a human review gate, three outputs) with only the labels changed.
- **Now:** new file `saos/reinforce-agent-visuals.php` (loaded before `saos/reinforce-agent-pages.php`) draws a different picture of each agent's own job, in the same panel, size and 10 s loop:
  - **A-01 SEO Intelligence:** value against difficulty map; the quick-win corner feeds a ranked page plan (P1 to P5).
  - **A-02 Content Research:** what the top four pages cover by subtopic; uncovered rows become gaps and H2s in a research brief with sources.
  - **A-03 Evidence Verification:** claims highlighted in a draft, matched in a claim ledger (source, confidence, status); the unsourced claim goes to a person.
  - **A-04 AEO / GEO Optimization:** page blocks made answer-ready (five checks), tracked in ChatGPT, Perplexity, Gemini and AI Overviews as mentioned, cited and described accurately.
  - **A-05 Social Sentiment:** forum, review and social comments grouped into an objection, a confusion and a question, then FAQ topics, new angles and copy in customers' words; tone bar.
  - **A-06 Competitor Intelligence:** topic-coverage radar of rivals against you with the gaps marked, rival alerts, and target pages.
  - **A-07 Content QA:** SEO, AEO and GEO, and evidence check lanes; one failed check goes to the fix list; approved by a person, with an audit trail.
  - **A-08 Search Performance:** clicks line with a detected drop, five causes checked, the root cause found, a recovery line and plan.
- **Rules kept:** illustrative only (no numbers, no client data); each SVG has its own title describing it; the panel cap names the agent and the visual; every visual ends with "REVIEWED BY A PERSON". Reduced motion shows the complete drawing with all highlights on.
- **Removed:** the shared diagram code and its keyframes from `reinforce-agent-pages.php`.
- **Phone versions** (Jamil: "yes, make phone versions with larger labels"): each agent also has a simpler phone drawing (`rl_agv_*_m()`, viewBox 320 by 392) with fewer labels at 11 px (about 11 to 12 px on screen, was about 6 px), laid out top to bottom. Shown at 560 px and below; the desktop drawing is hidden there, and the phone drawing is hidden above it. Checked on all 8 pages at 390 px; desktop unchanged (hero edges as before).
- **Verified:** all 8 SVGs parse as XML; rendered side by side (static and lit) and fixed overlaps in A-03, A-04, A-06 and A-08 before deploying; live on all 8 pages with no PHP notices; panel edges within the hero standard (F-024); phone width 390 on all 8; `copy-check.py` 0 issues.

---

## D-114 · Heroes brought to one standard (F-024 fixes)
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "use capitals", after the F-024 audit)

- **Rule now on every page:** eyebrow, H1 in capitals, lede, buttons on the left; one panel on the right whose top and bottom line up with the text column. Padding 80 px; grid 1.02/0.98.
- **Search Authority OS** (`saos/reinforce-saos.php`): dropped the full-screen-height hero; kit padding, grid, H1 margin and 19 px lede; the loop panel stretches to the text column with the loop centred. Removed the second line under the buttons ("Search Intelligence + Evidence + Content + AI Search + Continuous Optimization"), which repeated the loop.
- **Home** (`pages/reinforce-home.php`): H1 now in capitals (was the only sentence-case H1), 52 px so the locked core message fits 4 lines; kit padding and grid; the engine panel stretches to the text column. Wording unchanged.
- **Awards** (`pages/reinforce-awards.php`): the four-number tally moved from its own band into the hero panel above the listing rules; the panel stretches to the text column. The separate tally band is gone.
- **Search Authority Diagnostic:** H1 58 to 64 px; kit padding and grid; text starts level with the top of the form.
- **Packages:** H1 60 to 64 px; padding 72 to 80 px; kit grid; chart panel stretches to the text column.
- **Agents hub:** pipeline diagram capped at 390 px tall on desktop so the panel matches the text column (was 41 px off at each end).
- **Verified:** `hero-audit.mjs` on all 45 pages: 42 within the standard; Blog, Diagnostic and Contact are exceptions by design. Panel edges 0 px from the text on the six fixed pages at 1440 and 1900 px. Phone width 390 on each; no PHP notices; `copy-check.py` 0 issues.
- **Home "Built for" line** (Jamil: "yes, add both"): now lists all 8 industries in the D-022 order, adding E-commerce and Education. Hero still level at 1440 and 1900 px; phone width 390.

---

## F-024 · Hero audit: 36 of 45 heroes match; Search Authority OS, Home and Awards do not
**Date:** 5 October 2026 · **Status:** FINDING (Jamil: "Audit entire website for the hero sections"); fixes need Jamil's go-ahead.

- **Method:** `claude/tools/hero-audit.mjs` on all 45 published pages at 1440 px, and 10 pages at 1900 px; hero screenshots reviewed. Full report: `claude/research/hero-audit-2026-10-05.md`.
- **Standard (36 pages):** kit hero, 80 px padding, H1 64 px uppercase on 3 lines, 19 px lede, visual panel about 620 by 505 px with edges within 25 px of the text column.
- **Out of line:** Search Authority OS (older hero; panel 434 px against 576 px of text, 71 px gaps; 4-line H1); Home (same older hero; the only sentence-case H1; 88 px gaps); Awards (193 px rules panel against 456 px of text); Diagnostic (H1 58 px; the form is 85 px taller at each end); Packages (H1 60 px); Agents hub (41 px gaps); Contact (form 113 px longer at the bottom).
- **Recommendation:** one hero rule for every page; move Search Authority OS and Home onto the kit hero with panels stretched to the text height; Jamil to decide the Home H1 case (the locked core message is 5 lines in uppercase at 64 px).

---

## D-113 · About page: Our story and Milestones aligned
**Date:** 5 October 2026 · **Status:** DONE (Jamil, marked-up screenshot: "either separate it with section or make it aligned in terms of position and design")

- **Chosen:** aligned, not split. The eyebrow and H2 moved into the left column, so both columns start on the same line. Milestones became a framed panel (same style as the hero's "At a glance" box), and the columns stretch to equal height.
- **Bottom edge:** a three-step strip pinned to the foot of the text column (2020 Tallinn, where we started; 2021 Dhaka, Reinforce Lab Limited; Today Dhaka and Katy, two offices), so the text column ends level with the panel. Story text 17px. On phones the strip stacks and the panel follows the text.
- **Verified:** section screenshots at 1440 and 390; `copy-check.py` 0 issues; no PHP notices.

---

## D-112 · About page: "no client logos" section removed
**Date:** 5 October 2026 · **Status:** DONE (Jamil, with a screenshot of the section: "remove this")

- Removed the "Straight answer" block ("Why are there no client logos or results on this page?") from `pages/reinforce-about.php`. The page now has 10 H2s; no PHP notices; deployed and verified live.
- The "Evidence before claims" principle and the sourced Recognition cards stay.

---

## D-111 · Founder profile on About rebuilt (verified career facts)
**Date:** 5 October 2026 · **Status:** DONE on `.online` (Jamil: "this is pathetically POOR profile of mine"). **APPROVED 5 Oct:** "keep both sentences, keep all career details i will add image later". Headshot to follow (Jamil adds it); the 2018 "CEO at Reinforce Lab" question is still open.

- **Source:** "Interview with Jamil Ahmed", Onalytica, 7 Sep 2018 (re-read via Exa, 5 Oct): B.Pharm, East West University; international business at an oncology pharmaceutical company in Bangladesh from 2012, country manager for Sri Lanka, Latin America (Puerto Rico, Cuba) and West Africa (Ghana, Kenya, Mauritania); registered and marketed 16+ oncology and 5 general medicine brands in Sri Lanka; ciprofloxacin (Xbac) onto Ghana's Essential Medicines List via the Ghana National Drugs Program; Executive International Marketing, Square Group (2016); Product Manager, Immunology, Janssen Pharmaceutical Companies of Johnson & Johnson (2017). The interview's "No. 1" descriptions of his employers are not repeated.
- **Section now:** profile card (credentials list: education, pharma career, markets, today; LinkedIn and interview buttons; photo slot), a four-paragraph bio "From pharmaceutical marketing to AI Growth Systems", the LinkedIn headline quote, and an 8-step career path (2012 to Today).
- **Photo:** none exists on `.online` (media library and user 3 checked). The card shows a headshot as soon as the option `rl_about_founder_photo` holds its URL; the Person schema then gains `image`.
- **Schema:** Person gains `alumniOf` (East West University), `subjectOf` (the Onalytica interview) and "Pharmaceutical marketing" in `knowsAbout`.
- **Wording that is ours, not a source's (INFERENCE):** "his whole career has been about one job: putting the right product in front of the right people, with claims that stand up" and "Regulated marketing taught him that every claim needs evidence".
- **Open:** the interview (2018) already calls Jamil "CEO at Reinforce Lab", two years before the Tallinn start (D-109).
- **Verified:** no PHP notices; Person schema as above; `copy-check.py` 0 issues; desktop and phone section screenshots reviewed.

---

## D-110 · About page rebuilt to the v2 company-led copy
**Date:** 5 October 2026 · **Status:** DONE (Jamil: "dates are right, no Estonia office, keep all, build it")

- **Decisions in Jamil's answer:** the dates stand (started in Tallinn 2020; Reinforce Lab Limited founded in Bangladesh 1 April 2021); no Estonian office, so Tallinn appears only as the starting point; all `[CONFIRM]` lines kept (reason for the shift, "built our team in Dhaka", the pharmacist link to evidence checking, "Measured on business results"); the new H1 is used ("keep all").
- **File:** `pages/reinforce-about.php` v2.0, same URL `/about-us/` (APPROVED, PRESERVE), same shortcode. Sections: hero with facts panel; Our story with milestones (2020, 2021, 2024, 2025, 2026, Today); What we build (3 jobs, 4 service groups, Search Authority OS, links); Who we work with (3 situations, 8 industry links, regulated fields); How we work (4 engagement steps, the 9-stage method); 6 principles; Leadership; Recognition (5 sourced cards plus a link to `/awards/`); Offices; Straight answer; 7 FAQs; CTA. No team, culture or careers section; team and client proof wait for Jamil.
- **Copy:** exactly the v2 draft (`claude/drafts/about-page-content-2026-10-05.md`), except the facts-panel label "Reinforce Lab Limited" became "Founded" (value "1 April 2021, Bangladesh (Reinforce Lab Limited)") because the long label squeezed the phone layout.
- **Yoast meta description** (page 218): "Reinforce Lab began in Tallinn, Estonia in 2020 and expanded to Bangladesh in 2021. We build AI Growth Systems: search, content and automation as one." (150). Was: "Reinforce Lab builds AI Growth Systems that connect your website, content and search visibility. Founded by pharmacist and Semrush Ambassador Jamil Ahmed." Title unchanged.
- **Schema:** AboutPage; Organization gains `areaServed` Worldwide, `knowsAbout` (9 services) and `award` (the same 4 entries as `/awards/`, now from the shared `rl_awards_schema_list()` in `pages/reinforce-awards.php`), keeps `founder`, `foundingDate` 2021-04-01, `foundingLocation` Bangladesh; Person (Jamil); FAQPage (7).
- **Verified:** HTTP 200; `noindex, nofollow`; 1 H1, 11 H2; no `href="#"` in the content; no PHP notices; schema as above; `/awards/` schema unchanged; `copy-check.py` 0 issues on the file and the live page; phone width 390 with no horizontal scroll; section screenshots at 1440 and 390 reviewed (fixed: H3 subheadings rendered grey and letter-spaced; phone facts panel label column).
- **Tooling:** `shot.mjs sections <path> <prefix> [css]` saves one JPEG per section for review.

---

## D-109 · Origin story from Jamil; About page draft v2
**Date:** 5 October 2026 · **Status:** RECORDED (fact from Jamil); About copy DRAFT v2 in review, nothing built.

- **Jamil's words:** "We started as a full service digital marketing agency from Tallin, Estonia, 2020, and then we expanded to Bangladesh in 2021. Now we shifted to scale businesses with automation and reduce repetitive work."
- **What it settles (F-023):** the 2020 dates (Clutch, the old production About page) and the "began as a European startup" line in the press release and on DesignRush describe the Tallinn start. 1 April 2021 (D-108) is read as the date of Reinforce Lab Limited in Bangladesh. `[CONFIRM]` with Jamil before the build; D-108 values on `.online` are unchanged.
- **Still unexplained:** the 2018 Onalytica interview calls Jamil "CEO at Reinforce Lab", two years before the Tallinn start.
- **About draft v2** (`claude/drafts/about-page-content-2026-10-05.md`): the origin story and a milestone timeline (2020 Tallinn, 2021 Bangladesh, then the D-106 awards), services cut to a short summary with links, no culture or careers section (Jamil: "remove"), team and client proof left as `[LATER]` slots.
- **Context Jamil sent:** a Google AI Overview for "reinforce lab limited history" says "Founded around 2020 to 2021" and cites Facebook, LinkedIn, Crunchbase and HackerNoon, not the website. INFERENCE: one plain FAQ answer on About ("When and where did Reinforce Lab start?") gives AI answers a first-party source to cite.

---

## D-108 · Founding date is 1 April 2021 everywhere
**Date:** 5 October 2026 · **Status:** DONE (Jamil: "1 April 2021 everywhere"). Replaces D-069 (2020).

- **Why:** public sources disagree (2018, 2020, 2021, 2022; F-023). Crunchbase shows "Founded Apr 1, 2021"; Jamil chose that date for every place the site states it.
- **Changed on `.online` (all of them, after a full search of the theme code and the database for 2020):**
  - `pages/reinforce-about.php`: FAQ "When did Reinforce Lab start?" now reads "Reinforce Lab was founded in Bangladesh on 1 April 2021 and now works with businesses internationally."; "At a glance" Started: "1 April 2021, Bangladesh"; Organization `foundingDate` "2021-04-01" (was "2020"); header comment.
  - Jamil's author bio (user 3 `description`): "He founded Reinforce Lab in 2021 and leads it as CEO." (was 2020; the rest is Jamil's wording, unchanged).
  - Yoast `wpseo_titles` `org-founding-date`: "2021-04-01" (was empty), so the site-wide Organization node carries `foundingDate` on every page, not only About.
- **Verified:** About shows the new FAQ and Started line, no "2020" left in its HTML; `foundingDate":"2021-04-01"` in the schema on `/about-us/` and on `/`; the bio reads back from the database (no published post yet shows an author box). `copy-check.py` 0 issues on the file; `rl.py parity` 47 files, 0 differences; snapshot refreshed.
- **Not changed:** `reinforcelab.com` (production About still says 2020; changing it needs a separate approval under rule 2). Third-party profiles are Jamil's to update: Clutch says "Founded in 2020"; DesignRush and the Onalytica interview point to 2018.

---

## D-107 · `/awards/` linked from the footer only
**Date:** 5 October 2026 · **Status:** DONE (Jamil: "it will be in the footer only for now")

- **Change:** one link, "Awards", added to the footer's Company column after "About Us" in `core/reinforce-header.php` (`rl_render_footer()`), using `rl_url_by_path('awards')` like the other links. The footer is on every page, so `/awards/` now has a site-wide internal link.
- **Not changed:** the main menu and the About page. Jamil may revisit this later ("for now").
- **Verified:** the link renders on `/`, `/about-us/` and `/awards/` and points to `https://reinforcelab.online/awards/` (HTTP 200); `rl.py parity` 47 files, 0 differences.
- **Still open from D-106:** the WP Engine and Crunchbase links; `/awards/` in the URL Decision Register.

---

## D-106 · Awards page built on `.online` at `/awards/` (page 221)
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "use /awards/, drop the amber items, build it"; CEO Monthly: "eliminate")

- **URL:** `/awards/`, a new top-level page. **APPROVED: NEW URL** by Jamil (rule 2). Not a production URL; nothing changes on `reinforcelab.com`. Breadcrumb Home › About › Awards.
- **Created:** one guarded call (aborted if `blog_public` ≠ 0, if a page existed at `awards`, or if the shortcode was missing). Title "Awards", content `[reinforce_awards]`, author Jamil.
- **Yoast:** title "Awards and Recognition | Reinforce Lab"; meta "Reinforce Lab won HackerNoon Startups of The Year 2024 in Dhaka and DesignRush's June 2025 list. Every award links to the page that confirms it." (144 characters).
- **File:** new `wp/novamira-sandbox/pages/reinforce-awards.php` (added to the loader after About). Shared kit (D-044); no hero animation (company page, like About, D-039).
- **Content: only VERIFIED items from F-023, each with a source link.**
  - **Featured award:** HackerNoon Startups of The Year 2024, winner in Dhaka.
  - **Cards:** DesignRush Best Digital Marketing Agencies of June 2025; HackerNoon 11th in Marketing worldwide; HackerNoon honourable mentions in Creative Agency and Media Production; GoodFirms 8th of 442 SEO agencies and 8th of 166 digital marketing companies in Bangladesh (dated October 2026); HackerNoon Startups of the Week.
  - **Partners:** Semrush Agency Partner. **WP Engine Agency Partner** is confirmed but appears only when the option `rl_awards_wpengine_url` holds Jamil's partner page link (not yet supplied), so every card links to a source.
  - **Reviews:** Google 4.6 from 8 reviews; directory profiles (Clutch, GoodFirms, DesignRush, HackerNoon).
  - **Press:** Tech Cloud Ltd and Notionhive lists (labelled "Mention by another agency"), our EIN Presswire release (labelled "Our press release"), Onalytica interview; a note on why "As seen on" outlet logos are not shown.
  - Timeline by year, 4 FAQs, 8 sources, CTA to the diagnostic and About.
- **Dropped, as Jamil decided:** FindBestFirms, GoodFirms Branding, DesignRush Content Marketing (no list found), CEO Monthly (vanity award, F-023). The Semrush Ambassador card was also left out (no Semrush page names Jamil); the title stays in his bio.
- **Schema:** Yoast WebPage `about` the Organization; the Organization node gets `award` with the four confirmed awards and honours; `FAQPage` (4).
- **Verified:** HTTP 200; `noindex, nofollow`; 1 H1, 8 H2; no `href="#"` inside the page content; schema as above; no PHP notices; `copy-check.py` 0 issues on the file and the live page; desktop 1440 and phone 390 with no horizontal scroll. Sandbox network retries sometimes dropped jQuery, the logo or the kit CSS during screenshots (the same on About); direct requests return 200, and clean runs show no script errors. `rl.py parity` 47 files, 0 differences; snapshot and site map refreshed (50 pages).
- **Fixed during the build:** the "See it on HackerNoon" button stretched across the feature card.
- **Not done (needs Jamil):** where the page is linked from (decided in D-107: footer only); the WP Engine and Crunchbase links; the URL Decision Register (xlsx) still needs the new URL added.

---

## D-105 · Separate Awards page: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** APPROVED, built as D-106 (Jamil: "i want to build a separate Awards Page keeping a separate about page"; then "use /awards/, drop the amber items, build it").

**Mockup:** `claude/design-previews/awards-page-mockup.html`, published privately (claude.ai artifact "Awards Page Mockup"). Content comes only from F-023.

**Design: an evidence page.** Title "Recognition you can check for yourself", with the listing rules beside it (each item links to the awarding body's own page; how it was decided; our own press releases marked as ours; no awards sold with a publicity package). A tally that counts confirmed items only (1 award, 1 partner listing, Google 4.6 from 8 reviews, first founder interview 2018). The HackerNoon Dhaka 2024 win as a feature card (drawn seal, year, announced date, decided by public vote, "Confirmed at source", link). Other awards, partnerships, reviews, interviews and press releases, a timeline by year, a CTA to About, FAQs and sources. Items that still need proof (HackerNoon #11 in Marketing, GoodFirms, FindBestFirms, Semrush Ambassador page, WP Engine) show as dashed amber cards in the mockup only; none go live without a source link.

**Why this differs from the production homepage:** the production "As seen on" strip shows news logos that come from wire syndication of our own October 2024 press release, and the "5+ Global Recognition" and "80+ Featured in" counters cannot be backed by sources (F-023). The mockup lists the release as ours and explains why outlet logos are not shown. Production is untouched.

**v1 update, same day:** Jamil sent proof for two items (F-023 section 7). GoodFirms is now a confirmed card, "Ranked 8th, Top Digital Marketing Companies in Bangladesh" (166 firms, October 2026, dated because the ranking changes monthly), replacing the unproven "Top SEO and Branding Company" card. WP Engine Agency Partner is now confirmed (no tier stated). The tally now reads 1 award, 2 agency partnerships, Google 4.6, GoodFirms 8th. Then a third proof: **8th of 442 in GoodFirms "Top SEO Agencies in Bangladesh"** (updated 4 Oct 2026), added as its own card ahead of the digital marketing ranking and used in the tally. Then the production badge strip: **DesignRush Best Digital Marketing Agencies of June 2025 (7th of 31) VERIFIED** and added; FindBestFirms, GoodFirms Branding and DesignRush Content Marketing badges stay amber (no list found); GoodFirms Research Partner is a sign-up programme, not an award (F-023 section 7). Then **Notionhive "Top 20 SEO Companies in Bangladesh (2026)", 20th: VERIFIED**, added as a mention (Notionhive is itself an agency that ranks itself 1st) with its quote, in the press section and timeline. Then **Tech Cloud Ltd "Best SEO Service Company in Bangladesh: 25 Agencies Reviewed" (Jul 2026), 25th: VERIFIED**, added the same way. Then **HackerNoon 2024 honourable mentions in Creative Agency (Business) and Media Production (Media): VERIFIED**, added as a card and to the timeline; "#11 in Marketing" was then **VERIFIED** from Jamil's screenshot of HackerNoon's own Marketing leaderboard (11th of about 8,000) and moved to a confirmed card.

**Open for Jamil:** the slug (`/awards/` or `/about-us/awards/`), the exact WP Engine partner page URL, proof links for the remaining amber items (HackerNoon #11, FindBestFirms, Semrush Ambassador), and whether the "no awards sold with a publicity package" rule stays (it excludes the CEO Monthly award, F-023).
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll and no script errors. Drawn seal, no third-party logos (none supplied).

---

## F-023 · Reputation and recognition: what can be shown, and what public sources disagree on
**Date:** 4 October 2026 · **Status:** `[VERIFIED where marked; rest SELF-REPORTED]` (Jamil: "research about reinforce lab it's reputation awards with claude and exai as well")

Full brief with every source: `claude/research/reputation-and-recognition-2026-10-04.md`. Web search plus Exa.

- **VERIFIED, safe to show with a link:** HackerNoon Startups of The Year 2024, **winner in Dhaka, Bangladesh** (HackerNoon's own Asia winners page); a HackerNoon "Startups of the Week" feature (Nov 2025); Semrush Agency Partner listing; Onalytica interview with Jamil (2018), which also documents his pharma career (oncology international business from 2012, Square Group, Janssen) and B.Pharm from East West University.
- **VERIFIED but not recommended:** CEO Monthly "Most Impactful Branding & Marketing CEO of the Year 2024 (Bangladesh)". CEO Monthly belongs to AI Global Media, described on Wikipedia as an organiser of vanity awards (ASA ruling 2018).
- **SELF-REPORTED only:** HackerNoon "#11 in Marketing globally", GoodFirms top SEO and Branding, FindBestFirms best WordPress agency, WP Engine partner, "first Bangladeshi Semrush certified agency", Fit Small Business / SaleHoo / Onalytica influencer lists, 160+ clients, 12.98 million BDT raised, INPACE acquisition (April 2021) and European origin.
- **Reviews:** Google 4.6 from 8 reviews (2021); Clutch and GoodFirms profiles have **no reviews**. No complaints or negative coverage found.
- **Public facts disagree:** founding year (2018, 2020, 2021, 2022 across sources), size (2 to 9 up to 11 to 50), US office (Katy, Houston, a "Texas, Georgia" error, a Las Vegas address on GoodFirms), Dhaka suite (1402 vs 601), origin story. **Jamil to settle these before the About page uses them.** Directory profiles are Jamil's accounts, not production pages; nothing was changed anywhere.

---

## D-104 · Founder bio for the author box: Jamil's own wording, applied on `.online`
**Date:** 4 October 2026 · **Status:** DONE (Jamil supplied the text: "Like this now modify this", then "Write it properly"; D-084 item 1)

**The bio (Jamil's wording, two fixes only):**
> Jamil Ahmed is an SEO and AI search consultant, a pharmacist and a Semrush Ambassador. He founded Reinforce Lab in 2020 and leads it as CEO. Jamil builds AI Growth Systems for companies: he connects their website, content and search visibility with AI automation, so they are found on Google and in AI answers and turn that attention into revenue.

**Revised the same day** (Jamil: "Write it properly"): the roles are now in one opening sentence, "runs it" became "leads it", and the last sentence says what Jamil does for companies. The first applied version (Jamil's wording with two fixes) is replaced and kept here for the record: "Jamil Ahmed is an SEO and AI search consultant. He founded Reinforce Lab in 2020 and runs it as CEO. Jamil is a pharmacist and a Semrush Ambassador. He builds AI Growth Systems for companies: website, content and search visibility connected by AI automation, so the business is found on Google and in AI answers and turns that attention into revenue." Copy check 0 issues. Pronoun "he" is Jamil's own.

**Where it lives:** the WordPress user profile of `jamilahmed` (user 3), field "Biographical Info" (`description`), on `.online` only. It was empty before (recorded), so every author box showed the built-in default text; the author box in every post design reads this field first. **VERIFIED:** an in-memory post render shows the new bio in the author box. **INFERENCE, not yet verifiable:** Yoast also uses this field as the Person `description` on posts; there are no published posts by Jamil on `.online` to check it on.

**Not changed (for Jamil to decide):** the About page founder section and its Person schema line still use the earlier wording ("Founder and CEO of Reinforce Lab. Pharmacist, SEO and AI search consultant, and Semrush Ambassador."), and the longer About draft in `claude/drafts/founder-bio-2026-10-04.md` is unused. Production is untouched.

---

## D-103 · Product / Service template built on `.online`: all blog templates done
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Product / Service template")

**Files:** new `blog/reinforce-post-product.php` (added to the loader); `blog/reinforce-post.php` hands Product / Service posts to `rl_product_render()`. The Product fields, boxes and schema moved out of `blog/reinforce-post-types.php`, which now holds only the shared lists (services, industries, subtypes) and small helpers. No Product posts existed on `.online` (checked first), so no data was affected. Keys `rl_p_subtype`, `rl_p_service`, `rl_p_limits` and `rl_p_changelog` are kept; the status label is still the base field `rl_status`.

**Subtype label:** Jamil approved the mockup without naming another label, so the first subtype stays **"How it works"** (internal key `deepdive`). The chip shows "How it works", "Use case" or "Launch".

**How an editor writes a Product / Service post:**
- **Spec plate:** service or product (links the plate, the CTA and the schema), code (optional), name shown (defaults to the service name), one-line promise, what it is, part of (linked), best for, version. The disclosure always shows: "We make this. This article is about our own product" (or "service" for services).
- **Status guard (D-074, O-022):** a post about an agent or Search Authority OS without a status label is put back to draft on save, and any preview shows an amber banner. Badges: In development (amber), Early access (blue), Available (green).
- **How it works:** problems (`Problem | Sentence`, up to 3), steps (`Step | What happens | What comes out`, up to 5; `*` marks where a person decides), what goes in and out, an example (`Label | Text`; `>` shows the text as a quote).
- **Use case:** the situation, what you need, the playbook (`Step | What to do | Who | When`), signs it is working.
- **Launch:** version, release date, headline, items (`new`, `changed` or `fixed` | Text), what changes for current users.
- **For every subtype:** the body after the middle section, changelog (`YYYY-MM-DD | Change`, newest first), it does / it does not, honest note (`Lead | More`), fit, CTA to the product page, related articles (same product first, then other Product posts).

**Schema:** the article is `about` the Service (`…/#service`, provider the Organization). Any Review, AggregateRating, Product or Offer node, or review, rating or offer property on the article, is removed for these posts (D-076). Verified in memory.

**Checks:** in-memory previews of all three subtypes and of a post with no status label (nothing saved, F-003): no PHP notices; `copy-check.py` 0 issues on the file and the rendered pages; desktop 1440 and phone 390 with no horizontal scroll and no script errors; Case Study and Research previews re-run after the post-types file was trimmed, no notices; `rl.py parity` 46 files, 0 differences.
**Fixed during the build:** a code comment placed mid-line cut off two data keys (caught by the notice check before any post used it); the link in the plate now uses an underline, as a border was overridden.

**All blog templates are now built** (D-077): Guide, How-To, Best / List, Review, Comparison, Explainer, Industry, Updates, Case Study, Research and Product / Service. Opinion and Checklist use the base single-post design, as agreed. Next, as agreed in D-084: the founder bio choice, the merge into `main`, and the reminder to `git pull` before the daily sync.

---

## D-102 · Product / Service template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** APPROVED, built as D-103 (Jamil: "approved, build the Product / Service template"; D-077 process)

**Mockup:** `claude/design-previews/blog-product-template-mockup.html`, published privately (claude.ai artifact "Product Service Template Mockup"). Sample product: the Evidence Verification Agent (A-03), using the wording already on its agent page. Titles, versions, dates, the worked example and the playbook are sample content, tagged on the page. **Status shown as "In development"** (and "Early access" in the Launch view) because O-022 is still open; no claim that the agent is live.

**Design: a product sheet**, different from the ten built templates. A switcher at the top (mockup only) shows the three subtypes; in the build the subtype field picks the layout.
- **Shared header:** two chips (subtype + category), title with its point in red, standfirst, byline.
- **Spec plate** beside the title: the **"We make this. This article is about our own product."** disclosure at the top, product code and name with its one-line promise, **status badge** (In development, Early access or Available), what it is, part of (links to Search Authority OS), best for, version (Launch only), and two buttons: the product page and the free diagnostic.
- **How it works:** the problem in three cards, a **four-step flow** (each step with its output, and the step where **a person decides** marked in green), what goes in and what comes out, and **one worked example** taken from start to finish.
- **Use case:** the situation, **what you need** before you start, a **playbook** of numbered steps with who does it and when, and **signs it is working** (no invented numbers).
- **Launch:** a **release card** (version, date, items tagged New, Changed, Fixed), what changes for people already using it, and the **changelog** as a timeline.
- **Shared after the middle:** **what it does and does not do** side by side with an honest note, **who it is for and not for**, the light in-article CTA, related articles about the same product, FAQs, sources, author box.

**Rules carried over (D-076):** the disclosure always shows; a status label is required on agent and Search Authority OS posts until O-022 is settled; "What it does not do" is required; the post must target a different search than its product page; schema is Article `about` the Service, **never Review, ratings, Product or Offer markup**.
**Open item carried over:** the first subtype (internal key `deepdive`) is labelled "How it works", because the name first approved is on the banned word list (D-076); the mockup uses "How it works".
**Checks:** `copy-check.py` 0 issues; all three subtypes at desktop 1440 and phone 390 with no horizontal scroll and no script errors. Fixed before publishing: the subtype switcher showed both status badges at once (a CSS rule lost to a more specific one).

---

## D-101 · Research template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Research template")

**Files:** new `blog/reinforce-post-research.php` (added to the loader); `blog/reinforce-post.php` hands Research posts to `rl_research_render()`; the old Research fields, boxes and schema moved out of `blog/reinforce-post-types.php` (no Research posts existed on `.online`, checked first, so no data was affected). Keys `rl_rs_findings`, `rl_rs_method`, `rl_rs_sample` and `rl_rs_dataset` are kept. Only Product / Service still uses the shared boxes.

**The two open choices from D-100 are optional fields, not fixed wording:** the report number and the licence line show only when filled in, so Jamil decides per study. Neither is filled in on any post.

**How an editor writes a Research post:**
- **Study card:** report number (optional), sample and its detail, data collected (plus the same dates as `YYYY-MM-DD/YYYY-MM-DD` for the Dataset markup), markets, method in one line, checked by. "Get the data" shows only when a dataset URL is set.
- **Headline finding:** `Number | Sentence | Sample size`.
- **Key findings:** up to 5, `Number | Finding | Detail | Figure number`. Each gets its own anchor (`#finding-1`) and a button that copies a link to it. A line without `|` shows as a finding with no number.
- **Figures:** up to 4 (repeater): title, takeaway, chart (horizontal bars or columns), data `Label | Number`, suffix (e.g. %), tooltip text, sample and source. Drawn in the browser as one red series, with tooltip, "Show as a table", download and link. A % chart runs 0 to 100.
- **What we found:** an intro before the figures; the article body follows them.
- **How we ran the study:** at a glance (sample, period, sources, analysis), up to 4 steps, definitions, limits.
- **What this means for you** (up to 3 readers), **CTA**, **data and citation** (file card, licence, Plain / APA / Link citation with copy), **version history** (`YYYY-MM-DD | Version | What changed`, `!` marks a correction; newest first; the newest version shows in the card and the citation).
- Related studies: the three newest other Research posts, shown only when they exist.

**Schema:** the article is Article, BlogPosting and Report, with `reportNumber` and `version` when set. A Dataset node (when a dataset URL is set) with download and file format, `temporalCoverage`, `license` (when a licence URL is set), version, `variableMeasured` from the figure titles, and a description of at least 50 characters. dateModified follows the newest version date (never a future date). Verified in memory.

**Checks:** in-memory preview with the mockup's sample content and with a bare post (nothing saved, F-003): no PHP notices; `copy-check.py` 0 issues on the file and the rendered page; desktop 1440 and phone 390 with no horizontal scroll and no script errors; tooltips, table toggle and citation styles checked; `rl.py parity` 45 files, 0 differences.
**Fixed during the build:** the bar chart tooltip covered the figure title; it now sits beside the bar.

---

## D-100 · Research template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** APPROVED, built as D-101 (Jamil: "approved, build the Research template"; D-077 process)

**Mockup:** `claude/design-previews/blog-research-template-mockup.html`, published privately (claude.ai artifact "Research Template Mockup"). Sample topic: which sources AI answer tools cite for B2B buyer questions. **Every figure, finding and sample size is sample data**: the page banner says so and each data block carries a "Sample data" tag. The AI tools are not named, so no claim is made about a real product.

**Design: a published report**, different from the nine built templates:
- **Header:** two chips (Original Research + category), the title with its point in red, standfirst, byline with published and updated dates.
- **Study card** beside the title: report number (e.g. RL-R-2026-03), version, sample, collection period, markets, method, who checked the work, and two buttons: "Get the data" and "Cite this".
- **Headline number:** the one figure the study is known for, with its sample size.
- **Key findings:** a numbered ledger of up to 5, each a stat plus one plain sentence that can be quoted on its own, a link to its figure, and a "Link" button that copies a link to that finding (each finding has its own anchor).
- **Numbered figures:** Figure 1 horizontal bars, Figure 2 columns. Each has a title, the takeaway in one line, a hover tooltip, the sample size and source, "Show as a table", "Download CSV" and a link. One series in brand red, the same colour already checked against the dark surface (D-098).
- **How we ran the study:** sample, period, sources and analysis at a glance; the method in four steps; definitions; **limits of this study** (in amber, as honest notes).
- **What this means for you:** one card per reader (marketing leads, SEO and content teams, founders), then **the light in-article service CTA**.
- **Data and citation:** dataset download card (file name, rows, columns, size), licence line, citation in Plain, APA or Link form with a copy button.
- **Version history:** each version with its date and what changed; corrections tagged.
- Related studies, FAQs, sources, author box.

**Proposed schema for the build:** the article as Report (already in place), the Dataset node made fuller (period covered, what was measured, licence, CSV download), version and dateModified taken from the version history, and each key finding kept as plain text so AI tools can quote it.

**For Jamil to decide at the build:** the dataset licence wording (the mockup shows "Free to use and share with a link to this page", tagged "Licence to be agreed"); whether report numbers are used.
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll and no script errors; chart tooltips and the table toggle checked. Fixed before publishing: the source line under each figure had been inside the folded table, so it was hidden; the longest bar label was cut off on desktop and the 0% axis label on phone.

---

## D-099 · Case Study template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Case Study template")

**Files:** new `blog/reinforce-post-casestudy.php` (added to the loader); `blog/reinforce-post.php` hands Case Study posts to `rl_casestudy_render()`; the old case study fields, boxes and the publish guard moved out of `blog/reinforce-post-types.php` into the new file (no case study posts existed, so no data was affected). Only Research and Product/Service still use the shared boxes.

**How an editor writes a Case Study post:**
- **Approval first:** "Client approved this case study" must be ticked. Without it a published case study is put back to draft on save, and any preview shows a "Not approved" banner and hides the client quote (D-076).
- **Project file:** client (anonymised by default; "Client agreed to be named" names them), a note on how they are shown, industry (links to its `/industries/` page), project period, services used (linked chips), team.
- **Results:** up to 4 lines, `Metric | Before | After | Change | Period and source`.
- **Results chart:** title, points `Label | Number`, markers `Label | Text` (`Mar+0.6` places a marker part way to the next point), source. Drawn in the browser as one red series with a crosshair tooltip and a "Show the figures as a table" view.
- **The three acts:** challenge, client profile (`Label | Value`, up to 4), goals; phases `When | Phase | What we did | Deliverable; Deliverable`; what did not go to plan `Problem | How we handled it`; outcome, then the body, evidence screenshots (media gallery, up to 6; the image title is the label and the caption the text), what's next.
- **Client quote and role, lessons (up to 3), CTA, how we measured, other factors** `What changed | How we accounted for it`.
- **Related case studies:** the three newest other case study posts, shown only when they exist.

**Schema:** the base BlogPosting, Person and FAQPage, plus on the article: `about` = the client as an Organization when named, otherwise the industry; `mentions` = each service used as a Service with its page URL. Verified in memory for both cases.

**Checks:** in-memory preview with the mockup's sample content (nothing saved, F-003): no PHP notices; `copy-check.py` 0 issues on the file and the rendered page; desktop 1440 and phone 390 with no horizontal scroll; chart tooltip checked; approval-off preview shows the banner and no quote; `rl.py parity` 44 files, 0 differences.
**Tool fix found during the build:** `rl.py preview-post` returned only the first item of array fields (services, gallery), because WordPress already takes item 0 of a filtered single meta value. The preview now passes values the way WordPress stores them, and writes the schema graph next to the HTML (`out.html.schema.json`). Earlier previews used no array fields, so their checks stand.

---

## D-098 · Case Study template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** APPROVED, built as D-099 (Jamil: "approved, build the Case Study template"; D-077 process)

**Mockup:** `claude/design-previews/blog-casestudy-template-mockup.html`, published privately (claude.ai artifact "Case Study Template Mockup"). Sample topic: an anonymised pharmaceutical manufacturer whose product pages were blocked from Google. **Every client detail, figure and quote is sample data**: the page banner says so, and the client card, results and quote each carry a "Sample data" tag. No real client result is shown or implied.

**Design: a project file**, different from the eight built templates:
- **Header:** two chips (Case Study + category), the title with its outcome in red, standfirst, byline.
- **Project file card:** a red file tab, **"Approved by client"** badge, the client (named, or anonymised as in the sample), industry, project period, services used (linked chips), team.
- **Results:** up to four before-and-after tiles: the old figure struck through, the new figure, the change, and the period and data source under each.
- **The story in three acts:** 1 The brief (challenge and goals), 2 The work (phases with timing and what was delivered), 3 The outcome.
- **Client quote:** the client's exact, approved words with name or role.
- **What made the difference:** three lessons for readers; **the light in-article service CTA**; **services used** as cards linking to the service and industry pages.
- **How we measured:** periods compared, data sources, "shared with permission", and that results depend on many factors.
- FAQs (including why the client is or is not named), sources, author box.

**v2, same day** (Jamil asked "is it enough detailed for industry standard case study", then "yes, add 1 to 7 and update the mockup"). Added:
1. **Results chart over time** (organic clicks a month, January to August) with markers for "Work started" and "Template fix live", hover tooltip with crosshair, the end value labelled, the source under it, and "Show the figures as a table". One series in brand red; colour checked with the dataviz validator against the dark surface (all checks pass).
2. **Evidence screenshots:** a gallery of three (before, after, example page), each with date and caption.
3. **Client profile:** company size, markets, website, what they tried before.
4. **What did not go to plan:** problem and how we handled it, side by side.
5. **Other things that changed:** listed under "How we measured" (core update, seasonality, a trade show) with how each was accounted for.
6. **What's next:** the ongoing work.
7. **Related case studies:** three cards at the end, before the FAQs.
All new client details and figures carry the "Sample data" tag. Copy check 0 issues; desktop and phone with no horizontal scroll. Fixed before publishing: the screenshot placeholders shared a class with the phase timeline.

**Rules carried over (D-076):** the publish guard stays: a case study cannot go live until "Client approved this case study" is ticked; anonymised unless the client agreed in writing to be named; measured results only, with period and source; the quote only as approved by the client.
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll. Fixed before publishing: the sample tag in the client card and one awkward line.

---

## D-097 · Updates template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Updates template")

**Files:** new `blog/reinforce-post-updates.php` (added to the loader); `blog/reinforce-post.php` hands Updates posts to `rl_updates_render()`; the old updates boxes and fields were removed from `blog/reinforce-post-types.php` (no posts existed, so no data was affected). Keys `rl_u_what`, `rl_u_means`, `rl_u_do`, `rl_u_source` and `rl_u_log` are kept.

**How an editor writes an Updates post:**
- **Dateline:** status (Announced, Rolling out, Complete, Confirmed, Unconfirmed; Rolling out pulses gently), official source (`Name | URL`), **last checked** (date and time, UTC; update it each time the source is checked).
- **Rollout timeline:** up to 5 stages, `Stage | Date or note | done, now or next`.
- **The update in brief:** headline and text for what changed and what it means, headline and action lines for what to do. The heading counts the parts.
- **Sites to watch:** `Site type | high, medium or low | Note` (Watch closely, Watch, Lower risk), with an editable note saying it is our reading.
- **Do now / this week / later** action lines.
- **Official statement:** the exact words, word for word, and the date; shown only when filled in, with the source link.
- **Live log:** `YYYY-MM-DD HH:MM | What changed in this post` (time optional, UTC), sorted newest first automatically; a line starting with `!` is tagged "Correction".
- **CTA** after the official statement; the body follows as the in-depth part.

**Schema:** dateModified on the article and page follows the newest live log entry or "last checked" time, whichever is later (never a future time); plus the base BlogPosting, Person and FAQPage. Verified in memory: dateModified moved from 29 Sep 17:00 to 3 Oct 14:00 UTC. No NewsArticle markup (D-096).

**Checks:** in-memory preview with the mockup's content, dates moved into the past (nothing saved, F-003): no PHP notices; desktop 1440 and phone 390 with no horizontal scroll; `copy-check.py` 0 issues on the file and the rendered page; `rl.py parity` 43 files, 0 differences; live blog and SEO & AI Search Audit pages still 390 wide.
**Fixed during the build:** the "This week" action header wrapped beside its subtitle on desktop; the subtitle now sits under the heading.

---

## D-096 · Updates template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S REVIEW (Jamil: "yes, go ahead with the Updates mockup"; D-077 process)

**Mockup:** `claude/design-previews/blog-updates-template-mockup.html`, published privately (claude.ai artifact "Updates Template Mockup"). Sample topic: a placeholder "October 2026 core update". The update, dates and the official statement are placeholders, marked as such on the page; nothing in it is presented as real news.

**Design: a news desk bulletin**, different from the seven built templates:
- **Dateline bar:** two chips (Update + category), a **status pill** (Rolling out, Complete, Confirmed or Unconfirmed; Rolling out pulses gently, still with reduced motion), the official source and "Last checked" date and time.
- **Rollout timeline:** four stages (e.g. Announced, Rolling out, Complete, Review results) with the current stage marked "Now" and expected ones dimmed.
- **The update in three parts:** what changed, what it means, what to do.
- **Sites to watch:** each site type with a watch level (Watch closely, Watch, Lower risk) and a note, plus a line saying it is our reading, not Google's statement.
- **What to do, and when:** Now, This week, Later.
- **What Google said:** the official statement quoted word for word, with date and link (the template will only show it when the editor pastes the exact words).
- **The light in-article service CTA**, then the in-depth body.
- **Live log** beside the article (first on phones): timestamped changes to the post, newest first, with corrections tagged.
- FAQs, sources, author box.

**When built:** the "Last checked" time and the live log make freshness visible; the post's dateModified follows the latest log entry. No NewsArticle markup unless Jamil wants it (BlogPosting stays, as for every type).
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll. Fixed before publishing: the live log entries were squeezed into a narrow column; status dots are square (zero rounded corners, D-013).

---

## D-095 · Industry template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Industry template")

**Files:** new `blog/reinforce-post-industry.php` (added to the loader); `blog/reinforce-post.php` hands Industry posts to `rl_industry_render()`; the old industry boxes, fields and schema were removed from `blog/reinforce-post-types.php` (no posts existed, so no data was affected). `rl_pt_industries()` stays there because Case Study uses it too. Keys `rl_i_industry` and `rl_i_rules` are kept.

**How an editor writes an Industry post:**
- **Cover:** industry (one of the 8; names the sector on the cover and fills the industry card), written for, **reviewed for accuracy by** (`Name, qualification`; only a real reviewer who checked the post; empty hides it), markets covered.
- **Sector at a glance:** up to 4, `Label | Headline | One line`.
- **Sector rules:** `Rule | Market | What it means for search`, numbered R1, R2 automatically, with an editable note underneath (default "General guidance, not legal or regulatory advice.").
- **Buyer journey:** up to 4 stages, `Stage | Who searches | Question one; Question two | Content that answers`.
- **Where to start:** up to 6 moves, `Move | What to do | Impact 1 to 3 | Effort 1 to 3`; the heading counts them ("Five moves, in order").
- **What works / What to avoid** lines; the light CTA (after the buyer journey) links to the chosen service, or to the industry page when no service is chosen.
- **Body:** text before the first H2 is the intro; H2 sections show after the buyer journey.
- **Industry card:** the industry name, summary, page link and its first three services, read from the same industry data the industry pages use (`rl_ind_data()`), so it stays in step with them.

**Schema:** the article's `about` is the industry; when a reviewer is named the WebPage gets `reviewedBy` and `lastReviewed`. If the reviewer is Jamil, `reviewedBy` points to his existing Yoast Person record; anyone else is added as a Person with their qualification as job title. Verified in memory: reviewedBy = Jamil's Person id, about = Pharmaceutical & Life Sciences.

**Checks:** in-memory preview with the mockup's pharma content (nothing saved, F-003): no PHP notices; desktop 1440 and phone 390 with no horizontal scroll; `copy-check.py` 0 issues on the file and the rendered page; `rl.py parity` 42 files, 0 differences; live blog and Pharmaceutical industry pages still 390 wide.
**Fixed during the build:** the cover band class renamed so it cannot pick up the kit's `.band` section style.

---

## D-094 · Industry template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S REVIEW (Jamil: "yes, go ahead with the Industry mockup"; D-077 process)

**Mockup:** `claude/design-previews/blog-industry-template-mockup.html`, published privately (claude.ai artifact "Industry Template Mockup"). Sample topic: "SEO for pharmaceutical companies: what works under strict promotion rules". Sample content, marked as such on the page.

**Design: a sector briefing**, different from the Guide, How-To, Best / List, Review, Comparison and Explainer:
- **Briefing cover:** a striped red band reading "Industry briefing" down the side, two chips (Industry + category), the sector named, the title with its second half in red, "Written for" (the audience), **"Reviewed for accuracy by"** (e.g. Jamil Ahmed, Pharmacist; optional), "Markets covered", byline with the "Updated" date in green.
- **Sector at a glance:** four tiles on what makes search different in this industry (search risk, rules, buyers, proof).
- **Sector rules** as a compliance checklist (R1, R2, R3) with the market each applies to and what it means for search, plus a "general guidance, not legal or regulatory advice" note.
- **Buyer journey:** three stages on a track (Learn, Evaluate, Partner), each with who searches, real example questions, and the content that answers them.
- **Light in-article service CTA** pointing to the industry page.
- **Where to start:** five numbered moves with impact and effort bars; **what works and what to avoid** side by side.
- **Industry card:** the industry page link and up to three relevant services (from the industry data already used on the industry pages).
- FAQs, sources, author box.

**Expert review line:** the reviewer is shown only when the editor fills it in. For pharma and healthcare posts Jamil can be named as the pharmacist reviewer (a confirmed fact, D-068). **When built:** the reviewer goes into schema as `reviewedBy` on the page, and the article `about` is the industry.
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll.

---

## D-093 · Explainer template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Explainer template")

**Files:** new `blog/reinforce-post-explainer.php` (added to the loader); `blog/reinforce-post.php` hands Explainer posts to `rl_explainer_render()`; the old explainer boxes, fields and DefinedTerm code were removed from `blog/reinforce-post-types.php` (no posts existed, so no data was affected). The keys `rl_e_term`, `rl_e_definition` and `rl_e_related` are kept.

**How an editor writes an Explainer:**
- **Headword:** search question, term, abbreviation, word type (default "noun"), also called (comma separated), field.
- **Definition** (written to be quoted, starting with the term; the term is set in bold automatically) and where it comes from.
- **Key facts:** `Label | Value | URL` (URL optional; a path such as `/services/...` works).
- **Three levels:** "In 10 seconds" and "In 1 minute"; the third level ("In depth") is the article body and links to the first section below.
- **How it works:** up to 5 steps, `Step | What happens`. **It is / It is not** lines. **Example:** what it shows, before and after (`Note | Text`).
- **Related terms:** up to 4, `Term | One line | Relation | URL`, laid out around the term. The light service CTA shows after the example.
- **Body:** the full article sits after "How it works". Its H2s are added to "On this page" in the key facts box, together with the fixed sections.

**Behaviour:** "Copy definition" and "Copy" (cite this page) copy to the clipboard, or select the text when the browser refuses. The key facts box stays in view on desktop and sits first after the definition on phones.

**Schema:** DefinedTerm (name, definition, alternate names from the abbreviation and "also called"), and the article's `about` points to it; plus the base BlogPosting, Person and FAQPage.

**Checks:** in-memory preview with the mockup's GEO content (nothing saved, F-003): schema nodes Article/BlogPosting, Person, FAQPage, DefinedTerm; no PHP notices; desktop 1440 and phone 390 with no horizontal scroll; `copy-check.py` 0 issues on the file and the rendered page; `rl.py parity` 41 files, 0 differences; live blog and GEO pages still 390 wide.

---

## D-092 · Explainer template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S REVIEW (Jamil: "yes, go ahead with the Explainer mockup"; D-077 process)

**Mockup:** `claude/design-previews/blog-explainer-template-mockup.html`, published privately (claude.ai artifact "Explainer Template Mockup"). Sample topic: "What is generative engine optimization (GEO)?", linked to our GEO service. Sample content, marked as such on the page.

**Design: a reference entry**, different from the Guide (book), How-To (workbench), Best / List (shortlist board), Review (lab report) and Comparison (head-to-head):
- **Headword header:** the search question in small type, the term set very large with its abbreviation in red, then "noun", "Also called" and "Field" like a dictionary line. Two chips (Explainer + category), "Updated" date in green.
- **Definition block:** the quotable one-to-two sentence definition (the passage AI tools and featured snippets lift), a "Copy definition" button, and where the term comes from.
- **Key facts info box:** short for, where the term comes from, applies to, builds on (linked), measured by, plus "On this page" links. Sticky on desktop, first after the definition on phones.
- **Three levels:** 10 seconds, 1 minute, in depth (the full article), all visible (nothing hidden in tabs), each with a small depth meter.
- **How it works** as a 4-step flow with arrows (stacks on phones), **what it is and is not** side by side, a **before and after example**, the light in-article service CTA, **related terms** as a small concept map around the term, and a **"Cite this page"** line with a copy button.
- FAQs, sources, author box.

**When built:** DefinedTerm schema for the term and its definition (kept from D-076), with the related terms as `isRelatedTo` style links where they have URLs.
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll. Changed before publishing: the "after" example now uses the locked positioning wording.

---

## D-091 · Comparison template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Comparison template"). Two options, as noted in D-090; three-way comparisons can be added later if Jamil asks.

**Files:** new `blog/reinforce-post-comparison.php` (added to the loader); `blog/reinforce-post.php` hands Comparison posts to `rl_cmp_render()`; the old comparison boxes, fields and ItemList code were removed from `blog/reinforce-post-types.php` (no posts existed, so no data was affected). The field keys `rl_c_rows`, `rl_c_winners` and `rl_c_verdict` are kept with compatible formats.

**How an editor writes a Comparison:**
- **Option A and B:** name, one line, "Choose it if". A shows in red and B in a pale neutral everywhere on the page.
- **Rounds:** `Round | Winner | What A is like | What B is like`; the winner can be A, B, Tie or the option's name. The tally bar and the "what matters to you" picker are worked out from these lines.
- **Side-by-side details:** `Row | A | B`. **Winner by situation:** `Situation | A or B | Why`. **Or use both** (optional), **our verdict**, and the light service CTA (shown before the verdict).
- **Body:** text before the first H2 is the intro under the short answer; H2 sections show after the comparison as further reading.

**Behaviour:** the picker starts by showing the result across all rounds, then names the winner (or a tie) for the rounds the reader ticks. On phones the face-off stacks with the VS line across, and each round stacks with A and B labels.

**Schema:** ItemList of the two options (no ratings), plus the base BlogPosting, Person and FAQPage.

**Checks:** in-memory preview with the mockup's content (nothing saved, F-003): schema nodes Article/BlogPosting, Person, FAQPage, ItemList; no PHP notices; desktop 1440 and phone 390 with no horizontal scroll; picker tested with three rounds ticked (correct result); `copy-check.py` 0 issues on the file and the rendered page; `rl.py parity` 40 files, 0 differences; live blog and Enterprise SEO pages still 390 wide.

---

## D-090 · Comparison template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S REVIEW (Jamil: "yes, go ahead with the Comparison mockup"; D-077 process)

**Mockup:** `claude/design-previews/blog-comparison-template-mockup.html`, published privately (claude.ai artifact "Comparison Template Mockup"). Sample topic: "In-house SEO team vs SEO agency" (a decision our buyers make, and no claims about real products). Sample content, marked as such on the page.

**Design: a head-to-head**, different from the Guide (book), How-To (workbench), Best / List (shortlist board) and Review (lab report):
- **Centred header**, two chips (Comparison + category), "Updated" date in green.
- **Face-off:** Option A and Option B on either side of a VS line, each with a one-line description and "Choose it if". A in brand red, B in a pale neutral, used consistently through the page.
- **Tally bar:** rounds won by each side and ties, as one proportional bar.
- **Round by round:** each criterion is a row with A's side, the round name and a winner pointer in the middle (arrow towards the winner, or Tie), and B's side; the winning side is lightly tinted. On phones each round stacks with labels.
- **"What matters most to you?"** picker: the reader ticks rounds and the page names the winner for them (or a tie), counting only the rounds they picked.
- **Side-by-side details table**, **winner by situation** cards, **"Or use both"** note for the hybrid option.
- **The light in-article service CTA**, then **our verdict**, FAQs and sources, author box.

**When built:** 2 options in the face-off (3 supported later if Jamil wants it); the winner of each round is set by the editor; ItemList schema of the options stays (from D-076), no ratings.
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll.

---

## D-089 · Review template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Review template")

**Files:** new `blog/reinforce-post-review.php` (added to the loader after the Best / List file); `blog/reinforce-post.php` hands Review posts to `rl_review_render()`; the old review boxes, fields and Review schema were removed from `blog/reinforce-post-types.php` (no posts existed, so no data was affected).

**How an editor writes a Review:**
- **Product and test conditions:** product reviewed (third-party only, D-076), kind (software, product or service), version tested, test period, plan tested, "We paid for it ourselves" (on by default; off changes the disclosure to say the vendor gave access), test site or setup, affiliate switch.
- **Verdict:** verdict word (Highly recommended, Recommended, Good with limits, Not recommended), the verdict text, "Buy it if" and "Skip it if" lines.
- **Scorecard:** criteria as `Criterion | Weight | What it measures` plus the scores (comma separated). The headline score is the weighted average, so the scorecard total and the headline always match. A plain score field is used only when there are no criteria.
- **Test log:** `YYYY-MM-DD | What we did | What happened | Measured result`; a line starting with `*` is a key finding (filled marker).
- **Commercial details:** price from, price checked date, free trial, best for, pricing plans (`Plan | Price | What you get`; the plan named in "Plan tested" is marked), alternatives (`Name | Best for | From | Extra column | URL`) with an optional extra column heading and this product's value, visit link and button text, final verdict.
- **Light service CTA** after the pros and cons.
- **Body:** the article text sits under the verdict and before the test log; images with captions show in a screenshot frame.

**Behaviour:** verdict card stays in view on desktop (score, verdict, price, trial, best for, visit button, jump links); on phones a bottom bar shows the score and visit button (the page adds bottom padding so it never covers the footer). Visit links are `rel="sponsored nofollow"` when affiliate.

**Schema:** Review with `itemReviewed` (SoftwareApplication, Product or Service, with version), rating out of 10, author (Jamil's Yoast Person id), publisher, date, reviewBody, positive and negative notes; plus the base BlogPosting, Person and FAQPage. **Guard:** no Review schema when the product name is Reinforce Lab or one of our products (D-076).

**Checks:** in-memory preview with the mockup's placeholder content (nothing saved, F-003): schema nodes Article/BlogPosting, Person, FAQPage, Review; no PHP notices; desktop 1440 and phone 390 with no horizontal scroll; `copy-check.py` 0 issues on the file and the rendered page; all 3 visit links sponsored; `rl.py parity` 39 files, 0 differences; live blog and Technical SEO pages still 390 wide.
**Fixed during the build:** the phone bottom bar wrapped to three lines; it now keeps the score and one line of text.

---

## D-088 · Review template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S REVIEW (Jamil: "yes, go ahead with the Review mockup"; D-077 process)

**Mockup:** `claude/design-previews/blog-review-template-mockup.html`, published privately (claude.ai artifact "Review Template Mockup"). The product (Crawlwise), its alternatives, scores and prices are placeholders, marked as such on the page.

**Design: a lab test report**, different from the Guide (book), How-To (workbench) and Best / List (shortlist board):
- **Report header:** two chips (Review + category), title with the product name in red, standfirst, byline with the "Updated" date in green.
- **Test conditions strip:** version tested, test period, plan tested (and who paid), test site, price checked; the disclosure sits directly under it (we paid for our own licence; affiliate links do not change the score).
- **Verdict block up front:** big score with a 10-step meter and a verdict word (e.g. Recommended), the verdict in two or three sentences, then "Buy it if" and "Skip it if" side by side.
- **Verdict card that stays in view:** on desktop a side card (score, verdict, price from, free trial, best for, visit button, price-checked date, jump links); on phones a bottom bar with the score and the visit button.
- **Test log:** dated entries on a line, each with what happened and one measured result tag; key findings get a filled marker. A screenshot frame for evidence.
- **Scorecard:** each criterion with its weight, a one-line definition and a bar; the weighted score at the bottom equals the headline score.
- **Pros and cons** (drawn icons), **the light in-article service CTA**, **pricing plans** with the plan we tested marked, **how it compares** with alternatives (this product's row highlighted), and a **final verdict** with the visit button.
- FAQs (including "Did the vendor pay for this review?"), sources, author box.

**Rules carried over from D-076:** third-party products only, never our own services (self-reviews are not eligible for review rich results); visit links `rel="sponsored nofollow"` when affiliate.
**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll. Fixed before publishing: the odd fifth test-condition cell and the score block layout on phones.

---

## D-087 · Best / List template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Best/List template")

**Files:** new `blog/reinforce-post-list.php` (added to the loader after the How-To file); `blog/reinforce-post.php` hands list posts to `rl_list_render()`; the old list boxes, fields and ItemList code were removed from `blog/reinforce-post-types.php` (no posts existed, so no data was affected).

**How an editor writes a Best / List post:**
- **Picks** are an ACF PRO repeater, in ranked order. Per pick: name, badge, best for, verdict, scores (one per criterion, comma separated), overall score (only when there are no criteria), price from, what we liked, what could be better, key facts (`Label | Value`; the first one is also a table column), skip it if, visit link, more detail (optional longer notes).
- **Scoring criteria:** `Criterion | Weight` lines. The overall score is calculated as the weighted average of the pick's scores, so the numbers on the page always agree.
- **Method strip:** up to 3 facts (`Number | Label`), prices checked date, affiliate switch (shows the disclosure and marks visit links `rel="sponsored nofollow"`).
- **Pick by what you need** (`Need | Pick name | Why`, linked to the pick by name), **Also considered** (`Name | Reason`), **How we chose** (up to 3, `Heading | Text`), the in-article CTA (service, after which pick, headline, one line, button), and the "What the items are" label for the table heading.
- **Body:** text before the first H2 is the intro under the short answer; H2 sections show after "Pick by what you need" as further reading.

**Behaviour:** podium of the top three (Top pick raised in the middle; stacks on phones), sticky shortlist bar under the header with the current pick highlighted, comparison table sortable by rank, score and price (scrolls inside its own box on phones).

**Schema:** ItemList of the picks (name and `#pick-N` url) plus the base BlogPosting, Person and FAQPage. No per-pick Review or rating (D-086 recommendation: the scores are an editorial ranking).

**Checks:** in-memory preview with the mockup's placeholder data (nothing saved, F-003): schema nodes Article/BlogPosting, Person, FAQPage, ItemList; no PHP notices; desktop 1440 and phone 390 with no horizontal scroll; `copy-check.py` 0 issues on the file and the rendered page; `rl.py parity` 38 files, 0 differences; live blog and Website Maintenance pages still 390 wide.
**Fixed during the build:** the kit's section padding left a gap above the method strip; the kit's table-header style leaked into the pick names in the table; scores now always show one decimal (9.0, not 9).

---

## D-086 · Best / List template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S REVIEW (Jamil: "yes, go ahead with the Best/List mockup"; D-077 process)

**Mockup:** `claude/design-previews/blog-list-template-mockup.html`, published privately (claude.ai artifact "Best/List Template Mockup"). Product names, scores and prices in it are placeholders, marked as such on the page.

**Design: a shortlist board**, different from the Guide (book) and How-To (workbench):
- **Hero with a podium:** the top three picks as podium blocks (Top pick in the middle, raised), each with its label, score and starting price. Two chips only (Best / List + category). "Updated" date shown in green, since freshness matters for list posts.
- **Method strip:** hosts tested, weeks measured, criteria; the score weighting as one proportional bar; the date prices were checked; the affiliate disclosure.
- **Sticky shortlist bar:** every pick with rank and score, the current one highlighted while scrolling, and "Compare all".
- **Comparison table:** sortable by rank, score and price; top pick row highlighted; scrolls inside its own box on phones.
- **One spec sheet per pick:** big rank numeral and score plate, badge, "Best for", verdict, score breakdown bars per criterion (the overall score is the weighted sum, so the numbers always agree), what we liked / what could be better (drawn icons, no emoji), price, refund window, data centres, "Skip it if", visit button (`rel="sponsored nofollow"`) and the price-checked date.
- **The light in-article service CTA** (same pattern as Guide and How-To), after pick 2.
- **Pick by what you need:** four "If ... pick ..." cards linking to the pick.
- **Also considered** (with the reason each was left out), **How we chose**, FAQs and sources, author box.

**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll. Fixed before publishing: hero alignment and cut-off weighting labels.
**When built:** ItemList schema (already in the base), one Product per pick is not planned because the scores are our editorial ranking, not reviews of each product.

---

## D-085 · How-To template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the How-To template")

**Files:** new `blog/reinforce-post-howto.php` (added to the loader after the Guide file); `blog/reinforce-post.php` hands How-To posts to `rl_howto_render()`; the old How-To boxes, fields and schema were removed from `blog/reinforce-post-types.php` (no posts existed, so no data was affected).

**How an editor writes a How-To:**
- **Every H2 in the body is one step.** Text before the first H2 is the intro. Ordered lists inside a step show as lettered actions (a, b, c). Images with captions show in a screenshot frame. `<kbd>` shows as a key. A paragraph with class `tip` is a Tip box.
- **Job ticket fields:** Time (minutes), Level, Cost, "Before you start, you need" (one per line), "When you finish".
- **Step details:** one line per step, in order: `Minutes | Why this step matters | You should see`.
- **Side panel:** "Avoid these" (one per line), "If something goes wrong" (`Problem | Fix`).
- **Finish card:** headline (default "Done: all steps complete") and what to do next.
- **In-article CTA:** service, after which step, headline, one line, button (same light pattern as the Guide). If set after the last step it shows below the finish card.

**Behaviour:** sticky step tracker under the header (pills on desktop, count and line on phones); "Mark step done" turns the node into a check, fills the tracker and the progress bar, and is remembered in the reader's browser only (no data sent anywhere). Two chips only (How-To + category, D-077).

**Schema:** HowTo node built from the steps on the page (name = H2, text = first paragraph, url = `#step-N`), `totalTime`, `tool`, `description` from the excerpt; plus the base BlogPosting, Person and FAQPage.

**Checks:** in-memory preview (nothing saved, F-003) through the live template: schema nodes Article/BlogPosting, Person, FAQPage, HowTo; no PHP notices; desktop 1440 and phone 390 with no horizontal scroll; `copy-check.py` 0 issues on the file and the rendered page; `rl.py parity` 37 files, 0 differences; live blog, About and Technical SEO pages still 390 wide.
**Fixed during the build:** the theme's Bootstrap styles `.progress` and `.mark`, so those classes were renamed (`h-prog`, `h-mark`); lettered actions no longer break around inline elements such as `<kbd>`.

---

## D-084 · Founder bio: drafts for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S CHOICE (Jamil: "You already know my bio. write a better one my bio is poor")

**Deferred (4 Oct):** Jamil: "can you do it just after finishing the templates first". The bio choice and the merge of this branch into `main` wait until every blog template is built. Return to both straight after the last template.

Drafts in `claude/drafts/founder-bio-2026-10-04.md`: two author-box options (A: what Jamil builds; B: why a reader should trust the article), a longer About founder section, and a one-line Person schema description. Built only from confirmed facts (D-008, D-068, D-069); two lines are marked INFERENCE for Jamil to confirm or cut. The file also lists facts that would strengthen the bio if Jamil supplies them (years in SEO, pharmacy qualification, Ambassador since, talks or named clients). Nothing changed on `.online`. Once chosen, the bio goes into the author box (`blog/reinforce-post.php`, `blog/reinforce-post-guide.php`), the About founder section and the Person schema in `pages/reinforce-about.php`, and the mockups.

---

## D-083 · GitHub navigation: a README on the repository home, folder guides and a generated site map
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "I want a nice navigation of everything in GitHub so that i can find anything easily and documented")

- `README.md` (new, shown on the GitHub home page): the three rules, a "Start here" table (I want to... / go to), the site at a glance, the repository map, current status, how to keep the map current.
- `claude/site-map.md` (new, generated by the new `claude/tools/site-map.py` from the last snapshot): all 49 pages by section with ID, URL, status, the theme file that renders it (linked) and the SEO title.
- Folder guides (new): `claude/README.md` (every document by purpose), `claude/research/README.md` (brief to page), `claude/design-previews/README.md` (mockup, state, built file), `claude/data/README.md`. `wp/README.md` and `claude/tools/README.md` link to the site map.
- Checks: every relative link resolves; `copy-check.py` 0 issues on all new files. Nothing changed on `.online`.
- The README shows on the GitHub home page only once this branch is merged into `main` (open question to Jamil, D-082 GitHub note).

---

## D-082 · How-To template: design mockup v1 for review
**Date:** 4 October 2026 · **Status:** AWAITING JAMIL'S REVIEW (Jamil: "go ahead with the How-To mockup"; D-077 process)

**Mockup:** `claude/design-previews/blog-howto-template-mockup.html`, published privately (claude.ai artifact "How-To Template Mockup").

**Design: a workbench**, different from the Guide's book:
- **Job-ticket hero:** time, level meter, cost; a "Before you start, you need" checklist; "When you finish" result. Two chips only (How-To + category, per the D-077 chip rule).
- **Sticky step tracker:** every step as a pill, the current one highlighted, done ones filled, "2 of 5 done" and a progress line. On phones it shows the count and the line only.
- **Steps on a vertical track:** numbered nodes that turn into a filled check when the step is marked done; per step "Step N of M · minutes", a "Why" line, lettered actions, a keyboard-key style, a screenshot frame with caption, a green "You should see" check, and a "Mark step done" box.
- **The light in-article service CTA** (same pattern as the approved Guide CTA), placed after the step it matches (here Technical SEO after step 2).
- **Sticky side panel:** your progress, "Avoid these" (drawn cross icons, no emoji), "If something goes wrong" troubleshooting.
- **Finish card**, then FAQs and sources side by side and the author box.

**Checks:** `copy-check.py` 0 issues; desktop 1440 and phone 390 with no horizontal scroll. Fixed before publishing: the side panel was not sticking, and the "You should see" box now stacks on phones.

**GitHub note (same day):** Jamil could not see the work on GitHub. Every commit since 28 Sep is on the branch `claude/great-wright-cg4kqo` (81 commits ahead of `main`, `main` 0 ahead, so a clean fast-forward). `main` is unchanged pending Jamil's choice to merge. His Windows daily sync pushes to `main` without pulling, so after any merge his local copy must `git pull` first.

---

## D-081 · Step B, part 2: decision log split into an index, the current month and monthly archives
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "yes, do step A and step B one after another")

- **Before:** one 2,562-line file of 104 sections.
- **After:**
  - **this file:** an index of every entry (ID, title, date, status, where), the current month in full, and the open items (about 490 lines);
  - **`claude/decisions/2026-08.md`** (17 entries) and **`claude/decisions/2026-09.md`** (76 entries), unchanged and in their original order.
- D-036 had no date line and was filed in September (its text dates it 28 Sep).
- **Integrity check:** every one of the 104 original sections appears exactly once across the three files.
- The file name is unchanged, so the nightly task and the Cowork session still read `claude/decision-log.md` and find the latest work plus the full index.
- **Rule going forward:** at the start of each month, move the previous month into `claude/decisions/YYYY-MM.md` and keep its index rows.

---

## D-080 · Step B, part 1: theme code in folders with one loader
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "yes, do step A and step B one after another")

**Why:** 35 files in one flat folder would not scale to 11 post-type designs and more pages.

**Constraint (VERIFIED by reading `novamira/includes/sandbox-loader.php`):**
- Novamira loads **top-level `*.php` only**, in `glob()` order.
- A fatal error while loading puts the **whole sandbox into safe mode** (every custom page disabled).

**Layout:**
- `reinforce-loader.php` is the only top-level file. It requires the folder files in the **exact previous load order** (the server's real glob order was read and matched), so hook registration order is unchanged.
- Folders:
  - `core/`: header, kit.php, kit.css;
  - `pages/`: home, about, contact;
  - `saos/`: saos, diagnostic, packages, agents, agent-pages;
  - `services/`: the hub plus 18 service pages;
  - `industries/`;
  - `blog/`: blog, post, post-types, post-guide.
- The one code change: `core/reinforce-kit.php` now links `novamira-sandbox/core/reinforce-kit.css`.
- Documented in `wp/README.md`, plus a "Repository layout" section in CLAUDE.md. **A new file must be added to the loader list.**

**Migration (one guarded call):**
- It checked noindex, no safe mode, and every live file equal to git HEAD, and parse-checked every new file.
- It backed up every old file to `_backups/20261004-112407-restructure/` and moved the 128 legacy `.bak-*` files into `_backups/legacy/`.
- It wrote the folder files, deleted the old top-level files, and **wrote the loader last** (so no request could load a file twice), then cleared opcache and purged the LiteSpeed cache.
- A rollback script was prepared (restore the backup folder, remove the loader and folders); it was not needed.

**Verified after:**
- one top-level PHP file; no `.crashed` marker;
- `rl.py parity` 0 differences across 36 files; `rl.py crawl` 45 pages, 0 flags;
- kit.css served from `core/` (200, text/css); every sampled page 1 H1 with no PHP notices;
- 10 key pages exactly 390 px wide on phones;
- contact and diagnostic form handlers answer (invalid test → redirect, nothing saved);
- `/blog/paged-2/2/` still returns 410;
- snapshot refreshed.

**Tooling:** `rl.py` deploy, parity and backups handle subfolders; `copy-check.py` now scans subfolders.

---

## D-079 · Step A: tools and a database snapshot in the repo
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "yes, do step A and step B one after another")

**Finding:** all 35 sandbox files on `.online` matched GitHub, but three things lived outside it:
1. the database side of the site (pages, Yoast meta, menus, settings);
2. the deploy and QA tools (in a temporary session folder);
3. 125 deploy backups on the server.

**Done:**
- **`claude/tools/rl.py`** (new), one CLI with these commands:
  - `deploy` (guarded update or `--create`; noindex check, live md5 must equal git HEAD, PHP parse check, backup to `novamira-sandbox/_backups/<stamp>/`, opcache clear, md5 confirm);
  - `parity` (live vs repo md5);
  - `snapshot` (database export, secret-like values redacted);
  - `backups` (list, `--prune-days`);
  - `crawl` (every published page: em and en dashes, emoji, PHP notices, noindex);
  - `preview-post` (in-memory render through the live post template, nothing saved, F-003).
- **`claude/tools/shot.mjs`** (new): `width` (390 px check), `page` and `html` screenshots, with a git-ignored asset cache (`claude/tools/.cache/`).
- **`claude/tools/README.md`** rewritten, including the standard change routine.
- **`claude/data/online-snapshot/`** (new): pages.json (49 pages and posts with content, SEO meta and `rl_` fields), menus.json, menu_locations, options, yoast (IndexNow key redacted), terms, active_plugins, themer_layouts, rl_options (rollback copies), sandbox-md5.json. **Re-run `rl.py snapshot` after every change.**
- **Backups:** pruning older than 7 days found none to delete (the oldest is 28 Sep). The backups are not publicly readable (sandbox `.htaccess` returns 403, verified).

**Verified:** parity 0 differences; snapshot written; crawl of 45 pages with 0 flags; preview-post reproduces the Guide with its schema; `shot.mjs width` returns 390 for /blog/ and /about-us/.

---

## D-078 · Guide template built on `.online` from the approved mockup
**Date:** 4 October 2026 · **Status:** DONE (Jamil: "approved, build the Guide template")

**Files:**
- `wp/novamira-sandbox/reinforce-post-guide.php` (new; guarded create; live md5 = repo `92df9ea5…`).
- `reinforce-post.php`: hands Guide posts to `rl_guide_render()`, one line (backup `.bak-20261004-110803`, md5 `b8f2a263…`).
- `reinforce-post-types.php`: the placeholder Guide fields and boxes from D-076 were removed, so nothing is defined twice (md5 `9f6ae46f…`).

There is still **one** template entry point and no Themer singular layout (F-001). Other types keep the base layout until their own design is approved (D-077).

**How the editor's input maps to the design:**
- **Chapters are built automatically from the H2 headings:** chapter number, minutes per chapter, contents plate, chapter rail, "End of chapter / Next" links. Text before the first H2 renders as an intro.
- **Cover:**
  - title (the part after a colon shows in red);
  - standfirst = the WordPress excerpt;
  - two chips only (Guide + main category, D-077 review 1);
  - byline with published and real updated dates;
  - plate with chapters, total minutes and "A to Z" when a glossary exists.
- **New Guide fields:**
  - Start here paths ("Who it is for | Card text | #heading-id or URL", up to 3; shows "Chapter NN" when the link is a chapter);
  - in-article CTA: service (from the services list), after chapter N (default 2), headline, one line, button text. The diagnostic link is added automatically;
  - Glossary ("Term | Definition", sorted A to Z; anchors `#term-…`; text links to `#term-…` get a dotted underline);
  - Supporting articles hub ("Type | Title | URL"; when empty, 3 related articles show instead).
- **In the body:**
  - a quote block renders as the large pull quote;
  - a paragraph or block with the CSS class `tip` renders as the Tip box;
  - image blocks render as framed figures with captions;
  - tables scroll on phones.
- **Shared parts still used:** short answer, numbered key takeaways, FAQs and sources side by side, author box, diagnostic CTA.
- **Phones:** the chapter rail becomes a sticky "Chapter NN of NN · % read" bar with a progress line.
- **Schema:** the base BlogPosting, Person and FAQPage, **plus a DefinedTermSet** for the glossary.

**Verified (in memory, no post written, F-003):**
- A sample guide with 6 chapters was rendered through the live template: 1 H1, the 6 chapter ids built from the H2s, every section present, schema as above.
- Desktop and phone screenshots compared against the mockup.
- **Fixed after the first render:**
  - the excerpt printed raw `<p>` tags;
  - the CTA line picked up the kit's `.sub` style;
  - the kit's section padding doubled the chapter gaps.
- Phone width is exactly 390 px; `copy-check.py`: 0 issues.

**At the first real guide:** Rich Results Test, the live phone check, and confirming the sticky bar's top offset against the live header.

**Next (D-077 process):** design mockup for the next type, chosen by Jamil.

---

## D-077 · Blog templates: one type at a time, own design per type, mockup before code
**Date:** 3 October 2026 · **Status:** APPROVED (Jamil: "Why every blog templates look and feel almost similar and looks like a common template" … "work on one template at a time. Otherwise it always happens")

**Finding:** the D-076 build gave all 11 types the same page shell (same hero, same sidebar layout, same order) and the same box style for every type-specific section. The review screenshots also used one placeholder article for every type, so the templates read as one generic template.

**Decision:**
- One code file still renders all posts. That is what F-001 requires, and it says nothing about the look.
- **Each type now gets its own page design** (hero, layout and signature component), inside the D-013 design system.

**Process, per type:**
1. A static design mockup with realistic content for that type.
2. Jamil reviews it.
3. Only the approved design is built into the live template.
4. Then the next type starts.

The D-076 per-type sections stay live but are treated as placeholders until each type's design is approved. The multi-type review page (artifact `M1HRwpUmNwG46meKUJ4Gto`) is superseded.

**Type 1, Guide:** mockup `claude/design-previews/blog-guide-template-mockup.html`, published privately at https://claude.ai/artifact/G7CE2VXznAD2fQxKPB52dD. It is book-style:
- cover hero with a contents plate (chapters, minutes, glossary) and "Start here" paths;
- sticky chapter rail with reading progress (a progress bar and "Chapter 2 of 6" on phones);
- outlined chapter numbers opening each chapter, pull quote, note and figure styles, and "next chapter" links;
- back matter: A to Z glossary, a "this guide and its articles" hub map, FAQs and sources side by side, author box, CTA.

Sample content only. Awaiting Jamil's review.

**Review 1 (4 Oct):** "Pillar" chip removed. **Chip rule: at most two chips on a post hero, the type plus one main category** (Jamil: "use only two categories as chips"). Mockup v2 published.

**Review 2 (4 Oct):** in-article service CTA added (Jamil: "Add a call to action to an appropriate service/solution we provide in between the article. Light weight design and conversion optimized"). Mockup v3.
- **Design:** a slim band in the text column with thin red rules, a red left edge and a faint red wash; no heavy panel.
- **Content:** a label naming the service ("Reinforce Lab service · AI Search Optimization"), a question headline tied to the chapter just read, and one line on what we do.
- **One primary button** ("See how it works") plus a quiet text link to the free diagnostic as the low-commitment alternative. No invented proof or numbers.
- **Placement:** after the chapter whose topic matches the service (here after Chapter 2, about 40% into the article). Stacks on phones.
- **For the build:** editor fields to pick the service (from the services list) and the chapter it follows, with the headline and sub line written per post.

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
