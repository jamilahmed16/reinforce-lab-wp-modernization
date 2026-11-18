# Message for Hostinger customer support (draft, 18 Nov 2026)

Facts below come from `claude/decision-log.md` (F-033, F-035, F-036, F-041 to F-047). They were found by outside scans and read-only checks, not from server logs, so the message asks Hostinger to confirm them on the server.

---

**Subject:** Security incident on my hosting account: two WordPress sites hacked, please investigate and help clean up

Hello,

I am the owner of this hosting account. Two WordPress sites on it were hacked: reinforcelab.com (live) and reinforcelab.online (test copy). I need your security team to investigate at server level and help me clean the account. Please open this as a security case and send me the case number.

**What we found (from outside scans, not server logs)**

1. **reinforcelab.com:** on 14 Oct 2026 every page carried a hidden block of about 25 spam links (gambling and adult sites), placed off-screen just before the closing scripts. It was added by code running in the page footer, not by the page content. I have since removed these plugins: a fake plugin folder named `lunar-profiler-ink`, `wp-file-manager`, `cartflows-pro`, `custom-post-type-ui` and `woocommerce-checkout-manager`. The spam links are gone from the pages today, but I do not know how the attacker got in.
2. **reinforcelab.online:** an unknown administrator account named `reinforcelab` (email at `wp-ads.net`) logged in on 9, 14, 15 and 16 Oct 2026 from the IP addresses 157.22.72.125, 209.99.185.18 and 84.15.184.66. I also found six unknown administrator accounts (one hidden by a must-use plugin), an obfuscated fake plugin, a fake "Event" plugin added on 9 Oct, a PHP file inside `wp-content/cache/`, a zip file in uploads, a line in `wp-config.php` that loads a missing file `wp-includes/class-wp-cache.php`, and three hidden hourly cron tasks with random names. The earliest trace I can see is April 2026. I have kept the evidence and have not removed it.
3. **One account, many sites:** both sites sit under the same hosting user, together with about 20 other sites. I think the attack may have come through the account and not through one WordPress site.
4. **Crawler behaviour:** since 21 Oct, requests from Googlebot return an empty page and GPTBot gets HTTP 429, while normal browsers get the full page. The sites are served through your CDN (`hcdn`). Please tell me whether a CDN or firewall rule causes this and how to turn it off for real Googlebot.

**What I am asking you to do**

1. Run a full server-side malware scan of the whole account (all sites, all folders, the databases, cron and the home directory) and send me the report.
2. Check the access, error and login logs from April 2026 to today. Tell me how the attacker got in, which files and accounts were used, and which dates.
3. Check the account for anything outside WordPress: SSH keys, FTP accounts, extra database users, scheduled tasks, auto-prepend files, `.htaccess` rules and unknown files in the home directory.
4. Reset all sessions and tokens for the account, and tell me whether any of my hosting, FTP, SSH, database or email credentials were exposed.
5. Tell me whether the sites can be moved into separate users or separate hosting plans, so that one hacked site cannot reach the others.
6. If you can, clean the infected files, or give me a clean restore point from before April 2026 for each site.
7. Send me a written summary of what you find and what you removed, so I can keep it as a record.

**What I am doing on my side:** I am changing every password with two-factor authentication, keeping offline backups of both sites as evidence, and rebuilding the sites as fresh WordPress installs with new databases.

Please reply in writing and tell me what you need from me (access, logs, a date for the scan). I will not delete the evidence until you confirm you have what you need.

Thank you,
[Name], owner
Account email: [account email]
Domains: reinforcelab.com, reinforcelab.online

---

## Before you send it (for Jamil)
- Change your hosting, WordPress, database, FTP and mailbox passwords first, and turn on two-factor. Do not put any password in the message or in chat.
- Do not give support your WordPress admin login unless they ask for it through their own secure form.
- Attach the screenshots you already have (plugins list, mu-plugins) and name the three IP addresses above.
- Ask for a ticket number and keep every reply.
- If chat support only gives general advice, ask them to escalate to the security or abuse team.
