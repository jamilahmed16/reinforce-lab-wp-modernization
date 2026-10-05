<?php
/**
 * Plugin Name: Reinforce Lab - Case Study post design
 * Description: The approved Case Study design (D-077, mockup claude/design-previews/blog-casestudy-template-mockup.html v2). Project file: client card with the approval badge, before-and-after results, results chart over time, the story in three acts (brief with client profile and goals, work in phases, outcome with evidence and what's next), what did not go to plan, client quote, lessons, one in-article CTA, services used, how we measured with other factors, related case studies. Publish guard: no case study goes live without client approval (D-076). reinforce-post.php hands Case Study posts to rl_casestudy_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_casestudy_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'casestudy'; }

/* ---------- fields (Case Study only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'casestudy']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_casestudy', 'title' => 'Case Study (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_cs_permission', 'Client approved this case study', 'true_false', ['ui' => 1, 'instructions' => 'Required. Tick only when the client has approved the whole case study in writing. Without it the post stays a draft.']),
            $f('rl_cs_client', 'Client', 'text', ['instructions' => 'The client name, or an anonymised description such as "A UK pharmaceutical manufacturer".']),
            $f('rl_cs_named', 'Client agreed to be named', 'true_false', ['ui' => 1, 'instructions' => 'Off = the client is shown anonymised.']),
            $f('rl_cs_client_note', 'Client: note', 'text', ['instructions' => 'e.g. Anonymised at the client\'s request. Figures shared with permission.']),
            $f('rl_cs_industry', 'Industry', 'select', ['choices' => function_exists('rl_pt_industries') ? rl_pt_industries() : [], 'allow_null' => 1]),
            $f('rl_cs_period', 'Project period', 'text', ['instructions' => 'e.g. March to August 2026']),
            $f('rl_cs_services', 'Services used', 'checkbox', ['choices' => $services, 'layout' => 'vertical']),
            $f('rl_cs_team', 'Team', 'text', ['instructions' => 'Roles, e.g. SEO lead, technical SEO, writer, medical reviewer']),
            $f('rl_cs_results', 'Measured results', 'textarea', ['rows' => 4, 'instructions' => 'Up to 4, one per line: Metric | Before | After | Change | Period and data source. Before can be empty. Real, measured numbers only, shared with permission.']),
            $f('rl_cs_chart_title', 'Chart: what it shows', 'text', ['instructions' => 'e.g. Organic clicks a month. Leave the chart data empty for no chart.']),
            $f('rl_cs_chart', 'Chart: data', 'textarea', ['rows' => 6, 'instructions' => 'One point per line, in order: Label | Number. Example: Jan | 1150']),
            $f('rl_cs_chart_marks', 'Chart: markers', 'textarea', ['rows' => 2, 'instructions' => 'Up to 3, one per line: Label | Text. Add +0.5 to the label to place it between two points. Example: Mar+0.6 | Template fix live']),
            $f('rl_cs_chart_source', 'Chart: source', 'text', ['instructions' => 'e.g. Client\'s Google Search Console, shared with permission.']),
            $f('rl_cs_profile', 'Client profile', 'textarea', ['rows' => 4, 'instructions' => 'Up to 4, one per line: Label | Value. Example: Company size | 200 to 500 staff']),
            $f('rl_cs_challenge', 'The challenge', 'textarea', ['rows' => 4]),
            $f('rl_cs_goals', 'Goals', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_cs_approach', 'What we did (phases)', 'textarea', ['rows' => 5, 'instructions' => 'One per line: When | Phase | What we did | Deliverable; Deliverable. Example: Weeks 1 to 2 | Audit | A crawl found the cause. | Audit; Fix list']),
            $f('rl_cs_obstacles', 'What did not go to plan', 'textarea', ['rows' => 3, 'instructions' => 'One per line: Problem | How we handled it']),
            $f('rl_cs_outcome', 'What changed', 'textarea', ['rows' => 4]),
            $f('rl_cs_evidence', 'Evidence screenshots', 'gallery', ['return_format' => 'id', 'preview_size' => 'medium', 'max' => 6, 'instructions' => 'Up to 6. Each image\'s title is the label (e.g. Before · Feb 2026) and its caption the text. Only screenshots the client has approved.']),
            $f('rl_cs_next', 'What\'s next', 'textarea', ['rows' => 2]),
            $f('rl_cs_quote', 'Client quote', 'textarea', ['rows' => 3, 'instructions' => 'Exact words, approved by the client in writing.']),
            $f('rl_cs_quote_by', 'Quote by', 'text', ['instructions' => 'Name and role, or role only if anonymised.']),
            $f('rl_cs_lessons', 'What made the difference', 'textarea', ['rows' => 3, 'instructions' => 'Up to 3, one per line: Lesson | One or two sentences']),
            $f('rl_cs_method', 'How we measured', 'textarea', ['rows' => 3, 'instructions' => 'Periods compared, data sources, and that results depend on many factors.']),
            $f('rl_cs_factors', 'Other things that changed', 'textarea', ['rows' => 3, 'instructions' => 'One per line: What changed | How we accounted for it']),
            $f('rl_cs_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Shown after the lessons. Leave empty for none.']),
            $f('rl_cs_cta_head', 'In-article CTA: headline', 'text'),
            $f('rl_cs_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_cs_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
        ],
    ]);
});

/* Case studies need client approval before they can go live (D-076). */
add_action('acf/save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'post' || get_post_status($post_id) !== 'publish') return;
    if ((string) get_post_meta($post_id, 'rl_type', true) !== 'casestudy') return;
    if (get_post_meta($post_id, 'rl_cs_permission', true)) return;
    wp_update_post(['ID' => $post_id, 'post_status' => 'draft']); // stays a draft until the approval box is ticked
}, 20);

/* ---------- data ---------- */
function rl_casestudy_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
function rl_casestudy_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $k = $m('rl_cs_industry');
    $ind = ($k !== '' && function_exists('rl_ind_data') && isset(rl_ind_data()[$k])) ? rl_ind_data()[$k] : null;
    $svc = get_post_meta($id, 'rl_cs_services', true); $svc = is_array($svc) ? $svc : array_filter([(string) $svc]);
    $chart = [];
    foreach (rl_casestudy_rows(get_post_meta($id, 'rl_cs_chart', true), 2) as $r) { $n = (float) str_replace(',', '', $r[1]); if (is_numeric(str_replace(',', '', $r[1]))) $chart[] = [$r[0], $n]; }
    $labels = array_column($chart, 0); $marks = [];
    foreach (array_slice(rl_casestudy_rows(get_post_meta($id, 'rl_cs_chart_marks', true), 2), 0, 3) as $r) {
        if (preg_match('/^(.+?)\s*\+\s*(0?\.\d+)$/', $r[0], $mm)) { $base = trim($mm[1]); $off = (float) $mm[2]; } else { $base = $r[0]; $off = 0; }
        $i = array_search($base, $labels, true); if ($i !== false) $marks[] = [$i + $off, $r[1]];
    }
    $phases = [];
    foreach (rl_casestudy_rows(get_post_meta($id, 'rl_cs_approach', true), 1) as $r) $phases[] = ['when' => count($r) >= 2 ? $r[0] : '', 'name' => count($r) >= 2 ? $r[1] : $r[0], 'what' => $r[2] ?? '', 'dl' => array_values(array_filter(array_map('trim', explode(';', $r[3] ?? ''))))];
    $ev = get_post_meta($id, 'rl_cs_evidence', true); $ev = is_array($ev) ? array_slice(array_filter(array_map('intval', $ev)), 0, 6) : [];
    return $cache[$id] = ['ok' => (bool) get_post_meta($id, 'rl_cs_permission', true), 'client' => $m('rl_cs_client'), 'named' => (bool) get_post_meta($id, 'rl_cs_named', true), 'client_note' => $m('rl_cs_client_note'),
        'ikey' => $ind ? $k : '', 'ind' => $ind, 'period' => $m('rl_cs_period'), 'services' => array_values(array_filter($svc, function ($s) { return function_exists('rl_pt_services') && isset(rl_pt_services()[$s]); })), 'team' => $m('rl_cs_team'),
        'results' => array_slice(rl_casestudy_rows(get_post_meta($id, 'rl_cs_results', true), 3), 0, 4),
        'chart_title' => $m('rl_cs_chart_title'), 'chart' => $chart, 'marks' => $marks, 'chart_source' => $m('rl_cs_chart_source'),
        'profile' => array_slice(rl_casestudy_rows(get_post_meta($id, 'rl_cs_profile', true), 2), 0, 4), 'challenge' => $m('rl_cs_challenge'), 'goals' => rl_post_lines(get_post_meta($id, 'rl_cs_goals', true)),
        'phases' => $phases, 'obstacles' => rl_casestudy_rows(get_post_meta($id, 'rl_cs_obstacles', true), 2), 'outcome' => $m('rl_cs_outcome'), 'evidence' => $ev, 'next' => $m('rl_cs_next'),
        'quote' => $m('rl_cs_quote'), 'quote_by' => $m('rl_cs_quote_by'), 'lessons' => array_slice(rl_casestudy_rows(get_post_meta($id, 'rl_cs_lessons', true), 1), 0, 3),
        'method' => $m('rl_cs_method'), 'factors' => rl_casestudy_rows(get_post_meta($id, 'rl_cs_factors', true), 1)];
}

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_casestudy_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $x = rl_casestudy_data($id);
    $title = get_the_title($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $h1 = preg_match('/^(How .+?)\s+(got|grew|won|doubled|cut|reached|brought|turned|made|moved|built|fixed)\b(.*)$/i', $title, $tm) ? esc_html($tm[1]) . ' <em>' . esc_html($tm[2] . $tm[3]) . '</em>' : esc_html($title);
    $svcnames = function_exists('rl_pt_services') ? rl_pt_services() : [];
    $indurl = $x['ikey'] !== '' ? $u('industries/' . $x['ikey']) : '';
    $cta = null; $svc = (string) get_post_meta($id, 'rl_cs_cta_service', true); $head = trim((string) get_post_meta($id, 'rl_cs_cta_head', true));
    if ($svc !== '' && $head !== '' && isset($svcnames[$svc])) $cta = ['name' => $svcnames[$svc], 'url' => $u($svc), 'head' => $head, 'sub' => trim((string) get_post_meta($id, 'rl_cs_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_cs_cta_button', true)) ?: 'See how it works'];
    $diag = $u('search-authority-diagnostic');
    $ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $rows = array_filter([['Industry', $x['ind'] ? $x['ind']['name'] : ''], ['Project', $x['period']], ['Services', $x['services'] ? 'svc' : ''], ['Team', $x['team']]], function ($r) { return $r[1] !== ''; });
    $chart_desc = '';
    if (count($x['chart']) >= 2) { $f = $x['chart'][0]; $l = end($x['chart']); $chart_desc = ($x['chart_title'] ?: 'Values') . ': ' . number_format($f[1]) . ' in ' . $f[0] . ' to ' . number_format($l[1]) . ' in ' . $l[0] . '.'; }
    $acts = 0;
    ?>
<div class="rl-page rl-post rl-cs">
<?php if (!$x['ok']) { ?><p class="cs-guard" role="status">Not approved: this case study stays a draft until "Client approved this case study" is ticked.</p><?php } ?>

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<div class="wrap">
  <header class="cs-hero<?php echo $x['client'] !== '' ? '' : ' solo'; ?>">
    <div>
      <div class="cs-kicker"><span class="cs-kind">Case Study</span><?php if ($c['cat']) echo '<a class="cs-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
      <h1 class="cs-h1"><?php echo $h1; ?></h1>
      <?php if ($standfirst !== '') { ?><p class="cs-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
      <div class="cs-by">
        <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
        <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
        <?php if ($d['updated'] !== '') { ?><span class="fresh">Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
      </div>
    </div>
    <?php if ($x['client'] !== '') { ?>
    <aside class="file" aria-label="Project file">
      <div class="fh"><span>Project file</span><?php if ($x['ok']) echo '<span class="appr">' . $ok . 'Approved by client</span>'; ?></div>
      <div class="client"><span class="k">Client</span><b><?php echo esc_html($x['client']); ?></b><?php if ($x['client_note'] !== '') echo '<p>' . esc_html($x['client_note']) . '</p>'; ?></div>
      <?php if ($rows) { ?><dl><?php foreach ($rows as $r) {
          echo '<div><dt>' . esc_html($r[0]) . '</dt><dd>';
          if ($r[1] === 'svc') { echo '<span class="chips">'; foreach ($x['services'] as $s) { $su = $u($s); echo '<a href="' . esc_url($su) . '">' . esc_html($svcnames[$s]) . '</a>'; } echo '</span>'; }
          elseif ($r[0] === 'Industry' && $indurl) echo '<a href="' . esc_url($indurl) . '">' . esc_html($r[1]) . '</a>';
          else echo esc_html($r[1]);
          echo '</dd></div>';
      } ?></dl><?php } ?>
    </aside>
    <?php } ?>
  </header>

  <?php if ($x['results']) { ?>
  <section class="results" aria-label="Results">
    <p class="rh">The results</p>
    <div class="tiles n<?php echo count($x['results']); ?>">
      <?php foreach ($x['results'] as $r) { ?>
      <div class="tile"><span class="m"><?php echo esc_html($r[0]); ?></span>
        <span class="ba"><?php if ($r[1] !== '') echo '<span class="from"><span class="vh">Before: </span>' . esc_html($r[1]) . '</span><span class="arrow" aria-hidden="true">&rarr;</span>'; ?><span class="to"><?php echo $r[1] !== '' ? '<span class="vh">After: </span>' : ''; ?><?php echo esc_html($r[2]); ?></span></span>
        <?php if (!empty($r[3])) echo '<span class="d">' . esc_html($r[3]) . '</span>'; ?><?php if (!empty($r[4])) echo '<span class="src">' . esc_html($r[4]) . '</span>'; ?></div>
      <?php } ?>
    </div>
  </section>
  <?php } ?>

  <?php if (count($x['chart']) >= 2) { ?>
  <figure class="trend">
    <div class="th"><b><?php echo esc_html($x['chart_title'] ?: 'Results over time'); ?></b><span><?php echo esc_html($x['chart'][0][0] . ' to ' . end($x['chart'])[0]); ?></span></div>
    <div class="plot" data-chart="<?php echo esc_attr(wp_json_encode(['d' => $x['chart'], 'm' => $x['marks']])); ?>"><svg role="img" aria-label="<?php echo esc_attr($chart_desc); ?>"></svg><div class="tip" aria-hidden="true"></div></div>
    <?php if ($x['chart_source'] !== '') { ?><figcaption class="src2"><?php echo esc_html($x['chart_source']); ?></figcaption><?php } ?>
    <details><summary>Show the figures as a table</summary><table><thead><tr><th scope="col">Period</th><th scope="col"><?php echo esc_html($x['chart_title'] ?: 'Value'); ?></th></tr></thead><tbody><?php foreach ($x['chart'] as $p) echo '<tr><td>' . esc_html($p[0]) . '</td><td class="n">' . esc_html(number_format($p[1], floor($p[1]) == $p[1] ? 0 : 1)) . '</td></tr>'; ?></tbody></table></details>
  </figure>
  <?php } ?>
</div>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap cs-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="cs-main">
    <?php if ($d['answer'] !== '') { ?><div class="cs-answer"><p class="t">In short</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>

    <?php if ($x['challenge'] !== '' || $x['profile'] || $x['goals']) { $acts++; ?>
    <section class="act" aria-labelledby="act-brief"><div class="no"><b><?php echo $acts; ?></b>The brief</div><div>
      <h2 id="act-brief">The challenge</h2>
      <?php if ($x['challenge'] !== '') echo '<div class="cs-prose">' . wpautop(esc_html($x['challenge'])) . '</div>'; ?>
      <?php if ($x['profile']) { ?><dl class="profile n<?php echo count($x['profile']); ?>" aria-label="Client profile"><?php foreach ($x['profile'] as $p) echo '<div><dt>' . esc_html($p[0]) . '</dt><dd>' . esc_html($p[1]) . '</dd></div>'; ?></dl><?php } ?>
      <?php if ($x['goals']) { ?><ul class="goals" aria-label="Goals"><?php foreach ($x['goals'] as $g) echo '<li>' . esc_html($g) . '</li>'; ?></ul><?php } ?>
    </div></section>
    <?php } ?>

    <?php if ($x['phases']) { $acts++; ?>
    <section class="act" aria-labelledby="act-work"><div class="no"><b><?php echo $acts; ?></b>The work</div><div>
      <h2 id="act-work">What we did</h2>
      <ol class="phases"><?php foreach ($x['phases'] as $p) echo '<li class="pz"><div>' . ($p['when'] !== '' ? '<span class="w">' . esc_html($p['when']) . '</span>' : '') . '<h3>' . esc_html($p['name']) . '</h3>' . ($p['what'] !== '' ? '<p>' . esc_html($p['what']) . '</p>' : '') . ($p['dl'] ? '<div class="dl">' . implode('', array_map(function ($a) { return '<span>' . esc_html($a) . '</span>'; }, $p['dl'])) . '</div>' : '') . '</div></li>'; ?></ol>
    </div></section>
    <?php } ?>

    <?php if ($x['obstacles']) { ?>
    <div class="sec-h" id="obstacles"><span>Honest notes</span><h2>What did not go to plan</h2></div>
    <div class="obst"><?php foreach ($x['obstacles'] as $o) echo '<div class="ob"><div class="p"><span class="l">Problem</span><p>' . esc_html($o[0]) . '</p></div><div class="h"><span class="l">How we handled it</span><p>' . esc_html($o[1]) . '</p></div></div>'; ?></div>
    <?php } ?>

    <?php if ($x['outcome'] !== '' || $x['evidence'] || $x['next'] !== '' || trim($c['body']) !== '') { $acts++; ?>
    <section class="act" aria-labelledby="act-out"><div class="no"><b><?php echo $acts; ?></b>The outcome</div><div>
      <h2 id="act-out">What changed</h2>
      <?php if ($x['outcome'] !== '') echo '<div class="cs-prose">' . wpautop(esc_html($x['outcome'])) . '</div>'; ?>
      <?php if (trim($c['body']) !== '') echo '<div class="cs-prose">' . $c['body'] . '</div>'; ?>
      <?php if ($x['evidence']) { ?><div class="evidence"><?php foreach ($x['evidence'] as $aid) { $img = wp_get_attachment_image($aid, 'large', false, ['loading' => 'lazy']); if (!$img) continue; $lab = get_the_title($aid); $cap = wp_get_attachment_caption($aid); echo '<figure class="ev">' . $img . (($lab || $cap) ? '<figcaption>' . ($lab ? '<b>' . esc_html($lab) . '</b>' : '') . esc_html((string) $cap) . '</figcaption>' : '') . '</figure>'; } ?></div><?php } ?>
      <?php if ($x['next'] !== '') { ?><div class="next"><span class="k">What's next</span><div><h3>Ongoing work</h3><p><?php echo esc_html($x['next']); ?></p></div></div><?php } ?>
    </div></section>
    <?php } ?>

    <?php if ($x['quote'] !== '' && $x['ok']) { ?>
    <figure class="quote"><span class="mk" aria-hidden="true">&ldquo;</span><blockquote><?php echo esc_html($x['quote']); ?></blockquote><?php if ($x['quote_by'] !== '') echo '<figcaption><b>' . esc_html($x['quote_by']) . '</b><span>Client</span></figcaption>'; ?></figure>
    <?php } ?>

    <?php if ($x['lessons']) { ?>
    <div class="sec-h"><span>Lessons</span><h2>What made the difference</h2></div>
    <div class="lessons n<?php echo count($x['lessons']); ?>"><?php foreach ($x['lessons'] as $k => $l) echo '<div class="ls"><span class="n">' . sprintf('%02d', $k + 1) . '</span><h3>' . esc_html($l[0]) . '</h3>' . (!empty($l[1]) ? '<p>' . esc_html($l[1]) . '</p>' : '') . '</div>'; ?></div>
    <?php } ?>

    <?php if ($cta) { ?>
    <aside class="cs-icta" aria-label="Reinforce Lab service">
      <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
      <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
    </aside>
    <?php } ?>

    <?php if ($x['services'] || $x['ind']) { ?>
    <div class="sec-h"><span>Services used</span><h2>How we helped</h2></div>
    <div class="svcs"><?php foreach (array_slice($x['services'], 0, $x['ind'] ? 2 : 3) as $s) echo '<a class="svc" href="' . esc_url($u($s)) . '"><span class="k">Service</span><b>' . esc_html($svcnames[$s]) . '</b></a>'; ?><?php if ($x['ind'] && $indurl) echo '<a class="svc" href="' . esc_url($indurl) . '"><span class="k">Industry</span><b>' . esc_html($x['ind']['name']) . '</b><span>How we work with this sector</span></a>'; ?></div>
    <?php } ?>

    <?php if ($x['method'] !== '' || $x['factors']) { ?>
    <div class="method"><span class="k">How we measured</span><div><?php if ($x['method'] !== '') echo '<p>' . esc_html($x['method']) . '</p>'; ?><?php if ($x['factors']) { ?><ul class="factors" aria-label="Other things that changed"><?php foreach ($x['factors'] as $fct) echo '<li><b>' . esc_html($fct[0]) . '</b><span>' . esc_html($fct[1] ?? '') . '</span></li>'; ?></ul><?php } ?></div></div>
    <?php } ?>
  </div>

  <?php
    $rq = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true, 'meta_key' => 'rl_type', 'meta_value' => 'casestudy']);
    if ($rq->have_posts()) { ?>
  <section class="relcs" aria-labelledby="rel-cs-h">
    <div class="sec-h"><span>More case studies</span><h2 id="rel-cs-h">Related work</h2></div>
    <div class="more">
    <?php while ($rq->have_posts()) { $rq->the_post(); $rx = rl_casestudy_data(get_the_ID()); $r0 = $rx['results'][0] ?? null; ?>
      <a class="cs" href="<?php the_permalink(); ?>"><?php if ($rx['ind']) echo '<span class="k">' . esc_html($rx['ind']['name']) . '</span>'; ?><b><?php the_title(); ?></b><?php if ($r0) echo '<span class="r">' . esc_html($r0[0] . ': ' . (!empty($r0[3]) ? $r0[3] : $r0[2])) . '</span>'; ?></a>
    <?php } wp_reset_postdata(); ?>
    </div>
  </section>
  <?php } else echo rl_post_rel_section($id); ?>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <div class="cs-back">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="cs-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </div>
  <?php } ?>

  <aside class="cs-author" aria-label="About the author">
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
<?php if (count($x['chart']) >= 2) { ?>
<script>
(function(){
  var box=document.querySelector('.rl-cs .plot'); if(!box) return;
  var cfg=JSON.parse(box.getAttribute('data-chart')), data=cfg.d, marks=cfg.m||[], svg=box.querySelector('svg'), tip=box.querySelector('.tip'), NS='http://www.w3.org/2000/svg';
  var cs=getComputedStyle(document.documentElement), col=function(v,f){ var x=cs.getPropertyValue(v).trim(); return x||f; };
  var RED=col('--red-3','#e23b3b'), FAINT=col('--ink-faint','#7f7778'), INK=col('--ink','#f2eeee'), AMB='#d39b3a', BG=col('--bg-2','#0e0c0d');
  var fmt=function(v){ return Number(v).toLocaleString('en-GB'); };
  function el(n,a){ var e=document.createElementNS(NS,n); for(var k in a) e.setAttribute(k,a[k]); return e; }
  function nice(m){ var p=Math.pow(10,Math.floor(Math.log10(m||1))), s=[1,2,2.5,5,10]; for(var i=0;i<s.length;i++){ if(s[i]*p*4>=m) return s[i]*p; } return 10*p; }
  function draw(){
    var W=box.clientWidth, H=svg.clientHeight||260, L=52, R=16, T=26, B=26; svg.setAttribute('viewBox','0 0 '+W+' '+H); while(svg.firstChild) svg.removeChild(svg.firstChild);
    var maxV=Math.max.apply(null,data.map(function(d){return d[1];})), step=nice(maxV), top=step*Math.ceil(maxV*1.08/step);
    var n=data.length, x=function(i){return L+i*(W-L-R)/(n-1);}, y=function(v){return T+(1-v/top)*(H-T-B);};
    for(var v=0; v<=top+0.001; v+=step){ svg.appendChild(el('line',{x1:L,x2:W-R,y1:y(v),y2:y(v),stroke:'rgba(255,255,255,.08)'})); var t=el('text',{x:L-8,y:y(v)+4,'text-anchor':'end',fill:FAINT,'font-size':11,'font-family':'IBM Plex Mono, monospace'}); t.textContent=fmt(v); svg.appendChild(t); }
    var every=Math.ceil(n/(W<500?6:12));
    data.forEach(function(d,i){ if(i%every && i!==n-1) return; var t=el('text',{x:x(i),y:H-6,'text-anchor':i===0?'start':(i===n-1?'end':'middle'),fill:FAINT,'font-size':11,'font-family':'IBM Plex Mono, monospace'}); t.textContent=d[0]; svg.appendChild(t); });
    marks.forEach(function(m,k){ var mx=x(m[0]); svg.appendChild(el('line',{x1:mx,x2:mx,y1:T-8,y2:H-B,stroke:AMB,'stroke-dasharray':'3 3'})); var right=mx<W/2; var t=el('text',{x:mx+(right?6:-6),y:T-10+k*12,'text-anchor':right?'start':'end',fill:AMB,'font-size':10.5,'font-family':'IBM Plex Mono, monospace'}); t.textContent=m[1]; svg.appendChild(t); });
    var pts=data.map(function(d,i){return x(i)+','+y(d[1]);}).join(' ');
    svg.appendChild(el('polygon',{points:x(0)+','+y(0)+' '+pts+' '+x(n-1)+','+y(0),fill:'rgba(226,59,59,.10)'}));
    svg.appendChild(el('polyline',{points:pts,fill:'none',stroke:RED,'stroke-width':2,'stroke-linejoin':'round'}));
    svg.appendChild(el('circle',{cx:x(n-1),cy:y(data[n-1][1]),r:5,fill:RED,stroke:BG,'stroke-width':2}));
    var lt=el('text',{x:x(n-1)-8,y:y(data[n-1][1])-10,'text-anchor':'end',fill:INK,'font-size':12,'font-family':'IBM Plex Mono, monospace'}); lt.textContent=fmt(data[n-1][1]); svg.appendChild(lt);
    var cross=el('line',{y1:T,y2:H-B,stroke:'rgba(255,255,255,.3)',opacity:0}), dot=el('circle',{r:5,fill:RED,stroke:BG,'stroke-width':2,opacity:0});
    svg.appendChild(cross); svg.appendChild(dot);
    var hit=el('rect',{x:L,y:0,width:W-L-R,height:H,fill:'transparent'}); svg.appendChild(hit);
    function show(cx){ var i=Math.max(0,Math.min(n-1,Math.round((cx-L)/((W-L-R)/(n-1))))), px=x(i), py=y(data[i][1]);
      cross.setAttribute('x1',px); cross.setAttribute('x2',px); cross.setAttribute('opacity',1); dot.setAttribute('cx',px); dot.setAttribute('cy',py); dot.setAttribute('opacity',1);
      tip.innerHTML=''; var b=document.createElement('b'); b.textContent=data[i][0]; tip.appendChild(b); tip.appendChild(document.createTextNode(fmt(data[i][1])));
      tip.style.left=Math.min(Math.max(px,60),W-60)+'px'; tip.style.top=py+'px'; tip.style.opacity=1; }
    function hide(){ cross.setAttribute('opacity',0); dot.setAttribute('opacity',0); tip.style.opacity=0; }
    hit.addEventListener('pointermove',function(e){ show(e.clientX-svg.getBoundingClientRect().left); });
    hit.addEventListener('pointerleave',hide);
  }
  draw(); var tm; addEventListener('resize',function(){ clearTimeout(tm); tm=setTimeout(draw,120); });
})();
</script>
<?php }
}

/* ---------- schema: named client as the subject; services as mentions ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_casestudy_view()) return $graph;
    $id = get_queried_object_id(); $x = rl_casestudy_data($id);
    $svcn = function_exists('rl_pt_services') ? rl_pt_services() : [];
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type']) || !in_array('Article', (array) $n['@type'], true)) continue;
        if ($x['named'] && $x['client'] !== '') $n['about'] = ['@type' => 'Organization', 'name' => $x['client']];
        elseif ($x['ind']) $n['about'] = ['@type' => 'Thing', 'name' => $x['ind']['name']];
        if ($x['services'] && function_exists('rl_url_by_path')) $n['mentions'] = array_values(array_filter(array_map(function ($s) use ($svcn) { $su = rl_url_by_path($s, ''); return $su ? ['@type' => 'Service', '@id' => $su . '#service', 'name' => $svcn[$s], 'url' => $su] : null; }, $x['services'])));
    }
    unset($n);
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_casestudy_view()) return; ?>
<style id="rl-casestudy-css">
.rl-cs{color:var(--ink-dim);--ok:#3fa36b;--ok-line:rgba(63,163,107,.45);--amber:#d39b3a}
.rl-cs h1,.rl-cs h2,.rl-cs h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-cs .ic{width:14px;height:14px;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:square}
.rl-cs .vh{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)}
.rl-cs .cs-guard{margin:0;background:var(--amber);color:#1a1205;font-family:var(--f-mono);font-size:12px;letter-spacing:.06em;text-align:center;padding:8px var(--gutter,16px)}
.rl-cs .cs-hero{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,.9fr);gap:clamp(28px,5vw,60px);align-items:start;padding-block:clamp(24px,4vw,40px) 0}
.rl-cs .cs-hero.solo{grid-template-columns:minmax(0,1fr)}
.rl-cs .cs-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px}
.rl-cs .cs-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-cs .cs-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-cs .cs-h1{font-size:clamp(34px,4.6vw,60px);line-height:1;margin:0}
.rl-cs .cs-h1 em{font-style:normal;color:var(--red-3)}
.rl-cs .cs-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;margin:18px 0 0;max-width:640px}
.rl-cs .cs-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cs .cs-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-cs .cs-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-cs .cs-by b{color:var(--ink-dim);font-weight:500}
.rl-cs .cs-by .fresh,.rl-cs .cs-by .fresh b{color:var(--ok)}
.rl-cs .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-cs .file{border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));position:relative}
.rl-cs .file::before{content:"";position:absolute;top:-1px;left:22px;width:110px;height:8px;background:var(--red);clip-path:polygon(0 0,100% 0,92% 100%,8% 100%)}
.rl-cs .fh{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:16px 18px;border-bottom:1px dashed var(--line-2)}
.rl-cs .fh>span:first-child{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cs .appr{display:inline-flex;align-items:center;gap:6px;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--ok);border:1px solid var(--ok-line);padding:3px 8px}
.rl-cs .client{padding:18px;border-bottom:1px solid var(--line);display:grid;gap:6px}
.rl-cs .client .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cs .client b{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1.1}
.rl-cs .client p{margin:0;font-size:13.5px}
.rl-cs .file dl{margin:0;padding:6px 18px 14px}
.rl-cs .file dl div{display:grid;grid-template-columns:96px minmax(0,1fr);gap:12px;padding:9px 0;border-top:1px solid var(--line);font-size:14px}
.rl-cs .file dl div:first-child{border-top:0}
.rl-cs .file dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);padding-top:3px}
.rl-cs .file dd{margin:0;color:var(--ink)}
.rl-cs .file dd>a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-cs .chips{display:flex;flex-wrap:wrap;gap:6px}
.rl-cs .chips a{font-size:12.5px;color:var(--ink);text-decoration:none;border:1px solid var(--line-2);padding:2px 8px;background:var(--bg-2)}
.rl-cs .chips a:hover{border-color:var(--red-line)}
.rl-cs .results{margin-top:clamp(30px,4vw,44px);padding:0}
.rl-cs .rh{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 12px}
.rl-cs .tiles{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-cs .tiles.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-cs .tiles.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-cs .tiles.n1{grid-template-columns:minmax(0,1fr)}
.rl-cs .tile{background:var(--bg-2);padding:20px 20px 18px;display:grid;gap:8px;align-content:start;min-width:0}
.rl-cs .tile .m{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cs .tile .ba{display:flex;align-items:baseline;gap:10px;flex-wrap:wrap}
.rl-cs .tile .from{font-family:var(--f-display);font-size:20px;color:var(--ink-faint);text-decoration:line-through;text-decoration-thickness:1px}
.rl-cs .tile .arrow{color:var(--red-3);font-family:var(--f-mono)}
.rl-cs .tile .to{font-family:var(--f-display);font-size:40px;color:var(--ink);line-height:1;font-weight:500}
.rl-cs .tile .d{font-family:var(--f-mono);font-size:12px;color:var(--ok)}
.rl-cs .tile .src{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint);border-top:1px solid var(--line);padding-top:8px}
.rl-cs .trend{margin:14px 0 0;border:1px solid var(--line-2);background:var(--bg-2);padding:16px 18px 12px}
.rl-cs .trend .th{display:flex;flex-wrap:wrap;justify-content:space-between;gap:6px 12px;align-items:baseline}
.rl-cs .trend .th b{font-family:var(--f-display);font-size:18px;text-transform:uppercase;color:var(--ink);font-weight:500}
.rl-cs .trend .th span{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cs .plot{position:relative;margin-top:10px}
.rl-cs .plot svg{display:block;width:100%;height:260px}
.rl-cs .plot .tip{position:absolute;pointer-events:none;background:var(--panel-2,var(--panel));border:1px solid var(--line-2);padding:6px 10px;font-family:var(--f-mono);font-size:12px;color:var(--ink);white-space:nowrap;transform:translate(-50%,-110%);opacity:0;transition:opacity .12s}
.rl-cs .plot .tip b{display:block;font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint);font-weight:500}
.rl-cs .trend .src2{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint);margin:8px 0 0;text-align:left}
.rl-cs .trend details{margin-top:8px;font-size:13.5px;border:0;background:none}
.rl-cs .trend summary{cursor:pointer;font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-dim);padding:0}
.rl-cs .trend table{border-collapse:collapse;margin-top:8px;font-family:var(--f-mono);font-size:12.5px;width:100%;max-width:420px;min-width:0}
.rl-cs .trend th,.rl-cs .trend td{border:0;border-bottom:1px solid var(--line);padding:5px 8px;text-align:left;color:var(--ink-dim);background:none;font-family:var(--f-mono);font-size:12.5px;letter-spacing:0;text-transform:none}
.rl-cs .trend td.n{text-align:right;color:var(--ink);font-variant-numeric:tabular-nums}
.rl-cs .cs-feat{margin:28px auto 0}
.rl-cs .cs-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-cs .cs-main{max-width:900px;margin:0 auto;padding-block:clamp(34px,5vw,52px) 10px}
.rl-cs .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px;scroll-margin-top:96px}
.rl-cs .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3)}
.rl-cs .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-cs .cs-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-cs .cs-answer .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-cs .cs-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-cs .cs-prose>*{margin:0 0 1.1em}
.rl-cs .cs-prose p,.rl-cs .cs-prose li{font-size:17.5px;line-height:1.75}
.rl-cs .cs-prose h2{font-size:clamp(22px,2.4vw,26px);margin:1.6em 0 .5em}
.rl-cs .cs-prose h3{font-size:20px;margin:1.4em 0 .5em}
.rl-cs .cs-prose strong{color:var(--ink);font-weight:600}
.rl-cs .cs-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-cs .cs-prose ul,.rl-cs .cs-prose ol{padding-left:1.2em}
.rl-cs .cs-prose li::marker{color:var(--red-3)}
.rl-cs .act{display:grid;grid-template-columns:110px minmax(0,1fr);gap:22px;border-top:1px solid var(--line-2);padding:26px 0 0;margin-top:40px}
.rl-cs .act>div{min-width:0}
.rl-cs .act .no{font-family:var(--f-display);font-size:13px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);display:grid;gap:6px;align-content:start}
.rl-cs .act .no b{font-size:56px;line-height:.8;color:transparent;-webkit-text-stroke:1.3px var(--red-3);font-weight:700}
.rl-cs .act h2{font-size:clamp(24px,2.8vw,30px);margin:0 0 12px}
.rl-cs .profile{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1px;background:var(--line);border:1px solid var(--line);margin:18px 0 0}
.rl-cs .profile.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-cs .profile.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-cs .profile.n1{grid-template-columns:minmax(0,1fr)}
.rl-cs .profile div{background:var(--bg-2);padding:12px 14px}
.rl-cs .profile dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cs .profile dd{margin:4px 0 0;color:var(--ink);font-size:14.5px}
.rl-cs .goals{list-style:none;margin:14px 0 0;padding:0;display:grid;gap:6px}
.rl-cs .goals li{display:grid;grid-template-columns:18px 1fr;gap:8px;font-size:15.5px;color:var(--ink);margin:0}
.rl-cs .goals li::before{content:"";width:10px;height:10px;border:2px solid var(--red-3);margin-top:7px}
.rl-cs .phases{list-style:none;margin:6px 0 0;padding:0;position:relative}
.rl-cs .phases::before{content:"";position:absolute;left:7px;top:8px;bottom:8px;width:2px;background:var(--line-2)}
.rl-cs .pz{display:grid;grid-template-columns:16px minmax(0,1fr);gap:16px;padding-bottom:20px;margin:0}
.rl-cs .pz::before{content:"";width:16px;height:16px;background:var(--bg);border:2px solid var(--red-3);margin-top:3px;position:relative;z-index:1}
.rl-cs .pz .w{font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-cs .pz h3{font-family:var(--f-body);text-transform:none;letter-spacing:0;font-size:17px;font-weight:600;margin:2px 0 4px;line-height:1.35}
.rl-cs .pz p{margin:0;font-size:15px}
.rl-cs .pz .dl{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}
.rl-cs .pz .dl span{font-family:var(--f-mono);font-size:11px;color:var(--ink);background:var(--bg-2);border:1px solid var(--line-2);padding:2px 8px}
.rl-cs .obst{border:1px solid var(--line-2)}
.rl-cs .ob{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);border-top:1px solid var(--line)}
.rl-cs .ob:first-child{border-top:0}
.rl-cs .ob>div{padding:16px 18px}
.rl-cs .ob>div+div{border-left:1px solid var(--line);background:linear-gradient(90deg,rgba(63,163,107,.05),transparent)}
.rl-cs .ob .l{display:block;font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;margin-bottom:4px}
.rl-cs .ob .p .l{color:var(--amber)}
.rl-cs .ob .h .l{color:var(--ok)}
.rl-cs .ob p{margin:0;font-size:15px;color:var(--ink)}
.rl-cs .evidence{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-top:22px}
.rl-cs .ev{margin:0;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-cs .ev::before{content:"";display:block;height:24px;border-bottom:1px solid var(--line);background-image:linear-gradient(var(--line-2),var(--line-2)),linear-gradient(var(--line-2),var(--line-2)),linear-gradient(var(--line-2),var(--line-2));background-size:7px 7px;background-repeat:no-repeat;background-position:10px 8px,22px 8px,34px 8px}
.rl-cs .ev img{display:block;width:100%;height:auto}
.rl-cs .ev figcaption{font-size:13px;padding:10px 12px;border-top:1px solid var(--line);text-align:left;margin:0}
.rl-cs .ev figcaption b{display:block;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint);font-weight:500;margin-bottom:2px}
.rl-cs .next{display:grid;grid-template-columns:auto minmax(0,1fr);gap:16px;align-items:start;border:1px solid var(--line-2);background:var(--panel);padding:18px 20px;margin-top:22px}
.rl-cs .next .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:#fff;background:var(--red);padding:3px 8px;white-space:nowrap}
.rl-cs .next h3{font-size:18px;margin:0 0 4px}
.rl-cs .next p{margin:0;font-size:15px}
.rl-cs .quote{margin:40px 0 0;border:1px solid var(--red-line);background:radial-gradient(90% 140% at 0% 0%,rgba(153,0,0,.2),transparent 60%),var(--panel);padding:30px 32px;position:relative}
.rl-cs .quote .mk{position:absolute;top:10px;right:22px;font-family:var(--f-display);font-size:120px;line-height:1;color:rgba(226,59,59,.18)}
.rl-cs .quote blockquote{margin:0;padding:0;border:0;color:var(--ink);font-family:var(--f-body);text-transform:none;font-size:clamp(20px,2.2vw,25px);line-height:1.5;max-width:760px;position:relative}
.rl-cs .quote figcaption{display:flex;flex-wrap:wrap;align-items:center;gap:8px 14px;margin-top:18px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint);text-align:left}
.rl-cs .quote figcaption b{color:var(--ink);font-weight:500}
.rl-cs .lessons{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-cs .lessons.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-cs .lessons.n1{grid-template-columns:minmax(0,1fr)}
.rl-cs .ls{background:var(--bg);padding:18px 20px;display:grid;gap:6px;align-content:start}
.rl-cs .ls .n{font-family:var(--f-mono);font-size:11px;color:var(--red-3)}
.rl-cs .ls h3{font-size:17px;margin:0}
.rl-cs .ls p{margin:0;font-size:14.5px}
.rl-cs .cs-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-cs .cs-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-cs .cs-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-cs .cs-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-cs .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-cs .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-cs .go2:hover{background:var(--red-2)}
.rl-cs .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-cs .svcs{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
.rl-cs .svc{border:1px solid var(--line-2);background:var(--panel);padding:16px 18px;text-decoration:none;display:grid;gap:4px;align-content:start;transition:border-color .2s}
.rl-cs .svc:hover{border-color:var(--red-line)}
.rl-cs .svc .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-cs .svc b{font-family:var(--f-display);font-size:18px;text-transform:uppercase;color:var(--ink);font-weight:500}
.rl-cs .svc span:last-child:not(.k){font-size:13.5px;color:var(--ink-dim)}
.rl-cs .method{border:1px dashed var(--line-2);padding:16px 18px;margin-top:40px;display:grid;grid-template-columns:auto minmax(0,1fr);gap:14px;align-items:start}
.rl-cs .method .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);padding-top:2px}
.rl-cs .method p{margin:0;font-size:14px}
.rl-cs .factors{list-style:none;margin:10px 0 0;padding:0}
.rl-cs .factors li{display:grid;grid-template-columns:minmax(0,.8fr) minmax(0,1.2fr);gap:14px;padding:8px 0;margin:0;border-top:1px solid var(--line);font-size:14px}
.rl-cs .factors li:first-child{border-top:0}
.rl-cs .factors b{color:var(--ink);font-weight:500}
.rl-cs .relcs{margin-top:46px;padding:0}
.rl-cs .relcs .sec-h{margin-top:0}
.rl-cs .more{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-cs .cs{background:var(--bg);padding:18px 20px;text-decoration:none;display:grid;gap:8px;align-content:start;transition:background .2s}
.rl-cs .cs:hover{background:var(--panel)}
.rl-cs .cs .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-cs .cs b{font-family:var(--f-display);font-size:19px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1.15}
.rl-cs .cs .r{font-family:var(--f-mono);font-size:12px;color:var(--ok)}
.rl-cs .cs-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-cs .cs-back .sec-h{margin-top:0}
.rl-cs .cs-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-cs .cs-src li{padding:6px 0;color:var(--ink-faint)}
.rl-cs .cs-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-cs .cs-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-cs .cs-author .av{width:72px;height:72px;font-size:28px}
.rl-cs .cs-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-cs .cs-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-cs .cs-author p{margin:0 0 8px;font-size:15px}
.rl-cs .cs-author .links{display:flex;gap:18px;font-size:14px}
.rl-cs .cs-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:1000px){
  .rl-cs .cs-hero{grid-template-columns:minmax(0,1fr)}
  .rl-cs .tiles,.rl-cs .tiles.n3{grid-template-columns:repeat(2,minmax(0,1fr))}
  .rl-cs .profile{grid-template-columns:repeat(2,minmax(0,1fr))}
  .rl-cs .evidence,.rl-cs .more{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media(max-width:760px){
  .rl-cs .tiles,.rl-cs .tiles.n2,.rl-cs .tiles.n3{grid-template-columns:minmax(0,1fr)}
  .rl-cs .act{grid-template-columns:minmax(0,1fr);gap:10px}
  .rl-cs .act .no{grid-auto-flow:column;justify-content:start;align-items:end;gap:12px}
  .rl-cs .act .no b{font-size:44px}
  .rl-cs .lessons,.rl-cs .lessons.n2,.rl-cs .svcs,.rl-cs .cs-back,.rl-cs .evidence,.rl-cs .more,.rl-cs .profile,.rl-cs .profile.n2,.rl-cs .profile.n3{grid-template-columns:minmax(0,1fr)}
  .rl-cs .ob{grid-template-columns:minmax(0,1fr)}
  .rl-cs .ob>div+div{border-left:0;border-top:1px solid var(--line)}
  .rl-cs .factors li{grid-template-columns:minmax(0,1fr);gap:2px}
  .rl-cs .next{grid-template-columns:minmax(0,1fr)}
  .rl-cs .next .k{justify-self:start}
  .rl-cs .plot svg{height:220px}
  .rl-cs .quote{padding:22px 20px}
  .rl-cs .method{grid-template-columns:minmax(0,1fr);gap:6px}
  .rl-cs .cs-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-cs .cact{padding-right:16px}
  .rl-cs .cs-author{grid-template-columns:1fr}
  .rl-cs .cs-prose p,.rl-cs .cs-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-cs .go2,.rl-cs .svc,.rl-cs .cs{transition:none}.rl-cs .plot .tip{transition:none}}
</style>
<?php }, 24);
