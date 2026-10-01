<?php
/**
 * Plugin Name: Reinforce Lab - Packages & Pricing
 * Description: /packages/ (design: claude/design-previews/packages.html). Provides [reinforce_packages]. Pricing page only - no cart / self-checkout (D-017). Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_pkg() { return is_page('packages'); }

/* ---------- single source for plans, FAQ (markup + schema) ---------- */
function rl_pkg_plans() {
    return [
        ['tier' => '01 · Foundation', 'name' => 'Search Authority Foundation', 'price' => '$5,000', 'monthly' => 'setup + $1,500–$2,500 / month', 'min' => 5000, 'max' => 5000, 'feat' => false, 'cta' => 'Start here',
         'for' => 'Best entry point: get the intelligence engine running and start producing authority content.',
         'items' => ['SEO + SERP intelligence', 'Web research (Jina · Exa · Firecrawl)', 'Social sentiment &amp; complaint research', 'Evidence verification layer', 'AI Search / AEO / GEO optimization', 'Content strategy', '20–30 assets / month', 'Quality-control gates', 'GSC + GA4 reporting', '7-day performance reporting', 'Project-specific memory']],
        ['tier' => '02 · Growth OS · Most chosen', 'name' => 'Search Authority Growth OS', 'price' => '$10,000', 'monthly' => 'setup + $3,500–$5,000 / month', 'min' => 10000, 'max' => 10000, 'feat' => true, 'cta' => 'Get the Growth OS', 'inc' => 'Everything in Foundation, plus:',
         'for' => 'The core commercial offer: a self-improving engine that compounds authority month over month.',
         'items' => ['40–60 assets / month', 'Competitor intelligence', 'AI visibility monitoring', 'Original-data research', 'Content refresh engine', 'Cannibalization detection', 'SERP gap analysis', 'Voice-of-customer intelligence', 'Automated performance diagnosis', 'Internal-linking intelligence', 'Self-improvement feedback loop', 'Executive authority content', 'Custom reporting dashboard']],
        ['tier' => '03 · Enterprise', 'name' => 'Enterprise Intelligence OS', 'price' => '$20k–$35k+', 'monthly' => 'setup + $7,500–$15,000+ / month', 'min' => 20000, 'max' => null, 'feat' => false, 'cta' => 'Talk to us', 'inc' => 'Everything in Growth OS, plus:',
         'for' => 'For Pharma, Life Sciences, Finance, Healthcare and enterprise: evidence-grade, governed, multi-market.',
         'items' => ['Scientific evidence connectors (PubMed, Europe PMC, PubChem, ClinicalTrials.gov, FDA)', 'Regulatory intelligence', 'Patent intelligence', 'Industry-specific evidence graph', 'Advanced fact verification', 'Multi-market intelligence', 'AI / LLM visibility monitoring', 'Self-healing optimization', 'Custom agents &amp; API integrations', 'Enterprise governance', 'Human approval workflows', 'Executive intelligence reports']],
    ];
}
function rl_pkg_faqs() {
    return [
        ["Why can't I just buy online?", 'Because good work is scoped, not vending-machined. A $5k–$35k engagement depends on your industry, evidence requirements and goals. The diagnostic and a short call let us price it honestly, and let you see the intelligence before you commit.'],
        ['Is there a contract?', "It's a monthly retainer scoped to the plan. You own everything produced, and you can adjust scope as results come in."],
        ['How fast will we see results?', "Publishing can begin quickly; search authority compounds over months and varies by site, topic and competition. We connect GSC and GA4 so you track real movement; we don't promise a ranking date."],
        ['Can we start small and scale up?', 'Yes. Begin with Foundation or a single agent, then move to Growth OS or Enterprise as the system proves out.'],
        ['What makes this different from an agency or a tool?', 'An agency gives you people; a tool gives you software. Search Authority OS gives you an intelligence system (research, evidence, production, QA and self-healing) run by a team, tuned to your industry.'],
    ];
}

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_pkg()) $c[] = 'rl-pkg-page'; return $c; });
add_action('wp_head', 'rl_pkg_css', 22);
function rl_pkg_css() {
    if (!rl_is_pkg()) return; ?>
<style id="rl-pkg-css">
.rl-pkg{position:relative;width:100vw;margin-left:calc(50% - 50vw);--r:0px;--pill:0px;color:var(--ink);font-family:var(--f-body);font-size:16px;line-height:1.6}
body.rl-pkg-page .fl-page-content,body.rl-pkg-page .fl-content,body.rl-pkg-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-pkg *{box-sizing:border-box}
.rl-pkg a{text-decoration:none;color:inherit}
.rl-pkg h1,.rl-pkg h2,.rl-pkg h3,.rl-pkg h4{color:var(--ink)}
.rl-pkg .crumbs{padding-top:clamp(18px,2.4vw,28px);font-family:var(--f-mono);font-size:11.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-pkg .crumbs ol{list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:.6em}
.rl-pkg .crumbs li+li::before{content:"/";color:var(--red-2);margin-right:.6em}
.rl-pkg .crumbs a:hover{color:var(--ink)}.rl-pkg .crumbs [aria-current]{color:var(--ink-dim)}
.rl-pkg .sr{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(1px,1px,1px,1px);white-space:nowrap}
/* ---- ported from design preview (scoped) ---- */
.rl-pkg h1,.rl-pkg h2,.rl-pkg h3,.rl-pkg h4{font-family:var(--f-display);font-weight:600;text-transform:uppercase;margin:0;line-height:1.02;letter-spacing:.01em;text-wrap:balance}
.rl-pkg p{margin:0}
.rl-pkg ::selection{background:var(--red);color:#fff}
.rl-pkg :focus-visible{outline:2px solid var(--red-2);outline-offset:3px}
.rl-pkg .wrap{max-width:var(--maxw);margin:0 auto;padding-inline:var(--gutter)}
.rl-pkg .band{border-top:1px solid var(--line)}
.rl-pkg .band.alt{background:radial-gradient(90% 60% at 15% 0%,rgba(153,0,0,.10),transparent 55%),var(--bg-2)}
.rl-pkg section{position:relative;padding-block:clamp(52px,8vw,92px)}
.rl-pkg .ey{font-family:var(--f-mono);font-size:12px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-faint);display:inline-flex;gap:.5em;align-items:center}
.rl-pkg .ey b{color:var(--red-3);font-weight:500}
.rl-pkg .lede{color:var(--ink-dim);font-size:clamp(15px,1.6vw,19px);max-width:62ch}
.rl-pkg .head{max-width:66ch;margin-bottom:clamp(28px,5vw,48px)}
.rl-pkg .head h2{font-size:clamp(26px,4vw,44px);margin-top:14px}
.rl-pkg .head p{margin-top:16px}
.rl-pkg .center{text-align:center;margin-inline:auto}
.rl-pkg .btn{font-family:var(--f-display);text-transform:uppercase;font-weight:600;letter-spacing:.05em;font-size:14px;padding:15px 26px;display:inline-flex;align-items:center;gap:.55em;border:1px solid transparent;cursor:pointer;transition:.2s;border-radius:var(--pill)}
.rl-pkg .btn::before{content:"+";font-family:var(--f-mono);font-weight:500;color:var(--red-3);font-size:1.15em;line-height:0}
.rl-pkg .btn.p{background:linear-gradient(180deg,#241a1c,#120e0f);color:#fff;border-color:var(--red-line);box-shadow:14px 0 44px -14px var(--red-glow),inset 0 1px 0 var(--glass-hi)}
.rl-pkg .btn.p:hover{border-color:var(--red-2);box-shadow:20px 0 60px -12px var(--red-glow),inset 0 1px 0 var(--glass-hi);transform:translateY(-1px)}
.rl-pkg .btn.g{background:var(--glass);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);color:var(--ink);border-color:var(--glass-line)}
.rl-pkg .btn.g::before{color:var(--ink-faint)}
.rl-pkg .btn.g:hover{border-color:var(--red-line);color:#fff}
.rl-pkg .btn.full{width:100%;justify-content:center}
.rl-pkg .hero{padding-block:clamp(40px,6vw,72px);text-align:center}
.rl-pkg .h1{font-size:clamp(32px,5vw,60px);font-weight:700;letter-spacing:-.01em;line-height:1.02;max-width:16ch;margin-inline:auto}
.rl-pkg .h1 .r{color:var(--red-2)}
.rl-pkg .hero .lede{margin:18px auto 0}
.rl-pkg .hero-cta{display:flex;flex-wrap:wrap;gap:14px;margin-top:26px;justify-content:center}
.rl-pkg .hero .micro{margin-top:18px;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.04em}
.rl-pkg .pkgs{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;align-items:start}
@media(max-width:900px){.rl-pkg .pkgs{grid-template-columns:1fr}}
.rl-pkg .pkg{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:30px 26px;display:flex;flex-direction:column;gap:16px;box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9)}
.rl-pkg .pkg.feat{background:linear-gradient(180deg,rgba(153,0,0,.14),var(--glass-2));border-color:var(--red-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 0 70px -26px var(--red-glow)}
.rl-pkg .pkg .tier{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;color:var(--red-3);text-transform:uppercase}
.rl-pkg .pkg h3{font-size:23px}
.rl-pkg .pkg .price{font-family:var(--f-display);font-size:26px;font-weight:600}
.rl-pkg .pkg .price small{display:block;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);font-weight:400;letter-spacing:.03em;margin-top:6px;text-transform:none}
.rl-pkg .pkg .for{font-size:13.5px;color:var(--ink-dim);border-top:1px solid var(--line);border-bottom:1px solid var(--line);padding:12px 0}
.rl-pkg .pkg ul{list-style:none;margin:0;padding:0;display:grid;gap:10px}
.rl-pkg .pkg li{font-size:14px;color:var(--ink-dim);display:flex;gap:10px}
.rl-pkg .pkg li::before{content:"+";color:var(--red-3);font-family:var(--f-mono);flex:none}
.rl-pkg .pkg li.inc{color:var(--ink);font-weight:600}
.rl-pkg .pkg li.inc::before{content:"";width:7px;height:7px;margin:4px 3px 0 2px;border-left:1.5px solid var(--red-3);border-bottom:1.5px solid var(--red-3)}
.rl-pkg .pkg .btn{margin-top:auto;justify-content:center}
.rl-pkg .mx-scroll{overflow-x:auto;border:1px solid var(--line)}
.rl-pkg .mx{width:100%;border-collapse:collapse;font-size:14px;min-width:620px}
.rl-pkg .mx th,.rl-pkg .mx td{padding:13px 16px;border-bottom:1px solid var(--line);text-align:left}
.rl-pkg .mx thead th{font-family:var(--f-display);text-transform:uppercase;font-size:13px;letter-spacing:.04em;color:var(--ink)}
.rl-pkg .mx thead th:nth-child(3){color:var(--red-3)}
.rl-pkg .mx td:first-child{color:var(--ink-dim)}
.rl-pkg .mx td.c{text-align:center;font-family:var(--f-mono)}
.rl-pkg .mx .yes{color:var(--red-3)}
.rl-pkg .mx .no{color:var(--line-2)}
.rl-pkg .mx tbody tr:hover{background:rgba(255,255,255,.02)}
.rl-pkg .cols{display:grid;gap:16px}
.rl-pkg .c3{grid-template-columns:repeat(3,1fr)}
.rl-pkg .c4{grid-template-columns:repeat(4,1fr)}
@media(max-width:900px){.rl-pkg .c3,.rl-pkg .c4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rl-pkg .c3,.rl-pkg .c4{grid-template-columns:1fr}}
.rl-pkg .cell{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-pkg .cell .n{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.1em}
.rl-pkg .cell h3{font-size:17px;margin:10px 0 7px}
.rl-pkg .cell p{color:var(--ink-dim);font-size:14px}
.rl-pkg .faq details{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);margin-bottom:12px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-pkg .faq summary{cursor:pointer;padding:20px 24px;font-family:var(--f-display);text-transform:uppercase;font-size:16px;letter-spacing:.02em;list-style:none;display:flex;justify-content:space-between;gap:16px;align-items:center}
.rl-pkg .faq summary::-webkit-details-marker{display:none}
.rl-pkg .faq summary::after{content:"+";color:var(--red-3);font-family:var(--f-mono);font-size:20px}
.rl-pkg .faq details[open] summary::after{content:"–"}
.rl-pkg .faq p{padding:0 24px 22px;color:var(--ink-dim);font-size:15px;max-width:80ch}
.rl-pkg .final{position:relative;overflow:hidden;border:1px solid var(--red-line);background:#0b090a;padding:clamp(48px,7vw,92px) clamp(24px,5vw,64px);text-align:center;box-shadow:inset 0 1px 0 var(--glass-hi),0 0 130px -46px var(--red-glow)}
.rl-pkg .final::before{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(58% 96% at 50% 128%,rgba(226,59,59,.6),rgba(153,0,0,.28) 38%,transparent 70%),linear-gradient(180deg,transparent 40%,rgba(153,0,0,.10))}
.rl-pkg .final::after{content:"";position:absolute;inset:0;pointer-events:none;background:linear-gradient(102deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%),linear-gradient(258deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%)}
.rl-pkg .final>*{position:relative;z-index:2}
.rl-pkg .final h2{font-size:clamp(28px,5vw,52px)}
.rl-pkg .final .lede{margin:18px auto 26px}
.rl-pkg .final .cta{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
/* build additions */
.rl-pkg .ey{flex-wrap:wrap;row-gap:.2em}
.rl-pkg .mx-scroll{position:relative} /* contains the absolutely-positioned .sr labels so they can't widen the page on mobile */
/* hero: left-aligned + visual (D-039) - overrides the centred mock-up hero */
.rl-pkg .hero{text-align:left}
.rl-pkg .hero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:clamp(28px,4vw,56px);align-items:center}
@media(max-width:940px){.rl-pkg .hero-grid{grid-template-columns:1fr;gap:34px}}
.rl-pkg .hero .h1{margin-inline:0;max-width:14ch}
.rl-pkg .hero .lede{margin:18px 0 0}
.rl-pkg .hero .hero-cta{justify-content:flex-start}
/* hero visual: compounding staircase - refined chart (D-039, rev 2): one-time build, then subtle ambient motion */
.rl-pkg .stair{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 22px 12px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-pkg .stair .cap{display:flex;justify-content:space-between;gap:12px}
.rl-pkg .stair .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-pkg .pk-grid{stroke:var(--line);opacity:.7}
.rl-pkg .pk-axis{stroke:var(--line-2)}
.rl-pkg .pk-b{transform-box:fill-box;transform-origin:50% 100%;animation:rlpGrowL 10s cubic-bezier(.16,.84,.24,1) infinite both;animation-delay:var(--d)}
.rl-pkg .pk-blk{stroke:none}
.rl-pkg .pk-seg{stroke:#fff;stroke-opacity:.06}
.rl-pkg .pk-b.feat .pk-seg{stroke:#e23b3b;stroke-opacity:.2}
.rl-pkg .pk-top{stroke:var(--ink-faint);stroke-width:1.5}.rl-pkg .pk-b.feat .pk-top{stroke:var(--red-3)}
.rl-pkg .pk-name{font-family:var(--f-display);font-size:12px;letter-spacing:.09em;fill:var(--ink);font-weight:500}
.rl-pkg .pk-price{font-family:var(--f-mono);font-size:10px;fill:var(--ink-faint);letter-spacing:.04em}
.rl-pkg .pk-area{animation:rlpAreaL 10s ease infinite both}
.rl-pkg .pk-curve{fill:none;stroke-width:1.6;stroke-linecap:round;stroke-dashoffset:0;animation:rlpDrawL 10s cubic-bezier(.45,.05,.25,1) infinite both}
.rl-pkg .pk-shine{fill:none;stroke:#fff;stroke-width:1.6;stroke-linecap:round;opacity:0;animation:rlpShineL 10s cubic-bezier(.45,.05,.55,.95) infinite both}
.rl-pkg .pk-mk{fill:var(--bg);stroke:var(--red-3);stroke-width:1.2;transform-box:fill-box;transform-origin:center;animation:rlpPopL 10s ease infinite both;animation-delay:var(--d)}
.rl-pkg .pk-head{animation:rlpHeadL 10s ease infinite both}
.rl-pkg .pk-dot{fill:var(--red-3)}
.rl-pkg .pk-halo{fill:none;stroke:var(--red-3);transform-box:fill-box;transform-origin:center;opacity:0;animation:rlpPulse 2.6s ease-out infinite;animation-delay:3s}
.rl-pkg .pk-lab{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.2em;fill:var(--ink-dim)}
@media(max-width:560px){.rl-pkg .stair .cap span+span{display:none}.rl-pkg .pk-name{font-size:15px;letter-spacing:.04em}.rl-pkg .pk-price{font-size:13px}.rl-pkg .pk-lab{font-size:13px}.rl-pkg .stair{padding:16px 12px 8px}}
/* 10 s loop: build (0–30%) → hold (30–86%) → smooth glide-out (86–94%) → rebuild. No flashes. */
@keyframes rlpGrowL{0%{transform:scaleY(0);opacity:1}12%{transform:scaleY(1);opacity:1}86%{transform:scaleY(1);opacity:1}94%{transform:scaleY(1);opacity:0}100%{transform:scaleY(0);opacity:0}}
@keyframes rlpAreaL{0%,20%{opacity:0}32%,86%{opacity:1}94%,100%{opacity:0}}
@keyframes rlpDrawL{0%,9%{stroke-dashoffset:var(--L);opacity:1}27%{stroke-dashoffset:0;opacity:1}86%{stroke-dashoffset:0;opacity:1}94%,100%{stroke-dashoffset:0;opacity:0}}
@keyframes rlpShineL{0%,32%{stroke-dashoffset:38;opacity:0}36%{opacity:.5}70%{opacity:.5}78%,100%{stroke-dashoffset:calc(var(--L) * -1);opacity:0}}
@keyframes rlpPopL{0%{opacity:0;transform:scale(.4)}5%{opacity:1;transform:scale(1)}72%{opacity:1;transform:scale(1)}80%,100%{opacity:0;transform:scale(1)}}
@keyframes rlpHeadL{0%,26%{opacity:0}31%,86%{opacity:1}94%,100%{opacity:0}}
@keyframes rlpPulse{0%{opacity:.7;transform:scale(1)}100%{opacity:0;transform:scale(2.6)}}
.rl-pkg .mx tbody th{padding:13px 16px;border-bottom:1px solid var(--line);text-align:left;font-weight:400;color:var(--ink-dim)}
.rl-pkg a.cell{display:block;transition:.2s}.rl-pkg a.cell:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-pkg .lede a,.rl-pkg .faq p a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-pkg ul.pl{list-style:none;margin:0;padding:0;display:grid;gap:10px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_pkg() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $offers = array_map(function ($p) use ($url) {
        $spec = ['@type' => 'PriceSpecification', 'priceCurrency' => 'USD', 'minPrice' => $p['min'], 'description' => 'Setup fee; ' . $p['monthly'] . ' retainer'];
        if ($p['max']) $spec['maxPrice'] = $p['max'];
        return ['@type' => 'Offer', 'name' => $p['name'], 'description' => $p['for'], 'url' => $url . '#plans', 'priceSpecification' => $spec];
    }, rl_pkg_plans());
    $graph[] = [
        '@type' => 'Service',
        '@id' => $url . '#service',
        'name' => 'Search Authority OS',
        'description' => 'Search Authority OS packages from Reinforce Lab: Foundation, Growth OS and Enterprise Intelligence OS, scoped after a free diagnostic.',
        'url' => $url,
        'provider' => ['@id' => home_url('/') . '#organization'],
        'hasOfferCatalog' => ['@type' => 'OfferCatalog', 'name' => 'Search Authority OS packages', 'itemListElement' => $offers],
        'mainEntityOfPage' => ['@id' => $url],
    ];
    $graph[] = [
        '@type' => 'FAQPage',
        '@id' => $url . '#faq',
        'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) {
            return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]];
        }, rl_pkg_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_packages', 'rl_render_packages');
function rl_render_packages() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $matrix = [
        ['Assets per month', '20–30', '40–60', 'Scoped'],
        ['Search + SERP intelligence', 1, 1, 1],
        ['Evidence verification', 1, 1, 1],
        ['AEO / GEO optimization', 1, 1, 1],
        ['GSC + GA4 + 7-day reporting', 1, 1, 1],
        ['Competitor + AI-visibility monitoring', 0, 1, 1],
        ['Original-data research', 0, 1, 1],
        ['Self-improvement / self-healing loop', 0, 1, 1],
        ['Custom reporting dashboard', 0, 1, 1],
        ['Scientific / regulatory / patent evidence', 0, 0, 1],
        ['Governance + human approval workflows', 0, 0, 1],
        ['Custom agents + API integrations', 0, 0, 1],
    ];
    $cell = function ($v) {
        if ($v === 1) return '<td class="c yes"><span aria-hidden="true"><svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M3 8.5l3 3 7-7"/></svg></span><span class="sr">Included</span></td>';
        if ($v === 0) return '<td class="c no"><span aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><span class="sr">Not included</span></td>';
        return '<td class="c">' . esc_html($v) . '</td>';
    };
    $agents = [['A-01', 'seo-intelligence', 'Search Intelligence', 'Know exactly what to rank for.'], ['A-03', 'evidence-verification', 'Evidence Verification', 'Fact-checked, sourced content.'], ['A-04', 'aeo-geo-optimization', 'AEO / GEO', 'Show up inside AI answers.'], ['A-08', 'search-performance', 'Search Performance', 'Diagnose drops, recover rankings.']];
    ob_start(); ?>
<div class="rl-pkg">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Packages</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Packages&nbsp;<b>]</b></span>
      <h1 class="h1">Three ways to build <span class="r">search authority.</span></h1>
      <p class="lede"><a href="<?php echo $u('search-authority-os'); ?>">Search Authority OS</a> comes in three packages (Foundation, Growth OS and Enterprise), from a focused foundation to a full enterprise intelligence engine. Every engagement starts with a diagnostic, so scope and price fit what you actually need, not a template.</p>
      <div class="hero-cta"><a class="btn p" href="<?php echo $diag; ?>">Start with a diagnostic <span class="ar">&rarr;</span></a><a class="btn g" href="#plans">See the plans</a></div>
      <p class="micro">Setup + monthly retainer · Pricing below is a starting framework, finalized to scope</p>
    </div>
    <figure class="stair rl-anim" role="img" aria-label="Three packages as a rising staircase (Foundation, Growth OS and Enterprise), each adding capabilities, with search authority compounding across them.">
      <div class="cap" aria-hidden="true"><span>Scale path</span><span>Setup + monthly retainer</span></div>
      <div aria-hidden="true"><svg viewBox="0 0 520 420" xmlns="http://www.w3.org/2000/svg" focusable="false"><defs><linearGradient id="pkgB" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#ffffff" stop-opacity=".07"/><stop offset="1" stop-color="#ffffff" stop-opacity=".01"/></linearGradient><linearGradient id="pkgBF" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#c11414" stop-opacity=".34"/><stop offset="1" stop-color="#c11414" stop-opacity=".03"/></linearGradient><linearGradient id="pkgA" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#e23b3b" stop-opacity=".20"/><stop offset="1" stop-color="#e23b3b" stop-opacity="0"/></linearGradient><linearGradient id="pkgC" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#e23b3b" stop-opacity=".25"/><stop offset=".6" stop-color="#e23b3b" stop-opacity=".85"/><stop offset="1" stop-color="#ff6b6b"/></linearGradient></defs><line class="pk-grid" x1="44" y1="104" x2="492" y2="104"/><line class="pk-grid" x1="44" y1="184" x2="492" y2="184"/><line class="pk-grid" x1="44" y1="264" x2="492" y2="264"/><line class="pk-axis" x1="44" y1="344" x2="492" y2="344"/><g class="pk-b" style="--d:.15s"><rect class="pk-blk" x="88.0" y="252" width="84" height="92" fill="url(#pkgB)"/><line class="pk-seg" x1="98.0" y1="324" x2="162.0" y2="324"/><line class="pk-seg" x1="98.0" y1="304" x2="162.0" y2="304"/><line class="pk-seg" x1="98.0" y1="284" x2="162.0" y2="284"/><line class="pk-seg" x1="98.0" y1="264" x2="162.0" y2="264"/><line class="pk-top" x1="88.0" y1="252" x2="172.0" y2="252"/></g><text class="pk-name" x="130" y="368" text-anchor="middle">FOUNDATION</text><text class="pk-price" x="130" y="385" text-anchor="middle">$5k setup</text><g class="pk-b feat" style="--d:.35s"><rect class="pk-blk" x="218.0" y="176" width="84" height="168" fill="url(#pkgBF)"/><line class="pk-seg" x1="228.0" y1="324" x2="292.0" y2="324"/><line class="pk-seg" x1="228.0" y1="304" x2="292.0" y2="304"/><line class="pk-seg" x1="228.0" y1="284" x2="292.0" y2="284"/><line class="pk-seg" x1="228.0" y1="264" x2="292.0" y2="264"/><line class="pk-seg" x1="228.0" y1="244" x2="292.0" y2="244"/><line class="pk-seg" x1="228.0" y1="224" x2="292.0" y2="224"/><line class="pk-seg" x1="228.0" y1="204" x2="292.0" y2="204"/><line class="pk-top" x1="218.0" y1="176" x2="302.0" y2="176"/></g><text class="pk-name" x="260" y="368" text-anchor="middle">GROWTH OS</text><text class="pk-price" x="260" y="385" text-anchor="middle">$10k setup</text><g class="pk-b" style="--d:.55s"><rect class="pk-blk" x="348.0" y="100" width="84" height="244" fill="url(#pkgB)"/><line class="pk-seg" x1="358.0" y1="324" x2="422.0" y2="324"/><line class="pk-seg" x1="358.0" y1="304" x2="422.0" y2="304"/><line class="pk-seg" x1="358.0" y1="284" x2="422.0" y2="284"/><line class="pk-seg" x1="358.0" y1="264" x2="422.0" y2="264"/><line class="pk-seg" x1="358.0" y1="244" x2="422.0" y2="244"/><line class="pk-seg" x1="358.0" y1="224" x2="422.0" y2="224"/><line class="pk-seg" x1="358.0" y1="204" x2="422.0" y2="204"/><line class="pk-seg" x1="358.0" y1="184" x2="422.0" y2="184"/><line class="pk-seg" x1="358.0" y1="164" x2="422.0" y2="164"/><line class="pk-seg" x1="358.0" y1="144" x2="422.0" y2="144"/><line class="pk-seg" x1="358.0" y1="124" x2="422.0" y2="124"/><line class="pk-top" x1="348.0" y1="100" x2="432.0" y2="100"/></g><text class="pk-name" x="390" y="368" text-anchor="middle">ENTERPRISE</text><text class="pk-price" x="390" y="385" text-anchor="middle">$20k+ setup</text><path class="pk-area" d="M58,334 C70.0,327.7 96.3,317.3 130,296 C163.7,274.7 216.7,236.7 260,206 C303.3,175.3 354.0,136.0 390,112 C426.0,88.0 461.7,70.3 476,62 L476,344 L58,344 Z" fill="url(#pkgA)"/><path class="pk-curve" d="M58,334 C70.0,327.7 96.3,317.3 130,296 C163.7,274.7 216.7,236.7 260,206 C303.3,175.3 354.0,136.0 390,112 C426.0,88.0 461.7,70.3 476,62" stroke="url(#pkgC)" stroke-dasharray="500" style="--L:500"/><path class="pk-shine" d="M58,334 C70.0,327.7 96.3,317.3 130,296 C163.7,274.7 216.7,236.7 260,206 C303.3,175.3 354.0,136.0 390,112 C426.0,88.0 461.7,70.3 476,62" stroke-dasharray="38 500" style="--L:500"/><rect class="pk-mk" x="126.5" y="292.5" width="7" height="7" style="--d:1.25s"/><rect class="pk-mk" x="256.5" y="202.5" width="7" height="7" style="--d:1.60s"/><rect class="pk-mk" x="386.5" y="108.5" width="7" height="7" style="--d:1.95s"/><g class="pk-head"><rect class="pk-halo" x="470" y="56" width="12" height="12"/><rect class="pk-dot" x="472" y="58" width="8" height="8"/><text class="pk-lab" x="462" y="48" text-anchor="end">AUTHORITY</text></g></svg></div>
    </figure>
  </div>
</section>

<section class="band alt" id="plans">
  <div class="wrap">
    <h2 class="sr">The three Search Authority OS packages</h2>
    <div class="pkgs">
      <?php foreach (rl_pkg_plans() as $p) { ?>
      <div class="pkg<?php echo $p['feat'] ? ' feat' : ''; ?>">
        <div class="tier"><?php echo esc_html($p['tier']); ?></div>
        <h3><?php echo esc_html($p['name']); ?></h3>
        <div class="price"><?php echo esc_html($p['price']); ?> <small><?php echo esc_html($p['monthly']); ?></small></div>
        <div class="for"><?php echo esc_html($p['for']); ?></div>
        <ul>
          <?php if (!empty($p['inc'])) echo '<li class="inc">' . esc_html($p['inc']) . '</li>'; ?>
          <?php foreach ($p['items'] as $it) echo '<li>' . $it . '</li>'; ?>
        </ul>
        <a class="btn <?php echo $p['feat'] ? 'p' : 'g'; ?> full" href="<?php echo $diag; ?>"><?php echo esc_html($p['cta']); ?> <span class="ar">&rarr;</span></a>
      </div>
      <?php } ?>
    </div>
    <p class="micro center" style="margin-top:22px;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint)">No cart, no self-checkout. High-stakes work is scoped on a call; the diagnostic comes first.</p>
  </div>
</section>

<section id="compare">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Compare&nbsp;<b>]</b></span><h2>What's in each plan.</h2></div>
    <div class="mx-scroll">
      <table class="mx">
        <caption class="sr">Capabilities included in each Search Authority OS package</caption>
        <thead><tr><th scope="col">Capability</th><th scope="col">Foundation</th><th scope="col">Growth OS</th><th scope="col">Enterprise</th></tr></thead>
        <tbody>
          <?php foreach ($matrix as $r) { echo '<tr><th scope="row">' . esc_html($r[0]) . '</th>' . $cell($r[1]) . $cell($r[2]) . $cell($r[3]) . '</tr>'; } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="band alt" id="agents">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;À la carte&nbsp;<b>]</b></span><h2>Not ready for the full OS? Start with one agent.</h2><p class="lede">Each agent solves a specific problem and can run on its own. Adopt the system, or begin where the pain is sharpest.</p></div>
    <div class="cols c4">
      <?php foreach ($agents as $a) { ?>
      <a class="cell" href="<?php echo $u('services/agents/' . $a[1]); ?>"><div class="n"><?php echo $a[0]; ?></div><h3><?php echo esc_html($a[2]); ?></h3><p><?php echo esc_html($a[3]); ?></p></a>
      <?php } ?>
    </div>
    <div class="hero-cta" style="justify-content:flex-start;margin-top:22px"><a class="btn g" href="<?php echo $u('services/agents'); ?>">See all 8 agents <span class="ar">&rarr;</span></a></div>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>From diagnostic to compounding authority.</h2></div>
    <ol class="cols c4" style="list-style:none;margin:0;padding:0">
      <li class="cell"><div class="n">01</div><h3>Diagnostic</h3><p>We establish your real baseline and the highest-value opportunities.</p></li>
      <li class="cell"><div class="n">02</div><h3>Scope &amp; proposal</h3><p>A plan and price fit to your goals, no template retainer.</p></li>
      <li class="cell"><div class="n">03</div><h3>Build &amp; onboard</h3><p>The intelligence engine is configured to your market and evidence sources.</p></li>
      <li class="cell"><div class="n">04</div><h3>Publish &amp; self-heal</h3><p>Content ships, performance is monitored, and the system improves itself.</p></li>
    </ol>
  </div>
</section>

<section class="band alt faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About pricing &amp; engagement.</h2></div>
    <?php foreach (rl_pkg_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="cta">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Not sure which plan fits?</h2>
      <p class="lede">Start with the diagnostic. It shows exactly where you stand and which plan matches the opportunity, before you commit to a retainer.</p>
      <div class="cta"><a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a><a class="btn g" href="#plans">Compare plans again</a></div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
