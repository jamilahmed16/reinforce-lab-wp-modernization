<?php
/**
 * Plugin Name: Reinforce Lab - Mail (SMTP)
 * Description: Sends every WordPress email (Contact, Diagnostic, Audit forms) through Titan Email SMTP, authenticated as a reinforcelab.com mailbox, so messages pass SPF (spf.titan.email) and DKIM (titan1._domainkey.reinforcelab.com) instead of leaving the web server as wordpress@reinforcelab.online (F-028 C4). No plugin. Switched on only when wp-config.php defines RL_SMTP_USER and RL_SMTP_PASS (secrets never in git); otherwise WordPress keeps its default mail. Optional: RL_SMTP_HOST (default smtp.titan.email), RL_SMTP_PORT (default 465, SSL).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_smtp_on() { return defined('RL_SMTP_USER') && defined('RL_SMTP_PASS') && RL_SMTP_USER !== '' && RL_SMTP_PASS !== ''; }

add_action('phpmailer_init', function ($m) {
    if (!rl_smtp_on()) return;
    $m->isSMTP();
    $m->Host = defined('RL_SMTP_HOST') ? RL_SMTP_HOST : 'smtp.titan.email';
    $m->Port = defined('RL_SMTP_PORT') ? (int) RL_SMTP_PORT : 465;
    $m->SMTPSecure = $m->Port === 587 ? 'tls' : 'ssl';
    $m->SMTPAuth = true;
    $m->Username = RL_SMTP_USER;
    $m->Password = RL_SMTP_PASS;
    $m->Timeout = 15;
    $m->Sender = RL_SMTP_USER; // envelope sender, for SPF alignment
});

/* the From line: the authenticated mailbox, shown as "Reinforce Lab" (brand rule) */
add_filter('wp_mail_from', function ($from) { return rl_smtp_on() ? RL_SMTP_USER : $from; }, 20);
add_filter('wp_mail_from_name', function () { return 'Reinforce Lab'; }, 20);

/* keep the last failure (no secrets) so a broken mailbox shows up in a check instead of silently */
add_action('wp_mail_failed', function ($err) {
    update_option('rl_mail_last_error', ['time' => current_time('mysql'), 'smtp' => rl_smtp_on(), 'message' => mb_substr($err->get_error_message(), 0, 300)], false);
});
