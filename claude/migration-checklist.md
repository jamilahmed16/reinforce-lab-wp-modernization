# Migration checklist: reinforcelab.online replaces reinforcelab.com

Approach approved by Jamil on 7 October 2026 (D-144): **one switch**. The new pages, plus the kept production posts copied across unchanged (same URLs, original dates, new design), go live together; posts are rewritten one at a time after launch.

Status keys: `[ ]` open · `[x]` done · **(Jamil)** needs Jamil · **(gate)** the switch does not happen until this passes.

Nothing on reinforcelab.com changes until the switch itself (Rules 1 and 2). Every step before the switch happens on `.online` or in this repository.

---

## Part A: must be done BEFORE the switch

### A1. Data and decisions (Jamil)

- [ ] **Backlink export, page by page** (Semrush: Backlinks, export by target URL). Every URL with a backlink must resolve to a live page. **(Jamil)**
- [x] **The 20 "HUB-REVIEW" posts** are affiliate reviews, already decided in D-014b (10 Sep): keep all at their URLs under a `/reviews/` hub. Figures and flags: `claude/research/review-posts-proposal-2026-10-07.md`. The 3 weakest (WP Engine partner landing page, Beaver Builder review, Bluehost) stay for now and are redirected later (Jamil).
- [ ] **The store.** `/shop/` is planned PRESERVE and 8 product pages CONSOLIDATE, and production holds real customer and order data. Decide: does the store continue on the new site? If yes, customer and order data must be moved safely (never a database clone), and the payment provider must be named in the Privacy Policy. **(Jamil)**
- [x] **Bylines** (D-145): Jamil will rewrite every old post with new content and images, and each rewritten post carries his name. Titles may change in a rewrite; the URL (slug) stays unless a change is approved for that URL, with a 301.
- [x] The 14 open redirect decisions (D-146); the draft map has 0 undecided URLs.
- [ ] **URL-by-URL sign-off of the final redirect map** (all 631 unique pages, plus anything the backlink export adds). The September dispositions are a plan; Rule 2 needs approval per URL, given on the final map file. **(Jamil)**
- [x] Search Console pages, queries and indexing export (10 Sep). GA4 screenshots. WPCode inventory (F-014).
- [x] Author archives: all 16 production author URLs 301 to `/blog/` (D-139, D-144; supersedes the September plan of `/our-team` and 410).

### A2. Read-only inventory of production (needs Jamil's OK to fetch, no changes)

- [x] Fetch production's sitemaps and crawl its internal links (plain GET from the `.online` server, read-only), so the URL list also contains every URL production itself links to.
- [x] Production's Yoast redirects (already exported: `claude/data/production-config/yoast-redirects-2026-09-10.csv`) folded into the map, pointed straight at final targets (no chains).
- [ ] Production media used by kept posts: list of `/wp-content/uploads/...` files to copy, at the same paths.

### A3. Carry the kept posts across (`.online`)

What stays exactly the same: URL (slug), title, the words of the post, images (same file paths), publish date, category, Yoast title and meta description.

What changes, and why:
- **Design:** the new post template.
- **Links inside the text** that point to a URL being redirected or retired are pointed straight at the final page, so no visitor or crawler hits a redirect or a dead end. Wording is not touched.
- **3 posts built with Beaver Builder** become plain content (words and images the same).
- **Old Divi and Monarch leftovers** (about 650 metadata fields) are not copied.
- **Modified date:** set to production's value, so nothing looks freshly edited in bulk (F-003).
- **Author (D-145):** Jamil Ahmed on every post once he has rewritten it. A post carried across before its rewrite shows "Reinforce Lab team" until then (confirmed). Reviews under his name must be first-hand (product actually used, test dates, paid or not, affiliate relationship stated).

Tasks:
- [ ] Copy the kept posts (PRESERVE, PRESERVE+REBUILD, PRESERVE-URL+REWRITE, plus HUB-REVIEW posts kept) with the rules above. One controlled import, no new publishing; recorded as the agreed exception to F-003.
- [ ] Posts planned **REBUILD-new** (23): carried across as they are until each rewrite, or redirected now, per the map. **(Jamil decides with the map)**
- [ ] Every **301 and CONSOLIDATE target** exists and returns 200 before the switch.
- [ ] **Build the `/reviews/` hub** and its two pillars `/reviews/best-wordpress-hosting/` and `/reviews/best-seo-ai-tools/` (approved new URLs, D-016), so the 20 reviews are linked from the site.
- [ ] Copy the media files the kept posts use.
- [ ] Every carried post passes: copy check on new text only (old wording is not rewritten before launch), schema valid, images load, no layout overflow on phone.

### A4. Redirect map in code and the zero-failure test (gate)

- [ ] All approved 301s, 410s and merges implemented in code on `.online` (one source file, versioned in git).
- [ ] **Redirect test over every known old URL**: the 793-row register, Search Console's 425 pages and link targets, the backlink export, production's sitemaps and internal links, and the Yoast redirects. For each URL it checks: final status as approved (200, 301 to target, or 410), final URL equals the approved target, **at most one redirect hop**, no loops, the target is indexable with a self-canonical, query-string and trailing-slash variants behave the same. **Pass mark: 0 failures.** **(gate)**
- [ ] **Internal link scan** of every page and post on `.online`: 0 links to a 404, 410 or redirect; 0 links to `reinforcelab.online` (all switch to the live domain). **(gate)**
- [ ] Every URL a backlink points to resolves to a 200 page (directly or by one 301). **(gate)**

Note on "100% accuracy": the redirect test guarantees 100% for every URL that appears in any of the sources above. A URL that exists nowhere in our data (for example an old link on a third-party site that no export shows) can only be caught after launch, by watching the 404 log (B2).

### A5. Pages and site quality (mostly done)

- [x] All built pages pass the SEO/GEO/AEO standard; accessibility (axe) at 0; type scale, buttons, contrast, zero radius, 404 and search pages, consent bar (D-135 to D-143).
- [ ] **Page parity for the 17 pages kept at the same URL** (Home, Website Maintenance, 15 posts): each one is live on the new site at exactly the same address, returns 200, and still answers what people searched for to find it (topic and main sections kept, nothing that ranks dropped), so Google sees the same page continuing. Checked one by one before the switch. **(gate)**
- [x] Favicon and site icon (D-147). At the switch, copy the root `favicon.ico` and the site icon attachment with the rest.
- [ ] SMTP mailbox login for form email (code ready, O-027). **(Jamil)**
- [ ] GA4 measurement ID, retention 14 months (consent bar ready). **(Jamil)**
- [ ] VAT/BIN number on Terms and Privacy. **(Jamil)**
- [ ] Affiliate link formats (Semrush, WP Engine) checked. **(Jamil)**
- [ ] AI-crawler policy in robots.txt agreed.

### A6. The switch itself (runbook, gate)

- [ ] Fresh full backup of production (files and database) immediately before; rollback steps written and tested.
- [ ] **Novamira plugins and AI Abilities removed** from the copy that becomes production (Rule 1). **(gate)**
- [ ] Turn indexing on: WordPress "discourage search engines" off, `wp-content/uploads/.htaccess` noindex header **not** copied, canonical tags present (they are off only because `.online` is noindex).
- [ ] Domain switch to `https://reinforcelab.com` (search-replace of the domain in content and settings), SSL valid, `http` and `www` redirect to the main address in one hop.
- [ ] Security headers on the live server (HSTS, nosniff, referrer policy, frame protection), version numbers hidden.
- [ ] Re-run the A4 redirect test against the live domain within the first hour: 0 failures, or roll back. **(gate)**
- [ ] Submit the XML sitemap in Search Console; request indexing for Home and the main service pages.

---

## Part B: can be done AFTER the switch

### B1. Content, one at a time (F-003 pace)

- Rewrite carried posts to the blog rules (grade 8, top-10 competitor analysis), highest-value first by Search Console data.
- Write the REBUILD-new posts and the approved new posts (citation analysis, SEO consulting and AI, AI SEO pricing).
- Case study or first-hand result for the AI Search Optimization page; founder headshot for author boxes and About.
- Share images for the main service pages (as done for AI Search Optimization).

### B2. Monitoring (weekly for at least 6 weeks, then monthly)

- Search Console: pages indexed, crawl errors, 404s, clicks and impressions against the baseline.
- Server 404 log: any old URL that appears and is not in the map gets an approved redirect.
- Re-run the link scan after every content change.
- Keep redirects in place for at least 12 months; review hits before removing any.

### B3. Improvements that do not affect URLs

- Remove unused theme scripts on shortcode pages (about 63 KB) and test the phone menu.
- Convert client logos to WebP.
- Leftover minor items from the audit (P3).

---

## Order of work from here

1. Proposal for the 20 undecided posts (me) and your decisions on them, the store and bylines (Jamil).
2. Backlink export (Jamil).
3. Read-only production inventory (me, after your OK).
4. Final redirect map file for URL-by-URL sign-off (me, then Jamil).
5. Carry the kept posts across and implement the map in code (me).
6. Redirect test and link scan to 0 failures (me).
7. Launch inputs (Jamil) and the switch (together, on an agreed date).
