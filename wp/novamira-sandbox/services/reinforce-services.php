<?php
/**
 * Plugin Name: Reinforce Lab - Services hub
 * Description: /services/ - every service grouped, a problem-first router, how services connect (AI Growth Systems · Search Authority OS · Agents), method, industries, FAQ. Provides [reinforce_services]. Hero animation "Capability grid" (D-039 Step 3). Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_services() { return is_page('services') && !wp_get_post_parent_id(get_queried_object_id()); }

/* ---------- single source: services (cards, hero grid, ItemList schema) ----------
   [slug under /services/, name, short tile label, one-line description] */
function rl_services_groups() {
    return [
        ['seo', 'Search Engine Optimization', 'Search', 'Rankings and clicks in Google and Bing, built on technical health, strategy and authority.', [
            ['best-search-engine-optimization-services', 'Search Engine Optimization', 'SEO', 'The core SEO program: strategy, on-page, technical and authority work in one plan.'],
            ['technical-seo-services', 'Technical SEO', 'Technical', 'Crawlability, indexation, architecture and speed, so search engines and AI crawlers can reach every page that matters.'],
            ['enterprise-seo-strategy', 'Enterprise SEO Strategy', 'Enterprise', 'Search strategy for large sites and multi-team organisations: governance, priorities and authority at scale.'],
            ['international-seo', 'International SEO', 'International', 'Multi-country and multi-language search: hreflang, market targeting and localised content.'],
            ['local-seo', 'Local SEO', 'Local', 'Visibility in map results and local searches for every location you serve.'],
            ['seo-ai-search-audit', 'SEO & AI Search Audit', 'Audit', 'A full review of Google and AI-search performance with a prioritised fix list.'],
        ]],
        ['ai', 'AI Search & Content', 'AI Search', 'Be the source AI engines find, trust and cite, with content produced as a system.', [
            ['ai-search-optimization', 'AI Search Optimization (AISO)', 'AI Search', 'Be found, trusted and recommended in ChatGPT, Perplexity, Gemini and Google AI Overviews.'],
            ['generative-engine-optimization', 'Generative Engine Optimization (GEO)', 'GEO', 'Structure content and entity signals so generative engines extract, cite and link to you.'],
            ['llm-optimization', 'LLM Optimization', 'LLM', 'Shape how large language models understand and describe your brand, products and expertise.'],
            ['seo-content-systems', 'SEO Content Systems', 'Content', 'Research-led, evidence-checked content run as a system: briefs, writing, QA and refresh.'],
            ['press-release-services', 'Digital PR', 'Digital PR', 'Earned mentions and coverage that build authority for Google and AI engines.'],
        ]],
        ['auto', 'Automation & Growth', 'Automation', 'Remove manual work and turn search demand into qualified pipeline.', [
            ['ai-workflow-automation', 'AI Workflow Automation', 'Workflows', 'Automate repetitive business and marketing processes with AI workflows, with human approval where it matters.'],
            ['marketing-automation', 'Marketing Automation', 'Marketing', 'Email, nurture and CRM sequences that turn visitors into qualified conversations.'],
            ['lead-generation-systems', 'Lead Generation Systems', 'Lead Gen', 'Capture, qualify and route demand from search into your pipeline.'],
        ]],
        ['adv', 'Advisory & Web', 'Advisory/Web', 'Leadership direction on AI, and websites built to rank and convert.', [
            ['executive-ai-consulting', 'Executive AI Consulting', 'Exec AI', 'A practical AI roadmap for leadership: where AI creates value, what to build first and how to measure it.'],
            ['wordpress-website-design-service', 'WordPress Website Design', 'WordPress', 'Fast, well-structured WordPress sites built for search and AI discoverability.'],
            ['ecommerce-website-design-service', 'E-commerce Website Design', 'E-commerce', 'Online stores designed to rank, load fast and convert.'],
            ['website-maintenance-services', 'Website Maintenance', 'Maintenance', 'Updates, security, backups and performance checks that keep your site healthy.'],
        ]],
    ];
}
/* problem-first router: [problem, [service slugs]] */
function rl_services_router() {
    return [
        ['Organic traffic is falling', ['technical-seo-services', 'seo-ai-search-audit']],
        ['We rank on Google but not in AI answers', ['ai-search-optimization', 'generative-engine-optimization']],
        ['AI tools describe us wrongly, or not at all', ['llm-optimization']],
        ['Content gets published but produces no pipeline', ['seo-content-systems']],
        ['Too much manual work in marketing and operations', ['ai-workflow-automation', 'marketing-automation']],
        ['Not enough qualified leads from search', ['lead-generation-systems']],
        ['Expanding into new countries or languages', ['international-seo']],
        ['Leadership needs a clear AI plan', ['executive-ai-consulting']],
    ];
}
function rl_services_faqs() {
    return [
        ['What services does Reinforce Lab offer?', 'Reinforce Lab offers services in four groups: search engine optimization (core, technical, enterprise, international and local SEO, plus audits); AI search and content (AI Search Optimization, GEO, LLM Optimization, SEO Content Systems and Digital PR); automation and growth (AI Workflow Automation, Marketing Automation and Lead Generation Systems); and advisory and web (Executive AI Consulting, WordPress and e-commerce website design, and website maintenance). All of them are designed to work together as one AI Growth System.'],
        ['What is the difference between SEO, AI Search Optimization, GEO and LLM Optimization?', 'SEO earns rankings and clicks in search results. AI Search Optimization makes your brand visible and recommended across AI search experiences such as ChatGPT, Perplexity, Gemini and Google AI Overviews. GEO (Generative Engine Optimization) is the content and structure work that gets your pages extracted and cited inside generated answers. LLM Optimization focuses on how large language models understand and describe your brand as an entity. They overlap, so we plan them as one strategy.'],
        ['Do I need to buy every service?', 'No. Start with the service that solves your most urgent problem. Each one is built to plug into the wider AI Growth System, so you can add more as results come in.'],
        ['Where should I start?', 'With the free Search Authority Diagnostic. It shows where your biggest gap is (Google visibility, AI search, content, competitors or technical foundations) and recommends the service or package that fits.'],
        ['Do you work with regulated industries?', 'Yes. We work with pharmaceutical, life sciences and healthcare companies, where evidence matters. Important claims are tied to sources (such as PubMed and ClinicalTrials.gov where the field requires it) and a person reviews them before anything is published.'],
        ['How is pricing set?', 'Services are scoped after the diagnostic, based on your site, market and goals. Search Authority OS engagements start from $5,000 setup; the packages page shows the tiers.'],
    ];
}
function rl_services_index() {
    $ix = [];
    foreach (rl_services_groups() as $g) foreach ($g[4] as $s) $ix[$s[0]] = $s;
    return $ix;
}
function rl_services_link($slug) {
    if (!function_exists('rl_url_by_path')) return '';
    $l = rl_url_by_path('services/' . $slug, '');
    return $l ? esc_url($l) : '';
}

/* ---------- hero animation: Capability grid ----------
   Four service groups light tile by tile; each group sends a pulse down into its segment of the
   "AI Growth System" core; when all four are in, the core glows and an output pulse lights the
   caption. 10 s loop, soft fade 92-97 %, reset. Tiles are links where the page exists. */
function rl_services_cg_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    foreach (rl_services_groups() as $c => $g) {
        $s = 2 + $c * 14;
        $k .= $lit("rlcH$c", $s, $s + 2) . ".rl-svc .cg-c$c .cg-hon{animation-name:rlcH$c}\n";
        foreach ($g[4] as $j => $t) {
            $a = round($s + $j * 1.8, 1);
            $k .= $lit("rlcT{$c}_$j", $a, $a + 2) . ".rl-svc .cg-t{$c}_$j .cg-tl{animation-name:rlcT{$c}_$j}\n";
        }
        $p = round($s + count($g[4]) * 1.8 + 1, 1);
        $k .= $pul("rlcP$c", $p, $p + 8) . $lit("rlcS$c", $p + 7, $p + 9) . ".rl-svc .cg-p$c{animation-name:rlcP$c}.rl-svc .cg-s$c{animation-name:rlcS$c}\n";
    }
    $k .= $lit('rlcCore', 62, 66) . $pul('rlcOut', 66, 74) . $lit('rlcCap', 72, 76);
    return $k;
}
function rl_services_cg_svg() {
    $G = rl_services_groups(); $h = 'esc_html';
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlCgT"><title id="rlCgT">Reinforce Lab services in four groups (Search, AI Search and Content, Automation and Growth, Advisory and Web) connect into one AI Growth System, measured on business impact.</title>'
        . '<defs><linearGradient id="rlcCoreG" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#990000" stop-opacity=".16"/><stop offset="1" stop-color="#990000" stop-opacity=".03"/></linearGradient></defs>';
    $links = '';
    foreach ($G as $c => $g) {
        $x = 10 + $c * 127; $n = count($g[4]);
        $bottom = 32 + $n * 30 - 6; $cx = $x + 59.5; $tx = 116 + $c * 74 + 32;
        $path = 'M' . $cx . ' ' . $bottom . ' V246 C' . $cx . ' 262 ' . $tx . ' 256 ' . $tx . ' 272';
        $s .= '<path class="cg-e" d="' . $path . '"/><path class="cg-p cg-p' . $c . '" pathLength="100" d="' . $path . '"/>';
        $s .= '<g class="cg-c' . $c . '"><text class="cg-h" x="' . $x . '" y="20">' . $h(strtoupper($g[2])) . '</text><text class="cg-h cg-hon" x="' . $x . '" y="20">' . $h(strtoupper($g[2])) . '</text></g>';
        foreach ($g[4] as $j => $t) {
            $y = 32 + $j * 30; $l = rl_services_link($t[0]);
            $tile = '<g class="cg-t' . $c . '_' . $j . '"><rect class="cg-hit" x="' . $x . '" y="' . $y . '" width="119" height="24"/><rect class="cg-tl" x="' . $x . '" y="' . $y . '" width="119" height="24"/>'
                . '<text class="cg-tx" x="' . ($x + 10) . '" y="' . ($y + 15.5) . '">' . $h(strtoupper($t[2])) . '</text></g>';
            $s .= $l ? '<a href="' . $l . '" aria-label="' . esc_attr($t[1]) . '">' . $tile . '</a>' : $tile;
        }
    }
    $s .= '<rect class="cg-core" x="100" y="272" width="320" height="56"/><rect class="cg-cg" x="96" y="268" width="328" height="64"/>'
        . '<text class="cg-ct" x="260" y="300" text-anchor="middle">AI GROWTH SYSTEM</text>';
    for ($c = 0; $c < 4; $c++) { $sx = 116 + $c * 74; $s .= '<rect class="cg-sb" x="' . $sx . '" y="313" width="64" height="3"/><rect class="cg-sl cg-s' . $c . '" x="' . $sx . '" y="313" width="64" height="3"/>'; }
    $s .= '<path class="cg-e" d="M260 328 V356"/><path class="cg-p cg-po" pathLength="100" d="M260 328 V356"/>'
        . '<text class="cg-cap" x="260" y="378" text-anchor="middle">ONE SYSTEM · MEASURED ON BUSINESS IMPACT</text><text class="cg-cap cg-cap-on" x="260" y="378" text-anchor="middle">ONE SYSTEM · MEASURED ON BUSINESS IMPACT</text>';
    return $s . '</svg>';
}

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_services()) $c[] = 'rl-svc-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_services(); });
add_action('wp_head', 'rl_services_css', 22);
function rl_services_css() {
    if (!rl_is_services()) return; ?>
<style id="rl-svc-css">
/* shared rules live in reinforce-kit.css (D-044) */
body.rl-svc-page .fl-page-content,body.rl-svc-page .fl-content,body.rl-svc-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-svc .lede a,.rl-svc .faq p a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-svc .lede a:hover,.rl-svc .faq p a:hover{color:var(--red-3)}
/* hero */
/* hero visual: capability grid */
.rl-svc .cg{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 12px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-svc .cg .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:12px}
.rl-svc .cg .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-svc .cg svg{display:block;width:100%;height:auto;overflow:visible}
.rl-svc .cg-h{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-svc .cg-hon{fill:var(--red-3);opacity:0}
.rl-svc .cg-hit{fill:var(--bg);stroke:var(--line-2);stroke-width:1;transition:stroke .2s}
.rl-svc .cg-tl{fill:rgba(153,0,0,.12);stroke:var(--red-2);stroke-width:1;opacity:0}
.rl-svc .cg-tx{font-family:var(--f-mono);font-size:9px;letter-spacing:.08em;fill:var(--ink-dim);transition:fill .2s}
.rl-svc .cg a{cursor:pointer;outline:none}
.rl-svc .cg a:hover .cg-hit,.rl-svc .cg a:focus-visible .cg-hit{stroke:var(--red-3)}
.rl-svc .cg a:hover .cg-tx,.rl-svc .cg a:focus-visible .cg-tx{fill:#fff}
.rl-svc .cg-e{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-svc .cg-p{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-linecap:round;stroke-dasharray:10 100;stroke-dashoffset:10;opacity:0}
.rl-svc .cg-po{animation-name:rlcOut}
.rl-svc .cg-core{fill:url(#rlcCoreG);stroke:var(--red-line);stroke-width:1}
.rl-svc .cg-cg{fill:none;stroke:var(--red-2);stroke-width:1;opacity:0;animation-name:rlcCore}
.rl-svc .cg-ct{font-family:var(--f-display);font-weight:600;font-size:17px;letter-spacing:.06em;fill:var(--ink)}
.rl-svc .cg-sb{fill:rgba(255,255,255,.08)}
.rl-svc .cg-sl{fill:var(--red-2);opacity:0}
.rl-svc .cg-cap{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-svc .cg-cap-on{fill:var(--ink);opacity:0;animation-name:rlcCap}
.rl-svc .cg-hon,.rl-svc .cg-tl,.rl-svc .cg-p,.rl-svc .cg-cg,.rl-svc .cg-sl,.rl-svc .cg-cap-on{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-svc .cg-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-svc .cg-tx{font-size:12.5px;letter-spacing:0}.rl-svc .cg-h{font-size:11.5px;letter-spacing:.04em}.rl-svc .cg-cap{font-size:10.5px;letter-spacing:.04em}.rl-svc .cg .cap span+span{display:none}.rl-svc .cg{padding:16px 10px 8px}}
<?php echo rl_services_cg_kf(); ?>
/* router */
.rl-svc .router{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;list-style:none;margin:0;padding:0}
@media(max-width:760px){.rl-svc .router{grid-template-columns:1fr}}
.rl-svc .router li{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);padding:18px 22px;display:flex;flex-direction:column;gap:12px;box-shadow:inset 0 1px 0 var(--glass-hi);transition:.2s}
.rl-svc .router li:hover{border-color:var(--red-line)}
.rl-svc .router .pr{font-family:var(--f-display);text-transform:uppercase;font-size:16px;letter-spacing:.02em;color:var(--ink)}
.rl-svc .router .to{display:flex;flex-wrap:wrap;gap:6px}
.rl-svc .router .to a,.rl-svc .router .to span{font-family:var(--f-mono);font-size:12px;letter-spacing:.06em;border:1px solid var(--line-2);padding:5px 8px;color:var(--ink-dim);white-space:nowrap}
.rl-svc .router .to a:hover{border-color:var(--red-line);color:var(--ink)}
.rl-svc .router .to a::after{content:" →";color:var(--red-3)}
/* all services */
.rl-svc .grp{margin-top:clamp(36px,5vw,56px)}
.rl-svc .head+.grp{margin-top:0}
.rl-svc .grp-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:8px 18px;border-bottom:1px solid var(--line);padding-bottom:14px;margin-bottom:18px}
.rl-svc .grp-h h3{font-size:clamp(20px,2.4vw,26px)}
.rl-svc .grp-h .k{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.12em}
.rl-svc .grp-h p{color:var(--ink-dim);font-size:16px;flex-basis:100%}
.rl-svc .cards{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
@media(max-width:900px){.rl-svc .cards{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rl-svc .cards{grid-template-columns:1fr}}
.rl-svc .card{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);padding:22px;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:10px;transition:.2s}
.rl-svc a.card:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-svc .card h4{font-size:17px}
.rl-svc .card p{color:var(--ink-dim);font-size:16px}
.rl-svc .card .more{margin-top:auto;font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
/* ways in */
.rl-svc .ways{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:900px){.rl-svc .ways{grid-template-columns:1fr}}
.rl-svc .way{border:1px solid var(--glass-line);background:var(--glass);padding:28px 26px;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:12px;transition:.2s}
.rl-svc .way:hover{border-color:var(--red-line)}
.rl-svc .way.feat{background:linear-gradient(180deg,rgba(153,0,0,.14),var(--glass-2));border-color:var(--red-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 0 70px -26px var(--red-glow)}
.rl-svc .way .tag{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--red-3);text-transform:uppercase}
.rl-svc .way h3{font-size:20px}
.rl-svc .way p{color:var(--ink-dim);font-size:16px}
.rl-svc .way .more{margin-top:auto;font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
/* method */
.rl-svc .method{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(9,1fr);gap:8px;counter-reset:m}
@media(max-width:1100px){.rl-svc .method{grid-template-columns:repeat(3,1fr)}}
@media(max-width:480px){.rl-svc .method{grid-template-columns:repeat(2,1fr)}}
.rl-svc .method li{border:1px solid var(--line-2);background:var(--bg);padding:14px 12px;font-family:var(--f-display);text-transform:uppercase;font-size:14px;letter-spacing:.03em;counter-increment:m}
.rl-svc .method li::before{content:counter(m,decimal-leading-zero);display:block;font-family:var(--f-mono);font-size:11px;color:var(--red-3);letter-spacing:.1em;margin-bottom:6px}
/* industries */
.rl-svc .inds{display:flex;flex-wrap:wrap;gap:10px;list-style:none;margin:0;padding:0}
.rl-svc .inds a{display:inline-block;border:1px solid var(--glass-line);background:var(--glass);padding:12px 16px;font-family:var(--f-display);text-transform:uppercase;font-size:15px;letter-spacing:.03em;transition:.2s}
.rl-svc .inds a:hover{border-color:var(--red-line);color:#fff}
/* faq */
/* final */
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_services() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $items = []; $i = 0;
    foreach (rl_services_groups() as $g) foreach ($g[4] as $s) {
        $l = function_exists('rl_url_by_path') ? rl_url_by_path('services/' . $s[0], '') : '';
        $it = ['@type' => 'ListItem', 'position' => ++$i, 'item' => ['@type' => 'Service', 'name' => $s[1], 'description' => $s[3], 'provider' => ['@id' => home_url('/#organization')]]];
        if ($l) $it['item']['url'] = $l;
        $items[] = $it;
    }
    $graph[] = ['@type' => 'ItemList', '@id' => $url . '#services', 'name' => 'Reinforce Lab services', 'numberOfItems' => count($items), 'itemListElement' => $items];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_services_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_services', 'rl_render_services');
function rl_render_services() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $ix = rl_services_index();
    $inds = [['pharmaceutical', 'Pharmaceutical & Life Sciences'], ['healthcare', 'Healthcare'], ['b2b-saas', 'B2B SaaS'], ['ecommerce', 'E-commerce'], ['manufacturing', 'Manufacturing'], ['technology', 'Technology'], ['professional-services', 'Professional Services'], ['education', 'Education']];
    $method = ['Discover', 'Preserve', 'Architect', 'Content', 'AI Search', 'Build', 'QA', 'Launch', 'Monitor'];
    ob_start(); ?>
<div class="rl-page rl-svc">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Services</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;AI Growth Systems&nbsp;<b>]</b></span>
      <h1 class="h1">Every service.<br>One connected<br><span class="r">growth system.</span></h1>
      <p class="lede"><strong>Reinforce Lab services</strong> cover search engine optimization, AI search optimization, content systems, marketing automation, lead generation and executive AI consulting, engineered to work together as one <a href="<?php echo $u('services/ai-growth-systems'); ?>">AI Growth System</a>, not as separate retainers.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#all">See all services</a>
      </div>
    </div>
    <figure class="cg rl-anim">
      <div class="cap" aria-hidden="true"><span>Capabilities</span><span>Select a service</span></div>
      <?php echo rl_services_cg_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Search', 'kind' => 'chips', 'items' => ['SEO', 'Technical', 'Enterprise', 'International', 'Local', 'Audit']], ['label' => 'AI search and content', 'kind' => 'chips', 'items' => ['AI search', 'GEO', 'LLM', 'Content', 'Digital PR'], 'join' => false], ['label' => 'Automation', 'kind' => 'chips', 'items' => ['Workflows', 'Marketing', 'Lead gen'], 'join' => false], ['label' => 'Advisory and web', 'kind' => 'chips', 'items' => ['Exec AI', 'WordPress', 'E-commerce', 'Maintenance'], 'join' => false], ['label' => '', 'kind' => 'core', 'title' => 'AI Growth System', 'sub' => 'One system · measured on business impact']], ''); ?></figure>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Start with the problem&nbsp;<b>]</b></span><h2>What do you need to fix first?</h2><p class="lede">Pick the problem that sounds most like yours. Each one points to the service built to solve it.</p></div>
    <ul class="router">
      <?php foreach (rl_services_router() as $r) { ?>
      <li><span class="pr"><?php echo esc_html($r[0]); ?></span><span class="to"><?php foreach ($r[1] as $slug) { $l = rl_services_link($slug); $n = esc_html($ix[$slug][1]); echo $l ? '<a href="' . $l . '">' . $n . '</a>' : '<span>' . $n . '</span>'; } ?></span></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="all">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;All services&nbsp;<b>]</b></span><h2>Four groups. One strategy.</h2><p class="lede">Search, AI search, automation and the web, planned together so each piece strengthens the others.</p></div>
    <?php foreach (rl_services_groups() as $c => $g) { ?>
    <div class="grp" id="<?php echo esc_attr($g[0]); ?>">
      <div class="grp-h"><span class="k"><?php echo sprintf('%02d', $c + 1); ?></span><h3><?php echo esc_html($g[1]); ?></h3><p><?php echo esc_html($g[3]); ?></p></div>
      <div class="cards">
        <?php foreach ($g[4] as $s) { $l = rl_services_link($s[0]);
            $inner = '<h4>' . esc_html($s[1]) . '</h4><p>' . esc_html($s[3]) . '</p>';
            echo $l ? '<a class="card" href="' . $l . '">' . $inner . '<span class="more">Explore &rarr;</span></a>' : '<div class="card">' . $inner . '</div>';
        } ?>
      </div>
    </div>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="system">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How it fits together&nbsp;<b>]</b></span><h2>Three ways in.</h2><p class="lede">Buy one service, run one agent, or connect everything into one system where each part strengthens the others.</p></div>
    <div class="ways">
      <a class="way feat" href="<?php echo $u('services/ai-growth-systems'); ?>"><span class="tag">The umbrella</span><h3>AI Growth Systems</h3><p>Consulting and implementation that connects your website, content and search visibility into one growth engine.</p><span class="more">Explore &rarr;</span></a>
      <a class="way" href="<?php echo $u('search-authority-os'); ?>"><span class="tag">Flagship product</span><h3>Search Authority OS</h3><p>Our AI system that researches your market, verifies claims, produces content and monitors visibility across Google and AI search.</p><span class="more">See how it works &rarr;</span></a>
      <a class="way" href="<?php echo $u('services/agents'); ?>"><span class="tag">Start small</span><h3>Agents</h3><p>Eight specialised agents, each built for one search outcome. Run one on its own or combine them.</p><span class="more">Meet the agents &rarr;</span></a>
    </div>
  </div>
</section>

<section id="method">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How we work&nbsp;<b>]</b></span><h2>One method on every engagement.</h2><p class="lede">Whatever you start with, the work follows the same nine stages, so nothing that already earns traffic is lost, and everything new is measured.</p></div>
    <ol class="method"><?php foreach ($method as $m) echo '<li>' . esc_html($m) . '</li>'; ?></ol>
  </div>
</section>

<section class="band alt" id="industries">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Industries&nbsp;<b>]</b></span><h2>Built for your market.</h2><p class="lede">The same services, shaped to the rules, buyers and search behaviour of your industry.</p></div>
    <ul class="inds"><?php foreach ($inds as $i) echo '<li><a href="' . $u('industries/' . $i[0]) . '">' . esc_html($i[1]) . '</a></li>'; ?></ul>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About our services.</h2></div>
    <?php foreach (rl_services_faqs() as $k => $q) {
        $a = esc_html($q[1]);
        if ($k === 3) $a .= ' <a href="' . $diag . '">Request the diagnostic</a>.';
        if ($k === 5) $a .= ' <a href="' . $u('packages') . '">See packages</a>.'; ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo $a; ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="cta">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Not sure which service you need?</h2>
      <p class="lede">The free diagnostic shows where your biggest gap is, and which service, agent or package closes it.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('packages'); ?>">Compare packages</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
