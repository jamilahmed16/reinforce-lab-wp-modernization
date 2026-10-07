<?php
/**
 * Plugin Name: Reinforce Lab - Generative Engine Optimization
 * Description: /services/generative-engine-optimization/ (approved new URL, D-006) - GEO service page. Provides [reinforce_geo]. Hero animation "Fan-out to citation" (D-039 Step 3). Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_geo() { return is_page('generative-engine-optimization'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_geo_faqs() {
    return [
        ['What is Generative Engine Optimization (GEO)?', 'Generative Engine Optimization (GEO) is the practice of structuring and writing content so that generative AI search engines (such as ChatGPT, Perplexity, Gemini and Google AI Overviews) can retrieve it, extract a clear passage and cite the page in the answer they generate. It works at the level of passages, evidence and structure rather than keywords alone.'],
        ['What is the difference between GEO and SEO?', 'SEO helps a page rank in a list of search results. GEO helps a passage from that page get used and cited inside an AI-generated answer. GEO depends on good SEO (engines can only cite pages they can crawl and trust), but it adds answer-first writing, sourced facts and passage-level structure.'],
        ['How is GEO different from AI Search Optimization?', 'AI Search Optimization is the wider program for being visible and recommended across AI search, including AI-crawler access, entity clarity and third-party authority. GEO is the content layer inside it: making individual pages and passages worth extracting and citing.'],
        ['Does GEO work for Google AI Overviews and AI Mode?', 'Yes. Google’s AI features draw on pages Google can crawl and index, and AI Mode breaks a question into several related searches, a technique Google calls query fan-out. Pages that clearly answer those related questions, with evidence, give Google more to use.'],
        ['What kind of content gets cited most?', 'Content that answers a question directly and can stand on its own: clear definitions, step-by-step explanations, comparison tables and specific facts with a named source. Vague, promotional copy gives an AI engine nothing reliable to quote.'],
        ['Do you use AI to write GEO content?', 'We use AI for research and drafting support. People set the angle, verify every important claim against its source and approve each page before it is published, which matters most in regulated industries.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with GEO points specific to it (D-047) */
function rl_geo_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Mechanism, dosing and trial summaries written as sourced, self-contained passages', 'Citations to PubMed and ClinicalTrials.gov where the field requires it', 'Medical, legal and regulatory review before any passage ships']],
        ['healthcare', 'Healthcare', ['Condition and treatment explainers built as clear question-and-answer passages', 'Reviewer, date and source shown with each clinical answer', 'Plain-language definitions that patients and AI engines can quote']],
        ['b2b-saas', 'B2B SaaS', ['Comparison and alternatives pages with facts engines can extract', 'Use-case and “how to” passages mapped to buyer prompts', 'Integration and pricing-model explainers that stand on their own']],
        ['ecommerce', 'E-commerce', ['Buying guides with clear, citable criteria and recommendations', 'Product comparison tables engines can lift', 'Sizing, compatibility and care answers written as standalone passages']],
        ['manufacturing', 'Manufacturing', ['Specification and selection guides written as extractable passages', 'Material, standard and certification facts with named sources', 'Application notes that answer the questions engineers actually ask']],
        ['technology', 'Technology', ['Definitions and architecture explainers written answer-first', 'Docs structured so each section answers one question', 'Performance claims tied to their source']],
        ['professional-services', 'Professional Services', ['Insight articles that answer client questions directly', 'Regulation and process explainers with dated sources', 'Expert-attributed passages AI engines can credit']],
        ['education', 'Education', ['Course overviews that answer what you learn, how long it takes and what comes next', 'Admissions and funding explained as clear steps', 'Research summaries with citations AI engines can use']],
    ];
}

/* ---------- hero animation: Fan-out to citation ----------
   A buyer's question fans out into three related searches (query fan-out); the searches hit your
   page; three passages are highlighted, lifted into the generated answer and cited [1]; caption
   "retrieved · extracted · cited" lights. 10 s loop, soft fade 92-97 %, reset. */
function rl_geo_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlGeoT"><title id="rlGeoT">A buyer question fans out into related searches; the searches retrieve your page; three passages are extracted into the AI-generated answer and each is cited to your page.</title>';
    $s .= '<rect class="g-box" x="110" y="0" width="300" height="30"/><rect class="g-boxon" x="110" y="0" width="300" height="30"/><text class="g-qt" x="260" y="19" text-anchor="middle">HOW SHOULD WE CHOOSE A PROVIDER?</text>';
    $subs = ['SELECTION CRITERIA', 'TYPICAL COSTS', 'RED FLAGS'];
    foreach ([90, 260, 430] as $i => $cx) {
        $f = 'M260 30 C260 42 ' . $cx . ' 38 ' . $cx . ' 52';
        $r = 'M' . $cx . ' 74 C' . $cx . ' 88 ' . (80 + $i * 40) . ' 86 ' . (80 + $i * 40) . ' 100';
        $s .= '<path class="g-e" d="' . $f . '"/><path class="g-p g-pf' . $i . '" pathLength="100" d="' . $f . '"/>'
            . '<path class="g-e" d="' . $r . '"/><path class="g-p g-pr' . $i . '" pathLength="100" d="' . $r . '"/>'
            . '<rect class="g-pill" x="' . ($cx - 80) . '" y="52" width="160" height="22"/><rect class="g-pillon g-pl' . $i . '" x="' . ($cx - 80) . '" y="52" width="160" height="22"/>'
            . '<text class="g-st" x="' . $cx . '" y="66" text-anchor="middle">' . $subs[$i] . '</text>';
    }
    $s .= '<rect class="g-doc" x="0" y="100" width="240" height="250"/><rect class="g-docon" x="0" y="100" width="240" height="250"/><text class="g-lab" x="12" y="116">YOUR PAGE</text><line class="g-rule" x1="0" y1="124" x2="240" y2="124"/>';
    $hw = [110, 84, 124, 96, 130, 90];
    for ($b = 0; $b < 6; $b++) {
        $y = 132 + $b * 36;
        $s .= '<rect class="g-h" x="12" y="' . $y . '" width="' . $hw[$b] . '" height="4"/><rect class="g-b" x="12" y="' . ($y + 10) . '" width="206" height="3"/><rect class="g-b" x="12" y="' . ($y + 18) . '" width="' . (150 + ($b % 3) * 20) . '" height="3"/>';
    }
    $s .= '<rect class="g-ans" x="280" y="100" width="240" height="250"/><rect class="g-ansglow" x="280" y="100" width="240" height="250"/><text class="g-lab" x="292" y="116">GENERATED ANSWER</text><line class="g-rule" x1="280" y1="124" x2="520" y2="124"/>';
    foreach ([0, 2, 4] as $k => $b) {
        $yb = 132 + $b * 36; $ya = 136 + $k * 62;
        $s .= '<rect class="g-hi g-hi' . $k . '" x="6" y="' . ($yb - 5) . '" width="228" height="30"/>'
            . '<rect class="g-fly g-fly' . $k . '" x="6" y="' . ($yb - 5) . '" width="228" height="30"/>'
            . '<g class="g-seg g-seg' . $k . '"><rect class="g-ah" x="292" y="' . $ya . '" width="196" height="4"/><rect class="g-b" x="292" y="' . ($ya + 10) . '" width="170" height="3"/><rect class="g-b" x="292" y="' . ($ya + 18) . '" width="118" height="3"/></g>'
            . '<g class="g-chip g-chip' . $k . '"><rect x="416" y="' . ($ya + 13) . '" width="16" height="12"/><text x="424" y="' . ($ya + 22) . '" text-anchor="middle">1</text></g>';
    }
    $s .= '<text class="g-cap" x="260" y="380" text-anchor="middle">RETRIEVED · EXTRACTED · CITED</text><text class="g-cap g-capon" x="260" y="380" text-anchor="middle">RETRIEVED · EXTRACTED · CITED</text>';
    return $s . '</svg>';
}
function rl_geo_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = $lit('rlgBox', 1, 4);
    for ($i = 0; $i < 3; $i++) {
        $k .= $pul("rlgF$i", 5 + $i, 13 + $i) . $lit("rlgPl$i", 12 + $i, 14 + $i) . $pul("rlgR$i", 16 + $i, 24 + $i);
        $k .= ".rl-geo .g-pf$i{animation-name:rlgF$i}.rl-geo .g-pl$i{animation-name:rlgPl$i}.rl-geo .g-pr$i{animation-name:rlgR$i}\n";
    }
    $k .= $lit('rlgDoc', 24, 27);
    $dy = [[132 - 5, 136 - 6], [132 + 72 - 5, 136 + 62 - 6], [132 + 144 - 5, 136 + 124 - 6]];
    for ($i = 0; $i < 3; $i++) {
        $s = 28 + $i * 14; $d = $dy[$i][1] - $dy[$i][0];
        $k .= $lit("rlgHi$i", $s, $s + 2);
        $k .= "@keyframes rlgFly$i{0%," . ($s + 3) . "%{transform:translate(0,0);opacity:0}" . ($s + 4) . "%{opacity:1}" . ($s + 9) . "%{transform:translate(280px,{$d}px);opacity:1}" . ($s + 10) . "%,100%{transform:translate(280px,{$d}px);opacity:0}}\n";
        $k .= $lit("rlgSeg$i", $s + 8, $s + 10) . $lit("rlgChip$i", $s + 10, $s + 12);
        $k .= ".rl-geo .g-hi$i{animation-name:rlgHi$i}.rl-geo .g-fly$i{animation-name:rlgFly$i}.rl-geo .g-seg$i{animation-name:rlgSeg$i}.rl-geo .g-chip$i{animation-name:rlgChip$i}\n";
    }
    $k .= $lit('rlgAns', 70, 74) . $lit('rlgCap', 72, 76);
    return $k;
}

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_geo()) $c[] = 'rl-geo-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_geo(); });
add_action('wp_head', 'rl_geo_css', 22);
function rl_geo_css() {
    if (!rl_is_geo()) return; ?>
<style id="rl-geo-css">
/* shared rules live in reinforce-kit.css (D-044) */
body.rl-geo-page .fl-page-content,body.rl-geo-page .fl-content,body.rl-geo-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
/* hero */
/* hero visual: fan-out to citation */
.rl-geo .fan{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-geo .fan .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-geo .fan .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-geo .fan svg{display:block;width:100%;height:auto;overflow:visible}
.rl-geo .g-box,.rl-geo .g-pill,.rl-geo .g-doc,.rl-geo .g-ans{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-geo .g-boxon,.rl-geo .g-pillon,.rl-geo .g-docon{fill:rgba(153,0,0,.08);stroke:var(--red-2);stroke-width:1;opacity:0}
.rl-geo .g-boxon{animation-name:rlgBox}
.rl-geo .g-docon{fill:none;animation-name:rlgDoc}
.rl-geo .g-ansglow{fill:none;stroke:var(--red-2);stroke-width:1;opacity:0;animation-name:rlgAns}
.rl-geo .g-qt{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.08em;fill:var(--ink)}
.rl-geo .g-st{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-geo .g-lab{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-geo .g-rule{stroke:var(--line-2);stroke-width:1}
.rl-geo .g-h{fill:rgba(255,255,255,.22)}
.rl-geo .g-b{fill:rgba(255,255,255,.10)}
.rl-geo .g-ah{fill:rgba(255,255,255,.30)}
.rl-geo .g-e{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-geo .g-p{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-linecap:round;stroke-dasharray:10 100;stroke-dashoffset:10;opacity:0}
.rl-geo .g-hi{fill:rgba(153,0,0,.10);stroke:var(--red-2);stroke-width:1;opacity:0}
.rl-geo .g-fly{fill:rgba(153,0,0,.18);stroke:var(--red-3);stroke-width:1;opacity:0}
.rl-geo .g-seg,.rl-geo .g-chip{opacity:0}
.rl-geo .g-chip rect{fill:var(--red-2)}
.rl-geo .g-chip text{font-family:var(--f-mono);font-size:8.5px;fill:#fff}
.rl-geo .g-cap{font-family:var(--f-mono);font-size:9px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-geo .g-capon{fill:var(--ink);opacity:0;animation-name:rlgCap}
.rl-geo .g-boxon,.rl-geo .g-pillon,.rl-geo .g-docon,.rl-geo .g-ansglow,.rl-geo .g-p,.rl-geo .g-hi,.rl-geo .g-fly,.rl-geo .g-seg,.rl-geo .g-chip,.rl-geo .g-capon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-geo .g-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-geo .g-qt{font-size:10.5px;letter-spacing:0}.rl-geo .g-st{font-size:10px;letter-spacing:0}.rl-geo .g-lab{font-size:10px;letter-spacing:.08em}.rl-geo .g-cap{font-size:11px;letter-spacing:.06em}.rl-geo .fan .cap span+span{display:none}.rl-geo .fan{padding:16px 10px 10px}}
<?php echo rl_geo_kf(); ?>
/* before/after + research */
.rl-geo .ba{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:760px){.rl-geo .ba{grid-template-columns:1fr}}
.rl-geo .ba > div{border:1px solid var(--glass-line);background:var(--glass);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-geo .ba .after{border-color:var(--red-line);background:linear-gradient(180deg,rgba(153,0,0,.10),var(--glass))}
.rl-geo .ba .tag{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-geo .ba .after .tag{color:var(--red-3)}
.rl-geo .ba blockquote{margin:12px 0 14px;font-size:17px;line-height:1.55;color:var(--ink)}
.rl-geo .ba .before blockquote{color:var(--ink-dim)}
.rl-geo .ba ul{list-style:none;margin:0;padding:0;display:grid;gap:7px}
.rl-geo .ba li{font-size:14px;color:var(--ink-dim);display:flex;gap:10px}
.rl-geo .ba .before li::before{content:"×";color:var(--ink-faint);font-family:var(--f-mono)}
.rl-geo .ba .after li::before{content:"+";color:var(--red-3);font-family:var(--f-mono)}
.rl-geo .research{border-left:2px solid var(--red-2);padding:6px 0 6px 22px;margin-top:clamp(28px,4vw,40px);max-width:80ch}
.rl-geo .research p{color:var(--ink-dim);font-size:15px}
.rl-geo .research p+p{margin-top:10px}
.rl-geo .research .src{font-family:var(--f-mono);font-size:11px;letter-spacing:.06em;color:var(--ink-faint)}
.rl-geo .research .src:first-child{margin-top:0} /* kit .src adds margin-top (D-048); keep GEO as it was */
.rl-geo .research a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-geo .flow4{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,1fr);gap:14px;counter-reset:f}
@media(max-width:900px){.rl-geo .flow4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:520px){.rl-geo .flow4{grid-template-columns:1fr}}
.rl-geo .flow4 li{border:1px solid var(--glass-line);background:var(--glass);padding:22px;counter-increment:f;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-geo .flow4 li::before{content:counter(f,decimal-leading-zero);font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);letter-spacing:.1em}
.rl-geo .flow4 h3{font-size:16px;margin:8px 0}
.rl-geo .flow4 p{color:var(--ink-dim);font-size:14px}
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
    if (!rl_is_geo() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Generative Engine Optimization', 'alternateName' => 'GEO',
        'serviceType' => 'Generative engine optimization', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Generative Engine Optimization structures and writes content so AI search engines such as ChatGPT, Perplexity, Gemini and Google AI Overviews can retrieve it, extract a clear passage and cite the page, through answer-first passages, sourced facts, clear structure and structured data.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_geo_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_geo', 'rl_render_geo');
function rl_render_geo() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $chip = function ($path, $label) use ($ex) { $l = $ex($path); return '<li>' . ($l ? '<a href="' . $l . '">' . esc_html($label) . '</a>' : '<span>' . esc_html($label) . '</span>') . '</li>'; };
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-geo">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Generative Engine Optimization</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;GEO&nbsp;<b>]</b></span>
      <h1 class="h1">Write pages<br>AI engines<br><span class="r">quote and cite.</span></h1>
      <p class="lede"><strong>Generative Engine Optimization (GEO)</strong> structures and writes your content so AI search engines (ChatGPT, Perplexity, Gemini and Google AI Overviews) can retrieve it, extract a clear passage and cite your page in the answer. Reinforce Lab does GEO passage by passage, backed by evidence, and measures citations prompt by prompt.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#toolkit">What we optimize</a>
      </div>
    </div>
    <figure class="fan rl-anim">
      <div class="cap" aria-hidden="true"><span>Query fan-out</span><span>Passage &rarr; citation</span></div>
      <?php echo rl_geo_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'The question', 'kind' => 'rows', 'items' => ['How should we choose a provider?']], ['label' => 'Query fan-out', 'kind' => 'rows', 'items' => ['Selection criteria', 'Typical costs', 'Red flags']], ['label' => 'Retrieved from', 'kind' => 'rows', 'items' => [['Your page', 'hi']]], ['label' => 'Generated answer', 'kind' => 'rows', 'items' => [['[1] Your page cited', 'hi']]]], 'Retrieved · extracted · cited'); ?></figure>
  </div>
</section>

<section class="band alt" id="engines">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>How do generative engines choose what to cite?</h2><p class="lede">A generative engine doesn't hand out a list of ten links. It searches, reads, picks passages and writes an answer, citing the sources it relied on.</p></div>
    <ol class="flow4">
      <li><h3>The question expands</h3><p>Engines often break one question into several related searches. Google calls this "query fan-out" in AI Mode.</p></li>
      <li><h3>Pages are retrieved</h3><p>The engine pulls candidate pages it can crawl and trusts for each of those searches.</p></li>
      <li><h3>Passages are extracted</h3><p>It reads passages, not whole pages, and keeps the ones that answer clearly and specifically.</p></li>
      <li><h3>The answer is written and cited</h3><p>The chosen passages are combined into one answer, with links to the pages they came from.</p></li>
    </ol>
    <div class="research">
      <p class="src">What the research says</p>
      <p>The term GEO comes from a peer-reviewed study by researchers at Princeton University and IIT Delhi, presented at ACM KDD 2024. Testing content changes across a benchmark of diverse queries, they found that GEO methods could boost a source's visibility in generative engine responses by up to 40%, and that the best method varies by domain. Adding citations to credible sources, quotations and statistics were among the strongest methods; keyword stuffing was not.</p>
      <p class="src">Source: Aggarwal et al., "GEO: Generative Engine Optimization", KDD 2024. <a href="https://arxiv.org/abs/2311.09735" rel="noopener" target="_blank">arxiv.org/abs/2311.09735</a></p>
    </div>
  </div>
</section>

<section id="example">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Example&nbsp;<b>]</b></span><h2>What does a citable passage look like?</h2><p class="lede">The same idea, written two ways. Only one gives an AI engine something it can safely quote.</p></div>
    <div class="ba">
      <div class="before"><span class="tag">Before · hard to cite</span><blockquote>"We help brands grow online with smart, results-driven strategies tailored to every business."</blockquote><ul><li>No question answered</li><li>No specific fact or source</li><li>Could describe any company</li></ul></div>
      <div class="after"><span class="tag">After · built to be cited</span><blockquote>"Generative Engine Optimization (GEO) structures content so AI search engines can extract and cite it. It focuses on answer-first passages, sourced facts and clear headings."</blockquote><ul><li>Answers "what is GEO?" in the first sentence</li><li>Defines the term and names what it covers</li><li>Stands on its own if quoted</li></ul></div>
    </div>
  </div>
</section>

<section class="band alt" id="toolkit">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we optimize&nbsp;<b>]</b></span><h2>What makes a page worth citing?</h2><p class="lede">We work through each target page against the same checklist.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Answers</span><h3>Answer-first passages</h3><p>Each section opens with a short, direct answer to one question, then adds the detail.</p></div>
      <div class="cell"><span class="n">02 · Structure</span><h3>Question-shaped headings</h3><p>Headings that match how people actually ask, so each passage maps to a real prompt.</p></div>
      <div class="cell"><span class="n">03 · Evidence</span><h3>Sourced facts and figures</h3><p>Specific claims with a named source, verified by a person before publishing.</p></div>
      <div class="cell"><span class="n">04 · Independence</span><h3>Passages that stand alone</h3><p>No "as mentioned above". Every passage makes sense when it is lifted out on its own.</p></div>
      <div class="cell"><span class="n">05 · Formats</span><h3>Definitions, steps and tables</h3><p>The formats engines extract most cleanly: definitions, numbered steps and comparisons.</p></div>
      <div class="cell"><span class="n">06 · Signals</span><h3>Structured data and real freshness</h3><p>Schema that matches the visible content, and genuine update dates only when content really changes.</p></div>
    </div>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does a GEO engagement run?</h2><p class="lede">Five steps. The first sets the baseline every later change is measured against.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Map prompts to pages</h3><p>Match the questions your buyers ask to the pages that should be cited for them, and find the gaps.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Passage audit</h3><p>Score each target page for answers, evidence, structure and whether passages stand on their own.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Rewrite &amp; restructure</h3><p>Rewrite the passages that matter and create the missing pages, in your voice.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Evidence &amp; schema</h3><p>Tie claims to sources, have a person verify them, and add structured data that matches the page.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Measure &amp; refresh</h3><p>Re-run the prompts, see which passages get cited, and refresh pages when the facts change.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Prompt-to-page map</b>: which page should answer which buyer question.</li>
      <li><b>Passage audit</b>: a score and fix list for every target page.</li>
      <li><b>Rewritten passages</b>: answer-first, sourced and in your voice.</li>
      <li><b>New pages</b>: for the questions no page answers yet.</li>
      <li><b>Evidence log</b>: every important claim and the source behind it.</li>
      <li><b>Structured data</b>: FAQ, Article and Service markup that matches the page.</li>
      <li><b>Citation tracking</b>: which prompts cite you, and which passage they quote.</li>
      <li><b>Refresh plan</b>: when each page needs updating, based on real changes.</li>
    </ul>
  </div>
</section>

<section id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure GEO?</h2><p class="lede">We measure what each answer says about you, as well as where each page ranks.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Citation rate</h3><p>How often your pages are cited for the prompts you target.</p></div>
      <div class="metric"><h3>Cited pages</h3><p>Which of your pages engines rely on, and which never get used.</p></div>
      <div class="metric"><h3>Passage pickup</h3><p>Which passage is quoted, so we know what wording works.</p></div>
      <div class="metric"><h3>Prominence</h3><p>Whether you are the main source or one of several.</p></div>
      <div class="metric"><h3>AI referral traffic</h3><p>Visits and conversions from AI tools, tracked in your analytics.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;No tricks&nbsp;<b>]</b></span>
      <h2>We don't game AI engines.</h2>
      <p>No hidden text, no instructions planted for AI crawlers, no fake reviews and no mass-produced pages. Tricks like these can backfire when engines update, and they break the trust GEO depends on. We make pages more useful, more specific and better sourced, and we measure whether it works.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is GEO for?</h2><p class="lede">Teams whose buyers ask detailed questions before they buy, and whose answers need to be accurate.</p></div>
    <ul class="inds8">
      <?php foreach (rl_geo_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('GEO for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with GEO?</h2><p class="lede">GEO is the content layer. These services make sure the rest of the system supports it.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/ai-search-optimization', 'The umbrella', 'AI Search Optimization', 'The full program for being visible, accurately described and recommended across AI search.'],
          ['services/llm-optimization', 'Entity level', 'LLM Optimization', 'Shapes how language models understand and describe your brand.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Research-led, evidence-checked content produced as a system.'],
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Makes sure search engines and AI crawlers can reach and read every page that matters.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your Google and AI-search performance with a prioritised fix list.'],
          ['services/agents/aeo-geo-optimization', 'Always on', 'AEO/GEO Optimization Agent', 'The Search Authority OS agent that tracks where you appear in AI answers and structures pages to be cited.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About GEO.</h2></div>
    <?php foreach (rl_geo_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Which of your pages would an AI quote today?</h2>
      <p class="lede">The free Search Authority Diagnostic shows where you are cited, where competitors are cited instead, and which pages to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services/ai-search-optimization'); ?>">AI Search Optimization</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
