# Hosting research: performance and security (24 Oct 2026)

Asked by Jamil (24 Oct): "I need your research before deciding hosting: what are the best hosts for excellent performance and security." Context: D-219 (rebuild on the existing Hostinger account for now, move after the first client).

**How to read this:** prices and features were read on 24 Oct 2026 from each host's own pages and recent reviews; check them again at checkout. "Independent" means tested by Review Signal's WordPress Hosting Performance Benchmarks 2026 (wphostingbenchmarks.com), the only long-running independent load test (since 2013; 2026 is the first edition in three years). Everything else is the host's own claim. `[VERIFIED]` = read on the source page; `[CLAIM]` = the host says so, not independently tested.

## 1. The independent test (Review Signal 2026)

| Band | Top Tier |
|---|---|
| Under $25/month | 34SP.com, Bluehost, DreamHost, GoDaddy, GreenGeeks, ICDSoft, Lightning Base, **Pressable**, WP Buzz, **WPX** |
| $25 to $50/month | GreenGeeks, **Pressable**, Tangible, WordPress.com, WP Buzz, **WPX** |
| $51 to $100/month | Bluehost, **Pressable**, Tangible, WP Buzz, **WPX** |

- **Pressable** entered all 6 bands and was Top Tier in all 6: 100% uptime on all three monitors, 35 errors in 6.7 million test requests, A+ SSL. `[VERIFIED]`
- **WPX** had the fastest cached response in two bands (4.9 ms and 4.1 ms). `[VERIFIED]`
- **Kinsta, WP Engine, Rocket.net, SiteGround, Cloudways and Nexcess did not take part in 2026** (they did in earlier years). Hostinger was not in the $25 to $50 band. There is no current independent result for them: not slow, just untested. `[VERIFIED]`

## 2. The candidates side by side

| | Pressable | Kinsta | Rocket.net | WPX | WP Engine | Hostinger (separate plan) |
|---|---|---|---|---|---|---|
| Entry price | $25/mo, or $20.83/mo paid yearly ($250); no teaser price | $35/mo, about $30/mo yearly | $30/mo, $25/mo yearly; says no renewal rise | $29.99/mo Business; lowest rates need long prepay | $28 to $35/mo; renewal price not published | Cloud Startup $7.99/mo for 48 months, renews $25.99/mo; Agency Startup $29/mo (24 months), renews $49/mo |
| Independent 2026 test | Top Tier, every band | not tested | not tested | Top Tier, every band entered | not tested | not tested in our band |
| Firewall (WAF) | included | included (Cloudflare) | included (Cloudflare Enterprise) | included (ModSecurity) | edge WAF is a paid extension | basic; Monarx malware scanner |
| Malware clean-up | "we'll help you fix it", Jetpack Security included ($239/yr value) | removal pledge, conditions apply | malware scanning included | free clean-up, daily scans | support-assisted | free scanning |
| Backups kept | daily files + hourly database, 30 days | 14 days (entry plan) | 30 days | 28 days, restore-only | 30 to 60 days | daily (Cloud) |
| Site isolation | yes (WP Cloud, own PHP workers per site) | yes (container per site) | yes | yes | yes | **Agency plans: "full website isolation"**; a separate plan has its own server user |
| SSH + WP-CLI (our rebuild script needs it) | yes | yes | yes | SFTP; no root | yes | yes |
| Server type | WP Cloud (not LiteSpeed) | Google Cloud (not LiteSpeed) | edge + bare metal (not LiteSpeed) | **LiteSpeed** | Google Cloud / AWS (not LiteSpeed) | **LiteSpeed** |
| Data centres | US, real-time copy to a second region; 28 CDN edges | 30 to choose from, incl. Asia | 10 origins, 330+ edges | Chicago, London, Sydney | several | many incl. Asia |
| Other | Automattic (WordPress.com) company; Secure Hosting Alliance certified; 30-day money back | strong dashboard; Redis is $100/mo extra | unmetered visits, 50 GB bandwidth | fast human support | we have a WP Engine partner page (affiliate): not a reason to choose it | cheapest; same company as today |

## 3. What matters for our site specifically

- **Traffic is small today** (27 Search Console clicks in Aug 2026, DISCOVER baseline). Every entry plan above has room; visit caps (Pressable 30k, Kinsta 35k, WP Engine 25k) are far above our level.
- **LiteSpeed Cache (D-167):** works only on LiteSpeed servers (Hostinger, WPX). On Pressable, Kinsta, Rocket.net or WP Engine we drop that plugin and use the host's own cache. Small change in the rebuild script.
- **Beaver Builder, Themer, PowerPack, ACF PRO, Yoast Premium:** standard plugins, supported on all of these hosts.
- **Where visitors are:** Bangladesh and the US office plus international B2B. A strong CDN matters more than the origin city; all candidates include one.
- **Security lesson from F-033/F-035:** what hurt us was sharing one server user with ~20 other sites and not knowing the way in. Any of these hosts fixes the sharing problem; none removes the need for unique passwords, two-factor login and updates.

## 4. Recommendation

**Now (before the first client), stay with Hostinger but isolate reinforcelab.com.** Cheapest real fix for the shared-user risk:
- either a **separate Hostinger plan** just for reinforcelab.com (Cloud Startup, $7.99/mo for 48 months, renews $25.99/mo: its own server user, 4 CPU cores, SSH, WP-CLI, daily backups, LiteSpeed so nothing in our setup changes),
- or move the account to an **Agency plan** with "full website isolation" (Agency Startup $29/mo for 24 months, renews $49/mo) if Jamil wants to keep all ~20 sites together but separated.
Jamil to check which plan the account is on today (hPanel, Hosting) before choosing.

**Later (after the first client): Pressable first, Kinsta second, WPX third.**
1. **Pressable:** the only premium host with current independent proof (Top Tier in every band, 100% uptime), security included (WAF, malware monitoring, Jetpack Security, hourly database backups), honest pricing ($25/mo, no teaser rate), 30-day money back.
2. **Kinsta:** strong security and the widest choice of data centres (including Asia), but no 2026 independent test and higher price.
3. **WPX:** independently fast, free malware clean-up, LiteSpeed (our cache setup stays), but only three origin cities and the best prices need a long prepayment.
Not recommended for us now: **WP Engine** (edge firewall is an extra, renewal price not published, no current independent test) and **Rocket.net** (good on paper, no current independent test). Both are fine hosts; the evidence for them is weaker today.

## Sources (read 24 Oct 2026)

- Review Signal 2026 benchmarks: wphostingbenchmarks.com/benchmark/2026-25-wordpress/, /2026-50-wordpress/, /company/pressable/; The Repository news report (5 Jun 2026) on who took part; WP Cloud summary (7 Jul 2026).
- Pressable pricing and plan pages (pressable.com/pricing/, /managed-wordpress-hosting/affordable/, /monthly/, /agency-2026/).
- WPX security pages (wpx.net/page/secure, wpx.net/kb/what-does-wpx-do-to-protect-your-websites/) and JoshWP review (updated 25 Sep 2026).
- Hostinger pricing (hostinger.com/pricing, /pro) and its cloud hosting price article (21 Oct 2026).
- Kinsta, WP Engine and Rocket.net figures from HostingGuider (read 25 to 28 Sep 2026), iTechGuides (11 Aug 2026), VulnTitan Kinsta vs WP Engine security (3 Oct 2026) and ComparisonMath (1 Aug 2026). Confirm on each host's own page before buying.
