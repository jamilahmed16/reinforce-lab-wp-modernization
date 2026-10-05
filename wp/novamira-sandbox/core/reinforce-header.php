<?php
/**
 * Plugin Name: Reinforce Lab - Header (Systems Grid)
 * Description: Site-wide square-glass header + mega-menu (D-018/D-021). Renders from the "Primary" nav menu and the site logo. Provides [reinforce_header]; also auto-renders at wp_body_open.
 * Version: 1.0
 * Author: Reinforce Lab
 */
if (!defined('ABSPATH')) exit;

/* ---------- assets ---------- */
/* fonts self-hosted (D-123): no request to Google Fonts (privacy, LG Munich 2022) and faster first paint.
   The sandbox folder only serves CSS and JS, so the woff2 files are copied to uploads/reinforce-fonts/
   (again whenever a file changes) and the @font-face rules are printed inline with those URLs. */
function rl_fonts_base() {
    static $base = null;
    if ($base !== null) return $base;
    $up = wp_upload_dir(null, false);
    $dir = trailingslashit($up['basedir']) . 'reinforce-fonts/';
    $src = __DIR__ . '/fonts/';
    if (!is_dir($dir)) wp_mkdir_p($dir);
    foreach ((array) glob($src . '*.woff2') as $f) {
        $to = $dir . basename($f);
        if (!file_exists($to) || filesize($to) !== filesize($f)) @copy($f, $to);
    }
    return $base = trailingslashit($up['baseurl']) . 'reinforce-fonts/';
}
add_action('wp_head', function () {
    $base = rl_fonts_base();
    foreach (['oswald-latin.woff2', 'ibm-plex-sans-latin.woff2'] as $f) echo '<link rel="preload" href="' . esc_url($base . $f) . '" as="font" type="font/woff2" crossorigin>' . "\n";
    $css = (string) @file_get_contents(__DIR__ . '/reinforce-fonts.css');
    $css = preg_replace('#/\*.*?\*/#s', '', $css);
    $css = preg_replace_callback('#url\(fonts/([a-z0-9\-]+\.woff2)\)#', function ($m) use ($base) { return 'url(' . esc_url($base . $m[1]) . ')'; }, $css);
    echo '<style id="rl-fonts">' . trim($css) . "</style>\n";
}, 1);
/* Beaver Builder: no Google Fonts stylesheet and no prefetch hints for it (the site fonts are local) */
add_filter('fl_builder_google_fonts_pre_enqueue', '__return_empty_array');
add_filter('fl_enable_google_fonts_enqueue', '__return_false');
add_filter('fl_builder_preload_google_fonts', '__return_false');
/* the theme's Customizer fonts still come through as an "fl-builder-google-fonts-*" stylesheet: never print it */
add_filter('style_loader_tag', function ($tag, $handle, $href) {
    return (strpos((string) $href, 'fonts.googleapis.com') !== false || strpos((string) $href, 'fonts.gstatic.com') !== false) ? '' : $tag;
}, 99, 3);
add_filter('wp_resource_hints', function ($urls) {
    return array_values(array_filter((array) $urls, function ($u) {
        $h = is_array($u) ? (isset($u['href']) ? $u['href'] : '') : $u;
        return strpos($h, 'fonts.googleapis.com') === false && strpos($h, 'fonts.gstatic.com') === false;
    }));
}, 99);

add_action('wp_head', 'rl_header_css', 20);
function rl_header_css() { ?>
<style id="rl-header-css">
:root{
  --bg:#121011;--bg-2:#171314;--panel:#1a1516;--line:#2c2525;--line-2:#3a3130;
  --red:#990000;--red-2:#c11414;--red-3:#e23b3b;--red-glow:rgba(180,20,20,.55);--red-line:rgba(153,0,0,.50);
  --ink:#f3ede6;--ink-dim:#bcb2a9;--ink-faint:#877d75;
  --glass:rgba(30,23,25,.45);--glass-2:rgba(44,30,33,.55);--glass-line:rgba(255,255,255,.08);--glass-hi:rgba(255,255,255,.14);
  --grid:rgba(243,237,230,.035);--grid-red:rgba(180,20,20,.06);--grid-fine:rgba(243,237,230,.014);--grid-red2:rgba(200,30,30,.035);
  --maxw:1440px;--gutter:clamp(16px,4vw,64px);
  --f-display:'Oswald','Arial Narrow',sans-serif;--f-body:'IBM Plex Sans',system-ui,sans-serif;--f-mono:'IBM Plex Mono',ui-monospace,monospace;
}
/* dark base (design system D-018) */
body.rl-dark{background:var(--bg);color:var(--ink);font-family:var(--f-body)}
body.rl-dark #rl-grid{position:fixed;inset:-18%;z-index:0;pointer-events:none;will-change:transform;background-image:linear-gradient(var(--grid-fine) 1px,transparent 1px),linear-gradient(90deg,var(--grid-fine) 1px,transparent 1px),linear-gradient(var(--grid) 1px,transparent 1px),linear-gradient(90deg,var(--grid) 1px,transparent 1px),linear-gradient(var(--grid-red) 1px,transparent 1px),linear-gradient(90deg,var(--grid-red) 1px,transparent 1px);background-size:22px 22px,22px 22px,66px 66px,66px 66px,330px 330px,330px 330px;background-position:center top}
body.rl-dark #rl-grid2{position:fixed;inset:-22%;z-index:-1;pointer-events:none;will-change:transform;opacity:.28;background-image:linear-gradient(var(--grid-red2) 1px,transparent 1px),linear-gradient(90deg,var(--grid-red2) 1px,transparent 1px),radial-gradient(120% 90% at 80% -10%,rgba(153,0,0,.14),transparent 55%);background-size:132px 132px,132px 132px,100% 100%;background-position:center top}
body.rl-dark #rl-glow{position:fixed;left:0;top:0;width:450px;height:450px;transform:translate(-50%,-50%);border-radius:50%;pointer-events:none;z-index:1;mix-blend-mode:screen;opacity:0;transition:opacity .35s;background:radial-gradient(circle,rgba(200,32,32,.16),rgba(200,32,32,.055) 32%,transparent 58%)}
@media(prefers-reduced-motion:reduce){body.rl-dark #rl-glow{display:none}}
/* hide the default bb-theme header (we render our own) */
.fl-page-header,.fl-page-bar{display:none!important}
/* dark base for the theme content area (design is dark everywhere) */
body.rl-dark .fl-page,body.rl-dark .fl-page-content,body.rl-dark .fl-content,body.rl-dark .fl-post-content,body.rl-dark .fl-post,body.rl-dark .fl-builder-content{background:transparent!important;background-color:transparent!important;color:var(--ink)}
.fl-page-content h1,.fl-page-content h2,.fl-page-content h3,.fl-page-content h4,.fl-page-content h5,.fl-page-content h6{color:var(--ink)}
.fl-page-content a{color:var(--red-3)}

.rl-header *{box-sizing:border-box}
.rl-header a{color:inherit;text-decoration:none}
.rl-header{position:sticky;top:0;z-index:50;border-bottom:1px solid var(--line);background:rgba(18,16,17,.78);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);font-family:var(--f-body)}
.rl-header .wrap{max-width:var(--maxw);margin:0 auto;padding-inline:var(--gutter)}
.rl-header .nav{display:flex;flex-wrap:nowrap;align-items:center;justify-content:space-between;height:72px;gap:20px}
.rl-header .brand{display:flex;align-items:center;flex-shrink:0}
.rl-header .brand img{height:34px;width:auto;display:block}
.rl-header .brand .brandtext{font-family:var(--f-display);font-weight:700;text-transform:uppercase;letter-spacing:.06em;font-size:18px;color:var(--ink);display:flex;align-items:center;gap:10px}
.rl-header .brand .dot{width:11px;height:11px;background:var(--red);box-shadow:0 0 14px var(--red-glow)}
.rl-header .mainnav{margin-inline:auto}
.rl-header .mainnav>ul{display:flex;gap:28px;list-style:none;margin:0;padding:0;font-family:var(--f-display);text-transform:uppercase;font-size:13.5px;letter-spacing:.05em;color:var(--ink-dim);height:72px;align-items:center}
.rl-header .mainnav>ul>li{height:100%;display:flex;align-items:center}
.rl-header .mainnav>ul>li>a{display:flex;align-items:center;gap:6px;height:100%;position:relative;transition:.15s}
.rl-header .mainnav>ul>li>a:hover,.rl-header .mainnav>ul>li:focus-within>a{color:#fff}
.rl-header .mainnav>ul>li>a::after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:2px;background:var(--red-2);transform:scaleX(0);transform-origin:left;transition:transform .2s}
.rl-header .mainnav>ul>li>a:hover::after,.rl-header .mainnav>ul>li:focus-within>a::after{transform:scaleX(1)}
.rl-header .caret{font-size:10px;color:var(--red-3);transition:transform .2s}
.rl-header .has-mega:hover .caret,.rl-header .has-mega:focus-within .caret{transform:rotate(180deg)}
.rl-header .btn{font-family:var(--f-display);text-transform:uppercase;font-weight:600;letter-spacing:.05em;font-size:14px;padding:14px 24px;display:inline-flex;align-items:center;gap:.55em;border:1px solid transparent;cursor:pointer;transition:.2s;border-radius:0}
.rl-header .btn::before{content:"+";font-family:var(--f-mono);font-weight:500;color:var(--red-3);font-size:1.15em;line-height:0}
.rl-header .btn.p{background:linear-gradient(180deg,#241a1c,#120e0f);color:#fff;border-color:var(--red-line);box-shadow:14px 0 44px -14px var(--red-glow),inset 0 1px 0 var(--glass-hi)}
.rl-header .btn.p:hover{border-color:var(--red-2);transform:translateY(-1px)}
.rl-header .btn.g{background:var(--glass);backdrop-filter:blur(8px);color:var(--ink);border-color:var(--glass-line)}
.rl-header .btn.g::before{color:var(--ink-faint)}
.rl-header .btn.sm{padding:11px 18px;font-size:13px}
.rl-header .ar{transition:transform .2s}.rl-header .btn:hover .ar{transform:translateX(3px)}
.rl-header .hcta{flex-shrink:0}
/* mega */
.rl-header .has-mega{position:static}
.rl-header .mega{position:absolute;left:0;right:0;top:100%;background:rgba(20,16,17,.94);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border-top:1px solid var(--red-line);border-bottom:1px solid var(--line);box-shadow:0 40px 80px -30px rgba(0,0,0,.9),inset 0 1px 0 var(--glass-hi);opacity:0;visibility:hidden;transform:translateY(-8px);transition:.22s;pointer-events:none}
.rl-header .has-mega:hover .mega,.rl-header .has-mega:focus-within .mega{opacity:1;visibility:visible;transform:none;pointer-events:auto}
.rl-header .mega::before{content:"";position:absolute;inset:0;background:radial-gradient(60% 120% at 78% 0%,rgba(153,0,0,.12),transparent 60%);pointer-events:none}
.rl-header .mega-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:clamp(14px,1.6vw,30px);padding-block:30px;position:relative}
@media(max-width:1080px){.rl-header .mega-grid{grid-template-columns:repeat(2,1fr)}}
.rl-header .ind-grid{display:grid;grid-template-columns:1.3fr 1fr 1fr;gap:clamp(20px,3vw,52px);padding-block:32px;position:relative}
@media(max-width:900px){.rl-header .ind-grid{grid-template-columns:1fr 1fr}}
.rl-header .ind-intro p{font-size:13.5px;color:var(--ink-dim);line-height:1.7;margin:0 0 16px}
.rl-header .mega-col h5{font-family:var(--f-mono);font-weight:500;text-transform:uppercase;font-size:11px;letter-spacing:.16em;color:var(--ink-faint);margin:0 0 16px;padding-bottom:9px;border-bottom:1px solid var(--line)}
.rl-header .mega-lead2{display:inline-flex;align-items:center;gap:6px;margin-top:16px;font-family:var(--f-mono);font-size:12px;letter-spacing:.05em;color:var(--red-3);text-transform:uppercase}
.rl-header .mega-lead2:hover{color:#fff}
.rl-header .mega-list{list-style:none;margin:0;padding:0;display:grid;gap:2px}
.rl-header .mega-list a{display:flex;align-items:center;gap:9px;padding:8px 10px;font-size:14px;color:var(--ink-dim);border:1px solid transparent;transition:.14s}
.rl-header .mega-list a::before{content:"";width:5px;height:5px;background:var(--red);flex-shrink:0;opacity:.5;transition:.14s}
.rl-header .mega-list a:hover{color:#fff;background:var(--glass);border-color:var(--glass-line)}
.rl-header .mega-list a:hover::before{opacity:1;box-shadow:0 0 10px var(--red-glow)}
.rl-header .mega-flag{grid-column:1/-1;margin-top:6px;border-top:1px solid var(--line);padding-top:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap}
.rl-header .mega-flag .tag{font-family:var(--f-mono);font-size:10px;letter-spacing:.16em;color:var(--red-3);text-transform:uppercase;margin-bottom:4px}
.rl-header .mega-flag h4{font-size:18px;color:#fff;margin:0 0 3px;font-family:var(--f-display);text-transform:uppercase}
.rl-header .mega-flag .txt{flex:1;min-width:220px}.rl-header .mega-flag p{font-size:13px;color:var(--ink-dim);margin:0}
/* burger + mobile */
.rl-header .burger{display:none;flex-direction:column;gap:5px;width:42px;height:42px;align-items:center;justify-content:center;border:1px solid var(--glass-line);background:var(--glass);cursor:pointer;flex-shrink:0}
.rl-header .burger span{width:19px;height:2px;background:var(--ink);transition:.25s}
body.rl-mopen .rl-header .burger span:nth-child(1){transform:translateY(7px) rotate(45deg)}
body.rl-mopen .rl-header .burger span:nth-child(2){opacity:0}
body.rl-mopen .rl-header .burger span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
#rl-mobile{position:fixed;inset:72px 0 0;z-index:49;background:rgba(15,12,13,.98);backdrop-filter:blur(16px);transform:translateX(100%);transition:transform .3s;overflow-y:auto;padding:22px var(--gutter) 60px;visibility:hidden;font-family:var(--f-body)}
body.rl-mopen #rl-mobile{transform:none;visibility:visible}
#rl-mobile a{display:block;font-family:var(--f-display);text-transform:uppercase;font-size:18px;letter-spacing:.03em;color:var(--ink);padding:14px 0;border-bottom:1px solid var(--line);text-decoration:none}
#rl-mobile a:hover{color:var(--red-3)}
#rl-mobile .m-sub{font-family:var(--f-display);text-transform:uppercase;font-size:11px;letter-spacing:.15em;color:var(--ink-faint);margin:22px 0 4px;font-weight:500}
#rl-mobile .m-mini{font-size:15px;color:var(--ink-dim);padding:11px 0}
#rl-mobile .m-cta{margin-top:26px;justify-content:center;width:100%}
.rl-header .mainnav>ul{gap:24px}
@media(max-width:1150px){.rl-header .mainnav,.rl-header .hcta{display:none}.rl-header .burger{display:flex}}
/* hide default theme footer (we render our own) */
.fl-page-footer-wrap,.fl-page-footer,.fl-builder-content-primary+.fl-page-footer-wrap{display:none!important}
/* shared hero-animation system (D-039): .rl-anim wraps each page's hero SVG; paused off-screen by JS; static for reduced motion */
.rl-anim svg{display:block;width:100%;height:auto;overflow:visible}
.rl-anim.is-paused,.rl-anim.is-paused *{animation-play-state:paused!important}
@media(prefers-reduced-motion:reduce){.rl-anim,.rl-anim *{animation:none!important;transition:none!important}}
/* skip link: visually hidden until keyboard focus (a11y) */
.fl-screen-reader-text{position:absolute!important;width:1px;height:1px;overflow:hidden;clip:rect(1px,1px,1px,1px);white-space:nowrap}
body a.fl-screen-reader-text:focus{clip:auto;width:auto;height:auto;overflow:visible;top:12px;left:12px;z-index:100000;padding:12px 18px;background:var(--bg)!important;color:var(--ink)!important;border:1px solid var(--red-2)!important;box-shadow:0 0 24px -6px var(--red-glow)!important;outline:none;font-family:var(--f-display)!important;text-transform:uppercase;letter-spacing:.05em;font-size:14px!important;text-decoration:none}
/* ---- footer ---- */
.rl-footer{position:relative;overflow:hidden;border-top:1px solid var(--red-line);background:var(--bg-2);color:var(--ink-dim);background-image:radial-gradient(80% 65% at 50% 0%,rgba(153,0,0,.10),transparent 62%);font-family:var(--f-body)}
.rl-footer *{box-sizing:border-box}
.rl-footer a{color:inherit;text-decoration:none}
.rl-footer .wrap{max-width:var(--maxw);margin:0 auto;padding-inline:var(--gutter)}
.rl-footer .f-inner{padding-block:clamp(40px,6vw,72px)}
.rl-footer .f-social{display:flex;justify-content:center;gap:10px;margin-bottom:clamp(34px,5vw,52px)}
.rl-footer .f-social a{width:40px;height:40px;display:flex;align-items:center;justify-content:center;border:1px solid var(--glass-line);background:var(--glass);color:var(--ink-dim);transition:.18s}
.rl-footer .f-social a:hover{border-color:var(--red-2);color:#fff;box-shadow:0 0 24px -6px var(--red-glow)}.rl-footer .f-social svg{width:16px;height:16px;fill:currentColor}
.rl-footer .f-main{display:grid;grid-template-columns:1.4fr repeat(5,1fr);gap:clamp(20px,2.4vw,38px)}
@media(max-width:1000px){.rl-footer .f-main{grid-template-columns:1fr 1fr 1fr}}
@media(max-width:680px){.rl-footer .f-main{grid-template-columns:1fr 1fr}}
@media(max-width:440px){.rl-footer .f-main{grid-template-columns:1fr}}
.rl-footer .f-intro .brand{display:flex;align-items:center;gap:10px;font-family:var(--f-display);font-weight:700;text-transform:uppercase;letter-spacing:.06em;font-size:18px;color:var(--ink);margin-bottom:16px}
.rl-footer .f-intro .dot{width:11px;height:11px;background:var(--red);box-shadow:0 0 14px var(--red-glow)}
.rl-footer .f-intro p{color:var(--ink-dim);font-size:14.5px;max-width:42ch;line-height:1.75;margin:0}
.rl-footer .f-col h4{font-family:var(--f-display);text-transform:uppercase;font-size:15px;letter-spacing:.07em;color:var(--ink);margin:0 0 18px;position:relative;padding-bottom:10px}
.rl-footer .f-col h4::after{content:"";position:absolute;left:0;bottom:0;width:26px;height:2px;background:var(--red)}
.rl-footer .f-col ul{list-style:none;margin:0;padding:0;display:grid;gap:11px}
.rl-footer .f-col li>span{color:var(--ink-faint);font-size:14px}.rl-footer .f-col a{color:var(--ink-dim);font-size:14px;transition:.15s;display:inline-block}.rl-footer .f-col a:hover{color:#fff;transform:translateX(4px)}
.rl-footer .f-col .flag{color:var(--ink)}.rl-footer .f-col .flag:hover{color:var(--red-3)}
.rl-footer .f-contact{margin-top:clamp(38px,5vw,60px);border-top:1px solid var(--line);padding-top:clamp(30px,4vw,46px);text-align:center}
.rl-footer .f-contact .ct{font-family:var(--f-display);text-transform:uppercase;font-size:18px;letter-spacing:.08em;color:var(--ink);margin-bottom:clamp(24px,3vw,34px)}
.rl-footer .f-offices{display:grid;grid-template-columns:1fr 1fr;gap:30px;max-width:860px;margin:0 auto}@media(max-width:640px){.rl-footer .f-offices{grid-template-columns:1fr}}
.rl-footer .f-office .t{font-family:var(--f-display);text-transform:uppercase;font-size:14px;color:var(--red-3);letter-spacing:.05em;margin-bottom:10px;text-decoration:underline;text-underline-offset:4px}
.rl-footer .f-office p{color:var(--ink-dim);font-size:14px;line-height:1.85;margin:0}.rl-footer .f-office .ph{color:var(--ink);font-weight:600;margin-top:10px;display:block}
.rl-footer .f-direct{margin-top:26px;font-size:14px;color:var(--ink-dim)}.rl-footer .f-direct a{color:var(--ink)}.rl-footer .f-direct a:hover{color:var(--red-3)}
.rl-footer .f-bottom{border-top:1px solid var(--line);background:#0d0b0c;padding:15px;text-align:center;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.03em}.rl-footer .f-bottom b{color:var(--red-3);font-weight:500}
</style>
<?php }

/* ---------- mark body + inject background layers ---------- */
add_filter('body_class', function ($c) { $c[] = 'rl-dark'; return $c; });

/* ---------- schema: Organization legalName (Yoast 28 has no setting for it) ---------- */
add_filter('wpseo_schema_organization', function ($data) {
    if (is_array($data)) $data['legalName'] = 'Reinforce Lab Limited';
    return $data;
});

/* ---------- theme markup cleanup (D-012 gates) ---------- */
/* Theme footer (widgets + BB credit) removed from the HTML, not hidden; [reinforce_footer] replaces it. */
add_filter('fl_footer_enabled', '__return_false');

/* Skip link first in tab order: theme prints it at fl_body_open:20, after our header (wp_body_open runs at fl_body_open:10). */
add_action('after_setup_theme', function () {
    if (remove_action('fl_body_open', 'FLTheme::skip_to_link', 20)) add_action('fl_body_open', 'FLTheme::skip_to_link', 5);
}, 20);

/* Pages rendered by a [reinforce_*] shortcode supply their own H1: strip the theme's
   <header class="fl-post-header"><h1 class="fl-post-title"> so there is exactly one H1. */
function rl_is_rl_page() {
    return (is_page() || is_singular('rl_project')) && strpos((string) get_post_field('post_content', get_queried_object_id()), '[reinforce_') !== false;
}
add_action('fl_before_post', function () { if (rl_is_rl_page()) ob_start(); }, 1);
add_action('fl_before_post_content', function () {
    if (!rl_is_rl_page()) return;
    $html = ob_get_clean();
    echo preg_replace('#<header class="fl-post-header">.*?</header><!-- \.fl-post-header -->#s', '', (string) $html);
}, 1);

add_action('wp_body_open', function () {
    echo '<div id="rl-grid2" aria-hidden="true"></div><div id="rl-grid" aria-hidden="true"></div><div id="rl-glow" aria-hidden="true"></div>';
    echo do_shortcode('[reinforce_header]');
}, 5);

/* ---------- helpers ---------- */
function rl_url_by_path($path, $fallback = '#') {
    $p = get_page_by_path($path);
    return $p ? get_permalink($p) : $fallback;
}

/* ---------- header renderer ---------- */
add_shortcode('reinforce_header', 'rl_render_header');
function rl_render_header() {
    $items = wp_get_nav_menu_items('Primary');
    if (!$items) return '';
    $top = array(); $kids = array();
    foreach ($items as $it) {
        if (intval($it->menu_item_parent) === 0) $top[] = $it;
        else $kids[intval($it->menu_item_parent)][] = $it;
    }
    $has_class = function ($it, $cls) { return is_array($it->classes) && in_array($cls, $it->classes, true); };

    $white = get_option('reinforcelab_logo_white');
    $logo = $white ? wp_get_attachment_url($white) : '';
    $cta = rl_url_by_path('search-authority-diagnostic');
    $sos = rl_url_by_path('search-authority-os');

    ob_start(); ?>
<header class="rl-header">
  <div class="wrap nav">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php if ($logo): ?><img src="<?php echo esc_url($logo); ?>" alt="Reinforce Lab"><?php else: ?><span class="brandtext"><span class="dot"></span>Reinforce&nbsp;Lab</span><?php endif; ?>
    </a>
    <nav class="mainnav" aria-label="Primary">
      <ul>
        <?php foreach ($top as $t):
          $children = isset($kids[$t->ID]) ? $kids[$t->ID] : array();
          if (!$children): ?>
          <li><a href="<?php echo esc_url($t->url); ?>"><?php echo esc_html($t->title); ?></a></li>
        <?php else:
          $headers = array(); $plain = array();
          foreach ($children as $c) { if ($has_class($c, 'mega-col-header')) $headers[] = $c; else $plain[] = $c; } ?>
          <li class="has-mega">
            <a href="<?php echo esc_url($t->url); ?>" aria-haspopup="true"><?php echo esc_html($t->title); ?> <span class="caret">&#9662;</span></a>
            <div class="mega">
              <?php if ($headers): /* grouped mega (Solutions) */ ?>
              <div class="wrap mega-grid">
                <?php foreach ($headers as $h): $gc = isset($kids[$h->ID]) ? $kids[$h->ID] : array(); ?>
                <div class="mega-col">
                  <h5><?php echo esc_html($h->title); ?></h5>
                  <ul class="mega-list">
                    <?php foreach ($gc as $g): ?><li><a href="<?php echo esc_url($g->url); ?>"><?php echo esc_html($g->title); ?></a></li><?php endforeach; ?>
                  </ul>
                </div>
                <?php endforeach; ?>
                <div class="mega-flag">
                  <div class="txt">
                    <div class="tag">[ Flagship Product ]</div>
                    <h4>Search Authority OS</h4>
                    <p>The AI system that turns your website, content, and organic search into one growth engine.</p>
                  </div>
                  <?php foreach ($plain as $pl): ?><a class="mega-lead2" href="<?php echo esc_url($pl->url); ?>"><?php echo esc_html($pl->title); ?> <span class="ar">&rarr;</span></a><?php endforeach; ?>
                  <a class="btn g sm" href="<?php echo esc_url($sos); ?>">Explore the OS <span class="ar">&rarr;</span></a>
                </div>
              </div>
              <?php else: /* flat dropdown -> industries style */
                $half = ceil(count($plain) / 2);
                $colA = array_slice($plain, 0, $half);
                $colB = array_slice($plain, $half); ?>
              <div class="wrap ind-grid">
                <div class="mega-col ind-intro">
                  <h5><?php echo esc_html($t->title); ?>: Who We Serve</h5>
                  <p>AI Growth Systems tuned to each industry's search behaviour, buyers, and compliance realities.</p>
                  <a class="mega-lead2" href="<?php echo esc_url($t->url); ?>">All <?php echo esc_html($t->title); ?> <span class="ar">&rarr;</span></a>
                </div>
                <div class="mega-col"><ul class="mega-list"><?php foreach ($colA as $g): ?><li><a href="<?php echo esc_url($g->url); ?>"><?php echo esc_html($g->title); ?></a></li><?php endforeach; ?></ul></div>
                <div class="mega-col"><ul class="mega-list"><?php foreach ($colB as $g): ?><li><a href="<?php echo esc_url($g->url); ?>"><?php echo esc_html($g->title); ?></a></li><?php endforeach; ?></ul></div>
              </div>
              <?php endif; ?>
            </div>
          </li>
        <?php endif; endforeach; ?>
      </ul>
    </nav>
    <a class="btn p hcta" href="<?php echo esc_url($cta); ?>">Get Your Diagnostic <span class="ar">&rarr;</span></a>
    <button class="burger" id="rl-burger" aria-label="Menu" aria-expanded="false"><span></span><span></span><span></span></button>
  </div>
</header>
<div id="rl-mobile">
  <?php foreach ($top as $t):
    $children = isset($kids[$t->ID]) ? $kids[$t->ID] : array();
    if (!$children): ?>
    <a href="<?php echo esc_url($t->url); ?>"><?php echo esc_html($t->title); ?></a>
  <?php else:
    echo '<div class="m-sub">' . esc_html($t->title) . '</div>';
    foreach ($children as $c):
      if ($has_class($c, 'mega-col-header')) { echo '<div class="m-sub">' . esc_html($t->title) . ' · ' . esc_html($c->title) . '</div>'; $gc = isset($kids[$c->ID]) ? $kids[$c->ID] : array(); foreach ($gc as $g) { echo '<a class="m-mini" href="' . esc_url($g->url) . '">' . esc_html($g->title) . '</a>'; } }
      else { echo '<a class="m-mini" href="' . esc_url($c->url) . '">' . esc_html($c->title) . '</a>'; }
    endforeach;
  endif; endforeach; ?>
  <a class="btn p m-cta" href="<?php echo esc_url($cta); ?>">Get Your Diagnostic <span class="ar">&rarr;</span></a>
</div>
<?php
    return ob_get_clean();
}

/* ---------- footer renderer ---------- */
add_shortcode('reinforce_footer', 'rl_render_footer');
add_action('wp_footer', function () { echo do_shortcode('[reinforce_footer]'); }, 20);
function rl_render_footer() {
    $solutions = array(
        'AI Growth Systems' => 'services/ai-growth-systems',
        'AI Workflow Automation' => 'services/ai-workflow-automation',
        'AI Search Optimization' => 'services/ai-search-optimization',
        'Enterprise SEO Strategy' => 'services/enterprise-seo-strategy',
        'Technical SEO' => 'services/technical-seo-services',
        'International SEO' => 'services/international-seo',
        'SEO Content Systems' => 'services/seo-content-systems',
        'Generative Engine Optimization' => 'services/generative-engine-optimization',
        'LLM Optimization' => 'services/llm-optimization',
        'Lead Generation Systems' => 'services/lead-generation-systems',
        'Marketing Automation' => 'services/marketing-automation',
        'Executive AI Consulting' => 'services/executive-ai-consulting',
    );
    $industries = array(
        'Pharmaceutical & Life Sciences' => 'industries/pharmaceutical',
        'Healthcare' => 'industries/healthcare',
        'B2B SaaS' => 'industries/b2b-saas',
        'E-commerce' => 'industries/ecommerce',
        'Manufacturing' => 'industries/manufacturing',
        'Technology' => 'industries/technology',
        'Professional Services' => 'industries/professional-services',
        'Education' => 'industries/education',
    );
    ob_start(); ?>
<footer class="rl-footer">
  <div class="wrap f-inner">
    <div class="f-social">
      <a href="https://www.facebook.com/reinforcelabltd/" aria-label="Reinforce Lab on Facebook" rel="noopener" target="_blank"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
      <a href="https://www.instagram.com/reinforcelabltd/" aria-label="Reinforce Lab on Instagram" rel="noopener" target="_blank"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
      <a href="https://www.linkedin.com/company/reinforcelabltd/" aria-label="Reinforce Lab on LinkedIn" rel="noopener" target="_blank"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
    </div>
    <div class="f-main">
      <div class="f-intro">
        <div class="brand"><span class="dot"></span>Reinforce&nbsp;Lab</div>
        <p>Reinforce Lab builds AI Growth Systems that connect your website, content, and organic search visibility into one growth engine. We design and implement data-driven SEO, AI Search automation, and content systems for growth-stage founders and B2B companies who want measurable revenue.</p>
      </div>
      <div class="f-col">
        <h4>Search Authority OS</h4>
        <ul>
          <li><a class="flag" href="<?php echo esc_url(rl_url_by_path('search-authority-os')); ?>">Search Authority OS</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('search-authority-diagnostic')); ?>">Free Diagnostic</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('packages')); ?>">Packages &amp; Pricing</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('services/agents')); ?>">Agents</a></li>
        </ul>
      </div>
      <div class="f-col">
        <h4>Solutions</h4>
        <ul>
          <?php foreach ($solutions as $label => $path): $flag = ($label === 'AI Growth Systems') ? ' class="flag"' : ''; ?>
          <li><a<?php echo $flag; ?> href="<?php echo esc_url(rl_url_by_path($path)); ?>"><?php echo esc_html($label); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="f-col">
        <h4>Industries</h4>
        <ul>
          <?php foreach ($industries as $label => $path): ?>
          <li><a href="<?php echo esc_url(rl_url_by_path($path)); ?>"><?php echo esc_html($label); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="f-col">
        <h4>Company</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('about-us')); ?>">About Us</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('awards')); ?>">Awards</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('services')); ?>">Services</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('portfolio')); ?>">Portfolio</a></li>
          <li><a href="#">Clients</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('blog')); ?>">Blog</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('contact-us')); ?>">Contact Us</a></li>
        </ul>
      </div>
      <div class="f-col">
        <h4>Resources</h4>
        <ul>
          <li><a href="<?php echo esc_url(rl_url_by_path('search-authority-diagnostic')); ?>">Get a Free Quote</a></li>
          <li><a href="<?php echo esc_url(home_url('/sitemap_index.xml')); ?>">Sitemap</a></li>
          <?php $rl_pp = get_privacy_policy_url(); /* WordPress privacy page (page 3): a link only once it is published, plain text until then (D-119) */ ?>
          <li><?php echo $rl_pp ? '<a href="' . esc_url($rl_pp) . '">Privacy Policy</a>' : '<span>Privacy Policy</span>'; ?></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('terms-conditions')); ?>">Terms &amp; Conditions</a></li>
          <li><a href="<?php echo esc_url(rl_url_by_path('ftc-disclosure')); ?>">FTC Disclosure</a></li>
          <li><a href="#">Certificate of Incorporation</a></li>
        </ul>
      </div>
    </div>
    <div class="f-contact">
      <div class="ct">Contact Us</div>
      <div class="f-offices">
        <div class="f-office"><div class="t">Bangladesh Office Address</div><p>Reinforce Lab Ltd<br>Suite #1402, Level-13, Concord Tower,<br>113 Kazi Nazrul Islam Avenue, Dhaka - 1000, Bangladesh.<span class="ph">Contact: +880 1329-657096</span></p></div>
        <div class="f-office"><div class="t">USA Office Address</div><p>Reinforce Lab Inc<br>2511 Pines Pointe Dr, Katy, TX 77493, USA<span class="ph">Contact: +1 832 548 4553</span></p></div>
      </div>
      <div class="f-direct">Contact: <a href="tel:+8801329657096">+880 1329-657096</a> &nbsp;&middot;&nbsp; Email: <a href="mailto:hello@reinforcelab.com">hello@reinforcelab.com</a></div>
    </div>
  </div>
  <div class="f-bottom">&copy; <?php echo esc_html(date('Y')); ?> Reinforce Lab Ltd &middot; All Rights Reserved &middot; Created By <b>Reinforce Lab Ltd.</b></div>
</footer>
<?php
    return ob_get_clean();
}

/* ---------- JS: parallax grid + cursor glow + mobile toggle ---------- */
add_action('wp_footer', 'rl_header_js', 30);
function rl_header_js() { ?>
<script>
(function(){
  var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
  var grid=document.getElementById('rl-grid'),grid2=document.getElementById('rl-grid2'),glow=document.getElementById('rl-glow');
  var sy=0,mx=.5,my=.5,cx=innerWidth/2,cy=innerHeight/2,gx=cx,gy=cy,tmx=.5,tmy=.5,raf=false;
  function apply(){
    // ease mouse tilt for smoothness
    mx+=(tmx-mx)*.10; my+=(tmy-my)*.10;
    if(grid){var px=(mx-.5)*42,py=(my-.5)*42+sy*0.14;grid.style.transform='translate3d('+px.toFixed(1)+'px,'+py.toFixed(1)+'px,0)';}
    if(grid2){var px2=(mx-.5)*78,py2=(my-.5)*78+sy*0.28;grid2.style.transform='translate3d('+px2.toFixed(1)+'px,'+py2.toFixed(1)+'px,0)';}
    if(glow){gx+=(cx-gx)*.18;gy+=(cy-gy)*.18;glow.style.transform='translate('+gx.toFixed(1)+'px,'+gy.toFixed(1)+'px) translate(-50%,-50%)';}
    if(Math.abs(gx-cx)>.5||Math.abs(gy-cy)>.5||Math.abs(tmx-mx)>.002||Math.abs(tmy-my)>.002){requestAnimationFrame(apply);}else{raf=false;}
  }
  function kick(){if(!raf){raf=true;requestAnimationFrame(apply);}}
  if(!reduce&&(grid||glow)){addEventListener('scroll',function(){sy=scrollY||0;kick();},{passive:true});addEventListener('mousemove',function(e){tmx=e.clientX/innerWidth;tmy=e.clientY/innerHeight;cx=e.clientX;cy=e.clientY;if(glow)glow.style.opacity=1;kick();},{passive:true});addEventListener('mouseleave',function(){if(glow)glow.style.opacity=0;});apply();}
  // pause hero animations when off-screen (D-039)
  var an=document.querySelectorAll('.rl-anim');
  if(an.length&&'IntersectionObserver' in window){var io=new IntersectionObserver(function(es){es.forEach(function(e){e.target.classList.toggle('is-paused',!e.isIntersecting);});},{rootMargin:'80px'});an.forEach(function(el){io.observe(el);});}
  var b=document.getElementById('rl-burger');
  if(b){b.addEventListener('click',function(){var o=document.body.classList.toggle('rl-mopen');b.setAttribute('aria-expanded',o?'true':'false');});}
  var mob=document.getElementById('rl-mobile');
  if(mob){mob.addEventListener('click',function(e){if(e.target.closest('a')){document.body.classList.remove('rl-mopen');if(b)b.setAttribute('aria-expanded','false');}});}
})();
</script>
<?php }
