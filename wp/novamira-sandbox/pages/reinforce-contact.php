<?php
/**
 * Plugin Name: Reinforce Lab - Contact
 * Description: /contact-us/ (APPROVED - PRESERVE, rebuilt to the D-012 standard). Provides [reinforce_contact] and the contact-form handler, which reuses the Diagnostic pipeline: stores a private rl_diag_request entry (request_type "Contact message"), emails hello@reinforcelab.com, and forwards JSON to rl_diag_webhook_url when set. Uses the shared kit (D-044). No hero animation (Contact is excluded, D-039). Schema: ContactPage + Organization contactPoint/location + FAQPage.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_contact() { return is_page('contact-us') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }

/* Contact facts: identical to the approved footer (D-011/D-021) and the production /contact-us/ page. */
function rl_contact_info() {
    return [
        'email' => 'hello@reinforcelab.com',
        'offices' => [
            ['Bangladesh', 'Dhaka', ['Suite #1402, Level-13, Concord Tower', '113 Kazi Nazrul Islam Avenue', 'Dhaka 1000, Bangladesh'], '+880 1329-657096', '+8801329657096', ['streetAddress' => 'Suite #1402, Level-13, Concord Tower, 113 Kazi Nazrul Islam Avenue', 'addressLocality' => 'Dhaka', 'postalCode' => '1000', 'addressCountry' => 'BD']],
            ['United States', 'Katy, Texas', ['2511 Pines Pointe Dr', 'Katy, TX 77493, USA'], '+1 832 548 4553', '+18325484553', ['streetAddress' => '2511 Pines Pointe Dr', 'addressLocality' => 'Katy', 'addressRegion' => 'TX', 'postalCode' => '77493', 'addressCountry' => 'US']],
        ],
    ];
}
function rl_contact_topics() { return ['A new project', 'The free Search Authority Diagnostic', 'An existing engagement', 'Partnerships or press', 'Something else']; }
function rl_contact_faqs() {
    return [
        ['How do I contact Reinforce Lab?', 'Email hello@reinforcelab.com, call +880 1329-657096 in Bangladesh or +1 832 548 4553 in the United States, or send a message with the form on this page.'],
        ['Where are Reinforce Lab’s offices?', 'Reinforce Lab has two offices: Concord Tower, 113 Kazi Nazrul Islam Avenue, Dhaka, Bangladesh, and 2511 Pines Pointe Dr, Katy, Texas, USA.'],
        ['Should I send a message or request the diagnostic?', 'If you want a review of your search visibility, request the free Search Authority Diagnostic. It collects the details we need to prepare it. For anything else, send a message here.'],
        ['Do you work with clients outside Bangladesh and the United States?', 'Yes. Reinforce Lab works with clients around the world, remotely.'],
    ];
}

/* ---------- form handler (admin-post.php; works for visitors and logged-in users) ---------- */
add_action('admin_post_nopriv_rl_contact_msg', 'rl_contact_handle');
add_action('admin_post_rl_contact_msg', 'rl_contact_handle');
function rl_contact_handle() {
    $back = function_exists('rl_url_by_path') ? rl_url_by_path('contact-us', home_url('/')) : home_url('/');
    $go = function ($state) use ($back) { wp_safe_redirect(add_query_arg('sent', $state, $back) . '#message'); exit; };
    $f = wp_unslash($_POST);

    // spam layers (same as the Diagnostic): honeypot, too-fast submit (<3s), 5 messages / hour / IP. Bots get a fake success.
    if (!empty($f['rl_hp'])) $go('ok');
    $ts = isset($f['rl_ts']) ? (int) $f['rl_ts'] : 0;
    if ($ts && time() - $ts < 3) $go('ok');
    $rk = 'rl_contact_rl_' . md5((string) ($_SERVER['REMOTE_ADDR'] ?? ''));
    $hits = (int) get_transient($rk);
    if ($hits >= 5) $go('limit');
    set_transient($rk, $hits + 1, HOUR_IN_SECONDS);

    $cut = function ($v) { return mb_substr(sanitize_text_field((string) $v), 0, 200); };
    $topic = (string) ($f['topic'] ?? '');
    $d = [
        'name' => $cut($f['name'] ?? ''),
        'email' => sanitize_email($f['email'] ?? ''),
        'company' => $cut($f['company'] ?? ''),
        'website' => esc_url_raw(mb_substr((string) ($f['website'] ?? ''), 0, 200)),
        'topic' => in_array($topic, rl_contact_topics(), true) ? $topic : '',
        'message' => mb_substr(sanitize_textarea_field((string) ($f['message'] ?? '')), 0, 3000),
    ];
    if ($d['name'] === '' || !is_email($d['email']) || trim($d['message']) === '') $go('invalid');

    $id = wp_insert_post(['post_type' => 'rl_diag_request', 'post_status' => 'private', 'post_title' => '[Contact] ' . ($d['company'] !== '' ? $d['company'] . ' ' : '') . $d['name']], true);
    if (is_wp_error($id) || !$id) $go('error');
    foreach ($d as $k => $v) update_post_meta($id, $k, $v);
    update_post_meta($id, 'submitted_at', current_time('mysql'));
    update_post_meta($id, 'request_type', 'Contact message');

    $labels = ['name' => 'Name', 'email' => 'Email', 'company' => 'Company', 'website' => 'Website', 'topic' => 'About', 'message' => 'Message'];
    $body = "New contact message\n\n";
    foreach ($labels as $k => $l) $body .= $l . ': ' . ($d[$k] !== '' ? $d[$k] : 'not given') . "\n";
    $body .= "\nSaved in WordPress: " . admin_url('post.php?post=' . $id . '&action=edit') . "\n";
    $sent = wp_mail(rl_contact_info()['email'], 'Contact message: ' . ($d['company'] !== '' ? $d['company'] : $d['name']), $body, ['Reply-To: ' . $d['name'] . ' <' . $d['email'] . '>']);
    update_post_meta($id, 'email_sent', $sent ? 'yes' : 'no');

    $hook = trim((string) get_option('rl_diag_webhook_url', ''));
    if ($hook !== '') {
        wp_remote_post($hook, ['timeout' => 5, 'blocking' => false, 'headers' => ['Content-Type' => 'application/json'],
            'body' => wp_json_encode(['type' => 'contact_message', 'id' => $id, 'submitted_at' => current_time('c'), 'data' => $d])]);
        update_post_meta($id, 'webhook_sent', 'queued');
    }
    $go('ok');
}

add_filter('body_class', function ($c) { if (rl_is_contact()) $c[] = 'rl-contact-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_contact(); });
add_action('wp_head', 'rl_contact_css', 22);
function rl_contact_css() {
    if (!rl_is_contact()) return; ?>
<style id="rl-contact-css">
body.rl-contact-page .fl-page-content,body.rl-contact-page .fl-content,body.rl-contact-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-contact .hero-grid{align-items:start}
.rl-contact .direct{list-style:none;margin:26px 0 0;padding:0;border-top:1px solid var(--line)}
.rl-contact .direct li{display:grid;grid-template-columns:110px 1fr;gap:14px;padding:13px 0;border-bottom:1px solid var(--line)}
.rl-contact .direct .l{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);padding-top:3px}
.rl-contact .direct a{color:var(--ink);border-bottom:1px solid var(--red-line)}
.rl-contact .direct a:hover{color:var(--red-3)}
.rl-contact .form{background:var(--glass);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border:1px solid var(--glass-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 30px 70px -44px rgba(0,0,0,.95);padding:26px;position:relative;scroll-margin-top:110px}
.rl-contact .form .ft{font-family:var(--f-display);text-transform:uppercase;font-size:19px;font-weight:600;display:block}
.rl-contact .form .fs{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);letter-spacing:.1em;text-transform:uppercase;margin-top:4px;display:block}
.rl-contact .grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:18px}
.rl-contact .field{display:flex;flex-direction:column;gap:6px}
.rl-contact .field.full{grid-column:1/-1}
.rl-contact .field label{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-contact .field .req{color:var(--red-3)}
.rl-contact .field input,.rl-contact .field select,.rl-contact .field textarea{font-family:var(--f-body);font-size:14px;background:var(--bg);border:1px solid var(--line-2);color:var(--ink);padding:11px 12px;border-radius:0;transition:.15s;width:100%}
.rl-contact .field textarea{min-height:130px;resize:vertical}
.rl-contact .field input:focus,.rl-contact .field select:focus,.rl-contact .field textarea:focus{outline:none;border-color:var(--red-2);box-shadow:0 0 0 1px var(--red-line)}
.rl-contact .field select{appearance:none;background-image:linear-gradient(45deg,transparent 50%,var(--ink-faint) 50%),linear-gradient(135deg,var(--ink-faint) 50%,transparent 50%);background-position:calc(100% - 18px) 50%,calc(100% - 13px) 50%;background-size:5px 5px,5px 5px;background-repeat:no-repeat}
.rl-contact .form .note{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint);margin-top:14px;line-height:1.7}
.rl-contact .form .note a{color:var(--ink-dim);border-bottom:1px solid var(--red-line)}
.rl-contact .hp{position:absolute!important;left:-9999px;width:1px;height:1px;overflow:hidden}
.rl-contact .alert{margin-top:14px;padding:12px 14px;border:1px solid var(--red-2);background:rgba(153,0,0,.12);font-size:14px;color:var(--ink)}
.rl-contact .ok{text-align:center;padding:30px 10px}
.rl-contact .ok .m{font-family:var(--f-display);text-transform:uppercase;font-size:22px;margin-bottom:10px}
.rl-contact .ok p{color:var(--ink-dim);font-size:14px}
.rl-contact .ok .btn{margin-top:18px}
.rl-contact .office p{color:var(--ink-dim);font-size:15.5px;margin:0}
.rl-contact .office a{color:var(--ink);border-bottom:1px solid var(--red-line)}
@media(min-width:1001px){.rl-contact .steps{grid-template-columns:repeat(3,1fr)}}
@media(max-width:560px){.rl-contact .grid2{grid-template-columns:1fr}.rl-contact .form{padding:20px 16px}.rl-contact .direct li{grid-template-columns:1fr;gap:4px}}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_contact()) return $graph;
    $url = get_permalink(get_queried_object_id());
    $org = home_url('/#organization');
    $c = rl_contact_info();
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if (in_array('WebPage', $t, true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) { $n['@type'] = ['WebPage', 'ContactPage']; $n['about'] = ['@id' => $org]; }
        if (in_array('Organization', $t, true)) {
            $n['email'] = $c['email'];
            $n['contactPoint'] = array_map(function ($o) use ($c) { return ['@type' => 'ContactPoint', 'contactType' => 'customer service', 'telephone' => $o[4], 'email' => $c['email'], 'areaServed' => $o[5]['addressCountry']]; }, $c['offices']);
            $n['location'] = array_map(function ($o) { return ['@type' => 'Place', 'name' => 'Reinforce Lab, ' . $o[1], 'telephone' => $o[4], 'address' => ['@type' => 'PostalAddress'] + $o[5]]; }, $c['offices']);
        }
    }
    unset($n);
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_contact_faqs())];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_contact', 'rl_render_contact');
function rl_render_contact() {
    if (!rl_is_contact()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $c = rl_contact_info();
    $state = isset($_GET['sent']) ? sanitize_key($_GET['sent']) : '';
    $msgs = ['invalid' => 'Please add your name, a valid email and a message.', 'limit' => 'Too many messages from this connection. Please try again in an hour or email hello@reinforcelab.com.', 'error' => 'Something went wrong sending your message. Please try again or email hello@reinforcelab.com.'];
    $privacy = get_permalink(3);
    ob_start(); ?>
<div class="rl-page rl-contact">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Contact</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Contact&nbsp;<b>]</b></span>
      <h1 class="h1">Contact<br>Reinforce Lab.<br><span class="r">Let’s talk growth.</span></h1>
      <p class="lede"><strong>Email <a href="mailto:<?php echo esc_attr($c['email']); ?>"><?php echo esc_html($c['email']); ?></a></strong>, call our Dhaka or Katy, Texas office, or send a message with the form. Tell us what you want to grow and we’ll reply with the next step.</p>
      <ul class="direct">
        <li><span class="l">Email</span><span><a href="mailto:<?php echo esc_attr($c['email']); ?>"><?php echo esc_html($c['email']); ?></a></span></li>
        <?php foreach ($c['offices'] as $o) { ?>
        <li><span class="l"><?php echo esc_html($o[0]); ?></span><span><a href="tel:<?php echo esc_attr($o[4]); ?>"><?php echo esc_html($o[3]); ?></a></span></li>
        <?php } ?>
      </ul>
    </div>

    <div class="form" id="message">
      <?php if ($state === 'ok') { ?>
      <div class="ok" role="status">
        <div class="m">Message received</div>
        <p>Thank you. Your message has reached the Reinforce Lab team, and we’ll reply by email. Want a head start? Request the free diagnostic.</p>
        <a class="btn g" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
      </div>
      <?php } else { ?>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="rl_contact_msg">
        <input type="hidden" name="rl_ts" value="<?php echo (int) time(); ?>">
        <div class="hp" aria-hidden="true"><label for="rl_hp">Leave this field empty</label><input id="rl_hp" name="rl_hp" tabindex="-1" autocomplete="off"></div>
        <span class="ft">Send us a message</span>
        <span class="fs">We reply by email</span>
        <?php if (isset($msgs[$state])) echo '<p class="alert" role="alert">' . esc_html($msgs[$state]) . '</p>'; ?>
        <div class="grid2">
          <div class="field"><label for="name">Full name <span class="req" aria-hidden="true">*</span></label><input id="name" name="name" autocomplete="name" maxlength="200" required></div>
          <div class="field"><label for="email">Email <span class="req" aria-hidden="true">*</span></label><input id="email" name="email" type="email" autocomplete="email" maxlength="200" required></div>
          <div class="field"><label for="company">Company</label><input id="company" name="company" autocomplete="organization" maxlength="200"></div>
          <div class="field"><label for="website">Website</label><input id="website" name="website" type="url" placeholder="https://" autocomplete="url" maxlength="200"></div>
          <div class="field full"><label for="topic">What is it about?</label><select id="topic" name="topic"><option value="">Select…</option><?php foreach (rl_contact_topics() as $t) echo '<option>' . esc_html($t) . '</option>'; ?></select></div>
          <div class="field full"><label for="msg">Message <span class="req" aria-hidden="true">*</span></label><textarea id="msg" name="message" maxlength="3000" required></textarea></div>
        </div>
        <button class="btn p" type="submit" style="margin-top:18px;width:100%;justify-content:center">Send message <span class="ar">&rarr;</span></button>
        <p class="note">We use your details only to reply to your message. See our <a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a>.</p>
      </form>
      <?php } ?>
    </div>
  </div>
</section>

<section class="band alt" id="offices">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Offices&nbsp;<b>]</b></span><h2>Where are Reinforce Lab’s offices?</h2><p class="lede">Two offices (Dhaka and Katy, Texas) and clients around the world.</p></div>
    <div class="cols c2">
      <?php foreach ($c['offices'] as $o) { ?>
      <div class="cell office"><span class="n"><?php echo esc_html($o[0]); ?></span><h3><?php echo esc_html($o[1]); ?></h3><p><?php echo implode('<br>', array_map('esc_html', $o[2])); ?><br><a href="tel:<?php echo esc_attr($o[4]); ?>"><?php echo esc_html($o[3]); ?></a></p></div>
      <?php } ?>
    </div>
  </div>
</section>

<section id="next">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What happens next&nbsp;<b>]</b></span><h2>What happens after you get in touch?</h2><p class="lede">Three steps, no sales script.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>We read it</h3><p>Your message goes straight to the Reinforce Lab team, not a ticket queue.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>We reply</h3><p>By email, with answers or the questions we need answered first.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>We suggest a next step</h3><p>Usually the free diagnostic, or a straight answer if we’re not the right fit.</p></li>
    </ol>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>Contacting Reinforce Lab.</h2></div>
    <?php foreach (rl_contact_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Want a review of your search visibility?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('about-us'); ?>">About Reinforce Lab</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
