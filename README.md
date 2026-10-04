# Reinforce Lab: website modernization

The rebuild of the Reinforce Lab website. Everything is built and tested on the development site
**[reinforcelab.online](https://reinforcelab.online)** (noindex), then moves to the live site
**reinforcelab.com** only through an approved migration.

> **Working branch:** `claude/great-wright-cg4kqo`. Until it is merged, the newest work is on that branch, not on `main`.

## The three rules

1. **Never touch reinforcelab.com.** It is live, holds the SEO equity and runs the store.
2. **Every live URL is `PENDING, NO CHANGE AUTHORIZED`** until Jamil approves that specific URL.
3. **All work happens on reinforcelab.online.**

Full working rules: [`CLAUDE.md`](CLAUDE.md).

---

## Start here

| I want to... | Go to |
|---|---|
| See what was decided, and why | [Decision log](claude/decision-log.md) (index of every D, F and O entry, plus open items) |
| Find which file builds a page on the site | [Site map](claude/site-map.md) (every page: ID, URL, file, SEO title) |
| Find a theme file | [Theme code](wp/README.md) |
| Change something on the site safely | [Tools and the change routine](claude/tools/README.md) |
| See the rules every page must pass | [SEO, GEO and AEO build standard](claude/seo-geo-aeo-standard.md) |
| See approved designs | [Design previews](claude/design-previews/README.md) |
| Read the research behind a service page | [Research briefs](claude/research/README.md) |
| Find data (Search Console, GA4, site snapshot) | [Data](claude/data/README.md) |
| See every planning document | [Project documents](claude/README.md) |

---

## Site at a glance

| Section | Pages | Code folder |
|---|---|---|
| Home, About, Contact | 3 | [`pages/`](wp/novamira-sandbox/pages/) |
| Services hub and service pages | 19 | [`services/`](wp/novamira-sandbox/services/) |
| Industries hub and 8 industries | 9 | [`industries/`](wp/novamira-sandbox/industries/) |
| Search Authority OS, Diagnostic, Packages, Agents | 12 | [`saos/`](wp/novamira-sandbox/saos/) |
| Blog archive and single posts | 1 plus posts | [`blog/`](wp/novamira-sandbox/blog/) |
| Header, footer, shared styles | every page | [`core/`](wp/novamira-sandbox/core/) |

Page by page, with links: **[claude/site-map.md](claude/site-map.md)**.

---

## Repository map

```
README.md                    you are here
CLAUDE.md                    working rules, locked decisions, current state
wp/
  README.md                  theme code guide
  novamira-sandbox/          theme code, file for file as it is on reinforcelab.online
    reinforce-loader.php     the only file WordPress loads; it loads the rest in order
    core/                    header, footer, shared style kit
    pages/                   Home, About, Contact
    services/                services hub and every service page
    industries/              industries hub and the 8 industry pages
    saos/                    Search Authority OS, Diagnostic, Packages, Agents
    blog/                    blog archive, single post, post types, Guide template
claude/
  README.md                  index of every project document
  decision-log.md            decisions (D), findings (F), open items (O)
  decisions/                 earlier months of the decision log
  site-map.md                generated: page, URL and file
  seo-geo-aeo-standard.md    binding build standard
  migration-and-data-requirements.md
  phase-1-*.md, *-findings.md, crawl-waste-fix-plan.md   DISCOVER phase analysis
  redirect-map-2026-09.csv, preserve-disposition-*, URL Decision Register (xlsx)
  design-previews/           approved and in-review mockups
  research/                  research briefs per service and industries
  reference/                 source material from Jamil
  drafts/                    copy drafts awaiting approval
  data/                      Search Console, GA4, production config, site snapshot
  tools/                     deploy, parity, snapshot, crawl, screenshots, copy check, site map
scripts/
  daily-git-sync.ps1         Jamil's local daily sync (Windows)
```

---

## Current status (4 October 2026)

- **Built on `.online`:** Home, About, Contact, Services hub and all service pages, Industries hub and 8 industries, Search Authority OS, Diagnostic, Packages, Agents, Blog archive, the single-post base with 11 post types, and the Guide, How-To, Best / List and Review templates.
- **In review:** Comparison blog template mockup (D-090).
- **Next:** the remaining blog templates, one type at a time (D-077). Then the founder bio and the merge into `main` (D-084).
- **Migration to reinforcelab.com:** not scheduled. Blocked on the data listed in [migration-and-data-requirements.md](claude/migration-and-data-requirements.md).
- **Live site and GitHub match:** checked with `rl.py parity` (0 differences).

## Copy rules for every word on the site

No em or en dashes (ranges use "to"), no emojis, no AI filler words. Check with
`python3 claude/tools/copy-check.py <files>`; it must report 0 issues. Details: D-072 and D-073 in the decision log.

## Keeping this map current

- After any page, menu or SEO change: `python3 claude/tools/rl.py snapshot`, then `python3 claude/tools/site-map.py`.
- New theme file: add it to the folder table in [`wp/README.md`](wp/README.md) and to the loader list.
- New document: add a row to [`claude/README.md`](claude/README.md).
