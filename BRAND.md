# Reinforce Lab brand guide

One page for anyone making videos, slides, social posts or designs for Reinforce Lab. Every value here comes from the live design system on reinforcelab.online (decisions D-008, D-013, D-072, D-139, D-200, D-203 in `claude/decision-log.md`). If something here and the website disagree, the website code wins: `wp/novamira-sandbox/core/reinforce-header.php` and `core/reinforce-kit.css`.

## Who we are

- **Name:** Reinforce Lab. Always written exactly like that. "Reinforce Lab Limited" only in legal text.
- **Category:** AI Growth Systems.
- **Core message:** Build AI Growth Systems To Automate Operations, Improve Search Visibility, and Increase Revenue.
- **Positioning:** Reinforce Lab builds AI Growth Systems that connect your website, content, and organic search visibility into one growth engine.
- **We are not** an SEO agency, a digital marketing agency, a GEO agency or an AI automation agency.
- **Founder:** Jamil Ahmed.
- **Who we serve (8 industries):** Pharmaceutical & Life Sciences, Healthcare, B2B SaaS, E-commerce, Manufacturing, Technology, Professional Services, Education.
- **One call to action, everywhere:** "Get your free diagnostic".

## Colour

| Role | Colour | Hex |
|---|---|---|
| Background (main) | near-black, warm | `#121011` |
| Background (second band) | | `#171314` |
| Panel / card | | `#1a1516` |
| Brand red (the one accent) | deep red | `#990000` |
| Red, brighter (highlighted words, focus) | | `#c11414` |
| Red, light (small marks on dark) | | `#e85050` |
| Text (main) | warm off-white | `#f3ede6` |
| Text (secondary) | | `#bcb2a9` |
| Text (quiet) | | `#8f857d` |
| Lines and borders | | `#2c2525`, `#3a3130` |

Rules: dark ground always. Red is the **only** accent colour: no blue, green, purple or gradients of other colours. Use red sparingly, for one highlighted word in a headline, a marker, a line, a glow. Never white backgrounds.

## Type

| Use | Font | Style |
|---|---|---|
| Headlines, buttons | **Oswald** | UPPERCASE, bold (600), tight |
| Body text | **IBM Plex Sans** | normal case, regular |
| Small labels ("eyebrows"), numbers, code-like tags | **IBM Plex Mono** | UPPERCASE, wide letter spacing, often in `[ BRACKETS ]` |

All three are free Google Fonts. Headline pattern on the site: one line in white, the key phrase in brand red, for example **BUILD *AI GROWTH SYSTEMS*** with "AI GROWTH SYSTEMS" in red.

## Shapes and look

- **Square corners everywhere.** No rounded corners on buttons, cards, images or frames.
- **Thin lines:** 1px borders, dashed side rails, small square markers (about 9px) where lines meet.
- **Glass:** dark frosted panels (semi-transparent dark with a faint light edge), never light glass.
- **Red tiles:** small squares of red with a fine noise texture, used as accents in a row of cells.
- **Diagrams over photos:** systems drawn as boxes, lines, flows and loops in white and red on dark. No stock photos of people at laptops, handshakes or robots.
- **Icons are drawn** (simple line icons), never emoji.
- **Buttons:** dark, square, thin red border, a small red "+" before the label, a soft red glow.

## Motion (for video)

- Calm and precise: lines draw in, elements fade up in sequence, a red light sweeps once along a line.
- Short, deliberate moves (0.3 to 0.8 s). No bouncing, spinning, zoom blasts or glitch effects.
- Diagrams can run as a loop: ingest, process, output, repeat.

## Logo files

On the site's media library (use the original files, never redraw):
- Full colour: `/wp-content/uploads/2026/09/Official-Reinforce-Logo.png.png`
- White version (for dark backgrounds, the default for video): `/wp-content/uploads/2026/09/Official-Reinforce-Logo-White-Version.png.webp`
- Logo mark / site icon: `/wp-content/uploads/2026/10/reinforce-lab-site-icon.png`

Logo on dark background, white version, with clear space around it. Do not recolour, stretch, add effects or put it on busy backgrounds.

## Voice and words

- Plain, specific, confident. Short sentences. Say what we do and what the client gets.
- Numbers only when they are real and sourced. Never invent results, client names, rankings or traffic.
- **No em dashes or en dashes.** Use a comma, colon, full stop or parentheses. Ranges use "to": "20 to 30", "$1,500 to $2,500".
- **No emojis.**
- **Banned words and phrases:** delve, leverage, seamless, unlock, elevate, robust, cutting-edge, game-changer, landscape, realm, tapestry, empower, harness, supercharge, revolutionise, transformative, synergy, holistic, streamline, foster, embark, pivotal, testament, ever-evolving, "in today's", fast-paced, "important to note", deep dive, "dive into", unleash, paramount, myriad, plethora, bespoke, meticulous, intricate, boast, showcase, underscore, "more than ever", genuinely, truly, world-class, next-level, state-of-the-art, best-in-class, effortless, unparalleled, "look no further", "table stakes", operationalise, quietly, compound / compounding, "not just", "navigate the", "in the world of", "whether you're a".
- Checker: `python3 claude/tools/copy-check.py <file>` must report 0 issues.

## Quick checklist for a video

1. Dark `#121011` background, one red accent, white text.
2. Oswald uppercase headlines, IBM Plex Sans for any sentence, IBM Plex Mono for small labels.
3. Square corners, thin lines, drawn diagrams. No stock photos, no emoji.
4. White logo, unchanged.
5. Script uses the core message or positioning word for word where it appears.
6. Ends on "Get your free diagnostic" and reinforcelab.com.
7. No dashes, no banned words, no invented numbers.
