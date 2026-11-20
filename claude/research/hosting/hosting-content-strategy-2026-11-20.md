# Hosting content strategy: titles, meta, semantics and AI search (20 Nov 2026)

Status: **PROPOSAL, nothing applied.** Companion to `hosting-cluster-decision-2026-11-20.md`. Covers the 3 list pages and the 9 host pages. Numbers are US monthly volume and keyword difficulty (KD) from Jamil's Semrush screenshots and CSV (VERIFIED). Titles and metas below are drafts for approval; each page is written and previewed separately, 2 a day at most (D-306, F-003).

## 1. Answer to the URL question

- **The 3 lists stay** and are written to the high SEO plus GEO, AEO and LLM standard (section 2).
- **The 9 host URLs stay.** Slugs do not change. Titles, meta, headings and content change, so each page turns from a "how to build a website" guide into a full review that keeps a short setup section. This is Option A from the cluster decision. It still needs Jamil's explicit approval, page by page, before anything goes live.

## 2. The standard every page follows (D-012, D-134, D-072)

| Element | Rule |
|---|---|
| SEO title | 60 characters or less. Pattern: `[Host] Review 2026: [what the reader decides]`. Keyword first, year, no brand suffix unless it fits |
| Meta description | 140 to 160 characters. Names the host, the year, what the page covers and who it suits. No prices in the meta (they change) and no claim of testing |
| H1 | Matches the title's promise, may be longer than the title |
| Answer first | A 40 to 60 word "Short answer" panel (`rl_answer`) directly under the H1: who it suits, what it costs for the first term and at renewal, the one reason to skip it. Quote-ready, self-contained, dated |
| Jump-to table of contents | Anchor links to Pricing, Renewals, Features, WordPress, Who it suits, Who should skip it, FAQ. The jump-to links Google shows today must keep working |
| Section order | 1 Short answer. 2 Quick facts table (plans, first-term price, renewal price, guarantee, offer end date, source and date). 3 Pricing and renewals. 4 What you get. 5 WordPress hosting. 6 Pros and cons. 7 Who it suits and who should skip it. 8 Alternatives (two links). 9 How to set it up (the old guide, shortened). 10 FAQ |
| Question headings | Real searches from Semrush as H2 or H3 (listed per page below) |
| FAQ | 4 to 6 questions, each answer self-contained in 2 to 3 sentences, marked up with FAQPage, visible on the page |
| Tables | Plan table and first-term vs renewal table, built as real HTML tables so AI engines can lift them |
| Entity clarity | Name every brand change plainly: "A2 Hosting is now hosting.com", "Nexcess is now part of Liquid Web". Define terms once (managed WordPress, renewal price) |
| Freshness | A visible "Prices checked on [date]" line and a real `dateModified`. Never bulk redate (F-003) |
| Sources | Every price and offer links to the host's official page with the check date. Third-party test numbers carry source, date and method |
| Evidence label | Hostinger: first-hand allowed (D-321). The other eight: "Research-based review: we have not used this host" and no testing language |
| Schema | BlogPosting (author Jamil Ahmed, real dates) + BreadcrumbList + FAQPage. **No star ratings and no Review markup** on research-based pages, because we have no first-hand rating to mark up (RECOMMENDATION). Decide separately for Hostinger |
| Internal links | Up to the pillar and the best list for its type; across to two alternatives; down to nothing else. Anchor text is the host name |
| AI crawlers | Content in the initial HTML, not injected by script. The page appears in `llms.txt` with a one-line description |
| Gates | `copy-check.py` 0 issues, `readability.py` grade 8.0 or lower, `serp-semantics.py` on the draft, `link-scan.py`, `post-check.py`, phone width 390 |

## 3. Summary table: titles and metas (all lengths checked)

| # | URL | Current SEO title | Proposed SEO title | Chars | Meta chars | Focus keyword |
|---|---|---|---|---|---|---|
| 1 | `/best-web-hosting-services/` | Best Web Hosting Services 2026: 12 Hosts Compared | Best Web Hosting Services 2026: 12 Hosts Compared | 49 | 150 | best web hosting services (1,000, KD 73) |
| 2 | `/best-cloud-web-hosting-services/` | Best Cloud Hosting 2026: 7 Hosts Compared and Priced | Best Cloud Hosting 2026: 7 Hosts Compared and Priced | 52 | 156 | best cloud hosting (1,600, KD 55, only 58 domains needed) |
| 3 | `/reviews/best-wordpress-hosting/` | Best Web Hosting for WordPress: 15 Picks | Reinforce Lab | Best WordPress Hosting 2026: Top Picks Compared | 47 | 142 | best hosting for wordpress (1,300, KD 21); best wordpress hosting (4,400, KD 60) |
| 4 | `/hostinger-web-hosting/` | How to Build a Website with Hostinger Hosting | Hostinger Review 2026: Pricing, Plans and Real Experience | 57 | 152 | hostinger review (1,000, KD 69) |
| 5 | `/bluehost-wordpress-hosting/` | How to Make A Website with Bluehost WordPress Hosting | Bluehost Review 2026: Pricing, Renewals and WordPress Plans | 59 | 151 | bluehost review (480, KD 64) |
| 6 | `/cloudways-hosting/` | How to Make Website with Cloudways WordPress Hosting | Cloudways Review 2026: Pricing, Servers and Who It Suits | 56 | 151 | cloudways review (590, KD 52) |
| 7 | `/kinsta-wordpress-hosting/` | How to Build a Website with Kinsta Hosting | Reinforce Lab | Kinsta Review 2026: Pricing, Speed and Who Should Pay for It | 60 | 147 | kinsta review (720, KD 50) |
| 8 | `/namecheap-wordpress-hosting/` | How to Make A Website with Namecheap WordPress Hosting | Namecheap Hosting Review 2026: Shared vs EasyWP Plans | 53 | 152 | namecheap wordpress hosting (480, KD 58) |
| 9 | `/dreamhost-wordpress-hosting/` | How to make a website with DreamHost WordPress Hosting | DreamHost Review 2026: Pricing, WordPress Plans and Verdict | 59 | 153 | dreamhost review (210, KD 60) |
| 10 | `/flywheel-wordpress-hosting/` | How to Make A Website with Flywheel WordPress Hosting | Flywheel Review 2026: Pricing, Plans and Who It Suits | 53 | 151 | flywheel hosting (1,000, KD 43) |
| 11 | `/a2-wordpress-hosting/` | How to Build a Website with A2 Hosting (hosting.com) | A2 Hosting Review 2026: Now hosting.com, Pricing | 48 | 146 | a2 hosting review (260, KD 50; SERP not checked) |
| 12 | `/nexcess-wordpress-hosting/` | How to Make A Website with Nexcess Wordpress Hosting | Nexcess Review 2026: Now Liquid Web, Plans and Pricing | 54 | 158 | nexcess review (140, KD 32) |

## 4. Page by page

### 1. Pillar list (post 378): `/best-web-hosting-services/`

- **Current SEO title:** Best Web Hosting Services 2026: 12 Hosts Compared. **Current meta:** (150 chars, already good).
- **Proposed SEO title (49 chars):** Best Web Hosting Services 2026: 12 Hosts Compared
- **Proposed meta (150 chars):** Best web hosting services for 2026: 12 hosts compared on sale price, renewal price, speed, uptime and support, with each host checked on its own site.
- **Proposed H1:** Best Web Hosting Services 2026: 12 Hosts Compared on Price, Speed and Renewals
- **Focus keyword:** best web hosting services (1,000, KD 73)
- **Secondary keywords (US volume):** best web hosting 2026 (90); best web hosting for beginners (140); best cheap web hosting (720); cheapest web hosting (1,900); best web hosting for small business (1,900); best web hosting for ecommerce (320); shared hosting vs vps (260)
- **Question headings and FAQ (volume):** What is the best web hosting service? (210); How to choose the best web hosting service? (20); What are the best web hosting sites? (260)
- **Entities and terms to cover:** shared, VPS, cloud and managed hosting; renewal price; uptime; money-back guarantee; free domain; WooCommerce
- **What changes:** Keep the title. Add sections: beginners, cheap hosting, small business, ecommerce, shared vs VPS. Add a ranked table first, offer end dates, and the question headings. Link down to every host page.

### 2. Cloud list (post 368): `/best-cloud-web-hosting-services/`

- **Current SEO title:** Best Cloud Hosting 2026: 7 Hosts Compared and Priced. **Current meta:** (156 chars, contains "Costs start at $4 a month").
- **Proposed SEO title (52 chars):** Best Cloud Hosting 2026: 7 Hosts Compared and Priced
- **Proposed meta (156 chars):** Best cloud hosting for 2026: 7 hosts compared on price, renewals, speed and who manages the server, each checked on its own site. Costs start at $4 a month.
- **Proposed H1:** Best Cloud Hosting 2026: 7 Hosts Compared on Price, Renewals and Who Manages the Server
- **Focus keyword:** best cloud hosting (1,600, KD 55, only 58 domains needed)
- **Secondary keywords (US volume):** best cloud hosting services (320); best cloud web hosting (260); cloud hosting providers (1,300); managed cloud hosting (1,900); best managed cloud hosting (40); cheap cloud hosting (720); cloud hosting for wordpress (140); best cloud hosting for small business (40)
- **Question headings and FAQ (volume):** What is cloud hosting? (590, keep to a short definition); Cloud hosting vs VPS (260); Cloud hosting vs shared hosting (140); What is managed vs unmanaged cloud hosting? (140)
- **Entities and terms to cover:** virtual servers, scaling, managed vs unmanaged, DigitalOcean, Vultr, Cloudways, Kinsta (Google Cloud), uptime SLA
- **What changes:** Keep the title and meta. Add the cloud vs VPS and vs shared sections, a managed vs unmanaged section, a cloud-for-WordPress section and a small business line. Link to Cloudways and Kinsta host pages.

### 3. WordPress list (page 69): `/reviews/best-wordpress-hosting/`

- **Current SEO title:** Best Web Hosting for WordPress: 15 Picks | Reinforce Lab. **Current meta:** (151 chars).
- **Proposed SEO title (47 chars):** Best WordPress Hosting 2026: Top Picks Compared
- **Proposed meta (142 chars):** Best WordPress hosting for 2026: top picks compared on price, renewals, speed, support and who each suits, from managed hosts to budget plans.
- **Proposed H1:** Best WordPress Hosting 2026: Top Picks Compared on Price and Renewals
- **Focus keyword:** best hosting for wordpress (1,300, KD 21); best wordpress hosting (4,400, KD 60)
- **Secondary keywords (US volume):** best managed wordpress hosting (2,400); best wordpress web hosting (1,600); best hosting company for wordpress (720); cloud hosting for wordpress (140)
- **Question headings and FAQ (volume):** How to choose the best WordPress hosting? (90); Best WordPress hosting for high traffic (70); for enterprise (90); for agencies (50); How to choose the best managed WordPress hosting? (50)
- **Entities and terms to cover:** managed WordPress, shared, staging, caching, backups, WP Engine, Kinsta, Flywheel, Hostinger, Bluehost, DreamHost
- **What changes:** Page exists but the list is not built. Build it as the WordPress list. Use the lower-difficulty "best hosting for wordpress" as the lead term. Link down to the nine host pages.

### 4. Host page: `/hostinger-web-hosting/`

- **Current SEO title:** How to Build a Website with Hostinger Hosting. **Current meta:** 159 chars.
- **Proposed SEO title (57 chars):** Hostinger Review 2026: Pricing, Plans and Real Experience
- **Proposed meta (152 chars):** Hostinger review for 2026: plans, first term and renewal prices, WordPress hosting, speed and support, plus who should skip it and how to set up a site.
- **Proposed H1:** Hostinger Review 2026: Pricing, Plans and What Using It Is Like
- **Focus keyword:** hostinger review (1,000, KD 69)
- **Secondary keywords (US volume):** hostinger hosting (12,100, KD 27); hostinger reviews (1,300); hostinger review 2026 (480); hostinger wordpress hosting (3,600); hostinger hosting plans (1,300); hostinger pricing (1,000, host-owned: a section only)
- **Question headings and FAQ (volume):** Is Hostinger good for hosting? (40); How many websites can I host on the Premium plan? (30); How much is hosting on Hostinger? (30); Does the website builder include hosting? (40)
- **Entities and terms to cover:** Premium, Business and Cloud plans, hPanel, LiteSpeed, 48-month term price vs renewal, 30-day guarantee, Black Friday label
- **What changes:** Only host we can write first-hand (D-321): add a clearly labelled experience section. Label Black Friday prices. Ask Jamil before covering the website builder or Horizons.

### 5. Host page: `/bluehost-wordpress-hosting/`

- **Current SEO title:** How to Make A Website with Bluehost WordPress Hosting. **Current meta:** 143 chars.
- **Proposed SEO title (59 chars):** Bluehost Review 2026: Pricing, Renewals and WordPress Plans
- **Proposed meta (151 chars):** Bluehost review for 2026: plan prices, the renewal jump, WordPress hosting, support and who it suits, with a short guide to setting up your first site.
- **Proposed H1:** Bluehost Review 2026: Pricing, Renewals and WordPress Plans
- **Focus keyword:** bluehost review (480, KD 64)
- **Secondary keywords (US volume):** bluehost pricing (720, KD 14); bluehost reviews (590); bluehost hosting review (260); bluehost wordpress hosting (1,600); wordpress hosting on bluehost (1,300); bluehost hosting plans (1,000)
- **Question headings and FAQ (volume):** Is Bluehost a good hosting company? (30); Is Bluehost a good web host? (30); How many websites can I host on Bluehost? (20); Why does Bluehost have negative reviews?
- **Entities and terms to cover:** Starter, Choice Plus and Pro plans, free domain first year, renewal price, add-ons, WordPress.org recommended host claim (verify before use)
- **What changes:** Lead with the pricing table and renewal jump. Answer the negative reviews question fairly. Research-based label (not used first-hand).

### 6. Host page: `/cloudways-hosting/`

- **Current SEO title:** How to Make Website with Cloudways WordPress Hosting. **Current meta:** 159 chars.
- **Proposed SEO title (56 chars):** Cloudways Review 2026: Pricing, Servers and Who It Suits
- **Proposed meta (151 chars):** Cloudways review for 2026: how the cloud server plans work, what you pay, the free trial, WordPress hosting and who should choose it, with setup steps.
- **Proposed H1:** Cloudways Review 2026: Pricing, Cloud Servers and Who It Suits
- **Focus keyword:** cloudways review (590, KD 52)
- **Secondary keywords (US volume):** cloudways hosting (1,600); cloudways pricing (590, KD 56); cloudways wordpress hosting (320); cloudways wordpress hosting review 2025 or 2026 (50, KD 20); cloudways vs kinsta pricing for a small woocommerce store (40, KD 15)
- **Question headings and FAQ (volume):** What is Cloudways hosting? (20); Is Cloudways shared hosting? (20); What web hosting server does Cloudways recommend? (40)
- **Entities and terms to cover:** DigitalOcean, Vultr, Linode, Google Cloud, AWS, Flexible and Autonomous plans, 5-day and 3-day trials, pay as you go
- **What changes:** Fix the pricing section first (weak top 10). Add the Cloudways vs Kinsta WooCommerce comparison as a section. Use the official pricing page for the trial days. Research-based label.

### 7. Host page: `/kinsta-wordpress-hosting/`

- **Current SEO title:** How to Build a Website with Kinsta Hosting | Reinforce Lab. **Current meta:** 154 chars.
- **Proposed SEO title (60 chars):** Kinsta Review 2026: Pricing, Speed and Who Should Pay for It
- **Proposed meta (147 chars):** Kinsta review for 2026: plan prices, WordPress features, speed, support and who should pay for managed WordPress hosting, with a short setup guide.
- **Proposed H1:** Kinsta Review 2026: Pricing, Speed and Who Should Pay for It
- **Focus keyword:** kinsta review (720, KD 50)
- **Secondary keywords (US volume):** kinsta reviews (320); kinsta hosting review (210); kinsta wordpress hosting (480); kinsta managed wordpress hosting (210); kinsta pricing expensive (40); kinsta pricing (1,900, host-owned: a section only)
- **Question headings and FAQ (volume):** What is Kinsta hosting? (20); Is Kinsta shared hosting?; Does Kinsta support Magento or Drupal hosting?; Kinsta vs Shopify
- **Entities and terms to cover:** Google Cloud, C3D machines, staging, free migrations, plans by visits, first month free offer (ends 1 Dec 2026, official page)
- **What changes:** Lead with review, not pricing: the pricing head term belongs to Kinsta. Add a "why is Kinsta expensive" section and the first-month offer with its end date.

### 8. Host page: `/namecheap-wordpress-hosting/`

- **Current SEO title:** How to Make A Website with Namecheap WordPress Hosting. **Current meta:** 157 chars.
- **Proposed SEO title (53 chars):** Namecheap Hosting Review 2026: Shared vs EasyWP Plans
- **Proposed meta (152 chars):** Namecheap hosting review for 2026: shared hosting versus EasyWP plans, prices and renewals, WordPress support and who each plan suits, with setup steps.
- **Proposed H1:** Namecheap Hosting Review 2026: Shared Hosting vs EasyWP
- **Focus keyword:** namecheap wordpress hosting (480, KD 58)
- **Secondary keywords (US volume):** namecheap review (390); namecheap reviews (480); namecheap hosting review (210); namecheap easywp pricing official (320, KD 51); namecheap hosting plans (480); is namecheap hosting good (30)
- **Question headings and FAQ (volume):** Is Namecheap hosting good? (30); Is Namecheap hosting good for WordPress? (20); Does Namecheap host websites? (30); Does Namecheap hosting have WordPress?
- **Entities and terms to cover:** Stellar shared hosting, EasyWP Starter and Turbo, cPanel, domain registration, renewal price rises (Reddit complaints)
- **What changes:** Biggest page by impressions (45,133). Add the EasyWP section with its pricing, because easywp.com ranks position 3 for "namecheap wordpress hosting". Add a renewal table.

### 9. Host page: `/dreamhost-wordpress-hosting/`

- **Current SEO title:** How to make a website with DreamHost WordPress Hosting. **Current meta:** 152 chars.
- **Proposed SEO title (59 chars):** DreamHost Review 2026: Pricing, WordPress Plans and Verdict
- **Proposed meta (153 chars):** DreamHost review for 2026: shared and WordPress plan prices, renewals, support and who it suits, with a short guide to installing WordPress on DreamHost.
- **Proposed H1:** DreamHost Review 2026: Pricing, WordPress Plans and Verdict
- **Focus keyword:** dreamhost review (210, KD 60)
- **Secondary keywords (US volume):** dreamhost reviews (390); dreamhost hosting review (90); dreamhost wordpress hosting (210); dreamhost managed wordpress hosting (50); dreamhost pricing (480, KD 55); dreamhost dreampress review (40); dreamhost nonprofit hosting (170, KD 25)
- **Question headings and FAQ (volume):** Is DreamHost a good host? (30); Can I use WordPress plugins on DreamHost shared hosting?; How many WordPress sites does DreamHost host?; Why host WordPress on DreamHost?
- **Entities and terms to cover:** Shared Starter, Unlimited, DreamPress, nonprofit discount, 97-day guarantee (verify), renewal price
- **What changes:** Pricing term is reachable (36 domains). Add a nonprofit hosting section. Research-based label.

### 10. Host page (rewrite last): `/flywheel-wordpress-hosting/`

- **Current SEO title:** How to Make A Website with Flywheel WordPress Hosting. **Current meta:** 151 chars.
- **Proposed SEO title (53 chars):** Flywheel Review 2026: Pricing, Plans and Who It Suits
- **Proposed meta (151 chars):** Flywheel review for 2026: plans and prices, WordPress features for designers and agencies, who it suits and how to set up your first site step by step.
- **Proposed H1:** Flywheel Review 2026: Pricing, Plans and Who It Suits
- **Focus keyword:** flywheel hosting (1,000, KD 43)
- **Secondary keywords (US volume):** flywheel review (110, KD 29); flywheel hosting review (110); flywheel reviews (90); flywheel pricing (110, KD 16); flywheel web hosting (260); flywheel website hosting (170); flywheel wordpress hosting (70)
- **Question headings and FAQ (volume):** What is Flywheel hosting? (20); Can I install premium plugins in Flywheel hosting?; Can I put multiple websites on one Flywheel account?; Does Flywheel hosting have caching?
- **Entities and terms to cover:** WP Engine ownership, Local by Flywheel (separate free tool), agency and designer features, caching, staging, plans by sites and visits
- **What changes:** Holds position 1 for "flywheel hosting" today. Keep the ranking headings and steps, add review sections around them, rewrite last, watch Search Console for two weeks. Add one line separating Local by Flywheel from hosting.

### 11. Host page: `/a2-wordpress-hosting/`

- **Current SEO title:** How to Build a Website with A2 Hosting (hosting.com). **Current meta:** 144 chars.
- **Proposed SEO title (48 chars):** A2 Hosting Review 2026: Now hosting.com, Pricing
- **Proposed meta (146 chars):** A2 Hosting review for 2026: A2 is now hosting.com. See plan prices, the renewal jump, WordPress plans, support and who it suits, plus setup steps.
- **Proposed H1:** A2 Hosting Review 2026: Now hosting.com, Pricing and Renewals
- **Focus keyword:** a2 hosting review (260, KD 50; SERP not checked)
- **Secondary keywords (US volume):** a2 hosting pricing (70, KD 43); a2 hosting wordpress (40); is a2 hosting good (40, KD 47); what is a2 hosting (40, KD 17); hosting.com review
- **Question headings and FAQ (volume):** Is A2 Hosting good? (40); What is A2 Hosting? (40); How to cancel A2 Hosting? (20)
- **Entities and terms to cover:** World Host Group acquisition (Jan 2025), hosting.com rebrand (Apr to May 2025), Shared Starter renewal 9.4 times, 30-day guarantee, migration fees not refundable
- **What changes:** Open with the rebrand (readers search the old name). Renewal price rise is the theme. Needs the A2 review SERP screenshot before writing.

### 12. Host page: `/nexcess-wordpress-hosting/`

- **Current SEO title:** How to Make A Website with Nexcess Wordpress Hosting. **Current meta:** 149 chars.
- **Proposed SEO title (54 chars):** Nexcess Review 2026: Now Liquid Web, Plans and Pricing
- **Proposed meta (158 chars):** Nexcess review for 2026: Nexcess is now part of Liquid Web. See plans, prices, what each plan includes, WordPress features and who it suits, with setup steps.
- **Proposed H1:** Nexcess Review 2026: Now Part of Liquid Web, Plans and Pricing
- **Focus keyword:** nexcess review (140, KD 32)
- **Secondary keywords (US volume):** nexcess hosting (210, KD 15); nexcess reviews (70); nexcess hosting reviews (50); nexcess wordpress hosting (50); nexcess magento hosting (110, KD 20); nexcess web hosting (140)
- **Question headings and FAQ (volume):** What resources are included with Nexcess hosting plans?; Does Nexcess offer WooCommerce hosting?; What kind of cloud hosting does Nexcess offer?
- **Entities and terms to cover:** Liquid Web by Nexcess (April 2026, say "April 2026"), nexcess.net redirect to liquidweb.com (7 Oct 2025), Pro and Elite plans, email hosting (verify), Monarx
- **What changes:** Small family (about 500 a month, low difficulty). Open with the brand status. Verify email inclusion before stating it.

## 5. Checks before any page goes live

1. Jamil approves the page (title, meta, outline) after a `preview-post` render.
2. All prices, renewals and offer end dates re-read on the official page the day it is written; end dates written as dates.
3. `serp-semantics.py` run on the top 10 for the focus keyword, then again on the draft. The reports go in `claude/research/serp/<slug>/`.
4. Gates in section 2 pass. Post date is not changed; only the modified date moves (F-003).
5. Search Console watched for two weeks after each page. Flywheel and Namecheap first, because they hold the most impressions.

## 6. Gaps (not validated)

1. **Search Console queries per page.** The export has page totals only. The queries each URL earns today are unknown, so I cannot yet say which current headings carry rankings. Needed before Flywheel and Namecheap.
2. **A2 hosting review SERP** is missing (CSV row only).
3. **Facts marked "verify"** (Bluehost WordPress.org claim, DreamHost guarantee length, Nexcess email inclusion) are not confirmed; I will check them on the official pages before writing each page.
4. **Meta and title click rates are unknown.** Positions are 15 to 40 today, so these changes are expected to help relevance, not to guarantee clicks. That is INFERENCE.
