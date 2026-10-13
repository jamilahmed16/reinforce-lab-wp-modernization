<?php
/**
 * Plugin Name: Reinforce Lab - Careers
 * Description: /careers/ (production URL kept, D-182). Provides [reinforce_careers]. Jamil, 13 Oct 2026: not hiring; the page says so plainly and invites CVs by email. Uses the shared kit (D-044). No JobPosting schema while there are no open roles (Google guidance: only real, open jobs).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_careers() { return is_page('careers') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }

add_filter('body_class', function ($c) { if (rl_is_careers()) $c[] = 'rl-careers-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_careers(); });

/* ---------- schema: the WebPage is about the Organization; no JobPosting (no open roles) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_careers()) return $graph;
    $url = get_permalink(get_queried_object_id());
    foreach ($graph as &$n) {
        if (is_array($n) && !empty($n['@type']) && in_array('WebPage', (array) $n['@type'], true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) $n['about'] = ['@id' => home_url('/#organization')];
    }
    unset($n);
    return $graph;
}, 20);

add_action('wp_head', function () {
    if (!rl_is_careers()) return; ?>
<style id="rl-careers-css">
body.rl-careers-page .fl-page-content,body.rl-careers-page .fl-content,body.rl-careers-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-careers .status{display:inline-flex;align-items:center;gap:10px;margin-top:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink);border:1px solid var(--line-2);padding:9px 14px}
.rl-careers .status i{width:8px;height:8px;background:var(--ink-faint);display:block}
.rl-careers .send{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,56px);align-items:start}
.rl-careers .send ul{list-style:none;margin:0;padding:0;display:grid;gap:12px}
.rl-careers .send li{border:1px solid var(--glass-line);background:var(--glass);padding:16px 18px 16px 42px;position:relative;color:var(--ink-dim);font-size:16px}
.rl-careers .send li::before{content:"\2192";position:absolute;left:18px;top:16px;color:var(--red-3);font-family:var(--f-mono)}
.rl-careers .send li b{color:var(--ink);font-weight:600}
.rl-careers .note{color:var(--ink-dim);font-size:16px;margin-top:16px}
@media(max-width:860px){.rl-careers .send{grid-template-columns:minmax(0,1fr)}}
</style>
<?php }, 22);

add_shortcode('reinforce_careers', function () {
    if (!rl_is_careers()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $mail = 'mailto:hello@reinforcelab.com?subject=' . rawurlencode('CV: ');
    ob_start(); ?>
<div class="rl-page rl-careers">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('about-us'); ?>">About</a></li>
  <li><span aria-current="page">Careers</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;Careers&nbsp;<b>]</b></span>
    <h1 class="h1">Careers at<br><span class="r">Reinforce Lab.</span></h1>
    <p class="lede">There are no open roles at Reinforce Lab at the moment. If you do careful work in search, content, AI automation or WordPress, send us your CV. We keep it on file and get in touch if a role opens that fits your skills.</p>
    <p class="status"><i aria-hidden="true"></i>Open roles: none at the moment</p>
    <div class="cta-row">
      <a class="btn p" href="<?php echo esc_url($mail); ?>">Email your CV <span class="ar">&rarr;</span></a>
      <a class="btn g" href="<?php echo $u('about-us'); ?>">About Reinforce Lab</a>
    </div>
  </div>
</section>

<section class="band alt" id="work">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The work&nbsp;<b>]</b></span><h2>What kind of work do we do?</h2><p class="lede">Reinforce Lab builds AI Growth Systems: a company's website, content and organic search connected into one growth engine, with AI automation doing the repetitive work and people reviewing what matters. We work from Dhaka, Bangladesh, and Katy, Texas, for clients worldwide.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Search</span><h3>SEO and AI search</h3><p>Technical SEO, content that ranks, international SEO, and visibility in AI answers from ChatGPT, Gemini and Google's AI Overviews.</p></div>
      <div class="cell"><span class="n">02 · Systems</span><h3>AI workflow automation</h3><p>Workflows that research, draft, check and report, built so a person reviews the output before it is used.</p></div>
      <div class="cell"><span class="n">03 · Websites</span><h3>WordPress builds</h3><p>Fast, accessible WordPress websites and the upkeep that keeps them that way.</p></div>
    </div>
  </div>
</section>

<section id="send">
  <div class="wrap send">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Send your CV&nbsp;<b>]</b></span><h2>What should you send?</h2><p class="lede">One email to <a href="<?php echo esc_url($mail); ?>">hello@reinforcelab.com</a> with "CV" and the work you do in the subject line.</p></div>
    <div>
      <ul>
        <li><b>Your CV</b> as a PDF.</li>
        <li><b>Two or three pieces of work</b> you are proud of, as links, with a line on what you did yourself.</li>
        <li><b>Where you are based</b> and the hours you can work.</li>
        <li><b>The kind of role</b> you would want with us.</li>
      </ul>
      <p class="note">We use your CV only to consider you for work at Reinforce Lab, and delete it whenever you ask. Read our <a href="<?php echo $u('privacy-policy'); ?>">Privacy Policy</a>.</p>
    </div>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Careers&nbsp;<b>]</b></span>
      <h2>Send your CV for the next opening.</h2>
      <p class="lede">No open roles today. Your CV stays on file for the next one.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo esc_url($mail); ?>">Email your CV <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('contact-us'); ?>">Contact us</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
});
