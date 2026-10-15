<?php
/**
 * Plugin Name: Reinforce Lab - Affiliate link disclosure
 * Description: Labels affiliate links in post and page content automatically (D-122): rel="sponsored nofollow" (Google), an "Ad" label next to each link (UK ASA, FTC: disclosure next to the link), and a note at the top naming the partner with a link to /ftc-disclosure/. Partners: Semrush and WP Engine (Jamil, 5 Oct). Editors can also mark any link as affiliate with rel="sponsored" or class "aff".
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* Affiliate URL formats. Ordinary links to semrush.com or wpengine.com (citations) are NOT affiliate links.
   D-194: also the referral formats found in the carried posts (Impact *.sjv.io and *.pxf.io, ShareASale, DreamHost aff_id,
   Rewardful ?via=, FirstPromoter ?fpr=, Bluehost clickid). Returns the partner's name, or '' for an ordinary link. */
function rl_aff_names_map() {
    return ['semrush' => 'Semrush', 'wpengine' => 'WP Engine', 'bluehost' => 'Bluehost', 'hostinger' => 'Hostinger', 'namecheap' => 'Namecheap', 'nexcess' => 'Nexcess',
        'digitalocean' => 'DigitalOcean', 'proranktracker' => 'Rank Tracker', 'dreamhost' => 'DreamHost', 'jasper' => 'Jasper', 'copy' => 'Copy.ai', 'writesonic' => 'Writesonic',
        'rytr' => 'Rytr', 'anyword' => 'Anyword', 'surferseo' => 'Surfer SEO', 'shareasale' => 'ShareASale', 'liquidweb' => 'Liquid Web'];
}
function rl_aff_partner($url) {
    $u = wp_parse_url(html_entity_decode($url));
    if (empty($u['host'])) return '';
    $h = strtolower($u['host']); $q = isset($u['query']) ? strtolower($u['query']) : ''; $p = isset($u['path']) ? strtolower($u['path']) : '';
    if ($h === 'semrush.sjv.io' || (preg_match('/(^|\.)semrush\.com$/', $h) && preg_match('/(^|&)(ref|irclickid|irgwc|aff|affcode)=/', $q))) return 'Semrush';
    if ($h === 'wpengine.sjv.io' || (preg_match('/(^|\.)wpengine\.com$/', $h) && (preg_match('/(^|&)(w_agcid|irclickid|irgwc|ref|aff)=/', $q) || strpos($p, 'partnerspecialoffer') !== false))) return 'WP Engine';
    $name = function ($label) { $m = rl_aff_names_map(); return isset($m[$label]) ? $m[$label] : ucfirst($label); };
    if (preg_match('/^([a-z0-9-]+)\.(sjv|pxf)\.io$/', $h, $hm)) return $name($hm[1]);              // Impact
    if (preg_match('/(^|\.)shareasale\.com$/', $h) && strpos($p, '/r.cfm') !== false) return 'ShareASale';
    if ($h === 'click.dreamhost.com' && preg_match('/(^|&)aff_id=/', $q)) return 'DreamHost';
    if (preg_match('/^([a-z0-9-]+)\.i3f2\.net$/', $h, $hm)) return $name($hm[1]);                    // Impact vanity domain (Liquid Web)
    if ($h === 'partners.inmotionhosting.com') return 'InMotion Hosting';
    if (preg_match('/(^|\.)kinsta\.com$/', $h) && preg_match('/(^|&)kaid=/', $q)) return 'Kinsta';
    if (preg_match('/(^|\.)cloudways\.com$/', $h) && preg_match('/(^|&)id=\d+/', $q)) return 'Cloudways';
    if (preg_match('/(^|&)(via|fpr)=[^&]+/', $q) || (preg_match('/(^|\.)bluehost\.com$/', $h) && preg_match('/(^|&)clickid=/', $q))) {
        $base = preg_replace('/^(www|click|go|app)\./', '', $h);
        return $name(explode('.', $base)[0]);
    }
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
        if (strpos($attrs, 'data-aff') !== false) { if (preg_match('#data-aff="([^"]+)"#', $attrs, $dm)) $names[] = $dm[1]; return $m[0]; } /* D-194: labelled already (a page showing another post's text) */
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
        return '<a ' . $attrs . ' data-aff="' . esc_attr($partner) . '">' . $m[2] . '</a>' . rl_aff_label();
    }, $html);
    if ($names && strpos($html, 'class="rl-adnote"') === false) $html = rl_aff_note($names) . $html; /* D-190: a page may place its own note */
    return $html;
}, 20);

add_action('wp_head', function () {
    if (!is_singular()) return; ?>
<style id="rl-aff-css">
.rl-ad{display:inline-block;margin-left:4px;padding:0 5px;border:1px solid var(--red-line,rgba(226,59,59,.35));font-family:var(--f-mono,monospace);font-size:12px;line-height:1.5;letter-spacing:.1em;text-transform:uppercase;color:var(--red-3,#e85050);vertical-align:middle}
.rl-adnote{border:1px solid var(--red-line,rgba(226,59,59,.35));background:rgba(153,0,0,.08);padding:12px 14px;font-size:14.5px;color:var(--ink-dim,#b9b0a8);margin:0 0 22px}
.rl-adnote b{color:var(--red-3,#e85050)}.rl-adnote a{color:var(--ink,#f3ede6)}
</style>
<?php }, 23);
