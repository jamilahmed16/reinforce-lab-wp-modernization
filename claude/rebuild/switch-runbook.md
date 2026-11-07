# Switch day runbook: the rebuilt site becomes reinforcelab.com (checklist A6)

**Who:** Jamil approves the switch and does the hPanel steps (Rule 1: Claude never changes reinforcelab.com on its own). Claude runs the checks and the commands Jamil asks for, over SSH on the new site's folder only.
**When:** only after every gate in "Before" is green. Pick a quiet time (low traffic in Search Console, for example a weekend morning in Bangladesh).
**How long:** about 1 hour, plus 1 hour of checks.

## Before (all must be true)

- [ ] Staging build made by `claude/rebuild/rebuild.sh` from the latest export, on the test address.
- [ ] `python3 claude/tools/redirect-test.py https://<staging>`: **0 failures** (old `/wp-content/` files answer 410 there because of the server rules).
- [ ] `python3 claude/tools/link-scan.py https://<staging>`: **0 bad links**.
- [ ] `python3 claude/tools/post-check.py https://<staging>`: 81 posts, 0 problems.
- [ ] Page check of the 17 pages kept at the same address against production (A5).
- [ ] Jamil has looked at Home, a service page, a post and the blog on phone and desktop.
- [ ] Licences entered (Beaver Builder, Themer, PowerPack, ACF PRO, Yoast Premium); GA4 ID; SMTP mailbox tested with the contact form.
- [ ] Novamira is **not** installed on the new site (Rule 1). `wp plugin list` shows no novamira.
- [ ] Fresh full backup of production (hPanel, Backups: files and database), downloaded and kept offline.
- [ ] WooCommerce orders exported from production (D-148) and kept.

## Switch (Jamil in hPanel, Claude over SSH)

1. **Freeze:** no edits on either site from here.
2. **Move the old site aside (Jamil, File Manager):** rename reinforcelab.com's `public_html` to `public_html_old_<date>`. Do not delete it (evidence and rollback, 30 days).
3. **Put the new site in place:** move the staging folder's contents into a new `public_html` for reinforcelab.com (or point the domain's root at the staging folder if hPanel offers it). Copy `wp-config.php` with it (it points at the new database).
4. **Change the site address (Claude, SSH, in the new folder):**
   ```
   wp search-replace 'https://<staging>' 'https://reinforcelab.com' --all-tables-with-prefix --precise --skip-columns=guid
   wp search-replace 'https:\/\/<staging>' 'https:\/\/reinforcelab.com' --all-tables-with-prefix --precise --skip-columns=guid
   wp option update home 'https://reinforcelab.com' && wp option update siteurl 'https://reinforcelab.com'
   ```
5. **Turn indexing on:** `wp option update blog_public 1`. Copy `claude/data/robots-launch.txt` as the site's robots.txt (AI crawlers allowed, D-150). Make sure no `noindex` header file from `.online` came across (`wp-content/uploads/.htaccess` must only block scripts).
6. **SSL and one-hop redirects (Jamil, hPanel):** SSL active for reinforcelab.com and www; `http://` and `www.` go to `https://reinforcelab.com/` in one step.
7. **Cache:** LiteSpeed Cache with the `.online` settings (D-167: page cache only), then purge all.
8. **Environment type:** `wp config set WP_ENVIRONMENT_TYPE production`.

## First hour (Claude, gate)

- `python3 claude/tools/redirect-test.py https://reinforcelab.com`: **0 failures, or roll back.**
- `python3 claude/tools/link-scan.py https://reinforcelab.com` and `post-check.py https://reinforcelab.com`.
- The 45 ranking pages (F-051) and the pages with real backlinks (F-052) answer 200 or their approved one-step redirect.
- Home, contact form (a test message arrives), diagnostic form, cookie bar, one post, sitemap `https://reinforcelab.com/sitemap_index.xml`, robots.txt.
- Security headers present (HSTS, nosniff, referrer policy, frame protection).

## Rollback (if the first-hour gate fails and cannot be fixed within the hour)

1. Rename the new `public_html` to `public_html_new_failed_<date>`.
2. Rename `public_html_old_<date>` back to `public_html`.
3. Purge cache. Production is back as it was; nothing in its database was touched.

## After

- Search Console: submit the sitemap; request indexing for Home and the main service pages; upload the disavow file (D-221, refresh it first).
- Monitoring for 6 weeks (checklist B2): indexed pages, 404 log, clicks against the baseline.
- After 30 days with no rollback: download `public_html_old_<date>` as an archive for the record, then delete it from the server.
- Reminders: promotion session, company profile redesign, rewrites one at a time (D-218).
