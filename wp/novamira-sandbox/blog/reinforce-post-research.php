<?php
/**
 * Plugin Name: Reinforce Lab - Research post design
 * Description: The approved Research design (D-077, mockup claude/design-previews/blog-research-template-mockup.html). A published report: study card beside the title (report number, version, sample, period, markets, method, who checked it, data and citation buttons), headline number, key findings as a numbered ledger with a link for each, numbered figures with source, table view and CSV, how we ran the study (at a glance, steps, definitions, limits), what this means by reader, one in-article CTA, data and citation, version history with corrections, related studies. reinforce-post.php hands Research posts to rl_research_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_research_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'research'; }

/* ---------- fields (Research only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'research']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $s = function ($key, $label, $type, $extra = []) { return array_merge(['key' => 'field_rl_rs_fig_' . $key, 'name' => $key, 'label' => $label, 'type' => $type], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_research', 'title' => 'Research (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_rs_report_no', 'Report number', 'text', ['instructions' => 'Optional, e.g. RL-R-2026-03. Leave empty to show none.']),
            $f('rl_rs_sample', 'Sample', 'text', ['instructions' => 'The headline size, e.g. 1,200 answers.']),
            $f('rl_rs_sample_note', 'Sample: detail', 'text', ['instructions' => 'e.g. 400 questions, 3 AI answer tools']),
            $f('rl_rs_period', 'Data collected', 'text', ['instructions' => 'e.g. 1 to 31 July 2026']),
            $f('rl_rs_coverage', 'Data collected: dates for search engines', 'text', ['instructions' => 'YYYY-MM-DD/YYYY-MM-DD, e.g. 2026-07-01/2026-07-31. Used in the Dataset markup only.']),
            $f('rl_rs_markets', 'Markets', 'text', ['instructions' => 'e.g. UK and US, English']),
            $f('rl_rs_method', 'Method in one line', 'textarea', ['rows' => 2, 'instructions' => 'One or two sentences, e.g. Answers collected by hand, each citation classified by two people. Also used as the dataset description.']),
            $f('rl_rs_checked', 'Checked by', 'text', ['instructions' => 'Who checked the work, e.g. Second analyst, every classification.']),
            $f('rl_rs_headline', 'Headline finding', 'text', ['instructions' => 'Number | Sentence | Sample size. Example: 61% | Six in ten answers cited a vendor website. | n = 1,200 answers']),
            $f('rl_rs_findings', 'Key findings', 'textarea', ['rows' => 5, 'instructions' => 'Up to 5, one per line: Number | Finding in one sentence | Detail | Figure number. Example: 81% | Pricing questions cited a vendor website most often. | Definition questions least often (38%). | 2']),
            $f('rl_rs_found_intro', 'What we found: intro', 'textarea', ['rows' => 3, 'instructions' => 'Shown before the figures. The article body follows the figures.']),
            $f('rl_rs_figures', 'Figures', 'repeater', ['layout' => 'block', 'button_label' => 'Add figure', 'max' => 4, 'sub_fields' => [
                $s('title', 'Title', 'text', ['required' => 1, 'instructions' => 'e.g. Share of answers citing each source type']),
                $s('takeaway', 'Takeaway', 'text', ['instructions' => 'What the figure shows, in one sentence.']),
                $s('kind', 'Chart', 'select', ['choices' => ['bars' => 'Horizontal bars (long labels, ranking)', 'cols' => 'Columns (short labels, an order)'], 'default_value' => 'bars']),
                $s('data', 'Data', 'textarea', ['rows' => 6, 'instructions' => 'One per line: Label | Number. Example: Vendor websites | 61']),
                $s('suffix', 'Number suffix', 'text', ['default_value' => '%', 'instructions' => 'Shown after each number, e.g. %. Leave empty for plain numbers.']),
                $s('unit', 'Tooltip text', 'text', ['instructions' => 'Shown after the number on hover, e.g. of answers']),
                $s('note', 'Sample and source', 'text', ['instructions' => 'e.g. n = 1,200 answers. An answer can cite more than one source type.']),
            ]]),
            $f('rl_rs_datasource', 'At a glance: sources', 'text', ['instructions' => 'e.g. Answers saved as screenshots and text']),
            $f('rl_rs_analysis', 'At a glance: analysis', 'text', ['instructions' => 'e.g. Each citation classified twice; disagreements settled by a third person']),
            $f('rl_rs_steps', 'Method steps', 'textarea', ['rows' => 4, 'instructions' => 'Up to 4, one per line: Step | What we did']),
            $f('rl_rs_defs', 'Definitions', 'textarea', ['rows' => 3, 'instructions' => 'One per line: Term | What it means in this study']),
            $f('rl_rs_limits', 'Limits of this study', 'textarea', ['rows' => 4, 'instructions' => 'One per line. Honest limits.']),
            $f('rl_rs_means', 'What this means for you', 'textarea', ['rows' => 3, 'instructions' => 'Up to 3, one per line: Reader | Headline | Text. Example: Founders | Track how AI tools describe you | Ask the questions your buyers ask, every month.']),
            $f('rl_rs_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Shown after "What this means". Leave empty for none.']),
            $f('rl_rs_cta_head', 'In-article CTA: headline', 'text'),
            $f('rl_rs_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_rs_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
            $f('rl_rs_dataset', 'Dataset URL', 'url', ['instructions' => 'The file to download (CSV preferred). Leave empty if the data is not published.']),
            $f('rl_rs_dataset_name', 'Dataset: file name', 'text', ['instructions' => 'e.g. ai-citations-b2b-2026.csv']),
            $f('rl_rs_dataset_meta', 'Dataset: size', 'text', ['instructions' => 'e.g. 1,200 rows · 14 columns · 180 KB']),
            $f('rl_rs_licence', 'Licence', 'text', ['instructions' => 'Optional, e.g. Free to use and share with a link to this page. Leave empty to show no licence line.']),
            $f('rl_rs_licence_url', 'Licence URL', 'url', ['instructions' => 'Optional, e.g. the Creative Commons page for the licence. Used in the Dataset markup.']),
            $f('rl_rs_versions', 'Version history', 'textarea', ['rows' => 3, 'instructions' => 'One per line: YYYY-MM-DD | Version | What changed. Start the change with ! to mark a correction. Example: 2026-09-22 | 1.1 | !Figure 2: pricing questions 81%, not 84%.']),
        ],
    ]);
});

/* ---------- data ---------- */
function rl_research_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
function rl_research_num($v) { $v = str_replace([',', ' '], '', (string) $v); return is_numeric($v) ? (float) $v : null; }
function rl_research_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $hl = array_map('trim', explode('|', $m('rl_rs_headline')));
    $finds = [];
    foreach (array_slice(rl_research_rows(get_post_meta($id, 'rl_rs_findings', true), 1), 0, 5) as $r) {
        if (count($r) === 1) $finds[] = ['stat' => '', 'text' => $r[0], 'detail' => '', 'fig' => 0];
        else $finds[] = ['stat' => $r[0], 'text' => $r[1], 'detail' => $r[2] ?? '', 'fig' => (int) ($r[3] ?? 0)];
    }
    $figs = [];
    $n = min(4, (int) get_post_meta($id, 'rl_rs_figures', true));
    for ($i = 0; $i < $n; $i++) {
        $g = function ($k) use ($id, $i) { return trim((string) get_post_meta($id, 'rl_rs_figures_' . $i . '_' . $k, true)); };
        $rows = [];
        foreach (rl_research_rows($g('data'), 2) as $r) { $v = rl_research_num($r[1]); if ($v !== null) $rows[] = [$r[0], $v]; }
        if ($g('title') === '' || !$rows) continue;
        $figs[] = ['title' => $g('title'), 'takeaway' => $g('takeaway'), 'kind' => $g('kind') === 'cols' ? 'cols' : 'bars', 'rows' => $rows, 'suffix' => $g('suffix'), 'unit' => $g('unit'), 'note' => $g('note')];
    }
    $vers = [];
    foreach (rl_research_rows(get_post_meta($id, 'rl_rs_versions', true), 2) as $r) {
        $dt = function_exists('rl_pt_date') ? rl_pt_date($r[0]) : $r[0];
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $dt)) continue;
        $what = $r[2] ?? ''; $fix = strpos($what, '!') === 0;
        $vers[] = ['date' => $dt, 'v' => $r[1], 'what' => ltrim($fix ? substr($what, 1) : $what), 'fix' => $fix];
    }
    usort($vers, function ($a, $b) { return strcmp($b['date'], $a['date']); });
    $cov = $m('rl_rs_coverage');
    return $cache[$id] = [
        'no' => $m('rl_rs_report_no'), 'version' => $vers ? $vers[0]['v'] : '', 'versions' => $vers,
        'sample' => $m('rl_rs_sample'), 'sample_note' => $m('rl_rs_sample_note'), 'period' => $m('rl_rs_period'),
        'coverage' => preg_match('#^\d{4}-\d{2}-\d{2}/\d{4}-\d{2}-\d{2}$#', $cov) ? $cov : '',
        'markets' => $m('rl_rs_markets'), 'method' => $m('rl_rs_method'), 'checked' => $m('rl_rs_checked'),
        'headline' => ($hl[0] !== '' && !empty($hl[1])) ? ['n' => $hl[0], 'text' => $hl[1], 'size' => $hl[2] ?? ''] : null,
        'findings' => $finds, 'found_intro' => $m('rl_rs_found_intro'), 'figures' => $figs,
        'datasource' => $m('rl_rs_datasource'), 'analysis' => $m('rl_rs_analysis'),
        'steps' => array_slice(rl_research_rows(get_post_meta($id, 'rl_rs_steps', true), 1), 0, 4),
        'defs' => rl_research_rows(get_post_meta($id, 'rl_rs_defs', true), 2), 'limits' => rl_post_lines(get_post_meta($id, 'rl_rs_limits', true)),
        'means' => array_slice(rl_research_rows(get_post_meta($id, 'rl_rs_means', true), 2), 0, 3),
        'dataset' => esc_url_raw($m('rl_rs_dataset')), 'dataset_name' => $m('rl_rs_dataset_name'), 'dataset_meta' => $m('rl_rs_dataset_meta'),
        'licence' => $m('rl_rs_licence'), 'licence_url' => esc_url_raw($m('rl_rs_licence_url')),
    ];
}
function rl_research_fmt($v, $suffix) { return number_format($v, floor($v) == $v ? 0 : 1) . $suffix; }
/* Citation in three styles: plain, APA and an HTML link. */
function rl_research_cites($id, $x, $aname) {
    $t = get_the_title($id); $url = get_permalink($id); $y = get_the_date('Y', $id);
    $rep = trim(($x['no'] !== '' ? 'Report ' . $x['no'] : '') . ($x['version'] !== '' ? ($x['no'] !== '' ? ', version ' : 'Version ') . $x['version'] : ''));
    $parts = preg_split('/\s+/', trim($aname)); $last = array_pop($parts);
    $apa_by = $parts ? $last . ', ' . implode(' ', array_map(function ($p) { return mb_substr($p, 0, 1) . '.'; }, $parts)) : $last;
    return [
        'plain' => 'Reinforce Lab (' . $y . '). ' . $t . '.' . ($rep !== '' ? ' ' . $rep . '.' : '') . ' ' . $url,
        'apa' => $apa_by . ' (' . get_the_date('Y, F j', $id) . '). ' . $t . ($rep !== '' ? ' (' . ucfirst($rep) . ')' : '') . '. Reinforce Lab. ' . $url,
        'html' => '<a href="' . esc_url($url) . '">' . $t . '</a>',
    ];
}

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_research_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $x = rl_research_data($id);
    $title = get_the_title($id); $url = get_permalink($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $h1 = preg_match('/^(.+?)\s+(when|for|in|across|from)\s+(.+)$/i', $title, $tm) && mb_strlen($tm[1]) > 12 ? esc_html($tm[1]) . ' <em>' . esc_html($tm[2] . ' ' . $tm[3]) . '</em>' : esc_html($title);
    $svcnames = function_exists('rl_pt_services') ? rl_pt_services() : [];
    $cta = null; $svc = (string) get_post_meta($id, 'rl_rs_cta_service', true); $head = trim((string) get_post_meta($id, 'rl_rs_cta_head', true));
    if ($svc !== '' && $head !== '' && isset($svcnames[$svc])) $cta = ['name' => $svcnames[$svc], 'url' => $u($svc), 'head' => $head, 'sub' => trim((string) get_post_meta($id, 'rl_rs_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_rs_cta_button', true)) ?: 'See how it works'];
    $diag = $u('search-authority-diagnostic');
    $card = array_filter([
        ['Sample', $x['sample'], $x['sample_note']], ['Collected', $x['period'], ''], ['Markets', $x['markets'], ''], ['Method', $x['method'], ''], ['Checked by', $x['checked'], ''],
    ], function ($r) { return $r[1] !== ''; });
    $glance = array_filter([
        ['Sample', trim($x['sample'] . ($x['sample_note'] !== '' ? ', ' . $x['sample_note'] : ''), ', ')], ['Period', $x['period']], ['Sources', $x['datasource']], ['Analysis', $x['analysis']],
    ], function ($r) { return $r[1] !== ''; });
    $cites = rl_research_cites($id, $x, $c['aname']);
    $ln = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.5 9.5l3-3M7 4.5l1.5-1.5a2.5 2.5 0 013.5 3.5L10.5 8M9 11.5L7.5 13A2.5 2.5 0 014 9.5L5.5 8"/></svg>';
    $dl = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M8 2v8M4.5 6.5L8 10l3.5-3.5M3 13h10"/></svg>';
    $ext = $x['dataset'] !== '' ? strtoupper(pathinfo(parse_url($x['dataset'], PHP_URL_PATH) ?: '', PATHINFO_EXTENSION)) : '';
    ?>
<div class="rl-page rl-post rl-rs">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<div class="wrap">
  <div class="r-hero<?php echo $card ? '' : ' solo'; ?>">
    <div>
      <div class="r-kicker"><span class="r-kind">Original Research</span><?php if ($c['cat']) echo '<a class="r-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
      <h1 class="r-h1"><?php echo $h1; ?></h1>
      <?php if ($standfirst !== '') { ?><p class="r-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
      <div class="r-by">
        <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
        <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
        <?php $upd = $d['updated'] !== '' ? $d['updated'] : (($x['versions'] && $x['versions'][0]['date'] > get_the_date('Y-m-d', $id) && $x['versions'][0]['date'] <= current_time('Y-m-d')) ? $x['versions'][0]['date'] : ''); ?>
        <?php if ($upd !== '') { ?><span>Updated <time datetime="<?php echo esc_attr($upd); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($upd))); ?></b></time></span><?php } ?>
      </div>
    </div>
    <?php if ($card) { ?>
    <aside class="r-study" aria-label="Study at a glance">
      <?php if ($x['no'] !== '' || $x['version'] !== '') { ?><div class="sh"><span><?php echo $x['no'] !== '' ? 'Report ' . esc_html($x['no']) : 'This study'; ?></span><?php if ($x['version'] !== '') echo '<span class="ver">Version ' . esc_html($x['version']) . '</span>'; ?></div><?php } ?>
      <dl><?php foreach ($card as $r) echo '<div><dt>' . esc_html($r[0]) . '</dt><dd>' . esc_html($r[1]) . ($r[2] !== '' ? '<small>' . esc_html($r[2]) . '</small>' : '') . '</dd></div>'; ?></dl>
      <div class="acts<?php echo $x['dataset'] !== '' ? '' : ' one'; ?>"><?php if ($x['dataset'] !== '') echo '<a href="#data">' . $dl . 'Get the data</a>'; ?><a class="cite-go" href="#cite">Cite this</a></div>
    </aside>
    <?php } ?>
  </div>

  <?php if ($x['headline']) { ?>
  <section class="r-head" aria-label="Headline finding">
    <span class="big"><?php echo esc_html($x['headline']['n']); ?></span>
    <p><span class="k">Headline finding</span><?php echo esc_html($x['headline']['text']); ?></p>
    <?php if ($x['headline']['size'] !== '') echo '<span class="n">' . esc_html($x['headline']['size']) . '</span>'; ?>
  </section>
  <?php } ?>
</div>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap r-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="r-main">
    <?php if ($d['answer'] !== '') { ?><div class="r-answer"><p class="t">In short</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>

    <?php if ($x['findings']) { ?>
    <div class="sec-h" id="findings"><span>Results</span><h2>Key findings</h2></div>
    <ol class="r-finds">
      <?php foreach ($x['findings'] as $k => $f) { $fid = 'finding-' . ($k + 1); $hasfig = $f['fig'] >= 1 && $f['fig'] <= count($x['figures']); ?>
      <li class="r-fd<?php echo $f['stat'] === '' ? ' nostat' : ''; ?>" id="<?php echo $fid; ?>">
        <?php if ($f['stat'] !== '') { ?><span class="st"><?php echo esc_html($f['stat']); ?><small>Finding <?php echo $k + 1; ?></small></span><?php } ?>
        <div><h3><?php echo esc_html($f['text']); ?></h3><?php if ($f['detail'] !== '' || $hasfig) echo '<p>' . esc_html($f['detail']) . ($hasfig ? ' <a class="fig" href="#figure-' . $f['fig'] . '">See Figure ' . $f['fig'] . '</a>' : '') . '</p>'; ?></div>
        <a class="lnk" href="#<?php echo $fid; ?>" data-copy="#<?php echo $fid; ?>" aria-label="Copy a link to finding <?php echo $k + 1; ?>"><?php echo $ln; ?> Link</a>
      </li>
      <?php } ?>
    </ol>
    <?php } ?>

    <?php if ($x['found_intro'] !== '' || $x['figures'] || trim($c['body']) !== '') { ?>
    <div class="sec-h" id="figures"><span>The data</span><h2>What we found</h2></div>
    <?php if ($x['found_intro'] !== '') echo '<div class="r-prose">' . wpautop(esc_html($x['found_intro'])) . '</div>'; ?>
    <?php foreach ($x['figures'] as $k => $g) { $n = $k + 1;
        $desc = ($g['kind'] === 'cols' ? 'Column chart. ' : 'Bar chart. ') . $g['title'] . ': ' . implode(', ', array_map(function ($r) use ($g) { return $r[0] . ' ' . rl_research_fmt($r[1], $g['suffix']); }, $g['rows'])) . '.'; ?>
    <figure class="r-fig" id="figure-<?php echo $n; ?>">
      <div class="fh2"><span class="no">Figure <?php echo $n; ?></span><b><?php echo esc_html($g['title']); ?></b><?php if ($g['takeaway'] !== '') echo '<p>' . esc_html($g['takeaway']) . '</p>'; ?></div>
      <div class="plot" data-fig="<?php echo esc_attr(wp_json_encode(['k' => $g['kind'], 'd' => $g['rows'], 's' => $g['suffix'], 'u' => $g['unit']])); ?>"><svg role="img" aria-label="<?php echo esc_attr($desc); ?>"></svg><div class="tip" aria-hidden="true"></div></div>
      <figcaption class="ff"><span class="src2"><?php echo esc_html($g['note']); ?></span><span class="tools"><button type="button" class="tt" aria-expanded="false" aria-controls="figure-<?php echo $n; ?>-table">Show as a table</button><?php if ($x['dataset'] !== '') echo '<a href="' . esc_url($x['dataset']) . '" download>Download ' . esc_html($ext ?: 'data') . '</a>'; ?><a href="#figure-<?php echo $n; ?>" data-copy="#figure-<?php echo $n; ?>">Link</a></span></figcaption>
      <table id="figure-<?php echo $n; ?>-table" hidden><thead><tr><th scope="col">Item</th><th scope="col">Value</th></tr></thead><tbody><?php foreach ($g['rows'] as $r) echo '<tr><td>' . esc_html($r[0]) . '</td><td class="n">' . esc_html(rl_research_fmt($r[1], $g['suffix'])) . '</td></tr>'; ?></tbody></table>
    </figure>
    <?php } ?>
    <?php if (trim($c['body']) !== '') echo '<div class="r-prose r-body">' . $c['body'] . '</div>'; ?>
    <?php } ?>

    <?php if ($glance || $x['steps'] || $x['defs'] || $x['limits']) { ?>
    <div class="sec-h" id="method"><span>Method</span><h2>How we ran the study</h2></div>
    <?php if ($glance) { ?><dl class="r-glance n<?php echo count($glance); ?>" aria-label="Study at a glance"><?php foreach ($glance as $r) echo '<div><dt>' . esc_html($r[0]) . '</dt><dd>' . esc_html($r[1]) . '</dd></div>'; ?></dl><?php } ?>
    <?php if ($x['steps']) { ?><ol class="r-steps n<?php echo count($x['steps']); ?>"><?php foreach ($x['steps'] as $k => $s) echo '<li><span class="n" aria-hidden="true">' . ($k + 1) . '</span><h3>' . esc_html($s[0]) . '</h3>' . (!empty($s[1]) ? '<p>' . esc_html($s[1]) . '</p>' : '') . '</li>'; ?></ol><?php } ?>
    <?php if ($x['defs'] || $x['limits']) { ?>
    <div class="r-two<?php echo ($x['defs'] && $x['limits']) ? '' : ' one'; ?>">
      <?php if ($x['defs']) { ?><div class="r-defs"><span class="k">Definitions</span><dl><?php foreach ($x['defs'] as $df) echo '<dt>' . esc_html($df[0]) . '</dt><dd>' . esc_html($df[1]) . '</dd>'; ?></dl></div><?php } ?>
      <?php if ($x['limits']) { ?><div class="r-lims"><span class="k">Limits of this study</span><ul><?php foreach ($x['limits'] as $l) echo '<li>' . esc_html($l) . '</li>'; ?></ul></div><?php } ?>
    </div>
    <?php } ?>
    <?php } ?>

    <?php if ($x['means']) { ?>
    <div class="sec-h"><span>Use it</span><h2>What this means for you</h2></div>
    <div class="r-means n<?php echo count($x['means']); ?>"><?php foreach ($x['means'] as $mn) echo '<div class="mn"><span class="k">' . esc_html($mn[0]) . '</span><h3>' . esc_html($mn[1]) . '</h3>' . (!empty($mn[2]) ? '<p>' . esc_html($mn[2]) . '</p>' : '') . '</div>'; ?></div>
    <?php } ?>

    <?php if ($cta) { ?>
    <aside class="r-icta" aria-label="Reinforce Lab service">
      <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
      <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
    </aside>
    <?php } ?>

    <div class="sec-h" id="data"><span><?php echo $x['dataset'] !== '' ? 'Open data' : 'Use this research'; ?></span><h2><?php echo $x['dataset'] !== '' ? 'Data and citation' : 'Cite this research'; ?></h2></div>
    <div class="r-data<?php echo $x['dataset'] !== '' ? '' : ' one'; ?>">
      <?php if ($x['dataset'] !== '') { ?>
      <div>
        <span class="k">Dataset</span>
        <a class="dl-file" href="<?php echo esc_url($x['dataset']); ?>" download><span class="ext"><?php echo esc_html($ext ?: 'FILE'); ?></span><span><b><?php echo esc_html($x['dataset_name'] !== '' ? $x['dataset_name'] : basename((string) parse_url($x['dataset'], PHP_URL_PATH))); ?></b><?php if ($x['dataset_meta'] !== '') echo '<span>' . esc_html($x['dataset_meta']) . '</span>'; ?></span></a>
        <?php if ($x['licence'] !== '') echo '<p class="lic">' . ($x['licence_url'] !== '' ? '<a href="' . esc_url($x['licence_url']) . '" rel="noopener license" target="_blank">' . esc_html($x['licence']) . '</a>' : esc_html($x['licence'])) . '</p>'; ?>
      </div>
      <?php } ?>
      <div id="cite">
        <span class="k">Cite this research</span>
        <div class="cite-tabs" role="group" aria-label="Citation style"><button type="button" aria-pressed="true" data-style="plain">Plain</button><button type="button" aria-pressed="false" data-style="apa">APA</button><button type="button" aria-pressed="false" data-style="html">Link</button></div>
        <pre class="cite-box" data-cites="<?php echo esc_attr(wp_json_encode($cites)); ?>"><?php echo esc_html($cites['plain']); ?></pre>
        <button class="copy" type="button" data-copy-cite>Copy citation</button>
      </div>
    </div>

    <?php if ($x['versions']) { ?>
    <div class="sec-h"><span>Record</span><h2>Version history</h2></div>
    <div class="tscroll"><table class="r-ver"><thead><tr><th scope="col">Version</th><th scope="col">Date</th><th scope="col">What changed</th></tr></thead><tbody>
      <?php foreach ($x['versions'] as $v) echo '<tr><td>' . esc_html($v['v']) . '</td><td><time datetime="' . esc_attr($v['date']) . '">' . esc_html(date_i18n('j M Y', strtotime($v['date']))) . '</time></td><td>' . ($v['fix'] ? '<span class="cx">Correction</span>' : '') . esc_html($v['what']) . '</td></tr>'; ?>
    </tbody></table></div>
    <?php } ?>
  </div>

  <?php
    $rq = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true, 'meta_key' => 'rl_type', 'meta_value' => 'research']);
    if ($rq->have_posts()) { ?>
  <section class="r-rel" aria-labelledby="rel-rs-h">
    <div class="sec-h"><span>More research</span><h2 id="rel-rs-h">Related studies</h2></div>
    <div class="r-more">
    <?php while ($rq->have_posts()) { $rq->the_post(); $rx = rl_research_data(get_the_ID()); $rc = get_the_category(); $line = implode(' · ', array_filter([$rx['no'] !== '' ? 'Report ' . $rx['no'] : '', $rx['sample']])); ?>
      <a class="rr" href="<?php the_permalink(); ?>"><?php if ($rc) echo '<span class="k">' . esc_html($rc[0]->name) . '</span>'; ?><b><?php the_title(); ?></b><?php if ($line !== '') echo '<span class="r">' . esc_html($line) . '</span>'; ?></a>
    <?php } wp_reset_postdata(); ?>
    </div>
  </section>
  <?php } else echo rl_post_rel_section($id); ?>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <div class="r-back">
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
  </div>
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
<div class="r-toast" role="status" aria-live="polite"></div>
</div>
<script>
(function(){
  var root=document.querySelector('.rl-rs'); if(!root) return;
  var NS='http://www.w3.org/2000/svg', MONO='IBM Plex Mono, monospace', SANS='IBM Plex Sans, sans-serif';
  var cs=getComputedStyle(document.documentElement), col=function(v,f){ var x=cs.getPropertyValue(v).trim(); return x||f; };
  var RED=col('--red-3','#e85050'), FAINT=col('--ink-faint','#7f7778'), DIM=col('--ink-dim','#b8b0b1'), INK=col('--ink','#f2eeee');
  function el(n,a){ var e=document.createElementNS(NS,n); for(var k in a) e.setAttribute(k,a[k]); return e; }
  function txt(a,s){ var t=el('text',a); t.textContent=s; return t; }
  function fmt(v,s){ return Number(v).toLocaleString('en-GB',{maximumFractionDigits:1})+(s||''); }
  function nice(m){ var p=Math.pow(10,Math.floor(Math.log10(m||1))), st=[1,2,2.5,5,10]; for(var i=0;i<st.length;i++){ if(st[i]*p*4>=m) return st[i]*p; } return 10*p; }
  root.querySelectorAll('.plot[data-fig]').forEach(function(box){
    var cfg=JSON.parse(box.getAttribute('data-fig')), rows=cfg.d, sfx=cfg.s||'', svg=box.querySelector('svg'), tip=box.querySelector('.tip');
    var maxV=Math.max.apply(null,rows.map(function(r){return r[1];})), pct=sfx==='%'&&maxV<=100, step=pct?25:nice(maxV), top=pct?100:step*Math.ceil(maxV*1.05/step), ticks=[];
    for(var v=0; v<=top+0.001; v+=step) ticks.push(v);
    function tipAt(x,y,r){ tip.innerHTML=''; var b=document.createElement('b'); b.textContent=r[0]; tip.appendChild(b); tip.appendChild(document.createTextNode(fmt(r[1],sfx)+(cfg.u?' '+cfg.u:''))); tip.style.left=Math.min(Math.max(x,80),box.clientWidth-80)+'px'; tip.style.top=y+'px'; tip.style.opacity=1; }
    function draw(){
      var W=box.clientWidth; while(svg.firstChild) svg.removeChild(svg.firstChild);
      if(cfg.k==='cols'){
        var H=W<560?220:250, L=44, B=26, T=22; svg.setAttribute('viewBox','0 0 '+W+' '+H); svg.style.height=H+'px';
        var y=function(v){return T+(1-v/top)*(H-T-B);}, n=rows.length, slot=(W-L)/n, bw=Math.min(64,slot*.56);
        ticks.forEach(function(v){ svg.appendChild(el('line',{x1:L,x2:W,y1:y(v),y2:y(v),stroke:'rgba(255,255,255,.07)'})); svg.appendChild(txt({x:L-8,y:y(v)+4,'text-anchor':'end',fill:FAINT,'font-size':10.5,'font-family':MONO},fmt(v,sfx))); });
        rows.forEach(function(r,i){
          var cx=L+slot*i+slot/2, b=el('rect',{x:cx-bw/2,y:y(r[1]),width:bw,height:Math.max(0,y(0)-y(r[1])),fill:RED,opacity:.9}); svg.appendChild(b);
          svg.appendChild(txt({x:cx,y:y(r[1])-6,'text-anchor':'middle',fill:INK,'font-size':11.5,'font-family':MONO},fmt(r[1],sfx)));
          svg.appendChild(txt({x:cx,y:H-6,'text-anchor':'middle',fill:DIM,'font-size':W<560?10.5:12,'font-family':SANS},r[0]));
          var hit=el('rect',{x:L+slot*i,y:0,width:slot,height:H,fill:'transparent'}); svg.appendChild(hit);
          hit.addEventListener('pointerenter',function(){ b.setAttribute('opacity',1); b.setAttribute('stroke',INK); tipAt(cx,y(r[1])+4,r); });
          hit.addEventListener('pointerleave',function(){ b.setAttribute('opacity',.9); b.removeAttribute('stroke'); tip.style.opacity=0; });
        });
      } else {
        var narrow=W<560, lw=narrow?12:Math.min(260,Math.round(W*.3)), rowH=narrow?46:34, H2=rows.length*rowH+24; svg.setAttribute('viewBox','0 0 '+W+' '+H2); svg.style.height=H2+'px';
        var x=function(v){return lw+v/top*(W-lw-52);};
        ticks.forEach(function(v){ svg.appendChild(el('line',{x1:x(v),x2:x(v),y1:0,y2:H2-20,stroke:'rgba(255,255,255,.07)'})); svg.appendChild(txt({x:x(v),y:H2-4,'text-anchor':'middle',fill:FAINT,'font-size':10.5,'font-family':MONO},fmt(v,sfx))); });
        rows.forEach(function(r,i){
          var y0=i*rowH, by=narrow?y0+20:y0+8, bh=narrow?16:18;
          svg.appendChild(txt({x:narrow?0:lw-12,y:narrow?y0+14:by+13,'text-anchor':narrow?'start':'end',fill:DIM,'font-size':12.5,'font-family':SANS},r[0]));
          var b=el('rect',{x:x(0),y:by,width:Math.max(0,x(r[1])-x(0)),height:bh,fill:RED,opacity:.9}); svg.appendChild(b);
          svg.appendChild(txt({x:x(r[1])+6,y:by+bh-4,fill:INK,'font-size':11.5,'font-family':MONO},fmt(r[1],sfx)));
          var hit=el('rect',{x:0,y:y0,width:W,height:rowH,fill:'transparent'}); svg.appendChild(hit);
          hit.addEventListener('pointerenter',function(){ b.setAttribute('opacity',1); b.setAttribute('stroke',INK); tipAt(x(r[1])+120,by+bh+18,r); });
          hit.addEventListener('pointerleave',function(){ b.setAttribute('opacity',.9); b.removeAttribute('stroke'); tip.style.opacity=0; });
        });
      }
    }
    draw(); var tm; addEventListener('resize',function(){ clearTimeout(tm); tm=setTimeout(draw,120); });
  });
  root.querySelectorAll('.tt').forEach(function(b){ b.addEventListener('click',function(){ var t=document.getElementById(b.getAttribute('aria-controls')), o=t.hidden; t.hidden=!o; b.setAttribute('aria-expanded',o?'true':'false'); b.textContent=o?'Hide the table':'Show as a table'; }); });
  var toast=root.querySelector('.r-toast'), tt;
  function say(s){ toast.textContent=s; toast.classList.add('on'); clearTimeout(tt); tt=setTimeout(function(){ toast.classList.remove('on'); },1600); }
  function copy(s,msg){ if(navigator.clipboard&&navigator.clipboard.writeText){ navigator.clipboard.writeText(s).then(function(){ say(msg); },function(){}); } }
  root.querySelectorAll('[data-copy]').forEach(function(a){ a.addEventListener('click',function(){ var h=a.getAttribute('data-copy'); copy(location.href.split('#')[0]+h,'Link copied'); }); });
  var box=root.querySelector('.cite-box');
  if(box){ var cites=JSON.parse(box.getAttribute('data-cites')), style='plain';
    root.querySelectorAll('.cite-tabs button').forEach(function(b){ b.addEventListener('click',function(){ style=b.getAttribute('data-style'); box.textContent=cites[style]; root.querySelectorAll('.cite-tabs button').forEach(function(o){ o.setAttribute('aria-pressed',o===b?'true':'false'); }); }); });
    root.querySelector('[data-copy-cite]').addEventListener('click',function(){ copy(cites[style],'Citation copied'); }); }
})();
</script>
<?php
}

/* ---------- schema: Report, a fuller Dataset, dateModified from the version history ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_research_view()) return $graph;
    $id = get_queried_object_id(); $x = rl_research_data($id); $d = rl_post_data($id); $url = get_permalink($id);
    $latest = '';
    foreach ($x['versions'] as $v) if ($v['date'] <= current_time('Y-m-d')) { $latest = $v['date']; break; }
    if ($latest !== '' && $latest <= get_the_date('Y-m-d', $id)) $latest = '';
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if (in_array('Article', $t, true)) {
            $n['@type'] = ['Article', 'BlogPosting', 'Report'];
            if ($x['no'] !== '') $n['reportNumber'] = $x['no'];
            if ($x['version'] !== '') $n['version'] = $x['version'];
            if ($x['dataset'] !== '') $n['hasPart'] = ['@id' => $url . '#dataset'];
        }
        if ($latest !== '' && (in_array('Article', $t, true) || in_array('WebPage', $t, true)) && (empty($n['dateModified']) || substr($n['dateModified'], 0, 10) < $latest)) $n['dateModified'] = $latest . 'T00:00:00+00:00';
    }
    unset($n);
    if ($x['dataset'] !== '') {
        $ext = strtolower(pathinfo((string) parse_url($x['dataset'], PHP_URL_PATH), PATHINFO_EXTENSION));
        $fmt = ['csv' => 'text/csv', 'json' => 'application/json', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'zip' => 'application/zip'];
        $ds = ['@type' => 'Dataset', '@id' => $url . '#dataset', 'name' => get_the_title($id), 'description' => mb_strlen($x['method']) >= 50 ? $x['method'] : trim($x['method'] . ' ' . ($d['answer'] !== '' ? $d['answer'] : get_the_title($id))), // search engines want 50 or more characters
            'url' => $url, 'creator' => ['@id' => home_url('/#organization')], 'isAccessibleForFree' => true, 'datePublished' => get_the_date('Y-m-d', $id),
            'distribution' => [array_filter(['@type' => 'DataDownload', 'contentUrl' => $x['dataset'], 'encodingFormat' => $fmt[$ext] ?? null])]];
        if ($x['coverage'] !== '') $ds['temporalCoverage'] = $x['coverage'];
        if ($x['licence_url'] !== '') $ds['license'] = $x['licence_url'];
        if ($x['version'] !== '') $ds['version'] = $x['version'];
        if ($latest !== '') $ds['dateModified'] = $latest;
        if ($x['figures']) $ds['variableMeasured'] = array_values(array_map(function ($g) { return $g['title']; }, $x['figures']));
        $graph[] = $ds;
    }
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_research_view()) return; ?>
<style id="rl-research-css">
.rl-rs{color:var(--ink-dim);--amber:#d39b3a}
.rl-rs h1,.rl-rs h2,.rl-rs h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-rs .ic{width:14px;height:14px;flex:none;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:square}
.rl-rs .r-hero{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,.9fr);gap:clamp(28px,5vw,60px);align-items:start;padding-block:clamp(24px,4vw,40px) 0}
.rl-rs .r-hero.solo{grid-template-columns:minmax(0,1fr)}
.rl-rs .r-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px}
.rl-rs .r-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-rs .r-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-rs .r-h1{font-size:clamp(34px,4.6vw,60px);line-height:1;margin:0}
.rl-rs .r-h1 em{font-style:normal;color:var(--red-3)}
.rl-rs .r-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;margin:18px 0 0;max-width:640px}
.rl-rs .r-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-rs .r-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-rs .r-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-rs .r-by b{color:var(--ink-dim);font-weight:500}
.rl-rs .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-rs .r-study{border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2))}
.rl-rs .r-study .sh{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:14px 18px;border-bottom:1px solid var(--line-2);background:repeating-linear-gradient(135deg,transparent 0 10px,rgba(255,255,255,.018) 10px 20px)}
.rl-rs .r-study .sh span{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-rs .r-study .sh .ver{color:var(--ink);border:1px solid var(--line-2);padding:2px 8px;background:var(--bg-2);white-space:nowrap}
.rl-rs .r-study dl{margin:0;padding:4px 18px 8px}
.rl-rs .r-study dl div{display:grid;grid-template-columns:104px minmax(0,1fr);gap:12px;padding:9px 0;border-top:1px solid var(--line);font-size:14px}
.rl-rs .r-study dl div:first-child{border-top:0}
.rl-rs .r-study dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);padding-top:3px}
.rl-rs .r-study dd{margin:0;color:var(--ink)}
.rl-rs .r-study dd small{display:block;color:var(--ink-faint);font-size:12.5px}
.rl-rs .r-study .acts{display:grid;grid-template-columns:1fr 1fr;border-top:1px solid var(--line-2)}
.rl-rs .r-study .acts.one{grid-template-columns:1fr}
.rl-rs .r-study .acts a{display:flex;align-items:center;justify-content:center;gap:8px;padding:13px 10px;font-family:var(--f-display);font-size:13px;letter-spacing:.07em;text-transform:uppercase;text-decoration:none;color:#fff;background:var(--red);transition:background .15s}
.rl-rs .r-study .acts a:hover{background:var(--red-2)}
.rl-rs .r-study .acts a.cite-go{background:transparent;color:var(--ink)}
.rl-rs .r-study .acts a+a.cite-go{border-left:1px solid var(--line-2)}
.rl-rs .r-study .acts a.cite-go:hover{background:var(--panel-2,var(--panel))}
.rl-rs .r-head{margin-top:clamp(30px,4vw,44px);display:grid;grid-template-columns:auto minmax(0,1fr) auto;gap:10px 30px;align-items:center;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);padding:22px 0}
.rl-rs .r-head .big{font-family:var(--f-display);font-weight:600;font-size:clamp(64px,8vw,104px);line-height:.85;color:var(--red-3)}
.rl-rs .r-head p{margin:0;color:var(--ink);font-size:clamp(18px,1.8vw,22px);line-height:1.45;max-width:640px}
.rl-rs .r-head .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);display:block;margin-bottom:6px}
.rl-rs .r-head .n{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);text-align:right}
.rl-rs .r-feat{margin:28px auto 0}
.rl-rs .r-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-rs .r-main{max-width:900px;margin:0 auto;padding-block:clamp(34px,5vw,52px) 10px}
.rl-rs .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px;scroll-margin-top:96px}
.rl-rs .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3)}
.rl-rs .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-rs .r-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-rs .r-answer .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-rs .r-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-rs .r-prose>*{margin:0 0 1.1em}
.rl-rs .r-prose p,.rl-rs .r-prose li{font-size:17.5px;line-height:1.75}
.rl-rs .r-prose h2{font-size:clamp(22px,2.4vw,26px);margin:1.6em 0 .5em}
.rl-rs .r-prose h3{font-size:20px;margin:1.4em 0 .5em}
.rl-rs .r-prose strong{color:var(--ink);font-weight:600}
.rl-rs .r-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-rs .r-prose ul,.rl-rs .r-prose ol{padding-left:1.2em}
.rl-rs .r-prose li::marker{color:var(--red-3)}
.rl-rs .r-body{margin-top:28px}
.rl-rs .r-finds{list-style:none;margin:0;padding:0;border:1px solid var(--line-2)}
.rl-rs .r-fd{display:grid;grid-template-columns:150px minmax(0,1fr) auto;gap:6px 22px;align-items:start;padding:18px 20px;margin:0;border-top:1px solid var(--line);scroll-margin-top:96px}
.rl-rs .r-fd.nostat{grid-template-columns:minmax(0,1fr) auto}
.rl-rs .r-fd:first-child{border-top:0}
.rl-rs .r-fd:target{background:linear-gradient(90deg,rgba(153,0,0,.16),transparent 70%)}
.rl-rs .r-fd .st{font-family:var(--f-display);font-size:38px;line-height:1;color:var(--ink);font-weight:500;overflow-wrap:anywhere}
.rl-rs .r-fd .st small{display:block;font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);margin-top:6px;font-weight:400}
.rl-rs .r-fd h3{font-family:var(--f-body);text-transform:none;letter-spacing:0;font-size:18px;font-weight:600;line-height:1.4;margin:0 0 4px;text-wrap:pretty}
.rl-rs .r-fd p{margin:0;font-size:15px}
.rl-rs .r-fd .fig{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);white-space:nowrap}
.rl-rs .r-fd .lnk{display:inline-flex;align-items:center;gap:5px;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint);text-decoration:none;border:1px solid var(--line-2);padding:5px 8px;white-space:nowrap}
.rl-rs .r-fd .lnk .ic{width:11px;height:11px}
.rl-rs .r-fd .lnk:hover{color:var(--ink);border-color:var(--red-line)}
.rl-rs .r-fig{margin:30px 0 0;border:1px solid var(--line-2);background:var(--bg-2);scroll-margin-top:96px;padding:0}
.rl-rs .r-fig .fh2{display:grid;grid-template-columns:auto minmax(0,1fr);gap:4px 14px;padding:16px 18px 0}
.rl-rs .r-fig .no{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#fff;background:var(--red);padding:3px 8px;align-self:start;white-space:nowrap}
.rl-rs .r-fig .fh2 b{font-family:var(--f-display);font-size:19px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1.2}
.rl-rs .r-fig .fh2 p{grid-column:2;margin:0;font-size:14.5px;color:var(--ink-dim)}
.rl-rs .r-fig .plot{position:relative;margin:10px 18px 0}
.rl-rs .r-fig svg{display:block;width:100%;height:220px}
.rl-rs .r-fig .tip{position:absolute;pointer-events:none;background:var(--panel-2,var(--panel));border:1px solid var(--line-2);padding:6px 10px;font-family:var(--f-mono);font-size:12px;color:var(--ink);white-space:nowrap;transform:translate(-50%,-115%);opacity:0;transition:opacity .12s}
.rl-rs .r-fig .tip b{display:block;font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint);font-weight:500}
.rl-rs .r-fig .ff{display:flex;flex-wrap:wrap;justify-content:space-between;gap:8px 18px;align-items:center;padding:10px 18px 14px;border-top:1px solid var(--line);margin:6px 0 0;text-align:left}
.rl-rs .r-fig .src2{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint)}
.rl-rs .r-fig .tools{display:flex;flex-wrap:wrap;gap:8px}
.rl-rs .r-fig .tools a,.rl-rs .r-fig .tools button{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-dim);text-decoration:none;background:none;border:1px solid var(--line-2);padding:4px 8px;cursor:pointer;line-height:1.4;border-radius:0}
.rl-rs .r-fig .tools a:hover,.rl-rs .r-fig .tools button:hover,.rl-rs .r-fig .tools button[aria-expanded="true"]{color:var(--ink);border-color:var(--red-line)}
.rl-rs .r-fig table{border-collapse:collapse;margin:0 18px 16px;width:calc(100% - 36px);max-width:520px;min-width:0}
.rl-rs .r-fig th,.rl-rs .r-fig td{border:0;border-bottom:1px solid var(--line);padding:5px 8px;text-align:left;color:var(--ink-dim);background:none;font-family:var(--f-mono);font-size:12.5px;font-weight:400;letter-spacing:0;text-transform:none}
.rl-rs .r-fig td.n{text-align:right;color:var(--ink);font-variant-numeric:tabular-nums}
.rl-rs .r-glance{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2);margin:0}
.rl-rs .r-glance.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-rs .r-glance.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-rs .r-glance.n1{grid-template-columns:minmax(0,1fr)}
.rl-rs .r-glance div{background:var(--bg-2);padding:14px 16px}
.rl-rs .r-glance dt{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-rs .r-glance dd{margin:6px 0 0;color:var(--ink);font-size:14.5px;line-height:1.5}
.rl-rs .r-steps{list-style:none;margin:20px 0 0;padding:0;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-rs .r-steps.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-rs .r-steps.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-rs .r-steps.n1{grid-template-columns:minmax(0,1fr)}
.rl-rs .r-steps li{background:var(--bg);padding:16px 16px 18px;margin:0;display:grid;gap:6px;align-content:start}
.rl-rs .r-steps .n{font-family:var(--f-display);font-size:30px;line-height:1;color:transparent;-webkit-text-stroke:1.2px var(--red-3);font-weight:700}
.rl-rs .r-steps h3{font-family:var(--f-body);text-transform:none;letter-spacing:0;font-size:16px;font-weight:600;margin:0;line-height:1.35}
.rl-rs .r-steps p{margin:0;font-size:14px}
.rl-rs .r-two{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:16px;margin-top:16px}
.rl-rs .r-two.one{grid-template-columns:minmax(0,1fr)}
.rl-rs .r-defs,.rl-rs .r-lims{border:1px solid var(--line-2);padding:16px 18px}
.rl-rs .r-defs .k,.rl-rs .r-lims .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;display:block;margin-bottom:8px}
.rl-rs .r-defs .k{color:var(--ink-faint)}
.rl-rs .r-lims .k{color:var(--amber)}
.rl-rs .r-lims{border-color:rgba(211,155,58,.35);background:linear-gradient(180deg,rgba(211,155,58,.05),transparent)}
.rl-rs .r-defs dl{margin:0}
.rl-rs .r-defs dt{color:var(--ink);font-weight:600;font-size:14.5px;margin-top:10px}
.rl-rs .r-defs dt:first-child{margin-top:0}
.rl-rs .r-defs dd{margin:2px 0 0;font-size:14px}
.rl-rs .r-lims ul{margin:0;padding:0;list-style:none;display:grid;gap:8px}
.rl-rs .r-lims li{display:grid;grid-template-columns:14px 1fr;gap:8px;font-size:14px;color:var(--ink-dim);margin:0}
.rl-rs .r-lims li::before{content:"";width:8px;height:8px;border:1.5px solid var(--amber);margin-top:6px}
.rl-rs .r-means{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-rs .r-means.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-rs .r-means.n1{grid-template-columns:minmax(0,1fr)}
.rl-rs .mn{background:var(--bg);padding:18px 20px;display:grid;gap:6px;align-content:start}
.rl-rs .mn .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-rs .mn h3{font-size:17px;margin:0}
.rl-rs .mn p{margin:0;font-size:14.5px}
.rl-rs .r-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-rs .r-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-rs .r-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-rs .r-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-rs .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-rs .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-rs .go2:hover{background:var(--red-2)}
.rl-rs .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-rs .r-data{display:grid;grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);border:1px solid var(--line-2);background:var(--panel)}
.rl-rs .r-data.one{grid-template-columns:minmax(0,1fr)}
.rl-rs .r-data>div{padding:20px 22px;min-width:0;scroll-margin-top:96px}
.rl-rs .r-data>div+div{border-left:1px solid var(--line-2)}
.rl-rs .r-data .k{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);display:block;margin-bottom:10px}
.rl-rs .dl-file{display:grid;grid-template-columns:44px minmax(0,1fr);gap:12px;align-items:center;text-decoration:none;border:1px solid var(--line-2);background:var(--bg-2);padding:12px 14px;transition:border-color .2s}
.rl-rs .dl-file:hover{border-color:var(--red-line)}
.rl-rs .dl-file .ext{width:44px;height:52px;border:1px solid var(--red-line);display:grid;place-items:end center;padding-bottom:6px;font-family:var(--f-mono);font-size:10.5px;color:var(--red-3);position:relative}
.rl-rs .dl-file .ext::before{content:"";position:absolute;top:-1px;right:-1px;width:12px;height:12px;background:var(--panel);border-left:1px solid var(--red-line);border-bottom:1px solid var(--red-line)}
.rl-rs .dl-file b{display:block;color:var(--ink);font-weight:600;font-size:15px;overflow-wrap:anywhere}
.rl-rs .dl-file span span{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint)}
.rl-rs .lic{margin:12px 0 0;font-size:13.5px}
.rl-rs .lic a{color:var(--ink-dim);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-rs .cite-tabs{display:flex;border:1px solid var(--line-2);width:max-content;max-width:100%;margin-bottom:10px}
.rl-rs .cite-tabs button{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;background:none;border:0;color:var(--ink-faint);padding:5px 10px;cursor:pointer;border-radius:0}
.rl-rs .cite-tabs button+button{border-left:1px solid var(--line-2)}
.rl-rs .cite-tabs button[aria-pressed="true"]{background:var(--red);color:#fff}
.rl-rs .cite-box{font-family:var(--f-mono);font-size:12.5px;line-height:1.65;color:var(--ink);background:var(--bg-2);border:1px solid var(--line);padding:12px 14px;margin:0;white-space:pre-wrap;word-break:break-word;border-radius:0;max-width:100%}
.rl-rs .copy{margin-top:10px;font-family:var(--f-display);font-size:13px;letter-spacing:.07em;text-transform:uppercase;color:var(--ink);background:none;border:1px solid var(--line-2);padding:8px 14px;cursor:pointer;border-radius:0}
.rl-rs .copy:hover{border-color:var(--red-line)}
.rl-rs .r-ver{width:100%;border-collapse:collapse;border:1px solid var(--line-2);min-width:0}
.rl-rs .r-ver th,.rl-rs .r-ver td{text-align:left;padding:10px 14px;border:0;border-top:1px solid var(--line);vertical-align:top;background:none;color:var(--ink-dim);font-weight:400;font-size:14px;letter-spacing:0;text-transform:none;font-family:var(--f-body)}
.rl-rs .r-ver thead th{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);border-top:0;background:var(--bg-2)}
.rl-rs .r-ver td:first-child{font-family:var(--f-mono);color:var(--ink);white-space:nowrap}
.rl-rs .r-ver td:nth-child(2){font-family:var(--f-mono);white-space:nowrap}
.rl-rs .r-ver .cx{font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--amber);border:1px solid rgba(211,155,58,.5);padding:1px 6px;margin-right:6px}
.rl-rs .r-rel{margin-top:46px;padding:0}
.rl-rs .r-rel .sec-h{margin-top:0}
.rl-rs .r-more{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-rs .rr{background:var(--bg);padding:18px 20px;text-decoration:none;display:grid;gap:8px;align-content:start;transition:background .2s}
.rl-rs .rr:hover{background:var(--panel)}
.rl-rs .rr .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-rs .rr b{font-family:var(--f-display);font-size:19px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1.15}
.rl-rs .rr .r{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint)}
.rl-rs .r-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-rs .r-back .sec-h{margin-top:0}
.rl-rs .r-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-rs .r-src li{padding:6px 0;color:var(--ink-faint)}
.rl-rs .r-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-rs .r-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-rs .r-author .av{width:72px;height:72px;font-size:28px}
.rl-rs .r-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-rs .r-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-rs .r-author p{margin:0 0 8px;font-size:15px}
.rl-rs .r-author .links{display:flex;gap:18px;font-size:14px}
.rl-rs .r-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-rs .r-toast{position:fixed;left:50%;bottom:24px;transform:translateX(-50%);background:var(--panel-2,var(--panel));border:1px solid var(--line-2);color:var(--ink);font-family:var(--f-mono);font-size:12px;padding:8px 14px;opacity:0;transition:opacity .2s;pointer-events:none;z-index:50}
.rl-rs .r-toast.on{opacity:1}
@media(max-width:1000px){
  .rl-rs .r-hero{grid-template-columns:minmax(0,1fr)}
  .rl-rs .r-glance,.rl-rs .r-steps,.rl-rs .r-steps.n3{grid-template-columns:repeat(2,minmax(0,1fr))}
  .rl-rs .r-more{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media(max-width:760px){
  .rl-rs .r-head{grid-template-columns:minmax(0,1fr);gap:8px}
  .rl-rs .r-head .n{text-align:left}
  .rl-rs .r-fd,.rl-rs .r-fd.nostat{grid-template-columns:minmax(0,1fr);gap:6px}
  .rl-rs .r-fd .lnk{justify-self:start}
  .rl-rs .r-glance,.rl-rs .r-glance.n2,.rl-rs .r-glance.n3,.rl-rs .r-steps,.rl-rs .r-steps.n2,.rl-rs .r-steps.n3,.rl-rs .r-two,.rl-rs .r-means,.rl-rs .r-means.n2,.rl-rs .r-more,.rl-rs .r-back{grid-template-columns:minmax(0,1fr)}
  .rl-rs .r-data{grid-template-columns:minmax(0,1fr)}
  .rl-rs .r-data>div+div{border-left:0;border-top:1px solid var(--line-2)}
  .rl-rs .r-ver td:nth-child(2){white-space:normal}
  .rl-rs .r-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-rs .cact{padding-right:16px}
  .rl-rs .r-author{grid-template-columns:1fr}
  .rl-rs .r-prose p,.rl-rs .r-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-rs .go2,.rl-rs .rr,.rl-rs .dl-file,.rl-rs .r-study .acts a{transition:none}.rl-rs .r-fig .tip,.rl-rs .r-toast{transition:none}}
</style>
<?php }, 24);
