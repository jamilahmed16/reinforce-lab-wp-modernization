<?php
/**
 * Plugin Name: Reinforce Lab - AI Growth Systems
 * Description: /services/ai-growth-systems/ (approved new URL, D-003 / D-006a; page 71). Provides [reinforce_aigrowth]. The umbrella pillar for the locked category (D-008, D-023): what Reinforce Lab builds, the four layers, the systems by use case, how an engagement runs. Primary keyword "ai growth systems" (D-130). Facts and prices match Home and Packages. Uses the shared kit (D-044).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_aigrowth() { return is_page('ai-growth-systems'); }

function rl_aigrowth_faqs() {
    return [
        ['What does Reinforce Lab build when it builds an AI Growth System?', 'Four connected layers: a data foundation (your CRM, analytics and search data), AI models for research, writing and classification, automated workflows on tools such as Make or n8n, and a dashboard that reports business outcomes. We configure them around one goal first, such as search visibility, content production or lead follow-up, then extend the same system to the next.'],
        ['How much does an AI Growth System cost?', 'It depends on scope, which is why every engagement starts with a diagnostic. As a guide, Search Authority OS, our flagship system for search and content, starts at $5,000 setup plus $1,500 to $2,500 a month. Automation and lead-generation systems are scoped and priced after the diagnostic.'],
        ['Do I need to replace my current tools?', 'Usually not. We connect the tools you already pay for (your CRM, email platform, Search Console and analytics) and add automation and AI only where they remove manual work.'],
        ['Will AI publish or send things without a person checking?', 'Not where it matters. Each system has approval points: content, claims and anything sent to customers can be set to wait for a person before it goes out. Routine steps, such as tagging leads or updating reports, run on their own and are monitored.'],
        ['How is this different from Search Authority OS?', 'AI Growth Systems is what we build overall. Search Authority OS is our flagship AI Growth System for search and content: it researches your market, verifies claims, produces content and monitors your visibility in Google and AI search. Other systems cover operations, marketing automation and lead handling.'],
        ['Where do we start?', 'With the free Search Authority Diagnostic, or a strategy call. We map where time, traffic and revenue are being lost, then recommend the first system to build and what it should measure.'],
    ];
}

/* systems by use case: [service path, eyebrow, title, what it does, measured by] */
function rl_aigrowth_systems() {
    return [
        ['search-authority-os', 'Search and AI visibility', 'Search Authority OS', 'Researches your market, verifies every claim, produces content and monitors where you appear in Google and AI answers.', 'Visibility, citations, qualified traffic'],
        ['services/seo-content-systems', 'Content', 'Content system', 'Briefs, drafts, evidence checks and quality control run as one production line, with editors approving what ships.', 'Pages published to standard, rankings'],
        ['services/ai-workflow-automation', 'Operations', 'Operations automation', 'AI reads, sorts and drafts: inbox and ticket triage, data extraction from documents, CRM updates and reports.', 'Hours saved, error rate'],
        ['services/marketing-automation', 'Marketing', 'Marketing automation', 'Nurture emails, lead scoring, CRM updates and sales alerts triggered by what each lead actually does.', 'Response time, conversion'],
        ['services/lead-generation-systems', 'Pipeline', 'Lead generation system', 'Turns organic visibility into qualified, routed and tracked enquiries, from first visit to sales conversation.', 'Qualified leads, pipeline value'],
        ['services/executive-ai-consulting', 'Leadership', 'AI strategy and governance', 'Decides which processes to automate first, sets the rules for AI use, and keeps people in charge of the decisions that matter.', 'Roadmap, adoption, risk'],
    ];
}

function rl_aigrowth_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Evidence-checked content with reviewer sign-off', 'Separate journeys for healthcare professionals and patients']],
        ['healthcare', 'Healthcare', ['Patient and provider search visibility', 'Enquiry routing with review steps built in']],
        ['b2b-saas', 'B2B SaaS', ['Search, content and lead routing tied to trials and demos', 'Reporting against pipeline, not traffic']],
        ['ecommerce', 'E-commerce', ['Catalogue content produced and checked at scale', 'Visibility measured against orders']],
        ['manufacturing', 'Manufacturing', ['Technical specifications made findable', 'RFQs routed to the right team faster']],
        ['technology', 'Technology', ['Content for multi-stakeholder buying committees', 'Lead handling across long sales cycles']],
        ['professional-services', 'Professional Services', ['Authority content from named experts', 'Enquiry capture and follow-up for firms']],
        ['education', 'Education', ['Programme visibility for applicant questions', 'Enquiry automation across the enrolment cycle']],
    ];
}

/* hero visual: the four layers feeding three outcomes */
function rl_aigrowth_svg() {
    /* 520 x 392: same proportions as the other service hero visuals (F-024) */
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlAgT"><title id="rlAgT">An AI Growth System: four layers (data, AI models, automated workflows and a dashboard) connected into one loop that produces three outcomes: hours saved, search visibility and qualified pipeline, with people approving what matters.</title>';
    $layers = [['01', 'DATA', 'CRM · ANALYTICS · SEARCH CONSOLE'], ['02', 'AI MODELS', 'RESEARCH · WRITING · CLASSIFYING'], ['03', 'WORKFLOWS', 'MAKE · N8N · YOUR TOOLS'], ['04', 'DASHBOARD', 'OUTCOMES, NOT ACTIVITY']];
    foreach ($layers as $i => $l) {
        $y = 4 + $i * 90;
        $s .= '<rect class="ag-l' . ($i === 3 ? ' ag-on' : '') . '" x="0" y="' . $y . '" width="300" height="70"/>'
            . '<text class="ag-n" x="16" y="' . ($y + 31) . '">' . $l[0] . '</text><text class="ag-t" x="52" y="' . ($y + 31) . '">' . $l[1] . '</text>'
            . '<text class="ag-s" x="52" y="' . ($y + 52) . '">' . $l[2] . '</text>';
        if ($i < 3) $s .= '<line class="ag-k" x1="150" y1="' . ($y + 70) . '" x2="150" y2="' . ($y + 90) . '"/>';
    }
    $s .= '<path class="ag-loop" d="M300 309 H320 V39 H300"/><text class="ag-s" x="330" y="174" transform="rotate(90 330 174)" text-anchor="middle">LOOP: TUNED EVERY CYCLE</text>';
    foreach ([['HOURS SAVED', 66], ['SEARCH VISIBILITY', 174], ['QUALIFIED PIPELINE', 282]] as $o) {
        $s .= '<line class="ag-k" x1="320" y1="' . $o[1] . '" x2="350" y2="' . $o[1] . '"/><rect class="ag-o" x="350" y="' . ($o[1] - 30) . '" width="170" height="60"/><text class="ag-ot" x="366" y="' . ($o[1] + 4) . '">' . $o[0] . '</text>';
    }
    $s .= '<line class="ag-rule" x1="0" y1="362" x2="520" y2="362"/><text class="ag-s ag-ap" x="0" y="385">+ PEOPLE APPROVE WHAT MATTERS</text>';
    return $s . '</svg>';
}

add_filter('body_class', function ($c) { if (rl_is_aigrowth()) $c[] = 'rl-aigrowth-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_aigrowth(); });
add_action('wp_head', function () {
    if (!rl_is_aigrowth()) return; ?>
<style id="rl-aigrowth-css">
body.rl-aigrowth-page .fl-page-content,body.rl-aigrowth-page .fl-content,body.rl-aigrowth-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-aigrowth .agv{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-aigrowth .agv .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-aigrowth .agv .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-aigrowth .agv svg{display:block;width:100%;height:auto}
.rl-aigrowth .ag-l{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-aigrowth .ag-l.ag-on{fill:rgba(153,0,0,.10);stroke:var(--red-2)}
.rl-aigrowth .ag-n{font-family:var(--f-mono);font-size:10px;fill:var(--red-3)}
.rl-aigrowth .ag-t{font-family:var(--f-display);font-size:20px;letter-spacing:.04em;fill:var(--ink)}
.rl-aigrowth .ag-s{font-family:var(--f-mono);font-size:9px;letter-spacing:.12em;fill:var(--ink-faint)}
.rl-aigrowth .ag-k{stroke:var(--line-2);stroke-width:1;stroke-dasharray:3 4}
.rl-aigrowth .ag-loop{fill:none;stroke:var(--red-2);stroke-width:1.4}
.rl-aigrowth .ag-o{fill:var(--bg);stroke:var(--red-line);stroke-width:1}
.rl-aigrowth .ag-rule{stroke:var(--line-2);stroke-width:1}
.rl-aigrowth .ag-ap{fill:var(--red-3)}
.rl-aigrowth .ag-ot{font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;fill:var(--ink)}
.rl-aigrowth .lay{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin:0;padding:0;list-style:none}
.rl-aigrowth .lay li{border:1px solid var(--line-2);background:var(--bg-2);padding:20px;margin:0;display:grid;gap:8px;align-content:start}
.rl-aigrowth .lay .k{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;color:var(--red-3)}
.rl-aigrowth .lay h3{font-size:21px;margin:0}
.rl-aigrowth .lay p{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-aigrowth .lay .eg{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);border-top:1px solid var(--line);padding-top:10px;margin-top:4px}
.rl-aigrowth .sys .cell .m{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);border-top:1px solid var(--line);padding-top:10px;margin-top:8px;display:block}
.rl-aigrowth .sys .cell .m b{color:var(--red-3);font-weight:500}
.rl-aigrowth .price{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:20px;align-items:center;border:1px solid var(--red-line);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent);padding:22px 24px}
.rl-aigrowth .price p{margin:0;color:var(--ink-dim)}
.rl-aigrowth .price b{font-family:var(--f-display);font-size:30px;color:var(--ink);font-weight:500;display:block;line-height:1.1;margin-bottom:4px}
@media(max-width:1000px){.rl-aigrowth .lay{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:760px){.rl-aigrowth .lay{grid-template-columns:1fr}.rl-aigrowth .price{grid-template-columns:1fr}}
@media(max-width:560px){.rl-aigrowth .agv .cap span+span{display:none}.rl-aigrowth .agv{padding:16px 10px 10px}}
</style>
<?php }, 22);

add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_aigrowth() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'AI Growth Systems', 'serviceType' => 'AI growth systems design and implementation',
        'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Reinforce Lab designs, builds and runs AI Growth Systems: a data foundation, AI models, automated workflows and an outcome dashboard connected into one system for search visibility, content, operations and lead handling, with people approving what matters.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
        'hasOfferCatalog' => ['@type' => 'OfferCatalog', 'name' => 'AI Growth Systems', 'itemListElement' => array_map(function ($s) { return ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $s[2], 'description' => $s[3], 'url' => function_exists('rl_url_by_path') ? rl_url_by_path($s[0], '') : '']]; }, rl_aigrowth_systems())],
    ];
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_aigrowth_faqs())];
    foreach ($graph as &$n) { if (is_array($n) && isset($n['@id']) && $n['@id'] === $url && in_array('WebPage', (array) $n['@type'], true)) $n['citation'] = [['@type' => 'CreativeWork', 'name' => 'NIST AI Risk Management Framework', 'url' => 'https://www.nist.gov/itl/ai-risk-management-framework'], ['@type' => 'CreativeWork', 'name' => 'Google Search Central: guidance about AI-generated content', 'url' => 'https://developers.google.com/search/blog/2023/02/google-search-and-ai-content']]; } unset($n);
    return $graph;
}, 20);

add_shortcode('reinforce_aigrowth', 'rl_render_aigrowth');
function rl_render_aigrowth() {
    if (!rl_is_aigrowth()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-aigrowth">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">AI Growth Systems</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;AI Growth Systems&nbsp;<b>]</b></span>
      <h1 class="h1">AI Growth Systems,<br>built and run<br><span class="r">for your business.</span></h1>
      <p class="lede"><strong>Reinforce Lab designs, builds and runs AI Growth Systems</strong>: your data, AI models, automated workflows and an outcome dashboard connected into one system that researches, publishes, ranks and follows up, while your team approves what matters. We start with the system that removes the most manual work or lost revenue, then extend it.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#systems">See the systems</a>
      </div>
    </div>
    <figure class="agv rl-anim">
      <div class="cap" aria-hidden="true"><span>One system</span><span>Four layers</span></div>
      <?php echo rl_aigrowth_svg(); ?>
      <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Four layers', 'kind' => 'steps', 'items' => ['Data', 'AI models', 'Workflows', 'Dashboard']], ['label' => 'Run as', 'kind' => 'chips', 'items' => ['One loop, tuned every cycle'], 'join' => false], ['label' => 'Outcomes', 'kind' => 'chips', 'items' => [['Hours saved', 'ok'], ['Search visibility', 'ok'], ['Qualified pipeline', 'ok']]], ['label' => 'Control', 'kind' => 'chips', 'items' => ['+ People approve what matters'], 'join' => false]], ''); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="layers">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The four layers&nbsp;<b>]</b></span><h2>What does an AI Growth System include?</h2><p class="lede">Every AI Growth System we build has the same four layers. What changes from one business to the next is the data, the workflows and what the dashboard measures. New to the idea? <a href="<?php echo esc_url(home_url('/what-is-an-ai-growth-system/')); ?>">Read what an AI growth system is</a>.</p></div>
    <ol class="lay">
      <li><span class="k">01 · Data</span><h3>Data foundation</h3><p>Your CRM, analytics, Search Console and content data, cleaned and connected so every later step works from the same facts.</p><span class="eg">Example: one view of each lead, from first search to sales call.</span></li>
      <li><span class="k">02 · AI models</span><h3>AI models</h3><p>Models that research, write, summarise and classify, given clear instructions, your sources and your standards.</p><span class="eg">Example: a researched content brief, with sources, from one topic.</span></li>
      <li><span class="k">03 · Workflows</span><h3>Automated workflows</h3><p>The steps between tools, built on platforms such as Make or n8n and on the tools you already pay for, with approval points where a person should decide.</p><span class="eg">Example: a new enquiry scored, routed and answered within minutes.</span></li>
      <li><span class="k">04 · Dashboard</span><h3>Outcome dashboard</h3><p>Reporting on what the business cares about: hours saved, visibility in Google and AI search, qualified pipeline and revenue.</p><span class="eg">Example: pipeline by source, next to the work that produced it.</span></li>
    </ol>
  </div>
</section>

<section id="systems" class="sys">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Systems by use case&nbsp;<b>]</b></span><h2>Which AI Growth Systems can Reinforce Lab build?</h2><p class="lede">Start with one. Each runs on the same four layers, so the next system connects to the first instead of becoming another separate tool.</p></div>
    <div class="cols c3">
      <?php foreach (rl_aigrowth_systems() as $s) { $l = $ex($s[0]); $in = '<span class="n">' . esc_html($s[1]) . '</span><h3>' . esc_html($s[2]) . '</h3><p>' . esc_html($s[3]) . '</p><span class="m"><b>Measured by</b> ' . esc_html($s[4]) . '</span>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="band alt" id="engagement">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Engagement&nbsp;<b>]</b></span><h2>How does an AI Growth Systems engagement run?</h2><p class="lede">Four stages, run as a loop. You approve the design before anything is built, and the system is judged on the outcomes agreed at the start.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Diagnose</h3><p>We map your website, search visibility, content, workflows and funnel, and find where time, traffic and revenue are being lost.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Architect</h3><p>We design the system: which workflows to automate, which searches to own, which data feeds which decision, and where people approve.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Build and automate</h3><p>We build the workflows, pages, content engine and integrations on your accounts, test them, and train your team on the approval steps.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Measure and improve</h3><p>We track the agreed outcomes, fix what slips, and tune the system every cycle. Then we extend it to the next use case.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What do you get?</h2></div>
    <ul class="ticks">
      <li><b>Diagnostic and baseline</b>: where time, traffic and revenue are lost today, with the numbers to measure against.</li>
      <li><b>System design</b>: the workflows, data flows, AI steps and approval points, agreed with you before the build.</li>
      <li><b>The working system</b>: built, tested and documented on your accounts.</li>
      <li><b>Approval steps</b>: who checks what, before content, claims or customer messages go out.</li>
      <li><b>Outcome dashboard</b>: hours saved, visibility, pipeline and revenue, in one place.</li>
      <li><b>Monthly review</b>: what moved, what slipped, and the next improvement.</li>
    </ul>
    <div class="price" style="margin-top:22px">
      <p><b>From $5,000 setup</b>Search Authority OS, our flagship system for search and content, starts at $5,000 setup plus $1,500 to $2,500 a month. Other systems are scoped and priced after the diagnostic.</p>
      <a class="btn g" href="<?php echo $u('packages'); ?>">See the packages <span class="ar">&rarr;</span></a>
    </div>
  </div>
</section>

<section class="band alt" id="compare">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Compare&nbsp;<b>]</b></span><h2>How is an AI Growth System different from an agency or more AI tools?</h2></div>
    <div class="tscroll" role="region" aria-label="AI Growth System compared with an agency retainer and buying AI tools" tabindex="0">
      <table>
        <thead><tr><th scope="col"><span style="position:absolute;left:-9999px">Aspect</span></th><th scope="col">Agency retainer</th><th scope="col">More AI tools</th><th scope="col" class="us">AI Growth System</th></tr></thead>
        <tbody>
          <tr><th scope="row">What you pay for</th><td>Hours and deliverables</td><td>Subscriptions, one per task</td><td class="us">A system built once, then run and improved</td></tr>
          <tr><th scope="row">How the work connects</th><td>Hand-offs between people</td><td>Copy and paste between tools</td><td class="us">Shared data and automated workflows</td></tr>
          <tr><th scope="row">Who checks quality</th><td>The agency</td><td>Whoever uses the tool</td><td class="us">Set approval points, owned by your team</td></tr>
          <tr><th scope="row">What is reported</th><td>Activity</td><td>Usage</td><td class="us">Hours saved, visibility, pipeline, revenue</td></tr>
          <tr><th scope="row">When you add the next goal</th><td>A new scope and retainer</td><td>Another tool</td><td class="us">A new workflow on the same foundation</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Automation without oversight is a liability.</h2>
      <p>AI models make mistakes, and an automated workflow repeats a mistake at speed. That is why every system we build keeps people in charge of the decisions that matter, logs what the AI did, and is monitored after launch. The NIST AI Risk Management Framework asks the same of any organisation using AI, and Google judges content by its quality, not by whether AI helped write it.</p>
      <p class="src">Sources: <a href="https://www.nist.gov/itl/ai-risk-management-framework" rel="noopener" target="_blank">NIST: AI Risk Management Framework</a> · <a href="https://developers.google.com/search/blog/2023/02/google-search-and-ai-content" rel="noopener" target="_blank">Google Search Central Blog: guidance about AI-generated content</a></p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who are AI Growth Systems for?</h2><p class="lede">Growth-stage and established businesses whose marketing, search and operations run on separate tools and manual hand-offs. The same system is configured for each industry's buyers and rules.</p></div>
    <ul class="inds8">
      <?php foreach (rl_aigrowth_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('AI Growth Systems for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>What do people ask about AI Growth Systems?</h2></div>
    <?php foreach (rl_aigrowth_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Find the first system worth building.</h2>
      <p class="lede">The free Search Authority Diagnostic shows where time, traffic and revenue are being lost, and which system to build first.</p>
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
