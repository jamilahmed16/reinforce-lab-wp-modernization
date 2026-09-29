<?php
/**
 * Plugin Name: Reinforce Lab — shared page kit
 * Description: Enqueues reinforce-kit.css (shared layout, typography, buttons, cards, FAQ, CTA) on pages that opt in via the rl_kit_active filter (D-044). One cached file instead of the same ~9 KB inlined on every page.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_kit_active() { return (bool) apply_filters('rl_kit_active', false); }

/* Printed at wp_head priority 21 — after the header's inline CSS (20) and before each page's own
   CSS (22) — so the cascade order is exactly what it was when these rules were inline in each page.
   (wp_enqueue_style would print at priority 8, letting header rules such as `.fl-page-content a` win.) */
add_action('wp_head', function () {
    if (!rl_kit_active()) return;
    $f = __DIR__ . '/reinforce-kit.css';
    $v = file_exists($f) ? substr(md5_file($f), 0, 8) : '0';
    echo '<link rel="stylesheet" id="rl-kit-css" href="' . esc_url(content_url('novamira-sandbox/reinforce-kit.css') . '?ver=' . $v) . '" media="all">' . "\n";
}, 21);
