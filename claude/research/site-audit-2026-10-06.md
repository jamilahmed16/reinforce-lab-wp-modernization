# Site audit: reinforcelab.online, 6 October 2026 (F-028)

Scope: every published URL on `.online` (51 pages, 3 project pages, 1 post), plus the 404 page, search results, author, date and category archives, feeds, sitemaps and HTTP headers. Read-only; nothing was changed on either site. Production was not touched.

Method:
- Browser crawl (Playwright, Chromium) of all 55 URLs at desktop 1440 px and phone 390 px: computed type sizes, buttons, layout width, horizontal overflow, rounded corners, text under 12 px, tap targets, images, links, forms, console errors.
- Accessibility: axe-core 4 on every page (desktop), plus colour pairs for the contrast failures.
- HTTP: headers, redirects, 404, archives, sitemaps, favicon, every internal link (57 unique targets).
- Visual: one page per template, desktop and phone.
- Note: the sandbox proxy drops some asset requests. A first crawl showed JavaScript errors ("jQuery is not defined", "e.throttle is not a function") and Helvetica headings; a second crawl with cached assets showed none, and the scripts are present in the page HTML. Those were proxy artefacts, not site defects, and are not listed below.

Labels: VERIFIED (measured), INFERENCE, RECOMMENDATION. Priority: P1 fix before launch, P2 should fix, P3 improvement.

---

## What is already at industry standard (VERIFIED)

- No horizontal scroll on any page at 390 or 1440. CLS at most 0.003.
- One font system on 52 of 55 pages: Oswald, IBM Plex Sans, IBM Plex Mono. H1 64 px desktop / 34 px phone on 53 of 55 pages; H2 48 / 28 px on 45 pages; lede 19 / 16 px on 54; eyebrow 12 px on all 55; section padding 96 / 56 px; container 1440 max with 57.6 / 16 px gutters on all 55.
- Buttons: one size (51 to 53 px high, 14 px Oswald) on all 285 buttons.
- 0 broken internal links (57 targets, all 200). 0 images without alt. 0 external links without `noopener`. No lazy-loading above the fold.
- Skip link and phone menu button on every page. Every form field labelled.
- Forms (Contact, Diagnostic): honeypot, time check, 5 per hour per IP, saved in WordPress, email and optional webhook; both past submissions show `email_sent: yes`.
- Titles and metas unique and within length on all 55; schema with no broken references; `llms.txt`; XML sitemaps list exactly the published URLs; `http` to `https` and missing trailing slash both 301; Brotli compression; static files cached 7 days; HTML under 150 KB (largest 149 KB, the post).

---

## Findings

### A. Design consistency

| # | Finding (VERIFIED) | Where | Priority | Fix |
|---|---|---|---|---|
| A1 | **Rounded corners break D-013 (zero radius).** Buttons, the phone menu button and some cards have a 4 px radius from the Beaver Builder theme's own `.btn` style, which the kit never resets. | 55 of 55 pages (every button, the menu button, cards on some pages) | P1 | One kit rule: radius 0 on `.btn`, `.burger`, `.card` |
| A2 | **Body text size varies and is small.** Main paragraph text is 14.5 px on 36 pages, 15 px on 9, 14 px on 4, 16.5 px on legal pages, 17.5 px on the post. The common web standard for body copy is 16 px. | Site-wide | P2 | Pick one body size (RECOMMENDATION: 16 px) and one for cards; needs Jamil's OK as it changes the locked type scale |
| A3 | **Card title (H3) size has 11 variants**, 16 px to 32 px, depending on the page file. | 55 pages | P2 | One H3 size for cards (for example 20 px), one for large feature titles |
| A4 | **Text under 12 px**: mono labels at 10 to 11.5 px (phone hero labels 10 px, eyebrow numbers 11.5 px, footer and breadcrumb links 11.5 px). Median 31 instances per page on phone. | All pages | P2 | Raise the floor to 12 px |
| A5 | **Container width:** `.wrap` max-width is 1440 px. D-013 records "1280 content width". | All pages | P3 | Ask Jamil which is intended; update the record or the kit |
| A6 | **Code text falls back to SFMono / system mono** instead of IBM Plex Mono. | Privacy, International SEO, FTC | P3 | Set `code` to the brand mono |
| A7 | **Blog card shows a large empty grey box** where the featured image would be; the post has no featured image. Same on the category and author archives. | `/blog/`, archives | P1 | Featured image for the post, and a no-image card layout as fallback |
| A8 | **404 page and search results use the old default theme layout**: unstyled search box, "Recent Posts" and "Recent Comments" sidebar ("No comments to show"), no links back into the site. | 404, `?s=` | P1 | Design both in the kit: short message, search, links to Services, Blog, Contact |

### B. Accessibility (axe-core)

| # | Finding (VERIFIED) | Where | Priority | Fix |
|---|---|---|---|---|
| B1 | **Colour contrast below 4.5:1 for small text.** Brand light red `#e23b3b` on the dark backgrounds measures 4.23 to 4.44; faint grey `#877d75` measures 4.48. Also `#c11414` small text 2.9 and decorative step numbers `#a71414` 2.41. | 51 pages, 841 elements | P1 | Lighten the two tokens slightly (for example `--red-3` and `--ink-faint` by a few percent) so they pass 4.5:1; keep `#990000` as the accent |
| B2 | **Link names differ from visible text**: "Explore" links carry an `aria-label` that does not contain the word shown, which confuses voice-control users. | 32 pages, 249 links | P2 | Start each label with the visible text, or use hidden text instead of `aria-label` |
| B3 | **Heading order**: footer column titles are `h4` directly after page `h2`s. | 55 pages | P2 | Make footer titles non-heading text (or `h2`) |
| B4 | **Small tap targets on phone**: footer links about 15 px tall, breadcrumb links, "Explore" links 17 px tall. WCAG 2.2 asks for 24 px or enough spacing. | 55 pages | P2 | More line height and padding on footer, breadcrumb and "Explore" links |
| B5 | Links inside an SVG diagram (nested interactive), an empty table header, a banner landmark inside the article. | 1 to 2 pages each | P3 | Small markup fixes |

### C. Site functions and settings

| # | Finding (VERIFIED) | Priority | Fix |
|---|---|---|---|
| C1 | **No favicon or site icon** (`/favicon.ico` 404, no `<link rel=icon>`, no Apple touch icon, no `theme-color`). Browsers, bookmarks and Google results show a blank icon. | P1 | Site icon from the logo mark (512 px), plus theme colour `#121011` |
| C2 | **No security headers**: no HSTS, no `X-Content-Type-Options`, no `Referrer-Policy`, no `Permissions-Policy`, no frame protection; `X-Powered-By: PHP/8.3.30` is exposed; `readme.html` (WordPress version) is public. | P2 | Headers in `.htaccess` on `.online`, same set planned for `.com` at launch; hide the version |
| C3 | **LiteSpeed Cache is installed in the stack but inactive** on `.online`; HTML is generated on every request. | P2 | Activate and configure (Jamil's approval: plugin setting) |
| C4 | **Form email has no authenticated sender (no SMTP).** `wp_mail` reports success, but mail from the host without SPF/DKIM alignment often lands in spam. | P1 before launch | SMTP sending through the domain's mail provider (needs a plugin or provider details: Jamil) |
| C5 | **Comments and pingbacks are open** on the post (no form is shown, but `wp-comments-post.php` accepts spam). | P2 | Close comments and pingbacks site-wide unless Jamil wants comments |
| C6 | **Thin archives are live and indexable once launched**: author archive, date archives, "Uncategorized" category, comments feed; author and category sitemaps are listed. A one-author site gains nothing from them. | P2 | Yoast: turn off author and date archives, rename or retire "Uncategorized". These URL patterns exist on production, so this goes through the URL register first (Rule 2) |
| C7 | **No cookie consent, no GA4.** Jetpack Stats loads on all 55 pages (third-party tracking) with no consent banner; GA4 is not installed. Already on the launch list. | P1 before launch | Consent banner with GPC, then GA4 behind consent |
| C8 | **Uppercase URLs return 200** (`/About-Us/`), creating duplicates until canonicals are on (they are off while `.online` is noindex). | Launch | Canonical check is on the launch list |
| C9 | **`www.reinforcelab.online` does not resolve.** Fine for dev; `.com` must redirect `www` to the bare domain (or the reverse) at launch. | Launch | Launch checklist |

### D. Performance

| # | Finding (VERIFIED) | Priority | Fix |
|---|---|---|---|
| D1 | **Logo is a 1024 px image shown at 170 px**, with no width and height attributes, on every page. | P2 | 340 px version (2x) with width and height |
| D2 | **About 63 KB of JavaScript on every page** (jQuery, jQuery Migrate, Bootstrap 4, Magnific Popup, FitVids, theme script). Most pages are built from our own shortcodes and do not use Bootstrap, Magnific or FitVids. INFERENCE: most of it is unused there. | P3 | Remove unused scripts on shortcode pages, test the phone menu after |
| D3 | Client logos are PNG (57 PNG images across the pages crawled). | P3 | WebP versions |

### E. Content and brand consistency

| # | Finding (VERIFIED) | Priority | Fix |
|---|---|---|---|
| E1 | **Nine different labels for the same action** (go to the diagnostic): "Get your diagnostic" (header), "Get My Search Authority Diagnostic", "Get your free diagnostic", "Request my Search Authority Diagnostic", "Request my diagnostic", "Start with a diagnostic", "Start with the free diagnostic", "Start here", and on Home "Book a strategy call". Footer: "Get a Free Quote". | P2 | Jamil picks one primary label (and one for Contact); applied everywhere |
| E2 | **Footer uses the legal and regional names** "Reinforce Lab Ltd", "Reinforce Lab Inc", "Created By Reinforce Lab Ltd." The brand rule is "Reinforce Lab" everywhere, the legal name only in schema. The Bangladesh phone number appears twice. "Created by" the company itself is redundant. | P2 | Jamil to confirm: show "Reinforce Lab" with the office city, keep legal names only where legally needed |
| E3 | **US office (Katy, Texas, "Reinforce Lab Inc")** is in the footer and on Contact, but the Organization schema has only the Dhaka address. | P2 | Jamil to confirm the US entity and address; then add it to the schema, or remove it from the footer |
| E4 | **Few links into key pages** (in-content links): AI Growth Systems pillar 4, the post 3, About 4, Clients 3. | P2 | Link the pillar and the post from relevant service and industry pages |
| E5 | 54 of 55 pages share the default share image. | P3 | Page images for the main service pages, as done for AI Search Optimization |

---

## Fix plan

**I can fix on `.online` now (code and settings only, no URL or content decisions):** A1, A6, A7 (no-image card layout), A8, B1 (token values to be shown first), B2, B3, B4, B5, C1, C2 (headers on `.online` only), C5, D1, D3.

**Needs Jamil's decision first:** A2 and A3 (type scale), A4 (12 px floor), A5 (1280 or 1440), A7 (featured image design), C3 (LiteSpeed Cache), C4 (SMTP provider), C6 (archives; URL register), E1 (CTA label), E2 and E3 (footer names, US office).

**Launch list (already tracked or added):** C7, C8, C9, security headers on `.com`.
