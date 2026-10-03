<?php
/**
 * Plugin Name: Reinforce Lab - About
 * Description: /about-us/ (APPROVED - PRESERVE, rebuilt to the D-012 standard). Provides [reinforce_about]. Uses the shared kit (D-044). No hero animation (About is excluded, D-039). Schema: AboutPage + Person (founder) + FAQPage; Organization gains founder.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_about() { return is_page('about-us') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }

/* Founder facts: confirmed by Jamil (D-008 locked positioning; 28 Sep Home FAQ facts). Founding year 2020 confirmed by Jamil 30 Sep (D-069). */
function rl_about_person() {
    return [
        'name' => 'Jamil Ahmed',
        'job' => 'Founder and CEO',
        'linkedin' => 'https://www.linkedin.com/in/ahmedjamil16/',
    ];
}

function rl_about_faqs() {
    return [
        ['What is Reinforce Lab?', 'Reinforce Lab builds AI Growth Systems that connect your website, content, and organic search visibility into one growth engine. We design and implement data-driven SEO, AI search and content systems for growth-stage founders and B2B companies who want measurable revenue.'],
        ['Who founded Reinforce Lab?', 'Reinforce Lab was founded by Jamil Ahmed, its Founder and CEO. Jamil is a pharmacist, an SEO and AI search consultant, and a Semrush Ambassador.'],
        ['Where is Reinforce Lab based?', 'Reinforce Lab has offices in Dhaka, Bangladesh and Katy, Texas, in the United States, and works with clients remotely around the world.'],
        ['When did Reinforce Lab start?', 'Reinforce Lab began building brands in Bangladesh in 2020 and now works with businesses internationally.'],
        ['How is Reinforce Lab different from an SEO agency?', 'An agency usually sells separate tactics. We build one system: website, content, search and AI visibility, and the automation behind them, designed around your buyers and measured against revenue, not rankings alone.'],
        ['How do I start working with Reinforce Lab?', 'Start with the free Search Authority Diagnostic. It reviews your search visibility, content and AI-search presence and shows what to fix first. From there we recommend the smallest system that solves the problem.'],
    ];
}

add_filter('body_class', function ($c) { if (rl_is_about()) $c[] = 'rl-about-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_about(); });
add_action('wp_head', 'rl_about_css', 22);
function rl_about_css() {
    if (!rl_is_about()) return; ?>
<style id="rl-about-css">
body.rl-about-page .fl-page-content,body.rl-about-page .fl-content,body.rl-about-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-about .glance{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-about .glance .cap{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase;margin:0 0 8px}
.rl-about .glance dl{margin:0;display:grid;grid-template-columns:auto 1fr;column-gap:22px}
.rl-about .glance dt,.rl-about .glance dd{padding:13px 0;border-top:1px solid var(--line);margin:0}
.rl-about .glance dt{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);padding-top:16px}
.rl-about .glance dd{color:var(--ink);font-size:15px}
.rl-about .glance dd a{color:inherit}
.rl-about .founder{display:grid;grid-template-columns:.9fr 1.1fr;gap:clamp(24px,4vw,56px);align-items:start}
.rl-about .founder .card{border:1px solid var(--line-2);background:var(--panel);padding:26px}
.rl-about .founder .card .nm{font-family:var(--f-display);font-weight:600;font-size:28px;letter-spacing:.03em;text-transform:uppercase;margin:0 0 4px;color:var(--ink)}
.rl-about .founder .card .role{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);margin:0 0 18px}
.rl-about .founder .card ul{list-style:none;margin:0 0 20px;padding:0}
.rl-about .founder .card li{padding:10px 0;border-top:1px solid var(--line);color:var(--ink-dim);font-size:15px}
.rl-about .founder .txt p{color:var(--ink-dim);font-size:16.5px;margin:0 0 16px}
.rl-about .founder blockquote{margin:22px 0 0;padding:4px 0 4px 20px;border-left:2px solid var(--red-2);color:var(--ink);font-size:17px}
.rl-about .steps9{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--line);border:1px solid var(--line);list-style:none;margin:0;padding:0;counter-reset:s}
.rl-about .steps9 li{background:var(--bg-2);padding:22px}
.rl-about .steps9 .k{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--red-3)}
.rl-about .steps9 h3{margin:8px 0 6px}
.rl-about .steps9 p{margin:0;color:var(--ink-dim);font-size:15px}
.rl-about .office p{color:var(--ink-dim);font-size:15.5px;margin:0}
.rl-about .ind ul{margin:0;padding-left:18px;color:var(--ink-dim);font-size:14.5px}
@media(max-width:900px){.rl-about .founder{grid-template-columns:1fr}.rl-about .steps9{grid-template-columns:1fr 1fr}}
@media(max-width:560px){.rl-about .steps9{grid-template-columns:1fr}.rl-about .glance{padding:18px 16px}.rl-about .glance dl{column-gap:14px}}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_about()) return $graph;
    $url = get_permalink(get_queried_object_id());
    $org = home_url('/#organization');
    $pid = home_url('/#/schema/person/jamil-ahmed');
    $f = rl_about_person();
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if (in_array('WebPage', $t, true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) { $n['@type'] = ['WebPage', 'AboutPage']; $n['about'] = ['@id' => $org]; $n['mainEntity'] = ['@id' => $org]; }
        if (in_array('Organization', $t, true)) { $n['founder'] = ['@id' => $pid]; $n['foundingDate'] = '2020'; $n['foundingLocation'] = ['@type' => 'Place', 'name' => 'Bangladesh']; }
    }
    unset($n);
    $graph[] = [
        '@type' => 'Person', '@id' => $pid, 'name' => $f['name'], 'url' => $url,
        'jobTitle' => $f['job'], 'worksFor' => ['@id' => $org],
        'description' => 'Founder and CEO of Reinforce Lab. Pharmacist, SEO and AI search consultant, and Semrush Ambassador.',
        'knowsAbout' => ['Search engine optimization', 'AI search optimization', 'AI automation', 'Pharmacy'],
        'sameAs' => [$f['linkedin']],
    ];
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_about_faqs())];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_about', 'rl_render_about');
function rl_render_about() {
    if (!rl_is_about()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $diag = $u('search-authority-diagnostic');
    $f = rl_about_person();
    $method = [
        ['Discover', 'Audit what you have: search data, indexation, content and technical health.'],
        ['Preserve', 'Protect every page that already earns traffic, links or trust before anything changes.'],
        ['Architect', 'Design the site structure, URLs and internal links around how buyers search.'],
        ['Content', 'Plan and write evidence-led content for each stage of the buying journey.'],
        ['AI search', 'Make your facts clear and consistent for AI answers as well as blue links.'],
        ['Build', 'Build the pages, schema and automation to a written quality standard.'],
        ['QA', 'Check every page against that standard before it goes live.'],
        ['Launch', 'Go live with redirects mapped and tested, URL by URL.'],
        ['Monitor', 'Track visibility, leads and revenue, and fix what the data shows.'],
    ];
    $svc = [
        ['services/best-search-engine-optimization-services', 'Search Engine Optimization', 'The core search programme: technical, content and authority.'],
        ['services/ai-search-optimization', 'AI Search Optimization', 'Accurate, consistent visibility in AI answers and AI Overviews.'],
        ['services/seo-content-systems', 'SEO Content Systems', 'Research-to-publish content workflows with review built in.'],
        ['services/ai-workflow-automation', 'AI Workflow Automation', 'Repetitive operations automated, with people in the loop.'],
        ['services/lead-generation-systems', 'Lead Generation Systems', 'Search traffic turned into qualified enquiries and pipeline.'],
        ['services/executive-ai-consulting', 'Executive AI Consulting', 'Where AI helps your business, and where it doesn’t.'],
    ];
    ob_start(); ?>
<div class="rl-page rl-about">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">About</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;About Reinforce Lab&nbsp;<b>]</b></span>
      <h1 class="h1">About Reinforce Lab.<br>We build AI<br><span class="r">growth systems.</span></h1>
      <p class="lede"><strong>Reinforce Lab builds AI Growth Systems</strong> that connect your website, content, and organic search visibility into one growth engine. Founded by pharmacist and Semrush Ambassador <strong>Jamil Ahmed</strong>, we work with growth-stage founders and B2B companies from offices in Dhaka, Bangladesh and Katy, Texas.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#founder">Meet the founder</a>
      </div>
    </div>
    <aside class="glance" aria-label="Reinforce Lab at a glance">
      <p class="cap">At a glance</p>
      <dl>
        <dt>What</dt><dd>AI Growth Systems: SEO, AI search, content and automation as one system</dd>
        <dt>Founder</dt><dd><a href="#founder"><?php echo esc_html($f['name']); ?></a>, <?php echo esc_html($f['job']); ?></dd>
        <dt>Started</dt><dd>2020, Bangladesh</dd>
        <dt>Offices</dt><dd>Dhaka, Bangladesh · Katy, Texas, USA</dd>
        <dt>Clients</dt><dd>Worldwide, working remotely</dd>
      </dl>
    </aside>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we do&nbsp;<b>]</b></span><h2>What is an AI Growth System?</h2><p class="lede">One connected system instead of separate tactics, built to automate operations, improve search visibility, and increase revenue.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01</span><h3>Automate operations</h3><p>AI workflows take over repetitive research, content and reporting work, with a person reviewing what matters.</p></div>
      <div class="cell"><span class="n">02</span><h3>Improve search visibility</h3><p>Technical SEO, content and AI-search work that help the right buyers find you, in Google and in AI answers.</p></div>
      <div class="cell"><span class="n">03</span><h3>Increase revenue</h3><p>Visibility connected to enquiries and pipeline, so success is measured in customers, not traffic alone.</p></div>
    </div>
  </div>
</section>

<section id="founder">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The founder&nbsp;<b>]</b></span><h2>Who founded Reinforce Lab?</h2></div>
    <div class="founder">
      <div class="card">
        <p class="nm"><?php echo esc_html($f['name']); ?></p>
        <p class="role"><?php echo esc_html($f['job']); ?>, Reinforce Lab</p>
        <ul>
          <li>Pharmacist</li>
          <li>SEO &amp; AI search consultant</li>
          <li>Semrush Ambassador</li>
        </ul>
        <a class="btn g" href="<?php echo esc_url($f['linkedin']); ?>" rel="noopener" target="_blank">Jamil on LinkedIn <span class="ar">&rarr;</span></a>
      </div>
      <div class="txt">
        <p>Reinforce Lab was founded by <strong>Jamil Ahmed</strong>, who leads the company as Founder and CEO. He is a pharmacist, an SEO and AI search consultant, and a Semrush Ambassador.</p>
        <p>Jamil helps businesses design and implement AI Growth Systems using AI automation, AI Search Optimization, SEO, and intelligent workflows.</p>
        <blockquote>“I build AI Growth Systems for businesses with AI Automation, AI Search &amp; SEO.”<br><small style="color:var(--ink-faint);font-size:13px">Jamil Ahmed, LinkedIn</small></blockquote>
      </div>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How we work&nbsp;<b>]</b></span><h2>How does Reinforce Lab work?</h2><p class="lede">Every engagement follows the same nine-stage method, from first audit to ongoing monitoring.</p></div>
    <ol class="steps9">
      <?php foreach ($method as $i => $m) { ?>
      <li><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo esc_html($m[0]); ?></h3><p><?php echo esc_html($m[1]); ?></p></li>
      <?php } ?>
    </ol>
  </div>
</section>

<section id="principles">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Principles&nbsp;<b>]</b></span><h2>What do we stand for?</h2><p class="lede">Four rules we work by.</p></div>
    <div class="cols c2">
      <div class="cell"><span class="n">01</span><h3>Evidence before claims</h3><p>We cite our sources and never invent metrics, rankings or results, for our clients or for ourselves.</p></div>
      <div class="cell"><span class="n">02</span><h3>Preserve what already works</h3><p>Pages that earn traffic, links or trust are protected before anything is redesigned, moved or merged.</p></div>
      <div class="cell"><span class="n">03</span><h3>One system, not separate tactics</h3><p>Website, content, search and automation are planned together so each one strengthens the others.</p></div>
      <div class="cell"><span class="n">04</span><h3>People review the AI</h3><p>AI speeds up the work; a person checks what it produces before anything is published or delivered.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="services">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>]</b></span><h2>Which services does Reinforce Lab offer?</h2><p class="lede">Six places most clients start. <a href="<?php echo $u('services'); ?>">See all services</a> or the <a href="<?php echo $u('search-authority-os'); ?>">Search Authority OS</a>.</p></div>
    <div class="cols c3">
      <?php foreach ($svc as $s) { $l = $ex($s[0]); ?>
      <div class="cell"><span class="n">Service</span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($s[1]) . '</a>' : esc_html($s[1]); ?></h3><p><?php echo esc_html($s[2]); ?></p><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr($s[1]) . '">Explore &rarr;</a>'; ?></div>
      <?php } ?>
    </div>
  </div>
</section>

<?php if (function_exists('rl_ind_data')) { ?>
<section id="industries">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Industries&nbsp;<b>]</b></span><h2>Which industries do we work with?</h2><p class="lede">Eight sectors, each with its own buyers, rules and trust signals.</p></div>
    <ul class="inds8">
      <?php $i = 0; foreach (rl_ind_data() as $slug => $d) { $l = $ex('industries/' . $slug); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', ++$i); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d['name']) . '</a>' : esc_html($d['name']); ?></h3><ul><?php foreach (array_slice($d['chal'], 0, 2) as $c) echo '<li>' . esc_html($c[0]) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('AI Growth Systems for ' . $d['name']) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>
<?php } ?>

<section class="band alt" id="offices">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Offices&nbsp;<b>]</b></span><h2>Where is Reinforce Lab based?</h2><p class="lede">Two offices, clients worldwide.</p></div>
    <div class="cols c2">
      <div class="cell office"><span class="n">Bangladesh</span><h3>Dhaka</h3><p>Suite #1402, Level-13, Concord Tower,<br>113 Kazi Nazrul Islam Avenue, Dhaka 1000, Bangladesh.<br><a href="tel:+8801329657096">+880 1329-657096</a></p></div>
      <div class="cell office"><span class="n">United States</span><h3>Katy, Texas</h3><p>2511 Pines Pointe Dr, Katy, TX 77493, USA.<br><a href="tel:+18325484553">+1 832 548 4553</a></p></div>
    </div>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Why are there no client logos or results on this page?</h2>
      <p>Because we only publish what we can show. Case studies, client names and numbers go up with a client’s permission and the data to back them, not before. Until then, the fastest way to judge our work is the free diagnostic on your own site.</p>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About Reinforce Lab.</h2></div>
    <?php foreach (rl_about_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See where your growth system stands.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence, and shows what to fix first.</p>
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
