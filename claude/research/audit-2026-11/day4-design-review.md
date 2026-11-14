# Day 4: design review of Home and the top service pages, 14 Nov 2026 (F-067)

Scheduled task of the 7-day plan. `.online` only; nothing built or changed. Pages reviewed at 1440 and 390 with `claude/tools/shot.mjs`: Home, the pillar, GEO and core SEO (plus the H1 of all 19 service pages). Day 1 to 3 reports and BRAND.md read first. Mockups are standalone HTML in `claude/design-previews/day4/`, inside the locked system (dark ground, red accent, Oswald, IBM Plex, square corners).

## What the review found

1. **The service name in the H1 is already fixed.** All 19 service pages now carry it (checked live), so the Day 1 finding is closed. [VERIFIED]
2. **Heroes are strong** on desktop and phone: one H1 with the service name, a benefit line with one red phrase, a diagram, one primary button.
3. **No proof between the hero and the explanation** on the service pages (Day 1 and Day 3). Home has testimonials, awards and 46 clients, but the 19 service pages show none. [VERIFIED]
4. **Cost and timeline are not answered on the service page.** The Packages prices exist ($5,000 setup plus $1,500 to $2,500 a month, and the other two levels) but are not on the service pages. [VERIFIED from Home text]
5. **The pillar is not linked in the content of any service page** (Day 1: only 4 pages link to it). [VERIFIED, Day 1]
6. **No "how to choose a provider" block**, which competitors answer (Day 1: 7 headings on technical SEO, 3 on audit, 3 on core SEO).
7. **The first-visit cookie notice covers the hero buttons.** Measured on the live GEO page: at 390 x 844 the buttons sit at 633 to 753 px and the notice is fixed at 622 to 834 px (212 px, about a quarter of the screen). At 1440 x 900 it clips the bottom of the button row. [VERIFIED by measurement; my own finding]

## The five mockups (each needs Jamil's yes or no)

| # | Change | File | Source of the content | Open question |
|---|---|---|---|---|
| 1 | Proof band under the hero on each service page | `mockup-1-proof-band.html` | Existing Home content: 2 testimonials (full wording), 2 awards, 46 clients, links to Clients and Portfolio | Which awards to show; real client logos reuse the Home strip |
| 2 | Cost and timeline at a glance | `mockup-2-cost-and-timeline.html` | Published Packages prices | **Timeline rows are placeholders; Jamil to give the numbers** |
| 3 | "Part of AI Growth Systems" strip, related services and guides | `mockup-3-pillar-block.html` | Home FAQ definition; real service names; our published guides | Per-page choice of the three related services |
| 4 | "How to choose a provider" block | `mockup-4-how-to-choose.html` | Five questions to ask any provider, each matching facts in our published guides (SparkToro run-to-run variation, Google access and indexing) | Whether to name ourselves in the closing line |
| 5 | Compact cookie notice and shorter intro on the phone | `mockup-5-phone-first-screen.html` | Measured positions above | The shorter notice wording needs your OK because it is consent text |

Screenshots (desktop and phone) sit beside each mockup. The GEO page is used as the example; each change would apply to all 19 service pages, one page at a time on approval (F-003).

## Not done

No theme code, no page edit, nothing on reinforcelab.com. Mockup 2 timelines and any change to the cookie wording wait for Jamil. I did not review the industry pages or the company pages.
