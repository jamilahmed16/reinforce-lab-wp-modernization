<?php
/**
 * Plugin Name: Reinforce Lab - scroll motion
 * Description: Scroll motion (D-163). GSAP 3.15 + ScrollTrigger + SplitText (free "no charge" licence, self-hosted in core/vendor/, no CDN) and core/reinforce-motion.js, printed with defer at the end of the page, only on pages that opt in through the rl_motion_active filter. Rules: text stays real HTML and is visible without JavaScript (nothing is hidden by CSS, only by the script once it runs), the hero is never animated, only transform and opacity move, prefers-reduced-motion gets a still page. No smooth-scroll library (Lenis off, D-163).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_motion_active() { return !is_admin() && (bool) apply_filters('rl_motion_active', false); }

function rl_motion_src($rel) {
    $f = __DIR__ . '/' . $rel;
    $v = file_exists($f) ? substr(md5_file($f), 0, 8) : '0';
    return content_url('novamira-sandbox/core/' . $rel) . '?ver=' . $v;
}

/* Styles for elements the script adds (rail fills, lit states). Without the script none of these classes exist, so the page looks as before. */
add_action('wp_head', function () {
    if (!rl_motion_active()) return; ?>
<style id="rl-motion-css">
.rl-mo .tline{--fill:0}
.rl-mo .tl-fill{position:absolute;left:0;top:9px;height:1px;width:100%;background:var(--red);transform-origin:left center;transform:scaleX(0);box-shadow:0 0 12px var(--red-glow);pointer-events:none}
.rl-mo .tline li.on .nd{border-color:var(--red);background:var(--red);box-shadow:0 0 22px -2px var(--red-glow)}
.rl-mo .tline li.on .nd::after{background:#fff}
.rl-mo .tline li.on .k{-webkit-text-stroke-color:var(--red-2)}
.rl-mo .tline .nd,.rl-mo .tline .k{transition:background-color .6s,border-color .6s,box-shadow .6s,-webkit-text-stroke-color .6s}
@media(max-width:900px){.rl-mo .tl-fill{left:9px;top:10px;width:1px;height:calc(100% - 20px);transform-origin:center top;transform:scaleY(0)}}
.rl-mo .os-steps li{transition:background-color .5s,border-color .5s,color .5s}
.rl-mo .os-steps li.on{border-color:var(--red-line);background:linear-gradient(90deg,rgba(153,0,0,.22),rgba(153,0,0,.04))}
.rl-mo .os-steps li.on .os-n{background:var(--red);border-color:var(--red);color:#fff}
.rl-mo .os-steps li.on b{color:var(--ink)}
.rl-mo .os-bar{display:block;height:2px;margin-top:16px;background:var(--line);position:relative;overflow:hidden}
.rl-mo .os-bar i{position:absolute;inset:0;background:var(--red);transform-origin:left center;transform:scaleX(0)}
.rl-mo .ladder .lad-fill{position:absolute;left:23px;top:28px;bottom:28px;width:1px;background:var(--red);transform-origin:center top;transform:scaleY(0);box-shadow:0 0 12px var(--red-glow);pointer-events:none}
@media(max-width:560px){.rl-mo .ladder .lad-fill{left:17px}}
.rl-progress{position:fixed;left:0;top:0;right:0;height:2px;z-index:60;background:var(--red);transform-origin:left center;transform:scaleX(0);box-shadow:0 0 10px var(--red-glow);pointer-events:none}
.rl-mo .rl-home .final::before{opacity:var(--glow,1)}
.rl-mo .rl-home .final{box-shadow:inset 0 1px 0 var(--glass-hi),0 0 calc(60px + 90px * var(--glow,1)) calc(-56px + 10px * var(--glow,1)) var(--red-glow)}
</style>
<?php }, 23);

/* Scripts at the end of the page with defer: they never block the first paint or the hero (LCP). */
add_action('wp_footer', function () {
    if (!rl_motion_active()) return;
    foreach (['vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'reinforce-motion.js'] as $rel)
        echo '<script src="' . esc_url(rl_motion_src($rel)) . '" defer></script>' . "\n";
}, 30);
