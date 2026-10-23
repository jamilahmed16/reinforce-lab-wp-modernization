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
| D-177 | Layout shift after the lean pages: header no longer paints half-built (`rel=expect` render block until the header is parsed; menu widened 234 to 706 px mid-load, 0.011); font stand-ins tuned on measured line breaks across 57 pages and 14 real device setups (Oswald 500 to 600 at 73.4%, Plex Sans at 99.7%; the other two already best). Residual: on a first visit where a web font arrives after the first paint, some lines can still re-wrap (Lighthouse up to 0.03 to 0.05 on two pages, most pages 0 to 0.004). Jamil's rule recorded: never suggest other fonts | 12 Oct | DONE (Jamil: "A ..never suggest any other fonts") | `core/reinforce-header.php`, `core/reinforce-fonts.css` |
| F-038 | Hero drawings break the 12px rule on every page that has one (about 25 service and industry pages, D-139): the text inside the drawings shows at 7.8 to 9.5px on a 1440 screen, about 5px on a 1024 tablet (two-column hero), about 7px at 600 wide. The phone version (under 560px) is readable HTML and passes. Earlier audits (D-138, D-140) measured HTML text only and missed text inside drawings | 20 Oct | `[VERIFIED]` measured; fix waits for Jamil | this file |
| F-047 | Production Plugins screen (Jamil's screenshot, 22 Oct): WordPress 7.1.3 (current); 26 plugins, 24 active; WP File Manager removed; WooCommerce 11.2.1. Must-Use 2 (Hostinger), Drop-in 1 (LiteSpeed object cache). Licences expired, so updates blocked: Beaver Builder Pro 2.9.4.1 (2.11.1.2 out), Beaver Themer 1.5.2.1 (1.6.1 out), Yoast SEO Premium 28.4 (28.7 out). "Reinforce Lab Builder" 1.37.8 is Ultimate Addons for Beaver Builder white-labelled (`bb-ultimate-addon`); Jamil confirmed 23 Oct he white-labelled it. Inactive: PDF Invoices & Packing Slips, StackWC Order Notification. Plugin File Editor menu visible (no `DISALLOW_FILE_EDIT`). The same paid licences are needed for the new site at launch | 22 Oct | `[VERIFIED]` from screenshot | this file |
| F-046 | Production `wp-content/mu-plugins/` (Jamil's screenshot, 22 Oct): only `hostinger-auto-updates.php` (10.8 KiB) and `hostinger-preview-domain.php` (29.29 KiB), the same sizes as Hostinger's copies on `.online` (11,055 and 29,989 bytes). No `health-check-api.php`. Clean | 22 Oct | `[VERIFIED]` | this file |
| F-045 | **Fake plugin removed from production (22 Oct, Jamil).** `wp-content/plugins/lunar-profiler-ink/` now answers 404 like a missing folder (was 403). Jamil also removed `cartflows-pro`, `custom-post-type-ui` and `woocommerce-checkout-manager`. Home still 200 and full. Still open: `wp-file-manager` (200), `mu-plugins` contents (changed 22 Oct), top of `wp-config.php`, admin users, WPCode snippets, cron, Search Console live test | 22 Oct | `[VERIFIED]` read-only | this file |
| D-217 | **Rebuild script written and tested locally (Step 2.3, 23 Oct; Jamil: "Go, start the rebuild script").** `claude/rebuild/`: `rebuild.sh` (fresh WordPress 7.1.3 and free plugins from wordpress.org with checksums; Beaver Builder Pro, Themer, PowerPack, ACF PRO, Yoast Premium and the theme from Jamil's vendor zips, sha256 logged; our code from git loaded by a must-use plugin, **no Novamira**; data import; site address swap; media; `.htaccess` 410s; checks), `import.php` (same IDs; refuses unless the install is fresh), `media.php` (each file matched to sha1 and file type), `plugins.json` (never: Novamira, WooCommerce, WP File Manager, WPCode). `redirects.py htaccess` writes the 410 rules for 75 old file paths (only when the file is missing). `link-scan.py` now scans any copy through its sitemaps. Export refreshed from `.online` (2,343 media files, 0 risky fields). Local test on a throwaway WordPress with SQLite (wordpress.org is blocked from the sandbox): 387 records, 27 terms, 266 settings, 3 users imported with the same IDs; second run refused; 30 media files matched; pages served through our code; redirect test passed except what needs Yoast or `.htaccess` (not installable there). First full run needs the new hosting, an empty database and the 6 vendor zips (Jamil) | 23 Oct | DONE (local test); full run waits on Jamil | `claude/rebuild/README.md` |
| D-216 | **Links inside the old posts fixed; blog topic row trimmed (23 Oct).** Jamil: "1 yes, 2 hide". (1) New `claude/tools/fix-post-links.py`: 226 links in 73 carried posts, one post at a time, each backed up first (`_backups/post-links-20261023/`): links to a redirect now point straight at the page they end on (checked 200), links to a removed (410) page are unlinked with their words kept. Words checked identical in all 73 (tags stripped, before and after); post dates unchanged; every page 200. Log `claude/research/link-scan/fixes-2026-10-23.json`. (2) Blog topic row lists only topics whose archive still exists (today: All, Digital Marketing); topics can return later as real topic pages. Link scan after: 148 pages, 572 targets, **3 bad links left**, all to 3 approved posts not written yet (`/off-page-seo-checklist/`, `/generate-leads-for-business/`, `/video-seo/`, part of the rebuild-posts decision); they turn green when the posts are published, or get unlinked before launch | 23 Oct | DONE (Jamil, 23 Oct) | `claude/tools/fix-post-links.py`, `blog/reinforce-blog.php`, `core/reinforce-redirects.php` |
| D-215 | `/project/inpace/` and `/project/inpace-a-project-of-reinforce-lab/` 301 to `/portfolio/`, the same as MRCO and MicroInspire (Jamil, 23 Oct: "send it to /portfolio/ ... Okay"). Production answered 404 there; 0 clicks, 0 impressions, 0 backlinks | 23 Oct | DONE | `claude/data/redirect-map-draft.csv` |
| F-049 | **A4 internal link scan, first run (23 Oct).** New `claude/tools/link-scan.py`: 148 published pages, posts and projects plus the blog pages, 634 internal link targets, each requested once without following redirects. Run 1: 79 bad targets. Fixed: (1) category links in our templates (blog topic chips, post kickers, breadcrumbs) went through a redirect; one filter in `core/reinforce-redirects.php` now points each retired category straight to its approved target (Yoast strips the category base later, so the filter reads the path first); (2) post 330 (our own) had 4 links and 2 fields written as `https://reinforcelab.online/...`, now site-relative, date unchanged, backup `_backups/post330-20261023-103948`. Run 2: **0 bad links from our pages and templates; 0 dev-domain links in content; 0 full `reinforcelab.com` links.** Left: 65 bad targets (52 redirect, 10 gone, 3 not yet published), 226 links in all, all inside the words of the old posts carried from production (D-178). Fixing them edits about 73 old posts, which D-178 ("structure only") and F-003 (no mass modification) say needs Jamil's decision. Also for Jamil: most blog topic chips now lead off the blog (Search Engine Optimization to the SEO service page, Business and Content Marketing back to /blog/), because those archives were approved to redirect; hiding them leaves only All and Digital Marketing, so the row is unchanged until Jamil decides. Results: `claude/research/link-scan/`. Both decided in D-216 | 23 Oct | DONE (D-216) | `claude/tools/link-scan.py` |
| D-214 | **A4 redirects finished on .online: 0 failures (23 Oct).** Jamil's answers: `/get-a-free-quote/` 301 to `/search-authority-diagnostic/` ("Free diagnostic"); 9 category page-2 addresses go to page 1 ("Go to page 1"), one hop to where page 1 already goes; `/project/microinspire-a-project-of-reinforce-lab/` and `/project/mrco-international-a-project-of-reinforce-lab/` 301 to `/portfolio/` ("Old projects mrco and microinspire 301 to portfolio"); `/logossliderwp/features-logo/` and `/google-analytics-behavior-reports-2/` 410 ("Yes, 410"). InPace: "Inpace and Inpace shop are different projects", so `/project/inpace/` no longer jumps to `/portfolio/inpace-shop/` (that was WordPress guessing a nearby page). Production answers 404 there (checked read-only 23 Oct), so it stays 404 (no change) until Jamil names a page; the same applies to the other 5 kept addresses production answers 404 (3 future posts, 2 new service pages that already answer 200). Also: missed post `/social-media-content-ideas-for-restaurants/` carried as in D-178 (post 510, 24 images, noindex); client logo `Beyond-Borders-client-of-reinforce-lab-limited.png` copied; closed shop's `/product-sitemap.xml` and `/wp-json/wc/...` routes answer 410. Test: 2,103 requests over 803 old addresses, **0 failures**. Left for the server rule in the rebuild: 39 old `/wp-content/` files answer 404 instead of 410 (WordPress never sees them). Still open in A4: internal link scan; backlink targets (Semrush export from Jamil) | 23 Oct | DONE (Jamil, 23 Oct, 4 answers) | `core/reinforce-redirects.php`, `claude/data/redirect-map-draft.csv`, `claude/research/redirect-test/` |
| F-048 | **A4 redirect test, first runs (23 Oct).** New `core/reinforce-redirects.php` + generated `core/reinforce-redirects-map.php` (`claude/tools/redirects.py`, 135 x 301 straight to final page, 133 x 410; chains flattened) and `claude/tools/redirect-test.py` (every map row, plus no-slash and query variants). Run 1: 162 failures; fixed in code (junk `/paged-N/` and `?wc-ajax=` 410 at the earliest hook; approved removals no longer get WordPress's guessed redirect; feeds), in the test (query variants follow their path, D-148; 32 old images kept on purpose, D-178), and in two map rows that follow earlier approvals (`/services/pharmaceutical-seo/` 301 to `/industries/pharmaceutical/`, D-022/D-067; one address pointing at an approved 410 now 410). Run 2: 65 failures on 23 addresses, all listed for Jamil (4 decisions) or for the rebuild (server rules for 40 missing old images, `/product-sitemap.xml`, `/wp-json/wc/store/v1/cart/`; copy one client logo) or for me (carry the missed post `/social-media-content-ideas-for-restaurants/`, live on production with a backlink). Results: `claude/research/redirect-test/`. Run 3 after D-214: 0 failures | 23 Oct | DONE (D-214) | this file |
| D-213 | Jamil removed production users `sabera` and `farihaanika` on purpose (22 Oct, "Yes"). Their author archives `/author/sabera/` and `/author/farihaanika/` now 404, in line with retiring author archives on the new site. Yoast's author sitemap still lists them until it refreshes (resaving Permalinks forces it). URL Decision Register: record both as removed by Jamil | 22 Oct | DECIDED | this file |
| F-044 | Jamil's File Manager screenshot of production `wp-content/plugins/` (22 Oct): 33 folders, no `core-plugin`, none of the other `.online` attacker names. `lunar-profiler-ink` still there and **modified 15 hours ago** (after the clean-up began), `wp-file-manager` still there: both to delete. New: **All-In-One WP Security & Firewall** installed about an hour before; its "block fake Googlebots" feature most likely explains F-043's empty pages for our spoofed Googlebot (inference, Search Console live test still asked for). `hostinger-ai-assistant` re-added by Hostinger's AI (official plugin). Possibly unused plugins listed for Jamil to confirm | 22 Oct | `[VERIFIED]` from screenshot; deletions are Jamil's | this file |
| F-043 | **Production re-scan 22 Oct, after Jamil's clean-up.** Pages: 0 with spam or hidden links (193 addresses). Plugins updated (WooCommerce 11.2.0, Yoast 28.7, WPCode 2.4.0, Site Kit, All-in-One, PayPal, LiteSpeed now current); WP File Manager updated to 8.0.5 but not removed; fake `lunar-profiler-ink` folder still present. **New since 21 Oct: the site is served through Hostinger's CDN (`server: hcdn`), and a request naming itself `Googlebot/2.1` (desktop and smartphone) gets 200 with an empty page,** while browser, Bingbot, Google-InspectionTool, AdsBot-Google, Applebot, DuckDuckBot, PerplexityBot, ClaudeBot, OAI-SearchBot and ChatGPT-User get the full page; **GPTBot gets 429.** Likely the CDN's fake-Googlebot check (our request comes from a Hostinger address, not Google's) plus an AI-bot block; not provable from outside. Must be confirmed with Search Console URL Inspection (Test live URL). Also: `/author/sabera/` and `/author/farihaanika/` now 404 but stay in the author sitemap. robots.txt unchanged | 22 Oct | `[VERIFIED]` read-only; for Jamil, urgent check | this file |
| D-212 | Home page GoodFirms research partner badge now links to `https://www.goodfirms.co/resources/ai-adoption-statistics` (Jamil, 22 Oct; was the app development trends article). Opens in a new tab, `rel="noopener"`. Live on `.online` | 22 Oct | DONE | this file |
| F-042 | **Full outside scan of production (21 Oct, `claude/tools/prod-scan.py`, read-only GETs from `.online`).** All 193 sitemap addresses (plus a Googlebot copy of every fifth): 0 pages with spam, hidden or off-screen links, meta refresh or suspicious inline script; no cloaking; outside scripts only Google Tag Manager and google.com; all 200 except `/checkout/` (302 to cart, normal). First pass flagged every page; checked by hand, all false alarms ("cialis" inside "specialists", theme screen-reader and menu CSS, EWWW and LiteSpeed loaders), rules tightened and the full scan re-run. Still present: fake plugin folder `lunar-profiler-ink` (F-041). 15 plugins found, all slightly out of date; WP File Manager 8.0.4 installed (attack tool if an account is taken, not needed); WPCode installed (the old spam sat in the footer, its snippets need checking); `core-plugin` hidden behind the firewall, unknown. Backup and secret files refused by the server. Admin accounts, files outside pages and the database cannot be seen from outside. Steps for Jamil: `claude/production-cleanup-guide.md`. Results: `claude/research/prod-scan/2026-10-21/` | 21 Oct | `[VERIFIED]` read-only; production untouched | this file |
| F-041 | **Production check after Jamil's clean-up (21 Oct, read-only GETs from the `.online` server; the container itself is blocked from `.com`).** The F-033 spam block is gone: 0 spam domains, 0 off-screen blocks, 0 hidden sponsored links on 7 pages (home, about, contact, blog, services, shop, WP Engine page), identical for a browser and for Googlebot; all 200, titles normal. Still there: `/wp-content/plugins/lunar-profiler-ink/` answers 403 like the real WooCommerce folder (missing folders answer 404), so the fake plugin folder from F-035 still exists on `.com`. Other known paths (health-check-api mu-plugin, nimble-router-mod, onyx-store-tag, pulse-cache-ink, event, wise-news, cache/2704f406.php, the uploads zip, wp-includes/class-wp-cache.php) answer 404. Public author list: jamilahmed, sabera, farihaanika, catherine (only authors with posts show; hidden admins cannot be seen from outside). Production untouched | 21 Oct | `[VERIFIED]` read-only; for Jamil | this file |
| D-211 | **Hero drawing animation check, all 33 pages (Jamil: "is animation working for every page ... fix any that aren't").** Checked at 1440 and 390: running animations inside each drawing, and screenshots compared across a full 12 s loop. 65 of 66 views moved. The one that did not: AI Growth Systems on desktop, which had been built as a still drawing (no animation code). Added the same 10 s pattern as the other pages: layers light top to bottom, links pulse, a red pulse runs the loop line, the three outcomes light, the approval line brightens, soft reset. Overlays start invisible, so the still drawing shows when motion is turned off; also applied to the article copy `[reinforce_ag_layers]`. Re-test: moves | 20 Oct | DONE | this file |
| D-210 | **F-038 closed (Jamil: "all 19").** Drawing text raised to 12.5 units (14.6 on the wider Search Authority OS drawing) on the remaining pages, then every drawing captured and checked by eye; 10 needed layout fixes (long industry labels wrap onto two lines in taller boxes, loop and agent labels re-spaced, wider boxes on Marketing Automation, Local SEO checks moved under the results, Audit effort bars moved, Enterprise label right-aligned, normal letter spacing where text touched edges). Final measurement at 1440 on all 32 pages with a drawing: 13.8 to 13.9px (was 7.8 to 10). Tablet and phone show the readable version. Home left as is (D-205) | 20 Oct | DONE | this file |
| D-209 | Step cards fill the row (Jamil's screenshot of AI Growth Systems: 4 cards left a gap on the right). `core/reinforce-kit.css` reserved 5 columns for every `.steps` list; on desktop (over 1000px) a list with 2, 3 or 4 steps now gets one equal column per step. Checked: AI Growth Systems, Industries hub, Search Authority OS (4), Contact (3), Technical SEO (5, unchanged) at 1440 and 1024: no gap; phones still one per row. Also covers the agent pages (2 steps) | 20 Oct | DONE | this file |
| D-208 | F-038 page 5, AI Growth Systems: drawing labels 12.5 units (layer numbers, layer details, outcomes, loop and approval lines), layer text moved left so details clear the box edge, outcome connectors start after the vertical loop label. Same sizes in the article shortcode copy (`[reinforce_ag_layers]`). Measured 13.9px at 1440 (was 10.0); readable version on tablet and phone | 20 Oct | DONE | this file |
| D-207 | F-038 page 4, Technical SEO: every drawing label 12.5 units (tree nodes, page paths, status badges now 60 by 18, phase line, result row), index dots moved clear of the page paths, phone-only font overrides removed. Measured 13.9px at 1440 (was 8.9); readable version on tablet and phone | 20 Oct | DONE | this file |
| D-206 | F-038 page 3, Search Engine Optimization pillar (`/services/best-search-engine-optimization-services/`): every drawing label 12.5 units (13 for the Oswald beam title), pillar names re-centred, typing caret moved to x 406, phone-only font overrides removed. Measured 13.9px at 1440 (was 7.8), readable version on tablet and phone | 20 Oct | DONE | this file |
| D-205 | **Home left as it is for now (Jamil, 20 Oct: "leave the home page as it is for now")**: the signal field (D-165) and diagnostic scan (D-167) stay, and the Home hero drawing is skipped in the F-038 desktop pass until Jamil says otherwise | 20 Oct | DECIDED | this file |
| F-040 | Search Authority OS and Packages showed the drawing **and** the readable phone list together on desktop (page rule `.loop>div:not(.cap)` and `.stair>div:not(.cap)` set `display:flex` on the phone list too, beating the shared hide rule). Older bug, found while measuring F-038. Fixed with `:not(.rl-ph)`; desktop now shows only the drawing, phone and tablet only the list | 20 Oct | `[VERIFIED]` fixed | this file |
| D-204 | F-038 page 2, GEO: every drawing label 12.5 units (question, three searches, panel labels, citation chips 18 by 17, caption), spacing tightened to fit. Shared `core/reinforce-phone-hero.php`: every drawing with a readable version now switches to it below 500px of drawing width (was: phone screens only), so the 5px tablet case is gone on all pages at once. Desktop sizes on the other pages still to fix one by one | 20 Oct | DONE | this file |
| D-203 | **Frame background is now the site background (Jamil approved: red tiles, phone band, side lines as they are, keep the progress line).** `core/reinforce-frame.php` runs on every front-end page; `?bg=off` turns it off for one view to compare. Preview link rewriting removed. Supersedes the DRAFT status of D-202 | 20 Oct | DONE | this file |
| F-039 | **Our design went off on `.online` for about 2 minutes (10:29 to 10:31 UTC, 20 Oct).** The loader was deployed before the new file it lists (`core/reinforce-frame.php`), Novamira hit the missing file, wrote `.crashed` in the sandbox and switched all our code off, so pages showed the bare theme. Fixed: file deployed, `.crashed` copied to `_backups/crashed-20261020-103057.txt` and removed, cache purged, pages checked. Rule: deploy a new file first, the loader after | 20 Oct | `[VERIFIED]` resolved | this file |
| D-202 | **Draft frame background (preview only)** from Jamil's reference: dashed side rails, a full-width line and red square markers at every section join that draw in with a red sweep as the section appears, a band of cells under the hero with red textured tiles that light in a wave on scroll, and a red reading-progress line on the left rail. Shows only with `?bg=frame` (kept on links while browsing); the site is unchanged without it. Motion off for people who turn it off. Waits for Jamil's review | 20 Oct | DRAFT | this file |
| D-201 | F-038 pilot on page 72 (Jamil: A): every label in the AI answer drawing is 12.5 drawing units, layout refitted (markers, cards, checks, caret, typing width), and the drawing only shows when at least 500px wide, so text is 12px or more (measured 12.3 to 16.7px). Narrower, including the two-column tablet hero, gets the readable HTML version. Shared phone-version spacing between groups (16px). Other 24 drawings follow one at a time after Jamil sees this one | 20 Oct | DONE (pilot) | this file |
| D-200 | **Grid background removed site-wide (amends D-013, Jamil: "Eliminate the grids from the decision. Remove from everything")**: the two fixed grid layers and their scroll and mouse motion are gone from `core/reinforce-header.php`, the grid on Home blog card placeholders too. Mouse glow kept. A new background is to be drafted from Jamil's reference (Command Code: framed columns, corner marks, tiles) and approved before it goes live. Answer A for F-038: page 72 drawing first | 20 Oct | DONE (removal); draft next | this file |
| D-199 | F-037 fixes 2 to 5 live: body paragraphs capped at 60 to 65ch (FAQ, honest box, About founder, story and register, page 72 note and next step), `text-wrap: balance` on Home headings, `text-wrap: pretty` on body text site-wide (kit, Home, footer intro, About credentials), source links at 0.02em spacing. Re-scan: line-length, wide-tracking and unbalanced-heading 0 on all 3 pages; one-word endings 45 down to 1. Phone width 390 on 6 pages. Fix 1 (drawing text) became F-038 | 20 Oct | DONE | this file |
| F-037 | Impeccable design audit of Home, About and page 72 (desktop and phone): 5 real issues (illustration text about 7px on phone on page 72, breaking the 12px rule; body lines 88 to 124 characters; one-word heading and paragraph endings; wide spacing on source links). Its flags on mono eyebrows, red glow and the grid background are our locked design (D-013), kept. No contrast, overflow or font failures. Report: `claude/research/impeccable/README.md` | 20 Oct | fixes 2 to 5 done (D-199); fix 1 is F-038 | this file |
| D-198 | `.online` clean-up done (Jamil: "go", then "yes" for `adminwp`), through `claude/tools/cleanup-online.py`: 6 attacker admins deleted (`WordPress Support`, `reinforcelab`, `d6bvip8jhrd`, `ogbn0f5ynf`, `root`, and the hidden `adminwp`), all sessions ended; 9 planted items moved to quarantine; `wp-config.php` include line removed and 8 salts rotated; 5 planted cron tasks removed. Final check PASS: 2 admins (both Jamil's), site 200, still noindex, Novamira connected | 20 Oct | DONE | this file |
| D-197 | Clean-up of `.online` started (Jamil: "2"): evidence saved to `/home/u256952650/quarantine-reinforcelab-online-2026-10-18/` (outside the web folder, access denied): users, usermeta, options as JSON and a copy of `wp-config.php`. Removing the attacker accounts was blocked by this session's safety check; nothing else changed. Remaining steps handed to Jamil (hPanel and wp-admin) or to a later run once he allows it | 18 Oct | DONE in D-198 | this file |
| F-036 | Sweep of `.online` for ways back in: attacker **actively logs in** as admin `reinforcelab` (`@wp-ads.net`) on 9, 14, 15, 16 Oct from 157.22.72.125, 209.99.185.18, 84.15.184.66; `wp-config.php` line 3 loads a missing file `wp-includes/class-wp-cache.php`; 3 hidden hourly cron tasks with random names. Clean: core (3,782 files), Yoast, Jetpack, LiteSpeed match official checksums; no PHP auto-prepend; root `.htaccess` standard. The Hostinger account holds about 20 sites under one user. `default.php` is Hostinger's parked page (corrects F-035) | 18 Oct | `[VERIFIED]` read-only; nothing changed | this file |
| D-196 | Launch plan changed to a clean rebuild: fresh WordPress on new hosting, code from git, plugins from the vendors, content and settings imported as data, media images and PDFs only; nothing copied as files from the compromised Hostinger account. Step 2.1 done: data-only export of `.online` (385 records, 267 settings, 2,318 media files, 0 risky fields) | 18 Oct | APPROVED (Jamil: "Let's do this super step by step within next 24 hours"; "Yes I you can start") | `claude/tools/export-site.py`, `claude/data/site-export/`, `claude/migration-checklist.md` |
| F-035 | **`.online` is compromised too:** 6 unknown administrator accounts (one hidden by a must-use plugin), an obfuscated fake plugin, a `default.php` in the site root (later found to be Hostinger's parked page, F-036), a PHP file in `wp-content/cache/`, a fake "Event" plugin with a 72 KB payload added 9 Oct, and a dropper zip in uploads. Earliest traces April 2026. Our own code is intact (parity 0). Nothing removed: evidence kept for the host. Corrects F-033 ("`.online` is clean") | 18 Oct | `[VERIFIED]` read-only; for Jamil and the host | this file |
| D-195 | The two `/reviews/` pillars use the Best / List design and stay pillars: podium, shortlist, comparison table and a section per pick built from Jamil's own list posts (15 hosts from "15 Best Web Hosting Services", 5 tools from "5 Best AI Content Writing Tools"), then how to choose, every guide or review in the cluster, FAQs. No scores or prices. Own canonical (replaces D-193's canonical to the post) | 15 Oct | DONE (Jamil: "Yes list but it's still Pillars") | `pages/reinforce-reviews.php`, `pages/reinforce-reviews-picks.json`, `claude/tools/review-picks.py` |
| D-194 | Every affiliate link in the carried posts now gets the "Ad" label, `rel="sponsored"` and the note: the affiliate module recognises Impact (`*.sjv.io`, `*.pxf.io`), ShareASale, DreamHost `aff_id`, `?via=`, `?fpr=` and Bluehost `clickid` (was Semrush and WP Engine only). 15 posts were affected; no link is labelled twice. Logo images inside outside links get the site's name as alt text | 14 Oct | DONE (policy D-122: every affiliate link labelled) | `core/reinforce-affiliate.php`, `blog/reinforce-post.php` |
| D-193 | `/reviews/best-seo-ai-tools/` shows the text of "5 Best AI Content Writing Tools" (`/ai-content-writing-tools/`, post 358), read live from the post, with a contents list, and the 8 tool review cards below; canonical points to the post, which keeps its address. Title "5 Best AI Content Writing Tools" | 14 Oct | DONE (Jamil: "B") | `pages/reinforce-reviews.php` |
| F-034 | Carried posts carry other people's affiliate codes: Writesonic `via=rahat10` (3 links) and Rytr `via=md-rahat` (1); Jamil's own codes are `fpr=jamil39` (Jasper), `via=jamil` (Copy.ai), `fpr=jamil70` (Anyword), `fpr=jamil35` (Surfer SEO). Three logos in the AI tools table never reached `.online` | 14 Oct | `[VERIFIED]`; links unchanged, for Jamil | this file |
| D-192 | `/reviews/` linked from the site: "Reviews" in the footer (Resources, every page) and a Reviews strip under the topic chips on the blog and every topic page. Blog topic chips and "More topics" raised from 11px to 12px (the minimum) | 14 Oct | DONE (Jamil: "yes, add it to the footer and blog") | `core/reinforce-header.php`, `blog/reinforce-blog.php` |
| D-191 | `/reviews/` hub and its two pillars built and published (pages 67, 69, 70; the empty drafts from 20 Sep): every one of the 19 carried review and hosting posts plus the WP Engine partner page is now linked. No rankings, scores or prices until the first-hand rewrites; all posts kept | 14 Oct | DONE (Jamil: "yes, build the three pages now nothing will be eliminate keep all the posts we will rewrite later") | `pages/reinforce-reviews.php` |
| F-033 | **Production is hacked:** every page checked on reinforcelab.com carries a hidden block of 25 spam links (gambling and adult sites, `rel="sponsored"`), placed off-screen (`left:-20914565266523px`) just before the closing scripts. Added by code that runs in the page footer, not in page content. `.online` is clean | 14 Oct | `[VERIFIED]` on 6 pages; source not found (no access, production untouched) | this file |
| D-190 | WP Engine partner page rebuilt at production's address `/agency-partner-program-wp-engine-landing/` (page 505): hosting explained, what we do, an honest "is it right for you", disclosure, 5 FAQs. No offer or price stated. The partner button and "Ad" note appear only once the WP Engine link is saved; until then the page points to Contact | 14 Oct | DONE; partner link saved 14 Oct (Jamil: "its mine") | `pages/reinforce-wpengine.php`, `core/reinforce-affiliate.php` |
| F-032 | Production refused reads from the `.online` server (`/` 403, everything else 404) on 14 Oct | 14 Oct | RESOLVED same day (Jamil: "resolved"); all reads 200 again | this file |
| D-189 | About, "Who is Reinforce Lab for?": the 8 industries shown as linked cards (number, name, one-line summary from each industry page, arrow) in a 4-column grid, with "See all industries" beside the heading; replaces the row of small chips | 14 Oct | DONE (Jamil: "the industries are presented poorly") | `pages/reinforce-about.php` |
| D-188 | About: "Download our company profile" link (PDF, size shown) at the foot of the At a glance panel; shows only while the file exists. Company profile to be redesigned after the .com launch: reminder in the migration checklist, B3 | 14 Oct | DONE (Jamil: "Yes"; "after we migrate the website to .com we will redesign the company profile, remind after migration") | `pages/reinforce-about.php`, `claude/migration-checklist.md` |
| D-187 | Company profile PDF rebuilt in the new design (9 pages, A4 sideways, facts already on the site only) and placed on `.online` at production's address `/wp-content/uploads/2022/03/Reinforce-Lab-Company-Profile.pdf` (restore, D-182) | 13 Oct | DONE (Jamil: "finish it") | `claude/content/company-profile/` |
| D-186 | Home blog section: subheadline now under the "From the blog." heading, "Read the blog" button moved below the three cards; Awards and recognition intro text now under its heading on the left (was a right-hand column) | 13 Oct | DONE (Jamil: "keep the sub headline below headline", "Place the button below blog posts", "Place the text of subheading on the awards section on the left as well") | `pages/reinforce-home.php` |
| D-185 | Home "From the blog." section redone: heading row (title left; lede and "Read the blog" right) above three equal cards, each with a 16:9 image (or a brand panel), type, date, category, title, short excerpt and "Read article"; 2 cards at 1000px, 1 at 600px. Also fixed two sideways-scroll faults on home (Search Authority OS panel at 820 to 940px, testimonials below 820px) and clipped the scroll-in tilt so it cannot widen any kit page | 13 Oct | DONE (Jamil: "First change the Blog section in the home page ... organize it differently so that it looks professional") | `pages/reinforce-home.php`, `core/reinforce-kit.css` |
| D-184 | Category pages at production's addresses (Yoast "remove /category/ from URLs", as production): `/seo-tips/`, `/digital-marketing/`, `/digital-marketing/search-engine-optimization/` and so on; `/category/...` 301 to them; page 2+ noindex,follow. Careers H1 now "Careers at Reinforce Lab."; Jamil confirmed the CV-data line and the quoting line; "2025" in post titles stays until each rewrite (option C) | 13 Oct | DONE (Jamil: "Category pages ... Yes", "Yes C", "Okay", "Yes", Careers title "should focus on Career") | `wpseo_titles.stripcategorybase`, `pages/reinforce-careers.php` |
| D-183 | Careers and Legal Statement built fresh at their production addresses (both kept by D-182): Careers says plainly there are no open roles and invites CVs by email (no JobPosting schema); Legal Statement gives the verified company identity (Reinforce Lab Limited, RJSC C-180618/2022, 19 Apr 2022, Dhaka; Reinforce Lab Inc, Katy TX), contact, general-information, copyright, links, affiliate and related policies. Both in the footer. 200, noindex, one H1, axe 0, no sideways scroll | 13 Oct | DONE (Jamil: "No not hiring", "No Start fresh") | `pages/reinforce-careers.php`, `claude/content/legal-statement.html` |
| D-182 | Jamil's changes to the approved map: `/our-team/` and `/management/` 301 to `/about-us/`; `/services/creative/` and its graphic design page 301 to `/services/`; Legal Statement and Careers kept and to be built; WP Engine partner page and company profile PDF restored. Category pages: recommendation given (keep production's addresses without the `/category/` base, per the approved map), waiting for Jamil | 13 Oct | APPROVED (Jamil: "I want to redirect Our Team, Management, Keep and create Legal Statement. Keep and create Careers ... Restore ... yes ... /services/creative/ and its graphic design page no need redirect") | `claude/data/redirect-map-draft.csv`, `claude/redirect-signoff-list.md` |
| D-181 | Redirect sign-off: Jamil approved the 241-line list (`claude/redirect-signoff-list.md`: 106 stay, 104 move, 18 stay hidden from Google, 13 removed) and the ~575 junk addresses as one group by rule; any line can be changed later (a kept URL can still be redirected after launch; removals and moves are the hard ones to undo). Satisfies the per-URL approval of CLAUDE.md Rule 2 for these URLs | 13 Oct | APPROVED (Jamil: "We can approve this for now and we can redirect later what we don't want right") | `claude/redirect-signoff-list.md`, `claude/migration-checklist.md` |
| D-180 | Blog index organised: cards spaced (16 to 24px gap) with their own border and red hover edge; each card shows its article type, date and main category; posts without an image get a brand panel (type and category) instead of an empty box; filter row lists main categories only (8 with 3 or more posts, 8 small ones under "More topics"), with counts; 12 per page (3 x 4), 7 pages. No sideways scroll, axe 0 at 390 and 1440 | 12 Oct | DONE (Jamil, with a screenshot of the blog: "Fist fix the blog. Organize the blog. there is no gap between posts") | `blog/reinforce-blog.php` |
| D-179 | Carried posts finished for launch: Jamil's approved article type on all 80 (reviews held on Guide until review facts) and main category set as Yoast primary (13 posts gained that category); template: chapters and How-To steps from H3 where the real sections are H3 (median 1 to 14 chapters), empty old heading tags dropped at render, main category drives chip, breadcrumb, related posts and blog cards; all post designs use minmax(0,1fr) grids; long guides keep a compact cover. All 81 posts: no sideways scroll on phone or desktop, no script errors, dates unchanged | 12 Oct | DONE (Jamil: "Approve the list ... Yes", "Keep this", "yes, do both fixes") | `blog/reinforce-post*.php` |
| D-178 | 80 kept production posts carried across to .online (checklist A3): same slug, title, words, images at the same paths, publish and modified dates, categories, Yoast title and description; "Reinforce Lab team" byline credited to the Organization in schema; structure-only clean-up (old inline scripts and JSON-LD, Divi wrappers, hidden embed frames dropped; links and images made site-relative). Read-only copies in `claude/data/production-posts/`, tool `claude/tools/carry-posts.py`. 2,029 image files copied. All 80 checked: 200, titles and descriptions match production, noindex, every own image loads, no sideways scroll on phone. Must-stay URLs working 16 to 97 of 124 | 12 Oct | DONE (Jamil: "meanwhile start carrying the blog posts across") | `claude/tools/carry-posts.py`, `blog/reinforce-post.php` |
| D-176 | Lean setup on every other front-end view (all pages, the post template, blog index, search, 404): unused theme files removed, trimmed Bootstrap and skin rebuilt over 57 pages (Bootstrap 106 selectors, 8.7 KB; skin 253, 22 KB). 54 full-page screenshots identical; computed styles identical on 57 pages at 1440 and 390 (114 page-widths); forms, cookie bar, menus, 404 and search status checked. About, Contact, blog post, agents, Portfolio: mobile 98 to 100, desktop 98 to 100 (one 93 outlier) | 12 Oct | DONE (Jamil: "yes, do it") | `core/reinforce-speed.php`, `claude/tools/bs-trim/` |
| D-175 | Last render-blocking files removed from the lean pages: the theme skin (68 KB) replaced by an inline copy of the 228 selectors in use (21 KB), and our `reinforce-kit.css` printed inline there (other pages keep the cached file); both trimmed copies now fall back to the full theme file if the theme changes it (md5 check). Computed styles identical on every element of 30 pages at 1440 and 390. Mobile: home 96, 96, 98, 97 (LCP 2.1 s), technical SEO 99, 99, 98 (LCP 2.0 to 2.1 s), healthcare 98, 99, 99; desktop home 96, 98, 95, 96, technical SEO 99, 98, 96, healthcare 99, 98, 99; no render-blocking requests | 12 Oct | DONE (Jamil: "go ahead") | `core/reinforce-skin-lean.css`, `core/reinforce-speed.php`, `core/reinforce-kit.php`, `claude/tools/bs-trim/` |
| D-174 | Trimmed Bootstrap on the lean pages (home, services, industries): the 162 KB theme Bootstrap file (24 KB compressed, render-blocking, about 97% unused) replaced by an inline 8 KB copy of the 92 selectors these pages use (of 2,634), same cascade position; built by `claude/tools/bs-trim`. 60 full-page screenshots identical; menus, FAQ, scroll test, axe 0 all pass. Home mobile 96, 96, 96, 97 (LCP 2.4 to 2.5 s), desktop 97, 96, 98, 96; technical SEO mobile 97, 95, 97; healthcare mobile 97, 97, 97; CLS 0 to 0.001 | 12 Oct | DONE (Jamil: "yes, build the trimmed Bootstrap") | `core/reinforce-bootstrap-lean.css`, `core/reinforce-speed.php`, `claude/tools/bs-trim/` |
| D-173 | Jamil's PageSpeed Insights report (home, mobile: performance 95, accessibility 100, best practices 100, SEO 66, agentic 3/3) worked through: header logo served at its shown size (13 KB to 4 KB, width and height set), two early layout reads in the header script removed, header button light starts after 3 s. Home after: mobile 95, 95, 96, 97; desktop 98, 97, 97, 96, 91, 98 (median 97); CLS 0. SEO 66 is the required noindex on .online. Left open: cache lifetimes, Bootstrap/skin render-blocking CSS, HTTP/2 | 12 Oct | DONE (Jamil sent the report: "before that, real screenshot from my chrome browser") | `core/reinforce-header.php`, `uploads/reinforce-brand/` |
| D-172 | Service and industry pages made lean (as the home page, D-166): unused jQuery, theme scripts, Font Awesome, animate.css and lightbox removed (/services/agents/ excluded); card reveals moved to IntersectionObserver; motion files load on the first scroll, pointer move, touch or key press (home unchanged). 58 full-page screenshots identical before and after. Technical SEO desktop 97, 97, 97 and mobile 96, 96, 97 (was 97 and 91 to 92); healthcare desktop 97, 96, 97 and mobile 97, 97, 96 (was 96 to 97 and 91); page weight 275 KB to 185 KB; CLS 0 to 0.006; axe 0 | 11 Oct | DONE (Jamil: "yes, do it") | `core/reinforce-speed.php`, `core/reinforce-motion.php`, `core/reinforce-motion.js` |
| D-171 | Scroll motion phase 3 on the service and industry pages (shared .rl-page kit; /services/agents/ excluded): headings reveal line by line, cards, steps, metrics, myth rows and lists rise in turn, process steps fill a red top line in order, link cards tilt with a sheen, reading-progress bar, closing CTA glow; WebGL scenes now load on the home page only. Service page desktop 97, 97, 97, mobile 92, 91, 91 (before 97 to 98, 91 to 92); industry page desktop 96, 97, 97, mobile 91, 91, 91 (before 98, 91 to 92); CLS 0 to 0.003; axe 0 | 11 Oct | DONE (Jamil: "then Go ahead with Phase 3") | `core/reinforce-motion.js`, `core/reinforce-motion.php` |
| D-170 | Header call-to-action button: a short white light travels round its border once every 6 s (CSS and inline SVG, no script; faster on hover; off for reduced motion). Final values set by Jamil: core line 0.6 px white at 85%, halo 3 px white at 14%, glow 3 px blur white at 45% | 11 Oct | DONE (Jamil: "Can you create a moving line in the header call to action button", then the thickness values) | `core/reinforce-header.php` |
| D-169 | Hero diagram directed as "one cycle of growth": D-168 scan beam removed; a 12 s GSAP loop in five beats (ingest, absorb, process, emit, compound) using the diagram's own parts, a one-off power-on intro, layered depth on mouse move and hover tracing from each input; speed holds (desktop 93, 98, 98, 97; mobile 95, 91, 95, 95; CLS 0; axe 0) | 11 Oct | DONE, waiting on Jamil's view (Jamil: "I don't like it the last one ... First can you think like a director and then design to make it feel stunning") | `pages/reinforce-home.php`, `core/reinforce-motion.js`, `core/reinforce-motion.php` |
| D-168 | Hero: the scan powers the system diagram (option B): a dot grid behind the diagram and a vertical beam that sweeps left to right in step with its 10 s cycle (inputs, engine, outcomes), reading the diagram's own CSS clock; desktop only, 3 KB; speed unchanged (desktop 97, mobile 95, CLS 0) | 11 Oct | DONE (Jamil: "B. The scan powers the hero diagram (recommended)") | `core/reinforce-gescan.js` |
| D-167 | Closing CTA gets a "diagnostic scan" (WebGL radar sweep over a square-dot grid, desktop only, 2.8 KB); LiteSpeed Cache activated on .online (page cache only, all optimisation off, object cache off, form pages uncached, deploy purges the cache); supersedes the D-139 "no caching" choice. Home with cache: desktop median 97.5, mobile 95, server wait 0.9 s to about 0.55 s, CLS 0 | 11 Oct | DONE (Jamil: "give a different animation like the wave one ... Yes, After that test speed again and then enable LiteSpeed caching") | `core/reinforce-scan.js`, `core/reinforce-speed.php`, `claude/tools/rl.py` |
| D-166 | Mobile load time: home drops the unused render-blocking files (jQuery and Migrate, Font Awesome, animate.css, lightbox, theme scripts; Bootstrap and skin kept, removal tested and changes the layout); Oswald fallback tuned per weight; 3D field boots on first interaction. Mobile 90 to 94 to 98 (median 96), LCP 2.9 s to about 2.2 s, CLS 0; desktop median 95.5 (proxy-bound server response) | 11 Oct | DONE (Jamil: "Fix the mobile load time first"); page caching question for Jamil | `core/reinforce-speed.php` |
| D-165 | Home: 3D "signal field" behind "One system. Three outcomes" (hand-written WebGL, 2.7 KB, desktop only, lazy, pauses off-screen; CSS dotted field on phones), card animations (badges and testimonials rise with a 3D turn, pointer tilt with sheen, trophy draws, outcomes rise), motion setup moved to idle tasks, font swap fixed (size-matched fallbacks, Plex Mono optional); pass mark met: desktop median 96, mobile median 90, CLS 0 to 0.003 | 11 Oct | DONE (Jamil: "option 2"; pass mark desktop 96+, mobile 90+, no layout shift) | `core/reinforce-signal.js`, `core/reinforce-motion.js`, `core/reinforce-fonts.css` |
| D-164 | Scroll motion, phase 2: home headings reveal line by line (SplitText, reverted after), services and industries rows fade up in turn, red reading-progress bar, closing CTA glow builds on scroll; header slims on scroll sitewide (desktop, transform only, no layout shift); Lighthouse desktop 96, mobile 90 (baseline 91) | 11 Oct | DONE (Jamil asked for phase 2); phase 3 (service and industry pages) waits | `core/reinforce-motion.js`, `core/reinforce-header.php` |
| D-163 | Scroll motion, phase 1: GSAP 3.15 + ScrollTrigger self-hosted (home only, deferred, about 46 KB compressed); How it works rail draws with scroll, Search Authority OS holds while its five stages light up, Packages ladder rises; Lenis off; no change to text, hero or SEO; Lighthouse desktop 96 before and after, mobile 91 before, 89 after (median, within run-to-run noise) | 11 Oct | DONE (Jamil: "Go ahead with Phase 1? yes"); phase 2 waits for approval | `core/reinforce-motion.php`, `core/reinforce-motion.js` |
| D-162 | Home Proof section ("We run this system on ourselves", four placeholder tags) removed until there are real results; same placeholder block still on /search-authority-os/ (Jamil to decide) | 11 Oct | DONE (Jamil: "Remove and", message cut off) | `pages/reinforce-home.php` |
| D-161 | Home Recognition leads with the HackerNoon award: featured card "Winner, Startups of The Year 2024 in Dhaka" plus 11th in Marketing, two honourable mentions and Startups of the Week, each linked to HackerNoon; text from the /awards/ source; sub-heading now "Awards and recognition." | 11 Oct | DONE (Jamil: "what about my hackernoon startup award") | `pages/reinforce-home.php` |
| D-160 | Home layout variety, the rest: Outcomes as three statements, Problem with the heading held left and a list right, Industries as a two-column list with drawn icons, Recognition merged into Clients, Blog split (heading left, posts right); words unchanged; Proof untouched | 11 Oct | DONE (Jamil: "1. yes") | `pages/reinforce-home.php` |
| D-159 | Section intros back under the heading on the left (the split headings of D-158 step 1 removed); index and timeline kept | 11 Oct | DONE (Jamil: "the right text can be on the left after the heading") | `pages/reinforce-home.php` |
| D-158 | Home layout variety, first 3: section headings with an intro use the full width (heading left, intro right), What we do as a numbered index, How it works as a timeline; words unchanged | 11 Oct | DONE (Jamil: "Go ahead with the first 3"); next sections and the Proof question wait for him | `pages/reinforce-home.php` |
| D-157 | Home Clients logos: two rows of 12 scrolling right to left in an endless loop (row 2 slower), edges faded, pause on hover, still for reduced motion; Pro Tennis Academy logo to be replaced when Jamil sends it | 11 Oct | DONE (Jamil: "I want the logos in two line and moving from right to left smooth motion") | `pages/reinforce-home.php` |
| D-156 | Home: Clients section ("Companies we've worked with.") between Proof and Recognition, the same 24 logos in production home's order, white versions from /clients/, link to all 46 | 11 Oct | DONE (Jamil: "I want a client section before ... Recognition") | `pages/reinforce-home.php` |
| D-155 | Testimonial: the "..." marking the left-out sentence removed, and the note about it; the shortened quote stays as written | 11 Oct | DONE (Jamil: "“...” remove it and keep it as you written") | `pages/reinforce-home.php` |
| D-154 | Home Packages teaser: the empty right side now holds a ladder (free diagnostic, then Foundation, Growth OS, Enterprise with setup and monthly prices from the /packages/ source), each row a link | 11 Oct | DONE (Jamil: "The right side like boring") | `pages/reinforce-home.php` |
| D-153 | Home: Testimonials section after Recognition with the two client quotes from production's home (Md. Arifin Hussain, Bikroy; Mohammad Mozammal Haque, Mrco International), word for word except one sentence left out (marked "..."), square photos, no stars, no review schema | 11 Oct | DONE (Jamil: "Create a section for testimonial") | `pages/reinforce-home.php` |
| F-031 | Two GoodFirms badges on production's home page (Top SEO Services Company Bangladesh, Top Branding Company Bangladesh) point to files that return 404 on reinforcelab.com (`/wp-content/uploads/2024/10/...svg`); visitors see broken images; production not changed (Rule 1) | 11 Oct | OPEN (Jamil: originals from GoodFirms) | this file |
| D-152 | Home: own Recognition section after Proof with the six badges from production's home (GoodFirms x4, FindBestFirms, DesignRush), self-hosted, each linked to the directory's page, plus a link to /awards/ | 11 Oct | DONE (Jamil: "build a section with the images in the home page I want to have a separate section for this") | `pages/reinforce-home.php` |
| F-030 | `.online` inner pages all return the server's own 404 (Hostinger static page) since some time between 8 and 11 Oct; home and `/?page_id=` work, so the WordPress rewrite rules in `.htaccess` are missing or broken; Novamira cannot connect; site still noindex | 11 Oct | CLOSED (Jamil re-saved permalinks; 55 of 55 pages 200) | this file |
| D-151 | Citation-tool post: allowed, on Jamil's standard (deep research, official documentation, industry reputation, try features where possible, never claim use that did not happen, built to convert); "Explore Search Authority OS" kept | 11 Oct | APPROVED (Jamil) | this file |
| D-150 | AI crawlers allowed at launch (ChatGPT, Perplexity, Claude, Google AI and others); planned robots.txt written, not live | 11 Oct | APPROVED (Jamil: "allow them all. Yes.") | `claude/data/robots-launch.txt` |
| D-149 | Redirect sign-off method: Jamil checks one list of the 241 addresses that matter (live, clicks, backlinks, or shop), most important first; the ~575 junk and dead addresses are approved as one group by rule | 11 Oct | APPROVED (Jamil: "yes, do it this way"); list waiting for his check | `claude/redirect-signoff-list.md` |
| D-148 | Shop closed: `/shop/`, cart, checkout and store archives redirect to `/packages/` (account page to `/contact-us/`), empty store categories and tag 410, product pages keep their approved targets; Jamil keeps an export of past orders; customer data is not moved | 11 Oct | APPROVED (Jamil: "B. Close the shop") | `claude/data/approved-redirects-2026-10.csv` |
| D-147 | Site icon: the logo mark (white and logo red on #121011) as the WordPress Site Icon (32, 180, 192, 270 px), `favicon.ico` (16, 32, 48 px) in the site root, theme colour #121011; closes O-026 and F-028 C1 | 8 Oct | DONE (Jamil: "go ahead") | `claude/design-previews/site-icon/` |
| D-146 | The 14 redirect-map decisions approved as recommended: 6 old pages 301 to built pages, 6 dead pages 410, `/project/uiu/` 301 to `/clients/`, Beyond Borders image kept; the map has 0 undecided URLs | 8 Oct | APPROVED (Jamil: "go ahead") | `claude/data/approved-redirects-2026-10.csv` |
| F-029 | Read-only production inventory (8 Oct): 193 sitemap URLs, 509 URLs reached (223 live, 18 redirect, 19 broken links production itself points to), 18,791 internal links, 2,060 image uses; merged with register, Search Console, backlinks, Yoast redirects and later approvals into a draft map of 802 old URLs; every URL that is live, has clicks or backlinks has an approved fate; 14 decisions left | 8 Oct | DECISIONS DONE (D-146); backlink export and URL-by-URL sign-off open | `claude/data/redirect-map-decisions-needed.md` |
| D-145 | Bylines: Jamil rewrites every old post (new content and images) and each rewritten post carries his name; titles may change, slugs only with per-URL approval; the 20 HUB-REVIEW posts are already decided (D-014b), `/reviews/` hub to build before launch | 7 Oct | APPROVED (Jamil) | `claude/research/review-posts-proposal-2026-10-07.md` |
| D-144 | Migration approach: one switch (new pages plus kept production posts copied unchanged at the same URLs and dates, new design), posts rewritten after launch; 16 author URLs 301 to /blog/ supersede the September plan (/our-team and 410); checklist in `claude/migration-checklist.md` | 7 Oct | APPROVED (Jamil: "1. Yes 2. today's decision (all 16 go to /blog/)"); bylines pending | `claude/migration-checklist.md` |
| D-143 | Button groups: wherever two or more buttons sit together they are the same size (desktop side by side at the longest label's width; phone stacked, full width, equal height) | 7 Oct | DONE (Jamil: "All the buttons size must be equal where ever there are two buttons") | this file |
| D-142 | Phone footer reorganised like Jamil's reference (Semrush): the five link columns collapse into rows with a chevron and open on tap; desktop unchanged | 7 Oct | DONE (Jamil: "Organize it for Mobile device like the reference image attached") | this file |
| D-141 | Last three axe items fixed: post entry headers are plain blocks in all 12 post templates, Services diagram role group, hidden labels for the empty first table headers (Audit page, post 330 body); axe 0 on every page | 7 Oct | DONE (Jamil: "Go ahead") | this file |
| D-140 | Accessibility fixes from F-028: link names start with the visible text (axe label mismatch 249 to 0), footer column titles no longer headings (heading order 57 to 0), tap targets padded to 24px (2,800 small targets to 24, all inline in lists or text), form checkboxes 24px | 7 Oct | DONE (Jamil: "Go ahead") | this file |
| D-139 | Jamil's design decisions on F-028: body text 16px, card titles 20px, 12px minimum, container 1440 (supersedes D-013's 1280), one button label "Get your free diagnostic", footer names kept, US office in schema, LiteSpeed Cache stays off, author/date/Uncategorized archives retired (301 to /blog/) | 7 Oct | DONE on `.online` | this file |
| D-138 | F-028 P1 fixes on `.online`: zero radius everywhere, accessible colour tokens, blog grid and post share image, kit-styled 404 and search, SMTP code (waits for mailbox), cookie choice bar with GPC and consent-gated GA4, privacy policy row | 7 Oct | DONE (Jamil: "Do it all") | this file |
| O-026 | Favicon and site icon: Jamil asked to be reminded later (reminder scheduled 8 Oct) | 7 Oct | CLOSED (D-147) | this file |
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
| D-002 | WooCommerce (superseded: no cart for packages, 17 Sep; shop closed, no WooCommerce on the new site, D-148) | 20 Aug | SUPERSEDED by D-148 | [2026-08](decisions/2026-08.md) |
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

## D-204 · GEO drawing text, and readable version below 500px everywhere (F-038)

**Date:** 20 Oct 2026 · **Approved by:** Jamil ("next", option A) · `[VERIFIED]`

- `services/reinforce-geo.php`: every drawing label 12.5 units, letter spacing reduced to fit, citation chips 18 by 17. Measured 13.9px at 1440.
- `core/reinforce-phone-hero.php`: every hero figure with a readable version is a size container and switches to it below 500px of drawing width.
- Full measurement on 20 Oct, all 25 pages with a drawing: tablet (1024) and phone (390) now show the readable version on every page. Desktop (1440) smallest drawing text: fixed on AI Search Optimization and GEO (13.9px); still small on Home 9.1, AI Growth Systems 10.0, Services hub 9.5, Agents 9.4, Pharmaceutical, Executive AI and SEO Content Systems 8.4, Search Authority OS 8.0, Enterprise, International, LLM, Lead Generation, Press Release, Marketing Automation, AI Workflow, Technical SEO and E-commerce Design 8.9, SEO pillar, Local SEO, Audit, Website Maintenance and WordPress Design 7.8. Packages not measured on desktop (load failed). These get the same treatment one page at a time.
- Found and fixed on the way: F-040.

## D-203 · Frame background made the default

**Date:** 20 Oct 2026 · **Approved by:** Jamil ("Side lines: keep as they are. Red progress line: keep it.") · `[VERIFIED]`

- `rl_frame_on()` is now true on every front-end page; `?bg=off` switches it off for one page view (for comparing). The `?bg=frame` link rewriting is removed.
- Everything else as built in D-202: dashed side rails, section lines with square markers and a red sweep, red textured tile band under the hero (6 cells desktop, 4 on phone, phone hero gets the room it needs), red reading-progress line on the left rail. Motion off for people who turn it off.
- Pages without our page wrapper (`.rl-page` or `.rl-home`) get no frame.
- D-013 now reads: dark ground, brand red, Oswald, IBM Plex Sans and Mono, square corners, glass header, frame background (this entry). No grid.

## D-202 · Draft frame background (preview only)

**Date:** 20 Oct 2026 · **Asked by:** Jamil ("create a draft version of that and then finalize") · `[VERIFIED]` working, not approved

File: `core/reinforce-frame.php` (listed in `reinforce-loader.php`). Runs only when the address has `?bg=frame`; it then adds that to links inside the site so Jamil can browse in preview. No change for anyone else.

- **Rails:** two dashed lines just outside the content edges, top of page to the footer.
- **Section joins:** a full-width hairline at the top of each section with 9px square markers on the rails. As a section scrolls into view the line draws out from the centre, a red light sweeps across it once, and the markers flash brand red.
- **Hero band:** a row of cells (6 on desktop, 4 on phone) in the free space at the bottom of the hero, dashed dividers, two red noise-textured tiles; as you scroll, the tiles light in a wave and drift slightly. Shown only where the hero has at least 44px of free space (not on phone today).
- **Reading progress:** a red line with a square head runs down the left rail as you read.
- Layer sits above content with no pointer events (sections with their own background hid it otherwise), below the header. Off for people who turn off motion: lines static, no sweep, no progress line.
- Checked on Home and page 72 at 1440 and 390: no script errors, no sideways scroll.
- Jamil, 20 Oct: "Keep red tiles, show them on phone too, love it." Tiles stay brand red. Phone now shows the band (4 cells): in preview the hero gets just enough extra bottom space (84px of free room) before anything is measured, so section lines stay aligned. Checked on Home and page 72 at 390: 4 tiles, no sideways scroll, no script errors.
- Jamil, 20 Oct: side lines as they are, keep the progress line. Made the default in D-203.

## F-039 · Design off for 2 minutes after a deploy order mistake

**Date:** 20 Oct 2026 · `[VERIFIED]` resolved

`rl.py deploy` refused the new file without `--create`, but the loader that lists it deployed. Novamira caught the fatal "failed opening required" error, wrote `wp-content/novamira-sandbox/.crashed` and stopped loading the sandbox, so every page showed the bare theme with our header, design and page code off. Fixed within about 2 minutes: deployed the file with `--create`, copied `.crashed` to `_backups/crashed-20261020-103057.txt`, removed it, purged the cache, confirmed `rl-header` on Home, About, Blog, Services, Healthcare and page 72. `.online` only; production untouched. Rule from now: a new file goes live before the loader line that includes it.

## D-201 · Drawing text pilot on page 72 (F-038, option A)

**Date:** 20 Oct 2026 · **Approved by:** Jamil ("A") · `[VERIFIED]`

- `services/reinforce-aiso.php`: all drawing text at 12.5 units (tabs, question, labels, markers, card titles, checks, result row), spacing reduced where it was wide. Refitted: typing area 352 to 384 wide, caret travel 378, markers 18 by 17, cards 104 tall, checks 15 apart, result row 11px squares.
- The figure is a size container. Below 500px of drawing width the SVG hides and the readable `rl_ph` version shows (was: viewport under 560px only). 12.5 x 500 / 520 = 12.0px minimum by construction.
- Measured: 13.9px at 1440, 12.3px at 1280 and 600, 16.7px at 800; at 1024 the readable version shows. Old phone-only font overrides removed.
- `core/reinforce-phone-hero.php`: 16px between groups that have no arrow (labels touched the box above). Applies to every page with a phone version.
- Phone width 390 on page 72, GEO, Healthcare. Next: the same treatment for the other drawings, one page at a time, after Jamil reviews this one.

## D-200 · Grid background removed; new background to be drafted

**Date:** 20 Oct 2026 · **Approved by:** Jamil · `[VERIFIED]`

Jamil: "Eliminate the grids from the decision. Remove from everything. However I want some background things like grids ... organized in different way to look more tech savvy and modern with stunning scrolling effects. We will create a draft version of that and then finalize." Reference: five phone screenshots of commandcode.ai (framed page with dashed column rails, small square corner marks where sections meet, dashed cell dividers, textured tiles in the hero, logo wall in ruled cells).

- **D-013 amended:** the "systems grid" background is no longer part of the design system. Everything else in D-013 stands.
- **Removed:** `#rl-grid` and `#rl-grid2` (markup, CSS, the `--grid*` colour tokens, the scroll and mouse parallax code) from `core/reinforce-header.php`; the 20px grid on Home blog card placeholders (`.ph-grid`, red wash kept).
- **Kept:** the mouse glow (`#rl-glow`), off for people who turn off motion.
- **Check:** Home, About, page 72, Blog, Healthcare at 1440: no grid layers, glow follows the mouse, no script errors.
- **Next:** draft the new background as a preview Jamil can open, then finalize. F-038 answer is A, page 72 first.
- The Novamira design-system record keeps its ID `reinforce-lab-systems-grid`; renaming it is cosmetic and left alone.
- **Leftover sweep, 20 Oct (Jamil: "is there any traces left ... remove that"):** theme code, live HTML and every linked stylesheet on Home, About, GEO and Blog searched for `rl-grid`, `--grid*`, `grid-fine`, `grid-red` and the parallax code: none left. Only trace was the class name `ph-grid` on Home blog placeholders (now only a red wash), renamed `ph-wash`. Not grid traces: `.grid2` (two-column form layouts), the Novamira design record (its text describes the layout, only its name says grid). Open: the Home signal field (D-165) and diagnostic scan (D-167) are separate animated point fields, kept until Jamil decides.

## F-038 · Text inside hero drawings is under 12px on every page that has one

**Date:** 20 Oct 2026 · `[VERIFIED]` measured in Chromium, nothing changed

Found while fixing F-037 item 1. The hero drawings are SVG, so their text scales with the drawing. Smallest rendered text, measured on 12 of the 25 pages with a drawing (the rest use the same component and sizes):

| Width | Drawing width | Smallest text |
|---|---|---|
| 1440 | 580px | 7.8 to 9.5px |
| 1280 | 510px | 6.9 to 8.3px |
| 1024 (two-column hero) | 343 to 400px | 4.8 to 5.8px |
| 600 | 510px | 6.9 to 8.3px |
| under 560 | readable HTML version (`rl_ph`) | passes |

Breaks D-139 (nothing under 12px). Jamil chose A on 20 Oct (D-200). **Closed 20 Oct by D-210** (all pages 13.8 to 13.9px at 1440, Home excepted per D-205). The D-138 and D-140 audits checked HTML text only. Options for Jamil: (A) show the readable HTML version whenever the drawing would be narrow and redraw the drawing text to at least 12px at full size, page 72 first as a pilot, then the other pages one at a time; (B) treat drawing labels as decoration and exempt them from D-139. Recommendation: A.

## D-199 · Line length and wrapping fixes (F-037 items 2 to 5)

**Date:** 20 Oct 2026 · **Approved by:** Jamil ("Fix the 5") · `[VERIFIED]`

- `core/reinforce-kit.css` (every kit page): `text-wrap: pretty` on `p` and `li`; FAQ answers 65ch; honest box 60ch; `.src` spacing 0.06em to 0.02em.
- `pages/reinforce-home.php`: `text-wrap: balance` on headings, `pretty` on body, FAQ 65ch, `.src` 0.02em.
- `pages/reinforce-about.php`: founder and story paragraphs 65ch, register note 60ch, credentials `pretty`.
- `services/reinforce-aiso.php`: note 60ch, final next-step line 58ch.
- `core/reinforce-header.php`: footer intro `pretty`.

Check: Impeccable re-scan at 1440 and 390 shows 0 line-length, 0 wide-tracking and 0 unbalanced-heading on Home, About and page 72; one-word endings from 45 to 1 (a two-line credentials item on About). Phone width 390 on Home, About, page 72, Technical SEO, Healthcare and Blog. Parity 0. No database change.

## F-037 · Impeccable design audit (Home, About, AI Search Optimization)

**Date:** 20 Oct 2026 · `[VERIFIED]` read-only, nothing changed

Jamil asked whether Impeccable (open-source design skill for AI coding tools) helps, then approved an audit of 3 pages. Its scanner ran on the live pages at 1440 and 390 wide; each finding was checked against the code. Full report and raw results: `claude/research/impeccable/`.

- **Fix candidates:** (1) text inside the page 72 answer illustration renders about 7px on phone, against D-139; (2) body lines run 88 to 124 characters on desktop, cap near 70ch; (3) `text-wrap: balance` on headings; (4) `text-wrap: pretty` on body text; (5) normal letter spacing on `.src` links.
- **Kept, locked by D-013:** mono eyebrows above headings, red glow on main buttons and final panel, grid background.
- **Passed:** contrast, overflow, fonts, no nested cards.
- Tool not installed in the repo; impeccable.style is blocked by the container network policy, so the npm scanner and a git clone of the skill were used from scratch space.

## D-198 · .online clean-up completed

**Date:** 20 Oct 2026 · **Approved by:** Jamil ("go" for the steps, "yes" for `adminwp`) · `[VERIFIED]`

Run with `claude/tools/cleanup-online.py` (dry run by default, `--apply` to change), one step at a time, each with its own check. Jamil allowed only that script in this session's permission settings.

| Step | What changed | Check |
|---|---|---|
| users | Deleted `WordPress Support` (4), `reinforcelab` (5), `d6bvip8jhrd` (6), `ogbn0f5ynf` (7), `root` (10). None owned posts. Every login session ended | PASS |
| files | Moved to `quarantine.../files/wp-content/`: `mu-plugins/health-check-api.php`, plugins `lunar-profiler-ink`, `nimble-router-mod`, `onyx-store-tag`, `pulse-cache-ink`, `event`, `cache/2704f406.php`, `uploads/2026/08/ab5c7c9b.zip`, theme `wise-news` | PASS |
| wpconfig | Removed `@include_once(__DIR__ . "/wp-includes/class-wp-cache.php");`, rotated the 8 salts. Old file kept as `wp-config.php.pre-cleanup-20261020-065401` (sha1 before c422b17, after f06033d). Parsed before the swap | PASS, Novamira still connected |
| cron | Removed `_1sgjdxjsuyxct0tzy8`, `h072tqv7v631md8u`, `fxuh8e_9aidtaz1m`, `run_weekly_partner_astra`, `puc_cron_check_updates-hostinger-ai-assistant` | PASS, not back after page loads and a cron run |
| users (again) | `adminwp` (8, `healthcheck@wordpress.local`, "WP Health Service", created 11 Oct). The planted mu-plugin hid it from user lists, so the first sweep missed it; it showed once the mu-plugin was moved. F-035 counted 6 admins; my step list had only 5. No code re-creates it: the only file changed in 2 days was `wp-config.php` | PASS |

**Final state:** admins `jadirectives@gmail.com` and `jamilahmed`; plugin folders are only the stack plus Novamira; mu-plugins only Hostinger's two; themes `bb-theme` and `twentytwentyfive`; `blog_public` 0; home and login 200. All removed items and the database backups stay in quarantine (outside `public_html`, access denied) as evidence.

**Still open (not done here):** replace premium plugins with fresh vendor copies; Jamil's hPanel steps (password, two-factor login, cron, FTP/SSH users and keys, email password); malware scan of the other sites on the shared Hostinger account; production (F-033) untouched.

## F-036 · Hidden ways back in on .online, and the shared account
**Date:** 18 October 2026 · **Status:** `[VERIFIED]` read-only through Novamira; nothing changed (Jamil: "check .online for the hidden ways back in that I can see from inside WordPress")

- **Active attacker logins:** admin `reinforcelab` (`reinforcelab@wp-ads.net`, created 12 Mar 2026) has WordPress login sessions dated 9, 14, 15 and 16 October 2026, from 157.22.72.125, 209.99.185.18 and 84.15.184.66. The fake "Event" plugin files are dated 9 Oct 01:03. Jamil's own sessions and Novamira's application password come from 103.231.229.110. The other unknown admins have no sessions or application passwords.
- **Loader in `wp-config.php`:** line 3 `@include_once(__DIR__ . "/wp-includes/class-wp-cache.php");` is not part of WordPress; the file does not exist now (removed, perhaps by a host scan), so the line does nothing until the file is put back.
- **Hidden cron tasks:** `_1sgjdxjsuyxct0tzy8`, `h072tqv7v631md8u`, `fxuh8e_9aidtaz1m` (hourly; no callback attached at present, so dormant until their code is loaded). `run_weekly_partner_astra` and `puc_cron_check_updates-hostinger-ai-assistant` are leftovers of plugins that are not installed.
- **Clean:** PHP `auto_prepend_file` and `auto_append_file` empty; no `.user.ini` or `php.ini` in the site; root `.htaccess` is LiteSpeed plus standard WordPress rules; no options containing code; WordPress core 7.1.3: all 3,782 files match wordpress.org checksums, no extra files in `wp-admin` or `wp-includes`; Yoast SEO 28.6 (1,938 files), Jetpack 16.3 (4,202), LiteSpeed Cache 7.9.1 (323) match their official checksums with no extra PHP. Premium plugins (Beaver Builder, Themer, PowerPack, ACF Pro, Yoast Premium, Novamira) cannot be checked this way: they are to be replaced from the vendors.
- **Corrections to F-035:** `/default.php` and `/outreach/default.php` are Hostinger's default parked page (HTML), not a webshell; `.private/config.json` is Hostinger's own settings file.
- **Shared account:** the Hostinger user `u256952650` holds about 20 sites (folder names only, no files opened): advocategazi.com, aitoolsonfire.com, bestsportsmag.com, bookreviewsonfire.com, civicheadlines.com, digitallearningland.com, farsightx.com, farzanasabera.com, ipromag.com, jadirectives.com, jazabfragrances.com, kaifoverseas.com, laylearn.com, premiumbrandshop.com, ranksonfire.com, ranksonfire.site, reinforcelab.com, reinforcelab.online, signaturejeansbd.com. All run as one server user, so one infected site can change all of them. Several keep backup archives inside their web folders (ai1wm, updraft, aiowps, wpfm), which often hold full copies of `wp-config.php`.

---

## D-196 · Clean rebuild instead of moving .online
**Date:** 18 October 2026 · **Status:** APPROVED (Jamil, 15 Oct: "shall we delete entire website on .com and install a new WordPress ... for cleaning all previous unnecessary things and malware"; 18 Oct: "Let's do this super step by step within next 24 hours"; on F-035: "jadirectives@gmail.com is mine. Com and .online both on the same hostinger account. Yes I you can start")

- **Plan:** the new reinforcelab.com is a fresh WordPress on new hosting (not the compromised Hostinger account). Code from this repository; Beaver Builder theme and plugins downloaded new from the vendors with Jamil's licences; content and settings imported from `claude/data/site-export/`; media brought across as images, PDFs and fonts only, each matched to its sha1 and file signature. The old account is kept offline as evidence for 30 days. Steps and owners in `claude/migration-checklist.md`.
- **Step 2.1 done:** `claude/tools/export-site.py` (read-only) wrote `claude/data/site-export/`: 57 pages, 81 posts, 3 projects, 175 media records, 53 menu items, 1 Themer layout, the ACF setup, custom CSS; 27 terms; 267 settings (licences, tokens, passwords, hashes, Jetpack, Novamira, Hostinger, Cloudflare excluded; `litespeed.conf.hash` removed after review); 3 authors (no passwords); 2,318 media files, 69.6 MB, every file signature matches its extension. Scan of every exported field for script, iframe, PHP and obfuscation: 0. Left behind: the dev `.htaccess`, the dropper zip, plugin caches, the unused themes `twentytwentyfive` and `wise-news`, the 2 form submissions (personal data).
- **Correction:** I told Jamil on 15 Oct that `.online` was clean; F-035 showed it is not.

---

## F-035 · reinforcelab.online is compromised
**Date:** 18 October 2026 · **Status:** `[VERIFIED]` by read-only checks through Novamira; **nothing changed or deleted** (evidence for the host); reported to Jamil. **Corrects F-033**, which said `.online` was clean: that check looked only for the spam links, not for backdoors.

Found while scanning `.online` uploads before the clean launch (Jamil, 15 to 18 Oct: delete `.com`, install fresh WordPress, launch clean):
- **Administrator accounts that are not ours** (7 admins in total; only `jamilahmed`, 23 Aug, is known): `WordPress Support` `support@wordpless.org` (misspelt domain, registration date faked to 2017), `root` `admin@wordpress.com` (2 Apr 2026), `reinforcelab` `reinforcelab@wp-ads.net` (12 Mar 2026), `d6bvip8jhrd@reinforcelab.online` (20 May), `ogbn0f5ynf@reinforcelab.online` (12 Jul), `jadirectives@gmail.com` (2 Apr, same second as `root`; to confirm with Jamil).
- **Must-use plugin `health-check-api.php`** (2 Apr): hooks `pre_user_query` in the admin, the usual way to hide attacker accounts from the Users screen.
- **Fake plugins:** `wp-content/plugins/lunar-profiler-ink/lunar-profiler-ink.php` (60 KB compressed payload, 3 Apr, not in the plugin list); empty folders `nimble-router-mod`, `onyx-store-tag`, `pulse-cache-ink`; "Event 1.0.2" (`plugins/event/`, all files dated 9 Oct 2026 01:03, includes `assets/datems.php`, 72 KB).
- **Other files:** `/default.php` in the site root (16 KB, 2 Apr), `wp-content/cache/2704f406.php` (3 Apr), `wp-content/uploads/2026/08/ab5c7c9b.zip` (a zip holding one obfuscated 188 KB PHP file posing as "Crux Publisher Ink" by "Ava Young"; not in the media library; 3 Apr).
- **Not affected:** our code in `wp-content/novamira-sandbox/` matches git (parity 0); uploads otherwise hold only images, PDFs, fonts and Beaver Builder caches; no spam strings in posts, postmeta or options; Hostinger's two must-use plugins look standard.
- **Timeline (inference):** first traces 12 Mar to 3 Apr 2026, before this project started (Aug); new files on 9 Oct. Production (F-033) may share the cause; unknown whether it is the same hosting account.

**Consequence:** `.online` cannot be copied to `.com` as it is. The launch plan changes to a fresh WordPress install on clean hosting, with our code deployed from git and content and media brought across as data only (no PHP), see the launch plan proposed to Jamil 18 Oct.

---

## D-195 · Pillars in the Best / List design
**Date:** 15 October 2026 · **Status:** DONE (Jamil: "Don't you think the best type posts are list post not reviews?"; on the proposal: "Yes list but it's still Pillars")

- **Rule taken:** "best X" pages are list posts (several options side by side); "X review" pages stay reviews; the "How to make a website with X" posts are how-to guides. The two pillars target "best" searches, so they use the Best / List design (D-077) and keep their pillar job: linking every post in their cluster.
- **Content, from Jamil's own text only:** `claude/tools/review-picks.py` reads the saved production copies (8 Oct) of `/best-web-hosting-services/` and `/ai-content-writing-tools/` and writes `pages/reinforce-reviews-picks.json`: each pick's name, his "Best For" heading, his first paragraphs, pros and cons (hosting), "Why we picked it" and "Who it is for" (AI tools: the post's pros and cons headings are empty on production), and his own link. Order as in his posts. Only changes: proper names (Liquid Web, DreamHost, InMotion Hosting, SiteGround, A2 Hosting) and the copy rules (D-072): "robust" to "strong" (2), "cutting-edge" to "latest" (2), dashes to commas.
- **Layout:** List hero with the top three as a podium; the Ad note naming the partners; a line that there are no scores or prices until the first-hand rewrite; shortlist bar; "Compare all" table (#, name, best for, our guide); "Our picks in detail" (rank rail, badge, intro, more text, pros and cons, "Visit" link with Ad tag, link to our setup guide, review or the WP Engine partner page); then "How to choose", every guide or review in the cluster as cards, FAQs, call to action. The List styles load on these two pages through a new `rl_list_css` filter in `blog/reinforce-post-list.php`.
- **Canonical:** each pillar is its own canonical page again (D-193's canonical to `/ai-content-writing-tools/` removed); the pillar shows summaries and links to the full post. **Overlap to watch:** `/reviews/best-wordpress-hosting/` and `/best-web-hosting-services/` (and the AI tools pair) cover the same picks; when Jamil rewrites them, consolidating each old list into its pillar with a 301 is the cleaner end state, which needs his approval per URL (rule 2).
- **Affiliate formats added** (D-194 module): Liquid Web (`*.i3f2.net`), InMotion (`partners.inmotionhosting.com`), Kinsta (`kaid=`), Cloudways (`id=`). `/best-web-hosting-services/` now labels all 18 of its affiliate links.
- **Titles:** "Best Web Hosting for WordPress: 15 Picks | Reinforce Lab" (56), "5 Best AI Content Writing Tools | Reinforce Lab" (47); descriptions 151 and 139.
- **Schema:** the ItemList on each pillar is the ranking in editorial order (`ItemListOrderAscending`, no ratings, as D-086), plus CollectionPage and FAQPage.
- **Checks:** 15 and 5 picks, 15 and 5 table rows; every Visit link `rel="sponsored"` with one Ad tag, one note; no sideways scroll at 390 and 1440; axe 0 on both at 390 and 1440; no script errors; copy check 0.

---

## D-193 · AI writing tools text on /reviews/best-seo-ai-tools/
**Date:** 14 October 2026 · **Status:** DONE (Jamil: "https://reinforcelab.online/reviews/best-seo-ai-tools/ this is a list post and where is my text"; offered A (a list built from the 8 reviews), B (use the "5 Best AI Content Writing Tools" text), C (another page): "B")

- **Checked first:** production has no page at `/reviews/best-seo-ai-tools/` or any "best SEO AI tools" page (8 Oct inventory; the live check was blocked, F-032 again). The nearest is the list post `/ai-content-writing-tools/` (post 358 on `.online`, carried unchanged in D-178).
- **The page now:** hero "The 5 best AI content writing tools."; the post's full text, read live from post 358 (so a rewrite of the post shows here too), with its own H1 removed and a contents list of its H2s; then "More SEO and AI tool reviews" with the 8 tool cards. The "how to choose" list and the page's own FAQs were removed: the post has its own FAQs. Yoast title "5 Best AI Content Writing Tools | Reinforce Lab", description 134 characters.
- **Duplicate text:** the same words now sit at two addresses. This page's canonical points to `/ai-content-writing-tools/` (Yoast `wpseo_canonical`), so the post keeps its ranking and this page does not compete with it. Yoast prints no canonical on `.online` because the whole site is noindex; it will after launch.
- **Checks:** 200; one H1; 29 affiliate links labelled once each; no sideways scroll at 390 and 1440; axe 0 at both; no script errors.

---

## D-194 · All affiliate links labelled
**Date:** 14 October 2026 · **Status:** DONE (applies D-122: every affiliate link is marked Ad, `rel="sponsored"`, with a note at the top)

- **Found:** building D-193, the Jasper, Copy.ai, Writesonic, Rytr and Anyword links had no Ad label: the module only knew Semrush and WP Engine formats. A scan of all published posts found referral links in 15 carried posts: Jasper, Copy.ai, Surfer SEO, Anyword, Writesonic, Rytr (`?fpr=`, `?via=`), Bluehost, Hostinger, Namecheap, Nexcess, DigitalOcean, Rank Tracker (Impact `*.sjv.io` / `*.pxf.io`), DreamHost (`aff_id`), Bluehost (`clickid`), ShareASale.
- **Change (`core/reinforce-affiliate.php`):** those formats are recognised and named (partner name map); labelled links carry `data-aff`, so a page that shows another post's text does not label them twice. Ordinary links, and look-alikes such as Instagram's `ref=igb_carousel`, are not labelled.
- **Also (`blog/reinforce-post.php`):** in carried posts, a logo image with no alt text that is the only content of a link to another site gets that site's name as alt text (axe `image-alt` and `link-name` on the AI tools table).
- **Checks:** `/ai-content-writing-tools/`, `/reviews/best-seo-ai-tools/`, `/hostinger-web-hosting/`, `/dreamhost-wordpress-hosting/`, `/surfer-seo-review/`: every referral link labelled, none twice, none missing `sponsored`, one note naming the partners; the Instagram post and `/blog/` unchanged; WP Engine page still 2 labels; axe 0.

---

## F-034 · Other people's affiliate codes in carried posts; missing logos
**Date:** 14 October 2026 · **Status:** `[VERIFIED]`; nothing changed in the links; for Jamil

- **Codes:** Jamil's: Jasper `fpr=jamil39`, Copy.ai `via=jamil`, Anyword `fpr=jamil70`, Surfer SEO `fpr=jamil35`. Not his (by the code): Writesonic `via=rahat10` (3 links in `/ai-content-writing-tools/`, also in `/writesonic-review/`) and Rytr `via=md-rahat` (1). Commission from those goes to whoever owns those codes. The Impact, DreamHost and Bluehost links carry numeric ids that do not show the owner.
- **Missing images:** the Writesonic, Jasper and Rytr logos in the AI tools comparison table (`/wp-content/uploads/2022/11/*-logo-reinforce-lab.png`) were never copied to `.online`. To copy with `carry-posts.py media` once production stops refusing the `.online` server.
- **For Jamil:** which codes to use (replace the Rahat links with his own, or keep), and the WP Engine-style partner links for the hosts if he has them.

---

## D-192 · Reviews linked from the footer and the blog
**Date:** 14 October 2026 · **Status:** DONE (Jamil: "yes, add it to the footer and blog")

- **Footer:** "Reviews" under Resources, after "Get your free diagnostic" (`core/reinforce-header.php`), so every page links to `/reviews/`.
- **Blog:** a strip under the topic chips on `/blog/` and every topic page: "Reviews: WordPress hosting and SEO tool reviews, in one place", linking to `/reviews/` (`blog/reinforce-blog.php`). It shows only while the hub page exists.
- **Found while there:** the blog's topic chips and its "More topics" label were 11px, under the 12px minimum (D-139); both now 12px.
- **Checks:** footer and strip links resolve to `/reviews/` on `/blog/` and `/seo-tips/`; no sideways scroll at 390 and 1440; axe 0 on `/blog/`; no script errors; copy check 0.

---

## D-191 · Reviews hub and pillars
**Date:** 14 October 2026 · **Status:** DONE on `.online` (Jamil: "yes, build the three pages now nothing will be eliminate keep all the posts we will rewrite later"; hub approved D-014b, URLs D-016, task D-145)

- **Pages:** the three empty drafts created on 20 Sep were filled and published (read first: empty content, no template, no Yoast values): `/reviews/` (67), `/reviews/best-wordpress-hosting/` (69, child of 67), `/reviews/best-seo-ai-tools/` (70, child of 67). New module `pages/reinforce-reviews.php`, `[reinforce_reviews view="hub|hosting|tools"]`, in loader. Yoast titles 58 to 59 characters, descriptions 126 to 131.
- **Hub:** the two pillars as large cards; "How we review" (first-hand, paid or free stated, affiliate links marked Ad and `rel="sponsored"`, no paid placement, cheaper option named when it fits; same commitments as `/ftc-disclosure/`); every post as a card, grouped WordPress hosting, SEO tools, AI writing tools, Work and website tools; 3 FAQs; call to action.
- **Hosting pillar:** six questions for choosing a host (shared or managed, visitor location, backups and staging, WordPress support, renewal price, moving in and out); cards for WP Engine (our partner page) and the 9 host setup guides; the 2 comparison lists; 3 FAQs.
- **Tools pillar:** six points for choosing a tool; Semrush, Surfer SEO, Rank Tracker; Copy.ai, Writesonic, Jasper; ClickUp, Beaver Builder; 3 FAQs; Semrush partner and affiliate stated.
- **No rankings, scores, prices or "best" claims:** the carried posts are not first-hand yet. Each card shows the product, what kind of product it is, one plain line written for the card, the post type and its last-updated date. The cards do not show the carried titles, which keep old wording ("2025", en dashes) until each rewrite. The hosting posts are labelled as setup guides because that is what they are.
- **Schema:** WebPage + CollectionPage, ItemList of the linked posts (19, 11, 8), FAQPage; breadcrumbs from Yoast.
- **Checks:** all 3 pages 200 and noindex on `.online`; one H1 each; 20, 12 and 8 cards, every link 200; all 15 card images 200 (posts without a featured image show the brand panel); no sideways scroll at 390 and 1440; axe 0 on all three at 390 and 1440; no script errors; copy check 0.
- **Next:** (linked from the footer and blog in D-192) Jamil's review facts per product, affiliate links other than WP Engine and Semrush.

---

## F-033 · Production is hacked: hidden spam links on every page
**Date:** 14 October 2026 · **Status:** `[VERIFIED]` (read-only GETs from the `.online` server); nothing on production changed; reported to Jamil

- **What:** the HTML of `/`, `/about-us/`, `/contact-us/`, `/blog/`, `/services/` and `/agency-partner-program-wp-engine-landing/` all contain the same block: `<div style="position: absolute; left: -20914565266523px; top: 0px;">` holding 25 links, each `rel="sponsored"`, to 25 domains: unyu168a.com, api288a.org, gacoan88a.it.com, idnasia88a.org, topanwin1.org, bighoki1.org, indocair1.org, ledak388a.org, super33a.org, pisang123a.org, wawaslots.com, bidikbets.com, biru777a.com, rajapadi4dd.com, giatsaydanang.net, reisetips.net, barisyildirim.net, 8idd.it.com, livewebcamtwinks.com, sf-g.com, alwaraqalabyad.com, bni789a.it.com, mc777a.org, gg999a.org, vm777a.org (Indonesian gambling, one adult site, others).
- **Where it comes from (inference from position):** printed in the footer after WordPress's own `speculationrules` script and before WooCommerce's footer script, so it is added by PHP running on the `wp_footer` hook: a plugin, a must-use plugin, the theme's `functions.php`, or code stored in the database. Not in post content.
- **When:** not known. The 8 October inventory recorded only links inside page content, so it would not have caught it.
- **Why it matters:** hidden links are against Google's spam policies ("hidden text and links", "link spam") and a hacked site can get a "This site may be hacked" label or a manual action in Search Console. It may also explain part of the traffic collapse: that is INFERENCE, not shown. The server-side block seen on 14 Oct (F-032) may have been the host reacting; also unproven.
- **`.online`:** no spam links on 5 rendered pages or in the database (posts, postmeta, options). **Corrected 18 Oct (F-035): `.online` itself has backdoors and unknown admin accounts; this check only looked for the spam links.** The carried posts were copied from production's REST API `content` field, which does not include footer output. No match anywhere in the repository.
- **For Jamil (production is his to change):** run a malware scan with the host or a security plugin; check `wp-content/mu-plugins/`, the theme's `functions.php`, recently changed plugin files and unknown admin users; change all admin, hosting and database passwords; then check Search Console for Security Issues and Manual Actions. After cleaning, the block should be gone from the page source (search for "left: -20914565266523px").
- **Also found on the same page (not a problem):** the old WP Engine page's partner link is `https://wpengine.com/more/partnerspecialoffer/?w_agcid=kn5tE5th`; it matches the affiliate format `core/reinforce-affiliate.php` accepts. Jamil confirmed it is his ("its mine"); saved, see D-190.

---

## D-190 · WP Engine partner page
**Date:** 14 October 2026 · **Status:** DONE on `.online`; WAITING on the WP Engine partner link (Jamil: "Rebuild the WP Engine partner page ... I will give the link later make it now"; restore approved in D-182; sign-off: PRESERVE at slug, rel=sponsored, FTC disclosure, keep indexed)

- **Page:** `/agency-partner-program-wp-engine-landing/` (page 505, new module `pages/reinforce-wpengine.php`, `[reinforce_wpengine]`, in loader). Title "WP Engine Agency Partner: Hosting Set Up by Reinforce Lab"; description 131 characters. Breadcrumb Home, WordPress Website Design, WP Engine partner. Sections: hero ("WordPress hosting on WP Engine, set up by Reinforce Lab", partner badge); what WP Engine does (speed, site management, security, WordPress support, the four themes of the old page's icons, sourced to wpengine.com with "plans differ"); what we do (build, move with every URL mapped and redirects tested, look after, grow); "WP Engine is not the cheapest host" (who it suits, and that we do not require it); disclosure (affiliate programme and agency partner, commission at no extra cost, prices and terms on WP Engine's page; same wording as `/ftc-disclosure/`); 5 FAQs; closing call to action. Schema: WebPage about the Organization, mentions WP Engine; FAQPage. No Product or Offer.
- **No offer or price is stated:** the old page could not be read (F-032), and WP Engine sets and changes its own offer.
- **The partner link:** read from the option `rl_awards_wpengine_url`, the same one the Awards page waits on, and accepted only if it is a WP Engine affiliate format (`wpengine.com/partnerspecialoffer/`, `w_agcid`, `wpengine.sjv.io`). With no link: the main button is "Ask us about WP Engine hosting" (Contact) and no Ad note shows. With the link: "See WP Engine's partner offer" in the hero and the closing section, each `rel="sponsored nofollow noopener"` with an Ad tag beside it, plus the Ad note under the hero buttons. Saving Jamil's link turns on this page and the WP Engine card on `/awards/` together.
- **Affiliate module (`core/reinforce-affiliate.php`):** does not add its own top note when the page already carries one; the Ad tag is 12px (was 10.5px, under the 12px minimum).
- **Fix found while testing:** the site makes any row of two buttons an equal-width grid, which stretched the Ad tag into a full column. The partner button and its tag now share one wrapper.
- **Checks, both states** (with no link, and with a temporary test link `w_agcid=TEST-RL` that was removed straight after): 200, noindex on `.online`, one H1, no sideways scroll at 390 and 1440, axe 0, no script errors, copy check 0.
- **Partner link saved, 14 Oct** (Jamil, on the link found on the old page in F-033: "its mine"): `rl_awards_wpengine_url` = `https://wpengine.com/more/partnerspecialoffer/?w_agcid=kn5tE5th` on `.online`. The partner page now shows "See WP Engine's partner offer" twice, each `rel="sponsored nofollow noopener"` with an Ad tag, and one Ad note; the WP Engine Agency Partner card on `/awards/` is on, with its Ad tag and note. axe 0 on both pages at 390 and 1440; no sideways scroll.
- **Still to do:** link this page from the `/reviews/` hub when it is built (sign-off); after launch the page is indexed (PRESERVE).

---

## F-032 · Production refuses reads from the `.online` server
**Date:** 14 October 2026 · **Status:** RESOLVED the same day (Jamil: "resolved"); `/`, `/about-us/`, `/page-sitemap.xml` and the WP Engine page all 200 again

- From the `.online` server (`wp_remote_get`, default and browser user agents), on 14 Oct: `https://reinforcelab.com/` 403; `/about-us/`, `/agency-partner-program-wp-engine-landing/`, `/page-sitemap.xml` and the REST API all return the same 4,511-byte "This Page Does Not Exist" page. The same reads worked on 8 Oct (production inventory) and 13 Oct (carried posts).
- **Inference:** a firewall or security rule on production now blocks the `.online` server's address; it is not evidence that the pages were removed. Jamil to check in a normal browser and in the host's security settings. Nothing on production was changed.
- **Effect:** read-only checks of production from here (redirect test sources, media copies) will fail until it is lifted.

---

## D-189 · About: industries as cards
**Date:** 14 October 2026 · **Status:** DONE (Jamil, on a screenshot of About: "the industries are presented poorly")

- **Before:** a row of eight small uppercase chips under "Eight industries", with no description.
- **After:** eight linked cards, 4 columns on desktop, 2 at 1000px and below, 1 on phones. Each card: number, industry name, the one-line summary already used on its industry page (`rl_ind_data()['sum']`), and an arrow; a red top line widens on hover. "See all industries" links to `/industries/` beside the heading. A card without a page renders as plain text, not a dead link.
- **Checks:** no sideways scroll at 390, 900 and 1440; axe 0 at 390 and 1440; copy check 0.

---

## D-188 · Company profile link on About; redesign after launch
**Date:** 14 October 2026 · **Status:** DONE (Jamil: "Add a 'Download our company profile (PDF)' link on the About page. Shall I? Yes"; "after we migrate the website to .com we will redesign the company profile, remind after migration")

- **About (`/about-us/`):** a "Download our company profile" link with the file size (PDF, 609 KB) and a drawn download icon, at the foot of the At a glance panel in the hero. It links to `/wp-content/uploads/2022/03/Reinforce-Lab-Company-Profile.pdf` (D-187) and only shows while that file exists, so a missing file never leaves a broken link.
- **Checks:** link resolves to the PDF; no sideways scroll at 390 and 1440; axe 0 at both; no script errors; copy check 0.
- **Redesign after launch:** the migration has no date yet, so a timed reminder would fire at the wrong moment. The reminder sits in `claude/migration-checklist.md` under B3 (after the switch); raise it with Jamil once `.com` is live.

---

## D-187 · Company profile PDF
**Date:** 13 October 2026 · **Status:** DONE (Jamil: "WP Engine partner page and company profile PDF rebuilt for as per our new website" (D-182); on the draft: "finish it")

- **What:** a new company profile in the site's design (dark ground, brand red, Oswald, IBM Plex Sans and Mono, square corners), 9 pages, A4 sideways: cover (core message and positioning); who we are (story, facts table); what we build (three jobs, Search Authority OS loop); services (4 groups, 18 services) and the 8 industries; how we work (4 steps, 9-stage method); principles; awards and recognition; the 46 named clients; contact (both offices, email, phones, diagnostic). Every fact is already published on `.online` (About, Awards, Clients, Services, Legal Statement). Copy check 0.
- **Where:** `/wp-content/uploads/2022/03/Reinforce-Lab-Company-Profile.pdf` on `.online`, the same address production uses (kept by the sign-off list, row 28), so links to it keep working after launch. 623,251 bytes, md5 `51731d2d9787956107d7371ae06c5e38`; answers 200 `application/pdf` with `X-Robots-Tag: noindex, nofollow` (the dev site rule). Nothing was there before (404), so nothing was overwritten.
- **Source:** `claude/content/company-profile/company-profile.html`; rebuild with `node claude/content/company-profile/render.mjs` (it checks that every font loads and that no page runs into its footer).
- **Taken as approved with "finish it"** (asked on the draft, no separate answer): the legal-entity line on the contact page (Reinforce Lab Limited, RJSC no., Reinforce Lab Inc), the same exception as the Legal Statement; Jamil's bio line on page 2, taken from the About page; links to `reinforcelab.com/search-authority-diagnostic/` and `/awards/`, which work after launch.
- **Not done:** no page on `.online` links to the PDF yet.

---

## D-186 · Home: blog and awards intros stacked on the left
**Date:** 13 October 2026 · **Status:** DONE (Jamil, on screenshots of D-185: "keep the sub headline below headline", "Place the button below blog posts", "Place the text of subheading on the awards section on the left as well")

- **Blog section:** eyebrow, "From the blog." and the one-line intro now stack on the left, like the other home sections; the "Read the blog" button sits below the three cards. The two-column heading row from D-185 is gone.
- **Awards and recognition (inside Clients):** the intro text sits under the heading on the left instead of in a right-hand column.
- **Checks:** axe 0 at 390 and 1440; no sideways scroll at 390 and 900.

---

## D-185 · Home blog section, home overflow fixes
**Date:** 13 October 2026 · **Status:** DONE (Jamil: "First change the Blog section in the home page. I don't like it organize it differently so that it looks professional")

- **Blog section:** the old split layout (one large post beside a list) replaced by a heading row (eyebrow and "From the blog." on the left; the lede and the "Read the blog" button on the right) above three equal cards. Each card: a 16:9 featured image, or the brand panel with the post type and category when a post has no image; then type, date and main category; the title; a 22-word excerpt; "Read article". Three columns on desktop, two at 1000px and below (third card hidden), one at 600px and below (all three). Same three latest posts as before.
- **Overflow fixes found while testing (were already there):** the Search Authority OS panel used `1.4fr 1fr` tracks and only stacked at 820px, so from 820 to about 940px the step list pushed the page 20 to 40px wider than the screen; it now uses `minmax(0, ...)` tracks and stacks at 940px, like the hero. The testimonial grid below 820px now uses a `minmax(0,1fr)` track.
- **Scroll-in tilt:** cards waiting below the fold sit in a tilted 3D start state (D-171) and were a few pixels wider than the screen until they rose in (seen at 800px). `.rl-home` and the kit's `.rl-page` now have `overflow-x: clip` (it does not create a scroll box, so sticky panels on posts still stick; checked).
- **Checks:** no sideways scroll on home at 390, 760, 800, 820, 860, 900, 960, 1000, 1100 and 1440; axe 0 at 390 and 1440; scroll test on home (1440, 390), Technical SEO (390), Healthcare (1440), About (390): no layout shift, no script errors.

---

## D-184 · Category addresses, Careers headline, titles with "2025"
**Date:** 13 October 2026 · **Status:** DONE (Jamil: category pages at production's addresses "Yes"; "2025" in titles "Yes C"; the CV-data line "Okay"; the quoting line "Yes"; Careers: "Change the title it should focus on Career")

- **Category addresses:** Yoast option "remove the /category/ base" switched on (`wpseo_titles.stripcategorybase`, backup of the old value in `claude/data/backups/category-base-before-2026-10-13.json`), rewrite rules refreshed with a soft flush (no `.htaccess` write, F-030). Category archives now answer at production's addresses: `/seo-tips/`, `/digital-marketing/`, `/digital-marketing/search-engine-optimization/`, ...; the old `/category/...` addresses 301 to them (Yoast). Checked first: no page, post or project uses a category's address (25 categories). After: all 137 published pages and posts 200; `/seo-tips/`, `/seo-tips/page/2/`, `/digital-marketing/` 200. Page 2+ of any archive is `noindex, follow` by the blog template, matching the approved map (KEEP-NOINDEX). The 30 category addresses the map redirects answer 200 until the redirect map is in code (A4).
- **Careers:** H1 changed from "We are not hiring right now." to "Careers at Reinforce Lab."; the lede and the "Open roles: none" line stay.
- **Confirmed by Jamil:** the Careers line on CV data ("We use your CV only to consider you for work at Reinforce Lab, and delete it whenever you ask") and the Legal Statement quoting line.
- **"2025" in titles (option C):** the 46 post titles and 40 Google titles with "2025", the publish dates and the text stay as they are; the year changes in each post when Jamil rewrites it (F-003). Options A (change titles only) and B (remove the year) not taken.

---

## D-183 · Careers and Legal Statement pages
**Date:** 13 October 2026 · **Status:** DONE (Jamil: "Are you hiring now? ... No not hiring", "should I start from production's current Careers and Legal Statement text ... No Start fresh"; both kept by D-182)

- **Careers (`/careers/`, page 504, new module `pages/reinforce-careers.php`, `[reinforce_careers]`, in loader):** hero "We are not hiring right now." with a status line (open roles: none); the work we do (SEO and AI search, AI workflow automation, WordPress builds, from the real services); what to send (CV as PDF, 2 or 3 pieces of work, location and hours, kind of role) to hello@reinforcelab.com with "CV" in the subject; closing call to action. No JobPosting schema while there are no open roles; WebPage about the Organization. Yoast title and description set. Breadcrumb Home, About, Careers.
- **Legal Statement (`/legal-statement/`, page 503):** uses the existing legal layout (D-120), text in `claude/content/legal-statement.html`. Only facts already on record: Reinforce Lab Limited, RJSC no. C-180618/2022, incorporated 19 April 2022 in Dhaka, registered office (footer address), link to the Certificate of Incorporation PDF, founder Jamil Ahmed; Reinforce Lab Inc, Katy, Texas; email and both phone numbers. Sections: who runs the site, contact, what you read here (general information, no promised results), copyright and names, links, affiliate links, related policies. The legal names appear on this page only, as the page's purpose (brand rule exception stated to Jamil).
- **Footer:** Careers added under Company, Legal Statement under Resources (`core/reinforce-header.php`).
- **Checks:** both 200 and noindex, one H1, no sideways scroll at 1440 and 390, no script errors, axe 0, copy check 0.
- **For Jamil to confirm:** Careers says "We use your CV only to consider you for work at Reinforce Lab, and delete it whenever you ask"; the Legal Statement allows quoting "a short part of an article" with a link and asks permission for more. Both are policy statements he has not given before.

---

## D-182 · Changes to the approved map; pages to build
**Date:** 13 October 2026 · **Status:** APPROVED (Jamil: "I want to redirect Our Team, Management, Keep and create Legal Statement. Keep and create Careers. Restore: the WP Engine partner page and the company profile PDF. yes ... /services/creative/ and its graphic design page no need redirect")

- **Redirects (map and sign-off list updated):** `/our-team/` (29 clicks, 1 backlink) and `/management/` (10 clicks) 301 to `/about-us/` (founder and team story); `/services/creative/` and `/services/creative/graphic-design-services/` (151 impressions, 1 backlink) 301 to `/services/` (the service is not offered). Targets chosen by me and stated to Jamil; his reading of "no need redirect" taken as "not needed, redirect".
- **Keep and build:** `/legal-statement/` and `/careers/` (18 clicks).
- **Restore:** `/agency-partner-program-wp-engine-landing/` (7,340 impressions; affiliate page: `rel=sponsored`, FTC disclosure) and `/wp-content/uploads/2022/03/Reinforce-Lab-Company-Profile.pdf` (6 clicks).
- **Category pages (data, VERIFIED from the map):** 51 production category addresses, 0 clicks and 113 impressions in 16 months together (74 on `/digital-marketing/`). The approved map keeps 2 (`/digital-marketing/`, `/seo-tips/`), keeps 17 page-2 copies hidden from Google, redirects 30 and removes 2. Recommendation to Jamil: serve category archives at production's addresses (WordPress/Yoast "remove /category/ from category URLs", as production does), so the kept ones answer at the same address with no redirect; the rest follow the map. Waiting for his yes.

---

## D-181 · Redirect sign-off approved
**Date:** 13 October 2026 · **Status:** APPROVED (Jamil, after receiving the list: "We can approve this for now and we can redirect later what we don't want right")

- **What is approved:** every line of `claude/redirect-signoff-list.md` (241 old reinforcelab.com addresses: 106 stay at the same address, 104 move to the new page shown, 18 stay but hidden from Google, 13 removed), plus the ~575 junk and dead addresses as one group under the fixed rules in D-149 (removed, or follow their main page). This is the per-URL approval CLAUDE.md Rule 2 requires for these URLs.
- **Told to Jamil:** yes, a line can be changed later. A kept address can be redirected after launch with no loss; the 13 removals and 104 moves are the ones that are slow to undo once Google has processed them (all 13 removals have 0 clicks; the moves follow D-146 to D-149).
- **Consequences for the build (before launch):** the 106 "stay" addresses must answer 200 on the new site. On 12 Oct, 97 of 124 stay/stay-hidden addresses did (after D-178). Still to build or restore: `/our-team/`, `/careers/`, `/management/`, `/legal-statement/`, `/agency-partner-program-wp-engine-landing/`, the company profile PDF, production's category archives without the `/category/` base (`/seo-tips/`, `/digital-marketing/` and their page-2 copies), and `/services/creative/` with `/services/creative/graphic-design-services/` (approved as "stay" although that service is not offered; Jamil can switch them to a redirect later).
- **Next (checklist A4):** put the approved map in code on `.online` (one file, in git), point the carried posts' internal links straight at final pages, then the zero-failure redirect test.

---

## D-180 · Blog index organised
**Date:** 12 October 2026 · **Status:** DONE (Jamil, with a full-page screenshot of `/blog/`: "Fist fix the blog. Organize the blog. there is no gap between posts")

- **Found (VERIFIED from the screenshot and the template):** cards sat edge to edge (`gap:1px` with hairline shadows); the filter row listed all 22 production categories; Jamil's own post has no featured image, so its card was a tall empty box; 10 posts per page in 3 columns left one card alone on the last row.
- **Changed (`blog/reinforce-blog.php`):**
  - cards spaced (`clamp(16px,2vw,24px)`), each with its own border and a red edge on hover;
  - each card's line reads type, date, main category (D-179); the category link is underlined as well as red (axe `link-in-text-block`, WCAG 1.4.1);
  - a post without a featured image shows a brand panel (type in red mono, main category in Oswald, red rule) instead of an empty area; a post with only the default category shows "Reinforce Lab";
  - the filter row lists main categories only (`rl_blog_main_cats()`, from each post's main category), busiest first, with counts: the 8 with 3 or more posts in the row, the 8 smaller ones under a "More topics" button (native `<details>`); the current category always shows in the row;
  - 12 per page on the blog and its category and tag archives (`pre_get_posts`, main query only, F-001): 7 pages. The redirect map only lists `/blog/page/2/` (KEEP-NOINDEX), which still exists; `/blog/page/8/` and later now 404 as expected.
- **Checks:** `/blog/`, `/blog/page/2/`, `/blog/page/7/` and a category archive 200; 12 cards per page; no sideways scroll at 1440 and 390; no script errors; axe 0 on `/blog/` and `/blog/page/3/` at both widths. Screenshots desktop and phone.
- **For Jamil later:** his post "What is an AI Growth System?" has no category and no featured image (the brand panel stands in).

---

## D-179 · Carried posts: types, main categories, chapters
**Date:** 12 October 2026 · **Status:** DONE (Jamil approved the list `claude/blog-carried-posts-types.md`: "Yes"; the two agency lists: "Keep this"; the chapter and main-category fixes: "yes, do both fixes". On timing: ship the carried posts and improve them one by one after launch)

- **Types (approved list):** Guide 29, How-To 16, Explainer 10, Review 8, Best / List 6, Industry 5, Comparison 2, Opinion 2, Checklist 1, Update 1. Set as `rl_type`; the 5 Industry posts linked to Healthcare or E-commerce (`rl_i_industry`). **The 8 Reviews are on the Guide design for now:** the Review design prints a disclosure ("we paid for our own access ... We earn nothing if you buy" when its fields are empty), untrue for affiliate reviews; it needs Jamil's facts per post (paid or not, affiliate links or not). Tested first on 8 sample posts (one per type), then reverted, then applied.
- **Main category:** set as Yoast's primary category (`_yoast_wpseo_primary_category`); 13 posts did not carry their approved main category on production and gained it (their production categories stay, so category addresses keep working). New `rl_post_main_cat()`: primary category, else the first non-default one; used for the chip, breadcrumb, related posts (post template), blog cards (`reinforce-blog.php`) and research cards.
- **Chapters (render only, stored posts unchanged, no words changed):** for carried posts, empty heading tags are dropped (they held no text and became blank chapters or steps), and when the real sections are H3 (at least 4 H3s and at least three times as many H3s as H2s with text) H3 becomes H2 and H4 becomes H3. Median chapters per post 1 to 14; the How-To script now skips a step without a tick box (one post had thrown an error).
- **Layout found and fixed on the way:** with real chapter lists, long titles and code-like headings could widen pages on phones (Robots.txt post 627 px). Every bare `1fr` grid track in the post designs is now `minmax(0,1fr)` (91 tracks in 12 files; identical when nothing overflows); chapter titles wrap anywhere; long guides keep a compact cover (the "In this guide" list scrolls inside a 440 px box; the full list stays in the sticky rail).
- **Checks (VERIFIED):** all 80 carried posts plus Jamil's post: no sideways scroll at 390 and 1440, no script errors; breadcrumb shows the approved main category on all 80; published and modified dates unchanged (kept in the database after each meta write); no empty headings left. Screenshots: Guide, How-To, Industry, Explainer.
- **Open:** review facts from Jamil for the 8 reviews; one Explainer (`what-is-technical-seo-and-why-is-it-important`) still shows 2 sections (its old H2s are mostly empty and its 5 H3s sit under them; acceptable until the rewrite).

---

## D-177 · Layout shift after the lean pages
**Date:** 12 October 2026 · **Status:** DONE (Jamil chose option A, tune the stand-in fonts: "A ..never suggest any other fonts")

- **Rule (Jamil):** never suggest other fonts. Oswald, IBM Plex Sans and IBM Plex Mono stay; only the invisible stand-in faces used while they load ('Oswald Fallback', 'Plex Sans Fallback') are tuned.
- **Why it appeared:** with no render-blocking CSS left (D-174 to D-176), pages paint before the web fonts and before the whole HTML has arrived, so two kinds of movement became measurable.
- **Header, fixed (VERIFIED):** the browser painted the header from the first network chunk with 2 of 8 menu items (menu 234 px wide, centred), then widened it to 706 px when the rest arrived (layout shift 0.011 on desktop). `core/reinforce-header.php` now prints `<link rel="expect" href="#rl-header-end" blocking="render">` and a hidden marker after the header: no first paint until the header is parsed (Chrome 124 and later; other browsers ignore it; if the marker is missing, rendering unblocks at the end of parsing). After: that shift is gone (About desktop 0.013 to 0.004, Services 0.012 to 0.001 under desktop throttling).
- **Stand-in fonts, tuned (VERIFIED):** a tool (`scratchpad fbtune`) measured the height of every heading, paragraph, list item and button on the first screen with the real fonts and with the stand-ins at 19 sizes, on 57 pages. First pass at 1x density (12 widths), then on 14 real setups (phones 360 to 430 px at 2x to 3x and Lighthouse's 412 px at 1.75x, tablets 768 and 1024, desktops 1280 to 1920 including 1335 with a scrollbar). Result: Plex Sans stand-in 102.8% to 99.7% and Oswald 500 to 600 stand-in 76.8% to 73.4% (vertical overrides divided by the same factor, so line heights are unchanged); Oswald 400 and 700 were already at their best. Mismatches on real setups: Plex Sans 192 of 2,554 lines (7.5%, most at 360 px phones and 768 px tablets), Oswald 700 20 of 784, Oswald 500 to 600 13 of 1,969, Oswald 400 0.
- **Limit (honest):** a size factor cannot make Arial-based stand-ins break every line at the same word as Oswald or Plex Sans (letter shapes differ). On a first visit where a font arrives after the first paint, some lines can still re-wrap. Lighthouse after the changes: most pages 0 to 0.005; About desktop 0.032 (the intro paragraph gains a line at Lighthouse's 1,335 px width and nudges the centred panel), Services hub on Lighthouse mobile 0.05 (intro paragraph). Both are inside Google's "good" range (0.1) but above the 0.006 we have treated as "no shift". Repeat visits use cached fonts and do not shift.
- **Wrong turn recorded:** the first tuning pass used 1x density only; real phones are 2x to 3x and round letter widths differently. The second pass corrected it.

---

## D-178 · Kept production posts carried across
**Date:** 12 October 2026 · **Status:** DONE (Jamil: "meanwhile start carrying the blog posts across")

- **Which posts (VERIFIED):** production has 111 published posts (public REST API, read-only GET sent from the `.online` server, as in A2; the sandbox itself cannot reach reinforcelab.com). Matched to the draft redirect map: 80 KEEP (carried), 26 planned 301 and 5 planned 410 (not carried). The REBUILD-new posts that are KEEP in the map are carried as they are until each rewrite (checklist A3).
- **Record of what was carried:** `claude/data/production-posts/<slug>.json` (80 posts as production served them: content, dates, categories, featured image, Yoast head), `_categories.json` (27), `_featured-media.json` (76 of 80 featured images; 4 ids no longer exist in production's media library).
- **Kept exactly:** slug, title, the words (visible text compared before and after cleaning on all 80: identical), images at the same `/wp-content/uploads/` paths, publish date, modified date (set in the database after saving, F-003), categories (same slugs and names), Yoast title and description (stored as production renders them).
- **Structure-only changes:** inline `<script>` blocks dropped (one old reading-progress script; inline Article and FAQPage JSON-LD that would duplicate and contradict Yoast; the FAQ text stays in the post); Divi `<article class="et_pb_post">` wrappers unwrapped (2 posts); hidden WordPress embed iframes removed (the link they copy is still shown); links and images on reinforcelab.com made site-relative so they work on `.online` and after the switch. Links to URLs that will redirect are **not yet** pointed at their final pages: that waits for the redirect sign-off (D-149).
- **Author (D-145):** new user "Reinforce Lab team" (`reinforcelab-team`, contributor role, random password nobody holds, `.invalid` email). Template change: posts by that user credit the Organization as author in schema and drop the generic Person node; Jamil's own post keeps his Person. Updated date shown from production's modified date (`rl_updated`).
- **Safety:** each post saved as a draft, then set to published directly in the database, so WordPress publish actions (Jetpack social sharing, pings) never ran. Recorded as the agreed one-import exception to F-003 (checklist A3). Each post carries `_rl_carried` (production id and URL).
- **Media:** 2,029 files copied from production's uploads to the same paths on `.online` (read-only GET from the `.online` server); one filename with a double dot first blocked by the tool's path guard, guard narrowed and file copied.
- **Pilot then run:** 3 posts first (top traffic, Divi, embed), checked, then the other 77 in one run; 0 errors.
- **Checks (VERIFIED):** all 80 return 200; `<title>` and meta description equal production's Yoast values; noindex present; no reinforcelab.com images left; byline present; author credited to the Organization; all 1,636 own image URLs return 200; phone (390) no sideways scroll after a template rule that keeps classic captions with a fixed pixel width inside the column (2 posts had 1,034 px and 2,570 px captions). Blog index paginates to 9 pages. Must-stay URLs on the sign-off list working: 16 to 97 of 124.
- **Flagged for Jamil, not changed (old wording stays until each rewrite):** some Yoast titles end "Reinforce Lab Ltd" (brand rule says "Reinforce Lab"); the top-traffic post's meta description reads "Structured for AI Search: This article uses semantic HTML..."; 99 images in 12 review posts are embedded from other websites (hosting help pages, Cloudinary and others), as on production: they can break or be removed by their owners at any time and should be replaced with our own screenshots in each rewrite.
- **Still missing from the must-stay list (27):** pages `/our-team/`, `/careers/`, `/management/`, `/legal-statement/`, `/agency-partner-program-wp-engine-landing/`, the company profile PDF, `/services/creative/` and its graphic design page (to confirm with Jamil), and production's category archives without the `/category/` base (`/seo-tips/`, `/digital-marketing/` and their page-2 copies): needs a category-archive template built to F-001 and a decision on the category base.

---

## D-176 · Lean setup on every page
**Date:** 12 October 2026 · **Status:** DONE (Jamil: "yes, do it", on giving About, Contact, Portfolio and the blog the same treatment)

- **Checked first (VERIFIED):** the 27 remaining URLs (About, Awards, Blog, Clients, Contact, FTC, Packages, Portfolio and 3 case pages, Privacy, the diagnostic, Search Authority OS, Terms, the blog post, the 9 agents pages, 404, search) use none of the removed files: no inline jQuery (only the word "jQuery" in portfolio structured data), no Beaver Builder modules, no lightbox links, no embeds, no animate.css classes; the one form and icon on each is the hidden theme search box; the blog post's comment-reply script does not use jQuery and comments are closed.
- **Change:** `rl_lean_page` now covers every page, post, the blog index, search and 404 (archives stay retired, D-139). Trimmed Bootstrap and skin rebuilt over all 57 pages (Bootstrap 106 of 2,634 selectors, 8.7 KB; skin 253 of 959, 22 KB).
- **Checks:** 54 full-page screenshots (27 pages at 1440 and 390) identical before and after; computed styles of every element identical with trimmed and full CSS on all 57 pages at both widths (114 page-widths, `claude/tools/bs-trim/verify.mjs`); focus styles of the two forms identical (one 0 px outline colour differs, invisible); contact and diagnostic forms accept input; cookie bar closes; phone and mega menus work; 404 returns 404, search 200.
- **Speed (Lighthouse, 2 runs):** About mobile 99, 99, desktop 99, 99; Contact 99, 100 and 99, 98; the blog post 98, 99 and 99, 99; agents hub 99, 99 and 100, 93; Portfolio 99, 99 and 100, 99.
- **Found while checking:** a small layout shift when web fonts replace their stand-ins on some pages and widths (About on phones 0.016), now visible because pages paint before the fonts arrive. Handled in D-177.

---

## D-175 · Theme skin trimmed and the kit inlined on the lean pages
**Date:** 12 October 2026 · **Status:** DONE (Jamil, on the D-174 recommendation to trim the skin and inline the kit: "go ahead")

- **Skin:** the Beaver Builder theme skin (`uploads/bb-theme/skin-6aba2a89c9195.css`, 68 KB, render-blocking) trimmed with the D-174 method: 228 of 959 selectors match an element on the 30 lean pages; copy `core/reinforce-skin-lean.css`, 21 KB (3.3 KB compressed), printed inline in place of the link on lean pages.
- **Kit:** `core/reinforce-kit.php` prints `reinforce-kit.css` (12.6 KB, ours) inline at its usual spot (wp_head 21) on lean pages; other kit pages keep the cached link (D-044 still holds there).
- **Safety:** each trimmed copy records the md5 of the theme file it was cut from; `reinforce-speed.php` uses it only while the theme file is unchanged (a theme update, or a Customizer save, which writes a new skin, brings back the full file until the copy is rebuilt). Bootstrap copy rebuilt with the same header (content unchanged). Pages outside the lean set (About, agents, blog and the rest) keep the full theme files (checked).
- **Checks (VERIFIED):** computed style of every element and pseudo-element (64 properties) on all 30 lean pages at 1440 and 390, with the inline copies and then with the full theme files swapped back in: 0 differences on 60 page-widths (`claude/tools/bs-trim/verify.mjs`). Full-page screenshots: 59 of 60 identical; the industries hub at 1440 differed only in IBM Plex Mono text (breadcrumb, labels, source lines), which is `font-display: optional` and arrived at a different moment in the two captures. Menus, FAQ, scroll test (no layout shift, no errors), axe 0 on home, technical SEO and the industries hub.
- **Speed (Lighthouse, cached):** no render-blocking requests left. Home mobile 96, 96, 98, 97 (LCP 2.1 s, was 2.4 to 2.5 s), desktop 96, 98, 95, 96; technical SEO mobile 99, 99, 98 (LCP 2.0 to 2.1 s), desktop 99, 98, 96; healthcare mobile 98, 99, 99, desktop 99, 98, 99; CLS 0 to 0.001. Page weight: home 227 to 222 KB, technical SEO 158 to 153 KB.
- **Note:** home desktop sits at the 96 mark because the home motion (GSAP) starts at load for the hero loop (D-169, D-172); the other lean pages load it on first interaction.

---

## D-174 · Trimmed Bootstrap on the lean pages
**Date:** 12 October 2026 · **Status:** DONE (Jamil: "yes, build the trimmed Bootstrap")

- **Why:** on Jamil's PageSpeed report (D-173) the largest paint on a phone is the hero headline, and it waited about 0.9 s for two render-blocking style files: the theme's Bootstrap 4.6.1 (162 KB, 24 KB compressed) and the theme skin. Removing Bootstrap outright changed the layout (D-166).
- **Method (VERIFIED):** every selector in Bootstrap (2,634) was tested against the live DOM of the 30 lean pages (home, 20 under `/services/` without the agents pages, 9 under `/industries/`) at 1440 and 390, with states such as `:hover`, `:focus` and `::before` ignored so a rule is kept if its element exists (keeps more, never less). Our own scripts add no Bootstrap class names (checked: they add `on`, `done`, `slim`, `rl-mo`, `rl-mopen`, `tilting`, `is-paused`, `ge-gs`, `ca`, `cb`). 92 selectors match. The new file keeps the original text of those rules, in the original order and media queries: `core/reinforce-bootstrap-lean.css`, 8 KB (2.5 KB compressed), Bootstrap MIT notice kept.
- **Delivery:** `core/reinforce-speed.php` replaces the Bootstrap `<link>` on lean pages with the trimmed rules inline, at the same spot, so the cascade order is unchanged and there is one less file to wait for. Not while the page builder is open; falls back to the normal link if the file is missing. Other pages (About, blog, agents and the rest) keep the full file.
- **Tool:** `claude/tools/bs-trim/` (parse, match, build, with README). Re-run when a lean page gains markup Bootstrap might style (forms, tables, new elements).
- **Checks:** full-page screenshots of all 30 pages at 1440 and 390 before and after (60 pairs): same sizes, no pixel area above 0.05% changed on any page, no errors, no sideways scroll. Phone menu, mega menu and FAQ work on home, technical SEO and healthcare; scroll test no layout shift, no errors; axe 0 on home and technical SEO at both widths.
- **Speed (Lighthouse, cached):** home mobile 96, 96, 96, 97 (was 95, 95, 96, 97), LCP 2.4 to 2.5 s (was 2.3 to 2.7 s), first paint 1.5 s; home desktop 97, 96, 98, 96; technical SEO mobile 97, 95, 97 and desktop 97, 98, 97; healthcare mobile 97, 97, 97 and desktop 98, 97, 98; CLS 0 to 0.001. Page weight: home 245 to 227 KB, technical SEO 185 to 158 KB.
- **Still render-blocking (RECOMMENDATION):** the theme skin (`skin-*.css`, about 0.3 s estimated on a phone) on every lean page, and our own `reinforce-kit.css` on service and industry pages (about 0.6 s estimated). Same method can trim the skin; the kit is ours and could be inlined.

---

## D-173 · PageSpeed Insights report on the home page
**Date:** 12 October 2026 · **Status:** DONE (Jamil sent a full-page screenshot of PageSpeed Insights from his own Chrome: "before that, real screenshot from my chrome browser")

- **His report (VERIFIED from the screenshot, mobile, 12 Oct 01:57):** performance 95, accessibility 100, best practices 100, SEO 66, agentic browsing 3/3; FCP 1.4 s, LCP 2.7 s, TBT 20 ms, CLS 0, speed index 3.3 s. The screenshot is too small to read the item details, so the same report was run here (Lighthouse 13.5, all categories) to get them.
- **SEO 66:** the only failing SEO item is "Page is blocked from indexing", i.e. the noindex that `.online` must keep (CLAUDE.md). Not a defect; goes away on the live site.
- **Fixed:**
  - *Improve image delivery / image without width and height:* the header logo was the 1024 x 205 original (13 KB) shown at 170 x 34. Resized copies made on the server with the WordPress image editor from the media-library file: `uploads/reinforce-brand/reinforce-logo-white-340.webp` (4.2 KB) and `-510.webp` (6.6 KB); header uses them with `srcset` 2x/3x and `width="170" height="34"` (falls back to the original if the files are missing). Header checked at 1440 and phone: same look.
  - *Forced reflow (70 to 100 ms in the page's own script):* the header script read `scrollY` and `innerWidth/innerHeight` while the page was still loading. Now: no scroll check at load (a page restored mid-way fires a scroll event; tested reload at 1,492 px and an anchor link, both slim), and the mouse glow takes its position from the first mouse move (tested: follows the pointer, background parallax and slim header still work, no errors).
  - *Header button light (D-170):* it redraws on the main thread every frame (not composited); its first pass now starts after 3 s. Home desktop over 8 runs before this was median 94.5 (99, 94, 95, 94, 94, 97, 98, 94), under the 96 mark; after: 98, 97, 97, 96, 91, 98 (median 97).
- **Measured after (home, Lighthouse, cached):** mobile 95, 95, 96, 97 (LCP 2.3 to 2.7 s); desktop median 97; CLS 0; the image and forced-reflow items pass.
- **Left open (RECOMMENDATION):**
  - *Cache lifetimes:* static files are cached for 7 days; files with a version in their URL (our scripts, fonts, theme CSS) could be cached for a year. Server rule (`.htaccess`), helps returning visitors only; best set with the live-site LiteSpeed setup (migration checklist A6).
  - *Render-blocking CSS / unused CSS:* Bootstrap (21 KB, about 97% unused on the home page) and the theme skin (9.5 KB) still block the first paint (about 0.4 to 0.7 s on a throttled phone). Removing them changed the layout (D-166); the way forward is a small copy with only the rules our pages use. Separate task, needs the full screenshot comparison.
  - *Modern HTTP:* requests show as HTTP/1.1 in the runs here, which go through the sandbox proxy; cannot tell from the screenshot what Google's test saw. Check on the live host at launch.
  - *Minify JavaScript:* `reinforce-motion.js` could save 2 KB. Not worth a build step now.

---

## D-172 · Service and industry pages: lean page and late motion
**Date:** 11 October 2026 · **Status:** DONE (Jamil, on the D-171 recommendation: "yes, do it")

- **Checked first (VERIFIED):** the service and industry pages load the same unused files the home page had before D-166: jQuery and Migrate, the theme scripts (theme.min.js, bootstrap, fitvids, magnific, throttle), Font Awesome (only the hidden theme search icon), animate.css and the lightbox CSS. No inline script uses jQuery, no lightbox links, no videos or embeds; the FAQ is native `<details>`, the phone menu and mega menu are our own plain JavaScript.
- **Change 1, lean page:** `core/reinforce-speed.php` adds the same `rl_lean_page` opt-in for every page under `/services/` and `/industries/` (29 pages). `/services/agents/` is left out (different layout, not tested).
- **Visual check:** full-page screenshots of all 29 pages at 1440 and 390 before and after (58 pairs): same page sizes, pixel difference under 0.2% on every pair, no errors, no sideways scroll. Phone menu opens and closes, mega menu opens, FAQ toggles, `jQuery` undefined.
- **Problem found:** with the theme files gone the page paints sooner, and on desktop the reading and start-up of the GSAP files (60 to 100 ms tasks, measured with the motion script blocked as well, so not the motion itself) fell inside the load window: desktop 94 to 97, under the 96 mark. Moving the card reveals from one ScrollTrigger per card to IntersectionObserver did not change that (setup steps measured under 15 ms each).
- **Change 2, late motion:** on these pages the motion files (GSAP, ScrollTrigger, SplitText, `reinforce-motion.js`) now load on the visitor's first scroll, pointer move, touch or key press, in order, after the load event (the rule the WebGL scenes already follow). Whatever is already on screen at that moment stays as it is; only what is below gets the reveal (`window.rlMotionLate`). The home page still loads them at once (its hero loop must start on its own).
- **Measured (Lighthouse, cached, 3 runs):** technical SEO desktop 97, 97, 97 and mobile 96, 96, 97 (before D-171: 97 to 98 and 91 to 92); healthcare desktop 97, 96, 97 and mobile 97, 97, 96 (before: 98 and 91 to 92). Mobile LCP 2.2 to 2.5 s (was 2.9 s). Page weight 275 KB to 185 KB. CLS 0 to 0.006. Scroll test: motion runs, nothing left hidden, no layout shift, no errors. axe 0 at 390 and 1440 on technical SEO, healthcare and both hubs.
- **Noted, not changed:** the phone menu does not close with the Escape key (it closes with the menu button or a link); it never did. Small accessibility improvement for later.

---

## D-171 · Scroll motion, phase 3: service and industry pages
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "then Go ahead with Phase 3")

- **Scope:** every page under `/services/` and `/industries/` (the shared `.rl-page` kit: 19 service pages, the services hub, 8 industry pages and the industries hub), through the `rl_motion_active` filter in `core/reinforce-motion.php`. The AI agents pages under `/services/agents/` use a different layout and are left out.
- **Motion (lighter than the home page, no WebGL):** section headings (`.head h2`, the closing h2, the honest-note h2) reveal line by line and the split is undone afterwards; cards, metrics, steps, myth rows, industry tiles, tick lists and the honest note rise in turn as they enter (`ScrollTrigger.batch`); process steps fill a red line along their top one after another; link cards (`a.cell`) tilt toward the pointer with a soft sheen (desktop with a mouse); red reading-progress bar; the closing call to action's glow builds on scroll. The hero is not touched.
- **Script loading:** the two WebGL scenes (`reinforce-signal.js`, `reinforce-scan.js`) now load on the home page only; service and industry pages get GSAP, ScrollTrigger, SplitText and `reinforce-motion.js` (deferred, at the end of the page).
- **Checked (VERIFIED):** scroll test at 1440 and 390 on technical SEO, healthcare, the industries hub, the services hub and home: layout shift 0, no console errors, nothing left hidden after scrolling, no split markup left, all step lines filled, no sideways scroll. axe 0 at 390 and 1440 on technical SEO and healthcare. Frames captured (cards rising, step lines filling).
- **Speed (Lighthouse, cached, 3 runs each):** technical SEO desktop 97, 97, 97 (before 97, 98, 98), mobile 92, 91, 91 (before 92, 91, 92); healthcare desktop 96, 97, 97 (before 98, 98, 98), mobile 91, 91, 91 (before 91, 91, 92). CLS 0 to 0.003. Page weight up about 57 KB (the motion scripts). Pass mark (desktop 96, mobile 90, no shift) met, with little room on mobile.
- **RECOMMENDATION (not done):** mobile LCP on these pages is about 2.9 s because they still load the theme's unused jQuery, Font Awesome and animate.css; extending the D-166 lean-page filter to them would likely give the same gain as on the home page. Needs its own test per template.

---

## D-170 · Moving light on the header call-to-action button
**Date:** 11 October 2026 · **Status:** DONE (Jamil, with a screenshot of the header: "Can you create a moving line in the header call to action button")

- **What:** a short light (12% of the border) travels round the "Get your free diagnostic" button in the header once every 6 s, then rests; twice as fast on hover. Inline SVG with two rects on the border (`pathLength` 100, `stroke-dashoffset` keyframes), pure CSS, no script; hidden for reduced motion. Desktop header only (the button is hidden below 1151 px).
- **Look, as Jamil set it:** first version red with a white head; Jamil: "use white moving light more sleek its too thick and make it lighter and a bit glowing". Final values from Jamil: core line 0.6 px white at 85%, halo 3 px white at 14%, glow (drop shadow) 3 px blur white at 45%.

---

## D-169 · Hero diagram: one cycle of growth
**Date:** 11 October 2026 · **Status:** DONE, waiting on Jamil's view (Jamil, with a screenshot of the hero diagram: "I don't like it the last one. Can you think of something with the thing already have in this portion that looks amazing for animation hero section right side design elements ... First can you think like a director and then design to make it feel stunning")

- **Removed:** the D-168 scan beam (`core/reinforce-gescan.js` deleted from the repo; the live copy deleted after a backup in `_backups/<stamp>-removed`). Its CSS and canvas are gone from the home page.
- **Director's idea:** no new decoration. The diagram's own parts (inputs, wires, engine, stage readout, outcomes, feedback path) tell one story per loop: signals come in, the engine works on them, results go out, and results feed the next cycle.
- **The loop (12 s, GSAP timeline, repeats while on screen):**
  - Ingest (0 to 2.4 s): each input box fills red from the left in turn and sends a small square packet along its wire into the engine.
  - Absorb (2.4 to 6.9 s): the engine glows and a short red trace runs round its border.
  - Process (3.0 s on): the five stages light one by one and their bars fill.
  - Emit (7.0 s on): packets leave for the outcomes, each outcome lights as its packet lands.
  - Compound (9.5 to 11.1 s): a packet runs the feedback path back to the inputs, the feedback label lights, the inputs flicker.
  - Breathe (11.2 to 12 s): everything settles before the next cycle.
- **Power-on intro (once):** each wire draws in red and cools to grey, then the loop starts.
- **Depth and hover (desktop with a mouse only):** the layers (inputs, wires, engine, outcomes) move a few pixels at different rates with the pointer; hovering an input turns its two wires red and lights its outcome.
- **Markup:** `rl_home_ge_svg()` adds a fill rect per box, layer groups (`ge-L-in`, `ge-L-edges`, `ge-L-core`, `ge-L-out`), the engine trace path and an empty packets group. The old CSS keyframes are switched off once GSAP takes over (`.ge-gs`), so without JavaScript or with reduced motion the D-039 CSS animation still runs as before.
- **Bug found and fixed:** packets showed at rest before their beat (a `fromTo` drew its first frame at build time); fixed with `immediateRender: false`.
- **Rules as before (D-163 to D-165):** set up in idle time after load, desktop motion only inside `gsap.matchMedia`, off for reduced motion, paused off screen, no new library (GSAP already loaded), hero heading (the LCP element) untouched.
- **Checked:** filmed the hero (video and frame sheet); scroll test no layout shift and no console errors; axe 0 at 390 and 1440. Lighthouse (cached home, 4 runs): desktop 93, 98, 98, 97 (median 97.5); mobile 95, 91, 95, 95 (median 95); CLS 0 in every run. Pass mark (desktop 96, mobile 90, no shift) met.

---

## D-168 · Hero diagram scan
**Date:** 11 October 2026 · **Status:** DONE (Jamil asked whether the closing call-to-action scan in the hero would be harmful; answer: not for SEO or speed if built the same way, but the exact copy would repeat the ending and compete with the hero diagram; options A exact copy, B scan powers the diagram, C leave the hero. Jamil: "B. The scan powers the hero diagram (recommended)")

- **What:** `core/reinforce-gescan.js` (new, 3 KB compressed). Behind the hero's Inputs / Engine / Outcomes diagram, a grid of small square points in the brand reds with a vertical beam that sweeps left to right in step with the diagram's 10 s CSS cycle (`rl_home_ge_kf()`): across the inputs while they light (0 to 18%), slowly through the engine while its five stages run (18 to 57%), across the outcomes (58 to 83%), weaker during the feedback pulse, gone at the reset (92 to 100%). Points light behind the beam and fade; a few flash as findings. The beam reads the diagram's own animation clock (`.ge-cg` `getAnimations()`), so it never drifts and stops when the diagram is paused off screen (D-039).
- **Placement:** canvas inside `figure.ge` under the SVG and caption (z-index 0 and 1), above the panel background; the diagram boxes are opaque, so the points show only in the gaps.
- **Rules as for the other scenes (D-165, D-167):** desktop only, boots on the first interaction, draws only while on screen and the tab is visible, pixel ratio capped at 1.5, off with reduced motion, Save-Data, low memory or no WebGL. The hero heading (the page's LCP element) is not touched; a canvas is never an LCP candidate.
- **Checked:** in-step captures at 25%, 34% and 65% of the cycle (beam at the engine edge with inputs lit, inside the engine on "Verify", crossing to the outcomes with the out-pulses); no console errors; axe 0 at 390 and 1440. Lighthouse (cached home, 4 runs): desktop 97, 98, 97, 97; mobile 95, 94, 95, 95; CLS 0.

---

## D-167 · Diagnostic scan on the closing CTA; LiteSpeed page cache on
**Date:** 11 October 2026 · **Status:** DONE (Jamil, with a screenshot of the closing call to action: "Can you give a different animation like the wave one so it matches its style but not similar things. Yes, After that test speed again and then enable LiteSpeed caching")

- **Scan (`core/reinforce-scan.js`, new, 2.8 KB):** behind "Find out what's limiting your growth." a flat grid of square points in the brand reds; a radar beam sweeps from the red glow at the bottom of the panel (one sweep about every 10 s); points light up behind it and fade, about 2.5% of them flash as "findings"; the field is dimmed behind the text. One fragment shader, no library. Same rules as the signal field (D-165): desktop only, boots on first interaction, draws only while the panel is on screen (0 frames off screen, measured), pixel ratio capped at 1.5. First version too faint to see (levels too low); brightened. Canvas sits above the panel's glow and below its text.
- **Speed before caching (Lighthouse, 4 runs):** desktop 97, 97, 96, 97; mobile 95, 97, 97, 95; CLS 0.001 to 0.005.
- **LiteSpeed Cache 7.9.1 activated on `.online`** (installed, inactive until now). Backups first: `claude/data/backups/htaccess-before-litespeed-2026-10-11.txt` and `litespeed-options-before-activation-2026-10-11.json` (196 options). Settings kept from the saved configuration: page cache on, public TTL 7 days, every optimisation feature off (no CSS/JS minify or combine, no lazy load, no QUIC.cloud, no guest mode, no crawler). Object cache set off (Redis and Memcached exist on the host; not configured, left for later). `.htaccess`: LiteSpeed added its own block above the WordPress block; the WordPress block is unchanged (checked, after F-030).
- **Uncached on purpose:** `/contact-us/` and `/search-authority-diagnostic/` (`core/reinforce-speed.php`, `litespeed_control_set_nocache`): their anti-spam check prints the current time into the form, which a cached copy would freeze. Both forms post to `admin-post.php` (never cached).
- **Deploys purge the cache:** `rl.py deploy` now calls `litespeed_purge_all` after a successful deploy and reports `cache_purged` (tested: true, home served fresh after it).
- **Checks:** all 55 published pages 200; second request 53 cache hits and 2 no-cache (the form pages); no admin bar in any cached page; `noindex` present on every page; cached and freshly built home HTML identical apart from LiteSpeed's closing comment.
- **Speed with the cache (Lighthouse, home, 4 runs):** desktop 98, 97, 94, 98 (median 97.5); mobile 95, 95, 95, 95; server wait (TTFB) about 0.4 to 0.7 s (was 0.85 to 1.0 s, both through the sandbox proxy); CLS 0 to 0.003.
- **Supersedes D-139 "Caching: No".** For the live site: the same setup goes across at the switch (A6 in the migration checklist).

---

## D-166 · Home page mobile load time
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "Fix the mobile load time first")

- **Cause (VERIFIED, Lighthouse):** seven files blocked the first paint on phones: jQuery 3.7.1 and jQuery Migrate (in the head), Font Awesome 7 CSS, Bootstrap 4 CSS, the Beaver Builder theme skin, PowerPack animate.css and the Magnific Popup CSS; plus 0.75 to 1 s server response through the sandbox proxy.
- **Home page facts (VERIFIED):** no inline script uses jQuery; the only Font Awesome icon is the search icon in the Beaver Builder theme header, which is hidden (`.fl-page-header{display:none}`, our own header replaces it); no animate.css classes; no lightbox links. The theme scripts (theme.min.js, bootstrap.js, fitvids, magnific, throttle) serve that hidden header and lightboxes.
- **Change:** `core/reinforce-speed.php` (new, in loader). On pages that opt in through the `rl_lean_page` filter (home only for now; never when the page builder is open) it removes Font Awesome, animate.css and the lightbox CSS (at print time, they are added late by the plugins), the five theme scripts, and jQuery when nothing left depends on it. Bootstrap CSS and the skin stay: removing them was tested and changed the layout (page 300px shorter at 1440); inlining them was tested and refused (Bootstrap 162 KB, skin 68 KB uncompressed).
- **Side effect handled:** the page now paints before Oswald arrives, so the hero H1 re-wrapped on the font swap (CLS 0.07 to 0.08 on desktop). `'Oswald Fallback'` is now one face per weight, measured with fontTools on the site's own uppercase headings and buttons: Arial at 400 (71.7%), Arial Bold at 600 (76.8%) and 700 (78.4%), with matching ascent and descent overrides.
- **3D field:** now boots on the visitor's first scroll, pointer move, touch or key press, so its WebGL setup never lands in the page-load window (until then the CSS dotted field shows).
- **Visual check:** full-page screenshots before and after, desktop and phone: same page height, only the moving logos and 3D dots differ between captures.
- **Measured (Lighthouse 13.5, home):** mobile 94, 96, 96, 98 then 96, 96, 94 (median 96, was 90); mobile LCP about 2.1 to 2.6 s (median about 2.2 s, was 2.9 to 3.0 s); mobile first paint 1.8 s (was 2.3 s); CLS 0 to 0.001. Desktop 97, 95, 96, 95, 97, 93, 96, 95, then 94, 94, 97, 96, 97, 95 (median 95.5, was 96); desktop LCP 0.8 to 1.2 s, following the server response time (0.75 to 0.96 s through the proxy). Scroll test: CLS 0 on home at 1440 and 390, no console errors. axe 0.
- **Open:** the remaining desktop and mobile delay is server response time (no page cache; Jamil chose no caching in D-139). Page caching would cut it; asked Jamil whether to revisit.

---

## D-165 · 3D signal field, card animations, font-swap fix
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "option 2"; "Pass mark: desktop stays at 96 or above, mobile at 90 or above, with no layout shift. If the 3D can't meet that, I scale it down or switch to option 3.")

- **Research (11 Oct):** gsap.com/showcase renders its list with JavaScript and could not be read here; patterns taken from published case studies of GSAP award sites (fromanother, Iventions, Mat Voyce, MANA Yerba Mate, Joseph Santamaria) and Awwwards' GSAP collection: one motion language, transform/opacity only, WebGL only for one or two moments, lazy WebGL contexts paused off-screen, pixel ratio capped, reduced-motion respected.
- **3D signal field (option 2 of 3):** `core/reinforce-signal.js` (new, 2.7 KB compressed, no library). About 7,200 square points (zero-radius rule) in the brand reds on a perspective field behind "One system. Three outcomes that move the business."; slow waves, three brighter pulses travelling toward the three outcomes, slight response to the pointer and to scroll. Text stays HTML above it (canvas `aria-hidden`). Starts after load when the browser is idle, only near the screen; 0 frames drawn when scrolled away (measured); pauses when the tab is hidden; pixel ratio capped at 1.5. Never runs below 768px, with reduced motion, Save-Data or under 4 GB device memory: those visitors see a CSS dotted floor instead. First version overlapped the outcome text; field lowered and pulses softened.
- **Card animations (`core/reinforce-motion.js`):** outcome statements rise in turn; award badges and testimonial cards rise with a slight 3D turn; testimonial quote marks drop in; the HackerNoon trophy outline draws itself, then its three results slide in; badges, testimonials, the blog card and the HackerNoon card tilt toward the pointer (up to 6 degrees, 2.5 on the large award card) with a soft light sheen (desktop with a mouse only).
- **First measurement failed the mobile mark** (84 to 87): the setup of all animations ran as one long task (mobile blocking time 170 to 260 ms). Fix: setup now starts after load and runs one feature per idle task (each heading split separately). Mobile blocking time back to 0 to 130 ms.
- **Font swap (existing issue, D-163 F(b)) fixed so the "no layout shift" mark holds:** (1) IBM Plex Mono `font-display: optional` (it moved the hero diagram, CLS 0.164 in one run). Preloading it was tried and dropped: it pushed mobile LCP to 3.2 s. (2) Size-matched fallbacks `'Oswald Fallback'` (Arial scaled 72.3%, ascent 165%, descent 40%) and `'Plex Sans Fallback'` (102.8%, 99.7%, 26.8%), computed from the fonts' own metrics with fontTools, placed second in `--f-display` and `--f-body`; the swap no longer moves the hero buttons (was CLS up to 0.185 on mobile).
- **Final measurement (Lighthouse 13.5, home, 4 runs each):** desktop 96, 96, 95, 96 (median 96); mobile 90, 90, 93, 89 (median 90); CLS mobile 0 in all runs, desktop 0 to 0.003. Page 338 KiB. axe 0 at 390 and 1440. No console errors. Phone 390 wide.
- **Note:** desktop frame rate measured only in software rendering (about 17 frames per second in the test browser, no GPU); real graphics hardware runs it at screen rate.

---

## D-164 · Scroll motion, phase 2
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "Now ... Next: Phase 2, lighter motion across the rest of the home page"); phase 3 waits for approval

- **Headings:** every home section heading below the hero (h2, and the Recognition h3) slides up line by line out of a mask once, as it enters (`expo.out`, 1.1 s, 0.09 s between lines). GSAP SplitText 3.15 (free, self-hosted, `core/vendor/SplitText.min.js`, 3.7 KB compressed). The split is reverted when the reveal ends, so the heading HTML is exactly what the server sent (checked: no split elements left after scrolling).
- **Rows:** the services index (6 rows) and the industries list (8 rows) fade up in turn as they enter (ScrollTrigger.batch, 0.08 s stagger).
- **Progress bar:** 2px red bar across the top of the window, filled with page scroll. Home only.
- **Closing CTA:** the red glow under "Find out what's limiting your growth." builds from 20% to full as the panel comes into view (CSS variable `--glow`, scrubbed).
- **Header (sitewide, `core/reinforce-header.php`):** after 80px of scroll the header becomes 14px slimmer with a darker background and a slightly smaller logo; back above 40px. Done with transform (header moved up 14px, contents down 7px), so the page below never moves (layout shift measured during a full scroll: none added). Desktop only (at 1150px and below the phone menu is placed against the full 72px header). Plain script, no GSAP, so it works on every page.
- **Measured:** Lighthouse home, 3 runs: desktop 96, 97, 96 (baseline 96); mobile 90, 90, 90 (baseline 91), mobile blocking time 70 to 100 ms (SplitText work, inside Google's good range of 200 ms), CLS 0 to 0.015 (the existing font swap). Page weight 333 KiB. axe 0 at 390 and 1440. Phone width 390 on Home and About. No console errors.

---

## D-163 · Scroll motion, phase 1
**Date:** 11 October 2026 · **Status:** DONE, phase 2 waits for Jamil (Jamil: "Go ahead with Phase 1? yes"; Lenis question unanswered, kept off as recommended)

- **Scope agreed (11 Oct):** Jamil pasted a general "3D and motion website" brief and asked how to add motion "only for scroll" without losing SEO and speed. Kept from the brief: GSAP + ScrollTrigger, text and list reveals, the marquee (exists, D-157). Not used: theme change (stack locked), WebGL/3D hero and preloader (delay LCP), custom cursor and page transitions (code weight, keyboard and screen-reader cost). Lenis smooth scroll off (takes over native scrolling).
- **Files:** `core/reinforce-motion.php` (new, in loader: prints the motion CSS and the three scripts with `defer` at the end of the page, only where the `rl_motion_active` filter is true, Home only for now), `core/reinforce-motion.js` (new, 4.8 KB), `core/vendor/gsap.min.js` and `core/vendor/ScrollTrigger.min.js` (GSAP 3.15.0, free "no charge" standard licence, self-hosted, no CDN), `pages/reinforce-home.php` (filter on, Search Authority OS stage list).
- **Moments:** (1) How it works: the rail fills with scroll (scrubbed) and each stage's node and number turn red as the fill reaches it; the stage text rises in once. Vertical on phone. (2) Search Authority OS: the five stages are now a real list (Research, Verify, Write, Audit, Monitor, each with one line taken from the section's own wording); on desktop the section holds for about one screen while the stages light up in turn with a progress bar; on phone no hold, the stages light up as you scroll. (3) Packages: the ladder steps rise one after another and the rail fills red.
- **SEO and speed rules applied:** nothing is hidden by CSS; the script hides and reveals only after it runs, so crawlers and visitors without JavaScript see the full page. The hero is not animated. Only transform and opacity move. `prefers-reduced-motion` gets no motion (gsap.matchMedia). No render loop; ScrollTrigger only reacts to scroll.
- **Measured (Lighthouse 13.5, home, 3 runs each, through the sandbox proxy, medians):** desktop 96 before, 96 after (LCP 0.9 s, CLS 0, TBT 0 to 20 ms). Mobile 91 before, 89 after (runs 83, 89, 93; LCP 2.6 to 3.1 s; one run had CLS 0.185). Page weight 279 KiB to 327 KiB (+48 KiB, the scripts; served with Brotli: gsap 27.5 KB).
- **Found (existing, not caused by motion):** (a) Mobile LCP is about 2.9 s before and after: the hero H1 waits behind render-blocking Font Awesome CSS from Beaver Builder (about 1 s) and jQuery Migrate, plus about 1 s server response (no page cache). (b) The hero button row shifts when the web fonts load (CLS 0.015 in the baseline; 0.185 in one run when Oswald arrived late). Both for the speed phase: font fallback metrics, remove unused Font Awesome on the home page, page caching decision.
- **Checked:** motion runs on 1440 and 390 (stages light in order, hold only on desktop, ladder fully visible at the end), page width 390, axe 0 at 390 and 1440, copy check 0, scripts absent on `/blog/`.

---

## D-162 · Home Proof section removed
**Date:** 11 October 2026 · **Status:** DONE (asked: remove it, or merge it into the diagnostic section; Jamil: "Remove and", the rest of the message did not arrive)

- Removed from Home: the Proof section (heading "We run this system on ourselves.", four placeholder tags "Your baseline / Your gap / Your opportunity / Your plan", and the note under them), plus its styles. To come back when there are real, verified case-study results.
- Home order now: Hero, Why AI Growth Systems, What we do, The problem, How it works, Industries, Search Authority OS, Clients and recognition, Testimonials, Packages, Questions, Blog, Start here.
- **Open:** `/search-authority-os/` (`saos/reinforce-saos.php`, line 458) has the same four placeholder tags; not changed, Jamil to decide. Jamil's "and..." not yet known.
- Checked: phone width 390, axe 0 at 390 and 1440.

---

## D-161 · HackerNoon award on the home page
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "great. what about my hackernoon startup award")

- **Gap:** the HackerNoon results (all VERIFIED in F-023, `claude/research/reputation-and-recognition-2026-10-04.md`) were on `/awards/` only; the home page showed just the six directory badges.
- **Now:** the Recognition part of the Clients section opens with a featured card: drawn trophy, "HackerNoon · Startups of The Year", "Winner, Startups of The Year 2024 in Dhaka", the one-line explanation (public vote, more than 4,200 cities) and "See it on HackerNoon" (Asia winners page). Beside it, the three other HackerNoon results, each linking to its HackerNoon page: 11th in Marketing worldwide (2024), two honourable mentions (2024), Startups of the Week (Nov 2025). The six badges follow underneath.
- **Single source:** title, text, links and the three results come from `rl_awards_data()` in `pages/reinforce-awards.php`, so home and `/awards/` cannot disagree.
- **Copy:** sub-heading "Recognized by independent directories." became "Awards and recognition." (HackerNoon is a public vote, not a directory); intro: "A startup award decided by public vote, and rankings by GoodFirms, FindBestFirms and DesignRush. Each one links to the page on its own site."
- **Checked:** phone width 390, axe 0 at 390 and 1440, copy check 0.

---

## D-160 · Home page: the remaining sections redesigned
**Date:** 11 October 2026 · **Status:** DONE (Jamil, asked "Redesign the remaining sections the same way?": "1. yes"); Proof question still open

- **Outcomes:** the three boxes became three large statements side by side ("Automate / Operations" with the second word in red), divided by thin red rules, no boxes. Stacked with a left rule on phone.
- **The problem:** heading and intro on the left stay in place (sticky) while the four problems run as a list on the right: red cross in a square, title in Oswald, text below. Sources line kept under the list. One column on phone.
- **Industries:** the 8 boxes became a two-column list. Each row: a drawn line icon (flask, cross, layers, bag, factory, chip, briefcase, cap; SVG, no emoji), name with its tag, one line of text, arrow. Hover fills the icon red. Same links.
- **Clients and Recognition:** one section. Moving logos (D-157), "See all 46 clients", then a divider and "Recognition" as a sub-heading (h3) with the six badges (tiles 160px). One section heading fewer.
- **Blog:** heading, intro and "Read the blog" on the left; posts on the right as wide cards (image left, text right). Works for one post now and three later.
- **Not changed:** Hero, Search Authority OS, Proof (waits for Jamil), Testimonials, Packages, Questions, Start here. All words as before.
- **Result:** page height at 1440 down from 13,267px to 12,559px. Phone width 390, axe 0 at 390 and 1440, copy check 0.

---

## D-159 · Section intros under the heading again
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "the right text can be on the left after the heading")

- The split headings from D-158 (heading left, intro right) are removed: label, heading and intro stack on the left as before. The numbered services index and the How it works timeline stay.

---

## D-158 · Home page: less repetition, first three changes
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "i think it looks boring to see same pattern from top to bottom"; asked "Go ahead with the first 3?", Jamil: "Go ahead with the first 3? (yes / no)", taken as yes)

- **Found (review of the full page):** 9 of 13 sections had the same build (label and heading on the left half, right half empty, then a grid of equal dark boxes); page about 13,000px tall at 1440.
- **1. Headings:** every section heading that has an intro now uses the full width at 900px and up: label and heading left, intro right with a thin red rule (one column below 900px). Packages keeps its own two-column layout (D-154). CSS only.
- **2. What we do:** the 6 service boxes became a numbered index: 01 to 06 in outlined numbers, tag and title, description, and an arrow box; hover draws a red edge, tints the row and fills the arrow. Same links and words.
- **3. How it works:** the 4 boxes became a timeline: one rail from grey to red with a node per stage (last one filled), large outlined stage numbers that turn red on hover. Vertical rail on phone. Same words. Classes `.ix` and `.tline` (no kit or Bootstrap clash).
- **Not changed yet (waiting for Jamil):** Outcomes, Problem, Industries, Clients and Recognition merge, Blog, and the Proof question (remove until there are real numbers, or merge into the diagnostic section).
- **Checked:** phone width 390, axe 0 at 390 and 1440, copy check 0.

---

## D-157 · Home Clients logos move
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "I want the logos in two line and moving from right to left smooth motion"; "I will give you pro tennis logo and you add that later")

- The 24 logos (D-156) are now two rows of 12 (row 1 Accesstel to Panorama, row 2 INPACE to Sofosvel), both moving right to left without a seam: each row holds its logos twice and moves by half its width (CSS animation, no script). Row 1 takes 60s per loop, row 2 72s (45s and 54s on phone), so the rows drift apart slightly. Both ends fade out.
- Hovering a row pauses it. Visitors with "reduce motion" set get still rows that wrap. The repeated copy is `aria-hidden` with empty alt, so screen readers hear each client once.
- Checked: motion measured (both rows move left, row 2 slower), page width 390 on phone, axe 0 at 390 and 1440, copy check 0.
- Open: Jamil will send a new Pro Tennis Academy Dhaka logo; it replaces the white circle here and on `/clients/`.

---

## D-156 · Home page: Clients section
**Date:** 11 October 2026 · **Status:** DONE (Jamil, with a screenshot of production's "Companies we've worked with": "I want a client section before "[ Recognition ] Recognized by independent directories." section")

- **Where:** Home, after Proof and before Recognition (`#clients`). Home order now: ... Search Authority OS, Proof, Clients, Recognition, Testimonials, Packages, Questions, Blog, Start here.
- **What:** the same 24 clients as production's home, in the same order (Accesstel to Sofosvel). Logos are the white versions already made for `/clients/` (D-127, option `rl_client_logos_white`), so nothing new was uploaded. Grid 6 across at desktop, 4 on tablet, 3 on phone, 1px lines. "See all 46 clients" links to `/clients/`.
- **Copy:** heading "Companies we've worked with."; lede names only sectors that are in the list (UIU and FBS, Beacon Pharmaceuticals, Bikroy.com, Union Properties and Panorama).
- **Checked:** all 24 images load, phone width 390, axe 0 at 390 and 1440, copy check 0.

---

## D-155 · Testimonial shown without the "..."
**Date:** 11 October 2026 · **Status:** DONE (Jamil: "“...” remove it and keep it as you written")

- Mr Haque's quote keeps the sentence left out in D-153 out, but the "..." that marked the gap and the line explaining it ("Where we shortened a quote...") are removed. Lede now "In their own words." The left-out sentence is recorded in D-153.

---

## D-154 · Home Packages teaser: ladder on the right
**Date:** 11 October 2026 · **Status:** DONE (Jamil, screenshot of the section: "The right side like boring")

- The section is now two columns at desktop: the existing text and buttons left (unchanged), and a ladder right: Step 0 free Search Authority Diagnostic (dashed, links to the diagnostic), then 01 Foundation, 02 Growth OS (highlighted, "Most chosen" as on /packages/), 03 Enterprise, each with setup and monthly price and linking to /packages/. A rail runs through the steps, grey to red.
- Names and prices come from `rl_pkg_plans()` in `saos/reinforce-packages.php`, so the home page cannot show a different price from /packages/.
- One column on tablet and phone (ladder under the buttons). Class "rung", not "step": the kit already styles `.step` (it drew a second box around each row).
- Checked: phone width 390, axe 0 at 390 and 1440, copy check 0.

---

## D-153 · Home page: Testimonials section
**Date:** 11 October 2026 · **Status:** DONE (Jamil, with a screenshot of production's "What Client's Saying": "Create a section for testimonial")

- **Where:** Home, after Recognition and before Packages (`#testimonials`, alternate band, so the page keeps its light/dark rhythm: Proof, Recognition, Testimonials, Packages).
- **Text:** copied word for word from production's home page (read-only fetch, 11 Oct), not retyped from the screenshot. One sentence left out of Mr Haque's quote ("The collaborative approach and seamless communication of Reinforce Lab team made the whole journey easy and enjoyable."), because "seamless" is on the copy-rules list (D-072) and a client's words cannot be edited; the cut is marked "..." and the section says so. "Reinforce Lab Ltd." in Mr Hussain's quote kept as written (it is his wording). Roles written "Head of Marketing, Bikroy" (comma for the pipe).
- **Photos:** production's files, copied to `wp-content/uploads/reinforce-testimonials/`, 240px squares (zero radius rule, D-013). Mr Haque's original is cut to a circle in the file itself; filled white (his photo background) and cropped inside the circle. Copies in `claude/data/testimonials/`.
- **Left out on purpose:** the five stars (no rating source behind them) and Review/AggregateRating schema (Google does not show reviews a business publishes about itself; such markup can be treated as spam).
- **Design:** two cards (one on phone), drawn red quote mark, client name 20px Oswald, role 12px mono, quote 16px. The glass blur drew a second frame inside each card, so the cards use the solid panel background.
- **Checked:** phone width 390, axe 0 at 390 and 1440, copy check 0.

---

## F-031 · Two badge images broken on production
**Date:** 11 October 2026 · **Status:** OPEN (no change to production)

- Production's home page shows two GoodFirms badges from `https://reinforcelab.com/wp-content/uploads/2024/10/Reinforce-Lab-Limited-Top-SEO-Services_Company-Bangladesh.svg` and `...Top-Branding_Company-Bangladesh.svg`. Both return 404 (read-only GET, 11 Oct, with a normal browser identity too). Visitors to reinforcelab.com see two empty images in its Recognitions section.
- On `.online` (D-152) these two are cut from Jamil's screenshot. Better: the original badge files from Jamil's GoodFirms account, to replace the cut copies.

---

## D-152 · Home page: Recognition section
**Date:** 11 October 2026 · **Status:** DONE (Jamil, with a screenshot of production's Recognitions section: "build a section with the images in the home page I want to have a separate section for this")

- **Where:** its own section on the Home page, after Proof and before Packages (`#recognition`).
- **What:** the six badges from production's home page, in production's order: GoodFirms research partner, GoodFirms Top SEO Services Company Bangladesh, GoodFirms Top Digital Marketing Company, FindBestFirms Top WordPress Development (Aug 2024), GoodFirms Top Branding Company Bangladesh, DesignRush Top Content Marketing Agencies. Each links (new tab) to the directory page production links to; DesignRush links to the agency profile already used on `/awards/`. Heading "Recognized by independent directories." and a link to `/awards/`.
- **Images:** copied to `wp-content/uploads/reinforce-badges/` (copies in `claude/data/award-badges/`), not loaded from the directories, so no visitor data goes to third parties. Four from the files production uses; two cut from Jamil's screenshot (F-031).
- **Design:** badges sit on light #f4f4f4 tiles of one fixed height (200px, 160px on phone), because two badges have dark text that would vanish on the dark ground; square corners; captions 12px mono source + 16px text; 6 across at 1440, 3 on tablet, 2 on phone.
- **Found while building:** Bootstrap 4 (theme) styles `.badge` (nowrap, centred), which pushed the phone page to 539px; classes renamed `.recs`/`.rec`.
- **Checked:** phone width 390, all six images load, axe 0 at 390 and 1440, copy check 0.

---

## F-030 · `.online` inner pages return the server's 404
**Date:** 11 October 2026 · **Status:** CLOSED the same day: Jamil re-saved Settings, Permalinks. Re-checked: all 55 published pages 200, all 9 redirect targets 200, `/robots.txt` 200, Novamira connects, theme files match git (parity 0 differences).

- **Seen (VERIFIED, 11 Oct):** `/` returns 200; `/services/`, `/blog/`, `/industries/healthcare/`, `/packages/`, `/robots.txt`, `/wp-json/` all return Hostinger's static 404 page ("This Page Does Not Exist", 4,511 bytes, last modified 22 Apr 2025), served by LiteSpeed before WordPress runs. `/?page_id=72` reaches WordPress and 301s to `/services/ai-search-optimization/`. `/wp-admin/` and `/wp-login.php` work. Novamira fails ("OAuth metadata is malformed or unavailable"), because its discovery address is one of the broken ones.
- **Cause (INFERENCE):** the WordPress rewrite block in `public_html/.htaccess` is missing or broken. On 8 Oct after D-147 every page tested returned 200, so it changed between 8 and 11 Oct; who or what changed it is not known.
- **Safe:** home still prints `noindex, nofollow`; Rule 3 holds.
- **Fix (Jamil):** WordPress admin, Settings, Permalinks, Save Changes (no other change). If that does not fix it, Hostinger File Manager: check `public_html/.htaccess` holds the standard WordPress block.
- **Waiting on it:** checking the D-148 targets on `.online`, the `/reviews/` build, carrying posts across, parity checks.

---

## D-151 · Citation-tool post standard; button label kept
**Date:** 11 October 2026 · **Status:** APPROVED (Jamil: "definitely we will research them and try some of the functions if possible. also, before writing, we will research extremely well so that every information we give is accurate and up to date, research industry reputation, we will also read their official documentation ... it must drive value to visitor to convert them into customers")

- The post may describe tools from their official documentation and reputation research. Features we tried are stated as tried; everything else is credited to the tool's own documentation. We never say we used a tool we did not use. Blog rules D-134 apply.
- "Explore Search Authority OS" stays (Jamil asked which is better): it names the product, so a first-time visitor and Google both know where the link goes.

---

## D-150 · AI crawlers allowed
**Date:** 11 October 2026 · **Status:** APPROVED (Jamil: "Recommendation: allow them all. Yes.")

- At launch, robots.txt allows GPTBot, OAI-SearchBot, ChatGPT-User, PerplexityBot, Perplexity-User, ClaudeBot, Claude-SearchBot, Claude-User, Google-Extended and Applebot-Extended. Plan: `claude/data/robots-launch.txt`. Not live; `.online` stays noindex.

---

## D-149 · How the redirect map is signed off
**Date:** 11 October 2026 · **Status:** APPROVED (Jamil: "yes, do it this way")

- `claude/redirect-signoff-list.md` (and `.csv`): the 241 old addresses that are live on production, have Google clicks, have links from other sites, or belong to the closed shop, most important first, with the plan in plain words: 106 stay, 104 move, 18 stay hidden from Google, 13 removed.
- The remaining old addresses (junk `/paged-N/` copies, query variants, feeds, dead links) follow the fixed rules and are approved as one group with the list.
- Jamil replies "approved" or gives line numbers to change. This is the per-URL approval Rule 2 asks for.

---

## D-148 · Shop closed
**Date:** 11 October 2026 · **Status:** APPROVED (Jamil: "B. Close the shop. Each product address goes to the closest service page, and you keep an export of past orders for your records.")

- **Redirects (in the sign-off list):** `/shop/`, `/shop/page/2/`, `/cart/`, `/checkout/` to `/packages/`; `/my-account/` to `/contact-us/`; the two web-design store categories to `/services/wordpress-website-design-service/`; the empty Uncategorized store category, its page 2, the store tag and `/product-sitemap.xml` 410. The 19 product pages keep their September targets (SEO tiers to `/packages/`, web-design tiers to `/services/wordpress-website-design-service/`, e-commerce consultation to `/services/ecommerce-website-design-service/`).
- **Customer and order data:** not moved to the new site. Jamil exports past orders from production's WooCommerce admin for his records before the switch (read-only export; I do not touch production).
- Targets not yet re-checked on `.online` because of F-030.

---

## D-147 · Site icon and favicon
**Date:** 8 October 2026 · **Status:** DONE (reminder given 8 Oct; Jamil: "go ahead" on "make it from the logo mark")

- **Icon:** the two-block logo mark cut from the official logo (attachment 154): top block white, bottom block the logo's own red (#c21f25), centred on a square #121011 tile, no rounded corners. Sources and preview: `claude/design-previews/site-icon/`.
- **On `.online`:** uploaded as attachment 340 and set as the WordPress Site Icon (option `site_icon`), which prints `<link rel="icon">` (32, 192), `apple-touch-icon` (180) and the Windows tile (270). `favicon.ico` (16, 32, 48 px) written to the site root, because the server answers `/favicon.ico` itself with a 404 before WordPress runs (verified: LiteSpeed static 404). `<meta name="theme-color" content="#121011">` added in `core/reinforce-header.php`.
- **Verified:** home page prints all four icon tags and the theme colour; `/favicon.ico` 200 `image/x-icon`; icon files 200.
- **Migration:** the root `favicon.ico` and attachment 340 must go across at the switch (added to the checklist).

---

## D-146 · The 14 redirect-map decisions
**Date:** 8 October 2026 · **Status:** APPROVED (asked: "Reply "approve all", or give the numbers you want changed." Jamil: "go ahead")

- **301:** `/healthcare/` to `/industries/healthcare/`; `/digital-marketing/search-engine-optimization/local-seo/` and `/google-my-business-optimization-service/` to `/services/local-seo/`; `/seo-website-design/` to `/services/wordpress-website-design-service/`; `/b2b-marketing/` to `/industries/b2b-saas/`; `/seo-content-creator-2/` to `/services/seo-content-systems/`; `/project/uiu/` to `/clients/`. All 6 targets return 200 on `.online` (checked 8 Oct).
- **410:** `/basic-on-page-seo-checklist/`, `/liquidweb-wordpress-hosting/`, `/food-content-marketing/`, `/benefits-of-digital-marketing-for-small-businesses/`, `/link-building-tools/`, `/linkedin-content-ideas-for-businesses/` (already 404 on production).
- **Kept:** `/wp-content/uploads/2024/11/Beyond-Borders-client-of-reinforce-lab-limited.png`.
- **Recorded in** `claude/data/approved-redirects-2026-10.csv` (14 rows). Map rebuilt: 802 old URLs, 0 undecided (410: 446; 301: 148 plus 39 query variants; keep: 117 plus 6 query variants; keep with noindex: 34; config: 12).
- **Still open before the redirects go into code:** the Semrush backlink export (may add URLs) and Jamil's URL-by-URL sign-off of the final map file (Rule 2).

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
