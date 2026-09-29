# Competitor research + hero design analysis (29 Sep 2026)

**Trigger:** Jamil — Packages hero is centred while other heroes are left-aligned; Agents hero "chips" need deleting or organising; every hero (except legal, About, Blog, Contact) needs its own meaningful animation; research competitors first so our content beats theirs.
**Status:** ANALYSIS — nothing changed on `.online`. Plan awaits approval.
**Method:** Exa web search, 29 Sep 2026. VERIFIED = read on the competitor page. INFERENCE = my reading. RECOMMENDATION = proposed action.

---

## 1. Competitor findings (VERIFIED)

### A. AI SEO "agents" pages
| Competitor | How they sell agents | Notable |
|---|---|---|
| AEO Engine (aeoengine.ai) | "100+ coordinated optimization agents", strategist-supervised, weekly shipping | "Traditional SEO agency vs" table; FAQ "Do agents replace people? No…"; weekly report contents listed |
| Jasper (jasper.ai/solutions/seo-aeo-geo) | Named agent library: Competitor Audit, Gap Finder, Entity Mapper, AI Readiness Score, Query Planner… | Each agent = one job, one sentence |
| Juniors AI "Search Sensei" | 6 named agents (Keywords, Content, Site Audit, Performance, Competitors, AI Visibility) | Lists the exact data connections (GSC, GA4, Bing WMT, DataForSEO, Firecrawl, PageSpeed) |
| Citedintel | 6 agents in a "measure → fix → verify" loop | Scenario tables: step / where / what you walk away with |
| Meev | One agent, **approval before every action**, **16-point quality gate**, evidence attached to every proposal | Very clear "what it reads / what it proposes / what happens after approval" |
| Indexable AI | 10 agents, **one page per agent** with a spec table (data sources, refresh, outputs, integrations, hand-offs) | Org schema with `founder`, `knowsAbout`, `disambiguatingDescription`; per-agent `SoftwareApplication` schema |

### B. Free diagnostic / AI-visibility audit pages
| Competitor | Promise | Turnaround | Notable |
|---|---|---|---|
| Chyzh (audit.chyzh.agency) | 0–100 score, **47 checks**, 3 priority fixes | 60–90 s scan, email in 2–5 min | "The catch is honest: under 60 we'll pitch a retainer" |
| avaa.agency SEO/GEO Check | 60+ checks, up to 25 pages | instant | Checks GPTBot/ClaudeBot/PerplexityBot/**bingbot**, llms.txt, schema, E-E-A-T |
| SterlingWeb | 200+ checks, 6 modules | 90 s | Free plan + paid tiers |
| GeoIQ | score per AI system (6 engines) | 60 s | 4-week fix plan |
| **DerivateX** | **Run by hand by a senior strategist** | **48 business hours** | States **who it is NOT for**; "no pitch"; explains SEO vs AEO vs GEO audit |
| thibautcampana / ToolsPivot | weighted GEO score, live AI citation test | <60 s | Publishes the scoring weights |

### C. SEO + AI-search packages / pricing
| Competitor | Price range | Terms stated |
|---|---|---|
| WebFX AI SEO | $3,000 → $68,250/mo | **6-month commitment**; prompts × LLMs monitored per tier; assets/month |
| ThinkProfits AEO/GEO | $995 → $4,995/mo + $1,680–$3,800 setup | "No long-term contracts, cancel anytime" |
| DoodleWeb | $1,500 / $3,000 / $6,000/mo | 90-day initial term then month-to-month; no setup fee; priced by site size |
| Geovise | €800/mo+; €400 audit | Audit **credited** to first month; 30-day notice after 3 months |
| aisearchoptimization.agency | $590 → $3,490/mo | "All 6 AI platforms in every tier"; comparison vs DIY tools vs enterprise agency |
| Sprout Sage | $300 audit; $1,500–$4,000/mo | Names monitoring tools, passes tool cost through, month-to-month |
| Mercury (mtsoln) | US$550 → scoped | Contract length per tier; audit credited within 60 days |

### D. Evidence-verified content (our claimed differentiator)
PharmaText AI (claim-by-claim status: verified / partial / contradicted / unverified, passage-anchored citations), CertREV (credentialed expert certification + JSON-LD), CitePep (named clinician review), VayoMed (15+ clinical sources incl. PubMed, FDA, ClinicalTrials.gov), Buzzmatic (health-claim QA). **None of them combine the evidence layer with a full SEO + AI-search operating system** — they are point tools or content shops.

---

## 2. Where we are weaker (INFERENCE)
1. **Specificity.** Competitors publish numbers: checks run, engines covered, prompts monitored, turnaround, contract term, notice period. Our pages mostly don't.
2. **Diagnostic page:** no turnaround time; no mention of AI-crawler access (GPTBot / ClaudeBot / PerplexityBot / bingbot), llms.txt or schema checks, which **every** competitor lists; no sample report; no "who it's not for".
3. **Packages page:** no contract term or notice; no definition of an "asset"; no prompts/engines monitored per tier; no "what happens in month 1". Our pricing is premium (setup $5k–$35k+) — competitors justify premium with specifics; we must too.
4. **Agents:** competitors show each agent's **inputs → outputs → cadence → hand-off**, the quality gate and the approval step. Ours shows outcomes + 3 bullets.
5. **Proof & entity:** competitors show founder credentials, case numbers, and a rich Organization schema (`founder`, `knowsAbout`, `sameAs`, `disambiguatingDescription`). This also answers our name-collision risk (F-018).

## 3. Where we can win (INFERENCE)
1. **Evidence layer + full search OS in one** — unique combination in this research set.
2. **Publish our quality gate.** We already have a real, written standard (D-012 SEO/GEO/AEO standard). Competitors advertise "16-point" / "47-check" gates — ours can be shown as an actual checklist, which is also highly citable.
3. **Honesty as positioning** (no invented metrics, no ranking-date promises) — matches DerivateX/Chyzh tone that reads as trustworthy.
4. **Regulated-industry depth** (PubMed, ClinicalTrials.gov, FDA) inside the SEO system — competitors only offer this as a separate service.

**Honest limit:** no one can guarantee rankings "in everything". What we can do is out-publish competitors on specificity, evidence and structure — the signals Google and AI engines reward — and measure it.

---

## 4. Design analysis (VERIFIED from the live pages + Jamil's screenshots)
- **Alignment:** Home, SAOS, Diagnostic, Agents heroes = left-aligned; **Packages = centred** (inherited from the packages mock-up). Inconsistent.
- **Agents hero chips (A-01…A-08):** duplicate the agent grid directly below; on mobile they stack into an 8-row list that pushes content down. Low value.
- **Home and SAOS use the same visual** (input → core → output engine) — not "separate and meaningful".

### RECOMMENDATION — hero system
- **One hero pattern site-wide:** copy left, visual right (desktop); visual below the CTAs on mobile, simplified. Packages converted to this pattern.
- **Agents chips:** delete. The 8 agents move into the hero **visual itself** (clickable nodes), so navigation is kept without the clutter.
- **Animation rules:** inline SVG + CSS (transform/opacity only), no libraries, no canvas; `prefers-reduced-motion` → static frame; pauses when off-screen; `aria-hidden` with the meaning stated in text (content stays crawlable); fixed aspect-ratio (no layout shift); target < 8 KB per page. Excluded: legal pages, About, Blog, Contact.

### Concepts (each tells that page's story)
| Page | Concept | What moves |
|---|---|---|
| Home | **Growth engine** (upgrade existing) | Inputs stream in; the three outcomes (automate · visibility · revenue) light one by one |
| Search Authority OS | **Authority loop** | 5-node ring Research → Verify → Write → Audit → Monitor; a pulse travels the ring; an "authority" bar steps up each lap |
| Diagnostic | **7-layer scan** | Scan line sweeps 7 layer bars; each settles at a different level; score ring resolves to "?" (your score) |
| Packages | **Compounding staircase** | Foundation → Growth OS → Enterprise blocks rise; a compounding curve draws across them |
| Agents | **Agent constellation** | 8 agent nodes (clickable) grouped in 4 stages; pulses flow Understand → Verify → Optimize & QA → Measure, then loop |
| AI Growth Systems (service) | **Four layers** | Data · AI models · Automation · Dashboard stack assembles; data dots rise to a revenue line |
| Services hub | **Capability grid** | 12 tiles connect into one system |
| Service pages | One motif each — e.g. Technical SEO: crawler path repairs a broken node · International: globe arcs (hreflang) · Local: map-pin ripple · GEO/AI Search: AI answer card cites the brand [1] · LLM Optimization: entity graph forms · Workflow Automation: workflow nodes fire · Marketing Automation: sequence timeline · Lead Gen: funnel particles convert · Content Systems: document assembly line · Audit: magnifier finds issues · Enterprise SEO: dashboard · Executive AI Consulting: roadmap milestones · SEO pillar: result climbs the SERP |
| Industries (8) | Pharma: molecule + citation tags · Healthcare: ECG line · B2B SaaS: pipeline stages · E-commerce: product → cart · Manufacturing: gears + spec sheet · Technology: circuit traces · Professional Services: referral network · Education: learning pathway |
| Agent pages (8) | Each agent's function: keyword field · research web · claim → source chain · AI answer citation · sentiment bubbles · competitor radar · QA checklist ticking · performance line recovering |

---

## 5. Facts needed from Jamil (to beat competitors on specificity — not to be invented)
1. Diagnostic **turnaround** (e.g. 48 business hours?) and whether it's human-run, tool-assisted, or both.
2. **Contract terms**: minimum term, notice period, month-to-month after X?
3. **AI engines monitored** (ChatGPT, Perplexity, Gemini, AI Overviews, AI Mode, Claude, Copilot?) and **prompts tracked** per tier.
4. What counts as an **"asset"** in "20–30 assets / month".
5. Is the diagnostic fee-free always, and is anything **credited** toward a package?
6. Company **sameAs** profiles (LinkedIn company page, Crunchbase, socials) for Organization schema.
7. Any **real results** we may publish (e.g. Accfintax, JA Directives), with permission.
