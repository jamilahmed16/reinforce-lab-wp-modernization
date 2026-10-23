# Migration checklist: reinforcelab.online replaces reinforcelab.com

Approach approved by Jamil on 7 October 2026 (D-144): **one switch**. The new pages, plus the kept production posts copied across unchanged (same URLs, original dates, new design), go live together; posts are rewritten one at a time after launch.

Status keys: `[ ]` open · `[x]` done · **(Jamil)** needs Jamil · **(gate)** the switch does not happen until this passes.

Nothing on reinforcelab.com changes until the switch itself (Rules 1 and 2). Every step before the switch happens on `.online` or in this repository.

---

## Launch plan changed 18 Oct 2026: clean rebuild (F-033, F-035)

Both sites share one Hostinger account and both are compromised. Nothing is copied from the old servers as files. The new site is a **fresh WordPress on new hosting**: our code from git, plugins and theme fresh from the vendors, content and settings imported as data (`claude/data/site-export/`), media images and PDFs only, each checked. Jamil approved 18 Oct ("Yes I you can start"; `jadirectives@gmail.com` confirmed as his; `.com` and `.online` on the same account).

- [ ] **Step 1 (Jamil and Hostinger):** security ticket for the account (how they got in); every password changed (hosting, Titan mailbox, WordPress, database, FTP, registrar) with two-factor; full offline backups of both sites kept as evidence; WooCommerce orders and Semrush backlinks exported; new hosting chosen (new account, not the compromised one). **(Jamil)**
- [x] **Step 2.1:** everything built on `.online` exported as data only, scanned (0 risky fields), 2,318 media files listed with checksums (18 Oct).
- [ ] **Step 2.2:** redirect map in code and the redirect test (A4).
- [ ] **Step 2.3:** rebuild script: fresh WordPress + vendor plugins + our code from git + data import + media download with signature and checksum checks.
- [ ] **Step 3:** run the rebuild on the new hosting (noindex staging address), then every check: parity, axe, link scan, redirect test, speed. **(gate)**
- [ ] **Step 4:** the switch (A6), on the new hosting only; the old account stays offline 30 days as evidence, then is closed.

---

## Part A: must be done BEFORE the switch

### A1. Data and decisions (Jamil)

- [ ] **Backlink export, page by page** (Semrush: Backlinks, export by target URL). Every URL with a backlink must resolve to a live page. **(Jamil)**
- [x] **The 20 "HUB-REVIEW" posts** are affiliate reviews, already decided in D-014b (10 Sep): keep all at their URLs under a `/reviews/` hub. Figures and flags: `claude/research/review-posts-proposal-2026-10-07.md`. The 3 weakest (WP Engine partner landing page, Beaver Builder review, Bluehost) stay for now and are redirected later (Jamil).
- [x] **The store** is closed (D-148): shop, cart and product addresses redirect; customer data is not moved. **(Jamil)** export past orders from production's WooCommerce admin before the switch.
- [x] **Bylines** (D-145): Jamil will rewrite every old post with new content and images, and each rewritten post carries his name. Titles may change in a rewrite; the URL (slug) stays unless a change is approved for that URL, with a 301.
- [x] The 14 open redirect decisions (D-146); the draft map has 0 undecided URLs.
- [x] **Sign-off of the redirect map** (approved 13 Oct, D-181) with the 241-line list `claude/redirect-signoff-list.md` (D-149); the rest approved as one group by rule. Was: URL-by-URL sign-off of the final redirect map** (all 631 unique pages, plus anything the backlink export adds). The September dispositions are a plan; Rule 2 needs approval per URL, given on the final map file. **(Jamil)**
- [x] Search Console pages, queries and indexing export (10 Sep). GA4 screenshots. WPCode inventory (F-014).
- [x] Author archives: all 16 production author URLs 301 to `/blog/` (D-139, D-144; supersedes the September plan of `/our-team` and 410).

### A2. Read-only inventory of production (needs Jamil's OK to fetch, no changes)

- [x] Fetch production's sitemaps and crawl its internal links (plain GET from the `.online` server, read-only), so the URL list also contains every URL production itself links to.
- [x] Production's Yoast redirects (already exported: `claude/data/production-config/yoast-redirects-2026-09-10.csv`) folded into the map, pointed straight at final targets (no chains).
- [x] Production media used by kept posts: list of `/wp-content/uploads/...` files to copy, at the same paths. (D-178)

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
- [x] Copy the kept posts (PRESERVE, PRESERVE+REBUILD, PRESERVE-URL+REWRITE, plus HUB-REVIEW posts kept) with the rules above. One controlled import, no new publishing; recorded as the agreed exception to F-003. **Done 12 Oct (D-178): 80 posts.** Their internal links still point at the old URLs until the redirect sign-off; then they are pointed at final pages.
- [ ] Posts planned **REBUILD-new** (23): carried across as they are until each rewrite, or redirected now, per the map. **(Jamil decides with the map)**
- [ ] Every **301 and CONSOLIDATE target** exists and returns 200 before the switch.
- [x] **Build the `/reviews/` hub** and its two pillars `/reviews/best-wordpress-hosting/` and `/reviews/best-seo-ai-tools/` (approved new URLs, D-016), so the 20 reviews are linked from the site. Done 14 Oct (D-191): all 19 posts and the WP Engine page linked; no rankings until the first-hand rewrites.
- [x] Copy the media files the kept posts use. **Done 12 Oct (D-178): 2,029 files at the same paths.**
- [ ] Every carried post passes: copy check on new text only (old wording is not rewritten before launch), schema valid, images load, no layout overflow on phone.

### A4. Redirect map in code and the zero-failure test (gate)

- [x] All approved 301s, 410s and merges implemented in code on `.online` (one source file, versioned in git). `claude/data/redirect-map-draft.csv` builds `core/reinforce-redirects-map.php` (D-214).
- [ ] **Redirect test over every known old URL**: the 793-row register, Search Console's 425 pages and link targets, the backlink export, production's sitemaps and internal links, and the Yoast redirects. For each URL it checks: final status as approved (200, 301 to target, or 410), final URL equals the approved target, **at most one redirect hop**, no loops, the target is indexable with a self-canonical, query-string and trailing-slash variants behave the same. **Pass mark: 0 failures.** **(gate)** 23 Oct on `.online`: 2,103 requests over 803 addresses, 0 failures (D-214). Re-run on staging and in the first hour after the switch; the 39 old `/wp-content/` files need the server 410 rule from the rebuild.
- [ ] **Internal link scan** of every page and post on `.online`: 0 links to a 404, 410 or redirect; 0 links to `reinforcelab.online` (all switch to the live domain). **(gate)** 23 Oct: our pages and templates 0; 226 links inside 73 old carried posts wait on Jamil (F-049).
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
- [x] AI-crawler policy agreed: all AI crawlers allowed (D-150); robots.txt for launch in `claude/data/robots-launch.txt`.

### A6. The switch itself (runbook, gate)

- [ ] Fresh full backup of production (files and database) immediately before; rollback steps written and tested.
- [ ] **Novamira plugins and AI Abilities removed** from the copy that becomes production (Rule 1). **(gate)**
- [ ] Turn indexing on: WordPress "discourage search engines" off, `wp-content/uploads/.htaccess` noindex header **not** copied, canonical tags present (they are off only because `.online` is noindex).
- [ ] Domain switch to `https://reinforcelab.com` (search-replace of the domain in content and settings), SSL valid, `http` and `www` redirect to the main address in one hop.
- [ ] LiteSpeed Cache on the live site with the `.online` settings (D-167: page cache only, optimisations off, form pages uncached); purge after the switch.
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
- **Remind Jamil (23 Oct): set up promotion.** Merge the build branch into `main` with a pull request, then start a new Claude Code session for promotion only, recording in `claude/marketing/log.md` (M-numbers), not touching `wp/` or the decision log.
- **Remind Jamil: redesign the company profile PDF** (Jamil, 14 Oct 2026: "after we migrate the website to .com we will redesign the company profile, remind after migration"). The current one (D-187) stays at `/wp-content/uploads/2022/03/Reinforce-Lab-Company-Profile.pdf` until then; source in `claude/content/company-profile/`.

---

## Order of work from here

1. Proposal for the 20 undecided posts (me) and your decisions on them, the store and bylines (Jamil).
2. Backlink export (Jamil).
3. Read-only production inventory (me, after your OK).
4. Final redirect map file for URL-by-URL sign-off (me, then Jamil).
5. Carry the kept posts across and implement the map in code (me).
6. Redirect test and link scan to 0 failures (me).
7. Launch inputs (Jamil) and the switch (together, on an agreed date).
