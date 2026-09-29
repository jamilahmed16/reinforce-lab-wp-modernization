# International SEO — competitor & primary-source research (29 Sep 2026)

**Method:** Exa Agent run `agent_run_e14d64d08f804c7eb7a6d288dbb01d2b` (medium, 12 searches). Labels: VERIFIED = Google docs quoted; UNVERIFIED flagged.

## A. Competitors (page claims)
| Agency | Pricing shown | Angle | Gap |
|---|---|---|---|
| SEOCOM | from €2,500/mo for 2–3 markets | Native transcreation, hreflang correctness | No case-study method |
| Progression Agency | none | B2B, manufacturers, SaaS; mentions AI-search citation | No prices or outcomes |
| ThrillSEO | $2,800/mo for 1 market; $5,500 for 3–5 | Architecture-first, phased rollout | ROI claims without method |
| Pinnacli | none | Market validation plus AI visibility | Inconsistent claims |
| LASEO | none | Engineering-led, hreflang graph verification, revenue by country | No fees or credentials |
| SEOCUTTS | ₹55k–₹1.2L/mo | Explicit packages | Unevidenced "300%" claims |
| ForzaSEO | none | EU B2B and e-commerce | Thin detail |
| SUSO | none | International plus AI-search; white-label | No AI method |

**Opening (INFERENCE):** hardly any page cites Google's own guidance. None separates what Google documents from what is unverified for AI assistants.

## B. VERIFIED (developers.google.com / support.google.com)
1. **URL structures** — ccTLD / subdomain / subdirectory / URL parameters with Google's pros and cons; parameters "Not recommended"; a ccTLD is "a strong signal". — /search/docs/specialty/international/managing-multi-regional-sites
2. **hreflang:**
   - three methods: HTML, HTTP headers, sitemap;
   - "If page X links to page Y, page Y must link back to page X… may be ignored";
   - ISO 639-1 language plus optional ISO 3166-1 Alpha 2 region;
   - x-default "is used when no other language/region matches the user's browser setting".
   — /search/docs/specialty/international/localized-versions
3. **Page language:** "Google uses the visible content of your page to determine its language. We don't use any code-level language information such as lang attributes, or the URL."
4. **Redirects:** "Avoid automatically redirecting users from one language version of a site to a different language version…". "Googlebot crawler usually originates from the USA", without Accept-Language.
5. **Country targeting:** "The International Targeting report has been deprecated… country targeting… is no longer supported." Hreflang is still used. — support.google.com/webmasters/answer/12474899 (removal date not stated on the page).
6. **Spam policy:** scaled content abuse includes "automated transformations like synonymizing, translating, or other obfuscation techniques, where little value is provided to users". — /search/docs/essentials/spam-policies
7. **Same-language regional duplicates:** "pick a preferred version and use the rel="canonical" element and hreflang tags". Localized versions are duplicates only "if the main content of the page remains untranslated".
8. **AI assistants:** **no primary source** on how ChatGPT, Perplexity or Gemini choose regional pages. UNVERIFIED — do not claim.
