<?php
/**
 * Plugin Name: Reinforce Lab - AI Workflow Automation
 * Description: /services/ai-workflow-automation/ (D-023 new URL; no legacy redirects) - AI Workflow Automation service page. Provides [reinforce_aiwork]. Uses the shared kit (D-044). Hero animation "Human in the loop" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_aw() { return is_page('ai-workflow-automation'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_aw_faqs() {
    return [
        ['What is AI workflow automation?', 'AI workflow automation uses AI models together with integrations between your systems to handle repetitive work that involves reading, sorting or writing: triaging emails and tickets, extracting data from documents, drafting replies, updating records. A person reviews anything the AI isn’t confident about, and every step is logged.'],
        ['How is it different from ordinary automation?', 'Traditional automation follows fixed rules: if this, then that. It breaks when the input is messy. AI can read unstructured input (an email, a PDF, a free-text form), classify it and extract what matters, so work that used to need a person can flow automatically, with rules and human checks around it.'],
        ['Which tools do you use?', 'Whatever fits your stack. We usually build on the systems you already have (your CRM, helpdesk, email and document storage) connected through an integration platform and an AI model chosen for the task. The choice is made after mapping the process, not before.'],
        ['Is our data safe?', 'We design for it: only the data a step needs is sent to an AI model, access is limited to the accounts that need it, and we document where each piece of data goes. Sensitive processes can be kept inside your own environment or given a human review step.'],
        ['What does “human in the loop” mean?', 'It means the workflow sends uncertain or high-stakes cases to a person before anything happens, for example, a refund above a limit or an email the AI isn’t sure how to answer. Confident, routine cases go straight through. The threshold is yours to set and change.'],
        ['Does the EU AI Act apply to us?', 'It depends on what the AI does. The Act bans a small set of practices (in force since February 2025) and puts strict duties on high-risk uses such as CV sorting in recruitment, due from December 2027. It also requires that people are made aware when they are talking to a chatbot. Most back-office automation is lower risk, but we check each use case. This is not legal advice.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with AI workflow points (D-047) */
function rl_aw_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Document triage and data extraction with review steps built in', 'Medical-information enquiries routed and drafted for approval', 'Audit trails suited to regulated processes']],
        ['healthcare', 'Healthcare', ['Referral, enquiry and form processing', 'Admin inbox triage that keeps clinicians out of email', 'Patient data minimised and access controlled']],
        ['b2b-saas', 'B2B SaaS', ['Support ticket triage and drafted replies', 'Lead enrichment and routing into the CRM', 'Customer feedback summarised for product teams']],
        ['ecommerce', 'E-commerce', ['Order, return and supplier email handling', 'Product data extracted and cleaned from supplier files', 'Customer-service drafts checked before sending']],
        ['manufacturing', 'Manufacturing', ['Quotes, purchase orders and specs extracted from documents', 'Supplier and order updates synced between systems', 'Service reports summarised automatically']],
        ['technology', 'Technology', ['IT and service-desk triage', 'Knowledge assistants built on your own documentation', 'Release notes and status updates drafted from tickets']],
        ['professional-services', 'Professional Services', ['Client intake and document review workflows', 'Meeting notes turned into actions in your systems', 'Time-consuming admin handed to AI with partner sign-off']],
        ['education', 'Education', ['Admissions enquiry triage and drafted replies', 'Application documents checked and data extracted', 'Student-service questions answered from your own policies']],
    ];
}

/* ---------- hero animation: Human in the loop ----------
   Emails, tickets, invoices and forms arrive; an AI step classifies, extracts and drafts; a confidence
   check sends clear cases straight to your systems and routes uncertain ones to a person, who approves
   them; every step is written to an audit log; capture · process · check · act light in turn. 10 s loop,
   soft fade, reset. */
function rl_aw_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlAwT"><title id="rlAwT">Emails, tickets, invoices and forms pass through an AI step that classifies, extracts and drafts; confident results go straight to your systems, uncertain ones go to a person for approval, and every step is logged.</title>';
    $box = function ($cls, $x, $y, $w, $h, $t) { return '<rect class="w-b" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '"/><rect class="w-on ' . $cls . '" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '"/>' . ($t !== '' ? '<text class="w-t" x="' . ($x + $w / 2) . '" y="' . ($y + $h / 2 + 3.5) . '" text-anchor="middle">' . $t . '</text>' : ''); };
    $edge = function ($cls, $d) { return '<path class="w-e" d="' . $d . '"/>' . ($cls ? '<path class="w-p ' . $cls . '" pathLength="100" d="' . $d . '"/>' : ''); };
    $s .= '<text class="w-lab" x="0" y="20">INPUTS</text>';
    foreach (['EMAILS', 'TICKETS', 'INVOICES', 'FORMS'] as $i => $c) {
        $y = 36 + $i * 44; $cy = $y + 14;
        $s .= $edge('w-i' . $i, 'M92 ' . $cy . ' C112 ' . $cy . ' 108 124 128 124') . $box('w-in' . $i, 0, $y, 92, 28, $c);
    }
    $s .= $box('w-ai', 128, 64, 116, 120, '') . '<text class="w-h" x="140" y="84">AI STEP</text><line class="w-rule" x1="140" y1="92" x2="232" y2="92"/>';
    foreach (['CLASSIFY', 'EXTRACT', 'DRAFT'] as $i => $c) {
        $y = 112 + $i * 22;
        $s .= '<rect class="w-sq" x="140" y="' . ($y - 8) . '" width="9" height="9"/><rect class="w-sqon w-r' . $i . '" x="140" y="' . ($y - 8) . '" width="9" height="9"/><text class="w-ct" x="156" y="' . $y . '">' . $c . '</text>';
    }
    $s .= $edge('w-g0', 'M244 124 H264');
    $s .= '<polygon class="w-b" points="300,100 336,124 300,148 264,124"/><polygon class="w-on w-gt" points="300,100 336,124 300,148 264,124"/><text class="w-t" x="300" y="127.5" text-anchor="middle">SURE?</text>';
    $s .= '<text class="w-y" x="346" y="116">YES</text><text class="w-n" x="308" y="168">NO</text>';
    $s .= $edge('w-g1', 'M336 124 H406') . $edge('w-g2', 'M300 148 V216 H330') . $edge('w-g3', 'M450 216 H470 V184');
    $s .= $box('w-sys', 406, 64, 114, 120, '') . '<text class="w-h" x="418" y="84">YOUR SYSTEMS</text><line class="w-rule" x1="418" y1="92" x2="508" y2="92"/>';
    foreach (['CRM', 'ERP', 'HELPDESK'] as $i => $c) $s .= '<text class="w-ct" x="418" y="' . (114 + $i * 22) . '">' . $c . '</text>';
    $s .= $box('w-hr', 330, 200, 120, 32, 'HUMAN REVIEW') . '<text class="w-ok" x="390" y="250" text-anchor="middle">APPROVED</text>';
    $s .= '<text class="w-lab" x="0" y="286">AUDIT LOG · EVERY STEP RECORDED</text>';
    for ($i = 0; $i < 14; $i++) $s .= '<rect class="w-log" x="' . ($i * 37.5) . '' . '" y="294" width="31" height="10"/><rect class="w-logon w-l' . $i . '" x="' . ($i * 37.5) . '" y="294" width="31" height="10"/>';
    $s .= '<line class="w-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['CAPTURE', 'PROCESS', 'CHECK', 'ACT'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="w-ft" x="' . $x . '" y="372">' . $f . '</text><text class="w-ft w-fton w-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="w-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="w-fbon w-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_aw_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 4; $i++) { $s = 2 + $i * 2; $k .= $lit("rlawIn$i", $s, $s + 2) . $pul("rlawI$i", $s + 1, $s + 8) . ".rl-aw .w-in$i{animation-name:rlawIn$i}.rl-aw .w-i$i{animation-name:rlawI$i}\n"; }
    $k .= $lit('rlawAi', 12, 14);
    for ($i = 0; $i < 3; $i++) { $s = 14 + $i * 3; $k .= $lit("rlawR$i", $s, $s + 2) . ".rl-aw .w-r$i{animation-name:rlawR$i}\n"; }
    $k .= $pul('rlawG0', 23, 27) . $lit('rlawGt', 27, 29) . $pul('rlawG1', 30, 36) . $lit('rlawSys', 36, 38) . $pul('rlawG2', 42, 49) . $lit('rlawHr', 49, 51) . $lit('rlawOk', 55, 57) . $pul('rlawG3', 58, 64);
    $k .= ".rl-aw .w-ai{animation-name:rlawAi}.rl-aw .w-gt{animation-name:rlawGt}.rl-aw .w-sys{animation-name:rlawSys}.rl-aw .w-hr{animation-name:rlawHr}.rl-aw .w-ok{animation-name:rlawOk}";
    foreach ([0, 1, 2, 3] as $i) $k .= ".rl-aw .w-g$i{animation-name:rlawG$i}";
    $k .= "\n";
    $t = [4, 8, 12, 16, 19, 22, 28, 36, 44, 50, 56, 62, 66, 70];
    foreach ($t as $i => $s) $k .= $lit("rlawL$i", $s, $s + 1) . ".rl-aw .w-l$i{animation-name:rlawL$i}\n";
    foreach ([2, 12, 27, 36] as $i => $s) $k .= $lit("rlawF$i", $s, $s + 3) . "@keyframes rlawFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-aw .w-f$i{animation-name:rlawF$i}.rl-aw .w-fb$i{animation-name:rlawFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_aw()) $c[] = 'rl-aw-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_aw(); });
add_action('wp_head', 'rl_aw_css', 22);
function rl_aw_css() {
    if (!rl_is_aw()) return; ?>
<style id="rl-aw-css">
body.rl-aw-page .fl-page-content,body.rl-aw-page .fl-content,body.rl-aw-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-aw .awf{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-aw .awf .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-aw .awf .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-aw .awf svg{display:block;width:100%;height:auto;overflow:visible}
.rl-aw .w-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-aw .w-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-aw .w-t{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.1em;fill:var(--ink-dim)}
.rl-aw .w-h{font-family:var(--f-display);font-weight:600;font-size:11.5px;letter-spacing:.08em;fill:var(--ink)}
.rl-aw .w-rule{stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-aw .w-sq{fill:none;stroke:rgba(243,237,230,.2);stroke-width:.8}
.rl-aw .w-sqon{fill:var(--red-2);opacity:0}
.rl-aw .w-ct{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-aw .w-y,.rl-aw .w-n{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--red-3)}
.rl-aw .w-n{fill:var(--ink-faint)}
.rl-aw .w-ok{font-family:var(--f-mono);font-size:8px;letter-spacing:.16em;fill:var(--red-3);opacity:0}
.rl-aw .w-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-aw .w-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-aw .w-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-aw .w-log{fill:rgba(255,255,255,.04);stroke:rgba(243,237,230,.08);stroke-width:.6}
.rl-aw .w-logon{fill:rgba(194,26,26,.4);stroke:rgba(226,59,59,.6);stroke-width:.6;opacity:0}
.rl-aw .w-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-aw .w-fton{fill:var(--ink);opacity:0}
.rl-aw .w-fb{fill:rgba(255,255,255,.08)}
.rl-aw .w-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-aw .w-on,.rl-aw .w-sqon,.rl-aw .w-ok,.rl-aw .w-p,.rl-aw .w-logon,.rl-aw .w-fton,.rl-aw .w-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-aw .w-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-aw .w-t,.rl-aw .w-ct{font-size:9.5px;letter-spacing:0}.rl-aw .w-h{font-size:12.5px}.rl-aw .w-lab{font-size:9.5px;letter-spacing:.06em}.rl-aw .w-ft{font-size:11px;letter-spacing:.04em}.rl-aw .awf .cap span+span{display:none}.rl-aw .awf{padding:16px 10px 10px}}
<?php echo rl_aw_kf(); ?>
.rl-aw .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-aw .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_aw() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'AI Workflow Automation', 'alternateName' => ['AI automation services', 'AI business process automation'],
        'serviceType' => 'AI workflow automation', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'AI workflow automation for operations, sales, marketing and service: triage, document extraction, drafting and system updates built on your existing tools, with human review for uncertain cases, logging, testing and data minimisation.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_aw_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_aiwork', 'rl_render_aiwork');
function rl_render_aiwork() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $mck = esc_url('https://www.mckinsey.com/capabilities/quantumblack/our-insights/the-state-of-ai');
    $eu = esc_url('https://digital-strategy.ec.europa.eu/en/policies/regulatory-framework-ai');
    $nist = esc_url('https://www.nist.gov/itl/ai-risk-management-framework');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-aw">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">AI Workflow Automation</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;AI Workflow Automation&nbsp;<b>]</b></span>
      <h1 class="h1">Let AI do<br>the busywork.<br><span class="r">Keep control.</span></h1>
      <p class="lede"><strong>AI workflow automation</strong> uses AI models and integrations to handle repetitive work that involves reading, sorting and writing: triaging emails and tickets, extracting data from documents, drafting replies, updating your CRM, with a person approving anything the AI isn't sure about. Reinforce Lab maps your processes, builds the workflows on the tools you already use, and runs them with testing, logging and human checkpoints built in.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#guardrails">Our guardrails</a>
      </div>
    </div>
    <figure class="awf rl-anim">
      <div class="cap" aria-hidden="true"><span>AI workflow</span><span>Capture · process · check · act</span></div>
      <?php echo rl_aw_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we automate&nbsp;<b>]</b></span><h2>What can AI workflow automation do?</h2><p class="lede">The repetitive work between your systems, where people copy, sort, summarise and chase.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Triage</span><h3>Inbox &amp; ticket triage</h3><p>Emails and tickets read, categorised, prioritised and routed to the right person or queue.</p></div>
      <div class="cell"><span class="n">02 · Extract</span><h3>Document data extraction</h3><p>Invoices, forms, orders and contracts turned into structured data in your systems.</p></div>
      <div class="cell"><span class="n">03 · Draft</span><h3>Drafted replies</h3><p>Responses drafted from your policies and history, sent after review where it matters.</p></div>
      <div class="cell"><span class="n">04 · Update</span><h3>CRM &amp; record updates</h3><p>Records created and updated from emails, calls and forms. No more copy and paste.</p></div>
      <div class="cell"><span class="n">05 · Enrich</span><h3>Lead enrichment &amp; routing</h3><p>New leads researched, scored and routed to sales with the context they need.</p></div>
      <div class="cell"><span class="n">06 · Summarise</span><h3>Reports &amp; summaries</h3><p>Meetings, threads and data summarised into the updates people actually read.</p></div>
      <div class="cell"><span class="n">07 · Answer</span><h3>Knowledge assistants</h3><p>Answers drawn from your own documents and policies, with sources shown.</p></div>
      <div class="cell"><span class="n">08 · Content</span><h3>Content operations</h3><p>Briefs, first drafts, metadata and checks inside a reviewed content workflow.</p></div>
      <div class="cell"><span class="n">09 · Connect</span><h3>System handoffs</h3><p>Work passed between CRM, helpdesk, finance and email without anyone re-keying it.</p></div>
    </div>
  </div>
</section>

<section id="state">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Why AI projects stall&nbsp;<b>]</b></span><h2>Why do so many AI projects stall at the pilot?</h2><p class="lede">Almost everyone uses AI. Few have built it into how work actually flows. McKinsey's 2025 global survey shows the gap.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">88%</span><h3>Use AI somewhere</h3><p>of respondents say their organisation regularly uses AI in at least one business function, up from 78% a year earlier.</p></div>
      <div class="metric"><span class="num">62%</span><h3>Trying AI agents</h3><p>say their organisation is at least experimenting with AI agents.</p></div>
      <div class="metric"><span class="num">39%</span><h3>See profit impact</h3><p>report any impact on EBIT at the enterprise level from AI.</p></div>
    </div>
    <p class="quote">The organisations getting the most value are redesigning their workflows, not just adding AI tools to them. That is where we start.</p>
    <p class="src">Source: McKinsey, <a href="<?php echo $mck; ?>" rel="noopener" target="_blank">The state of AI in 2025: Agents, innovation, and transformation</a> (November 2025)</p>
  </div>
</section>

<section class="band alt" id="guardrails">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Guardrails&nbsp;<b>]</b></span><h2>How do we keep AI automation safe?</h2><p class="lede">Six controls in every workflow we build. We use the NIST AI Risk Management Framework (govern, map, measure, manage) as our checklist.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · People</span><h3>Human in the loop</h3><p>Uncertain or high-stakes cases go to a person before anything happens.</p></div>
      <div class="cell"><span class="n">02 · Thresholds</span><h3>Confidence limits</h3><p>Clear rules for what runs automatically, set by you and easy to change.</p></div>
      <div class="cell"><span class="n">03 · Logging</span><h3>Audit trail</h3><p>Every input, decision and action recorded, so you can see what happened and why.</p></div>
      <div class="cell"><span class="n">04 · Testing</span><h3>Tested on real cases</h3><p>Workflows checked against real examples before launch and monitored after.</p></div>
      <div class="cell"><span class="n">05 · Data</span><h3>Minimum data, limited access</h3><p>Only what each step needs is shared, and only the right accounts can see it.</p></div>
      <div class="cell"><span class="n">06 · Disclosure</span><h3>Honest with people</h3><p>Anyone talking to an AI assistant is told so, as the EU AI Act requires for chatbots.</p></div>
    </div>
    <p class="quote">"When using AI systems such as chatbots, humans should be made aware that they are interacting with a machine so they can take an informed decision."<br>European Commission, AI Act</p>
    <p class="src">Sources: European Commission, <a href="<?php echo $eu; ?>" rel="noopener" target="_blank">AI Act</a> · NIST, <a href="<?php echo $nist; ?>" rel="noopener" target="_blank">AI Risk Management Framework</a>. Not legal advice.</p>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does an AI automation project run?</h2><p class="lede">One workflow at a time, measured against how it works today.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Map</h3><p>How the work is done today: steps, systems, volumes, exceptions and time spent.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Prioritise</h3><p>The workflows with the most volume, the least risk and the clearest rules first.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Pilot</h3><p>One workflow built with human review on every case until it proves itself.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Measure</h3><p>Time saved, accuracy and override rate against the baseline.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Scale</h3><p>Automation widened where it earns trust, then handed over with documentation.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Process map</b>: how the work flows today and where time goes.</li>
      <li><b>Automation roadmap</b>: workflows ranked by value, effort and risk.</li>
      <li><b>Built workflows</b>: integrations, AI steps, rules and review queues.</li>
      <li><b>Test set</b>: real examples each workflow is checked against.</li>
      <li><b>Guardrails</b>: thresholds, logging, access controls and data map.</li>
      <li><b>Documentation</b>: how each workflow works and how to change it.</li>
      <li><b>Team training</b>: so your people can run and improve it.</li>
      <li><b>Monthly report</b>: hours saved, accuracy, overrides and cost per task.</li>
    </ul>
  </div>
</section>

<section id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure AI automation?</h2><p class="lede">Against the baseline we record before anything changes.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Hours saved</h3><p>Time no longer spent on the task, measured against the baseline.</p></div>
      <div class="metric"><h3>Turnaround time</h3><p>How quickly requests are handled from arrival to done.</p></div>
      <div class="metric"><h3>Accuracy</h3><p>Share of cases handled correctly, checked against a sample.</p></div>
      <div class="metric"><h3>Override rate</h3><p>How often people change or reject what the AI did.</p></div>
      <div class="metric"><h3>Cost per task</h3><p>Including AI and platform costs, not just labour saved.</p></div>
      <div class="metric"><h3>Adoption</h3><p>Whether the team actually uses the workflow, week by week.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Not every process should be automated.</h2>
      <p>Some work is rare, high-stakes or depends on judgement that a model can't be trusted with. Automating it creates risk, not savings. We will tell you which processes to leave alone, which to automate fully, and which to automate with a person approving the result, and we measure every workflow against how it worked before.</p>
    </div>
  </div>
</section>

<section id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is AI workflow automation for?</h2><p class="lede">Teams whose people spend hours a week reading, sorting, copying and chasing between systems.</p></div>
    <ul class="inds8">
      <?php foreach (rl_aw_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('AI workflow automation for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section class="band alt" id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with AI workflow automation?</h2><p class="lede">Automation pays off most when strategy, marketing and sales run on the same system.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/executive-ai-consulting', 'Strategy', 'Executive AI Consulting', 'Where AI should (and shouldn’t) go in your business, and in what order.'],
          ['services/marketing-automation', 'Marketing', 'Marketing Automation', 'Nurture, scoring and sales handoff for every lead.'],
          ['services/lead-generation-systems', 'Sales', 'Lead Generation Systems', 'Channels, landing pages, qualification and routing as one system.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Content workflows where AI assists and people write, edit and approve.'],
          ['services/llm-optimization', 'AI visibility', 'LLM Optimization', 'How AI models describe your business to the people asking about it.'],
          ['search-authority-os', 'System', 'Search Authority OS', 'Search, content and automation run as one operating system.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About AI workflow automation.</h2></div>
    <?php foreach (rl_aw_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Where are your people losing hours every week?</h2>
      <p class="lede">The free diagnostic reviews how work and leads flow through your business, and shows where automation would pay off first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services'); ?>">All services</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
