<?php
/**
 * Plugin Name: Reinforce Lab - Entity signals (Organization profiles, contact point, llms.txt)
 * Description: Site-wide entity data for search engines and LLMs (D-117, fixes from F-025). Adds verified directory profiles as Organization sameAs and a contactPoint for each office; serves /llms.txt from the live pages (Yoast's generated file had empty links and is switched off).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* Directory profiles verified in F-023; LinkedIn, Crunchbase, Facebook and Instagram from Jamil (5 Oct, D-118). */
function rl_entity_profiles() {
    return [
        'https://www.linkedin.com/company/reinforcelabltd/',
        'https://www.crunchbase.com/organization/reinforce-lab',
        'https://www.facebook.com/reinforcelabltd/',
        'https://www.instagram.com/reinforcelabltd/',
        'https://clutch.co/profile/reinforce-lab',
        'https://www.goodfirms.co/company/reinforce-lab-limited',
        'https://www.designrush.com/agency/profile/reinforce-lab-ltd',
        'https://hackernoon.com/company/reinforcelablimited',
        'https://agencies.semrush.com/reinforce-lab-ltd',
    ];
}

add_filter('wpseo_schema_organization', function ($data) {
    if (!is_array($data)) return $data;
    $data['sameAs'] = array_values(array_unique(array_merge(isset($data['sameAs']) ? (array) $data['sameAs'] : [], rl_entity_profiles())));
    $data['email'] = 'hello@reinforcelab.com';
    /* company registration, from the RJSC Certificate of Incorporation (D-128) */
    $data['identifier'] = ['@type' => 'PropertyValue', 'propertyID' => 'RJSC company registration number (Bangladesh)', 'value' => 'C-180618/2022'];
    $data['address'] = ['@type' => 'PostalAddress', 'streetAddress' => 'Suite #1402, Level-13, Concord Tower, 113 Kazi Nazrul Islam Avenue', 'addressLocality' => 'Dhaka', 'postalCode' => '1000', 'addressCountry' => 'BD'];
    $data['contactPoint'] = [
        ['@type' => 'ContactPoint', 'contactType' => 'sales', 'email' => 'hello@reinforcelab.com', 'telephone' => '+880-1329-657096', 'areaServed' => 'BD'],
        ['@type' => 'ContactPoint', 'contactType' => 'sales', 'email' => 'hello@reinforcelab.com', 'telephone' => '+1-832-548-4553', 'areaServed' => 'US'],
    ];
    return $data;
}, 20);

/* ---------- /llms.txt (llmstxt.org format), built from the live pages so links never go stale ---------- */
function rl_llms_txt() {
    $line = function ($path) {
        $p = get_page_by_path($path);
        if (!$p || $p->post_status !== 'publish') return '';
        $d = html_entity_decode(trim((string) get_post_meta($p->ID, '_yoast_wpseo_metadesc', true)), ENT_QUOTES, 'UTF-8');
        return '- [' . html_entity_decode(get_the_title($p), ENT_QUOTES, 'UTF-8') . '](' . get_permalink($p) . ')' . ($d !== '' ? ': ' . $d : '') . "\n";
    };
    $sec = function ($title, $paths) use ($line) { $s = ''; foreach ($paths as $p) $s .= $line($p); return $s !== '' ? "\n## $title\n\n" . $s : ''; };
    $children = function ($parent, $skip = []) {
        $pp = get_page_by_path($parent); if (!$pp) return [];
        $kids = get_pages(['parent' => $pp->ID, 'post_status' => 'publish', 'sort_column' => 'menu_order,post_title']);
        $out = []; foreach ($kids as $k) { $path = $parent . '/' . $k->post_name; if (!in_array($path, $skip, true)) $out[] = $path; }
        return $out;
    };
    $home = get_post((int) get_option('page_on_front'));
    $t = "# Reinforce Lab\n\n";
    $t .= "> Reinforce Lab builds AI Growth Systems: a company's website, content and organic search visibility connected into one growth engine, with AI automation doing the repetitive work and people reviewing what matters. Search Authority OS is its flagship.\n\n";
    $t .= "- Legal name: Reinforce Lab Limited, founded in Dhaka, Bangladesh on 19 April 2022 (RJSC registration no. C-180618/2022). The business started in Tallinn, Estonia, in 2020 and expanded to Bangladesh in 2021\n";
    $t .= "- Founder and CEO: Jamil Ahmed, pharmacist, SEO and AI search consultant, Semrush Ambassador\n";
    $t .= "- Offices: Dhaka, Bangladesh, and Katy, Texas, USA; clients worldwide\n";
    $t .= "- Contact: hello@reinforcelab.com, +880 1329-657096, +1 832 548 4553\n";
    $t .= "- Industries: Pharmaceutical & Life Sciences, Healthcare, B2B SaaS, E-commerce, Manufacturing, Technology, Professional Services, Education\n";
    $t .= "\n## Company\n\n" . ($home ? '- [Home](' . home_url('/') . '): ' . trim((string) get_post_meta($home->ID, '_yoast_wpseo_metadesc', true)) . "\n" : '') . $line('about-us') . $line('awards') . $line('portfolio') . $line('clients') . $line('contact-us');
    $proj = get_posts(['post_type' => 'rl_project', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC']);
    if ($proj) { $t .= "\n## Portfolio projects\n\n"; foreach ($proj as $pp) { $d = html_entity_decode(trim((string) get_post_meta($pp->ID, '_yoast_wpseo_metadesc', true)), ENT_QUOTES, 'UTF-8'); $t .= '- [' . html_entity_decode(get_the_title($pp), ENT_QUOTES, 'UTF-8') . '](' . get_permalink($pp) . ')' . ($d !== '' ? ': ' . $d : '') . "\n"; } }
    $t .= $sec('Search Authority OS', ['search-authority-os', 'packages', 'search-authority-diagnostic', 'services/agents']);
    $t .= $sec('Services', array_merge(['services'], $children('services', ['services/agents'])));
    $t .= $sec('Industries', array_merge(['industries'], $children('industries')));
    $t .= $sec('Optional', array_merge($children('services/agents'), ['blog', 'privacy-policy', 'terms-conditions', 'ftc-disclosure']));
    if (($coi = get_option('rl_coi_attachment')) && ($cu = wp_get_attachment_url($coi))) $t .= '- [Certificate of Incorporation](' . $cu . '): Reinforce Lab Limited, RJSC registration no. C-180618/2022, 19 April 2022 (PDF)' . "\n";
    return $t;
}
add_action('parse_request', function () {
    $uri = isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '';
    if ($uri !== '/llms.txt') return;
    status_header(200);
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Robots-Tag: noindex');
    echo rl_llms_txt();
    exit;
}, 0);
