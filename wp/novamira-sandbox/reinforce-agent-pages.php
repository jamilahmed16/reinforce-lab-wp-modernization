<?php
/**
 * Plugin Name: Reinforce Lab — Agent pages (8)
 * Description: /services/agents/{slug}/ — the 8 Search Authority OS agent selling pages (D-016; outcome-led per the strategy doc), one template with per-agent content. Provides [reinforce_agent]. Uses the shared kit (D-044). Hero animation "Agent loop" with per-agent labels (D-039 Step 3). Availability of the agent software: see O-022.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* ---------- single source: the 8 agent pages (outcome-led; D-016 strategy: "sell one specific business outcome, not technology") ----------
   Keys: id, name, stage, h1 (3 lines), lede, anim [inputs, steps, outputs], problems, does (4 steps), get (6), honest [h2, p],
   inds (8 × 2 points, D-022 order), faqs (4), neighbours (2 agent slugs), yoast [title, meta]. */
function rl_ag_data() {
    return [
        'seo-intelligence' => [
            'id' => 'A-01', 'name' => 'SEO Intelligence', 'stage' => 'Understand',
            'h1' => ['Know exactly', 'what to rank for', 'and why.'],
            'lede' => 'The <strong>SEO Intelligence Agent</strong> tells you which searches are worth winning. It reads your Search Console data, rankings, search-result layouts and demand, separates high-value opportunities from vanity keywords, and turns them into a prioritised plan of topics and pages — reviewed by the Reinforce Lab team before it reaches you.',
            'anim' => [['SEARCH CONSOLE', 'SERP DATA', 'KEYWORD DATA'], ['DEMAND', 'INTENT', 'VALUE'], ['PRIORITY TOPICS', 'PAGE PLAN', 'QUICK WINS']],
            'problems' => [['Chasing volume', 'High-volume keywords that never turn into leads eat the budget.'], ['Guessing intent', 'Pages target a keyword but not what the searcher actually wants.'], ['No priorities', 'Hundreds of ideas, and no clear order to do them in.']],
            'does' => [['Read the data', 'Search Console queries, rankings, search-result features and demand.'], ['Judge intent', 'What each search is really asking for, and which page should answer it.'], ['Score value', 'Opportunity weighed by relevance to what you sell, difficulty and position.'], ['Plan', 'A ranked list of topics and pages, with quick wins marked.']],
            'get' => ['A prioritised topic and page plan', 'Quick wins: pages close to page one', 'Search intent for every priority topic', 'Keywords mapped to existing or new pages', 'Cannibalisation warnings where pages compete', 'A monthly refresh as the data changes'],
            'honest' => ['The best keyword is rarely the biggest one.', 'Search volume is the easiest number to find and the least useful on its own. The SEO Intelligence Agent ranks opportunities by how likely they are to bring in a customer — which often means smaller, more specific searches first.'],
            'inds' => [['Therapy-area and product searches prioritised', 'HCP and patient intent kept apart'], ['Condition and service searches by location', 'Patient questions mapped to pages'], ['Solution, integration and comparison searches', 'Buying-stage intent over traffic'], ['Category and product demand by season', 'Commercial intent ranked by margin'], ['Application and specification searches', 'Trade and distributor demand'], ['Problem-led and product searches', 'Technical and buyer intent separated'], ['Practice-area searches that win clients', 'Local and national demand compared'], ['Course and programme searches', 'Student intent by stage']],
            'faqs' => [['What does the SEO Intelligence Agent do?', 'It works out which searches are worth winning for your business. It reads your Search Console data, rankings, search-result layouts and demand, judges the intent behind each search and scores its value, then produces a prioritised plan of topics and pages.'], ['What do I actually receive?', 'A ranked topic and page plan, quick wins close to page one, the search intent behind each priority topic, keywords mapped to existing or new pages, and warnings where your own pages compete with each other.'], ['Is it better than a keyword tool?', 'A keyword tool gives you lists. The agent’s output is a decision: which searches matter for your business, in what order, and which page should win each one — checked by people before you get it.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['content-research', 'competitor-intelligence'],
            'yoast' => ['SEO Intelligence Agent | Search Authority OS | Reinforce Lab', 'The SEO Intelligence Agent shows which searches are worth winning: demand, intent and value turned into a prioritised topic and page plan, reviewed by people.'],
        ],
        'content-research' => [
            'id' => 'A-02', 'name' => 'Content Research', 'stage' => 'Understand',
            'h1' => ['Research-backed', 'topics, not', 'guesses.'],
            'lede' => 'The <strong>Content Research Agent</strong> gives writers what they need to publish something better than what already ranks. It maps what the market asks and what already ranks, finds the information gaps competitors leave open, and hands your writers a researched brief with sources — not just a keyword.',
            'anim' => [['SERP CONTENT', 'QUESTIONS', 'RIVAL PAGES'], ['MAP', 'GAPS', 'ANGLES'], ['RESEARCH BRIEF', 'OUTLINE', 'SOURCES']],
            'problems' => [['Copycat content', 'Articles that rewrite the top results add nothing new — and rank like it.'], ['Thin briefs', 'Writers get a keyword and a word count, then guess the rest.'], ['Missed questions', 'The questions buyers actually ask go unanswered.']],
            'does' => [['Map the topic', 'What already ranks, and what each result covers.'], ['Collect the questions', 'What people ask about the topic, across search and communities.'], ['Find the gaps', 'What competitors leave out, get wrong or cover thinly.'], ['Brief the writer', 'Angle, structure, questions to answer and sources to use.']],
            'get' => ['A researched brief for every piece', 'The questions each piece must answer', 'Gaps competitors leave open', 'A recommended angle and outline', 'Sources for key facts and figures', 'Internal links to include'],
            'honest' => ['Research is where originality starts.', 'You cannot write something better than what ranks without first knowing exactly what ranks and what it misses. The Content Research Agent does that work up front, so writers spend their time on insight rather than on reading ten search results.'],
            'inds' => [['Disease-area questions mapped for writers', 'Sources flagged for medical review'], ['Patient questions by condition and treatment', 'Plain-language angles'], ['Buyer questions for each solution', 'Gaps in competitor comparisons'], ['Buying-guide questions by category', 'Product comparison angles'], ['Technical questions engineers ask', 'Application and specification gaps'], ['Explainers for technical and non-technical buyers', 'Gaps in documentation content'], ['Client questions by practice area', 'Regulatory and market-update angles'], ['Student and parent questions by stage', 'Course comparison gaps']],
            'faqs' => [['What does the Content Research Agent do?', 'It researches a topic before anything is written: what already ranks, what people ask, and what competitors leave out. The result is a brief that gives the writer an angle, a structure, the questions to answer and the sources to use.'], ['What is in a research brief?', 'The target search and its intent, the questions to answer, the gaps to fill, a recommended angle and outline, sources for key facts, and the internal links to include.'], ['Does it write the content?', 'No. It prepares the research so your writers — or ours — can write something genuinely better. Writing, editing and expert review stay with people.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['seo-intelligence', 'evidence-verification'],
            'yoast' => ['Content Research Agent | Search Authority OS | Reinforce Lab', 'The Content Research Agent turns topics into researched briefs: what ranks, what people ask, what competitors miss, and the sources writers need.'],
        ],
        'evidence-verification' => [
            'id' => 'A-03', 'name' => 'Evidence Verification', 'stage' => 'Verify',
            'h1' => ['Every claim', 'sourced and', 'checked.'],
            'lede' => 'The <strong>Evidence Verification Agent</strong> makes sure what you publish is true and can be backed up. It ties every important claim to a source, scores how confident the evidence is, and flags weak or conflicting sources for a person to review — using domain sources such as PubMed and ClinicalTrials.gov where the field requires it.',
            'anim' => [['DRAFT CLAIMS', 'SOURCES', 'DOMAIN DATA'], ['MATCH', 'SCORE', 'FLAG'], ['SOURCED CLAIMS', 'CONFIDENCE', 'REVIEW FLAGS']],
            'problems' => [['Unsupported claims', 'Statistics and statements with no source — or a source that doesn’t say it.'], ['Outdated facts', 'Figures that were true years ago, still published today.'], ['Risk in regulated fields', 'In health, finance and law, one wrong claim can cost more than the page earns.']],
            'does' => [['Extract claims', 'Every statistic, fact and statement that needs support.'], ['Match sources', 'Each claim linked to the source that supports it.'], ['Score confidence', 'How strong, recent and relevant the evidence is.'], ['Flag for review', 'Weak, conflicting or missing evidence sent to a person.']],
            'get' => ['A claim-by-claim evidence log', 'A source for every important claim', 'Confidence scores', 'Flags for weak or conflicting evidence', 'Suggested corrections and replacements', 'An audit trail for compliance review'],
            'honest' => ['A confidence score is not a sign-off.', 'The agent finds and scores evidence; it does not replace medical, legal or compliance review. Anything it flags goes to a person, and in regulated fields your own reviewers keep the final say.'],
            'inds' => [['Claims checked against PubMed and ClinicalTrials.gov', 'Evidence logs for medical-legal review'], ['Clinical statements sourced and dated', 'Weak evidence flagged for clinicians'], ['Product and market claims sourced', 'Statistics checked for age and origin'], ['Product claims checked against specs', 'Review and rating claims verified'], ['Performance and standards claims sourced', 'Certifications checked'], ['Benchmarks and research claims verified', 'Vendor statistics traced to source'], ['Regulatory statements checked and dated', 'Financial and legal claims flagged for review'], ['Research and outcome claims sourced', 'Rankings and statistics verified']],
            'faqs' => [['What does the Evidence Verification Agent do?', 'It checks the claims in your content. Every important statement is matched to a source, scored for how confident the evidence is, and flagged for human review if the evidence is weak, conflicting or missing.'], ['Which sources does it use?', 'The sources the claim requires: official and primary sources first, and domain databases such as PubMed and ClinicalTrials.gov for medical and life-sciences content.'], ['Does it replace our medical or legal review?', 'No. It prepares an evidence log that makes that review faster and more thorough. Final approval stays with your reviewers.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['content-research', 'content-qa'],
            'yoast' => ['Evidence Verification Agent | Search Authority OS | Reinforce Lab', 'The Evidence Verification Agent ties every important claim to a source, scores confidence and flags weak evidence for human review.'],
        ],
        'aeo-geo-optimization' => [
            'id' => 'A-04', 'name' => 'AEO / GEO Optimization', 'stage' => 'Optimize & QA',
            'h1' => ['Show up inside', 'AI answers,', 'accurately.'],
            'lede' => 'The <strong>AEO / GEO Optimization Agent</strong> helps your brand appear — correctly — in AI answers. It tracks where you are mentioned and cited across ChatGPT, Perplexity, Gemini and Google’s AI Overviews, structures your pages so AI systems can extract and cite them, and strengthens the facts AI tools use to describe you.',
            'anim' => [['AI ANSWERS', 'YOUR PAGES', 'ENTITY FACTS'], ['TRACK', 'STRUCTURE', 'ALIGN'], ['CITATION REPORT', 'PAGE FIXES', 'ENTITY FIXES']],
            'problems' => [['Invisible in AI', 'You rank on Google but AI answers recommend competitors.'], ['Described wrongly', 'AI tools get your services, prices or facts wrong.'], ['Hard to cite', 'Pages bury the answer, so AI systems quote someone else.']],
            'does' => [['Track answers', 'Where you are mentioned or cited for the prompts that matter.'], ['Diagnose', 'Why competitors are cited instead — structure, facts or authority.'], ['Structure pages', 'Clear answers, definitions and data that can be extracted and cited.'], ['Align facts', 'One consistent description of your brand across the sources AI uses.']],
            'get' => ['An AI visibility and citation report', 'The prompts where you are missing', 'Page-level fixes for citable answers', 'Entity and fact corrections', 'Structured data recommendations', 'Monthly tracking of mentions and citations'],
            'honest' => ['No one controls what an AI says.', 'AI answers change and differ between tools. What can be improved is how clear, consistent and citable your information is — and whether you track the results honestly, prompt by prompt, rather than claiming guaranteed placement.'],
            'inds' => [['AI answers checked for accurate product facts', 'Citable, reviewed disease-area content'], ['Service and location facts consistent for AI', 'Clinician expertise made citable'], ['Presence in AI tool recommendations', 'Comparison prompts tracked'], ['Product facts consistent across AI tools', 'Buying-guide prompts tracked'], ['Specifications AI tools can quote accurately', 'Distributor facts aligned'], ['Visibility in technical and buying prompts', 'Documentation structured for citation'], ['Firm and expert facts consistent for AI', 'Practice-area prompts tracked'], ['Course facts AI tools get right', 'Admissions prompts tracked']],
            'faqs' => [['What do AEO and GEO mean?', 'Answer engine optimization (AEO) and generative engine optimization (GEO) describe the work of making your content findable, citable and correctly described in AI-generated answers — from ChatGPT, Perplexity and Gemini to Google’s AI Overviews.'], ['What does the agent track?', 'For the prompts that matter to your business, whether your brand is mentioned, whether your pages are cited, how you are described, and which competitors appear instead.'], ['Can you guarantee we’ll appear in AI answers?', 'No one can. AI answers vary between tools and over time. We improve what can be improved — clarity, consistency and authority — and report the results prompt by prompt.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['content-qa', 'search-performance'],
            'yoast' => ['AEO / GEO Optimization Agent | Search Authority OS | Reinforce Lab', 'The AEO / GEO Optimization Agent tracks where you appear in AI answers and makes your pages and brand facts easier for AI to cite correctly.'],
        ],
        'social-sentiment' => [
            'id' => 'A-05', 'name' => 'Social Sentiment', 'stage' => 'Understand',
            'h1' => ['Write in your', 'customers’', 'own words.'],
            'lede' => 'The <strong>Social Sentiment Agent</strong> brings the real voice of your customers into your content. It collects the questions, objections and complaints people post in forums, reviews and social channels, groups them into themes, and turns them into topics, angles and FAQs — so your content sounds like the people you sell to.',
            'anim' => [['FORUMS', 'REVIEWS', 'SOCIAL POSTS'], ['COLLECT', 'CLUSTER', 'TRANSLATE'], ['TOP OBJECTIONS', 'FAQ TOPICS', 'NEW ANGLES']],
            'problems' => [['Written for insiders', 'Content uses your language, not the words customers search with.'], ['Objections ignored', 'The doubts that stop a purchase never get answered.'], ['Stale topics', 'Content plans miss what people are talking about right now.']],
            'does' => [['Collect', 'Public posts, reviews and discussions about your topic, category and competitors.'], ['Cluster', 'Group them into recurring questions, objections and complaints.'], ['Weigh', 'Separate recurring themes from one-off noise.'], ['Translate', 'Turn themes into topics, angles, FAQs and wording for your content.']],
            'get' => ['A customer-voice report by theme', 'Top questions and objections', 'Complaints about you and your competitors', 'FAQ topics in customers’ words', 'Content angles for your plan', 'Monthly updates as conversations change'],
            'honest' => ['Loud is not the same as common.', 'A few angry posts can look like a trend. The agent weighs how often a theme recurs before it shapes your content — and the analysis uses public conversations only, handled with care for people’s privacy.'],
            'inds' => [['Public conversations about conditions and treatments', 'Questions HCPs and patients raise'], ['Patient questions and concerns by service', 'Review themes by location'], ['User complaints about tools in your category', 'Feature and pricing objections'], ['Review themes by product and category', 'Delivery and returns concerns'], ['Buyer and engineer questions from forums', 'Trade-show and industry discussion themes'], ['Developer and buyer pain points', 'Competitor complaint themes'], ['Client questions by practice area', 'Common objections to hiring'], ['Student and parent concerns by stage', 'Review themes by programme']],
            'faqs' => [['What does the Social Sentiment Agent do?', 'It collects what real people say about your topic, category and competitors — in forums, reviews and social channels — groups it into themes, and turns those themes into topics, angles and FAQs for your content.'], ['Which sources does it look at?', 'Public sources relevant to your market, such as forums, review sites and social channels. It does not access private messages or accounts.'], ['How is this different from social media monitoring?', 'Monitoring tracks mentions of your brand. This agent studies what your customers ask and complain about, and turns it into content decisions.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['content-research', 'competitor-intelligence'],
            'yoast' => ['Social Sentiment Agent | Search Authority OS | Reinforce Lab', 'The Social Sentiment Agent turns real customer questions, objections and complaints from public conversations into topics, angles and FAQs.'],
        ],
        'competitor-intelligence' => [
            'id' => 'A-06', 'name' => 'Competitor Intelligence', 'stage' => 'Understand',
            'h1' => ['Find the gaps', 'your rivals', 'leave open.'],
            'lede' => 'The <strong>Competitor Intelligence Agent</strong> shows where your competitors win in search — and where they don’t. It maps what they cover, rank for and get cited for in AI answers, identifies the gaps worth owning, and keeps watch so a competitor’s move doesn’t surprise you.',
            'anim' => [['RIVAL RANKINGS', 'RIVAL CONTENT', 'AI CITATIONS'], ['MAP', 'COMPARE', 'MONITOR'], ['GAP LIST', 'THREAT ALERTS', 'TARGET PAGES']],
            'problems' => [['Blind spots', 'You don’t know which searches your rivals own — or why.'], ['Surprises', 'A competitor’s new content takes your rankings before anyone notices.'], ['Copying the leader', 'Plans follow the biggest rival instead of the gaps it leaves.']],
            'does' => [['Map', 'Which searches, topics and AI prompts each competitor wins.'], ['Compare', 'Your coverage against theirs, page by page and topic by topic.'], ['Find gaps', 'Where demand is real and competitors are weak or absent.'], ['Monitor', 'New content, ranking moves and citations over time.']],
            'get' => ['A competitor coverage map', 'Gaps worth owning, ranked by value', 'Pages to build or strengthen', 'Where rivals get cited in AI answers', 'Alerts on significant competitor moves', 'A monthly competitive summary'],
            'honest' => ['Beating a competitor rarely means copying them.', 'The most valuable finding is usually what a strong competitor ignores. The agent looks for those gaps first — the searches with real demand where you can be the best answer, not the tenth version of theirs.'],
            'inds' => [['Therapy-area coverage against rival brands', 'HCP and patient content gaps'], ['Local rivals’ service and location coverage', 'Condition content gaps'], ['Comparison and alternative searches rivals own', 'Integration content gaps'], ['Category rankings against rival stores', 'Buying-guide gaps'], ['Application searches rivals rank for', 'Technical content gaps'], ['Rival visibility in technical and AI prompts', 'Documentation gaps'], ['Practice-area searches rival firms win', 'Thought-leadership gaps'], ['Course searches rival institutions own', 'Programme comparison gaps']],
            'faqs' => [['What does the Competitor Intelligence Agent do?', 'It maps what your competitors rank for, cover and get cited for in AI answers, compares it with your own coverage, finds the gaps worth owning, and keeps watch for significant moves.'], ['Which competitors does it track?', 'The ones you name, plus the sites that actually compete with you in search results — which are often not the companies you compete with for sales.'], ['What do I do with the findings?', 'Each gap comes with a recommendation — build a page, strengthen one, or leave it alone — ranked by value to your business.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['seo-intelligence', 'search-performance'],
            'yoast' => ['Competitor Intelligence Agent | Search Authority OS | Reinforce Lab', 'The Competitor Intelligence Agent maps where rivals win in search and AI answers, finds the gaps worth owning and watches for their next move.'],
        ],
        'content-qa' => [
            'id' => 'A-07', 'name' => 'Content QA', 'stage' => 'Optimize & QA',
            'h1' => ['A quality gate', 'before anything', 'ships.'],
            'lede' => 'The <strong>Content QA Auditor</strong> checks every piece before it is published. Each asset is tested against your SEO, AEO, GEO and evidence standards, thin, unsupported or off-brand content is caught before it goes live, and a human approval step stays in place where it matters.',
            'anim' => [['DRAFT', 'STANDARDS', 'EVIDENCE LOG'], ['SEO CHECK', 'AEO/GEO CHECK', 'EVIDENCE CHECK'], ['FIX LIST', 'APPROVAL', 'AUDIT TRAIL']],
            'problems' => [['Quality drifts at scale', 'The more you publish, the more inconsistent it gets.'], ['Mistakes reach the live site', 'Missing titles, broken links, unsupported claims — found by customers.'], ['Scaled-content risk', 'Pages produced in volume without enough value can breach Google’s policies.']],
            'does' => [['Check SEO', 'Titles, headings, links, schema and search intent.'], ['Check AEO/GEO', 'Clear answers, definitions and citable structure.'], ['Check evidence', 'Every important claim has a source and passes review.'], ['Gate', 'A pass, or a specific fix list — then human approval.']],
            'get' => ['A pass or fix list for every asset', 'SEO checks on every page', 'AEO / GEO readiness checks', 'Evidence and claim checks', 'Brand and style checks', 'An audit trail of what was checked and approved'],
            'honest' => ['A checklist can’t judge insight.', 'The auditor catches what rules can catch — missing elements, weak evidence, thin sections. Whether a piece is genuinely useful still needs an editor’s judgement, so a person approves before anything important goes live.'],
            'inds' => [['Medical-legal checks built into the gate', 'Evidence logs attached to approvals'], ['Clinical accuracy and accessibility checks', 'Author and review-date checks'], ['Product-accuracy checks before launch', 'SEO checks for every template'], ['Product page completeness checks', 'Structured data checks'], ['Specification accuracy checks', 'Download and form checks'], ['Technical accuracy and code-sample checks', 'Documentation standards'], ['Regulatory and confidentiality checks', 'Partner approval steps'], ['Course-fact and accessibility checks', 'Admissions content approvals']],
            'faqs' => [['What does the Content QA Auditor check?', 'SEO (titles, headings, links, schema, intent), AEO and GEO readiness (clear answers and citable structure), evidence (every important claim sourced), and your brand and style rules — before anything is published.'], ['Why does it matter for Google?', 'Google treats many pages made mainly to manipulate rankings rather than help people as scaled content abuse, however they are produced. A quality gate keeps volume from turning into risk.'], ['Does a person still approve content?', 'Yes. The auditor produces a pass or a fix list; a person approves before anything important goes live.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['evidence-verification', 'aeo-geo-optimization'],
            'yoast' => ['Content QA Auditor | Search Authority OS | Reinforce Lab', 'The Content QA Auditor checks every asset against SEO, AEO, GEO and evidence standards before it ships, with human approval where it matters.'],
        ],
        'search-performance' => [
            'id' => 'A-08', 'name' => 'Search Performance', 'stage' => 'Measure & heal',
            'h1' => ['Diagnose drops.', 'Recover', 'rankings.'],
            'lede' => 'The <strong>Search Performance Agent</strong> finds out why pages slip and what to do about it. It reads your Search Console, GA4 and AI visibility data, diagnoses decay, intent shifts and pages competing with each other, recommends the fix — and tracks whether it worked.',
            'anim' => [['SEARCH CONSOLE', 'GA4', 'AI VISIBILITY'], ['DETECT', 'DIAGNOSE', 'FIX'], ['DROP ALERTS', 'ROOT CAUSE', 'RECOVERY PLAN']],
            'problems' => [['Unexplained drops', 'Traffic falls and nobody can say why.'], ['Slow decay', 'Pages lose ground month by month until they disappear.'], ['Fixes nobody checks', 'Changes are made, but no one measures whether they worked.']],
            'does' => [['Detect', 'Pages and queries losing clicks, impressions or position.'], ['Diagnose', 'Decay, intent shifts, competition, cannibalisation or technical causes.'], ['Recommend', 'The fix for each page — refresh, merge, redirect or rebuild.'], ['Track', 'Whether the fix worked, then what to do next.']],
            'get' => ['Alerts on significant drops', 'A root cause for each declining page', 'A prioritised recovery plan', 'Cannibalisation and decay reports', 'Before-and-after tracking of every fix', 'A performance report every week'],
            'honest' => ['Not every drop is a problem you can fix.', 'Some losses come from changes in demand or in how Google presents results. The agent separates those from problems you can fix, so effort goes where it can recover something — and Google itself says some changes take weeks or months to show.'],
            'inds' => [['Drops on therapy-area and product pages diagnosed', 'Recovery tracked page by page'], ['Location and service page decay caught early', 'Seasonal demand separated from losses'], ['Solution and comparison page drops diagnosed', 'Pipeline impact tracked'], ['Category and product page losses diagnosed', 'Seasonal and stock effects separated'], ['Product and application page decay caught', 'Distributor page performance tracked'], ['Documentation and resource page drops diagnosed', 'AI visibility changes tracked'], ['Practice-area page losses diagnosed', 'Local and national changes separated'], ['Course page drops caught before admissions peaks', 'Programme performance tracked']],
            'faqs' => [['What does the Search Performance Agent do?', 'It watches your search performance, detects pages and queries that are slipping, diagnoses why, recommends the fix and tracks whether it worked.'], ['Which data does it use?', 'Your Google Search Console and GA4 data, plus AI visibility tracking where it is part of your plan. Access is read-only.'], ['How quickly will a fix show results?', 'It varies. Google says some changes take effect in hours and others take several months, and suggests waiting a few weeks to judge whether a change helped. The agent tracks each fix over that period.'], ['Can I use it on its own?', 'Yes. Every agent can run on its own, scoped after the free diagnostic, or as part of a Search Authority OS package.']],
            'neighbours' => ['seo-intelligence', 'aeo-geo-optimization'],
            'yoast' => ['Search Performance Agent | Search Authority OS | Reinforce Lab', 'The Search Performance Agent detects slipping pages, diagnoses the cause, recommends the fix and tracks recovery across Search Console, GA4 and AI search.'],
        ],
    ];
}

/* current agent: a page under /services/agents/ whose slug is in the data */
function rl_ag_current() {
    static $cur = null;
    if ($cur !== null) return $cur;
    $cur = '';
    if (!is_page()) return $cur;
    $p = get_queried_object();
    if (!$p || empty($p->post_parent)) return $cur;
    $parent = get_post($p->post_parent);
    if ($parent && $parent->post_name === 'agents' && isset(rl_ag_data()[$p->post_name])) $cur = $p->post_name;
    return $cur;
}
function rl_is_ag() { return rl_ag_current() !== ''; }

/* ---------- hero animation: Agent loop (one family, labels per agent) ----------
   The agent's three inputs light and feed the agent; its three steps run in turn; results pass a human
   review gate; its three outputs are delivered; input · analyse · review · deliver light in turn.
   10 s loop, soft fade, reset. */
function rl_ag_svg($a) {
    list($in, $st, $out) = $a['anim'];
    $name = strtoupper($a['name']);
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlAgPT"><title id="rlAgPT">' . esc_html($a['name']) . ' Agent: ' . esc_html(ucwords(strtolower(implode(', ', $in)))) . ' are analysed in three steps — ' . esc_html(strtolower(implode(', ', $st))) . ' — then reviewed by a person before ' . esc_html(strtolower(implode(', ', $out))) . ' are delivered.</title>';
    $box = function ($cls, $x, $y, $w, $h, $t, $tc = 'a-t') { return '<rect class="a-b" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '"/><rect class="a-on ' . $cls . '" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '"/>' . ($t !== '' ? '<text class="' . $tc . '" x="' . ($x + $w / 2) . '" y="' . ($y + $h / 2 + 3.5) . '" text-anchor="middle">' . esc_html($t) . '</text>' : ''); };
    $edge = function ($cls, $d) { return '<path class="a-e" d="' . $d . '"/><path class="a-p ' . $cls . '" pathLength="100" d="' . $d . '"/>'; };
    $s .= '<text class="a-lab" x="0" y="20">INPUTS</text><text class="a-lab" x="400" y="20">OUTPUTS</text>';
    foreach ($in as $i => $t) { $y = 36 + $i * 60; $cy = $y + 17; $s .= $edge('a-pi' . $i, 'M118 ' . $cy . ' C136 ' . $cy . ' 130 128 148 128') . $box('a-in' . $i, 0, $y, 118, 34, $t); }
    $s .= $box('a-core', 148, 36, 160, 164, '') . '<text class="a-id" x="160" y="56">' . esc_html($a['id']) . ' AGENT</text><text class="a-h" x="160" y="74">' . esc_html($name) . '</text><line class="a-rule" x1="160" y1="84" x2="296" y2="84"/>';
    foreach ($st as $i => $t) {
        $y = 112 + $i * 32;
        $s .= '<rect class="a-sq" x="160" y="' . ($y - 9) . '" width="10" height="10"/><rect class="a-sqon a-s' . $i . '" x="160" y="' . ($y - 9) . '" width="10" height="10"/><text class="a-ct" x="178" y="' . $y . '">' . esc_html($t) . '</text>';
    }
    $s .= $edge('a-pg', 'M308 128 H330');
    $s .= '<polygon class="a-b" points="354,104 378,128 354,152 330,128"/><polygon class="a-on a-gate" points="354,104 378,128 354,152 330,128"/><text class="a-gt" x="354" y="172" text-anchor="middle">HUMAN</text><text class="a-gt" x="354" y="184" text-anchor="middle">REVIEW</text>';
    foreach ($out as $i => $t) { $y = 36 + $i * 60; $cy = $y + 17; $s .= $edge('a-po' . $i, 'M378 128 C390 128 386 ' . $cy . ' 400 ' . $cy) . $box('a-out' . $i, 400, $y, 120, 34, $t, 'a-t a-to'); }
    $s .= '<text class="a-cap" x="260" y="262" text-anchor="middle">SEARCH AUTHORITY OS · STAGE: ' . esc_html(strtoupper($a['stage'])) . '</text>';
    $s .= '<line class="a-rule2" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['INPUT', 'ANALYSE', 'REVIEW', 'DELIVER'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="a-ft" x="' . $x . '" y="372">' . $f . '</text><text class="a-ft a-fton a-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="a-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="a-fbon a-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_ag_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 3; $i++) { $s = 2 + $i * 3; $k .= $lit("rlagIn$i", $s, $s + 2) . $pul("rlagPi$i", $s + 1, $s + 8) . ".rl-ag .a-in$i{animation-name:rlagIn$i}.rl-ag .a-pi$i{animation-name:rlagPi$i}\n"; }
    $k .= $lit('rlagCore', 12, 15);
    for ($i = 0; $i < 3; $i++) { $s = 16 + $i * 5; $k .= $lit("rlagS$i", $s, $s + 2) . ".rl-ag .a-s$i{animation-name:rlagS$i}\n"; }
    $k .= $pul('rlagPg', 31, 36) . $lit('rlagGate', 36, 39);
    for ($i = 0; $i < 3; $i++) { $s = 40 + $i * 4; $k .= $pul("rlagPo$i", $s, $s + 6) . $lit("rlagOut$i", $s + 5, $s + 7) . ".rl-ag .a-po$i{animation-name:rlagPo$i}.rl-ag .a-out$i{animation-name:rlagOut$i}\n"; }
    $k .= ".rl-ag .a-core{animation-name:rlagCore}.rl-ag .a-pg{animation-name:rlagPg}.rl-ag .a-gate{animation-name:rlagGate}\n" . $lit('rlagCap', 60, 64);
    foreach ([2, 12, 36, 45] as $i => $s) $k .= $lit("rlagF$i", $s, $s + 3) . "@keyframes rlagFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-ag .a-f$i{animation-name:rlagF$i}.rl-ag .a-fb$i{animation-name:rlagFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_ag()) $c[] = 'rl-ag-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_ag(); });
add_action('wp_head', 'rl_ag_css', 22);
function rl_ag_css() {
    if (!rl_is_ag()) return; ?>
<style id="rl-ag-css">
body.rl-ag-page .fl-page-content,body.rl-ag-page .fl-content,body.rl-ag-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-ag .agf{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-ag .agf .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-ag .agf .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-ag .agf svg{display:block;width:100%;height:auto;overflow:visible}
.rl-ag .a-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ag .a-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-ag .a-t{font-family:var(--f-mono);font-size:8px;letter-spacing:.08em;fill:var(--ink-dim)}
.rl-ag .a-to{fill:var(--ink)}
.rl-ag .a-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-ag .a-id{font-family:var(--f-mono);font-size:8px;letter-spacing:.18em;fill:var(--red-3)}
.rl-ag .a-h{font-family:var(--f-display);font-weight:600;font-size:11px;letter-spacing:.05em;fill:var(--ink)}
.rl-ag .a-rule{stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-ag .a-sq{fill:none;stroke:rgba(243,237,230,.25);stroke-width:.8}
.rl-ag .a-sqon{fill:var(--red-2);opacity:0}
.rl-ag .a-ct{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-ag .a-gt{font-family:var(--f-mono);font-size:7.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ag .a-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-ag .a-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-ag .a-cap{font-family:var(--f-mono);font-size:8px;letter-spacing:.16em;fill:var(--ink-faint);opacity:0;animation-name:rlagCap}
.rl-ag .a-rule2{stroke:var(--line-2);stroke-width:1}
.rl-ag .a-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ag .a-fton{fill:var(--ink);opacity:0}
.rl-ag .a-fb{fill:rgba(255,255,255,.08)}
.rl-ag .a-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-ag .a-on,.rl-ag .a-sqon,.rl-ag .a-p,.rl-ag .a-cap,.rl-ag .a-fton,.rl-ag .a-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-ag .a-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-ag .a-t{font-size:8.5px;letter-spacing:0}.rl-ag .a-ct{font-size:10px;letter-spacing:.04em}.rl-ag .a-h{font-size:11.5px}.rl-ag .a-lab,.rl-ag .a-id,.rl-ag .a-gt{font-size:9px;letter-spacing:.06em}.rl-ag .a-cap{font-size:9px;letter-spacing:.04em}.rl-ag .a-ft{font-size:11px;letter-spacing:.04em}.rl-ag .agf .cap span+span{display:none}.rl-ag .agf{padding:16px 10px 10px}}
<?php echo rl_ag_kf(); ?>
.rl-ag .ind ul li{font-size:14px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_ag() || !is_array($graph)) return $graph;
    $a = rl_ag_data()[rl_ag_current()];
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => $a['name'] . ($a['id'] === 'A-07' ? ' Auditor' : ' Agent'),
        'serviceType' => 'AI search and content agent', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => wp_strip_all_tags($a['lede']),
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
        'isRelatedTo' => ['@type' => 'Service', 'name' => 'Search Authority OS', 'url' => function_exists('rl_url_by_path') ? rl_url_by_path('search-authority-os', home_url('/')) : home_url('/')],
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, $a['faqs']),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_agent', 'rl_render_agent');
function rl_render_agent() {
    if (!rl_is_ag()) return '';
    $slug = rl_ag_current(); $all = rl_ag_data(); $a = $all[$slug];
    $label = $a['name'] . ($a['id'] === 'A-07' ? ' Auditor' : ' Agent');
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $diag = $u('search-authority-diagnostic');
    $inds = [['pharmaceutical', 'Pharmaceutical & Life Sciences'], ['healthcare', 'Healthcare'], ['b2b-saas', 'B2B SaaS'], ['ecommerce', 'E-commerce'], ['manufacturing', 'Manufacturing'], ['technology', 'Technology'], ['professional-services', 'Professional Services'], ['education', 'Education']];
    $stageNote = ['Understand' => 'Demand, competitors and customer voice — before anything is written.', 'Verify' => 'Every important claim sourced and confidence-scored.', 'Optimize & QA' => 'Structured for Google and AI answers, then checked before it ships.', 'Measure & heal' => 'Performance read continuously; slipping pages diagnosed and fixed.'];
    ob_start(); ?>
<div class="rl-page rl-ag">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><a href="<?php echo $u('services/agents'); ?>">Agents</a></li>
  <li><span aria-current="page"><?php echo esc_html($label); ?></span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Agents&nbsp;<b>/</b>&nbsp;<?php echo esc_html($a['id'] . ' ' . $a['name']); ?>&nbsp;<b>]</b></span>
      <h1 class="h1"><?php echo esc_html($a['h1'][0]); ?><br><?php echo esc_html($a['h1'][1]); ?><br><span class="r"><?php echo esc_html($a['h1'][2]); ?></span></h1>
      <p class="lede"><?php echo wp_kses($a['lede'], ['strong' => []]); ?></p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services/agents'); ?>">All 8 agents</a>
      </div>
    </div>
    <figure class="agf rl-anim">
      <div class="cap" aria-hidden="true"><span><?php echo esc_html($a['id'] . ' · ' . $a['name']); ?></span><span>Input · analyse · review · deliver</span></div>
      <?php echo rl_ag_svg($a); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="problem">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The problem&nbsp;<b>]</b></span><h2>What problem does the <?php echo esc_html($label); ?> solve?</h2></div>
    <div class="cols c3">
      <?php foreach ($a['problems'] as $i => $p) { ?>
      <div class="cell"><span class="n"><?php echo sprintf('%02d', $i + 1); ?> · Problem</span><h3><?php echo esc_html($p[0]); ?></h3><p><?php echo esc_html($p[1]); ?></p></div>
      <?php } ?>
    </div>
  </div>
</section>

<section id="does">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>What does the <?php echo esc_html($label); ?> do?</h2><p class="lede">Four steps — with a person reviewing the result before it reaches you.</p></div>
    <ol class="steps">
      <?php foreach ($a['does'] as $i => $d) { ?>
      <li class="step"><div class="k" aria-hidden="true"><?php echo sprintf('%02d', $i + 1); ?></div><h3><?php echo esc_html($d[0]); ?></h3><p><?php echo esc_html($d[1]); ?></p></li>
      <?php } ?>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Human review</h3><p>The Reinforce Lab team checks the output before it is delivered or acted on.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <?php foreach ($a['get'] as $g) echo '<li>' . esc_html($g) . '</li>'; ?>
    </ul>
  </div>
</section>

<section id="fits">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Search Authority OS&nbsp;<b>]</b></span><h2>Where does it fit in Search Authority OS?</h2><p class="lede">Stage: <strong><?php echo esc_html($a['stage']); ?></strong> — <?php echo esc_html($stageNote[$a['stage']]); ?> Run it on its own, or connect it to the agents it works with.</p></div>
    <div class="cols c3">
      <?php foreach ($a['neighbours'] as $n) { $b = $all[$n]; $l = $ex('services/agents/' . $n); $bl = $b['name'] . ($b['id'] === 'A-07' ? ' Auditor' : ' Agent');
          $in = '<span class="n">' . esc_html($b['id'] . ' · ' . $b['stage']) . '</span><h3>' . esc_html($bl) . '</h3><p>' . esc_html(wp_strip_all_tags(explode('.', $b['lede'])[0]) . '.') . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; }
      $l = $ex('search-authority-os'); $in = '<span class="n">The full system</span><h3>Search Authority OS</h3><p>All eight agents connected, so each stage feeds the next and performance feeds the loop.</p>';
      echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; ?>
    </div>
  </div>
</section>

<section class="band alt" id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2><?php echo esc_html($a['honest'][0]); ?></h2>
      <p><?php echo esc_html($a['honest'][1]); ?></p>
    </div>
  </div>
</section>

<section id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is the <?php echo esc_html($label); ?> for?</h2></div>
    <ul class="inds8">
      <?php foreach ($inds as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($a['inds'][$i] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr($label . ' for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About the <?php echo esc_html($label); ?>.</h2></div>
    <?php foreach ($a['faqs'] as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Is this the agent you need first?</h2>
      <p class="lede">The free Search Authority Diagnostic shows where your biggest search gap is — and which agent or package closes it.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('packages'); ?>">Compare packages</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
