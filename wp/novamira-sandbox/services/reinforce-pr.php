<?php
/**
 * Plugin Name: Reinforce Lab - Digital PR & Link Building
 * Description: /services/press-release-services/ (production URL kept, D-023; rebuilt as Digital PR & link building; 301 target for the legacy off-page / link-building URLs, O-018 B) - Digital PR service page. Provides [reinforce_pr]. Uses the shared kit (D-044). Hero animation "Story to authority" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_pr() { return is_page('press-release-services'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_pr_faqs() {
    return [
        ['What is digital PR?', 'Digital PR is earning coverage, links and mentions from online publications by giving journalists something worth reporting: original data, expert commentary, useful resources or genuine news. For SEO, it is the safest way to build links, because each one is an editorial choice by the publication rather than a placement someone paid for.'],
        ['What is off-page SEO?', 'Off-page SEO is everything outside your own website that affects how search engines and AI tools judge it: mainly links from other sites, mentions of your brand, coverage in the press and citations in AI answers. Google uses links to find pages and to judge how relevant they are.'],
        ['Is affordable link building safe?', 'Cheap links are usually sold per link, as placements that pass ranking credit, and Google lists buying or selling links for ranking purposes as link spam. Paid placements are fine for exposure if they are qualified with rel="sponsored" or rel="nofollow". On a smaller budget we focus on link reclamation, partner links and expert commentary, which cost less and carry no policy risk.'],
        ['Do you guarantee a number of links?', 'No. Journalists and editors decide what they cover and link to, so any guaranteed link count is either a guess or a paid placement. We agree targets for relevant outlets and pages, report every piece of coverage and its link status, and adjust the campaign on what journalists respond to.'],
        ['Do press releases help SEO?', 'A press release helps when it carries real news that journalists pick up and write about. Links inside distributed releases should not pass ranking credit. Google lists optimised anchor-text links in press releases distributed on other sites as link spam. We write releases for journalists, not for links.'],
        ['How long does a digital PR campaign take?', 'A data-led campaign usually needs several weeks of research, writing and approval before outreach begins; reactive commentary can go out the same day. Coverage arrives after launch, and its effect on rankings builds over months rather than days.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with digital PR points (D-047) */
function rl_pr_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Research and disease-area data stories for trade and health media', 'Expert commentary reviewed by medical and legal teams', 'Congress, trial and launch news pitched to specialist press']],
        ['healthcare', 'Healthcare', ['Clinician experts offered for health and local news', 'Patient-safe data stories from anonymised, aggregate insight', 'Coverage that builds trust signals for health searches']],
        ['b2b-saas', 'B2B SaaS', ['Original product-usage and industry data reports', 'Founder and expert commentary for tech and trade press', 'Links to product, integration and comparison pages']],
        ['ecommerce', 'E-commerce', ['Product and trend stories for consumer and lifestyle media', 'Seasonal data campaigns timed to buying peaks', 'Links earned to category and product pages']],
        ['manufacturing', 'Manufacturing', ['Trade-press coverage for innovations, plants and contracts', 'Engineering experts for industry features', 'Industry-body and supplier links, not bought placements']],
        ['technology', 'Technology', ['Research reports and benchmarks journalists can cite', 'Reactive expert comment on breaking tech news', 'Coverage in the publications buyers actually read']],
        ['professional-services', 'Professional Services', ['Thought leadership turned into quotable data', 'Partners and experts placed in business and trade media', 'Reactive comment on regulation, tax and market news']],
        ['education', 'Education', ['Faculty experts offered for news and features', 'Research findings pitched to education and national press', 'Links to course, research and department pages']],
    ];
}

/* ---------- hero animation: Story to authority ----------
   An original-data story builds; it is pitched to four outlets; coverage lands with a link (or, in an
   AI answer, a citation); links flow back to your site and its authority meter fills; the four
   stages - pitch, coverage, links, citations - light in turn. 10 s loop, soft fade, reset. */
function rl_pr_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlPrT"><title id="rlPrT">An original-data story is pitched to news, trade and industry outlets; coverage links back to your site and AI answers cite your brand, so authority builds without bought links.</title>';
    $s .= '<rect class="p-b" x="0" y="112" width="130" height="126"/><text class="p-lab" x="12" y="130">ORIGINAL DATA</text><line class="p-rule" x1="12" y1="138" x2="118" y2="138"/>';
    foreach ([46, 70, 32, 84] as $i => $h) $s .= '<rect class="p-bar p-bar' . $i . '" x="' . (18 + $i * 26) . '" y="' . (226 - $h) . '" width="16" height="' . $h . '"/>';
    $s .= '<line class="p-rule" x1="12" y1="226.5" x2="118" y2="226.5"/>';
    $outs = ['NEWS SITE', 'TRADE PRESS', 'INDUSTRY BLOG', 'AI ANSWER'];
    foreach ($outs as $i => $o) {
        $y = 14 + $i * 86; $cy = $y + 30;
        $d = 'M130 175 C165 175 160 ' . $cy . ' 196 ' . $cy;
        $s .= '<path class="p-e" d="' . $d . '"/><path class="p-p p-pp' . $i . '" pathLength="100" d="' . $d . '"/>';
        $l = 'M346 ' . $cy . ' C382 ' . $cy . ' 376 175 410 175';
        $s .= '<path class="p-e' . ($i === 3 ? ' p-ed' : '') . '" d="' . $l . '"/><path class="p-p p-pl' . $i . '" pathLength="100" d="' . $l . '"/>';
        $s .= '<rect class="p-b" x="196" y="' . $y . '" width="150" height="60"/><rect class="p-on p-o' . $i . '" x="196" y="' . $y . '" width="150" height="60"/>'
            . '<text class="p-ot" x="208" y="' . ($y + 17) . '">' . $o . '</text>'
            . '<rect class="p-hl p-h' . $i . '" x="208" y="' . ($y + 26) . '" width="' . [120, 104, 112, 96][$i] . '" height="4"/><rect class="p-hl p-h' . $i . '" x="208" y="' . ($y + 35) . '" width="84" height="4"/>';
        $s .= $i === 3
            ? '<text class="p-lk p-k' . $i . '" x="208" y="' . ($y + 52) . '">CITED: YOUR BRAND</text>'
            : '<text class="p-lk p-k' . $i . '" x="208" y="' . ($y + 52) . '">LINK → YOUR SITE</text>';
    }
    $s .= '<rect class="p-b p-site" x="410" y="112" width="110" height="126"/><rect class="p-on p-siteon" x="410" y="112" width="110" height="126"/><text class="p-st" x="422" y="132">YOUR SITE</text><line class="p-rule" x1="422" y1="140" x2="508" y2="140"/><text class="p-lab" x="422" y="160">AUTHORITY</text>';
    for ($i = 0; $i < 4; $i++) $s .= '<rect class="p-seg" x="422" y="' . (218 - $i * 12) . '" width="86" height="8"/><rect class="p-segon p-g' . $i . '" x="422" y="' . (218 - $i * 12) . '" width="86" height="8"/>';
    $s .= '<line class="p-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['PITCH', 'COVERAGE', 'LINKS', 'CITATIONS'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="p-ft" x="' . $x . '" y="372">' . $f . '</text><text class="p-ft p-fton p-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="p-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="p-fbon p-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_pr_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 4; $i++) { $s = 2 + $i * 2; $k .= "@keyframes rlprBar$i{0%,{$s}%{transform:scaleY(0)}" . ($s + 6) . "%,92%{transform:scaleY(1);opacity:1}97%,100%{transform:scaleY(1);opacity:0}}\n.rl-pr .p-bar$i{animation-name:rlprBar$i}\n"; }
    for ($i = 0; $i < 4; $i++) {
        $p = 14 + $i * 3; $o = $p + 8; $l = 40 + $i * 4;
        $k .= $pul("rlprPp$i", $p, $p + 8) . $lit("rlprO$i", $o, $o + 3) . $lit("rlprH$i", $o + 1, $o + 4) . $lit("rlprK$i", $o + 4, $o + 6) . $pul("rlprPl$i", $l, $l + 9) . $lit("rlprG$i", $l + 8, $l + 10);
        $k .= ".rl-pr .p-pp$i{animation-name:rlprPp$i}.rl-pr .p-o$i{animation-name:rlprO$i}.rl-pr .p-h$i{animation-name:rlprH$i}.rl-pr .p-k$i{animation-name:rlprK$i}.rl-pr .p-pl$i{animation-name:rlprPl$i}.rl-pr .p-g$i{animation-name:rlprG$i}\n";
    }
    $k .= $lit('rlprSite', 48, 52);
    foreach ([14, 24, 42, 56] as $i => $s) $k .= $lit("rlprF$i", $s, $s + 3) . "@keyframes rlprFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-pr .p-f$i{animation-name:rlprF$i}.rl-pr .p-fb$i{animation-name:rlprFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_pr()) $c[] = 'rl-pr-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_pr(); });
add_action('wp_head', 'rl_pr_css', 22);
function rl_pr_css() {
    if (!rl_is_pr()) return; ?>
<style id="rl-pr-css">
body.rl-pr-page .fl-page-content,body.rl-pr-page .fl-content,body.rl-pr-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-pr .prw{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-pr .prw .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-pr .prw .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-pr .prw svg{display:block;width:100%;height:auto;overflow:visible}
.rl-pr .p-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-pr .p-site{stroke:rgba(226,59,59,.35)}
.rl-pr .p-on{fill:rgba(153,0,0,.07);stroke:rgba(226,59,59,.6);stroke-width:.8;opacity:0}
.rl-pr .p-siteon{animation-name:rlprSite}
.rl-pr .p-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-pr .p-st{font-family:var(--f-display);font-weight:600;font-size:12px;letter-spacing:.08em;fill:var(--ink)}
.rl-pr .p-rule{stroke:rgba(243,237,230,.1);stroke-width:.8}
.rl-pr .p-bar{fill:rgba(194,26,26,.55);stroke:rgba(226,59,59,.7);stroke-width:.6;transform-box:fill-box;transform-origin:50% 100%;transform:scaleY(0)}
.rl-pr .p-bar3{fill:var(--red-2)}
.rl-pr .p-e{fill:none;stroke:rgba(243,237,230,.08);stroke-width:.8}
.rl-pr .p-ed{stroke-dasharray:2 4}
.rl-pr .p-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0}
.rl-pr .p-ot{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.14em;fill:var(--ink-dim)}
.rl-pr .p-hl{fill:rgba(255,255,255,.14);opacity:0}
.rl-pr .p-lk{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:var(--red-3);opacity:0}
.rl-pr .p-seg{fill:rgba(255,255,255,.05);stroke:rgba(243,237,230,.08);stroke-width:.6}
.rl-pr .p-segon{fill:rgba(194,26,26,.5);stroke:rgba(226,59,59,.7);stroke-width:.6;opacity:0}
.rl-pr .p-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-pr .p-fton{fill:var(--ink);opacity:0}
.rl-pr .p-fb{fill:rgba(255,255,255,.08)}
.rl-pr .p-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-pr .p-bar,.rl-pr .p-p,.rl-pr .p-on,.rl-pr .p-hl,.rl-pr .p-lk,.rl-pr .p-segon,.rl-pr .p-fton,.rl-pr .p-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-pr .p-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-pr .p-ot{font-size:10px;letter-spacing:.03em}.rl-pr .p-lk{font-size:9.5px;letter-spacing:0}.rl-pr .p-lab{font-size:9.5px;letter-spacing:.06em}.rl-pr .p-ft{font-size:11px;letter-spacing:.04em}.rl-pr .prw .cap span+span{display:none}.rl-pr .prw{padding:16px 10px 10px}}
<?php echo rl_pr_kf(); ?>
.rl-pr .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-pr .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
.rl-pr .factors{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:820px){.rl-pr .factors{grid-template-columns:1fr}}
.rl-pr .factor{border:1px solid var(--glass-line);background:var(--glass);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi);display:flex;flex-direction:column;gap:10px}
.rl-pr .factor .n{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-pr .factor h3{font-size:20px}
.rl-pr .factor p{color:var(--ink-dim);font-size:16px}
.rl-pr .factor .we{margin-top:auto;border-top:1px solid var(--line);padding-top:10px;color:var(--ink);font-size:16px}
.rl-pr .factor .we b{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;color:var(--red-3);font-weight:500;text-transform:uppercase;margin-right:6px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_pr() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Digital PR & Link Building', 'alternateName' => ['Digital PR', 'Off-page SEO', 'Link building services'],
        'serviceType' => 'Digital PR and off-page SEO', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Digital PR and off-page SEO that earns coverage, links and mentions from relevant publications through original data, expert commentary and newsworthy stories, within Google’s link policies, with no bought links, to build authority in Google and AI search.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_pr_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_pr', 'rl_render_pr');
function rl_render_pr() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $gd = function ($p) { return esc_url('https://developers.google.com/search/docs/' . $p); };
    $spam = $gd('essentials/spam-policies');
    $cision = esc_url('https://www.prnewswire.com/content/dam/prnewswire/resources/white-papers/Cision_2026_State_of_the_Media_Report.pdf');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-pr">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Digital PR &amp; Link Building</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Digital PR&nbsp;<b>]</b></span>
      <h1 class="h1">Earn coverage<br>and links that<br><span class="r">build authority.</span></h1>
      <p class="lede"><strong>Digital PR</strong> is off-page SEO done in the open. Reinforce Lab builds stories from original data and expert insight, pitches them to the journalists who cover your field, and earns the coverage, links and mentions that build your authority in Google and AI search, with no bought links and no keyword-stuffed press releases.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#rules">Link rules</a>
      </div>
    </div>
    <figure class="prw rl-anim">
      <div class="cap" aria-hidden="true"><span>Digital PR</span><span>Story · coverage · links · citations</span></div>
      <?php echo rl_pr_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'The story', 'kind' => 'core', 'title' => 'Original data', 'sub' => 'Pitched to the right outlets'], ['label' => 'Coverage', 'kind' => 'rows', 'items' => ['News site', 'Trade press', 'Industry blog']], ['label' => 'Results', 'kind' => 'rows', 'items' => [['Link → your site', 'ok'], ['AI answer · cited: your brand', 'hi']]]], 'Pitch · coverage · links · citations'); ?></figure>
  </div>
</section>

<section class="band alt" id="offpage">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Off-page SEO&nbsp;<b>]</b></span><h2>What is off-page SEO, and where does link building fit?</h2><p class="lede">Off-page SEO is what other sites say about you. Links are part of it; so are coverage, mentions and citations in AI answers.</p></div>
    <div class="factors">
      <div class="factor"><span class="n">01 · Links</span><h3>How Google finds and judges you</h3><p>Google uses links to discover pages and as a signal of how relevant they are.</p><p class="we"><b>We earn</b>Editorial links from relevant publications to the pages that matter commercially.</p></div>
      <div class="factor"><span class="n">02 · Coverage</span><h3>Who is talking about you</h3><p>Coverage in the publications your buyers read builds trust (and branded search) with or without a link.</p><p class="we"><b>We earn</b>Features, quotes and mentions in news, trade and industry media.</p></div>
      <div class="factor"><span class="n">03 · Citations</span><h3>What AI answers say</h3><p>AI search tools lean on independent sources. Brands that trusted publications cover are easier to cite.</p><p class="we"><b>We track</b>Whether AI answers mention and cite you, alongside links.</p></div>
    </div>
    <p class="src">Source: Google, <a href="<?php echo $gd('crawling-indexing/links-crawlable'); ?>" rel="noopener" target="_blank">Link best practices</a> · <a href="<?php echo $gd('fundamentals/seo-starter-guide'); ?>" rel="noopener" target="_blank">SEO Starter Guide</a></p>
  </div>
</section>

<section id="journalists">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What journalists want&nbsp;<b>]</b></span><h2>What makes journalists cover a story?</h2><p class="lede">Relevance, first and by a distance. Cision's 2026 survey of 1,899 journalists in 19 markets is the brief we work to.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">79%</span><h3>Relevance wins</h3><p>are most likely to engage with a pitch relevant to their beat, audience or coverage area.</p></div>
      <div class="metric"><span class="num">82%</span><h3>Irrelevance loses</h3><p>reject a pitch that isn't relevant to their audience or coverage, the top reason for deleting one.</p></div>
      <div class="metric"><span class="num">47%</span><h3>Data is in demand</h3><p>want PR teams to send them more data or research, the most-requested resource.</p></div>
      <div class="metric"><span class="num">66%</span><h3>PR feeds the news</h3><p>rely on PR-provided content (press releases, pitches, media kits) for story ideas.</p></div>
      <div class="metric"><span class="num">53%</span><h3>No sales pitches</h3><p>reject pitches that are too promotional or sales-focused.</p></div>
      <div class="metric"><span class="num">97%</span><h3>Email, short, once</h3><p>prefer pitches by email; 64% say follow up once, and no more.</p></div>
    </div>
    <p class="src">Source: Cision, <a href="<?php echo $cision; ?>" rel="noopener" target="_blank">2026 State of the Media Report</a> (survey January to February 2026)</p>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we do&nbsp;<b>]</b></span><h2>What does our digital PR and link building cover?</h2><p class="lede">Nine ways to earn links and coverage, each chosen for your pages, your market and your budget.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Data</span><h3>Original data studies</h3><p>Surveys, analysis of your own data and public datasets, turned into findings journalists can report.</p></div>
      <div class="cell"><span class="n">02 · Reactive</span><h3>Expert commentary</h3><p>Your experts offered to journalists on breaking news in your field, often the same day.</p></div>
      <div class="cell"><span class="n">03 · News</span><h3>Press releases done right</h3><p>Releases for real news, written for journalists, never as a vehicle for keyword links.</p></div>
      <div class="cell"><span class="n">04 · Assets</span><h3>Linkable resources</h3><p>Tools, guides, indexes and visual data that people cite and link to over time.</p></div>
      <div class="cell"><span class="n">05 · Product</span><h3>Product &amp; brand stories</h3><p>Launches, milestones and behind-the-scenes angles pitched to the right beats.</p></div>
      <div class="cell"><span class="n">06 · Reclaim</span><h3>Link reclamation</h3><p>Unlinked brand mentions and broken links to your site turned back into working links.</p></div>
      <div class="cell"><span class="n">07 · Partners</span><h3>Partner &amp; industry links</h3><p>Associations, suppliers, events and partners, where a link reflects a real relationship.</p></div>
      <div class="cell"><span class="n">08 · Targets</span><h3>Links to the right pages</h3><p>Campaigns planned around the service, product and category pages you need to rank.</p></div>
      <div class="cell"><span class="n">09 · AI search</span><h3>Citations in AI answers</h3><p>Coverage in the sources AI search tools draw on, tracked for mentions and citations.</p></div>
    </div>
  </div>
</section>

<section id="rules">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Link rules&nbsp;<b>]</b></span><h2>Which link building tactics break Google's rules?</h2><p class="lede">Cheap link building usually means one of these. Here is what Google actually says.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Buy links in bulk; it's cheaper per link."</p></div><div class="f"><span class="tag">Google says</span><p>Buying or selling links for ranking purposes is link spam: "creating links to or from a site primarily for the purpose of manipulating search rankings."</p><a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Paid placements have to be hidden."</p></div><div class="f"><span class="tag">Google says</span><p>Paying for advertising and sponsorship is normal. It isn't a violation when the links are qualified with rel="sponsored" or rel="nofollow".</p><a href="<?php echo $gd('crawling-indexing/qualify-outbound-links'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Put your keywords in the press release links."</p></div><div class="f"><span class="tag">Google says</span><p>Links with optimised anchor text in articles, guest posts or press releases distributed on other sites are listed as link spam.</p><a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Run a guest-posting campaign at scale."</p></div><div class="f"><span class="tag">Google says</span><p>Large-scale article marketing or guest-posting campaigns with keyword-rich anchor text links are listed as link spam.</p><a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Anchor text should be your exact keyword."</p></div><div class="f"><span class="tag">Google says</span><p>Good anchor text is descriptive, reasonably concise and relevant, written naturally, without keyword stuffing.</p><a href="<?php echo $gd('crawling-indexing/links-crawlable'); ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
    <p class="src">Source: Google, <a href="<?php echo $spam; ?>" rel="noopener" target="_blank">Spam policies for Google web search</a></p>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does a digital PR campaign run?</h2><p class="lede">From the pages you need to rank to the journalists who can help them.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Discover</h3><p>Target pages, competitors' links and coverage, and the beats of the journalists who matter.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Develop</h3><p>The story and the data behind it, fact-checked, then approved by you.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Pitch</h3><p>Short, beat-specific emails to a researched list, with one follow-up.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Verify</h3><p>Every piece of coverage logged, with its link, target page and link attribute checked.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Report &amp; reuse</h3><p>What landed, what it changed, and the next angle from what journalists responded to.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Link &amp; coverage audit</b>: your links and mentions against competitors', by target page.</li>
      <li><b>Campaign plan</b>: story angles, target pages and target outlets.</li>
      <li><b>Research &amp; data asset</b>: the findings, charts and methodology journalists need.</li>
      <li><b>Press materials</b>: release, pitches, expert quotes and visuals.</li>
      <li><b>Media list</b>: journalists and outlets chosen by beat and audience.</li>
      <li><b>Outreach</b>: personalised pitching and follow-up.</li>
      <li><b>Coverage log</b>: every placement with link status, attribute and target page.</li>
      <li><b>Monthly report</b>: coverage, links, referral traffic, rankings and AI citations.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Measurement&nbsp;<b>]</b></span><h2>How do we measure digital PR?</h2><p class="lede">By relevance and results, not by a raw count of links.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Relevant coverage</h3><p>Pieces in publications your buyers actually read, by outlet and topic.</p></div>
      <div class="metric"><h3>Referring domains</h3><p>New, relevant sites linking to you, and the share that are editorial.</p></div>
      <div class="metric"><h3>Links to target pages</h3><p>Links reaching the pages you need to rank, beyond the home page.</p></div>
      <div class="metric"><h3>Referral traffic &amp; leads</h3><p>Visits and conversions from coverage.</p></div>
      <div class="metric"><h3>Rankings &amp; brand search</h3><p>Movement for target pages and growth in searches for your name.</p></div>
      <div class="metric"><h3>AI citations</h3><p>Whether AI answers mention and cite you, and which sources they use.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Nobody honest can guarantee coverage.</h2>
      <p>Journalists decide what they write and what they link to. An agency that guarantees a number of links is either guessing or paying for placements, and paid links that pass ranking credit are exactly what Google's spam policies target. We guarantee the work: a story worth covering, pitched to the right people, with every result reported.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is digital PR for?</h2><p class="lede">Brands with expertise or data worth sharing, in markets where authority decides who ranks and who gets cited.</p></div>
    <ul class="inds8">
      <?php foreach (rl_pr_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Digital PR for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with digital PR?</h2><p class="lede">Coverage builds authority. These services make sure it lands on pages that can rank and get cited.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/enterprise-seo-strategy', 'Scale', 'Enterprise SEO Strategy', 'One SEO standard across teams, templates, releases and markets.'],
          ['services/ai-search-optimization', 'AI search', 'AI Search Optimization', 'Visibility and accurate recommendations across AI search.'],
          ['services/generative-engine-optimization', 'Citations', 'GEO', 'Content structured so AI engines can quote and cite it.'],
          ['services/llm-optimization', 'Entity level', 'LLM Optimization', 'One consistent description of your brand across the sources AI models learn from.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'The pages your coverage links to, produced as a system.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your Google and AI-search performance, including authority.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About digital PR and link building.</h2></div>
    <?php foreach (rl_pr_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Who links to you, and who links to your competitors?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your authority, links and AI-search visibility, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services'); ?>">All services</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
