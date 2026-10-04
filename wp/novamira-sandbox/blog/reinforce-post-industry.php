<?php
/**
 * Plugin Name: Reinforce Lab - Industry post design
 * Description: The approved Industry design (D-077, mockup claude/design-previews/blog-industry-template-mockup.html). Sector briefing: cover with the industry band, written for, reviewed by and markets covered; sector at a glance; sector rules as a compliance checklist; buyer journey by stage; one in-article CTA; where to start (moves with impact and effort); what works and what to avoid; industry card with the industry page and services. reinforce-post.php hands Industry posts to rl_industry_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_industry_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'industry'; }

/* ---------- fields (Industry only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'industry']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_industry', 'title' => 'Industry (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_i_industry', 'Industry', 'select', ['choices' => function_exists('rl_pt_industries') ? rl_pt_industries() : [], 'allow_null' => 1, 'instructions' => 'Names the sector on the cover and fills the industry card with the industry page and its services.']),
            $f('rl_i_audience', 'Written for', 'text', ['instructions' => 'e.g. Marketing and medical affairs teams']),
            $f('rl_i_reviewer', 'Reviewed for accuracy by', 'text', ['instructions' => 'Name, qualification. Example: Jamil Ahmed, Pharmacist. Only a real reviewer who checked this post. Leave empty to hide.']),
            $f('rl_i_markets', 'Markets covered', 'text', ['instructions' => 'e.g. UK, EU and US']),
            $f('rl_i_glance', 'Sector at a glance', 'textarea', ['rows' => 4, 'instructions' => 'Up to 4, one per line: Label | Headline | One line. Example: Search risk | Your money or your life | Health content is held to the highest bar.']),
            $f('rl_i_rules', 'Sector rules', 'textarea', ['rows' => 4, 'instructions' => 'One per line: Rule | Market it applies to | What it means for search. Numbered R1, R2 and so on automatically.']),
            $f('rl_i_rules_note', 'Rules: note under the list', 'text', ['default_value' => 'General guidance, not legal or regulatory advice.']),
            $f('rl_i_journey', 'Buyer journey', 'textarea', ['rows' => 4, 'instructions' => 'Up to 4 stages, one per line: Stage | Who searches | Question one; Question two | Content that answers. Example: Learn | Patients, carers | what causes x; x treatment options | Unbranded disease education']),
            $f('rl_i_moves', 'Where to start', 'textarea', ['rows' => 5, 'instructions' => 'Up to 6, in order, one per line: Move | What to do | Impact 1 to 3 | Effort 1 to 3']),
            $f('rl_i_works', 'What works', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_i_avoid', 'What to avoid', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_i_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Empty = links to the industry page.']),
            $f('rl_i_cta_head', 'In-article CTA: headline', 'text', ['instructions' => 'Shown after the buyer journey. Leave empty for no CTA.']),
            $f('rl_i_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_i_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how we work with your sector']),
        ],
    ]);
});

/* ---------- data ---------- */
function rl_industry_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
function rl_industry_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $k = $m('rl_i_industry');
    $ind = ($k !== '' && function_exists('rl_ind_data') && isset(rl_ind_data()[$k])) ? rl_ind_data()[$k] : null;
    $journey = [];
    foreach (array_slice(rl_industry_rows(get_post_meta($id, 'rl_i_journey', true), 1), 0, 4) as $j)
        $journey[] = ['stage' => $j[0], 'who' => $j[1] ?? '', 'qs' => array_values(array_filter(array_map('trim', explode(';', $j[2] ?? '')))), 'ct' => $j[3] ?? ''];
    $lvl = function ($v) { $n = (int) $v; return $n >= 1 && $n <= 3 ? $n : 0; };
    $moves = [];
    foreach (array_slice(rl_industry_rows(get_post_meta($id, 'rl_i_moves', true), 1), 0, 6) as $mv) $moves[] = ['t' => $mv[0], 'd' => $mv[1] ?? '', 'imp' => $lvl($mv[2] ?? 0), 'eff' => $lvl($mv[3] ?? 0)];
    $note = get_post_meta($id, 'rl_i_rules_note', true);
    return $cache[$id] = ['key' => $ind ? $k : '', 'ind' => $ind, 'audience' => $m('rl_i_audience'), 'reviewer' => $m('rl_i_reviewer'), 'markets' => $m('rl_i_markets'),
        'glance' => array_slice(rl_industry_rows(get_post_meta($id, 'rl_i_glance', true), 2), 0, 4), 'rules' => rl_industry_rows(get_post_meta($id, 'rl_i_rules', true), 1),
        'rules_note' => $note === '' || $note === null ? 'General guidance, not legal or regulatory advice.' : trim((string) $note),
        'journey' => $journey, 'moves' => $moves, 'works' => rl_post_lines(get_post_meta($id, 'rl_i_works', true)), 'avoid' => rl_post_lines(get_post_meta($id, 'rl_i_avoid', true))];
}

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_industry_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $x = rl_industry_data($id);
    $title = get_the_title($id);
    $tp = explode(':', $title, 2);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $parts = preg_split('#(?=<h2\b)#i', $c['body'], 2);
    $intro = trim($parts[0]); $more = trim($parts[1] ?? '');
    $indurl = $x['key'] !== '' ? $u('industries/' . $x['key']) : '';
    $cta = null; $head = trim((string) get_post_meta($id, 'rl_i_cta_head', true)); $svc = (string) get_post_meta($id, 'rl_i_cta_service', true);
    if ($head !== '') {
        if ($svc !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) $cta = ['name' => rl_pt_services()[$svc], 'url' => $u($svc)];
        elseif ($x['ind'] && $indurl) $cta = ['name' => $x['ind']['name'], 'url' => $indurl];
        if ($cta) $cta += ['head' => $head, 'sub' => trim((string) get_post_meta($id, 'rl_i_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_i_cta_button', true)) ?: 'See how we work with your sector'];
    }
    $diag = $u('search-authority-diagnostic');
    $ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $no = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M4 4l8 8M12 4l-8 8"/></svg>';
    $warn = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M8 2l7 12H1z M8 6v4 M8 12v1"/></svg>';
    $bar = function ($n) { $h = ''; for ($i = 1; $i <= 3; $i++) $h .= '<i' . ($i <= $n ? ' class="on"' : '') . '></i>'; return $h; };
    $meta = array_filter([['Written for', $x['audience'], ''], ['Reviewed for accuracy by', $x['reviewer'], 'rev'], ['Markets covered', $x['markets'], '']], function ($r) { return $r[1] !== ''; });
    ?>
<div class="rl-page rl-post rl-ind">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<div class="wrap">
  <header class="i-cover">
    <div class="i-band" aria-hidden="true"><span>Industry briefing</span></div>
    <div class="cv">
      <div class="cv-top">
        <div class="i-kicker"><span class="i-kind">Industry</span><?php if ($c['cat']) echo '<a class="i-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
        <?php if ($x['ind']) { ?><span class="sector">Sector <?php echo $indurl ? '<a href="' . esc_url($indurl) . '">' . esc_html($x['ind']['name']) . '</a>' : '<b>' . esc_html($x['ind']['name']) . '</b>'; ?></span><?php } ?>
      </div>
      <h1 class="i-h1"><?php echo count($tp) === 2 ? esc_html($tp[0]) . ':<em>' . esc_html($tp[1]) . '</em>' : esc_html($title); ?></h1>
      <?php if ($standfirst !== '') { ?><p class="i-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
      <?php if ($meta) { ?><dl class="i-meta n<?php echo count($meta); ?>"><?php foreach ($meta as $r) echo '<div' . ($r[2] ? ' class="' . $r[2] . '"' : '') . '><dt>' . esc_html($r[0]) . '</dt><dd>' . ($r[2] === 'rev' ? $ok : '') . esc_html($r[1]) . '</dd></div>'; ?></dl><?php } ?>
      <div class="i-by">
        <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
        <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
        <?php if ($d['updated'] !== '') { ?><span class="fresh">Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
      </div>
    </div>
  </header>
  <?php if ($x['glance']) { ?>
  <div class="i-glance n<?php echo count($x['glance']); ?>" aria-label="The sector at a glance"><?php foreach ($x['glance'] as $g) echo '<div class="gl"><span class="k">' . esc_html($g[0]) . '</span><b>' . esc_html($g[1]) . '</b>' . (!empty($g[2]) ? '<p>' . esc_html($g[2]) . '</p>' : '') . '</div>'; ?></div>
  <?php } ?>
</div>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap i-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="i-main">
    <?php if ($d['answer'] !== '') { ?><div class="i-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
    <?php if ($d['takeaways']) { ?><div class="i-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . sprintf('%02d', $i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>
    <?php if ($intro !== '') echo '<div class="i-prose">' . $intro . '</div>'; ?>

    <?php if ($x['rules']) { ?>
    <div class="sec-h" id="rules"><span>Sector rules</span><h2>Rules to know before you publish</h2><p>Check every page against these before it goes live. Your own regulatory or legal team has the final word.</p></div>
    <div class="rules">
      <div class="rh"><span>Rule and what it means for search</span><b><?php echo $warn; ?>Compliance</b></div>
      <?php foreach ($x['rules'] as $k => $r) echo '<div class="rule"><span class="code">R' . ($k + 1) . '</span><h3>' . esc_html($r[0]) . (!empty($r[1]) ? '<small>' . esc_html($r[1]) . '</small>' : '') . '</h3><p>' . esc_html($r[2] ?? '') . '</p></div>'; ?>
    </div>
    <?php if ($x['rules_note'] !== '') { ?><p class="rnote"><?php echo esc_html($x['rules_note']); ?></p><?php } ?>
    <?php } ?>

    <?php if ($x['journey']) { ?>
    <div class="sec-h" id="journey"><span>Buyer journey</span><h2>What your audiences search for</h2></div>
    <ol class="journey n<?php echo count($x['journey']); ?>">
      <?php foreach ($x['journey'] as $k => $j) { ?>
      <li class="stage"><span class="dot" aria-hidden="true"><?php echo $k + 1; ?></span><h3><?php echo esc_html($j['stage']); ?></h3><?php if ($j['who'] !== '') echo '<span class="who">' . esc_html($j['who']) . '</span>'; ?>
        <?php if ($j['qs']) { ?><ul class="qs" aria-label="Example searches"><?php foreach ($j['qs'] as $q) echo '<li>' . esc_html($q) . '</li>'; ?></ul><?php } ?>
        <?php if ($j['ct'] !== '') echo '<p class="ct"><b>Content that answers</b>' . esc_html($j['ct']) . '</p>'; ?></li>
      <?php } ?>
    </ol>
    <?php } ?>

    <?php if ($more !== '') echo '<div class="i-prose i-more">' . $more . '</div>'; ?>

    <?php if ($cta) { ?>
    <aside class="i-icta" aria-label="Reinforce Lab service">
      <div><p class="lbl">Reinforce Lab · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
      <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
    </aside>
    <?php } ?>

    <?php if ($x['moves']) { ?>
    <div class="sec-h" id="moves"><span>Where to start</span><h2><?php echo esc_html(ucfirst(['', 'one', 'two', 'three', 'four', 'five', 'six'][count($x['moves'])])); ?> move<?php echo count($x['moves']) > 1 ? 's' : ''; ?>, in order</h2></div>
    <ol class="moves">
      <?php foreach ($x['moves'] as $k => $mv) { ?>
      <li class="mv"><span class="n" aria-hidden="true"><?php echo $k + 1; ?></span><div><h3><?php echo esc_html($mv['t']); ?></h3><?php if ($mv['d'] !== '') echo '<p>' . esc_html($mv['d']) . '</p>'; ?></div>
        <?php if ($mv['imp'] || $mv['eff']) { ?><div class="tags"><?php if ($mv['imp']) echo '<span class="tg imp">Impact<span class="bar" role="img" aria-label="Impact ' . (int) $mv['imp'] . ' of 3">' . $bar($mv['imp']) . '</span></span>'; ?><?php if ($mv['eff']) echo '<span class="tg eff">Effort<span class="bar" role="img" aria-label="Effort ' . (int) $mv['eff'] . ' of 3">' . $bar($mv['eff']) . '</span></span>'; ?></div><?php } ?></li>
      <?php } ?>
    </ol>
    <?php } ?>

    <?php if ($x['works'] || $x['avoid']) { ?>
    <div class="sec-h"><span>In this sector</span><h2>What works and what to avoid</h2></div>
    <div class="wa<?php echo ($x['works'] && $x['avoid']) ? '' : ' one'; ?>">
      <?php if ($x['works']) { ?><div class="wk"><p class="h"><?php echo $ok; ?>Works</p><ul><?php foreach ($x['works'] as $w) echo '<li>' . $ok . '<span>' . esc_html($w) . '</span></li>'; ?></ul></div><?php } ?>
      <?php if ($x['avoid']) { ?><div class="av2"><p class="h"><?php echo $no; ?>Avoid</p><ul><?php foreach ($x['avoid'] as $w) echo '<li>' . $no . '<span>' . esc_html($w) . '</span></li>'; ?></ul></div><?php } ?>
    </div>
    <?php } ?>

    <?php if ($x['ind']) { $svcs = array_slice($x['ind']['svc'] ?? [], 0, 3); ?>
    <div class="indcard<?php echo $svcs ? '' : ' one'; ?>">
      <div class="l"><span class="k">Industry</span><h2><?php echo esc_html($x['ind']['name']); ?></h2><?php if (!empty($x['ind']['sum'])) echo '<p>' . esc_html($x['ind']['sum']) . '</p>'; ?><?php if ($indurl) echo '<a class="more" href="' . esc_url($indurl) . '">How we work with this sector &rarr;</a>'; ?></div>
      <?php if ($svcs && function_exists('rl_url_by_path')) { ?><ul><?php foreach ($svcs as $s) { $su = rl_url_by_path($s[0], ''); echo '<li>' . ($su ? '<a href="' . esc_url($su) . '">' : '<span class="na">') . '<span>' . esc_html($s[1]) . (!empty($s[2]) ? '<small>' . esc_html($s[2]) . '</small>' : '') . '</span>' . ($su ? '<span class="ar" aria-hidden="true">&rarr;</span></a>' : '</span>') . '</li>'; } ?></ul><?php } ?>
    </div>
    <?php } ?>
  </div>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <div class="i-back">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="i-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </div>
  <?php } ?>

  <aside class="i-author" aria-label="About the author">
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

/* ---------- schema: the article is about the industry; the reviewer goes on the page ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_industry_view()) return $graph;
    $id = get_queried_object_id(); $x = rl_industry_data($id);
    $rev = null;
    if ($x['reviewer'] !== '') {
        $p = array_map('trim', explode(',', $x['reviewer'], 2));
        $founder = function_exists('rl_about_person') ? rl_about_person() : null;
        $ju = $founder && $p[0] === $founder['name'] ? get_user_by('login', 'jamilahmed') : null;
        $rev = ($ju && function_exists('rl_person_schema_id')) ? ['@id' => rl_person_schema_id($ju->ID)] : array_filter(['@type' => 'Person', 'name' => $p[0], 'jobTitle' => $p[1] ?? '']);
    }
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if ($x['ind'] && in_array('Article', $t, true)) $n['about'] = ['@type' => 'Thing', 'name' => $x['ind']['name']];
        if ($rev && in_array('WebPage', $t, true)) { $n['reviewedBy'] = $rev; $n['lastReviewed'] = get_the_modified_date('Y-m-d', $id); }
    }
    unset($n);
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_industry_view()) return; ?>
<style id="rl-industry-css">
.rl-ind{color:var(--ink-dim);--ok:#3fa36b;--amber:#d39b3a}
.rl-ind h1,.rl-ind h2,.rl-ind h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-ind .ic{width:14px;height:14px;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:square}
.rl-ind .i-cover{display:grid;grid-template-columns:64px minmax(0,1fr);margin-top:clamp(22px,3vw,34px);border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2))}
.rl-ind .i-cover .i-band{background:repeating-linear-gradient(180deg,var(--red) 0 10px,#7a0000 10px 20px);display:flex;align-items:center;justify-content:center;padding:0;margin:0}
.rl-ind .i-cover .i-band span{writing-mode:vertical-rl;transform:rotate(180deg);font-family:var(--f-mono);font-size:11px;letter-spacing:.3em;text-transform:uppercase;color:#fff;white-space:nowrap}
.rl-ind .cv{padding:clamp(22px,3vw,36px);display:grid;gap:16px;min-width:0}
.rl-ind .cv-top{display:flex;flex-wrap:wrap;justify-content:space-between;gap:10px;align-items:center}
.rl-ind .i-kicker{display:flex;flex-wrap:wrap;gap:10px}
.rl-ind .i-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-ind .i-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-ind .sector{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-ind .sector b,.rl-ind .sector a{color:var(--ink);font-weight:500;text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-ind .i-h1{font-size:clamp(34px,4.8vw,62px);line-height:1;max-width:980px;margin:0}
.rl-ind .i-h1 em{font-style:normal;color:var(--red-3)}
.rl-ind .i-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;max-width:720px;margin:0}
.rl-ind .i-meta{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));border-top:1px dashed var(--line-2);padding-top:16px;gap:16px;margin:0}
.rl-ind .i-meta.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-ind .i-meta.n1{grid-template-columns:minmax(0,1fr)}
.rl-ind .i-meta dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:4px}
.rl-ind .i-meta dd{margin:0;color:var(--ink);font-weight:500;font-size:14.5px;display:flex;align-items:center;gap:8px}
.rl-ind .i-meta .rev .ic{color:var(--ok)}
.rl-ind .i-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-ind .i-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-ind .i-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-ind .i-by b{color:var(--ink-dim);font-weight:500}
.rl-ind .i-by .fresh,.rl-ind .i-by .fresh b{color:var(--ok)}
.rl-ind .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-ind .i-glance{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2);border-top:0}
.rl-ind .i-glance.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-ind .i-glance.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-ind .i-glance.n1{grid-template-columns:minmax(0,1fr)}
.rl-ind .gl{background:var(--bg-2);padding:16px 18px;display:grid;gap:4px;align-content:start}
.rl-ind .gl .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3)}
.rl-ind .gl b{font-family:var(--f-display);font-size:19px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1.1}
.rl-ind .gl p{margin:0;font-size:13.5px}
.rl-ind .i-feat{margin:28px auto 0}
.rl-ind .i-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-ind .i-main{max-width:900px;margin:0 auto;padding-block:clamp(34px,5vw,52px) 10px}
.rl-ind .i-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-ind .i-answer .t,.rl-ind .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-ind .i-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-ind .i-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:28px}
.rl-ind .i-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-ind .i-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-ind .i-prose>*{margin:0 0 1.1em}
.rl-ind .i-prose p,.rl-ind .i-prose li{font-size:17.5px;line-height:1.75}
.rl-ind .i-prose h2{font-size:clamp(24px,2.8vw,30px);margin:1.8em 0 .6em;scroll-margin-top:96px}
.rl-ind .i-prose h3{font-size:21px;margin:1.4em 0 .5em;scroll-margin-top:96px}
.rl-ind .i-prose strong{color:var(--ink);font-weight:600}
.rl-ind .i-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-ind .i-prose ul,.rl-ind .i-prose ol{padding-left:1.2em}
.rl-ind .i-prose li::marker{color:var(--red-3)}
.rl-ind .i-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-ind .i-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-ind .i-prose th,.rl-ind .i-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-ind .i-more{margin-top:12px}
.rl-ind .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px;scroll-margin-top:96px}
.rl-ind .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-ind .sec-h p{flex-basis:100%;margin:2px 0 0;font-size:15px}
.rl-ind .rules{border:1px solid var(--line-2);background:var(--panel)}
.rl-ind .rules .rh{display:flex;justify-content:space-between;gap:10px;padding:12px 18px;border-bottom:1px solid var(--line-2);background:var(--bg-2);font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-ind .rules .rh b{color:var(--amber);font-weight:500;display:flex;gap:8px;align-items:center}
.rl-ind .rules .rh .ic{stroke-width:1.6}
.rl-ind .rule{display:grid;grid-template-columns:70px minmax(0,1fr) minmax(0,1.3fr);gap:16px;padding:16px 18px;border-top:1px solid var(--line);align-items:start}
.rl-ind .rh + .rule{border-top:0}
.rl-ind .rule .code{font-family:var(--f-mono);font-size:11px;color:var(--amber);border:1px solid rgba(211,155,58,.45);padding:3px 6px;text-align:center}
.rl-ind .rule h3{font-family:var(--f-body);text-transform:none;letter-spacing:0;font-size:16px;font-weight:600;line-height:1.35;margin:0}
.rl-ind .rule h3 small{display:block;font-family:var(--f-mono);font-size:10.5px;font-weight:400;letter-spacing:.08em;color:var(--ink-faint);margin-top:4px;text-transform:uppercase}
.rl-ind .rule p{margin:0;font-size:15px}
.rl-ind .rnote{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);margin:8px 0 0}
.rl-ind .journey{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));position:relative}
.rl-ind .journey.n4{grid-template-columns:repeat(4,minmax(0,1fr))}
.rl-ind .journey.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-ind .journey.n1{grid-template-columns:minmax(0,1fr)}
.rl-ind .journey::before{content:"";position:absolute;left:0;right:0;top:19px;height:2px;background:linear-gradient(90deg,var(--line-2),var(--red-3))}
.rl-ind .stage{position:relative;padding-right:18px;display:grid;gap:10px;align-content:start;margin:0;min-width:0}
.rl-ind .stage .dot{width:40px;height:40px;display:grid;place-items:center;background:var(--bg);border:2px solid var(--red-3);font-family:var(--f-display);font-size:18px;color:var(--ink);position:relative;z-index:1}
.rl-ind .stage:last-child .dot{background:var(--red)}
.rl-ind .stage h3{font-size:19px;margin:4px 0 0}
.rl-ind .stage .who{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-ind .qs{list-style:none;margin:0;padding:0;display:grid;gap:6px}
.rl-ind .qs li{font-family:var(--f-mono);font-size:12.5px;color:var(--ink);background:var(--bg-2);border:1px solid var(--line-2);padding:7px 10px;margin:0;overflow-wrap:anywhere}
.rl-ind .qs li::before{content:"? ";color:var(--red-3)}
.rl-ind .stage .ct{font-size:14px;border-top:1px solid var(--line);padding-top:8px;margin:0}
.rl-ind .stage .ct b{display:block;font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);font-weight:500;margin-bottom:2px}
.rl-ind .moves{list-style:none;margin:0;padding:0;border:1px solid var(--line-2)}
.rl-ind .mv{display:grid;grid-template-columns:56px minmax(0,1fr) 170px;gap:16px;align-items:center;padding:16px 18px;margin:0;border-top:1px solid var(--line)}
.rl-ind .mv:first-child{border-top:0;background:linear-gradient(90deg,rgba(153,0,0,.16),transparent 70%)}
.rl-ind .mv .n{font-family:var(--f-display);font-size:34px;color:transparent;-webkit-text-stroke:1.2px var(--red-3);line-height:1}
.rl-ind .mv:first-child .n{color:var(--red-3)}
.rl-ind .mv h3{font-family:var(--f-body);text-transform:none;letter-spacing:0;font-size:16.5px;font-weight:600;margin:0 0 3px;line-height:1.35}
.rl-ind .mv p{margin:0;font-size:14.5px}
.rl-ind .tags{display:grid;gap:6px}
.rl-ind .tg{display:grid;grid-template-columns:52px 1fr;align-items:center;gap:8px;font-family:var(--f-mono);font-size:10px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-ind .tg .bar{display:flex;gap:2px}
.rl-ind .tg .bar i{width:16px;height:6px;background:var(--line-2)}
.rl-ind .tg.imp .bar i.on{background:var(--ok)}
.rl-ind .tg.eff .bar i.on{background:var(--amber)}
.rl-ind .wa{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-ind .wa.one{grid-template-columns:minmax(0,1fr)}
.rl-ind .wa>div{background:var(--panel);padding:18px 20px}
.rl-ind .wa .h{display:flex;align-items:center;gap:8px;font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;margin:0 0 8px}
.rl-ind .wk .h{color:var(--ok)}
.rl-ind .av2 .h{color:var(--red-3)}
.rl-ind .wa ul{list-style:none;margin:0;padding:0}
.rl-ind .wa li{display:grid;grid-template-columns:18px 1fr;gap:8px;padding:8px 0;margin:0;border-top:1px solid var(--line);font-size:15px}
.rl-ind .wa li:first-child{border-top:0}
.rl-ind .wk .ic{color:var(--ok);margin-top:4px}
.rl-ind .av2 .ic{color:var(--red-3);margin-top:4px}
.rl-ind .i-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-ind .i-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-ind .i-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-ind .i-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-ind .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-ind .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-ind .go2:hover{background:var(--red-2)}
.rl-ind .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-ind .indcard{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);border:1px solid var(--red-line);background:var(--panel);margin-top:46px}
.rl-ind .indcard.one{grid-template-columns:minmax(0,1fr)}
.rl-ind .indcard .l{padding:24px 26px;border-right:1px solid var(--line-2);background:radial-gradient(90% 140% at 0% 0%,rgba(153,0,0,.22),transparent 60%);display:grid;gap:10px;align-content:start}
.rl-ind .indcard.one .l{border-right:0}
.rl-ind .indcard .l .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3)}
.rl-ind .indcard .l h2{font-size:26px;margin:0}
.rl-ind .indcard .l p{margin:0;font-size:15px}
.rl-ind .indcard .l a.more{font-family:var(--f-display);text-transform:uppercase;letter-spacing:.06em;font-size:14px;text-decoration:none;color:var(--ink);border-bottom:1px solid var(--red-line);justify-self:start}
.rl-ind .indcard ul{list-style:none;margin:0;padding:0}
.rl-ind .indcard li{margin:0}
.rl-ind .indcard li a,.rl-ind .indcard li .na{display:grid;grid-template-columns:minmax(0,1fr) 20px;gap:10px;padding:14px 20px;border-bottom:1px solid var(--line);text-decoration:none;color:var(--ink);font-size:15px}
.rl-ind .indcard li:last-child a,.rl-ind .indcard li:last-child .na{border-bottom:0}
.rl-ind .indcard li a:hover{background:rgba(255,255,255,.03)}
.rl-ind .indcard li small{display:block;font-size:13px;color:var(--ink-faint)}
.rl-ind .indcard li .ar{color:var(--red-3)}
.rl-ind .i-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-ind .i-back .sec-h{margin-top:0}
.rl-ind .i-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-ind .i-src li{padding:6px 0;color:var(--ink-faint)}
.rl-ind .i-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-ind .i-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-ind .i-author .av{width:72px;height:72px;font-size:28px}
.rl-ind .i-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-ind .i-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-ind .i-author p{margin:0 0 8px;font-size:15px}
.rl-ind .i-author .links{display:flex;gap:18px;font-size:14px}
.rl-ind .i-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:1000px){
  .rl-ind .i-glance,.rl-ind .i-glance.n3{grid-template-columns:repeat(2,minmax(0,1fr))}
  .rl-ind .journey.n4{grid-template-columns:repeat(2,minmax(0,1fr));gap:26px 0}
  .rl-ind .journey.n4::before{display:none}
}
@media(max-width:760px){
  .rl-ind .i-cover{grid-template-columns:minmax(0,1fr)}
  .rl-ind .i-cover .i-band{height:36px}
  .rl-ind .i-cover .i-band span{writing-mode:horizontal-tb;transform:none;letter-spacing:.2em}
  .rl-ind .i-meta,.rl-ind .i-meta.n2{grid-template-columns:minmax(0,1fr)}
  .rl-ind .i-glance,.rl-ind .i-glance.n2,.rl-ind .i-glance.n3{grid-template-columns:minmax(0,1fr)}
  .rl-ind .rule{grid-template-columns:56px minmax(0,1fr);gap:10px 12px}
  .rl-ind .rule p{grid-column:2}
  .rl-ind .journey,.rl-ind .journey.n2,.rl-ind .journey.n4{grid-template-columns:minmax(0,1fr);gap:26px}
  .rl-ind .journey::before,.rl-ind .journey.n4::before{display:block;left:19px;right:auto;top:0;bottom:0;width:2px;height:auto;background:linear-gradient(180deg,var(--line-2),var(--red-3))}
  .rl-ind .stage{padding-right:0;padding-left:56px}
  .rl-ind .stage .dot{position:absolute;left:0;top:0}
  .rl-ind .mv{grid-template-columns:44px minmax(0,1fr)}
  .rl-ind .mv .tags{grid-column:2}
  .rl-ind .wa,.rl-ind .i-back,.rl-ind .indcard,.rl-ind .i-take{grid-template-columns:minmax(0,1fr)}
  .rl-ind .indcard .l{border-right:0;border-bottom:1px solid var(--line-2)}
  .rl-ind .i-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-ind .cact{padding-right:16px}
  .rl-ind .i-author{grid-template-columns:1fr}
  .rl-ind .i-prose p,.rl-ind .i-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-ind .go2{transition:none}}
</style>
<?php }, 24);
