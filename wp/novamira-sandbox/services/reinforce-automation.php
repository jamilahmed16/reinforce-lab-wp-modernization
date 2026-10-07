<?php
/**
 * Plugin Name: Reinforce Lab - Marketing Automation
 * Description: /services/marketing-automation/ (approved new URL, 27 Sep 2026; D-023 301 target for the legacy email-marketing and social-media service pages) - Marketing Automation service page. Provides [reinforce_automation]. Uses the shared kit (D-044). Hero animation "Nurture to handoff" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_ma() { return is_page('marketing-automation'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_ma_faqs() {
    return [
        ['What is marketing automation?', 'Marketing automation is software that sends the right message to each lead at the right time based on what they do: filling in a form, clicking an email, visiting a pricing page. It runs nurture emails, scores leads, updates your CRM and alerts sales when a lead is ready, so no enquiry is forgotten and sales spends time on the leads most likely to buy.'],
        ['Is marketing automation the same as email marketing?', 'No. Email marketing is one channel: newsletters and campaigns. Marketing automation connects email with your website, forms, CRM and sales team, and sends messages triggered by each person’s behaviour. We run both: campaigns for everyone, and automated journeys for each stage of the buying process.'],
        ['Which platform do you use?', 'Usually the one you already have. Most businesses already pay for a CRM and an email platform that can automate far more than they use it for. We audit what you have, recommend changes only where they are needed, and build on it, so you keep ownership of your data and workflows.'],
        ['Is our email compliant?', 'We check. Gmail requires every sender to authenticate with SPF or DKIM, and senders of more than 5,000 messages a day to Gmail accounts to use SPF, DKIM and DMARC, offer one-click unsubscribe and keep spam rates below 0.3%. In the US, CAN-SPAM applies to business-to-business email too; in the UK, PECR requires consent before emailing individuals, with a limited exception for existing customers.'],
        ['Why don’t you report open rates?', 'Because they are no longer reliable. Apple’s Mail Privacy Protection hides whether an email was actually opened, and Litmus reported that it accounted for 55% of all opens as of March 2024. We report clicks, replies, conversions, qualified leads and pipeline instead.'],
        ['How long does it take to set up?', 'It depends on the state of your CRM and data. We start with an audit and the journeys that matter most (usually new-lead nurture and sales handoff) and launch those first, then add further workflows once the first ones are working.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with automation points (D-047) */
function rl_ma_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['HCP communications with consent and approval steps built in', 'Event and congress follow-up sequences', 'CRM data kept clean for compliance and reporting']],
        ['healthcare', 'Healthcare', ['Enquiry and appointment follow-up that respects patient privacy', 'Referral-partner nurture programmes', 'Reminders and recall journeys where consent allows']],
        ['b2b-saas', 'B2B SaaS', ['Trial and demo nurture based on product behaviour', 'Lead scoring agreed with sales, synced to the CRM', 'Onboarding and expansion journeys for customers']],
        ['ecommerce', 'E-commerce', ['Welcome, browse and abandoned-basket journeys', 'Post-purchase and replenishment emails', 'Segments built from purchase history']],
        ['manufacturing', 'Manufacturing', ['Quote-request follow-up that never goes cold', 'Distributor and dealer communications', 'Long-cycle nurture with technical content']],
        ['technology', 'Technology', ['Webinar and event follow-up workflows', 'Account-based nurture for target companies', 'Sales alerts on high-intent behaviour']],
        ['professional-services', 'Professional Services', ['Client-alert and insight newsletters by practice area', 'Event invitations and follow-up', 'Referral and relationship nurture']],
        ['education', 'Education', ['Enquiry-to-application journeys for prospective students', 'Open-day and event reminders', 'Segmented communications by course and stage']],
    ];
}

/* ---------- hero animation: Nurture to handoff ----------
   A form fill triggers a workflow: a guide email goes out, a "clicked?" branch sends engaged leads a
   case study while the others wait for a new angle; the lead score rises past the MQL line, sales is
   alerted and a deal is created in the CRM; trigger · nurture · score · handoff light in turn. 10 s
   loop, soft fade, reset. */
function rl_ma_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlMaT"><title id="rlMaT">A form fill triggers an automated nurture workflow; engaged leads receive a case study, their lead score rises past the qualification threshold, sales is alerted and a deal is created in the CRM.</title>';
    $s .= '<text class="m-lab" x="0" y="12">THE WORKFLOW</text>';
    $box = function ($cls, $x, $y, $w, $t) { return '<rect class="m-b" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="34"/><rect class="m-on ' . $cls . '" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="34"/><text class="m-t" x="' . ($x + $w / 2) . '" y="' . ($y + 20.5) . '" text-anchor="middle">' . $t . '</text>'; };
    $edge = function ($cls, $d, $dash = false) { return '<path class="m-e' . ($dash ? ' m-ed' : '') . '" d="' . $d . '"/>' . ($cls ? '<path class="m-p ' . $cls . '" pathLength="100" d="' . $d . '"/>' : ''); };
    $s .= $edge('m-p0', 'M160 58 V84') . $edge('m-p1', 'M160 118 V148') . $edge('m-p2', 'M205 170 H240 V222') . $edge('', 'M115 170 H60 V222', true) . $edge('m-p3', 'M240 256 V290');
    $s .= $box('m-o0', 100, 24, 120, 'FORM FILL') . $box('m-o1', 100, 84, 120, 'EMAIL · GUIDE');
    $s .= '<polygon class="m-b" points="160,148 205,170 160,192 115,170"/><polygon class="m-on m-o2" points="160,148 205,170 160,192 115,170"/><text class="m-t" x="160" y="173.5" text-anchor="middle">CLICKED?</text>';
    $s .= '<text class="m-y" x="214" y="164">YES</text><text class="m-n" x="92" y="164" text-anchor="end">NO</text>';
    $s .= $box('m-o3', 180, 222, 120, 'EMAIL · CASE STUDY') . '<rect class="m-b m-dim" x="0" y="222" width="120" height="34"/><text class="m-t m-tdim" x="60" y="242.5" text-anchor="middle">WAIT · NEW ANGLE</text>';
    $s .= $box('m-o4', 180, 290, 120, 'SALES ALERT');
    $s .= '<text class="m-lab" x="350" y="12">LEAD SCORE</text>';
    $s .= '<rect class="m-sc" x="390" y="40" width="44" height="240"/><rect class="m-scon" x="390" y="40" width="44" height="240"/>';
    $s .= '<line class="m-mql" x1="378" y1="112" x2="446" y2="112"/><line class="m-mql m-mqlon" x1="378" y1="112" x2="446" y2="112"/><text class="m-ml" x="452" y="115.5">MQL</text><text class="m-ml m-mlon" x="452" y="115.5">MQL</text>';
    $s .= '<rect class="m-b" x="340" y="290" width="180" height="34"/><rect class="m-on m-crm" x="340" y="290" width="180" height="34"/><text class="m-t" x="430" y="310.5" text-anchor="middle">CRM · DEAL CREATED</text>';
    $s .= $edge('m-p4', 'M300 307 H340');
    $s .= '<line class="m-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['TRIGGER', 'NURTURE', 'SCORE', 'HANDOFF'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="m-ft" x="' . $x . '" y="372">' . $f . '</text><text class="m-ft m-fton m-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="m-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="m-fbon m-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_ma_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    $o = [2, 11, 20, 29, 40];
    foreach ($o as $i => $t) $k .= $lit("rlmaO$i", $t, $t + 2) . ".rl-ma .m-o$i{animation-name:rlmaO$i}\n";
    foreach ([4, 13, 22, 32, 44] as $i => $t) $k .= $pul("rlmaP$i", $t, $t + 7) . ".rl-ma .m-p$i{animation-name:rlmaP$i}\n";
    $k .= "@keyframes rlmaSc{0%,12%{transform:scaleY(0);opacity:1}15%,28%{transform:scaleY(.3)}31%,40%{transform:scaleY(.55)}44%,92%{transform:scaleY(.82);opacity:1}97%,100%{transform:scaleY(.82);opacity:0}}\n";
    $k .= $lit('rlmaMql', 43, 45) . $lit('rlmaCrm', 50, 53);
    foreach ([2, 11, 28, 46] as $i => $s) $k .= $lit("rlmaF$i", $s, $s + 3) . "@keyframes rlmaFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-ma .m-f$i{animation-name:rlmaF$i}.rl-ma .m-fb$i{animation-name:rlmaFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_ma()) $c[] = 'rl-ma-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_ma(); });
add_action('wp_head', 'rl_ma_css', 22);
function rl_ma_css() {
    if (!rl_is_ma()) return; ?>
<style id="rl-ma-css">
body.rl-ma-page .fl-page-content,body.rl-ma-page .fl-content,body.rl-ma-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-ma .mfl{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-ma .mfl .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-ma .mfl .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-ma .mfl svg{display:block;width:100%;height:auto;overflow:visible}
.rl-ma .m-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ma .m-dim{stroke-dasharray:3 3}
.rl-ma .m-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-ma .m-crm{animation-name:rlmaCrm}
.rl-ma .m-t{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.1em;fill:var(--ink-dim)}
.rl-ma .m-tdim{fill:var(--ink-faint)}
.rl-ma .m-y,.rl-ma .m-n{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--red-3)}
.rl-ma .m-n{fill:var(--ink-faint)}
.rl-ma .m-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-ma .m-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-ma .m-ed{stroke-dasharray:2 4}
.rl-ma .m-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-ma .m-sc{fill:rgba(255,255,255,.035);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ma .m-scon{fill:rgba(194,26,26,.35);stroke:rgba(226,59,59,.7);stroke-width:.8;transform-box:fill-box;transform-origin:50% 100%;transform:scaleY(0);animation-name:rlmaSc}
.rl-ma .m-mql{stroke:rgba(243,237,230,.3);stroke-width:1;stroke-dasharray:3 3}
.rl-ma .m-mqlon{stroke:#fff;opacity:0;animation-name:rlmaMql}
.rl-ma .m-ml{font-family:var(--f-mono);font-size:9px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-ma .m-mlon{fill:#fff;opacity:0;animation-name:rlmaMql}
.rl-ma .m-rule{stroke:var(--line-2);stroke-width:1}
.rl-ma .m-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ma .m-fton{fill:var(--ink);opacity:0}
.rl-ma .m-fb{fill:rgba(255,255,255,.08)}
.rl-ma .m-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-ma .m-on,.rl-ma .m-p,.rl-ma .m-scon,.rl-ma .m-mqlon,.rl-ma .m-mlon,.rl-ma .m-fton,.rl-ma .m-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-ma .m-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-ma .m-t{font-size:9.5px;letter-spacing:0}.rl-ma .m-lab{font-size:9.5px;letter-spacing:.06em}.rl-ma .m-ft{font-size:11px;letter-spacing:.04em}.rl-ma .m-ml{font-size:10.5px}.rl-ma .mfl .cap span+span{display:none}.rl-ma .mfl{padding:16px 10px 10px}}
<?php echo rl_ma_kf(); ?>
.rl-ma .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_ma() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Marketing Automation', 'alternateName' => ['Email marketing services', 'Lead nurturing', 'Marketing automation services'],
        'serviceType' => 'Marketing automation and email marketing', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Marketing automation services: lead capture, email nurture journeys, lead scoring, CRM workflows, sales handoff, email campaigns and deliverability, built on your existing platform, compliant with sender and consent rules, and measured in pipeline.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_ma_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_automation', 'rl_render_automation');
function rl_render_automation() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $gm = esc_url('https://support.google.com/a/answer/81126');
    $ftc = esc_url('https://www.ftc.gov/business-guidance/resources/can-spam-act-compliance-guide-business');
    $ico = esc_url('https://ico.org.uk/for-organisations/direct-marketing-and-privacy-and-electronic-communications/guide-to-pecr/electronic-and-telephone-marketing/electronic-mail-marketing/');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-ma">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Marketing Automation</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Marketing Automation&nbsp;<b>]</b></span>
      <h1 class="h1">Follow up with<br>every lead,<br><span class="r">automatically.</span></h1>
      <p class="lede"><strong>Marketing automation</strong> sends the right message to each lead at the right moment: nurture emails, lead scoring, CRM updates and sales alerts, based on what they actually do. Reinforce Lab designs, builds and runs these workflows on the platforms you already use, with deliverability and consent built in, and measures them in pipeline, not opens.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#rules">Email rules</a>
      </div>
    </div>
    <figure class="mfl rl-anim">
      <div class="cap" aria-hidden="true"><span>Marketing automation</span><span>Trigger · nurture · score · handoff</span></div>
      <?php echo rl_ma_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Trigger', 'kind' => 'rows', 'items' => ['Form fill']], ['label' => 'Nurture', 'kind' => 'rows', 'items' => ['Email · guide', 'Clicked? Yes: email · case study', ['Clicked? No: wait · new angle', 'dim']]], ['label' => 'Score', 'kind' => 'steps', 'items' => ['Lead score', ['MQL', 'hi']]], ['label' => 'Handoff', 'kind' => 'rows', 'items' => ['Sales alert', ['CRM · deal created', 'hi']]]], 'Trigger · nurture · score · handoff'); ?></figure>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we do&nbsp;<b>]</b></span><h2>What does marketing automation cover?</h2><p class="lede">Everything between a lead arriving and a salesperson calling, plus the campaigns that keep customers engaged.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Capture</span><h3>Forms &amp; lead capture</h3><p>Forms, consent and routing that put every lead in the right place with the right permissions.</p></div>
      <div class="cell"><span class="n">02 · Nurture</span><h3>Email nurture journeys</h3><p>Sequences triggered by behaviour (downloads, visits, clicks) that answer the next question a buyer has.</p></div>
      <div class="cell"><span class="n">03 · Score</span><h3>Lead scoring</h3><p>A scoring model agreed with sales, so "ready to talk" means the same thing to both teams.</p></div>
      <div class="cell"><span class="n">04 · CRM</span><h3>CRM workflows &amp; data</h3><p>Lifecycle stages, field rules, deduplication and syncs that keep your CRM trustworthy.</p></div>
      <div class="cell"><span class="n">05 · Handoff</span><h3>Sales alerts &amp; handoff</h3><p>Instant alerts and tasks when a lead is ready, with the context sales needs.</p></div>
      <div class="cell"><span class="n">06 · Campaigns</span><h3>Email marketing</h3><p>Newsletters and campaigns planned, written, designed, tested and sent.</p></div>
      <div class="cell"><span class="n">07 · Social</span><h3>Social publishing workflows</h3><p>Scheduling, approval and reporting for social posts, so publishing runs on a system.</p></div>
      <div class="cell"><span class="n">08 · Delivery</span><h3>Deliverability</h3><p>SPF, DKIM and DMARC, list hygiene and spam-rate monitoring, so your email reaches the inbox.</p></div>
      <div class="cell"><span class="n">09 · Report</span><h3>Reporting &amp; attribution</h3><p>Which journeys and campaigns create qualified leads, pipeline and revenue.</p></div>
    </div>
  </div>
</section>

<section id="rules">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Email rules&nbsp;<b>]</b></span><h2>What rules does your marketing email have to follow?</h2><p class="lede">Since February 2024, Gmail has enforced sender requirements, and privacy law has always applied. Five things we still hear, and what the rules actually say.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Email authentication is only for big senders."</p></div><div class="f"><span class="tag">Gmail says</span><p>All senders must set up SPF or DKIM. Senders of more than 5,000 messages a day to Gmail accounts need SPF, DKIM and DMARC.</p><a href="<?php echo $gm; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Hide the unsubscribe link to keep the list big."</p></div><div class="f"><span class="tag">Gmail says</span><p>Bulk senders' marketing messages must support one-click unsubscribe and show a clearly visible unsubscribe link, and keep spam rates below 0.3%.</p><a href="<?php echo $gm; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"B2B email is exempt from spam law."</p></div><div class="f"><span class="tag">FTC says</span><p>CAN-SPAM "makes no exception for business-to-business email". Opt-outs must be honoured within 10 business days.</p><a href="<?php echo $ftc; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Buy a list and start emailing."</p></div><div class="f"><span class="tag">ICO says</span><p>In the UK you must not email individuals without specific consent. The "soft opt-in" covers your own previous customers, not bought-in lists.</p><a href="<?php echo $ico; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Our agency sends it, so compliance is their problem."</p></div><div class="f"><span class="tag">FTC says</span><p>Even if you hire another company to handle your email marketing, "you can't contract away your legal responsibility to comply with the law."</p><a href="<?php echo $ftc; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
    <p class="src">Sources: Google, <a href="<?php echo $gm; ?>" rel="noopener" target="_blank">Email sender guidelines</a> · US FTC, <a href="<?php echo $ftc; ?>" rel="noopener" target="_blank">CAN-SPAM Act compliance guide</a> · UK ICO, <a href="<?php echo $ico; ?>" rel="noopener" target="_blank">Electronic mail marketing</a>. Not legal advice.</p>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does a marketing automation project run?</h2><p class="lede">Clean data and agreed definitions first. Automation only amplifies what it's given.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Audit</h3><p>Your CRM, email platform, data quality, deliverability and current journeys.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Map</h3><p>Buyer journeys, lifecycle stages and a lead-scoring model agreed with sales.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Build</h3><p>Workflows, emails, forms and CRM rules: highest-value journeys first.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Test</h3><p>Every branch, email and sync checked before anything goes live.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Optimise</h3><p>Monthly review of what creates pipeline, then the next journey.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Automation audit</b>: platform, CRM, data, deliverability and journeys.</li>
      <li><b>Journey map</b>: lifecycle stages and the messages for each one.</li>
      <li><b>Lead-scoring model</b>: agreed with sales, documented and synced.</li>
      <li><b>Workflows built</b>: nurture, handoff, re-engagement and customer journeys.</li>
      <li><b>Emails</b>: written, designed and tested across devices.</li>
      <li><b>Deliverability setup</b>: SPF, DKIM, DMARC and one-click unsubscribe checked.</li>
      <li><b>Documentation</b>: how every workflow works, so your team owns it.</li>
      <li><b>Monthly report</b>: clicks, conversions, qualified leads and pipeline.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure marketing automation?</h2><p class="lede">Not by open rates. Apple's Mail Privacy Protection hides whether an email was really opened. Litmus reported it accounted for 55% of all opens as of March 2024.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Clicks &amp; replies</h3><p>Real signs that a person read and acted on the email.</p></div>
      <div class="metric"><h3>Conversions</h3><p>Demo requests, downloads and sign-ups from each journey.</p></div>
      <div class="metric"><h3>Qualified leads</h3><p>Leads that reach the agreed score and are accepted by sales.</p></div>
      <div class="metric"><h3>Speed to lead</h3><p>Time from a lead being ready to sales making contact.</p></div>
      <div class="metric"><h3>Pipeline &amp; revenue</h3><p>Deals and revenue influenced by automated journeys.</p></div>
      <div class="metric"><h3>List health</h3><p>Deliverability, spam complaints, bounces and unsubscribes.</p></div>
    </div>
    <p class="src">Source: Litmus, <a href="<?php echo esc_url('https://www.litmus.com/blog/measure-email-marketing-success'); ?>" rel="noopener" target="_blank">How to measure email marketing success beyond open rate</a> (June 2024)</p>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Automation makes bad follow-up faster.</h2>
      <p>If your data is messy, your message unclear or sales and marketing disagree on what a good lead is, automation will simply do the wrong thing at scale. That's why we fix the data and agree the definitions before we build anything, and why we start with the two or three journeys that matter most, not fifty workflows nobody maintains.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is marketing automation for?</h2><p class="lede">Businesses with more leads than their team can follow up by hand, or a long buying cycle where timing decides who wins.</p></div>
    <ul class="inds8">
      <?php foreach (rl_ma_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Marketing automation for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with marketing automation?</h2><p class="lede">Automation turns leads into pipeline. These services bring the leads in and extend automation across the business.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/lead-generation-systems', 'Leads', 'Lead Generation Systems', 'The campaigns, pages and offers that bring qualified leads in.'],
          ['services/ai-workflow-automation', 'Operations', 'AI Workflow Automation', 'AI-powered workflows beyond marketing: operations, sales and service.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'The guides and case studies your nurture journeys send.'],
          ['services/best-search-engine-optimization-services', 'Search', 'Search Engine Optimization', 'Organic visibility that brings buyers to your forms in the first place.'],
          ['services/executive-ai-consulting', 'Strategy', 'Executive AI Consulting', 'Where AI and automation should (and shouldn’t) go in your business.'],
          ['search-authority-os', 'System', 'Search Authority OS', 'Search, content and automation run as one operating system.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About marketing automation.</h2></div>
    <?php foreach (rl_ma_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>How many leads go cold before anyone calls?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews how leads reach you and what happens next, and shows what to fix first.</p>
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
