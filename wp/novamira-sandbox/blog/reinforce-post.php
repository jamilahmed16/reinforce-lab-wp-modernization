<?php
/**
 * Plugin Name: Reinforce Lab - Single post template (long-form base)
 * Description: The one template for every blog post (D-074). Shared long-form base: short answer, key takeaways, sticky contents, reading time, real published/updated dates, sources, FAQs, author box, related posts, CTA, BlogPosting schema. Post fields are registered in code with ACF (no DB field groups). Type-specific sections hook into rl_post_type_sections. No Beaver Themer singular layout, so no location is targeted twice (F-001). Uses the shared kit (D-044).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_post_view() { return !is_admin() && is_singular('post'); }

/* The approved post types (D-074). Key = stored value. */
function rl_post_types() {
    return [
        'guide' => 'Guide', 'howto' => 'How-To', 'explainer' => 'Explainer', 'list' => 'Best / List', 'review' => 'Review',
        'comparison' => 'Comparison', 'industry' => 'Industry', 'updates' => 'Update', 'casestudy' => 'Case Study',
        'research' => 'Research', 'product' => 'Product & Service', 'opinion' => 'Opinion', 'checklist' => 'Checklist',
    ];
}
function rl_post_status_labels() { return ['available' => 'Available', 'early' => 'Early access', 'development' => 'In development']; }

/* Yoast's own Person @id for a user, so posts and the About page describe one entity. */
function rl_person_schema_id($user_id) {
    $u = get_userdata($user_id);
    return $u ? home_url('/') . '#/schema/person/' . wp_hash($u->user_login . $u->ID) : '';
}

/* ---------- fields (ACF local group: lives in code, shows in the post editor) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_rl_post', 'title' => 'Article settings (Reinforce Lab)', 'position' => 'side', 'style' => 'default',
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            ['key' => 'field_rl_type', 'name' => 'rl_type', 'label' => 'Article type', 'type' => 'select', 'choices' => rl_post_types(), 'default_value' => 'guide', 'required' => 1],
            ['key' => 'field_rl_status', 'name' => 'rl_status', 'label' => 'Status label', 'type' => 'select', 'choices' => rl_post_status_labels(), 'allow_null' => 1,
             'instructions' => 'Required on posts about the agents or Search Authority OS (D-074, O-022).',
             'conditional_logic' => [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'product']]]],
            ['key' => 'field_rl_answer', 'name' => 'rl_answer', 'label' => 'Short answer', 'type' => 'textarea', 'rows' => 4,
             'instructions' => 'Two or three sentences that answer the main question directly. Shown first, quoted by search and AI tools.'],
            ['key' => 'field_rl_takeaways', 'name' => 'rl_takeaways', 'label' => 'Key takeaways', 'type' => 'textarea', 'rows' => 5, 'instructions' => 'One per line, 3 to 6 lines.'],
            ['key' => 'field_rl_updated', 'name' => 'rl_updated', 'label' => 'Last substantive update', 'type' => 'date_picker', 'display_format' => 'j M Y', 'return_format' => 'Y-m-d',
             'instructions' => 'Set only when the content really changed (F-003: no bulk redating). Typo fixes do not count.'],
            ['key' => 'field_rl_faqs', 'name' => 'rl_faqs', 'label' => 'FAQs', 'type' => 'textarea', 'rows' => 6, 'instructions' => 'One per line: Question? | Answer'],
            ['key' => 'field_rl_sources', 'name' => 'rl_sources', 'label' => 'Sources', 'type' => 'textarea', 'rows' => 6, 'instructions' => 'One per line: Source title | https://url'],
        ],
    ]);
});

/* ---------- data helpers ---------- */
function rl_post_lines($v) { return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $v)), 'strlen')); }
function rl_post_pairs($v) {
    $out = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l, 2)); if (count($p) === 2 && $p[0] !== '' && $p[1] !== '') $out[] = $p; }
    return $out;
}
function rl_post_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $types = rl_post_types();
    $type = (string) get_post_meta($id, 'rl_type', true);
    if (!isset($types[$type])) $type = 'guide';
    $status = (string) get_post_meta($id, 'rl_status', true);
    $pub = get_the_date('Y-m-d', $id);
    $upd = (string) get_post_meta($id, 'rl_updated', true);
    if (strlen($upd) === 8 && ctype_digit($upd)) $upd = substr($upd, 0, 4) . '-' . substr($upd, 4, 2) . '-' . substr($upd, 6, 2); // ACF stores Ymd
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $upd) || $upd <= $pub) $upd = '';
    $sources = [];
    foreach (rl_post_pairs(get_post_meta($id, 'rl_sources', true)) as $s) { $u = esc_url_raw($s[1]); if ($u) $sources[] = [$s[0], $u]; }
    return $cache[$id] = [
        'type' => $type, 'type_label' => $types[$type],
        'status' => isset(rl_post_status_labels()[$status]) ? $status : '',
        'answer' => trim((string) get_post_meta($id, 'rl_answer', true)),
        'takeaways' => rl_post_lines(get_post_meta($id, 'rl_takeaways', true)),
        'published' => $pub, 'updated' => $upd,
        'faqs' => rl_post_pairs(get_post_meta($id, 'rl_faqs', true)),
        'sources' => $sources,
    ];
}

/* Adds ids to H2/H3 in the article body and returns [html, toc]. Contents list = H2s only. */
function rl_post_prepare($html) {
    $toc = []; $used = [];
    $html = preg_replace_callback('#<h([23])([^>]*)>(.*?)</h\1>#is', function ($m) use (&$toc, &$used) {
        $text = trim(wp_strip_all_tags($m[3]));
        if ($text === '') return $m[0];
        if (preg_match('/\sid=["\']([^"\']+)["\']/', $m[2], $idm)) { $id = $idm[1]; $attrs = $m[2]; }
        else {
            $base = sanitize_title($text) ?: 'section'; $id = $base; $n = 2;
            while (isset($used[$id])) $id = $base . '-' . $n++;
            $attrs = $m[2] . ' id="' . esc_attr($id) . '"';
        }
        $used[$id] = true;
        if ($m[1] === '2') $toc[] = [$id, $text];
        return '<h' . $m[1] . $attrs . '>' . $m[3] . '</h' . $m[1] . '>';
    }, $html);
    // wide tables scroll inside their own box on phones (kit .tscroll)
    $html = preg_replace('#<table\b#i', '<div class="tscroll"><table', $html);
    $html = preg_replace('#</table>#i', '</table></div>', $html);
    return [$html, $toc];
}
function rl_post_minutes($html) { return max(1, (int) ceil(str_word_count(wp_strip_all_tags($html)) / 230)); }

/* ---------- head: kit, CSS, schema ---------- */
add_filter('body_class', function ($c) { if (rl_is_post_view()) $c[] = 'rl-post-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_post_view(); });
add_action('wp_head', 'rl_post_css', 22);
function rl_post_css() {
    if (!rl_is_post_view()) return; ?>
<style id="rl-post-css">
body.rl-post-page .fl-page-content,body.rl-post-page .fl-content,body.rl-post-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-post .hero{padding-bottom:clamp(18px,3vw,30px)}
.rl-post .hero .h1{font-size:clamp(34px,4.6vw,58px);max-width:980px}
.rl-post .tags{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:18px}
.rl-post .tag{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--line-2);color:var(--ink-dim);padding:6px 10px}
.rl-post .tag.type{border-color:var(--red-line);color:var(--ink)}
.rl-post .tag.st{border-color:var(--red-2);color:var(--red-3)}
.rl-post .meta{display:flex;flex-wrap:wrap;gap:6px 22px;margin-top:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-post .meta b{color:var(--ink-dim);font-weight:500}
.rl-post .meta a{color:var(--ink-dim);border-bottom:1px solid var(--red-line)}
.rl-post .feat{margin:clamp(22px,3vw,34px) 0 0;border:1px solid var(--line)}
.rl-post .feat img{display:block;width:100%;height:auto}
.rl-post .grid{display:grid;grid-template-columns:minmax(0,1fr) 280px;gap:clamp(32px,5vw,72px);align-items:start;padding-block:clamp(34px,5vw,64px)}
.rl-post .grid.notoc{grid-template-columns:minmax(0,1fr)}
.rl-post article{max-width:760px;min-width:0}
.rl-post .toc{position:sticky;top:110px;border:1px solid var(--line);background:var(--panel);padding:18px 18px 12px;max-height:calc(100vh - 140px);overflow:auto}
.rl-post .toc .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 10px}
.rl-post .toc ol{list-style:none;margin:0;padding:0;counter-reset:t}
.rl-post .toc li{counter-increment:t;border-top:1px solid var(--line)}
.rl-post .toc a{display:grid;grid-template-columns:26px 1fr;padding:9px 0;font-size:14px;line-height:1.4;color:var(--ink-dim)}
.rl-post .toc a::before{content:counter(t,decimal-leading-zero);font-family:var(--f-mono);font-size:11px;color:var(--red-3);padding-top:2px}
.rl-post .toc a:hover,.rl-post .toc a[aria-current]{color:var(--ink)}
.rl-post .toc-m{display:none;border:1px solid var(--line);background:var(--panel);margin-bottom:26px}
.rl-post .toc-m summary{cursor:pointer;padding:14px 16px;font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink)}
.rl-post .toc-m ol{margin:0;padding:0 16px 12px 34px;color:var(--ink-dim)}
.rl-post .toc-m li{padding:6px 0}
.rl-post .toc-m a{color:var(--ink-dim)}
.rl-post .answer{border:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin:0 0 28px}
.rl-post .answer .t,.rl-post .take .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-post .answer p{margin:0;font-size:18px;line-height:1.6;color:var(--ink)}
.rl-post .take{border:1px solid var(--line);background:var(--panel);padding:20px 24px;margin:0 0 36px}
.rl-post .take ul{margin:0;padding:0;list-style:none}
.rl-post .take li{position:relative;padding:8px 0 8px 22px;border-top:1px solid var(--line);color:var(--ink-dim)}
.rl-post .take li:first-child{border-top:0}
.rl-post .take li::before{content:"";position:absolute;left:2px;top:16px;width:8px;height:8px;background:var(--red-2)}
.rl-post .body{font-size:17.5px;line-height:1.75;color:var(--ink-dim)}
.rl-post .body>*{margin:0 0 1.15em}
.rl-post .body h2{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);font-size:clamp(26px,3vw,34px);line-height:1.1;margin:1.9em 0 .6em;scroll-margin-top:110px}
.rl-post .body h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);font-size:21px;line-height:1.2;margin:1.6em 0 .5em;scroll-margin-top:110px}
.rl-post .body h4{color:var(--ink);font-size:18px;margin:1.4em 0 .4em}
.rl-post .body a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-post .body a:hover{color:var(--red-3)}
.rl-post .body strong{color:var(--ink)}
.rl-post .body ul,.rl-post .body ol{padding-left:1.3em}
.rl-post .body li{margin:.35em 0}
.rl-post .body li::marker{color:var(--red-3)}
.rl-post .body blockquote{margin:1.6em 0;padding:4px 0 4px 22px;border-left:2px solid var(--red-2);color:var(--ink);font-size:19px}
.rl-post .body img{max-width:100%;height:auto;display:block}
.rl-post .body figure{margin:1.6em 0}
.rl-post .body figcaption{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);margin-top:8px}
.rl-post .body .tscroll{overflow-x:auto;max-width:100%}
.rl-post .body table{width:100%;border-collapse:collapse;font-size:15px}
.rl-post .body th,.rl-post .body td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-post .body th{color:var(--ink);background:var(--panel);font-weight:600}
.rl-post .body code{font-family:var(--f-mono);font-size:.9em;background:var(--panel);padding:2px 6px;color:var(--ink)}
.rl-post .body pre{background:var(--panel);border:1px solid var(--line);padding:16px;overflow-x:auto}
.rl-post .body pre code{padding:0;background:none}
.rl-post .body hr{border:0;border-top:1px solid var(--line);margin:2em 0}
.rl-post .faqp{margin-top:48px}
.rl-post .faqp h2,.rl-post .src h2{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);font-size:clamp(24px,2.8vw,30px);margin:0 0 16px}
.rl-post .src{margin-top:44px;border-top:1px solid var(--line);padding-top:26px}
.rl-post .src ol{margin:0;padding-left:1.4em;color:var(--ink-faint);font-size:15px}
.rl-post .src li{padding:5px 0}
.rl-post .src a{color:var(--ink-dim);border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-post .author{display:grid;grid-template-columns:72px 1fr;gap:20px;margin-top:44px;border:1px solid var(--line-2);background:var(--panel);padding:24px}
.rl-post .author .av{width:72px;height:72px;border:1px solid var(--red-line);display:flex;align-items:center;justify-content:center;font-family:var(--f-display);font-weight:600;font-size:26px;color:var(--ink);background:var(--bg-2)}
.rl-post .author .av img{width:100%;height:100%;object-fit:cover}
.rl-post .author .nm{font-family:var(--f-display);font-weight:600;font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-post .author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 10px}
.rl-post .author p{margin:0 0 10px;color:var(--ink-dim);font-size:15px}
.rl-post .author .links{display:flex;flex-wrap:wrap;gap:16px;font-size:14px}
.rl-post .author .links a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-post .rel .posts{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--line);border:1px solid var(--line)}
.rl-post .rel .post{background:var(--bg-2);padding:22px;display:flex;flex-direction:column;gap:10px}
.rl-post .rel .post .m{font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-post .rel .post h3{font-size:19px;line-height:1.2;margin:0}
.rl-post .rel .post h3 a{color:var(--ink)}
.rl-post .rel .post h3 a:hover{color:var(--red-3)}
@media(max-width:1000px){.rl-post .grid{grid-template-columns:minmax(0,1fr)}.rl-post .toc{display:none}.rl-post .toc-m{display:block}.rl-post .rel .posts{grid-template-columns:1fr 1fr}}
@media(max-width:560px){.rl-post .body{font-size:16.5px}.rl-post .answer{padding:18px 16px}.rl-post .answer p{font-size:16.5px}.rl-post .take{padding:16px}.rl-post .author{grid-template-columns:1fr;padding:18px}.rl-post .rel .posts{grid-template-columns:1fr}}
</style>
<?php }

add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_post_view()) return $graph;
    $id = get_queried_object_id();
    $p = get_post($id);
    $d = rl_post_data($id);
    $url = get_permalink($id);
    $pid = rl_person_schema_id($p->post_author);
    $jamil = function_exists('rl_about_person') && get_the_author_meta('display_name', $p->post_author) === rl_about_person()['name'];
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if (in_array('Article', $t, true)) {
            $n['@type'] = ['Article', 'BlogPosting'];
            $n['datePublished'] = get_the_date('c', $id);
            $n['dateModified'] = $d['updated'] !== '' ? $d['updated'] . 'T00:00:00' . get_the_date('P', $id) : get_the_date('c', $id); // real dates only (F-003)
            $n['genre'] = $d['type_label'];
            if ($d['answer'] !== '') $n['abstract'] = $d['answer'];
            if ($d['sources']) $n['citation'] = array_map(function ($s) { return ['@type' => 'CreativeWork', 'name' => $s[0], 'url' => $s[1]]; }, $d['sources']);
        }
        if ($jamil && in_array('Person', $t, true) && isset($n['@id']) && $n['@id'] === $pid) {
            $f = rl_about_person();
            $n['jobTitle'] = $f['job'];
            $n['description'] = 'Founder and CEO of Reinforce Lab. Pharmacist, SEO and AI search consultant, and Semrush Ambassador.';
            $n['knowsAbout'] = ['Search engine optimization', 'AI search optimization', 'AI automation', 'Pharmacy'];
            $n['sameAs'] = array_values(array_unique(array_merge((array) ($n['sameAs'] ?? []), [$f['linkedin']])));
            $n['worksFor'] = ['@id' => home_url('/#organization')];
            if (function_exists('rl_url_by_path')) $n['url'] = rl_url_by_path('about-us', $n['url'] ?? home_url('/'));
        }
    }
    unset($n);
    if ($d['faqs']) $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, $d['faqs'])];
    return $graph;
}, 20);

/* ---------- render ---------- */
add_action('template_redirect', 'rl_post_render', 99);
function rl_post_render() {
    if (!rl_is_post_view() || is_404() || is_feed()) return;
    rl_post_output();
    exit;
}
/* Split out so a preview harness can render without exiting. */
function rl_post_output() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    get_header();
    while (have_posts()) { the_post();
        $id = get_the_ID();
        $d = rl_post_data($id);
        [$body, $toc] = rl_post_prepare(apply_filters('the_content', get_the_content()));
        $mins = rl_post_minutes($body);
        $blog = (int) get_option('page_for_posts');
        $blog_url = $blog ? get_permalink($blog) : home_url('/');
        $cats = get_the_category($id);
        $cat = null; foreach ($cats as $c) if ((int) $c->term_id !== (int) get_option('default_category')) { $cat = $c; break; }
        $aid = (int) get_post_field('post_author', $id);
        $aname = get_the_author_meta('display_name', $aid);
        $founder = function_exists('rl_about_person') && $aname === rl_about_person()['name'] ? rl_about_person() : null;
        $bio = trim(wp_strip_all_tags(get_the_author_meta('description', $aid)));
        $about = $u('about-us');
        // Guide posts use their own approved design (D-077); every other type keeps this layout until its design is approved.
        if ($d['type'] === 'guide' && function_exists('rl_guide_render')) { rl_guide_render(compact('id', 'd', 'body', 'toc', 'mins', 'blog_url', 'cat', 'aname', 'founder', 'bio', 'about', 'u')); continue; }
        ?>
<div class="rl-page rl-post">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($blog_url); ?>">Blog</a></li>
  <?php if ($cat) { ?><li><a href="<?php echo esc_url(get_category_link($cat)); ?>"><?php echo esc_html($cat->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words(get_the_title(), 8)); ?></span></li>
</ol></nav>

<header class="hero">
  <div class="wrap">
    <div class="tags">
      <span class="tag type"><?php echo esc_html($d['type_label']); ?></span>
      <?php if ($d['type'] === 'product' && $d['status'] !== '') echo '<span class="tag st">' . esc_html(rl_post_status_labels()[$d['status']]) . '</span>'; ?>
      <?php if ($cat) echo '<a class="tag" href="' . esc_url(get_category_link($cat)) . '">' . esc_html($cat->name) . '</a>'; ?>
    </div>
    <h1 class="h1"><?php the_title(); ?></h1>
    <div class="meta">
      <span>By <?php echo $founder ? '<a href="' . $about . '#founder">' . esc_html($aname) . '</a>' : '<b>' . esc_html($aname) . '</b>'; ?></span>
      <span>Published <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><b><?php echo esc_html(get_the_date('j M Y')); ?></b></time></span>
      <?php if ($d['updated'] !== '') { ?><span>Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
      <span><b><?php echo (int) $mins; ?> min</b> read</span>
    </div>
    <?php if (has_post_thumbnail()) { ?><figure class="feat"><?php the_post_thumbnail('full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>
  </div>
</header>

<div class="wrap grid<?php echo $toc ? '' : ' notoc'; ?>">
  <article>
    <?php if ($toc) { ?>
    <details class="toc-m"><summary>Contents (<?php echo count($toc); ?>)</summary><ol><?php foreach ($toc as $t) echo '<li><a href="#' . esc_attr($t[0]) . '">' . esc_html($t[1]) . '</a></li>'; ?></ol></details>
    <?php } ?>
    <?php if ($d['answer'] !== '') { ?>
    <div class="answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div>
    <?php } ?>
    <?php if ($d['takeaways']) { ?>
    <div class="take"><p class="t">Key takeaways</p><ul><?php foreach ($d['takeaways'] as $k) echo '<li>' . esc_html($k) . '</li>'; ?></ul></div>
    <?php } ?>

    <?php do_action('rl_post_type_sections_before', $d['type'], $id, $d); ?>
    <div class="body"><?php echo $body; ?></div>
    <?php do_action('rl_post_type_sections_after', $d['type'], $id, $d); ?>

    <?php if ($d['faqs']) { ?>
    <section class="faq faqp" id="faq" aria-labelledby="faq-h">
      <h2 id="faq-h">Frequently asked questions</h2>
      <?php foreach ($d['faqs'] as $k => $q) { ?>
      <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
      <?php } ?>
    </section>
    <?php } ?>

    <?php if ($d['sources']) { ?>
    <section class="src" id="sources" aria-labelledby="src-h">
      <h2 id="src-h">Sources</h2>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </section>
    <?php } ?>

    <aside class="author" aria-label="About the author">
      <div class="av" aria-hidden="true"><?php echo esc_html(mb_substr($aname, 0, 1)); ?></div>
      <div>
        <p class="nm"><?php echo esc_html($aname); ?></p>
        <?php if ($founder) { ?>
        <p class="role"><?php echo esc_html($founder['job']); ?>, Reinforce Lab</p>
        <p><?php echo $bio !== '' ? esc_html($bio) : 'Pharmacist, SEO and AI search consultant, and Semrush Ambassador. Jamil builds AI Growth Systems for businesses using AI automation, AI Search Optimization, SEO and intelligent workflows.'; ?></p>
        <div class="links"><a href="<?php echo $about; ?>#founder">About Jamil</a><a href="<?php echo esc_url($founder['linkedin']); ?>" rel="noopener" target="_blank">LinkedIn</a></div>
        <?php } elseif ($bio !== '') { ?>
        <p><?php echo esc_html($bio); ?></p>
        <?php } ?>
      </div>
    </aside>
  </article>

  <?php if ($toc) { ?>
  <aside class="toc" aria-label="Contents">
    <p class="t">Contents</p>
    <ol><?php foreach ($toc as $t) echo '<li><a href="#' . esc_attr($t[0]) . '">' . esc_html($t[1]) . '</a></li>'; ?></ol>
  </aside>
  <?php } ?>
</div>

<?php
        $rel = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true,
            'category__in' => $cat ? [$cat->term_id] : []]);
        $hasrel = $rel->have_posts();
        if ($hasrel) { ?>
<section class="band alt rel" id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Keep reading&nbsp;<b>]</b></span><h2>Related articles</h2></div>
    <ul class="posts">
      <?php while ($rel->have_posts()) { $rel->the_post(); $rd = rl_post_data(get_the_ID()); ?>
      <li class="post"><span class="m"><?php echo esc_html($rd['type_label']); ?> · <?php echo esc_html(get_the_date('j M Y')); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read: ' . get_the_title()); ?>">Read article &rarr;</a></li>
      <?php } wp_reset_postdata(); ?>
    </ul>
  </div>
</section>
<?php } ?>

<section class="<?php echo $hasrel ? '' : 'band alt'; ?>" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See where your search visibility stands.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $u('search-authority-diagnostic'); ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo esc_url($blog_url); ?>">More articles</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    }
    get_footer();
}
