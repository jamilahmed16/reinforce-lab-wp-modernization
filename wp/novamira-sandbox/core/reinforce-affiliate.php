<?php
/**
 * Plugin Name: Reinforce Lab - Affiliate link disclosure
 * Description: Labels affiliate links in post and page content automatically (D-122): rel="sponsored nofollow" (Google), an "Ad" label next to each link (UK ASA, FTC: disclosure next to the link), and a note at the top naming the partner with a link to /ftc-disclosure/. Partners: Semrush and WP Engine (Jamil, 5 Oct). Editors can also mark any link as affiliate with rel="sponsored" or class "aff".
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* Affiliate URL formats. Ordinary links to semrush.com or wpengine.com (citations) are NOT affiliate links.
   [CONFIRM with Jamil's real affiliate links and add their formats here.] */
function rl_aff_partner($url) {
    $u = wp_parse_url(html_entity_decode($url));
    if (empty($u['host'])) return '';
    $h = strtolower($u['host']); $q = isset($u['query']) ? strtolower($u['query']) : ''; $p = isset($u['path']) ? strtolower($u['path']) : '';
    if ($h === 'semrush.sjv.io' || (preg_match('/(^|\.)semrush\.com$/', $h) && preg_match('/(^|&)(ref|irclickid|irgwc|aff|affcode)=/', $q))) return 'Semrush';
    if ($h === 'wpengine.sjv.io' || (preg_match('/(^|\.)wpengine\.com$/', $h) && (preg_match('/(^|&)(w_agcid|irclickid|irgwc|ref|aff)=/', $q) || strpos($p, 'partnerspecialoffer') !== false))) return 'WP Engine';
    return '';
}

function rl_aff_label() { return ' <span class="rl-ad" title="Affiliate link: we earn a commission if you buy">Ad</span>'; }
function rl_aff_names($names) {
    $names = array_values(array_unique($names));
    if (count($names) < 2) return implode('', $names);
    return implode(', ', array_slice($names, 0, -1)) . ' and ' . end($names);
}
function rl_aff_note($names) {
    $who = $names ? rl_aff_names($names) : 'our partners';
    return '<p class="rl-adnote"><b>Ad:</b> this page contains affiliate links to ' . esc_html($who) . ', each marked "Ad". If you buy through them we earn a commission, at no extra cost to you. It does not change what we recommend. <a href="' . esc_url(home_url('/ftc-disclosure/')) . '">How we handle affiliate links</a>.</p>';
}

add_filter('the_content', function ($html) {
    if (!is_singular() || is_admin() || strpos($html, '<a ') === false) return $html;
    $names = [];
    $html = preg_replace_callback('#<a\s([^>]*)>(.*?)</a>#is', function ($m) use (&$names) {
        $attrs = $m[1];
        if (!preg_match('#href=("|\')(.*?)\1#i', $attrs, $hm)) return $m[0];
        $partner = rl_aff_partner($hm[2]);
        $manual = preg_match('#rel=("|\')[^"\']*sponsored#i', $attrs) || preg_match('#class=("|\')[^"\']*\baff\b#i', $attrs);
        if ($partner === '' && !$manual) return $m[0];
        if ($partner === '') { $h = wp_parse_url($hm[2], PHP_URL_HOST); $partner = $h ? preg_replace('/^www\./', '', $h) : ''; }
        if ($partner !== '') $names[] = $partner;
        if (preg_match('#rel=("|\')(.*?)\1#i', $attrs, $rm)) {
            $rel = array_unique(array_merge(preg_split('/\s+/', trim($rm[2])), ['sponsored', 'nofollow', 'noopener']));
            $attrs = str_replace($rm[0], 'rel="' . esc_attr(implode(' ', array_filter($rel))) . '"', $attrs);
        } else {
            $attrs .= ' rel="sponsored nofollow noopener"';
        }
        return '<a ' . $attrs . '>' . $m[2] . '</a>' . rl_aff_label();
    }, $html);
    if ($names) $html = rl_aff_note($names) . $html;
    return $html;
}, 20);

add_action('wp_head', function () {
    if (!is_singular()) return; ?>
<style id="rl-aff-css">
.rl-ad{display:inline-block;margin-left:4px;padding:0 5px;border:1px solid var(--red-line,rgba(226,59,59,.35));font-family:var(--f-mono,monospace);font-size:10.5px;line-height:1.6;letter-spacing:.1em;text-transform:uppercase;color:var(--red-3,#e23b3b);vertical-align:middle}
.rl-adnote{border:1px solid var(--red-line,rgba(226,59,59,.35));background:rgba(153,0,0,.08);padding:12px 14px;font-size:14.5px;color:var(--ink-dim,#b9b0a8);margin:0 0 22px}
.rl-adnote b{color:var(--red-3,#e23b3b)}.rl-adnote a{color:var(--ink,#f3ede6)}
</style>
<?php }, 23);
