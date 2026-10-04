<?php
/**
 * Plugin Name: Reinforce Lab - Product / Service post design
 * Description: The approved Product / Service design (D-077, mockup claude/design-previews/blog-product-template-mockup.html). A product sheet: spec plate beside the title ("We make this" disclosure, code and name, status badge, what it is, part of, best for, version, links), then one middle by subtype: How it works (problems, step flow with the human decision marked, in and out, a worked example), Use case (situation, what you need, playbook, signs it is working), Launch (release card, what changes for current users, changelog). Shared: does and does not do, who it is for, one CTA, related articles. Article about the Service; never Review, ratings, Product or Offer markup (D-076). reinforce-post.php hands Product posts to rl_product_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_product_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'product'; }
/* Agents and Search Authority OS need a status label until O-022 is settled (D-074). */
function rl_product_needs_status($svc) { return strpos((string) $svc, 'services/agents') === 0 || in_array($svc, ['search-authority-os', 'search-authority-diagnostic'], true); }
function rl_product_kind($svc) { return strpos((string) $svc, 'services/agents/') === 0 ? 'agent' : (rl_product_needs_status($svc) ? 'product' : 'service'); }

/* ---------- fields (Product / Service only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $type = [['field' => 'field_rl_type', 'operator' => '==', 'value' => 'product']];
    $show = [$type];
    $only = function ($sub) use ($type) { return [array_merge($type, [['field' => 'field_rl_p_subtype', 'operator' => '==', 'value' => $sub]])]; };
    $f = function ($key, $label, $ftype, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $ftype, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_product', 'title' => 'Product / Service (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_p_subtype', 'Subtype', 'select', ['choices' => function_exists('rl_pt_subtypes') ? rl_pt_subtypes() : [], 'default_value' => 'deepdive', 'instructions' => 'Picks the layout of the middle of the page.']),
            $f('rl_p_service', 'Service or product', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'The page this post supports. The post must target a different search than that page. Agents and Search Authority OS also need the status label (above).']),
            $f('rl_p_code', 'Code', 'text', ['instructions' => 'Optional, e.g. A-03 for an agent.']),
            $f('rl_p_name', 'Name shown', 'text', ['instructions' => 'Optional. Defaults to the service name, e.g. Evidence Verification Agent.']),
            $f('rl_p_promise', 'One-line promise', 'text', ['instructions' => 'As on its page, e.g. Every claim sourced and checked.']),
            $f('rl_p_what', 'What it is', 'text', ['instructions' => 'e.g. An AI agent, run by our team']),
            $f('rl_p_partof', 'Part of', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Optional, e.g. Search Authority OS.']),
            $f('rl_p_bestfor', 'Best for', 'text'),
            $f('rl_p_problems', 'The problem', 'textarea', ['rows' => 3, 'conditional_logic' => $only('deepdive'), 'instructions' => 'Up to 3, one per line: Problem | One sentence']),
            $f('rl_p_steps', 'Steps', 'textarea', ['rows' => 5, 'conditional_logic' => $only('deepdive'), 'instructions' => 'Up to 5, one per line: Step | What happens | What comes out. Start the step with * where a person decides. Example: *Flag for review | Weak evidence sent to a person. | The evidence log']),
            $f('rl_p_in', 'What goes in', 'text', ['conditional_logic' => $only('deepdive')]),
            $f('rl_p_out', 'What comes out', 'text', ['conditional_logic' => $only('deepdive')]),
            $f('rl_p_ex_title', 'Example: title', 'text', ['conditional_logic' => $only('deepdive'), 'instructions' => 'e.g. A sentence from a draft']),
            $f('rl_p_example', 'Example: start to finish', 'textarea', ['rows' => 4, 'conditional_logic' => $only('deepdive'), 'instructions' => 'One per line: Label | Text. Start the label with > to show the text as a quote. Example: >The claim | "Most adults with high blood pressure do not know they have it."']),
            $f('rl_p_situation', 'The situation', 'textarea', ['rows' => 3, 'conditional_logic' => $only('usecase')]),
            $f('rl_p_needs', 'What you need', 'textarea', ['rows' => 4, 'conditional_logic' => $only('usecase'), 'instructions' => 'One per line.']),
            $f('rl_p_plays', 'The playbook', 'textarea', ['rows' => 5, 'conditional_logic' => $only('usecase'), 'instructions' => 'One per line: Step | What to do | Who | When']),
            $f('rl_p_signs', 'Signs it is working', 'textarea', ['rows' => 3, 'conditional_logic' => $only('usecase'), 'instructions' => 'One per line. No invented numbers.']),
            $f('rl_p_version', 'Version', 'text', ['instructions' => 'Launch posts, e.g. 0.3']),
            $f('rl_p_release_date', 'Release date', 'date_picker', ['display_format' => 'j M Y', 'return_format' => 'Y-m-d', 'conditional_logic' => $only('launch')]),
            $f('rl_p_release_title', 'Release: headline', 'text', ['conditional_logic' => $only('launch')]),
            $f('rl_p_release_items', 'Release: what is in it', 'textarea', ['rows' => 5, 'conditional_logic' => $only('launch'), 'instructions' => 'One per line: new, changed or fixed | Text. Example: new | Checks medical claims against PubMed.']),
            $f('rl_p_whatchanges', 'What changes for current users', 'textarea', ['rows' => 3, 'conditional_logic' => $only('launch')]),
            $f('rl_p_changelog', 'Changelog', 'textarea', ['rows' => 4, 'instructions' => 'One per line: YYYY-MM-DD | Change. Newest first on the page.']),
            $f('rl_p_does', 'It does', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_p_limits', 'It does not', 'textarea', ['rows' => 3, 'instructions' => 'Required. One per line. Honest limits.']),
            $f('rl_p_honest', 'Honest note', 'text', ['instructions' => 'Lead sentence | More. Example: A confidence score is not a sign-off. | Your reviewers keep the final say.']),
            $f('rl_p_fit_yes', 'A good fit if', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_p_fit_no', 'Not the right fit if', 'textarea', ['rows' => 2, 'instructions' => 'One per line.']),
            $f('rl_p_cta_head', 'In-article CTA: headline', 'text', ['instructions' => 'Links to the product page. Leave empty for none.']),
            $f('rl_p_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_p_cta_button', 'In-article CTA: button text', 'text', ['instructions' => 'Defaults to "About the agent", "About the service" or "About the product".']),
        ],
    ]);
});

/* Posts about agents or Search Authority OS stay drafts until a status label is chosen (D-074, O-022). */
add_action('acf/save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'post' || get_post_status($post_id) !== 'publish') return;
    if ((string) get_post_meta($post_id, 'rl_type', true) !== 'product') return;
    if (!rl_product_needs_status((string) get_post_meta($post_id, 'rl_p_service', true))) return;
    if ((string) get_post_meta($post_id, 'rl_status', true) !== '') return;
    wp_update_post(['ID' => $post_id, 'post_status' => 'draft']);
}, 20);

/* ---------- data ---------- */
function rl_product_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
function rl_product_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $names = function_exists('rl_pt_services') ? rl_pt_services() : [];
    $svc = $m('rl_p_service'); $svc = isset($names[$svc]) ? $svc : '';
    $part = $m('rl_p_partof'); $part = isset($names[$part]) && $part !== $svc ? $part : '';
    $sub = $m('rl_p_subtype'); $subs = function_exists('rl_pt_subtypes') ? rl_pt_subtypes() : [];
    if (!isset($subs[$sub])) $sub = 'deepdive';
    $steps = [];
    foreach (array_slice(rl_product_rows(get_post_meta($id, 'rl_p_steps', true), 1), 0, 5) as $r) { $h = strpos($r[0], '*') === 0; $steps[] = ['name' => ltrim($h ? substr($r[0], 1) : $r[0]), 'what' => $r[1] ?? '', 'out' => $r[2] ?? '', 'human' => $h]; }
    $ex = [];
    foreach (rl_product_rows(get_post_meta($id, 'rl_p_example', true), 2) as $r) { $q = strpos($r[0], '>') === 0; $ex[] = ['k' => ltrim($q ? substr($r[0], 1) : $r[0]), 'v' => $r[1], 'quote' => $q]; }
    $items = [];
    foreach (rl_product_rows(get_post_meta($id, 'rl_p_release_items', true), 2) as $r) { $t = strtolower($r[0]); $items[] = [in_array($t, ['new', 'changed', 'fixed'], true) ? $t : 'changed', $r[1]]; }
    $log = [];
    foreach (rl_product_rows(get_post_meta($id, 'rl_p_changelog', true), 2) as $r) { $dt = function_exists('rl_pt_date') ? rl_pt_date($r[0]) : ''; if ($dt !== '') $log[] = [$dt, $r[1]]; }
    usort($log, function ($a, $b) { return strcmp($b[0], $a[0]); });
    $hn = array_map('trim', explode('|', $m('rl_p_honest'), 2));
    $rd = function_exists('rl_pt_date') ? rl_pt_date($m('rl_p_release_date')) : '';
    return $cache[$id] = [
        'sub' => $sub, 'sub_label' => trim(explode('/', $subs[$sub] ?? 'How it works')[0]), // chip shows Use case, Launch 'svc' => $svc, 'kind' => rl_product_kind($svc),
        'name' => $m('rl_p_name') !== '' ? $m('rl_p_name') : ($svc !== '' ? $names[$svc] : ''), 'code' => $m('rl_p_code'), 'promise' => $m('rl_p_promise'),
        'what' => $m('rl_p_what'), 'part' => $part, 'part_name' => $part !== '' ? $names[$part] : '', 'bestfor' => $m('rl_p_bestfor'), 'version' => $m('rl_p_version'),
        'problems' => array_slice(rl_product_rows(get_post_meta($id, 'rl_p_problems', true), 1), 0, 3), 'steps' => $steps, 'in' => $m('rl_p_in'), 'out' => $m('rl_p_out'),
        'ex_title' => $m('rl_p_ex_title'), 'example' => $ex,
        'situation' => $m('rl_p_situation'), 'needs' => rl_post_lines(get_post_meta($id, 'rl_p_needs', true)), 'plays' => rl_product_rows(get_post_meta($id, 'rl_p_plays', true), 1), 'signs' => rl_post_lines(get_post_meta($id, 'rl_p_signs', true)),
        'release_date' => $rd, 'release_title' => $m('rl_p_release_title'), 'items' => $items, 'whatchanges' => $m('rl_p_whatchanges'), 'log' => $log,
        'does' => rl_post_lines(get_post_meta($id, 'rl_p_does', true)), 'limits' => rl_post_lines(get_post_meta($id, 'rl_p_limits', true)),
        'honest' => $hn[0] !== '' ? $hn : null, 'fit_yes' => rl_post_lines(get_post_meta($id, 'rl_p_fit_yes', true)), 'fit_no' => rl_post_lines(get_post_meta($id, 'rl_p_fit_no', true)),
    ];
}

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_product_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $x = rl_product_data($id);
    $title = get_the_title($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    if (preg_match('/^(.{8,}?:)\s+(.+)$/u', $title, $tm) || preg_match('/^(.{12,}?)\s+((?:to|for|when|checks|finds|turns|makes|builds|works|helps)\s.+)$/iu', $title, $tm)) $h1 = esc_html($tm[1]) . ' <em>' . esc_html($tm[2]) . '</em>';
    else $h1 = esc_html($title);
    $purl = $x['svc'] !== '' ? $u($x['svc']) : ''; $diag = $u('search-authority-diagnostic');
    $about = ['agent' => 'About the agent', 'product' => 'About the product', 'service' => 'About the service'][$x['kind']];
    $status = $d['status'] !== '' && function_exists('rl_post_status_labels') ? rl_post_status_labels()[$d['status']] : '';
    $scls = ['available' => 'live', 'early' => 'early', 'development' => 'dev'][$d['status']] ?? '';
    $missing = $status === '' && rl_product_needs_status($x['svc']);
    $rows = array_filter([['What it is', $x['what'], ''], ['Part of', $x['part_name'], $x['part'] !== '' ? $u($x['part']) : ''], ['Best for', $x['bestfor'], ''],
        ['Version', trim($x['version'] . ($x['sub'] === 'launch' && $x['release_date'] !== '' ? ' · ' . date_i18n('j M Y', strtotime($x['release_date'])) : ''), ' ·'), '']], function ($r) { return $r[1] !== ''; });
    $chead = trim((string) get_post_meta($id, 'rl_p_cta_head', true));
    $cta = ($chead !== '' && $purl) ? ['head' => $chead, 'sub' => trim((string) get_post_meta($id, 'rl_p_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_p_cta_button', true)) ?: $about] : null;
    $ic = function ($p) { return '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true">' . $p . '</svg>'; };
    $i_ok = $ic('<path d="M3 8.5l3 3 7-7"/>'); $i_no = $ic('<path d="M4 4l8 8M12 4l-8 8"/>');
    $i_mk = $ic('<path d="M8 1.5l5.5 2.5v4c0 3.2-2.4 5.6-5.5 6.5C4.9 13.6 2.5 11.2 2.5 8V4z"/><path d="M5.5 8l2 2 3-3.5"/>');
    $i_pp = $ic('<circle cx="8" cy="5" r="2.6"/><path d="M3 14c.6-3 2.6-4.5 5-4.5s4.4 1.5 5 4.5"/>');
    $tag = ['new' => 'New', 'changed' => 'Changed', 'fixed' => 'Fixed'];
    ?>
<div class="rl-page rl-post rl-pd">
<?php if ($missing) { ?><p class="p-guard" role="status">No status label: posts about agents or Search Authority OS stay drafts until a status label is chosen (O-022).</p><?php } ?>

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<div class="wrap">
  <header class="p-hero">
    <div>
      <div class="p-kicker"><span class="p-kind"><?php echo esc_html($x['sub_label']); ?></span><?php if ($c['cat']) echo '<a class="p-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
      <h1 class="p-h1"><?php echo $h1; ?></h1>
      <?php if ($standfirst !== '') { ?><p class="p-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
      <div class="p-by">
        <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
        <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
        <?php if ($d['updated'] !== '') { ?><span>Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
      </div>
    </div>
    <aside class="p-plate" aria-label="About this <?php echo esc_attr($x['kind']); ?>">
      <div class="made"><?php echo $i_mk; ?><span><b>We make this.</b> This article is about our own <?php echo $x['kind'] === 'service' ? 'service' : 'product'; ?>.</span></div>
      <?php if ($x['name'] !== '') { ?><div class="pid<?php echo $x['code'] !== '' ? '' : ' nocode'; ?>"><?php if ($x['code'] !== '') echo '<span class="code">' . esc_html($x['code']) . '</span>'; ?><b><?php echo esc_html($x['name']); ?></b><?php if ($x['promise'] !== '') echo '<p>' . esc_html($x['promise']) . '</p>'; ?></div><?php } ?>
      <?php if ($status !== '') { ?><div class="pst"><span class="k">Status</span><span class="p-badge <?php echo esc_attr($scls); ?>"><?php echo esc_html($status); ?></span></div><?php } ?>
      <?php if ($rows) { ?><dl><?php foreach ($rows as $r) echo '<div><dt>' . esc_html($r[0]) . '</dt><dd>' . ($r[2] ? '<a href="' . esc_url($r[2]) . '">' . esc_html($r[1]) . '</a>' : esc_html($r[1])) . '</dd></div>'; ?></dl><?php } ?>
      <div class="acts<?php echo $purl ? '' : ' one'; ?>"><?php if ($purl) echo '<a href="' . esc_url($purl) . '">' . esc_html($about) . '</a>'; ?><a class="sec" href="<?php echo esc_url($diag); ?>">Free diagnostic</a></div>
    </aside>
  </header>
</div>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap p-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="p-main">
    <?php if ($d['answer'] !== '') { ?><div class="p-answer"><p class="t">In short</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>

    <?php if ($x['sub'] === 'deepdive') { ?>
      <?php if ($x['problems']) { ?>
      <div class="sec-h"><span>The problem</span><h2>What goes wrong without it</h2></div>
      <div class="p-probs n<?php echo count($x['problems']); ?>"><?php foreach ($x['problems'] as $p) echo '<div class="pb"><b>' . esc_html($p[0]) . '</b>' . (!empty($p[1]) ? '<p>' . esc_html($p[1]) . '</p>' : '') . '</div>'; ?></div>
      <?php } ?>
      <?php if ($x['steps']) { ?>
      <div class="sec-h" id="how"><span>Step by step</span><h2>How it works</h2></div>
      <ol class="p-flow n<?php echo count($x['steps']); ?>"><?php foreach ($x['steps'] as $k => $s) echo '<li class="st' . ($s['human'] ? ' human' : '') . '"><span class="n">Step ' . ($k + 1) . '</span><h3>' . esc_html($s['name']) . '</h3>' . ($s['what'] !== '' ? '<p>' . esc_html($s['what']) . '</p>' : '') . ($s['human'] ? '<span class="who">' . $i_pp . 'A person decides</span>' : '') . ($s['out'] !== '' ? '<div class="out"><span>Out:</span> ' . esc_html($s['out']) . '</div>' : '') . '</li>'; ?></ol>
      <?php } ?>
      <?php if ($x['in'] !== '' || $x['out'] !== '') { ?><div class="p-io"><?php if ($x['in'] !== '') echo '<div><span class="k">What goes in</span>' . esc_html($x['in']) . '</div>'; if ($x['out'] !== '') echo '<div><span class="k">What comes out</span>' . esc_html($x['out']) . '</div>'; ?></div><?php } ?>
      <?php if ($x['example']) { ?>
      <div class="sec-h"><span>Example</span><h2>Start to finish</h2></div>
      <div class="p-walk"><?php if ($x['ex_title'] !== '') echo '<div class="wh"><b>' . esc_html($x['ex_title']) . '</b></div>'; ?><ol><?php foreach ($x['example'] as $e) echo '<li><span class="k">' . esc_html($e['k']) . '</span>' . ($e['quote'] ? '<p class="claim">' . esc_html($e['v']) . '</p>' : '<p>' . esc_html($e['v']) . '</p>') . '</li>'; ?></ol></div>
      <?php } ?>
    <?php } elseif ($x['sub'] === 'usecase') { ?>
      <?php if ($x['situation'] !== '') { ?><div class="sec-h"><span>The situation</span><h2>Where this helps</h2></div><div class="p-prose"><?php echo wpautop(esc_html($x['situation'])); ?></div><?php } ?>
      <?php if ($x['needs']) { ?><div class="sec-h"><span>Before you start</span><h2>What you need</h2></div><ul class="p-need"><?php foreach ($x['needs'] as $n) echo '<li>' . esc_html($n) . '</li>'; ?></ul><?php } ?>
      <?php if ($x['plays']) { ?>
      <div class="sec-h" id="how"><span>The playbook</span><h2>Step by step</h2></div>
      <ol class="p-plays"><?php foreach ($x['plays'] as $k => $p) { $meta = ''; if (!empty($p[2])) $meta .= '<div><dt>Who</dt><dd>' . esc_html($p[2]) . '</dd></div>'; if (!empty($p[3])) $meta .= '<div><dt>When</dt><dd>' . esc_html($p[3]) . '</dd></div>';
          echo '<li class="play' . ($meta ? '' : ' nometa') . '"><span class="n" aria-hidden="true">' . ($k + 1) . '</span><div><h3>' . esc_html($p[0]) . '</h3>' . (!empty($p[1]) ? '<p>' . esc_html($p[1]) . '</p>' : '') . '</div>' . ($meta ? '<dl>' . $meta . '</dl>' : '') . '</li>'; } ?></ol>
      <?php } ?>
      <?php if ($x['signs']) { ?><div class="p-signs"><span class="k">Signs it is working</span><ul><?php foreach ($x['signs'] as $s) echo '<li>' . esc_html($s) . '</li>'; ?></ul></div><?php } ?>
    <?php } else { ?>
      <?php if ($x['items'] || $x['release_title'] !== '') { ?>
      <div class="sec-h"><span>This release</span><h2>What is new</h2></div>
      <div class="p-release<?php echo $x['version'] !== '' ? '' : ' nov'; ?>">
        <?php if ($x['version'] !== '') { ?><div class="v"><?php echo esc_html($x['version']); ?><?php if ($x['release_date'] !== '') echo '<small><time datetime="' . esc_attr($x['release_date']) . '">' . esc_html(date_i18n('j M Y', strtotime($x['release_date']))) . '</time></small>'; ?></div><?php } ?>
        <div><?php if ($x['release_title'] !== '') echo '<h3>' . esc_html($x['release_title']) . '</h3>'; ?><?php if ($x['items']) { ?><ul><?php foreach ($x['items'] as $it) echo '<li><span class="tag ' . esc_attr($it[0]) . '">' . esc_html($tag[$it[0]]) . '</span><span>' . esc_html($it[1]) . '</span></li>'; ?></ul><?php } ?></div>
      </div>
      <?php } ?>
      <?php if ($x['whatchanges'] !== '') { ?><div class="sec-h"><span>If you already use it</span><h2>What changes for you</h2></div><div class="p-prose"><?php echo wpautop(esc_html($x['whatchanges'])); ?></div><?php } ?>
    <?php } ?>

    <?php if (trim($c['body']) !== '') echo '<div class="p-prose p-body">' . $c['body'] . '</div>'; ?>

    <?php if ($x['log']) { ?>
    <div class="sec-h" id="changelog"><span>Record</span><h2>Changelog</h2></div>
    <ol class="p-log"><?php foreach ($x['log'] as $l) echo '<li><time datetime="' . esc_attr($l[0]) . '">' . esc_html(date_i18n('j M Y', strtotime($l[0]))) . '</time><p>' . esc_html($l[1]) . '</p></li>'; ?></ol>
    <?php } ?>

    <?php if ($x['does'] || $x['limits']) { ?>
    <div class="sec-h"><span>Honest limits</span><h2><?php echo $x['does'] ? 'What it does and does not do' : 'What it does not do'; ?></h2></div>
    <div class="p-nots<?php echo ($x['does'] && $x['limits']) ? '' : ' one'; ?>">
      <?php if ($x['does']) { ?><div class="yes"><span class="k">It does</span><ul><?php foreach ($x['does'] as $l) echo '<li>' . $i_ok . '<span>' . esc_html($l) . '</span></li>'; ?></ul></div><?php } ?>
      <?php if ($x['limits']) { ?><div class="no"><span class="k">It does not</span><ul><?php foreach ($x['limits'] as $l) echo '<li>' . $i_no . '<span>' . esc_html($l) . '</span></li>'; ?></ul></div><?php } ?>
    </div>
    <?php if ($x['honest']) echo '<p class="p-honest"><b>' . esc_html($x['honest'][0]) . '</b>' . (!empty($x['honest'][1]) ? ' ' . esc_html($x['honest'][1]) : '') . '</p>'; ?>
    <?php } ?>

    <?php if ($x['fit_yes'] || $x['fit_no']) { ?>
    <div class="sec-h"><span>Fit</span><h2>Who it is for</h2></div>
    <div class="p-fit<?php echo ($x['fit_yes'] && $x['fit_no']) ? '' : ' one'; ?>">
      <?php if ($x['fit_yes']) { ?><div><span class="k">A good fit if</span><ul><?php foreach ($x['fit_yes'] as $l) echo '<li>' . esc_html($l) . '</li>'; ?></ul></div><?php } ?>
      <?php if ($x['fit_no']) { ?><div><span class="k">Not the right fit if</span><ul><?php foreach ($x['fit_no'] as $l) echo '<li>' . esc_html($l) . '</li>'; ?></ul></div><?php } ?>
    </div>
    <?php } ?>

    <?php if ($cta) { ?>
    <aside class="p-icta" aria-label="Reinforce Lab <?php echo esc_attr($x['kind']); ?>">
      <div><p class="lbl">Reinforce Lab · <?php echo esc_html($x['part_name'] !== '' ? $x['part_name'] : $x['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
      <div class="cact"><a class="go2" href="<?php echo esc_url($purl); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
    </aside>
    <?php } ?>
  </div>

  <?php
    $rel = [];
    $base = ['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true, 'fields' => 'ids'];
    if ($x['svc'] !== '') $rel = get_posts($base + ['meta_query' => [['key' => 'rl_type', 'value' => 'product'], ['key' => 'rl_p_service', 'value' => $x['svc']]]]);
    if (count($rel) < 3) $rel = array_merge($rel, get_posts(array_merge($base, ['posts_per_page' => 3 - count($rel), 'post__not_in' => array_merge([$id], $rel), 'meta_key' => 'rl_type', 'meta_value' => 'product'])));
    if ($rel) { ?>
  <section class="p-rel" aria-labelledby="rel-pd-h">
    <div class="sec-h"><span>More on our products</span><h2 id="rel-pd-h">Related articles</h2></div>
    <div class="p-more"><?php foreach ($rel as $rid) { $rx = rl_product_data($rid); echo '<a class="rr" href="' . esc_url(get_permalink($rid)) . '"><span class="k">' . esc_html($rx['sub_label']) . '</span><b>' . esc_html(get_the_title($rid)) . '</b></a>'; } ?></div>
  </section>
  <?php } ?>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <div class="p-back">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="p-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </div>
  <?php } ?>

  <aside class="p-author" aria-label="About the author">
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
<?php
}

/* ---------- schema: the article is about our Service; never Review, ratings, Product or Offer (D-076) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_product_view()) return $graph;
    $x = rl_product_data(get_queried_object_id());
    if ($x['svc'] === '' || !function_exists('rl_url_by_path')) return $graph;
    $su = rl_url_by_path($x['svc'], '');
    if (!$su) return $graph;
    $svc = array_filter(['@type' => 'Service', '@id' => $su . '#service', 'name' => $x['name'], 'url' => $su, 'provider' => ['@id' => home_url('/#organization')]]);
    $out = [];
    foreach ($graph as $n) {
        if (is_array($n) && !empty($n['@type']) && array_intersect((array) $n['@type'], ['Review', 'AggregateRating', 'Product', 'Offer'])) continue;
        if (is_array($n) && !empty($n['@type']) && in_array('Article', (array) $n['@type'], true)) { $n['about'] = $svc; unset($n['review'], $n['aggregateRating'], $n['offers']); }
        $out[] = $n;
    }
    return $out;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_product_view()) return; ?>
<style id="rl-product-css">
.rl-pd{color:var(--ink-dim);--ok:#3fa36b;--ok-line:rgba(63,163,107,.45);--amber:#d39b3a;--blue:#7fb2e5}
.rl-pd h1,.rl-pd h2,.rl-pd h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-pd .ic{width:14px;height:14px;flex:none;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:square}
.rl-pd .p-guard{margin:0;background:var(--amber);color:#1a1205;font-family:var(--f-mono);font-size:12px;letter-spacing:.06em;text-align:center;padding:8px var(--gutter,16px)}
.rl-pd .p-hero{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,.9fr);gap:clamp(28px,5vw,60px);align-items:start;padding-block:clamp(24px,4vw,40px) 0}
.rl-pd .p-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px}
.rl-pd .p-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-pd .p-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-pd .p-h1{font-size:clamp(34px,4.6vw,60px);line-height:1;margin:0}
.rl-pd .p-h1 em{font-style:normal;color:var(--red-3)}
.rl-pd .p-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;margin:18px 0 0;max-width:640px}
.rl-pd .p-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-pd .p-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-pd .p-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-pd .p-by b{color:var(--ink-dim);font-weight:500}
.rl-pd .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-pd .p-plate{border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2))}
.rl-pd .made{display:flex;align-items:center;gap:10px;padding:11px 18px;background:rgba(153,0,0,.18);border-bottom:1px solid var(--red-line);font-size:13.5px;color:var(--ink)}
.rl-pd .made .ic{width:16px;height:16px;color:var(--red-3)}
.rl-pd .made b{font-weight:600}
.rl-pd .pid{display:grid;grid-template-columns:auto minmax(0,1fr);gap:4px 16px;padding:18px;border-bottom:1px solid var(--line)}
.rl-pd .pid.nocode{grid-template-columns:minmax(0,1fr)}
.rl-pd .pid .code{grid-row:span 2;width:62px;height:62px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:21px;color:var(--red-3);background:repeating-linear-gradient(135deg,transparent 0 6px,rgba(226,59,59,.06) 6px 12px)}
.rl-pd .pid b{font-family:var(--f-display);font-size:24px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1.05}
.rl-pd .pid p{margin:0;font-size:14px}
.rl-pd .pst{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:12px 18px;border-bottom:1px solid var(--line)}
.rl-pd .pst .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-pd .p-badge{display:inline-flex;align-items:center;gap:7px;font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;padding:4px 9px;border:1px solid;background:none;border-radius:0;font-weight:400;line-height:1.4}
.rl-pd .p-badge::before{content:"";width:7px;height:7px;background:currentColor}
.rl-pd .p-badge.dev{color:var(--amber);border-color:rgba(211,155,58,.55)}
.rl-pd .p-badge.early{color:var(--blue);border-color:rgba(127,178,229,.5)}
.rl-pd .p-badge.live{color:var(--ok);border-color:var(--ok-line)}
.rl-pd .p-plate dl{margin:0;padding:4px 18px 8px}
.rl-pd .p-plate dl div{display:grid;grid-template-columns:96px minmax(0,1fr);gap:12px;padding:9px 0;border-top:1px solid var(--line);font-size:14px}
.rl-pd .p-plate dl div:first-child{border-top:0}
.rl-pd .p-plate dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);padding-top:3px}
.rl-pd .p-plate dd{margin:0;color:var(--ink)}
.rl-pd .p-plate dd a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-pd .p-plate .acts{display:grid;grid-template-columns:1fr 1fr;border-top:1px solid var(--line-2)}
.rl-pd .p-plate .acts.one{grid-template-columns:1fr}
.rl-pd .p-plate .acts a{display:flex;align-items:center;justify-content:center;padding:13px 10px;font-family:var(--f-display);font-size:13px;letter-spacing:.07em;text-transform:uppercase;text-decoration:none;color:#fff;background:var(--red);transition:background .15s}
.rl-pd .p-plate .acts a:hover{background:var(--red-2)}
.rl-pd .p-plate .acts a.sec{background:transparent;color:var(--ink)}
.rl-pd .p-plate .acts a+a.sec{border-left:1px solid var(--line-2)}
.rl-pd .p-plate .acts a.sec:hover{background:var(--panel-2,var(--panel))}
.rl-pd .p-feat{margin:28px auto 0}
.rl-pd .p-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-pd .p-main{max-width:900px;margin:0 auto;padding-block:clamp(34px,5vw,52px) 10px}
.rl-pd .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px;scroll-margin-top:96px}
.rl-pd .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3)}
.rl-pd .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-pd .p-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-pd .p-answer .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-pd .p-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-pd .p-prose>*{margin:0 0 1.1em}
.rl-pd .p-prose p,.rl-pd .p-prose li{font-size:17.5px;line-height:1.75}
.rl-pd .p-prose h2{font-size:clamp(22px,2.4vw,26px);margin:1.6em 0 .5em}
.rl-pd .p-prose h3{font-size:20px;margin:1.4em 0 .5em}
.rl-pd .p-prose strong{color:var(--ink);font-weight:600}
.rl-pd .p-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-pd .p-prose ul,.rl-pd .p-prose ol{padding-left:1.2em}
.rl-pd .p-prose li::marker{color:var(--red-3)}
.rl-pd .p-body{margin-top:32px}
.rl-pd .p-probs{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-pd .p-probs.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-pd .p-probs.n1{grid-template-columns:minmax(0,1fr)}
.rl-pd .pb{background:var(--bg);padding:16px 18px;display:grid;gap:4px;align-content:start}
.rl-pd .pb b{color:var(--ink);font-weight:600;font-size:15.5px}
.rl-pd .pb p{margin:0;font-size:14px}
.rl-pd .p-flow{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));border:1px solid var(--line-2);background:var(--bg-2)}
.rl-pd .p-flow.n5{grid-template-columns:repeat(5,minmax(0,1fr))}
.rl-pd .p-flow.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-pd .p-flow.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-pd .p-flow.n1{grid-template-columns:minmax(0,1fr)}
.rl-pd .st{position:relative;margin:0;padding:18px 18px 16px;display:grid;gap:6px;align-content:start;border-left:1px solid var(--line)}
.rl-pd .st:first-child{border-left:0}
.rl-pd .st::after{content:"";position:absolute;right:-7px;top:26px;width:12px;height:12px;background:var(--bg-2);border-top:1px solid var(--red-3);border-right:1px solid var(--red-3);transform:rotate(45deg);z-index:1}
.rl-pd .st:last-child::after{display:none}
.rl-pd .st .n{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-pd .st h3{font-size:18px;margin:0}
.rl-pd .st p{margin:0;font-size:14px}
.rl-pd .st .out{margin-top:6px;font-family:var(--f-mono);font-size:11px;color:var(--ink);border-top:1px dashed var(--line-2);padding-top:8px}
.rl-pd .st .out span{color:var(--ink-faint)}
.rl-pd .st.human{background:linear-gradient(180deg,rgba(63,163,107,.08),transparent)}
.rl-pd .st .who{display:inline-flex;align-items:center;gap:6px;font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--ok);border:1px solid var(--ok-line);padding:2px 7px;justify-self:start}
.rl-pd .st .who .ic{width:11px;height:11px}
.rl-pd .p-io{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:12px;margin-top:12px}
.rl-pd .p-io div{border:1px dashed var(--line-2);padding:12px 14px;font-size:14px}
.rl-pd .p-io .k{display:block;font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:4px}
.rl-pd .p-walk{border:1px solid var(--line-2);background:var(--panel)}
.rl-pd .p-walk .wh{padding:14px 18px;border-bottom:1px solid var(--line-2)}
.rl-pd .p-walk .wh b{font-family:var(--f-display);font-size:18px;text-transform:uppercase;color:var(--ink);font-weight:500}
.rl-pd .p-walk ol{list-style:none;margin:0;padding:0}
.rl-pd .p-walk li{display:grid;grid-template-columns:130px minmax(0,1fr);gap:16px;padding:14px 18px;margin:0;border-top:1px solid var(--line)}
.rl-pd .p-walk li:first-child{border-top:0}
.rl-pd .p-walk .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);padding-top:2px}
.rl-pd .p-walk p{margin:0;font-size:15px;color:var(--ink)}
.rl-pd .p-walk .claim{font-family:var(--f-mono);font-size:13px;background:var(--bg-2);border-left:2px solid var(--red-3);padding:8px 12px}
.rl-pd .p-need{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px 22px}
.rl-pd .p-need li{display:grid;grid-template-columns:18px 1fr;gap:8px;font-size:15px;color:var(--ink);margin:0}
.rl-pd .p-need li::before{content:"";width:12px;height:12px;border:1.5px solid var(--red-3);margin-top:5px}
.rl-pd .p-plays{list-style:none;margin:0;padding:0;border:1px solid var(--line-2)}
.rl-pd .play{display:grid;grid-template-columns:64px minmax(0,1fr) 200px;gap:16px;padding:18px 20px;margin:0;border-top:1px solid var(--line);align-items:start}
.rl-pd .play.nometa{grid-template-columns:64px minmax(0,1fr)}
.rl-pd .play:first-child{border-top:0}
.rl-pd .play .n{font-family:var(--f-display);font-size:40px;line-height:.9;color:transparent;-webkit-text-stroke:1.2px var(--red-3);font-weight:700}
.rl-pd .play h3{font-family:var(--f-body);text-transform:none;letter-spacing:0;font-size:17px;font-weight:600;margin:0 0 4px;line-height:1.35}
.rl-pd .play p{margin:0;font-size:14.5px}
.rl-pd .play dl{margin:0;display:grid;gap:6px;font-size:13px}
.rl-pd .play dt{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-pd .play dd{margin:0;color:var(--ink)}
.rl-pd .p-signs{margin-top:16px;border:1px solid var(--ok-line);background:linear-gradient(180deg,rgba(63,163,107,.06),transparent);padding:16px 18px}
.rl-pd .p-signs .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ok);display:block;margin-bottom:8px}
.rl-pd .p-signs ul{margin:0;padding:0 0 0 1.1em;display:grid;gap:6px;font-size:15px}
.rl-pd .p-signs li::marker{color:var(--ok)}
.rl-pd .p-release{display:grid;grid-template-columns:auto minmax(0,1fr);gap:18px 26px;border:1px solid var(--red-line);background:radial-gradient(90% 140% at 0% 0%,rgba(153,0,0,.18),transparent 60%),var(--panel);padding:22px 24px}
.rl-pd .p-release.nov{grid-template-columns:minmax(0,1fr)}
.rl-pd .p-release .v{font-family:var(--f-display);font-size:56px;line-height:.9;color:var(--ink)}
.rl-pd .p-release .v small{display:block;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin-top:8px}
.rl-pd .p-release h3{font-size:22px;margin:0 0 8px}
.rl-pd .p-release ul{margin:0;padding:0;list-style:none;display:grid;gap:8px}
.rl-pd .p-release li{display:grid;grid-template-columns:66px 1fr;gap:10px;font-size:15px;color:var(--ink);margin:0}
.rl-pd .p-release .tag{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.12em;text-transform:uppercase;border:1px solid var(--line-2);padding:2px 0;text-align:center;align-self:start;margin-top:3px;color:var(--ink-dim)}
.rl-pd .p-release .tag.new{color:var(--ok);border-color:var(--ok-line)}
.rl-pd .p-release .tag.fixed{color:var(--amber);border-color:rgba(211,155,58,.5)}
.rl-pd .p-log{list-style:none;margin:0;padding:0;position:relative}
.rl-pd .p-log::before{content:"";position:absolute;left:5px;top:6px;bottom:6px;width:2px;background:var(--line-2)}
.rl-pd .p-log li{display:grid;grid-template-columns:12px 110px minmax(0,1fr);gap:14px;padding:0 0 16px;margin:0}
.rl-pd .p-log li::before{content:"";width:12px;height:12px;background:var(--bg);border:2px solid var(--red-3);margin-top:4px;position:relative;z-index:1}
.rl-pd .p-log li:first-child::before{background:var(--red-3)}
.rl-pd .p-log time{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);padding-top:2px}
.rl-pd .p-log p{margin:0;font-size:15px;color:var(--ink)}
.rl-pd .p-nots{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-pd .p-nots.one,.rl-pd .p-fit.one{grid-template-columns:minmax(0,1fr)}
.rl-pd .p-nots>div{background:var(--bg);padding:18px 20px}
.rl-pd .p-nots .k,.rl-pd .p-fit .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;display:block;margin-bottom:10px}
.rl-pd .p-nots .yes .k{color:var(--ok)}
.rl-pd .p-nots .no .k{color:var(--red-3)}
.rl-pd .p-nots ul{list-style:none;margin:0;padding:0;display:grid;gap:9px}
.rl-pd .p-nots li{display:grid;grid-template-columns:16px 1fr;gap:10px;font-size:15px;color:var(--ink);margin:0}
.rl-pd .p-nots li .ic{margin-top:4px;stroke-width:2}
.rl-pd .p-nots .yes .ic{color:var(--ok)}
.rl-pd .p-nots .no .ic{color:var(--red-3)}
.rl-pd .p-honest{margin:12px 0 0;border-left:3px solid var(--amber);padding:12px 16px;background:linear-gradient(90deg,rgba(211,155,58,.07),transparent);font-size:15px}
.rl-pd .p-honest b{color:var(--ink)}
.rl-pd .p-fit{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:16px}
.rl-pd .p-fit>div{border:1px solid var(--line-2);padding:16px 18px}
.rl-pd .p-fit .k{color:var(--ink-faint)}
.rl-pd .p-fit ul{margin:0;padding-left:1.1em;display:grid;gap:6px;font-size:15px}
.rl-pd .p-fit li::marker{color:var(--red-3)}
.rl-pd .p-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-pd .p-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-pd .p-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-pd .p-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-pd .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-pd .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-pd .go2:hover{background:var(--red-2)}
.rl-pd .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-pd .p-rel{margin-top:46px;padding:0}
.rl-pd .p-rel .sec-h{margin-top:0}
.rl-pd .p-more{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-pd .rr{background:var(--bg);padding:18px 20px;text-decoration:none;display:grid;gap:8px;align-content:start;transition:background .2s}
.rl-pd .rr:hover{background:var(--panel)}
.rl-pd .rr .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-pd .rr b{font-family:var(--f-display);font-size:19px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1.15}
.rl-pd .p-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-pd .p-back .sec-h{margin-top:0}
.rl-pd .p-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-pd .p-src li{padding:6px 0;color:var(--ink-faint)}
.rl-pd .p-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-pd .p-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-pd .p-author .av{width:72px;height:72px;font-size:28px}
.rl-pd .p-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-pd .p-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-pd .p-author p{margin:0 0 8px;font-size:15px}
.rl-pd .p-author .links{display:flex;gap:18px;font-size:14px}
.rl-pd .p-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:1000px){
  .rl-pd .p-hero{grid-template-columns:minmax(0,1fr)}
  .rl-pd .p-flow,.rl-pd .p-flow.n3,.rl-pd .p-flow.n5{grid-template-columns:repeat(2,minmax(0,1fr))}
  .rl-pd .st:nth-child(odd){border-left:0}
  .rl-pd .st:nth-child(n+3){border-top:1px solid var(--line)}
  .rl-pd .st:nth-child(even)::after{display:none}
  .rl-pd .p-more{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media(max-width:760px){
  .rl-pd .p-flow,.rl-pd .p-flow.n2,.rl-pd .p-flow.n3,.rl-pd .p-flow.n5{grid-template-columns:minmax(0,1fr)}
  .rl-pd .st{border-left:0;border-top:1px solid var(--line)}
  .rl-pd .st:first-child{border-top:0}
  .rl-pd .st::after,.rl-pd .st:nth-child(even)::after{display:block;right:auto;left:24px;top:auto;bottom:-7px;transform:rotate(135deg)}
  .rl-pd .st:last-child::after{display:none}
  .rl-pd .p-probs,.rl-pd .p-probs.n2,.rl-pd .p-io,.rl-pd .p-nots,.rl-pd .p-fit,.rl-pd .p-need,.rl-pd .p-more,.rl-pd .p-back{grid-template-columns:minmax(0,1fr)}
  .rl-pd .p-walk li{grid-template-columns:minmax(0,1fr);gap:4px}
  .rl-pd .play,.rl-pd .play.nometa{grid-template-columns:44px minmax(0,1fr)}
  .rl-pd .play dl{grid-column:2}
  .rl-pd .play .n{font-size:32px}
  .rl-pd .p-release{grid-template-columns:minmax(0,1fr)}
  .rl-pd .p-log li{grid-template-columns:12px minmax(0,1fr)}
  .rl-pd .p-log li p{grid-column:2}
  .rl-pd .p-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-pd .cact{padding-right:16px}
  .rl-pd .p-author{grid-template-columns:1fr}
  .rl-pd .p-prose p,.rl-pd .p-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-pd .go2,.rl-pd .rr,.rl-pd .p-plate .acts a{transition:none}}
</style>
<?php }, 24);
