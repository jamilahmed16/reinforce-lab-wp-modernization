<?php
/**
 * Plugin Name: Reinforce Lab - SEO Content Systems
 * Description: /services/seo-content-systems/ (approved new URL, 27 Sep 2026; D-023 301 target for the legacy content-writing, copywriting, blog-writing and content-marketing service pages) - SEO Content Systems service page. Provides [reinforce_content]. Uses the shared kit (D-044). Hero animation "Content system" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_content() { return is_page('seo-content-systems'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_content_faqs() {
    return [
        ['What is SEO content writing?', 'SEO content writing is creating web pages, articles and copy that answer what people search for, in a way search engines can understand and trust. Good SEO content is written for people first: it matches the searcher’s intent, shows real expertise, is easy to read, and links to related pages on your site.'],
        ['What is an SEO content system?', 'An SEO content system is the repeatable process behind the writing: research, a topic map, briefs, expert input, drafting, editing, publishing, internal linking and scheduled refreshes. It replaces one-off articles with a programme where every page has a purpose, an owner and a place in a topic cluster.'],
        ['Do you use AI to write content?', 'We use AI where it helps: organising research, outlining, transcribing expert interviews and checking drafts. Every page is written and edited by people, fact-checked, and approved by you or your experts. Google says appropriate use of AI is not against its guidelines, but using AI gives content no special gains: quality is what counts.'],
        ['Who writes the content, and how do you get our expertise?', 'Our writers do the writing; your experts supply what only they know. We interview your specialists, sales and customer teams, turn their knowledge into briefs and drafts, and send pages back for technical review, so the expertise on the page is yours.'],
        ['How many articles will you publish each month?', 'As many as can be done well, agreed in the plan, not promised as a volume target. We publish steadily rather than in bulk, because Google treats many pages made mainly to rank as scaled content abuse, however they are produced.'],
        ['Do you update existing content?', 'Yes. Refreshing, merging or removing outdated pages is part of every programme. Google’s starter guide recommends checking older content and updating it, or deleting it if it is no longer relevant.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with content points (D-047) */
function rl_content_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Disease-area and product content with medical-legal review built in', 'Clear authorship, sources and review dates', 'HCP and patient content written for each audience']],
        ['healthcare', 'Healthcare', ['Condition and treatment pages reviewed by clinicians', 'Plain-language answers to real patient questions', 'Service and location pages that convert enquiries']],
        ['b2b-saas', 'B2B SaaS', ['Solution, use-case and integration pages for buying-stage searches', 'Comparison and alternatives pages written honestly', 'Product experts turned into bylined thought leadership']],
        ['ecommerce', 'E-commerce', ['Category and buying-guide content that helps people choose', 'Product copy that is unique, not manufacturer text', 'Seasonal content planned ahead of demand']],
        ['manufacturing', 'Manufacturing', ['Application, specification and material pages engineers search for', 'Technical expertise captured from your engineers', 'Case studies from real projects and installations']],
        ['technology', 'Technology', ['Technical guides and documentation that rank', 'Explainers for non-technical buyers', 'Research and benchmarks that earn citations']],
        ['professional-services', 'Professional Services', ['Practice-area pages that answer client questions', 'Partner insight turned into regular, bylined content', 'Regulatory and market updates written fast and accurately']],
        ['education', 'Education', ['Course and programme pages matched to how students search', 'Faculty expertise and research made readable', 'Admissions content for each stage of the decision']],
    ];
}

/* ---------- hero animation: Content system ----------
   A page moves through the pipeline - research, brief, draft, expert review, publish - each stage
   lighting as it passes; once published it joins a topic cluster: the pillar page and six supporting
   pages light and link to each other; then the refresh loop runs back to research. 10 s loop, soft
   fade, reset. */
function rl_sc_svg() {
    $s = '<svg viewBox="0 0 520 356" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlScT"><title id="rlScT">A page moves through research, brief, draft, expert review and publishing; it joins a topic cluster of linked pages around a pillar page; then a refresh loop returns it to research.</title>';
    foreach (['RESEARCH', 'BRIEF', 'DRAFT', 'REVIEW', 'PUBLISH'] as $i => $t) {
        $x = $i * 106;
        if ($i < 4) $s .= '<line class="c-ar" x1="' . ($x + 96) . '" y1="44" x2="' . ($x + 106) . '" y2="44"/>';
        $s .= '<rect class="c-b" x="' . $x . '" y="24" width="96" height="40"/><rect class="c-on c-st' . $i . '" x="' . $x . '" y="24" width="96" height="40"/>'
            . '<text class="c-t" x="' . ($x + 48) . '" y="47.5" text-anchor="middle">' . $t . '</text><text class="c-t c-ton c-tt' . $i . '" x="' . ($x + 48) . '" y="47.5" text-anchor="middle">' . $t . '</text>';
    }
    $s .= '<text class="c-lab" x="0" y="12">THE PIPELINE</text>';
    $s .= '<g class="c-doc"><rect class="c-dr" x="35" y="74" width="26" height="32"/><rect class="c-dl" x="40" y="81" width="16" height="2.5"/><rect class="c-dl" x="40" y="87" width="12" height="2.5"/><rect class="c-dl" x="40" y="93" width="16" height="2.5"/><rect class="c-dl" x="40" y="99" width="9" height="2.5"/></g>';
    $s .= '<path class="c-e c-ed" d="M478 64 V124 H48 V64"/><path class="c-p c-rf" pathLength="100" d="M478 64 V124 H48 V64"/><text class="c-lab c-rft" x="263" y="118" text-anchor="middle">REFRESH</text>';
    $s .= '<text class="c-lab" x="0" y="160">THE TOPIC CLUSTER</text>';
    $s .= '<rect class="c-b" x="208" y="222" width="104" height="40"/><rect class="c-on c-pil" x="208" y="222" width="104" height="40"/><text class="c-pt" x="260" y="246.5" text-anchor="middle">PILLAR PAGE</text>';
    $cl = [['GUIDE', 0, 176], ['HOW-TO', 0, 229], ['FAQ', 0, 282], ['COMPARISON', 410, 176], ['GLOSSARY', 410, 229], ['CASE STUDY', 410, 282]];
    foreach ($cl as $i => $c) {
        $x = $c[1]; $y = $c[2]; $cy = $y + 14;
        $d = $x === 0 ? 'M110 ' . $cy . ' C160 ' . $cy . ' 170 242 208 242' : 'M410 ' . $cy . ' C360 ' . $cy . ' 350 242 312 242';
        $s .= '<path class="c-e" d="' . $d . '"/><path class="c-p c-lk' . $i . '" pathLength="100" d="' . $d . '"/>'
            . '<rect class="c-b" x="' . $x . '" y="' . $y . '" width="110" height="28"/><rect class="c-on c-cl' . $i . '" x="' . $x . '" y="' . $y . '" width="110" height="28"/><text class="c-t c-ct" x="' . ($x + 55) . '" y="' . ($y + 17.5) . '" text-anchor="middle">' . $c[0] . '</text>';
    }
    $s .= '<text class="c-cap" x="260" y="346" text-anchor="middle">ONE SYSTEM · EVERY PAGE BRIEFED, REVIEWED, LINKED AND REFRESHED</text><text class="c-cap c-capon" x="260" y="346" text-anchor="middle">ONE SYSTEM · EVERY PAGE BRIEFED, REVIEWED, LINKED AND REFRESHED</text>';
    return $s . '</svg>';
}
function rl_sc_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = '';
    $arr = [4, 11, 18, 25, 32];
    foreach ($arr as $i => $t) $k .= $lit("rlscS$i", $t, $t + 2) . ".rl-sc .c-st$i,.rl-sc .c-tt$i{animation-name:rlscS$i}\n";
    /* the page steps from stage to stage */
    $f = "@keyframes rlscDoc{0%{transform:translateX(0);opacity:0}3%{transform:translateX(0);opacity:1}";
    for ($i = 1; $i < 5; $i++) { $f .= ($arr[$i] - 4) . "%{transform:translateX(" . (($i - 1) * 106) . "px)}" . $arr[$i] . "%{transform:translateX(" . ($i * 106) . "px)}"; }
    $k .= $f . "36%{transform:translateX(424px);opacity:1}40%,100%{transform:translateX(424px);opacity:0}}\n";
    $k .= $lit('rlscPil', 38, 41);
    for ($i = 0; $i < 6; $i++) { $s = 42 + $i * 4; $k .= "@keyframes rlscL$i{0%,{$s}%{stroke-dashoffset:100;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($s + 5) . "%,92%{stroke-dashoffset:0;opacity:1}97%,100%{stroke-dashoffset:0;opacity:0}}\n" . $lit("rlscC$i", $s + 4, $s + 6) . ".rl-sc .c-lk$i{animation-name:rlscL$i}.rl-sc .c-cl$i{animation-name:rlscC$i}\n"; }
    $k .= "@keyframes rlscRf{0%,70%{stroke-dashoffset:10;opacity:0}71%{opacity:1}83%{opacity:1}84%,100%{stroke-dashoffset:-100;opacity:0}}\n" . $lit('rlscRft', 70, 73) . $lit('rlscCap', 76, 80);
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_content()) $c[] = 'rl-sc-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_content(); });
add_action('wp_head', 'rl_content_css', 22);
function rl_content_css() {
    if (!rl_is_content()) return; ?>
<style id="rl-sc-css">
body.rl-sc-page .fl-page-content,body.rl-sc-page .fl-content,body.rl-sc-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-sc .csy{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-sc .csy .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-sc .csy .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-sc .csy svg{display:block;width:100%;height:auto;overflow:visible}
.rl-sc .c-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-sc .c-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-sc .c-pil{animation-name:rlscPil}
.rl-sc .c-ar{stroke:rgba(243,237,230,.2);stroke-width:.8}
.rl-sc .c-t{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.14em;fill:var(--ink-faint)}
.rl-sc .c-ton{fill:#fff;opacity:0}
.rl-sc .c-ct{fill:var(--ink-dim)}
.rl-sc .c-pt{font-family:var(--f-display);font-weight:600;font-size:11.5px;letter-spacing:.08em;fill:var(--ink)}
.rl-sc .c-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-sc .c-rft{fill:var(--red-3);opacity:0;animation-name:rlscRft}
.rl-sc .c-dr{fill:rgba(194,26,26,.35);stroke:var(--red-3);stroke-width:.8}
.rl-sc .c-dl{fill:rgba(255,255,255,.55)}
.rl-sc .c-doc{animation-name:rlscDoc}
.rl-sc .c-e{fill:none;stroke:rgba(243,237,230,.08);stroke-width:.8}
.rl-sc .c-ed{stroke-dasharray:2 4}
.rl-sc .c-p{fill:none;stroke:rgba(226,59,59,.75);stroke-width:1;stroke-dasharray:100 100;stroke-dashoffset:100;opacity:0}
.rl-sc .c-rf{stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;animation-name:rlscRf;animation-timing-function:ease-in-out}
.rl-sc .c-cap{font-family:var(--f-mono);font-size:7.5px;letter-spacing:.12em;fill:var(--ink-faint)}
.rl-sc .c-capon{fill:var(--ink);opacity:0;animation-name:rlscCap}
.rl-sc .c-on,.rl-sc .c-ton,.rl-sc .c-doc,.rl-sc .c-p,.rl-sc .c-rft,.rl-sc .c-capon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-sc .c-t{font-size:9.5px;letter-spacing:.02em}.rl-sc .c-pt{font-size:12.5px}.rl-sc .c-lab{font-size:9.5px;letter-spacing:.06em}.rl-sc .c-cap{display:none}.rl-sc .csy .cap span+span{display:none}.rl-sc .csy{padding:16px 10px 10px}}
<?php echo rl_sc_kf(); ?>
.rl-sc .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-sc .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_content() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'SEO Content Systems', 'alternateName' => ['SEO content writing services', 'SEO copywriting', 'Blog writing services'],
        'serviceType' => 'SEO content writing and content strategy', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'SEO content systems: research, topic maps, briefs, expert input, human-edited writing, publishing, internal linking and scheduled refreshes, people-first content that ranks in Google, gets cited in AI answers and converts.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_content_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_content', 'rl_render_content');
function rl_render_content() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $gd = function ($p) { return esc_url('https://developers.google.com/search/' . $p); };
    $ai = $gd('blog/2023/02/google-search-and-ai-content');
    $cmi = esc_url('https://contentmarketinginstitute.com/b2b-research/b2b-content-marketing-trends-research');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-sc">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">SEO Content Systems</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;SEO Content&nbsp;<b>]</b></span>
      <h1 class="h1">Content that ranks,<br>gets cited<br><span class="r">and converts.</span></h1>
      <p class="lede"><strong>SEO content systems</strong> turn SEO content writing into a repeatable process: research, a topic map, briefs, your experts' knowledge, human-edited writing, publishing, internal links and scheduled refreshes. Reinforce Lab builds and runs that system, so every page answers a real search, shows real expertise, and earns its place in Google and in AI answers.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#ai">Our AI policy</a>
      </div>
    </div>
    <figure class="csy rl-anim">
      <div class="cap" aria-hidden="true"><span>Content system</span><span>Pipeline · cluster · refresh</span></div>
      <?php echo rl_sc_svg(); ?>
    </figure>
  </div>
</section>

<section class="band alt" id="system">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The system&nbsp;<b>]</b></span><h2>What is an SEO content system?</h2><p class="lede">It is the process behind the writing. Six stages, run the same way for every page, so quality doesn't depend on who happened to write it.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Research</span><h3>Search &amp; audience</h3><p>What your buyers search for at each stage, what already ranks, and what your competitors miss.</p></div>
      <div class="cell"><span class="n">02 · Map</span><h3>Topic map</h3><p>Pillar and cluster pages planned around your services, so each page has one job and none compete.</p></div>
      <div class="cell"><span class="n">03 · Brief</span><h3>Briefs with expert input</h3><p>Search intent, structure, questions to answer and the expertise we need from your team.</p></div>
      <div class="cell"><span class="n">04 · Write</span><h3>Human-written, edited</h3><p>Drafted by writers, checked by editors, fact-checked and reviewed by your experts.</p></div>
      <div class="cell"><span class="n">05 · Publish</span><h3>Published &amp; linked</h3><p>Titles, structure, schema and internal links set, and the page linked into its cluster.</p></div>
      <div class="cell"><span class="n">06 · Refresh</span><h3>Measured &amp; updated</h3><p>Performance reviewed, then pages refreshed, merged or retired on a schedule.</p></div>
    </div>
  </div>
</section>

<section id="data">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Why programmes stall&nbsp;<b>]</b></span><h2>Why do most content programmes stall?</h2><p class="lede">Not for lack of a strategy. The Content Marketing Institute's 2026 survey of 1,015 B2B marketers shows where it breaks.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">40%</span><h3>Content that converts</h3><p>name creating content that prompts action (such as a conversion) as a top challenge.</p></div>
      <div class="metric"><span class="num">39%</span><h3>Not enough resource</h3><p>cite constraints on time, people or budget.</p></div>
      <div class="metric"><span class="num">33%</span><h3>Hard to measure</h3><p>struggle to measure how effective their content is.</p></div>
      <div class="metric"><span class="num">89%</span><h3>AI is everywhere</h3><p>of AI users use it to generate or optimise written content.</p></div>
      <div class="metric"><span class="num">12%</span><h3>…and not always better</h3><p>of those using AI for content say its quality has decreased.</p></div>
      <div class="metric"><span class="num">37%</span><h3>Experts left out</h3><p>say fewer than 5% of their in-house experts contribute to thought leadership.</p></div>
    </div>
    <p class="src">Source: Content Marketing Institute, <a href="<?php echo $cmi; ?>" rel="noopener" target="_blank">B2B Content and Marketing Trends: Insights for 2026</a> (October 2025)</p>
  </div>
</section>

<section class="band alt" id="ai">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;AI &amp; Google&nbsp;<b>]</b></span><h2>Does Google penalise AI-written content?</h2><p class="lede">No. Google judges quality, not how content was made. But it does act on content produced at scale to game rankings. Here is what Google actually says.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Google bans AI content."</p></div><div class="f"><span class="tag">Google says</span><p>"Appropriate use of AI or automation is not against our guidelines." Using it mainly to manipulate rankings is.</p><a href="<?php echo $ai; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"AI content gets a ranking boost."</p></div><div class="f"><span class="tag">Google says</span><p>"Using AI doesn't give content any special gains. It's just content."</p><a href="<?php echo $ai; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Publish hundreds of pages and some will rank."</p></div><div class="f"><span class="tag">Google says</span><p>Many pages made mainly to manipulate rankings, not help users, is scaled content abuse, "no matter how it's created".</p><a href="<?php echo $gd('blog/2024/03/core-update-spam-policies'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Longer articles always rank better."</p></div><div class="f"><span class="tag">Google says</span><p>There's no magical word count target: content length alone doesn't matter for ranking.</p><a href="<?php echo $gd('docs/fundamentals/seo-starter-guide'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Authorship doesn't matter."</p></div><div class="f"><span class="tag">Google says</span><p>Consider accurate author bylines wherever readers might ask "Who wrote this?", and disclose AI use where they'd ask "How was this created?"</p><a href="<?php echo $ai; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
    <p class="quote">Our policy: AI helps with research, outlines, transcripts and checks. People write, edit and fact-check every page, and your experts approve it.</p>
  </div>
</section>

<section id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we write&nbsp;<b>]</b></span><h2>What content do we produce?</h2><p class="lede">SEO content writing, website copywriting and blog writing, all planned inside one system.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Services</span><h3>Service &amp; solution pages</h3><p>The pages that sell: clear, specific and built to rank for buying-stage searches.</p></div>
      <div class="cell"><span class="n">02 · Pillars</span><h3>Pillar &amp; cluster pages</h3><p>In-depth hub pages and the supporting pages that build topical authority around them.</p></div>
      <div class="cell"><span class="n">03 · Blog</span><h3>SEO blog articles</h3><p>Articles that answer real questions your buyers ask, linked to the pages that convert.</p></div>
      <div class="cell"><span class="n">04 · Copy</span><h3>Website copywriting</h3><p>Home, about and landing-page copy that is clear to people and to search engines.</p></div>
      <div class="cell"><span class="n">05 · Compare</span><h3>Comparison pages</h3><p>Honest comparisons and alternatives pages for buyers weighing their options.</p></div>
      <div class="cell"><span class="n">06 · Proof</span><h3>Case studies</h3><p>Real projects and results, written up with your clients' approval.</p></div>
      <div class="cell"><span class="n">07 · Guides</span><h3>Guides &amp; resources</h3><p>Useful, citable resources that earn links and mentions over time.</p></div>
      <div class="cell"><span class="n">08 · Answers</span><h3>Answer-ready content</h3><p>Clear definitions, FAQs and facts that AI search tools can quote accurately.</p></div>
      <div class="cell"><span class="n">09 · Refresh</span><h3>Content refreshes</h3><p>Existing pages updated, merged or retired, often the fastest win.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does an SEO content engagement run?</h2><p class="lede">Audit what you have, plan what's missing, then publish steadily, never in bulk.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Audit</h3><p>Every existing page: what ranks, what converts, what overlaps and what's out of date.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Plan</h3><p>Topic map, priorities and a publishing calendar tied to your services.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Interview</h3><p>Your experts, sales and customer teams: the knowledge no competitor has.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Produce</h3><p>Brief, write, edit, fact-check, approve and publish, page by page.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Refresh</h3><p>Measure every page and update, merge or retire on a schedule.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Content audit</b>: every page rated keep, improve, merge or retire.</li>
      <li><b>Topic map</b>: pillars, clusters and the searches each page targets.</li>
      <li><b>Editorial calendar</b>: agreed priorities and publishing dates.</li>
      <li><b>Briefs</b>: intent, structure, questions and expert input for each page.</li>
      <li><b>Written &amp; edited pages</b>: fact-checked and approved by your experts.</li>
      <li><b>On-page setup</b>: titles, headings, schema and internal links.</li>
      <li><b>Style &amp; AI guidelines</b>: how your content is written and how AI may be used.</li>
      <li><b>Monthly report</b>: rankings, traffic, conversions and AI citations per page.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure content?</h2><p class="lede">Page by page, against what it was written to do.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Indexed &amp; ranking</h3><p>Whether each page is indexed and where it ranks for its target searches.</p></div>
      <div class="metric"><h3>Organic traffic</h3><p>Visits from search to each page and cluster.</p></div>
      <div class="metric"><h3>Conversions</h3><p>Enquiries, sign-ups and assisted conversions from content.</p></div>
      <div class="metric"><h3>Engagement</h3><p>Whether readers stay, scroll and click through to the next step.</p></div>
      <div class="metric"><h3>Links &amp; citations</h3><p>Links earned and mentions in AI answers.</p></div>
      <div class="metric"><h3>Content health</h3><p>Pages refreshed, merged or retired, and what that changed.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>More content is not a strategy.</h2>
      <p>Anyone can publish a hundred articles a month now. Most of them won't rank, won't be cited and won't sell, and publishing at that scale mainly to rank is exactly what Google's scaled-content policy targets. We would rather publish fewer pages that each answer a real question with real expertise, and keep them up to date.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who are SEO content systems for?</h2><p class="lede">Businesses with deep expertise that isn't yet on their website, and buyers who research before they talk to anyone.</p></div>
    <ul class="inds8">
      <?php foreach (rl_content_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('SEO content for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with SEO content?</h2><p class="lede">Content ranks when the site is sound and the brand is trusted. These services cover the rest.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/best-search-engine-optimization-services', 'Pillar', 'Search Engine Optimization', 'All four pillars of SEO (technical, on-page, content and authority) as one system.'],
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Crawling, indexing and speed, so new pages get found and indexed.'],
          ['services/press-release-services', 'Authority', 'Digital PR &amp; Link Building', 'Coverage and links that give your content the authority to rank.'],
          ['services/generative-engine-optimization', 'Citations', 'GEO', 'Content structured so AI engines can quote and cite it.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'Visibility and accurate descriptions of your brand in AI answers.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO &amp; AI Search Audit', 'A full review of your content, technical SEO and AI-search visibility.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . $r[2] . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About SEO content.</h2></div>
    <?php foreach (rl_content_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Is your content working, or just published?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your content, indexing and AI-search visibility, and shows what to fix first.</p>
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
