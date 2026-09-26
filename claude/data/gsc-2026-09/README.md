# GSC primary data — pulled 10 September 2026

Search Console exports for **reinforcelab.com** (production). First non-SEMrush, global traffic evidence in the project. Closes O-005 and O-010. Findings written up as **F-007→F-011** in [../../decision-log.md](../../decision-log.md).

| Folder | Report | Notes |
|---|---|---|
| `performance/` | Performance on Search | 16 months, Web, **global**. Chart.csv = daily; Pages.csv = 425 pages; Queries.csv = 999 (GSC cap). |
| `coverage-all/` | Page Indexing (all known pages) | 93 indexed / 346 not. Chart retains only from 2026-06-11. |
| `coverage-post-sitemap/` | Page Indexing (post-sitemap.xml) | 52 indexed / 60 not. |
| `drilldown-crawled-full/` | Crawled – currently not indexed | **Complete** 139-row list. ~113 junk (63 `/paged-N/`, author archives, feeds, wc-ajax, sitemaps) + ~20–25 real rejections. |
| `drilldown-crawled-sample/` | Crawled – not indexed | 19-row sample (superseded by crawled-full). |
| `drilldown-discovered/` | Discovered – currently not indexed | 39-row **sample** of 74. Every row `Last crawled: 1970-01-01` = never fetched. |
| `links/` | Links report | `external-referring-sites-sitewide.csv` (~60 domains), `external-anchor-text.csv` (branded/navigational, ~zero topical — F-012), `external-referring-sites.csv` (homepage's 50), `external-top-target-pages.csv` (homepage = 261/50 ≈ 93% of external equity — F-010), `internal-top-target-pages.csv` (nav/footer dominance — F-011). |
| `ga4/` | GA4 (production property), 90 days | 7 screenshots + full-page PDF — F-013. $0 revenue / 0 transactions / 0 leads; 31 key events (68% Organic Search); China+Singapore bot-like; Bangladesh = real engaged audience; 404 page = #3 most-viewed. NOT clean CSVs. |
| `raw/` | Originals | Untouched GSC downloads (zips + loose Links CSVs), incl. 11 unlabelled internal-link drilldowns. |

All exports are **reinforcelab.com (production)** data.

**Still open (DISCOVER):** O-014 (WPCode / Code Snippets inventory). **Confirm:** O-015 (production shows two homepage titles incl. "AI Growth Systems" — which page, and traced to which approval? — F-013).
