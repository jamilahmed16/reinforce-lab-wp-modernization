<?php
/**
 * Plugin Name: Reinforce Lab - Blog archive template
 * Description: The single archive template for /blog/ (posts page) and every category, tag, author and date archive. F-001 by design: ONE loop, bound to the main query, core pagination (/page/N/ only), and no Beaver Themer archive layout at all, so no location can be targeted twice. Requests carrying Beaver Builder's `flpaged` var (/paged-N/M/ junk) get a 410. Paginated archives (page 2+) are noindex,follow (disposition sheet: KEEP-noindex). Uses the shared kit (D-044). No hero animation (Blog is excluded, D-039).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_blog_archive() { return !is_admin() && (is_home() || is_category() || is_tag() || is_author() || is_date()); }

/* ---------- F-001: /paged-N/M/ junk → 410 (approved RETIRE-410 in the disposition sheet) ---------- */
add_action('template_redirect', function () {
    if ((string) get_query_var('flpaged') === '') return;
    global $wp_query;
    $wp_query->set_404();
    status_header(410);
    nocache_headers();
}, 0);

/* ---------- thin archives retired (Jamil, 7 Oct 2026, F-028 C6): author and date archives and the default
   "Uncategorized" category 301 to /blog/. One author site; production's /author/<name>/ URLs (7, with
   impressions) are listed in the URL register with the same target. Runs on 'wp' before Yoast's own
   archive redirect (which would send them to the home page). Feeds are left alone. ---------- */
add_action('wp', function () {
    if (is_admin() || is_feed() || (string) get_query_var('flpaged') !== '' || strpos((string) ($_SERVER['REQUEST_URI'] ?? ''), '/paged-') !== false) return; // F-001 junk keeps its approved 410
    $default = (int) get_option('default_category');
    $author_path = (bool) preg_match('#^/author/[^/]+(/|$)#', (string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH)); // includes production's former authors and their /page/N/ and /paged-N/ URLs
    if (is_author() || is_date() || ($default && is_category($default)) || $author_path) {
        $blog = (int) get_option('page_for_posts');
        wp_safe_redirect($blog ? get_permalink($blog) : home_url('/'), 301, 'Reinforce Lab');
        exit;
    }
}, 0);
add_filter('wpseo_sitemap_exclude_taxonomy', function ($ex, $tax) { return $tax === 'category' && !get_categories(['hide_empty' => true, 'exclude' => [(int) get_option('default_category')]]) ? true : $ex; }, 10, 2); // no category sitemap while only Uncategorized exists
add_filter('wpseo_exclude_from_sitemap_by_term_ids', function ($ids) { $d = (int) get_option('default_category'); return $d ? array_merge((array) $ids, [$d]) : $ids; });

/* ---------- robots: page 2+ of any archive, and any empty archive, = noindex,follow ---------- */
add_filter('wpseo_robots', function ($robots) {
    if (!rl_is_blog_archive()) return $robots;
    global $wp_query;
    return (is_paged() || (int) $wp_query->post_count === 0) ? 'noindex, follow' : $robots;
}, 20);

/* ---------- schema: the articles on this archive page as an ItemList (Yoast already emits CollectionPage + BreadcrumbList) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    global $wp_query;
    if (!is_array($graph) || !rl_is_blog_archive() || empty($wp_query->posts)) return $graph;
    $items = []; $i = 0;
    foreach ($wp_query->posts as $p) $items[] = ['@type' => 'ListItem', 'position' => ++$i, 'url' => get_permalink($p), 'name' => get_the_title($p)];
    $graph[] = ['@type' => 'ItemList', '@id' => home_url(add_query_arg([])) . '#articles', 'numberOfItems' => count($items), 'itemListElement' => $items];
    return $graph;
}, 20);

add_filter('body_class', function ($c) { if (rl_is_blog_archive()) $c[] = 'rl-blog-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_blog_archive(); });
add_action('wp_head', 'rl_blog_css', 22);
function rl_blog_css() {
    if (!rl_is_blog_archive()) return; ?>
<style id="rl-blog-css">
body.rl-blog-page .fl-page-content,body.rl-blog-page .fl-content,body.rl-blog-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-blog .hero{padding-bottom:clamp(20px,3vw,36px)}
.rl-blog .hero .lede{max-width:760px}
.rl-blog .cats{list-style:none;margin:26px 0 0;padding:0;display:flex;flex-wrap:wrap;gap:8px}
.rl-blog .cats a{display:inline-block;font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:7px 12px;transition:.15s}
.rl-blog .cats a:hover,.rl-blog .cats a[aria-current]{color:var(--ink);border-color:var(--red-2)}
/* hairlines drawn per card (not a grid background), so empty grid cells stay transparent when a row is not full */
.rl-blog .posts{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:clamp(16px,2vw,24px)} /* D-180: cards stand apart */
.rl-blog .post{background:var(--bg-2);display:flex;flex-direction:column;border:1px solid var(--line-2);transition:border-color .2s,transform .2s}
.rl-blog .post:hover{border-color:var(--red-line)}
.rl-blog .post .img{display:block;aspect-ratio:16/9;overflow:hidden;background:var(--panel);border-bottom:1px solid var(--line-2)}
.rl-blog .post .img.ph{position:relative;display:flex;flex-direction:column;justify-content:flex-end;gap:8px;padding:22px;background:radial-gradient(80% 90% at 85% 10%,rgba(153,0,0,.28),transparent 60%),linear-gradient(180deg,var(--panel),var(--bg-2));text-decoration:none}
.rl-blog .post .img.ph::before{content:"";position:absolute;left:22px;top:22px;width:44px;height:2px;background:var(--red-2)}
.rl-blog .post .img.ph b{font-family:var(--f-display);font-size:clamp(22px,2.2vw,28px);text-transform:uppercase;line-height:1.05;color:var(--ink)}
.rl-blog .post .img.ph span{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-blog .post .type{color:var(--ink)}
.rl-blog .cats .n{color:var(--ink-faint);margin-left:6px}
.rl-blog .more-cats{margin-top:8px}
.rl-blog .rv-strip{display:inline-flex;align-items:center;gap:14px;max-width:100%;margin-top:22px;padding:12px 16px;border:1px solid var(--red-line);background:rgba(153,0,0,.08);color:var(--ink);text-decoration:none;transition:background .2s}
.rl-blog .rv-strip:hover{background:rgba(153,0,0,.18)}
.rl-blog .rv-strip .k{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-blog .rv-strip .k{flex:none}.rl-blog .rv-strip .t{font-size:16px;min-width:0;line-height:1.4}.rl-blog .rv-strip .ar{flex:none}
.rl-blog .rv-strip .ar{color:var(--red-3)}
.rl-blog .more-cats summary{display:inline-flex;align-items:center;cursor:pointer;list-style:none;font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-dim);border:1px dashed var(--line-2);padding:7px 12px}
.rl-blog .more-cats summary::-webkit-details-marker{display:none}
.rl-blog .more-cats summary::after{content:"+";margin-left:8px;color:var(--red-3)}
.rl-blog .more-cats[open] summary::after{content:"\2212"}
.rl-blog .more-cats summary:hover{color:var(--ink);border-color:var(--red-2)}
.rl-blog .more-cats .cats{margin-top:8px}
.rl-blog .more-cats summary .n{color:var(--ink-faint);margin-left:6px}
.rl-blog .post .img img{width:100%;height:100%;object-fit:cover;display:block}
.rl-blog .post .body{padding:22px;display:flex;flex-direction:column;gap:10px;flex:1}
.rl-blog .post .meta{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-blog .post .meta a{color:var(--red-3);text-decoration:underline;text-decoration-color:var(--red-line);text-underline-offset:3px} /* D-180: told apart from the type label by more than colour (WCAG 1.4.1) */
.rl-blog .post h2{font-size:21px;line-height:1.15;margin:0}
.rl-blog .post h2 a{color:var(--ink)}
.rl-blog .post h2 a:hover{color:var(--red-3)}
.rl-blog .post p{color:var(--ink-dim);font-size:16px;margin:0}
.rl-blog .post .more{margin-top:auto}
.rl-blog .empty{border:1px solid var(--line-2);background:var(--panel);padding:clamp(26px,4vw,44px);max-width:760px}
.rl-blog .empty h2{margin:0 0 10px}
.rl-blog .empty p{color:var(--ink-dim);margin:0 0 18px}
.rl-blog .pager{margin-top:32px}
.rl-blog .pager .nav-links{display:flex;flex-wrap:wrap;gap:6px}
.rl-blog .pager .page-numbers{display:inline-block;min-width:42px;text-align:center;font-family:var(--f-mono);font-size:13px;padding:10px 12px;border:1px solid var(--line-2);color:var(--ink-dim)}
.rl-blog .pager .page-numbers.current{border-color:var(--red-2);color:var(--ink);background:rgba(153,0,0,.12)}
.rl-blog .pager a.page-numbers:hover{border-color:var(--red-2);color:var(--ink)}
.rl-blog .pager .screen-reader-text{position:absolute;left:-9999px}
@media(max-width:1000px){.rl-blog .posts{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:560px){.rl-blog .posts{grid-template-columns:minmax(0,1fr)}}
/* D-319 magazine sections (blog page 1 only). Read-only fixed-count lists; the paginated list below stays the one main loop (F-001). */
.rl-blog .mag-sec{padding:clamp(30px,4.5vw,56px) 0;border-top:1px solid var(--line-2)}
.rl-blog .mag-sec.alt{background:var(--bg-2)}
.rl-blog .mag-sh{display:flex;justify-content:space-between;align-items:flex-end;gap:18px;flex-wrap:wrap;margin-bottom:24px;padding-bottom:14px;border-bottom:2px solid var(--red-2)}
.rl-blog .mag-sh h2{margin:0;font-size:clamp(28px,3.2vw,42px)}
.rl-blog .mag-sh p{margin:6px 0 0;color:var(--ink-dim);max-width:640px}
.rl-blog .mag-sh .all{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-blog .mag-g3,.rl-blog .mag-g4{list-style:none;margin:0;padding:0;display:grid;gap:clamp(16px,2vw,24px)}
.rl-blog .mag-g3{grid-template-columns:repeat(3,minmax(0,1fr))}.rl-blog .mag-g4{grid-template-columns:repeat(4,minmax(0,1fr))}
.rl-blog .mag-feat{display:grid;grid-template-columns:1.35fr 1fr;gap:clamp(16px,2vw,24px)}
.rl-blog .mag-feat{align-items:stretch}
.rl-blog .mag-feat>.posts{display:grid;grid-auto-rows:1fr;margin:0}
.rl-blog .mag-feat>.posts>li{height:100%}
.rl-blog .mag-stack{list-style:none;margin:0;padding:0;display:grid;gap:14px;grid-auto-rows:1fr;align-content:stretch}
.rl-blog .mag-stack li{display:grid;grid-template-columns:190px minmax(0,1fr);gap:16px;align-items:center;background:var(--bg-2);border:1px solid var(--line-2)}
.rl-blog .mag-stack .img{aspect-ratio:16/9;border:0}
.rl-blog .mag-stack .body{padding:12px 16px 12px 0;gap:6px}
.rl-blog .mag-stack h3{font-size:18px;line-height:1.15;margin:0}
.rl-blog .mag-stack h3 a,.rl-blog .post h3 a{color:var(--ink)}
.rl-blog .post h3{font-size:20px;line-height:1.15;margin:0}
.rl-blog .post.big h3{font-size:clamp(24px,2.5vw,34px)}
.rl-blog .mag-all{padding-top:clamp(30px,4.5vw,56px)}
@media(max-width:1000px){.rl-blog .mag-g4,.rl-blog .mag-g3{grid-template-columns:repeat(2,minmax(0,1fr))}.rl-blog .mag-feat{grid-template-columns:1fr}}
@media(max-width:600px){.rl-blog .mag-g3,.rl-blog .mag-g4{grid-template-columns:minmax(0,1fr)}.rl-blog .mag-stack li{grid-template-columns:120px minmax(0,1fr)}}
</style>
<?php }


/* D-180: the filter row lists main categories only (the category each post is filed under, D-179), busiest first,
   instead of every production category. */
function rl_blog_main_cats() {
    $n = [];
    foreach (get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids', 'no_found_rows' => true]) as $pid) {
        $c = function_exists('rl_post_main_cat') ? rl_post_main_cat($pid) : null;
        if ($c && (int) $c->term_id !== (int) get_option('default_category')) { $n[$c->term_id] = ($n[$c->term_id] ?? 0) + 1; }
    }
    arsort($n);
    $out = [];
    foreach ($n as $tid => $count) {
        if (function_exists('rl_cat_archive_retired') && rl_cat_archive_retired($tid)) continue;  // its archive redirects: no chip (A4 link scan)
        $t = get_term($tid, 'category'); if ($t && !is_wp_error($t)) $out[] = [$t, $count];
    }
    return $out;
}

/* Pagination links never carry tracking parameters (utm_*, fbclid, gclid and the like). WordPress copies the current
   query string into "page 2" links, and LiteSpeed ignores these parameters when it caches, so one visit from a
   newsletter link would otherwise put "?utm_source=..." links into the cached page every visitor and crawler sees.
   Other parameters (for example ?s= on search results) are kept. */
add_filter('paginate_links', function ($link) {
    $q = (string) wp_parse_url($link, PHP_URL_QUERY);
    if ($q === '') return $link;
    parse_str($q, $args);
    $drop = array_values(array_filter(array_keys($args), function ($k) { return (bool) preg_match('/^(utm_[a-z_]*|fbclid|gclid|gbraid|wbraid|msclkid|_ga|_gl|mc_cid|mc_eid|nc)$/i', $k); }));
    return $drop ? remove_query_arg($drop, $link) : $link;
});

/* D-180: 12 per page on the blog and its category archives (3 columns x 4 rows, or 2 x 6 on tablets). Main query only (F-001). */
add_action('pre_get_posts', function ($q) {
    if (!is_admin() && $q->is_main_query() && ($q->is_home() || $q->is_category() || $q->is_tag())) $q->set('posts_per_page', 12);
});

/* ---------- headings per archive type (each archive gets its own H1 and intro, never a shared text block) ---------- */
function rl_blog_heading() {
    if (is_category() || is_tag()) {
        $t = get_queried_object();
        $desc = trim(wp_strip_all_tags(term_description($t)));
        return [is_category() ? 'Category' : 'Tag', [$t->name], $desc !== '' ? $desc : 'Articles from Reinforce Lab about ' . $t->name . '.'];
    }
    if (is_author()) {
        $a = get_queried_object();
        $bio = trim(wp_strip_all_tags(get_the_author_meta('description', $a->ID)));
        return ['Author', [$a->display_name], $bio !== '' ? $bio : 'Articles by ' . $a->display_name . ' at Reinforce Lab.'];
    }
    if (is_date()) {
        $label = is_day() ? get_the_date('j F Y') : (is_month() ? get_the_date('F Y') : get_the_date('Y'));
        return ['Archive', ['Articles from', $label], 'Everything Reinforce Lab published in ' . $label . '.'];
    }
    return ['Blog', ['Insights on AI', 'growth systems', '<r>and search.</r>'], '<strong>The Reinforce Lab blog</strong> covers SEO, AI search, content systems and automation: practical articles for growth-stage founders and B2B teams who want search to drive revenue.'];
}

/* D-319: magazine sections on page 1 of /blog/. Order set by Jamil (16 Nov 2026): AI, SEO, Marketing, Content, Reviews, Hosting.
   Each section lists posts whose MAIN category (D-179) is that category, newest first, no post twice, at least 3 or the section is skipped. */
function rl_mag_card($p, $big = false) {
    $id = $p->ID; $cat = function_exists('rl_post_main_cat') ? rl_post_main_cat($id) : null;
    $pdx = function_exists('rl_post_data') ? rl_post_data($id) : array();
    $pdate = !empty($pdx['updated']) ? 'Updated ' . date_i18n('j M Y', strtotime($pdx['updated'])) : get_the_date('j M Y', $id);
    $tl = !empty($pdx['type_label']) ? $pdx['type_label'] : '';
    $link = get_permalink($id); $cname = $cat ? $cat->name : 'Reinforce Lab';
    ob_start(); ?>
<li class="post<?php echo $big ? ' big' : ''; ?>">
  <?php if (has_post_thumbnail($id)) { ?><a class="img" href="<?php echo esc_url($link); ?>" tabindex="-1" aria-hidden="true"><?php echo get_the_post_thumbnail($id, 'medium_large', array('loading' => 'lazy', 'alt' => '')); ?></a><?php }
  else { ?><a class="img ph" href="<?php echo esc_url($link); ?>" tabindex="-1" aria-hidden="true"><span><?php echo esc_html($tl ?: 'Article'); ?></span><b><?php echo esc_html($cname); ?></b></a><?php } ?>
  <div class="body">
    <span class="meta"><?php if ($tl) echo '<span class="type">' . esc_html($tl) . '</span> · '; ?><time datetime="<?php echo esc_attr(!empty($pdx['updated']) ? $pdx['updated'] : get_the_date('c', $id)); ?>"><?php echo esc_html($pdate); ?></time></span>
    <h3><a href="<?php echo esc_url($link); ?>"><?php echo esc_html(get_the_title($id)); ?></a></h3>
    <?php if ($big) { ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt($id), 30)); ?></p><?php } ?>
  </div>
</li>
<?php return ob_get_clean();
}
function rl_blog_magazine() {
    $secs = array(
        array('ai-growth-systems', 'AI Growth Systems', 'How AI, content and search visibility work together as one growth engine.', 'feat', 5),
        array('search-engine-optimization', 'SEO', 'Technical SEO, content and zero-click search.', 'g3', 3),
        array('digital-marketing', 'Marketing', 'Digital marketing strategy, channels and industry guides.', 'g3', 3),
        array('content-marketing', 'Content', 'Content ideas, writing and social media for small business.', 'g3', 3),
        array('review-articles', 'Reviews', 'Reviews of SEO, content and WordPress tools and hosts.', 'g4', 4),
        array('web-hosting', 'Hosting', 'WordPress hosting guides, comparisons and deals.', 'g4', 4),
    );
    $shown = array(); $i = 0;
    foreach ($secs as $s) {
        list($slug, $title, $sub, $layout, $cnt) = $s;
        $term = get_term_by('slug', $slug, 'category'); if (!$term || is_wp_error($term)) continue;
        $pool = get_posts(array('category' => $term->term_id, 'numberposts' => 60, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC', 'no_found_rows' => true));
        $pick = array();
        foreach ($pool as $p) {
            if (in_array($p->ID, $shown, true)) continue;
            $mc = function_exists('rl_post_main_cat') ? rl_post_main_cat($p->ID) : null;
            if (!$mc || (int) $mc->term_id !== (int) $term->term_id) continue;
            $pick[] = $p; if (count($pick) >= $cnt) break;
        }
        if (count($pick) < 3) continue;
        foreach ($pick as $p) $shown[] = $p->ID;
        $i++; $alt = ($i % 2 === 0) ? ' alt' : '';
        $all = ($slug === 'review-articles' && function_exists('rl_url_by_path') && rl_url_by_path('reviews', '')) ? array(rl_url_by_path('reviews', ''), 'Reviews hub') : array(get_category_link($term), 'All ' . $title . ' articles');
        echo '<section class="mag-sec' . $alt . '" id="sec-' . esc_attr($slug) . '"><div class="wrap"><header class="mag-sh"><div><span class="ey"><b>[</b>&nbsp;' . sprintf('%02d', $i) . '&nbsp;<b>]</b></span><h2>' . esc_html($title) . '</h2><p>' . esc_html($sub) . '</p></div><a class="all" href="' . esc_url($all[0]) . '">' . esc_html($all[1]) . ' &rarr;</a></header>';
        if ($layout === 'feat') {
            echo '<div class="mag-feat"><ul class="posts" style="grid-template-columns:1fr">' . rl_mag_card($pick[0], true) . '</ul><ul class="mag-stack">';
            foreach (array_slice($pick, 1) as $p) echo rl_mag_card($p);
            echo '</ul></div>';
        } else {
            echo '<ul class="' . ($layout === 'g4' ? 'mag-g4' : 'mag-g3') . ' posts">';
            foreach ($pick as $p) echo rl_mag_card($p);
            echo '</ul>';
        }
        echo '</div></section>';
    }
    return $i;
}

/* ---------- render: one loop, the main query, core pagination ---------- */
add_action('template_redirect', 'rl_blog_render', 99);
function rl_blog_render() {
    if (!rl_is_blog_archive() || is_404() || is_feed()) return;
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    [$kind, $h1, $lede] = rl_blog_heading();
    $blog = (int) get_option('page_for_posts');
    $blog_url = $blog ? get_permalink($blog) : home_url('/');
    $paged = max(1, (int) get_query_var('paged'));
    get_header(); ?>
<div class="rl-page rl-blog">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <?php if (is_home()) { ?>
  <li><span aria-current="page">Blog</span></li>
  <?php } else { ?>
  <li><a href="<?php echo esc_url($blog_url); ?>">Blog</a></li>
  <li><span aria-current="page"><?php echo esc_html(wp_strip_all_tags(implode(' ', $h1))); ?></span></li>
  <?php } ?>
</ol></nav>

<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;<?php echo esc_html($kind); ?><?php if ($paged > 1) echo ' · Page ' . (int) $paged; ?>&nbsp;<b>]</b></span>
    <h1 class="h1"><?php echo implode('<br>', array_map(function ($l) { return strpos($l, '<r>') === 0 ? '<span class="r">' . esc_html(wp_strip_all_tags($l)) . '</span>' : esc_html($l); }, $h1)); ?></h1>
    <p class="lede"><?php echo is_home() ? wp_kses($lede, ['strong' => []]) : esc_html($lede); ?></p>
    <?php
    $cats = rl_blog_main_cats();
    if ($cats) {
        $cur = is_category() ? get_queried_object_id() : 0;
        echo '<ul class="cats" aria-label="Categories"><li><a href="' . esc_url($blog_url) . '"' . (is_home() ? ' aria-current="page"' : '') . '>All<span class="n">' . (int) wp_count_posts('post')->publish . '</span></a></li>';
        $chip = function ($c) use ($cur) { return '<li><a href="' . esc_url(get_category_link($c[0])) . '"' . ($cur === $c[0]->term_id ? ' aria-current="page"' : '') . '>' . esc_html($c[0]->name) . '<span class="n">' . (int) $c[1] . '</span></a></li>'; };
        $main = array_filter($cats, function ($c) use ($cur) { return $c[1] >= 3 || $c[0]->term_id === $cur; });
        $more = array_filter($cats, function ($c) use ($main) { return !in_array($c, $main, true); });
        foreach ($main as $c) echo $chip($c);
        echo '</ul>';
        if ($more) { echo '<details class="more-cats"><summary>More topics<span class="n">' . count($more) . '</span></summary><ul class="cats">'; foreach ($more as $c) echo $chip($c); echo '</ul></details>'; }
    }
    $rv = function_exists('rl_url_by_path') ? rl_url_by_path('reviews', '') : ''; /* D-192: the reviews hub, linked from the blog */
    if ($rv) { ?><a class="rv-strip" href="<?php echo esc_url($rv); ?>"><span class="k">Reviews</span><span class="t">WordPress hosting and SEO tool reviews, in one place</span><span class="ar" aria-hidden="true">&rarr;</span></a><?php } ?>
  </div>
</section>

<?php $mag = (is_home() && $paged === 1) ? rl_blog_magazine() : 0; ?>
<section class="band alt<?php echo $mag ? ' mag-all' : ''; ?>" id="articles">
  <div class="wrap">
    <?php if ($mag) { ?><header class="mag-sh"><div><h2>All articles</h2><p>Every article, newest first.</p></div></header><?php } ?>
    <?php if (have_posts()) { ?>
    <ul class="posts">
      <?php while (have_posts()) { the_post();
          $cat = function_exists('rl_post_main_cat') ? rl_post_main_cat(get_the_ID()) : null; /* D-179 */ ?>
      <li class="post">
        <?php $pdx = function_exists('rl_post_data') ? rl_post_data(get_the_ID()) : array(); $tl = !empty($pdx['type_label']) ? $pdx['type_label'] : '';
          $pdate = !empty($pdx['updated']) ? 'Updated ' . date_i18n('j M Y', strtotime($pdx['updated'])) : get_the_date('j M Y'); /* last-updated date when set */
          if (has_post_thumbnail()) { ?><a class="img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'alt' => '']); ?></a><?php }
          else { ?><a class="img ph" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><span><?php echo esc_html($tl ?: 'Article'); ?></span><b><?php echo esc_html($cat && (int) $cat->term_id !== (int) get_option('default_category') ? $cat->name : 'Reinforce Lab'); ?></b></a><?php } ?>
        <div class="body">
          <span class="meta"><?php if ($tl) echo '<span class="type">' . esc_html($tl) . '</span> · '; ?><time datetime="<?php echo esc_attr(!empty($pdx['updated']) ? $pdx['updated'] : get_the_date('c')); ?>"><?php echo esc_html($pdate); ?></time><?php if ($cat && (int) $cat->term_id !== (int) get_option('default_category')) echo ' · <a href="' . esc_url(get_category_link($cat)) . '">' . esc_html($cat->name) . '</a>'; ?></span>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
          <a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read article: ' . get_the_title()); ?>">Read article &rarr;</a>
        </div>
      </li>
      <?php } ?>
    </ul>
    <?php
      // F-001: core pagination on the main query → /blog/page/N/ only. Never a Beaver Builder Posts module.
      the_posts_pagination(['class' => 'pager', 'mid_size' => 1, 'prev_text' => '&larr; Newer', 'next_text' => 'Older &rarr;', 'screen_reader_text' => 'Blog pages']);
    } else { ?>
    <div class="empty">
      <h2>No articles here yet.</h2>
      <p>New articles are on the way. Meanwhile, see how an AI Growth System works or get a free review of your own search visibility.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $u('search-authority-diagnostic'); ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services'); ?>">All services</a>
      </div>
    </div>
    <?php } ?>
  </div>
</section>

</div>
<?php
    get_footer();
    exit;
}
