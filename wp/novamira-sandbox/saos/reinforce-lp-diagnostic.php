<?php
/**
 * Plugin Name: Reinforce Lab - Diagnostic landing page (campaigns)
 * Description: /get-diagnostic/ (D-239): a conversion page for ads and outreach with one goal, a request for the free Search Authority Diagnostic. No site menu or footer, a short form, the call to action repeated. Always noindex and left out of the sitemap, so it never competes with /search-authority-diagnostic/. Provides [reinforce_lp_diagnostic]. Uses the shared kit (D-044) and the existing request handler (rl_diag_handle in reinforce-diagnostic.php).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

const RL_LP_SLUG = 'get-diagnostic';
function rl_is_lp() { return !empty($GLOBALS['rl_lp_force']) || is_page(RL_LP_SLUG); }

add_filter('body_class', function ($c) { if (rl_is_lp()) $c[] = 'rl-lp-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_lp(); });

/* never indexed, whatever the site setting is (the main diagnostic page is the one that ranks) */
add_filter('wpseo_robots', function ($r) { return rl_is_lp() ? 'noindex, follow' : $r; }, 99);
add_filter('wp_robots', function ($r) { if (rl_is_lp()) { $r['noindex'] = true; unset($r['index']); } return $r; }, 99);
add_filter('wpseo_exclude_from_sitemap_by_post_ids', function ($ids) { $p = get_page_by_path(RL_LP_SLUG); if ($p) $ids[] = (int) $p->ID; return $ids; });

function rl_lp_faqs() {
    return [
        ['Is the diagnostic really free?', 'Yes. The diagnostic is free. It is the first step before any engagement and establishes your real baseline before anything is built.'],
        ['What exactly do I receive?', 'A review of seven dimensions of search authority: organic search, AI search, content authority, competitors, search demand, customer voice and technical foundation, each with its evidence and gap, plus a prioritized 90-day plan covering what to create, what to improve and what to stop.'],
        ['Does it cover AI search (ChatGPT, Perplexity, AI Overviews)?', 'Yes. We review your brand mentions, citations and entity visibility across ChatGPT, Perplexity and Google AI Overviews alongside your Google rankings, so you see where you stand in both.'],
        ['Who is this for?', 'Organizations with a real search opportunity, from enterprise teams in pharma, life sciences, healthcare and finance to established and growth-stage businesses. Enterprise requests get priority review; established businesses also get a strategy call.'],
        ['Am I obligated to buy anything afterward?', 'No. The diagnostic is free with no obligation. If you want help acting on the plan, we will recommend the package that fits, or you can implement it yourself.'],
        ['How is this different from a regular SEO audit?', 'It is a free, focused read of where you stand in Google and in AI search, with a 90-day plan. It is not a full audit. If you need the complete technical and content analysis, that is the paid SEO & AI Search Audit.'],
        ['Is my information confidential?', 'Yes. Your details are used only to prepare your diagnostic and to contact you about it.'],
    ];
}

add_action('wp_head', 'rl_lp_css', 22);
function rl_lp_css() {
    if (!rl_is_lp()) return; ?>
<style id="rl-lp-css">
body.rl-lp-page .rl-header,body.rl-lp-page #rl-mobile,body.rl-lp-page .rl-footer{display:none!important}
body.rl-lp-page .fl-page-content,body.rl-lp-page .fl-content,body.rl-lp-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
body.rl-lp-page{padding-top:0!important}
.rl-lp .top{border-bottom:1px solid var(--line);padding-block:16px}
.rl-lp .top .wrap{display:flex;align-items:center;justify-content:space-between;gap:16px}
.rl-lp .top img{display:block;height:34px;width:auto}
.rl-lp .top .back{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-dim);border-bottom:1px solid var(--red-line);padding-bottom:2px}
.rl-lp .top .back:hover{color:var(--ink)}
.rl-lp .hero{padding-block:clamp(32px,5vw,64px)}
.rl-lp .hero-grid{align-items:start}
.rl-lp .ticks{list-style:none;margin:22px 0 0;padding:0;display:grid;gap:10px}
.rl-lp .ticks li{position:relative;padding-left:22px;color:var(--ink-dim)}
.rl-lp .ticks li::before{content:"";position:absolute;left:0;top:.55em;width:9px;height:9px;background:var(--red-2)}
.rl-lp .micro{font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint);margin-top:22px;line-height:1.8}
.rl-lp .form{background:var(--glass);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border:1px solid var(--glass-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 30px 70px -44px rgba(0,0,0,.9);padding:clamp(20px,3vw,32px);scroll-margin-top:20px}
.rl-lp .form .ft{font-family:var(--f-display);text-transform:uppercase;font-size:20px;font-weight:600;color:var(--ink)}
.rl-lp .form .fs{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.1em;text-transform:uppercase;margin-top:4px;display:block}
.rl-lp .fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:20px}
@media(max-width:560px){.rl-lp .fields{grid-template-columns:minmax(0,1fr)}}
.rl-lp .field{display:flex;flex-direction:column;gap:6px;min-width:0}
.rl-lp .field.full{grid-column:1/-1}
.rl-lp .field label{font-family:var(--f-mono);font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-lp .field .req{color:var(--red-3)}
.rl-lp .field input,.rl-lp .field select{font-family:var(--f-body);font-size:16px;background:var(--bg);border:1px solid var(--line-2);color:var(--ink);padding:13px 12px;border-radius:0;width:100%;min-height:48px}
.rl-lp .field input:focus,.rl-lp .field select:focus{outline:none;border-color:var(--red-2);box-shadow:0 0 0 1px var(--red-line)}
.rl-lp .consent{display:flex;gap:10px;align-items:flex-start;margin-top:16px;font-size:14px;color:var(--ink-dim);line-height:1.5}
.rl-lp .consent input{margin-top:3px;width:18px;height:18px;flex:none;accent-color:#990000}
.rl-lp .btn.full{width:100%;justify-content:center;min-height:54px;font-size:15px}
.rl-lp .under{font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint);margin-top:12px;text-align:center}
.rl-lp .note{font-size:12px;color:var(--ink-faint);margin-top:14px;line-height:1.7}
.rl-lp .note a{border-bottom:1px solid var(--red-line);color:var(--ink-dim)}
.rl-lp .hp{position:absolute!important;left:-9999px;width:1px;height:1px;overflow:hidden}
.rl-lp .msg{border:1px solid var(--red-line);padding:12px 14px;margin-top:16px;color:var(--ink);font-size:14px}
.rl-lp .ok .m{font-family:var(--f-display);text-transform:uppercase;font-size:24px;font-weight:600;color:var(--ink)}
.rl-lp .ok p{margin-top:10px;color:var(--ink-dim)}
.rl-lp .cols{display:grid;gap:14px;margin-top:28px}
.rl-lp .cols.c4{grid-template-columns:repeat(4,minmax(0,1fr))}.rl-lp .cols.c3{grid-template-columns:repeat(3,minmax(0,1fr))}.rl-lp .cols.c2{grid-template-columns:repeat(2,minmax(0,1fr))}
@media(max-width:1000px){.rl-lp .cols.c4{grid-template-columns:repeat(2,minmax(0,1fr))}.rl-lp .cols.c3{grid-template-columns:minmax(0,1fr)}}
@media(max-width:620px){.rl-lp .cols.c4,.rl-lp .cols.c2{grid-template-columns:minmax(0,1fr)}}
.rl-lp .cell{background:var(--panel);border:1px solid var(--line);padding:22px;min-width:0}
.rl-lp .cell .n{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--red-3)}
.rl-lp .cell h3{margin-top:10px}.rl-lp .cell p{margin-top:8px;color:var(--ink-dim);font-size:15px}
.rl-lp .cell .tag{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-lp .line{margin-top:22px;color:var(--ink);font-size:18px;max-width:70ch}
.rl-lp .deliv{list-style:none;margin:26px 0 0;padding:0;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
@media(max-width:700px){.rl-lp .deliv{grid-template-columns:minmax(0,1fr)}}
.rl-lp .deliv li{border-left:2px solid var(--red-2);padding:6px 0 6px 16px;color:var(--ink-dim)}.rl-lp .deliv b{color:var(--ink)}
.rl-lp .steps{list-style:none;margin:28px 0 0;padding:0;display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:14px}
@media(max-width:1000px){.rl-lp .steps{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:560px){.rl-lp .steps{grid-template-columns:minmax(0,1fr)}}
.rl-lp .step{background:var(--panel);border:1px solid var(--line);padding:20px;min-width:0}
.rl-lp .step .k{font-family:var(--f-display);font-size:30px;font-weight:700;color:var(--red-2);line-height:1}
.rl-lp .step h3{margin-top:10px}.rl-lp .step p{margin-top:6px;color:var(--ink-dim);font-size:15px}
.rl-lp .mid{margin-top:30px;display:flex;flex-wrap:wrap;align-items:center;gap:16px}
.rl-lp .mid span{font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-lp .logos{list-style:none;margin:28px 0 0;padding:0;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:14px;align-items:center}
@media(max-width:900px){.rl-lp .logos{grid-template-columns:repeat(3,minmax(0,1fr))}}
.rl-lp .logos li{border:1px solid var(--line);background:var(--panel);height:84px;display:flex;align-items:center;justify-content:center;padding:14px}
.rl-lp .logos img{max-width:100%;max-height:44px;width:auto;height:auto;opacity:.85}
.rl-lp .quote{margin:0;display:flex;flex-direction:column;gap:20px;padding:clamp(22px,3vw,32px);background:var(--panel);border:1px solid var(--glass-line);min-width:0}
.rl-lp .quote blockquote{margin:0;padding:0;border:0}
.rl-lp .quote blockquote::before{content:"\201C";display:block;font-family:var(--f-display);font-size:52px;line-height:.8;color:var(--red-2);margin-bottom:6px}
.rl-lp .quote blockquote p{margin:0;font-size:16px;line-height:1.65;color:var(--ink)}
.rl-lp .quote figcaption{margin-top:auto;display:flex;align-items:center;gap:14px;padding-top:18px;border-top:1px solid var(--line)}
.rl-lp .quote img{width:52px;height:52px;object-fit:cover;flex:none}
.rl-lp .quote .nm{display:block;color:var(--ink);font-weight:600}.rl-lp .quote .rl{display:block;color:var(--ink-faint);font-size:14px}
.rl-lp .cred{margin-top:22px;color:var(--ink-dim);max-width:72ch}
.rl-lp .final{text-align:center;max-width:820px;margin:0 auto}
.rl-lp .final .lede{margin:16px auto 0}.rl-lp .final .btn{margin-top:26px}
.rl-lp .foot{border-top:1px solid var(--line);padding-block:22px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-lp .foot .wrap{display:flex;flex-wrap:wrap;gap:8px 20px;justify-content:space-between}
.rl-lp .foot a{color:var(--ink-dim);border-bottom:1px solid var(--red-line)}
</style>
<?php
}

add_shortcode('reinforce_lp_diagnostic', 'rl_render_lp_diagnostic');
function rl_render_lp_diagnostic() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $state = isset($_GET['diag']) ? sanitize_key($_GET['diag']) : '';
    $msgs = ['invalid' => 'Please add your name, a valid work email and your company.', 'limit' => 'Too many requests from this connection. Please try again in an hour or email hello@reinforcelab.com.', 'error' => 'Something went wrong saving your request. Please try again or email hello@reinforcelab.com.'];
    $ind = function_exists('rl_diag_choices') ? rl_diag_choices()['industry'] : [];
    $logo_id = get_option('reinforcelab_logo_white'); $logo = $logo_id ? wp_get_attachment_url($logo_id) : '';
    $white = (array) get_option('rl_client_logos_white', []);
    $names = function_exists('rl_clients_list') ? array_flip(rl_clients_list()) : [];
    $pick = array_slice(array_values(array_filter(['beacon-pharmaceuticals', 'united-international-university', 'bikroy-com', 'hp', 'accesstel', 'iba-alumni-association'], function ($s) use ($white) { return !empty($white[$s]); })), 0, 6);
    $quotes = function_exists('rl_home_testimonials') ? array_slice(rl_home_testimonials(), 0, 2) : [];
    $cta = '<a class="btn p" href="#request">Get your free diagnostic <span class="ar">&rarr;</span></a>';
    ob_start(); ?>
<div class="rl-page rl-lp">

<div class="top"><div class="wrap">
  <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Reinforce Lab home"><?php if ($logo) { ?><img src="<?php echo esc_url($logo); ?>" alt="Reinforce Lab" width="170" height="34"><?php } else { echo 'Reinforce Lab'; } ?></a>
  <a class="back" href="<?php echo esc_url(home_url('/')); ?>">Back to main site</a>
</div></div>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Free&nbsp;<b>/</b>&nbsp;Search Authority Diagnostic&nbsp;<b>]</b></span>
      <h1 class="h1">Find out exactly<br>what's limiting your<br><span class="r">search authority.</span></h1>
      <p class="lede">Get a free, data-backed diagnostic from Reinforce Lab of your Google visibility, AI search presence (ChatGPT, Perplexity, AI Overviews), content authority and competitors, plus a prioritized 90-day action plan.</p>
      <ul class="ticks">
        <li>Where you stand in Google and in AI answers</li>
        <li>The highest-value demand you are not capturing</li>
        <li>What to create, what to improve and what to stop</li>
      </ul>
      <p class="micro">For growth-stage and established B2B companies · Human-reviewed · No generic automated reports</p>
    </div>

    <div class="form" id="request">
      <?php if ($state === 'ok') { ?>
      <div class="ok" role="status">
        <div class="m">Request received</div>
        <p>Thank you. We will review your details before preparing your diagnostic, and reply to the email address you gave.</p>
      </div>
      <?php } else { ?>
      <div class="ft">Request your free diagnostic</div>
      <span class="fs">About 2 minutes · Confidential</span>
      <?php if (isset($msgs[$state])) echo '<div class="msg" role="alert">' . esc_html($msgs[$state]) . '</div>'; ?>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="rl_diag_request">
        <input type="hidden" name="rl_from" value="lp">
        <input type="hidden" name="rl_ts" value="<?php echo (int) time(); ?>">
        <div class="hp" aria-hidden="true"><label for="rl_hp">Leave this field empty</label><input id="rl_hp" name="rl_hp" tabindex="-1" autocomplete="off"></div>
        <div class="fields">
          <div class="field"><label for="name">Full name <span class="req" aria-hidden="true">*</span></label><input id="name" name="name" autocomplete="name" maxlength="200" required></div>
          <div class="field"><label for="email">Work email <span class="req" aria-hidden="true">*</span></label><input id="email" name="email" type="email" autocomplete="email" maxlength="200" required></div>
          <div class="field"><label for="company">Company <span class="req" aria-hidden="true">*</span></label><input id="company" name="company" autocomplete="organization" maxlength="200" required></div>
          <div class="field"><label for="website">Website</label><input id="website" name="website" type="url" placeholder="https://" autocomplete="url" maxlength="200"></div>
          <div class="field full"><label for="industry">Industry</label><select id="industry" name="industry"><option value="">Select</option><?php foreach ($ind as $o) echo '<option>' . esc_html($o) . '</option>'; ?></select></div>
        </div>
        <label class="consent"><input type="checkbox" name="consent" value="1" required> <span>I agree that Reinforce Lab may use these details to prepare my diagnostic and contact me about it.</span></label>
        <button class="btn p full" type="submit" style="margin-top:18px">Get your free diagnostic <span class="ar">&rarr;</span></button>
        <p class="under">Takes about 2 minutes · Confidential · No obligation</p>
        <p class="note">We use your details only to prepare your diagnostic and contact you about it. We keep them for up to 24 months, stored with our host, and we never sell them. You can withdraw your consent or ask us to delete them at any time: <a href="mailto:hello@reinforcelab.com">hello@reinforcelab.com</a>. See the <a href="<?php echo esc_url(get_permalink(3)); ?>">Privacy Policy</a>.</p>
      </form>
      <?php } ?>
    </div>
  </div>
</section>

<section class="band alt">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The problem&nbsp;<b>]</b></span><h2>Why most search efforts stall.</h2></div>
    <div class="cols c4">
      <div class="cell"><div class="n">01</div><p>You rank on Google but stay invisible in AI answers.</p></div>
      <div class="cell"><div class="n">02</div><p>Content is published, yet it does not bring qualified pipeline.</p></div>
      <div class="cell"><div class="n">03</div><p>Reports show traffic and rankings, but not which work produces revenue.</p></div>
      <div class="cell"><div class="n">04</div><p>Manual research, reporting and follow-up still take too many hours every week.</p></div>
    </div>
    <p class="line">Buyers now research across Google and AI tools. Most growth plans still measure only one of them.</p>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What you get&nbsp;<b>]</b></span><h2>What your free diagnostic includes.</h2><p class="lede">A focused review of seven dimensions of search authority.</p></div>
    <div class="cols c4">
      <div class="cell"><div class="n">01</div><h3>Organic Search</h3><p>Rankings, impressions, click rate and missed opportunities.</p></div>
      <div class="cell"><div class="n">02</div><h3>AI Search</h3><p>Brand mentions and citations across ChatGPT, Perplexity and AI Overviews.</p></div>
      <div class="cell"><div class="n">03</div><h3>Content Authority</h3><p>Depth, topical gaps and commercial alignment.</p></div>
      <div class="cell"><div class="n">04</div><h3>Competitor Intelligence</h3><p>Where competitors win and where gaps are open.</p></div>
      <div class="cell"><div class="n">05</div><h3>Search Demand</h3><p>High-value queries and underserved intent.</p></div>
      <div class="cell"><div class="n">06</div><h3>Customer Voice</h3><p>Real questions and objections in your buyers' language.</p></div>
      <div class="cell"><div class="n">07</div><h3>Technical Foundation</h3><p>Indexability, architecture and barriers.</p></div>
      <div class="cell" style="border-color:var(--red-line)"><div class="n">90</div><h3>Your 90-day plan</h3><p>The actions in order, most valuable first.</p></div>
    </div>
    <ul class="deliv">
      <li><b>What is working</b> and what is holding you back.</li>
      <li><b>Your biggest opportunities</b>, ranked by impact and effort.</li>
      <li><b>What to create, improve and stop.</b></li>
      <li><b>A prioritized 90-day action plan.</b></li>
    </ul>
    <div class="mid"><?php echo $cta; ?><span>Free · Confidential · Human-reviewed</span></div>
  </div>
</section>

<section class="band alt">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>How the diagnostic works.</h2></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Request</h3><p>Share a few details. About 2 minutes.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Research</h3><p>We analyze your site, search data, competitors and AI visibility.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Verify</h3><p>Findings are evidence-based and confidence-rated.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Review</h3><p>A human quality check before anything is sent.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Deliver</h3><p>You receive your diagnostic and 90-day plan.</p></li>
    </ol>
    <p class="line" style="font-size:16px;color:var(--ink-dim)">No purchased lists. No generic scorecards. Confidential.</p>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it is for&nbsp;<b>]</b></span><h2>Built for organizations with something to protect, and to gain.</h2></div>
    <div class="cols c3">
      <div class="cell"><span class="tag">Priority review</span><h3>Enterprise and regulated</h3><p>Pharma, life sciences, healthcare and finance teams with a real content operation.</p></div>
      <div class="cell"><span class="tag">Diagnostic and strategy call</span><h3>Established companies</h3><p>A meaningful search opportunity and active marketing.</p></div>
      <div class="cell"><span class="tag">Growth</span><h3>Growth-stage teams</h3><p>Ready to connect search visibility to pipeline.</p></div>
    </div>
  </div>
</section>

<section class="band alt">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Trust&nbsp;<b>]</b></span><h2>Trusted by companies that need evidence, not claims.</h2></div>
    <?php if ($pick) { ?><ul class="logos"><?php foreach ($pick as $slug) { $nm = isset($names[$slug]) ? $names[$slug] : $slug; echo '<li>' . wp_get_attachment_image($white[$slug], 'medium', false, ['alt' => $nm . ' logo', 'loading' => 'lazy', 'decoding' => 'async']) . '</li>'; } ?></ul><?php } ?>
    <?php if ($quotes) { ?><div class="cols c2"><?php foreach ($quotes as $t) { ?>
      <figure class="quote">
        <blockquote><p><?php echo esc_html($t['quote']); ?></p></blockquote>
        <figcaption><?php if (function_exists('rl_home_upload')) { ?><img src="<?php echo esc_url(rl_home_upload('reinforce-testimonials/' . $t['photo'])); ?>" alt="<?php echo esc_attr($t['name']); ?>" width="52" height="52" loading="lazy" decoding="async"><?php } ?><span><span class="nm"><?php echo esc_html($t['name']); ?></span><span class="rl"><?php echo esc_html($t['role']); ?></span></span></figcaption>
      </figure>
    <?php } ?></div><?php } ?>
    <p class="cred">Founded by Jamil Ahmed, a pharmacist and Semrush Ambassador. Evidence checking is built into the process.</p>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See what's really limiting your growth.</h2>
      <p class="lede">The diagnostic establishes your real baseline and shows exactly what to do next. No obligation to buy anything afterward.</p>
      <?php echo $cta; ?>
      <p class="under">Takes about 2 minutes · Confidential · Human-reviewed</p>
    </div>
  </div>
</section>

<section class="band alt faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>Before you request it.</h2></div>
    <?php foreach (rl_lp_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
    <div class="mid" style="justify-content:center"><?php echo $cta; ?></div>
  </div>
</section>

<div class="foot"><div class="wrap">
  <span>&copy; <?php echo esc_html(gmdate('Y')); ?> Reinforce Lab</span>
  <span><a href="<?php echo esc_url(get_permalink(3)); ?>">Privacy Policy</a> &nbsp; <a href="<?php echo $u('terms-conditions'); ?>">Terms</a></span>
</div></div>

</div>
<?php
    return ob_get_clean();
}
