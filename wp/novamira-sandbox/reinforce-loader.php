<?php
/**
 * Plugin Name: Reinforce Lab - Loader
 * Description: The only top-level file in the Novamira sandbox. Novamira loads top-level *.php files only, so every Reinforce Lab file lives in a folder (core, pages, saos, services, industries, blog) and is loaded from the list below (D-080). The order is the order Novamira used before the reorganisation (alphabetical by file name), kept so hook registration order does not change. A new file must be added to this list or it will not load.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

foreach ([
    'pages/reinforce-about.php',
    'saos/reinforce-agent-pages.php',
    'saos/reinforce-agents.php',
    'services/reinforce-aiso.php',
    'services/reinforce-aiwork.php',
    'services/reinforce-audit.php',
    'services/reinforce-automation.php',
    'blog/reinforce-blog.php',
    'blog/reinforce-post-casestudy.php',
    'blog/reinforce-post-research.php',
    'blog/reinforce-post-product.php',
    'pages/reinforce-contact.php',
    'services/reinforce-content.php',
    'saos/reinforce-diagnostic.php',
    'services/reinforce-ecomdesign.php',
    'services/reinforce-enterprise.php',
    'services/reinforce-execai.php',
    'services/reinforce-geo.php',
    'core/reinforce-header.php',
    'pages/reinforce-home.php',
    'industries/reinforce-industries.php',
    'services/reinforce-intl.php',
    'core/reinforce-kit.php',
    'services/reinforce-leadgen.php',
    'services/reinforce-llm.php',
    'services/reinforce-local.php',
    'services/reinforce-maintenance.php',
    'saos/reinforce-packages.php',
    'blog/reinforce-post-comparison.php',
    'blog/reinforce-post-explainer.php',
    'blog/reinforce-post-guide.php',
    'blog/reinforce-post-howto.php',
    'blog/reinforce-post-industry.php',
    'blog/reinforce-post-list.php',
    'blog/reinforce-post-review.php',
    'blog/reinforce-post-types.php',
    'blog/reinforce-post-updates.php',
    'blog/reinforce-post.php',
    'services/reinforce-pr.php',
    'saos/reinforce-saos.php',
    'services/reinforce-seo.php',
    'services/reinforce-services.php',
    'services/reinforce-techseo.php',
    'services/reinforce-wpdesign.php',
] as $rl_file) {
    require_once __DIR__ . '/' . $rl_file;
}
unset($rl_file);
