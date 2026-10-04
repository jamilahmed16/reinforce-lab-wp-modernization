<?php
/**
 * Plugin Name: Reinforce Lab - Post type sections
 * Description: The sections each article type adds to the single post template (D-074, D-076). Fields are an ACF local group whose fields show only for their type. Renders through rl_post_type_sections_before/after (reinforce-post.php) and extends the post schema. Opinion and Checklist use the base only for now. Guide, How-To, Best / List and Review have their own design files (reinforce-post-guide.php, -howto.php, -list.php, -review.php).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* ---------- choices ---------- */
function rl_pt_services() {
    return [
        'services/best-search-engine-optimization-services' => 'Search Engine Optimization', 'services/ai-search-optimization' => 'AI Search Optimization',
        'services/generative-engine-optimization' => 'Generative Engine Optimization', 'services/llm-optimization' => 'LLM Optimization',
        'services/technical-seo-services' => 'Technical SEO', 'services/international-seo' => 'International SEO', 'services/local-seo' => 'Local SEO',
        'services/enterprise-seo-strategy' => 'Enterprise SEO Strategy', 'services/seo-content-systems' => 'SEO Content Systems',
        'services/press-release-services' => 'Digital PR & Link Building', 'services/seo-ai-search-audit' => 'SEO & AI Search Audit',
        'services/marketing-automation' => 'Marketing Automation', 'services/lead-generation-systems' => 'Lead Generation Systems',
        'services/ai-workflow-automation' => 'AI Workflow Automation', 'services/executive-ai-consulting' => 'Executive AI Consulting',
        'services/wordpress-website-design-service' => 'WordPress Website Design', 'services/ecommerce-website-design-service' => 'E-commerce Website Design',
        'services/website-maintenance-services' => 'Website Maintenance', 'search-authority-os' => 'Search Authority OS',
        'search-authority-diagnostic' => 'Search Authority Diagnostic', 'services/agents' => 'Agents (all)',
        'services/agents/seo-intelligence' => 'SEO Intelligence Agent', 'services/agents/content-research' => 'Content Research Agent',
        'services/agents/evidence-verification' => 'Evidence Verification Agent', 'services/agents/aeo-geo-optimization' => 'AEO / GEO Optimization Agent',
        'services/agents/social-sentiment' => 'Social Sentiment Agent', 'services/agents/competitor-intelligence' => 'Competitor Intelligence Agent',
        'services/agents/content-qa' => 'Content QA Auditor', 'services/agents/search-performance' => 'Search Performance Agent',
    ];
}
function rl_pt_industries() {
    $o = [];
    if (function_exists('rl_ind_data')) foreach (rl_ind_data() as $k => $d) $o[$k] = $d['name'];
    return $o;
}
function rl_pt_subtypes() { return ['deepdive' => 'How it works', 'usecase' => 'Use case / playbook', 'launch' => 'Launch / changelog']; }

/* ---------- fields ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = function ($type) { return [[['field' => 'field_rl_type', 'operator' => '==', 'value' => $type]]]; };
    $ta = function ($key, $label, $type, $help = '', $rows = 5) use ($show) { return ['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => 'textarea', 'rows' => $rows, 'instructions' => $help, 'conditional_logic' => $show($type)]; };
    $tx = function ($key, $label, $type, $help = '') use ($show) { return ['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => 'text', 'instructions' => $help, 'conditional_logic' => $show($type)]; };
    $sel = function ($key, $label, $type, $choices, $help = '') use ($show) { return ['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => 'select', 'choices' => $choices, 'allow_null' => 1, 'instructions' => $help, 'conditional_logic' => $show($type)]; };
    $tf = function ($key, $label, $type, $help = '') use ($show) { return ['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => 'true_false', 'ui' => 1, 'instructions' => $help, 'conditional_logic' => $show($type)]; };
    $num = function ($key, $label, $type, $min, $max, $help = '') use ($show) { return ['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => 'number', 'min' => $min, 'max' => $max, 'step' => 0.1, 'instructions' => $help, 'conditional_logic' => $show($type)]; };
    acf_add_local_field_group([
        'key' => 'group_rl_post_types', 'title' => 'Article type sections (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 5,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            // Guide fields live in reinforce-post-guide.php (D-077)
            // How-To fields live in reinforce-post-howto.php (D-077)
            // Explainer
            $tx('rl_e_term', 'Term', 'explainer', 'The exact term being defined.'),
            $ta('rl_e_definition', 'Definition', 'explainer', 'One or two sentences, written to be quoted.', 3),
            $ta('rl_e_related', 'Related terms', 'explainer', 'One per line: Term | URL (URL optional)', 4),
            // Best / List fields live in reinforce-post-list.php (D-077)
            // Review fields live in reinforce-post-review.php (D-077)
            // Comparison
            $ta('rl_c_options', 'Options compared', 'comparison', 'One per line, 2 to 4 options.', 3),
            $ta('rl_c_rows', 'Comparison rows', 'comparison', 'One per line: Criterion | value for option 1 | value for option 2 (and so on)', 8),
            $ta('rl_c_winners', 'Winner by use case', 'comparison', 'One per line: Use case | Option', 4),
            $ta('rl_c_verdict', 'Verdict', 'comparison', 'Two or three sentences.', 3),
            // Industry
            $sel('rl_i_industry', 'Industry', 'industry', rl_pt_industries()),
            $ta('rl_i_rules', 'Sector rules and cautions', 'industry', 'One per line: Rule | What it means for this topic', 4),
            // Updates
            $ta('rl_u_what', 'What changed', 'updates', '', 3),
            $ta('rl_u_means', 'What it means', 'updates', '', 3),
            $ta('rl_u_do', 'What to do', 'updates', 'One action per line.', 4),
            $tx('rl_u_source', 'Official source', 'updates', 'Title | URL'),
            $ta('rl_u_log', 'Update log', 'updates', 'One per line: YYYY-MM-DD | What was added or corrected', 4),
            // Case Study
            $tx('rl_cs_client', 'Client', 'casestudy', 'The client name, or an anonymised description such as "A UK pharmaceutical manufacturer".'),
            $tf('rl_cs_named', 'Client agreed to be named', 'casestudy', 'Off = the client is shown anonymised.'),
            $tf('rl_cs_permission', 'Client approved this case study', 'casestudy', 'Required. A case study without approval cannot be published.'),
            $sel('rl_cs_industry', 'Industry', 'casestudy', rl_pt_industries()),
            $ta('rl_cs_challenge', 'Challenge', 'casestudy', '', 3),
            $ta('rl_cs_approach', 'Approach', 'casestudy', 'One step per line.', 4),
            $ta('rl_cs_results', 'Measured results', 'casestudy', 'One per line: Metric | Result | Period and data source. Real, measured numbers only.', 4),
            $ta('rl_cs_quote', 'Client quote', 'casestudy', 'Exact words, approved by the client.', 3),
            $tx('rl_cs_quote_by', 'Quote by', 'casestudy', 'Name and role, or role only if anonymised.'),
            // Research
            $ta('rl_rs_findings', 'Key findings', 'research', 'One per line.', 5),
            $ta('rl_rs_method', 'Method', 'research', 'How the data was collected and analysed.', 4),
            $tx('rl_rs_sample', 'Sample', 'research', 'e.g. "1,200 URLs from 40 sites, crawled July 2026".'),
            ['key' => 'field_rl_rs_dataset', 'name' => 'rl_rs_dataset', 'label' => 'Dataset URL', 'type' => 'url', 'conditional_logic' => $show('research')],
            // Product & Service
            $sel('rl_p_subtype', 'Subtype', 'product', rl_pt_subtypes()),
            $sel('rl_p_service', 'Service or product', 'product', rl_pt_services(), 'The page this post supports. The post must target a different search query than that page.'),
            $ta('rl_p_limits', 'What it does not do', 'product', 'One per line. Honest limits.', 4),
            $ta('rl_p_changelog', 'Changelog', 'product', 'Launch posts. One per line: YYYY-MM-DD | Change', 4),
        ],
    ]);
});

/* Case studies need client approval before they can go live. */
add_action('acf/save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'post' || get_post_status($post_id) !== 'publish') return;
    if ((string) get_post_meta($post_id, 'rl_type', true) !== 'casestudy') return;
    if (get_post_meta($post_id, 'rl_cs_permission', true)) return;
    wp_update_post(['ID' => $post_id, 'post_status' => 'draft']); // stays a draft until the approval box is ticked
}, 20);

/* ---------- helpers ---------- */
function rl_pt_rows($v, $min = 2) {
    $out = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $out[] = $p; }
    return $out;
}
function rl_pt_m($id, $k) { return trim((string) get_post_meta($id, $k, true)); }
function rl_pt_link($text, $url) {
    if ($url === '') return esc_html($text);
    $ext = strpos($url, '#') !== 0 && strpos($url, home_url()) !== 0;
    return '<a href="' . esc_url($url) . '"' . ($ext ? ' rel="noopener" target="_blank"' : '') . '>' . esc_html($text) . '</a>';
}
function rl_pt_date($ymd) { if (strlen($ymd) === 8 && ctype_digit($ymd)) $ymd = substr($ymd, 0, 4) . '-' . substr($ymd, 4, 2) . '-' . substr($ymd, 6, 2); return preg_match('/^\d{4}-\d{2}-\d{2}$/', $ymd) ? $ymd : ''; }
function rl_pt_box($cls, $title, $inner) { return '<section class="ptb ' . esc_attr($cls) . '"><p class="t">' . esc_html($title) . '</p>' . $inner . '</section>'; }
function rl_pt_ul($items, $cls = '') { return $items ? '<ul' . ($cls ? ' class="' . esc_attr($cls) . '"' : '') . '>' . implode('', array_map(function ($i) { return '<li>' . esc_html($i) . '</li>'; }, $items)) . '</ul>' : ''; }
function rl_pt_svc_link($path) {
    $names = rl_pt_services();
    if (!isset($names[$path]) || !function_exists('rl_url_by_path')) return ['', ''];
    $u = rl_url_by_path($path, '');
    return [$u, $names[$path]];
}

/* ---------- before the body ---------- */
add_action('rl_post_type_sections_before', function ($type, $id, $d) {
    $u = function ($path) { return function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; };
    switch ($type) {
        case 'explainer':
            $term = rl_pt_m($id, 'rl_e_term'); $def = rl_pt_m($id, 'rl_e_definition');
            if ($term !== '' && $def !== '') echo '<section class="ptb def"><p class="t">Definition</p><dl><dt>' . esc_html($term) . '</dt><dd>' . esc_html($def) . '</dd></dl></section>';
            break;
        case 'comparison':
            $opts = rl_post_lines(get_post_meta($id, 'rl_c_options', true)); $rows = rl_pt_rows(get_post_meta($id, 'rl_c_rows', true));
            if ($opts && $rows) {
                $h = '<div class="tscroll"><table class="pt-table"><thead><tr><th scope="col">Criterion</th>';
                foreach ($opts as $o) $h .= '<th scope="col">' . esc_html($o) . '</th>';
                $h .= '</tr></thead><tbody>';
                foreach ($rows as $r) { $h .= '<tr><th scope="row">' . esc_html($r[0]) . '</th>'; foreach ($opts as $i => $o) $h .= '<td>' . esc_html($r[$i + 1] ?? '') . '</td>'; $h .= '</tr>'; }
                echo rl_pt_box('summary', 'Side by side', $h . '</tbody></table></div>');
            }
            break;
        case 'industry':
            $k = rl_pt_m($id, 'rl_i_industry');
            if ($k !== '' && function_exists('rl_ind_data') && isset(rl_ind_data()[$k])) {
                $ind = rl_ind_data()[$k]; $l = $u('industries/' . $k);
                echo rl_pt_box('indbox', 'Industry: ' . $ind['name'], '<p>' . esc_html($ind['sum']) . '</p>' . ($l ? '<a class="more" href="' . esc_url($l) . '">How we work with ' . esc_html($ind['name']) . ' &rarr;</a>' : ''));
            }
            break;
        case 'updates':
            $w = rl_pt_m($id, 'rl_u_what'); $m = rl_pt_m($id, 'rl_u_means'); $do = rl_post_lines(get_post_meta($id, 'rl_u_do', true));
            if ($w !== '' || $m !== '' || $do) {
                echo '<section class="ptb upd"><p class="t">The update in brief</p><div class="g3">'
                    . '<div><p class="sub">What changed</p><p>' . esc_html($w) . '</p></div>'
                    . '<div><p class="sub">What it means</p><p>' . esc_html($m) . '</p></div>'
                    . '<div><p class="sub">What to do</p>' . rl_pt_ul($do) . '</div></div>';
                $src = rl_pt_rows(get_post_meta($id, 'rl_u_source', true));
                if ($src) echo '<p class="srcl">Official source: ' . rl_pt_link($src[0][0], $src[0][1]) . '</p>';
                echo '</section>';
            }
            break;
        case 'casestudy':
            $client = rl_pt_m($id, 'rl_cs_client'); $k = rl_pt_m($id, 'rl_cs_industry');
            $indname = ($k !== '' && function_exists('rl_ind_data') && isset(rl_ind_data()[$k])) ? rl_ind_data()[$k]['name'] : '';
            $res = rl_pt_rows(get_post_meta($id, 'rl_cs_results', true));
            $h = '<div class="facts">' . ($client !== '' ? '<div><span>Client</span><b>' . esc_html($client) . '</b></div>' : '') . ($indname ? '<div><span>Industry</span><b>' . esc_html($indname) . '</b></div>' : '') . '</div>';
            $ch = rl_pt_m($id, 'rl_cs_challenge');
            if ($ch !== '') $h .= '<p class="sub">The challenge</p><p>' . esc_html($ch) . '</p>';
            if ($res) {
                $h .= '<div class="metrics">';
                foreach ($res as $r) $h .= '<div class="mt"><b>' . esc_html($r[1]) . '</b><span>' . esc_html($r[0]) . '</span>' . (!empty($r[2]) ? '<small>' . esc_html($r[2]) . '</small>' : '') . '</div>';
                $h .= '</div>';
            }
            if ($client !== '' || $ch !== '' || $res) echo rl_pt_box('case', 'Case study', $h);
            $ap = rl_post_lines(get_post_meta($id, 'rl_cs_approach', true));
            if ($ap) echo rl_pt_box('approach', 'Our approach', '<ol class="num">' . implode('', array_map(function ($x) { return '<li>' . esc_html($x) . '</li>'; }, $ap)) . '</ol>');
            break;
        case 'research':
            $f = rl_post_lines(get_post_meta($id, 'rl_rs_findings', true));
            if ($f) echo rl_pt_box('findings', 'Key findings', '<ol class="num">' . implode('', array_map(function ($x) { return '<li>' . esc_html($x) . '</li>'; }, $f)) . '</ol>');
            $m = rl_pt_m($id, 'rl_rs_method'); $s = rl_pt_m($id, 'rl_rs_sample'); $ds = esc_url(rl_pt_m($id, 'rl_rs_dataset'));
            if ($m !== '' || $s !== '') echo rl_pt_box('method', 'Method', ($s !== '' ? '<p class="sub">Sample</p><p>' . esc_html($s) . '</p>' : '') . ($m !== '' ? '<p>' . esc_html($m) . '</p>' : '') . ($ds ? '<a class="more" href="' . $ds . '" rel="noopener" target="_blank">Download the dataset &rarr;</a>' : ''));
            break;
        case 'product':
            echo '<p class="disc">Reinforce Lab makes this. This article is about our own ' . (strpos(rl_pt_m($id, 'rl_p_service'), 'agents') !== false || rl_pt_m($id, 'rl_p_service') === 'search-authority-os' ? 'product' : 'service') . '.</p>';
            $sub = rl_pt_m($id, 'rl_p_subtype');
            [$sl, $sn] = rl_pt_svc_link(rl_pt_m($id, 'rl_p_service'));
            if ($sn !== '') {
                $st = $d['status'] !== '' ? rl_post_status_labels()[$d['status']] : '';
                $diag = $u('search-authority-diagnostic');
                echo rl_pt_box('prodbox', isset(rl_pt_subtypes()[$sub]) ? rl_pt_subtypes()[$sub] : 'Product', '<div class="pb"><div><p class="pn">' . esc_html($sn) . '</p>' . ($st ? '<p class="sub">Status: ' . esc_html($st) . '</p>' : '') . '</div><div class="cta-row">' . ($sl ? '<a class="btn g" href="' . esc_url($sl) . '">About ' . esc_html($sn) . '</a>' : '') . ($diag ? '<a class="btn p" href="' . esc_url($diag) . '">Get your free diagnostic <span class="ar">&rarr;</span></a>' : '') . '</div></div>');
            }
            break;
    }
}, 10, 3);
function rl_pt_minutes_label($m) { $m = (int) round($m); if ($m < 60) return $m . ' minutes'; $h = intdiv($m, 60); $r = $m % 60; return $h . ' hour' . ($h > 1 ? 's' : '') . ($r ? ' ' . $r . ' minutes' : ''); }

/* ---------- after the body ---------- */
add_action('rl_post_type_sections_after', function ($type, $id, $d) {
    switch ($type) {
        case 'explainer':
            $r = rl_pt_rows(get_post_meta($id, 'rl_e_related', true), 1);
            if ($r) echo rl_pt_box('related-terms', 'Related terms', '<ul class="links">' . implode('', array_map(function ($x) { return '<li>' . rl_pt_link($x[0], $x[1] ?? '') . '</li>'; }, $r)) . '</ul>');
            break;
        case 'comparison':
            $w = rl_pt_rows(get_post_meta($id, 'rl_c_winners', true)); $v = rl_pt_m($id, 'rl_c_verdict');
            if ($w) { $h = '<dl class="gloss">'; foreach ($w as $r) $h .= '<dt>' . esc_html($r[0]) . '</dt><dd>' . esc_html($r[1]) . '</dd>'; echo rl_pt_box('winners', 'Winner by use case', $h . '</dl>'); }
            if ($v !== '') echo rl_pt_box('verdict', 'Our verdict', '<p>' . esc_html($v) . '</p>');
            break;
        case 'industry':
            $rules = rl_pt_rows(get_post_meta($id, 'rl_i_rules', true));
            if ($rules) { $h = '<dl class="gloss">'; foreach ($rules as $r) $h .= '<dt>' . esc_html($r[0]) . '</dt><dd>' . esc_html($r[1]) . '</dd>'; echo rl_pt_box('rules', 'Sector rules to know', $h . '</dl>'); }
            $k = rl_pt_m($id, 'rl_i_industry');
            if ($k !== '' && function_exists('rl_ind_data') && isset(rl_ind_data()[$k]) && function_exists('rl_url_by_path')) {
                $h = '<ul class="links">';
                foreach (array_slice(rl_ind_data()[$k]['svc'], 0, 4) as $s) { $l = rl_url_by_path($s[0], ''); $h .= '<li>' . rl_pt_link($s[1], $l) . ($s[2] ? '<span class="muted"> · ' . esc_html($s[2]) . '</span>' : '') . '</li>'; }
                echo rl_pt_box('indsvc', 'Services for ' . rl_ind_data()[$k]['name'], $h . '</ul>');
            }
            break;
        case 'updates':
            $log = rl_pt_rows(get_post_meta($id, 'rl_u_log', true));
            if ($log) { $h = '<dl class="gloss log">'; foreach ($log as $r) { $dt = rl_pt_date($r[0]); $h .= '<dt><time datetime="' . esc_attr($dt) . '">' . esc_html($dt ? date_i18n('j M Y', strtotime($dt)) : $r[0]) . '</time></dt><dd>' . esc_html($r[1]) . '</dd>'; } echo rl_pt_box('log', 'Update log', $h . '</dl>'); }
            break;
        case 'casestudy':
            $q = rl_pt_m($id, 'rl_cs_quote'); $by = rl_pt_m($id, 'rl_cs_quote_by');
            if ($q !== '') echo '<figure class="ptb quote"><blockquote>' . esc_html($q) . '</blockquote>' . ($by !== '' ? '<figcaption>' . esc_html($by) . '</figcaption>' : '') . '</figure>';
            break;
        case 'research':
            $cite = 'Reinforce Lab (' . get_the_date('Y', $id) . '). ' . get_the_title($id) . '. ' . get_permalink($id);
            echo rl_pt_box('cite', 'Cite this research', '<p class="mono">' . esc_html($cite) . '</p>');
            break;
        case 'product':
            $lim = rl_post_lines(get_post_meta($id, 'rl_p_limits', true));
            if ($lim) echo rl_pt_box('limits', 'What it does not do', rl_pt_ul($lim, 'cons'));
            $log = rl_pt_rows(get_post_meta($id, 'rl_p_changelog', true));
            if ($log) { $h = '<dl class="gloss log">'; foreach ($log as $r) { $dt = rl_pt_date($r[0]); $h .= '<dt><time datetime="' . esc_attr($dt) . '">' . esc_html($dt ? date_i18n('j M Y', strtotime($dt)) : $r[0]) . '</time></dt><dd>' . esc_html($r[1]) . '</dd>'; } echo rl_pt_box('log', 'Changelog', $h . '</dl>'); }
            break;
    }
}, 10, 3);

/* ---------- schema additions ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !function_exists('rl_is_post_view') || !rl_is_post_view()) return $graph;
    $id = get_queried_object_id(); $d = rl_post_data($id); $url = get_permalink($id);
    $pid = rl_person_schema_id(get_post_field('post_author', $id));
    $add = null; $about = null;
    switch ($d['type']) {
        case 'explainer':
            $term = rl_pt_m($id, 'rl_e_term'); $def = rl_pt_m($id, 'rl_e_definition');
            if ($term !== '' && $def !== '') { $add = ['@type' => 'DefinedTerm', '@id' => $url . '#term', 'name' => $term, 'description' => $def, 'url' => $url]; $about = ['@id' => $url . '#term']; }
            break;
        case 'comparison':
            $opts = rl_post_lines(get_post_meta($id, 'rl_c_options', true));
            if ($opts) $add = ['@type' => 'ItemList', '@id' => $url . '#options', 'name' => get_the_title($id), 'numberOfItems' => count($opts), 'itemListElement' => array_map(function ($o, $i) { return ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $o]; }, $opts, array_keys($opts))];
            break;
        case 'research':
            $ds = esc_url_raw(rl_pt_m($id, 'rl_rs_dataset'));
            if ($ds) {
                $desc = rl_pt_m($id, 'rl_rs_method') ?: $d['answer'];
                $add = ['@type' => 'Dataset', '@id' => $url . '#dataset', 'name' => get_the_title($id), 'description' => $desc, 'url' => $url, 'creator' => ['@id' => home_url('/#organization')],
                    'distribution' => [['@type' => 'DataDownload', 'contentUrl' => $ds]]];
                $s = rl_pt_m($id, 'rl_rs_sample'); if ($s !== '') $add['variableMeasured'] = $s;
            }
            break;
        case 'industry':
            $k = rl_pt_m($id, 'rl_i_industry');
            if ($k !== '' && function_exists('rl_ind_data') && isset(rl_ind_data()[$k])) $about = ['@type' => 'Thing', 'name' => rl_ind_data()[$k]['name']];
            break;
        case 'product':
            [$sl, $sn] = rl_pt_svc_link(rl_pt_m($id, 'rl_p_service'));
            if ($sl) $about = ['@type' => 'Service', '@id' => $sl . '#service', 'name' => $sn, 'url' => $sl, 'provider' => ['@id' => home_url('/#organization')]];
            break;
    }
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        if (in_array('Article', (array) $n['@type'], true)) {
            if ($about) $n['about'] = $about;
            if ($d['type'] === 'research') $n['@type'] = ['Article', 'BlogPosting', 'Report'];
        }
    }
    unset($n);
    if ($add) $graph[] = $add;
    return $graph;
}, 30);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!function_exists('rl_is_post_view') || !rl_is_post_view()) return; ?>
<style id="rl-post-types-css">
.rl-post .ptb{border:1px solid var(--line);background:var(--panel);padding:20px 24px;margin:0 0 28px}
.rl-post .body + .ptb,.rl-post .body ~ .ptb{margin-top:36px}
.rl-post .ptb .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 12px}
.rl-post .ptb .sub{font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint);margin:12px 0 6px}
.rl-post .ptb p{margin:0 0 10px;color:var(--ink-dim);font-size:16px}
.rl-post .ptb p:last-child{margin-bottom:0}
.rl-post .ptb ul,.rl-post .ptb ol{margin:0;padding:0;list-style:none}
.rl-post .ptb li{padding:8px 0;border-top:1px solid var(--line);color:var(--ink-dim);font-size:15.5px}
.rl-post .ptb li:first-child{border-top:0}
.rl-post .ptb a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-post .ptb a.btn{border-bottom:0}
.rl-post .ptb .muted{color:var(--ink-faint)}
.rl-post .ptb .mono{font-family:var(--f-mono);font-size:13px;color:var(--ink);word-break:break-word}
.rl-post .ptb .facts{display:flex;flex-wrap:wrap;gap:10px 28px;margin-bottom:6px}
.rl-post .ptb .facts span{display:block;font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-post .ptb .facts b{color:var(--ink);font-size:16px}
.rl-post .ptb .ticks2 li,.rl-post .ptb .pros li{position:relative;padding-left:22px}
.rl-post .ptb .ticks2 li::before,.rl-post .ptb .pros li::before{content:"";position:absolute;left:2px;top:13px;width:9px;height:5px;border-left:2px solid var(--red-3);border-bottom:2px solid var(--red-3);transform:rotate(-45deg)}
.rl-post .ptb .cons li{position:relative;padding-left:22px}
.rl-post .ptb .cons li::before{content:"";position:absolute;left:2px;top:17px;width:10px;height:2px;background:var(--ink-faint)}
.rl-post .ptb .paths{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:8px}
.rl-post .ptb .paths li{border:1px solid var(--line-2);padding:12px 14px}
.rl-post .ptb .paths li:first-child{border-top:1px solid var(--line-2)}
.rl-post .ptb .steps-list li,.rl-post .ptb .items li{display:grid;grid-template-columns:34px 1fr;gap:10px;padding:12px 0}
.rl-post .ptb .k{font-family:var(--f-mono);font-size:12px;color:var(--red-3);padding-top:2px}
.rl-post .ptb .steps-list b,.rl-post .ptb .items b{color:var(--ink);font-size:16.5px}
.rl-post .ptb .steps-list p,.rl-post .ptb .items p{margin:4px 0 0}
.rl-post .ptb.def{border-left:3px solid var(--red-2)}
.rl-post .ptb.def dt{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);font-size:22px;margin-bottom:6px}
.rl-post .ptb.def dd{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-post .ptb .gloss{margin:0}
.rl-post .ptb .gloss dt{color:var(--ink);font-weight:600;padding-top:12px;border-top:1px solid var(--line)}
.rl-post .ptb .gloss dt:first-child{border-top:0;padding-top:0}
.rl-post .ptb .gloss dd{margin:4px 0 12px;color:var(--ink-dim);font-size:15.5px}
.rl-post .ptb .pt-table{min-width:560px}
.rl-post .ptb .pt-table td.n{font-family:var(--f-mono);color:var(--red-3)}
.rl-post .ptb .pt-table th,.rl-post .ptb .pt-table td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top;font-size:14.5px}
.rl-post .ptb .pt-table thead th{color:var(--ink);background:var(--bg-2)}
.rl-post .ptb .pt-table tbody th{color:var(--ink);font-weight:600}
.rl-post .ptb.verdict{border-color:var(--red-line)}
.rl-post .ptb .vtop{display:flex;gap:20px;align-items:flex-start}
.rl-post .ptb .score{flex:none;width:86px;height:86px;border:1px solid var(--red-2);display:flex;flex-direction:column;align-items:center;justify-content:center;background:var(--bg-2)}
.rl-post .ptb .score b{font-family:var(--f-display);font-size:34px;color:var(--ink);line-height:1}
.rl-post .ptb .score span{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint)}
.rl-post .ptb .pn{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink)!important;font-size:20px}
.rl-post .ptb .pc{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:10px}
.rl-post .ptb .g3{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.rl-post .ptb .srcl{margin-top:14px;font-size:14.5px}
.rl-post .ptb .metrics{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1px;background:var(--line);border:1px solid var(--line);margin-top:16px}
.rl-post .ptb .mt{background:var(--bg-2);padding:16px}
.rl-post .ptb .mt b{display:block;font-family:var(--f-display);font-size:30px;color:var(--ink);line-height:1.1}
.rl-post .ptb .mt span{display:block;color:var(--ink-dim);font-size:14px;margin-top:4px}
.rl-post .ptb .mt small{display:block;font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);margin-top:6px}
.rl-post .ptb ol.num{counter-reset:n}
.rl-post .ptb ol.num li{counter-increment:n;display:grid;grid-template-columns:34px 1fr;gap:10px}
.rl-post .ptb ol.num li::before{content:counter(n,decimal-leading-zero);font-family:var(--f-mono);font-size:12px;color:var(--red-3);padding-top:3px}
.rl-post .ptb.quote{border-left:3px solid var(--red-2)}
.rl-post .ptb.quote blockquote{margin:0;color:var(--ink);font-size:20px;line-height:1.5}
.rl-post .ptb.quote figcaption{margin-top:12px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-post .ptb .pb{display:flex;flex-wrap:wrap;gap:16px;align-items:center;justify-content:space-between}
.rl-post .ptb .pb .cta-row{margin:0}
.rl-post .disc{border:1px dashed var(--line-2);padding:12px 16px;margin:0 0 24px;font-size:14.5px;color:var(--ink-dim)}
@media(max-width:700px){.rl-post .ptb .g3,.rl-post .ptb .pc{grid-template-columns:1fr}.rl-post .ptb{padding:16px}.rl-post .ptb .vtop{flex-direction:column}}
</style>
<?php }, 23);
