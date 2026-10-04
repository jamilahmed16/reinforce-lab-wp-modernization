<?php
/**
 * Plugin Name: Reinforce Lab - Review post design
 * Description: The approved Review design (D-077, mockup claude/design-previews/blog-review-template-mockup.html). Lab test report: test conditions, verdict and score up front with buy it if / skip it if, article body, dated test log, weighted scorecard, pros and cons, one in-article service CTA, pricing plans with the tested plan marked, comparison with alternatives, final verdict, verdict card that stays in view (side card on desktop, bottom bar on phones). Third-party products only (D-076). reinforce-post.php hands Review posts to rl_review_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_review_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'review'; }
function rl_review_words() { return ['highly' => 'Highly recommended', 'recommended' => 'Recommended', 'limits' => 'Good, with limits', 'not' => 'Not recommended']; }

/* ---------- fields (Review only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'review']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_review', 'title' => 'Review (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_r_product', 'Product reviewed', 'text', ['instructions' => 'Third-party products only. Never our own services or products (D-076).']),
            $f('rl_r_kind', 'Kind of product', 'select', ['choices' => ['SoftwareApplication' => 'Software or app', 'Product' => 'Physical or other product', 'Service' => 'Service'], 'default_value' => 'SoftwareApplication']),
            $f('rl_r_version', 'Version tested', 'text'),
            $f('rl_r_period', 'Test period', 'text', ['instructions' => 'e.g. August to September 2026']),
            $f('rl_r_plan', 'Plan tested', 'text', ['instructions' => 'e.g. Pro. The pricing plan with this name is marked "Plan we tested".']),
            $f('rl_r_paid', 'We paid for it ourselves', 'true_false', ['ui' => 1, 'default_value' => 1, 'instructions' => 'Off = the vendor gave us access. The disclosure says so.']),
            $f('rl_r_setup', 'Test site or setup', 'text', ['instructions' => 'e.g. 12,000 URLs, WordPress']),
            $f('rl_r_affiliate', 'Contains affiliate links', 'true_false', ['ui' => 1, 'instructions' => 'Shows the disclosure and marks visit links as sponsored.']),
            $f('rl_r_word', 'Verdict word', 'select', ['choices' => rl_review_words(), 'allow_null' => 1]),
            $f('rl_r_verdict', 'Verdict', 'textarea', ['rows' => 3, 'instructions' => 'Two or three sentences.']),
            $f('rl_r_buy', 'Buy it if', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_r_skip', 'Skip it if', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_r_criteria', 'Scorecard criteria', 'textarea', ['rows' => 5, 'instructions' => 'One per line: Criterion | Weight in % | What it measures. Example: Accuracy | 30 | Issues that were real when checked by hand']),
            $f('rl_r_scores', 'Scores', 'text', ['instructions' => 'One score out of 10 per criterion, in order, separated by commas. The headline score is the weighted average.']),
            $f('rl_r_score', 'Score out of 10 (only if there are no criteria)', 'number', ['min' => 0, 'max' => 10, 'step' => 0.1]),
            $f('rl_r_log', 'Test log', 'textarea', ['rows' => 6, 'instructions' => 'One per line: YYYY-MM-DD | What we did | What happened | Measured result (optional). Start the line with * to mark a key finding.']),
            $f('rl_r_pros', 'What we liked', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_r_cons', 'What could be better', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_r_price', 'Price from', 'text', ['instructions' => 'As shown on the vendor site, e.g. $19 a month.']),
            $f('rl_r_price_date', 'Price checked on', 'date_picker', ['display_format' => 'j M Y', 'return_format' => 'Y-m-d']),
            $f('rl_r_trial', 'Free trial', 'text', ['instructions' => 'e.g. 14 days. Leave empty to hide.']),
            $f('rl_r_best', 'Best for', 'text'),
            $f('rl_r_plans', 'Pricing plans', 'textarea', ['rows' => 4, 'instructions' => 'One per line: Plan | Price | What you get. Example: Pro | $49 a month | Up to 100,000 URLs']),
            $f('rl_r_alts', 'Alternatives', 'textarea', ['rows' => 4, 'instructions' => 'One per line: Name | Best for | From | Extra column value | URL (URL optional)']),
            $f('rl_r_alt_col', 'Alternatives: extra column heading', 'text', ['instructions' => 'e.g. JavaScript pages. Leave empty for no extra column.']),
            $f('rl_r_alt_this', 'Alternatives: extra column value for this product', 'text'),
            $f('rl_r_url', 'Visit link', 'url'),
            $f('rl_r_button', 'Visit button text', 'text', ['instructions' => 'Empty = "Visit" plus the product name.']),
            $f('rl_r_final', 'Final verdict', 'textarea', ['rows' => 2, 'instructions' => 'One or two sentences at the end, above the visit button.']),
            $f('rl_r_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Shown after the pros and cons. Leave empty for none.']),
            $f('rl_r_cta_head', 'In-article CTA: headline', 'text'),
            $f('rl_r_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_r_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
        ],
    ]);
});

/* ---------- data ---------- */
function rl_review_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
function rl_review_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $crit = [];
    foreach (rl_review_rows(get_post_meta($id, 'rl_r_criteria', true), 2) as $r) { $w = (float) $r[1]; if ($w > 0) $crit[] = [$r[0], $w, $r[2] ?? '']; }
    $scores = [];
    foreach (preg_split('/\s*,\s*/', $m('rl_r_scores'), -1, PREG_SPLIT_NO_EMPTY) as $x) $scores[] = max(0, min(10, (float) $x));
    $score = null;
    if ($crit && count($scores) >= count($crit)) { $tw = array_sum(array_column($crit, 1)); $sum = 0; foreach ($crit as $k => $c) $sum += $scores[$k] * $c[1]; $score = round($sum / $tw, 1); }
    elseif ($m('rl_r_score') !== '') $score = round(max(0, min(10, (float) $m('rl_r_score'))), 1);
    $product = $m('rl_r_product');
    $pd = function_exists('rl_pt_date') ? rl_pt_date($m('rl_r_price_date')) : '';
    return $cache[$id] = [
        'product' => $product, 'kind' => in_array($m('rl_r_kind'), ['SoftwareApplication', 'Product', 'Service'], true) ? $m('rl_r_kind') : 'SoftwareApplication',
        'version' => $m('rl_r_version'), 'period' => $m('rl_r_period'), 'plan' => $m('rl_r_plan'), 'paid' => get_post_meta($id, 'rl_r_paid', true) !== '0', 'setup' => $m('rl_r_setup'),
        'aff' => (bool) get_post_meta($id, 'rl_r_affiliate', true), 'word' => rl_review_words()[$m('rl_r_word')] ?? '', 'verdict' => $m('rl_r_verdict'),
        'buy' => rl_post_lines(get_post_meta($id, 'rl_r_buy', true)), 'skip' => rl_post_lines(get_post_meta($id, 'rl_r_skip', true)),
        'crit' => $crit, 'scores' => $scores, 'score' => $score,
        'log' => rl_review_rows(get_post_meta($id, 'rl_r_log', true), 3),
        'pros' => rl_post_lines(get_post_meta($id, 'rl_r_pros', true)), 'cons' => rl_post_lines(get_post_meta($id, 'rl_r_cons', true)),
        'price' => $m('rl_r_price'), 'checked' => $pd ? date_i18n('j M Y', strtotime($pd)) : '', 'trial' => $m('rl_r_trial'), 'best' => $m('rl_r_best'),
        'plans' => rl_review_rows(get_post_meta($id, 'rl_r_plans', true), 2), 'alts' => rl_review_rows(get_post_meta($id, 'rl_r_alts', true), 2),
        'alt_col' => $m('rl_r_alt_col'), 'alt_this' => $m('rl_r_alt_this'),
        'url' => esc_url_raw($m('rl_r_url')), 'button' => $m('rl_r_button') ?: ($product !== '' ? 'Visit ' . $product : 'Visit site'), 'final' => $m('rl_r_final'),
    ];
}
function rl_review_num($x) { return number_format((float) $x, 1); }
function rl_review_pct($x) { return rtrim(rtrim(number_format((float) $x, 1), '0'), '.'); }
/* Never mark up a review of our own products or services (D-076). */
function rl_review_is_own($name) { return (bool) preg_match('/reinforce\s*lab|search authority (os|diagnostic)/i', $name); }

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_review_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $r = rl_review_data($id);
    $title = get_the_title($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $rel = $r['aff'] ? 'sponsored nofollow noopener' : 'noopener';
    $tw = array_sum(array_column($r['crit'], 1));
    $p = $r['product'];
    $h1 = ($p !== '' && stripos($title, $p) === 0) ? '<span class="pn">' . esc_html(mb_substr($title, 0, mb_strlen($p) + (mb_substr($title, mb_strlen($p), 1) === ':' ? 1 : 0))) . '</span>' . esc_html(mb_substr($title, mb_strlen($p) + (mb_substr($title, mb_strlen($p), 1) === ':' ? 1 : 0))) : esc_html($title);
    $cond = array_filter([['Version tested', $r['version']], ['Test period', $r['period']], ['Plan tested', $r['plan'] !== '' ? $r['plan'] . ($r['paid'] ? ', paid by us' : ', access from the vendor') : ''], ['Test site', $r['setup']], ['Price checked', $r['checked']]], function ($x) { return $x[1] !== ''; });
    $cta = null; $svc = (string) get_post_meta($id, 'rl_r_cta_service', true); $head = trim((string) get_post_meta($id, 'rl_r_cta_head', true));
    if ($svc !== '' && $head !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) {
        $cta = ['name' => rl_pt_services()[$svc], 'url' => $u($svc), 'head' => $head, 'sub' => trim((string) get_post_meta($id, 'rl_r_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_r_cta_button', true)) ?: 'See how it works'];
    }
    $diag = $u('search-authority-diagnostic');
    $ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $no = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M4 4l8 8M12 4l-8 8"/></svg>';
    $visit = function ($cls = 'go') use ($r, $rel) { return $r['url'] !== '' ? '<a class="' . $cls . '" href="' . esc_url($r['url']) . '" rel="' . esc_attr($rel) . '" target="_blank">' . esc_html($r['button']) . ' <span aria-hidden="true">&rarr;</span></a>' : ''; };
    $meter = '';
    if ($r['score'] !== null) { $full = (int) floor($r['score']); $frac = $r['score'] - $full; for ($i = 1; $i <= 10; $i++) $meter .= '<i' . ($i <= $full ? ' class="on"' : ($i === $full + 1 && $frac > 0.001 ? ' class="half"' : '')) . '></i>'; }
    $jump = array_filter(['log' => $r['log'] ? 'Test log' : '', 'scores' => $r['crit'] ? 'Scorecard' : '', 'pricing' => $r['plans'] ? 'Pricing' : '', 'alts' => $r['alts'] ? 'Alternatives' : '']);
    $card = $r['score'] !== null || $r['url'] !== '' || $r['price'] !== '';
    ?>
<div class="rl-page rl-post rl-review">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<header class="wrap r-hero">
  <div class="r-kicker"><span class="r-kind">Review</span><?php if ($c['cat']) echo '<a class="r-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
  <h1 class="r-h1"><?php echo $h1; ?></h1>
  <?php if ($standfirst !== '') { ?><p class="r-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
  <div class="r-by">
    <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
    <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
    <?php if ($d['updated'] !== '') { ?><span class="fresh">Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
  </div>
  <?php if ($cond) { ?>
  <dl class="r-cond c<?php echo count($cond); ?>" aria-label="Test conditions"><?php foreach ($cond as $x) echo '<div><dt>' . esc_html($x[0]) . '</dt><dd>' . esc_html($x[1]) . '</dd></div>'; ?></dl>
  <?php } ?>
  <p class="r-disc<?php echo $cond ? ' under' : ''; ?>"><b>Disclosure:</b> <?php echo $r['paid'] ? 'we paid for our own access.' : 'the vendor gave us free access for this test, and did not see the review before it was published.'; ?><?php echo $r['aff'] ? ' Some links are affiliate links; if you buy through them we may earn a commission at no extra cost to you. It does not change the score.' : ' We earn nothing if you buy.'; ?></p>

  <?php if ($r['score'] !== null || $r['verdict'] !== '' || $r['buy'] || $r['skip']) { ?>
  <section class="r-verdict<?php echo $r['score'] === null ? ' noscore' : ''; ?>" aria-label="Our verdict">
    <?php if ($r['score'] !== null) { ?>
    <div class="score"><span class="lb">Our score</span><span class="big"><?php echo esc_html(rl_review_num($r['score'])); ?><small>/ 10</small></span><div class="meter" aria-hidden="true"><?php echo $meter; ?></div><?php if ($r['word'] !== '') { ?><span class="word"><?php echo esc_html($r['word']); ?></span><?php } ?></div>
    <?php } ?>
    <?php if ($r['verdict'] !== '') { ?><div class="vtext"><p class="lb">The verdict</p><p class="v"><?php echo esc_html($r['verdict']); ?></p></div><?php } ?>
    <?php if ($r['buy'] || $r['skip']) { ?>
    <div class="bs">
      <?php if ($r['buy']) { ?><div class="buy"><p class="h"><?php echo $ok; ?>Buy it if</p><ul><?php foreach ($r['buy'] as $x) echo '<li>' . esc_html($x) . '</li>'; ?></ul></div><?php } ?>
      <?php if ($r['skip']) { ?><div class="skip"><p class="h"><?php echo $no; ?>Skip it if</p><ul><?php foreach ($r['skip'] as $x) echo '<li>' . esc_html($x) . '</li>'; ?></ul></div><?php } ?>
    </div>
    <?php } ?>
  </section>
  <?php } ?>
</header>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap r-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="r-main<?php echo $card ? '' : ' nocard'; ?>">
    <article class="r-text">
      <?php if ($d['answer'] !== '') { ?><div class="r-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
      <?php if ($d['takeaways']) { ?><div class="r-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . sprintf('%02d', $i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>
      <?php if (trim($c['body']) !== '') echo '<div class="r-prose">' . $c['body'] . '</div>'; ?>

      <?php if ($r['log']) { ?>
      <section class="sec" id="log" aria-labelledby="log-h"><div class="sec-h"><span>Test log</span><h2 id="log-h">What happened when we used it</h2></div>
        <ol class="r-log"><?php foreach ($r['log'] as $l) {
            $key = strpos($l[0], '*') === 0; $dt = function_exists('rl_pt_date') ? rl_pt_date(ltrim($l[0], '* ')) : '';
            echo '<li' . ($key ? ' class="key"' : '') . '><time' . ($dt ? ' datetime="' . esc_attr($dt) . '"' : '') . '>' . esc_html($dt ? date_i18n('j M Y', strtotime($dt)) : ltrim($l[0], '* ')) . '</time><span class="dot" aria-hidden="true"></span><div><h3>' . esc_html($l[1]) . '</h3><p>' . esc_html($l[2]) . '</p>' . (!empty($l[3]) ? '<span class="m">' . esc_html($l[3]) . '</span>' : '') . '</div></li>';
        } ?></ol>
      </section>
      <?php } ?>

      <?php if ($r['crit'] && count($r['scores']) >= count($r['crit'])) { ?>
      <section class="sec" id="scores" aria-labelledby="sc-h"><div class="sec-h"><span>Scorecard</span><h2 id="sc-h">How it scored</h2></div>
        <div class="scard">
          <?php foreach ($r['crit'] as $k => $cr) echo '<div class="srow"><span class="c">' . esc_html($cr[0]) . ' <em class="w">' . esc_html(rl_review_pct($cr[1] / $tw * 100)) . '%</em>' . ($cr[2] !== '' ? '<small>' . esc_html($cr[2]) . '</small>' : '') . '</span><span class="bar" aria-hidden="true"><i style="width:' . esc_attr($r['scores'][$k] * 10) . '%"></i></span><b>' . esc_html(rl_review_num($r['scores'][$k])) . '</b></div>'; ?>
          <div class="stotal"><span>Weighted score</span><b><?php echo esc_html(rl_review_num($r['score'])); ?> / 10</b></div>
        </div>
      </section>
      <?php } ?>

      <?php if ($r['pros'] || $r['cons']) { ?>
      <section class="sec" id="proscons" aria-labelledby="pc-h"><div class="sec-h"><span>In short</span><h2 id="pc-h">Pros and cons</h2></div>
        <div class="pc">
          <?php if ($r['pros']) { ?><div class="pros"><p class="h">What we liked</p><ul><?php foreach ($r['pros'] as $x) echo '<li>' . $ok . '<span>' . esc_html($x) . '</span></li>'; ?></ul></div><?php } ?>
          <?php if ($r['cons']) { ?><div class="cons"><p class="h">What could be better</p><ul><?php foreach ($r['cons'] as $x) echo '<li>' . $no . '<span>' . esc_html($x) . '</span></li>'; ?></ul></div><?php } ?>
        </div>
      </section>
      <?php } ?>

      <?php if ($cta) { ?>
      <aside class="r-icta" aria-label="Reinforce Lab service">
        <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
        <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
      </aside>
      <?php } ?>

      <?php if ($r['plans']) { ?>
      <section class="sec" id="pricing" aria-labelledby="pr-h"><div class="sec-h"><span>Pricing</span><h2 id="pr-h">Plans and what they cost</h2></div>
        <div class="plans n<?php echo min(4, count($r['plans'])); ?>"><?php foreach ($r['plans'] as $pl) {
            $tested = $r['plan'] !== '' && stripos($r['plan'], $pl[0]) === 0;
            echo '<div class="plan' . ($tested ? ' tested' : '') . '">' . ($tested ? '<span class="tg">Plan we tested</span>' : '') . '<h3>' . esc_html($pl[0]) . '</h3><p class="pr">' . esc_html($pl[1]) . '</p>' . (!empty($pl[2]) ? '<p>' . esc_html($pl[2]) . '</p>' : '') . '</div>';
        } ?></div>
        <p class="pnote"><?php echo $r['checked'] ? 'Prices from the vendor site, checked ' . esc_html($r['checked']) . '. ' : ''; ?>Prices change; check before you buy.</p>
      </section>
      <?php } ?>

      <?php if ($r['alts']) { ?>
      <section class="sec" id="alts" aria-labelledby="al-h"><div class="sec-h"><span>Alternatives</span><h2 id="al-h">How it compares</h2></div>
        <div class="tw"><table class="r-table">
          <thead><tr><th scope="col">Name</th><th scope="col">Best for</th><th scope="col">From</th><?php if ($r['alt_col'] !== '') echo '<th scope="col">' . esc_html($r['alt_col']) . '</th>'; ?></tr></thead>
          <tbody>
            <tr class="this"><th scope="row"><?php echo esc_html($p); ?><span class="tg2">This review</span></th><td><?php echo esc_html($r['best']); ?></td><td class="num"><?php echo esc_html($r['price']); ?></td><?php if ($r['alt_col'] !== '') echo '<td>' . esc_html($r['alt_this']) . '</td>'; ?></tr>
            <?php foreach ($r['alts'] as $a) { $au = esc_url($a[4] ?? ''); ?>
            <tr><th scope="row"><?php echo $au ? '<a href="' . $au . '" rel="noopener" target="_blank">' . esc_html($a[0]) . '</a>' : esc_html($a[0]); ?></th><td><?php echo esc_html($a[1] ?? ''); ?></td><td class="num"><?php echo esc_html($a[2] ?? ''); ?></td><?php if ($r['alt_col'] !== '') echo '<td>' . esc_html($a[3] ?? '') . '</td>'; ?></tr>
            <?php } ?>
          </tbody>
        </table></div>
      </section>
      <?php } ?>

      <?php if ($r['final'] !== '' || $r['score'] !== null) { ?>
      <section class="r-final<?php echo $r['score'] === null ? ' noscore' : ''; ?>" aria-label="Final verdict">
        <?php if ($r['score'] !== null) { ?><div class="fs"><?php echo esc_html(rl_review_num($r['score'])); ?><small>out of 10</small></div><?php } ?>
        <div><h2>Final verdict<?php echo $r['word'] !== '' ? ': ' . esc_html(mb_strtolower($r['word'])) : ''; ?></h2><?php if ($r['final'] !== '') echo '<p>' . esc_html($r['final']) . '</p>'; ?></div>
        <?php echo $visit(); ?>
      </section>
      <?php } ?>
    </article>

    <?php if ($card) { ?>
    <aside class="r-card" aria-label="Verdict at a glance">
      <div class="top"><span class="nm"><?php echo esc_html($p); ?><?php if ($r['version'] !== '') echo '<small>Version ' . esc_html($r['version']) . '</small>'; ?></span><?php if ($r['score'] !== null) { ?><span class="sc"><?php echo esc_html(rl_review_num($r['score'])); ?><small>/10</small></span><?php } ?></div>
      <?php $rows = array_filter([['Verdict', $r['word']], ['Price from', $r['price']], ['Free trial', $r['trial']], ['Best for', $r['best']]], function ($x) { return $x[1] !== ''; }); if ($rows) { ?>
      <dl><?php foreach ($rows as $x) echo '<div><dt>' . esc_html($x[0]) . '</dt><dd>' . esc_html($x[1]) . '</dd></div>'; ?></dl>
      <?php } ?>
      <?php if ($r['url'] !== '' || $r['checked']) { ?><div class="acts"><?php echo $visit(); ?><?php if ($r['checked'] && $r['price'] !== '') { ?><span class="chk">Price checked <?php echo esc_html($r['checked']); ?></span><?php } ?></div><?php } ?>
      <?php if ($jump) { ?><nav class="jump" aria-label="In this review"><?php foreach ($jump as $k => $l) echo '<a href="#' . esc_attr($k) . '">' . esc_html($l) . '</a>'; ?></nav><?php } ?>
    </aside>
    <?php } ?>
  </div>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <section class="r-back" aria-label="Questions and sources">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="r-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </section>
  <?php } ?>

  <aside class="r-author" aria-label="About the author">
    <span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span>
    <div>
      <p class="nm"><?php echo esc_html($c['aname']); ?></p>
      <?php if ($c['founder']) { ?>
      <p class="role"><?php echo esc_html($c['founder']['job']); ?>, Reinforce Lab</p>
      <p><?php echo $c['bio'] !== '' ? esc_html($c['bio']) : 'Pharmacist, SEO and AI search consultant, and Semrush Ambassador. Jamil builds AI Growth Systems for businesses using AI automation, AI Search Optimization, SEO and intelligent workflows.'; ?></p>
      <div class="links"><a href="<?php echo $c['about']; ?>#founder">About Jamil</a><a href="<?php echo esc_url($c['founder']['linkedin']); ?>" rel="noopener" target="_blank">LinkedIn</a></div>
      <?php } elseif ($c['bio'] !== '') { ?><p><?php echo esc_html($c['bio']); ?></p><?php } ?>
    </div>
  </aside>
</div>

<?php
    $rq = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true, 'category__in' => $c['cat'] ? [$c['cat']->term_id] : []]);
    if ($rq->have_posts()) { ?>
<section class="band alt rel" id="related"><div class="wrap"><div class="head"><span class="ey"><b>[</b>&nbsp;Keep reading&nbsp;<b>]</b></span><h2>Related articles</h2></div><ul class="posts">
<?php while ($rq->have_posts()) { $rq->the_post(); $rd = rl_post_data(get_the_ID()); ?>
  <li class="post"><span class="m"><?php echo esc_html($rd['type_label']); ?> · <?php echo esc_html(get_the_date('j M Y')); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read: ' . get_the_title()); ?>">Read article &rarr;</a></li>
<?php } wp_reset_postdata(); ?>
</ul></div></section>
<?php } ?>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See where your search visibility stands.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility in Google and AI answers, and shows what to fix first.</p>
      <div class="cta-row"><a class="btn p" href="<?php echo esc_url($diag); ?>">Get your free diagnostic <span class="ar">&rarr;</span></a><a class="btn g" href="<?php echo esc_url($c['blog_url']); ?>">More articles</a></div>
    </div>
  </div>
</section>

<?php if ($card) { ?>
<div class="r-mbar" aria-label="Verdict at a glance"><div><?php if ($r['score'] !== null) { ?><span class="s"><?php echo esc_html(rl_review_num($r['score'])); ?><small> / 10</small></span><br><?php } ?><span class="n"><?php echo esc_html($p . ($r['price'] !== '' ? ' · from ' . $r['price'] : '')); ?></span></div><?php echo $visit(); ?></div>
<?php } ?>
</div>
<?php
}

/* ---------- body class, so the phone bar does not cover the footer ---------- */
add_filter('body_class', function ($cl) { if (rl_is_review_view()) $cl[] = 'rl-review-page'; return $cl; });

/* ---------- schema: Review of a third-party product (never our own, D-076) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_review_view()) return $graph;
    $id = get_queried_object_id(); $url = get_permalink($id); $r = rl_review_data($id);
    if ($r['product'] === '' || $r['score'] === null || rl_review_is_own($r['product'])) return $graph;
    $item = ['@type' => $r['kind'], 'name' => $r['product']];
    if ($r['kind'] === 'SoftwareApplication') { $item['applicationCategory'] = 'BusinessApplication'; if ($r['version'] !== '') $item['softwareVersion'] = $r['version']; }
    $node = ['@type' => 'Review', '@id' => $url . '#review', 'name' => get_the_title($id), 'itemReviewed' => $item,
        'reviewRating' => ['@type' => 'Rating', 'ratingValue' => $r['score'], 'bestRating' => 10, 'worstRating' => 0],
        'author' => ['@id' => rl_person_schema_id(get_post_field('post_author', $id))], 'publisher' => ['@id' => home_url('/#organization')],
        'datePublished' => get_the_date('c', $id), 'mainEntityOfPage' => ['@id' => $url]];
    if ($r['verdict'] !== '') $node['reviewBody'] = $r['verdict'];
    $li = function ($xs) { return ['@type' => 'ItemList', 'itemListElement' => array_map(function ($x, $i) { return ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $x]; }, $xs, array_keys($xs))]; };
    if ($r['pros']) $node['positiveNotes'] = $li($r['pros']);
    if ($r['cons']) $node['negativeNotes'] = $li($r['cons']);
    $graph[] = $node;
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_review_view()) return; ?>
<style id="rl-review-css">
.rl-review{color:var(--ink-dim);--ok:#3fa36b}
.rl-review h1,.rl-review h2,.rl-review h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-review .ic{width:14px;height:14px;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:square}
.rl-review .r-hero{padding-block:clamp(24px,4vw,40px) 0}
.rl-review .r-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px}
.rl-review .r-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-review .r-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-review .r-h1{font-size:clamp(34px,4.8vw,62px);line-height:1;max-width:980px;margin:0}
.rl-review .r-h1 .pn{color:var(--red-3)}
.rl-review .r-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;max-width:680px;margin:18px 0 0}
.rl-review .r-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-review .r-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-review .r-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-review .r-by b{color:var(--ink-dim);font-weight:500}
.rl-review .r-by .fresh,.rl-review .r-by .fresh b{color:var(--ok)}
.rl-review .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-review .r-cond{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));margin:28px 0 0;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-review .r-cond.c4{grid-template-columns:repeat(4,minmax(0,1fr))}
.rl-review .r-cond.c3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-review .r-cond.c2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-review .r-cond.c1{grid-template-columns:minmax(0,1fr)}
.rl-review .r-cond div{padding:12px 16px;border-right:1px dashed var(--line-2);min-width:0}
.rl-review .r-cond div:last-child{border-right:0}
.rl-review .r-cond dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-review .r-cond dd{margin:3px 0 0;color:var(--ink);font-weight:500;font-size:14.5px;overflow-wrap:anywhere}
.rl-review .r-disc{font-size:13.5px;color:var(--ink-faint);border:1px dashed var(--line-2);padding:10px 16px;margin:28px 0 0}
.rl-review .r-disc.under{border-top:0;margin-top:0}
.rl-review .r-disc b{color:var(--ink-dim);font-weight:500}
.rl-review .r-verdict{display:grid;grid-template-columns:240px minmax(0,1fr);border:1px solid var(--red-line);background:radial-gradient(80% 140% at 0% 0%,rgba(153,0,0,.22),transparent 60%),var(--panel);margin:28px 0 0;padding:0}
.rl-review .r-verdict.noscore{grid-template-columns:minmax(0,1fr)}
.rl-review .score{border-right:1px solid var(--red-line);padding:24px;display:flex;flex-direction:column;justify-content:center;gap:10px;background:var(--bg-2)}
.rl-review .score .lb,.rl-review .vtext .lb{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0}
.rl-review .score .big{font-family:var(--f-display);font-weight:600;font-size:88px;line-height:.85;color:var(--ink)}
.rl-review .score .big small{font-family:var(--f-mono);font-size:14px;font-weight:400;color:var(--ink-faint);margin-left:4px}
.rl-review .meter{display:grid;grid-template-columns:repeat(10,1fr);gap:3px}
.rl-review .meter i{height:8px;background:var(--line-2)}
.rl-review .meter i.on{background:var(--red-3)}
.rl-review .meter i.half{background:linear-gradient(90deg,var(--red-3) 50%,var(--line-2) 50%)}
.rl-review .score .word{font-family:var(--f-display);text-transform:uppercase;letter-spacing:.06em;color:var(--ink);font-size:17px}
.rl-review .vtext{padding:24px 28px;min-width:0}
.rl-review .vtext .lb{margin-bottom:10px}
.rl-review .vtext p.v{margin:0;color:var(--ink);font-size:19px;line-height:1.6}
.rl-review .bs{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border-top:1px solid var(--red-line);grid-column:1/-1}
.rl-review .bs>div{background:var(--panel);padding:18px 22px}
.rl-review .bs .h{display:flex;align-items:center;gap:8px;font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;margin:0 0 10px}
.rl-review .bs .buy .h{color:var(--ok)}
.rl-review .bs .skip .h{color:var(--red-3)}
.rl-review .bs ul,.rl-review .pc ul{list-style:none;margin:0;padding:0}
.rl-review .bs li{padding:6px 0;margin:0;border-top:1px solid var(--line);font-size:15px}
.rl-review .bs li:first-child{border-top:0}
.rl-review .r-feat{margin:28px auto 0}
.rl-review .r-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-review .r-main{display:grid;grid-template-columns:minmax(0,780px) minmax(0,1fr);gap:clamp(30px,5vw,64px);padding-block:clamp(36px,5vw,56px) 20px;align-items:start}
.rl-review .r-main.nocard{grid-template-columns:minmax(0,780px)}
.rl-review .r-text{min-width:0}
.rl-review .r-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-review .r-answer .t,.rl-review .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-review .r-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-review .r-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:28px}
.rl-review .r-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-review .r-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-review .r-prose>*{margin:0 0 1.1em}
.rl-review .r-prose p,.rl-review .r-prose li{font-size:17.5px;line-height:1.75}
.rl-review .r-prose h2{font-size:clamp(24px,2.8vw,30px);margin:1.8em 0 .6em;scroll-margin-top:110px}
.rl-review .r-prose h2:first-child{margin-top:0}
.rl-review .r-prose h3{font-size:21px;margin:1.4em 0 .5em;scroll-margin-top:110px}
.rl-review .r-prose strong{color:var(--ink);font-weight:600}
.rl-review .r-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-review .r-prose ul,.rl-review .r-prose ol{padding-left:1.2em}
.rl-review .r-prose li::marker{color:var(--red-3)}
.rl-review .r-prose figure:not(.wp-block-table){margin:22px 0;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-review .r-prose figure:not(.wp-block-table)::before{content:"";display:block;height:27px;border-bottom:1px solid var(--line);background-image:linear-gradient(var(--line-2),var(--line-2)),linear-gradient(var(--line-2),var(--line-2)),linear-gradient(var(--line-2),var(--line-2));background-size:8px 8px;background-repeat:no-repeat;background-position:12px 9px,26px 9px,40px 9px}
.rl-review .r-prose figure img{display:block;width:100%;height:auto}
.rl-review .r-prose figcaption{text-align:left;font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);padding:10px 12px;border-top:1px solid var(--line);margin:0}
.rl-review .r-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-review .r-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-review .r-prose th,.rl-review .r-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-review .sec{scroll-margin-top:96px;padding:0}
.rl-review .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px}
.rl-review .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-review .r-log{list-style:none;margin:0;padding:0;position:relative}
.rl-review .r-log::before{content:"";position:absolute;left:112px;top:8px;bottom:8px;width:1px;background:var(--line-2)}
.rl-review .r-log li{display:grid;grid-template-columns:100px 24px minmax(0,1fr);gap:0 12px;padding:0 0 22px;margin:0}
.rl-review .r-log time{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);padding-top:2px;text-align:right}
.rl-review .r-log .dot{width:11px;height:11px;margin:6px 0 0 1px;background:var(--bg);border:2px solid var(--red-3);position:relative;z-index:1}
.rl-review .r-log li.key .dot{background:var(--red-3)}
.rl-review .r-log h3{font-family:var(--f-body);text-transform:none;font-size:16.5px;font-weight:600;letter-spacing:0;margin:0 0 4px;line-height:1.35}
.rl-review .r-log p{margin:0;font-size:15.5px}
.rl-review .r-log .m{display:inline-block;font-family:var(--f-mono);font-size:11.5px;color:var(--ink);background:var(--panel-2,var(--panel));border:1px solid var(--line-2);padding:1px 7px;margin-top:6px}
.rl-review .scard{border:1px solid var(--line-2);background:var(--bg-2)}
.rl-review .srow{display:grid;grid-template-columns:minmax(0,1.1fr) minmax(0,1.6fr) 44px;gap:16px;align-items:center;padding:14px 18px;border-top:1px solid var(--line)}
.rl-review .srow:first-child{border-top:0}
.rl-review .srow .c{color:var(--ink);font-size:15px}
.rl-review .srow .c .w{font-style:normal;font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint);margin-left:6px}
.rl-review .srow .c small{display:block;font-size:13px;color:var(--ink-faint);margin-top:2px}
.rl-review .srow .bar{height:6px;background:var(--line-2)}
.rl-review .srow .bar i{display:block;height:100%;background:linear-gradient(90deg,var(--red),var(--red-3))}
.rl-review .srow b{font-family:var(--f-mono);font-weight:500;color:var(--ink);text-align:right;font-variant-numeric:tabular-nums}
.rl-review .stotal{display:flex;justify-content:space-between;align-items:baseline;padding:14px 18px;border-top:1px solid var(--red-line);background:var(--panel)}
.rl-review .stotal span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-review .stotal b{font-family:var(--f-display);font-size:26px;color:var(--ink);font-weight:500}
.rl-review .pc{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-review .pc>div{background:var(--panel);padding:18px 20px}
.rl-review .pc .h{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;margin:0 0 8px}
.rl-review .pros .h{color:var(--ok)}
.rl-review .cons .h{color:var(--red-3)}
.rl-review .pc li{display:grid;grid-template-columns:18px 1fr;gap:8px;padding:8px 0;margin:0;border-top:1px solid var(--line);font-size:15px}
.rl-review .pc li:first-child{border-top:0}
.rl-review .pros .ic{color:var(--ok);margin-top:4px}
.rl-review .cons .ic{color:var(--red-3);margin-top:4px}
.rl-review .r-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-review .r-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-review .r-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-review .r-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-review .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-review .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-review .go2:hover{background:var(--red-2)}
.rl-review .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-review .plans{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-review .plans.n1{grid-template-columns:minmax(0,1fr)}
.rl-review .plans.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-review .plans.n4{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-review .plan{background:var(--bg-2);padding:20px;display:grid;gap:6px;align-content:start}
.rl-review .plan.tested{background:var(--panel);box-shadow:inset 0 3px 0 var(--red-3)}
.rl-review .plan .tg{justify-self:start;font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:#fff;background:var(--red);padding:2px 7px}
.rl-review .plan h3{font-size:19px;margin:0}
.rl-review .plan .pr{font-family:var(--f-display);font-size:26px;color:var(--ink);font-weight:500;line-height:1.15;margin:0}
.rl-review .plan p{margin:0;font-size:14.5px}
.rl-review .pnote{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);margin:8px 0 0}
.rl-review .tw{overflow-x:auto;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-review .r-table{width:100%;border-collapse:collapse;min-width:600px;font-size:14.5px;margin:0}
.rl-review .r-table th,.rl-review .r-table td{padding:12px 14px;text-align:left;border:0;border-bottom:1px solid var(--line);vertical-align:top;background:none}
.rl-review .r-table thead th{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);font-weight:500;background:var(--panel)}
.rl-review .r-table tbody th{color:var(--ink);font-family:var(--f-body);font-size:15px;font-weight:600;letter-spacing:0;text-transform:none}
.rl-review .r-table tbody th a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-review .r-table tbody tr:last-child>*{border-bottom:0}
.rl-review .r-table tr.this{background:linear-gradient(90deg,rgba(153,0,0,.2),transparent 70%)}
.rl-review .r-table tr.this th{box-shadow:inset 3px 0 0 var(--red-2)}
.rl-review .r-table td.num{font-family:var(--f-mono);color:var(--ink);white-space:nowrap}
.rl-review .tg2{font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint);margin-left:8px;font-weight:500;white-space:nowrap}
.rl-review .go{display:block;text-align:center;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;transition:background .15s}
.rl-review .go:hover{background:var(--red-2)}
.rl-review .r-final{border:1px solid var(--red-line);background:var(--panel);padding:24px 26px;margin:46px 0 0;display:grid;grid-template-columns:auto minmax(0,1fr) auto;gap:20px;align-items:center}
.rl-review .r-final.noscore{grid-template-columns:minmax(0,1fr) auto}
.rl-review .r-final .fs{font-family:var(--f-display);font-size:56px;color:var(--ink);line-height:.9}
.rl-review .r-final .fs small{display:block;font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint);letter-spacing:.12em;margin-top:6px;text-transform:uppercase}
.rl-review .r-final h2{font-size:22px;margin:0 0 6px}
.rl-review .r-final p{margin:0;font-size:15.5px}
.rl-review .r-card{position:sticky;top:96px;border:1px solid var(--line-2);background:var(--panel);align-self:start}
.rl-review .r-card .top{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:16px 18px;border-bottom:1px solid var(--line-2)}
.rl-review .r-card .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);line-height:1}
.rl-review .r-card .nm small{display:block;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;color:var(--ink-faint);margin-top:6px}
.rl-review .r-card .sc{font-family:var(--f-display);font-size:38px;color:var(--ink);line-height:1;white-space:nowrap}
.rl-review .r-card .sc small{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint)}
.rl-review .r-card dl{margin:0;padding:6px 18px}
.rl-review .r-card dl div{display:flex;justify-content:space-between;gap:12px;padding:9px 0;border-top:1px solid var(--line);font-size:14px}
.rl-review .r-card dl div:first-child{border-top:0}
.rl-review .r-card dt{color:var(--ink-faint)}
.rl-review .r-card dd{margin:0;color:var(--ink);text-align:right}
.rl-review .r-card .acts{padding:14px 18px 18px;display:grid;gap:8px}
.rl-review .r-card .chk{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);text-align:center}
.rl-review .r-card .jump{display:flex;flex-wrap:wrap;gap:6px 14px;padding:12px 18px;border-top:1px solid var(--line-2);font-size:13px}
.rl-review .r-card .jump a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-review .r-back{border-top:1px solid var(--line-2);margin-top:30px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-review .r-back .sec-h{margin-top:0}
.rl-review .r-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-review .r-src li{padding:6px 0;color:var(--ink-faint)}
.rl-review .r-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-review .r-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-review .r-author .av{width:72px;height:72px;font-size:28px}
.rl-review .r-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-review .r-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-review .r-author p{margin:0 0 8px;font-size:15px}
.rl-review .r-author .links{display:flex;gap:18px;font-size:14px}
.rl-review .r-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-review .r-mbar{display:none}
@media(max-width:1000px){
  .rl-review .r-main{grid-template-columns:minmax(0,1fr)}
  .rl-review .r-card{display:none}
  .rl-review .r-cond,.rl-review .r-cond.c4{grid-template-columns:repeat(3,minmax(0,1fr))}
  .rl-review .r-cond div:nth-child(3n){border-right:0}
  .rl-review .r-cond div:nth-child(n+4){border-top:1px dashed var(--line-2)}
  .rl-review .r-mbar{display:flex;position:fixed;left:0;right:0;bottom:0;z-index:40;gap:12px;align-items:center;justify-content:space-between;padding:10px var(--gutter,16px) calc(10px + env(safe-area-inset-bottom,0px));background:rgba(18,16,17,.96);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-top:1px solid var(--line-2)}
  .rl-review .r-mbar .s{font-family:var(--f-display);font-size:24px;color:var(--ink);line-height:1}
  .rl-review .r-mbar .s small{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint)}
  .rl-review .r-mbar .n{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:.08em}
  .rl-review .r-mbar .go{padding:10px 14px;font-size:13px;flex:none}
  body.rl-review-page{padding-bottom:72px}
}
@media(max-width:700px){
  .rl-review .r-cond,.rl-review .r-cond.c4,.rl-review .r-cond.c3{grid-template-columns:1fr 1fr}
  .rl-review .r-cond div{border-right:1px dashed var(--line-2)!important;border-top:1px dashed var(--line-2)}
  .rl-review .r-cond div:nth-child(2n){border-right:0!important}
  .rl-review .r-cond div:nth-child(-n+2){border-top:0}
  .rl-review .r-cond div:last-child:nth-child(odd){grid-column:1/-1;border-right:0!important}
  .rl-review .r-verdict{grid-template-columns:minmax(0,1fr)}
  .rl-review .score{border-right:0;border-bottom:1px solid var(--red-line);padding:20px 18px}
  .rl-review .score .big{font-size:68px}
  .rl-review .vtext{padding:20px 18px}
  .rl-review .vtext p.v{font-size:17px}
  .rl-review .bs,.rl-review .pc,.rl-review .plans,.rl-review .plans.n2,.rl-review .plans.n4,.rl-review .r-back,.rl-review .r-take{grid-template-columns:minmax(0,1fr)}
  .rl-review .srow{grid-template-columns:minmax(0,1fr) 44px;gap:6px 12px}
  .rl-review .srow .bar{grid-column:1/-1;grid-row:2}
  .rl-review .r-log::before{left:7px}
  .rl-review .r-log li{grid-template-columns:24px minmax(0,1fr)}
  .rl-review .r-log time{grid-column:2;text-align:left}
  .rl-review .r-log .dot{grid-row:1/3;grid-column:1}
  .rl-review .r-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-review .cact{padding-right:16px}
  .rl-review .r-final,.rl-review .r-final.noscore{grid-template-columns:minmax(0,1fr)}
  .rl-review .r-author{grid-template-columns:1fr}
  .rl-review .r-prose p,.rl-review .r-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-review .go,.rl-review .go2{transition:none}}
</style>
<?php }, 24);
