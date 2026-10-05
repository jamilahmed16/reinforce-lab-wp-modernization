# Theme code for reinforcelab.online

`wp/novamira-sandbox/` mirrors `wp-content/novamira-sandbox/` on reinforcelab.online, file for file. `claude/tools/rl.py parity` must report 0 differences.

Novamira loads **top-level `*.php` files only**, so there is one top-level file, `reinforce-loader.php`, and everything else lives in a folder and is loaded from the loader's list (D-080).

| Folder | What lives there |
|---|---|
| `core/` | Site-wide parts: header, mega menu, mobile menu, footer, helpers (`reinforce-header.php`); the shared page kit (`reinforce-kit.php` + `reinforce-kit.css`); phone versions of hero diagrams (`reinforce-phone-hero.php`) |
| `pages/` | Company pages: Home, About, Awards, Contact |
| `saos/` | Search Authority OS, Diagnostic (form handler), Packages, Agents hub, the 8 agent pages, and their 8 hero visuals (`reinforce-agent-visuals.php`) |
| `services/` | The Services hub and every service page |
| `industries/` | The Industries hub and the 8 industry pages (one file) |
| `blog/` | Blog archive template, single post template, post-type sections, and one file per approved post-type design (`reinforce-post-guide.php`, …) |

Which file builds which page (with page IDs and URLs): [`claude/site-map.md`](../claude/site-map.md).

## Adding a file

1. Put it in the right folder, named `reinforce-<name>.php`.
2. Add `'<folder>/reinforce-<name>.php',` to the list in `reinforce-loader.php`. **A file that is not in the list does not load.**
3. Deploy the new file with `python3 claude/tools/rl.py deploy --create <folder>/reinforce-<name>.php`, then deploy the loader with `python3 claude/tools/rl.py deploy reinforce-loader.php`.

## Not in the repo

- `index.html`, `web.config` and `.htaccess` on the server are Novamira's own protection files (only CSS and JS are served directly).
- `_backups/` on the server holds deploy backups. Every version is also in git history.
