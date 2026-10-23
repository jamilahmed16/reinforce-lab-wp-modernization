<?php
/**
 * Plugin Name: Reinforce Lab
 * Description: Loads the Reinforce Lab site code from wp-content/novamira-sandbox/ (same folder and asset addresses as on reinforcelab.online). Replaces the Novamira plugin, which must never run on the live site (Rule 1). Installed by claude/rebuild/rebuild.sh.
 */
if (!defined('ABSPATH')) exit;
$rl_loader = WP_CONTENT_DIR . '/novamira-sandbox/reinforce-loader.php';
if (is_readable($rl_loader)) {
    require_once $rl_loader;
} elseif (function_exists('error_log')) {
    error_log('Reinforce Lab: site code missing at ' . $rl_loader);
}
