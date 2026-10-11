<?php
/**
 * Plugin Name: Reinforce Lab - page speed
 * Description: Removes theme and plugin files a page does not use (D-166). The home page is built entirely by [reinforce_home] with its own header, footer and vanilla JavaScript, so the Beaver Builder theme's jQuery stack, Font Awesome (only used by the hidden BB header search icon), PowerPack's animate.css and the lightbox are dead weight there; seven of them blocked the first paint on phones. Bootstrap CSS and the theme skin stay: removing them was tested and changes the layout (page wrappers and spacing use them). Pages opt in through the rl_lean_page filter: home (D-166), service and industry pages (D-172).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_lean_page() { return !is_admin() && !is_customize_preview() && (bool) apply_filters('rl_lean_page', is_front_page()); }

add_action('wp_enqueue_scripts', function () {
    if (!rl_lean_page() || (class_exists('FLBuilderModel') && FLBuilderModel::is_builder_active())) return;
    foreach (['font-awesome-5', 'pp-animate', 'jquery-magnificpopup'] as $h) { wp_dequeue_style($h); }
    foreach (['fl-automator', 'bootstrap-4', 'jquery-fitvids', 'jquery-magnificpopup', 'jquery-throttle'] as $h) { wp_dequeue_script($h); }
    /* jQuery only stays if something still on the page depends on it */
    $needs = false;
    foreach (wp_scripts()->queue as $h) {
        if ($h === 'jquery') continue;
        $s = wp_scripts()->registered[$h] ?? null;
        if ($s && array_intersect(['jquery', 'jquery-core', 'jquery-migrate'], (array) $s->deps)) { $needs = true; break; }
    }
    if (!$needs) { wp_dequeue_script('jquery'); wp_dequeue_script('jquery-core'); wp_dequeue_script('jquery-migrate'); }
}, 1000);

/* Font Awesome and animate.css are enqueued by the builder plugins after the hook above; drop their tags at print time */
add_filter('style_loader_tag', function ($tag, $handle) {
    return (rl_lean_page() && in_array($handle, ['font-awesome-5', 'font-awesome', 'pp-animate', 'jquery-magnificpopup'], true) && !(class_exists('FLBuilderModel') && FLBuilderModel::is_builder_active())) ? '' : $tag;
}, 10, 2);

/* LiteSpeed page cache (D-167): pages with a form stay uncached. Their anti-spam check prints the current time
   into the form ("submitted too fast" test), which a cached copy would freeze. The forms post to admin-post.php,
   which is never cached. */
add_action('template_redirect', function () {
    if (is_page(['contact-us', 'search-authority-diagnostic'])) do_action('litespeed_control_set_nocache', 'Reinforce Lab: page with a form (D-167)');
}, 0);

/* D-172: service and industry pages (shared .rl-page kit, built by shortcodes with our own header and footer) use none
   of the removed files either: no inline jQuery, no lightbox links, no animate.css classes, the only Font Awesome icon
   is the hidden theme search icon. The AI agents pages under /services/agents/ are left out (different layout, not tested). */
add_filter('rl_lean_page', function ($on) {
    if ($on || !is_page()) return $on;
    $u = get_page_uri();
    return (bool) preg_match('#^(services|industries)(/|$)#', $u) && strpos($u, 'services/agents') !== 0;
});

/* D-174: on lean pages the full Bootstrap 4 file (162 KB, about 97% unused, blocked the first paint) is replaced, at
   the same place in the page so the cascade order is unchanged, by an inline copy of only the rules these pages use
   (core/reinforce-bootstrap-lean.css, about 8 KB, built by claude/tools/bs-trim). Falls back to the normal link if
   the file is missing. */
add_filter('style_loader_tag', function ($tag, $handle) {
    if ($handle !== 'bootstrap-4' || !rl_lean_page() || (class_exists('FLBuilderModel') && FLBuilderModel::is_builder_active())) return $tag;
    $f = __DIR__ . '/reinforce-bootstrap-lean.css';
    if (!is_readable($f)) return $tag;
    return '<style id="bootstrap-4-lean">' . str_replace('</', '<\\/', file_get_contents($f)) . "</style>\n";
}, 10, 2);
