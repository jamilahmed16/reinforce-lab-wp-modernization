<?php
/**
 * Plugin Name: Reinforce Lab — SEO & AI Search Audit
 * Description: /services/seo-ai-search-audit/ (approved new URL, D-006; paid one-time audit in the D-016 funnel: free diagnostic → paid audit → packages) — service page. Provides [reinforce_audit]. Uses the shared kit (D-044). Hero animation "Audit sweep" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_audit() { return is_page('seo-ai-search-audit'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_audit_faqs() {
    return [
        ['What is an SEO & AI Search Audit?', 'The SEO & AI Search Audit is a one-time, in-depth review of a website’s technical health, content, authority, competitors and visibility in Google and AI search. It is carried out by people rather than exported from a tool, and delivered as a written report, a prioritised fix register and a roadmap your team can act on.'],
        ['How is it different from the free Search Authority Diagnostic?', 'The free diagnostic is a focused read of where you stand and what to do next. The audit is the full, paid analysis: every important page and template, your competitors, and a documented test of your AI search visibility — with evidence behind each finding.'],
        ['Is the audit just an automated tool report?', 'No. We use crawlers and data tools to collect information, but people review every finding, check the evidence, remove false alarms and decide the priorities. Each issue in the fix register says what we found, why it matters and how to confirm it has been fixed.'],
        ['How do you test AI search visibility?', 'We agree a fixed set of buyer questions with you, run each one on each AI search tool we cover, and record the tool, date, location, language, whether you were mentioned or cited, and which sources were used. Because AI answers vary, we repeat the runs and report the results as dated observations, not guarantees.'],
        ['What do you need from us?', 'Read-only access to Google Search Console and Google Analytics, a list of your main competitors and markets, and a short call about your goals. Access to your CMS is optional and only needed for a deeper technical review.'],
        ['How much does the audit cost, and how long does it take?', 'The SEO & AI Search Audit starts from $2,500 for a standard website and is delivered within 10 business days once access and scope are confirmed, followed by a 60-minute walkthrough. Large, multi-market or very large sites are quoted after scoping. If you start a Search Authority OS package within 60 days, the full audit fee is credited toward it.'],
        ['Do you fix the issues too?', 'The audit is a one-time analysis and plan. You can implement it in-house — the fix register is written for developers and content teams — or we can implement it through our services or a Search Authority OS package.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with audit points (D-047) */
function rl_audit_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Claims and sources reviewed on key product and condition pages', 'HCP, patient and country versions checked for indexing and duplication', 'AI answers about your products checked for accuracy']],
        ['healthcare', 'Healthcare', ['Location, practitioner and service pages checked for thin or duplicate content', 'Medical content reviewed for sources, reviewers and dates', 'Listings and reviews checked against Google’s rules']],
        ['b2b-saas', 'B2B SaaS', ['JavaScript rendering, docs and app/site separation checked', 'Visibility in AI shortlists and comparison answers', 'Content mapped to funnel stages and pipeline']],
        ['ecommerce', 'E-commerce', ['Filters, variants and crawl waste quantified', 'Category and product templates checked against Core Web Vitals', 'Product visibility in AI answers for buying questions']],
        ['manufacturing', 'Manufacturing', ['Catalogue and spec-sheet indexability reviewed', 'Distributor and regional duplicates found', 'Visibility for engineer and buyer questions, including in AI answers']],
        ['technology', 'Technology', ['Architecture across products and integrations assessed', 'Docs structure and findability reviewed', 'Brand and product accuracy checked across AI tools']],
        ['professional-services', 'Professional Services', ['Service, location and expert pages assessed for trust signals', 'Insight content reviewed for depth and freshness', 'Local and AI visibility for adviser searches']],
        ['education', 'Education', ['Course pages, archives and campus sites checked for crawl waste', 'Programme visibility for applicant questions in Google and AI', 'Multi-campus and hreflang setup reviewed']],
    ];
}

/* ---------- hero animation: Audit sweep ----------
   A magnifier sweeps a website wireframe; five issues surface where it stops (404, slow template,
   thin content, missing schema, not cited in AI); they are written into a prioritised fix register
   (P1–P3 with effort), then a 30 · 60 · 90-day roadmap lights. 10 s loop, soft fade, reset. */
function rl_audit_issues() {
    // code, x, y, register label, priority, effort width
    return [['404', 60, 92, 'BROKEN LINKS', 'P1', 40], ['CWV', 186, 124, 'SLOW TEMPLATE', 'P1', 70], ['AI', 120, 282, 'NOT CITED IN AI', 'P2', 60], ['THIN', 64, 204, 'THIN CONTENT', 'P2', 50], ['SCHEMA', 150, 236, 'MISSING SCHEMA', 'P3', 30]];
}
function rl_audit_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlAuT"><title id="rlAuT">A magnifier sweeps a website and finds broken links, a slow template, thin content, missing schema and pages not cited in AI search; the issues become a prioritised fix register and a 30, 60 and 90-day roadmap.</title>';
    $s .= '<rect class="u-pg" x="0" y="0" width="250" height="330"/><rect class="u-bar" x="0" y="0" width="250" height="18"/><circle class="u-dot" cx="10" cy="9" r="2.5"/><circle class="u-dot" cx="19" cy="9" r="2.5"/><circle class="u-dot" cx="28" cy="9" r="2.5"/>'
        . '<rect class="u-bk" x="14" y="30" width="80" height="8"/><rect class="u-bk" x="150" y="30" width="86" height="8"/>'
        . '<rect class="u-hero" x="14" y="50" width="222" height="60"/><rect class="u-bl" x="26" y="62" width="120" height="8"/><rect class="u-bl" x="26" y="76" width="160" height="4"/><rect class="u-bl" x="26" y="86" width="140" height="4"/>';
    foreach ([14, 89, 164] as $x) $s .= '<rect class="u-card" x="' . $x . '" y="122" width="72" height="54"/><rect class="u-bl" x="' . ($x + 8) . '" y="132" width="40" height="5"/><rect class="u-bl" x="' . ($x + 8) . '" y="144" width="54" height="3"/><rect class="u-bl" x="' . ($x + 8) . '" y="152" width="46" height="3"/>';
    foreach ([188, 198, 208, 218, 236, 246, 256, 266] as $i => $y) $s .= '<rect class="u-bl" x="14" y="' . $y . '" width="' . [210, 190, 200, 120, 206, 180, 196, 100][$i] . '" height="3"/>';
    $s .= '<rect class="u-foot" x="0" y="296" width="250" height="34"/>';
    foreach (rl_audit_issues() as $i => $d) {
        $s .= '<g class="u-is u-is' . $i . '"><circle cx="' . $d[1] . '" cy="' . $d[2] . '" r="5"/><rect x="' . ($d[1] + 8) . '" y="' . ($d[2] - 7) . '" width="' . (strlen($d[0]) * 6.2 + 10) . '" height="14"/><text x="' . ($d[1] + 13) . '" y="' . ($d[2] + 3) . '">' . $d[0] . '</text></g>';
    }
    $s .= '<g class="u-lens"><circle class="u-glass" cx="0" cy="0" r="30"/><line class="u-handle" x1="21" y1="21" x2="40" y2="40"/></g>';
    $s .= '<text class="u-lab" x="272" y="12">FIX REGISTER</text><line class="u-rule" x1="272" y1="20" x2="520" y2="20"/>';
    $ord = [0, 1, 2, 3, 4];
    foreach ($ord as $r => $i) {
        $d = rl_audit_issues()[$i]; $y = 30 + $r * 44;
        $s .= '<g class="u-row u-row' . $r . '"><rect class="u-rb" x="272" y="' . $y . '" width="248" height="36"/><rect class="u-pr u-' . strtolower($d[4]) . '" x="282" y="' . ($y + 10) . '" width="22" height="16"/><text class="u-prt" x="293" y="' . ($y + 21.5) . '" text-anchor="middle">' . $d[4] . '</text>'
            . '<text class="u-rt" x="314" y="' . ($y + 16) . '">' . $d[3] . '</text><text class="u-eff" x="314" y="' . ($y + 29) . '">EFFORT</text><rect class="u-eb" x="352" y="' . ($y + 25) . '" width="80" height="3"/><rect class="u-ef" x="352" y="' . ($y + 25) . '" width="' . $d[5] . '" height="3"/></g>';
    }
    $s .= '<line class="u-rule" x1="272" y1="262" x2="520" y2="262"/><text class="u-lab" x="272" y="280">ROADMAP</text>';
    foreach (['30 DAYS', '60 DAYS', '90 DAYS'] as $i => $t) {
        $x = 272 + $i * 84;
        $s .= '<rect class="u-rm" x="' . $x . '" y="290" width="78" height="30"/><rect class="u-rmon u-rm' . $i . '" x="' . $x . '" y="290" width="78" height="30"/><text class="u-rmt" x="' . ($x + 39) . '" y="309" text-anchor="middle">' . $t . '</text>';
    }
    $s .= '<text class="u-cap" x="260" y="376" text-anchor="middle">FOUND BY PEOPLE · BACKED BY EVIDENCE · PRIORITISED</text><text class="u-cap u-capon" x="260" y="376" text-anchor="middle">FOUND BY PEOPLE · BACKED BY EVIDENCE · PRIORITISED</text>';
    return $s . '</svg>';
}
function rl_audit_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $I = rl_audit_issues();
    // lens path: start off-page left, visit the five issues in the order 404, CWV, THIN, SCHEMA, AI, then park
    $path = [[0, 20, 60], [4, 40, 70]]; $visit = [0, 1, 3, 4, 2]; $t = 8; $stop = [];
    foreach ($visit as $n => $i) { $path[] = [$t, $I[$i][1], $I[$i][2]]; $path[] = [$t + 3, $I[$i][1], $I[$i][2]]; $stop[$i] = $t + 1; $t += 8; }
    $path[] = [$t + 2, 210, 320]; $path[] = [92, 210, 320]; $path[] = [100, 20, 60];
    $k = '@keyframes rlauLens{';
    foreach ($path as $p) $k .= $p[0] . '%{transform:translate(' . $p[1] . 'px,' . $p[2] . 'px)}';
    $k .= "}\n@keyframes rlauLensO{0%,2%{opacity:0}5%,50%{opacity:1}56%,100%{opacity:0}}\n";
    foreach ($stop as $i => $s) $k .= $lit("rlauI$i", $s, $s + 2) . ".rl-audit .u-is$i{animation-name:rlauI$i}\n";
    for ($r = 0; $r < 5; $r++) { $s = 52 + $r * 3; $k .= $lit("rlauR$r", $s, $s + 3) . ".rl-audit .u-row$r{animation-name:rlauR$r}\n"; }
    for ($i = 0; $i < 3; $i++) { $s = 70 + $i * 4; $k .= $lit("rlauM$i", $s, $s + 3) . ".rl-audit .u-rm$i{animation-name:rlauM$i}\n"; }
    $k .= $lit('rlauCap', 82, 86);
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_audit()) $c[] = 'rl-audit-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_audit(); });
add_action('wp_head', 'rl_audit_css', 22);
function rl_audit_css() {
    if (!rl_is_audit()) return; ?>
<style id="rl-audit-css">
body.rl-audit-page .fl-page-content,body.rl-audit-page .fl-content,body.rl-audit-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-audit .swp{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-audit .swp .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-audit .swp .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-audit .swp svg{display:block;width:100%;height:auto;overflow:visible}
.rl-audit .u-pg{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-audit .u-bar{fill:rgba(255,255,255,.04)}.rl-audit .u-dot{fill:rgba(255,255,255,.18)}
.rl-audit .u-bk,.rl-audit .u-bl{fill:rgba(255,255,255,.10)}
.rl-audit .u-hero{fill:rgba(153,0,0,.08);stroke:var(--line-2);stroke-width:1}
.rl-audit .u-card{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-audit .u-foot{fill:rgba(255,255,255,.03)}
.rl-audit .u-is{opacity:0}
.rl-audit .u-is circle{fill:var(--red-2);stroke:#fff;stroke-width:1}
.rl-audit .u-is rect{fill:var(--red-2)}
.rl-audit .u-is text{font-family:var(--f-mono);font-size:8px;letter-spacing:.08em;fill:#fff}
.rl-audit .u-lens{animation:rlauLens 10s cubic-bezier(.45,0,.2,1) infinite both,rlauLensO 10s linear infinite both}
.rl-audit .u-glass{fill:rgba(255,255,255,.04);stroke:rgba(243,237,230,.7);stroke-width:1.6}
.rl-audit .u-handle{stroke:rgba(243,237,230,.7);stroke-width:3.5;stroke-linecap:round}
.rl-audit .u-lab{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-audit .u-rule{stroke:var(--line-2);stroke-width:1}
.rl-audit .u-row{opacity:0}
.rl-audit .u-rb{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-audit .u-pr{fill:none;stroke:var(--line-2)}.rl-audit .u-p1{fill:var(--red-2);stroke:var(--red-2)}.rl-audit .u-p2{fill:rgba(153,0,0,.25);stroke:var(--red-2)}
.rl-audit .u-prt{font-family:var(--f-mono);font-size:8px;fill:#fff}
.rl-audit .u-rt{font-family:var(--f-mono);font-size:9px;letter-spacing:.1em;fill:var(--ink)}
.rl-audit .u-eff{font-family:var(--f-mono);font-size:7px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-audit .u-eb{fill:rgba(255,255,255,.08)}.rl-audit .u-ef{fill:var(--ink-faint)}
.rl-audit .u-rm{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-audit .u-rmon{fill:rgba(153,0,0,.14);stroke:var(--red-2);stroke-width:1;opacity:0}
.rl-audit .u-rmt{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.14em;fill:var(--ink)}
.rl-audit .u-cap{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-audit .u-capon{fill:var(--ink);opacity:0;animation-name:rlauCap}
.rl-audit .u-is,.rl-audit .u-row,.rl-audit .u-rmon,.rl-audit .u-capon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-audit .u-is text{font-size:10px;letter-spacing:0}.rl-audit .u-rt{font-size:10.5px;letter-spacing:.02em}.rl-audit .u-rmt{font-size:10px;letter-spacing:.04em}.rl-audit .u-cap{font-size:9.5px;letter-spacing:.02em}.rl-audit .u-lab{font-size:10px;letter-spacing:.08em}.rl-audit .swp .cap span+span{display:none}.rl-audit .swp{padding:16px 10px 10px}}
<?php echo rl_audit_kf(); ?>
/* diagnostic vs audit vs packages */
.rl-audit td.hl{white-space:nowrap}
/* AI test method */
.rl-audit .method-ai{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;list-style:none;margin:0;padding:0;counter-reset:m}
@media(max-width:900px){.rl-audit .method-ai{grid-template-columns:repeat(2,1fr)}}@media(max-width:520px){.rl-audit .method-ai{grid-template-columns:1fr}}
.rl-audit .method-ai li{border:1px solid var(--glass-line);background:var(--glass);padding:20px;counter-increment:m;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-audit .method-ai li::before{content:counter(m,decimal-leading-zero);display:block;font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);letter-spacing:.1em;margin-bottom:8px}
.rl-audit .method-ai h3{font-size:16px;margin-bottom:6px}
.rl-audit .method-ai p{color:var(--ink-dim);font-size:14px}
.rl-audit .log{margin-top:18px;border:1px solid var(--red-line);background:#0b090a;padding:16px 20px;font-family:var(--f-mono);font-size:12px;line-height:1.8;color:var(--ink-dim);overflow-x:auto;white-space:pre}
.rl-audit .log b{color:var(--ink);font-weight:500}.rl-audit .log i{color:var(--red-3);font-style:normal}
/* pricing (D-053) */
.rl-audit .price{display:grid;grid-template-columns:.9fr 1.1fr;gap:16px;align-items:stretch}
@media(max-width:820px){.rl-audit .price{grid-template-columns:1fr}}
.rl-audit .p-main{border:1px solid var(--red-line);background:linear-gradient(180deg,rgba(153,0,0,.14),var(--glass-2));padding:30px 28px;box-shadow:inset 0 1px 0 var(--glass-hi),0 0 70px -26px var(--red-glow);display:flex;flex-direction:column;gap:6px;align-items:flex-start}
.rl-audit .p-from{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-audit .p-amt{font-family:var(--f-display);font-weight:700;font-size:clamp(44px,6vw,64px);line-height:1;color:var(--ink)}
.rl-audit .p-note{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.08em;color:var(--ink-dim);margin-bottom:18px}
.rl-audit .p-list{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:1fr 1fr;gap:12px}
@media(max-width:560px){.rl-audit .p-list{grid-template-columns:1fr}}
.rl-audit .p-list li{border:1px solid var(--glass-line);background:var(--glass);padding:18px 20px;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:4px}
.rl-audit .p-list b{font-family:var(--f-display);text-transform:uppercase;font-weight:600;font-size:17px;letter-spacing:.02em;color:var(--ink)}
.rl-audit .p-list span{color:var(--ink-dim);font-size:14px}
/* is / isn't */
.rl-audit .isnt{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:760px){.rl-audit .isnt{grid-template-columns:1fr}}
.rl-audit .isnt>div{border:1px solid var(--glass-line);background:var(--glass);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-audit .isnt .yes{border-color:var(--red-line);background:linear-gradient(180deg,rgba(153,0,0,.10),var(--glass))}
.rl-audit .isnt h3{font-size:18px;margin-bottom:12px}
.rl-audit .isnt ul{list-style:none;margin:0;padding:0;display:grid;gap:9px}
.rl-audit .isnt li{font-size:14.5px;color:var(--ink-dim);display:flex;gap:10px}
.rl-audit .isnt .yes li::before{content:"+";color:var(--red-3);font-family:var(--f-mono)}
.rl-audit .isnt .no li::before{content:"×";color:var(--ink-faint);font-family:var(--f-mono)}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_audit() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'SEO & AI Search Audit', 'serviceType' => 'SEO and AI search audit',
        'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'A one-time, human-led audit of a website’s technical health, content, authority, competitors and visibility in Google and AI search, delivered as a written report, a prioritised fix register and a roadmap.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
        'offers' => ['@type' => 'Offer', 'url' => $url, 'priceCurrency' => 'USD', 'price' => '2500',
            'priceSpecification' => ['@type' => 'PriceSpecification', 'minPrice' => 2500, 'priceCurrency' => 'USD'],
            'description' => 'From $2,500 for a standard website; larger or multi-market sites quoted after scoping.'],
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_audit_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_audit', 'rl_render_audit');
function rl_render_audit() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $diag = $u('search-authority-diagnostic');
    $pkg = $u('packages');
    $req = esc_url(add_query_arg('interest', 'audit', function_exists('rl_url_by_path') ? rl_url_by_path('search-authority-diagnostic', home_url('/')) : home_url('/')) . '#request');
    ob_start(); ?>
<div class="rl-page rl-audit">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">SEO &amp; AI Search Audit</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;SEO &amp; AI Search Audit&nbsp;<b>]</b></span>
      <h1 class="h1">See everything<br>holding back your<br><span class="r">search growth.</span></h1>
      <p class="lede">The <strong>SEO &amp; AI Search Audit</strong> is a one-time, in-depth review of your technical health, content, authority, competitors and visibility in Google and AI search. It is done by people, backed by evidence, and delivered as a prioritised plan your team can act on.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $req; ?>">Request an audit <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#covers">What's included</a>
      </div>
    </div>
    <figure class="swp rl-anim">
      <div class="cap" aria-hidden="true"><span>Audit sweep</span><span>Issues &rarr; fix register</span></div>
      <?php echo rl_audit_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="compare">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Where it fits&nbsp;<b>]</b></span><h2>Diagnostic, audit or package — which do you need?</h2><p class="lede">Three steps, each a bigger commitment than the last. Most teams start with the free diagnostic.</p></div>
    <div class="tscroll" role="region" aria-label="Comparison of the free diagnostic, the audit and the packages" tabindex="0">
      <table>
        <thead><tr><th scope="col">&nbsp;</th><th scope="col">Search Authority Diagnostic</th><th scope="col" class="us">SEO &amp; AI Search Audit</th><th scope="col">Search Authority OS packages</th></tr></thead>
        <tbody>
          <tr><th scope="row">What it is</th><td>A focused read of where you stand</td><td class="us">The full, one-time analysis and plan</td><td>An ongoing system that researches, writes, audits and monitors</td></tr>
          <tr><th scope="row">Depth</th><td>Seven layers, headline findings</td><td class="us">Every important page and template, competitors and a documented AI-visibility test</td><td>Continuous, month after month</td></tr>
          <tr><th scope="row">You get</th><td>Your biggest gaps and the next step</td><td class="us">Report, fix register, roadmap and a walkthrough</td><td>Content, fixes and reporting delivered for you</td></tr>
          <tr><th scope="row">Cost</th><td class="hl">Free</td><td class="us">From $2,500 — credited toward a package within 60 days</td><td>From $5,000 setup</td></tr>
          <tr><th scope="row">Start</th><td><a href="<?php echo $diag; ?>">Request &rarr;</a></td><td class="us">You are here</td><td><a href="<?php echo $pkg; ?>">Compare &rarr;</a></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="covers">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we review&nbsp;<b>]</b></span><h2>What does the audit cover?</h2><p class="lede">Nine areas, reviewed together — because a content problem is often a technical problem, and an AI-visibility problem is often an authority problem.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Technical</span><h3>Technical foundation</h3><p>Crawling, indexing, rendering, architecture, redirects, sitemaps and Core Web Vitals.</p></div>
      <div class="cell"><span class="n">02 · Content</span><h3>Content &amp; topical depth</h3><p>What you cover, what's thin or duplicated, what's missing, and where pages compete with each other.</p></div>
      <div class="cell"><span class="n">03 · Authority</span><h3>Links &amp; mentions</h3><p>Who links to you and mentions you, how that compares with competitors, and risky links.</p></div>
      <div class="cell"><span class="n">04 · AI search</span><h3>AI search visibility</h3><p>Whether AI tools mention, cite and describe you correctly — tested with a documented method.</p></div>
      <div class="cell"><span class="n">05 · Entity</span><h3>Brand &amp; entity accuracy</h3><p>Consistency of your name, description and profiles, and errors AI tools repeat.</p></div>
      <div class="cell"><span class="n">06 · Competitors</span><h3>Competitor benchmark</h3><p>Where named competitors win in Google and AI answers, and why.</p></div>
      <div class="cell"><span class="n">07 · Demand</span><h3>Search demand &amp; gaps</h3><p>The high-value questions and queries you're not yet capturing.</p></div>
      <div class="cell"><span class="n">08 · Local &amp; global</span><h3>Local and international</h3><p>Listings, location pages, hreflang and country versions — where they apply.</p></div>
      <div class="cell"><span class="n">09 · Measurement</span><h3>Tracking you can trust</h3><p>Search Console, analytics and conversion tracking checked, so progress can be measured.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="ai-method">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How we test AI visibility&nbsp;<b>]</b></span><h2>How do you measure AI search visibility properly?</h2><p class="lede">Asking ChatGPT one question once proves nothing — answers change between sessions. This is the method we use, and every result is logged.</p></div>
    <ol class="method-ai">
      <li><h3>Fix the questions</h3><p>Agree a set of real buyer questions with you before testing starts.</p></li>
      <li><h3>Run every engine</h3><p>Ask each question on each AI search tool in scope.</p></li>
      <li><h3>Repeat the runs</h3><p>Run questions more than once, because answers vary.</p></li>
      <li><h3>Log the evidence</h3><p>Record engine, date, location, language, mention, citation and sources.</p></li>
    </ol>
<pre class="log" aria-label="Example of one logged AI visibility test">engine <b>Perplexity</b>   date <b>2026-09-29</b>   location <b>UK</b>   language <b>EN</b>
prompt <b>"best technical SEO partner for a B2B SaaS company"</b>
mentioned <i>no</i>   cited <i>no</i>   sources <b>3 competitors · 1 directory · 1 forum</b>
note   repeat run 2/3 · same result · competitor cited from a comparison page</pre>
    <p class="src">Illustrative example of the log format — not a real client result.</p>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Written report</b> — findings in plain language, with the evidence behind each one.</li>
      <li><b>Fix register</b> — every issue with severity, effort, owner and how to confirm it's fixed.</li>
      <li><b>Prioritised roadmap</b> — what to do first, next and later.</li>
      <li><b>AI visibility log</b> — every prompt test, with engine, date, sources and result.</li>
      <li><b>Competitor benchmark</b> — where named competitors win, in Google and in AI answers.</li>
      <li><b>Opportunity map</b> — the content and pages worth creating or improving.</li>
      <li><b>Measurement check</b> — what your tracking can and can't tell you today.</li>
      <li><b>60-minute walkthrough</b> — we take your team through the findings and answer questions.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="pricing">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Pricing&nbsp;<b>]</b></span><h2>How much does the audit cost?</h2><p class="lede">One fixed price for a standard website, agreed before any work starts. Bigger or more complex sites are quoted after a short scoping call.</p></div>
    <div class="price">
      <div class="p-main"><span class="p-from">From</span><span class="p-amt">$2,500</span><span class="p-note">one-time · standard website</span><a class="btn p" href="<?php echo $req; ?>">Request an audit <span class="ar">&rarr;</span></a></div>
      <ul class="p-list">
        <li><b>10 business days</b><span>from confirmed access and scope to delivered report</span></li>
        <li><b>60-minute walkthrough</b><span>with your team, to go through every priority</span></li>
        <li><b>Credited in full</b><span>toward a Search Authority OS package started within 60 days</span></li>
        <li><b>Quoted separately</b><span>for large, multi-market or very large sites</span></li>
      </ul>
    </div>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does the audit run?</h2><p class="lede">Scoped first, so the price and delivery date are clear before any work starts.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Scope</h3><p>A short call on goals, markets and competitors, then a written scope.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Access &amp; data</h3><p>Read-only access to Search Console and analytics; CMS access only if needed.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Crawl &amp; research</h3><p>Crawl the site, test AI visibility and research demand and competitors.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Analyse &amp; verify</h3><p>People review every finding, check the evidence and set the priorities.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Report &amp; walkthrough</h3><p>Deliver the report, fix register and roadmap — and walk your team through them.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="isnt">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Clear boundaries&nbsp;<b>]</b></span><h2>What is — and isn't — in the audit?</h2></div>
    <div class="isnt">
      <div class="yes"><h3>The audit is</h3><ul><li>A human-led analysis, with tools used to collect data</li><li>Evidence-backed: every finding shows what we saw and where</li><li>Prioritised by impact and effort</li><li>Written for the people who will fix things</li><li>Yours to keep and use in-house</li></ul></div>
      <div class="no"><h3>The audit isn't</h3><ul><li>An automated tool export with your logo on it</li><li>A promise of rankings or AI citations — nobody can honestly make one</li><li>Implementation — that's a separate service if you want it</li><li>A sales call in disguise — the plan stands on its own</li></ul></div>
    </div>
  </div>
</section>

<section id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is the audit for?</h2><p class="lede">Teams that need the full picture before they commit budget — after a traffic drop, before a redesign or migration, or when AI tools ignore them.</p></div>
    <ul class="inds8">
      <?php foreach (rl_audit_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('SEO & AI Search Audit for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section class="band alt" id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;After the audit&nbsp;<b>]</b></span><h2>Who can fix what the audit finds?</h2><p class="lede">Implement it yourself, or hand any part of the plan to the service built for it.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/technical-seo-services', 'Technical', 'Technical SEO', 'Crawlability, indexation, speed and structured data — fixed and verified.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'Visibility, accuracy and recommendations across AI search.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Research-led, evidence-checked content produced as a system.'],
          ['services/llm-optimization', 'Entity level', 'LLM Optimization', 'Consistent brand facts so AI tools describe you correctly.'],
          ['services/local-seo', 'Local', 'Local SEO', 'Listings, reviews and location pages for every place you serve.'],
          ['packages', 'Everything', 'Search Authority OS packages', 'The full system, run month after month — from $5,000 setup.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About the audit.</h2></div>
    <?php foreach (rl_audit_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Not sure you need the full audit yet?</h2>
      <p class="lede">Start with the free Search Authority Diagnostic. If you need to go deeper, we'll scope the audit from there.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $req; ?>">Request an audit <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $diag; ?>">Start with the free diagnostic</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
