<?php
/**
 * Plugin Name: Reinforce Lab - WP Engine partner page
 * Description: /agency-partner-program-wp-engine-landing/ (production URL kept, D-182; APPROVED: PRESERVE, rel=sponsored + FTC disclosure). Provides [reinforce_wpengine]. D-190: rebuilt in the kit (D-044). The partner link comes from the option rl_awards_wpengine_url (the same link the Awards page uses); until Jamil supplies it the page shows no affiliate link and points to Contact instead. No offer, price or discount is stated here: WP Engine shows its current partner offer on its own page.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_wpengine() { return is_page('agency-partner-program-wp-engine-landing'); }
function rl_wpengine_link() { $l = trim((string) get_option('rl_awards_wpengine_url', '')); return $l && function_exists('rl_aff_partner') && rl_aff_partner($l) === 'WP Engine' ? $l : ''; }

function rl_wpengine_faqs() {
    return [
        ['What is the WP Engine Agency Partner Program?', 'It is WP Engine\'s programme for agencies that build and host WordPress websites for their clients. Reinforce Lab is a member, and a WP Engine agency partner.'],
        ['Do I have to host with WP Engine to work with Reinforce Lab?', 'No. We build, move and look after WordPress sites on any good host. WP Engine is one option we recommend for business sites where speed and uptime matter.'],
        ['Does Reinforce Lab earn money if I sign up?', 'Yes. Our link to WP Engine is an affiliate link, marked Ad. If you buy through it, WP Engine pays us a commission, at no extra cost to you. It does not change what we recommend.'],
        ['Where are the prices and the current offer?', 'On WP Engine\'s own partner offer page. WP Engine sets its prices and terms and can change them, so we do not repeat them here.'],
        ['Can you move my existing site to WP Engine?', 'Yes. We map every URL first, move the site, and test the redirects before switching over, so pages that already earn traffic keep their place in search.'],
    ];
}

add_filter('body_class', function ($c) { if (rl_is_wpengine()) $c[] = 'rl-wpe-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_wpengine(); });

/* ---------- schema: WebPage about the Organization, FAQPage; no Product or Offer (we do not sell the hosting) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_wpengine()) return $graph;
    $url = get_permalink(get_queried_object_id());
    foreach ($graph as &$n) {
        if (is_array($n) && !empty($n['@type']) && in_array('WebPage', (array) $n['@type'], true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) {
            $n['about'] = ['@id' => home_url('/#organization')];
            $n['mentions'] = [['@type' => 'Organization', 'name' => 'WP Engine', 'url' => 'https://wpengine.com/']];
        }
    }
    unset($n);
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_wpengine_faqs())];
    return $graph;
}, 20);

add_action('wp_head', function () {
    if (!rl_is_wpengine()) return; ?>
<style id="rl-wpe-css">
body.rl-wpe-page .fl-page-content,body.rl-wpe-page .fl-content,body.rl-wpe-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-wpe .rl-adnote{max-width:820px;margin:22px 0 0}
.rl-wpe .badge{display:inline-flex;align-items:center;gap:10px;margin-top:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink);border:1px solid var(--red-line);padding:9px 14px;background:rgba(153,0,0,.08)}
.rl-wpe .badge i{width:8px;height:8px;background:var(--red-2);display:block}
.rl-wpe .cta-row .rl-ad{flex:0 0 auto!important;width:auto!important;min-width:0!important;align-self:center;margin:0 0 0 -6px}
.rl-wpe .cell .ico{width:40px;height:40px;display:grid;place-items:center;border:1px solid var(--red-line);color:var(--red-3);margin-bottom:16px}
.rl-wpe .cell .ico svg{width:20px;height:20px}
.rl-wpe .src{display:block;margin-top:18px;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.04em}
.rl-wpe .src a{color:var(--ink-dim);border-bottom:1px solid var(--line-2)}
.rl-wpe .two{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,56px);align-items:start}
@media(max-width:860px){.rl-wpe .two{grid-template-columns:minmax(0,1fr)}}
</style>
<?php }, 22);

add_shortcode('reinforce_wpengine', function () {
    if (!rl_is_wpengine()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $aff = rl_wpengine_link();
    $offer = function ($label, $cls = 'btn p') use ($aff) { return '<a class="' . $cls . '" href="' . esc_url($aff) . '" rel="sponsored nofollow noopener" target="_blank">' . $label . ' <span class="ar">&rarr;</span></a>'; };
    $ico = function ($d) { return '<span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">' . $d . '</svg></span>'; };
    ob_start(); ?>
<div class="rl-page rl-wpe">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services/wordpress-website-design-service'); ?>">WordPress Website Design</a></li>
  <li><span aria-current="page">WP Engine partner</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;WP Engine Agency Partner&nbsp;<b>]</b></span>
    <h1 class="h1">WordPress hosting on WP Engine,<br><span class="r">set up by Reinforce Lab.</span></h1>
    <p class="lede">Reinforce Lab is a member of WP Engine's Agency Partner Program. WP Engine runs managed WordPress hosting; we build the site, move it there safely, and look after it, so your website stays fast, secure and visible in search.</p>
    <p class="badge"><i aria-hidden="true"></i>WP Engine agency partner</p>
    <div class="cta-row">
      <?php if ($aff) { echo $offer('See WP Engine\'s partner offer'); ?>
      <a class="btn g" href="<?php echo $u('contact-us'); ?>">Ask us about hosting</a>
      <?php } else { ?>
      <a class="btn p" href="<?php echo $u('contact-us'); ?>">Ask us about WP Engine hosting <span class="ar">&rarr;</span></a>
      <a class="btn g" href="#what">What WP Engine does</a>
      <?php } ?>
    </div>
    <?php if ($aff && function_exists('rl_aff_note')) echo rl_aff_note(['WP Engine']); ?>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The hosting&nbsp;<b>]</b></span><h2>What does WP Engine do for a WordPress site?</h2><p class="lede">WP Engine is a managed WordPress hosting company. It runs the servers and the WordPress platform, so your team works on the website, not on the hosting.</p></div>
    <div class="cols c2">
      <div class="cell"><?php echo $ico('<path d="M13 2 4 14h7l-1 8 9-12h-7z"/>'); ?><h3>Speed</h3><p>Servers and caching set up for WordPress, with a content delivery network to serve pages quickly to visitors in other countries.</p></div>
      <div class="cell"><?php echo $ico('<rect x="3" y="4" width="18" height="16"/><path d="M3 9h18M8 14h8"/>'); ?><h3>Site management</h3><p>Staging copies to test changes before they go live, and daily backups you can restore from.</p></div>
      <div class="cell"><?php echo $ico('<path d="M12 3 4 6v6c0 5 3.4 8 8 9 4.6-1 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/>'); ?><h3>Security</h3><p>Free SSL certificates and a platform that WP Engine watches and patches, which removes a lot of the routine security work.</p></div>
      <div class="cell"><?php echo $ico('<circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/>'); ?><h3>WordPress support</h3><p>Support from a team that works only on WordPress, available around the clock.</p></div>
    </div>
    <span class="src">Source: features described on <a href="https://wpengine.com/" rel="noopener" target="_blank">wpengine.com</a>. Plans differ in what they include; check the plan before you buy.</span>
  </div>
</section>

<section id="us">
  <div class="wrap two">
    <div class="head" style="margin-bottom:0"><span class="ey"><b>[</b>&nbsp;Our part&nbsp;<b>]</b></span><h2>What does Reinforce Lab do?</h2><p class="lede">Hosting is one piece. We handle the website around it, from the first build to the day-to-day upkeep.</p></div>
    <ul class="ticks" style="grid-template-columns:minmax(0,1fr)">
      <li><b>Build the site.</b> A fast, well-structured WordPress or WooCommerce site, set up on WP Engine from the start. <a class="inl" href="<?php echo $u('services/wordpress-website-design-service'); ?>">WordPress Website Design</a></li>
      <li><b>Move an existing site.</b> Every URL mapped before the move and every redirect tested after it, so pages that earn traffic keep their place in search.</li>
      <li><b>Look after it.</b> Updates, security checks, backups and speed checks every month. <a class="inl" href="<?php echo $u('services/website-maintenance-services'); ?>">Website Maintenance</a></li>
      <li><b>Grow it.</b> SEO and AI search work on top of a site that loads fast and stays online. <a class="inl" href="<?php echo $u('services'); ?>">All services</a></li>
    </ul>
  </div>
</section>

<section class="band alt" id="fit">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Is it right for you?&nbsp;<b>]</b></span>
      <h2>WP Engine is not the cheapest host.</h2>
      <p>It suits business websites where speed, uptime and security matter: sites that bring in leads or sales, online stores, and sites with steady traffic. For a small site with few visitors, a lower-cost host can be enough, and we will tell you if that is your case. You do not need to host with WP Engine to work with us.</p>
    </div>
  </div>
</section>

<section id="disclosure">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Disclosure&nbsp;<b>]</b></span><h2>How the partner link works.</h2>
    <p class="lede">We are a member of the WP Engine affiliate programme and a WP Engine agency partner. If you sign up through our link, WP Engine pays us a commission, at no extra cost to you. Prices, offers and terms are set by WP Engine and shown on its own page. A commission never decides what we recommend. <a href="<?php echo $u('ftc-disclosure'); ?>">How we handle affiliate links</a>.</p></div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About WP Engine and Reinforce Lab.</h2></div>
    <?php foreach (rl_wpengine_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Fast hosting, and a site built to use it.</h2>
      <p class="lede">Tell us about your site and we will say whether WP Engine fits, what moving would involve, and what we would fix first.</p>
      <div class="cta-row">
        <?php if ($aff) echo $offer('See WP Engine\'s partner offer'); ?>
        <a class="btn <?php echo $aff ? 'g' : 'p'; ?>" href="<?php echo $u('contact-us'); ?>">Talk to us about hosting<?php echo $aff ? '' : ' <span class="ar">&rarr;</span>'; ?></a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
});
