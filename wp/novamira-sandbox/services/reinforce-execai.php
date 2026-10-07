<?php
/**
 * Plugin Name: Reinforce Lab - Executive AI Consulting
 * Description: /services/executive-ai-consulting/ (D-023 new URL; 301 target for the legacy /services/business-consultancy-service/) - Executive AI Consulting service page. Provides [reinforce_execai]. Uses the shared kit (D-044). Hero animation "Matrix to roadmap" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_ex() { return is_page('executive-ai-consulting'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_ex_faqs() {
    return [
        ['What is executive AI consulting?', 'Executive AI consulting helps a leadership team decide where AI should (and shouldn’t) be used in the business: which use cases are worth funding, what data and governance they need, which regulations apply, and how the return will be measured. The output is a prioritised roadmap the board can approve and the business can act on.'],
        ['Why do so many AI projects fail?', 'Gartner predicted that at least 30% of generative AI projects would be abandoned after proof of concept by the end of 2025, because of poor data quality, inadequate risk controls, escalating costs or unclear business value, and that over 40% of agentic AI projects will be cancelled by the end of 2027. Most failures are decided before the build: the wrong use case, no baseline, or no owner.'],
        ['Does the EU AI Act affect us?', 'If you use or supply AI in the EU, parts of it already apply. AI literacy duties and the prohibited practices have applied since 2 February 2025; transparency rules, such as telling people when they are talking to a chatbot, since 2 August 2026; and rules for high-risk uses listed in Annex III apply from 2 December 2027. We map which of your use cases fall where. This is not legal advice.'],
        ['What is AI literacy under the EU AI Act?', 'Article 4 has applied since 2 February 2025. Since the Digital Omnibus on AI took effect on 27 July 2026, providers and deployers of AI systems must take measures to support the development of AI literacy among the staff and others who operate or use AI on their behalf, reflecting their knowledge, experience and the context of use, without having to guarantee a specific level for any individual. Role-based training is part of every engagement.'],
        ['Do you sell or recommend particular AI tools?', 'We are not resellers. We recommend tools only after the use case, data and risks are clear, and we test vendor claims. Gartner warns of “agent washing”, estimating that only about 130 of the thousands of agentic AI vendors are real.'],
        ['How long does an engagement take?', 'An assessment and roadmap usually takes a few weeks, depending on the size of the business and how many teams are involved. We then support the first pilots so the roadmap turns into measured results, not a slide deck.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with executive AI points (D-047) */
function rl_ex_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['AI use cases mapped against regulatory and quality requirements', 'Governance for medical, legal and regulatory review', 'Vendor due diligence for regulated data']],
        ['healthcare', 'Healthcare', ['Where AI can reduce admin without touching clinical judgement', 'Patient-data and consent questions settled first', 'Staff AI literacy by role']],
        ['b2b-saas', 'B2B SaaS', ['AI in the product versus AI in operations: separate roadmaps', 'Build-versus-buy decisions for AI features', 'Transparency duties for customer-facing AI']],
        ['ecommerce', 'E-commerce', ['Customer-service, content and merchandising use cases ranked', 'Chatbot disclosure and data use planned in', 'Return on AI measured per channel']],
        ['manufacturing', 'Manufacturing', ['Document, quoting and service use cases before the shop floor', 'Data readiness across ERP and legacy systems', 'Safety-related uses separated and governed']],
        ['technology', 'Technology', ['Internal AI use policy for engineering and support', 'Agentic AI pilots with clear value and controls', 'Vendor and model selection without the hype']],
        ['professional-services', 'Professional Services', ['Confidentiality rules for client data and AI tools', 'Knowledge and document work prioritised by value', 'Partner-level governance and sign-off']],
        ['education', 'Education', ['AI in admissions and assessment treated as high-risk where it is', 'Policies for staff and student use', 'Admin automation before academic decisions']],
    ];
}

/* ---------- hero animation: Matrix to roadmap ----------
   AI use cases appear on a value × feasibility matrix; the "do first" quadrant lights; a risk check
   flags one case for governance before it goes ahead; the chosen cases flow into a quarterly roadmap -
   governance, pilot, scale, review; assess · prioritise · govern · roadmap light in turn. 10 s loop,
   soft fade, reset. */
function rl_ex_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlExT"><title id="rlExT">AI use cases are scored for value and feasibility; the best are checked for risk and placed on a quarterly roadmap of governance, pilots, scaling and review.</title>';
    $s .= '<text class="x-lab" x="36" y="14">USE CASES · VALUE × FEASIBILITY</text>';
    $s .= '<rect class="x-q" x="36" y="24" width="264" height="240"/><rect class="x-on x-best" x="168" y="24" width="132" height="120"/>';
    $s .= '<line class="x-ax" x1="168" y1="24" x2="168" y2="264"/><line class="x-ax" x1="36" y1="144" x2="300" y2="144"/>';
    $s .= '<text class="x-ql x-qlon" x="292" y="40" text-anchor="end">DO FIRST</text><text class="x-ql" x="44" y="40">PLAN</text><text class="x-ql" x="292" y="256" text-anchor="end">QUICK WINS</text><text class="x-ql" x="44" y="256">DROP</text>';
    $s .= '<text class="x-axl" x="168" y="282" text-anchor="middle">FEASIBILITY →</text><text class="x-axl" transform="translate(24 144) rotate(-90)" text-anchor="middle">VALUE →</text>';
    $pts = [[250, 60], [96, 84], [272, 110], [214, 190], [120, 214], [206, 82], [260, 226], [80, 170]];
    foreach ($pts as $i => $p) $s .= '<rect class="x-u x-u' . $i . '" x="' . ($p[0] - 7) . '" y="' . ($p[1] - 7) . '" width="14" height="14"/>';
    $s .= '<rect class="x-risk" x="265" y="103" width="14" height="14"/><text class="x-rt" x="272" y="132" text-anchor="middle">RISK CHECK</text>';
    $s .= '<path class="x-e" d="M300 84 H362"/><path class="x-p" pathLength="100" d="M300 84 H362"/>';
    $s .= '<text class="x-lab" x="340" y="14">ROADMAP</text>';
    foreach (['Q1', 'Q2', 'Q3', 'Q4'] as $i => $q) {
        $y = 30 + $i * 58;
        $s .= '<text class="x-qt" x="340" y="' . ($y + 25) . '">' . $q . '</text><rect class="x-lane" x="366" y="' . $y . '" width="154" height="40"/>';
    }
    foreach ([['GOVERNANCE', 366, 104], ['PILOT', 400, 90], ['SCALE', 420, 100], ['REVIEW', 450, 70]] as $i => $b) {
        $y = 30 + $i * 58;
        $s .= '<rect class="x-blk x-b' . $i . '" x="' . $b[1] . '" y="' . ($y + 6) . '" width="' . $b[2] . '" height="28"/><text class="x-bt x-b' . $i . '" x="' . ($b[1] + $b[2] / 2) . '" y="' . ($y + 23.5) . '" text-anchor="middle">' . $b[0] . '</text>';
    }
    $s .= '<line class="x-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['ASSESS', 'PRIORITISE', 'GOVERN', 'ROADMAP'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="x-ft" x="' . $x . '" y="372">' . $f . '</text><text class="x-ft x-fton x-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="x-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="x-fbon x-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_ex_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 8; $i++) { $s = 2 + $i * 2; $k .= $lit("rlexU$i", $s, $s + 2) . ".rl-ex .x-u$i{animation-name:rlexU$i}\n"; }
    /* chosen cases (top-right quadrant) brighten once the quadrant lights */
    foreach ([0, 2, 5] as $i) $k .= ".rl-ex .x-u$i{fill:rgba(194,26,26,.55);stroke:rgba(226,59,59,.9)}\n";
    $k .= $lit('rlexBest', 20, 24) . "@keyframes rlexRisk{0%,28%{opacity:0}30%{opacity:1}36%{opacity:.35}40%,92%{opacity:1}97%,100%{opacity:0}}\n" . $lit('rlexRt', 28, 31);
    $k .= "@keyframes rlexP{0%,40%{stroke-dashoffset:10;opacity:0}41%{opacity:1}45%{opacity:1}46%,100%{stroke-dashoffset:-100;opacity:0}}\n";
    foreach ([46, 51, 56, 61] as $i => $s) $k .= $lit("rlexB$i", $s, $s + 3) . ".rl-ex .x-b$i{animation-name:rlexB$i}\n";
    foreach ([2, 20, 28, 46] as $i => $s) $k .= $lit("rlexF$i", $s, $s + 3) . "@keyframes rlexFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-ex .x-f$i{animation-name:rlexF$i}.rl-ex .x-fb$i{animation-name:rlexFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_ex()) $c[] = 'rl-ex-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_ex(); });
add_action('wp_head', 'rl_ex_css', 22);
function rl_ex_css() {
    if (!rl_is_ex()) return; ?>
<style id="rl-ex-css">
body.rl-ex-page .fl-page-content,body.rl-ex-page .fl-content,body.rl-ex-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-ex .exm{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-ex .exm .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-ex .exm .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-ex .exm svg{display:block;width:100%;height:auto;overflow:visible}
.rl-ex .x-q{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ex .x-on{fill:rgba(153,0,0,.1);stroke:rgba(226,59,59,.6);stroke-width:.8;opacity:0}
.rl-ex .x-best,.rl-ex .x-qlon{animation-name:rlexBest}
.rl-ex .x-ax{stroke:rgba(243,237,230,.14);stroke-width:.8;stroke-dasharray:3 3}
.rl-ex .x-ql{font-family:var(--f-mono);font-size:8px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ex .x-qlon{fill:var(--red-3);opacity:0}
.rl-ex .x-axl{font-family:var(--f-mono);font-size:8px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ex .x-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-ex .x-u{fill:rgba(255,255,255,.1);stroke:rgba(243,237,230,.35);stroke-width:.8;opacity:0}
.rl-ex .x-risk{fill:none;stroke:#fff;stroke-width:1.4;stroke-dasharray:3 2;opacity:0;animation-name:rlexRisk}
.rl-ex .x-rt{font-family:var(--f-mono);font-size:7.5px;letter-spacing:.14em;fill:#fff;opacity:0;animation-name:rlexRt}
.rl-ex .x-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-ex .x-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0;animation-name:rlexP;animation-timing-function:ease-in-out}
.rl-ex .x-qt{font-family:var(--f-mono);font-size:9px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-ex .x-lane{fill:rgba(255,255,255,.025);stroke:rgba(243,237,230,.08);stroke-width:.6}
.rl-ex .x-blk{fill:rgba(153,0,0,.14);stroke:rgba(226,59,59,.7);stroke-width:.8;opacity:0}
.rl-ex .x-bt{font-family:var(--f-mono);font-size:8px;letter-spacing:.12em;fill:#fff;opacity:0}
.rl-ex .x-rule{stroke:var(--line-2);stroke-width:1}
.rl-ex .x-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ex .x-fton{fill:var(--ink);opacity:0}
.rl-ex .x-fb{fill:rgba(255,255,255,.08)}
.rl-ex .x-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-ex .x-on,.rl-ex .x-qlon,.rl-ex .x-u,.rl-ex .x-risk,.rl-ex .x-rt,.rl-ex .x-p,.rl-ex .x-blk,.rl-ex .x-bt,.rl-ex .x-fton,.rl-ex .x-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-ex .x-ql,.rl-ex .x-axl,.rl-ex .x-bt{font-size:9.5px;letter-spacing:.02em}.rl-ex .x-rt{font-size:9px;letter-spacing:0}.rl-ex .x-lab{font-size:9.5px;letter-spacing:.06em}.rl-ex .x-qt{font-size:10.5px}.rl-ex .x-ft{font-size:11px;letter-spacing:.02em}.rl-ex .exm .cap span+span{display:none}.rl-ex .exm{padding:16px 10px 10px}}
<?php echo rl_ex_kf(); ?>
.rl-ex .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_ex() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Executive AI Consulting', 'alternateName' => ['AI strategy consulting', 'AI advisory for leadership teams', 'Business consultancy'],
        'serviceType' => 'AI strategy and governance consulting', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Executive AI consulting for leadership teams: AI opportunity assessment, use-case prioritisation, business cases, data readiness, governance and AI policy, EU AI Act mapping, vendor selection, AI literacy training and a roadmap supported through the first pilots.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_ex_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_execai', 'rl_render_execai');
function rl_render_execai() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $g1 = esc_url('https://www.gartner.com/en/newsroom/press-releases/2024-07-29-gartner-predicts-30-percent-of-generative-ai-projects-will-be-abandoned-after-proof-of-concept-by-end-of-2025');
    $g2 = esc_url('https://www.gartner.com/en/newsroom/press-releases/2025-06-25-gartner-predicts-over-40-percent-of-agentic-ai-projects-will-be-canceled-by-end-of-2027');
    $mck = esc_url('https://www.mckinsey.com/capabilities/quantumblack/our-insights/the-state-of-ai');
    $tl = esc_url('https://ai-act-service-desk.ec.europa.eu/en/ai-act/timeline/timeline-implementation-eu-ai-act');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-ex">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Executive AI Consulting</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Executive AI Consulting&nbsp;<b>]</b></span>
      <h1 class="h1">An AI strategy<br>your board<br><span class="r">can act on.</span></h1>
      <p class="lede"><strong>Executive AI consulting</strong> helps leadership teams decide where AI should (and shouldn't) go in their business: which use cases are worth funding, what data and governance they need, which regulations apply, and how the return will be measured. Reinforce Lab delivers a prioritised roadmap with the guardrails to match, then helps turn the first projects into measured results.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#ai-act">EU AI Act dates</a>
      </div>
    </div>
    <figure class="exm rl-anim">
      <div class="cap" aria-hidden="true"><span>AI strategy</span><span>Assess · prioritise · govern · roadmap</span></div>
      <?php echo rl_ex_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Use cases · value × feasibility', 'kind' => 'chips', 'items' => [['Do first', 'hi'], 'Plan', 'Quick wins', ['Drop', 'dim']]], ['label' => 'Then', 'kind' => 'rows', 'items' => ['Risk check']], ['label' => 'Roadmap', 'kind' => 'steps', 'items' => ['Q1', 'Q2', 'Q3', 'Q4']], ['label' => 'Governance', 'kind' => 'steps', 'items' => ['Pilot', 'Scale', 'Review']]], 'Assess · prioritise · govern'); ?></figure>
  </div>
</section>

<section class="band alt" id="why">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Why AI projects fail&nbsp;<b>]</b></span><h2>Why do so many AI initiatives fail?</h2><p class="lede">Rarely because the technology doesn't work. Usually because of decisions made before anything was built.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">30%</span><h3>Abandoned after the pilot</h3><p>of generative AI projects, Gartner predicted, would be abandoned after proof of concept by the end of 2025, for poor data, weak risk controls, rising costs or unclear value.</p></div>
      <div class="metric"><span class="num">40%+</span><h3>Agentic projects cancelled</h3><p>of agentic AI projects will be cancelled by the end of 2027, Gartner predicts, and only about 130 of thousands of "agentic" vendors are real.</p></div>
      <div class="metric"><span class="num">39%</span><h3>See profit impact</h3><p>of organisations report any enterprise-level EBIT impact from AI, in McKinsey's 2025 global survey.</p></div>
    </div>
    <p class="src">Sources: Gartner, <a href="<?php echo $g1; ?>" rel="noopener" target="_blank">July 2024</a> and <a href="<?php echo $g2; ?>" rel="noopener" target="_blank">June 2025</a> press releases · McKinsey, <a href="<?php echo $mck; ?>" rel="noopener" target="_blank">The state of AI in 2025</a></p>
  </div>
</section>

<section id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we do&nbsp;<b>]</b></span><h2>What does executive AI consulting cover?</h2><p class="lede">The decisions a leadership team has to own, made with evidence, not hype.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Opportunities</span><h3>AI opportunity assessment</h3><p>Where AI could save time, reduce cost or create revenue across your functions.</p></div>
      <div class="cell"><span class="n">02 · Priorities</span><h3>Use-case prioritisation</h3><p>Every idea scored for value, feasibility and risk, so the first projects are the right ones.</p></div>
      <div class="cell"><span class="n">03 · Value</span><h3>Business cases</h3><p>Costs, benefits and a baseline for each priority, so the return can actually be measured.</p></div>
      <div class="cell"><span class="n">04 · Data</span><h3>Data readiness</h3><p>Whether the data each use case needs exists, is good enough and can be used lawfully.</p></div>
      <div class="cell"><span class="n">05 · Governance</span><h3>AI policy &amp; governance</h3><p>Who approves AI use, what staff may use, and how risk is reviewed, using the NIST AI RMF as a checklist.</p></div>
      <div class="cell"><span class="n">06 · Regulation</span><h3>EU AI Act mapping</h3><p>Your role and duties for each use case: provider or deployer, transparency, high-risk or not.</p></div>
      <div class="cell"><span class="n">07 · Vendors</span><h3>Tool &amp; vendor selection</h3><p>Independent assessment of tools and vendors against your use cases, not their marketing.</p></div>
      <div class="cell"><span class="n">08 · People</span><h3>AI literacy &amp; training</h3><p>Role-based training for leaders and staff: the measures the AI Act asks organisations to take.</p></div>
      <div class="cell"><span class="n">09 · Roadmap</span><h3>Roadmap &amp; operating model</h3><p>What happens in what order, who owns it and how progress is reported to the board.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="ai-act">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;EU AI Act&nbsp;<b>]</b></span><h2>What does the EU AI Act already require?</h2><p class="lede">More than most leadership teams realise. The Act applies in stages, several of them already in force.</p></div>
    <div class="tscroll" role="region" aria-label="EU AI Act application timeline" tabindex="0">
      <table>
        <thead><tr><th scope="col">Date</th><th scope="col">What applies</th><th scope="col">What it means for you</th></tr></thead>
        <tbody>
          <tr><th scope="row">1 Aug 2024</th><td>The AI Act enters into force</td><td>The clock starts on every later deadline.</td></tr>
          <tr><th scope="row">2 Feb 2025</th><td>Definitions, AI literacy and prohibited practices</td><td>Banned practices must stop; organisations must act on AI literacy for staff using AI.</td></tr>
          <tr><th scope="row">2 Aug 2025</th><td>Rules for general-purpose AI models; governance in place</td><td>Mainly model providers, but it shapes the tools you buy.</td></tr>
          <tr><th scope="row">27 Jul 2026</th><td>Digital Omnibus on AI amends the Act</td><td>AI-literacy duty becomes: take measures to support it, no guaranteed individual level; some deadlines move.</td></tr>
          <tr><th scope="row">2 Aug 2026</th><td>Most rules apply, including transparency (Article 50); enforcement starts</td><td>Tell people when they're talking to a chatbot or seeing AI-generated content.</td></tr>
          <tr><th scope="row">2 Dec 2027</th><td>Rules for high-risk AI systems listed in Annex III</td><td>Uses such as CV screening need risk management, documentation and human oversight.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="src">Source: European Commission AI Act Service Desk, <a href="<?php echo $tl; ?>" rel="noopener" target="_blank">Timeline for the implementation of the EU AI Act</a> (reflecting the Digital Omnibus on AI, Regulation (EU) 2026/1744). Not legal advice.</p>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does an engagement run?</h2><p class="lede">From a list of ideas to a board decision, then to the first measured results.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Discover</h3><p>Interviews with leaders and teams; a review of processes, data and current AI use.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Assess</h3><p>Opportunities scored for value, feasibility and risk, with a baseline for each.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Decide</h3><p>A leadership workshop to agree priorities, budget, owners and guardrails.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Pilot</h3><p>The first one or two projects delivered and measured against the business case.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Govern &amp; scale</h3><p>What works is scaled; what doesn't is stopped early, both reported to the board.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>AI opportunity map</b>: ideas from across the business, in one place.</li>
      <li><b>Prioritised roadmap</b>: scored for value, feasibility and risk, with owners.</li>
      <li><b>Business cases</b>: costs, benefits and baselines for the priorities.</li>
      <li><b>AI use policy</b>: what staff may use, how, and who approves.</li>
      <li><b>Risk &amp; regulation register</b>: EU AI Act role and duties per use case.</li>
      <li><b>Vendor shortlist</b>: tools assessed against your requirements.</li>
      <li><b>Leadership workshop</b>: priorities and guardrails agreed by the people accountable.</li>
      <li><b>First-90-days plan</b>: the pilots, their measures and their owners.</li>
    </ul>
  </div>
</section>

<section id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure AI strategy?</h2><p class="lede">By what the business gets out of it, including the projects it was right to stop.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Value against the business case</h3><p>Savings or revenue delivered compared with what was approved.</p></div>
      <div class="metric"><h3>Time to first result</h3><p>How long from decision to a measured pilot outcome.</p></div>
      <div class="metric"><h3>Projects stopped early</h3><p>Weak ideas stopped before they became expensive, a success, not a failure.</p></div>
      <div class="metric"><h3>Adoption</h3><p>Whether people actually use the AI tools that were rolled out.</p></div>
      <div class="metric"><h3>Risk &amp; incidents</h3><p>Issues found by review before launch, and incidents after it.</p></div>
      <div class="metric"><h3>AI literacy coverage</h3><p>Share of staff trained for the way they use AI in their role.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Sometimes the answer is "not yet".</h2>
      <p>If the data isn't there, the process isn't stable or the risk outweighs the return, the right decision is to wait, or to fix the foundations first. We would rather tell a board that than sell it a pilot destined to join the abandoned ones. Our job is a strategy you can defend, not the biggest possible AI budget.</p>
    </div>
  </div>
</section>

<section id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is executive AI consulting for?</h2><p class="lede">Founders, CEOs and leadership teams who need to decide what AI means for their business, and be able to explain that decision.</p></div>
    <ul class="inds8">
      <?php foreach (rl_ex_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Explore: Executive AI consulting for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section class="band alt" id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What turns the strategy into results?</h2><p class="lede">The roadmap is delivered through these services.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/ai-workflow-automation', 'Operations', 'AI Workflow Automation', 'The first automations built with human review, logging and testing.'],
          ['services/marketing-automation', 'Marketing', 'Marketing Automation', 'Nurture, scoring and sales handoff for every lead.'],
          ['services/lead-generation-systems', 'Sales', 'Lead Generation Systems', 'Channels, qualification and closed-loop measurement as one system.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'How your brand shows up when buyers ask AI tools.'],
          ['services/llm-optimization', 'AI visibility', 'LLM Optimization', 'How AI models describe your business.'],
          ['search-authority-os', 'System', 'Search Authority OS', 'Search, content and automation run as one operating system.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About executive AI consulting.</h2></div>
    <?php foreach (rl_ex_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Is your AI plan ready for the board?</h2>
      <p class="lede">Start with the free diagnostic: a review of where you stand today and where AI and automation would pay off first.</p>
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
