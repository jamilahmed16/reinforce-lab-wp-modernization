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
.rl-blog .cats a{display:inline-block;font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:7px 12px;transition:.15s}
.rl-blog .cats a:hover,.rl-blog .cats a[aria-current]{color:var(--ink);border-color:var(--red-2)}
/* hairlines drawn per card (not a grid background), so empty grid cells stay transparent when a row is not full */
.rl-blog .posts{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(3,1fr);gap:1px}
.rl-blog .post{background:var(--bg-2);display:flex;flex-direction:column;box-shadow:0 0 0 1px var(--line)}
.rl-blog .post .img{display:block;aspect-ratio:16/9;overflow:hidden;background:var(--panel)}
.rl-blog .post .img img{width:100%;height:100%;object-fit:cover;display:block}
.rl-blog .post .body{padding:22px;display:flex;flex-direction:column;gap:10px;flex:1}
.rl-blog .post .meta{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-blog .post .meta a{color:var(--red-3)}
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
@media(max-width:1000px){.rl-blog .posts{grid-template-columns:1fr 1fr}}
@media(max-width:560px){.rl-blog .posts{grid-template-columns:1fr}}
</style>
<?php }

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
    $cats = get_categories(['hide_empty' => true, 'exclude' => [(int) get_option('default_category')]]);
    if ($cats) {
        $cur = is_category() ? get_queried_object_id() : 0;
        echo '<ul class="cats" aria-label="Categories"><li><a href="' . esc_url($blog_url) . '"' . (is_home() ? ' aria-current="page"' : '') . '>All</a></li>';
        foreach ($cats as $c) echo '<li><a href="' . esc_url(get_category_link($c)) . '"' . ($cur === $c->term_id ? ' aria-current="page"' : '') . '>' . esc_html($c->name) . '</a></li>';
        echo '</ul>';
    } ?>
  </div>
</section>

<section class="band alt" id="articles">
  <div class="wrap">
    <?php if (have_posts()) { ?>
    <ul class="posts">
      <?php while (have_posts()) { the_post();
          $cat = get_the_category(); $cat = $cat ? $cat[0] : null; ?>
      <li class="post">
        <?php if (has_post_thumbnail()) { ?><a class="img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'alt' => '']); ?></a><?php } ?>
        <div class="body">
          <span class="meta"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j M Y')); ?></time><?php if ($cat && (int) $cat->term_id !== (int) get_option('default_category')) echo ' · <a href="' . esc_url(get_category_link($cat)) . '">' . esc_html($cat->name) . '</a>'; ?></span>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
          <a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read: ' . get_the_title()); ?>">Read article &rarr;</a>
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
