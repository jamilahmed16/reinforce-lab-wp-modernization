<?php
/**
 * Plugin Name: Reinforce Lab — Search Engine Optimization (core SEO pillar)
 * Description: /services/best-search-engine-optimization-services/ (production URL kept, D-023; 420k impressions / 16 months) — the core SEO pillar; Technical, On-page, Content, Authority, Local, International and Enterprise link up to it. 301 target for /services/best-on-page-seo-services/. Provides [reinforce_seo]. Uses the shared kit (D-044). Hero animation "Four pillars" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_seo() { return is_page('best-search-engine-optimization-services'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_seo_faqs() {
    return [
        ['What are SEO services?', 'SEO services — search engine optimization services — improve how search engines find, understand and rank your website, so more of the right people reach it from Google and AI search. They usually cover technical SEO, on-page optimization, content, and authority building such as digital PR, plus keyword research and reporting.'],
        ['What do SEO services include?', 'Google lists the services a good SEO provides: a review of your site content or structure, technical advice on development (hosting, redirects, error pages, JavaScript), content development, keyword research, SEO training, expertise in specific markets and geographies, and optimizing for generative AI. We cover all of them, grouped into four pillars: technical, on-page, content and authority.'],
        ['How long does SEO take to work?', 'Google says some changes take effect in a few hours and others take several months, and that you should generally wait a few weeks to judge whether a change helped. A full SEO programme builds over months: technical fixes first, then content and authority that compound over time.'],
        ['Can you guarantee a first-page or number-one ranking?', 'No — and Google itself says no one can guarantee a #1 ranking on Google, and to beware of anyone who claims to. We commit to the work, to following Google’s guidelines, and to reporting honestly what changed.'],
        ['Do I need an SEO consultant or an SEO agency?', 'If you have a team that can implement changes, a consultant who sets the strategy and standards may be enough. If you need the work done — fixes, content, outreach and reporting — a managed SEO service is usually the better fit. Google notes that small local businesses can often do much of the work themselves.'],
        ['Does SEO still matter with AI search?', 'Yes. AI search tools draw on web pages that can be crawled, understood and trusted — the same foundations SEO builds. We extend SEO with AI search optimization, so your brand is visible and described accurately in AI answers as well as in Google’s results.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with SEO points (D-047) */
function rl_seo_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Disease-area and product content reviewed for accuracy and compliance', 'Clear authorship and sources for health searches', 'Brand, product and HCP sites kept technically clean']],
        ['healthcare', 'Healthcare', ['Service, condition and location pages that answer patient questions', 'Clinician expertise shown clearly on every page', 'Local visibility for every clinic and practice']],
        ['b2b-saas', 'B2B SaaS', ['Solution, integration and comparison pages for buying-stage searches', 'Content that answers each stakeholder in the buying group', 'Organic pipeline tracked into your CRM']],
        ['ecommerce', 'E-commerce', ['Category and product pages optimised at the template level', 'Faceted navigation kept out of the crawl', 'Product structured data for rich results']],
        ['manufacturing', 'Manufacturing', ['Product, application and specification pages engineers search for', 'Technical content that turns expertise into rankings', 'Distributor and regional pages kept consistent']],
        ['technology', 'Technology', ['JavaScript sites rendered and indexed correctly', 'Documentation and developer content optimised for search', 'Authority from original research and expert commentary']],
        ['professional-services', 'Professional Services', ['Practice-area and expert pages that win high-value searches', 'Thought leadership built to rank and to be cited', 'Office and city pages for local visibility']],
        ['education', 'Education', ['Course and programme pages matched to how students search', 'Department and campus sites under one standard', 'Research and faculty expertise that earns links']],
    ];
}

/* ---------- hero animation: Four pillars ----------
   Google's three stages (crawl · index · serve) form the foundation; four pillars — technical,
   on-page, content, authority — rise in turn and carry a "search authority" beam. Each finished
   pillar moves your result up one place in the search results, until it ranks first and the AI
   overview cites it. 10 s loop, soft fade, reset. */
function rl_seo_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlSeT"><title id="rlSeT">On a foundation of crawling, indexing and serving, four pillars — technical SEO, on-page SEO, content and authority — rise in turn; with each one your page climbs the search results until it ranks first and is cited in the AI overview.</title>';
    $s .= '<rect class="s-b" x="0" y="300" width="250" height="28"/><rect class="s-on s-fnd" x="0" y="300" width="250" height="28"/><text class="s-ft" x="125" y="318" text-anchor="middle">CRAWL · INDEX · SERVE</text>';
    foreach (['TECHNICAL', 'ON-PAGE', 'CONTENT', 'AUTHORITY'] as $i => $c) {
        $x = 12 + $i * 60; $cx = $x + 20;
        $s .= '<rect class="s-col" x="' . $x . '" y="96" width="40" height="204"/><rect class="s-fill s-c' . $i . '" x="' . $x . '" y="96" width="40" height="204"/>'
            . '<text class="s-ct" transform="translate(' . ($cx + 3.5) . ' 198) rotate(-90)" text-anchor="middle">' . $c . '</text><text class="s-ct s-cton s-t' . $i . '" transform="translate(' . ($cx + 3.5) . ' 198) rotate(-90)" text-anchor="middle">' . $c . '</text>';
    }
    $s .= '<rect class="s-b" x="0" y="64" width="250" height="28"/><rect class="s-on s-beam" x="0" y="64" width="250" height="28"/><text class="s-bt" x="125" y="82" text-anchor="middle">SEARCH AUTHORITY</text><text class="s-bt s-bton" x="125" y="82" text-anchor="middle">SEARCH AUTHORITY</text>';
    $s .= '<text class="s-lab" x="0" y="40">THE FOUR PILLARS OF SEO</text>';
    $s .= '<rect class="s-q" x="290" y="0" width="230" height="28"/><text class="s-qt" x="302" y="18">SEO SERVICES</text><rect class="s-caret" x="392" y="9" width="2" height="11"/>';
    $s .= '<rect class="s-ai" x="290" y="40" width="230" height="56"/><rect class="s-on s-aion" x="290" y="40" width="230" height="56"/><text class="s-lab" x="302" y="58">AI OVERVIEW</text><rect class="s-bar" x="302" y="66" width="150" height="4"/><text class="s-cite" x="302" y="86">CITED: YOUR PAGE</text>';
    for ($k = 0; $k < 4; $k++) {
        $y = 108 + $k * 52;
        $s .= '<g class="s-r s-r' . $k . '"><rect class="s-rb" x="290" y="' . $y . '" width="230" height="44"/><text class="s-rn" x="302" y="' . ($y + 17) . '">RESULT</text><rect class="s-bar" x="302" y="' . ($y + 25) . '" width="' . [150, 130, 160, 120][$k] . '" height="4"/><rect class="s-bar" x="302" y="' . ($y + 33) . '" width="96" height="4"/></g>';
    }
    $s .= '<g class="s-you"><rect class="s-yb" x="290" y="316" width="230" height="44"/><text class="s-yt" x="302" y="333">YOUR PAGE</text><rect class="s-ybar" x="302" y="341" width="150" height="4"/><rect class="s-ybar" x="302" y="349" width="96" height="4"/></g>';
    $s .= '<text class="s-cap" x="0" y="384">BUILT ON GOOGLE’S THREE STAGES — CRAWL · INDEX · SERVE</text>';
    return $s . '</svg>';
}
function rl_seo_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = $lit('rlseFnd', 2, 5);
    $done = [];
    for ($i = 0; $i < 4; $i++) {
        $s = 8 + $i * 8; $done[] = $s + 6;
        $k .= "@keyframes rlseC$i{0%,{$s}%{transform:scaleY(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleY(1);opacity:1}97%,100%{transform:scaleY(1);opacity:0}}\n" . $lit("rlseT$i", $s + 4, $s + 6);
        $k .= ".rl-seo .s-c$i{animation-name:rlseC$i}.rl-seo .s-t$i{animation-name:rlseT$i}\n";
    }
    $k .= $lit('rlseBeam', 42, 46) . $lit('rlseAi', 50, 54) . $lit('rlseCite', 54, 57);
    /* your page climbs one slot per finished pillar; the result it passes drops one slot */
    $mv = function ($name, $steps, $dy) {
        $f = "@keyframes $name{0%{transform:translateY(0);opacity:0}2%{transform:translateY(0);opacity:1}";
        $y = 0;
        foreach ($steps as $t) { $f .= "{$t}%{transform:translateY({$y}px)}"; $y += $dy; $f .= ($t + 3) . "%{transform:translateY({$y}px)}"; }
        return $f . "92%{transform:translateY({$y}px);opacity:1}97%,100%{transform:translateY({$y}px);opacity:0}}\n";
    };
    $k .= $mv('rlseYou', $done, -52);
    for ($r = 0; $r < 4; $r++) $k .= $mv("rlseR$r", [$done[3 - $r]], 52) . ".rl-seo .s-r$r{animation-name:rlseR$r}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_seo()) $c[] = 'rl-seo-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_seo(); });
add_action('wp_head', 'rl_seo_css', 22);
function rl_seo_css() {
    if (!rl_is_seo()) return; ?>
<style id="rl-seo-css">
body.rl-seo-page .fl-page-content,body.rl-seo-page .fl-content,body.rl-seo-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-seo .pil{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-seo .pil .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-seo .pil .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-seo .pil svg{display:block;width:100%;height:auto;overflow:visible}
.rl-seo .s-b,.rl-seo .s-q,.rl-seo .s-ai,.rl-seo .s-rb{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-seo .s-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-seo .s-fnd{animation-name:rlseFnd}.rl-seo .s-beam{animation-name:rlseBeam}.rl-seo .s-aion{animation-name:rlseAi}
.rl-seo .s-ft{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.16em;fill:var(--ink-dim)}
.rl-seo .s-col{fill:rgba(255,255,255,.03);stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-seo .s-fill{fill:rgba(194,26,26,.3);stroke:rgba(226,59,59,.6);stroke-width:.8;transform-box:fill-box;transform-origin:50% 100%;transform:scaleY(0)}
.rl-seo .s-ct{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-seo .s-cton{fill:#fff;opacity:0}
.rl-seo .s-bt{font-family:var(--f-display);font-weight:600;font-size:12px;letter-spacing:.1em;fill:var(--ink-faint)}
.rl-seo .s-bton{fill:var(--ink);opacity:0;animation-name:rlseBeam}
.rl-seo .s-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-seo .s-qt{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.12em;fill:var(--ink)}
.rl-seo .s-caret{fill:var(--red-3);animation:rlseBlink 1s steps(1) infinite}
@keyframes rlseBlink{50%{opacity:0}}
.rl-seo .s-bar{fill:rgba(255,255,255,.10)}
.rl-seo .s-cite{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:var(--red-3);opacity:0;animation-name:rlseCite}
.rl-seo .s-rn{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-faint)}
.rl-seo .s-yb{fill:rgba(153,0,0,.14);stroke:var(--red-2);stroke-width:1}
.rl-seo .s-yt{font-family:var(--f-mono);font-size:9px;letter-spacing:.12em;fill:#fff}
.rl-seo .s-ybar{fill:rgba(255,255,255,.22)}
.rl-seo .s-you{animation-name:rlseYou}
.rl-seo .s-cap{font-family:var(--f-mono);font-size:7px;letter-spacing:.1em;fill:var(--ink-faint)}
.rl-seo .s-on,.rl-seo .s-fill,.rl-seo .s-cton,.rl-seo .s-bton,.rl-seo .s-cite,.rl-seo .s-r,.rl-seo .s-you{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-seo .s-ft{font-size:10px;letter-spacing:.04em}.rl-seo .s-ct{font-size:10.5px;letter-spacing:.06em}.rl-seo .s-bt{font-size:13px}.rl-seo .s-lab{font-size:9.5px;letter-spacing:.06em}.rl-seo .s-qt{font-size:11px;letter-spacing:.04em}.rl-seo .s-rn,.rl-seo .s-yt{font-size:10.5px;letter-spacing:.02em}.rl-seo .s-cite{font-size:9.5px;letter-spacing:0}.rl-seo .s-cap{display:none}.rl-seo .pil .cap span+span{display:none}.rl-seo .pil{padding:16px 10px 10px}}
<?php echo rl_seo_kf(); ?>
.rl-seo .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-seo .factors{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:820px){.rl-seo .factors{grid-template-columns:1fr}}
.rl-seo .factor{border:1px solid var(--glass-line);background:var(--glass);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:10px}
.rl-seo .factor .n{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-seo .factor h3{font-size:20px}
.rl-seo .factor p{color:var(--ink-dim);font-size:14.5px}
.rl-seo .factor .we{margin-top:auto;border-top:1px solid var(--line);padding-top:10px;color:var(--ink);font-size:14px}
.rl-seo .factor .we b{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;color:var(--red-3);font-weight:500;text-transform:uppercase;margin-right:6px}
.rl-seo .gl{margin:0 0 26px;display:flex;flex-wrap:wrap;gap:8px 10px;list-style:none;padding:0}
.rl-seo .gl li{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.06em;color:var(--ink-dim);border:1px solid var(--line-2);padding:6px 10px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_seo() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Search Engine Optimization Services', 'alternateName' => ['SEO services', 'SEO consulting'],
        'serviceType' => 'Search engine optimization', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Search engine optimization services covering the four pillars of SEO — technical SEO, on-page SEO, content and authority — built to Google’s guidelines and extended to AI search, measured in leads and revenue.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
        'hasOfferCatalog' => ['@type' => 'OfferCatalog', 'name' => 'SEO services', 'itemListElement' => array_map(function ($p) { return ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $p[0], 'url' => $p[1]]]; }, array_values(array_filter(array_map(function ($s) { $l = function_exists('rl_url_by_path') ? rl_url_by_path('services/' . $s[0], '') : ''; return $l ? [$s[1], $l] : null; }, [['technical-seo-services', 'Technical SEO'], ['seo-content-systems', 'SEO Content Systems'], ['press-release-services', 'Digital PR & Link Building'], ['local-seo', 'Local SEO'], ['international-seo', 'International SEO'], ['enterprise-seo-strategy', 'Enterprise SEO Strategy'], ['ai-search-optimization', 'AI Search Optimization']]))))],
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_seo_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_seo', 'rl_render_seo');
function rl_render_seo() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $gd = function ($p) { return esc_url('https://developers.google.com/search/docs/' . $p); };
    $sg = $gd('fundamentals/seo-starter-guide');
    $need = $gd('fundamentals/do-i-need-seo');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-seo">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Search Engine Optimization</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;SEO&nbsp;<b>]</b></span>
      <h1 class="h1">SEO services<br>that compound<br><span class="r">into authority.</span></h1>
      <p class="lede"><strong>Search engine optimization (SEO) services</strong> help search engines find, understand and trust your website, so the right customers reach you from Google and from AI answers. Reinforce Lab runs all four pillars — technical SEO, on-page SEO, content and authority — as one system, built to Google's own guidelines and measured in leads and revenue, not rankings alone.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#what">What's included</a>
      </div>
    </div>
    <figure class="pil rl-anim">
      <div class="cap" aria-hidden="true"><span>Search engine optimization</span><span>Four pillars · one system</span></div>
      <?php echo rl_seo_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What's included&nbsp;<b>]</b></span><h2>What are SEO services, and what do they include?</h2><p class="lede">Google's own list of what a good SEO provides is a fair checklist. We cover every item — organised into the disciplines below, each with its own specialist page.</p></div>
    <ul class="gl" aria-label="Services Google lists for an SEO">
      <li>Site content &amp; structure review</li><li>Technical advice</li><li>Content development</li><li>Keyword research</li><li>SEO training</li><li>Market &amp; geography expertise</li><li>Optimizing for generative AI</li>
    </ul>
    <div class="cols c3">
      <?php foreach ([
          ['services/technical-seo-services', '01 · Technical', 'Technical SEO', 'Crawling, indexing, rendering, speed and site architecture — so search engines can reach and understand every page.'],
          ['#onpage', '02 · On-page', 'On-page SEO', 'Titles, snippets, headings, internal links and structured data that tell search engines what each page is about.'],
          ['services/seo-content-systems', '03 · Content', 'SEO Content Systems', 'Keyword research, briefs and helpful content produced as a repeatable system.'],
          ['services/press-release-services', '04 · Authority', 'Digital PR &amp; Link Building', 'Coverage, links and mentions earned from relevant publications — never bought.'],
          ['services/local-seo', '05 · Local', 'Local SEO', 'Google Business Profile, citations, reviews and location pages for nearby customers.'],
          ['services/international-seo', '06 · Markets', 'International SEO', 'Country and language versions, hreflang and market-by-market launches.'],
          ['services/enterprise-seo-strategy', '07 · Scale', 'Enterprise SEO Strategy', 'Governance, templates, releases and migrations for large, complex sites.'],
          ['services/ai-search-optimization', '08 · AI search', 'AI Search Optimization', 'Visibility and accurate descriptions of your brand in AI answers.'],
          ['services/seo-ai-search-audit', '09 · Start', 'SEO &amp; AI Search Audit', 'A one-time, evidence-led review with a prioritised fix list.'],
      ] as $r) { $l = $r[0][0] === '#' ? $r[0] : $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . $r[2] . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
    <p class="src">Source: Google, <a href="<?php echo $need; ?>" rel="noopener" target="_blank">Do you need an SEO?</a></p>
  </div>
</section>

<section id="stages">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How search works&nbsp;<b>]</b></span><h2>How does Google decide what to show?</h2><p class="lede">Google works in three stages, and not every page makes it through each one. SEO makes sure yours does.</p></div>
    <div class="factors">
      <div class="factor"><span class="n">01 · Crawling</span><h3>Can Google find the page?</h3><p>Google discovers pages mainly through links and sitemaps, then downloads and renders them.</p><p class="we"><b>We make sure</b>Important pages are linked, reachable and rendered — and junk URLs don't waste the crawl.</p></div>
      <div class="factor"><span class="n">02 · Indexing</span><h3>Does Google understand it?</h3><p>Google analyses the content, picks a canonical version from duplicates, and decides whether to store it. Indexing isn't guaranteed.</p><p class="we"><b>We make sure</b>Each page is unique, clearly canonical and worth indexing.</p></div>
      <div class="factor"><span class="n">03 · Serving</span><h3>Is it the best answer?</h3><p>For each search, Google returns what it judges most relevant and highest quality, using hundreds of factors.</p><p class="we"><b>We make sure</b>The page answers the search better than the alternatives — and is trusted.</p></div>
    </div>
    <p class="quote">"Google doesn't accept payment to crawl a site more frequently, or rank it higher. If anyone tells you otherwise, they're wrong." — Google Search Central</p>
    <p class="src">Source: Google, <a href="<?php echo $gd('fundamentals/how-search-works'); ?>" rel="noopener" target="_blank">In-depth guide to how Google Search works</a></p>
  </div>
</section>

<section class="band alt" id="onpage">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;On-page SEO&nbsp;<b>]</b></span><h2>What is on-page SEO?</h2><p class="lede">On-page SEO is everything on the page itself that helps search engines and people understand it. These are the elements we optimise on every page we touch.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">Titles</span><h3>Title links</h3><p>A title unique to the page, clear and concise, that accurately describes its content.</p></div>
      <div class="cell"><span class="n">Snippets</span><h3>Meta descriptions</h3><p>A short, relevant summary that helps people decide to click from the results.</p></div>
      <div class="cell"><span class="n">Structure</span><h3>Headings &amp; readability</h3><p>Well-organised, easy-to-read content broken into sections with helpful headings.</p></div>
      <div class="cell"><span class="n">Language</span><h3>How people search</h3><p>The words your customers actually use — beginners and experts alike — written naturally, never stuffed.</p></div>
      <div class="cell"><span class="n">Links</span><h3>Internal links &amp; anchor text</h3><p>Descriptive links that connect related pages and tell search engines what each one covers.</p></div>
      <div class="cell"><span class="n">Schema</span><h3>URLs &amp; structured data</h3><p>Descriptive URLs and structured data that match what the page shows.</p></div>
    </div>
    <p class="src">Source: Google, <a href="<?php echo $sg; ?>" rel="noopener" target="_blank">SEO Starter Guide</a></p>
  </div>
</section>

<section id="myths">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Myths&nbsp;<b>]</b></span><h2>Which SEO beliefs can you stop worrying about?</h2><p class="lede">Google's own starter guide lists things it believes you shouldn't focus on. Here are five we still hear every week.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"You need the meta keywords tag."</p></div><div class="f"><span class="tag">Google says</span><p>Google Search doesn't use the keywords meta tag.</p><a href="<?php echo $sg; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Pages need at least 2,000 words to rank."</p></div><div class="f"><span class="tag">Google says</span><p>Content length alone doesn't matter for ranking — there's no magical word count target.</p><a href="<?php echo $sg; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"E-E-A-T is a ranking factor you can score."</p></div><div class="f"><span class="tag">Google says</span><p>E-E-A-T isn't a ranking factor. Showing real experience and expertise still helps people trust your content.</p><a href="<?php echo $sg; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Duplicate content gets you penalised."</p></div><div class="f"><span class="tag">Google says</span><p>Duplicate content isn't a violation of its spam policies — but it can waste crawling and confuse users, so we still fix it.</p><a href="<?php echo $sg; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"This agency can guarantee you the #1 spot."</p></div><div class="f"><span class="tag">Google says</span><p>No one can guarantee a #1 ranking on Google. Beware of anyone who claims to, or claims a "special relationship" with Google.</p><a href="<?php echo $need; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
  </div>
</section>

<section class="band alt" id="method">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Method&nbsp;<b>]</b></span><h2>How does Reinforce Lab run an SEO programme?</h2><p class="lede">Nine stages, in order. Protecting what already ranks comes before building anything new.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Discover</span><h3>Baseline</h3><p>Search Console, analytics, crawl and competitors — what ranks, what doesn't, and why.</p></div>
      <div class="cell"><span class="n">02 · Preserve</span><h3>Protect what works</h3><p>Every URL with traffic, links or impressions is kept or redirected deliberately.</p></div>
      <div class="cell"><span class="n">03 · Architect</span><h3>Site structure</h3><p>Pillars, supporting pages and internal links mapped to how customers search.</p></div>
      <div class="cell"><span class="n">04 · Content</span><h3>Helpful pages</h3><p>People-first content that answers each search better than the alternatives.</p></div>
      <div class="cell"><span class="n">05 · AI search</span><h3>Answer-ready</h3><p>Clear, citable answers and consistent entity facts for AI search.</p></div>
      <div class="cell"><span class="n">06 · Build</span><h3>Implement</h3><p>Technical fixes, templates, schema and pages built to one standard.</p></div>
      <div class="cell"><span class="n">07 · QA</span><h3>Check before launch</h3><p>Indexing, redirects, schema, speed and mobile checked page by page.</p></div>
      <div class="cell"><span class="n">08 · Launch</span><h3>Release safely</h3><p>Changes shipped in steps, not in one risky batch.</p></div>
      <div class="cell"><span class="n">09 · Monitor</span><h3>Measure &amp; iterate</h3><p>Rankings, traffic, leads and AI visibility tracked — then the next priority.</p></div>
    </div>
  </div>
</section>

<section id="b2b">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;B2B SEO&nbsp;<b>]</b></span><h2>How is B2B SEO different?</h2><p class="lede">Fewer searches, bigger deals, longer decisions. B2B SEO is judged by pipeline, not traffic.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">Buying groups</span><h3>Several people decide</h3><p>Content for each role in the decision — the user, the budget holder and the technical evaluator.</p></div>
      <div class="cell"><span class="n">Intent</span><h3>Low volume, high value</h3><p>Searches with a few dozen impressions can be worth more than thousands of casual visits.</p></div>
      <div class="cell"><span class="n">Pipeline</span><h3>Measured in revenue</h3><p>Organic leads followed into your CRM, so SEO is judged by the deals it helps create.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="consultant">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Consultant or agency&nbsp;<b>]</b></span><h2>Do you need an SEO consultant or an SEO agency?</h2><p class="lede">It depends on who will do the work. We work both ways.</p></div>
    <div class="cols c2">
      <div class="cell"><span class="n">SEO consulting</span><h3>You have the team</h3><p>We set the strategy, standards and priorities, review what your team ships, and train them. Best when you have developers and writers who can implement.</p></div>
      <div class="cell"><span class="n">Managed SEO</span><h3>You need the work done</h3><p>We do the technical fixes, content and outreach, and report on results. Best when SEO has no owner in-house.</p></div>
    </div>
    <p class="quote">"If you run a small local business, you can probably do much of the work yourself." — Google, Do you need an SEO?</p>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>SEO audit &amp; baseline</b> — technical, content, authority and competitors.</li>
      <li><b>Keyword &amp; topic map</b> — the searches that matter, mapped to pages.</li>
      <li><b>Prioritised roadmap</b> — what to fix and build first, and why.</li>
      <li><b>Technical fixes</b> — crawling, indexing, speed and structured data.</li>
      <li><b>On-page optimisation</b> — titles, snippets, headings and internal links.</li>
      <li><b>Content</b> — new and improved pages that answer real searches.</li>
      <li><b>Authority</b> — digital PR and earned links within Google's policies.</li>
      <li><b>Monthly reporting</b> — rankings, traffic, leads and AI visibility.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure SEO success?</h2><p class="lede">Rankings are a means. These are the numbers we report.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Indexed pages</h3><p>Share of the pages that matter that Google has indexed.</p></div>
      <div class="metric"><h3>Impressions &amp; clicks</h3><p>Search Console visibility for your target topics and pages.</p></div>
      <div class="metric"><h3>Rankings that matter</h3><p>Positions for the searches that bring customers, not vanity terms.</p></div>
      <div class="metric"><h3>Organic leads</h3><p>Enquiries, sign-ups and sales from organic search.</p></div>
      <div class="metric"><h3>Pipeline &amp; revenue</h3><p>Deals and revenue that organic search helped create.</p></div>
      <div class="metric"><h3>AI visibility</h3><p>Whether AI answers mention, describe and cite you correctly.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>No one can guarantee you the top spot.</h2>
      <p>Google says so itself. What we can promise is the work that makes rankings likely: a site Google can crawl and index, pages that answer searches better than the alternatives, and authority earned the right way — with every change explained and every result reported, good or bad.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who are our SEO services for?</h2><p class="lede">B2B and specialist businesses where the right customer searching at the right moment is worth real revenue.</p></div>
    <ul class="inds8">
      <?php foreach (rl_seo_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('SEO for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Beyond classic SEO&nbsp;<b>]</b></span><h2>What extends SEO into AI search?</h2><p class="lede">Search now includes AI answers. These services carry your SEO into them.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/generative-engine-optimization', 'Citations', 'GEO', 'Content structured so AI engines can quote and cite it.'],
          ['services/llm-optimization', 'Entity level', 'LLM Optimization', 'One consistent description of your brand across the sources AI models learn from.'],
          ['search-authority-os', 'System', 'Search Authority OS', 'SEO, content and AI search run as one operating system.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About SEO services.</h2></div>
    <?php foreach (rl_seo_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Where is your SEO holding you back?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your indexing, content, authority and AI-search visibility, and shows what to fix first.</p>
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
