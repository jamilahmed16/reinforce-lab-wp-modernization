<?php
/**
 * Plugin Name: Reinforce Lab - page speed
 * Description: Removes theme and plugin files a page does not use (D-166). The home page is built entirely by [reinforce_home] with its own header, footer and vanilla JavaScript, so the Beaver Builder theme's jQuery stack, Font Awesome (only used by the hidden BB header search icon), PowerPack's animate.css and the lightbox are dead weight there; seven of them blocked the first paint on phones. Bootstrap CSS and the theme skin stay (the page wrappers use them). Pages opt in through the rl_lean_page filter; home only for now.
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
