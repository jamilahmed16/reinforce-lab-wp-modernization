<?php
/**
 * Plugin Name: Reinforce Lab - Updates post design
 * Description: The approved Updates design (D-077, mockup claude/design-previews/blog-updates-template-mockup.html). News desk bulletin: dateline bar with status pill, official source and last checked time; rollout timeline; the update in three parts; sites to watch with a watch level; what to do now, this week and later; the official statement word for word; one in-article service CTA; live log of changes beside the article. reinforce-post.php hands Updates posts to rl_updates_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_updates_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'updates'; }
function rl_updates_statuses() { return ['announced' => 'Announced', 'rolling' => 'Rolling out', 'complete' => 'Complete', 'confirmed' => 'Confirmed', 'unconfirmed' => 'Unconfirmed']; }

/* ---------- fields (Updates only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'updates']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_updates', 'title' => 'Updates (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_u_status', 'Status', 'select', ['choices' => rl_updates_statuses(), 'allow_null' => 1, 'instructions' => 'Shown as the pill in the dateline. Unconfirmed = not confirmed by the official source.']),
            $f('rl_u_source', 'Official source', 'text', ['instructions' => 'Name | URL. Example: Google Search Central | https://...']),
            $f('rl_u_checked', 'Last checked (UTC)', 'date_time_picker', ['display_format' => 'j M Y H:i', 'return_format' => 'Y-m-d H:i:s', 'first_day' => 1, 'instructions' => 'When you last checked the official source. Update it each time you check.']),
            $f('rl_u_stages', 'Rollout timeline', 'textarea', ['rows' => 4, 'instructions' => 'Up to 5, one per line: Stage | Date or note | done, now or next. Example: Rolling out | Started 8 Oct | now']),
            $f('rl_u_what_h', 'What changed: headline', 'text'),
            $f('rl_u_what', 'What changed', 'textarea', ['rows' => 3]),
            $f('rl_u_means_h', 'What it means: headline', 'text'),
            $f('rl_u_means', 'What it means', 'textarea', ['rows' => 3]),
            $f('rl_u_do_h', 'What to do: headline', 'text'),
            $f('rl_u_do', 'What to do', 'textarea', ['rows' => 4, 'instructions' => 'One action per line.']),
            $f('rl_u_affected', 'Sites to watch', 'textarea', ['rows' => 4, 'instructions' => 'One per line: Site type | high, medium or low | Note']),
            $f('rl_u_aff_note', 'Sites to watch: note', 'text', ['default_value' => 'Our reading, not a statement from the official source.']),
            $f('rl_u_now', 'Do now', 'textarea', ['rows' => 3, 'instructions' => 'One action per line.']),
            $f('rl_u_week', 'Do this week', 'textarea', ['rows' => 3, 'instructions' => 'One action per line.']),
            $f('rl_u_later', 'Do later', 'textarea', ['rows' => 3, 'instructions' => 'One action per line.']),
            $f('rl_u_quote', 'Official statement', 'textarea', ['rows' => 3, 'instructions' => 'The exact words from the official source, copied word for word. Leave empty if there is no statement.']),
            $f('rl_u_quote_date', 'Official statement: date', 'date_picker', ['display_format' => 'j M Y', 'return_format' => 'Y-m-d']),
            $f('rl_u_log', 'Live log', 'textarea', ['rows' => 6, 'instructions' => 'One per line, newest first or any order: YYYY-MM-DD HH:MM | What changed in this post. Time is UTC and optional. Start the line with ! to tag a correction.']),
            $f('rl_u_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Shown after the official statement. Leave empty for none.']),
            $f('rl_u_cta_head', 'In-article CTA: headline', 'text'),
            $f('rl_u_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_u_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
        ],
    ]);
});

/* ---------- data ---------- */
function rl_updates_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
/* "2026-10-10 14:00" or "2026-10-10" → [iso, label, timestamp] */
function rl_updates_when($s, $year = false) {
    $s = trim($s);
    if (preg_match('/^(\d{4}-\d{2}-\d{2})(?:[ T](\d{1,2}:\d{2}))?/', $s, $m)) {
        $ts = strtotime($m[1] . ' ' . ($m[2] ?? '00:00') . ' UTC');
        if (!$ts) return null;
        if (!empty($m[2])) return [gmdate('Y-m-d\TH:i\Z', $ts), gmdate($year ? 'j M Y, H:i' : 'j M, H:i', $ts) . ' UTC', $ts];
        return [gmdate('Y-m-d', $ts), gmdate('j M Y', $ts), $ts];
    }
    return null;
}
function rl_updates_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $src = array_map('trim', explode('|', $m('rl_u_source'), 2));
    $stages = [];
    foreach (array_slice(rl_updates_rows(get_post_meta($id, 'rl_u_stages', true), 1), 0, 5) as $s) { $st = strtolower($s[2] ?? 'next'); $stages[] = ['name' => $s[0], 'note' => $s[1] ?? '', 'state' => in_array($st, ['done', 'now', 'next'], true) ? $st : 'next']; }
    $aff = [];
    foreach (rl_updates_rows(get_post_meta($id, 'rl_u_affected', true), 1) as $a) { $lv = strtolower($a[1] ?? ''); $lv = in_array($lv, ['high', 'medium', 'low'], true) ? $lv : 'medium'; $aff[] = ['type' => $a[0], 'lvl' => $lv, 'note' => $a[2] ?? '']; }
    $log = [];
    foreach (rl_updates_rows(get_post_meta($id, 'rl_u_log', true), 2) as $l) {
        $corr = strpos($l[0], '!') === 0; $w = rl_updates_when(ltrim($l[0], '! '));
        if ($w) $log[] = ['iso' => $w[0], 'label' => $w[1], 'ts' => $w[2], 'text' => $l[1], 'corr' => $corr];
    }
    usort($log, function ($a, $b) { return $b['ts'] <=> $a['ts']; });
    $chk = rl_updates_when(str_replace('T', ' ', $m('rl_u_checked')), true);
    $qd = function_exists('rl_pt_date') ? rl_pt_date($m('rl_u_quote_date')) : '';
    $note = get_post_meta($id, 'rl_u_aff_note', true);
    return $cache[$id] = ['status' => $m('rl_u_status'), 'src_name' => $src[0] ?? '', 'src_url' => esc_url_raw($src[1] ?? ''), 'checked' => $chk,
        'stages' => $stages, 'what' => [$m('rl_u_what_h'), $m('rl_u_what')], 'means' => [$m('rl_u_means_h'), $m('rl_u_means')], 'do' => [$m('rl_u_do_h'), rl_post_lines(get_post_meta($id, 'rl_u_do', true))],
        'aff' => $aff, 'aff_note' => $note === '' || $note === null ? 'Our reading, not a statement from the official source.' : trim((string) $note),
        'now' => rl_post_lines(get_post_meta($id, 'rl_u_now', true)), 'week' => rl_post_lines(get_post_meta($id, 'rl_u_week', true)), 'later' => rl_post_lines(get_post_meta($id, 'rl_u_later', true)),
        'quote' => $m('rl_u_quote'), 'quote_date' => $qd ? date_i18n('j M Y', strtotime($qd)) : '', 'log' => $log];
}

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_updates_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $x = rl_updates_data($id);
    $title = get_the_title($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $cta = null; $svc = (string) get_post_meta($id, 'rl_u_cta_service', true); $head = trim((string) get_post_meta($id, 'rl_u_cta_head', true));
    if ($svc !== '' && $head !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) {
        $cta = ['name' => rl_pt_services()[$svc], 'url' => $u($svc), 'head' => $head, 'sub' => trim((string) get_post_meta($id, 'rl_u_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_u_cta_button', true)) ?: 'See how it works'];
    }
    $diag = $u('search-authority-diagnostic');
    $statuses = rl_updates_statuses();
    $brief = array_filter(['What changed' => $x['what'], 'What it means' => $x['means'], 'What to do' => $x['do']], function ($b) { return $b[0] !== '' || !empty($b[1]); });
    $when = array_filter(['now' => ['Now', 'Today', $x['now']], 'week' => ['This week', 'While it rolls out', $x['week']], 'later' => ['Later', 'After it completes', $x['later']]], function ($w) { return (bool) $w[2]; });
    $lvl = ['high' => 'Watch closely', 'medium' => 'Watch', 'low' => 'Lower risk'];
    $src = $x['src_name'] !== '' ? ($x['src_url'] ? '<a href="' . esc_url($x['src_url']) . '" rel="noopener" target="_blank">' . esc_html($x['src_name']) . '</a>' : esc_html($x['src_name'])) : '';
    ?>
<div class="rl-page rl-post rl-upd">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<header class="wrap u-desk">
  <div class="ticker">
    <span class="u-kind">Update</span><?php if ($c['cat']) echo '<a class="u-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?>
    <?php if (isset($statuses[$x['status']])) { ?><span class="status s-<?php echo esc_attr($x['status']); ?>"><i aria-hidden="true"></i><?php echo esc_html($statuses[$x['status']]); ?></span><?php } ?>
    <span class="sp"></span>
    <?php if ($src !== '') { ?><span>Source <b><?php echo $src; ?></b></span><?php } ?>
    <?php if ($x['checked']) { ?><span>Last checked <b><time datetime="<?php echo esc_attr($x['checked'][0]); ?>"><?php echo esc_html($x['checked'][1]); ?></time></b></span><?php } ?>
  </div>
  <h1 class="u-h1"><?php echo esc_html($title); ?></h1>
  <?php if ($standfirst !== '') { ?><p class="u-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
  <div class="u-by">
    <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
    <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
    <?php if ($d['updated'] !== '') { ?><span class="fresh">Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
  </div>
  <?php if ($x['stages']) { ?>
  <ol class="roll n<?php echo count($x['stages']); ?>" aria-label="Rollout">
    <?php foreach ($x['stages'] as $s) { $lab = ['done' => 'Done', 'now' => 'Now', 'next' => 'Expected'][$s['state']]; ?>
    <li class="rs <?php echo $s['state']; ?>"<?php echo $s['state'] === 'now' ? ' aria-current="step"' : ''; ?>><span class="s"><?php echo $lab; ?></span><b><?php echo esc_html($s['name']); ?></b><?php if ($s['note'] !== '') echo '<span class="t">' . esc_html($s['note']) . '</span>'; ?></li>
    <?php } ?>
  </ol>
  <?php } ?>
</header>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap u-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="u-main<?php echo $x['log'] ? '' : ' nolog'; ?>">
    <article class="u-text">
      <?php if ($d['answer'] !== '') { ?><div class="u-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
      <?php if ($d['takeaways']) { ?><div class="u-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . sprintf('%02d', $i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>

      <?php if ($brief) { $i = 0; ?>
      <div class="sec-h" id="brief"><span>In brief</span><h2>The update in <?php echo ['', 'one part', 'two parts', 'three parts'][count($brief)]; ?></h2></div>
      <div class="brief n<?php echo count($brief); ?>">
        <?php foreach ($brief as $lab => $b) { $i++; ?>
        <div class="bf"><span class="n"><?php echo sprintf('%02d', $i); ?> · <?php echo esc_html($lab); ?></span><?php if ($b[0] !== '') echo '<h3>' . esc_html($b[0]) . '</h3>'; ?>
          <?php if (is_array($b[1])) { if ($b[1]) echo '<ul>' . implode('', array_map(function ($a) { return '<li>' . esc_html($a) . '</li>'; }, $b[1])) . '</ul>'; } elseif ($b[1] !== '') echo '<p>' . esc_html($b[1]) . '</p>'; ?></div>
        <?php } ?>
      </div>
      <?php } ?>

      <?php if ($x['aff']) { ?>
      <div class="sec-h" id="who"><span>Who is affected</span><h2>Sites to watch</h2></div>
      <div class="aff"><?php foreach ($x['aff'] as $a) echo '<div class="ar"><b>' . esc_html($a['type']) . '</b><div class="lvl ' . $a['lvl'] . '"><span>' . $lvl[$a['lvl']] . '</span><span class="m" aria-hidden="true"><i></i><i></i><i></i></span></div>' . ($a['note'] !== '' ? '<p>' . esc_html($a['note']) . '</p>' : '<p></p>') . '</div>'; ?></div>
      <?php if ($x['aff_note'] !== '') { ?><p class="anote"><?php echo esc_html($x['aff_note']); ?></p><?php } ?>
      <?php } ?>

      <?php if ($when) { ?>
      <div class="sec-h" id="do"><span>Your next steps</span><h2>What to do, and when</h2></div>
      <div class="acts n<?php echo count($when); ?>">
        <?php foreach ($when as $k => $w) { ?><div class="when <?php echo $k; ?>"><div class="wh"><b><?php echo $w[0]; ?></b><span><?php echo $w[1]; ?></span></div><ul><?php foreach ($w[2] as $a) echo '<li>' . esc_html($a) . '</li>'; ?></ul></div><?php } ?>
      </div>
      <?php } ?>

      <?php if ($x['quote'] !== '') { ?>
      <div class="sec-h" id="official"><span>Official source</span><h2>What <?php echo esc_html($x['src_name'] !== '' ? $x['src_name'] : 'the source'); ?> said</h2></div>
      <figure class="official">
        <span class="mk" aria-hidden="true">&ldquo;</span>
        <div><blockquote<?php echo $x['src_url'] ? ' cite="' . esc_url($x['src_url']) . '"' : ''; ?>><?php echo esc_html($x['quote']); ?></blockquote>
          <figcaption class="by"><?php echo esc_html(trim($x['src_name'] . ($x['quote_date'] ? ', ' . $x['quote_date'] : ''), ', ')); ?><?php if ($x['src_url']) echo ' · <a href="' . esc_url($x['src_url']) . '" rel="noopener" target="_blank">Read the announcement</a>'; ?></figcaption></div>
      </figure>
      <?php } ?>

      <?php if ($cta) { ?>
      <aside class="u-icta" aria-label="Reinforce Lab service">
        <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
        <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
      </aside>
      <?php } ?>

      <?php if (trim($c['body']) !== '') echo '<div class="u-prose">' . $c['body'] . '</div>'; ?>
    </article>

    <?php if ($x['log']) { ?>
    <aside class="u-log" aria-label="Live updates to this post">
      <div class="lh"><b><?php if ($x['status'] === 'rolling') echo '<i aria-hidden="true"></i>'; ?>Live log</b><span>Newest first</span></div>
      <ol><?php foreach ($x['log'] as $k => $l) echo '<li' . ($k === 0 ? ' class="new"' : '') . '><div><time datetime="' . esc_attr($l['iso']) . '">' . esc_html($l['label']) . '</time><p>' . esc_html($l['text']) . ($l['corr'] ? '<span class="tag">Correction</span>' : '') . '</p></div></li>'; ?></ol>
      <?php if ($x['quote'] !== '' || $x['src_url']) { ?><div class="ft"><a href="<?php echo $x['quote'] !== '' ? '#official' : esc_url($x['src_url']); ?>">Official source</a></div><?php } ?>
    </aside>
    <?php } ?>
  </div>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <div class="u-back">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="u-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </div>
  <?php } ?>

  <aside class="u-author" aria-label="About the author">
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
<?php
}

/* ---------- schema: dateModified follows the newest live log entry ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_updates_view()) return $graph;
    $id = get_queried_object_id(); $x = rl_updates_data($id);
    $latest = $x['log'] ? $x['log'][0]['ts'] : 0;
    if ($x['checked'] && $x['checked'][2] > $latest) $latest = $x['checked'][2];
    if (!$latest || $latest > time() + 3600) return $graph;
    $iso = gmdate('c', $latest);
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if ((in_array('Article', $t, true) || in_array('WebPage', $t, true)) && (empty($n['dateModified']) || strtotime($n['dateModified']) < $latest)) $n['dateModified'] = $iso;
    }
    unset($n);
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_updates_view()) return; ?>
<style id="rl-updates-css">
.rl-upd{color:var(--ink-dim);--ok:#3fa36b;--amber:#d39b3a}
.rl-upd h1,.rl-upd h2,.rl-upd h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-upd .u-desk{padding-block:clamp(22px,3vw,34px) 0}
.rl-upd .ticker{display:flex;flex-wrap:wrap;align-items:center;gap:10px 14px;border-block:1px solid var(--line-2);padding:10px 0;font-family:var(--f-mono);font-size:11.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-upd .u-kind{color:#fff;background:var(--red);padding:5px 10px;letter-spacing:.2em}
.rl-upd .u-cat{color:var(--ink-dim);border:1px solid var(--line-2);padding:4px 10px;letter-spacing:.16em;text-decoration:none}
.rl-upd .status{display:inline-flex;align-items:center;gap:8px;border:1px solid currentColor;padding:4px 10px}
.rl-upd .status i{width:8px;height:8px;background:currentColor}
.rl-upd .s-rolling,.rl-upd .s-announced{color:var(--amber)}
.rl-upd .s-complete,.rl-upd .s-confirmed{color:var(--ok)}
.rl-upd .s-unconfirmed{color:var(--ink-dim)}
.rl-upd .s-rolling i{animation:rlpulse 1.6s ease-in-out infinite}
@keyframes rlpulse{50%{opacity:.25}}
.rl-upd .ticker .sp{flex:1}
.rl-upd .ticker b{color:var(--ink);font-weight:500}
.rl-upd .ticker b a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-upd .u-h1{font-size:clamp(34px,5vw,64px);line-height:1;max-width:1000px;margin:22px 0 0}
.rl-upd .u-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;max-width:720px;margin:16px 0 0}
.rl-upd .u-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:20px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-upd .u-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-upd .u-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-upd .u-by b{color:var(--ink-dim);font-weight:500}
.rl-upd .u-by .fresh,.rl-upd .u-by .fresh b{color:var(--ok)}
.rl-upd .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-upd .roll{list-style:none;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));margin:26px 0 0;padding:0;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-upd .roll.n1{grid-template-columns:minmax(0,1fr)}
.rl-upd .roll.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-upd .roll.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-upd .roll.n5{grid-template-columns:repeat(5,minmax(0,1fr))}
.rl-upd .rs{padding:14px 16px;margin:0;border-right:1px solid var(--line);position:relative;display:grid;gap:4px;align-content:start;min-width:0}
.rl-upd .rs:last-child{border-right:0}
.rl-upd .rs::before{content:"";position:absolute;left:0;right:0;top:0;height:3px;background:var(--line-2)}
.rl-upd .rs.done::before{background:var(--red-3)}
.rl-upd .rs.now::before{background:linear-gradient(90deg,var(--red-3) 50%,var(--line-2) 50%)}
.rl-upd .rs .s{font-family:var(--f-mono);font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-upd .rs.now .s{color:var(--amber)}
.rl-upd .rs b{font-family:var(--f-display);font-size:18px;text-transform:uppercase;color:var(--ink);font-weight:500}
.rl-upd .rs.next b{color:var(--ink-faint)}
.rl-upd .rs .t{font-family:var(--f-mono);font-size:12px;color:var(--ink-dim)}
.rl-upd .u-feat{margin:28px auto 0}
.rl-upd .u-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-upd .u-main{display:grid;grid-template-columns:minmax(0,780px) minmax(0,1fr);gap:clamp(30px,5vw,64px);padding-block:clamp(34px,5vw,52px) 10px;align-items:start}
.rl-upd .u-main.nolog{grid-template-columns:minmax(0,780px)}
.rl-upd .u-text{min-width:0}
.rl-upd .u-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-upd .u-answer .t,.rl-upd .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-upd .u-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-upd .u-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:28px}
.rl-upd .u-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-upd .u-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-upd .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px;scroll-margin-top:96px}
.rl-upd .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-upd .u-answer + .sec-h,.rl-upd .u-take + .sec-h{margin-top:30px}
.rl-upd .brief{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-upd .brief.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-upd .brief.n1{grid-template-columns:minmax(0,1fr)}
.rl-upd .bf{background:var(--panel);padding:18px 18px 20px;display:grid;gap:8px;align-content:start;min-width:0}
.rl-upd .bf .n{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3)}
.rl-upd .bf h3{font-size:18px;margin:0}
.rl-upd .bf p{margin:0;font-size:15px}
.rl-upd .bf ul{margin:0;padding-left:1.1em;font-size:15px}
.rl-upd .bf li{padding:2px 0;margin:0}
.rl-upd .bf li::marker{color:var(--red-3)}
.rl-upd .aff{border:1px solid var(--line-2)}
.rl-upd .ar{display:grid;grid-template-columns:minmax(0,1fr) 150px minmax(0,1.2fr);gap:16px;align-items:center;padding:14px 18px;border-top:1px solid var(--line)}
.rl-upd .ar:first-child{border-top:0}
.rl-upd .ar b{color:var(--ink);font-weight:600;font-size:15.5px}
.rl-upd .ar p{margin:0;font-size:14.5px}
.rl-upd .lvl{display:grid;gap:5px}
.rl-upd .lvl span:first-child{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase}
.rl-upd .lvl .m{display:flex;gap:3px}
.rl-upd .lvl .m i{flex:1;height:6px;background:var(--line-2)}
.rl-upd .lvl.high span:first-child{color:var(--red-3)}
.rl-upd .lvl.high .m i{background:var(--red-3)}
.rl-upd .lvl.medium span:first-child{color:var(--amber)}
.rl-upd .lvl.medium .m i:nth-child(-n+2){background:var(--amber)}
.rl-upd .lvl.low span:first-child{color:var(--ok)}
.rl-upd .lvl.low .m i:first-child{background:var(--ok)}
.rl-upd .anote{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);margin:8px 0 0}
.rl-upd .acts{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
.rl-upd .acts.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-upd .acts.n1{grid-template-columns:minmax(0,1fr)}
.rl-upd .when{border:1px solid var(--line-2);background:var(--bg-2);min-width:0}
.rl-upd .when .wh{display:grid;gap:2px;padding:12px 16px;border-bottom:1px solid var(--line-2)}
.rl-upd .when .wh b{font-family:var(--f-display);font-size:18px;text-transform:uppercase;color:var(--ink);font-weight:500}
.rl-upd .when .wh span{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-upd .when.now{border-color:var(--red-line)}
.rl-upd .when.now .wh{background:linear-gradient(90deg,rgba(153,0,0,.25),transparent)}
.rl-upd .when ul{list-style:none;margin:0;padding:6px 16px 12px}
.rl-upd .when li{display:grid;grid-template-columns:18px 1fr;gap:8px;padding:8px 0;margin:0;border-top:1px solid var(--line);font-size:14.5px}
.rl-upd .when li:first-child{border-top:0}
.rl-upd .when li::before{content:"";width:12px;height:12px;border:1px solid var(--line-2);margin-top:5px}
.rl-upd .when.now li::before{border-color:var(--red-3)}
.rl-upd .official{border:1px solid var(--line-2);background:var(--panel);display:grid;grid-template-columns:auto minmax(0,1fr);gap:18px;padding:22px 24px;align-items:start;margin:0}
.rl-upd .official .mk{font-family:var(--f-display);font-size:64px;line-height:.7;color:var(--red-3)}
.rl-upd .official blockquote{margin:0;padding:0;border:0;color:var(--ink);font-family:var(--f-body);text-transform:none;font-size:18px;line-height:1.6}
.rl-upd .official .by{margin:12px 0 0;font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);text-align:left}
.rl-upd .official .by a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-upd .u-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-upd .u-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-upd .u-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-upd .u-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-upd .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-upd .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-upd .go2:hover{background:var(--red-2)}
.rl-upd .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-upd .u-prose{margin-top:46px}
.rl-upd .u-prose>*{margin:0 0 1.1em}
.rl-upd .u-prose p,.rl-upd .u-prose li{font-size:17.5px;line-height:1.75}
.rl-upd .u-prose h2{font-size:clamp(24px,2.8vw,30px);margin:1.8em 0 .6em;scroll-margin-top:96px}
.rl-upd .u-prose h2:first-child{margin-top:0}
.rl-upd .u-prose h3{font-size:21px;margin:1.4em 0 .5em;scroll-margin-top:96px}
.rl-upd .u-prose strong{color:var(--ink);font-weight:600}
.rl-upd .u-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-upd .u-prose ul,.rl-upd .u-prose ol{padding-left:1.2em}
.rl-upd .u-prose li::marker{color:var(--red-3)}
.rl-upd .u-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-upd .u-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-upd .u-prose th,.rl-upd .u-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-upd .u-log{position:sticky;top:96px;border:1px solid var(--line-2);background:var(--panel)}
.rl-upd .u-log .lh{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:14px 18px;border-bottom:1px solid var(--line-2);background:var(--bg-2)}
.rl-upd .u-log .lh b{font-family:var(--f-display);font-size:19px;text-transform:uppercase;color:var(--ink);font-weight:600;display:flex;align-items:center;gap:10px}
.rl-upd .u-log .lh b i{width:8px;height:8px;background:var(--red-3);animation:rlpulse 1.6s ease-in-out infinite}
.rl-upd .u-log .lh span{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-upd .u-log ol{list-style:none;margin:0;padding:6px 18px 10px}
.rl-upd .u-log li{display:grid;grid-template-columns:14px minmax(0,1fr);gap:10px;padding:10px 0;margin:0;border-top:1px solid var(--line)}
.rl-upd .u-log li:first-child{border-top:0}
.rl-upd .u-log li::before{content:"";width:9px;height:9px;margin-top:6px;border:2px solid var(--line-2)}
.rl-upd .u-log li.new::before{border-color:var(--red-3);background:var(--red-3)}
.rl-upd .u-log time{display:block;font-family:var(--f-mono);font-size:11px;color:var(--ink-faint)}
.rl-upd .u-log li.new time{color:var(--red-3)}
.rl-upd .u-log p{margin:2px 0 0;font-size:14px;color:var(--ink)}
.rl-upd .u-log .tag{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--amber);border:1px solid rgba(211,155,58,.45);padding:0 5px;margin-left:6px;white-space:nowrap}
.rl-upd .u-log .ft{border-top:1px solid var(--line-2);padding:12px 18px;font-size:13px}
.rl-upd .u-log .ft a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-upd .u-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-upd .u-back .sec-h{margin-top:0}
.rl-upd .u-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-upd .u-src li{padding:6px 0;color:var(--ink-faint)}
.rl-upd .u-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-upd .u-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-upd .u-author .av{width:72px;height:72px;font-size:28px}
.rl-upd .u-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-upd .u-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-upd .u-author p{margin:0 0 8px;font-size:15px}
.rl-upd .u-author .links{display:flex;gap:18px;font-size:14px}
.rl-upd .u-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:1000px){
  .rl-upd .u-main{grid-template-columns:minmax(0,1fr)}
  .rl-upd .u-log{position:static;order:-1}
  .rl-upd .acts,.rl-upd .acts.n2{grid-template-columns:minmax(0,1fr)}
}
@media(max-width:760px){
  .rl-upd .ticker .sp{display:none}
  .rl-upd .roll,.rl-upd .roll.n3,.rl-upd .roll.n5{grid-template-columns:repeat(2,minmax(0,1fr))}
  .rl-upd .rs:nth-child(2n){border-right:0}
  .rl-upd .rs:nth-child(n+3){border-top:1px solid var(--line)}
  .rl-upd .brief,.rl-upd .brief.n2{grid-template-columns:minmax(0,1fr)}
  .rl-upd .ar{grid-template-columns:minmax(0,1fr) 120px;gap:8px 14px}
  .rl-upd .ar p{grid-column:1/-1}
  .rl-upd .official{grid-template-columns:minmax(0,1fr)}
  .rl-upd .official .mk{font-size:48px}
  .rl-upd .u-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-upd .cact{padding-right:16px}
  .rl-upd .u-back,.rl-upd .u-take{grid-template-columns:minmax(0,1fr)}
  .rl-upd .u-author{grid-template-columns:1fr}
  .rl-upd .u-prose p,.rl-upd .u-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-upd .s-rolling i,.rl-upd .u-log .lh b i{animation:none}.rl-upd .go2{transition:none}}
</style>
<?php }, 24);
