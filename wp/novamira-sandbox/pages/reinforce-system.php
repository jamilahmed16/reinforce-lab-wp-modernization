<?php
/**
 * Plugin Name: Reinforce Lab - 404 and search
 * Description: Kit-styled 404 page and search results (F-028 A8), replacing the Beaver Builder theme defaults (unstyled search box, "Recent Posts" and "Recent Comments" sidebar). The 404 (and 410) status is kept. Search matches titles, Yoast titles, meta descriptions and focus keyphrases as well as content, because most pages store only a shortcode in post_content. One list, no pagination (the site has under 100 items), so search never creates /page/N/ URLs. Search results stay noindex (Yoast default).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_system_page() { return !is_admin() && (is_404() || is_search()); }

add_filter('body_class', function ($c) { if (rl_is_system_page()) $c[] = 'rl-system-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_system_page(); });
add_filter('wpseo_robots', function ($r) { return is_search() ? 'noindex, follow' : $r; }, 20);

add_action('wp_head', function () {
    if (!rl_is_system_page()) return; ?>
<style id="rl-system-css">
body.rl-system-page .fl-page-content,body.rl-system-page .fl-content,body.rl-system-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-sys .hero .lede{max-width:680px}
.rl-sys .sform{display:flex;max-width:640px;margin-top:28px;border:1px solid var(--glass-line);background:var(--glass)}
.rl-sys .sform label{position:absolute;left:-9999px}
.rl-sys .sform input{flex:1;min-width:0;background:transparent;border:0;color:var(--ink);font:inherit;font-size:16px;padding:15px 18px;outline:none}
.rl-sys .sform input::placeholder{color:var(--ink-faint)}
.rl-sys .sform:focus-within{border-color:var(--red-line)}
.rl-sys .sform button{font-family:var(--f-display);text-transform:uppercase;font-weight:600;letter-spacing:.05em;font-size:14px;padding:0 24px;background:linear-gradient(180deg,#241a1c,#120e0f);color:#fff;border:0;border-left:1px solid var(--red-line);cursor:pointer}
.rl-sys .sform button:hover{color:var(--red-3)}
.rl-sys .count{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 18px}
.rl-sys .results{list-style:none;margin:0;padding:0;border-top:1px solid var(--line)}
.rl-sys .results li{border-bottom:1px solid var(--line)}
.rl-sys .results a{display:grid;grid-template-columns:120px minmax(0,1fr) auto;gap:6px 24px;align-items:baseline;padding:20px 4px}
.rl-sys .results .t{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-sys .results h2{font-size:21px;line-height:1.2;margin:0;color:var(--ink)}
.rl-sys .results p{grid-column:2;margin:0;color:var(--ink-dim);font-size:16px;max-width:75ch}
.rl-sys .results .go{grid-row:1;grid-column:3;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint)}
.rl-sys .results a:hover h2,.rl-sys .results a:hover .go{color:var(--red-3)}
@media(max-width:700px){.rl-sys .results a{grid-template-columns:1fr}.rl-sys .results p{grid-column:1}.rl-sys .results .go{display:none}}
.rl-sys .code{font-family:var(--f-display);font-size:clamp(90px,16vw,200px);line-height:.85;font-weight:700;color:transparent;-webkit-text-stroke:1px var(--red-line);letter-spacing:-.02em;margin:0;user-select:none}
.rl-sys .cell{display:flex;flex-direction:column;gap:8px}
</style>
<?php }, 22);

/* single source: the places a lost visitor most likely wanted */
function rl_system_links() {
    return [
        ['', 'Start', 'Home', 'What Reinforce Lab does and how an AI Growth System works.'],
        ['services', 'Services', 'All services', 'AI search, SEO, content systems, automation and web.'],
        ['search-authority-os', 'Flagship', 'Search Authority OS', 'The system that builds search authority month after month.'],
        ['blog', 'Articles', 'Blog', 'Plain explanations of AI search and AI growth systems.'],
        ['about-us', 'Company', 'About Reinforce Lab', 'Who we are, where we work and how we got here.'],
        ['contact-us', 'Talk to us', 'Contact', 'Email, phone or a message through the form.'],
    ];
}

/* search: titles, SEO titles, meta descriptions, focus keyphrases and content; scored, most relevant first */
function rl_system_search($q) {
    $terms = array_values(array_filter(preg_split('/\s+/', mb_strtolower(trim($q))), function ($t) { return mb_strlen($t) > 1; }));
    if (!$terms) return [];
    $posts = get_posts(['post_type' => ['page', 'post', 'rl_project'], 'post_status' => 'publish', 'numberposts' => 300, 'suppress_filters' => false]);
    $out = [];
    foreach ($posts as $p) {
        if (get_post_meta($p->ID, '_yoast_wpseo_meta-robots-noindex', true) === '1') continue; // pages kept out of search engines stay out of site search
        $title = mb_strtolower($p->post_title);
        $desc = (string) get_post_meta($p->ID, '_yoast_wpseo_metadesc', true);
        $meta = mb_strtolower($desc . ' ' . get_post_meta($p->ID, '_yoast_wpseo_title', true) . ' ' . get_post_meta($p->ID, '_yoast_wpseo_focuskw', true));
        $body = mb_strtolower(wp_strip_all_tags(preg_replace('/\[[^\]]*\]/', ' ', $p->post_content . ' ' . $p->post_excerpt)));
        $score = 0;
        foreach ($terms as $t) {
            $hit = 0;
            if (mb_strpos($title, $t) !== false) $hit += 6;
            if (mb_strpos($meta, $t) !== false) $hit += 3;
            if (mb_strpos($body, $t) !== false) $hit += 1;
            if (!$hit) { $score = 0; break; } // every term must match somewhere
            $score += $hit;
        }
        if ($score) $out[] = ['s' => $score, 'p' => $p, 'desc' => $desc !== '' ? $desc : wp_trim_words(wp_strip_all_tags($p->post_excerpt ?: $p->post_content), 28)];
    }
    usort($out, function ($a, $b) { return $b['s'] <=> $a['s'] ?: strcmp($a['p']->post_title, $b['p']->post_title); });
    return $out;
}

function rl_system_type($p) {
    if ($p->post_type === 'post') return 'Article';
    if ($p->post_type === 'rl_project') return 'Project';
    $path = trim(str_replace(home_url(), '', get_permalink($p)), '/');
    if (strpos($path, 'industries/') === 0) return 'Industry';
    if (strpos($path, 'services/agents/') === 0) return 'Agent';
    if (strpos($path, 'services/') === 0) return 'Service';
    return 'Page';
}

function rl_system_form($value = '') {
    return '<form class="sform" role="search" method="get" action="' . esc_url(home_url('/')) . '"><label for="rl-s">Search this site</label><input id="rl-s" type="search" name="s" value="' . esc_attr($value) . '" placeholder="Search services, industries and articles" autocomplete="off"><button type="submit">Search</button></form>';
}

add_action('template_redirect', 'rl_system_render', 98);
function rl_system_render() {
    if (!rl_is_system_page() || is_feed()) return;
    if (is_search() && get_query_var('paged') > 1) { wp_safe_redirect(add_query_arg('s', rawurlencode(get_search_query(false)), home_url('/')), 301); exit; }
    $u = function ($path) { return esc_url($path === '' ? home_url('/') : (function_exists('rl_url_by_path') ? rl_url_by_path($path, home_url('/' . $path . '/')) : home_url('/' . $path . '/'))); };
    $diag = $u('search-authority-diagnostic');
    $q = is_search() ? get_search_query(false) : '';
    $results = is_search() ? rl_system_search($q) : [];
    $gone = is_404() && http_response_code() === 410;
    get_header(); ?>
<div class="rl-page rl-sys">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page"><?php echo is_search() ? 'Search' : 'Page not found'; ?></span></li>
</ol></nav>

<?php if (is_404()) { ?>
<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;<?php echo $gone ? 'Error 410' : 'Error 404'; ?>&nbsp;<b>]</b></span>
      <h1 class="h1"><?php echo $gone ? 'This page has been<br><span class="r">removed.</span>' : 'This page<br>could not be<br><span class="r">found.</span>'; ?></h1>
      <p class="lede">The link may be old, or the address may have a typo. Search the site, or pick one of the pages below.</p>
      <?php echo rl_system_form(); ?>
    </div>
    <p class="code" aria-hidden="true"><?php echo $gone ? '410' : '404'; ?></p>
  </div>
</section>
<?php } else { ?>
<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;Search&nbsp;<b>]</b></span>
    <h1 class="h1"><?php echo $q !== '' ? 'Results for<br><span class="r">' . esc_html(mb_strimwidth($q, 0, 60, '...')) . '</span>' : 'Search<br><span class="r">this site.</span>'; ?></h1>
    <?php echo rl_system_form($q); ?>
  </div>
</section>

<section class="band alt" id="results">
  <div class="wrap">
    <?php if ($results) { ?>
    <p class="count"><?php echo count($results) === 1 ? '1 result' : count($results) . ' results'; ?></p>
    <ul class="results">
      <?php foreach ($results as $r) { $p = $r['p']; ?>
      <li><a href="<?php echo esc_url(get_permalink($p)); ?>"><span class="t"><?php echo esc_html(rl_system_type($p)); ?></span><h2><?php echo esc_html(get_the_title($p)); ?></h2><span class="go" aria-hidden="true">&rarr;</span><p><?php echo esc_html($r['desc']); ?></p></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <div class="head"><h2><?php echo $q !== '' ? 'Nothing matched that search.' : 'What are you looking for?'; ?></h2><p class="lede">Try a shorter or different word, such as "SEO", "AI search" or "healthcare", or start from one of these pages.</p></div>
    <?php } ?>
  </div>
</section>
<?php } ?>

<?php if (is_404() || !$results) { ?>
<section<?php echo is_404() ? ' class="band alt"' : ''; ?> id="popular">
  <div class="wrap">
    <?php if (is_404()) { ?><div class="head"><span class="ey"><b>[</b>&nbsp;Popular pages&nbsp;<b>]</b></span><h2>Where would you like to go?</h2></div><?php } ?>
    <div class="cols c3">
      <?php foreach (rl_system_links() as $l) { ?>
      <a class="cell" href="<?php echo $u($l[0]); ?>"><span class="n"><?php echo esc_html($l[1]); ?></span><h3><?php echo esc_html($l[2]); ?></h3><p><?php echo esc_html($l[3]); ?></p><span class="more">Open &rarr;</span></a>
      <?php } ?>
    </div>
  </div>
</section>
<?php } ?>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Not sure where to start?</h2>
      <p class="lede">The free Search Authority Diagnostic shows where you stand in Google and in AI answers, and what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('contact-us'); ?>">Talk to us</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    get_footer();
    exit;
}
