<?php
/**
 * Plugin Name: Reinforce Lab - Best / List post design
 * Description: The approved Best / List design (D-077, mockup claude/design-previews/blog-list-template-mockup.html). Shortlist board: podium of the top three, method strip with the score weighting, sticky shortlist bar, sortable comparison table, one spec sheet per pick (score breakdown, pros and cons, key facts, skip it if, visit button), one in-article service CTA, pick by need, also considered, how we chose, FAQs and sources, author box. Picks are an ACF PRO repeater. reinforce-post.php hands list posts to rl_list_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_list_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'list'; }

/* ---------- fields (Best / List only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'list']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $s = function ($key, $label, $type, $extra = []) { return array_merge(['key' => 'field_rl_lp_' . $key, 'name' => $key, 'label' => $label, 'type' => $type], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_list', 'title' => 'Best / List (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_l_item_label', 'What the items are', 'text', ['default_value' => 'Name', 'instructions' => 'Column heading in the comparison table, e.g. Host, Tool, Agency.']),
            $f('rl_l_criteria', 'Scoring criteria', 'textarea', ['rows' => 5, 'instructions' => 'One per line: Criterion | Weight in %. Example: Speed | 30. Each pick gives one score per criterion, in this order; the overall score is the weighted average.']),
            $f('rl_l_facts', 'Method strip: facts', 'textarea', ['rows' => 3, 'instructions' => 'Up to 3, one per line: Number | Label. Example: 6 | Weeks measured']),
            $f('rl_l_checked', 'Prices checked on', 'date_picker', ['display_format' => 'j M Y', 'return_format' => 'Y-m-d']),
            $f('rl_l_affiliate', 'Contains affiliate links', 'true_false', ['ui' => 1, 'instructions' => 'Shows the disclosure and marks visit buttons as sponsored.']),
            $f('rl_l_picks', 'Picks (in ranked order)', 'repeater', ['layout' => 'block', 'button_label' => 'Add pick', 'min' => 0, 'sub_fields' => [
                $s('name', 'Name', 'text', ['required' => 1]),
                $s('badge', 'Badge', 'text', ['instructions' => 'Short, e.g. Top pick, Best value. The first three appear on the podium.']),
                $s('best_for', 'Best for', 'text'),
                $s('verdict', 'Verdict', 'textarea', ['rows' => 3, 'instructions' => 'Two or three sentences.']),
                $s('scores', 'Scores', 'text', ['instructions' => 'One score out of 10 per criterion, in order, separated by commas. Example: 9.4, 9.2, 9.0, 8.8, 8.2']),
                $s('overall', 'Overall score (only if there are no criteria)', 'number', ['min' => 0, 'max' => 10, 'step' => 0.1]),
                $s('price', 'Price from', 'text', ['instructions' => 'As shown on the vendor site, e.g. $25 a month.']),
                $s('pros', 'What we liked', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
                $s('cons', 'What could be better', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
                $s('facts', 'Key facts', 'textarea', ['rows' => 3, 'instructions' => 'One per line: Label | Value. The first one also shows as a column in the comparison table.']),
                $s('skip', 'Skip it if', 'text'),
                $s('url', 'Visit link', 'url'),
                $s('more', 'More detail', 'wysiwyg', ['tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'instructions' => 'Optional. Longer notes from testing, shown under the verdict.']),
            ]]),
            $f('rl_l_needs', 'Pick by what you need', 'textarea', ['rows' => 4, 'instructions' => 'One per line: Need | Pick name (exactly as above) | Why. Example: You sell online | Bramble Press | Checkout pages stay quick']),
            $f('rl_l_also', 'Also considered', 'textarea', ['rows' => 3, 'instructions' => 'One per line: Name | Why it is not on the list']),
            $f('rl_l_method', 'How we chose', 'textarea', ['rows' => 4, 'instructions' => 'Up to 3, one per line: Heading | Text. Example: Same site, every host | We moved one real business site to each host.']),
            $f('rl_l_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Leave empty for no in-article CTA.']),
            $f('rl_l_cta_after', 'In-article CTA: after pick', 'number', ['min' => 1, 'max' => 50, 'default_value' => 2]),
            $f('rl_l_cta_head', 'In-article CTA: headline', 'text', ['instructions' => 'Example: Moving your site to a new host?']),
            $f('rl_l_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_l_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
        ],
    ]);
});

/* ---------- data ---------- */
function rl_list_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
function rl_list_criteria($id) {
    $c = [];
    foreach (rl_list_rows(get_post_meta($id, 'rl_l_criteria', true), 2) as $r) { $w = (float) $r[1]; if ($w > 0) $c[] = [$r[0], $w]; }
    return $c;
}
/* Reads the repeater straight from post meta (count + rl_l_picks_N_field), so it works without ACF's API. */
function rl_list_picks($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $crit = rl_list_criteria($id); $tw = array_sum(array_column($crit, 1));
    $n = (int) get_post_meta($id, 'rl_l_picks', true);
    $out = [];
    for ($i = 0; $i < $n; $i++) {
        $g = function ($k) use ($id, $i) { return get_post_meta($id, 'rl_l_picks_' . $i . '_' . $k, true); };
        $name = trim((string) $g('name'));
        if ($name === '') continue;
        $scores = [];
        foreach (preg_split('/\s*,\s*/', trim((string) $g('scores')), -1, PREG_SPLIT_NO_EMPTY) as $x) $scores[] = max(0, min(10, (float) $x));
        $overall = null;
        if ($crit && count($scores) >= count($crit)) { $sum = 0; foreach ($crit as $k => $c) $sum += $scores[$k] * $c[1]; $overall = round($sum / $tw, 1); }
        elseif ($g('overall') !== '' && $g('overall') !== null) $overall = round((float) $g('overall'), 1);
        $price = trim((string) $g('price'));
        $out[] = ['name' => $name, 'badge' => trim((string) $g('badge')), 'best' => trim((string) $g('best_for')), 'verdict' => trim((string) $g('verdict')),
            'scores' => $scores, 'score' => $overall, 'price' => $price, 'price_num' => preg_match('/[\d.,]+/', $price, $pm) ? (float) str_replace(',', '', $pm[0]) : null,
            'pros' => rl_post_lines($g('pros')), 'cons' => rl_post_lines($g('cons')), 'facts' => rl_list_rows($g('facts'), 2),
            'skip' => trim((string) $g('skip')), 'url' => esc_url_raw(trim((string) $g('url'))), 'more' => trim((string) $g('more'))];
    }
    foreach ($out as $k => &$p) $p['anchor'] = 'pick-' . ($k + 1);
    unset($p);
    return $cache[$id] = $out;
}
function rl_list_num($x) { return number_format((float) $x, 1); }
function rl_list_pct($x) { return rtrim(rtrim(number_format((float) $x, 1), '0'), '.'); }

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_list_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $picks = rl_list_picks($id); $n = count($picks);
    $crit = rl_list_criteria($id); $tw = array_sum(array_column($crit, 1));
    $title = get_the_title($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $label = trim((string) get_post_meta($id, 'rl_l_item_label', true)) ?: 'Name';
    $facts = array_slice(rl_list_rows(get_post_meta($id, 'rl_l_facts', true), 2), 0, 3);
    $checked = function_exists('rl_pt_date') ? rl_pt_date((string) get_post_meta($id, 'rl_l_checked', true)) : '';
    $checked_h = $checked ? date_i18n('j M Y', strtotime($checked)) : '';
    $aff = (bool) get_post_meta($id, 'rl_l_affiliate', true);
    $needs = rl_list_rows(get_post_meta($id, 'rl_l_needs', true), 2);
    $also = rl_list_rows(get_post_meta($id, 'rl_l_also', true), 2);
    $method = array_slice(rl_list_rows(get_post_meta($id, 'rl_l_method', true), 2), 0, 3);
    $byname = []; foreach ($picks as $p) $byname[mb_strtolower($p['name'])] = $p['anchor'];
    $col = ($n && $picks[0]['facts']) ? $picks[0]['facts'][0][0] : '';
    $hasprice = (bool) array_filter(array_column($picks, 'price'));
    $hasscore = (bool) array_filter(array_column($picks, 'score'), function ($x) { return $x !== null; });
    // body: text before the first H2 is the intro, any H2 sections follow the picks
    $parts = preg_split('#(?=<h2\b)#i', $c['body'], 2);
    $intro = trim($parts[0]); $more = trim($parts[1] ?? '');
    $cta = null; $svc = (string) get_post_meta($id, 'rl_l_cta_service', true);
    $head = trim((string) get_post_meta($id, 'rl_l_cta_head', true));
    if ($svc !== '' && $head !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) {
        $cta = ['after' => min(max(1, (int) (get_post_meta($id, 'rl_l_cta_after', true) ?: 2)), max(1, $n)), 'name' => rl_pt_services()[$svc], 'url' => $u($svc), 'head' => $head,
                'sub' => trim((string) get_post_meta($id, 'rl_l_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_l_cta_button', true)) ?: 'See how it works'];
    }
    $diag = $u('search-authority-diagnostic');
    $rel = $aff ? 'sponsored nofollow noopener' : 'noopener';
    $h1 = preg_replace('/\b(20\d\d)\b/', '<span class="yr">$1</span>', esc_html($title), 1);
    $ic_ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $ic_x = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M4 4l8 8M12 4l-8 8"/></svg>';
    ?>
<div class="rl-page rl-post rl-list">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<header class="wrap l-hero<?php echo $n ? '' : ' solo'; ?>">
  <div>
    <div class="l-kicker"><span class="l-kind">Best / List</span><?php if ($c['cat']) echo '<a class="l-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
    <h1 class="l-h1"><?php echo $h1; ?></h1>
    <?php if ($standfirst !== '') { ?><p class="l-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
    <div class="l-by">
      <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
      <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
      <?php if ($d['updated'] !== '') { ?><span class="fresh">Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
    </div>
  </div>
  <?php if ($n) { $top = array_slice($picks, 0, 3); ?>
  <div class="l-pod-wrap">
    <div class="l-pod-h"><span>Our picks</span><?php if ($hasscore) { ?><span>Score out of 10</span><?php } ?></div>
    <div class="l-podium n<?php echo count($top); ?>">
      <?php foreach ($top as $k => $p) { ?>
      <a class="pd pd<?php echo $k + 1; ?>" href="#<?php echo esc_attr($p['anchor']); ?>">
        <?php if ($p['badge'] !== '') { ?><span class="pl"><?php echo esc_html($p['badge']); ?></span><?php } ?>
        <span class="pn"><?php echo esc_html($p['name']); ?></span>
        <?php if ($p['score'] !== null) { ?><span class="ps"><b><?php echo esc_html(rl_list_num($p['score'])); ?></b> / 10</span><?php } ?>
        <?php if ($p['price'] !== '') { ?><span class="pf">From <?php echo esc_html($p['price']); ?></span><?php } ?>
      </a>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
</header>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap l-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<?php if ($facts || $crit || $checked_h || $aff) { ?>
<section class="l-method" aria-label="How we ranked">
  <div class="wrap row">
    <?php if ($facts) { ?><div class="facts"><?php foreach ($facts as $f) echo '<div><b>' . esc_html($f[0]) . '</b><span>' . esc_html($f[1]) . '</span></div>'; ?></div><?php } ?>
    <?php if ($crit) { ?><div class="wb"><span class="wlab">How the score is weighted</span><div class="wbar"><?php foreach ($crit as $cr) { $pc = rl_list_pct($cr[1] / $tw * 100); echo '<span style="flex:' . esc_attr($cr[1]) . '"><b>' . esc_html($pc) . '%</b>' . esc_html($cr[0]) . '</span>'; } ?></div></div><?php } ?>
    <?php if ($checked_h || $method) { ?><div class="checked"><?php if ($checked_h) { ?><span>Prices checked</span><b><?php echo esc_html($checked_h); ?></b><?php } ?><?php if ($method) { ?><a href="#how">How we tested</a><?php } ?></div><?php } ?>
  </div>
  <?php if ($aff) { ?><div class="wrap"><p class="disc"><b>Ad:</b> the "Visit" links marked "Ad" on this page are affiliate links. If you buy through them we earn a commission, at no extra cost to you. It does not change the ranking. <a href="<?php echo esc_url(home_url('/ftc-disclosure/')); ?>">How we handle affiliate links</a>.</p></div><?php } ?>
</section>
<?php } ?>

<?php if ($n > 1) { ?>
<nav class="l-short" aria-label="The shortlist">
  <div class="wrap">
    <span class="lbl">Shortlist</span>
    <ol><?php foreach ($picks as $k => $p) echo '<li><a href="#' . esc_attr($p['anchor']) . '"><b>' . ($k + 1) . '</b><span>' . esc_html($p['name']) . '</span>' . ($p['score'] !== null ? '<em>' . esc_html(rl_list_num($p['score'])) . '</em>' : '') . '</a></li>'; ?></ol>
    <a class="cmp" href="#compare">Compare all</a>
  </div>
</nav>
<?php } ?>

<div class="wrap">
  <div class="l-main">
    <?php if ($d['answer'] !== '') { ?><div class="l-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
    <?php if ($d['takeaways']) { ?><div class="l-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . sprintf('%02d', $i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>
    <?php if ($intro !== '') echo '<div class="l-prose l-intro">' . $intro . '</div>'; ?>

    <?php if ($n > 1) { ?>
    <div class="sec-h" id="compare"><span>At a glance</span><h2>Compare all <?php echo (int) $n; ?></h2></div>
    <div class="tw">
      <table class="l-table">
        <thead><tr>
          <th scope="col"><button type="button" data-k="rank" aria-sort="ascending">#</button></th>
          <th scope="col"><?php echo esc_html($label); ?></th>
          <th scope="col">Best for</th>
          <?php if ($hasscore) { ?><th scope="col"><button type="button" data-k="score">Score</button></th><?php } ?>
          <?php if ($hasprice) { ?><th scope="col"><button type="button" data-k="price">From</button></th><?php } ?>
          <?php if ($col !== '') { ?><th scope="col"><?php echo esc_html($col); ?></th><?php } ?>
        </tr></thead>
        <tbody>
        <?php foreach ($picks as $k => $p) {
            $cv = ''; foreach ($p['facts'] as $f) if ($f[0] === $col) { $cv = $f[1]; break; } ?>
          <tr<?php echo $k === 0 ? ' class="top"' : ''; ?> data-rank="<?php echo $k + 1; ?>" data-score="<?php echo esc_attr($p['score'] ?? 0); ?>" data-price="<?php echo esc_attr($p['price_num'] ?? 999999); ?>">
            <td class="rk"><?php echo $k + 1; ?></td>
            <th scope="row"><a href="#<?php echo esc_attr($p['anchor']); ?>"><?php echo esc_html($p['name']); ?></a><?php if ($k === 0 && $p['badge'] !== '') echo '<span class="tag">' . esc_html($p['badge']) . '</span>'; ?></th>
            <td><?php echo esc_html($p['best']); ?></td>
            <?php if ($hasscore) { ?><td class="num"><?php if ($p['score'] !== null) { ?><span class="mini" aria-hidden="true"><i style="width:<?php echo esc_attr($p['score'] * 10); ?>%"></i></span><?php echo esc_html(rl_list_num($p['score'])); } ?></td><?php } ?>
            <?php if ($hasprice) { ?><td class="num"><?php echo esc_html($p['price']); ?></td><?php } ?>
            <?php if ($col !== '') { ?><td><?php echo esc_html($cv); ?></td><?php } ?>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
    <p class="tnote"><?php echo $hasscore || $hasprice ? 'Sort by ' . implode(' or ', array_filter([$hasscore ? 'score' : '', $hasprice ? 'price' : ''])) . '.' : ''; ?><?php echo $checked_h ? ' Prices checked ' . esc_html($checked_h) . '.' : ''; ?></p>
    <?php } ?>

    <?php if ($n) { ?>
    <div class="sec-h"><span>The ranking</span><h2>Our picks in detail</h2></div>
    <?php foreach ($picks as $k => $p) { ?>
    <article class="pick<?php echo $k === 0 ? ' first' : ''; ?>" id="<?php echo esc_attr($p['anchor']); ?>" aria-labelledby="<?php echo esc_attr($p['anchor']); ?>-h">
      <div class="rail"><span class="rank" aria-hidden="true"><?php echo $k + 1; ?></span><?php if ($p['score'] !== null) { ?><div class="plate"><b><?php echo esc_html(rl_list_num($p['score'])); ?></b><span>out of 10</span></div><?php } ?></div>
      <div class="pbody">
        <?php if ($p['badge'] !== '') { ?><p class="bdg"><?php echo esc_html($p['badge']); ?></p><?php } ?>
        <h2 id="<?php echo esc_attr($p['anchor']); ?>-h"><span class="vh"><?php echo $k + 1; ?>. </span><?php echo esc_html($p['name']); ?></h2>
        <?php if ($p['best'] !== '') { ?><p class="bf">Best for: <b><?php echo esc_html($p['best']); ?></b></p><?php } ?>
        <?php if ($p['verdict'] !== '') { ?><p class="vd"><?php echo esc_html($p['verdict']); ?></p><?php } ?>
        <?php if ($p['more'] !== '') { ?><div class="l-prose more"><?php echo wp_kses_post(wpautop($p['more'])); ?></div><?php } ?>
        <?php if ($crit && count($p['scores']) >= count($crit)) { ?>
        <div class="bks" aria-label="Score breakdown"><?php foreach ($crit as $ci => $cr) echo '<div class="br"><span>' . esc_html($cr[0]) . ' <small>' . esc_html(rl_list_pct($cr[1] / $tw * 100)) . '%</small></span><span class="bt" aria-hidden="true"><i style="width:' . esc_attr($p['scores'][$ci] * 10) . '%"></i></span><b>' . esc_html(rl_list_num($p['scores'][$ci])) . '</b></div>'; ?></div>
        <?php } ?>
        <?php if ($p['pros'] || $p['cons']) { ?>
        <div class="pc">
          <?php if ($p['pros']) { ?><div><p class="lb">What we liked</p><ul class="pros"><?php foreach ($p['pros'] as $x) echo '<li>' . $ic_ok . '<span>' . esc_html($x) . '</span></li>'; ?></ul></div><?php } ?>
          <?php if ($p['cons']) { ?><div><p class="lb">What could be better</p><ul class="cons"><?php foreach ($p['cons'] as $x) echo '<li>' . $ic_x . '<span>' . esc_html($x) . '</span></li>'; ?></ul></div><?php } ?>
        </div>
        <?php } ?>
        <?php $spec = $p['price'] !== '' ? array_merge([['Price from', $p['price']]], $p['facts']) : $p['facts']; if ($spec) { ?>
        <dl class="spec"><?php foreach ($spec as $s) echo '<div><dt>' . esc_html($s[0]) . '</dt><dd>' . esc_html($s[1]) . '</dd></div>'; ?></dl>
        <?php } ?>
        <?php if ($p['skip'] !== '') { ?><p class="skip"><b>Skip it if</b> <?php echo esc_html($p['skip']); ?></p><?php } ?>
        <?php if ($p['url'] !== '' || $checked_h) { ?>
        <div class="act"><?php if ($p['url'] !== '') { ?><a class="go" href="<?php echo esc_url($p['url']); ?>" rel="<?php echo esc_attr($rel); ?>" target="_blank">Visit <?php echo esc_html($p['name']); ?> <span aria-hidden="true">&rarr;</span></a><?php if ($aff && function_exists('rl_aff_label')) echo rl_aff_label(); ?><?php } ?><?php if ($checked_h && $p['price'] !== '') { ?><span class="chk">Price checked <?php echo esc_html($checked_h); ?></span><?php } ?></div>
        <?php } ?>
      </div>
    </article>
    <?php if ($cta && $cta['after'] === $k + 1) { ?>
    <aside class="l-icta" aria-label="Reinforce Lab service">
      <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
      <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
    </aside>
    <?php } ?>
    <?php } ?>
    <?php } ?>

    <?php if ($needs) { ?>
    <div class="sec-h"><span>Quick decision</span><h2>Pick by what you need</h2></div>
    <div class="needs"><?php foreach ($needs as $nd) { $a = $byname[mb_strtolower($nd[1])] ?? ''; ?>
      <a class="nd" href="<?php echo $a ? '#' . esc_attr($a) : '#compare'; ?>"><span class="if">If</span><span class="q"><?php echo esc_html($nd[0]); ?></span><span class="arr" aria-hidden="true">&rarr;</span><span class="pk">Pick <b><?php echo esc_html($nd[1]); ?></b></span><?php if (!empty($nd[2])) { ?><span class="why"><?php echo esc_html($nd[2]); ?></span><?php } ?></a>
    <?php } ?></div>
    <?php } ?>

    <?php if ($more !== '') echo '<div class="l-prose l-more">' . $more . '</div>'; ?>

    <?php if ($also) { ?>
    <div class="sec-h"><span>Not on the list</span><h2>Also considered</h2></div>
    <ul class="also"><?php foreach ($also as $a) echo '<li><b>' . esc_html($a[0]) . '</b><span>' . esc_html($a[1]) . '</span></li>'; ?></ul>
    <?php } ?>

    <?php if ($method) { ?>
    <div class="sec-h" id="how"><span>Method</span><h2>How we chose</h2></div>
    <div class="how"><?php foreach ($method as $m) echo '<div><h3>' . esc_html($m[0]) . '</h3><p>' . esc_html($m[1]) . '</p></div>'; ?></div>
    <?php } ?>
  </div>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <section class="l-back" aria-label="Questions and sources">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="l-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </section>
  <?php } ?>

  <aside class="l-author" aria-label="About the author">
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

</div>
<?php if ($n > 1) { ?>
<script>
(function(){
  var root=document.querySelector('.rl-list'); if(!root) return;
  var tb=root.querySelector('.l-table tbody'), btns=[].slice.call(root.querySelectorAll('.l-table thead button'));
  btns.forEach(function(b){ b.addEventListener('click',function(){
    var k=b.getAttribute('data-k'), cur=b.getAttribute('aria-sort'), dir=cur==='ascending'?'descending':(cur==='descending'?'ascending':(k==='score'?'descending':'ascending'));
    btns.forEach(function(x){x.removeAttribute('aria-sort');}); b.setAttribute('aria-sort',dir);
    var rows=[].slice.call(tb.rows); rows.sort(function(a,c){var d=parseFloat(a.getAttribute('data-'+k))-parseFloat(c.getAttribute('data-'+k));return dir==='ascending'?d:-d;});
    rows.forEach(function(r){tb.appendChild(r);});
  });});
  var picks=[].slice.call(root.querySelectorAll('.pick')), chips=[].slice.call(root.querySelectorAll('.l-short li a'));
  function cur(){ var c=-1; picks.forEach(function(p,i){ if(p.getBoundingClientRect().top<innerHeight*0.4) c=i; });
    chips.forEach(function(a,i){ a.classList.toggle('on',i===c); if(i===c) a.setAttribute('aria-current','true'); else a.removeAttribute('aria-current'); }); }
  addEventListener('scroll',cur,{passive:true}); cur();
})();
</script>
<?php }
}

/* ---------- schema: the ranking as an ItemList (editorial ranking only, no per-item Review or rating, D-086) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_list_view()) return $graph;
    $id = get_queried_object_id(); $url = get_permalink($id);
    $picks = rl_list_picks($id);
    if (!$picks) return $graph;
    $graph[] = ['@type' => 'ItemList', '@id' => $url . '#list', 'name' => get_the_title($id), 'numberOfItems' => count($picks), 'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
        'itemListElement' => array_map(function ($p, $i) use ($url) { return ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $p['name'], 'url' => $url . '#' . $p['anchor']]; }, $picks, array_keys($picks))];
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_list_view()) return; ?>
<style id="rl-list-css">
.rl-list{color:var(--ink-dim);--ok:#3fa36b}
.rl-list h1,.rl-list h2,.rl-list h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-list .ic{width:14px;height:14px;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:square}
.rl-list .vh{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)}
.rl-list .l-hero{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1.05fr);gap:clamp(28px,5vw,64px);align-items:center;padding-block:clamp(26px,4vw,44px) clamp(28px,4vw,40px)}
.rl-list .l-hero.solo{grid-template-columns:minmax(0,1fr)}
.rl-list .l-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px}
.rl-list .l-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-list .l-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-list .l-h1{font-size:clamp(36px,5vw,66px);line-height:.98;margin:0}
.rl-list .l-h1 .yr{color:var(--red-3)}
.rl-list .l-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;max-width:560px;margin:20px 0 0}
.rl-list .l-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:24px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-list .l-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-list .l-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-list .l-by b{color:var(--ink-dim);font-weight:500}
.rl-list .l-by .fresh,.rl-list .l-by .fresh b{color:var(--ok)}
.rl-list .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-list .l-pod-h{display:flex;justify-content:space-between;font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:10px}
.rl-list .l-podium{display:grid;grid-template-columns:1fr 1.12fr 1fr;align-items:end;gap:8px}
.rl-list .l-podium.n2{grid-template-columns:1fr 1.12fr}
.rl-list .l-podium.n1{grid-template-columns:minmax(0,1fr)}
.rl-list .pd{display:grid;gap:6px;text-decoration:none;border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:16px;position:relative;transition:border-color .2s;min-width:0}
.rl-list .pd:hover{border-color:var(--red-line)}
.rl-list .pd::after{content:"";position:absolute;left:-1px;right:-1px;bottom:-1px;height:4px;background:var(--line-2)}
.rl-list .pd1{order:2;padding-block:26px 22px;border-color:var(--red-line);background:radial-gradient(120% 90% at 50% 0%,rgba(153,0,0,.28),transparent 65%),var(--panel)}
.rl-list .pd1::after{background:var(--red-3)}
.rl-list .pd2{order:1}.rl-list .pd3{order:3}
.rl-list .pl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-list .pn{font-family:var(--f-display);font-size:21px;text-transform:uppercase;color:var(--ink);line-height:1.05;overflow-wrap:anywhere}
.rl-list .pd1 .pn{font-size:25px}
.rl-list .ps{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint)}
.rl-list .ps b{font-family:var(--f-display);font-size:30px;color:var(--ink);font-weight:500}
.rl-list .pd1 .ps b{font-size:38px}
.rl-list .pf{font-size:13.5px;color:var(--ink-dim)}
.rl-list .l-feat{margin-top:0;margin-bottom:clamp(28px,4vw,44px)}
.rl-list .l-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-list .l-method{padding-block:0;border-block:1px solid var(--line-2);background:rgba(14,12,13,.7)}
.rl-list .l-method .row{display:flex;flex-wrap:wrap;gap:18px clamp(18px,3vw,40px);align-items:center;padding-block:18px}
.rl-list .l-method .wb{flex:1 1 360px;min-width:0}
.rl-list .facts{display:flex;gap:26px}
.rl-list .facts div{display:grid}
.rl-list .facts b{font-family:var(--f-display);font-size:28px;font-weight:500;color:var(--ink);line-height:1}
.rl-list .facts span,.rl-list .wlab,.rl-list .checked span{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-list .wbar{display:flex;gap:2px;margin-top:6px;min-width:0}
.rl-list .wbar span{min-width:0;background:var(--panel-2,var(--panel));border-top:2px solid var(--red-2);padding:7px 8px;font-size:12px;line-height:1.35;color:var(--ink-dim)}
.rl-list .wbar span b{display:block;font-family:var(--f-mono);font-weight:500;color:var(--ink)}
.rl-list .checked{text-align:right;margin-left:auto}
.rl-list .checked b{display:block;color:var(--ink);font-size:14.5px;font-weight:500}
.rl-list .checked a{font-size:13px;color:var(--ink-dim)}
.rl-list .disc{font-size:13.5px;color:var(--ink-faint);margin:0;padding-bottom:14px}
.rl-list .disc b{color:var(--ink-dim);font-weight:500}
.rl-list .l-short{position:sticky;top:72px;z-index:6;background:rgba(18,16,17,.94);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:1px solid var(--line-2)}
.rl-list .l-short .wrap{display:flex;align-items:center;gap:16px;height:54px}
.rl-list .l-short .lbl{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink);white-space:nowrap}
.rl-list .l-short ol{list-style:none;margin:0;padding:0;display:flex;gap:6px;flex:1;min-width:0;overflow-x:auto;scrollbar-width:none}
.rl-list .l-short ol::-webkit-scrollbar{display:none}
.rl-list .l-short li a{display:flex;align-items:center;gap:8px;height:34px;padding:0 10px;border:1px solid var(--line-2);background:var(--bg-2);text-decoration:none;color:var(--ink-dim);font-size:13px;white-space:nowrap}
.rl-list .l-short li a b{font-family:var(--f-mono);font-size:11px;color:var(--red-3);font-weight:500}
.rl-list .l-short li a em{font-style:normal;font-family:var(--f-mono);font-size:11px;color:var(--ink-faint)}
.rl-list .l-short li a.on{border-color:var(--red-2);color:var(--ink)}
.rl-list .l-short .cmp{font-family:var(--f-mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line);white-space:nowrap}
.rl-list .l-main{max-width:900px;padding-block:clamp(30px,4vw,48px) 10px}
.rl-list .l-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-list .l-answer .t,.rl-list .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-list .l-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-list .l-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:28px}
.rl-list .l-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-list .l-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-list .l-prose>*{margin:0 0 1.1em}
.rl-list .l-prose p,.rl-list .l-prose li{font-size:17.5px;line-height:1.75}
.rl-list .l-prose h2{font-size:clamp(24px,2.8vw,30px);margin:1.8em 0 .6em;scroll-margin-top:140px}
.rl-list .l-prose h3{font-size:21px;margin:1.4em 0 .5em;scroll-margin-top:140px}
.rl-list .l-prose strong{color:var(--ink);font-weight:600}
.rl-list .l-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-list .l-prose ul,.rl-list .l-prose ol{padding-left:1.2em}
.rl-list .l-prose li::marker{color:var(--red-3)}
.rl-list .l-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-list .l-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-list .l-prose th,.rl-list .l-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-list .l-more{margin-top:20px}
.rl-list .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:44px 0 16px}
.rl-list .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-list .tw{overflow-x:auto;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-list .l-table{width:100%;border-collapse:collapse;min-width:680px;font-size:14.5px;margin:0}
.rl-list .l-table th,.rl-list .l-table td{padding:12px 14px;text-align:left;border:0;border-bottom:1px solid var(--line);vertical-align:middle;background:none}
.rl-list .l-table thead th{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);font-weight:500;background:var(--panel)}
.rl-list .l-table thead button{all:unset;cursor:pointer;display:inline-flex;gap:6px;align-items:center;color:var(--ink)}
.rl-list .l-table thead button:focus-visible{outline:2px solid var(--red-3);outline-offset:3px}
.rl-list .l-table thead button::after{content:"";width:0;height:0;border:4px solid transparent;border-top-color:var(--ink-faint);margin-top:4px}
.rl-list .l-table thead button[aria-sort="ascending"]::after{border-top-color:transparent;border-bottom-color:var(--red-3);margin-top:-4px}
.rl-list .l-table thead button[aria-sort="descending"]::after{border-top-color:var(--red-3)}
.rl-list .l-table tbody th{color:var(--ink);font-family:var(--f-body);font-size:15px;font-weight:600;letter-spacing:0;text-transform:none}
.rl-list .l-table tbody th a{text-decoration:none;color:var(--ink)}
.rl-list .l-table tbody tr:last-child>*{border-bottom:0}
.rl-list .l-table tr.top{background:linear-gradient(90deg,rgba(153,0,0,.2),transparent 70%)}
.rl-list .l-table tr.top td.rk{box-shadow:inset 3px 0 0 var(--red-2)}
.rl-list .l-table .rk{font-family:var(--f-mono);color:var(--red-3);width:40px}
.rl-list .l-table .tag{font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:#fff;background:var(--red);padding:2px 6px;margin-left:10px;font-weight:500;white-space:nowrap}
.rl-list .mini{display:inline-block;width:60px;height:4px;background:var(--line-2);margin-right:10px;vertical-align:middle}
.rl-list .mini i{display:block;height:100%;background:var(--red-3)}
.rl-list .l-table td.num{font-family:var(--f-mono);color:var(--ink);white-space:nowrap;font-variant-numeric:tabular-nums}
.rl-list .tnote{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);margin:8px 0 0}
.rl-list .pick{display:grid;grid-template-columns:120px minmax(0,1fr);border:1px solid var(--line-2);background:var(--panel);margin-top:22px;scroll-margin-top:140px}
.rl-list .pick.first{border-color:var(--red-line);box-shadow:0 30px 80px -60px rgba(226,59,59,.6)}
.rl-list .rail{border-right:1px solid var(--line-2);background:var(--bg-2);display:flex;flex-direction:column;align-items:center;padding:22px 10px;gap:18px}
.rl-list .rank{font-family:var(--f-display);font-weight:700;font-size:84px;line-height:.8;color:transparent;-webkit-text-stroke:1.5px var(--red-3)}
.rl-list .pick.first .rank{color:var(--red);-webkit-text-stroke:1.5px var(--red-2)}
.rl-list .plate{border:1px solid var(--line-2);width:84px;text-align:center;padding:10px 4px;background:var(--panel)}
.rl-list .plate b{display:block;font-family:var(--f-display);font-size:30px;color:var(--ink);font-weight:500;line-height:1}
.rl-list .plate span{font-family:var(--f-mono);font-size:10px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:.08em}
.rl-list .pbody{padding:22px 26px 24px;min-width:0}
.rl-list .bdg{display:inline-block;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);border:1px solid var(--red-line);padding:3px 8px;margin:0 0 10px}
.rl-list .pick.first .bdg{background:var(--red);color:#fff;border-color:var(--red-2)}
.rl-list .pick h2{font-size:clamp(26px,3vw,34px);margin:0}
.rl-list .bf{margin:6px 0 12px;font-size:15px}
.rl-list .bf b{color:var(--ink);font-weight:500}
.rl-list .vd{color:var(--ink);font-size:17px;line-height:1.7;margin:0 0 18px}
.rl-list .more p{font-size:16px}
.rl-list .bks{display:grid;gap:7px;margin-bottom:20px;padding:14px 16px;border:1px solid var(--line);background:var(--bg-2)}
.rl-list .br{display:grid;grid-template-columns:minmax(0,190px) minmax(0,1fr) 34px;gap:12px;align-items:center;font-size:13.5px}
.rl-list .br small{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint)}
.rl-list .bt{height:6px;background:var(--line-2)}
.rl-list .bt i{display:block;height:100%;background:linear-gradient(90deg,var(--red),var(--red-3))}
.rl-list .br b{font-family:var(--f-mono);font-weight:500;color:var(--ink);text-align:right;font-variant-numeric:tabular-nums}
.rl-list .pc{display:grid;grid-template-columns:1fr 1fr;gap:22px}
.rl-list .lb{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 8px}
.rl-list .pc ul{list-style:none;margin:0;padding:0}
.rl-list .pc li{display:grid;grid-template-columns:18px 1fr;gap:8px;padding:7px 0;margin:0;border-top:1px solid var(--line);font-size:14.5px}
.rl-list .pc li:first-child{border-top:0}
.rl-list .pros .ic{color:var(--ok);margin-top:4px}
.rl-list .cons .ic{color:var(--red-3);margin-top:4px}
.rl-list .spec{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1px;background:var(--line);border:1px solid var(--line);margin:20px 0 0}
.rl-list .spec div{background:var(--bg-2);padding:12px 14px}
.rl-list .spec dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-list .spec dd{margin:4px 0 0;color:var(--ink);font-size:15px}
.rl-list .skip{margin:16px 0 0;font-size:14.5px;border-left:2px solid var(--line-2);padding-left:12px}
.rl-list .skip b{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink);font-weight:500;margin-right:6px}
.rl-list .act{display:flex;flex-wrap:wrap;gap:12px 18px;align-items:center;margin-top:20px}
.rl-list .go{font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px}
.rl-list .pick:not(.first) .go{background:transparent;border-color:var(--line-2)}
.rl-list .pick:not(.first) .go:hover{border-color:var(--red-2)}
.rl-list .chk{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint)}
.rl-list .l-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:30px 0 8px;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-list .l-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-list .l-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-list .l-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-list .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-list .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-list .go2:hover{background:var(--red-2)}
.rl-list .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-list .needs{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-list .nd{background:var(--bg);padding:18px 20px;text-decoration:none;display:grid;grid-template-columns:auto 1fr auto;gap:4px 12px;align-items:baseline;transition:background .2s}
.rl-list .nd:hover{background:var(--panel)}
.rl-list .nd .if{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-list .nd .q{color:var(--ink);font-size:15.5px}
.rl-list .nd .arr{color:var(--red-3)}
.rl-list .nd .pk{grid-column:2/4;font-family:var(--f-display);text-transform:uppercase;font-size:19px;color:var(--ink-dim)}
.rl-list .nd .pk b{color:var(--ink);font-weight:600}
.rl-list .nd .why{grid-column:2/4;font-size:13.5px;color:var(--ink-faint)}
.rl-list .also{list-style:none;margin:0;padding:0;border:1px solid var(--line-2)}
.rl-list .also li{display:grid;grid-template-columns:200px 1fr;gap:16px;padding:14px 18px;margin:0;border-top:1px solid var(--line);font-size:15px}
.rl-list .also li:first-child{border-top:0}
.rl-list .also b{color:var(--ink);font-weight:500}
.rl-list .how{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}
.rl-list .how div{border-top:2px solid var(--red-2);padding-top:12px}
.rl-list .how h3{font-size:17px;margin:0 0 6px}
.rl-list .how p{margin:0;font-size:15px}
.rl-list .l-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-list .l-back .sec-h{margin-top:0}
.rl-list .l-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-list .l-src li{padding:6px 0;color:var(--ink-faint)}
.rl-list .l-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-list .l-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-list .l-author .av{width:72px;height:72px;font-size:28px}
.rl-list .l-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-list .l-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-list .l-author p{margin:0 0 8px;font-size:15px}
.rl-list .l-author .links{display:flex;gap:18px;font-size:14px}
.rl-list .l-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:1000px){
  .rl-list .l-hero{grid-template-columns:minmax(0,1fr)}
  .rl-list .checked{text-align:left;margin-left:0}
  .rl-list .l-short{top:64px}
  .rl-list .l-short .cmp{display:none}
  .rl-list .pick{scroll-margin-top:130px}
}
@media(max-width:700px){
  .rl-list .l-podium,.rl-list .l-podium.n2{grid-template-columns:minmax(0,1fr)}
  .rl-list .pd1,.rl-list .pd2,.rl-list .pd3{order:0}
  .rl-list .pd{grid-template-columns:minmax(0,1fr) auto;align-items:baseline}
  .rl-list .pd .pl,.rl-list .pd .pn{grid-column:1/-1}
  .rl-list .facts{gap:18px}
  .rl-list .l-method .wb{flex-basis:100%}
  .rl-list .wbar{flex-wrap:wrap}
  .rl-list .wbar span{flex:1 1 45%!important}
  .rl-list .pick{grid-template-columns:minmax(0,1fr)}
  .rl-list .rail{flex-direction:row;justify-content:space-between;border-right:0;border-bottom:1px solid var(--line-2);padding:14px 16px}
  .rl-list .rank{font-size:56px}
  .rl-list .pbody{padding:18px 16px 20px}
  .rl-list .br{grid-template-columns:minmax(0,1fr) 34px;gap:4px 10px}
  .rl-list .br .bt{grid-column:1/-1;grid-row:2}
  .rl-list .pc,.rl-list .needs,.rl-list .how,.rl-list .l-back,.rl-list .l-take{grid-template-columns:minmax(0,1fr)}
  .rl-list .spec{grid-template-columns:1fr 1fr}
  .rl-list .also li{grid-template-columns:1fr;gap:4px}
  .rl-list .l-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-list .cact{padding-right:16px}
  .rl-list .l-author{grid-template-columns:1fr}
  .rl-list .l-prose p,.rl-list .l-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-list .pd,.rl-list .nd,.rl-list .go2{transition:none}}
</style>
<?php }, 24);
