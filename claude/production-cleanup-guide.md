# reinforcelab.com clean-up: Jamil's steps

Written 21 Oct 2026 after Claude's outside scan (F-041, F-042). Claude cannot change production; these steps are yours. After each step, tell Claude and it re-runs the scan (`python3 claude/tools/prod-scan.py`) to confirm.

## What the outside scan found

| | Result |
|---|---|
| Spam links (F-033) | **Gone** from all 193 pages in the sitemaps. Google sees the same pages as visitors |
| Fake plugin `lunar-profiler-ink` | **Still on the server** (the folder answers like a real one) |
| WP File Manager plugin | Installed (8.0.4). A file manager inside WordPress is a favourite tool for attackers. Not needed |
| WPCode (Insert Headers and Footers) | Installed. It adds code to every page's header and footer, where the spam block used to sit. Its snippets must be checked |
| Other plugins | 15 found. Every one is a little behind its latest version |
| `core-plugin` | Blocked by the firewall by name, so its presence cannot be seen from outside. Hackers use this name |
| Backup and secret files | Protected (the server refuses them) |
| Admin accounts | Cannot be seen from outside |

## Your steps, in order

### 1. Make a backup first (5 minutes)
hPanel → Websites → reinforcelab.com → **Backups** → generate a new backup of files and database. Do not skip: it lets us undo any step.

### 2. Run Hostinger's malware scan (10 minutes, runs by itself)
hPanel → Websites → reinforcelab.com → **Security** → **Malware Scanner** → scan. Send Claude a screenshot of the result, including every file it lists.

### 3. Delete the fake plugin
hPanel → **File Manager** → `public_html/wp-content/plugins/`.
- Right-click `lunar-profiler-ink` → **Delete**.
- While you are in this folder, take a screenshot of the full list of folders and send it to Claude. Look especially for `core-plugin` or any name you do not recognise. Expected folders: `woocommerce`, `wordpress-seo`, `wordpress-seo-premium`, `bb-plugin`, `bb-theme-builder`, `bbpowerpack`, `wpforms`, `insert-headers-and-footers`, `classic-editor`, `google-site-kit`, `all-in-one-wp-migration`, `woocommerce-paypal-payments`, `litespeed-cache`, `wp-file-manager`, `ewww-image-optimizer`, and possibly a few more you installed yourself.

### 4. Check the must-use plugins folder
File Manager → `public_html/wp-content/mu-plugins/`. Screenshot the list. Normal on Hostinger: `hostinger-auto-updates.php`, `hostinger-preview-domain.php`. Anything else (for example `health-check-api.php`) is suspect: do not open it, tell Claude.

### 5. Check the top of wp-config.php (look only, do not send it)
File Manager → `public_html/wp-config.php` → **Edit**. Look at the first 5 lines only. It should start with `<?php` followed by comments. If you see a line with `include`, `require`, `eval` or a long jumble of letters near the top, tell Claude the line (that line only, never the passwords further down). On `.online` the attacker had added `@include_once(__DIR__ . "/wp-includes/class-wp-cache.php");` as line 3.

### 6. Check the admin users
wp-admin → **Users** → click **Administrator**. Screenshot the list. Delete any account you do not know, and when asked, give its content to your own account. Names seen on `.online`: `reinforcelab` (email `@wp-ads.net`), `root`, `WordPress Support`, `adminwp` (often hidden from the list), `d6bvip8jhrd`, `ogbn0f5ynf`.

### 7. Check WPCode snippets
wp-admin → **Code Snippets** (WPCode) → **All Snippets**. Screenshot the list. Any snippet you did not add, especially one set to the site footer or "run everywhere", should be deactivated and deleted. Then **Code Snippets → Header & Footer**: the footer box should be empty or hold only code you know (for example Google tags).

### 8. Remove WP File Manager, then update everything
wp-admin → **Plugins**: deactivate and delete **WP File Manager** (Hostinger's File Manager does the same job safely). Then **Dashboard → Updates**: update WordPress, every plugin and the Beaver Builder theme. Note the WordPress version it shows before updating and tell Claude.

### 9. Passwords and two-factor login
- Change the password of every admin account you keep.
- hPanel password, and turn on two-factor login in hPanel.
- Your email (Titan) password.
- Database password and the secret keys in `wp-config.php`: ask Claude first. Changing these needs a matching change in `wp-config.php`, and a mistake takes the site down.

### 10. Server scheduled tasks
hPanel → **Advanced** → **Cron Jobs**. Screenshot the list. Hostinger sites normally have none; anything listed that you did not create is suspect.

### 11. Google Search Console
Search Console → **Security & Manual actions** → **Security issues** and **Manual actions**. If either shows a problem, click **Request review** and say the hacked links were removed and the site was cleaned.

### 12. Tell Claude
Claude re-runs the scan and checks: the fake plugin folder answers 404, File Manager is gone, versions are current, still no spam on any page.

## Also on the same Hostinger account
About 20 other sites share this account. One infected site can change the others. After reinforcelab.com, run the Malware Scanner (step 2) on each of them.
