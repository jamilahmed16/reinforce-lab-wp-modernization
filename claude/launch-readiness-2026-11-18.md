# Launch readiness: reinforcelab.online to reinforcelab.com, 18 Nov 2026 (F-070)

`.online` and this repository only. Nothing on reinforcelab.com was fetched or changed. VERIFIED = run or read today. INFERENCE = my reading. RECOMMENDATION = not applied.

**Correction to CLAUDE.md and the 15 Nov handoff:** they say "765 of 787 URLs pending". That is out of date. The redirect map has 803 old URLs with 0 undecided (`redirect-map-gaps.md`), approved by Jamil on 8 Oct (D-146) and 13 Oct (D-181). The "five exports" (backlinks, Search Console, Page Indexing, GA4, WPCode) are recorded as received (checklist A1, F-014, F-052). VERIFIED from the repository. CLAUDE.md should be updated when Jamil agrees.

## Gates run today on .online

| Gate | Result |
|---|---|
| Redirect test, 2,107 requests over 807 old addresses | **0 failures.** 49 old `/wp-content/` files answer 404 instead of 410 until the server rule exists (`claude/rebuild/htaccess-410.conf`); 27 old files kept on purpose (D-178) |
| Internal link scan, 176 pages, 643 targets | 0 links to `.online` or `.com` written out. **9 bad links (404), all mine, all from unpublished hosting pages.** 2 were on live post 378 and are **fixed today**; 7 are on the temporary preview post 664 |
| Carried posts check | 81 posts, 1,083 images, 0 problems |
| Parity, live code vs git | 82 files, 3 known differences (GSAP vendor files, kept out of git by design) |
| Site noindex | Yes, every page (Day 6 crawl) |

## Still open before the switch

**Jamil only**
1. **Step 1 of the launch plan (F-033, F-035):** both sites share one Hostinger account and both are compromised. Needed: security ticket with Hostinger, every password changed with two-factor, offline backups kept as evidence, WooCommerce past orders exported, and **new hosting chosen (a new account)**. Nothing in the repository says this is done.
2. **Where the rebuild runs (D-219):** the plan is a fresh WordPress in a new folder and database on the existing account for now. SSH on, a test address, an empty database and the 6 vendor zips uploaded. Not recorded as done.
3. Launch inputs: SMTP mailbox for form email (O-027), GA4 measurement ID and 14-month retention, VAT/BIN number on Terms and Privacy, affiliate link formats checked.
4. A date for the switch, agreed together.

**Me (can start on your go)**
1. Delete the temporary preview post 664 (it has 7 dead links).
2. Re-run link scan and redirect test on the staging copy, then against `.com` in the first hour (`redirect-test.py https://reinforcelab.com`).
3. Step 3: run `claude/rebuild/rebuild.sh` on the new hosting, then parity, axe, link scan, redirect test and speed. This is a gate.
4. Page parity for the 17 kept pages (checklist A5) and the phone overflow check on carried posts (A3).
5. Server 410 rule for the 49 old files (`htaccess-410.conf`).

**Content going live with the site**
- The 12 hosting reviews, the hosting list and their links are drafts. Decide whether they go live before the switch or after. If before: publish in small batches, then add each review link to post 378, then run the link scan again.
- Page 69 `/reviews/best-wordpress-hosting/`: redirect or keep (open question).
- Old posts launch with their old text and are rewritten after launch (D-218). 59 of them have en dashes today. That is accepted in D-218 and is not a launch blocker.

## The switch itself (runbook: `claude/rebuild/switch-runbook.md`)
Fresh full backup, Novamira and AI Abilities removed (Rule 1, gate), indexing on, `uploads/.htaccess` noindex header not copied, domain switch with SSL and one-hop http and www, LiteSpeed settings, security headers, redirect test within the first hour (0 failures or roll back), sitemap submitted, `robots-launch.txt` in place, then weekly monitoring for 6 weeks.

## RECOMMENDATION
Do Step 1 first. Everything else on the list is ready or is my work, and no switch date should be set until the new hosting and the security ticket are done. I would not launch the hosting reviews before the switch unless you want them ranked from day one: they are new URLs, and F-003 says to publish in small batches.
