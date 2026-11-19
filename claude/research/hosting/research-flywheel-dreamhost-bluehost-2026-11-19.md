# Research briefs: Flywheel, DreamHost and Bluehost (19 Nov 2026)

Made while waiting for Jamil's Semrush exports. Exa (search and fetch) and the competitor semantics tool; Firecrawl not needed. Search results here are pages ranking for the term, not Google's verified order. Nothing is written for publication yet. VERIFIED = read at the publisher on 19 Nov 2026. We do not host with any of these three, so no first-hand claim is allowed (only Hostinger, per D-321).

## How to use these briefs
Each brief gives: the facts to use, independent tests with method and date, conflicts between sources (and which side to trust), an angle that the top pages do not take, and the questions the ranking pages answer. Before drafting, the Semrush data decides the keyword and whether the existing URL (`/flywheel-wordpress-hosting/` and so on) is rewritten or a review is added.

---
## 1. Flywheel (existing URL ranks position 1 for "flywheel hosting", 1,000 a month)

### Official facts (getflywheel.com/pricing, read 19 Nov 2026)
- Starter $25 a month billed $300 a year (1 site, 25,000 visits, 10 GB, 50 GB bandwidth). Freelance $96 billed $1,150 a year (up to 10 sites, 100,000 visits, 20 GB, 200 GB). Agency $242 billed $2,900 a year (up to 30 sites, 400,000 visits, 50 GB, 500 GB). Custom for 30+ sites.
- Monthly billing (digitalpritam, 28 Oct 2026, from the same page): Starter $30, Freelance $115, Agency $290. Yearly includes 2 months free.
- Overages: $1 per 1,000 visits over the limit and $1 per GB over the storage limit. Example on the page: 30,000 visits on Starter is a $5 fee. Extra site $20 a month or $200 a year.
- Refund: 60-day money-back on new Starter and most Freelance plans. Agency and Custom excluded. Not for upgrades or renewals.
- No email hosting or domain registration. Free migrations. 24/7 chat. CDN powered by Fastly. FlyCache. Staging, Blueprints, Local app.
- Data centers: North America, Australia, UK, EU, none in Asia (digitalpritam, 28 Oct 2026, from Flywheel's availability page).
- Parent: WP Engine (Ecommerce Paradise snippet and a competitor heading "What happened to Flywheel after WP Engine acquired it?"; confirm the date on an official page before writing).

### Independent tests
| Source | Date | Method | Result |
|---|---|---|---|
| Whspe | 15 Nov 2026 | Nightly measurement from Istanbul, 29 valid runs | Median TTFB 173 ms, but runs vary by 61% (some nights about 500 ms). US rank 68 of 124 |
| Kripesh Adwani | 2 Nov 2026 | Own Tiny plan for 4 years: GTmetrix, Better Uptime every 30 s, 50 virtual users | LCP 828 ms (San Antonio) and 931 ms (Mumbai); uptime 99.99% over 365 days; 9,960 requests, 1 failed, P95 6 ms |
| Software Rundown | 2 Apr 2026 | Same site on five hosts, up to 500 concurrent users | Flywheel average TTFB 276 ms; at 500 users 950 ms and 3.8% errors (Kinsta 0%). Its Flywheel price ($15) does not match Flywheel's own page, so use only the timings |
| PVY Empire | 27 Jun 2026 | Starter plan | TTFB under 300 ms; no written uptime SLA |

### Conflicts
- Guarantee: PVY Empire says 30 days, Flywheel says 60 days. Use Flywheel (official).
- Trust: HostingAdvice rates it 4.8 of 5. digitalpritam reports Trustpilot 1.5 from 71 reviews. G2 shows 4.1 from 43 reviews, with 2026 complaints about support and about plugin updates held back for days (reviewer quotes, 30 Mar and 2 Sep 2026). Present both, attributed.
- Phone support: only for customers who spend $250 or more a month (HostingAdvice).

### Angle the top pages do not take
A cost-at-your-traffic table (our arithmetic): the plan you really need once visits pass the limit, using the $1 per 1,000 visits overage, against Kinsta, WP Engine and Cloudways. Plus an honest "who should not buy" for Asia-based audiences and anyone who needs email.

### Questions ranking pages answer
Is Flywheel easy to use? Is it fast? Does it include email? What support does it offer? What payment methods? Refund policy? Will they migrate my site? What is the right plan? Can I host multiple sites? Free trial? What CDN? How does it compare with Kinsta and WP Engine? What happened after WP Engine bought it? Is it worth the price? Who should use it?

---
## 2. DreamHost (existing URL: 4 ranking keywords, positions 11 to 27)

### Official facts (dreamhost.com pricing and plan pages, read 19 Nov 2026)
- Web Hosting Launch: $2.89 a month for the first year, renews at $10.99 (25 websites, 40,000 visits, 25 GB NVMe, daily backups). On a 4-year term $1.99 a month, renews at $7.99 (dreamhost.com/hosting/reviews). Growth $3.99 (50 sites, 200,000 visits, 50 GB). Scale (100 sites, 400,000 visits, 100 GB).
- Included: Liftoff AI website builder, unlimited free SSL, free domain for the first year, 3 months of free mailboxes, then email is billed. 24/7 support. Independently owned.
- DreamPress 1 (managed WordPress): $14.99 a month first year, renews at $19.99 (1 site, 15 GB, 40,000 visits, 14-day backups).
- Managed VPS Business: $13.75, renews at $31.99 (2 cores, 2 GB RAM). Stack 4 (root access, 2 vCPU, 4 GB, 75 GB): renews at $11.99.
- Guarantee: 30 days on the current plan pages. 100% uptime guarantee: one day of credit per hour of downtime, up to 10% of the next renewal.

### Independent tests
| Source | Date | Method | Result |
|---|---|---|---|
| WPBeginner | 6 Aug 2026 (July tests) | 15 hosts, same site, GTmetrix, 6 regions, 30-day uptime | LCP 986 ms, global response 658 ms, 100% uptime, score 64 of 100 (Hostinger 88, Bluehost 69) |
| hosttest.de | 10 Feb 2026 | Launch monthly plan | Uptime 100%, TTFB 0.133 s, LCP 1.5 s, overall 1.4 (very good) |
| HostingTweaks | 16 Aug 2026 | Repeated timed runs | Median TTFB 217 ms, fully loaded 3.6 s. Its uptime figures contradict each other, do not quote them |
| WPSchool | 23 Apr 2026 | 30 days on Shared Unlimited, 50 concurrent users | TTFB 487 ms, 99.97% uptime, TTFB rose to 800 to 950 ms under load |
| HostingAdvice | 2026 | Hands-on | Live chat waits of about 30 minutes; AI builder was hit or miss |

### Conflicts
- **Refund:** older reviews (WPSchool, ServerPicks) say 97 days. DreamHost's current plan pages say 30 days. RankPlot (30 Jun 2026) says DreamHost retired Shared Starter and Unlimited for new buyers in October 2025. Use the official 30 days and say older plans had longer windows only if DreamHost confirms.
- **Plan names:** WPSchool and RankPlot tested legacy plans. Label any such number as "tested on a legacy plan".
- **Data centers:** WPSchool says US only (Ashburn, Hillsboro). RankPlot lists Amsterdam too. Check DreamHost before stating.

### Angle
The renewal truth: $2.89 to $10.99 is 3.8 times (Host Cliff, 13 Nov 2026, also our arithmetic), while the 4-year term goes $1.99 to $7.99 (4.0 times). A table of 1-year, 4-year and monthly cost, plus the legacy 97-day myth corrected.

### Questions
Is DreamHost fast? Uptime? Phone support? WooCommerce? Is it good for WordPress? Is the control panel easy? Money-back guarantee? How much after renewal? Support quality?

---
## 3. Bluehost (existing URL: no ranking keywords in Semrush, 20,980 impressions at position 39.9)

### Official facts (bluehost.com shared and WordPress pages, read 19 Nov 2026)
- Black Friday (offer Oct 1 to Nov 30, 2026): Starter $4.24 a month on a 12-month term (65% off), renews at $11.99. Business $6.79 (58% off), renews at $15.99. Starter: 10 websites, 10 GB NVMe, ideal for about 40,000 visits, weekly backups, 99.99% uptime SLA, 30-day money-back guarantee, no phone on Starter.
- 36-month terms (TechRadar, 19 Oct 2026): Starter $3.99 renewing at $9.99, Business $6.99 renewing at $13.99, eCommerce Essentials $14.99 renewing at $21.99. The full term is charged up front.
- Recommended by WordPress.org. Trustpilot 4.4 from 32,360 reviews (Bluehost page).
- Free domain for the first year (redeem within 90 days). Domain privacy free only from Business.

### Independent tests
| Source | Date | Method | Result |
|---|---|---|---|
| WPBeginner | 6 Aug 2026 (July tests) | Same protocol on 15 hosts | Score 69 of 100, LCP 933 ms, 599 ms global response, 100% uptime over 30 days. Load test blocked by Bluehost's Cloudflare; last completed run 140 ms P95 at 50 users |
| SimonHosting | 11 May 2026 | GTmetrix, 30-day UptimeRobot, 50 users | TTFB 462 ms, LCP 0.90 s, 100% uptime, 298 ms at 50 users, zero failures |
| TechRadar | 19 Oct 2026 | WordPress Benchmark plugin and Siege at 5, 9 and 15 users | Server score 7.9. Availability 95.6% to 96.7%; response time rose from 0.41 s to 2.61 s at 15 users |
| HostsAdvice | 9 Feb 2026 | Hands-on | TTFB 589 to 804 ms; measured uptime about 99.96% |
| Softwarestackpro (Themeisle tracker) | 10 Oct 2026 | Long-running test site | US LCP 0.69 s against 1.2 s for similar hosts; Europe 1.29 s; Asia 2.05 s; no downtime in 3 months |

### Conflicts and cautions
- Intro prices differ by term and by link (WPBeginner $2.99, TechRadar $3.99, Bluehost Black Friday $4.24). Always state the term.
- Oracle Cloud migration claims (4 to 5 times faster) are Bluehost's own figures via trybestsoft. Label as vendor claims.
- Weekly backups only on shared plans.

### Angle
A 36-month versus 12-month cost table (our arithmetic: $3.99 x 36 = $143.64 then $9.99 x 36 = $359.64) and an honest "beginner pick that is not the fastest": WPBeginner puts Hostinger at 659 ms LCP and Bluehost at 933 ms.

### Questions
Is Bluehost good for beginners? How fast? Uptime? Cost after the first term? Can I avoid the renewal increase? Refund? Who should use it? What is Bluehost? Is it worth it in 2026?

---
## Missing before any draft (needs Jamil)
1. Semrush exports (request in `claude/data/semrush-hosting-request-2026-11-19.md`) to confirm the keyword and the URL decision.
2. Affiliate link formats, offer end dates, and whether we add these three to the review set.
3. A second read of each host's official pages on the publish day.
