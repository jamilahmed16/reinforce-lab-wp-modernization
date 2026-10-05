<?php
/**
 * Plugin Name: Reinforce Lab - Post type sections
 * Description: Shared lists and helpers for the article type designs (D-074, D-076): the services, industries and Product / Service subtypes, plus small row, date and box helpers. Every type except Opinion and Checklist (base only) has its own design file with its own fields, sections and schema (reinforce-post-guide.php, -howto.php, -list.php, -review.php, -comparison.php, -explainer.php, -industry.php, -updates.php, -casestudy.php, -research.php, -product.php).
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
        'services/website-maintenance-services' => 'Website Maintenance', 'services/ai-growth-systems' => 'AI Growth Systems', 'search-authority-os' => 'Search Authority OS',
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

function rl_pt_minutes_label($m) { $m = (int) round($m); if ($m < 60) return $m . ' minutes'; $h = intdiv($m, 60); $r = $m % 60; return $h . ' hour' . ($h > 1 ? 's' : '') . ($r ? ' ' . $r . ' minutes' : ''); }
