# hPanel steps for the rebuild setup (D-219), 18 Nov 2026

Do these on the existing Hostinger account. Menu names in hPanel can differ a little; the goal of each step is stated. Never paste a password, key or token into chat, git or this file.

## Before you start (10 minutes)
1. Hostinger password changed, two-factor on (the security case is still open).
2. Licences: Beaver Builder, Beaver Themer and Yoast Premium were expired on production (F-047). Renew or confirm active, or the zip download may be blocked or old.

## Step 1: test address
1. hPanel, **Websites, Add website**. Choose the empty option (custom PHP or "empty website"), not WordPress auto-install.
2. Address: `new.reinforcelab.online` (a subdomain of the dev domain, so nothing on reinforcelab.com changes).
3. Note the folder path hPanel shows (usually `~/domains/new.reinforcelab.online/public_html`).
4. Turn on SSL for it (hPanel, Security, SSL) and leave it noindex.
5. Add a password to the folder (hPanel, **Advanced, Password protect directories**), so only you and I can see the staging site.

## Step 2: empty database
1. **Databases, Management**, create a new database and a new database user. Use a long unique password that is not used anywhere else.
2. Write down the database name, user and host (`localhost`) in a private note. The password stays in your password manager.

## Step 3: SSH
1. **Advanced, SSH Access**, turn SSH on.
2. Note the host, port and user hPanel shows. Add an SSH key if you can (better than a password).
3. Log in from your computer once to check it works. WP-CLI (`wp`), `php`, `git` and `curl` must exist: run `wp --version`, `php -v` (8.2 or newer), `git --version`.

## Step 4: the 6 vendor zips
Download each from the vendor account and upload to one folder outside the web folder, `~/rl-vendor/` (hPanel **File Manager**, or `scp`). Keep the zips unopened.

| Zip | Where to download |
|---|---|
| Beaver Builder Pro (`bb-plugin`) | wpbeaverbuilder.com, My Account, Downloads |
| Beaver Themer (`bb-theme-builder`) | wpbeaverbuilder.com, My Account, Downloads |
| Beaver Builder Theme (`bb-theme`) | wpbeaverbuilder.com, My Account, Downloads |
| PowerPack (`bbpowerpack`) | wpbeaveraddons.com, My Account |
| ACF PRO (`advanced-custom-fields-pro`) | advancedcustomfields.com, My Account |
| Yoast SEO Premium (`wordpress-seo-premium`) | my.yoast.com, Downloads |

The script checks each zip has the right folder inside and writes its checksum to the log.

## Step 5: run the rebuild (over SSH)
```bash
git clone https://github.com/jamilahmed16/reinforce-lab-wp-modernization.git rl && cd rl
git checkout claude/great-wright-cg4kqo
export DB_NAME=... DB_USER=... DB_PASSWORD=... DB_HOST=localhost
bash claude/rebuild/rebuild.sh --path ~/domains/new.reinforcelab.online/public_html --url https://new.reinforcelab.online --vendor ~/rl-vendor --source https://reinforcelab.online
```
If the repository is private, clone with a read-only deploy key or upload a zip of the branch instead.
The script stops at the first problem and says why. Save the log it writes to `claude/rebuild/logs/` and send it to me (it holds no passwords).

## Step 6: after the run
1. Log in at `https://new.reinforcelab.online/wp-admin/` and enter the five licence keys.
2. Change the admin password right away.
3. Tell me it is done. I run the redirect test, link scan, post check, parity, accessibility and speed checks against it.

## What I need from you
The address (`https://new.reinforcelab.online`), the log from step 5, and the staging password if you set one. Not the database password or SSH key.
