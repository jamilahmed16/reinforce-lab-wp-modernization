# Tools

Everything needed to change, check and record reinforcelab.online (**development only, never production**).
Run from the repository root. Requires the Novamira CLI (connected to `.online`), Python 3, and Node with Playwright.

## `rl.py`: deploy, parity, snapshot, backups, crawl, preview

| Command | What it does | Writes to .online? |
|---|---|---|
| `python3 claude/tools/rl.py deploy <file> …` | Guarded update. Aborts unless the site is noindex and the live file still matches git HEAD. Parse-checks PHP, backs up to `novamira-sandbox/_backups/<stamp>/`, writes, clears opcache, then confirms the live md5 equals the repo. | yes |
| `python3 claude/tools/rl.py deploy --create <file>` | Guarded create of a new sandbox file (aborts if it exists). | yes |
| `python3 claude/tools/rl.py deploy --changed` | Deploys every sandbox file that differs from git HEAD. | yes |
| `python3 claude/tools/rl.py parity` | Compares every live sandbox file with the repo by md5. Must report 0 differences. | no |
| `python3 claude/tools/rl.py snapshot` | Exports the database side of the site to `claude/data/online-snapshot/` (pages and posts with content, Yoast meta and `rl_` fields; menus; reading and permalink settings; Yoast settings; categories; plugins; Themer layouts; `rl_` options; the sandbox md5 manifest). Secret-like values are redacted. Run after every change and commit the result. | no |
| `python3 claude/tools/rl.py backups [--prune-days N]` | Lists deploy backups; with `--prune-days` deletes those older than N days. Every backed-up version is also in git history. | only with prune |
| `python3 claude/tools/rl.py crawl` | Fetches every published page and flags em or en dashes, emoji, PHP notices, or a missing noindex. | no |
| `python3 claude/tools/rl.py preview-post spec.json out.html` | Renders a post **in memory** through the live single-post template (nothing is saved, F-003). `spec.json`: `{"title", "excerpt", "body_file" or "body", "meta": {"rl_type": "guide", …}}`. Prints the schema node types. | no |

## `shot.mjs`: screenshots and phone width

```bash
node claude/tools/shot.mjs width blog/ about-us/            # each must print 390
node claude/tools/shot.mjs page industries/healthcare/ out   # out-desktop.jpg, out-phone.jpg
node claude/tools/shot.mjs html preview.html out             # screenshot an rl.py preview-post render
```

The dev-site proxy drops random assets, so static assets are cached in `claude/tools/.cache/` (git-ignored) and replayed; only the HTML is fetched fresh.

## `copy-check.py`: copy rules (D-072, D-073)

`python3 claude/tools/copy-check.py [files…]`: no em or en dashes, no emoji or emoji-like symbols, no banned AI words. Must report 0 issues before anything ships.

## Style fingerprint (visual-regression check for CSS refactors)

Records the computed style and box of every element inside each page's wrapper at 1440 px and 390 px, then diffs two runs. Used for D-044 (CSS merge).

```bash
node claude/tools/style-fingerprint.mjs before
# ...deploy the change...
node claude/tools/style-fingerprint.mjs after
python3 claude/tools/style-fingerprint-diff.py fp-before.json fp-after.json   # TOTAL 0 = no visual change
```

Add pages to the `pages` map as they are built. It caches static assets for deterministic runs and uses `reducedMotion: 'reduce'`.

## Standard change routine

1. Edit the file in `wp/novamira-sandbox/`.
2. `copy-check.py`, then `php -l` on the file.
3. `rl.py deploy <file>` (or `--create`).
4. Check: `shot.mjs width …`, screenshots, and `rl.py crawl` for site-wide copy changes.
5. `rl.py snapshot` if pages, menus, Yoast or settings changed.
6. Record the change in `claude/decision-log.md`, commit and push.
