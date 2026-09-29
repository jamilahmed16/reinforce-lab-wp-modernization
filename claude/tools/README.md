# Verification tools

## Style fingerprint (visual-regression check for CSS refactors)
Records the computed style and box of every element inside each page's wrapper at 1440 px and 390 px, then diffs two runs. Used for D-044 (CSS merge).

```bash
node style-fingerprint.mjs before        # writes fp-before.json
# ...deploy the change...
node style-fingerprint.mjs after
python3 style-fingerprint-diff.py fp-before.json fp-after.json   # TOTAL 0 = no visual change
```

- **Deterministic by design.** The dev-site proxy randomly fails 1–3 assets per load, which made naive runs differ by thousands of properties between identical loads. The script therefore caches every static asset on first fetch (with retries, in `rcache/`) and replays it. Only the HTML document and `reinforce-kit.css` are fetched fresh, so two runs differ only by the change under test (verified: 0 diffs between two baseline runs).
- It runs with `reducedMotion: 'reduce'`, so animations don't add noise.
- Add pages to the `pages` map as they adopt the kit.
- Requires Playwright (global install) and `HTTPS_PROXY`.
