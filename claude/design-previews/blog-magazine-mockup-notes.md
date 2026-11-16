# Blog magazine layout (mockup, 16 Nov 2026) - NOT BUILT

Files: `blog-magazine-mockup.html` (desktop 1440 and phone 390 screenshots alongside). Uses real post titles, dates and covers from .online. Design system unchanged (dark ground, brand red, Oswald, IBM Plex, square corners).

## What changes on /blog/ (page 1 only)
1. Hero and category chips stay (chips gain "AI Growth Systems" and "Reviews").
2. Section 01 AI Growth Systems: one large feature (latest) plus four stacked items. First on the page.
3. Section 02 Reviews: four cards, link to the Reviews hub.
4. Section 03 SEO and search, 04 Web hosting, 05 Marketing and content: three or four cards each, each with an "All ... articles" link to its category archive.
5. Section 06 All articles: the existing paginated list (12 a page, /blog/page/N/).

## F-001 and the other blog rules
- The paginated list stays ONE loop bound to the main query with core pagination. The sections above it are read-only, fixed-count queries (no pagination, no_found_rows) shown on page 1 only. Page 2 onward and every category archive keep today's single list. No Beaver Themer layout is involved.
- Archive retirements (author, date, Uncategorized) and noindex on page 2+ are untouched.
- Section order puts AI Growth Systems first whatever the post dates are.

## What it needs (a data change, no content change)
- Two new categories: "AI Growth Systems" and "Reviews". The 25 AI cluster posts (including the pillar, post 330, now Uncategorized) get AI Growth Systems as their main category. The tool reviews (Surfer, SEMrush, Jasper, Copy.AI, ClickUp, Beaver Builder, Rank Tracker, Writesonic) and each hosting review get Reviews.
- New category archive URLs appear: /category/ai-growth-systems/ and /category/reviews/ (new URLs, no production equivalent).
- Hosting posts keep Web Hosting. Hosting comparisons and coupon pages stay in Web Hosting; hosting reviews go to Reviews.
