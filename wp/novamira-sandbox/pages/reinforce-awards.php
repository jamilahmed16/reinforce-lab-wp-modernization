<?php
/**
 * Plugin Name: Reinforce Lab - Awards
 * Description: /awards/ (APPROVED - NEW URL, Jamil 4 Oct 2026, D-106). Provides [reinforce_awards]. Recognition you can check: every item links to the page that confirms it (F-023). Uses the shared kit (D-044). No hero animation. Schema: WebPage about the Organization, Organization award list, FAQPage.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_awards() { return is_page('awards') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }

/* Every item below is VERIFIED in claude/research/reputation-and-recognition-2026-10-04.md (F-023). Nothing goes here without a source link. */
function rl_awards_data() {
    $hn = 'https://hackernoon.com/startups-of-the-year-2024-winners-';
    return [
        'feature' => [
            'by' => 'HackerNoon · Startups of The Year', 'title' => 'Winner, Startups of The Year 2024 in Dhaka',
            'text' => 'Chosen by community vote among the startups nominated in Dhaka, in HackerNoon\'s yearly awards for startups in more than 4,200 cities.',
            'facts' => [['Year', '2024'], ['Announced', '24 Apr 2025'], ['Decided by', 'public vote']],
            'url' => $hn . 'asia', 'link' => 'See it on HackerNoon',
        ],
        'awards' => [
            ['DesignRush', 'Jun 2025', 'Best Digital Marketing Agencies of June 2025', 'Named by DesignRush among 31 agencies that use the best tools and AI to improve campaign results.', 'https://www.newsfilecorp.com/release/255349/DesignRush-Names-the-Best-Digital-Marketing-Agencies-of-June-2025', 'Read the DesignRush announcement'],
            ['HackerNoon', '2024', '11th in Marketing, worldwide', 'Placed 11th of about 8,000 marketing startups in Startups of The Year 2024, by public vote.', 'https://startups.hackernoon.com/industry/marketing', 'See the Marketing leaderboard'],
            ['HackerNoon', '2024', 'Two honourable mentions, Startups of The Year 2024', 'Creative Agency, among 7,500 startups in the Business industry, and Media Production, among 8,300 startups in the Media industry.', $hn . 'business', 'See the Business results'],
            ['GoodFirms', 'Oct 2026', 'Ranked 8th, Top SEO Agencies in Bangladesh', 'A directory ranking of 442 SEO agencies, updated by GoodFirms each month. Shown with the date it was checked.', 'https://www.goodfirms.co/seo-agencies/bangladesh', 'See the GoodFirms list'],
            ['GoodFirms', 'Oct 2026', 'Ranked 8th, Top Digital Marketing Companies in Bangladesh', 'A directory ranking of 166 firms, updated by GoodFirms each month. Shown with the date it was checked.', 'https://www.goodfirms.co/directory/country/top-digital-marketing-companies/bangladesh', 'See the GoodFirms list'],
            ['HackerNoon', 'Nov 2025', 'Startups of the Week', 'Featured as one of three startups of the week, from the Startups of The Year database.', 'https://hackernoon.com/meet-manc-sport-reinforce-lab-limited-and-klatch-technologies-hackernoon-startups-of-the-week', 'Read the feature'],
        ],
        /* WP Engine Agency Partner is confirmed (F-023 §7) but shows only once Jamil sends the partner page URL: every card must link to its source. */
        'partners' => array_values(array_filter([
            ['Semrush', 'Listed', 'Semrush Agency Partner', 'Listed in the Semrush Agency Partners directory, with offices in Dhaka and Katy, Texas.', 'https://agencies.semrush.com/reinforce-lab-ltd', 'See the listing'],
            get_option('rl_awards_wpengine_url') ? ['WP Engine', 'Partner', 'WP Engine Agency Partner', 'Member of WP Engine\'s partner programme for agencies that build and host WordPress sites, with a partner offer page for our clients.', get_option('rl_awards_wpengine_url'), 'See our WP Engine partner page'] : null,
        ])),
        'profiles' => [
            ['Clutch', 'https://clutch.co/profile/reinforce-lab'],
            ['GoodFirms', 'https://www.goodfirms.co/company/reinforce-lab-limited'],
            ['DesignRush', 'https://www.designrush.com/agency/profile/reinforce-lab-ltd'],
            ['HackerNoon', 'https://hackernoon.com/company/reinforcelablimited'],
        ],
        'press' => [
            ['2026-07-13', 'Jul 2026', 'Best SEO Service Company in Bangladesh: 25 Agencies Reviewed', 'Tech Cloud Ltd, a Dhaka agency, lists us 25th, noting "transparent communication" and our 4.6 Google rating.', 'Mention by another agency', 'https://techcloudltd.com/blog/best-seo-service-company-in-bangladesh/'],
            ['2026-02-08', 'Feb 2026', 'Top 20 SEO Companies in Bangladesh (2026)', 'Notionhive, a Dhaka agency, lists us 20th: "a reputation among the best emerging SEO agencies in Bangladesh for its structured approach to digital marketing and transparent project communication."', 'Mention by another agency', 'https://notionhive.com/blog/top-seo-companies-in-bangladesh'],
            ['2024-10-22', 'Oct 2024', 'Reinforce Lab expands across continents', 'Our announcement of the US office in Katy, Texas, distributed by EIN Presswire.', 'Our press release', 'https://www.einpresswire.com/article/753486845/reinforce-lab-a-rising-global-digital-marketing-leader-expanding-across-continents'],
            ['2018-09-07', 'Sep 2018', 'Interview with Jamil Ahmed', 'Onalytica asks our founder about his move from pharmaceutical brand marketing into business intelligence and digital marketing.', 'Interview', 'https://onalytica.com/blog/posts/interview-jamil-ahmed/'],
        ],
        'timeline' => [
            ['2018', 'Onalytica interview with our founder', 'Interview'],
            ['2024', 'Winner, HackerNoon Startups of The Year 2024 in Dhaka', 'Award, public vote'],
            ['2024', '11th of about 8,000 in Marketing, and honourable mentions in Creative Agency and Media Production, HackerNoon Startups of The Year 2024', 'Industry results, public vote'],
            ['2025', 'DesignRush, Best Digital Marketing Agencies of June 2025', 'Award, editorial list'],
            ['2025', 'HackerNoon Startups of the Week', 'Feature'],
            ['2026', 'Listed among the Top 20 SEO Companies in Bangladesh by Notionhive', 'Mention, February 2026'],
            ['2026', 'Listed among 25 SEO service companies in Bangladesh by Tech Cloud Ltd', 'Mention, July 2026'],
            ['2026', 'Ranked 8th of 442, GoodFirms Top SEO Agencies in Bangladesh, and 8th of 166 in Top Digital Marketing Companies', 'Directory rankings, October 2026'],
        ],
        'sources' => [
            ['HackerNoon: Startups of The Year 2024 winners, Asia', $hn . 'asia'],
            ['HackerNoon: Startups of The Year 2024 winners, Business', $hn . 'business'],
            ['HackerNoon: Startups of The Year 2024 winners, Media Industry', $hn . 'media-industry'],
            ['HackerNoon: Startups of The Year 2024, Marketing leaderboard', 'https://startups.hackernoon.com/industry/marketing'],
            ['DesignRush: Best Digital Marketing Agencies of June 2025', 'https://www.newsfilecorp.com/release/255349/DesignRush-Names-the-Best-Digital-Marketing-Agencies-of-June-2025'],
            ['GoodFirms: Top SEO Agencies in Bangladesh', 'https://www.goodfirms.co/seo-agencies/bangladesh'],
            ['GoodFirms: Top Digital Marketing Companies in Bangladesh', 'https://www.goodfirms.co/directory/country/top-digital-marketing-companies/bangladesh'],
            ['Semrush Agency Partners: Reinforce Lab', 'https://agencies.semrush.com/reinforce-lab-ltd'],
        ],
    ];
}

function rl_awards_faqs() {
    return [
        ['What awards has Reinforce Lab won?', 'Reinforce Lab won HackerNoon\'s Startups of The Year 2024 in Dhaka, Bangladesh, and was named among DesignRush\'s Best Digital Marketing Agencies of June 2025. It also placed 11th of about 8,000 in HackerNoon\'s 2024 Marketing category.'],
        ['Why are some awards not listed?', 'We only list recognition we can link to on the awarding body\'s own site, and we leave out awards sold with a publicity package.'],
        ['How can I check an award?', 'Each card links to the page that confirms it. Open the link and look for Reinforce Lab by name.'],
        ['Are the GoodFirms rankings fixed?', 'No. GoodFirms updates its rankings every month, so each one is shown with the month it was checked.'],
    ];
}

add_filter('body_class', function ($c) { if (rl_is_awards()) $c[] = 'rl-awards-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_awards(); });

/* ---------- schema ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_awards()) return $graph;
    $url = get_permalink(get_queried_object_id());
    $org = home_url('/#organization');
    $award = ['Startups of The Year 2024, winner in Dhaka, Bangladesh (HackerNoon)', 'Best Digital Marketing Agencies of June 2025 (DesignRush)', 'Startups of The Year 2024, 11th in Marketing worldwide (HackerNoon)', 'Startups of The Year 2024, honourable mentions in Creative Agency and Media Production (HackerNoon)'];
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if (in_array('WebPage', $t, true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) { $n['about'] = ['@id' => $org]; }
        if (in_array('Organization', $t, true)) { $n['award'] = $award; }
    }
    unset($n);
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_awards_faqs())];
    return $graph;
}, 20);

/* ---------- CSS ---------- */
add_action('wp_head', 'rl_awards_css', 22);
function rl_awards_css() {
    if (!rl_is_awards()) return; ?>
<style id="rl-awards-css">
body.rl-awards-page .fl-page-content,body.rl-awards-page .fl-content,body.rl-awards-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-awards{--ok:#3fa36b;--ok-line:rgba(63,163,107,.45);--amber:#d39b3a}
.rl-awards .ic{width:12px;height:12px;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:square}
.rl-awards .a-rule{margin:0;border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 22px}
.rl-awards .a-rule .cap{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 10px}
.rl-awards .a-rule ul{margin:0;padding:0;list-style:none;display:grid;gap:9px}
.rl-awards .a-rule li{display:grid;grid-template-columns:16px 1fr;gap:10px;font-size:15px;color:var(--ink);margin:0}
.rl-awards .a-rule li .ic{width:14px;height:14px;margin-top:5px;color:var(--ok)}
.rl-awards .a-tally{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2);margin:0}
.rl-awards .a-tally div{background:var(--bg-2);padding:16px 18px;margin:0}
.rl-awards .a-tally dt{font-family:var(--f-display);font-size:40px;line-height:1;color:var(--ink);font-weight:500;margin:0}
.rl-awards .a-tally dd{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin:6px 0 0}
.rl-awards .a-proof{display:inline-flex;align-items:center;gap:6px;font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;text-transform:uppercase;padding:2px 8px;border:1px solid var(--ok-line);color:var(--ok);justify-self:start}
.rl-awards .a-feature{display:grid;grid-template-columns:220px minmax(0,1fr);border:1px solid var(--red-line);background:radial-gradient(90% 140% at 0% 0%,rgba(153,0,0,.2),transparent 60%),var(--panel)}
.rl-awards .a-seal{display:grid;place-items:center;padding:26px;border-right:1px solid var(--red-line)}
.rl-awards .a-seal svg{width:150px;height:150px}
.rl-awards .a-feature .body{padding:24px 26px;display:grid;gap:10px;align-content:start}
.rl-awards .a-feature .by{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);margin:0}
.rl-awards .a-feature h3{font-size:clamp(24px,2.6vw,32px);margin:0}
.rl-awards .a-feature p{margin:0;font-size:15.5px;color:var(--ink-dim)}
.rl-awards .a-feature .btn{justify-self:start}
.rl-awards .a-facts{display:flex;flex-wrap:wrap;gap:8px 22px;align-items:center;font-family:var(--f-mono);font-size:12px;color:var(--ink-dim);border-top:1px solid var(--line);padding-top:12px}
.rl-awards .a-facts b{color:var(--ink);font-weight:500}
.rl-awards .a-cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-top:12px}
.rl-awards .a-cards.two{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-awards .a-card{border:1px solid var(--line-2);background:var(--bg-2);padding:18px 20px;display:grid;gap:8px;align-content:start}
.rl-awards .a-card .top{display:flex;justify-content:space-between;align-items:center;gap:10px}
.rl-awards .a-card .who{font-family:var(--f-mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--red-3)}
.rl-awards .a-card .yr{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint)}
.rl-awards .a-card h3{font-size:19px;line-height:1.12;margin:0}
.rl-awards .a-card p{margin:0;font-size:14.5px;color:var(--ink-dim)}
.rl-awards .a-src{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);justify-self:start}
.rl-awards .a-src:hover{color:var(--ink)}
.rl-awards .a-rating{display:grid;grid-template-columns:auto minmax(0,1fr);gap:14px;align-items:center}
.rl-awards .a-rating b{font-family:var(--f-display);font-size:44px;line-height:1;color:var(--ink);font-weight:500}
.rl-awards .a-stars{display:flex;gap:3px;margin-bottom:4px}
.rl-awards .a-stars i{width:14px;height:14px;background:var(--amber);clip-path:polygon(50% 0,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%)}
.rl-awards .a-stars i.h{background:linear-gradient(90deg,var(--amber) 60%,var(--line-2) 60%)}
.rl-awards .a-links{display:flex;flex-wrap:wrap;gap:8px}
.rl-awards .a-links a{font-family:var(--f-mono);font-size:12px;color:var(--ink);text-decoration:none;border:1px solid var(--line-2);padding:4px 10px}
.rl-awards .a-links a:hover{border-color:var(--red-line)}
.rl-awards .a-press{border:1px solid var(--line-2);margin:0;padding:0;list-style:none}
.rl-awards .a-pr{display:grid;grid-template-columns:110px minmax(0,1fr) auto;gap:16px;padding:16px 18px;border-top:1px solid var(--line);align-items:start;margin:0}
.rl-awards .a-pr:first-child{border-top:0}
.rl-awards .a-pr time{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);padding-top:3px}
.rl-awards .a-pr h3{font-family:var(--f-body);text-transform:none;letter-spacing:0;font-size:16px;font-weight:600;margin:0;line-height:1.4}
.rl-awards .a-pr h3 a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-awards .a-pr p{margin:4px 0 0;font-size:14.5px;color:var(--ink-dim)}
.rl-awards .a-pr .kind{font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:2px 8px;white-space:nowrap}
.rl-awards .a-note{margin:12px 0 0;border-left:3px solid var(--amber);padding:12px 16px;background:linear-gradient(90deg,rgba(211,155,58,.07),transparent);font-size:15px;color:var(--ink-dim)}
.rl-awards .a-note b{color:var(--ink)}
.rl-awards .a-tl{list-style:none;margin:0;padding:0;position:relative;max-width:900px}
.rl-awards .a-tl::before{content:"";position:absolute;left:58px;top:6px;bottom:6px;width:2px;background:var(--line-2)}
.rl-awards .a-tl li{display:grid;grid-template-columns:48px 22px minmax(0,1fr);gap:0 12px;padding:0 0 18px;margin:0;align-items:start}
.rl-awards .a-tl .y{font-family:var(--f-display);font-size:20px;color:var(--ink);text-align:right;line-height:1.1}
.rl-awards .a-tl .d{width:12px;height:12px;border:2px solid var(--red-3);background:var(--bg);margin:5px 0 0 5px;position:relative;z-index:1}
.rl-awards .a-tl p{margin:0;font-size:15.5px;color:var(--ink)}
.rl-awards .a-tl p span{display:block;font-size:13px;color:var(--ink-faint)}
.rl-awards .a-srcs{margin:0;padding-left:1.4em;font-size:14.5px;max-width:900px}
.rl-awards .a-srcs li{padding:5px 0;color:var(--ink-faint)}
.rl-awards .a-srcs a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
@media(max-width:1000px){.rl-awards .a-cards{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:760px){
  .rl-awards .a-tally{grid-template-columns:repeat(2,minmax(0,1fr))}
  .rl-awards .a-feature{grid-template-columns:1fr}.rl-awards .a-seal{border-right:0;border-bottom:1px solid var(--red-line);padding:18px}.rl-awards .a-seal svg{width:120px;height:120px}
  .rl-awards .a-cards,.rl-awards .a-cards.two{grid-template-columns:1fr}
  .rl-awards .a-pr{grid-template-columns:1fr;gap:6px}.rl-awards .a-pr .kind{justify-self:start}
}
</style>
<?php }

/* ---------- markup ---------- */
add_shortcode('reinforce_awards', 'rl_render_awards');
function rl_render_awards() {
    if (!rl_is_awards()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $a = rl_awards_data();
    $ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $proof = '<span class="a-proof">' . $ok . 'Confirmed at source</span>';
    $ext = ' rel="noopener" target="_blank"';
    $card = function ($c) use ($proof, $ext) { return '<div class="a-card"><div class="top"><span class="who">' . esc_html($c[0]) . '</span><span class="yr">' . esc_html($c[1]) . '</span></div><h3>' . esc_html($c[2]) . '</h3><p>' . esc_html($c[3]) . '</p>' . $proof . '<a class="a-src" href="' . esc_url($c[4]) . '"' . $ext . '>' . esc_html($c[5]) . '</a></div>'; };
    $f = $a['feature'];
    ob_start(); ?>
<div class="rl-page rl-awards">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('about-us'); ?>">About</a></li>
  <li><span aria-current="page">Awards</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Awards and recognition&nbsp;<b>]</b></span>
      <h1 class="h1">Recognition<br>you can <span class="r">check<br>for yourself.</span></h1>
      <p class="lede"><strong>Reinforce Lab won HackerNoon's Startups of The Year 2024 in Dhaka</strong> and was named among DesignRush's Best Digital Marketing Agencies of June 2025. Every award, ranking and partnership on this page links to the page that confirms it. If we cannot link to it, it is not here.</p>
      <div class="cta-row">
        <a class="btn p" href="#awards">See the awards <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('about-us'); ?>">About Reinforce Lab</a>
      </div>
    </div>
    <aside class="a-rule" aria-label="How we list recognition">
      <p class="cap">How we list recognition</p>
      <ul>
        <li><?php echo $ok; ?><span>Each item links to the awarding or listing body's own page.</span></li>
        <li><?php echo $ok; ?><span>We say how it was decided: a vote, a review, or a listing.</span></li>
        <li><?php echo $ok; ?><span>Our own press releases are marked as ours, not as press coverage.</span></li>
        <li><?php echo $ok; ?><span>We do not list awards that are sold with a publicity package.</span></li>
      </ul>
    </aside>
  </div>
</section>

<section class="band alt" aria-label="At a glance">
  <div class="wrap">
    <dl class="a-tally">
      <div><dt>2</dt><dd>Awards, independently confirmed</dd></div>
      <div><dt>11th</dt><dd>of about 8,000, HackerNoon Marketing 2024</dd></div>
      <div><dt>8th</dt><dd>of 442 SEO agencies, GoodFirms Bangladesh</dd></div>
      <div><dt>4.6</dt><dd>Google rating, 8 reviews</dd></div>
    </dl>
  </div>
</section>

<section id="awards">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Awards&nbsp;<b>]</b></span><h2>What has Reinforce Lab won?</h2></div>
    <article class="a-feature">
      <div class="a-seal" aria-hidden="true">
        <svg viewBox="0 0 160 160"><circle cx="80" cy="80" r="74" fill="none" stroke="#e23b3b" stroke-width="1.5"/><circle cx="80" cy="80" r="62" fill="none" stroke="rgba(226,59,59,.4)" stroke-dasharray="2 4"/><text x="80" y="58" text-anchor="middle" fill="#b8b0b1" font-family="IBM Plex Mono, monospace" font-size="9" letter-spacing="2">STARTUPS OF</text><text x="80" y="71" text-anchor="middle" fill="#b8b0b1" font-family="IBM Plex Mono, monospace" font-size="9" letter-spacing="2">THE YEAR</text><text x="80" y="104" text-anchor="middle" fill="#f2eeee" font-family="Oswald, sans-serif" font-size="34" font-weight="600">2024</text><text x="80" y="122" text-anchor="middle" fill="#e23b3b" font-family="IBM Plex Mono, monospace" font-size="9" letter-spacing="2">DHAKA WINNER</text></svg>
      </div>
      <div class="body">
        <p class="by"><?php echo esc_html($f['by']); ?></p>
        <h3><?php echo esc_html($f['title']); ?></h3>
        <p><?php echo esc_html($f['text']); ?></p>
        <div class="a-facts"><?php foreach ($f['facts'] as $x) echo '<span>' . esc_html($x[0]) . ' <b>' . esc_html($x[1]) . '</b></span>'; echo $proof; ?></div>
        <a class="btn g" href="<?php echo esc_url($f['url']); ?>"<?php echo $ext; ?>><?php echo esc_html($f['link']); ?> <span class="ar">&rarr;</span></a>
      </div>
    </article>
    <div class="a-cards"><?php foreach ($a['awards'] as $c) echo $card($c); ?></div>
  </div>
</section>

<section class="band alt" id="partners">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Partners&nbsp;<b>]</b></span><h2>Which partnerships does Reinforce Lab hold?</h2></div>
    <div class="a-cards<?php echo count($a['partners']) < 3 ? ' two' : ''; ?>"><?php foreach ($a['partners'] as $c) echo $card($c); ?></div>
  </div>
</section>

<section id="reviews">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Reviews&nbsp;<b>]</b></span><h2>Where can I read reviews of Reinforce Lab?</h2></div>
    <div class="a-cards two">
      <div class="a-card"><div class="top"><span class="who">Google</span><span class="yr">Dhaka office</span></div><div class="a-rating"><b>4.6</b><div><div class="a-stars" role="img" aria-label="4.6 out of 5"><i></i><i></i><i></i><i></i><i class="h"></i></div><p>From 8 Google reviews</p></div></div><a class="a-src" href="https://www.google.com/maps/search/?api=1&amp;query=Reinforce+Lab+Limited+Concord+Tower+Dhaka"<?php echo $ext; ?>>Read the reviews on Google</a></div>
      <div class="a-card"><div class="top"><span class="who">Directories</span><span class="yr">Profiles</span></div><h3>Find us on</h3><p>Reviews from clients on these sites are welcome.</p><div class="a-links"><?php foreach ($a['profiles'] as $p) echo '<a href="' . esc_url($p[1]) . '"' . $ext . '>' . esc_html($p[0]) . '</a>'; ?></div></div>
    </div>
  </div>
</section>

<section class="band alt" id="press">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Press&nbsp;<b>]</b></span><h2>Where has Reinforce Lab been mentioned?</h2></div>
    <ul class="a-press"><?php foreach ($a['press'] as $p) echo '<li class="a-pr"><time datetime="' . esc_attr($p[0]) . '">' . esc_html($p[1]) . '</time><div><h3><a href="' . esc_url($p[5]) . '"' . $ext . '>' . esc_html($p[2]) . '</a></h3><p>' . esc_html($p[3]) . '</p></div><span class="kind">' . esc_html($p[4]) . '</span></li>'; ?></ul>
    <p class="a-note"><b>About "As seen on" logos.</b> Our press releases are republished by news sites through wire services. That is not the same as those outlets writing about us, so we list the release itself rather than their logos.</p>
  </div>
</section>

<section id="timeline">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Timeline&nbsp;<b>]</b></span><h2>Recognition by year</h2></div>
    <ol class="a-tl"><?php foreach ($a['timeline'] as $t) echo '<li><span class="y">' . esc_html($t[0]) . '</span><span class="d" aria-hidden="true"></span><p>' . esc_html($t[1]) . '<span>' . esc_html($t[2]) . '</span></p></li>'; ?></ol>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About our awards.</h2></div>
    <?php foreach (rl_awards_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="sources">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Evidence&nbsp;<b>]</b></span><h2>Sources</h2></div>
    <ol class="a-srcs"><?php foreach ($a['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '"' . $ext . '>' . esc_html($s[0]) . '</a></li>'; ?></ol>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See what we would fix first on your site.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('about-us'); ?>">About Reinforce Lab</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
