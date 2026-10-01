<?php
/**
 * Plugin Name: Reinforce Lab - LLM Optimization
 * Description: /services/llm-optimization/ (D-023 new slug) - LLM Optimization service page (entity & description layer). Provides [reinforce_llm]. Hero animation "Entity alignment" (D-039 Step 3). Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_llm() { return is_page('llm-optimization'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_llm_faqs() {
    return [
        ['What is LLM Optimization?', 'LLM Optimization is the work of shaping how large language models (the AI behind tools such as ChatGPT, Claude, Gemini and Perplexity) understand, describe and recommend a brand. It makes the facts about a brand consistent and easy to find everywhere models learn from and look things up, then checks what the models actually say.'],
        ['How is LLM Optimization different from GEO and AI Search Optimization?', 'AI Search Optimization is the full program for being visible in AI search. GEO works on pages and passages so they get cited in answers. LLM Optimization works on the brand itself as an entity: who you are, what you do and who you serve, stated the same way everywhere, so models describe you correctly even when no page is cited.'],
        ['Can you fix wrong information ChatGPT or another AI says about us?', 'Not by editing the model; no one outside the AI company can do that. We find where the wrong information comes from, correct it at the source, publish clear and current facts on your own site, and re-test. Tools that search the web can pick up corrections quickly; what a model learned in training changes only when it is retrained.'],
        ['Should we block AI crawlers?', 'It depends on the crawler. Some collect data for training models, others fetch pages for AI search answers. OpenAI, for example, says sites that opt out of its search crawler will not be shown in ChatGPT search answers, while its separate training crawler can be blocked without that effect. We help you set a policy per crawler, based on what you want.'],
        ['What is llms.txt, and do we need one?', 'llms.txt is a proposal, published by Jeremy Howard in September 2024, for a plain-text file at a site’s root that points AI agents to a site’s most useful pages. It is not an official standard and no major AI company has said it relies on it, so we treat it as a low-cost extra, not a ranking factor.'],
        ['How long does LLM Optimization take?', 'Corrections on your own site and profiles can be picked up quickly by AI tools that search the web. Changes to what a model learned during training take longer, because they depend on the next training cycle. We baseline how each model describes you first, then report changes against that baseline.'],
    ];
}
/* verified crawler facts (claude/research/llm-optimization-research-2026-09-29.md) */
function rl_llm_crawlers() {
    return [
        ['OpenAI', 'GPTBot', 'Training', 'Collects content that may be used to train OpenAI’s models.', 'https://developers.openai.com/api/docs/bots'],
        ['OpenAI', 'OAI-SearchBot', 'AI search', 'Surfaces sites in ChatGPT search. Sites that opt out are not shown in ChatGPT search answers.', 'https://developers.openai.com/api/docs/bots'],
        ['OpenAI', 'ChatGPT-User', 'User request', 'Visits a page when a user’s question needs it; not an automatic web crawler.', 'https://developers.openai.com/api/docs/bots'],
        ['Anthropic', 'ClaudeBot', 'Training', 'Collects web content that could contribute to training Claude models.', 'https://support.claude.com/en/articles/8896518-does-anthropic-crawl-data-from-the-web-and-how-can-site-owners-block-the-crawler'],
        ['Anthropic', 'Claude-SearchBot', 'AI search', 'Crawls to improve the quality of Claude’s search results.', 'https://support.claude.com/en/articles/8896518-does-anthropic-crawl-data-from-the-web-and-how-can-site-owners-block-the-crawler'],
        ['Anthropic', 'Claude-User', 'User request', 'Fetches pages when a user asks Claude a question.', 'https://support.claude.com/en/articles/8896518-does-anthropic-crawl-data-from-the-web-and-how-can-site-owners-block-the-crawler'],
        ['Perplexity', 'PerplexityBot', 'AI search', 'Surfaces and links sites in Perplexity results; not used to train foundation models.', 'https://docs.perplexity.ai/docs/resources/perplexity-crawlers'],
        ['Perplexity', 'Perplexity-User', 'User request', 'Visits a page to answer a user’s question; not used for training.', 'https://docs.perplexity.ai/docs/resources/perplexity-crawlers'],
        ['Google', 'Google-Extended', 'Training &amp; grounding', 'A control token for use in Gemini training and grounding. It does not affect inclusion or ranking in Google Search.', 'https://developers.google.com/crawling/docs/crawlers-fetchers/google-common-crawlers'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with LLM Optimization points specific to it (D-047) */
function rl_llm_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['One consistent company, product and pipeline description across sites and registries', 'Outdated or wrong product facts traced and corrected at the source', 'Brand, generic and company names kept distinct to avoid confusion']],
        ['healthcare', 'Healthcare', ['Practice, practitioner and location facts consistent across directories', 'Wrong descriptions of services or specialisms traced and fixed at the source', 'Organization and person markup linking official profiles']],
        ['b2b-saas', 'B2B SaaS', ['Category and positioning stated identically on your site, review sites and profiles', 'Old pricing, features and product names cleaned up across the web', 'Clear separation from similarly named products']],
        ['ecommerce', 'E-commerce', ['Brand, product-line and retailer facts consistent across marketplaces and listings', 'Outdated product information retired at the source', 'Brand and reseller names made unambiguous']],
        ['manufacturing', 'Manufacturing', ['Company, plant, certification and capability facts aligned across directories', 'Legacy brand and acquisition names mapped to the current company', 'Product and part names kept consistent so models match them correctly']],
        ['technology', 'Technology', ['Consistent descriptions of products, integrations and category', 'Rebrands and renamed products connected so models don’t mix them up', 'Founder, company and product clearly linked']],
        ['professional-services', 'Professional Services', ['Firm, partner and practice-area facts consistent everywhere', 'Mergers and name changes reflected across profiles and directories', 'Named experts linked to the firm so models credit the right people']],
        ['education', 'Education', ['Institution, campus and programme names consistent across listings', 'Discontinued courses and outdated facts removed at the source', 'Accreditation and affiliations stated clearly so models describe you correctly']],
    ];
}

/* ---------- hero animation: Entity alignment ----------
   Six sources that describe your brand start scattered and inconsistent (≠); one by one they
   slide into place, connect to the brand entity and become consistent (=); the entity glows and
   a pulse reaches the model's answer, which reads "consistent · correct · current".
   10 s loop, soft glide back and reset. */
function rl_llm_nodes() {
    // label, x-centre, y-centre, scatter dx, dy
    return [['WEBSITE', 75, 40, -14, -10], ['SCHEMA', 75, 120, -22, 8], ['PROFILES', 75, 200, -10, 16], ['DIRECTORIES', 445, 40, 16, -12], ['REVIEWS', 445, 120, 22, -6], ['PRESS', 445, 200, 12, 14]];
}
function rl_llm_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlLlmT"><title id="rlLlmT">Six sources that describe your brand (website, schema, profiles, directories, reviews and press) move from inconsistent to consistent and connect to one brand entity, so the AI model describes the brand consistently, correctly and currently.</title>';
    foreach (rl_llm_nodes() as $i => $n) {
        list($lab, $cx, $cy) = $n;
        $left = $cx < 260; $ex = $left ? $cx + 65 : $cx - 65; $tx = $left ? 205 : 315;
        $d = 'M' . $ex . ' ' . $cy . ' C' . (($ex + $tx) / 2) . ' ' . $cy . ' ' . (($ex + $tx) / 2) . ' 120 ' . $tx . ' 120';
        $s .= '<path class="l-e" d="' . $d . '"/><path class="l-es l-es' . $i . '" d="' . $d . '"/><path class="l-p l-p' . $i . '" pathLength="100" d="' . $d . '"/>';
    }
    foreach (rl_llm_nodes() as $i => $n) {
        list($lab, $cx, $cy) = $n;
        $s .= '<g class="l-n l-n' . $i . '"><rect class="l-nb" x="' . ($cx - 65) . '" y="' . ($cy - 17) . '" width="130" height="34"/><rect class="l-nbon l-nbon' . $i . '" x="' . ($cx - 65) . '" y="' . ($cy - 17) . '" width="130" height="34"/>'
            . '<text class="l-nt" x="' . ($cx - 53) . '" y="' . ($cy + 3.5) . '">' . $lab . '</text>'
            . '<text class="l-ne l-ne' . $i . '" x="' . ($cx + 52) . '" y="' . ($cy + 4) . '" text-anchor="end">≠</text><text class="l-eq l-eq' . $i . '" x="' . ($cx + 52) . '" y="' . ($cy + 4) . '" text-anchor="end">=</text></g>';
    }
    $s .= '<rect class="l-c" x="205" y="96" width="110" height="48"/><rect class="l-cg" x="199" y="90" width="122" height="60"/>'
        . '<text class="l-ct" x="260" y="117" text-anchor="middle">YOUR BRAND</text><text class="l-cs" x="260" y="133" text-anchor="middle">ONE ENTITY</text>';
    $s .= '<path class="l-e" d="M260 144 V282"/><path class="l-p l-pd" pathLength="100" d="M260 144 V282"/>';
    $s .= '<rect class="l-m" x="60" y="282" width="400" height="70"/><rect class="l-mg" x="60" y="282" width="400" height="70"/><text class="l-ml" x="76" y="300">MODEL ANSWER</text>'
        . '<text class="l-mq" x="444" y="300" text-anchor="end">"WHO IS YOUR BRAND?"</text>'
        . '<rect class="l-mb" x="76" y="312" width="360" height="4"/><rect class="l-mb" x="76" y="324" width="300" height="4"/><rect class="l-mb" x="76" y="336" width="220" height="4"/>'
        . '<rect class="l-mbon" x="76" y="312" width="360" height="4"/><rect class="l-mbon" x="76" y="324" width="300" height="4"/><rect class="l-mbon" x="76" y="336" width="220" height="4"/>';
    $s .= '<text class="l-cap" x="260" y="382" text-anchor="middle">CONSISTENT · CORRECT · CURRENT</text><text class="l-cap l-capon" x="260" y="382" text-anchor="middle">CONSISTENT · CORRECT · CURRENT</text>';
    return $s . '</svg>';
}
function rl_llm_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    foreach (rl_llm_nodes() as $i => $n) {
        $s = 8 + $i * 7; $dx = $n[3]; $dy = $n[4];
        $k .= "@keyframes rllN$i{0%,{$s}%{transform:translate({$dx}px,{$dy}px);opacity:.5}" . ($s + 6) . "%,92%{transform:translate(0,0);opacity:1}100%{transform:translate({$dx}px,{$dy}px);opacity:.5}}\n";
        $k .= "@keyframes rllNe$i{0%,{$s}%{opacity:1}" . ($s + 4) . "%,94%{opacity:0}100%{opacity:1}}\n";
        $k .= $lit("rllEq$i", $s + 5, $s + 7) . $lit("rllEs$i", $s + 6, $s + 8) . $pul("rllP$i", $s + 6, $s + 13);
        $k .= ".rl-llm .l-n$i{animation-name:rllN$i}.rl-llm .l-ne$i{animation-name:rllNe$i}.rl-llm .l-eq$i,.rl-llm .l-nbon$i{animation-name:rllEq$i}.rl-llm .l-es$i{animation-name:rllEs$i}.rl-llm .l-p$i{animation-name:rllP$i}\n";
    }
    $k .= $lit('rllCore', 58, 62) . $pul('rllDown', 60, 68) . $lit('rllModel', 66, 70) . $lit('rllCap', 72, 76);
    $k .= "@keyframes rllBars{0%,66%{transform:scaleX(0);opacity:1}74%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n";
    return $k;
}

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_llm()) $c[] = 'rl-llm-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_llm(); });
add_action('wp_head', 'rl_llm_css', 22);
function rl_llm_css() {
    if (!rl_is_llm()) return; ?>
<style id="rl-llm-css">
/* shared rules live in reinforce-kit.css (D-044) */
body.rl-llm-page .fl-page-content,body.rl-llm-page .fl-content,body.rl-llm-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
/* hero */
/* hero visual: entity alignment */
.rl-llm .ent{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-llm .ent .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-llm .ent .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-llm .ent svg{display:block;width:100%;height:auto;overflow:visible}
.rl-llm .l-e{fill:none;stroke:var(--line-2);stroke-width:1;stroke-dasharray:3 4}
.rl-llm .l-es{fill:none;stroke:rgba(194,26,26,.55);stroke-width:1;opacity:0}
.rl-llm .l-p{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-linecap:round;stroke-dasharray:10 100;stroke-dashoffset:10;opacity:0}
.rl-llm .l-pd{animation-name:rllDown}
.rl-llm .l-nb,.rl-llm .l-m{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-llm .l-nbon{fill:rgba(153,0,0,.08);stroke:var(--red-2);stroke-width:1;opacity:0}
.rl-llm .l-nt{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.14em;fill:var(--ink-dim)}
.rl-llm .l-ne{font-family:var(--f-mono);font-size:14px;fill:var(--ink-faint)}
.rl-llm .l-eq{font-family:var(--f-mono);font-size:14px;fill:var(--red-3);opacity:0}
.rl-llm .l-c{fill:rgba(153,0,0,.10);stroke:var(--red-line);stroke-width:1}
.rl-llm .l-cg{fill:none;stroke:var(--red-2);stroke-width:1;opacity:0;animation-name:rllCore}
.rl-llm .l-ct{font-family:var(--f-display);font-weight:600;font-size:15px;letter-spacing:.06em;fill:var(--ink)}
.rl-llm .l-cs{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-llm .l-mg{fill:rgba(153,0,0,.08);stroke:var(--red-2);stroke-width:1;opacity:0;animation-name:rllModel}
.rl-llm .l-ml,.rl-llm .l-mq{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-llm .l-mq{letter-spacing:.06em;fill:var(--ink-dim)}
.rl-llm .l-mb{fill:rgba(255,255,255,.08)}
.rl-llm .l-mbon{fill:rgba(255,255,255,.34);transform-box:fill-box;transform-origin:0 50%;animation:rllBars 10s cubic-bezier(.45,0,.2,1) infinite both}
.rl-llm .l-cap{font-family:var(--f-mono);font-size:9px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-llm .l-capon{fill:var(--ink);opacity:0;animation-name:rllCap}
.rl-llm .l-n,.rl-llm .l-ne,.rl-llm .l-eq,.rl-llm .l-nbon,.rl-llm .l-es,.rl-llm .l-p,.rl-llm .l-cg,.rl-llm .l-mg,.rl-llm .l-capon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-llm .l-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-llm .l-nt{font-size:11px;letter-spacing:.04em}.rl-llm .l-ml,.rl-llm .l-mq{font-size:10px;letter-spacing:.04em}.rl-llm .l-cap{font-size:11px;letter-spacing:.06em}.rl-llm .ent .cap span+span{display:none}.rl-llm .ent{padding:16px 10px 10px}}
<?php echo rl_llm_kf(); ?>
/* two routes + crawler table */
.rl-llm .routes{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:760px){.rl-llm .routes{grid-template-columns:1fr}}
.rl-llm .route{border:1px solid var(--glass-line);background:var(--glass);padding:26px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-llm .route .n{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-llm .route h3{font-size:20px;margin:10px 0}
.rl-llm .route p{color:var(--ink-dim);font-size:15px}
.rl-llm .route .fix{margin-top:14px;padding-top:12px;border-top:1px solid var(--line);color:var(--ink);font-size:14.5px}
.rl-llm .route .fix b{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;color:var(--red-3);font-weight:500;text-transform:uppercase;margin-right:6px}
.rl-llm .role{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;border:1px solid var(--line-2);padding:3px 7px;white-space:nowrap;color:var(--ink-dim)}
.rl-llm .role.s{border-color:var(--red-line);color:var(--red-3)}
.rl-llm td.bot{font-family:var(--f-mono);font-size:13px;color:var(--ink);white-space:nowrap}
.rl-llm .tnote{color:var(--ink-faint);font-size:13px;margin-top:14px;max-width:80ch}
/* before/after + research */
.rl-llm .ba{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:760px){.rl-llm .ba{grid-template-columns:1fr}}
.rl-llm .ba > div{border:1px solid var(--glass-line);background:var(--glass);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-llm .ba .after{border-color:var(--red-line);background:linear-gradient(180deg,rgba(153,0,0,.10),var(--glass))}
.rl-llm .ba .tag{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-llm .ba .after .tag{color:var(--red-3)}
.rl-llm .ba blockquote{margin:12px 0 14px;font-size:17px;line-height:1.55;color:var(--ink)}
.rl-llm .ba .before blockquote{color:var(--ink-dim)}
.rl-llm .ba ul{list-style:none;margin:0;padding:0;display:grid;gap:7px}
.rl-llm .ba li{font-size:14px;color:var(--ink-dim);display:flex;gap:10px}
.rl-llm .ba .before li::before{content:"×";color:var(--ink-faint);font-family:var(--f-mono)}
.rl-llm .ba .after li::before{content:"+";color:var(--red-3);font-family:var(--f-mono)}
.rl-llm .research{border-left:2px solid var(--red-2);padding:6px 0 6px 22px;margin-top:clamp(28px,4vw,40px);max-width:80ch}
.rl-llm .research p{color:var(--ink-dim);font-size:15px}
.rl-llm .research p+p{margin-top:10px}
.rl-llm .research .src{font-family:var(--f-mono);font-size:11px;letter-spacing:.06em;color:var(--ink-faint)}
.rl-llm .research a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-llm .flow4{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,1fr);gap:14px;counter-reset:f}
@media(max-width:900px){.rl-llm .flow4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:520px){.rl-llm .flow4{grid-template-columns:1fr}}
.rl-llm .flow4 li{border:1px solid var(--glass-line);background:var(--glass);padding:22px;counter-increment:f;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-llm .flow4 li::before{content:counter(f,decimal-leading-zero);font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);letter-spacing:.1em}
.rl-llm .flow4 h3{font-size:16px;margin:8px 0}
.rl-llm .flow4 p{color:var(--ink-dim);font-size:14px}
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
    if (!rl_is_llm() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'LLM Optimization', 'alternateName' => 'Large language model optimization',
        'serviceType' => 'LLM optimization', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'LLM Optimization shapes how large language models such as those behind ChatGPT, Claude, Gemini and Perplexity understand, describe and recommend a brand, by making brand facts consistent and current across the sources models learn from and look up, setting an AI-crawler policy, and testing what models say.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_llm_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_llm', 'rl_render_llm');
function rl_render_llm() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $chip = function ($path, $label) use ($ex) { $l = $ex($path); return '<li>' . ($l ? '<a href="' . $l . '">' . esc_html($label) . '</a>' : '<span>' . esc_html($label) . '</span>') . '</li>'; };
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-llm">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">LLM Optimization</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;LLM Optimization&nbsp;<b>]</b></span>
      <h1 class="h1">Make AI describe<br>your brand<br><span class="r">correctly.</span></h1>
      <p class="lede"><strong>LLM Optimization</strong> shapes how large language models (the AI behind ChatGPT, Claude, Gemini and Perplexity) understand, describe and recommend your brand. Reinforce Lab makes your brand facts consistent everywhere models learn from and look things up, then tests what the models actually say.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#crawlers">AI crawler guide</a>
      </div>
    </div>
    <figure class="ent rl-anim">
      <div class="cap" aria-hidden="true"><span>Entity alignment</span><span>Sources &rarr; model</span></div>
      <?php echo rl_llm_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="know">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How AI knows you&nbsp;<b>]</b></span><h2>How does an AI model know about your brand?</h2><p class="lede">There are two routes, and they need different fixes. The AI companies document both.</p></div>
    <div class="routes">
      <div class="route"><span class="n">Route 01 · Memory</span><h3>What it learned in training</h3><p>Models are trained on data up to a cut-off date. OpenAI's own help pages say its models "do not incorporate information about events beyond that, unless tools are used." Whatever the web said about you before that date is baked in.</p><p class="fix"><b>Fix</b>Consistent, accurate facts about you across the web, so the next training round learns the right story.</p></div>
      <div class="route"><span class="n">Route 02 · Lookup</span><h3>What it looks up live</h3><p>With search switched on, tools such as ChatGPT search, Perplexity and Gemini with Google Search grounding fetch current pages and cite them. Google says grounding lets Gemini cite "verifiable sources beyond its knowledge cutoff."</p><p class="fix"><b>Fix</b>Clear, current, crawlable pages that state your facts plainly, and a crawler policy that lets search bots in.</p></div>
    </div>
  </div>
</section>

<section id="crawlers">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;AI crawler guide&nbsp;<b>]</b></span><h2>Which AI crawlers should you allow?</h2><p class="lede">Not all AI crawlers do the same job. Some collect training data, some power AI search, and some fetch a page only when a person asks. Blocking the wrong one can remove you from AI answers.</p></div>
    <div class="tscroll" role="region" aria-label="AI crawlers by company and purpose" tabindex="0">
      <table>
        <thead><tr><th scope="col">Company</th><th scope="col">User agent</th><th scope="col">Used for</th><th scope="col">What the company says</th></tr></thead>
        <tbody>
        <?php foreach (rl_llm_crawlers() as $c) { $srch = strpos($c[2], 'search') !== false; ?>
          <tr><th scope="row"><?php echo esc_html($c[0]); ?></th><td class="bot"><?php echo esc_html($c[1]); ?></td><td><span class="role<?php echo $srch ? ' s' : ''; ?>"><?php echo $c[2]; ?></span></td><td><?php echo esc_html($c[3]); ?> <a href="<?php echo esc_url($c[4]); ?>" rel="noopener" target="_blank">Source</a></td></tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
    <p class="tnote">Summarised from each company's own crawler documentation, checked 29 September 2026. Crawler names and rules change; we re-check them for every client. Google's AI Overviews and AI Mode use pages indexed for Google Search; Google-Extended does not control that.</p>
  </div>
</section>

<section class="band alt" id="why">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The problem&nbsp;<b>]</b></span><h2>Why do AI models get brands wrong?</h2><p class="lede">Models repeat what the web tells them. When the web is unclear, the answer is too.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Inconsistency</span><h3>Different stories in different places</h3><p>Your site, profiles and directories describe you in different words, or list different services.</p></div>
      <div class="cell"><span class="n">02 · Outdated facts</span><h3>Old information still online</h3><p>Past services, old prices or former addresses keep being repeated long after they changed.</p></div>
      <div class="cell"><span class="n">03 · Name confusion</span><h3>Someone else shares your name</h3><p>Similar brand names get merged, and their facts end up in your description.</p></div>
      <div class="cell"><span class="n">04 · No source of truth</span><h3>Nothing clearly states the facts</h3><p>Without a clear About page and structured data, models have to guess who you are and what you do.</p></div>
      <div class="cell"><span class="n">05 · Thin coverage</span><h3>Few independent mentions</h3><p>When trusted third parties rarely mention you, models know little, or lean on competitors.</p></div>
      <div class="cell"><span class="n">06 · Blocked access</span><h3>The wrong crawlers blocked</h3><p>A blanket block on "AI bots" can shut out the search crawlers that would have cited your current facts.</p></div>
    </div>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does LLM Optimization work?</h2><p class="lede">Five steps, starting with what the models say about you today.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Entity baseline</h3><p>Ask each model the questions buyers ask (who you are, what you do, how you compare) and record every answer.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Trace the errors</h3><p>For each wrong or missing fact, find the pages and profiles it most likely comes from.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Set the source of truth</h3><p>One clear description, a facts-rich About page, and Organization schema that links your official profiles.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Align the web</h3><p>Update profiles, directories and listings to match, correct outdated pages, and agree your AI-crawler policy.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Re-test &amp; monitor</h3><p>Ask the same questions again on a schedule, and catch new errors before buyers do.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Model description report</b>: how each AI model describes you today, answer by answer.</li>
      <li><b>Error log</b>: every wrong, outdated or missing fact, with its likely source.</li>
      <li><b>Brand fact sheet</b>: the agreed name, description, services and key facts, in one place.</li>
      <li><b>About page &amp; schema</b>: a facts-first About page and Organization markup linking your official profiles.</li>
      <li><b>Profile alignment</b>: the profiles and listings to update, with the exact wording.</li>
      <li><b>AI-crawler policy</b>: which crawlers to allow or block, set in your robots rules.</li>
      <li><b>llms.txt</b>: an optional map of your key pages for AI agents.</li>
      <li><b>Re-test reports</b>: what changed in each model's answers since the baseline.</li>
    </ul>
  </div>
</section>

<section id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure LLM Optimization?</h2><p class="lede">By what the models say, on a fixed set of questions, over time.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Description accuracy</h3><p>Share of answers that describe you correctly.</p></div>
      <div class="metric"><h3>Consistency across models</h3><p>Whether different AI tools tell the same, correct story.</p></div>
      <div class="metric"><h3>Entity recognition</h3><p>Whether models know you exist, and put you in the right category.</p></div>
      <div class="metric"><h3>Recommendation presence</h3><p>How often you are suggested for the needs you serve.</p></div>
      <div class="metric"><h3>Errors resolved</h3><p>Wrong facts traced, corrected at the source and no longer repeated.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Nobody can edit an AI model for you.</h2>
      <p>No agency can change what a model learned or make it say something. What we can do is fix what models read: your own pages, your profiles and the sources that describe you, and keep the crawlers that fetch fresh facts able to reach you. AI tools that search the web pick those fixes up first; trained memory follows as models are retrained.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is LLM Optimization for?</h2><p class="lede">Brands that AI tools describe wrongly, vaguely or not at all, and teams in regulated fields, where a wrong description is a real risk.</p></div>
    <ul class="inds8">
      <?php foreach (rl_llm_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('LLM Optimization for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with LLM Optimization?</h2><p class="lede">LLM Optimization fixes the entity. These services make sure the pages and the program behind it are just as strong.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/ai-search-optimization', 'The umbrella', 'AI Search Optimization', 'The full program for being visible, accurately described and recommended across AI search.'],
          ['services/generative-engine-optimization', 'Passage level', 'Generative Engine Optimization (GEO)', 'Structures your pages so generative engines extract and cite them.'],
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Makes sure search engines and AI crawlers can reach and read every page that matters.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Research-led, evidence-checked content produced as a system.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your Google and AI-search performance with a prioritised fix list.'],
          ['services/agents/aeo-geo-optimization', 'Always on', 'AEO/GEO Optimization Agent', 'The Search Authority OS agent that tracks where you appear in AI answers and strengthens entity signals.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About LLM Optimization.</h2></div>
    <?php foreach (rl_llm_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>What does AI say about you today?</h2>
      <p class="lede">The free Search Authority Diagnostic shows how AI tools describe your brand, where the facts go wrong, and what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services/ai-search-optimization'); ?>">AI Search Optimization</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
