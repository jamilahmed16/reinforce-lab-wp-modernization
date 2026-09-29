# LLM Optimization — competitor & primary-source research (29 Sep 2026)

**Method:** Exa Agent run `agent_run_4142235cd7904b8d964846322dcf2433` (medium effort, 12 searches) at Jamil's instruction to use Exa for deep research. VERIFIED = quoted from the primary source; INFERENCE = page-level reading; UNVERIFIED = flagged.

## A. Competitor pages (page claims, not verified performance)
| Competitor | URL | Angle | Gap |
|---|---|---|---|
| Proven ROI | provenroi.com/services/llm-optimization | Entity hub, schema, citation-ready content, llms.txt, six-platform monitoring; own monitoring tool | Self-reported results |
| UPLIFY | uplify.agency/en/generative-engine-optimization/ | Entity/author signals, proof blocks, dated AI-answer checks; refuses to guarantee mentions | Few outcome numbers |
| Zebora | zebora.io | "AI Brand Index": visibility, sentiment, accuracy | Thin implementation detail |
| Lureon | lureon.ai | Done-for-you research, content, reporting | Qualitative metrics only |
| XLR8 AI | tryxlr8.ai | Software plus managed execution (SEO/GEO/LinkedIn/Reddit) | Testimonial-only results |
| indexLLM.me | indexllm.me | B2B SaaS; daily Reddit/Quora activity | No quality controls or measurement definitions |
| PrometixAI | prometixai.com | Three-way framing: AI SEO vs GEO vs LLM SEO | Thin process |

**Takeaways (INFERENCE):** everyone offers the same four workstreams: entity clarity, schema, citation-ready content and repeated AI checks. The openings we can take:
- a transparent prompt panel;
- fact-accuracy monitoring with the source of each error traced;
- **explicit separation of training crawlers, search crawlers and user-triggered fetches**;
- no guarantees.

## B. Primary-source facts (VERIFIED)
1. **llms.txt:** proposed by Jeremy Howard, "Published September 3, 2024". Described as "A proposal to standardise on using an /llms.txt file to provide information to help agents use a website." It is a proposal; adoption by any specific model is unverified. — https://llmstxt.org/
2. **OpenAI** — https://developers.openai.com/api/docs/bots
   - **GPTBot:** "used to crawl content that may be used in training OpenAI's generative AI foundation models."
   - **OAI-SearchBot:** "used to surface websites in search results in ChatGPT's search features… Sites that are opted out of OAI-SearchBot will not be shown in ChatGPT search answers."
   - **ChatGPT-User:** visits pages when users ask; "not used for crawling the web in an automatic fashion."
3. **Anthropic** — https://support.claude.com/en/articles/8896518
   - **ClaudeBot:** collects content "that could potentially contribute to their training."
   - **Claude-User:** retrieves content in response to a user query.
   - **Claude-SearchBot:** "navigates the web to improve search result quality."
4. **Perplexity** — https://docs.perplexity.ai/docs/resources/perplexity-crawlers
   - **PerplexityBot:** "designed to surface and link websites in search results on Perplexity. It is not used to crawl content for AI foundation models."
   - **Perplexity-User:** user-triggered fetches; not for training.
5. **Google-Extended:** manages use for training future Gemini models and for grounding in Gemini Apps / Vertex AI. "Google-Extended does not impact a site's inclusion in Google Search nor is it used as a ranking signal." AI Overviews / AI Mode links require the page to be indexed and snippet-eligible, with "no additional technical requirements". — https://developers.google.com/crawling/docs/crawlers-fetchers/google-common-crawlers ; https://developers.google.com/search/docs/appearance/ai-features
6. **Training cutoff plus retrieval:**
   - OpenAI: "trained on data up to a certain point… unless tools are used"; Search "look[s] up current or niche information from the web and provide[s] cited answers" (help.openai.com/en/articles/8313428).
   - Anthropic publishes knowledge and training cutoffs (docs.anthropic.com models overview).
   - Google: Grounding with Google Search cites "verifiable sources beyond its knowledge cutoff" (ai.google.dev).
7. **Knowledge Graph:** Google's Knowledge Graph describes real-world entities (developers.google.com/knowledge-graph). Structured data gives "explicit clues about the meaning of a page" (Search Central).
   - **UNVERIFIED:** that Wikidata is required by, or directly consumed by, LLMs, or that it raises recommendations. Do not claim it.
