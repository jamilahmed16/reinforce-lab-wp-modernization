# Reinforce Lab: SEO-Safe WordPress Modernization

Working repository for the evidence-first rebuild of [reinforcelab.com](https://reinforcelab.com): moving a live WordPress site to a new build without losing search equity.

Maintained by [Jamil Ahmed](https://jamilahmed.com), founder of [Reinforce Lab Limited](https://reinforcelab.com). This is reference material from active work, not a packaged product. For the generalized, reusable version of the method, see the [SEO, GEO and AEO Playbook](https://github.com/jamilahmed16/seo-geo-aeo-playbook).

## Approach

The project follows three rules:

1. Production is never changed directly.
2. Every existing URL needs explicit approval before any change (slug, redirect, canonical, consolidation, removal).
3. All building and testing happens on a separate development site, then moves to production only through an approved migration.

Methodology: Discover, Preserve, Architect, Content, AI Search, Build, QA, Launch, Monitor.

## What is inside

| Path | Contents |
|---|---|
| `CLAUDE.md` | Operating rules, locked decisions, current state and working instructions for the AI-assisted workflow |
| `claude/` | Strategy and diagnosis documents: SEO, GEO and AEO build standard, crawl waste analysis, indexation diagnosis, URL disposition rules, content history, migration requirements and the decision log |
| `claude/data/` | Search Console, analytics and link exports used as evidence, plus redirect and URL maps |
| `claude/design-previews/` | Static design previews for key pages |
| `claude/reference/` | Positioning and Search Authority OS strategy references |
| `wp/novamira-sandbox/` | Sandbox PHP for the development site header and home page |
| `scripts/` | Maintenance scripts |

## Stack

WordPress, Yoast SEO Premium, Beaver Builder Pro, Beaver Themer, ACF PRO.

## Status

Active. The decision log records every decision and finding in order.

## Contact

Questions about this work or about SEO, GEO and AI search for your own brand: [reinforcelab.com](https://reinforcelab.com) or [jamilahmed.com](https://jamilahmed.com).

## Copyright

Copyright (c) 2026 Reinforce Lab Limited. All rights reserved. See [LICENSE](LICENSE).
