# bs-trim: trimmed Bootstrap for the lean pages (D-174)

The Beaver Builder theme loads all of Bootstrap 4.6.1 (162 KB, 24 KB compressed) and blocks the first paint with it.
The lean pages (home, `/services/`, `/industries/`, see `core/reinforce-speed.php`) use about 90 of its 2,634
selectors. These scripts build `wp/novamira-sandbox/core/reinforce-bootstrap-lean.css` (about 8 KB), which
`reinforce-speed.php` prints inline in place of the Bootstrap link on those pages.

Re-run when a lean page gains markup that Bootstrap might style (new HTML elements, form fields, tables):

```
mkdir -p /tmp/bs && cd /tmp/bs
curl -so bootstrap-4.min.css 'https://reinforcelab.online/wp-content/themes/bb-theme/css/bootstrap-4.min.css?ver=1.7.20'
python3 <repo>/claude/tools/bs-trim/bsparse.py            # -> selectors.json (every selector in Bootstrap)
node <repo>/claude/tools/bs-trim/bsmatch.mjs <repo>/claude/tools/bs-trim/urls.txt   # -> used.json (selectors that match an element on any listed page, 1440 and 390; :hover and other states ignored, so it keeps more, never less)
python3 <repo>/claude/tools/bs-trim/bsbuild.py            # -> bootstrap-lean.css (original text of the kept selectors, same order, same media queries)
cp bootstrap-lean.css <repo>/wp/novamira-sandbox/core/reinforce-bootstrap-lean.css
```

Then compare full-page screenshots of every page in `urls.txt` before and after (D-174 method) before deploying.
