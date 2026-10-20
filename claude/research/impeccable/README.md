# Impeccable design audit, 20 Oct 2026 (F-037)

**Pages:** Home, About, AI Search Optimization (page 72). Each scanned at 1440x900 and 390x844.
**Tool:** Impeccable 4.7.0 (Paul Bakaus, Apache 2.0). The `impeccable detect` scanner (61 fixed rules) ran against the live pages, and the skill's `audit` checklist was used to judge the results. Nothing was installed in the repo: the install route (impeccable.style) is blocked by this container's network policy, so the scanner came from npm and the skill text from a git clone, both kept in the session scratchpad.
**Raw results:** the six `*.json` files in this folder.

**Update 20 Oct:** items 2 to 5 fixed (D-199). Item 1 turned out to affect every hero drawing on the site (F-038), waiting for Jamil.

Every finding was checked by hand against the page code before it was sorted. Nothing on the site was changed.

## Real issues (worth fixing)

| # | Issue | Where | Why it matters | Fix (needs Jamil's OK) |
|---|---|---|---|---|
| 1 | Text drawn inside the AI answer illustration is 10 to 11px in the drawing, so it shows at about 7px on a phone | page 72, `services/reinforce-aiso.php` (`.ai-q`, `.ai-ck`, `.ai-pl`, `.ai-tab` and others) | Breaks our own rule: nothing under 12px (D-139). Unreadable on a phone | Larger type inside the drawing, or fewer words in it on phone |
| 2 | Long text lines: 88 to 124 characters per line on desktop | About (founder text, register note, FAQ), page 72 (`.note`, `.honest`, FAQ, `.next`), Home FAQ | Over about 80 characters the eye loses its place. Readers skim and leave | Cap body paragraphs at about 70 characters wide (`max-width: 70ch`) in `core/reinforce-kit.css` |
| 3 | Headings that end with one short word on its own line | Home section headings and blog card titles, mostly on phone | Looks unfinished | `text-wrap: balance` on headings, one line of CSS |
| 4 | Paragraphs that end with a single word on the last line (5 to 14 per page at each width) | All three pages | Small visual gaps | `text-wrap: pretty` on body text, one line of CSS |
| 5 | Source links under charts and claims use wide letter spacing (0.06em) | `.src a` on Home and page 72 | Slightly harder to read | Letter spacing back to normal on those links |

## Flagged, but they are our locked design (D-013), so no change

| Rule | What it flagged | Why we keep it |
|---|---|---|
| kicker-above-heading, hero-eyebrow-chip | The small mono labels above headings, such as `[ AI Growth Systems ]` | IBM Plex Mono eyebrows are part of the locked design system |
| dark-glow | The red glow on the main buttons and the final call-to-action panel | Brand red on dark glass is the locked look |
| codex-grid-background | The faint grid behind the page | It is the design system itself (`reinforce-lab-systems-grid`) |

Impeccable treats these as signs of AI-made design. That is its taste, not a defect. Changing them would mean reopening D-013, which only Jamil can do.

## Flagged, already handled

| Rule | What it flagged | Status |
|---|---|---|
| marquee | The moving client logo rows on Home | It pauses on hover and stops fully for people who turn off motion in their settings |
| numbered-section-labels | Numbered labels on About (20) and page 72 (6) | A style choice; worth a look only if Jamil wants About calmer |

## What passed

No contrast failures, no tiny body text outside the illustration, no overflow, no bad fonts, no nested cards and no purple gradients on any of the three pages, at either width.
