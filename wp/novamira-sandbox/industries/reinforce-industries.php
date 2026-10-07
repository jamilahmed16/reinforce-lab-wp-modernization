<?php
/**
 * Plugin Name: Reinforce Lab - Industries hub + 8 industry pages
 * Description: /industries/ and /industries/{pharmaceutical, healthcare, b2b-saas, ecommerce, manufacturing, technology, professional-services, education}/ (D-022 plain slugs; keyword capture in title/H1/content). One file, shared data. Provides [reinforce_industries] (hub) and [reinforce_industry] (pages). Uses the shared kit (D-044). Hero animations "Eight industries, one system" (hub) and "Industry system" (pages) (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* ---------- single source: the 8 industries (D-022 plain slugs; keyword capture in title/H1/content) ----------
   Keys: name, short, sum (hub card), h1 (3 lines), lede, real (3 realities), guard (3 guardrails), chal (3 challenges),
   facts (2 × [label, text, source, url]), svc (6 × [path, name, line]), agents (2 slugs), honest [h2, p], faqs (4), yoast. */
function rl_ind_data() {
    $G = 'https://developers.google.com/search/docs/';
    return [
        'pharmaceutical' => [
            'name' => 'Pharmaceutical & Life Sciences', 'short' => 'PHARMA & LIFE SCIENCES',
            'sum' => 'Evidence-led search and AI visibility for brands where every claim is reviewed.',
            'h1' => ['Search and AI', 'growth for', 'life sciences.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for pharmaceutical and life sciences companies</strong>: search, content and AI visibility designed around medical-legal review, evidence and the rules that govern how medicines can be promoted, so HCPs, patients and partners find accurate, trusted information from you.',
            'real' => ['REGULATED CLAIMS', 'HCPS + PATIENTS', 'LONG APPROVALS'], 'guard' => ['MEDICAL-LEGAL REVIEW', 'EVIDENCE LOG', 'AD POLICY CHECK'],
            'chal' => [['Every claim is regulated', 'Content must be accurate, balanced and approved before it goes anywhere near search.'], ['Two very different audiences', 'Healthcare professionals and patients search differently and need different pages.'], ['Slow approvals, fast search', 'Review cycles take weeks; search demand and AI answers change daily.']],
            'facts' => [['Paid search is tightly restricted', 'Google allows pharmaceutical manufacturers to promote prescription drugs only in Canada, New Zealand and the United States, and only once certified by Google.', 'Google Ads Help, Healthcare and medicines', 'https://support.google.com/adspolicy/answer/176031'], ['Trust carries the most weight', 'Google says that of experience, expertise, authoritativeness and trustworthiness, trust is most important, and its systems give even more weight to strong E-E-A-T on topics that can affect people’s health.', 'Google Search Central, Creating helpful content', $G . 'fundamentals/creating-helpful-content']],
            'svc' => [['services/seo-content-systems', 'SEO Content Systems', 'Disease-area and product content with medical-legal review built into the workflow.'], ['services/ai-search-optimization', 'AI Search Optimization', 'Accurate product and disease-area facts in AI answers.'], ['services/international-seo', 'International SEO', 'Market-by-market sites without duplicate or conflicting pages.'], ['services/enterprise-seo-strategy', 'Enterprise SEO Strategy', 'Brand, product and HCP sites governed by one standard.'], ['services/technical-seo-services', 'Technical SEO', 'Complex, multi-site estates crawled and indexed correctly.'], ['services/executive-ai-consulting', 'Executive AI Consulting', 'Where AI can help, and where regulation says it can’t.']],
            'agents' => ['evidence-verification', 'content-qa'],
            'honest' => ['Search can’t move faster than your approvals.', 'In a regulated industry the review process is part of the product, not an obstacle to it. We plan content around your medical-legal cycle, prepare evidence logs that make review faster, and never publish around it.'],
            'faqs' => [['What does Reinforce Lab do for pharmaceutical and life sciences companies?', 'We build search, content and AI visibility systems that fit regulated promotion: evidence-led content with medical-legal review built in, separate journeys for healthcare professionals and patients, accurate facts for AI answers, and technical SEO for complex multi-market estates.'], ['Can pharmaceutical companies advertise prescription drugs on Google?', 'Only in a few countries. Google allows pharmaceutical manufacturers to promote prescription drugs in Canada, New Zealand and the United States, and only after certification. Organic search and content therefore matter more for most markets.'], ['How do you handle medical-legal review?', 'Review is built into the workflow: every claim is logged with its source, content is prepared in the format your reviewers use, and nothing is published without approval.'], ['Which services do life sciences companies usually start with?', 'Usually an SEO & AI Search Audit or the free diagnostic, followed by SEO Content Systems with evidence verification, and AI Search Optimization for product and disease-area facts.']],
            'yoast' => ['Pharma & Life Sciences SEO and AI Search | Reinforce Lab', 'Search, content and AI visibility for pharma and life sciences companies, built around medical-legal review, evidence and the rules on promoting medicines.'],
        ],
        'healthcare' => [
            'name' => 'Healthcare', 'short' => 'HEALTHCARE',
            'sum' => 'Trusted, local and accessible visibility for clinics, practices and providers.',
            'h1' => ['Be the trusted', 'answer for', 'patients.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for healthcare providers</strong>: clinics, practices and health services that need patients to find accurate, trustworthy information (in Google, in local results and in AI answers) and to book with confidence.',
            'real' => ['HEALTH TOPICS', 'LOCAL SEARCH', 'PATIENT TRUST'], 'guard' => ['CLINICIAN REVIEW', 'PATIENT PRIVACY', 'ACCESSIBILITY'],
            'chal' => [['Health is held to a higher standard', 'Google weighs trust more heavily on topics that can affect people’s health.'], ['Patients search locally', 'Most searches are for a service near them: profiles, reviews and location pages decide who is seen.'], ['Privacy and accessibility', 'Enquiry forms, tracking and design must respect patients’ privacy and be usable by everyone.']],
            'facts' => [['Trust is the priority', 'Google says trust is the most important part of E-E-A-T, and that its systems give even more weight to it on topics that could significantly affect people’s health.', 'Google Search Central, Creating helpful content', $G . 'fundamentals/creating-helpful-content'], ['Profiles must reflect reality', 'Google requires a Business Profile name to reflect the real-world name used on signage and stationery. Adding extra keywords can get a profile suspended.', 'Google Business Profile Help', 'https://support.google.com/business/answer/3038177']],
            'svc' => [['services/local-seo', 'Local SEO', 'Clinic and practice profiles, reviews and location pages done within the rules.'], ['services/seo-content-systems', 'SEO Content Systems', 'Condition and treatment content reviewed by clinicians.'], ['services/ai-search-optimization', 'AI Search Optimization', 'Accurate service and location facts in AI answers.'], ['services/wordpress-website-design-service', 'WordPress Website Design', 'Accessible, fast sites patients can use easily.'], ['services/marketing-automation', 'Marketing Automation', 'Enquiry and referral follow-up that respects consent.'], ['services/website-maintenance-services', 'Website Maintenance', 'Booking forms and sites kept secure and working.']],
            'agents' => ['evidence-verification', 'search-performance'],
            'honest' => ['Clinical accuracy comes before rankings.', 'Health content that ranks but misleads does real harm. Every clinical statement we publish is sourced and reviewed by your clinicians, and we will not use tactics that trade patient trust for traffic.'],
            'faqs' => [['What does Reinforce Lab do for healthcare providers?', 'We help clinics, practices and health services be found and trusted: local SEO for every location, clinician-reviewed content, accurate facts for AI answers, accessible websites and enquiry follow-up that respects patient privacy.'], ['Why is healthcare SEO different?', 'Google holds health content to a higher standard of trust, and most patients search locally. Accurate, reviewed content and well-managed local profiles matter more than in most industries.'], ['Do clinicians review the content?', 'Yes. Clinical statements are sourced and reviewed by your clinicians before publication, with author and review details shown on the page.'], ['Which services do healthcare providers usually start with?', 'Usually Local SEO and a review of existing content, followed by SEO Content Systems for conditions and treatments and AI Search Optimization for accurate facts in AI answers.']],
            'yoast' => ['Healthcare SEO and AI Search | Reinforce Lab', 'Healthcare SEO and AI search for clinics and providers: local visibility, clinician-reviewed content, accurate AI answers and privacy-aware websites.'],
        ],
        'b2b-saas' => [
            'name' => 'B2B SaaS', 'short' => 'B2B SAAS',
            'sum' => 'Pipeline from search and AI answers for software companies with long buying cycles.',
            'h1' => ['Pipeline from', 'search and', 'AI answers.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for B2B SaaS companies</strong>: search, content and AI visibility aimed at buying committees that research on their own, and marketing systems that turn that research into demos, trials and pipeline.',
            'real' => ['BUYING GROUPS', 'SELF-SERVE RESEARCH', 'LONG CYCLES'], 'guard' => ['PIPELINE TRACKING', 'CRM SYNC', 'CONSENT'],
            'chal' => [['Buyers research alone', 'Most of the evaluation happens before anyone talks to sales.'], ['Many people decide', 'Users, budget holders and technical evaluators all need different answers.'], ['Traffic isn’t pipeline', 'Blog traffic rarely maps to demos unless content targets buying-stage searches.']],
            'facts' => [['Buyers prefer self-service', '61% of B2B buyers prefer an overall rep-free buying experience, and 73% actively avoid suppliers who send irrelevant outreach.', 'Gartner, B2B buyer survey (June 2025)', 'https://www.gartner.com/en/newsroom/press-releases/2025-06-25-gartner-sales-survey-finds-61-percent-of-b2b-buyers-prefer-a-rep-free-buying-experience'], ['Consistency matters', '69% of B2B buyers report inconsistencies between what a supplier’s website says and what its sellers tell them.', 'Gartner, B2B buyer survey (June 2025)', 'https://www.gartner.com/en/newsroom/press-releases/2025-06-25-gartner-sales-survey-finds-61-percent-of-b2b-buyers-prefer-a-rep-free-buying-experience']],
            'svc' => [['services/best-search-engine-optimization-services', 'Search Engine Optimization', 'Solution, integration and comparison pages for buying-stage searches.'], ['services/ai-search-optimization', 'AI Search Optimization', 'Be recommended when buyers ask AI tools for software.'], ['services/seo-content-systems', 'SEO Content Systems', 'Content for every role in the buying group.'], ['services/lead-generation-systems', 'Lead Generation Systems', 'Demo and trial funnels measured to pipeline.'], ['services/marketing-automation', 'Marketing Automation', 'Trial nurture, lead scoring and sales handoff.'], ['services/llm-optimization', 'LLM Optimization', 'One consistent description of your product across AI models.']],
            'agents' => ['seo-intelligence', 'competitor-intelligence'],
            'honest' => ['Traffic is not the goal. Pipeline is.', 'A SaaS blog can grow for years without producing a single demo. We start from the searches and prompts buyers use when they are close to choosing (comparisons, alternatives, integrations) and measure what reaches your CRM.'],
            'faqs' => [['What does Reinforce Lab do for B2B SaaS companies?', 'We build search, content and AI visibility aimed at software buyers who research on their own, and connect it to lead generation and marketing automation so research turns into demos, trials and pipeline.'], ['How do B2B software buyers research?', 'Largely on their own: Gartner found 61% of B2B buyers prefer a rep-free buying experience. That makes your website, search visibility and presence in AI answers the main sales channel early in the journey.'], ['How do you measure SaaS SEO?', 'By pipeline: demos, trials and opportunities from organic search and AI referrals, tracked into your CRM, not traffic alone.'], ['Which services do SaaS companies usually start with?', 'Usually the SEO & AI Search Audit or free diagnostic, then buying-stage content and AI Search Optimization, with lead generation and marketing automation connecting it to pipeline.']],
            'yoast' => ['B2B SaaS SEO and AI Growth | Reinforce Lab', 'B2B SaaS SEO, AI search and demand systems for software companies: buying-stage content, AI recommendations and funnels measured to pipeline.'],
        ],
        'ecommerce' => [
            'name' => 'E-commerce', 'short' => 'E-COMMERCE',
            'sum' => 'Search, product data and checkout systems for online retailers and B2B stores.',
            'h1' => ['More shoppers', 'from search', 'and AI.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for e-commerce businesses</strong>: category and product pages that rank, product data Google and AI tools can use, and a checkout and follow-up system that turns more of those visits into orders.',
            'real' => ['LARGE CATALOGUES', 'PRICE COMPARISON', 'CART ABANDONMENT'], 'guard' => ['PRODUCT DATA', 'CHECKOUT QA', 'ACCESSIBILITY'],
            'chal' => [['Catalogues create crawl problems', 'Filters and sorting can generate endless URLs that waste Google’s attention.'], ['Shoppers compare everything', 'Price, delivery, stock and reviews decide the click, often right in the results.'], ['Most carts are abandoned', 'Surprise costs and long checkouts lose sales you already paid to attract.']],
            'facts' => [['Most carts are abandoned', 'Baymard Institute puts the average documented cart abandonment rate at 70.22%, with extra costs the top avoidable reason (40%).', 'Baymard Institute (updated September 2025)', 'https://baymard.com/lists/cart-abandonment-rate'], ['Product data shows in results', 'Google can show price, availability, shipping and returns in search results when product pages carry merchant listings structured data or feed Merchant Center.', 'Google Search Central, Product structured data', $G . 'appearance/structured-data/product']],
            'svc' => [['services/ecommerce-website-design-service', 'E-commerce Website Design', 'Stores built to be found and bought from.'], ['services/technical-seo-services', 'Technical SEO', 'Faceted navigation and large catalogues kept crawlable.'], ['services/seo-content-systems', 'SEO Content Systems', 'Category copy and buying guides that help shoppers choose.'], ['services/marketing-automation', 'Marketing Automation', 'Welcome, abandoned-basket and post-purchase journeys.'], ['services/lead-generation-systems', 'Lead Generation Systems', 'Shopping and search campaigns bid on revenue.'], ['services/ai-search-optimization', 'AI Search Optimization', 'Products recommended accurately in AI shopping answers.']],
            'agents' => ['competitor-intelligence', 'search-performance'],
            'honest' => ['More traffic won’t fix a leaky checkout.', 'If most carts are abandoned, the fastest revenue is usually in the checkout, not in more visitors. We look at the whole path (search, product page, cart, follow-up) and fix the biggest leak first.'],
            'faqs' => [['What does Reinforce Lab do for e-commerce businesses?', 'We improve the whole path from search to order: category and product pages that rank, product data for Google and AI tools, crawl control for large catalogues, a shorter checkout and automated follow-up.'], ['Why do shoppers abandon their carts?', 'Baymard Institute’s research puts the average abandonment rate at 70.22%. Leaving aside browsing, extra costs such as shipping and fees are the top reason, followed by slow delivery and not trusting the site.'], ['How do products appear with prices in Google?', 'Through product structured data (merchant listings markup on pages where customers can buy) and product feeds in Google Merchant Center. We set up and maintain both.'], ['Which services do online stores usually start with?', 'Usually the free diagnostic or an SEO & AI Search Audit, then technical SEO for the catalogue, product data, and checkout and marketing automation fixes.']],
            'yoast' => ['E-commerce SEO and AI Search | Reinforce Lab', 'E-commerce SEO and AI search for online stores: ranking category and product pages, product data for Google and AI, crawl control and a checkout that converts.'],
        ],
        'manufacturing' => [
            'name' => 'Manufacturing', 'short' => 'MANUFACTURING',
            'sum' => 'Visibility with engineers, specifiers and distributors across every market.',
            'h1' => ['Get specified', 'by engineers', 'who search.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for manufacturers</strong>: product, application and specification content that engineers and buyers find in search and AI tools, multi-market sites that work in every language, and quote-request systems that never let an enquiry go cold.',
            'real' => ['TECHNICAL BUYERS', 'MANY MARKETS', 'BIG CATALOGUES'], 'guard' => ['SPEC ACCURACY', 'MARKET VERSIONS', 'ERP DATA'],
            'chal' => [['Buyers are engineers', 'They search for applications, specifications and standards, not marketing slogans.'], ['Many markets, many languages', 'Country and language versions compete with each other unless they are set up correctly.'], ['Enquiries go cold', 'Quote requests sit in inboxes while buyers contact the next supplier.']],
            'facts' => [['Language versions need signals', 'Google recommends telling it about localised versions of a page with hreflang, and if page X links to page Y, page Y must link back to page X, or the annotations may be ignored.', 'Google Search Central, Localized versions of your pages', $G . 'specialty/international/localized-versions'], ['Product data helps', 'Product structured data lets Google understand and present product information such as specifications, availability and price where it applies.', 'Google Search Central, Product structured data', $G . 'appearance/structured-data/product']],
            'svc' => [['services/international-seo', 'International SEO', 'Country and language versions for every market you sell in.'], ['services/seo-content-systems', 'SEO Content Systems', 'Application and specification content captured from your engineers.'], ['services/technical-seo-services', 'Technical SEO', 'Large product catalogues kept crawlable and fast.'], ['services/lead-generation-systems', 'Lead Generation Systems', 'Quote-request funnels routed by product and region.'], ['services/marketing-automation', 'Marketing Automation', 'Long-cycle nurture and distributor communications.'], ['services/ai-workflow-automation', 'AI Workflow Automation', 'Quotes, orders and specs extracted from documents automatically.']],
            'agents' => ['content-research', 'competitor-intelligence'],
            'honest' => ['Your engineers know more than your website says.', 'Most manufacturers’ best expertise never reaches their site. We capture it (applications, tolerances, standards, trade-offs) in the words engineers search with, because that is what gets a product specified.'],
            'faqs' => [['What does Reinforce Lab do for manufacturers?', 'We make your products findable by the engineers, specifiers and buyers who search for them: application and specification content, multi-market sites, technical SEO for large catalogues, and quote-request systems connected to sales.'], ['How should manufacturers handle sites in several languages?', 'Each language or country version needs to be marked up so Google shows the right one. Google recommends hreflang, with every version linking back to the others. We set this up and check it.'], ['Where does AI fit for manufacturers?', 'Engineers increasingly ask AI tools for suppliers and specifications. Clear, accurate technical content makes your products easier to cite, and AI workflow automation can take the admin out of quotes and orders.'], ['Which services do manufacturers usually start with?', 'Usually an SEO & AI Search Audit, then content built from your engineers’ expertise, international SEO for multi-market sites, and lead generation for quote requests.']],
            'yoast' => ['Manufacturing SEO and B2B Lead Generation | Reinforce Lab', 'SEO and lead generation for manufacturers: application and specification content engineers search for, multi-market sites and quote-request systems.'],
        ],
        'technology' => [
            'name' => 'Technology', 'short' => 'TECHNOLOGY',
            'sum' => 'Search and AI visibility for complex products, technical buyers and JavaScript-heavy sites.',
            'h1' => ['Be the answer', 'technical buyers', 'trust.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for technology companies</strong>: sites Google and AI crawlers can actually render, documentation and technical content buyers trust, and a clear, consistent description of your product wherever people research it.',
            'real' => ['COMPLEX PRODUCTS', 'JS-HEAVY SITES', 'CROWDED CATEGORY'], 'guard' => ['RENDER CHECK', 'TECH REVIEW', 'DOCS STANDARDS'],
            'chal' => [['JavaScript hides content', 'Content that only appears after scripts run can be missed by search and AI crawlers.'], ['Complex products, simple searches', 'Buyers search in plain language; product pages speak in features.'], ['Crowded categories', 'Every vendor claims the same thing, including “AI”.']],
            'facts' => [['Rendering is a separate step', 'Google processes JavaScript pages in three phases (crawling, rendering and indexing) and says server-side or pre-rendering is still a great idea because not all bots can run JavaScript.', 'Google Search Central, JavaScript SEO basics', $G . 'crawling-indexing/javascript/javascript-seo-basics'], ['Buyers see through the hype', 'Gartner estimates that only about 130 of the thousands of vendors claiming agentic AI are real, warning of “agent washing”.', 'Gartner (June 2025)', 'https://www.gartner.com/en/newsroom/press-releases/2025-06-25-gartner-predicts-over-40-percent-of-agentic-ai-projects-will-be-canceled-by-end-of-2027']],
            'svc' => [['services/technical-seo-services', 'Technical SEO', 'JavaScript rendering, crawling and indexing checked and fixed.'], ['services/seo-content-systems', 'SEO Content Systems', 'Documentation, guides and explainers that rank.'], ['services/llm-optimization', 'LLM Optimization', 'One accurate description of your product across AI models.'], ['services/ai-search-optimization', 'AI Search Optimization', 'Presence when buyers ask AI tools for solutions.'], ['services/press-release-services', 'Digital PR & Link Building', 'Research and benchmarks that earn coverage and links.'], ['services/lead-generation-systems', 'Lead Generation Systems', 'Account-focused campaigns measured to pipeline.']],
            'agents' => ['aeo-geo-optimization', 'competitor-intelligence'],
            'honest' => ['Clever sites often hide their best content.', 'Modern front-ends can look impressive and still show search and AI crawlers an empty page. We check what crawlers actually see first, because no amount of content helps if it never gets rendered.'],
            'faqs' => [['What does Reinforce Lab do for technology companies?', 'We make sure search and AI crawlers can see your content, turn complex products into content technical buyers search for and trust, and keep your product described consistently across Google and AI tools.'], ['Does JavaScript hurt SEO?', 'It can. Google renders JavaScript in a separate phase after crawling, and not all bots can run it. Server-side rendering or pre-rendering makes content reliably visible; Google itself recommends it.'], ['How do you stand out in a crowded category?', 'With specifics: original research, clear comparisons and documentation that proves what the product does. Vague claims (especially about AI) are what buyers have learned to ignore.'], ['Which services do technology companies usually start with?', 'Usually a technical SEO check of rendering and indexing, then content and LLM optimization so the product is described accurately in search and AI answers.']],
            'yoast' => ['Technology Company SEO and AI Search | Reinforce Lab', 'SEO and AI search for technology companies: JavaScript rendering fixed, technical content buyers trust and a consistent product description across AI tools.'],
        ],
        'professional-services' => [
            'name' => 'Professional Services', 'short' => 'PROFESSIONAL SERVICES',
            'sum' => 'Visibility for firms that win clients on expertise: legal, finance, consulting and more.',
            'h1' => ['Win clients', 'who search', 'for expertise.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for professional services firms</strong> (legal, accounting, finance, consulting and advisory) so the people looking for expertise find your practice areas, your experts and your offices in Google, in local results and in AI answers.',
            'real' => ['TRUST-LED BUYING', 'LOCAL + NATIONAL', 'EXPERT-DRIVEN'], 'guard' => ['CONFIDENTIALITY', 'PARTNER SIGN-OFF', 'PROFILE RULES'],
            'chal' => [['Clients buy trust', 'Advice on money, law and risk is judged on credibility before price.'], ['Expertise stays in people’s heads', 'Partners know more than the website shows, and rarely have time to write.'], ['Local and national at once', 'Each office competes locally while the firm competes nationally.']],
            'facts' => [['Trust is weighed more heavily', 'Google gives even more weight to strong E-E-A-T on topics that could significantly affect people’s financial stability or safety, the territory of legal and financial advice.', 'Google Search Central, Creating helpful content', $G . 'fundamentals/creating-helpful-content'], ['Profiles follow strict rules', 'Google requires Business Profile names to match the real-world name, and allows only one profile per business. Keyword-stuffed or duplicate listings risk suspension.', 'Google Business Profile Help', 'https://support.google.com/business/answer/3038177']],
            'svc' => [['services/best-search-engine-optimization-services', 'Search Engine Optimization', 'Practice-area pages that win high-value searches.'], ['services/local-seo', 'Local SEO', 'Every office found in local results, within Google’s rules.'], ['services/seo-content-systems', 'SEO Content Systems', 'Partner expertise turned into regular, bylined content.'], ['services/press-release-services', 'Digital PR & Link Building', 'Experts placed in business and trade media.'], ['services/ai-search-optimization', 'AI Search Optimization', 'Your firm recommended accurately in AI answers.'], ['services/marketing-automation', 'Marketing Automation', 'Client alerts, events and referral nurture.']],
            'agents' => ['evidence-verification', 'social-sentiment'],
            'honest' => ['Your reputation is the product.', 'A firm’s name is worth more than any ranking. We never publish advice that hasn’t been checked by the people accountable for it, and we keep client confidentiality ahead of any content idea.'],
            'faqs' => [['What does Reinforce Lab do for professional services firms?', 'We help legal, accounting, finance, consulting and advisory firms get found for their practice areas and experts: SEO for practice-area pages, local SEO for offices, expert-led content, digital PR and accurate descriptions in AI answers.'], ['Why is trust so important in professional services search?', 'Google gives more weight to trust on topics that can affect people’s finances or safety. Clear authorship, real expertise and accurate, reviewed content matter more than volume.'], ['How do you get content from busy partners?', 'Short interviews. We turn a partner’s thinking into drafts in their voice, and they approve the result, so expertise gets published without taking over their week.'], ['Which services do firms usually start with?', 'Usually the free diagnostic, then practice-area SEO and local SEO for offices, with SEO Content Systems and digital PR building authority over time.']],
            'yoast' => ['Professional Services SEO and Marketing | Reinforce Lab', 'SEO, local SEO and AI search for law, accounting, finance and consulting firms: practice-area visibility, expert-led content and accurate AI answers.'],
        ],
        'education' => [
            'name' => 'Education', 'short' => 'EDUCATION',
            'sum' => 'Student recruitment through search, AI answers and admissions journeys.',
            'h1' => ['Reach students', 'where they', 'search.'],
            'lede' => 'Reinforce Lab builds <strong>AI Growth Systems for education providers</strong> (universities, colleges, schools and training providers) so prospective students and their families find the right course, get accurate answers in Google and AI tools, and move smoothly from enquiry to application.',
            'real' => ['LONG DECISIONS', 'SEASONAL PEAKS', 'MANY AUDIENCES'], 'guard' => ['ACCESSIBILITY', 'COURSE ACCURACY', 'CONSENT'],
            'chal' => [['Decisions take months', 'Students compare options over a long period, across many sources.'], ['Peaks are predictable', 'Searches surge around open days, deadlines and results, and sites must be ready.'], ['Many audiences', 'Students, parents, international applicants and employers all need different answers.']],
            'facts' => [['Course rich results are gone', 'In June 2025 Google announced it would phase out several structured data features in Search, including Course Info, so course pages now need to win on clear content, not special result formats.', 'Google Search Central Blog (June 2025)', 'https://developers.google.com/search/blog/2025/06/simplifying-search-results'], ['Helpful beats generic', 'Google’s systems prioritise helpful, reliable content created for people, and ask whether content provides original information and a complete description of the topic.', 'Google Search Central, Creating helpful content', $G . 'fundamentals/creating-helpful-content']],
            'svc' => [['services/seo-content-systems', 'SEO Content Systems', 'Course and programme pages matched to how students search.'], ['services/ai-search-optimization', 'AI Search Optimization', 'Accurate course facts in AI answers.'], ['services/marketing-automation', 'Marketing Automation', 'Enquiry-to-application journeys by course and stage.'], ['services/wordpress-website-design-service', 'WordPress Website Design', 'Accessible sites many editors can manage safely.'], ['services/international-seo', 'International SEO', 'Recruitment sites for international applicants.'], ['services/lead-generation-systems', 'Lead Generation Systems', 'Open-day and enquiry campaigns tracked to applications.']],
            'agents' => ['social-sentiment', 'search-performance'],
            'honest' => ['Rich results won’t rescue a weak course page.', 'With Google retiring course-specific result formats, course pages now compete on substance: clear entry requirements, outcomes, costs and dates, written for students. That is where we start.'],
            'faqs' => [['What does Reinforce Lab do for education providers?', 'We help universities, colleges, schools and training providers recruit through search: course pages students find and trust, accurate course facts in AI answers, accessible websites and enquiry-to-application journeys.'], ['Does Google still show course rich results?', 'No. In June 2025 Google announced it was phasing out several structured data features, including Course Info, and removed them from Search Console reporting in September 2025. Course pages now need to stand out through their content.'], ['How do you handle recruitment peaks?', 'By planning content, campaigns and site capacity around your calendar (open days, deadlines and results) and checking speed and uptime before the peaks, not during them.'], ['Which services do education providers usually start with?', 'Usually the free diagnostic, then SEO Content Systems for course pages, AI Search Optimization for accurate answers and marketing automation for enquiry follow-up.']],
            'yoast' => ['Education SEO and Student Recruitment | Reinforce Lab', 'SEO and AI search for universities, colleges and training providers: course pages students trust, accurate AI answers and enquiry-to-application journeys.'],
        ],
    ];
}

function rl_is_indhub() { return is_page('industries') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }
function rl_ind_current() {
    static $cur = null;
    if ($cur !== null) return $cur;
    $cur = '';
    if (!is_page()) return $cur;
    $p = get_queried_object();
    if (!$p || empty($p->post_parent)) return $cur;
    $parent = get_post($p->post_parent);
    if ($parent && $parent->post_name === 'industries' && (int) $parent->post_parent === 0 && isset(rl_ind_data()[$p->post_name])) $cur = $p->post_name;
    return $cur;
}
function rl_is_ind() { return rl_ind_current() !== ''; }
function rl_ind_svc_name($path) { $m = ['services/best-search-engine-optimization-services' => 'SEO']; return $m[$path] ?? ''; }

/* ---------- hero animation (industry pages): Industry system ----------
   The industry's three realities feed an AI Growth System whose four layers fill in turn - search,
   content, AI search, automation; the industry's three guardrails are checked; a growth line draws;
   context · system · guardrails · growth light in turn. 10 s loop, soft fade, reset. */
function rl_ind_svg($a) {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlInT"><title id="rlInT">An AI Growth System for ' . esc_html($a['name']) . ': search, content, AI search and automation layers built around the industry’s realities and guardrails.</title>';
    $s .= '<text class="n-lab" x="0" y="20">CONTEXT</text><text class="n-lab" x="360" y="20">GUARDRAILS</text>';
    foreach ($a['real'] as $i => $t) {
        $y = 36 + $i * 60; $cy = $y + 17;
        $s .= '<path class="n-e" d="M128 ' . $cy . ' C144 ' . $cy . ' 142 115 160 115"/><path class="n-p n-pr' . $i . '" pathLength="100" d="M128 ' . $cy . ' C144 ' . $cy . ' 142 115 160 115"/>'
            . '<rect class="n-b" x="0" y="' . $y . '" width="128" height="34"/><rect class="n-on n-r' . $i . '" x="0" y="' . $y . '" width="128" height="34"/><text class="n-t" x="64" y="' . ($y + 20.5) . '" text-anchor="middle">' . esc_html($t) . '</text>';
    }
    $s .= '<rect class="n-b" x="160" y="30" width="180" height="170"/><rect class="n-on n-core" x="160" y="30" width="180" height="170"/><text class="n-id" x="172" y="50">' . esc_html($a['short']) . '</text><text class="n-h" x="172" y="68">AI GROWTH SYSTEM</text><line class="n-rule" x1="172" y1="78" x2="328" y2="78"/>';
    foreach (['SEARCH', 'CONTENT', 'AI SEARCH', 'AUTOMATION'] as $i => $t) {
        $y = 98 + $i * 26;
        $s .= '<text class="n-ct" x="172" y="' . $y . '">' . $t . '</text><rect class="n-bar" x="252" y="' . ($y - 7) . '" width="76" height="7"/><rect class="n-baron n-l' . $i . '" x="252" y="' . ($y - 7) . '" width="76" height="7"/>';
    }
    foreach ($a['guard'] as $i => $t) {
        $y = 36 + $i * 60;
        $s .= '<path class="n-e" d="M340 115 C352 115 348 ' . ($y + 17) . ' 360 ' . ($y + 17) . '"/>'
            . '<rect class="n-b" x="360" y="' . $y . '" width="160" height="34"/><rect class="n-on n-g' . $i . '" x="360" y="' . $y . '" width="160" height="34"/>'
            . '<rect class="n-sq" x="372" y="' . ($y + 12) . '" width="10" height="10"/><rect class="n-sqon n-g' . $i . '" x="372" y="' . ($y + 12) . '" width="10" height="10"/><text class="n-gt" x="390" y="' . ($y + 20.5) . '">' . esc_html($t) . '</text>';
    }
    $s .= '<text class="n-lab" x="0" y="238">GROWTH</text><line class="n-rule" x1="0" y1="316" x2="520" y2="316"/>';
    $s .= '<path class="n-gr" pathLength="100" d="M0 306 L60 300 L120 302 L180 288 L240 284 L300 268 L360 262 L420 246 L480 236 L520 226"/>';
    $s .= '<line class="n-rule2" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['CONTEXT', 'SYSTEM', 'GUARDRAILS', 'GROWTH'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="n-ft" x="' . $x . '" y="372">' . $f . '</text><text class="n-ft n-fton n-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="n-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="n-fbon n-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_ind_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 3; $i++) { $s = 2 + $i * 3; $k .= $lit("rlinR$i", $s, $s + 2) . $pul("rlinPr$i", $s + 1, $s + 8) . ".rl-ind .n-r$i{animation-name:rlinR$i}.rl-ind .n-pr$i{animation-name:rlinPr$i}\n"; }
    $k .= $lit('rlinCore', 12, 15) . ".rl-ind .n-core{animation-name:rlinCore}\n";
    for ($i = 0; $i < 4; $i++) { $s = 14 + $i * 5; $k .= "@keyframes rlinL$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 5) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-ind .n-l$i{animation-name:rlinL$i}\n"; }
    for ($i = 0; $i < 3; $i++) { $s = 36 + $i * 4; $k .= $lit("rlinG$i", $s, $s + 2) . ".rl-ind .n-g$i{animation-name:rlinG$i}\n"; }
    $k .= "@keyframes rlinGr{0%,48%{stroke-dashoffset:100;opacity:1}62%,92%{stroke-dashoffset:0;opacity:1}97%,100%{stroke-dashoffset:0;opacity:0}}\n";
    foreach ([2, 14, 36, 48] as $i => $s) $k .= $lit("rlinF$i", $s, $s + 3) . "@keyframes rlinFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-ind .n-f$i{animation-name:rlinF$i}.rl-ind .n-fb$i{animation-name:rlinFb$i}\n";
    return $k;
}

/* ---------- hero animation (hub): Eight industries, one system ----------
   Each industry lights in turn and sends a pulse into the central AI Growth Systems core, which lights
   once all eight are connected. 10 s loop, soft fade, reset. */
function rl_indhub_svg() {
    $s = '<svg viewBox="0 0 520 360" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlIhT"><title id="rlIhT">Eight industries: pharmaceutical and life sciences, healthcare, B2B SaaS, e-commerce, manufacturing, technology, professional services and education, connected to one AI Growth System.</title>';
    $n = ['PHARMA & LIFE SCI', 'HEALTHCARE', 'B2B SAAS', 'E-COMMERCE', 'MANUFACTURING', 'TECHNOLOGY', 'PROFESSIONAL SVCS', 'EDUCATION'];
    foreach ($n as $i => $t) {
        $left = $i < 4; $r = $i % 4; $y = 20 + $r * 76; $x = $left ? 0 : 370; $cy = $y + 17;
        $d = $left ? 'M150 ' . $cy . ' C175 ' . $cy . ' 170 150 195 150' : 'M370 ' . $cy . ' C345 ' . $cy . ' 350 150 325 150';
        $s .= '<path class="h-e" d="' . $d . '"/><path class="h-p h-p' . $i . '" pathLength="100" d="' . $d . '"/>'
            . '<rect class="h-b" x="' . $x . '" y="' . $y . '" width="150" height="34"/><rect class="h-on h-n' . $i . '" x="' . $x . '" y="' . $y . '" width="150" height="34"/><text class="h-t" x="' . ($x + 75) . '" y="' . ($y + 20.5) . '" text-anchor="middle">' . $t . '</text>';
    }
    $s .= '<rect class="h-b" x="195" y="118" width="130" height="64"/><rect class="h-on h-core" x="195" y="118" width="130" height="64"/><text class="h-h" x="260" y="146" text-anchor="middle">AI GROWTH</text><text class="h-h" x="260" y="164" text-anchor="middle">SYSTEMS</text>';
    $s .= '<text class="h-cap" x="260" y="350" text-anchor="middle">ONE SYSTEM · EIGHT INDUSTRIES · INDUSTRY RULES BUILT IN</text><text class="h-cap h-capon" x="260" y="350" text-anchor="middle">ONE SYSTEM · EIGHT INDUSTRIES · INDUSTRY RULES BUILT IN</text>';
    return $s . '</svg>';
}
function rl_indhub_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    $order = [0, 4, 1, 5, 2, 6, 3, 7];
    foreach ($order as $j => $i) { $s = 3 + $j * 6; $k .= $lit("rlihN$i", $s, $s + 2) . $pul("rlihP$i", $s + 1, $s + 7) . ".rl-indhub .h-n$i{animation-name:rlihN$i}.rl-indhub .h-p$i{animation-name:rlihP$i}\n"; }
    $k .= $lit('rlihCore', 52, 56) . $lit('rlihCap', 60, 64) . ".rl-indhub .h-core{animation-name:rlihCore}.rl-indhub .h-capon{animation-name:rlihCap}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_indhub()) $c[] = 'rl-indhub-page'; if (rl_is_ind()) $c[] = 'rl-ind-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_indhub() || rl_is_ind(); });
add_action('wp_head', 'rl_ind_css', 22);
function rl_ind_css() {
    if (!rl_is_indhub() && !rl_is_ind()) return; ?>
<style id="rl-ind-css">
body.rl-indhub-page .fl-page-content,body.rl-indhub-page .fl-content,body.rl-indhub-page .fl-post-content,body.rl-ind-page .fl-page-content,body.rl-ind-page .fl-content,body.rl-ind-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-ind .inf,.rl-indhub .inf{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-ind .inf .cap,.rl-indhub .inf .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-ind .inf .cap span,.rl-indhub .inf .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-ind .inf svg,.rl-indhub .inf svg{display:block;width:100%;height:auto;overflow:visible}
.rl-ind .n-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ind .n-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-ind .n-t{font-family:var(--f-mono);font-size:8px;letter-spacing:.08em;fill:var(--ink-dim)}
.rl-ind .n-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-ind .n-id{font-family:var(--f-mono);font-size:7.5px;letter-spacing:.14em;fill:var(--red-3)}
.rl-ind .n-h{font-family:var(--f-display);font-weight:600;font-size:12px;letter-spacing:.06em;fill:var(--ink)}
.rl-ind .n-rule{stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-ind .n-ct{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-ind .n-bar{fill:rgba(255,255,255,.06)}
.rl-ind .n-baron{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-ind .n-sq{fill:none;stroke:rgba(243,237,230,.25);stroke-width:.8}
.rl-ind .n-sqon{fill:var(--red-2);opacity:0}
.rl-ind .n-gt{font-family:var(--f-mono);font-size:8px;letter-spacing:.08em;fill:var(--ink-dim)}
.rl-ind .n-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-ind .n-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-ind .n-gr{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-linejoin:round;stroke-dasharray:100;stroke-dashoffset:100;animation-name:rlinGr}
.rl-ind .n-rule2{stroke:var(--line-2);stroke-width:1}
.rl-ind .n-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ind .n-fton{fill:var(--ink);opacity:0}
.rl-ind .n-fb{fill:rgba(255,255,255,.08)}
.rl-ind .n-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-ind .n-on,.rl-ind .n-p,.rl-ind .n-baron,.rl-ind .n-sqon,.rl-ind .n-gr,.rl-ind .n-fton,.rl-ind .n-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-ind .n-p{animation-timing-function:ease-in-out}
.rl-indhub .h-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-indhub .h-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-indhub .h-t{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:var(--ink-dim)}
.rl-indhub .h-h{font-family:var(--f-display);font-weight:600;font-size:13px;letter-spacing:.08em;fill:var(--ink)}
.rl-indhub .h-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-indhub .h-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-indhub .h-cap{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-indhub .h-capon{fill:var(--ink);opacity:0}
.rl-indhub .h-on,.rl-indhub .h-p,.rl-indhub .h-capon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-indhub .h-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-ind .n-t,.rl-ind .n-gt{font-size:9px;letter-spacing:0}.rl-ind .n-ct{font-size:9.5px;letter-spacing:.04em}.rl-ind .n-lab,.rl-ind .n-id{font-size:9px;letter-spacing:.06em}.rl-ind .n-ft{font-size:11px;letter-spacing:.02em}.rl-indhub .h-t{font-size:9.5px;letter-spacing:0}.rl-indhub .h-cap{display:none}.rl-ind .inf .cap span+span,.rl-indhub .inf .cap span+span{display:none}.rl-ind .inf,.rl-indhub .inf{padding:16px 10px 10px}}
<?php echo rl_is_indhub() ? rl_indhub_kf() : rl_ind_kf(); ?>
.rl-ind .fact .src,.rl-indhub .fact .src{margin-top:auto}
.rl-ind .fact,.rl-indhub .fact{display:flex;flex-direction:column;gap:10px}
.rl-ind .fact p,.rl-indhub .fact p{color:var(--ink-dim);font-size:16px}
.rl-indhub .ind .sum{color:var(--ink-dim);font-size:16px;margin:0}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || (!rl_is_indhub() && !rl_is_ind())) return $graph;
    $url = get_permalink(get_queried_object_id());
    if (rl_is_indhub()) {
        $items = [];
        $i = 0;
        foreach (rl_ind_data() as $slug => $d) { $items[] = ['@type' => 'ListItem', 'position' => ++$i, 'name' => $d['name'], 'url' => function_exists('rl_url_by_path') ? rl_url_by_path('industries/' . $slug, $url) : $url]; }
        $graph[] = ['@type' => 'ItemList', '@id' => $url . '#industries', 'name' => 'Industries served by Reinforce Lab', 'numberOfItems' => count($items), 'itemListElement' => $items];
        $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_indhub_faqs())];
        return $graph;
    }
    $d = rl_ind_data()[rl_ind_current()];
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'AI Growth Systems for ' . $d['name'], 'serviceType' => 'SEO, AI search, content and marketing automation',
        'url' => $url, 'mainEntityOfPage' => ['@id' => $url], 'description' => wp_strip_all_tags($d['lede']),
        'audience' => ['@type' => 'BusinessAudience', 'name' => $d['name']], 'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, $d['faqs'])];
    return $graph;
}, 20);

function rl_indhub_faqs() {
    return [
        ['Which industries does Reinforce Lab work with?', 'Eight: pharmaceutical and life sciences, healthcare, B2B SaaS, e-commerce, manufacturing, technology, professional services and education. Each has its own page explaining how the AI Growth System is adapted to its buyers, rules and trust signals.'],
        ['Do you work with businesses outside these eight industries?', 'Yes. The services apply to any business that wins customers through search. These eight are where we focus our industry knowledge, examples and guardrails.'],
        ['Where do finance and legal firms fit?', 'Under Professional Services, alongside accounting, consulting and advisory firms, industries where trust, expertise and confidentiality decide who wins the client.'],
        ['Why does industry matter for SEO and AI search?', 'Because trust, buyers and rules differ. Google gives more weight to trust on topics that affect health, finances or safety; B2B buyers research largely on their own; and regulated industries face limits on what they can say and advertise.'],
    ];
}

/* ---------- markup: hub ---------- */
add_shortcode('reinforce_industries', 'rl_render_industries');
function rl_render_industries() {
    if (!rl_is_indhub()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $diag = $u('search-authority-diagnostic');
    $G = 'https://developers.google.com/search/docs/fundamentals/creating-helpful-content';
    ob_start(); ?>
<div class="rl-page rl-indhub">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Industries</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Industries&nbsp;<b>]</b></span>
      <h1 class="h1">AI growth systems<br>built for your<br><span class="r">industry.</span></h1>
      <p class="lede">Reinforce Lab builds <strong>AI Growth Systems for eight industries</strong>: pharmaceutical and life sciences, healthcare, B2B SaaS, e-commerce, manufacturing, technology, professional services and education. The system is the same (search, content, AI search and automation), but the buyers, rules and trust signals it is built around are not.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#list">See the industries</a>
      </div>
    </div>
    <figure class="inf rl-anim">
      <div class="cap" aria-hidden="true"><span>Industries</span><span>Eight industries · one system</span></div>
      <?php echo rl_indhub_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Eight industries', 'kind' => 'chips', 'items' => ['Pharma & life sci', 'Healthcare', 'B2B SaaS', 'E-commerce', 'Manufacturing', 'Technology', 'Professional svcs', 'Education']], ['label' => '', 'kind' => 'core', 'title' => 'AI Growth Systems', 'sub' => 'Industry rules built in']], 'One system · eight industries'); ?></figure>
  </div>
</section>

<section class="band alt" id="list">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The industries&nbsp;<b>]</b></span><h2>Which industries do we work with?</h2><p class="lede">Eight sectors where search decides who gets considered, and where getting the details wrong is expensive.</p></div>
    <ul class="inds8">
      <?php $i = 0; foreach (rl_ind_data() as $slug => $d) { $l = $ex('industries/' . $slug); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', ++$i); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d['name']) . '</a>' : esc_html($d['name']); ?></h3><p class="sum"><?php echo esc_html($d['sum']); ?></p><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('AI Growth Systems for ' . $d['name']) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="why">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Why industry matters&nbsp;<b>]</b></span><h2>Why does industry matter in search and AI?</h2><p class="lede">Three things change from one industry to the next, and each one changes how the system should be built.</p></div>
    <div class="cols c3">
      <div class="cell fact"><span class="n">01 · Trust</span><h3>Trust is weighed differently</h3><p>Google gives even more weight to strong E-E-A-T on topics that could affect people’s health, financial stability or safety.</p><p class="src">Source: <a href="<?php echo esc_url($G); ?>" rel="noopener" target="_blank">Google, Creating helpful content</a></p></div>
      <div class="cell fact"><span class="n">02 · Buyers</span><h3>Buyers search differently</h3><p>61% of B2B buyers prefer a rep-free buying experience, while patients, shoppers and students each research in their own way.</p><p class="src">Source: <a href="<?php echo esc_url('https://www.gartner.com/en/newsroom/press-releases/2025-06-25-gartner-sales-survey-finds-61-percent-of-b2b-buyers-prefer-a-rep-free-buying-experience'); ?>" rel="noopener" target="_blank">Gartner (June 2025)</a></p></div>
      <div class="cell fact"><span class="n">03 · Rules</span><h3>Rules differ</h3><p>Some industries can’t advertise freely at all: Google allows prescription-drug ads from manufacturers in only three countries, and only after certification.</p><p class="src">Source: <a href="<?php echo esc_url('https://support.google.com/adspolicy/answer/176031'); ?>" rel="noopener" target="_blank">Google Ads, Healthcare and medicines</a></p></div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How we adapt&nbsp;<b>]</b></span><h2>How is the system adapted to each industry?</h2><p class="lede">One system, tuned in four ways.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Context</h3><p>Who buys, how they search, and what they need to trust you.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Guardrails</h3><p>Review steps, compliance rules and privacy built into the workflow.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>System</h3><p>Search, content, AI search and automation configured for the sector.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Measure</h3><p>Success defined the way your industry buys: pipeline, bookings, orders or applications.</p></li>
    </ol>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About our industries.</h2></div>
    <?php foreach (rl_indhub_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See how your industry shows up in search and AI.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence against your industry, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services'); ?>">All services</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}

/* ---------- markup: industry page ---------- */
add_shortcode('reinforce_industry', 'rl_render_industry');
function rl_render_industry() {
    if (!rl_is_ind()) return '';
    $slug = rl_ind_current(); $d = rl_ind_data()[$slug];
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $diag = $u('search-authority-diagnostic');
    $agents = function_exists('rl_ag_data') ? rl_ag_data() : [];
    ob_start(); ?>
<div class="rl-page rl-ind">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('industries'); ?>">Industries</a></li>
  <li><span aria-current="page"><?php echo esc_html($d['name']); ?></span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Industries&nbsp;<b>/</b>&nbsp;<?php echo esc_html($d['name']); ?>&nbsp;<b>]</b></span>
      <h1 class="h1"><?php echo esc_html($d['h1'][0]); ?><br><?php echo esc_html($d['h1'][1]); ?><br><span class="r"><?php echo esc_html($d['h1'][2]); ?></span></h1>
      <p class="lede"><?php echo wp_kses($d['lede'], ['strong' => []]); ?></p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#services">Services for <?php echo esc_html(strtok($d['name'], ' &')); ?></a>
      </div>
    </div>
    <figure class="inf rl-anim">
      <div class="cap" aria-hidden="true"><span><?php echo esc_html($d['name']); ?></span><span>Context · system · guardrails · growth</span></div>
      <?php echo rl_ind_svg($d); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Context', 'kind' => 'chips', 'items' => $d['real']], ['label' => '', 'kind' => 'core', 'title' => $d['name'], 'sub' => 'AI Growth System'], ['label' => 'System', 'kind' => 'chips', 'items' => ['Search', 'Content', 'AI search', 'Automation'], 'join' => false], ['label' => 'Guardrails', 'kind' => 'rows', 'items' => array_map(function ($t) { return [$t, 'ok']; }, $d['guard'])], ['label' => 'Growth', 'kind' => 'rows', 'items' => [['Search, content and automation working as one', 'hi']]]], 'Context · system · guardrails · growth'); ?></figure>
  </div>
</section>

<section class="band alt" id="challenges">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The challenge&nbsp;<b>]</b></span><h2>What makes <?php echo esc_html($d['name']); ?> search different?</h2></div>
    <div class="cols c3">
      <?php foreach ($d['chal'] as $i => $c) { ?>
      <div class="cell"><span class="n"><?php echo sprintf('%02d', $i + 1); ?> · Challenge</span><h3><?php echo esc_html($c[0]); ?></h3><p><?php echo esc_html($c[1]); ?></p></div>
      <?php } ?>
    </div>
  </div>
</section>

<section id="evidence">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The evidence&nbsp;<b>]</b></span><h2>What do the rules and research say?</h2></div>
    <div class="cols c2">
      <?php foreach ($d['facts'] as $f) { ?>
      <div class="cell fact"><h3><?php echo esc_html($f[0]); ?></h3><p><?php echo esc_html($f[1]); ?></p><p class="src">Source: <a href="<?php echo esc_url($f[3]); ?>" rel="noopener" target="_blank"><?php echo esc_html($f[2]); ?></a></p></div>
      <?php } ?>
    </div>
  </div>
</section>

<section class="band alt" id="services">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>]</b></span><h2>Which services fit <?php echo esc_html($d['name']); ?>?</h2><p class="lede">The parts of the AI Growth System that matter most in your industry.</p></div>
    <div class="cols c3">
      <?php foreach ($d['svc'] as $s) { $l = $ex($s[0]); $in = '<span class="n">Service</span><h3>' . esc_html($s[1]) . '</h3><p>' . esc_html($s[2]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section id="agents">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Agents&nbsp;<b>]</b></span><h2>Which Search Authority OS agents help most?</h2></div>
    <div class="cols c3">
      <?php foreach ($d['agents'] as $ag) { if (!isset($agents[$ag])) continue; $a = $agents[$ag]; $l = $ex('services/agents/' . $ag); $al = $a['name'] . ($a['id'] === 'A-07' ? ' Auditor' : ' Agent');
          $in = '<span class="n">' . esc_html($a['id'] . ' · ' . $a['stage']) . '</span><h3>' . esc_html($al) . '</h3><p>' . esc_html(wp_strip_all_tags(explode('.', $a['lede'])[0]) . '.') . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; }
      $l = $ex('search-authority-os'); $in = '<span class="n">The full system</span><h3>Search Authority OS</h3><p>All eight agents connected into one search and content operating system.</p>';
      echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; ?>
    </div>
  </div>
</section>

<section class="band alt" id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2><?php echo esc_html($d['honest'][0]); ?></h2>
      <p><?php echo esc_html($d['honest'][1]); ?></p>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About <?php echo esc_html($d['name']); ?>.</h2></div>
    <?php foreach ($d['faqs'] as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>How does your business show up in search and AI?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('industries'); ?>">All industries</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
