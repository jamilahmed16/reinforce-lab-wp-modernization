<?php
/**
 * Plugin Name: Reinforce Lab - Enterprise SEO Strategy
 * Description: /services/enterprise-seo-strategy/ (D-023 new slug; legacy off-page / link-building URLs mapped here - intent check O-018) - Enterprise SEO Strategy service page. Provides [reinforce_enterprise]. Uses the shared kit (D-044). Hero animation "One standard, every page" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_ent() { return is_page('enterprise-seo-strategy'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_ent_faqs() {
    return [
        ['What is enterprise SEO?', 'Enterprise SEO is search engine optimization for large, complex organisations: sites with thousands of pages or more, several teams publishing and building, and often several countries or brands. The work shifts from fixing single pages to setting standards for templates, releases, migrations and content, so every page the organisation ships meets them, and to earning authority that a large brand can defend.'],
        ['How is enterprise SEO different from regular SEO?', 'The techniques are the same; the scale and the people are not. One template mistake can repeat across thousands of URLs, fixes have to go through engineering queues, and content, product, development and regional teams all change the site. Enterprise SEO adds governance, ticket-ready specifications, release checks and reporting by page group and market.'],
        ['Do you build links?', 'We build authority the way Google allows: digital PR with newsworthy material, partner and industry relationships, and resources worth citing. We don’t buy links that pass ranking credit, run link exchanges or place keyword links in press releases. Google lists those as link spam. Paid placements are fine for exposure, qualified with rel="sponsored" or rel="nofollow".'],
        ['Will a site migration lose our rankings?', 'Google says to expect temporary fluctuation during a move, and that larger sites can take longer than a few weeks to settle. What protects rankings is the preparation: a complete old-to-new URL map, permanent server-side redirects kept for at least a year, a staged move where possible, and close monitoring afterwards.'],
        ['Does crawl budget matter for our site?', 'It depends on size and how often content changes. Google’s crawl budget guide is aimed at sites with about a million or more pages that change weekly, or 10,000 or more that change daily, and Google calls those rough estimates, not exact thresholds. Below that, index quality usually matters more than crawl budget.'],
        ['How do you work with our in-house teams?', 'Inside your existing process. We write standards and checklists your teams can own, turn fixes into tickets with acceptance criteria, review releases before they ship, and report what shipped, what stalled and what it changed, by page group, market and business outcome.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with enterprise SEO points (D-047) */
function rl_ent_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Brand, product and market sites under one governed standard', 'Medical-legal review built into the content workflow', 'Market-by-market launches without duplicate or conflicting pages']],
        ['healthcare', 'Healthcare', ['Location, service and clinician pages governed at scale', 'Reviewed medical content with clear authorship and dates', 'Migrations of large provider sites without lost visibility']],
        ['b2b-saas', 'B2B SaaS', ['Product, docs, integration and marketing sites working as one', 'Release checks so product launches don’t break SEO', 'Authority from original data and partner ecosystems']],
        ['ecommerce', 'E-commerce', ['Faceted navigation and pagination controlled at the template level', 'Category and product templates that scale cleanly', 'Platform migrations with complete redirect maps']],
        ['manufacturing', 'Manufacturing', ['Product catalogues and spec pages structured for search', 'Regional and distributor sites aligned under one standard', 'Industry and trade-body authority, not bought links']],
        ['technology', 'Technology', ['Multi-product and multi-domain estates brought into one architecture', 'JavaScript rendering checked before every release', 'Developer and documentation content governed for search']],
        ['professional-services', 'Professional Services', ['Practice, office and expert pages governed firm-wide', 'Thought leadership that earns citations and coverage', 'Mergers and rebrands handled as planned migrations']],
        ['education', 'Education', ['Course, department and campus sites under one standard', 'Many publishers, one set of templates and rules', 'Faculty research turned into earned authority']],
    ];
}

/* ---------- hero animation: One standard, every page ----------
   Four teams send work through one SEO standards gate (templates · QA gate · releases); the page
   grid lights in a wave as the standard rolls out across templates; earned links from press,
   partners and industry sources flow into the site. 10 s loop, soft fade, reset. */
function rl_ent_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlEnT"><title id="rlEnT">Content, development, product and regional teams work through one SEO standard (templates, a QA gate and releases) so every page meets it, while earned links from press, partners and industry sources build authority.</title>';
    $teams = ['CONTENT', 'DEVELOPMENT', 'PRODUCT', 'REGIONS'];
    foreach ($teams as $i => $t) {
        $y = 30 + $i * 58; $cy = $y + 18;
        $d = 'M120 ' . $cy . ' C145 ' . $cy . ' 145 135 170 135';
        $s .= '<path class="e-e" d="' . $d . '"/><path class="e-p e-p' . $i . '" pathLength="100" d="' . $d . '"/>'
            . '<rect class="e-t" x="0" y="' . $y . '" width="120" height="36"/><rect class="e-tl e-tl' . $i . '" x="0" y="' . $y . '" width="120" height="36"/><text class="e-tt" x="12" y="' . ($cy + 3.5) . '">' . $t . '</text>';
    }
    $s .= '<rect class="e-g" x="170" y="80" width="124" height="110"/><rect class="e-gl" x="170" y="80" width="124" height="110"/><text class="e-gt" x="182" y="100">SEO STANDARDS</text><line class="e-rule" x1="182" y1="108" x2="282" y2="108"/>';
    foreach (['TEMPLATES', 'QA GATE', 'RELEASES'] as $i => $c) {
        $y = 126 + $i * 20;
        $s .= '<rect class="e-sq" x="182" y="' . ($y - 8) . '" width="9" height="9"/><rect class="e-sqon e-c' . $i . '" x="182" y="' . ($y - 8) . '" width="9" height="9"/><text class="e-ct" x="198" y="' . $y . '">' . $c . '</text>';
    }
    $s .= '<path class="e-e" d="M294 135 H326"/><path class="e-p e-po" pathLength="100" d="M294 135 H326"/>';
    $s .= '<text class="e-lab" x="330" y="18">EVERY TEMPLATE, EVERY PAGE</text>';
    for ($c = 0; $c < 8; $c++) for ($r = 0; $r < 9; $r++) {
        $x = 330 + $c * 24; $y = 28 + $r * 24;
        $s .= '<rect class="e-cell" x="' . $x . '" y="' . $y . '" width="18" height="18"/><rect class="e-on e-col' . $c . '" x="' . $x . '" y="' . $y . '" width="18" height="18"/>';
    }
    $src = [['PRESS', 60], ['PARTNERS', 180], ['INDUSTRY', 300]];
    foreach ($src as $i => $d) {
        $x = $d[1];
        $path = 'M' . ($x + 40) . ' 300 C' . ($x + 40) . ' 270 ' . (380 + $i * 50) . ' 290 ' . (380 + $i * 50) . ' 246';
        $s .= '<path class="e-e e-ed" d="' . $path . '"/><path class="e-p e-pl' . $i . '" pathLength="100" d="' . $path . '"/>'
            . '<rect class="e-src" x="' . $x . '" y="300" width="80" height="26"/><rect class="e-srcon e-s' . $i . '" x="' . $x . '" y="300" width="80" height="26"/><text class="e-st" x="' . ($x + 40) . '" y="317" text-anchor="middle">' . $d[0] . '</text>';
    }
    $s .= '<text class="e-lab" x="0" y="292">EARNED LINKS</text>';
    $s .= '<text class="e-cap" x="260" y="376" text-anchor="middle">ONE STANDARD · EVERY TEAM · EVERY PAGE</text><text class="e-cap e-capon" x="260" y="376" text-anchor="middle">ONE STANDARD · EVERY TEAM · EVERY PAGE</text>';
    return $s . '</svg>';
}
function rl_ent_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 4; $i++) { $s = 3 + $i * 3; $k .= $lit("rleT$i", $s, $s + 2) . $pul("rleP$i", $s + 1, $s + 9) . ".rl-ent .e-tl$i{animation-name:rleT$i}.rl-ent .e-p$i{animation-name:rleP$i}\n"; }
    $k .= $lit('rleG', 18, 21);
    for ($i = 0; $i < 3; $i++) { $s = 20 + $i * 4; $k .= $lit("rleC$i", $s, $s + 2) . ".rl-ent .e-c$i{animation-name:rleC$i}\n"; }
    $k .= $pul('rlePo', 31, 36);
    for ($c = 0; $c < 8; $c++) { $s = 34 + $c * 3; $k .= $lit("rleCol$c", $s, $s + 3) . ".rl-ent .e-col$c{animation-name:rleCol$c}\n"; }
    for ($i = 0; $i < 3; $i++) { $s = 62 + $i * 3; $k .= $lit("rleS$i", $s, $s + 2) . $pul("rleL$i", $s + 1, $s + 10) . ".rl-ent .e-s$i{animation-name:rleS$i}.rl-ent .e-pl$i{animation-name:rleL$i}\n"; }
    $k .= $lit('rleCap', 78, 82);
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_ent()) $c[] = 'rl-ent-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_ent(); });
add_action('wp_head', 'rl_ent_css', 22);
function rl_ent_css() {
    if (!rl_is_ent()) return; ?>
<style id="rl-ent-css">
body.rl-ent-page .fl-page-content,body.rl-ent-page .fl-content,body.rl-ent-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-ent .gov{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-ent .gov .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-ent .gov .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-ent .gov svg{display:block;width:100%;height:auto;overflow:visible}
.rl-ent .e-e{fill:none;stroke:rgba(243,237,230,.08);stroke-width:.8}
.rl-ent .e-ed{stroke-dasharray:2 4}
.rl-ent .e-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-ent .e-po{animation-name:rlePo}
.rl-ent .e-t,.rl-ent .e-src{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ent .e-tl,.rl-ent .e-srcon{fill:rgba(153,0,0,.07);stroke:rgba(226,59,59,.6);stroke-width:.8;opacity:0}
.rl-ent .e-tt{font-family:var(--f-mono);font-size:9px;letter-spacing:.14em;fill:var(--ink-dim)}
.rl-ent .e-st{font-family:var(--f-mono);font-size:8px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-ent .e-g{fill:var(--bg);stroke:rgba(226,59,59,.35);stroke-width:.8}
.rl-ent .e-gl{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.7);stroke-width:.8;opacity:0;animation-name:rleG}
.rl-ent .e-gt{font-family:var(--f-display);font-weight:600;font-size:12px;letter-spacing:.08em;fill:var(--ink)}
.rl-ent .e-rule{stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-ent .e-sq{fill:none;stroke:rgba(243,237,230,.2);stroke-width:.8}
.rl-ent .e-sqon{fill:var(--red-2);opacity:0}
.rl-ent .e-ct{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-ent .e-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-ent .e-cell{fill:rgba(255,255,255,.035);stroke:rgba(243,237,230,.08);stroke-width:.6}
.rl-ent .e-on{fill:rgba(194,26,26,.35);stroke:rgba(226,59,59,.55);stroke-width:.6;opacity:0}
.rl-ent .e-cap{font-family:var(--f-mono);font-size:9px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-ent .e-capon{fill:var(--ink);opacity:0;animation-name:rleCap}
.rl-ent .e-p,.rl-ent .e-tl,.rl-ent .e-srcon,.rl-ent .e-gl,.rl-ent .e-sqon,.rl-ent .e-on,.rl-ent .e-capon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-ent .e-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-ent .e-tt{font-size:10.5px;letter-spacing:.04em}.rl-ent .e-st{font-size:10px;letter-spacing:.02em}.rl-ent .e-ct{font-size:10px;letter-spacing:.02em}.rl-ent .e-lab{font-size:9.5px;letter-spacing:.06em}.rl-ent .e-cap{font-size:10.5px;letter-spacing:.04em}.rl-ent .gov .cap span+span{display:none}.rl-ent .gov{padding:16px 10px 10px}}
<?php echo rl_ent_kf(); ?>
.rl-ent .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-ent .instead{margin-top:34px}
.rl-ent .instead h3.sub{font-size:22px;margin-bottom:16px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_ent() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Enterprise SEO Strategy', 'alternateName' => 'Enterprise SEO',
        'serviceType' => 'Enterprise search engine optimization', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Enterprise SEO strategy for large, complex organisations: SEO governance and standards across teams, template-level technical fixes, migration planning, international architecture, content systems, authority building within Google’s link policies, and reporting by page group, market and business outcome.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_ent_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_enterprise', 'rl_render_enterprise');
function rl_render_enterprise() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $gd = function ($p) { return esc_url('https://developers.google.com/' . $p); };
    $spam = $gd('search/docs/essentials/spam-policies');
    $move = $gd('search/docs/crawling-indexing/site-move-with-url-changes');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-ent">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Enterprise SEO Strategy</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Enterprise SEO&nbsp;<b>]</b></span>
      <h1 class="h1">One SEO standard<br>for every team<br><span class="r">and every page.</span></h1>
      <p class="lede"><strong>Enterprise SEO strategy</strong> is search engine optimization for large, complex organisations: many pages, many teams, often many markets. Reinforce Lab sets the standards your templates, releases and migrations must meet, gets fixes shipped through your engineering process, and builds authority within Google's link policies, then reports what it changed by page group, market and revenue.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#authority">How we build links</a>
      </div>
    </div>
    <figure class="gov rl-anim">
      <div class="cap" aria-hidden="true"><span>Governance</span><span>Teams · standard · pages · links</span></div>
      <?php echo rl_ent_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Teams', 'kind' => 'chips', 'items' => ['Content', 'Development', 'Product', 'Regions']], ['label' => '', 'kind' => 'core', 'title' => 'SEO standards', 'sub' => 'One standard for every team'], ['label' => 'Applied through', 'kind' => 'steps', 'items' => ['Templates', 'QA gate', 'Releases']], ['label' => 'Earned links', 'kind' => 'chips', 'items' => ['Press', 'Partners', 'Industry']]], 'One standard · every team · every page'); ?></figure>
  </div>
</section>

<section class="band alt" id="scale">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The problem at scale&nbsp;<b>]</b></span><h2>Why does SEO break in large organisations?</h2><p class="lede">Rarely because nobody knows what to do. Usually because nobody owns the standard, and the site changes faster than anyone checks it.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Templates</span><h3>One mistake, thousands of URLs</h3><p>A faulty pagination, filter or canonical rule in one template repeats on every page built from it, and junk URLs crowd out the pages that matter.</p></div>
      <div class="cell"><span class="n">02 · Queues</span><h3>Fixes wait behind features</h3><p>SEO issues sit in engineering backlogs without clear specifications, owners or acceptance criteria, so they don't ship.</p></div>
      <div class="cell"><span class="n">03 · Releases</span><h3>Every launch is a risk</h3><p>Redesigns, platform changes and rebrands change URLs, rendering and internal links, often without an SEO check before release.</p></div>
      <div class="cell"><span class="n">04 · Teams</span><h3>Many publishers, no rules</h3><p>Content, product, regional and agency teams publish to their own conventions, creating duplicates and pages that compete with each other.</p></div>
      <div class="cell"><span class="n">05 · Authority</span><h3>Shortcuts that backfire</h3><p>Pressure for quick links leads to paid placements and exchanges that Google treats as link spam.</p></div>
      <div class="cell"><span class="n">06 · Reporting</span><h3>Averages hide the problem</h3><p>Site-wide totals mask the page groups and markets that are falling, so the wrong work gets prioritised.</p></div>
    </div>
  </div>
</section>

<section id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we do&nbsp;<b>]</b></span><h2>What does enterprise SEO strategy cover?</h2><p class="lede">Nine workstreams under one standard, scoped to what your organisation needs, not sold as a bundle.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Governance</span><h3>SEO standards &amp; ownership</h3><p>Written standards, a clear owner for each rule, and checklists your content, product and engineering teams can follow.</p></div>
      <div class="cell"><span class="n">02 · Templates</span><h3>Template-level technical SEO</h3><p>Crawling, indexing, rendering, canonicals, pagination and faceted navigation fixed where they are generated.</p></div>
      <div class="cell"><span class="n">03 · Releases</span><h3>Release &amp; QA gates</h3><p>SEO checks before launches and after them, so regressions are caught in staging, not in Search Console.</p></div>
      <div class="cell"><span class="n">04 · Migrations</span><h3>Migrations &amp; replatforming</h3><p>URL maps, redirect plans, staged moves and post-launch monitoring for redesigns, mergers and domain changes.</p></div>
      <div class="cell"><span class="n">05 · Markets</span><h3>International architecture</h3><p>Country and language structure, hreflang and market launches governed from one standard.</p></div>
      <div class="cell"><span class="n">06 · Content</span><h3>Content systems at scale</h3><p>Topic ownership, briefs and editorial QA so many teams publish helpful, non-competing pages.</p></div>
      <div class="cell"><span class="n">07 · Authority</span><h3>Digital PR &amp; earned links</h3><p>Newsworthy data, expert commentary and partner relationships that earn links and mentions, never bought.</p></div>
      <div class="cell"><span class="n">08 · AI search</span><h3>Visibility in AI answers</h3><p>How AI search tools describe and cite your brand, tracked alongside classic search.</p></div>
      <div class="cell"><span class="n">09 · Reporting</span><h3>Forecasts &amp; reporting</h3><p>Baselines by page group and market, forecasts with stated assumptions, and reporting tied to leads and revenue.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="authority">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Authority &amp; off-page SEO&nbsp;<b>]</b></span><h2>How do we build authority without link spam?</h2><p class="lede">Off-page SEO is where enterprise brands take the most avoidable risk. These are the link rules we work to, in Google's own words.</p></div>
    <p class="quote">"Link spam is the practice of creating links to or from a site primarily for the purpose of manipulating search rankings."<br>Google Search spam policies</p>
    <div class="myths" style="margin-top:28px">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Buying links in bulk is the fastest way to rank."</p></div><div class="f"><span class="tag">Google says</span><p>Buying or selling links for ranking purposes (for money, goods, services or free products) is listed as link spam, along with automated link programs and excessive link exchanges.</p><a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Any paid placement breaks Google's rules."</p></div><div class="f"><span class="tag">Google says</span><p>Buying links for advertising and sponsorship is a normal part of the web. It isn't a violation as long as the links are qualified with rel="sponsored" or rel="nofollow".</p><a href="<?php echo $gd('search/docs/crawling-indexing/qualify-outbound-links'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Keyword links in press releases and guest posts build authority."</p></div><div class="f"><span class="tag">Google says</span><p>Links with optimised anchor text in articles, guest posts or press releases distributed on other sites are listed as link spam.</p><a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"A sitewide footer link on partner sites is free authority."</p></div><div class="f"><span class="tag">Google says</span><p>Widely distributed links in the footers or templates of various sites are listed as link spam.</p><a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Publish on a big site's subfolder to borrow its rankings."</p></div><div class="f"><span class="tag">Google says</span><p>Publishing third-party content on a host mainly to exploit the host's ranking signals is site reputation abuse, enforced since 5 May 2024.</p><a href="<?php echo $gd('search/blog/2024/11/site-reputation-abuse'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
    <div class="instead">
      <h3 class="sub">What we do instead</h3>
      <div class="cols c3">
        <div class="cell"><span class="n">Earn</span><h3>Digital PR</h3><p>Original data, research and expert commentary that journalists and industry sites choose to cite.</p></div>
        <div class="cell"><span class="n">Connect</span><h3>Partners &amp; industry</h3><p>Associations, partners, events and suppliers where a link reflects a real relationship.</p></div>
        <div class="cell"><span class="n">Protect</span><h3>Link audits &amp; qualification</h3><p>Review of your existing links and your outbound paid links, qualified with the right rel attribute.</p></div>
      </div>
    </div>
    <p class="src">Sources: Google, <a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Spam policies for Google web search</a> · <a href="<?php echo $gd('search/docs/crawling-indexing/qualify-outbound-links'); ?>" rel="noopener" target="_blank">Qualify outbound links</a></p>
  </div>
</section>

<section id="migrate">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Migrations&nbsp;<b>]</b></span><h2>How do we protect rankings during a migration?</h2><p class="lede">Migrations are where large sites lose the most visibility in the least time. The protection is in the preparation.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Inventory</h3><p>Every URL that has traffic, links or impressions, from crawls, logs, Search Console and analytics.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>URL map</h3><p>Each old URL mapped to its closest new equivalent, reviewed and signed off.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Redirects</h3><p>Permanent server-side redirects, tested in staging and kept for at least a year.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Staged launch</h3><p>Move in steps where possible, changing one thing at a time.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Monitor</h3><p>Crawl errors, indexing and rankings watched daily until the new URLs settle.</p></li>
    </ol>
    <p class="quote">"Expect temporary fluctuation in site ranking during the move."<br>Google Search Central, Site moves with URL changes</p>
    <p class="src">Source: Google, <a href="<?php echo $move; ?>" rel="noopener" target="_blank">Site moves and migrations</a></p>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does an enterprise SEO engagement run?</h2><p class="lede">Baseline first, standards second, then shipped work, measured by page group.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Discover</h3><p>Crawl, logs, Search Console and analytics, plus interviews with the teams that change the site.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Baseline</h3><p>Performance by page group and market, and a roadmap ranked by impact and effort, with owners.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Standards</h3><p>SEO standards, release checklists and ticket-ready specifications for your teams.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Ship</h3><p>Fixes, content and authority work delivered through your sprints and approval routes.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Measure</h3><p>What shipped, what stalled and what it changed, then the next priority.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Enterprise SEO audit</b>: crawl, logs, templates, content and links, by page group.</li>
      <li><b>Prioritised roadmap</b>: impact, effort, owner and dependencies for every item.</li>
      <li><b>SEO standards</b>: rules for templates, content, internal links, schema and releases.</li>
      <li><b>Ticket-ready specifications</b>: with acceptance criteria your developers can build to.</li>
      <li><b>Release QA</b>: pre-launch and post-launch checks for every significant change.</li>
      <li><b>Migration plan</b>: URL map, redirect rules and monitoring when you move or merge.</li>
      <li><b>Authority programme</b>: digital PR and partner links within Google's policies.</li>
      <li><b>Reporting</b>: visibility, traffic, leads and revenue by page group and market.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure enterprise SEO?</h2><p class="lede">By page group and market, not a single site-wide average.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Indexed, useful pages</h3><p>Share of important pages indexed, and junk URLs removed from the crawl.</p></div>
      <div class="metric"><h3>Visibility by page group</h3><p>Impressions, clicks and rankings for each template and market.</p></div>
      <div class="metric"><h3>Shipped vs stalled</h3><p>How many SEO tickets shipped, how fast, and what they changed.</p></div>
      <div class="metric"><h3>Release regressions</h3><p>SEO issues caught before launch versus found after.</p></div>
      <div class="metric"><h3>Earned authority</h3><p>Quality links and mentions from relevant, independent sources.</p></div>
      <div class="metric"><h3>Leads &amp; revenue</h3><p>Organic conversions and pipeline, including visibility in AI answers.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Enterprise SEO is won in the ticket queue.</h2>
      <p>Most large sites already have audits full of the right recommendations. What they lack is the standard, the owner and the ticket that gets each one shipped, and a check that stops the next release from undoing it. That is where we spend our time. We won't promise rankings, and we won't take shortcuts with links that put a brand at risk.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is enterprise SEO for?</h2><p class="lede">Organisations with large or complex sites (many pages, many teams, several markets or brands) where search is a meaningful channel.</p></div>
    <ul class="inds8">
      <?php foreach (rl_ent_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Enterprise SEO for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with enterprise SEO?</h2><p class="lede">Enterprise strategy sets the standard. These services deliver the specialist work within it.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Crawling, indexing, rendering and speed, fixed at the template level.'],
          ['services/international-seo', 'Multi-country', 'International SEO', 'Country and language architecture, hreflang and market launches.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Briefs, workflows and editorial QA for many publishing teams.'],
          ['services/press-release-services', 'Authority', 'Digital PR', 'Newsworthy stories and data that earn coverage and links.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'Visibility and accurate recommendations across AI search.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your Google and AI-search performance with a prioritised fix list.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About enterprise SEO.</h2></div>
    <?php foreach (rl_ent_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Is your SEO standard shipping, or stuck in the backlog?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your indexing, templates, authority and AI-search visibility, and shows what to fix first.</p>
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
