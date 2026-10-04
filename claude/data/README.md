# Data

Evidence and exports. Never invent numbers: if a figure is not in these files or the decision log, it is not known.
Back to [project documents](../README.md).

| Folder or file | What it is | Site |
|---|---|---|
| [gsc-2026-09/](gsc-2026-09/README.md) | Search Console (performance, page indexing, links) and GA4, pulled 10 Sep 2026 | reinforcelab.com |
| [production-config/](production-config/) | WPCode snippets and Yoast redirects exported 10 Sep 2026 | reinforcelab.com (read only) |
| [approved-new-urls-2026-09.csv](approved-new-urls-2026-09.csv) | New URLs Jamil approved | both |
| [online-snapshot/](online-snapshot/) | The database side of the development site: pages with content and SEO meta, menus, settings, Yoast settings (secrets redacted), categories, plugins, Themer layouts, `rl_` options, sandbox file md5s. Refresh with `python3 claude/tools/rl.py snapshot` | reinforcelab.online |

Still missing for the migration (Jamil to export): URL-level backlinks, full GSC pages and queries, GSC Page Indexing, GA4 landing pages and conversions. See [migration-and-data-requirements.md](../migration-and-data-requirements.md).
