# bs-trim: trimmed theme CSS for the lean pages (D-174, D-175)

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

The theme skin is trimmed the same way (D-175), with the input and output names and a banner as arguments:

```
python3 bsparse.py skin.css && node bsmatch.mjs urls.txt
python3 bsbuild.py skin.css skin-lean.css "Beaver Builder theme skin (...), trimmed to the rules used on the lean pages (D-175)."
cp skin-lean.css <repo>/wp/novamira-sandbox/core/reinforce-skin-lean.css
```

Each built file records the md5 of the file it was cut from. `reinforce-speed.php` uses the copy only while the
theme's file still has that md5; after a theme update or a Customizer save (which writes a new skin file) the page
falls back to the full file until the copy is rebuilt.

**Verify before deploying the copy for real use:** `node verify.mjs [urls.txt]` loads every page (1440 and 390),
records the computed style of every element and pseudo-element, swaps the inline copies back to the full theme
files and records again; it prints any difference (D-175: 0 on 60 page-widths). Also compare full-page screenshots
before and after. Note: IBM Plex Mono uses `font-display: optional`, so screenshots can differ where it arrives late;
the computed-style check is the reliable one.
