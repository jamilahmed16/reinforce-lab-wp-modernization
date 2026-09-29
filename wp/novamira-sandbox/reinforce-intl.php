<?php
/**
 * Plugin Name: Reinforce Lab — International SEO
 * Description: /services/international-seo/ (D-023 new slug) — International SEO service page. Provides [reinforce_intl]. Uses the shared kit (D-044). Hero animation "Market routing" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_intl() { return is_page('international-seo'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_intl_faqs() {
    return [
        ['What is international SEO?', 'International SEO makes sure search engines show the right language and country version of a website to each market, and that each version can rank on its own. It covers site structure, hreflang, localized content and keyword research per market, local authority, and reporting country by country.'],
        ['Should we use country domains, subdomains or subdirectories?', 'Google compares the options: country-code domains send the clearest country signal but cost more to run; subdomains are easy to separate; subdirectories on one domain are the lowest maintenance; URL parameters are not recommended. For most B2B companies we recommend subdirectories on one strong domain, unless a legal, brand or market reason points to country domains.'],
        ['What does hreflang do?', 'hreflang tells Google which pages are language or regional versions of each other, so searchers are shown the right one. Every version must list itself and all the others, using ISO language and region codes, and an x-default version can act as the fallback when no other version matches.'],
        ['Should we redirect visitors to their country version automatically?', 'Google advises against automatically redirecting users to a different language version based on what you think their language is. Googlebot usually crawls from the USA, so automatic redirects can stop it — and users — from reaching every version. A visible language or country selector is the safer choice.'],
        ['Can we use machine translation?', 'As a starting point, yes — but not as the finished page. Google’s spam policies list automated translation that adds little value, produced at scale, as scaled content abuse. We use translation tools for drafts and have native speakers review, adapt and localize every page that matters.'],
        ['Does hreflang control which version ChatGPT or Perplexity shows?', 'No AI company documents how its assistant chooses between country or language versions of a page, so no one can promise that. We implement what Google documents, keep each version clear and consistent, and check what AI tools answer in each market and language.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with international SEO points (D-047) */
function rl_intl_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Country-specific product information kept separate where approvals and labels differ', 'HCP and patient content localized with medical and regulatory review in each market', 'hreflang only between pages that are genuinely equivalent']],
        ['healthcare', 'Healthcare', ['Services and locations presented in the languages patients use', 'Medical translations reviewed by native clinical reviewers', 'Local contact details and terms for each country']],
        ['b2b-saas', 'B2B SaaS', ['Localized landing pages, pricing and currency for each market', 'Docs and help-centre language versions paired correctly', 'Market-specific comparison and alternatives content']],
        ['ecommerce', 'E-commerce', ['Country stores with the right currency, shipping and returns', 'Products and variants mapped correctly across locales', 'Filter and sort URLs controlled in every language version']],
        ['manufacturing', 'Manufacturing', ['Spec sheets and datasheets in each buyer’s language', 'Distributor and regional sites structured without duplicate content', 'Units, standards and certifications localized for each market']],
        ['technology', 'Technology', ['New regions launched market by market, not all at once', 'Developer docs localized where adoption justifies it', 'Product names kept consistent across languages']],
        ['professional-services', 'Professional Services', ['Office and jurisdiction pages that reflect local rules', 'Practice-area content adapted to each market’s business context', 'Partner and expert profiles in the relevant languages']],
        ['education', 'Education', ['Programme pages for international applicants in their language', 'Entry requirements and visa information by country', 'Multi-campus and partner sites paired with correct hreflang']],
    ];
}

/* ---------- hero animation: Market routing ----------
   A slowly turning globe sits between four language/market versions of one page. The hreflang
   links draw between every pair (each version lists all the others); then a search from each
   market is routed to its own version, which is marked "served". The caption lights:
   right language · right market · right page. 10 s loop (globe turns on its own 12 s cycle). */
function rl_intl_nodes() {
    // code, url, cx, cy
    return [['EN · X-DEFAULT', '/', 260, 34], ['DE', '/de/', 430, 170], ['FR-CA', '/fr-ca/', 260, 306], ['EN-GB', '/uk/', 90, 170]];
}
function rl_intl_svg() {
    $N = rl_intl_nodes();
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlInT"><title id="rlInT">Four language and market versions of one page are linked to each other with hreflang, and a searcher in each market is served the right version: right language, right market, right page.</title>';
    $s .= '<g class="i-globe"><circle cx="260" cy="170" r="88"/><ellipse cx="260" cy="170" rx="88" ry="30"/><line x1="182" y1="128" x2="338" y2="128"/><line x1="182" y1="212" x2="338" y2="212"/>'
        . '<ellipse class="i-mer" cx="260" cy="170" rx="34" ry="88"/><ellipse class="i-mer i-mer2" cx="260" cy="170" rx="66" ry="88"/><line x1="260" y1="82" x2="260" y2="258"/></g>';
    $arcs = ['M322 34 Q430 34 430 152', 'M430 188 Q430 306 322 306', 'M198 306 Q90 306 90 188', 'M90 152 Q90 34 198 34', 'M260 52 V288', 'M368 170 H152'];
    foreach ($arcs as $i => $d) $s .= '<path class="i-e" d="' . $d . '"/><path class="i-a i-a' . $i . '" pathLength="100" d="' . $d . '"/>';
    $srv = ['M260 170 V52', 'M260 170 H368', 'M260 170 V288', 'M260 170 H152'];
    foreach ($srv as $i => $d) $s .= '<path class="i-p i-p' . $i . '" pathLength="100" d="' . $d . '"/>';
    $s .= '<rect class="i-core" x="236" y="158" width="48" height="24"/><text class="i-ct" x="260" y="174" text-anchor="middle">SEARCH</text>';
    foreach ($N as $i => $n) {
        list($code, $url, $cx, $cy) = $n;
        $s .= '<g><rect class="i-n" x="' . ($cx - 62) . '" y="' . ($cy - 18) . '" width="124" height="36"/><rect class="i-lit i-l' . $i . '" x="' . ($cx - 62) . '" y="' . ($cy - 18) . '" width="124" height="36"/>'
            . '<text class="i-code" x="' . ($cx - 52) . '" y="' . ($cy - 3) . '">' . $code . '</text><text class="i-url" x="' . ($cx - 52) . '" y="' . ($cy + 11) . '">' . $url . '</text>'
            . '<rect class="i-ok i-ok' . $i . '" x="' . ($cx + 46) . '" y="' . ($cy + 4) . '" width="8" height="8"/></g>';
    }
    $s .= '<text class="i-tag i-tag0" x="260" y="352" text-anchor="middle">HREFLANG · EVERY VERSION LISTS EVERY OTHER</text>';
    $s .= '<text class="i-cap" x="260" y="376" text-anchor="middle">RIGHT LANGUAGE · RIGHT MARKET · RIGHT PAGE</text><text class="i-cap i-capon" x="260" y="376" text-anchor="middle">RIGHT LANGUAGE · RIGHT MARKET · RIGHT PAGE</text>';
    return $s . '</svg>';
}
function rl_intl_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $win = function ($n, $a, $b) { return "@keyframes $n{0%,{$a}%{opacity:0}" . ($a + 2) . "%,{$b}%{opacity:1}" . ($b + 2) . "%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 6; $i++) { $s = 4 + $i * 5; $k .= "@keyframes rliA$i{0%,{$s}%{stroke-dashoffset:100;opacity:1}" . ($s + 5) . "%,92%{stroke-dashoffset:0;opacity:1}97%{stroke-dashoffset:0;opacity:0}100%{stroke-dashoffset:100;opacity:0}}\n.rl-intl .i-a$i{animation-name:rliA$i}\n"; }
    $first = [4, 4, 9, 14];
    for ($i = 0; $i < 4; $i++) $k .= $lit("rliL$i", $first[$i], $first[$i] + 2) . ".rl-intl .i-l$i{animation-name:rliL$i}\n";
    $k .= $win('rliTag', 8, 36) . ".rl-intl .i-tag0{animation-name:rliTag}\n";
    for ($i = 0; $i < 4; $i++) { $s = 42 + $i * 7; $k .= $pul("rliP$i", $s, $s + 6) . $lit("rliOk$i", $s + 5, $s + 7) . ".rl-intl .i-p$i{animation-name:rliP$i}.rl-intl .i-ok$i{animation-name:rliOk$i}\n"; }
    $k .= $lit('rliCap', 72, 76);
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_intl()) $c[] = 'rl-intl-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_intl(); });
add_action('wp_head', 'rl_intl_css', 22);
function rl_intl_css() {
    if (!rl_is_intl()) return; ?>
<style id="rl-intl-css">
body.rl-intl-page .fl-page-content,body.rl-intl-page .fl-content,body.rl-intl-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-intl .mkt{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-intl .mkt .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-intl .mkt .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-intl .mkt svg{display:block;width:100%;height:auto;overflow:visible}
.rl-intl .i-globe circle,.rl-intl .i-globe ellipse,.rl-intl .i-globe line{fill:none;stroke:rgba(243,237,230,.10);stroke-width:1}
.rl-intl .i-mer{transform-box:fill-box;transform-origin:50% 50%;animation:rliTurn 12s linear infinite}
.rl-intl .i-mer2{animation-delay:-6s}
@keyframes rliTurn{0%{transform:scaleX(1)}50%{transform:scaleX(-1)}100%{transform:scaleX(1)}}
.rl-intl .i-e{fill:none;stroke:var(--line-2);stroke-width:1;stroke-dasharray:3 4}
.rl-intl .i-a{fill:none;stroke:var(--red-2);stroke-width:1.2;stroke-dasharray:100;stroke-dashoffset:100}
.rl-intl .i-p{fill:none;stroke:var(--red-3);stroke-width:1.8;stroke-linecap:round;stroke-dasharray:10 100;stroke-dashoffset:10;opacity:0}
.rl-intl .i-core{fill:var(--bg);stroke:var(--red-line);stroke-width:1}
.rl-intl .i-ct{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--ink-dim)}
.rl-intl .i-n{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-intl .i-lit{fill:rgba(153,0,0,.08);stroke:var(--red-2);stroke-width:1;opacity:0}
.rl-intl .i-code{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.12em;fill:var(--red-3)}
.rl-intl .i-url{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.06em;fill:var(--ink-dim)}
.rl-intl .i-ok{fill:var(--red-2);opacity:0}
.rl-intl .i-tag{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--ink-faint);opacity:0}
.rl-intl .i-cap{font-family:var(--f-mono);font-size:9px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-intl .i-capon{fill:var(--ink);opacity:0;animation-name:rliCap}
.rl-intl .i-a,.rl-intl .i-p,.rl-intl .i-lit,.rl-intl .i-ok,.rl-intl .i-tag,.rl-intl .i-capon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-intl .i-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-intl .i-code,.rl-intl .i-url{font-size:11px;letter-spacing:.02em}.rl-intl .i-cap{font-size:10.5px;letter-spacing:.04em}.rl-intl .i-tag{font-size:9.5px;letter-spacing:.02em}.rl-intl .mkt .cap span+span{display:none}.rl-intl .mkt{padding:16px 10px 10px}}
<?php echo rl_intl_kf(); ?>
/* hreflang rules + code */
.rl-intl .hl{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:16px;align-items:start}
@media(max-width:900px){.rl-intl .hl{grid-template-columns:minmax(0,1fr)}}
.rl-intl .hl>*{min-width:0}
.rl-intl .rules{list-style:none;margin:0;padding:0;display:grid;gap:12px;counter-reset:r}
.rl-intl .rules li{border:1px solid var(--glass-line);background:var(--glass);padding:16px 18px 16px 52px;position:relative;counter-increment:r;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-intl .rules li::before{content:counter(r,decimal-leading-zero);position:absolute;left:18px;top:17px;font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);letter-spacing:.1em}
.rl-intl .rules b{display:block;font-family:var(--f-display);text-transform:uppercase;font-weight:600;font-size:15px;letter-spacing:.02em;margin-bottom:4px}
.rl-intl .rules span{color:var(--ink-dim);font-size:14.5px}
.rl-intl .code{margin:0;border:1px solid var(--red-line);background:#0b090a;padding:20px 22px;overflow-x:auto;font-family:var(--f-mono);font-size:12.5px;line-height:1.75;color:var(--ink-dim);white-space:pre}
.rl-intl .code .c{color:var(--ink-faint)}.rl-intl .code .t{color:var(--red-3)}.rl-intl .code .v{color:var(--ink)}
.rl-intl .code-cap{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:10px;display:block}
.rl-intl td.lvl{white-space:nowrap}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_intl() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'International SEO', 'serviceType' => 'International search engine optimization',
        'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'International SEO makes sure search engines show the right language and country version of a website to each market — through site structure, hreflang, native localization, per-market keyword research, local authority and country-level reporting.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_intl_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_intl', 'rl_render_intl');
function rl_render_intl() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $g = function ($path) { return esc_url('https://developers.google.com/search/docs/' . $path); };
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-intl">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">International SEO</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;International SEO&nbsp;<b>]</b></span>
      <h1 class="h1">Reach every market<br>in its own<br><span class="r">language.</span></h1>
      <p class="lede"><strong>International SEO</strong> makes sure search engines show the right language and country version of your site to each market — and that every version earns rankings of its own. Reinforce Lab plans the structure, implements hreflang, localizes with native review and reports market by market, following Google's own guidance.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Check your international setup — free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#structure">Choosing a structure</a>
      </div>
    </div>
    <figure class="mkt rl-anim">
      <div class="cap" aria-hidden="true"><span>Market routing</span><span>hreflang &rarr; right page</span></div>
      <?php echo rl_intl_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="structure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Site structure&nbsp;<b>]</b></span><h2>Country domains, subdomains or subdirectories?</h2><p class="lede">Google lists four ways to structure a multi-regional site. Each has trade-offs — this is how Google describes them.</p></div>
    <div class="tscroll" role="region" aria-label="Comparison of international URL structures" tabindex="0">
      <table>
        <thead><tr><th scope="col">Structure</th><th scope="col">Example</th><th scope="col">Strengths (per Google)</th><th scope="col">Drawbacks (per Google)</th></tr></thead>
        <tbody>
          <tr><th scope="row">Country domain</th><td class="lvl">example.de</td><td>Clear geotargeting and easy separation; "a strong signal" of the target country; server location irrelevant</td><td>Targets one country only; more infrastructure; can be expensive or hard to get</td></tr>
          <tr><th scope="row">Subdomain</th><td class="lvl">de.example.com</td><td>Easy to set up and separate; allows different server locations</td><td>Users may not recognise the target country from the URL; separate sites to maintain</td></tr>
          <tr><th scope="row">Subdirectory</th><td class="lvl us">example.com/de/</td><td class="us">Lowest maintenance; easy to set up; same hosting</td><td class="us">Users may not recognise the target country from the URL; single server location</td></tr>
          <tr><th scope="row">URL parameter</th><td class="lvl">example.com?loc=de</td><td>—</td><td>Not recommended by Google; hard to segment</td></tr>
        </tbody>
      </table>
    </div>
    <p class="src">Source: Google, <a href="<?php echo $g('specialty/international/managing-multi-regional-sites'); ?>" rel="noopener" target="_blank">Managing multi-regional and multilingual sites</a>. Our default for most B2B sites: subdirectories on one strong domain, unless a legal, brand or market reason points elsewhere.</p>
  </div>
</section>

<section id="hreflang">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;hreflang&nbsp;<b>]</b></span><h2>How does hreflang work?</h2><p class="lede">hreflang tells Google which pages are language or regional versions of each other, so each searcher gets the right one. Small mistakes make Google ignore it — these are the rules.</p></div>
    <div class="hl">
      <ol class="rules">
        <li><b>Every version lists every version</b><span>Each page lists itself and all its alternates. If page X links to page Y, page Y must link back — or the annotations may be ignored.</span></li>
        <li><b>Use valid codes</b><span>Language in ISO 639-1 (e.g. <code>de</code>), with an optional region in ISO 3166-1 Alpha 2 (e.g. <code>de-AT</code>). A region on its own is invalid.</span></li>
        <li><b>Set a fallback</b><span><code>x-default</code> is used when no other version matches the user's language or region — often a language selector or global page.</span></li>
        <li><b>Pick one method</b><span>HTML tags, HTTP headers or the XML sitemap. Large sites usually manage hreflang in sitemaps.</span></li>
      </ol>
      <div>
        <span class="code-cap">Example · HTML head of every version</span>
<pre class="code"><span class="c">&lt;!-- listed on /, /de/, /fr-ca/ and /uk/ alike --&gt;</span>
<span class="t">&lt;link</span> rel="alternate" hreflang="<span class="v">en</span>"    href="https://example.com/" /&gt;
<span class="t">&lt;link</span> rel="alternate" hreflang="<span class="v">de</span>"    href="https://example.com/de/" /&gt;
<span class="t">&lt;link</span> rel="alternate" hreflang="<span class="v">fr-CA</span>" href="https://example.com/fr-ca/" /&gt;
<span class="t">&lt;link</span> rel="alternate" hreflang="<span class="v">en-GB</span>" href="https://example.com/uk/" /&gt;
<span class="t">&lt;link</span> rel="alternate" hreflang="<span class="v">x-default</span>" href="https://example.com/" /&gt;</pre>
      </div>
    </div>
    <p class="src">Source: Google, <a href="<?php echo $g('specialty/international/localized-versions'); ?>" rel="noopener" target="_blank">Tell Google about localized versions of your page</a></p>
  </div>
</section>

<section class="band alt" id="myths">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Myths vs Google&nbsp;<b>]</b></span><h2>Which international SEO beliefs are wrong?</h2><p class="lede">Common assumptions, checked against Google's own documentation.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"The HTML lang attribute tells Google what language a page is in."</p></div><div class="f"><span class="tag">Google says</span><p>Google uses the visible content of the page to decide its language. It doesn't use code-level language information such as lang attributes, or the URL.</p><a href="<?php echo $g('specialty/international/managing-multi-regional-sites'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Redirect visitors to their country version automatically, by IP."</p></div><div class="f"><span class="tag">Google says</span><p>Avoid automatic redirects between language versions. Googlebot usually crawls from the USA, so redirects can stop users and search engines from reaching every version.</p><a href="<?php echo $g('specialty/international/managing-multi-regional-sites'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Just set the target country in Search Console."</p></div><div class="f"><span class="tag">Google says</span><p>The International Targeting report is deprecated and country targeting is no longer supported. Google still uses hreflang.</p><a href="https://support.google.com/webmasters/answer/12474899" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Machine-translate every page — it's the fastest way to scale."</p></div><div class="f"><span class="tag">Google says</span><p>Its spam policies list automated transformations, including translating, that add little value as scaled content abuse. Translation needs real localization and review.</p><a href="<?php echo $g('essentials/spam-policies'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Same-language pages for different countries will be penalised as duplicates."</p></div><div class="f"><span class="tag">Google says</span><p>For similar same-language pages across regions, pick a preferred version and use rel=canonical and hreflang so the right URL is served. Translated pages are not duplicates.</p><a href="<?php echo $g('specialty/international/localized-versions'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
  </div>
</section>

<section id="check">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we do&nbsp;<b>]</b></span><h2>What does international SEO involve?</h2><p class="lede">Nine workstreams — from deciding which markets are worth entering to proving each one pays back.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Markets</span><h3>Market prioritisation</h3><p>Demand, competition and fit per country, so you enter the markets worth entering first.</p></div>
      <div class="cell"><span class="n">02 · Structure</span><h3>Architecture decision</h3><p>Country domains, subdomains or subdirectories — chosen and documented with the reasons.</p></div>
      <div class="cell"><span class="n">03 · hreflang</span><h3>Implementation &amp; QA</h3><p>Reciprocal annotations, valid codes and x-default — validated across every version.</p></div>
      <div class="cell"><span class="n">04 · Research</span><h3>Native keyword research</h3><p>How each market actually searches — not a translation of your English keywords.</p></div>
      <div class="cell"><span class="n">05 · Localization</span><h3>Native review</h3><p>Pages adapted for language, culture, units and currency, and reviewed by native speakers.</p></div>
      <div class="cell"><span class="n">06 · Authority</span><h3>Local signals</h3><p>Mentions, links and listings that matter in each market, not only at home.</p></div>
      <div class="cell"><span class="n">07 · Technical</span><h3>Per-locale technical SEO</h3><p>Sitemaps per locale, canonicals, crawlable language selectors and speed in each region.</p></div>
      <div class="cell"><span class="n">08 · Measurement</span><h3>Country-level reporting</h3><p>Search Console and analytics split by market, tied to enquiries and revenue.</p></div>
      <div class="cell"><span class="n">09 · AI search</span><h3>AI answers per market</h3><p>What AI tools say about you in each language — observed and reported, not assumed.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does an international SEO engagement run?</h2><p class="lede">Market by market — so each launch is proven before the next one starts.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Prioritise markets</h3><p>Score countries on demand, competition and readiness, and agree the order.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Decide the structure</h3><p>Choose the URL structure and write it down, with a redirect plan if anything moves.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Build &amp; hreflang</h3><p>Set up the versions, hreflang and sitemaps, then validate every pair before launch.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Localize &amp; publish</h3><p>Research and adapt content per market, with native review before anything goes live.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Measure per market</h3><p>Report each market separately, fix what's served wrongly, and roll out the next one.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Market priority model</b> — which countries to enter, in which order, and why.</li>
      <li><b>Architecture decision record</b> — the chosen structure, alternatives and trade-offs.</li>
      <li><b>hreflang map</b> — every page and its alternates, validated for return links and codes.</li>
      <li><b>Native keyword research</b> — per market and language, mapped to pages.</li>
      <li><b>Localization briefs</b> — what to adapt beyond the words, for each market.</li>
      <li><b>Redirect &amp; migration plan</b> — for any URL that changes, tested before launch.</li>
      <li><b>Per-locale sitemaps</b> — clean, canonical and in sync with hreflang.</li>
      <li><b>Country dashboards</b> — impressions, clicks, enquiries and revenue by market.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure international SEO?</h2><p class="lede">Market by market, against the baseline taken before launch.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Visibility per market</h3><p>Impressions and clicks in each country's search results.</p></div>
      <div class="metric"><h3>Right version served</h3><p>Share of searchers landing on the version meant for their market.</p></div>
      <div class="metric"><h3>hreflang health</h3><p>Missing return links, invalid codes and orphaned versions over time.</p></div>
      <div class="metric"><h3>Indexed pages per locale</h3><p>Whether each version's important pages are actually in the index.</p></div>
      <div class="metric"><h3>Enquiries &amp; revenue by market</h3><p>What each market brings in — the reason to be there.</p></div>
      <div class="metric"><h3>AI answers per language</h3><p>How AI tools describe and recommend you in each market.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Translation isn't localization — and hreflang doesn't steer AI.</h2>
      <p>A translated page that ignores how a market searches, buys and speaks rarely ranks. We research and adapt each market properly, with native review. And while Google documents how it uses hreflang, no AI company documents how its assistant picks a country version — so we don't promise it. We implement what Google documents and check what AI tools actually answer in each market.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is international SEO for?</h2><p class="lede">Companies selling in more than one country or language — or planning to — who need each market to perform on its own.</p></div>
    <ul class="inds8">
      <?php foreach (rl_intl_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('International SEO for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with international SEO?</h2><p class="lede">International SEO multiplies whatever your core site already does well. These services make sure that's a lot.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Crawlability, indexation and speed — the base every language version depends on.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'Visibility, accuracy and recommendations across AI search, market by market.'],
          ['services/llm-optimization', 'Entity level', 'LLM Optimization', 'One consistent brand description across languages, so models don’t mix versions up.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Research-led, evidence-checked content produced as a system — in every language you serve.'],
          ['services/enterprise-seo-strategy', 'Scale', 'Enterprise SEO Strategy', 'Governance and priorities for large, multi-team, multi-market sites.'],
          ['services/local-seo', 'Local', 'Local SEO', 'Visibility in map results and local searches for every location you serve.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About international SEO.</h2></div>
    <?php foreach (rl_intl_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Is each market seeing the right version of your site?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your structure, hreflang and visibility market by market — and shows what to fix first.</p>
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
