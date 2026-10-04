<?php
/**
 * Plugin Name: Reinforce Lab - Local SEO
 * Description: /services/local-seo/ (D-023 new slug; production legacy /best-local-search-engine-optimization-service/ decision pending - O-017) - Local SEO service page. Provides [reinforce_local]. Uses the shared kit (D-044). Hero animation "Local pack" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_local() { return is_page('local-seo'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_local_faqs() {
    return [
        ['What is local SEO?', 'Local SEO (local search engine optimization) makes a business visible when people nearby search for what it offers: in Google’s local results and Maps, on Apple Maps and Bing, and in AI answers. It covers the Google Business Profile and other map listings, consistent business details across directories, reviews, location and service-area pages, local structured data and local links.'],
        ['How does Google rank local results?', 'Google says local results are mainly based on relevance, distance and prominence: how well a profile matches the search, how far the business is from the searcher, and how well known it is, including links and reviews. Google also says there is no way to request or pay for a better local ranking.'],
        ['Can we add keywords to our Google Business Profile name?', 'No. Google’s guidelines say the name should reflect your real-world business name, as used on signage and stationery, and that adding unnecessary information to it is not permitted and can lead to the profile being suspended.'],
        ['How should we get more reviews?', 'Ask every customer, not only the happy ones, and make it easy for them. Google prohibits offering incentives for reviews and selectively asking for positive ones, and the US FTC’s rule on fake reviews, announced in August 2024, bans buying or selling fake reviews. Replying to reviews shows customers you value their feedback.'],
        ['We don’t have a shopfront. Can we still do local SEO?', 'Yes. Google treats you as a service-area business: one profile for your central office with the areas you serve, and your address hidden from customers. You can’t list virtual offices unless they are staffed during business hours, so we build visibility through service-area pages, not fake locations.'],
        ['Does local SEO help in AI search?', 'It can. OpenAI says ChatGPT search can use your location and sometimes works with other search providers for local results, and Google offers Gemini grounding with Google Maps data. Accurate, consistent listings and clear location pages give these tools correct facts to use, though no one controls what an AI answers.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with local SEO points (D-047) */
function rl_local_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Offices, sites and facilities listed accurately on every map', 'Clinical-trial site and location pages kept compliant and current', 'Company details consistent across medical and industry directories']],
        ['healthcare', 'Healthcare', ['Practice and practitioner profiles set up within Google’s rules', 'Review requests that respect patient privacy', 'Location pages with services, hours and accessibility details']],
        ['b2b-saas', 'B2B SaaS', ['Regional offices and city pages for teams that sell locally', 'Company details consistent across software directories and maps', 'Local partner, event and community mentions']],
        ['ecommerce', 'E-commerce', ['Store locator and store pages for every physical location', 'Hours, stock and collection details consistent across maps', 'Store-level reviews managed location by location']],
        ['manufacturing', 'Manufacturing', ['Plants, depots and showrooms listed accurately on every map', 'Service-area profiles for field engineers and installers', 'Consistent listings in industrial directories and trade associations']],
        ['technology', 'Technology', ['Office and support-centre listings consistent across maps', 'Service-area pages for on-site IT and installation work', 'Local partner and reseller listings aligned with yours']],
        ['professional-services', 'Professional Services', ['A profile for each real office: no virtual-office risk', 'Practice-area pages for each city you serve', 'Client reviews gathered within Google’s rules']],
        ['education', 'Education', ['Campus and admissions-office listings on Google, Apple and Bing', 'Campus pages with directions, open days and contacts', 'Consistent campus and department names across directories']],
    ];
}

/* ---------- hero animation: Local pack ----------
   A "near me" search goes out; ripples spread from the searcher across a street map; business pins
   drop; Google's three local factors light in turn - relevance, distance (the dashed line to your
   pin) and prominence (your pin's halo); then the local results list builds and your listing lights,
   with profile · reviews · citations checked. 10 s loop, soft fade, reset. */
function rl_local_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlLoT"><title id="rlLoT">A nearby customer searches; Google weighs relevance, distance and prominence; your business appears in the local results with a complete profile, genuine reviews and consistent citations.</title>'
        . '<defs><clipPath id="rlloMap"><rect x="0" y="40" width="300" height="260"/></clipPath></defs>';
    $s .= '<rect class="o-q" x="0" y="0" width="300" height="28"/><text class="o-qt" x="12" y="18">ACCOUNTANT NEAR ME</text><rect class="o-caret" x="152" y="9" width="2" height="11"/>';
    $s .= '<rect class="o-map" x="0" y="40" width="300" height="260"/><g clip-path="url(#rlloMap)" class="o-streets">';
    foreach ([70, 120, 175, 230, 280] as $y) $s .= '<line x1="0" y1="' . $y . '" x2="300" y2="' . ($y + 6) . '"/>';
    foreach ([40, 105, 165, 225, 275] as $x) $s .= '<line x1="' . $x . '" y1="40" x2="' . ($x - 8) . '" y2="300"/>';
    $s .= '<path class="o-road" d="M0 250 C80 220 140 200 300 110"/>';
    for ($i = 0; $i < 3; $i++) $s .= '<circle class="o-rip o-rip' . $i . '" cx="150" cy="180" r="100"/>';
    $s .= '<path class="o-dist" pathLength="100" d="M150 180 L196 128"/></g>';
    $pin = function ($cls, $x, $y) { return '<g class="o-pin ' . $cls . '"><path d="M' . $x . ' ' . $y . ' c-7 -9 -10 -13 -10 -18 a10 10 0 0 1 20 0 c0 5 -3 9 -10 18z"/><circle cx="' . $x . '" cy="' . ($y - 18) . '" r="3.5"/></g>'; };
    $s .= $pin('o-c o-c0', 70, 96) . $pin('o-c o-c1', 250, 78) . $pin('o-c o-c2', 238, 268);
    $s .= '<circle class="o-halo" cx="196" cy="110" r="22"/>' . $pin('o-you', 196, 128);
    $s .= '<circle class="o-me" cx="150" cy="180" r="5"/><circle class="o-me2" cx="150" cy="180" r="10"/>';
    $s .= '<text class="o-lab" x="320" y="18">LOCAL RESULTS</text><line class="o-rule" x1="320" y1="28" x2="520" y2="28"/>';
    $rows = [['o-r0', 40, 'COMPETITOR'], ['o-r1', 110, 'YOUR BUSINESS'], ['o-r2', 180, 'COMPETITOR']];
    foreach ($rows as $r) {
        $s .= '<g class="o-row ' . $r[0] . '"><rect class="o-rb" x="320" y="' . $r[1] . '" width="200" height="60"/><text class="o-rn" x="332" y="' . ($r[1] + 20) . '">' . $r[2] . '</text>'
            . '<rect class="o-bar" x="332" y="' . ($r[1] + 28) . '" width="120" height="4"/><rect class="o-bar" x="332" y="' . ($r[1] + 37) . '" width="90" height="4"/></g>';
    }
    $s .= '<rect class="o-you-row" x="320" y="110" width="200" height="60"/><text class="o-you-t" x="332" y="130">YOUR BUSINESS</text>';
    foreach (['PROFILE', 'REVIEWS', 'CITATIONS'] as $i => $c) $s .= '<text class="o-chk o-chk' . $i . '" x="' . (332 + $i * 62) . '" y="160">+ ' . $c . '</text>';
    $s .= '<line class="o-rule" x1="0" y1="318" x2="520" y2="318"/>';
    foreach (['RELEVANCE', 'DISTANCE', 'PROMINENCE'] as $i => $f) {
        $x = $i * 178;
        $s .= '<text class="o-ft" x="' . $x . '" y="344">' . $f . '</text><text class="o-ft o-fton o-f' . $i . '" x="' . $x . '" y="344">' . $f . '</text>'
            . '<rect class="o-fb" x="' . $x . '" y="356" width="150" height="3"/><rect class="o-fbon o-fb' . $i . '" x="' . $x . '" y="356" width="150" height="3"/>';
    }
    $s .= '<text class="o-src" x="0" y="386">GOOGLE’S THREE LOCAL FACTORS: RELEVANCE · DISTANCE · PROMINENCE</text>';
    return $s . '</svg>';
}
function rl_local_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = "@keyframes rlloType{0%,2%{opacity:0}4%,92%{opacity:1}97%,100%{opacity:0}}\n";
    for ($i = 0; $i < 3; $i++) { $s = 6 + $i * 5; $k .= "@keyframes rlloRip$i{0%,{$s}%{transform:scale(.08);opacity:0}" . ($s + 1) . "%{opacity:.7}" . ($s + 16) . "%,100%{transform:scale(1.2);opacity:0}}\n.rl-local .o-rip$i{animation-name:rlloRip$i}\n"; }
    foreach ([0, 1, 2] as $i) { $s = 8 + $i * 2; $k .= "@keyframes rlloC$i{0%,{$s}%{transform:translateY(-10px);opacity:0}" . ($s + 3) . "%,92%{transform:translateY(0);opacity:1}97%,100%{transform:translateY(0);opacity:0}}\n.rl-local .o-c$i{animation-name:rlloC$i}\n"; }
    $k .= "@keyframes rlloYou{0%,14%{transform:translateY(-10px);opacity:0}17%,92%{transform:translateY(0);opacity:1}97%,100%{transform:translateY(0);opacity:0}}\n";
    $f = [20, 30, 40];
    for ($i = 0; $i < 3; $i++) {
        $s = $f[$i];
        $k .= $lit("rlloF$i", $s, $s + 3) . "@keyframes rlloFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n";
        $k .= ".rl-local .o-f$i{animation-name:rlloF$i}.rl-local .o-fb$i{animation-name:rlloFb$i}\n";
    }
    $k .= "@keyframes rlloDist{0%,30%{opacity:0}36%,92%{opacity:1}97%,100%{opacity:0}}\n";
    $k .= "@keyframes rlloHalo{0%,40%{transform:scale(.6);opacity:0}44%{opacity:.9}52%,100%{transform:scale(1.3);opacity:0}}\n";
    foreach ([0, 1, 2] as $i) { $s = 50 + $i * 3; $k .= $lit("rlloR$i", $s, $s + 3) . ".rl-local .o-r$i{animation-name:rlloR$i}\n"; }
    $k .= $lit('rlloYr', 60, 63);
    foreach ([0, 1, 2] as $i) { $s = 64 + $i * 3; $k .= $lit("rlloK$i", $s, $s + 2) . ".rl-local .o-chk$i{animation-name:rlloK$i}\n"; }
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_local()) $c[] = 'rl-local-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_local(); });
add_action('wp_head', 'rl_local_css', 22);
function rl_local_css() {
    if (!rl_is_local()) return; ?>
<style id="rl-local-css">
body.rl-local-page .fl-page-content,body.rl-local-page .fl-content,body.rl-local-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-local .lpk{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-local .lpk .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-local .lpk .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-local .lpk svg{display:block;width:100%;height:auto;overflow:visible}
.rl-local .o-q,.rl-local .o-map{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-local .o-qt{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.12em;fill:var(--ink);animation:rlloType 10s linear infinite both}
.rl-local .o-caret{fill:var(--red-3);animation:rlloBlink 1s steps(1) infinite}
@keyframes rlloBlink{50%{opacity:0}}
.rl-local .o-streets line{stroke:rgba(243,237,230,.06);stroke-width:6}
.rl-local .o-road{fill:none;stroke:rgba(243,237,230,.09);stroke-width:10}
.rl-local .o-rip{fill:none;stroke:var(--red-2);stroke-width:1;transform-box:fill-box;transform-origin:50% 50%;opacity:0}
.rl-local .o-dist{fill:none;stroke:var(--red-3);stroke-width:1.4;stroke-dasharray:4 4;animation:rlloDist 10s cubic-bezier(.45,0,.2,1) infinite both}
.rl-local .o-pin path{fill:#3a3234;stroke:rgba(243,237,230,.25);stroke-width:1}.rl-local .o-pin circle{fill:var(--bg)}
.rl-local .o-you path{fill:var(--red-2);stroke:var(--red-3)}.rl-local .o-you circle{fill:#fff}
.rl-local .o-you{animation:rlloYou 10s cubic-bezier(.45,0,.2,1) infinite both}
.rl-local .o-halo{fill:none;stroke:var(--red-3);stroke-width:1.2;transform-box:fill-box;transform-origin:50% 50%;opacity:0;animation:rlloHalo 10s ease-out infinite both}
.rl-local .o-me{fill:#fff}.rl-local .o-me2{fill:none;stroke:rgba(255,255,255,.5);stroke-width:1}
.rl-local .o-lab{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-local .o-rule{stroke:var(--line-2);stroke-width:1}
.rl-local .o-row{opacity:0}
.rl-local .o-rb{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-local .o-rn{font-family:var(--f-mono);font-size:9px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-local .o-bar{fill:rgba(255,255,255,.10)}
.rl-local .o-you-row{fill:rgba(153,0,0,.12);stroke:var(--red-2);stroke-width:1;opacity:0;animation-name:rlloYr}
.rl-local .o-you-t{font-family:var(--f-mono);font-size:9px;letter-spacing:.12em;fill:#fff;opacity:0;animation-name:rlloYr}
.rl-local .o-chk{font-family:var(--f-mono);font-size:8px;letter-spacing:.08em;fill:var(--red-3);opacity:0}
.rl-local .o-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-local .o-fton{fill:var(--ink);opacity:0}
.rl-local .o-fb{fill:rgba(255,255,255,.08)}
.rl-local .o-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-local .o-src{font-family:var(--f-mono);font-size:7px;letter-spacing:.1em;fill:var(--ink-faint)}
.rl-local .o-rip,.rl-local .o-c,.rl-local .o-row,.rl-local .o-you-row,.rl-local .o-you-t,.rl-local .o-chk,.rl-local .o-fton,.rl-local .o-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-local .o-rip{animation-timing-function:ease-out}
@media(max-width:560px){.rl-local .o-qt{font-size:11px;letter-spacing:.04em}.rl-local .o-rn,.rl-local .o-you-t{font-size:10.5px;letter-spacing:.02em}.rl-local .o-chk{font-size:9px;letter-spacing:0}.rl-local .o-ft{font-size:11px;letter-spacing:.04em}.rl-local .o-src{display:none}.rl-local .lpk .cap span+span{display:none}.rl-local .lpk{padding:16px 10px 10px}}
<?php echo rl_local_kf(); ?>
/* three factors */
.rl-local .factors{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:820px){.rl-local .factors{grid-template-columns:1fr}}
.rl-local .factor{border:1px solid var(--glass-line);background:var(--glass);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:10px}
.rl-local .factor .n{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-local .factor h3{font-size:20px}
.rl-local .factor p{color:var(--ink-dim);font-size:14.5px}
.rl-local .factor .we{margin-top:auto;border-top:1px solid var(--line);padding-top:10px;color:var(--ink);font-size:14px}
.rl-local .factor .we b{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;color:var(--red-3);font-weight:500;text-transform:uppercase;margin-right:6px}
.rl-local .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_local() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Local SEO', 'alternateName' => 'Local search engine optimization',
        'serviceType' => 'Local search engine optimization', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Local SEO makes a business visible when people nearby search for what it offers (in Google’s local results and Maps, Apple Maps, Bing and AI answers) through Google Business Profile management, consistent citations, compliant reviews, location and service-area pages, LocalBusiness structured data and local links.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_local_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_local', 'rl_render_local');
function rl_render_local() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $gb = function ($id) { return esc_url('https://support.google.com/business/answer/' . $id); };
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-local">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Local SEO</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Local SEO&nbsp;<b>]</b></span>
      <h1 class="h1">Get found by<br>customers<br><span class="r">near you.</span></h1>
      <p class="lede"><strong>Local SEO</strong> (local search engine optimization) makes your business visible when people nearby search for what you offer: in Google's local results and Maps, on Apple Maps and Bing, and in AI answers. Reinforce Lab builds the profiles, citations, reviews and location pages that local visibility depends on, within Google's own guidelines.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#rules">Listing rules</a>
      </div>
    </div>
    <figure class="lpk rl-anim">
      <div class="cap" aria-hidden="true"><span>Local search</span><span>Relevance · distance · prominence</span></div>
      <?php echo rl_local_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="rank">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How local ranking works&nbsp;<b>]</b></span><h2>How does Google rank local results?</h2><p class="lede">Google names three things. Two of them you can improve. One you can't, and anyone promising otherwise is guessing.</p></div>
    <div class="factors">
      <div class="factor"><span class="n">01 · Relevance</span><h3>Does your listing match the search?</h3><p>How well your profile and pages match what someone is looking for.</p><p class="we"><b>We improve</b>Categories, services, descriptions and location pages that say exactly what you do.</p></div>
      <div class="factor"><span class="n">02 · Distance</span><h3>How far away are you?</h3><p>How close your business is to the searcher, or to the place they searched for.</p><p class="we"><b>We can't change</b>Your location, so we make sure every real location and service area is listed correctly.</p></div>
      <div class="factor"><span class="n">03 · Prominence</span><h3>How well known are you?</h3><p>How recognised your business is, online and off, including links, articles and reviews.</p><p class="we"><b>We improve</b>Reviews, consistent citations, local links and mentions.</p></div>
    </div>
    <p class="quote">"There's no way to request or pay for a better local ranking on Google."<br>Google Business Profile Help</p>
    <p class="src">Source: Google, <a href="<?php echo $gb(7091); ?>" rel="noopener" target="_blank">Tips to improve your local ranking</a></p>
  </div>
</section>

<section id="check">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we do&nbsp;<b>]</b></span><h2>What does local SEO cover?</h2><p class="lede">Nine areas, each checked against the platform's own rules.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Google</span><h3>Google Business Profile</h3><p>Complete, accurate profiles (name, categories, services, hours, photos and posts) managed within Google's guidelines.</p></div>
      <div class="cell"><span class="n">02 · Apple &amp; Bing</span><h3>Every map, Google included</h3><p>Apple Business Connect and Bing Places kept in step, so Siri, Apple Maps and Bing show the same facts.</p></div>
      <div class="cell"><span class="n">03 · Citations</span><h3>Consistent business details</h3><p>Name, address and phone the same across directories and data sources, with duplicates cleaned up.</p></div>
      <div class="cell"><span class="n">04 · Reviews</span><h3>A compliant review program</h3><p>Ask every customer, reply helpfully, and never incentivise or filter, as Google and the FTC require.</p></div>
      <div class="cell"><span class="n">05 · Pages</span><h3>Location &amp; service-area pages</h3><p>A useful page for each real location or service area, never thin copies with the city name swapped.</p></div>
      <div class="cell"><span class="n">06 · Schema</span><h3>LocalBusiness structured data</h3><p>Markup that matches each location page, with the name and address Google requires.</p></div>
      <div class="cell"><span class="n">07 · Authority</span><h3>Local links &amp; mentions</h3><p>Chambers, associations, partners, events and local press that make you better known where you work.</p></div>
      <div class="cell"><span class="n">08 · AI search</span><h3>Local answers in AI</h3><p>Accurate listings and location facts that AI tools with local and map data can use, checked, not assumed.</p></div>
      <div class="cell"><span class="n">09 · Tracking</span><h3>Calls, directions &amp; leads</h3><p>Profile actions, location-page conversions and map visibility across your service area.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="rules">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Rules that protect your listing&nbsp;<b>]</b></span><h2>Which local SEO tactics break the rules?</h2><p class="lede">Some common tactics can get a profile suspended or break consumer law. Here is what Google and the FTC actually say.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Add city and service keywords to your business name."</p></div><div class="f"><span class="tag">Google says</span><p>Your name should reflect your real-world business name. Adding unnecessary information isn't permitted and could result in suspension of your profile.</p><a href="<?php echo $gb(3038177); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Offer a discount in exchange for a review."</p></div><div class="f"><span class="tag">Google says</span><p>Incentives for posting, changing or removing reviews are strictly prohibited. The US FTC's final rule (August 2024) also bans buying or selling fake reviews.</p><a href="<?php echo $gb(3474122); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Only ask your happiest customers for reviews."</p></div><div class="f"><span class="tag">Google says</span><p>Businesses may not discourage negative reviews or selectively ask for positive ones.</p><a href="https://support.google.com/contributionpolicy/answer/7400114" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Get a virtual office in every city you want to rank in."</p></div><div class="f"><span class="tag">Google says</span><p>You can't list a virtual office unless it is staffed during business hours. Service-area businesses get one profile with the areas they serve.</p><a href="<?php echo $gb(3038177); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"You can pay Google to rank higher on the map."</p></div><div class="f"><span class="tag">Google says</span><p>There's no way to request or pay for a better local ranking. (Ads are separate and labelled as ads.)</p><a href="<?php echo $gb(7091); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
    <p class="src">FTC: <a href="https://www.ftc.gov/news-events/news/press-releases/2024/08/federal-trade-commission-announces-final-rule-banning-fake-reviews-testimonials" rel="noopener" target="_blank">Final rule banning fake reviews and testimonials</a>, 14 August 2024</p>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does a local SEO engagement run?</h2><p class="lede">Foundations first, then the work that builds on them.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Local audit</h3><p>Profiles, citations, reviews, location pages and competitors, mapped across your service area.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Fix the foundations</h3><p>Claim and correct Google, Apple and Bing listings, and clean up inconsistent details.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Pages &amp; schema</h3><p>Build useful location and service-area pages with matching structured data.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Reviews &amp; authority</h3><p>Start a compliant review program and earn local links and mentions.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Measure &amp; expand</h3><p>Track visibility and leads per location, then roll out to the next area.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Local audit</b>: listings, citations, reviews, pages and competitors per location.</li>
      <li><b>Optimised profiles</b>: Google Business Profile, Apple Business Connect and Bing Places.</li>
      <li><b>Citation clean-up</b>: consistent details and duplicates resolved.</li>
      <li><b>Location &amp; service-area pages</b>: useful, unique and linked to your services.</li>
      <li><b>LocalBusiness schema</b>: for every location page.</li>
      <li><b>Review program</b>: request flow, reply guidelines and policy safeguards.</li>
      <li><b>Local authority plan</b>: associations, partners, events and press.</li>
      <li><b>Monthly local report</b>: visibility, calls, directions and leads by location.</li>
    </ul>
  </div>
</section>

<section id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure local SEO?</h2><p class="lede">By what local visibility turns into, not by a single ranking check from one spot.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Map visibility across your area</h3><p>Where you appear in local results across a grid of points around your area.</p></div>
      <div class="metric"><h3>Profile actions</h3><p>Calls, direction requests and website clicks from your profiles.</p></div>
      <div class="metric"><h3>Reviews</h3><p>Volume, rating and reply rate over time, per location.</p></div>
      <div class="metric"><h3>Citation accuracy</h3><p>Share of listings with correct, consistent business details.</p></div>
      <div class="metric"><h3>Location-page leads</h3><p>Enquiries and conversions from each location page.</p></div>
      <div class="metric"><h3>AI local answers</h3><p>Whether AI tools name you, and with correct details, for local prompts.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Distance is the one thing no one can change.</h2>
      <p>Someone searching three streets from a competitor will often see that competitor first, whatever anyone promises. We work on what can move: how relevant and how well known you are, the accuracy of every listing, and the quality of your location pages. And we never use tactics that put your profile at risk.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is local SEO for?</h2><p class="lede">Businesses with real locations or service areas (offices, clinics, stores, plants or field teams) whose customers search nearby.</p></div>
    <ul class="inds8">
      <?php foreach (rl_local_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Local SEO for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with local SEO?</h2><p class="lede">Local visibility rests on a healthy site and a clear brand. These services cover the rest.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Crawlability, indexation and speed, so location pages get found and indexed.'],
          ['services/international-seo', 'Multi-country', 'International SEO', 'Language and country versions for businesses with locations abroad.'],
          ['services/llm-optimization', 'Entity level', 'LLM Optimization', 'One consistent description of your business, so AI tools get your details right.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'Visibility and accurate recommendations across AI search, including local prompts.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Useful location and service content produced as a system.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your Google and AI-search performance with a prioritised fix list.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About local SEO.</h2></div>
    <?php foreach (rl_local_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Are nearby customers finding you, or a competitor?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your listings, reviews and local visibility, and shows what to fix first.</p>
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
