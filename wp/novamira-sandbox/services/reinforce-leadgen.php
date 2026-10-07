<?php
/**
 * Plugin Name: Reinforce Lab - Lead Generation Systems
 * Description: /services/lead-generation-systems/ (D-023 new URL; 301 target for the legacy /services/ppc-management-services/) - Lead Generation Systems service page. Provides [reinforce_leadgen]. Uses the shared kit (D-044). Hero animation "Closed loop" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_lg() { return is_page('lead-generation-systems'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_lg_faqs() {
    return [
        ['What is a lead generation system?', 'A lead generation system connects every step between a buyer’s first search and a closed deal: the channels that attract them, the landing pages and forms that convert them, the qualification and routing that get the right leads to sales quickly, and the closed-loop data that shows which campaigns created revenue, so budget moves to what works.'],
        ['Do you manage PPC and Google Ads?', 'Yes. Paid search is usually one of the channels in the system. We structure campaigns, manage keywords and negatives, write and test ads, build the landing pages, set up conversion tracking and bid on the value of leads, using what happens in your CRM after the form fill.'],
        ['What is closed-loop reporting?', 'Closed-loop reporting connects a lead’s source to what happened next in your CRM: qualified, opportunity, won or lost. Google Ads can import these offline conversions, so bidding learns which searches produce customers rather than just enquiries.'],
        ['Should we chase a better Quality Score?', 'Not directly. Google describes Quality Score as a diagnostic tool, not a key performance indicator, and says it is not an input in the ad auction. Its three components (expected click-through rate, ad relevance and landing page experience) are useful clues about what to improve.'],
        ['Do we need Consent Mode?', 'If you advertise to users in the European Economic Area and use Google’s measurement or personalisation features, Google requires consent signals to be collected and passed on. Consent Mode’s ad_user_data setting is required for measurement uses such as enhanced conversions. We set this up with your consent platform.'],
        ['How is lead generation priced?', 'Scope and pricing are agreed after an audit of your current channels, tracking and CRM. Media spend is paid to the ad platforms and reported separately from management fees, so you can always see what the media itself cost.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with lead generation points (D-047) */
function rl_lg_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['B2B and partnering lead programmes within advertising rules', 'Event and congress lead capture with consent', 'Enquiries routed to the right medical or commercial team']],
        ['healthcare', 'Healthcare', ['Appointment and enquiry funnels per service and location', 'Ad and landing-page claims kept within healthcare policies', 'Call and form tracking back to booked patients']],
        ['b2b-saas', 'B2B SaaS', ['Demo and trial funnels measured to pipeline, not sign-ups', 'Paid search on high-intent and competitor terms', 'Product-qualified leads routed to sales automatically']],
        ['ecommerce', 'E-commerce', ['Wholesale and B2B enquiry funnels alongside retail', 'Shopping and search campaigns bid on value', 'Landing pages built for each product line']],
        ['manufacturing', 'Manufacturing', ['Quote and specification-request funnels', 'Routing by region, product and distributor', 'Long-cycle tracking from enquiry to order']],
        ['technology', 'Technology', ['Account-focused campaigns for target companies', 'Webinar and content offers that qualify interest', 'Closed-loop reporting from CRM opportunities']],
        ['professional-services', 'Professional Services', ['Practice-area landing pages for high-value searches', 'Consultation requests qualified before a partner call', 'Referral and search leads measured side by side']],
        ['education', 'Education', ['Programme enquiry funnels by course and market', 'Open-day and event registration tracked to applications', 'Consent-compliant campaigns for each region']],
    ];
}

/* ---------- hero animation: Closed loop ----------
   Four channels send visitors to a landing page and form; a qualification step sends sales-ready
   leads to sales and the rest to nurture; a closed deal is fed back as conversion data to the paid
   channel's bidding - the loop closes; attract · convert · qualify · close the loop light in turn.
   10 s loop, soft fade, reset. */
function rl_lg_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlLgT"><title id="rlLgT">Search, paid ads, content and referrals send visitors to a landing page and form; qualified leads go to sales and the rest to nurture; closed deals are fed back as conversion data to improve ad bidding.</title>';
    $box = function ($cls, $x, $y, $w, $t, $h = 32) { return '<rect class="g-b" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '"/><rect class="g-on ' . $cls . '" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '"/><text class="g-t" x="' . ($x + $w / 2) . '" y="' . ($y + $h / 2 + 3.5) . '" text-anchor="middle">' . $t . '</text>'; };
    $edge = function ($cls, $d, $dash = false) { return '<path class="g-e' . ($dash ? ' g-ed' : '') . '" d="' . $d . '"/>' . ($cls ? '<path class="g-p ' . $cls . '" pathLength="100" d="' . $d . '"/>' : ''); };
    $s .= '<text class="g-lab" x="0" y="20">CHANNELS</text>';
    foreach (['SEARCH', 'PAID ADS', 'CONTENT', 'REFERRALS'] as $i => $c) {
        $y = 36 + $i * 50; $cy = $y + 16;
        $s .= $edge('g-c' . $i, 'M96 ' . $cy . ' C116 ' . $cy . ' 110 146 130 146');
        $s .= $box('g-ch' . $i, 0, $y, 96, $c);
    }
    $s .= $edge('g-q0', 'M226 146 H250') . $edge('g-q1', 'M320 146 H340') . $edge('g-q2', 'M380 124 V76 H420') . $edge('g-q3', 'M380 168 V216 H420') . $edge('g-q4', 'M465 92 V116');
    $s .= $box('g-lp', 130, 130, 96, 'LANDING PAGE') . $box('g-fm', 250, 130, 70, 'FORM');
    $s .= '<polygon class="g-b" points="380,124 420,146 380,168 340,146"/><polygon class="g-on g-dq" points="380,124 420,146 380,168 340,146"/><text class="g-t" x="380" y="149.5" text-anchor="middle">FIT?</text>';
    $s .= '<text class="g-y" x="386" y="104">YES</text><text class="g-n" x="386" y="196">NOT YET</text>';
    $s .= $box('g-sl', 420, 60, 90, 'SALES') . $box('g-cd', 420, 116, 90, 'CLOSED DEAL') . $box('g-nu', 420, 200, 90, 'NURTURE');
    $s .= $edge('g-lp5', 'M510 132 H516 V310 H48 V118', true) . '<text class="g-lt" x="262" y="304" text-anchor="middle">CONVERSION DATA → AD BIDDING</text>';
    $s .= '<rect class="g-on g-paid" x="0" y="86" width="96" height="32"/><text class="g-t g-tpaid" x="48" y="105.5" text-anchor="middle">PAID ADS</text>';
    $s .= '<line class="g-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['ATTRACT', 'CONVERT', 'QUALIFY', 'CLOSE THE LOOP'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="g-ft" x="' . $x . '" y="372">' . $f . '</text><text class="g-ft g-fton g-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="g-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="g-fbon g-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_lg_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 4; $i++) { $s = 2 + $i * 2; $k .= $lit("rlgCh$i", $s, $s + 2) . $pul("rlgC$i", $s + 1, $s + 8) . ".rl-lg .g-ch$i{animation-name:rlgCh$i}.rl-lg .g-c$i{animation-name:rlgC$i}\n"; }
    $k .= $lit('rlgLp', 13, 15) . $pul('rlgQ0', 15, 20) . $lit('rlgFm', 20, 22) . $pul('rlgQ1', 22, 26) . $lit('rlgDq', 26, 28)
        . $pul('rlgQ2', 28, 34) . $lit('rlgSl', 34, 36) . $pul('rlgQ3', 29, 35) . $lit('rlgNu', 35, 37) . $pul('rlgQ4', 38, 45) . $lit('rlgCd', 45, 47)
        . "@keyframes rlgLp5{0%,50%{stroke-dashoffset:10;opacity:0}51%{opacity:1}65%{opacity:1}66%,100%{stroke-dashoffset:-100;opacity:0}}\n" . $lit('rlgLt', 50, 53)
        . "@keyframes rlgPaid{0%,65%{opacity:0}67%{opacity:1;fill:rgba(194,26,26,.35)}75%,92%{opacity:1;fill:rgba(153,0,0,.09)}97%,100%{opacity:0}}\n";
    foreach (['lp' => 'Lp', 'fm' => 'Fm', 'dq' => 'Dq', 'sl' => 'Sl', 'nu' => 'Nu', 'cd' => 'Cd'] as $c => $n) $k .= ".rl-lg .g-$c{animation-name:rlg$n}";
    foreach ([0, 1, 2, 3, 4] as $i) $k .= ".rl-lg .g-q$i{animation-name:rlgQ$i}";
    $k .= ".rl-lg .g-lp5{animation-name:rlgLp5}.rl-lg .g-lt{animation-name:rlgLt}.rl-lg .g-paid{animation-name:rlgPaid}\n";
    foreach ([2, 13, 26, 50] as $i => $s) $k .= $lit("rlgF$i", $s, $s + 3) . "@keyframes rlgFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-lg .g-f$i{animation-name:rlgF$i}.rl-lg .g-fb$i{animation-name:rlgFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_lg()) $c[] = 'rl-lg-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_lg(); });
add_action('wp_head', 'rl_lg_css', 22);
function rl_lg_css() {
    if (!rl_is_lg()) return; ?>
<style id="rl-lg-css">
body.rl-lg-page .fl-page-content,body.rl-lg-page .fl-content,body.rl-lg-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-lg .lgl{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-lg .lgl .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-lg .lgl .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-lg .lgl svg{display:block;width:100%;height:auto;overflow:visible}
.rl-lg .g-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-lg .g-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-lg .g-t{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.1em;fill:var(--ink-dim)}
.rl-lg .g-y,.rl-lg .g-n{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--red-3)}
.rl-lg .g-n{fill:var(--ink-faint)}
.rl-lg .g-tpaid{fill:#fff;opacity:0;animation:rlgPaidT 10s cubic-bezier(.45,0,.2,1) infinite both}
@keyframes rlgPaidT{0%,65%{opacity:0}67%,92%{opacity:1}97%,100%{opacity:0}}
.rl-lg .g-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-lg .g-lt{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--red-3);opacity:0}
.rl-lg .g-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-lg .g-ed{stroke-dasharray:2 4}
.rl-lg .g-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-lg .g-rule{stroke:var(--line-2);stroke-width:1}
.rl-lg .g-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-lg .g-fton{fill:var(--ink);opacity:0}
.rl-lg .g-fb{fill:rgba(255,255,255,.08)}
.rl-lg .g-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-lg .g-on,.rl-lg .g-p,.rl-lg .g-lt,.rl-lg .g-fton,.rl-lg .g-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-lg .g-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-lg .g-t{font-size:9.5px;letter-spacing:0}.rl-lg .g-lab{font-size:9.5px;letter-spacing:.06em}.rl-lg .g-lt{font-size:9px;letter-spacing:.02em}.rl-lg .g-ft{font-size:10.5px;letter-spacing:.02em}.rl-lg .lgl .cap span+span{display:none}.rl-lg .lgl{padding:16px 10px 10px}}
<?php echo rl_lg_kf(); ?>
.rl-lg .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_lg() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Lead Generation Systems', 'alternateName' => ['B2B lead generation', 'PPC management services', 'Google Ads management'],
        'serviceType' => 'Lead generation and paid search management', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Lead generation systems that connect channels, landing pages, forms, qualification, routing and closed-loop measurement, including PPC and Google Ads management bid on the value of leads recorded in your CRM.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_lg_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_leadgen', 'rl_render_leadgen');
function rl_render_leadgen() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $ga = function ($id) { return esc_url('https://support.google.com/google-ads/answer/' . $id); };
    $gartner = esc_url('https://www.gartner.com/en/newsroom/press-releases/2025-06-25-gartner-sales-survey-finds-61-percent-of-b2b-buyers-prefer-a-rep-free-buying-experience');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-lg">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Lead Generation Systems</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Lead Generation&nbsp;<b>]</b></span>
      <h1 class="h1">Turn demand into<br>qualified pipeline,<br><span class="r">not form fills.</span></h1>
      <p class="lede"><strong>Lead generation systems</strong> connect every step between a buyer's first search and a closed deal: the channels that attract them, the landing pages and forms that convert them, the qualification and routing that get the right leads to sales fast, and the closed-loop data that tells your ads which leads became revenue. Reinforce Lab builds and runs the whole system, including PPC and Google Ads.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#ppc">PPC management</a>
      </div>
    </div>
    <figure class="lgl rl-anim">
      <div class="cap" aria-hidden="true"><span>Lead generation</span><span>Attract · convert · qualify · close the loop</span></div>
      <?php echo rl_lg_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Channels', 'kind' => 'chips', 'items' => ['Search', 'Paid ads', 'Content', 'Referrals']], ['label' => 'Convert', 'kind' => 'steps', 'items' => ['Landing page', 'Form']], ['label' => 'Qualify', 'kind' => 'rows', 'items' => [['Fit? Yes: sales → closed deal', 'hi'], ['Not yet: nurture', 'dim']]]], 'Conversion data → ad bidding'); ?></figure>
  </div>
</section>

<section class="band alt" id="system">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The system&nbsp;<b>]</b></span><h2>What is a lead generation system?</h2><p class="lede">Six parts that most businesses run separately, and lose leads between. We run them as one.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Attract</span><h3>Channels</h3><p>Organic search, paid search, content and referrals, each chosen for where your buyers actually look.</p></div>
      <div class="cell"><span class="n">02 · Convert</span><h3>Landing pages &amp; CRO</h3><p>A page for each offer and audience, tested and improved on what converts to pipeline.</p></div>
      <div class="cell"><span class="n">03 · Capture</span><h3>Forms &amp; data</h3><p>Forms that ask only what sales needs, with consent recorded and sources captured.</p></div>
      <div class="cell"><span class="n">04 · Qualify</span><h3>Qualification &amp; routing</h3><p>Fit and intent checked, then leads routed to the right person, or to nurture.</p></div>
      <div class="cell"><span class="n">05 · Handoff</span><h3>CRM &amp; speed to lead</h3><p>Every lead in the CRM with its source, and sales alerted while the lead is warm.</p></div>
      <div class="cell"><span class="n">06 · Close the loop</span><h3>Revenue feedback</h3><p>CRM outcomes fed back to your ad platforms and reports, so budget follows revenue.</p></div>
    </div>
  </div>
</section>

<section id="buyers">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How B2B buyers buy&nbsp;<b>]</b></span><h2>How do B2B buyers want to be found?</h2><p class="lede">Mostly on their own terms. Gartner's survey of 632 B2B buyers shows why lead generation has to earn attention, not chase it.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">61%</span><h3>Prefer self-service</h3><p>of B2B buyers prefer an overall rep-free buying experience.</p></div>
      <div class="metric"><span class="num">73%</span><h3>Avoid irrelevant outreach</h3><p>actively avoid suppliers who send them irrelevant outreach.</p></div>
      <div class="metric"><span class="num">69%</span><h3>Notice mixed messages</h3><p>report inconsistencies between a supplier's website and what its sellers say.</p></div>
    </div>
    <p class="src">Source: Gartner, <a href="<?php echo $gartner; ?>" rel="noopener" target="_blank">Sales survey of 632 B2B buyers</a> (conducted August to September 2024, published June 2025)</p>
  </div>
</section>

<section class="band alt" id="ppc">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;PPC management&nbsp;<b>]</b></span><h2>What does our PPC management include?</h2><p class="lede">Paid search run as part of the system, measured on qualified pipeline, not clicks.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">Structure</span><h3>Campaign architecture</h3><p>Campaigns organised by intent and offer, so budget and messaging stay under control.</p></div>
      <div class="cell"><span class="n">Keywords</span><h3>Keywords &amp; negatives</h3><p>High-intent terms in, irrelevant searches out, reviewed from real search-term data.</p></div>
      <div class="cell"><span class="n">Ads</span><h3>Ads &amp; testing</h3><p>Ads that match the searcher's intent, tested continuously.</p></div>
      <div class="cell"><span class="n">Pages</span><h3>Landing pages</h3><p>Pages that match the ad and the search, one of the three signals Google uses to judge ad quality.</p></div>
      <div class="cell"><span class="n">Bidding</span><h3>Bidding on value</h3><p>Conversion values and CRM outcomes that teach bidding which leads matter.</p></div>
      <div class="cell"><span class="n">Tracking</span><h3>Tracking &amp; consent</h3><p>Conversion tracking, enhanced conversions and Consent Mode set up correctly.</p></div>
    </div>
  </div>
</section>

<section id="myths">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Myths&nbsp;<b>]</b></span><h2>Which PPC habits cost you money?</h2><p class="lede">Four common habits, and what Google's own documentation says.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Push Quality Score up and costs will fall."</p></div><div class="f"><span class="tag">Google says</span><p>Quality Score is a diagnostic tool, "not a key performance indicator", and "not an input in the ad auction".</p><a href="<?php echo $ga(6167118); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"The landing page is the website team's problem."</p></div><div class="f"><span class="tag">Google says</span><p>Landing page experience (how relevant and useful the page is) is one of the three components of Quality Score, alongside expected CTR and ad relevance.</p><a href="<?php echo $ga(6167118); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"A form fill is a conversion."</p></div><div class="f"><span class="tag">Google says</span><p>An ad often starts a path that ends in a sale offline. Importing offline conversions lets you measure what happens after the click or call.</p><a href="<?php echo $ga(2998031); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Consent is just a cookie-banner job."</p></div><div class="f"><span class="tag">Google says</span><p>For users in the EEA, the ad_user_data consent type is required for measurement uses such as enhanced conversions and tag-based conversion tracking.</p><a href="<?php echo $ga(13802165); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does a lead generation engagement run?</h2><p class="lede">Fix the measurement first. Everything else depends on it.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Audit</h3><p>Channels, tracking, forms, CRM and where leads are lost today.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Define</h3><p>Ideal customer, offers, and what counts as a qualified lead, agreed with sales.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Build</h3><p>Tracking, landing pages, forms, routing and campaigns.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Launch</h3><p>Channels switched on in stages, with budgets capped until data arrives.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Optimise</h3><p>Budget moved weekly towards what creates qualified pipeline.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Lead-flow audit</b>: where leads come from, where they stall and where they're lost.</li>
      <li><b>Lead definitions</b>: qualified-lead criteria and handoff rules agreed with sales.</li>
      <li><b>Tracking plan</b>: conversions, sources, consent and CRM fields.</li>
      <li><b>Landing pages &amp; forms</b>: built, tested and improved.</li>
      <li><b>Campaigns</b>: PPC and other channels, set up and managed.</li>
      <li><b>Routing &amp; alerts</b>: the right lead to the right person, fast.</li>
      <li><b>Closed-loop setup</b>: CRM outcomes fed back to ads and reports.</li>
      <li><b>Monthly report</b>: cost per qualified lead, pipeline and revenue by channel.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure lead generation?</h2><p class="lede">By what reaches sales and closes, not by the number of forms filled in.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Qualified leads</h3><p>Leads that meet the definition you agreed with sales.</p></div>
      <div class="metric"><h3>Cost per qualified lead</h3><p>Spend divided by qualified leads, by channel and campaign.</p></div>
      <div class="metric"><h3>Lead-to-opportunity rate</h3><p>How many leads sales accepts and turns into opportunities.</p></div>
      <div class="metric"><h3>Speed to lead</h3><p>Time from enquiry to first contact.</p></div>
      <div class="metric"><h3>Pipeline &amp; revenue</h3><p>Opportunities and revenue by source, from your CRM.</p></div>
      <div class="metric"><h3>Customer acquisition cost</h3><p>What it costs to win a customer, channel by channel.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Cheap leads are expensive.</h2>
      <p>It is easy to lower cost per lead: loosen the targeting, shorten the form, offer something free. Sales then spends its week on people who were never going to buy. We optimise for qualified pipeline instead, which sometimes means fewer leads, a longer form and a higher cost per lead that is worth far more.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who are lead generation systems for?</h2><p class="lede">B2B and high-value businesses where one qualified lead is worth far more than a hundred cheap ones.</p></div>
    <ul class="inds8">
      <?php foreach (rl_lg_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Lead generation for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with lead generation?</h2><p class="lede">Leads need a system on both sides: visibility before, follow-up after.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/marketing-automation', 'Follow-up', 'Marketing Automation', 'Nurture, scoring and sales handoff for every lead the system brings in.'],
          ['services/best-search-engine-optimization-services', 'Organic', 'Search Engine Optimization', 'Organic visibility that brings in leads without paying per click.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Guides, comparisons and case studies that attract and qualify buyers.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'Be recommended when buyers research with AI tools.'],
          ['services/ai-workflow-automation', 'Operations', 'AI Workflow Automation', 'AI-powered routing, enrichment and follow-up across the business.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of how buyers find you across Google and AI search.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About lead generation.</h2></div>
    <?php foreach (rl_lg_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Do you know which campaigns create customers?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews how buyers find you and what happens after they enquire, and shows what to fix first.</p>
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
