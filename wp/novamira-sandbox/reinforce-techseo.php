<?php
/**
 * Plugin Name: Reinforce Lab — Technical SEO
 * Description: /services/technical-seo/ (production URL kept — D-046; was /services/technical-seo/ on .online) — Technical SEO service page. Provides [reinforce_techseo]. Uses the shared kit (D-044). Hero animation "Crawl, fix, index" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_techseo() { return is_page('technical-seo-services'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_techseo_faqs() {
    return [
        ['What is technical SEO?', 'Technical SEO is the work that makes sure search engines and AI crawlers can crawl, render, understand and index the pages that matter on a website — quickly, without errors and without wasting effort on junk URLs. It covers crawlability, indexation, site architecture, page speed, structured data and access for crawlers.'],
        ['How is a technical SEO audit different from what you deliver?', 'An audit lists problems. We trace each problem to its root cause — often one template or setting that creates hundreds of symptoms — fix it with your team or directly in WordPress, and then re-crawl the site to verify the fix worked.'],
        ['What are the Core Web Vitals thresholds?', 'Google’s web.dev guidance says a good experience means Largest Contentful Paint within 2.5 seconds, Interaction to Next Paint of 200 milliseconds or less, and Cumulative Layout Shift of 0.1 or less, measured at the 75th percentile of page loads on mobile and desktop. Interaction to Next Paint replaced First Input Delay on 12 March 2024.'],
        ['Does blocking a page in robots.txt remove it from Google?', 'No. Google’s documentation says robots.txt controls crawling, not indexing. If a page is blocked from crawling, Google cannot see a noindex rule on it, so the URL can still appear in results. To keep a page out of the index, it must be crawlable and carry a noindex rule.'],
        ['Do AI crawlers see the same page as Googlebot?', 'Not necessarily. Google renders JavaScript, but its own guidance notes that not all bots can run JavaScript. The major AI companies do not document whether their crawlers render JavaScript, and a Vercel study observed several that did not. The safe approach is to make important content available in the page’s initial HTML.'],
        ['Will technical fixes put our current rankings at risk?', 'Not with our process. We inventory every URL that earns traffic or links before changing anything, map redirects for any URL that must move, test changes on a staging or development copy, and re-crawl after release. Nothing that already ranks is changed without your approval.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with technical SEO points specific to it */
function rl_techseo_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Separate HCP and patient sections, gated content and country versions indexed correctly', 'Frequently updated product and pipeline pages kept crawlable, current and free of duplicates', 'Clean HTML and structured data so evidence-heavy pages are read accurately']],
        ['healthcare', 'Healthcare', ['Location and practitioner pages at scale without duplicate or thin URLs', 'Fast, stable pages on mobile for people searching on the go', 'Medical content with visible reviewer and update details, marked up to match']],
        ['b2b-saas', 'B2B SaaS', ['JavaScript-heavy pages rendered so crawlers see the real content', 'Docs, changelogs and help centres organised without crawl waste', 'Marketing site, app and staging kept separate — staging never indexed']],
        ['ecommerce', 'E-commerce', ['Filters and sorting that don’t multiply into endless URLs', 'Variants and out-of-stock or discontinued products handled with the right canonical or redirect', 'Category and product templates that pass Core Web Vitals']],
        ['manufacturing', 'Manufacturing', ['Large catalogues and spec sheets, including PDFs, made crawlable and indexable', 'Distributor and regional sites without duplicate content', 'Legacy sites migrated without losing the pages that bring enquiries']],
        ['technology', 'Technology', ['Architecture that keeps many products and integrations easy to find', 'JavaScript frameworks checked for what crawlers actually receive', 'Developer docs and API references structured for search and AI answers']],
        ['professional-services', 'Professional Services', ['Service, location and team pages structured so each one can rank', 'Insights and articles kept fast, indexable and linked to the right services', 'Clean sites after mergers and rebrands — old domains redirected correctly']],
        ['education', 'Education', ['Course pages that change every intake kept current and indexable', 'Large archives of news, events and past courses consolidated to cut crawl waste', 'Multi-campus and international versions paired with correct hreflang']],
    ];
}

/* ---------- hero animation: Crawl, fix, index ----------
   A crawler maps a site tree; three faults surface (a broken link 404, a slow page, an orphan
   page with no links in); each is repaired in turn; every page is then marked indexed and the
   four checks light: crawlable · renderable · indexable · fast. 10 s loop, soft fade, reset. */
function rl_techseo_tree() {
    return [
        'l2' => [['SERVICES', 85], ['BLOG', 257], ['INDUSTRIES', 435]],
        'l3' => [['/SEO', 42, 0], ['/AUDIT', 128, 0], ['/POST-A', 214, 1], ['/POST-B', 300, 1], ['/PHARMA', 392, 2], ['/SAAS', 478, 2]],
    ];
}
function rl_techseo_svg() {
    $T = rl_techseo_tree();
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlTsT"><title id="rlTsT">A crawler maps a website: it finds a broken link, a slow page and an orphan page, each is fixed, and every page becomes crawlable, renderable, indexable and fast.</title>';
    foreach ($T['l2'] as $i => $n) {
        $d = 'M260 45 C260 65 ' . $n[1] . ' 65 ' . $n[1] . ' 85';
        $s .= '<path class="t-e" d="' . $d . '"/><path class="t-p t-p1' . $i . '" pathLength="100" d="' . $d . '"/>';
    }
    foreach ($T['l3'] as $i => $n) {
        $px = $T['l2'][$n[2]][1];
        $d = 'M' . $px . ' 115 C' . $px . ' 141 ' . $n[1] . ' 141 ' . $n[1] . ' 167';
        $s .= '<path class="t-e" d="' . $d . '"/><path class="t-p t-p2' . $i . '" pathLength="100" d="' . $d . '"/>';
    }
    $s .= '<path class="t-fixe" pathLength="100" d="M257 115 V237"/>';
    $s .= '<rect class="t-n" x="205" y="15" width="110" height="30"/><rect class="t-lit t-lit-root" x="205" y="15" width="110" height="30"/><text class="t-tx" x="260" y="34" text-anchor="middle">HOME</text>';
    foreach ($T['l2'] as $i => $n) {
        $s .= '<rect class="t-n" x="' . ($n[1] - 60) . '" y="85" width="120" height="30"/><rect class="t-lit t-l2' . $i . '" x="' . ($n[1] - 60) . '" y="85" width="120" height="30"/><text class="t-tx" x="' . $n[1] . '" y="104" text-anchor="middle">' . $n[0] . '</text>';
    }
    $node3 = function ($cls, $lab, $cx, $cy) {
        return '<rect class="t-n' . ($cls === 'orph' ? ' t-orph' : '') . '" x="' . ($cx - 38) . '" y="' . ($cy - 13) . '" width="76" height="26"/>'
            . '<rect class="t-lit t-' . $cls . '" x="' . ($cx - 38) . '" y="' . ($cy - 13) . '" width="76" height="26"/>'
            . '<text class="t-tx t-sm" x="' . $cx . '" y="' . ($cy + 3.5) . '" text-anchor="middle">' . $lab . '</text>'
            . '<rect class="t-ix t-ix' . $cls . '" x="' . ($cx + 28) . '" y="' . ($cy - 10) . '" width="6" height="6"/>';
    };
    foreach ($T['l3'] as $i => $n) $s .= $node3('l3' . $i, $n[0], $n[1], 180);
    $s .= $node3('orph', '/GUIDE', 257, 250);
    $badge = function ($k, $cx, $y, $bad, $good) {
        return '<g class="t-bad t-bad' . $k . '"><rect x="' . ($cx - 26) . '" y="' . $y . '" width="52" height="14"/><text x="' . $cx . '" y="' . ($y + 10) . '" text-anchor="middle">' . $bad . '</text></g>'
            . '<g class="t-good t-good' . $k . '"><rect x="' . ($cx - 26) . '" y="' . $y . '" width="52" height="14"/><text x="' . $cx . '" y="' . ($y + 10) . '" text-anchor="middle">' . $good . '</text></g>';
    };
    $s .= '<rect class="t-warn t-warn0" x="176" y="167" width="76" height="26"/><rect class="t-warn t-warn1" x="440" y="167" width="76" height="26"/><rect class="t-warn t-warn2" x="219" y="237" width="76" height="26"/>';
    $s .= $badge(0, 214, 198, '404', '200 OK') . $badge(1, 478, 198, 'SLOW', 'FAST') . $badge(2, 331, 243, 'ORPHAN', 'LINKED');
    $s .= '<text class="t-ph t-ph0" x="0" y="300">CRAWLING…</text><text class="t-ph t-ph1" x="0" y="300">FIXING ROOT CAUSES…</text><text class="t-ph t-ph2" x="0" y="300">VERIFIED &amp; INDEXED</text>';
    $s .= '<line class="t-rule" x1="0" y1="318" x2="520" y2="318"/>';
    foreach (['CRAWLABLE', 'RENDERABLE', 'INDEXABLE', 'FAST'] as $i => $m) {
        $x = $i * 130;
        $s .= '<rect class="t-sq" x="' . $x . '" y="340" width="10" height="10"/><rect class="t-sqon t-m' . $i . '" x="' . $x . '" y="340" width="10" height="10"/>'
            . '<text class="t-mt" x="' . ($x + 18) . '" y="349">' . $m . '</text><text class="t-mt t-mton t-m' . $i . '" x="' . ($x + 18) . '" y="349">' . $m . '</text>';
    }
    return $s . '</svg>';
}
function rl_techseo_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $win = function ($n, $a, $b) { return "@keyframes $n{0%,{$a}%{opacity:0}" . ($a + 2) . "%,{$b}%{opacity:1}" . ($b + 2) . "%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = $lit('rltRoot', 1, 3) . ".rl-tseo .t-lit-root{animation-name:rltRoot}\n";
    for ($i = 0; $i < 3; $i++) {
        $k .= $pul("rltP1$i", 2 + $i * .5, 9 + $i * .5) . $lit("rltL2$i", 8 + $i, 10 + $i) . ".rl-tseo .t-p1$i{animation-name:rltP1$i}.rl-tseo .t-l2$i{animation-name:rltL2$i}\n";
    }
    for ($i = 0; $i < 6; $i++) {
        $g = intdiv($i, 2);
        $k .= $pul("rltP2$i", 11 + $g, 18 + $g) . $lit("rltL3$i", 17 + $i * .8, 19 + $i * .8) . ".rl-tseo .t-p2$i{animation-name:rltP2$i}.rl-tseo .t-l3$i{animation-name:rltL3$i}\n";
    }
    $fix = [32, 42, 57];
    for ($j = 0; $j < 3; $j++) {
        $k .= $win("rltBad$j", 24, $fix[$j]) . $lit("rltGood$j", $fix[$j] + 1, $fix[$j] + 3);
        $k .= ".rl-tseo .t-bad$j,.rl-tseo .t-warn$j{animation-name:rltBad$j}.rl-tseo .t-good$j{animation-name:rltGood$j}\n";
    }
    $k .= "@keyframes rltFixE{0%,50%{stroke-dashoffset:100;opacity:1}58%,92%{stroke-dashoffset:0;opacity:1}97%{stroke-dashoffset:0;opacity:0}100%{stroke-dashoffset:100;opacity:0}}\n";
    $k .= $lit('rltOrphLit', 57, 59) . "@keyframes rltOrphDash{0%,56%{opacity:1}58%,94%{opacity:0}100%{opacity:1}}\n.rl-tseo .t-orph{animation-name:rltOrphDash}.rl-tseo .t-lit.t-orph{animation-name:rltOrphLit}\n";
    $ix = ['l30', 'l31', 'l32', 'l33', 'l34', 'l35', 'orph'];
    foreach ($ix as $i => $c) $k .= $lit("rltIx$i", 64 + $i * 1.5, 66 + $i * 1.5) . ".rl-tseo .t-ix$c{animation-name:rltIx$i}\n";
    for ($i = 0; $i < 4; $i++) $k .= $lit("rltM$i", 74 + $i * 3, 76 + $i * 3) . ".rl-tseo .t-m$i{animation-name:rltM$i}\n";
    $k .= $win('rltPh0', 1, 24) . $win('rltPh1', 26, 60) . $lit('rltPh2', 64, 67) . ".rl-tseo .t-ph0{animation-name:rltPh0}.rl-tseo .t-ph1{animation-name:rltPh1}.rl-tseo .t-ph2{animation-name:rltPh2}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_techseo()) $c[] = 'rl-tseo-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_techseo(); });
add_action('wp_head', 'rl_techseo_css', 22);
function rl_techseo_css() {
    if (!rl_is_techseo()) return; ?>
<style id="rl-tseo-css">
body.rl-tseo-page .fl-page-content,body.rl-tseo-page .fl-content,body.rl-tseo-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
/* hero visual: crawl, fix, index */
.rl-tseo .crawl{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-tseo .crawl .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-tseo .crawl .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-tseo .crawl svg{display:block;width:100%;height:auto;overflow:visible}
.rl-tseo .t-e{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-tseo .t-p{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-linecap:round;stroke-dasharray:10 100;stroke-dashoffset:10;opacity:0}
.rl-tseo .t-fixe{fill:none;stroke:var(--red-2);stroke-width:1.2;stroke-dasharray:100;stroke-dashoffset:100;animation-name:rltFixE}
.rl-tseo .t-n{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-tseo .t-n.t-orph{stroke:var(--ink-faint);stroke-dasharray:3 3}
.rl-tseo .t-lit{fill:rgba(255,255,255,.03);stroke:rgba(243,237,230,.45);stroke-width:1;opacity:0}
.rl-tseo .t-tx{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.14em;fill:var(--ink-dim)}
.rl-tseo .t-sm{font-size:8.5px;letter-spacing:.06em}
.rl-tseo .t-ix{fill:var(--red-2);opacity:0}
.rl-tseo .t-warn{fill:rgba(153,0,0,.14);stroke:var(--red-3);stroke-width:1;opacity:0}
.rl-tseo .t-bad,.rl-tseo .t-good{opacity:0}
.rl-tseo .t-bad rect{fill:var(--red-2)}.rl-tseo .t-bad text{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:#fff}
.rl-tseo .t-good rect{fill:none;stroke:var(--ink-faint);stroke-width:1}.rl-tseo .t-good text{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:var(--ink)}
.rl-tseo .t-ph{font-family:var(--f-mono);font-size:9px;letter-spacing:.2em;fill:var(--red-3);opacity:0}
.rl-tseo .t-rule{stroke:var(--line-2);stroke-width:1}
.rl-tseo .t-sq{fill:none;stroke:var(--line-2);stroke-width:1}.rl-tseo .t-sqon{fill:var(--red-2);opacity:0}
.rl-tseo .t-mt{font-family:var(--f-mono);font-size:9px;letter-spacing:.14em;fill:var(--ink-faint)}.rl-tseo .t-mton{fill:var(--ink);opacity:0}
.rl-tseo .t-lit,.rl-tseo .t-p,.rl-tseo .t-fixe,.rl-tseo .t-n.t-orph,.rl-tseo .t-ix,.rl-tseo .t-warn,.rl-tseo .t-bad,.rl-tseo .t-good,.rl-tseo .t-ph,.rl-tseo .t-sqon,.rl-tseo .t-mton{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-tseo .t-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-tseo .t-tx{font-size:11px;letter-spacing:.04em}.rl-tseo .t-sm{font-size:10px;letter-spacing:0}.rl-tseo .t-bad text,.rl-tseo .t-good text{font-size:9.5px;letter-spacing:0}.rl-tseo .t-ph{font-size:10.5px;letter-spacing:.08em}.rl-tseo .t-mt{font-size:10.5px;letter-spacing:.02em}.rl-tseo .crawl .cap span+span{display:none}.rl-tseo .crawl{padding:16px 10px 10px}}
<?php echo rl_techseo_kf(); ?>
/* four stages */
.rl-tseo .stages{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,1fr);gap:14px;counter-reset:s}
@media(max-width:900px){.rl-tseo .stages{grid-template-columns:repeat(2,1fr)}}@media(max-width:520px){.rl-tseo .stages{grid-template-columns:1fr}}
.rl-tseo .stages li{border:1px solid var(--glass-line);background:var(--glass);padding:22px;counter-increment:s;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:8px}
.rl-tseo .stages li::before{content:counter(s,decimal-leading-zero);font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);letter-spacing:.1em}
.rl-tseo .stages h3{font-size:17px}
.rl-tseo .stages p{color:var(--ink-dim);font-size:14px}
.rl-tseo .stages .brk{margin-top:auto;border-top:1px solid var(--line);padding-top:10px;font-size:13.5px;color:var(--ink)}
.rl-tseo .stages .brk b{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;color:var(--red-3);font-weight:500;text-transform:uppercase;margin-right:6px}
/* CWV + myths */
.rl-tseo td.num{font-family:var(--f-display);font-size:20px;color:var(--ink);white-space:nowrap}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_techseo() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Technical SEO', 'serviceType' => 'Technical search engine optimization',
        'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Technical SEO makes sure search engines and AI crawlers can crawl, render, understand and index the pages that matter — covering crawlability, indexation, site architecture, Core Web Vitals, structured data and crawler access, with root causes fixed and verified after release.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_techseo_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_techseo', 'rl_render_techseo');
function rl_render_techseo() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $chip = function ($path, $label) use ($ex) { $l = $ex($path); return '<li>' . ($l ? '<a href="' . $l . '">' . esc_html($label) . '</a>' : '<span>' . esc_html($label) . '</span>') . '</li>'; };
    $g = function ($path) { return esc_url('https://developers.google.com/search/docs/' . $path); };
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-tseo">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Technical SEO</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Technical SEO&nbsp;<b>]</b></span>
      <h1 class="h1">Fix what stops<br>search engines<br><span class="r">and AI crawlers.</span></h1>
      <p class="lede"><strong>Technical SEO</strong> makes sure search engines and AI crawlers can crawl, render, understand and index the pages that matter — quickly, without errors and without wasting effort on junk URLs. Reinforce Lab finds the root causes, fixes them, and re-crawls to prove the fix worked.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#check">What we check</a>
      </div>
    </div>
    <figure class="crawl rl-anim">
      <div class="cap" aria-hidden="true"><span>Site crawl</span><span>Crawl &rarr; fix &rarr; index</span></div>
      <?php echo rl_techseo_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="stages">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How search works&nbsp;<b>]</b></span><h2>Where can a page get stuck?</h2><p class="lede">Google describes Search in three stages — crawling, indexing and serving — and says not every page makes it through each one. For JavaScript sites, rendering sits in between. Technical SEO removes what blocks a page at each stage.</p></div>
    <ol class="stages">
      <li><h3>Crawl</h3><p>The crawler finds and downloads the page by following links and sitemaps.</p><p class="brk"><b>Breaks when</b>Pages are blocked, orphaned, buried deep or lost in redirect chains.</p></li>
      <li><h3>Render</h3><p>The page's code runs so the full content can be read.</p><p class="brk"><b>Breaks when</b>Key content only appears after JavaScript that some crawlers never run.</p></li>
      <li><h3>Index</h3><p>The content is analysed and stored, with one version chosen as canonical.</p><p class="brk"><b>Breaks when</b>Duplicates, conflicting canonicals or stray noindex rules get in the way.</p></li>
      <li><h3>Serve</h3><p>The page is shown for relevant searches — and used by AI features that draw on the index.</p><p class="brk"><b>Breaks when</b>The page is slow, unstable or unclear about what it is.</p></li>
    </ol>
    <p class="src">Sources: Google, <a href="<?php echo $g('fundamentals/how-search-works'); ?>" rel="noopener" target="_blank">How Google Search works</a> · <a href="<?php echo $g('crawling-indexing/javascript/javascript-seo-basics'); ?>" rel="noopener" target="_blank">JavaScript SEO basics</a></p>
  </div>
</section>

<section id="check">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we check&nbsp;<b>]</b></span><h2>What does a technical SEO review cover?</h2><p class="lede">Nine areas, checked against how Google documents them — and against what AI crawlers can actually read.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Crawlability</span><h3>Can crawlers reach it?</h3><p>robots.txt, internal links, orphan pages, redirect chains, broken links and crawl traps such as endless pagination or filter URLs.</p></div>
      <div class="cell"><span class="n">02 · Indexation</span><h3>Should it be in the index?</h3><p>noindex rules, canonicals, duplicate and thin URLs, and what Search Console reports as crawled or discovered but not indexed.</p></div>
      <div class="cell"><span class="n">03 · Rendering</span><h3>Is the content in the HTML?</h3><p>Whether headings, text and links exist in the initial HTML or only appear after JavaScript runs.</p></div>
      <div class="cell"><span class="n">04 · Performance</span><h3>Is it fast and stable?</h3><p>Core Web Vitals by template and device — loading, responsiveness and layout stability.</p></div>
      <div class="cell"><span class="n">05 · Architecture</span><h3>Is the structure clear?</h3><p>URL patterns, click depth, breadcrumbs and internal links that send authority to the pages that matter.</p></div>
      <div class="cell"><span class="n">06 · Sitemaps</span><h3>Do sitemaps help?</h3><p>Clean XML sitemaps that list only canonical, indexable URLs — no redirects, no errors, no junk.</p></div>
      <div class="cell"><span class="n">07 · Structured data</span><h3>Does the markup match?</h3><p>Schema that is valid and represents the visible page, as Google's guidelines require.</p></div>
      <div class="cell"><span class="n">08 · AI access</span><h3>Can AI crawlers read it?</h3><p>Crawler rules per AI company, server-rendered content, and pages that load without errors for bots.</p></div>
      <div class="cell"><span class="n">09 · International</span><h3>Are languages paired?</h3><p>hreflang where you serve several languages or regions — every version listing itself and all the others.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="cwv">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Core Web Vitals&nbsp;<b>]</b></span><h2>What are the Core Web Vitals thresholds?</h2><p class="lede">Google's three user-experience metrics, with the "good" thresholds it publishes. We measure them per page template, on mobile and desktop.</p></div>
    <div class="tscroll" role="region" aria-label="Core Web Vitals thresholds" tabindex="0">
      <table>
        <thead><tr><th scope="col">Metric</th><th scope="col">What it measures</th><th scope="col" class="us">"Good" threshold</th></tr></thead>
        <tbody>
          <tr><th scope="row">LCP</th><td>Largest Contentful Paint — how fast the main content loads</td><td class="num us">≤ 2.5 s</td></tr>
          <tr><th scope="row">INP</th><td>Interaction to Next Paint — how fast the page responds to clicks and taps</td><td class="num us">≤ 200 ms</td></tr>
          <tr><th scope="row">CLS</th><td>Cumulative Layout Shift — how much the layout jumps while loading</td><td class="num us">≤ 0.1</td></tr>
        </tbody>
      </table>
    </div>
    <p class="src">Measured at the 75th percentile of page loads, on mobile and desktop. INP replaced First Input Delay on 12 March 2024. Sources: <a href="https://web.dev/articles/vitals" rel="noopener" target="_blank">web.dev — Web Vitals</a> · <a href="https://web.dev/blog/inp-cwv-march-12" rel="noopener" target="_blank">INP becomes a Core Web Vital</a></p>
  </div>
</section>

<section id="myths">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Myths vs Google&nbsp;<b>]</b></span><h2>Which technical SEO beliefs are wrong?</h2><p class="lede">Common assumptions, checked against Google's own documentation.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Blocking a page in robots.txt removes it from Google."</p></div><div class="f"><span class="tag">Google says</span><p>robots.txt controls crawling. If a page is blocked, Google can't see its noindex rule — to keep it out of the index, let it be crawled and add noindex.</p><a href="<?php echo $g('crawling-indexing/robots-meta-tag'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"A canonical tag forces Google to pick that URL."</p></div><div class="f"><span class="tag">Google says</span><p>rel=canonical is a strong signal, not a command. Conflicting signals — say, a canonical and a redirect pointing different ways — can make Google choose another URL.</p><a href="<?php echo $g('crawling-indexing/consolidate-duplicate-urls'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"If it's in the sitemap, it will be indexed."</p></div><div class="f"><span class="tag">Google says</span><p>A sitemap helps discovery but doesn't guarantee that every URL in it will be crawled or indexed.</p><a href="<?php echo $g('crawling-indexing/sitemaps/overview'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Every site needs to worry about crawl budget."</p></div><div class="f"><span class="tag">Google says</span><p>Crawl budget mainly matters for very large sites (1 million+ pages), fast-changing sites with 10,000+ pages, or sites with many URLs stuck as "Discovered – currently not indexed". For most, the issue is junk URLs, not budget.</p><a href="https://developers.google.com/crawling/docs/crawl-budget" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"If Google can render our JavaScript, every crawler can."</p></div><div class="f"><span class="tag">Google says</span><p>Server-side or pre-rendering "is still a great idea" because "not all bots can run JavaScript". AI companies don't document whether their crawlers render it, and a Vercel study observed several that did not.</p><a href="<?php echo $g('crawling-indexing/javascript/javascript-seo-basics'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does a technical SEO engagement run?</h2><p class="lede">We don't stop at a list of problems. Every fix is traced to its cause and verified after release.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Crawl &amp; collect</h3><p>Crawl the site, and read Search Console, analytics and — where available — server logs.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Find root causes</h3><p>Group symptoms by cause. One template or plugin setting can create hundreds of junk URLs.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Prioritise</h3><p>Rank fixes by impact and effort, with the pages that earn traffic protected first.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Fix safely</h3><p>Implement with your developers or directly in WordPress, tested on a copy of the site before going live.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Verify &amp; monitor</h3><p>Re-crawl after release to prove each fix, then watch indexing and Core Web Vitals for regressions.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Technical audit</b> — every issue, grouped by root cause, with severity and affected URLs.</li>
      <li><b>URL inventory</b> — which URLs earn traffic or links and must be protected.</li>
      <li><b>Prioritised fix plan</b> — ranked by impact and effort, with clear acceptance criteria.</li>
      <li><b>Developer-ready tickets</b> — or the fixes themselves, applied on WordPress.</li>
      <li><b>Redirect map</b> — for any URL that has to change, tested before launch.</li>
      <li><b>Core Web Vitals plan</b> — per template, on mobile and desktop.</li>
      <li><b>Crawler &amp; sitemap setup</b> — robots rules, AI-crawler policy and clean sitemaps.</li>
      <li><b>Verification crawl</b> — proof after release that each fix worked.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure technical SEO?</h2><p class="lede">By whether the right pages get crawled, indexed and served — not by a generic health score.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Indexed important pages</h3><p>Share of your valuable pages that are actually in the index.</p></div>
      <div class="metric"><h3>Crawl waste</h3><p>Share of crawled URLs that are junk, duplicates or errors.</p></div>
      <div class="metric"><h3>Core Web Vitals pass rate</h3><p>Templates passing all three thresholds at the 75th percentile.</p></div>
      <div class="metric"><h3>Errors and redirect chains</h3><p>Broken links, 4xx/5xx responses and chained redirects over time.</p></div>
      <div class="metric"><h3>AI-crawler access</h3><p>Whether the crawlers you allow can fetch and read your key pages.</p></div>
      <div class="metric"><h3>Organic landing-page results</h3><p>Traffic and conversions on the pages the fixes were for.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Protect what works&nbsp;<b>]</b></span>
      <h2>We don't break what already ranks.</h2>
      <p>Technical fixes can remove traffic as easily as they add it. Before we change anything, we inventory the URLs that earn traffic and links, map redirects for anything that must move, and test on a copy of the site. Nothing that already ranks changes without your approval — and every release is re-crawled.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is technical SEO for?</h2><p class="lede">Sites losing traffic without a clear reason, sites with pages Google never indexes, and teams planning a redesign or migration.</p></div>
    <ul class="inds8">
      <?php foreach (rl_techseo_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Technical SEO for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with technical SEO?</h2><p class="lede">Technical SEO is the foundation. These services build on it.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your Google and AI-search performance with a prioritised fix list.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'The full program for being visible, accurately described and recommended across AI search.'],
          ['services/international-seo', 'Global', 'International SEO', 'Multi-country and multi-language search — hreflang, market targeting and localised content.'],
          ['services/enterprise-seo-strategy', 'Scale', 'Enterprise SEO Strategy', 'Search strategy for large sites and multi-team organisations.'],
          ['services/website-maintenance-services', 'Upkeep', 'Website Maintenance', 'Updates, security, backups and performance checks that keep your site healthy.'],
          ['services/agents/search-performance', 'Always on', 'Search Performance Agent', 'The Search Authority OS agent that reads Search Console and analytics continuously and diagnoses drops.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About technical SEO.</h2></div>
    <?php foreach (rl_techseo_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>What's stopping your pages from being indexed?</h2>
      <p class="lede">The free Search Authority Diagnostic includes a technical foundation review — indexability, crawlability, architecture and the barriers holding you back.</p>
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
