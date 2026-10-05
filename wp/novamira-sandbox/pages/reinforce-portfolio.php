<?php
/**
 * Plugin Name: Reinforce Lab - Portfolio
 * Description: /portfolio/ (production URL kept, rule R4 core page, D-124) and the project pages /portfolio/<slug>/ (D-125, D-126: moved from production /projects/<slug>/, 301 at migration). Provides [reinforce_portfolio]. PLACEHOLDER LIST: the six projects already shown on reinforcelab.com/portfolio/, facts taken read-only from production (Exa, 5 Oct 2026); Jamil will send the real portfolio. No results or numbers appear without a source. Uses the shared kit (D-044). Schema: CollectionPage with an ItemList of CreativeWork, FAQPage.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_portfolio() { return is_page('portfolio') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }

/* One entry per project. Replace with Jamil's list (D-124). Fields: name, client, industry [label, path], work type, period, needed, built[], stack[], site url or ''.
   Sources: reinforcelab.com/projects/inpace-shop/, /projects/access-tutor/, /projects/iba-alumni-lottery/ and /portfolio/ (read-only). */
function rl_portfolio_data() {
    return [
        ['Inpace Shop', 'INPACE Management Services Limited', ['E-commerce', 'industries/ecommerce'], 'E-commerce website', 'Aug to Oct 2021',
            'A camera and computer accessories retailer with three shops in Dhaka needed its online store rebuilt. The old site loaded slowly, its navigation was broken, it had few payment and shipping options, and visitors left before finding products.',
            ['WooCommerce store with order tracking and customer accounts', 'Product search that makes the catalogue easy to browse', 'Payment gateway integration', 'Product photography of the real stock', 'Image and code optimisation for faster pages'],
            ['WordPress', 'WooCommerce', 'Product photography', 'Social media'], 'https://inpaceshop.com/'],
        ['AccessTUTOR', 'Accesstel', ['Education', 'industries/education'], 'Web application', 'Jul to Sep 2021',
            'An online tutoring platform where students preparing for HSC and university admission exams find private tutors, and tutors run their classes.',
            ['Landing page and branding', 'Course management with quizzes and exams', 'Google Meet schedule shown in the dashboard', 'Responsive front end for phones, tablets and desktops'],
            ['Python', 'Django', 'Relational database', 'Google Meet API'], ''],
        ['IBA Alumni Lottery', 'IBA Alumni Association', ['Education', 'industries/education'], 'Web application', 'Aug to Oct 2021',
            'The alumni association of the Institute of Business Administration needed one place for its reunion: a database of alumni, online registration, and a fair prize draw.',
            ['Alumni database with graduation years and contact details', 'Online reunion registration', 'A random draw that picks a registered alumnus, with results on the site', 'Responsive design for phone and desktop'],
            ['Python', 'Django', 'MySQL', 'jQuery'], ''],
        ['Signature Jeans', 'Signature Jeans BD', ['E-commerce', 'industries/ecommerce'], 'E-commerce website', '2024',
            'A Dhaka denim brand selling online needed a store where shoppers can find the right fit and order.',
            ['Online store with product and size pages', 'Checkout and order management'],
            ['WordPress', 'WooCommerce'], 'https://signaturejeansbd.com/'],
        ['Beyond Borders', '', ['', ''], 'Website, content and SEO', '',
            'A website build followed by content and search work.',
            ['WordPress website', 'Content marketing', 'Search engine optimisation'],
            ['WordPress', 'Content', 'SEO'], ''],
        ['Advocate Gazi', 'Advocate Gazi', ['Professional Services', 'industries/professional-services'], 'WordPress website', '2022',
            'A law practice needed a website that sets out its practice areas and services and makes it easy for clients to get in touch.',
            ['WordPress website design and build', 'Practice area and service pages', 'Contact routes for new clients'],
            ['WordPress'], 'https://advocategazi.com/'],
    ];
}

function rl_portfolio_faqs() {
    return [
        ['What kind of projects does Reinforce Lab take on?', 'Websites and online stores built on WordPress and WooCommerce, custom web applications, and the search, content and automation work that brings people to them. Our current work centres on AI Growth Systems: one system connecting your website, content and search visibility.'],
        ['Why are there no traffic or revenue numbers here?', 'We only publish a result when we can show where it comes from and the client agrees. Full case studies with results are being prepared, and each one will name its source.'],
        ['Can I talk to a past client?', 'Yes. Ask us and we will put you in touch with a client who has agreed to take calls.'],
        ['How do I start a project?', 'Start with the free Search Authority Diagnostic, or contact us with what you need. We reply within two business days.'],
    ];
}

add_filter('body_class', function ($c) { if (rl_is_portfolio()) $c[] = 'rl-portfolio-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_portfolio(); });

/* ---------- schema ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_portfolio()) return $graph;
    $url = get_permalink(get_queried_object_id());
    $org = home_url('/#organization');
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if (in_array('WebPage', $t, true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) {
            $n['@type'] = ['WebPage', 'CollectionPage'];
            $n['about'] = ['@id' => $org];
            $n['mainEntity'] = ['@id' => $url . '#projects'];
        }
    }
    unset($n);
    $items = [];
    foreach (rl_portfolio_data() as $i => $p) {
        $w = ['@type' => 'CreativeWork', 'name' => $p[0], 'description' => $p[5], 'creator' => ['@id' => $org], 'genre' => $p[3], 'keywords' => implode(', ', $p[7])];
        if ($p[1] !== '') $w['sourceOrganization'] = ['@type' => 'Organization', 'name' => $p[1]];
        if ($p[8] !== '') $w['url'] = $p[8];
        if (preg_match('/(20\d\d)$/', $p[4], $m)) $w['dateCreated'] = $m[1];
        $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'item' => $w];
    }
    $graph[] = ['@type' => 'ItemList', '@id' => $url . '#projects', 'name' => 'Reinforce Lab projects', 'numberOfItems' => count($items), 'itemListElement' => $items];
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_portfolio_faqs())];
    return $graph;
}, 20);

/* ---------- CSS ---------- */
add_action('wp_head', 'rl_portfolio_css', 22);
function rl_portfolio_css() {
    if (rl_is_portfolio()) rl_portfolio_css_body();
}
function rl_portfolio_css_body() { ?>
<style id="rl-portfolio-css">
body.rl-portfolio-page .fl-page-content,body.rl-portfolio-page .fl-content,body.rl-portfolio-page .fl-post-content,body.rl-project-page .fl-page-content,body.rl-project-page .fl-content,body.rl-project-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
body.rl-project-page .fl-post-meta,body.rl-project-page .fl-post-nav,body.rl-project-page .fl-comments{display:none!important}
.rl-portfolio .ic{width:12px;height:12px;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:square}
.rl-portfolio .hero-grid{align-items:stretch}
.rl-portfolio .p-panel{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));display:flex;flex-direction:column;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-portfolio .p-tally{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1px;background:var(--line-2);border-bottom:1px solid var(--line-2);margin:0;flex:1}
.rl-portfolio .p-tally div{background:var(--bg-2);padding:20px 22px;margin:0;display:flex;flex-direction:column;justify-content:center}
.rl-portfolio .p-tally dt{font-family:var(--f-display);font-size:44px;line-height:1;color:var(--ink);font-weight:500;margin:0}
.rl-portfolio .p-tally dd{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin:6px 0 0}
.rl-portfolio .p-kinds{padding:18px 22px}
.rl-portfolio .p-kinds .cap{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 10px}
.rl-portfolio .chips{display:flex;flex-wrap:wrap;gap:6px;margin:0;padding:0;list-style:none}
.rl-portfolio .chips li{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-dim);border:1px solid var(--line-2);padding:3px 9px;margin:0}
.rl-portfolio .p-note{margin:0 0 18px;border-left:3px solid var(--red-3);padding:12px 16px;background:linear-gradient(90deg,rgba(153,0,0,.1),transparent);font-size:15px;color:var(--ink-dim)}
.rl-portfolio .p-note b{color:var(--ink)}
.rl-portfolio .p-note a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-portfolio .p-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
.rl-portfolio .p-card{border:1px solid var(--line-2);background:var(--bg-2);display:grid;grid-template-rows:auto 1fr;margin:0}
.rl-portfolio .p-shot{position:relative;border-bottom:1px solid var(--line-2);background:radial-gradient(120% 120% at 100% 0%,rgba(153,0,0,.22),transparent 55%),var(--panel);aspect-ratio:16/7;overflow:hidden}
.rl-portfolio .p-shot svg{position:absolute;inset:0;width:100%;height:100%}
.rl-portfolio .p-shot .tag{position:absolute;left:14px;top:12px;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-portfolio .p-shot .yr{position:absolute;right:14px;top:12px;font-family:var(--f-mono);font-size:11px;color:var(--ink-faint)}
.rl-portfolio .p-body{padding:18px 20px 20px;display:grid;gap:10px;align-content:start}
.rl-portfolio .p-body h3{font-size:24px;line-height:1.1;margin:0}
.rl-portfolio .p-who{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);margin:-4px 0 0}
.rl-portfolio .p-who a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-portfolio .p-body p{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-portfolio .p-body .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin:4px 0 0}
.rl-portfolio .p-built{margin:0;padding:0;list-style:none;display:grid;gap:6px}
.rl-portfolio .p-built li{display:grid;grid-template-columns:14px 1fr;gap:9px;font-size:14.5px;color:var(--ink);margin:0}
.rl-portfolio .p-built li .ic{margin-top:5px;color:var(--red-3)}
.rl-portfolio .p-foot{display:flex;flex-wrap:wrap;justify-content:space-between;gap:10px;align-items:center;border-top:1px solid var(--line);padding-top:12px;margin-top:4px}
.rl-portfolio .p-site{font-family:var(--f-mono);font-size:11.5px;color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-portfolio .p-site:hover{color:var(--red-3)}
.rl-portfolio .p-work{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}
.rl-portfolio .p-work a{border:1px solid var(--line-2);background:var(--bg-2);padding:18px 20px;display:grid;gap:8px;text-decoration:none;color:var(--ink)}
.rl-portfolio .p-work a:hover{border-color:var(--red-line)}
.rl-portfolio .p-work b{font-family:var(--f-display);font-weight:500;font-size:19px;text-transform:uppercase;letter-spacing:.02em}
.rl-portfolio .p-work span{font-size:14.5px;color:var(--ink-dim)}
.rl-portfolio .p-work em{font-style:normal;font-family:var(--f-mono);font-size:11.5px;color:var(--red-3)}
.rl-portfolio .p-cs{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-project .pj-tag{font-size:.5em;line-height:1.15;display:inline-block;margin-top:10px}
.rl-project .pj-panel .p-shot{aspect-ratio:16/6}
.rl-project .pj-facts{margin:0;display:grid}
.rl-project .pj-facts div{display:grid;grid-template-columns:96px minmax(0,1fr);gap:12px;padding:11px 20px;border-top:1px solid var(--line);margin:0}
.rl-project .pj-facts dt{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);padding-top:3px}
.rl-project .pj-facts dd{margin:0;font-size:14.5px;color:var(--ink)}
.rl-project .pj-facts dd a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-project .pj-two{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:28px;align-items:start}
.rl-project .pj-intro{margin:0;font-size:17px;color:var(--ink-dim)}
.rl-project .pj-blocks{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.rl-project .pj-b{border:1px solid var(--line-2);background:var(--bg-2);padding:20px 22px;display:grid;gap:8px;align-content:start;margin:0}
.rl-project .pj-b .n{font-family:var(--f-mono);font-size:11px;color:var(--red-3);letter-spacing:.12em}
.rl-project .pj-b h3{font-size:21px;margin:0;line-height:1.15}
.rl-project .pj-b p{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-project .pj-stack{display:flex;flex-wrap:wrap;align-items:center;gap:10px 14px;margin-top:16px}
.rl-project .pj-stack .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-project .pj-got{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 28px;margin-bottom:18px}
.rl-project .pj-more{grid-template-columns:repeat(3,minmax(0,1fr))}
@media(max-width:1000px){.rl-portfolio .p-work{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:760px){.rl-project .pj-two,.rl-project .pj-blocks,.rl-project .pj-got,.rl-project .pj-more{grid-template-columns:1fr}.rl-project .pj-facts div{grid-template-columns:84px minmax(0,1fr);padding:10px 16px}}
@media(max-width:760px){.rl-portfolio .p-grid,.rl-portfolio .p-work{grid-template-columns:1fr}.rl-portfolio .p-shot{aspect-ratio:16/8}}
</style>
<?php }

/* A drawn frame per work type (no screenshots yet): store, app or site. */
function rl_portfolio_frame($type, $i) {
    $g = 'pg' . $i;
    $top = '<rect x="40" y="26" width="520" height="190" fill="#171314" stroke="#3a3130"/><rect x="40" y="26" width="520" height="18" fill="#1f1a1b" stroke="#3a3130"/><circle cx="52" cy="35" r="3" fill="#990000"/><circle cx="62" cy="35" r="3" fill="#3a3130"/><circle cx="72" cy="35" r="3" fill="#3a3130"/><rect x="200" y="31" width="200" height="8" fill="#121011"/>';
    if (stripos($type, 'commerce') !== false) {
        $b = '';
        for ($k = 0; $k < 4; $k++) { $x = 64 + $k * 124; $b .= '<rect x="' . $x . '" y="96" width="104" height="70" fill="url(#' . $g . ')" stroke="#3a3130"/><rect x="' . $x . '" y="174" width="70" height="6" fill="#3a3130"/><rect x="' . $x . '" y="186" width="40" height="6" fill="#990000"/>'; }
        $body = '<rect x="64" y="58" width="150" height="10" fill="#f2eeee" opacity=".8"/><rect x="64" y="74" width="230" height="6" fill="#3a3130"/><rect x="470" y="58" width="66" height="22" fill="none" stroke="#e23b3b"/>' . $b;
    } elseif (stripos($type, 'application') !== false) {
        $body = '<rect x="40" y="44" width="110" height="172" fill="#1a1516" stroke="#3a3130"/>';
        for ($k = 0; $k < 5; $k++) $body .= '<rect x="56" y="' . (62 + $k * 22) . '" width="' . ($k === 1 ? 78 : 64) . '" height="7" fill="' . ($k === 1 ? '#e23b3b' : '#3a3130') . '"/>';
        $body .= '<rect x="170" y="62" width="170" height="64" fill="url(#' . $g . ')" stroke="#3a3130"/><rect x="356" y="62" width="180" height="64" fill="#1a1516" stroke="#3a3130"/><path d="M370 112l30-22 26 12 30-26 28 16 30-20" fill="none" stroke="#e23b3b" stroke-width="2"/><rect x="170" y="140" width="366" height="12" fill="#1f1a1b"/><rect x="170" y="160" width="366" height="12" fill="#1a1516"/><rect x="170" y="180" width="366" height="12" fill="#1f1a1b"/>';
    } else {
        $body = '<rect x="64" y="62" width="250" height="14" fill="#f2eeee" opacity=".8"/><rect x="64" y="84" width="200" height="14" fill="#f2eeee" opacity=".8"/><rect x="64" y="110" width="230" height="6" fill="#3a3130"/><rect x="64" y="122" width="190" height="6" fill="#3a3130"/><rect x="64" y="142" width="96" height="22" fill="#990000"/><rect x="350" y="58" width="186" height="110" fill="url(#' . $g . ')" stroke="#3a3130"/><rect x="64" y="182" width="140" height="22" fill="#1a1516" stroke="#3a3130"/><rect x="216" y="182" width="140" height="22" fill="#1a1516" stroke="#3a3130"/><rect x="368" y="182" width="168" height="22" fill="#1a1516" stroke="#3a3130"/>';
    }
    return '<svg viewBox="0 0 600 240" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><defs><linearGradient id="' . $g . '" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2c2525"/><stop offset="1" stop-color="#4a0f0f"/></linearGradient></defs>' . $top . $body . '</svg>';
}

/* ---------- markup ---------- */
add_shortcode('reinforce_portfolio', 'rl_render_portfolio');
function rl_render_portfolio() {
    if (!rl_is_portfolio()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $data = rl_portfolio_data();
    $ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $ext = ' rel="noopener" target="_blank"';
    $inds = array_unique(array_filter(array_map(function ($p) { return $p[2][0]; }, $data)));
    $types = array_unique(array_map(function ($p) { return $p[3]; }, $data));
    ob_start(); ?>
<div class="rl-page rl-portfolio">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Portfolio</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Portfolio&nbsp;<b>]</b></span>
      <h1 class="h1">Websites, stores<br>and systems <span class="r">we have<br>built.</span></h1>
      <p class="lede"><strong>Reinforce Lab has built online stores, web applications and websites for retailers, schools, associations and professional firms</strong>, on WordPress, WooCommerce and Python with Django. Each project below says what the client needed, what we built and the tools we used.</p>
      <div class="cta-row">
        <a class="btn p" href="#projects">See the projects <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic</a>
      </div>
    </div>
    <aside class="p-panel" aria-label="Portfolio at a glance">
      <dl class="p-tally">
        <div><dt><?php echo count($data); ?></dt><dd>Projects shown</dd></div>
        <div><dt><?php echo count($inds); ?></dt><dd>Industries</dd></div>
        <div><dt>2021</dt><dd>First project</dd></div>
        <div><dt>2</dt><dd>Offices, Dhaka and Katy</dd></div>
      </dl>
      <div class="p-kinds">
        <p class="cap">Types of work</p>
        <ul class="chips"><?php foreach ($types as $t) echo '<li>' . esc_html($t) . '</li>'; ?></ul>
      </div>
    </aside>
  </div>
</section>

<section id="projects">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Projects&nbsp;<b>]</b></span><h2>What has Reinforce Lab built?</h2></div>
    <p class="p-note"><b>Case studies with results are on the way.</b> We publish a number only when we can show where it comes from and the client agrees, so the projects below describe the work, not the results. <a href="<?php echo $u('clients'); ?>">See all our clients</a>.</p>
    <div class="p-grid">
    <?php foreach ($data as $i => $p) {
        $ind = $p[2][0] !== '' ? '<a href="' . $u($p[2][1]) . '">' . esc_html($p[2][0]) . '</a>' : '';
        $who = array_filter([$p[1] !== '' ? esc_html($p[1]) : '', $ind]); ?>
      <article class="p-card">
        <div class="p-shot"><?php echo rl_portfolio_frame($p[3], $i); ?><span class="tag"><?php echo esc_html($p[3]); ?></span><?php if ($p[4] !== '') echo '<span class="yr">' . esc_html($p[4]) . '</span>'; ?></div>
        <div class="p-body">
          <h3><?php echo esc_html($p[0]); ?></h3>
          <?php if ($who) echo '<p class="p-who">' . implode(' &middot; ', $who) . '</p>'; ?>
          <p><?php echo esc_html($p[5]); ?></p>
          <p class="lbl">What we built</p>
          <ul class="p-built"><?php foreach ($p[6] as $b) echo '<li>' . $ok . '<span>' . esc_html($b) . '</span></li>'; ?></ul>
          <div class="p-foot">
            <ul class="chips"><?php foreach ($p[7] as $s) echo '<li>' . esc_html($s) . '</li>'; ?></ul>
            <?php $cs = rl_project_url_by_name($p[0]); if ($cs) echo '<a class="p-cs" href="' . esc_url($cs) . '">Read the project &rarr;</a>'; elseif ($p[8] !== '') echo '<a class="p-site" href="' . esc_url($p[8]) . '"' . $ext . '>Visit the site</a>'; ?>
          </div>
        </div>
      </article>
    <?php } ?>
    </div>
  </div>
</section>

<section class="band alt" id="services">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>]</b></span><h2>The services behind this work</h2></div>
    <div class="p-work">
      <a href="<?php echo $u('services/wordpress-website-design-service'); ?>"><b>WordPress websites</b><span>Fast, well structured sites your team can edit.</span><em>WordPress Website Design &rarr;</em></a>
      <a href="<?php echo $u('services/ecommerce-website-design-service'); ?>"><b>Online stores</b><span>WooCommerce stores with payments, accounts and order tracking.</span><em>E-commerce Website Design &rarr;</em></a>
      <a href="<?php echo $u('services/best-search-engine-optimization-services'); ?>"><b>Search</b><span>Technical, content and AI search work that brings buyers to the site.</span><em>Search Engine Optimization &rarr;</em></a>
      <a href="<?php echo $u('services/website-maintenance-services'); ?>"><b>Care after launch</b><span>Updates, backups, security and speed checks.</span><em>Website Maintenance &rarr;</em></a>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About our work.</h2></div>
    <?php foreach (rl_portfolio_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See what we would fix first on your site.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('contact-us'); ?>">Contact us</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}

/* =========================================================================
   Project pages: /portfolio/<slug>/ (Jamil 5 Oct 2026: "it should be under /portfolio/ no /projects", D-126).
   Production has them at /projects/<slug>/: those URLs 301 here (below, and in the migration redirect map).
   Post type rl_project with the "portfolio" slug and NO archive: /portfolio/ itself stays the Portfolio page.
   Content rewritten from the production project pages (read-only, Exa); facts only, no results.
   ========================================================================= */
add_action('init', function () {
    register_post_type('rl_project', [
        'label' => 'Projects', 'labels' => ['name' => 'Projects', 'singular_name' => 'Project'],
        'public' => true, 'has_archive' => false, 'show_in_rest' => true, 'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'author', 'excerpt', 'revisions'],
        'rewrite' => ['slug' => 'portfolio', 'with_front' => false],
    ]);
});

function rl_is_project() { return is_singular('rl_project'); }

/* production URLs /projects/<slug>/ (and the old Yoast redirect access-tutor-copy) go to /portfolio/<slug>/ with a 301 (D-126) */
add_action('template_redirect', function () {
    $path = trim((string) wp_parse_url(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '', PHP_URL_PATH), '/');
    if (!preg_match('#^projects/([a-z0-9-]+)$#', $path, $m)) return;
    $slug = $m[1] === 'access-tutor-copy' ? 'inpace-shop' : $m[1];
    $post = get_page_by_path($slug, OBJECT, 'rl_project');
    if ($post && $post->post_status === 'publish') { wp_safe_redirect(get_permalink($post), 301); exit; }
}, 1);

/* keyed by post slug */
function rl_project_details() {
    return [
        'inpace-shop' => [
            'name' => 'Inpace Shop', 'tagline' => 'An online store for cameras and computer accessories',
            'lede' => 'INPACE Shop sells camera equipment and computer accessories from three shops in Dhaka: BCS Computer City in Agargaon, Multiplan Center and Eastern Plus. We rebuilt its online store on WooCommerce so customers can find products, pay and track their orders.',
            'facts' => [['Client', 'INPACE Management Services Limited'], ['Industry', 'E-commerce'], ['Project', 'August to October 2021'], ['Team', 'Senior developer, product photographer, client service manager, project manager'], ['Work', 'E-commerce development, product photography, social media management']],
            'ind' => 'industries/ecommerce', 'site' => 'https://inpaceshop.com/', 'type' => 'E-commerce website',
            'needed_intro' => 'The old store was hard to use. Its design was dated and busy, so shoppers struggled to find what they came for.',
            'needed' => ['Pages loaded slowly', 'Navigation was broken', 'Few payment and shipping options', 'Many visitors left before reaching a product'],
            'built' => [
                ['A WooCommerce store', 'A new store with customer accounts to manage orders, order tracking, and a payment gateway connected for secure checkout.'],
                ['Search and navigation', 'Clear categories and product search, so customers reach the right camera or accessory in a few clicks.'],
                ['Real product photos', 'We photographed the products in stock, so shoppers see what they will receive rather than stock images.'],
                ['Faster pages', 'Hosting on Kinsta with caching, automatic backups and SSL, plus compressed images and minified code.'],
            ],
            'stack' => ['WordPress', 'WooCommerce', 'Kinsta hosting', 'Product photography', 'Social media'],
            'got' => ['A rebuilt store that is easier to browse and buy from', 'Order tracking and customer accounts', 'Photos of the real products', 'A faster, secured site with automatic backups'],
            'date' => '2023-03-21 11:32:24',
        ],
        'access-tutor' => [
            'name' => 'AccessTUTOR', 'tagline' => 'An online tutoring platform for exam students',
            'lede' => 'AccessTUTOR, part of Accesstel, connects students with private tutors in Maths, Science, English and other subjects. We designed and built the platform for students preparing for HSC and university admission exams.',
            'facts' => [['Client', 'Accesstel'], ['Industry', 'Education'], ['Project', 'July to September 2021'], ['Team', 'Senior developer, UX and UI designer, client manager, project manager'], ['Work', 'Landing page design, branding, front-end and back-end development']],
            'ind' => 'industries/education', 'site' => '', 'type' => 'Web application',
            'needed_intro' => 'AccessTUTOR wanted an online learning platform where students take classes with tutors, and which the team could grow over time.',
            'needed' => ['Course management that is simple for tutors', 'Quizzes and exams so students can track progress', 'Video classes through Google Meet', 'A platform that works on phones as well as computers'],
            'built' => [
                ['Course management', 'Tutors set up courses with videos, audio and other media, and add quizzes and exams so students can check what they have learned.'],
                ['A flexible back end', 'Built with Python, Django and a relational database, so new features and new courses can be added as the platform grows.'],
                ['Google Meet in the dashboard', 'Google did not then allow other platforms to schedule and start Meet calls automatically. We used the Google Meet API to bring each call\'s date, time and participants into the dashboard, so the team manages classes in one place.'],
                ['Built for every screen', 'A responsive front end that works on desktops, laptops, tablets and phones, with a clean interface students can find their way around.'],
            ],
            'stack' => ['Python', 'Django', 'Relational database', 'Google Meet API', 'Responsive front end'],
            'got' => ['A tutoring platform with its own brand and landing page', 'Course management with quizzes and exams', 'Video class details in one dashboard', 'A design that works on any device'],
            'date' => '2023-03-16 10:00:00',
        ],
        'iba-alumni-lottery' => [
            'name' => 'IBA Alumni Lottery', 'tagline' => 'A reunion website with an alumni database and a fair prize draw',
            'lede' => 'The IBA Alumni Association brings together graduates of the Institute of Business Administration, a business school in Bangladesh. For its reunion we built one website: a database of alumni, online registration, and a prize draw that picks winners at random.',
            'facts' => [['Client', 'IBA Alumni Association'], ['Industry', 'Education'], ['Project', 'August to October 2021'], ['Team', 'Front-end and back-end developers'], ['Work', 'Full stack web development']],
            'ind' => 'industries/education', 'site' => '', 'type' => 'Web application',
            'needed_intro' => 'The association wanted a central place for its alumni and for the reunion programme.',
            'needed' => ['All reunion information in one place', 'A database of alumni that stays up to date', 'Online registration for the reunion', 'A prize draw that everyone can trust'],
            'built' => [
                ['Alumni database', 'A MySQL database of alumni with graduation years and contact details, easy to update as new graduates join.'],
                ['Reunion registration', 'Alumni register for the reunion online, from a phone or a computer.'],
                ['A random prize draw', 'A custom draw in Python and Django picks a registered alumnus at random, and alumni see the results on the site, so the draw is fair and open.'],
                ['What it taught us', 'Python, Django and jQuery were new to some of the team, and the draw logic took real problem solving. The project made us better at working through a hard brief together.'],
            ],
            'stack' => ['Python', 'Django', 'MySQL', 'jQuery'],
            'got' => ['One website for the reunion', 'An alumni database that can be kept current', 'Online registration', 'A random draw with results anyone can check'],
            'date' => '2023-03-21 12:02:47',
        ],
    ];
}
function rl_project_current() {
    if (!rl_is_project()) return null;
    $d = rl_project_details(); $s = get_post_field('post_name', get_queried_object_id());
    return isset($d[$s]) ? $d[$s] + ['slug' => $s] : null;
}
/* the Portfolio card links to the project page when one is published */
function rl_project_url_by_name($name) {
    foreach (rl_project_details() as $slug => $p) {
        if ($p['name'] !== $name) continue;
        $post = get_page_by_path($slug, OBJECT, 'rl_project');
        return ($post && $post->post_status === 'publish') ? get_permalink($post) : '';
    }
    return '';
}

add_filter('body_class', function ($c) { if (rl_is_project()) $c[] = 'rl-project-page'; return $c; });
/* full width: no blog sidebar on project pages */
add_filter('theme_mod_fl-blog-layout', function ($v) { return rl_is_project() ? 'no-sidebar' : $v; });
add_filter('fl_theme_mods', function ($m) { if (rl_is_project()) $m['fl-blog-layout'] = 'no-sidebar'; return $m; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_project(); });
/* the portfolio CSS (cards, chips, panel) is shared with the project pages */
add_action('wp_head', function () { if (rl_is_project() && !rl_is_portfolio()) { rl_portfolio_css_body(); } }, 22);

add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !($p = rl_project_current())) return $graph;
    $url = get_permalink(get_queried_object_id());
    $org = home_url('/#organization');
    $facts = array_column($p['facts'], 1, 0);
    $work = ['@type' => 'CreativeWork', '@id' => $url . '#project', 'name' => $p['name'], 'headline' => $p['tagline'], 'description' => $p['lede'], 'creator' => ['@id' => $org], 'sourceOrganization' => ['@type' => 'Organization', 'name' => $facts['Client']], 'genre' => $p['type'], 'keywords' => implode(', ', $p['stack']), 'dateCreated' => '2021'];
    if ($p['site']) $work['url'] = $p['site'];
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        if (in_array('WebPage', (array) $n['@type'], true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) { $n['mainEntity'] = ['@id' => $url . '#project']; $n['about'] = ['@id' => $url . '#project']; }
    }
    unset($n);
    $graph[] = $work;
    return $graph;
}, 20);

/* Yoast breadcrumb: Home > Portfolio > project */
add_filter('wpseo_breadcrumb_links', function ($links) {
    if (!rl_is_project() || count($links) < 2) return $links;
    $pf = get_page_by_path('portfolio');
    if ($pf) array_splice($links, 1, 0, [['url' => get_permalink($pf), 'text' => 'Portfolio', 'id' => $pf->ID]]);
    return $links;
});

add_shortcode('reinforce_project', 'rl_render_project');
function rl_render_project() {
    $p = rl_project_current();
    if (!$p) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $ext = ' rel="noopener" target="_blank"';
    $others = array_filter(rl_project_details(), function ($k) use ($p) { return $k !== $p['slug']; }, ARRAY_FILTER_USE_KEY);
    ob_start(); ?>
<div class="rl-page rl-portfolio rl-project">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('portfolio'); ?>">Portfolio</a></li>
  <li><span aria-current="page"><?php echo esc_html($p['name']); ?></span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Project&nbsp;&middot;&nbsp;<?php echo esc_html($p['type']); ?>&nbsp;<b>]</b></span>
      <h1 class="h1"><?php echo esc_html($p['name']); ?><br><span class="r pj-tag"><?php echo esc_html($p['tagline']); ?></span></h1>
      <p class="lede"><?php echo esc_html($p['lede']); ?></p>
      <div class="cta-row">
        <a class="btn p" href="#built">What we built <span class="ar">&rarr;</span></a>
        <?php if ($p['site']) echo '<a class="btn g" href="' . esc_url($p['site']) . '"' . $ext . '>Visit the site</a>'; else echo '<a class="btn g" href="' . $u('portfolio') . '">All projects</a>'; ?>
      </div>
    </div>
    <aside class="p-panel pj-panel" aria-label="Project facts">
      <div class="p-shot"><?php echo rl_portfolio_frame($p['type'], 'h'); ?><span class="tag"><?php echo esc_html($p['type']); ?></span></div>
      <dl class="pj-facts"><?php foreach ($p['facts'] as $f) {
          $v = esc_html($f[1]);
          if ($f[0] === 'Industry') $v = '<a href="' . $u($p['ind']) . '">' . $v . '</a>';
          echo '<div><dt>' . esc_html($f[0]) . '</dt><dd>' . $v . '</dd></div>';
      } ?></dl>
    </aside>
  </div>
</section>

<section id="needed">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The brief&nbsp;<b>]</b></span><h2>What did <?php echo esc_html($p['name']); ?> need?</h2></div>
    <div class="pj-two">
      <p class="pj-intro"><?php echo esc_html($p['needed_intro']); ?></p>
      <ul class="p-built"><?php foreach ($p['needed'] as $n) echo '<li>' . $ok . '<span>' . esc_html($n) . '</span></li>'; ?></ul>
    </div>
  </div>
</section>

<section class="band alt" id="built">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The work&nbsp;<b>]</b></span><h2>What did Reinforce Lab build?</h2></div>
    <div class="pj-blocks"><?php foreach ($p['built'] as $i => $b) echo '<article class="pj-b"><span class="n">0' . ($i + 1) . '</span><h3>' . esc_html($b[0]) . '</h3><p>' . esc_html($b[1]) . '</p></article>'; ?></div>
    <div class="pj-stack"><span class="lbl">Built with</span><ul class="chips"><?php foreach ($p['stack'] as $s) echo '<li>' . esc_html($s) . '</li>'; ?></ul></div>
  </div>
</section>

<section id="delivered">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Delivered&nbsp;<b>]</b></span><h2>What the client got</h2></div>
    <ul class="p-built pj-got"><?php foreach ($p['got'] as $g) echo '<li>' . $ok . '<span>' . esc_html($g) . '</span></li>'; ?></ul>
    <p class="p-note"><b>About results.</b> This page describes the work we delivered. We publish traffic or sales figures only when we can show their source and the client agrees.</p>
  </div>
</section>

<section class="band alt" id="more">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;More work&nbsp;<b>]</b></span><h2>Other projects</h2></div>
    <div class="p-work pj-more">
      <?php foreach ($others as $slug => $o) { $ou = rl_project_url_by_name($o['name']); if (!$ou) continue; echo '<a href="' . esc_url($ou) . '"><b>' . esc_html($o['name']) . '</b><span>' . esc_html($o['tagline']) . '</span><em>' . esc_html($o['type']) . ' &rarr;</em></a>'; } ?>
      <a href="<?php echo $u('portfolio'); ?>"><b>All projects</b><span>Stores, web applications and websites we have built.</span><em>Portfolio &rarr;</em></a>
    </div>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Planning a site or a platform like this?</h2>
      <p class="lede">Tell us what you need, or start with the free Search Authority Diagnostic to see what to fix first on your current site.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('contact-us'); ?>">Contact us</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
