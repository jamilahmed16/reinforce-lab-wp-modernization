<?php
/**
 * Plugin Name: Reinforce Lab - Website Maintenance
 * Description: /services/website-maintenance-services/ (production URL kept, D-023; 66 clicks, 277,583 impressions / 16 months, avg position 32.6) - Website Maintenance service page. Provides [reinforce_maintenance]. Uses the shared kit (D-044). Hero animation "A month of care" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_mt() { return is_page('website-maintenance-services'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_mt_faqs() {
    return [
        ['What do website maintenance services include?', 'Website maintenance services keep a website secure, fast and working. They cover software updates for WordPress core, plugins and themes; off-site backups and restore tests; security and vulnerability monitoring; uptime monitoring; speed and Core Web Vitals; SEO health such as broken links, redirects and indexing errors; form and checkout testing; small content changes; and support when something goes wrong, with a monthly report.'],
        ['How often should a WordPress site be updated?', 'Security fixes should be applied as soon as they are available and tested, because attackers move fast: Patchstack found that heavily exploited WordPress vulnerabilities reached mass exploitation in a median of 5 hours. Routine updates are best applied on a regular schedule, tested on a staging copy first so nothing breaks on the live site.'],
        ['Aren’t automatic updates enough?', 'No. Updates only help once a fix exists, and Patchstack reports that 46% of WordPress vulnerabilities in 2025 had no fix from the developer by the time they were made public. Maintenance adds vulnerability monitoring, protection rules, tested backups and someone accountable when something breaks.'],
        ['Doesn’t our web host handle security?', 'Only part of it. WordPress’s own hardening guide notes that hosts are responsible for the infrastructure, not the application you install on it: your plugins, themes and settings. In Patchstack’s large-scale test of hosting companies, only 26% of vulnerability attacks were blocked.'],
        ['Do you maintain websites you didn’t build?', 'Yes. Every new site starts with an onboarding audit: we take a full backup, check updates, plugins, security, speed and SEO health, fix anything urgent, and then move the site onto the regular maintenance schedule.'],
        ['How much does website maintenance cost?', 'It depends on the size and complexity of the site: a brochure site needs less than a busy online store with many plugins and integrations. After the onboarding audit you get a monthly plan with the scope written down.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with maintenance points (D-047) */
function rl_mt_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Change logs suited to regulated content', 'Access reviews for every user and agency', 'Tested backups before every significant change']],
        ['healthcare', 'Healthcare', ['Booking and enquiry forms tested every week', 'Security monitoring for sites handling patient enquiries', 'Accessibility kept intact through updates']],
        ['b2b-saas', 'B2B SaaS', ['Marketing site kept fast while teams publish daily', 'Integrations and tracking checked after every update', 'Staging-first updates so launches aren’t broken']],
        ['ecommerce', 'E-commerce', ['Checkout and payments tested after every update', 'Store backups timed around orders', 'Plugin security watched closely on busy stores']],
        ['manufacturing', 'Manufacturing', ['Product and spec libraries kept working and fast', 'Quote forms and downloads tested regularly', 'Multilingual sites updated together']],
        ['technology', 'Technology', ['Documentation and resource hubs kept healthy', 'Performance monitored against Core Web Vitals', 'Security alerts acted on quickly']],
        ['professional-services', 'Professional Services', ['People and insight pages updated on request', 'Contact and booking forms always working', 'Confidential enquiries protected']],
        ['education', 'Education', ['Course pages and admissions forms kept current', 'Peak-season speed and uptime monitoring', 'Many editors, one set of safe permissions']],
    ];
}

/* ---------- hero animation: A month of care ----------
   Days of the month tick over as daily backups complete, with weekly update days marked; the status
   panel lights - uptime, backups, updates, security, speed; then a plugin vulnerability alert arrives
   and is handled - alert, check, patch, verify - before security turns green again; backup · update ·
   protect · report light in turn. 10 s loop, soft fade, reset. */
function rl_mt_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlMtT"><title id="rlMtT">Over a month, the website is backed up daily and updated weekly; uptime, backups, updates, security and speed are monitored; when a plugin vulnerability alert arrives it is checked, patched and verified.</title>';
    $s .= '<text class="t-lab" x="0" y="12">THIS MONTH</text>';
    for ($d = 0; $d < 28; $d++) {
        $c = $d % 7; $r = intdiv($d, 7); $x = $c * 35; $y = 22 + $r * 36;
        $wk = ($c === 2);
        $s .= '<rect class="t-day" x="' . $x . '" y="' . $y . '" width="29" height="30"/><rect class="t-dayon t-d' . $d . ($wk ? ' t-wk' : '') . '" x="' . $x . '" y="' . $y . '" width="29" height="30"/>';
        if ($wk) $s .= '<text class="t-u t-d' . $d . '" x="' . ($x + 14.5) . '" y="' . ($y + 19) . '" text-anchor="middle">UPD</text>';
    }
    $s .= '<rect class="t-alert" x="175" y="94" width="29" height="30"/>';
    $s .= '<text class="t-lab" x="0" y="190">INCIDENT</text>';
    foreach (['ALERT', 'CHECK', 'PATCH', 'VERIFY'] as $i => $t) {
        $x = $i * 62;
        if ($i) $s .= '<line class="t-ar" x1="' . ($x - 8) . '" y1="215" x2="' . $x . '" y2="215"/>';
        $s .= '<rect class="t-b" x="' . $x . '" y="200" width="54" height="30"/><rect class="t-on t-i' . $i . '" x="' . $x . '" y="200" width="54" height="30"/><text class="t-t" x="' . ($x + 27) . '" y="218.5" text-anchor="middle">' . $t . '</text>';
    }
    $s .= '<text class="t-lab" x="280" y="12">STATUS</text>';
    foreach (['UPTIME', 'BACKUPS', 'UPDATES', 'SECURITY', 'SPEED'] as $i => $t) {
        $y = 22 + $i * 46;
        $s .= '<rect class="t-b" x="280" y="' . $y . '" width="240" height="36"/><rect class="t-on t-s' . $i . '" x="280" y="' . $y . '" width="240" height="36"/><text class="t-st" x="294" y="' . ($y + 22) . '">' . $t . '</text>'
            . '<rect class="t-led t-l' . $i . '" x="494" y="' . ($y + 12) . '" width="12" height="12"/>';
    }
    $s .= '<rect class="t-warn" x="494" y="' . (22 + 3 * 46 + 12) . '" width="12" height="12"/><text class="t-wt" x="486" y="' . (22 + 3 * 46 + 22) . '" text-anchor="end">VULNERABLE PLUGIN</text><text class="t-ok" x="486" y="' . (22 + 3 * 46 + 22) . '" text-anchor="end">PATCHED</text>';
    $s .= '<line class="t-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['BACKUP', 'UPDATE', 'PROTECT', 'REPORT'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="t-ft" x="' . $x . '" y="372">' . $f . '</text><text class="t-ft t-fton t-f' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="t-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="t-fbon t-fb' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_mt_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = '';
    for ($d = 0; $d < 28; $d++) { $s = round(2 + $d * 1.25, 2); $k .= $lit("rlmtD$d", $s, $s + 1) . ".rl-mt .t-d$d{animation-name:rlmtD$d}\n"; }
    for ($i = 0; $i < 5; $i++) { $s = 4 + $i * 5; $k .= $lit("rlmtS$i", $s, $s + 3) . ".rl-mt .t-s$i,.rl-mt .t-l$i{animation-name:rlmtS$i}\n"; }
    /* security LED hides during the incident, returns once verified */
    $k .= "@keyframes rlmtS3b{0%,19%{opacity:0}22%,44%{opacity:1}45%,63%{opacity:0}66%,92%{opacity:1}97%,100%{opacity:0}}\n.rl-mt .t-l3{animation-name:rlmtS3b}\n";
    $k .= "@keyframes rlmtWarn{0%,44%{opacity:0}45%,48%{opacity:1}50%{opacity:.3}52%,63%{opacity:1}64%,100%{opacity:0}}\n";
    $k .= "@keyframes rlmtAlert{0%,44%{opacity:0}45%,48%{opacity:1}50%{opacity:.3}52%,63%{opacity:1}66%,100%{opacity:0}}\n";
    $k .= $lit('rlmtOk', 64, 67);
    foreach ([46, 51, 56, 61] as $i => $s) $k .= $lit("rlmtI$i", $s, $s + 2) . ".rl-mt .t-i$i{animation-name:rlmtI$i}\n";
    foreach ([2, 10, 46, 70] as $i => $s) $k .= $lit("rlmtF$i", $s, $s + 3) . "@keyframes rlmtFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-mt .t-f$i{animation-name:rlmtF$i}.rl-mt .t-fb$i{animation-name:rlmtFb$i}\n";
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_mt()) $c[] = 'rl-mt-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_mt(); });
add_action('wp_head', 'rl_mt_css', 22);
function rl_mt_css() {
    if (!rl_is_mt()) return; ?>
<style id="rl-mt-css">
body.rl-mt-page .fl-page-content,body.rl-mt-page .fl-content,body.rl-mt-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-mt .mtf{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-mt .mtf .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-mt .mtf .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-mt .mtf svg{display:block;width:100%;height:auto;overflow:visible}
.rl-mt .t-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-mt .t-day{fill:rgba(255,255,255,.03);stroke:rgba(243,237,230,.1);stroke-width:.6}
.rl-mt .t-dayon{fill:rgba(194,26,26,.28);stroke:rgba(226,59,59,.55);stroke-width:.6;opacity:0}
.rl-mt .t-wk{fill:rgba(194,26,26,.5)}
.rl-mt .t-u{font-family:var(--f-mono);font-size:7px;letter-spacing:.08em;fill:#fff;opacity:0}
.rl-mt .t-alert{fill:none;stroke:#fff;stroke-width:1.4;opacity:0;animation-name:rlmtAlert}
.rl-mt .t-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-mt .t-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.6);stroke-width:.8;opacity:0}
.rl-mt .t-t{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:var(--ink-dim)}
.rl-mt .t-ar{stroke:rgba(243,237,230,.2);stroke-width:.8}
.rl-mt .t-st{font-family:var(--f-mono);font-size:9px;letter-spacing:.16em;fill:var(--ink-dim)}
.rl-mt .t-led{fill:var(--red-2);opacity:0}
.rl-mt .t-warn{fill:#fff;opacity:0;animation-name:rlmtWarn}
.rl-mt .t-wt{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:#fff;opacity:0;animation-name:rlmtWarn}
.rl-mt .t-ok{font-family:var(--f-mono);font-size:8px;letter-spacing:.14em;fill:var(--red-3);opacity:0;animation-name:rlmtOk}
.rl-mt .t-rule{stroke:var(--line-2);stroke-width:1}
.rl-mt .t-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-mt .t-fton{fill:var(--ink);opacity:0}
.rl-mt .t-fb{fill:rgba(255,255,255,.08)}
.rl-mt .t-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-mt .t-dayon,.rl-mt .t-u,.rl-mt .t-alert,.rl-mt .t-on,.rl-mt .t-led,.rl-mt .t-warn,.rl-mt .t-wt,.rl-mt .t-ok,.rl-mt .t-fton,.rl-mt .t-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-mt .t-st{font-size:10.5px;letter-spacing:.04em}.rl-mt .t-t,.rl-mt .t-wt,.rl-mt .t-ok{font-size:9.5px;letter-spacing:0}.rl-mt .t-lab{font-size:9.5px;letter-spacing:.06em}.rl-mt .t-u{font-size:8.5px;letter-spacing:0}.rl-mt .t-ft{font-size:11px;letter-spacing:.04em}.rl-mt .mtf .cap span+span{display:none}.rl-mt .mtf{padding:16px 10px 10px}}
<?php echo rl_mt_kf(); ?>
.rl-mt .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-mt .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_mt() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'Website Maintenance Services', 'alternateName' => ['Website maintenance', 'WordPress maintenance', 'Website support services'],
        'serviceType' => 'Website maintenance and support', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'Website maintenance services for WordPress sites: tested updates, off-site backups and restore tests, security and vulnerability monitoring, uptime monitoring, Core Web Vitals, SEO health checks, form and checkout testing, content changes and support, with a monthly report.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_mt_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_maintenance', 'rl_render_maintenance');
function rl_render_maintenance() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $ps = esc_url('https://patchstack.com/whitepaper/state-of-wordpress-security-in-2026/');
    $hard = esc_url('https://developer.wordpress.org/advanced-administration/security/hardening/');
    $upg = esc_url('https://wordpress.org/documentation/article/configuring-automatic-background-updates/');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-mt">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">Website Maintenance</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;Website Maintenance&nbsp;<b>]</b></span>
      <h1 class="h1">Website maintenance<br>that keeps you<br><span class="r">secure and fast.</span></h1>
      <p class="lede"><strong>Website maintenance services</strong> keep your website secure, fast and working: tested updates, off-site backups, security and vulnerability monitoring, uptime checks, speed and SEO health, content changes and support when something breaks. Reinforce Lab maintains WordPress sites on a set schedule and reports every month on what was done and what was found.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#schedule">See the schedule</a>
      </div>
    </div>
    <figure class="mtf rl-anim">
      <div class="cap" aria-hidden="true"><span>Website care</span><span>Backup · update · protect · report</span></div>
      <?php echo rl_mt_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Every month', 'kind' => 'steps', 'items' => ['Backup', 'Update', 'Protect', 'Report']], ['label' => 'Incident', 'kind' => 'steps', 'items' => [['Alert: vulnerable plugin', 'x'], 'Check', 'Patch', ['Verified · patched', 'ok']]], ['label' => 'Status', 'kind' => 'chips', 'items' => [['Uptime', 'ok'], ['Backups', 'ok'], ['Updates', 'ok'], ['Security', 'ok'], ['Speed', 'ok']]]], 'Backup · update · protect · report'); ?></figure>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What's included&nbsp;<b>]</b></span><h2>What do our website maintenance services include?</h2><p class="lede">Everything that keeps a WordPress site safe, fast and working, so your team can focus on the business.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Updates</span><h3>Tested updates</h3><p>WordPress core, plugins and themes updated, tested on a staging copy first.</p></div>
      <div class="cell"><span class="n">02 · Backups</span><h3>Off-site backups</h3><p>Regular backups stored away from your server, with restores tested so you know they work.</p></div>
      <div class="cell"><span class="n">03 · Security</span><h3>Security monitoring</h3><p>Vulnerability alerts, protection rules and malware scans, acted on quickly.</p></div>
      <div class="cell"><span class="n">04 · Uptime</span><h3>Uptime monitoring</h3><p>Checks around the clock, with alerts the moment your site goes down.</p></div>
      <div class="cell"><span class="n">05 · Speed</span><h3>Speed &amp; Core Web Vitals</h3><p>Loading, responsiveness and stability tracked and kept within Google's thresholds.</p></div>
      <div class="cell"><span class="n">06 · SEO</span><h3>SEO health</h3><p>Broken links, redirects, indexing errors and Search Console warnings found and fixed.</p></div>
      <div class="cell"><span class="n">07 · Testing</span><h3>Forms &amp; checkout</h3><p>Enquiry forms, bookings and checkouts tested so leads and orders keep arriving.</p></div>
      <div class="cell"><span class="n">08 · Changes</span><h3>Content &amp; small changes</h3><p>Text, images, pages and small design changes done for you.</p></div>
      <div class="cell"><span class="n">09 · Support</span><h3>Support &amp; fixes</h3><p>A named team to call when something breaks, with every fix logged.</p></div>
    </div>
  </div>
</section>

<section id="risk">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Why it matters&nbsp;<b>]</b></span><h2>Why does WordPress need regular maintenance?</h2><p class="lede">Because the risk is in the add-ons, and it moves fast. Patchstack's analysis of 2025 shows the scale.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">11,334</span><h3>New vulnerabilities</h3><p>found in the WordPress ecosystem in 2025, a 42% increase on 2024.</p></div>
      <div class="metric"><span class="num">91%</span><h3>In plugins</h3><p>of them were in plugins and 9% in themes. Only six were in WordPress core.</p></div>
      <div class="metric"><span class="num">5 hrs</span><h3>To mass exploitation</h3><p>the median time for heavily exploited vulnerabilities to be attacked at scale.</p></div>
    </div>
    <p class="quote">"Fundamentally, security is not about perfectly secure systems… What security is though is risk reduction, not risk elimination."<br>WordPress.org, Hardening WordPress</p>
    <p class="src">Sources: Patchstack, <a href="<?php echo $ps; ?>" rel="noopener" target="_blank">State of WordPress Security in 2026</a> (updated 25 February 2026) · WordPress.org, <a href="<?php echo $hard; ?>" rel="noopener" target="_blank">Hardening WordPress</a></p>
  </div>
</section>

<section class="band alt" id="schedule">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Schedule&nbsp;<b>]</b></span><h2>What happens every day, week and month?</h2><p class="lede">A fixed routine, so nothing depends on someone remembering.</p></div>
    <div class="tscroll" role="region" aria-label="Website maintenance schedule" tabindex="0">
      <table>
        <thead><tr><th scope="col">How often</th><th scope="col">What we do</th><th scope="col">Why it matters</th></tr></thead>
        <tbody>
          <tr><th scope="row">Continuously</th><td>Uptime monitoring, vulnerability alerts and protection rules</td><td>Problems are caught before your customers find them.</td></tr>
          <tr><th scope="row">Daily</th><td>Off-site backups</td><td>A recent restore point is always available.</td></tr>
          <tr><th scope="row">Weekly</th><td>Updates tested on staging, then applied; forms and checkout tested</td><td>Fixes arrive quickly without breaking the live site.</td></tr>
          <tr><th scope="row">Monthly</th><td>Speed and Core Web Vitals review, SEO health check, backup restore test, report</td><td>You see what was done, what was found and what's next.</td></tr>
          <tr><th scope="row">Quarterly</th><td>User and access review, plugin audit</td><td>Old accounts and unused plugins are removed before they become a risk.</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="myths">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Myths&nbsp;<b>]</b></span><h2>Is it enough to turn on automatic updates?</h2><p class="lede">Four assumptions that leave WordPress sites exposed, and what the evidence says.</p></div>
    <div class="myths">
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Automatic updates keep us safe."</p></div><div class="f"><span class="tag">Patchstack found</span><p>46% of vulnerabilities had no fix from the developer by the time they were made public, so there was nothing to update to.</p><a href="<?php echo $ps; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Our host takes care of security."</p></div><div class="f"><span class="tag">The evidence</span><p>WordPress.org notes hosts are responsible for the infrastructure, not the application you install. In Patchstack's test of hosting companies, only 26% of vulnerability attacks were blocked.</p><a href="<?php echo $hard; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"We have backups, so we're covered."</p></div><div class="f"><span class="tag">WordPress.org says</span><p>Verify the backups you created are there and usable: "This is essential." A backup you have never restored is a hope, not a plan.</p><a href="<?php echo $upg; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
      <div class="myth"><div class="m"><span class="tag">Myth</span><p>"Premium plugins are safer than free ones."</p></div><div class="f"><span class="tag">Patchstack found</span><p>Premium components had three times more known exploited vulnerabilities than free ones in 2025.</p><a href="<?php echo $ps; ?>" rel="noopener" target="_blank">Source &rarr;</a></div></div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does website maintenance start?</h2><p class="lede">An audit first, so we know exactly what we're looking after.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Onboard</h3><p>Access, a full backup and a record of how the site is set up.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Audit</h3><p>Updates, plugins, security, speed, SEO health and forms checked.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Stabilise</h3><p>Anything urgent fixed before the routine begins.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Maintain</h3><p>The daily, weekly and monthly schedule runs.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Report</h3><p>A monthly report on what was done, found and recommended.</p></li>
    </ol>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Onboarding audit</b>: the state of your site, with urgent issues fixed.</li>
      <li><b>Maintenance schedule</b>: backups, updates, checks and reviews on a fixed routine.</li>
      <li><b>Staging site</b>: where every update is tested before it goes live.</li>
      <li><b>Security monitoring</b>: vulnerability alerts, protection rules and malware scans.</li>
      <li><b>Uptime monitoring</b>: alerts the moment the site goes down.</li>
      <li><b>Change log</b>: every update, fix and change recorded.</li>
      <li><b>Support</b>: a named team for fixes and content changes.</li>
      <li><b>Monthly report</b>: uptime, updates, backups, security, speed and SEO health.</li>
    </ul>
  </div>
</section>

<section class="band alt" id="measure">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Reporting&nbsp;<b>]</b></span><h2>What does the monthly report show?</h2><p class="lede">Facts, not reassurance.</p></div>
    <div class="cols c3">
      <div class="metric"><h3>Uptime</h3><p>How long the site was available, and any outages with their cause.</p></div>
      <div class="metric"><h3>Updates applied</h3><p>Which updates were tested and applied, and anything held back.</p></div>
      <div class="metric"><h3>Backups &amp; restores</h3><p>Backups completed and the result of the latest restore test.</p></div>
      <div class="metric"><h3>Security</h3><p>Vulnerabilities found, protected and patched, and any threats blocked.</p></div>
      <div class="metric"><h3>Speed</h3><p>Core Web Vitals and page speed against Google's thresholds.</p></div>
      <div class="metric"><h3>SEO health</h3><p>Broken links, redirect and indexing issues found and fixed.</p></div>
    </div>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>No one can promise a site will never be hacked.</h2>
      <p>What maintenance can promise is that risk is kept low, problems are spotted fast, and there is always a tested backup to fall back on. We would rather tell you that honestly than sell you a guarantee, and we'll show you, every month, exactly what we did to keep your site safe.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who is website maintenance for?</h2><p class="lede">Any business whose website brings in leads or orders, and can't afford to be down, slow or hacked.</p></div>
    <ul class="inds8">
      <?php foreach (rl_mt_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Website maintenance for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with website maintenance?</h2><p class="lede">A well-maintained site is the base. These services build on it.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/wordpress-website-design-service', 'Websites', 'WordPress Website Design', 'New WordPress sites built to rank and convert.'],
          ['services/ecommerce-website-design-service', 'Stores', 'E-commerce Website Design', 'Online stores built to be found and bought from.'],
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Crawling, indexing and speed at the template level.'],
          ['services/best-search-engine-optimization-services', 'Search', 'Search Engine Optimization', 'Organic visibility for a site that is already healthy.'],
          ['services/ai-workflow-automation', 'Operations', 'AI Workflow Automation', 'Automate the busywork around your website and business.'],
          ['services/seo-ai-search-audit', 'Starting point', 'SEO & AI Search Audit', 'A full review of your site, search and AI visibility.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About website maintenance.</h2></div>
    <?php foreach (rl_mt_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>When was your website last backed up, and tested?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your site's health, speed and search visibility, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services'); ?>">All services</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
