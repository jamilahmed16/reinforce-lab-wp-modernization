# Hero section audit: all 45 published pages on `.online` (5 Oct 2026)

**Asked by Jamil:** "Audit entire website for the hero sections ... one is aligned with text in size and design and some of the hero's are not" (screenshots: Search Authority OS, not aligned; AI Search Optimization, aligned).
**Method:** Playwright on the live dev site at 1440 px (all 45 pages) and 1900 px (10 pages), measuring the computed H1 size, case, line count, hero padding, grid columns, and the top and bottom edges of the text column and the visual panel. Hero screenshots reviewed. Desktop only; phone layouts were not part of this audit. Finding F-024.

## The standard (36 of 45 pages)

The 18 service pages, 8 industry pages, 8 agent pages, and the Services and Industries hubs use the shared kit hero (`core/reinforce-kit.css`) and match it:

| Element | Standard |
|---|---|
| Hero padding | 80 px top and bottom |
| Grid | text 1.02 fr, visual 0.98 fr, 56 px gap, vertically centred |
| Eyebrow, then H1 | Oswald 700, **uppercase**, 64 px, last line in red, 3 lines |
| Lede | 19 px, max 62ch |
| Buttons | primary + ghost, 53 px tall |
| Visual panel | 615 to 622 px wide, about 505 px tall |
| Alignment | panel top and bottom within 25 px of the text column's top and bottom |

AI Search Optimization (Jamil's "aligned" example) measures: text column 486 px tall, panel 505 px, top edge 10 px apart, bottom edge 9 px apart.

## Pages that break the standard

| # | Page | What is different (measured at 1440 px) | Severity |
|---|---|---|---|
| 1 | **Search Authority OS** (`/search-authority-os/`) | Own hero, not the kit one. H1 runs to **4 lines**; text column 576 px tall but the loop panel only 434 px, so the panel floats **71 px below the text top and 71 px above its bottom**. Panel narrower (558 px vs 622). Padding 52 px, lede 18 px. Two extra lines under the buttons ("Built for ..." and the capability line). | High (Jamil's example) |
| 2 | **Home** (`/`) | Same older hero as Search Authority OS. The only H1 on the site **not in uppercase** (sentence case). 4 lines; text 570 px vs panel 393 px: panel sits **89 px below the text top, 88 px above its bottom**. Panel 558 px wide. Padding 64 px. "Built for" line under the buttons. | High |
| 3 | **Awards** (`/awards/`) | Kit hero, but the "How we list recognition" panel is only **193 px tall** against a 456 px text column: a small box floating in the middle (132 px gap at the top and bottom). | High |
| 4 | **Search Authority Diagnostic** (`/search-authority-diagnostic/`) | H1 58 px (smaller). The form panel (684 px) is **taller** than the text (515 px), so the heading starts 85 px below the form's top. | Medium |
| 5 | **Packages** (`/packages/`) | H1 60 px, padding 72 px, grid 666/603. The chart panel lines up within 20 px, so it looks close to the standard; only the heading size differs. | Low |
| 6 | **Agents hub** (`/services/agents/`) | Kit hero; the agent map panel is 536 px tall against a 456 px text column, so the edges are 41 px apart (top and bottom). | Low |
| 7 | **Contact** (`/contact-us/`) | Tops align (set to top alignment on purpose); the form ends 113 px below the text. Acceptable for a form, but the left column ends with empty space. | Low |
| 8 | **About** (`/about-us/`) | Standard hero; H1 runs to 4 lines because the new headline is longer. The facts panel matches the text height (12 px). | OK |
| 9 | **Blog** (`/blog/`) | Text-only hero, no visual (by design for the post index). | OK |

The other 36 pages are within the standard: H1 64 px uppercase on 3 lines, panel edges within 25 px.

## Recommendation (needs Jamil's go-ahead)

One rule for every hero: **eyebrow, H1 (64 px, uppercase, 3 lines where the words allow), lede, buttons on the left; one visual panel on the right whose top lines up with the eyebrow and whose bottom lines up with the last line of the text column.**

1. **Search Authority OS and Home:** move both onto the kit hero (80 px padding, the 1.02/0.98 grid, 19 px lede), widen the visual panel to the standard width and stretch it to the text column's height, with the loop and the engine diagram centred inside. Shorten or move the "Built for" lines so the text column is not much taller than the panel.
2. **Home H1 case:** the H1 is the locked core message. Uppercase at 64 px makes it 5 lines in the text column. Options: keep sentence case (the one exception on the site), or uppercase at a smaller size for Home only. **Jamil to choose.**
3. **Awards:** make the hero panel the same height as the text, by adding the four-number tally (2 awards, 11th, 8th of 442, 4.6 Google) under the rules inside the same panel.
4. **Diagnostic:** H1 to 64 px and align the text column to the top of the form, so the eyebrow and the form start on the same line.
5. **Packages:** H1 to 64 px and padding to 80 px.
6. **Agents hub:** stretch the text column or trim the map panel so the edges meet.
7. **Contact:** leave as it is (forms are taller than text by nature), or add the office hours or a short "what happens next" list under the contact rows to fill the column.

Every change is on `.online` only and checked again with the same measurement script afterwards.
