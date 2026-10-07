<?php
/**
 * Plugin Name: Reinforce Lab - Search Authority Diagnostic
 * Description: /search-authority-diagnostic/ (design: claude/design-previews/search-authority-diagnostic.html). Provides [reinforce_diagnostic] and the request-form handler: stores a private ACF "Diagnostic Request", emails RL_DIAG_NOTIFY, and forwards JSON to the webhook in option rl_diag_webhook_url when set (empty = off). Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

define('RL_DIAG_NOTIFY', 'hello@reinforcelab.com');

function rl_is_diag() { return is_page('search-authority-diagnostic'); }

/* ---------- single source for form choices, FAQ and description ---------- */
function rl_diag_choices() {
    return [
        'industry' => ['Pharmaceutical & Life Sciences', 'Healthcare', 'B2B SaaS', 'E-commerce', 'Manufacturing', 'Technology', 'Professional Services (incl. Finance)', 'Education', 'Other'],
        'challenge' => ['Low organic visibility', 'Declining rankings', 'Poor AI-search visibility', "Content isn't generating results", 'Competitors are outperforming us', 'Need a scalable content system', 'Need better SEO / AEO / GEO', 'Need enterprise search intelligence'],
        'volume' => ['1 to 10', '11 to 30', '31 to 50', '50+'],
    ];
}
function rl_diag_faqs() {
    // [question, answer, optional link path, optional link label]
    return [
        ['Is the Search Authority Diagnostic free?', 'Yes. The diagnostic is free. It is the first step before any engagement and establishes your real baseline before anything is built.', 'packages', 'See packages'],
        ['What does the diagnostic include?', 'A review of seven dimensions of search authority: organic search, AI search, content authority, competitors, search demand, customer voice and technical foundation, each with its evidence and gap, plus a prioritized 90-day plan covering what to create, what to improve and what to stop.'],
        ['Does it cover AI search like ChatGPT, Perplexity and AI Overviews?', 'Yes. We review your brand mentions, citations and entity visibility across ChatGPT, Perplexity and Google AI Overviews alongside your Google rankings, so you see where you stand in both.'],
        ['Who is the diagnostic for?', 'Organizations with a real search opportunity, from enterprise teams in pharma, life sciences, healthcare and finance to established and early-stage businesses. Enterprise requests get priority review; established businesses also get a strategy call.'],
        ['What happens after I request it?', 'We review your details, research your site, search data, competitors and AI visibility, and pass the findings through a human quality check. You then receive your diagnostic and a prioritized 90-day plan.'],
        ['Am I obligated to buy anything afterwards?', 'No. The diagnostic is free with no obligation. If you want help acting on the plan, we will recommend the package that fits, or you can implement it yourself.'],
        ['Is my information confidential?', 'Yes. Your details are used only to prepare your diagnostic and to contact you about it.'],
        ['How is this different from the paid SEO & AI Search Audit?', 'The diagnostic is a free, focused read of where you stand and what to do next. The SEO & AI Search Audit is a paid, one-time deep audit for teams that need the full technical and content analysis.', 'services/seo-ai-search-audit', 'About the SEO &amp; AI Search Audit'],
    ];
}
define('RL_DIAG_DESC', 'The Search Authority Diagnostic is a free, data-backed review from Reinforce Lab of your Google visibility, AI-search presence, content authority, competitors and demand signals, with a prioritized 90-day plan.');

/* ---------- form handler (admin-post.php; works for visitors and logged-in users) ---------- */
add_action('admin_post_nopriv_rl_diag_request', 'rl_diag_handle');
add_action('admin_post_rl_diag_request', 'rl_diag_handle');
function rl_diag_handle() {
    $back = function_exists('rl_url_by_path') ? rl_url_by_path('search-authority-diagnostic', home_url('/')) : home_url('/');
    $go = function ($state) use ($back) { wp_safe_redirect(add_query_arg('diag', $state, $back) . '#request'); exit; };
    $f = wp_unslash($_POST);

    // spam layers: honeypot, too-fast submit (<3s), 5 requests / hour / IP. Bots get a fake success.
    if (!empty($f['rl_hp'])) $go('ok');
    $ts = isset($f['rl_ts']) ? (int) $f['rl_ts'] : 0;
    if ($ts && time() - $ts < 3) $go('ok');
    $rk = 'rl_diag_rl_' . md5((string) ($_SERVER['REMOTE_ADDR'] ?? ''));
    $hits = (int) get_transient($rk);
    if ($hits >= 5) $go('limit');
    set_transient($rk, $hits + 1, HOUR_IN_SECONDS);

    $cut = function ($v) { return mb_substr(sanitize_text_field((string) $v), 0, 200); };
    $choices = rl_diag_choices();
    $pick = function ($k) use ($f, $choices) { $v = (string) ($f[$k] ?? ''); return in_array($v, $choices[$k], true) ? $v : ''; };
    $d = [
        'name' => $cut($f['name'] ?? ''),
        'email' => sanitize_email($f['email'] ?? ''),
        'company' => $cut($f['company'] ?? ''),
        'website' => esc_url_raw(mb_substr((string) ($f['website'] ?? ''), 0, 200)),
        'role' => $cut($f['role'] ?? ''),
        'industry' => $pick('industry'),
        'challenge' => $pick('challenge'),
        'volume' => $pick('volume'),
        'outcome' => $cut($f['outcome'] ?? ''),
    ];
    if ($d['name'] === '' || $d['company'] === '' || !is_email($d['email']) || empty($f['consent'])) $go('invalid');
    // request type (D-053): the audit page links here with ?interest=audit → hidden field; anything else = diagnostic
    $audit = (($f['interest'] ?? '') === 'audit');
    $type = $audit ? 'SEO & AI Search Audit' : 'Search Authority Diagnostic';

    $id = wp_insert_post(['post_type' => 'rl_diag_request', 'post_status' => 'private', 'post_title' => ($audit ? '[Audit] ' : '') . $d['company'] . ' ' . $d['name']], true);
    if (is_wp_error($id) || !$id) $go('error');
    $save = function ($k, $v) use ($id) { function_exists('update_field') ? update_field($k, $v, $id) : update_post_meta($id, $k, $v); };
    foreach ($d as $k => $v) $save($k, $v);
    $save('submitted_at', current_time('mysql'));
    update_post_meta($id, 'request_type', $type);
    update_post_meta($id, 'consent', 'yes, ' . current_time('mysql') . ', form notice of 5 Oct 2026 (D-123)');

    $labels = ['name' => 'Name', 'email' => 'Email', 'company' => 'Company', 'website' => 'Website', 'role' => 'Role', 'industry' => 'Industry', 'challenge' => 'Biggest challenge', 'volume' => 'Monthly content volume', 'outcome' => 'Desired outcome'];
    $body = "New " . $type . " request\n\n";
    foreach ($labels as $k => $l) $body .= $l . ': ' . ($d[$k] !== '' ? $d[$k] : 'not given') . "\n";
    $body .= "\nSaved in WordPress: " . admin_url('post.php?post=' . $id . '&action=edit') . "\n";
    $sent = wp_mail(RL_DIAG_NOTIFY, ($audit ? 'Audit request: ' : 'Diagnostic request: ') . $d['company'], $body, ['Reply-To: ' . $d['name'] . ' <' . $d['email'] . '>']);
    $save('email_sent', $sent ? 'yes' : 'no');

    $hook = trim((string) get_option('rl_diag_webhook_url', ''));
    if ($hook !== '') {
        wp_remote_post($hook, ['timeout' => 5, 'blocking' => false, 'headers' => ['Content-Type' => 'application/json'],
            'body' => wp_json_encode(['type' => $audit ? 'seo_ai_search_audit_request' : 'search_authority_diagnostic_request', 'id' => $id, 'submitted_at' => current_time('c'), 'data' => $d])]);
        $save('webhook_sent', 'queued');
    }
    $go('ok');
}

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_diag()) $c[] = 'rl-diag-page'; return $c; });
add_action('wp_head', 'rl_diag_css', 22);
function rl_diag_css() {
    if (!rl_is_diag()) return; ?>
<style id="rl-diag-css">
.rl-diag .src{font-family:var(--f-mono);font-size:11px;letter-spacing:.06em;line-height:1.7;color:var(--ink-faint);margin:16px 0 0}
.rl-diag .src a{color:var(--ink-dim);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-diag{position:relative;width:100vw;margin-left:calc(50% - 50vw);--r:0px;--pill:0px;color:var(--ink);font-family:var(--f-body);font-size:16px;line-height:1.6}
body.rl-diag-page .fl-page-content,body.rl-diag-page .fl-content,body.rl-diag-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-diag *{box-sizing:border-box}
.rl-diag a{text-decoration:none;color:inherit}
.rl-diag p{margin:0}.rl-diag ul{margin:0;padding:0}
.rl-diag h1,.rl-diag h2,.rl-diag h3,.rl-diag h4{font-family:var(--f-display);font-weight:600;text-transform:uppercase;margin:0;line-height:1.02;letter-spacing:.01em;text-wrap:balance;color:var(--ink)}
.rl-diag .wrap{max-width:var(--maxw);margin:0 auto;padding-inline:var(--gutter)}
.rl-diag :focus-visible{outline:2px solid var(--red-2);outline-offset:3px}
.rl-diag .lede a,.rl-diag .inl{color:var(--ink);border-bottom:1px solid var(--red-line)}.rl-diag .lede a:hover,.rl-diag .inl:hover{color:var(--red-3)}
.rl-diag .crumbs{padding-top:clamp(18px,2.4vw,28px);font-family:var(--f-mono);font-size:11.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-diag .crumbs ol{list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:.6em}
.rl-diag .crumbs li+li::before{content:"/";color:var(--red-2);margin-right:.6em}
.rl-diag .crumbs a:hover{color:var(--ink)}.rl-diag .crumbs [aria-current]{color:var(--ink-dim)}
/* ---- ported from design preview (scoped) ---- */
.rl-diag .band{border-top:1px solid var(--line)}
.rl-diag .band.alt{background:radial-gradient(90% 60% at 15% 0%,rgba(153,0,0,.10),transparent 55%),var(--bg-2)}
.rl-diag section{position:relative;padding-block:clamp(52px,8vw,92px)}
.rl-diag .ey{font-family:var(--f-mono);font-size:12px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-faint);display:inline-flex;gap:.5em;align-items:center}
.rl-diag .ey b{color:var(--red-3);font-weight:500}
.rl-diag .lede{color:var(--ink-dim);font-size:clamp(15px,1.6vw,19px);max-width:60ch}
.rl-diag .head{max-width:64ch;margin-bottom:clamp(28px,5vw,48px)}
.rl-diag .head h2{font-size:clamp(26px,4vw,44px);margin-top:14px}
.rl-diag .head p{margin-top:16px}
.rl-diag .btn{font-family:var(--f-display);text-transform:uppercase;font-weight:600;letter-spacing:.05em;font-size:14px;padding:15px 26px;display:inline-flex;align-items:center;gap:.55em;border:1px solid transparent;cursor:pointer;transition:.2s;border-radius:var(--pill);position:relative}
.rl-diag .btn::before{content:"+";font-family:var(--f-mono);font-weight:500;color:var(--red-3);font-size:1.15em;line-height:0}
.rl-diag .btn.p{background:linear-gradient(180deg,#241a1c,#120e0f);color:#fff;border-color:var(--red-line);box-shadow:14px 0 44px -14px var(--red-glow),inset 0 1px 0 var(--glass-hi)}
.rl-diag .btn.p:hover{border-color:var(--red-2);box-shadow:20px 0 60px -12px var(--red-glow),inset 0 1px 0 var(--glass-hi);transform:translateY(-1px)}
.rl-diag .btn.g{background:var(--glass);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);color:var(--ink);border-color:var(--glass-line)}
.rl-diag .btn.g::before{color:var(--ink-faint)}
.rl-diag .btn.g:hover{border-color:var(--red-line);color:#fff}
.rl-diag .btn.full{width:100%;justify-content:center;padding:17px}
/* kit hero standard (F-024); the form is taller than the text, so both start on the same line */
.rl-diag .hero{padding-block:clamp(36px,6vw,80px)}
.rl-diag .hero-grid{display:grid;grid-template-columns:1.02fr .98fr;gap:clamp(28px,4vw,56px);align-items:start}
@media(max-width:940px){.rl-diag .hero-grid{grid-template-columns:1fr;gap:34px}}
.rl-diag .h1{font-size:clamp(34px,5.1vw,64px);font-weight:700;letter-spacing:-.01em;line-height:1.02;margin-top:14px}
.rl-diag .h1 .r{color:var(--red-2)}
.rl-diag .hero .lede{margin-top:18px}
.rl-diag .ticks{margin-top:22px;display:grid;gap:10px}
.rl-diag .ticks li{list-style:none;display:flex;gap:11px;color:var(--ink-dim);font-size:15px}
.rl-diag .ticks li::before{content:"›";color:var(--red-3);font-family:var(--f-mono)}
.rl-diag .hero .micro{margin-top:20px;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.04em}
.rl-diag .hero .micro b{color:var(--ink-dim);font-weight:500}
.rl-diag .form{background:var(--glass);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border:1px solid var(--glass-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 30px 70px -44px rgba(0,0,0,.95);padding:26px}
.rl-diag .form .ft{font-family:var(--f-display);text-transform:uppercase;font-size:19px;font-weight:600}
.rl-diag .form .fs{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);letter-spacing:.1em;text-transform:uppercase;margin-top:4px;display:block}
.rl-diag .grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:18px}
@media(max-width:520px){.rl-diag .grid2{grid-template-columns:1fr}}
.rl-diag .field{display:flex;flex-direction:column;gap:6px}
.rl-diag .field.full{grid-column:1/-1}
.rl-diag .field label{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-diag .field input,.rl-diag .field select{font-family:var(--f-body);font-size:14px;background:var(--bg);border:1px solid var(--line-2);color:var(--ink);padding:11px 12px;border-radius:0;transition:.15s}
.rl-diag .field input:focus,.rl-diag .field select:focus{outline:none;border-color:var(--red-2);box-shadow:0 0 0 1px var(--red-line)}
.rl-diag .field select{appearance:none;background-image:linear-gradient(45deg,transparent 50%,var(--ink-faint) 50%),linear-gradient(135deg,var(--ink-faint) 50%,transparent 50%);background-position:calc(100% - 18px) 50%,calc(100% - 13px) 50%;background-size:5px 5px,5px 5px;background-repeat:no-repeat}
.rl-diag .form .note{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint);margin-top:14px;line-height:1.7}
.rl-diag .ok{display:none;text-align:center;padding:30px 10px}
.rl-diag .ok .m{font-family:var(--f-display);text-transform:uppercase;font-size:22px;margin-bottom:10px}
.rl-diag .ok p{color:var(--ink-dim);font-size:14px}
.rl-diag .ok .mono{font-family:var(--f-mono);color:var(--red-3);font-size:11px;letter-spacing:.1em;margin-top:14px}
.rl-diag .cols{display:grid;gap:16px}
.rl-diag .c3{grid-template-columns:repeat(3,1fr)}
.rl-diag .c4{grid-template-columns:repeat(4,1fr)}
@media(max-width:900px){.rl-diag .c3,.rl-diag .c4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rl-diag .c3,.rl-diag .c4{grid-template-columns:1fr}}
.rl-diag .cell{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi);transition:.2s}
.rl-diag .cell:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-diag .cell .n{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.1em}
.rl-diag .cell h3{font-size:17px;margin:10px 0 7px}
.rl-diag .cell p{color:var(--ink-dim);font-size:14px}
.rl-diag .steps{display:grid;grid-template-columns:repeat(5,1fr);gap:14px}
@media(max-width:900px){.rl-diag .steps{grid-template-columns:repeat(2,1fr)}}
@media(max-width:520px){.rl-diag .steps{grid-template-columns:1fr}}
.rl-diag .step{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:20px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-diag .step .k{font-family:var(--f-display);font-size:30px;color:var(--red-3);font-weight:700;opacity:.8}
.rl-diag .step h4{font-size:14px;margin:6px 0 6px}
.rl-diag .step p{color:var(--ink-dim);font-size:13px}
.rl-diag .deliv{display:grid;grid-template-columns:1fr 1fr;gap:12px}
@media(max-width:640px){.rl-diag .deliv{grid-template-columns:1fr}}
.rl-diag .deliv li{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:16px 18px;display:flex;gap:12px;color:var(--ink-dim);font-size:15px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-diag .deliv li::before{content:"→";color:var(--red-3);font-family:var(--f-mono)}
.rl-diag .deliv b{color:var(--ink);font-weight:600}
.rl-diag .q{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:760px){.rl-diag .q{grid-template-columns:1fr}}
.rl-diag .q .cell .tag{font-family:var(--f-mono);font-size:11px;color:var(--red-3);letter-spacing:.1em;text-transform:uppercase}
.rl-diag .final{position:relative;overflow:hidden;border:1px solid var(--red-line);background:#0b090a;padding:clamp(44px,7vw,88px) clamp(24px,5vw,64px);text-align:center;box-shadow:inset 0 1px 0 var(--glass-hi),0 0 130px -46px var(--red-glow)}
.rl-diag .final::before{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(58% 96% at 50% 128%,rgba(226,59,59,.6),rgba(153,0,0,.28) 38%,transparent 70%),linear-gradient(180deg,transparent 40%,rgba(153,0,0,.10))}
.rl-diag .final::after{content:"";position:absolute;inset:0;pointer-events:none;background:linear-gradient(102deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%),linear-gradient(258deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%)}
.rl-diag .final>*{position:relative;z-index:2}
.rl-diag .final h2{font-size:clamp(28px,5vw,52px)}
.rl-diag .final .lede{margin:18px auto 26px}
.rl-diag .final .cta{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
/* build additions */
.rl-diag .ey{flex-wrap:wrap;row-gap:.2em}
/* ticks: block items so inline <em> doesn't become its own flex column (design-preview defect) */
.rl-diag .ticks li{display:block;position:relative;padding-left:20px}
.rl-diag .ticks li::before{position:absolute;left:0;top:0}
.rl-diag .step h3{font-size:14px;margin:6px 0}
.rl-diag .field .req{color:var(--red-3)}
.rl-diag .consent{display:flex;gap:10px;align-items:flex-start;margin-top:16px;font-size:14px;color:var(--ink-dim);line-height:1.5;cursor:pointer}.rl-diag .consent input{width:18px;height:18px;margin-top:2px;flex:0 0 auto;accent-color:var(--red-2)}
.rl-diag .hp{position:absolute!important;left:-9999px;width:1px;height:1px;overflow:hidden}
.rl-diag .alert{margin-top:14px;padding:12px 14px;border:1px solid var(--red-2);background:rgba(153,0,0,.12);font-size:14px;color:var(--ink)}
.rl-diag .form .note a{color:var(--ink-dim);border-bottom:1px solid var(--red-line)}
.rl-diag .ok.show{display:block}
.rl-diag .ok .btn{margin-top:18px}
.rl-diag .faq details{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);margin-bottom:12px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-diag .faq summary{cursor:pointer;padding:20px 24px;font-family:var(--f-display);text-transform:uppercase;font-size:16px;letter-spacing:.02em;list-style:none;display:flex;justify-content:space-between;gap:16px;align-items:center}
.rl-diag .faq summary::-webkit-details-marker{display:none}
.rl-diag .faq summary::after{content:"+";color:var(--red-2);font-family:var(--f-mono);font-size:20px}
.rl-diag .faq details[open] summary::after{content:"\2212"}
.rl-diag .faq p{padding:0 24px 22px;color:var(--ink-dim);font-size:15px;max-width:75ch}
.rl-diag .faq p a{color:var(--ink);border-bottom:1px solid var(--red-line)}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_diag() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service',
        '@id' => $url . '#service',
        'name' => 'Search Authority Diagnostic',
        'description' => RL_DIAG_DESC,
        'url' => $url,
        'serviceType' => 'SEO and AI search visibility diagnostic',
        'provider' => ['@id' => home_url('/') . '#organization'],
        'areaServed' => 'Worldwide',
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD', 'url' => $url],
        'mainEntityOfPage' => ['@id' => $url],
    ];
    $graph[] = [
        '@type' => 'FAQPage',
        '@id' => $url . '#faq',
        'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) {
            return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]];
        }, rl_diag_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_diagnostic', 'rl_render_diagnostic');
function rl_render_diagnostic() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $state = isset($_GET['diag']) ? sanitize_key($_GET['diag']) : '';
    $is_audit = isset($_GET['interest']) && sanitize_key($_GET['interest']) === 'audit';
    $msgs = ['invalid' => 'Please add your name, a valid work email and your company.', 'limit' => 'Too many requests from this connection. Please try again in an hour or email hello@reinforcelab.com.', 'error' => 'Something went wrong saving your request. Please try again or email hello@reinforcelab.com.'];
    $c = rl_diag_choices();
    $opts = function ($k) use ($c) { $h = '<option value="">Select…</option>'; foreach ($c[$k] as $o) $h .= '<option>' . esc_html($o) . '</option>'; return $h; };
    $privacy = get_permalink(3);
    ob_start(); ?>
<div class="rl-diag">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Search Authority Diagnostic</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Free&nbsp;<b>/</b>&nbsp;Search Authority Diagnostic&nbsp;<b>]</b></span>
      <h1 class="h1">Find out what's<br>limiting your<br><span class="r">search authority.</span></h1>
      <p class="lede">The <strong>Search Authority Diagnostic</strong> is a free, data-backed review from Reinforce Lab of your Google visibility, AI-search presence, content authority, competitors and demand signals. Not a generic SEO scorecard: what matters, what's missing, and what to do next.</p>
      <ul class="ticks">
        <li>Where you stand in Google <em>and</em> in AI answers (ChatGPT, Perplexity, AI Overviews)</li>
        <li>The highest-value demand you're not capturing</li>
        <li>A prioritized 90-day action plan: create, improve, stop</li>
      </ul>
      <p class="micro">For selected businesses and organizations · <b>Confidential</b> · No purchased lists · No generic automated audit</p>
    </div>

    <div class="form" id="request">
      <?php if ($state === 'ok') { ?>
      <div class="ok show" role="status">
        <div class="m">Request received</div>
        <p>Thank you. We'll review your details before preparing your diagnostic. While you wait, see how Search Authority OS works.</p>
        <a class="btn g" href="<?php echo $u('search-authority-os'); ?>">How Search Authority OS works <span class="ar">&rarr;</span></a>
      </div>
      <?php } else { ?>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="rl_diag_request">
        <?php if ($is_audit) echo '<input type="hidden" name="interest" value="audit">'; ?>
        <input type="hidden" name="rl_ts" value="<?php echo (int) time(); ?>">
        <div class="hp" aria-hidden="true"><label for="rl_hp">Leave this field empty</label><input id="rl_hp" name="rl_hp" tabindex="-1" autocomplete="off"></div>
        <span class="ft"><?php echo $is_audit ? 'Request your SEO &amp; AI Search Audit' : 'Request your diagnostic'; ?></span>
        <span class="fs"><?php echo $is_audit ? 'Takes ~2 minutes · we reply with a scope and quote' : 'Takes ~2 minutes'; ?></span>
        <?php if (isset($msgs[$state])) echo '<p class="alert" role="alert">' . esc_html($msgs[$state]) . '</p>'; ?>
        <div class="grid2">
          <div class="field"><label for="name">Full name <span class="req" aria-hidden="true">*</span></label><input id="name" name="name" autocomplete="name" maxlength="200" required></div>
          <div class="field"><label for="email">Work email <span class="req" aria-hidden="true">*</span></label><input id="email" name="email" type="email" autocomplete="email" maxlength="200" required></div>
          <div class="field"><label for="company">Company <span class="req" aria-hidden="true">*</span></label><input id="company" name="company" autocomplete="organization" maxlength="200" required></div>
          <div class="field"><label for="website">Website</label><input id="website" name="website" type="url" placeholder="https://" autocomplete="url" maxlength="200"></div>
          <div class="field"><label for="role">Role</label><input id="role" name="role" autocomplete="organization-title" maxlength="200"></div>
          <div class="field"><label for="industry">Industry</label><select id="industry" name="industry"><?php echo $opts('industry'); ?></select></div>
          <div class="field full"><label for="challenge">Biggest search challenge</label><select id="challenge" name="challenge"><?php echo $opts('challenge'); ?></select></div>
          <div class="field"><label for="volume">Monthly content volume</label><select id="volume" name="volume"><?php echo $opts('volume'); ?></select></div>
          <div class="field"><label for="outcome">Desired outcome</label><input id="outcome" name="outcome" placeholder="e.g. pipeline, authority" maxlength="200"></div>
        </div>
        <label class="consent"><input type="checkbox" name="consent" value="1" required> <span>I agree that Reinforce Lab may use these details to prepare my diagnostic and contact me about it.</span></label>
        <button class="btn p full" type="submit" style="margin-top:18px">Request My Search Authority Diagnostic <span class="ar">&rarr;</span></button>
        <p class="note">We use your details only to prepare your diagnostic and contact you about it. We keep your details for up to 24 months, stored with our host, Hostinger, and we never sell them. You can withdraw your consent or ask us to delete them at any time: <a href="mailto:hello@reinforcelab.com">hello@reinforcelab.com</a>. See our <a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a>.</p>
      </form>
      <?php } ?>
    </div>
  </div>
</section>

<section class="band alt" id="analyze">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we analyze&nbsp;<b>]</b></span><h2>What does the diagnostic review?</h2><p class="lede">Not one meaningless SEO score. We review seven dimensions of authority, each with evidence and a gap.</p></div>
    <div class="cols c4">
      <div class="cell"><div class="n">01</div><h3>Organic Search</h3><p>Rankings, queries, impressions, CTR, visibility and the opportunities you're missing.</p></div>
      <div class="cell"><div class="n">02</div><h3>AI Search</h3><p>Brand mentions, citations and entity visibility across ChatGPT, Perplexity and AI Overviews.</p></div>
      <div class="cell"><div class="n">03</div><h3>Content Authority</h3><p>Depth, topical coverage, information gaps, originality and commercial alignment.</p></div>
      <div class="cell"><div class="n">04</div><h3>Competitor Intelligence</h3><p>Where competitors win, what they cover, and the gaps left open for you.</p></div>
      <div class="cell"><div class="n">05</div><h3>Search Demand</h3><p>High-value queries, emerging topics, intent patterns and underserved demand.</p></div>
      <div class="cell"><div class="n">06</div><h3>Customer Voice</h3><p>The questions, objections and complaints in your customers' own language.</p></div>
      <div class="cell"><div class="n">07</div><h3>Technical Foundation</h3><p>Indexability, crawlability, architecture, internal linking and technical barriers.</p></div>
      <div class="cell" style="border-color:var(--red-line)"><div class="n" aria-hidden="true">→</div><h3>Your Authority Score</h3><p>Seven weighted dimensions, each explainable: current state, evidence, gap, priority.</p></div>
    </div>
    <p class="src">Sources: <a href="https://support.google.com/webmasters/answer/7576553" rel="noopener" target="_blank">Google Search Console Help: Performance report</a> · <a href="https://developers.google.com/search/docs/appearance/ai-features" rel="noopener" target="_blank">Google Search Central: AI features and your website</a> · <a href="https://platform.openai.com/docs/bots" rel="noopener" target="_blank">OpenAI: crawlers and user agents</a></p>
  </div>
</section>

<section id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What you receive&nbsp;<b>]</b></span><h2>A prioritized action plan, not a PDF you file away.</h2></div>
    <ul class="deliv" style="list-style:none">
      <li><span><b>What's working</b> and what's holding you back.</span></li>
      <li><span><b>Your biggest opportunities</b>, ranked by impact × effort.</span></li>
      <li><span><b>What to create</b>: the content that would actually move you.</span></li>
      <li><span><b>What to improve</b>: the pages worth saving.</span></li>
      <li><span><b>What to stop</b>: the effort that isn't paying off.</span></li>
      <li><span><b>A 90-day plan</b>: sequenced P0 → P3, with the recommended system.</span></li>
    </ul>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>How does the diagnostic work?</h2></div>
    <ol class="steps" style="list-style:none;margin:0;padding:0">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Request</h3><p>You share a few details. Two minutes.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Research</h3><p>We analyze your site, search data, competitors and AI visibility.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Verify</h3><p>Findings are evidenced and confidence-rated. No invented data.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Review</h3><p>A human quality gate before anything reaches you.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Deliver</h3><p>Your personalized Search Authority Diagnostic and 90-day plan.</p></li>
    </ol>
  </div>
</section>

<section id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Built for organizations with something to protect, and to gain.</h2></div>
    <div class="q">
      <div class="cell"><span class="tag">Priority</span><h3 style="margin:10px 0 8px;font-size:18px">Enterprise</h3><p>Pharma, Life Sciences, Healthcare, Finance or enterprise, a real content operation and a clear search problem. Priority review.</p></div>
      <div class="cell"><span class="tag">Growth</span><h3 style="margin:10px 0 8px;font-size:18px">Established</h3><p>A meaningful search opportunity and active marketing. Diagnostic plus a strategy call.</p></div>
      <div class="cell"><span class="tag">Early</span><h3 style="margin:10px 0 8px;font-size:18px">Early stage</h3><p>Smaller or newer footprint. A focused read and an educational path forward.</p></div>
    </div>
  </div>
</section>

<section class="band alt faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>What do people ask about the diagnostic?</h2></div>
    <?php foreach (rl_diag_faqs() as $k => $q) {
        $a = esc_html($q[1]);
        if (!empty($q[2])) $a .= ' <a href="' . $u($q[2]) . '">' . $q[3] . '</a>.'; ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo $a; ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See what's really limiting your growth.</h2>
      <p class="lede">The diagnostic establishes your real baseline (no borrowed numbers, no invented results) and shows exactly what to do next.</p>
      <div class="cta">
        <a class="btn p" href="#request">Request My Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('search-authority-os'); ?>">How Search Authority OS works</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
