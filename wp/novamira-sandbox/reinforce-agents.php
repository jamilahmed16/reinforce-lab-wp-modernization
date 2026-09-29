<?php
/**
 * Plugin Name: Reinforce Lab — Agents hub
 * Description: /services/agents/ — the 8 Search Authority OS agents (outcome-led, per strategy doc §"8 Agent Selling Pages"). Provides [reinforce_agents]. Styled after the SAOS page (no separate mock-up). Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_agents() { return is_page('agents') && (int) wp_get_post_parent_id(get_queried_object_id()) === (int) (get_page_by_path('services') ? get_page_by_path('services')->ID : 0); }

/* ---------- single source: agents (markup + ItemList schema), FAQ ---------- */
function rl_agents_list() {
    return [
        ['A-01', 'seo-intelligence', 'Search Intelligence', 'Know exactly what to rank for.', ['Reads rankings, queries, SERP structure and real demand', 'Separates high-value opportunities from vanity keywords', 'Feeds a prioritized topic and page plan'], 'Teams guessing at keywords or chasing volume'],
        ['A-02', 'content-research', 'Content Research', 'Research-backed topics, not guesses.', ['Maps what the market asks and what already ranks', 'Finds information gaps competitors leave open', 'Hands writers a researched brief, not a keyword'], 'Content teams that need depth and originality'],
        ['A-03', 'evidence-verification', 'Evidence Verification', 'Fact-checked, sourced content.', ['Ties every important claim to a source and a confidence score', 'Flags weak or conflicting sources for human review', 'Uses domain sources such as PubMed and ClinicalTrials.gov where the field requires it'], 'Regulated and expertise-led industries'],
        ['A-04', 'aeo-geo-optimization', 'AEO / GEO Optimization', 'Show up inside AI answers.', ['Tracks where you appear across ChatGPT, Perplexity, Gemini and AI Overviews', 'Structures pages so AI engines can extract and cite them', 'Strengthens entity signals around your brand'], 'Brands that rank on Google but vanish in AI search'],
        ['A-05', 'social-sentiment', 'Social Sentiment', 'Write from real customer voice.', ['Collects the questions, objections and complaints customers actually post', 'Turns them into topics, angles and FAQs', 'Keeps content aligned with how buyers talk'], 'Marketers who want content that sounds like the customer'],
        ['A-06', 'competitor-intelligence', 'Competitor Intelligence', "See where rivals win — and don't.", ['Maps what competitors cover, rank for and get cited for', 'Identifies the gaps worth owning', 'Monitors movement so you are not surprised'], 'Categories where a few rivals dominate search'],
        ['A-07', 'content-qa', 'Content QA Auditor', 'A quality gate before anything ships.', ['Checks every asset against SEO, AEO, GEO and evidence standards', 'Catches thin, unsupported or off-brand content', 'Keeps a human approval step where it matters'], 'Teams scaling output without losing quality'],
        ['A-08', 'search-performance', 'Search Performance', 'Diagnose drops, recover rankings.', ['Reads GSC, GA4 and AI visibility continuously', 'Diagnoses decay, intent shifts and cannibalization', 'Recommends — and tracks — the fix'], 'Sites with slipping rankings or unexplained traffic loss'],
    ];
}
function rl_agents_faqs() {
    return [
        ['Can I use a single agent on its own?', 'Yes. Every agent can run on its own. Start where the pain is sharpest, then add agents or move to a full Search Authority OS package as results come in. Scope and price are set after the free diagnostic.'],
        ['Which agent should I start with?', 'The free Search Authority Diagnostic shows where your biggest gap is — visibility, evidence, AI search, competitors or performance — and recommends the agent or package that fits.'],
        ['Do the agents replace my team?', 'No. Agents handle research, verification, monitoring and quality checks. Your people keep strategy, approvals and relationships — human review stays in the loop.'],
        ['How do the agents work together?', 'Research agents feed verification, verified content passes optimization and QA, and performance monitoring feeds what the system does next. Combined, they form Search Authority OS.'],
        ['What does an agent cost?', 'Single agents are scoped to your site and goals after the diagnostic. For full-system pricing, see the Search Authority OS packages.'],
    ];
}

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_agents()) $c[] = 'rl-agents-page'; return $c; });
add_action('wp_head', 'rl_agents_css', 22);
function rl_agents_css() {
    if (!rl_is_agents()) return; ?>
<style id="rl-agents-css">
.rl-agents{position:relative;width:100vw;margin-left:calc(50% - 50vw);color:var(--ink);font-family:var(--f-body);font-size:16px;line-height:1.6}
body.rl-agents-page .fl-page-content,body.rl-agents-page .fl-content,body.rl-agents-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-agents *{box-sizing:border-box}
.rl-agents a{text-decoration:none;color:inherit}
.rl-agents p{margin:0}
.rl-agents h1,.rl-agents h2,.rl-agents h3,.rl-agents h4{font-family:var(--f-display);font-weight:600;text-transform:uppercase;margin:0;line-height:1.02;letter-spacing:.01em;text-wrap:balance;color:var(--ink)}
.rl-agents .wrap{max-width:var(--maxw);margin:0 auto;padding-inline:var(--gutter)}
.rl-agents section{position:relative;padding-block:clamp(56px,8vw,96px)}
.rl-agents .band{border-top:1px solid var(--line)}
.rl-agents .band.alt{background:radial-gradient(90% 60% at 15% 0%,rgba(153,0,0,.10),transparent 55%),var(--bg-2)}
.rl-agents :focus-visible{outline:2px solid var(--red-2);outline-offset:3px}
.rl-agents .ey{font-family:var(--f-mono);font-size:12px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-faint);display:inline-flex;flex-wrap:wrap;row-gap:.2em;gap:.5em;align-items:center}
.rl-agents .ey b{color:var(--red-2);font-weight:500}
.rl-agents .lede{color:var(--ink-dim);font-size:clamp(16px,1.6vw,19px);max-width:62ch}
.rl-agents .lede a,.rl-agents .faq p a{color:var(--ink);border-bottom:1px solid var(--red-line)}.rl-agents .lede a:hover{color:var(--red-3)}
.rl-agents .head{max-width:64ch;margin-bottom:clamp(32px,5vw,52px)}
.rl-agents .head h2{font-size:clamp(28px,4.2vw,48px);margin-top:14px}.rl-agents .head p{margin-top:18px}
.rl-agents .crumbs{padding-top:clamp(18px,2.4vw,28px);font-family:var(--f-mono);font-size:11.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-agents .crumbs ol{list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:.6em}
.rl-agents .crumbs li+li::before{content:"/";color:var(--red-2);margin-right:.6em}
.rl-agents .crumbs a:hover{color:var(--ink)}.rl-agents .crumbs [aria-current]{color:var(--ink-dim)}
/* buttons (same as SAOS/Home) */
.rl-agents .btn{font-family:var(--f-display);text-transform:uppercase;font-weight:600;letter-spacing:.05em;font-size:14px;padding:15px 26px;display:inline-flex;align-items:center;gap:.55em;border:1px solid transparent;cursor:pointer;transition:.2s;position:relative}
.rl-agents .btn::before{content:"+";font-family:var(--f-mono);font-weight:500;color:var(--red-3);font-size:1.15em;line-height:0}
.rl-agents .btn.p{background:linear-gradient(180deg,#241a1c,#120e0f);color:#fff;border-color:var(--red-line);box-shadow:14px 0 44px -14px var(--red-glow),inset 0 1px 0 var(--glass-hi)}
.rl-agents .btn.p:hover{border-color:var(--red-2);transform:translateY(-1px)}
.rl-agents .btn.g{background:var(--glass);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);color:var(--ink);border-color:var(--glass-line)}
.rl-agents .btn.g::before{color:var(--ink-faint)}.rl-agents .btn.g:hover{border-color:var(--red-line);color:#fff}
.rl-agents .ar{transition:transform .2s}.rl-agents .btn:hover .ar{transform:translateX(4px)}
.rl-agents .cta-row{display:flex;flex-wrap:wrap;gap:14px;margin-top:28px}
/* hero */
.rl-agents .hero{padding-block:clamp(36px,6vw,80px)}
.rl-agents .h1{font-size:clamp(34px,5.1vw,64px);font-weight:700;letter-spacing:-.01em;margin-top:14px;max-width:18ch}
.rl-agents .h1 .r{color:var(--red-2)}
.rl-agents .hero .lede{margin-top:18px}
.rl-agents .chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:26px;list-style:none;padding:0}
.rl-agents .chips a{display:inline-flex;gap:.6em;align-items:center;border:1px solid var(--line-2);background:var(--bg);padding:8px 12px;font-family:var(--f-mono);font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-dim);transition:.15s}
.rl-agents .chips a b{color:var(--red-3);font-weight:500}.rl-agents .chips a:hover{border-color:var(--red-line);color:var(--ink)}
/* agent cards */
.rl-agents .grid2{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
@media(max-width:820px){.rl-agents .grid2{grid-template-columns:1fr}}
.rl-agents .agent{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:28px 26px;box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9);display:flex;flex-direction:column;gap:12px;transition:.2s;scroll-margin-top:90px}
.rl-agents .agent:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-agents .agent .id{font-family:var(--f-mono);font-size:11px;color:var(--red-3);letter-spacing:.12em}
.rl-agents .agent h3{font-size:22px}
.rl-agents .agent .out{font-family:var(--f-display);text-transform:uppercase;letter-spacing:.03em;font-size:15px;color:var(--ink-dim)}
.rl-agents .agent ul{list-style:none;margin:4px 0 0;padding:0;display:grid;gap:9px}
.rl-agents .agent li{font-size:14.5px;color:var(--ink-dim);display:flex;gap:10px}
.rl-agents .agent li::before{content:"›";color:var(--red-2);font-family:var(--f-mono);flex:none}
.rl-agents .agent .for{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.04em;color:var(--ink-faint);border-top:1px solid var(--line);padding-top:12px;margin-top:auto}
.rl-agents .agent .for b{color:var(--ink-dim);font-weight:500}
.rl-agents .agent .more{font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-agents .agent .more:hover{color:var(--ink)}
/* agent map */
.rl-agents .map{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;list-style:none;margin:0;padding:0}
@media(max-width:900px){.rl-agents .map{grid-template-columns:repeat(2,1fr)}}@media(max-width:520px){.rl-agents .map{grid-template-columns:1fr}}
.rl-agents .stage{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);padding:22px;box-shadow:inset 0 1px 0 var(--glass-hi);position:relative}
.rl-agents .stage .k{font-family:var(--f-display);font-size:30px;color:var(--red-2);font-weight:700;opacity:.85}
.rl-agents .stage h3{font-size:16px;margin:6px 0 8px}
.rl-agents .stage p{color:var(--ink-dim);font-size:14px}
.rl-agents .stage .ids{display:flex;flex-wrap:wrap;gap:6px;margin-top:12px}
.rl-agents .stage .ids a{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.06em;border:1px solid var(--line-2);padding:4px 7px;color:var(--ink-dim)}
.rl-agents .stage .ids a:hover{border-color:var(--red-line);color:var(--ink)}
/* one agent vs full OS */
.rl-agents .choose{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:760px){.rl-agents .choose{grid-template-columns:1fr}}
.rl-agents .opt{border:1px solid var(--glass-line);background:var(--glass);padding:30px 26px;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:14px}
.rl-agents .opt.feat{background:linear-gradient(180deg,rgba(153,0,0,.14),var(--glass-2));border-color:var(--red-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 0 70px -26px var(--red-glow)}
.rl-agents .opt .tag{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;color:var(--red-2);text-transform:uppercase}
.rl-agents .opt h3{font-size:22px}
.rl-agents .opt ul{list-style:none;margin:0;padding:0;display:grid;gap:9px}
.rl-agents .opt li{font-size:14.5px;color:var(--ink-dim);display:flex;gap:10px}.rl-agents .opt li::before{content:"+";color:var(--red-2);font-family:var(--f-mono)}
.rl-agents .opt .btn{margin-top:auto;justify-content:center}
/* faq */
.rl-agents .faq details{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);margin-bottom:12px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-agents .faq summary{cursor:pointer;padding:20px 24px;font-family:var(--f-display);text-transform:uppercase;font-size:16px;letter-spacing:.02em;list-style:none;display:flex;justify-content:space-between;gap:16px;align-items:center}
.rl-agents .faq summary::-webkit-details-marker{display:none}
.rl-agents .faq summary::after{content:"+";color:var(--red-2);font-family:var(--f-mono);font-size:20px}
.rl-agents .faq details[open] summary::after{content:"–"}
.rl-agents .faq p{padding:0 24px 22px;color:var(--ink-dim);font-size:15px;max-width:75ch}
/* final */
.rl-agents .final{position:relative;overflow:hidden;border:1px solid var(--red-line);background:#0b090a;padding:clamp(48px,7vw,92px) clamp(24px,5vw,64px);text-align:center;box-shadow:inset 0 1px 0 var(--glass-hi),0 0 130px -46px var(--red-glow)}
.rl-agents .final::before{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(58% 96% at 50% 128%,rgba(226,59,59,.6),rgba(153,0,0,.28) 38%,transparent 70%),linear-gradient(180deg,transparent 40%,rgba(153,0,0,.10))}
.rl-agents .final::after{content:"";position:absolute;inset:0;pointer-events:none;background:linear-gradient(102deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%),linear-gradient(258deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%)}
.rl-agents .final>*{position:relative;z-index:2}
.rl-agents .final h2{font-size:clamp(30px,5vw,56px);margin-top:14px}
.rl-agents .final .lede{margin:20px auto 0}
.rl-agents .final .cta-row{justify-content:center}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_agents() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $items = [];
    foreach (rl_agents_list() as $i => $a) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $a[2] . ' Agent', 'url' => function_exists('rl_url_by_path') ? rl_url_by_path('services/agents/' . $a[1], $url) : $url];
    }
    $graph[] = ['@type' => 'ItemList', '@id' => $url . '#agents', 'name' => 'Search Authority OS agents', 'numberOfItems' => count($items), 'itemListElement' => $items];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_agents_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_agents', 'rl_render_agents');
function rl_render_agents() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $pkg = $u('packages');
    $A = [];
    foreach (rl_agents_list() as $a) $A[$a[0]] = $a;
    $idlink = function ($id) use ($A, $u) { return '<a href="' . $u('services/agents/' . $A[$id][1]) . '">' . esc_html($id . ' ' . $A[$id][2]) . '</a>'; };
    ob_start(); ?>
<div class="rl-agents">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Agents</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;Search Authority OS&nbsp;<b>/</b>&nbsp;Agents&nbsp;<b>]</b></span>
    <h1 class="h1">Start with one agent. <span class="r">Scale into the full OS.</span></h1>
    <p class="lede"><strong>Search Authority OS agents</strong> are eight specialised AI agents from Reinforce Lab, each built to deliver one search outcome — from knowing what to rank for to recovering lost rankings. Run one on its own, or combine them into the full <a href="<?php echo $u('search-authority-os'); ?>">Search Authority OS</a>.</p>
    <div class="cta-row">
      <a class="btn p" href="<?php echo $diag; ?>">Find the right agent — free diagnostic <span class="ar">&rarr;</span></a>
      <a class="btn g" href="#agents">See the 8 agents</a>
    </div>
    <ul class="chips" aria-label="Jump to an agent">
      <?php foreach (rl_agents_list() as $a) echo '<li><a href="#' . esc_attr(strtolower($a[0])) . '"><b>' . esc_html($a[0]) . '</b>' . esc_html($a[2]) . '</a></li>'; ?>
    </ul>
  </div>
</section>

<section class="band alt" id="agents">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The agents&nbsp;<b>]</b></span><h2>Eight agents. Eight specific outcomes.</h2><p class="lede">Each agent sells a result, not a tool. Pick the problem you need solved first.</p></div>
    <div class="grid2">
      <?php foreach (rl_agents_list() as $a) { $link = $u('services/agents/' . $a[1]); ?>
      <article class="agent" id="<?php echo esc_attr(strtolower($a[0])); ?>">
        <div class="id"><?php echo esc_html($a[0]); ?></div>
        <h3><a href="<?php echo $link; ?>"><?php echo esc_html($a[2]); ?> Agent</a></h3>
        <p class="out"><?php echo esc_html($a[3]); ?></p>
        <ul><?php foreach ($a[4] as $li) echo '<li>' . esc_html($li) . '</li>'; ?></ul>
        <p class="for"><b>Best for:</b> <?php echo esc_html($a[5]); ?></p>
        <a class="more" href="<?php echo $link; ?>" aria-label="Explore the <?php echo esc_attr($a[2]); ?> Agent">Explore agent &rarr;</a>
      </article>
      <?php } ?>
    </div>
  </div>
</section>

<section id="map">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How they connect&nbsp;<b>]</b></span><h2>Four stages. One loop.</h2><p class="lede">On their own, agents solve one problem. Connected, each stage feeds the next — and performance data feeds the loop back to the start.</p></div>
    <ol class="map">
      <li class="stage"><div class="k" aria-hidden="true">01</div><h3>Understand</h3><p>Demand, competitors and customer voice — before anything is written.</p><div class="ids"><?php echo $idlink('A-01') . $idlink('A-02') . $idlink('A-05') . $idlink('A-06'); ?></div></li>
      <li class="stage"><div class="k" aria-hidden="true">02</div><h3>Verify</h3><p>Every important claim sourced and confidence-scored.</p><div class="ids"><?php echo $idlink('A-03'); ?></div></li>
      <li class="stage"><div class="k" aria-hidden="true">03</div><h3>Optimize &amp; QA</h3><p>Structured for Google and AI answers, then checked before it ships.</p><div class="ids"><?php echo $idlink('A-04') . $idlink('A-07'); ?></div></li>
      <li class="stage"><div class="k" aria-hidden="true">04</div><h3>Measure &amp; heal</h3><p>Performance read continuously; slipping pages diagnosed and fixed.</p><div class="ids"><?php echo $idlink('A-08'); ?></div></li>
    </ol>
  </div>
</section>

<section class="band alt" id="choose">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;One agent or the full OS&nbsp;<b>]</b></span><h2>Where should you start?</h2></div>
    <div class="choose">
      <div class="opt">
        <span class="tag">Start focused</span>
        <h3>A single agent</h3>
        <ul><li>You have one clear, urgent problem</li><li>You want proof before committing to a system</li><li>Your team already covers the other stages</li></ul>
        <a class="btn g" href="<?php echo $diag; ?>">Find your starting agent <span class="ar">&rarr;</span></a>
      </div>
      <div class="opt feat">
        <span class="tag">Compounding</span>
        <h3>The full Search Authority OS</h3>
        <ul><li>You have gaps across research, evidence, AI search and performance</li><li>You want every stage feeding the next</li><li>You need a system that improves month over month</li></ul>
        <a class="btn p" href="<?php echo $pkg; ?>">Compare packages <span class="ar">&rarr;</span></a>
      </div>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About the agents.</h2></div>
    <?php foreach (rl_agents_faqs() as $k => $q) {
        $a = esc_html($q[1]);
        if ($k === 4) $a .= ' <a href="' . $pkg . '">See packages</a>.';
        if ($k === 1) $a .= ' <a href="' . $diag . '">Request the diagnostic</a>.'; ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo $a; ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Not sure which agent you need?</h2>
      <p class="lede">The free diagnostic shows where your biggest search gap is — and which agent or package closes it.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('search-authority-os'); ?>">How Search Authority OS works</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
