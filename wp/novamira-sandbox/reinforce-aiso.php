<?php
/**
 * Plugin Name: Reinforce Lab — AI Search Optimization
 * Description: /services/ai-search-optimization/ (approved new URL, D-006) — AISO service page. Provides [reinforce_aiso]. Hero animation "Cited answer" (D-039 Step 3). Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_aiso() { return is_page('ai-search-optimization'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_aiso_faqs() {
    return [
        ['What is AI Search Optimization?', 'AI Search Optimization (AISO) is the work of making a brand visible, accurately described and recommended when people ask AI search tools — such as ChatGPT, Perplexity, Gemini and Google AI Overviews — about its category. It combines AI-crawler access, entity and schema work, answer-first content, evidence and third-party authority, and it is measured prompt by prompt, engine by engine.'],
        ['How is AI Search Optimization different from SEO?', 'SEO earns rankings and clicks in a list of results. AI Search Optimization earns a place inside the answer itself, where the AI names a few brands and cites a few sources. They share foundations — crawlable pages, authority and clear content — so Reinforce Lab runs them as one program rather than two.'],
        ['Which AI search engines do you cover?', 'We track where you appear across ChatGPT, Perplexity, Gemini and Google AI Overviews, and we look at other assistants where they matter in your market. Each engine is measured separately, because a brand can be recommended in one and missing from another.'],
        ['Can you guarantee my brand will appear in AI answers?', 'No — and you should be wary of anyone who does. Nobody controls what an AI model says. What we control are the inputs: whether AI crawlers can reach your site, whether your brand is described consistently, whether content worth citing exists, and whether trusted third parties mention you. We improve those inputs and measure the results.'],
        ['How long does AI Search Optimization take?', 'It depends on your starting point. Fixes such as AI-crawler access and structured data can be picked up as soon as the engines re-read your pages; broader gains across your full prompt set take consistent work over months. We set expectations after the baseline and report against it.'],
        ['Do I still need SEO if I invest in AI search?', 'Yes. AI search tools draw heavily on pages that are already crawlable, well-structured and trusted in search. Strong SEO makes AI Search Optimization work harder, and the same fixes usually improve both.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with AI Search Optimization points specific to it (D-047) */
function rl_aiso_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Accurate AI answers about products and conditions, backed by sourced and reviewed claims', 'Separate visibility for healthcare-professional and patient questions', 'Monitoring for outdated or incorrect descriptions in AI answers']],
        ['healthcare', 'Healthcare', ['Named in AI answers when patients compare providers and treatments', 'Clinical content with reviewer details AI engines can trust', 'Locations and services kept consistent so AI gives the right details']],
        ['b2b-saas', 'B2B SaaS', ['Included in AI shortlists for “best tool for…” and comparison prompts', 'Accurate descriptions of features, integrations and pricing model', 'Mentions on the review sites and communities AI engines read']],
        ['ecommerce', 'E-commerce', ['Products recommended when shoppers ask AI for options', 'Specs, availability and returns stated clearly and consistently', 'Reviews earned on sources AI engines cite']],
        ['manufacturing', 'Manufacturing', ['Found when engineers and buyers ask AI for suppliers and specs', 'Specifications and certifications stated plainly for AI to quote', 'Distributor and product listings aligned so AI names the right source']],
        ['technology', 'Technology', ['Clear category positioning so AI places you among the right peers', 'Documentation and integration pages AI engines can cite', 'Consistent product names across the web to avoid confusion']],
        ['professional-services', 'Professional Services', ['Recommended when buyers ask AI for advisers in your field and region', 'Expertise shown through named experts, credentials and sourced insight', 'Service areas and specialisms described the same way everywhere']],
        ['education', 'Education', ['Programmes surfaced when students ask AI to compare courses', 'Entry requirements and key dates kept current so AI answers correctly', 'Accreditation and outcomes stated clearly, with sources']],
    ];
}

/* ---------- hero animation: Cited answer ----------
   A buyer's prompt types in; an AI answer writes itself; three sources appear and source [1] —
   your brand — lights, passes three checks (crawlable · structured · verified), and the three
   measures light: mentioned · cited · described accurately. 10 s loop, soft fade, reset.
   Engine tabs step every 10 s (40 s cycle). */
function rl_aiso_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlAiT"><title id="rlAiT">A buyer asks an AI search engine a question; the answer cites your brand as source one — crawlable, structured and verified — and the brand is mentioned, cited and described accurately.</title>'
        . '<defs><clipPath id="rlaiType"><rect class="ai-typ" x="16" y="52" width="352" height="24"/></clipPath></defs>';
    $tabs = ['CHATGPT', 'PERPLEXITY', 'GEMINI', 'AI OVERVIEWS'];
    foreach ($tabs as $i => $t) $s .= '<text class="ai-tab" x="' . (4 + $i * 128) . '" y="16">' . $t . '</text><text class="ai-tab ai-tab-on ai-tab' . $i . '" x="' . (4 + $i * 128) . '" y="16">' . $t . '</text>';
    $s .= '<line class="ai-rule" x1="0" y1="26" x2="520" y2="26"/><rect class="ai-ul" x="4" y="25" width="92" height="2"/>';
    $s .= '<rect class="ai-box" x="0" y="42" width="520" height="42"/>'
        . '<text class="ai-q" x="16" y="67" clip-path="url(#rlaiType)">WHO ARE THE MOST TRUSTED PROVIDERS IN OUR CATEGORY?</text><rect class="ai-caret" x="16" y="58" width="2" height="12"/>';
    $s .= '<text class="ai-pl" x="0" y="110">AI ANSWER</text>';
    $w = [470, 430, 452, 300];
    foreach ($w as $i => $ww) $s .= '<rect class="ai-ln ai-ln' . $i . '" x="0" y="' . (122 + $i * 16) . '" width="' . $ww . '" height="5"/>';
    $s .= '<g class="ai-mk ai-mk1"><rect class="ai-mkb" x="476" y="118" width="16" height="13"/><text class="ai-mkt" x="484" y="128" text-anchor="middle">1</text></g>'
        . '<g class="ai-mk ai-mk2"><rect class="ai-mkb" x="436" y="134" width="16" height="13"/><text class="ai-mkt" x="444" y="144" text-anchor="middle">2</text></g>'
        . '<g class="ai-mk ai-mk3"><rect class="ai-mkb" x="306" y="166" width="16" height="13"/><text class="ai-mkt" x="314" y="176" text-anchor="middle">3</text></g>'
        . '<rect class="ai-mkon" x="476" y="118" width="16" height="13"/><text class="ai-mkton" x="484" y="128" text-anchor="middle">1</text>';
    $s .= '<text class="ai-pl" x="0" y="210">SOURCES</text>';
    $cards = [['1', 'YOUR BRAND'], ['2', 'SOURCE'], ['3', 'SOURCE']];
    foreach ($cards as $i => $c) {
        $x = $i * 176;
        $s .= '<g class="ai-src ai-src' . $i . '"><rect class="ai-card" x="' . $x . '" y="218" width="168" height="96"/><text class="ai-cn" x="' . ($x + 12) . '" y="238">[' . $c[0] . ']</text><text class="ai-ct" x="' . ($x + 36) . '" y="238">' . $c[1] . '</text>'
            . '<rect class="ai-cl" x="' . ($x + 12) . '" y="252" width="' . ($i ? 110 : 120) . '" height="4"/><rect class="ai-cl" x="' . ($x + 12) . '" y="262" width="' . ($i ? 80 : 96) . '" height="4"/></g>';
    }
    $s .= '<rect class="ai-cardon" x="0" y="218" width="168" height="96"/><text class="ai-cton" x="36" y="238">YOUR BRAND</text>'
        . '<path class="ai-e" d="M484 131 V196 Q484 204 476 204 H92 Q84 204 84 212 V218"/><path class="ai-p" pathLength="100" d="M484 131 V196 Q484 204 476 204 H92 Q84 204 84 212 V218"/>';
    foreach (['CRAWLABLE', 'STRUCTURED', 'VERIFIED'] as $i => $c) {
        $y = 282 + $i * 12;
        $s .= '<text class="ai-ck ai-ck' . $i . '" x="12" y="' . $y . '">+ ' . $c . '</text>';
    }
    $s .= '<line class="ai-rule" x1="0" y1="338" x2="520" y2="338"/>';
    foreach (['MENTIONED', 'CITED', 'DESCRIBED ACCURATELY'] as $i => $m) {
        $x = [0, 150, 290][$i];
        $s .= '<rect class="ai-sq" x="' . $x . '" y="356" width="10" height="10"/><rect class="ai-sqon ai-m' . $i . '" x="' . $x . '" y="356" width="10" height="10"/>'
            . '<text class="ai-mt" x="' . ($x + 18) . '" y="365">' . $m . '</text><text class="ai-mt ai-mton ai-m' . $i . '" x="' . ($x + 18) . '" y="365">' . $m . '</text>';
    }
    return $s . '</svg>';
}
function rl_aiso_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = "@keyframes rlaiType{0%,2%{transform:scaleX(0)}14%,92%{transform:scaleX(1)}97%,100%{transform:scaleX(1);opacity:0}}\n"
        . "@keyframes rlaiQ{0%,92%{opacity:1}97%,100%{opacity:0}}\n"
        . "@keyframes rlaiCaret{0%,2%{transform:translateX(0);opacity:1}14%{transform:translateX(350px);opacity:1}15%,100%{transform:translateX(350px);opacity:0}}\n"
        . "@keyframes rlaiP{0%,50%{stroke-dashoffset:10;opacity:0}51%{opacity:1}57%{opacity:1}58%,100%{stroke-dashoffset:-100;opacity:0}}\n"
        . "@keyframes rlaiTabs{0%,23%{transform:translateX(0)}25%,48%{transform:translateX(128px)}50%,73%{transform:translateX(256px)}75%,98%{transform:translateX(384px)}100%{transform:translateX(0)}}\n";
    foreach ([0, 1, 2, 3] as $i) {
        $a = $i * 25; $b = $a + 2; $c = $a + 23; $d = $a + 25;
        $k .= "@keyframes rlaiT$i{0%{opacity:0}" . ($i ? "$a%{opacity:0}" : '') . "$b%,$c%{opacity:1}$d%,100%{opacity:0}}\n.rl-aiso .ai-tab$i{animation:rlaiT$i 40s linear infinite both}\n";
    }
    foreach ([0, 1, 2, 3] as $i) { $s = 16 + $i * 6; $k .= "@keyframes rlaiL$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-aiso .ai-ln$i{animation-name:rlaiL$i}\n"; }
    foreach ([1, 2, 3] as $i) { $s = 36 + $i * 2; $k .= $lit("rlaiM$i", $s, $s + 2) . ".rl-aiso .ai-mk$i{animation-name:rlaiM$i}\n"; }
    foreach ([0, 1, 2] as $i) { $s = 42 + $i * 3; $k .= $lit("rlaiS$i", $s, $s + 3) . ".rl-aiso .ai-src$i{animation-name:rlaiS$i}\n"; }
    $k .= $lit('rlaiOn', 48, 52) . $lit('rlaiCard', 56, 60);
    foreach ([0, 1, 2] as $i) { $s = 60 + $i * 3; $k .= $lit("rlaiC$i", $s, $s + 2) . ".rl-aiso .ai-ck$i{animation-name:rlaiC$i}\n"; }
    foreach ([0, 1, 2] as $i) { $s = 70 + $i * 4; $k .= $lit("rlaiX$i", $s, $s + 2) . ".rl-aiso .ai-m$i{animation-name:rlaiX$i}\n"; }
    return $k;
}

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_aiso()) $c[] = 'rl-aiso-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_aiso(); });
add_action('wp_head', 'rl_aiso_css', 22);
function rl_aiso_css() {
    if (!rl_is_aiso()) return; ?>
<style id="rl-aiso-css">
/* shared rules live in reinforce-kit.css (D-044) */
body.rl-aiso-page .fl-page-content,body.rl-aiso-page .fl-content,body.rl-aiso-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
/* hero */
/* hero visual */
.rl-aiso .ans{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-aiso .ans .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-aiso .ans .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-aiso .ans svg{display:block;width:100%;height:auto;overflow:visible}
.rl-aiso .ai-tab{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-aiso .ai-tab-on{fill:var(--ink);opacity:0}
.rl-aiso .ai-rule{stroke:var(--line-2);stroke-width:1}
.rl-aiso .ai-ul{fill:var(--red-2);animation:rlaiTabs 40s cubic-bezier(.45,0,.2,1) infinite both}
.rl-aiso .ai-box{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-aiso .ai-pl{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-aiso .ai-q{font-family:var(--f-mono);font-size:10px;letter-spacing:.06em;fill:var(--ink);animation:rlaiQ 10s linear infinite both}
.rl-aiso .ai-typ{transform-box:fill-box;transform-origin:0 50%;animation:rlaiType 10s steps(40,end) infinite both}
.rl-aiso .ai-caret{fill:var(--red-3);animation:rlaiCaret 10s linear infinite both}
.rl-aiso .ai-ln{fill:rgba(255,255,255,.12);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-aiso .ai-mkb{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-aiso .ai-mkt{font-family:var(--f-mono);font-size:8.5px;fill:var(--ink-dim)}
.rl-aiso .ai-mk,.rl-aiso .ai-src,.rl-aiso .ai-ck{opacity:0}
.rl-aiso .ai-mkon{fill:var(--red-2);opacity:0;animation-name:rlaiOn}
.rl-aiso .ai-mkton{font-family:var(--f-mono);font-size:8.5px;fill:#fff;opacity:0;animation-name:rlaiOn}
.rl-aiso .ai-card{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-aiso .ai-cardon{fill:rgba(153,0,0,.10);stroke:var(--red-2);stroke-width:1;opacity:0;animation-name:rlaiCard}
.rl-aiso .ai-cn{font-family:var(--f-mono);font-size:9px;fill:var(--red-3)}
.rl-aiso .ai-ct{font-family:var(--f-mono);font-size:9px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-aiso .ai-cton{font-family:var(--f-mono);font-size:9px;letter-spacing:.12em;fill:#fff;opacity:0;animation-name:rlaiCard}
.rl-aiso .ai-cl{fill:rgba(255,255,255,.08)}
.rl-aiso .ai-ck{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--red-3)}
.rl-aiso .ai-e{fill:none;stroke:var(--line-2);stroke-width:1;stroke-dasharray:3 4}
.rl-aiso .ai-p{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-linecap:round;stroke-dasharray:10 100;stroke-dashoffset:10;opacity:0;animation:rlaiP 10s ease-in-out infinite both}
.rl-aiso .ai-sq{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-aiso .ai-sqon{fill:var(--red-2);opacity:0}
.rl-aiso .ai-mt{font-family:var(--f-mono);font-size:9px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-aiso .ai-mton{fill:var(--ink);opacity:0}
.rl-aiso .ai-ln,.rl-aiso .ai-mk,.rl-aiso .ai-mkon,.rl-aiso .ai-mkton,.rl-aiso .ai-src,.rl-aiso .ai-cardon,.rl-aiso .ai-cton,.rl-aiso .ai-ck,.rl-aiso .ai-sqon,.rl-aiso .ai-mton{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-aiso .ai-tab{font-size:11px;letter-spacing:.02em}.rl-aiso .ai-q{font-size:10.5px;letter-spacing:0}.rl-aiso .ai-ct,.rl-aiso .ai-cton,.rl-aiso .ai-cn{font-size:11px;letter-spacing:.02em}.rl-aiso .ai-ck{font-size:10px;letter-spacing:.02em}.rl-aiso .ai-mt{font-size:11px;letter-spacing:.02em}.rl-aiso .ai-pl{font-size:10px}.rl-aiso .ans .cap span+span{display:none}.rl-aiso .ans{padding:16px 10px 10px}}
<?php echo rl_aiso_kf(); ?>
/* comparison table */
/* cards */
/* steps */
/* lists */
/* faq */
/* final */
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_aiso() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'AI Search Optimization', 'alternateName' => 'AISO',
        'serviceType' => 'AI search optimization', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'AI Search Optimization makes a brand visible, accurately described and recommended in AI search tools such as ChatGPT, Perplexity, Gemini and Google AI Overviews — through AI-crawler access, entity and schema work, answer-first content, evidence and third-party authority, measured per engine.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_aiso_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_aiso', 'rl_render_aiso');
function rl_render_aiso() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $chip = function ($path, $label) use ($ex) { $l = $ex($path); return '<li>' . ($l ? '<a href="' . $l . '">' . esc_html($label) . '</a>' : '<span>' . esc_html($label) . '</span>') . '</li>'; };
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-aiso">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">AI Search Optimization</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;AI Search Optimization&nbsp;<b>]</b></span>
      <h1 class="h1">Be found in Google.<br>Be named in<br><span class="r">AI answers.</span></h1>
      <p class="lede"><strong>AI Search Optimization (AISO)</strong> makes your brand visible, accurately described and recommended when buyers ask ChatGPT, Perplexity, Gemini or Google AI Overviews about your category. Reinforce Lab runs it as one program with your SEO — measured engine by engine, on the questions your buyers actually ask.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Check your AI visibility — free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#how">See how it works</a>
      </div>
    </div>
    <figure class="ans rl-anim">
      <div class="cap" aria-hidden="true"><span>AI answer</span><span>Source [1] = you</span></div>
      <?php echo rl_aiso_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Definitions&nbsp;<b>]</b></span><h2>What is AI Search Optimization — and how is it different?</h2><p class="lede">Four disciplines get mixed up. They overlap, but each has its own goal. AI Search Optimization is the umbrella for being visible in AI search; GEO and LLM Optimization are specialist layers inside it.</p></div>
    <div class="tscroll" role="region" aria-label="Comparison of SEO, AI Search Optimization, GEO and LLM Optimization" tabindex="0">
      <table>
        <thead><tr><th scope="col"><span class="sr" style="position:absolute;left:-9999px">Aspect</span></th><th scope="col">SEO</th><th scope="col" class="us">AI Search Optimization</th><th scope="col">GEO</th><th scope="col">LLM Optimization</th></tr></thead>
        <tbody>
          <tr><th scope="row">Goal</th><td>Rank and earn clicks in search results</td><td class="us">Be visible, cited and recommended across AI search</td><td>Get your pages extracted and cited inside generated answers</td><td>Shape how language models understand and describe your brand</td></tr>
          <tr><th scope="row">Where it shows</th><td>Google and Bing results</td><td class="us">ChatGPT, Perplexity, Gemini, Google AI Overviews</td><td>The answer text and its source list</td><td>What a model says about you, with or without a search</td></tr>
          <tr><th scope="row">What we work on</th><td>Technical health, content, links</td><td class="us">AI-crawler access, entity, content, evidence, authority</td><td>Passage structure, answer blocks, citations</td><td>Entity consistency, descriptions, third-party coverage</td></tr>
          <tr><th scope="row">How it's measured</th><td>Rankings, clicks, conversions</td><td class="us">Mentions, citations, accuracy, share of voice, AI referrals</td><td>Citation rate per prompt</td><td>Accuracy and consistency of descriptions</td></tr>
          <tr><th scope="row">Learn more</th><td><?php $l = $ex('services/best-search-engine-optimization-services'); echo $l ? '<a href="' . $l . '">SEO &rarr;</a>' : '<a href="' . $u('services/technical-seo-services') . '">Technical SEO &rarr;</a>'; ?></td><td class="us">You are here</td><td><a href="<?php echo $u('services/generative-engine-optimization'); ?>">GEO &rarr;</a></td><td><a href="<?php echo $u('services/llm-optimization'); ?>">LLM Optimization &rarr;</a></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="why">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The problem&nbsp;<b>]</b></span><h2>Why do brands disappear from AI answers?</h2><p class="lede">Ranking on Google does not mean an AI will name you. These are the usual reasons — and what we do about each.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Access</span><h3>AI crawlers can't read you</h3><p>Robots rules, firewalls or script-only pages stop AI crawlers from reaching the content you want quoted.</p><p class="fix"><b>Fix</b>Crawler policy, llms.txt and server-rendered pages.</p></div>
      <div class="cell"><span class="n">02 · Entity</span><h3>The AI isn't sure who you are</h3><p>Different names, descriptions and profiles across the web make your brand hard to identify — or easy to confuse.</p><p class="fix"><b>Fix</b>One consistent entity, schema and linked profiles.</p></div>
      <div class="cell"><span class="n">03 · Content</span><h3>Nothing clean to quote</h3><p>Long pages that never answer the question directly give AI engines nothing to lift.</p><p class="fix"><b>Fix</b>Answer-first pages built around real buyer questions.</p></div>
      <div class="cell"><span class="n">04 · Evidence</span><h3>Claims without sources</h3><p>Unsupported claims are risky to repeat — especially in health, pharma and finance.</p><p class="fix"><b>Fix</b>Every important claim tied to a source and checked by a person.</p></div>
      <div class="cell"><span class="n">05 · Authority</span><h3>No one else vouches for you</h3><p>AI engines lean on independent sources. If trusted third parties never mention you, a competitor gets named instead.</p><p class="fix"><b>Fix</b>Earned mentions, reviews and digital PR.</p></div>
      <div class="cell"><span class="n">06 · Measurement</span><h3>No one is checking</h3><p>Most teams don't know which prompts mention them, or whether the description is even right.</p><p class="fix"><b>Fix</b>A tracked prompt set, engine by engine.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>How does AI Search Optimization work?</h2><p class="lede">Five steps, run as a loop. Measurement comes first, so every fix is judged against a baseline.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Baseline</h3><p>Build a prompt set from real buyer questions — search queries, sales and customer questions — and record where you are mentioned, cited and described, against named competitors.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Open access</h3><p>Check that AI crawlers can reach the right pages, agree your crawler policy, publish an llms.txt and make sure content is in the page's HTML.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Clarify the entity</h3><p>One name, one description, structured data and linked profiles, so every engine knows who you are, what you do and who you serve.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Content &amp; evidence</h3><p>Answer-first pages and question-led headings, with every important claim sourced and reviewed before it ships.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Authority &amp; monitoring</h3><p>Earn the third-party mentions AI engines trust, re-run the prompt set, and correct anything the engines get wrong.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>AI visibility baseline</b> — where you appear in ChatGPT, Perplexity, Gemini and Google AI Overviews today.</li>
      <li><b>Your prompt set</b> — the buyer questions that matter to revenue, agreed with you.</li>
      <li><b>Competitor comparison</b> — who gets named and cited instead of you, and why.</li>
      <li><b>AI-access fixes</b> — crawler policy, llms.txt and rendering checks.</li>
      <li><b>Entity &amp; schema plan</b> — Organization, Service and FAQ markup and consistent profiles.</li>
      <li><b>Content priorities</b> — the pages to create, rewrite or refresh first.</li>
      <li><b>Accuracy review</b> — where AI tools describe you wrongly, and the sources behind it.</li>
      <li><b>Monthly reporting</b> — mentions, citations, accuracy and AI referral traffic, with next actions.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure AI visibility?</h2><p class="lede">Rankings alone can't show AI visibility. We report five measures, per engine, on your prompt set.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Mention rate</h3><p>How often your brand is named in answers to your prompts.</p></div>
      <div class="metric"><h3>Citation rate</h3><p>How often your pages are linked as a source.</p></div>
      <div class="metric"><h3>Description accuracy</h3><p>Whether what the AI says about you is correct and current.</p></div>
      <div class="metric"><h3>Share of voice</h3><p>How your visibility compares with named competitors.</p></div>
      <div class="metric"><h3>AI referral traffic</h3><p>Visits and conversions from AI tools, tracked in your analytics.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>No one can guarantee what an AI will say.</h2>
      <p>AI answers change from one session to the next, and no agency controls the models. What we control are the inputs — access, entity, content, evidence and authority — and we measure the outputs on a fixed prompt set so you can see what the work is doing. If a prompt stays flat, we tell you and change the plan.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is AI Search Optimization for?</h2><p class="lede">Businesses whose buyers research before they buy — and industries where an AI getting the facts wrong carries real risk.</p></div>
    <ul class="inds8">
      <?php foreach (rl_aiso_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('AI Search Optimization for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with AI Search Optimization?</h2><p class="lede">AI Search Optimization is strongest when these pieces are in place. Add them as you need them.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/generative-engine-optimization', 'Passage level', 'Generative Engine Optimization (GEO)', 'Structures your pages so generative engines extract and cite them.'],
          ['services/llm-optimization', 'Entity level', 'LLM Optimization', 'Shapes how language models understand and describe your brand.'],
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Makes sure search engines and AI crawlers can reach and read every page that matters.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Research-led, evidence-checked content that gives AI engines something worth citing.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your Google and AI-search performance with a prioritised fix list.'],
          ['services/agents/aeo-geo-optimization', 'Always on', 'AEO/GEO Optimization Agent', 'The Search Authority OS agent that tracks where you appear in AI answers and structures pages to be cited.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About AI Search Optimization.</h2></div>
    <?php foreach (rl_aiso_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Do AI tools recommend you — or a competitor?</h2>
      <p class="lede">The free Search Authority Diagnostic shows where you stand in Google and in AI answers, and what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('search-authority-os'); ?>">How Search Authority OS works</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
