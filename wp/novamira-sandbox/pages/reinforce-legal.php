<?php
/**
 * Plugin Name: Reinforce Lab - Legal pages
 * Description: Layout for legal pages (Privacy Policy, Terms & Conditions, FTC Disclosure; D-120). The page's own text stays editable in WordPress inside [reinforce_legal updated="..." lede="..."] ... [/reinforce_legal]; this file adds the kit layout: breadcrumb, hero with H1 and "last updated", an automatic contents list from the H2s, and prose styles.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_legal() { return is_page() && strpos((string) get_post_field('post_content', get_queried_object_id()), '[reinforce_legal') !== false; }

add_filter('body_class', function ($c) { if (rl_is_legal()) $c[] = 'rl-legal-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_legal(); });
add_action('wp_head', function () {
    if (!rl_is_legal()) return; ?>
<style id="rl-legal-css">
body.rl-legal-page .fl-page-content,body.rl-legal-page .fl-content,body.rl-legal-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-legal .hero{padding-bottom:clamp(20px,3vw,36px)}
.rl-legal .upd{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin-top:18px}
.rl-legal .lg{display:grid;grid-template-columns:240px minmax(0,1fr);gap:clamp(28px,4vw,64px);align-items:start;padding-bottom:clamp(48px,7vw,96px)}
.rl-legal .toc{position:sticky;top:96px;border-left:1px solid var(--red-line);padding-left:16px}
.rl-legal .toc p{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 10px}
.rl-legal .toc ol{list-style:none;margin:0;padding:0;display:grid;gap:8px}
.rl-legal .toc a{color:var(--ink-dim);font-size:14px;text-decoration:none}.rl-legal .toc a:hover{color:#fff}
.rl-legal .prose{max-width:78ch;color:var(--ink-dim);font-size:16.5px;line-height:1.75}
.rl-legal .prose h2{font-size:clamp(22px,2.4vw,28px);color:var(--ink);margin:44px 0 12px;scroll-margin-top:96px}
.rl-legal .prose h2:first-child{margin-top:0}
.rl-legal .prose h3{font-size:20px;color:var(--ink);margin:26px 0 8px}
.rl-legal .prose p{margin:0 0 14px}
.rl-legal .prose ul{margin:0 0 16px;padding-left:20px}.rl-legal .prose li{margin:0 0 6px}
.rl-legal .prose strong{color:var(--ink)}
.rl-legal .prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}.rl-legal .prose a:hover{color:var(--red-3)}
.rl-legal .prose table{width:100%;min-width:0;border-collapse:collapse;margin:8px 0 20px;font-size:16px}
.rl-legal .prose th,.rl-legal .prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-legal .prose th{color:var(--ink);font-family:var(--f-mono);font-size:12px;letter-spacing:.1em;text-transform:uppercase;background:rgba(255,255,255,.03)}
@media(max-width:900px){.rl-legal .lg{grid-template-columns:minmax(0,1fr)}.rl-legal .toc{position:static}}
.rl-legal .prose{overflow-wrap:anywhere}
@media(max-width:600px){.rl-legal .prose table,.rl-legal .prose thead,.rl-legal .prose tbody,.rl-legal .prose tr,.rl-legal .prose th,.rl-legal .prose td{display:block}.rl-legal .prose thead{display:none}.rl-legal .prose td{border-top:0}.rl-legal .prose tr{border-top:1px solid var(--line-2);margin-bottom:10px}}
</style>
<?php }, 22);

add_shortcode('reinforce_legal', function ($atts, $content = '') {
    if (!rl_is_legal()) return '';
    $a = shortcode_atts(['updated' => '', 'lede' => '', 'eyebrow' => 'Legal'], $atts);
    $title = get_the_title(get_queried_object_id());
    $body = trim((string) $content); // WordPress has already run wpautop on the post content (priority 10, before shortcodes)
    $toc = [];
    $body = preg_replace_callback('#<h2>(.*?)</h2>#s', function ($m) use (&$toc) {
        $id = sanitize_title(wp_strip_all_tags($m[1])); $toc[] = [$id, wp_strip_all_tags($m[1])];
        return '<h2 id="' . esc_attr($id) . '">' . $m[1] . '</h2>';
    }, $body);
    ob_start(); ?>
<div class="rl-page rl-legal">
<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page"><?php echo esc_html($title); ?></span></li>
</ol></nav>
<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;<?php echo esc_html($a['eyebrow']); ?>&nbsp;<b>]</b></span>
    <h1 class="h1"><?php echo esc_html($title); ?></h1>
    <?php if ($a['lede'] !== '') echo '<p class="lede">' . esc_html($a['lede']) . '</p>'; ?>
    <?php if ($a['updated'] !== '') echo '<p class="upd">Last updated: ' . esc_html($a['updated']) . '</p>'; ?>
  </div>
</section>
<section>
  <div class="wrap lg">
    <?php if ($toc) { ?><nav class="toc" aria-label="On this page"><p>On this page</p><ol><?php foreach ($toc as $t) echo '<li><a href="#' . esc_attr($t[0]) . '">' . esc_html($t[1]) . '</a></li>'; ?></ol></nav><?php } ?>
    <div class="prose"><?php echo $body; ?></div>
  </div>
</section>
</div>
<?php
    return ob_get_clean();
});
