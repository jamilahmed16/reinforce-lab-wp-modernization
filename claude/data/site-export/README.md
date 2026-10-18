# Site export: reinforcelab.online as data only (18 Oct 2026)

Why: `.online` and `.com` share one Hostinger account and both are compromised (F-033, F-035). The new site is rebuilt on a **fresh WordPress on new hosting**. Nothing executable is copied from the old servers: code comes from this git repository and from the vendors; content, settings and media come from these files.

Made by `python3 claude/tools/export-site.py` (read-only on `.online`). Re-run it before the rebuild if content changes on `.online`.

| File | What it holds |
|---|---|
| `posts.json` | 57 pages, 81 posts, 3 portfolio projects, 175 media records, 53 menu items, the Beaver Themer layout, the ACF field group (1 group, 12 fields, 1 post type) and the custom CSS, each with its meta (Yoast, ACF, `rl_*`, featured image). Revisions, edit locks, trash and Jetpack meta left out. |
| `terms.json` | 25 categories, 2 menus, which post is in which, and the menu locations. |
| `options.json` | 267 settings the site needs (site title, permalinks, front and blog pages, Yoast, Beaver Builder, LiteSpeed, our `rl_*` options). Licence keys, tokens, passwords, hashes, Jetpack, Novamira, Hostinger and Cloudflare settings are excluded by name, and any nested key that looks like a credential is replaced by `[removed]`. |
| `option-names.json` | The names of all 577 options on `.online`, to check nothing needed was missed. |
| `users.json` | The 3 authors posts point at (`jamilahmed`, `jadirectives@gmail.com`, `reinforcelab-team`): names and roles only. No passwords. The six unknown admins (F-035) are not here. |
| `uploads.json` | 2,318 media files (69.6 MB) to bring across, each with size, sha1 and file signature (every signature matches its extension). Only images, PDFs, fonts and two checked SVG badges. Left out: the dev-only `.htaccess`, the dropper zip `2026/08/ab5c7c9b.zip`, and plugin-generated caches. |
| `scan.json` | Fields matching script, iframe, PHP or obfuscation patterns: **0**. |

Not exported on purpose: the 2 diagnostic form submissions (personal data, test entries), Novamira's design record, the unused themes (`twentytwentyfive`, `wise-news`), every plugin's files (installed fresh from the vendor), everything in F-035.
