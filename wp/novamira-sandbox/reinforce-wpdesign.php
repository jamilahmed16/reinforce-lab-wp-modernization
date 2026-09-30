<?php
/**
 * Plugin Name: Reinforce Lab — WordPress Website Design
 * Description: /services/wordpress-website-design-service/ (production URL kept, D-023; 281,585 impressions / 16 months; WooCommerce web-design product URLs 301 here) — WordPress Website Design service page. Provides [reinforce_wpdesign]. Uses the shared kit (D-044). Hero animation "Wireframe to launch" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_wpd() { return is_page('wordpress-website-design-service'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_wpd_faqs() {
    return [
        ['What do WordPress website design services include?', 'A WordPress website design service plans, designs and builds a website on WordPress: discovery and sitemap, wireframes, visual design, content, development, SEO foundations, performance, accessibility, integrations with your CRM and analytics, testing and launch — plus training so your team can edit the site themselves.'],
        ['Why build on WordPress?', 'WordPress runs 40.2% of all websites (W3Techs, September 2026), so it is well supported, flexible and not tied to one agency. Your team can update content without a developer, and the site can grow from a few pages to thousands.'],
        ['Will a redesign hurt our rankings?', 'It can, if URLs change without a plan. We keep URLs wherever possible, map every changed URL to its closest new page with a permanent redirect, test everything on a staging site, and monitor Search Console after launch. Google recommends keeping redirects for as long as possible — generally at least a year.'],
        ['How fast will the site be?', 'We build to Google’s Core Web Vitals: Largest Contentful Paint within 2.5 seconds, Interaction to Next Paint of 200 milliseconds or less, and Cumulative Layout Shift of 0.1 or less, measured at the 75th percentile of real visits. We check against these before launch and monitor them after.'],
        ['Will the site be accessible?', 'We design and test to WCAG 2.2 level AA — the W3C’s current accessibility guidelines. If you sell to consumers online in the EU, the European Accessibility Act has applied to e-commerce services since 28 June 2025. This is not legal advice.'],
        ['How much does a WordPress website cost?', 'It depends on the number of page templates, how much content needs writing or moving, the integrations you need and whether an existing site is being migrated. After a discovery call you get a written scope and quote.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with WordPress design points (D-047) */
function rl_wpd_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Corporate, product and HCP sites with approval workflows', 'Content governed by user roles and review steps', 'Accessible design for patients and professionals']],
        ['healthcare', 'Healthcare', ['Service, clinician and location pages patients can use easily', 'Booking and enquiry forms that respect privacy', 'WCAG 2.2 AA accessibility built in']],
        ['b2b-saas', 'B2B SaaS', ['Marketing sites the growth team can edit daily', 'Solution, integration and comparison page templates', 'Forms and analytics wired to your CRM']],
        ['ecommerce', 'E-commerce', ['Brand and content sites alongside your store', 'Fast category and landing-page templates', 'Accessibility for EU e-commerce requirements']],
        ['manufacturing', 'Manufacturing', ['Product and application libraries that are easy to maintain', 'Spec sheets, downloads and quote requests', 'Multilingual sites for distributors and markets']],
        ['technology', 'Technology', ['Fast, component-based sites for complex products', 'Documentation and resource hubs', 'Integrations with product and marketing tools']],
        ['professional-services', 'Professional Services', ['Practice-area, people and insight templates', 'Easy publishing for partners and experts', 'Office and location pages for local search']],
        ['education', 'Education', ['Course and programme templates editors can manage', 'Accessible design for every student', 'Admissions forms connected to your systems']],
    ];
}

/* ---------- hero animation: Wireframe to launch ----------
   A page is planned as a wireframe inside a browser frame, then designed — header, hero, button, cards
   and footer fill in — and finally passes the launch checks: Core Web Vitals, accessibility, the redirect
   map and SEO; plan · design · build · launch light in turn. 10 s loop, soft fade, reset. */
function rl_wp_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlWpT"><title id="rlWpT">A website is wireframed, designed and built in WordPress, then passes launch checks for speed, accessibility, redirects and SEO.</title>';
    $s .= '<rect class="p-fr" x="0" y="0" width="320" height="320"/><line class="p-rule" x1="0" y1="26" x2="320" y2="26"/>';
    foreach ([0, 1, 2] as $i) $s .= '<rect class="p-dot" x="' . (10 + $i * 12) . '" y="9" width="8" height="8"/>';
    $s .= '<rect class="p-url" x="56" y="7" width="190" height="12"/><text class="p-ut" x="64" y="16">YOURDOMAIN.COM</text>';
    /* blocks: [class, x, y, w, h] — wireframe outline, then design fill */
    $blk = [['b0', 14, 38, 292, 22], ['b1', 14, 70, 292, 96], ['b2', 14, 178, 90, 64], ['b3', 115, 178, 90, 64], ['b4', 216, 178, 90, 64], ['b5', 14, 254, 292, 52]];
    foreach ($blk as $i => $b) {
        $s .= '<rect class="p-wf p-w' . $i . '" pathLength="100" x="' . $b[1] . '" y="' . $b[2] . '" width="' . $b[3] . '" height="' . $b[4] . '"/><rect class="p-fill p-d' . $i . '" x="' . $b[1] . '" y="' . $b[2] . '" width="' . $b[3] . '" height="' . $b[4] . '"/>';
    }
    $s .= '<g class="p-hero"><rect class="p-h1" x="28" y="86" width="150" height="10"/><rect class="p-h2" x="28" y="102" width="112" height="10"/><rect class="p-tx" x="28" y="120" width="170" height="4"/><rect class="p-tx" x="28" y="128" width="140" height="4"/><rect class="p-btn" x="28" y="140" width="64" height="16"/></g>';
    $s .= '<g class="p-nav"><rect class="p-logo" x="24" y="45" width="40" height="8"/><rect class="p-tx" x="190" y="47" width="22" height="4"/><rect class="p-tx" x="218" y="47" width="22" height="4"/><rect class="p-tx" x="246" y="47" width="22" height="4"/><rect class="p-cta" x="274" y="43" width="24" height="12"/></g>';
    $s .= '<text class="p-lab" x="344" y="12">LAUNCH CHECKS</text>';
    foreach (['LCP ≤ 2.5 S', 'INP ≤ 200 MS', 'CLS ≤ 0.1', 'WCAG 2.2 AA', 'REDIRECT MAP', 'SCHEMA & SEO'] as $i => $c) {
        $y = 38 + $i * 44;
        $s .= '<rect class="p-row" x="344" y="' . ($y - 16) . '" width="176" height="32"/><rect class="p-rowon p-c' . $i . '" x="344" y="' . ($y - 16) . '" width="176" height="32"/>'
            . '<rect class="p-sq" x="356" y="' . ($y - 5) . '" width="10" height="10"/><rect class="p-sqon p-c' . $i . '" x="356" y="' . ($y - 5) . '" width="10" height="10"/><text class="p-ct" x="376" y="' . ($y + 3.5) . '">' . $c . '</text>';
    }
    $s .= '<line class="p-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['PLAN', 'DESIGN', 'BUILD', 'LAUNCH'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="p-ft" x="' . $x . '" y="372">' . $f . '</text><text class="p-ft p-fton p-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="p-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="p-fbon p-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_wp_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 6; $i++) { $s = 2 + $i * 3; $k .= "@keyframes rlwpW$i{0%,{$s}%{stroke-dashoffset:100;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($s + 5) . "%,92%{stroke-dashoffset:0;opacity:1}97%,100%{stroke-dashoffset:0;opacity:0}}\n.rl-wpd .p-w$i{animation-name:rlwpW$i}\n"; }
    for ($i = 0; $i < 6; $i++) { $s = 22 + $i * 2; $k .= $lit("rlwpD$i", $s, $s + 3) . ".rl-wpd .p-d$i{animation-name:rlwpD$i}\n"; }
    $k .= $lit('rlwpNav', 24, 27) . $lit('rlwpHero', 28, 32);
    for ($i = 0; $i < 6; $i++) { $s = 44 + $i * 4; $k .= $lit("rlwpC$i", $s, $s + 2) . ".rl-wpd .p-c$i{animation-name:rlwpC$i}\n"; }
    foreach ([2, 22, 32, 44] as $i => $s) $k .= $lit("rlwpF$i", $s, $s + 3) . "@keyframes rlwpFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-wpd .p-f$i{animation-name:rlwpF$i}.rl-wpd .p-fb$i{animation-name:rlwpFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_wpd()) $c[] = 'rl-wpd-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_wpd(); });
add_action('wp_head', 'rl_wpd_css', 22);
function rl_wpd_css() {
    if (!rl_is_wpd()) return; ?>
<style id="rl-wpd-css">
body.rl-wpd-page .fl-page-content,body.rl-wpd-page .fl-content,body.rl-wpd-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-wpd .wpf{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-wpd .wpf .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-wpd .wpf .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-wpd .wpf svg{display:block;width:100%;height:auto;overflow:visible}
.rl-wpd .p-fr{fill:var(--bg);stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-wpd .p-rule{stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-wpd .p-dot{fill:rgba(243,237,230,.18)}
.rl-wpd .p-url{fill:rgba(255,255,255,.04);stroke:rgba(243,237,230,.1);stroke-width:.6}
.rl-wpd .p-ut{font-family:var(--f-mono);font-size:7px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-wpd .p-wf{fill:none;stroke:rgba(243,237,230,.35);stroke-width:.8;stroke-dasharray:4 3;opacity:0}
.rl-wpd .p-fill{fill:rgba(255,255,255,.035);stroke:rgba(243,237,230,.14);stroke-width:.8;opacity:0}
.rl-wpd .p-d1{fill:rgba(153,0,0,.14);stroke:rgba(226,59,59,.45)}
.rl-wpd .p-nav{opacity:0;animation-name:rlwpNav}.rl-wpd .p-hero{opacity:0;animation-name:rlwpHero}
.rl-wpd .p-logo{fill:#fff}.rl-wpd .p-cta{fill:var(--red-2)}
.rl-wpd .p-h1,.rl-wpd .p-h2{fill:rgba(243,237,230,.85)}
.rl-wpd .p-tx{fill:rgba(243,237,230,.28)}
.rl-wpd .p-btn{fill:var(--red-2)}
.rl-wpd .p-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-wpd .p-row{fill:var(--bg);stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-wpd .p-rowon{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.55);stroke-width:.8;opacity:0}
.rl-wpd .p-sq{fill:none;stroke:rgba(243,237,230,.25);stroke-width:.8}
.rl-wpd .p-sqon{fill:var(--red-2);opacity:0}
.rl-wpd .p-ct{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-wpd .p-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-wpd .p-fton{fill:var(--ink);opacity:0}
.rl-wpd .p-fb{fill:rgba(255,255,255,.08)}
.rl-wpd .p-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-wpd .p-wf,.rl-wpd .p-fill,.rl-wpd .p-nav,.rl-wpd .p-hero,.rl-wpd .p-rowon,.rl-wpd .p-sqon,.rl-wpd .p-fton,.rl-wpd .p-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-wpd .p-ct{font-size:10px;letter-spacing:.02em}.rl-wpd .p-lab{font-size:9.5px;letter-spacing:.06em}.rl-wpd .p-ut{font-size:8.5px;letter-spacing:.04em}.rl-wpd .p-ft{font-size:11px;letter-spacing:.04em}.rl-wpd .wpf .cap span+span{display:none}.rl-wpd .wpf{padding:16px 10px 10px}}
<?php echo rl_wp_kf(); ?>
.rl-wpd .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-wpd .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_wpd() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'WordPress Website Design', 'alternateName' => ['WordPress website design services', 'WordPress web design agency', 'WordPress web development'],
        'serviceType' => 'WordPress website design and development', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'WordPress website design and development for B2B and specialist businesses: discovery, UX, custom design, editor-friendly builds, SEO foundations, Core Web Vitals performance, WCAG 2.2 AA accessibility, integrations and SEO-safe redesigns and migrations.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_wpd_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_wpdesign', 'rl_render_wpdesign');
function rl_render_wpdesign() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $w3t = esc_url('https://w3techs.com/technologies/details/cm-wordpress');
    $cwv = esc_url('https://web.dev/articles/vitals');
    $wcag = esc_url('https://www.w3.org/TR/WCAG22/');
    $eaa = esc_url('https://commission.europa.eu/strategy-and-policy/policies/justice-and-fundamental-rights/disability/union-equality-strategy-rights-persons-disabilities-2021-2030/european-accessibility-act_en');
    $move = esc_url('https://developers.google.com/search/docs/crawling-indexing/site-move-with-url-changes');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-wpd">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">WordPress Website Design</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;WordPress Website Design&nbsp;<b>]</b></span>
      <h1 class="h1">WordPress sites<br>built to rank<br><span class="r">and convert.</span></h1>
      <p class="lede"><strong>WordPress website design services</strong> from Reinforce Lab plan, design and build fast, accessible WordPress sites that your team can edit and Google can crawl — with your search rankings protected through every redesign and migration. WordPress runs 40.2% of all websites; we make yours one that brings in qualified leads.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#redesign">Redesign safely</a>
      </div>
    </div>
    <figure class="wpf rl-anim">
      <div class="cap" aria-hidden="true"><span>WordPress build</span><span>Plan · design · build · launch</span></div>
      <?php echo rl_wp_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What's included&nbsp;<b>]</b></span><h2>What do our WordPress website design services include?</h2><p class="lede">Everything from the first sitemap to the first month after launch — designed around how your buyers search and decide.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Discovery</span><h3>Goals, audience &amp; sitemap</h3><p>What the site must achieve, who it's for, and the pages and structure that get them there.</p></div>
      <div class="cell"><span class="n">02 · UX</span><h3>Wireframes &amp; journeys</h3><p>Page layouts and paths to enquiry, tested before any design polish.</p></div>
      <div class="cell"><span class="n">03 · Design</span><h3>Custom visual design</h3><p>A design system built on your brand — not a theme with your logo on it.</p></div>
      <div class="cell"><span class="n">04 · Build</span><h3>WordPress development</h3><p>Clean, reusable templates your team can edit without breaking the layout.</p></div>
      <div class="cell"><span class="n">05 · Content</span><h3>Content &amp; copy</h3><p>Page copy written for people and search, or your existing content moved and improved.</p></div>
      <div class="cell"><span class="n">06 · SEO</span><h3>SEO foundations</h3><p>Titles, headings, schema, internal links and sitemaps built in from the start.</p></div>
      <div class="cell"><span class="n">07 · Speed</span><h3>Core Web Vitals</h3><p>Fast loading, quick responses and stable layouts, checked against Google's thresholds.</p></div>
      <div class="cell"><span class="n">08 · Access</span><h3>Accessibility</h3><p>Designed and tested to WCAG 2.2 level AA, so everyone can use the site.</p></div>
      <div class="cell"><span class="n">09 · Connect</span><h3>Integrations</h3><p>Forms, CRM, analytics, consent and marketing tools connected and tested.</p></div>
    </div>
    <p class="src">WordPress share: W3Techs, <a href="<?php echo $w3t; ?>" rel="noopener" target="_blank">Usage statistics of WordPress</a> (40.2% of all websites, 25 September 2026)</p>
  </div>
</section>

<section id="standards">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Standards&nbsp;<b>]</b></span><h2>What standards does every site meet?</h2><p class="lede">Published standards, not opinions — so "done" means the same thing to you and to us.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">2.5s</span><h3>Largest Contentful Paint</h3><p>The main content loads within 2.5 seconds — Google's "good" threshold for loading.</p></div>
      <div class="metric"><span class="num">200ms</span><h3>Interaction to Next Paint</h3><p>The page responds to clicks and taps in 200 milliseconds or less.</p></div>
      <div class="metric"><span class="num">0.1</span><h3>Cumulative Layout Shift</h3><p>Nothing jumps around while the page loads — a layout shift score of 0.1 or less.</p></div>
    </div>
    <p class="quote">Accessibility is built to WCAG 2.2 level AA, the W3C's current guidelines. For businesses selling online to EU consumers, the European Accessibility Act has applied to e-commerce services since 28 June 2025.</p>
    <p class="src">Sources: Google, <a href="<?php echo $cwv; ?>" rel="noopener" target="_blank">Web Vitals</a> (75th percentile of page loads) · W3C, <a href="<?php echo $wcag; ?>" rel="noopener" target="_blank">WCAG 2.2</a> · European Commission, <a href="<?php echo $eaa; ?>" rel="noopener" target="_blank">European Accessibility Act</a>. Not legal advice.</p>
  </div>
</section>

<section class="band alt" id="redesign">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Redesigns&nbsp;<b>]</b></span><h2>How do we redesign without losing your rankings?</h2><p class="lede">Most redesigns that lose traffic lose it at launch — through changed URLs nobody mapped. We treat every redesign as a migration.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Inventory</h3><p>Every URL with traffic, links or impressions, from crawls, Search Console and analytics.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Keep URLs</h3><p>Pages that rank keep their addresses wherever possible.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Map redirects</h3><p>Each changed URL mapped one-to-one to its closest new page with a permanent redirect.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Test on staging</h3><p>Redirects, titles, schema, speed and forms checked before launch.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Monitor</h3><p>Search Console, rankings and conversions watched daily after launch.</p></li>
    </ol>
    <p class="quote">"Keep the redirects for as long as possible, generally at least 1 year." — Google Search Central, Site moves and migrations</p>
    <p class="src">Source: Google, <a href="<?php echo $move; ?>" rel="noopener" target="_blank">Site moves with URL changes</a></p>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does a WordPress project run?</h2><p class="lede">Clear stages, with your sign-off before each one moves on.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Discover</h3><p>Goals, audience, competitors, current site and search data.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Plan &amp; wireframe</h3><p>Sitemap, page structure and wireframes, approved by you.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Design</h3><p>Visual design and a design system for every template.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Build &amp; test</h3><p>Development, content, SEO, speed and accessibility testing on staging.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Launch &amp; support</h3><p>Go-live, monitoring, training and handover.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Sitemap &amp; wireframes</b> — the structure and layout of every page type.</li>
      <li><b>Design system</b> — colours, type, components and page templates.</li>
      <li><b>WordPress build</b> — editor-friendly templates and reusable blocks.</li>
      <li><b>SEO setup</b> — titles, schema, sitemaps, internal links and analytics.</li>
      <li><b>Redirect map</b> — every changed URL mapped and tested.</li>
      <li><b>Performance &amp; accessibility report</b> — Core Web Vitals and WCAG 2.2 AA checks.</li>
      <li><b>Training</b> — so your team can publish and update with confidence.</li>
      <li><b>Launch support</b> — monitoring and fixes in the weeks after go-live.</li>
    </ul>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>A beautiful site that loses its rankings is a failed redesign.</h2>
      <p>Design matters, but a new website is judged by what happens after launch: does it keep the traffic you had, load quickly, work for everyone and turn visitors into enquiries? We plan for those outcomes from the first meeting — and we'd rather keep a ranking URL than rename it for the sake of a tidier sitemap.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who are our WordPress websites for?</h2><p class="lede">B2B and specialist businesses whose website has to win search traffic and turn it into enquiries.</p></div>
    <ul class="inds8">
      <?php foreach (rl_wpd_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('WordPress websites for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with a new WordPress site?</h2><p class="lede">A new site is the start. These services keep it fast, found and converting.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/website-maintenance-services', 'After launch', 'Website Maintenance', 'Updates, backups, security and speed, month after month.'],
          ['services/ecommerce-website-design-service', 'Stores', 'E-commerce Website Design', 'Online stores designed to sell and to rank.'],
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Crawling, indexing and speed at the template level.'],
          ['services/best-search-engine-optimization-services', 'Search', 'Search Engine Optimization', 'Organic visibility for the pages your new site is built around.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'The pages and articles that fill your new site with answers.'],
          ['services/lead-generation-systems', 'Leads', 'Lead Generation Systems', 'Landing pages, forms and routing that turn visits into pipeline.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About WordPress website design.</h2></div>
    <?php foreach (rl_wpd_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Is your website helping you win business?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your site's speed, structure, search visibility and conversion paths, and shows what to fix first.</p>
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
