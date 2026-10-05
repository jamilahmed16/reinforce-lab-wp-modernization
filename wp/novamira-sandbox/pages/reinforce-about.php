<?php
/**
 * Plugin Name: Reinforce Lab - About
 * Description: /about-us/ (APPROVED - PRESERVE, rebuilt to the D-012 standard; company-led copy v2, D-110). Provides [reinforce_about]. Uses the shared kit (D-044). No hero animation (About is excluded, D-039). Schema: AboutPage + Person (founder) + FAQPage; Organization gains founder, foundingDate, award, knowsAbout, areaServed.
 * Version: 2.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_about() { return is_page('about-us') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }

/* Founder facts: confirmed by Jamil (D-008 locked positioning; 28 Sep Home FAQ facts).
   Origin (Jamil, 5 Oct, D-109): started in Tallinn, Estonia in 2020 as a full-service digital marketing agency; expanded to Bangladesh in 2021.
   Reinforce Lab Limited founded 1 April 2021, Bangladesh (D-108). No Estonian office today. */
function rl_about_person() {
    return [
        'name' => 'Jamil Ahmed',
        'job' => 'Founder and CEO',
        'linkedin' => 'https://www.linkedin.com/in/ahmedjamil16/',
        'interview' => 'https://onalytica.com/blog/posts/interview-jamil-ahmed/', // Onalytica, 7 Sep 2018: career and education source (verified, F-023)
    ];
}

function rl_about_faqs() {
    return [
        ['What is Reinforce Lab?', 'Reinforce Lab is an AI Growth Systems company. We connect a company\'s website, content and organic search visibility into one growth engine, with AI automation taking over the repetitive work, and measure it against enquiries and revenue.'],
        ['When and where did Reinforce Lab start?', 'Reinforce Lab started in Tallinn, Estonia in 2020 as a full-service digital marketing agency. It expanded to Bangladesh in 2021, where Reinforce Lab Limited was founded on 1 April 2021.'],
        ['Who founded Reinforce Lab?', 'Jamil Ahmed, who leads the company as Founder and CEO. Jamil is a pharmacist, an SEO and AI search consultant, and a Semrush Ambassador.'],
        ['Where is Reinforce Lab based?', 'Reinforce Lab has offices in Dhaka, Bangladesh and Katy, Texas, in the United States, and works with clients remotely around the world.'],
        ['How is Reinforce Lab different from a digital marketing agency?', 'We started as one. An agency usually sells separate tactics; we now build one system: website, content, search and AI visibility, and the automation behind them, designed around your buyers and measured against revenue, not rankings alone.'],
        ['Which industries does Reinforce Lab work with?', 'Eight: Pharmaceutical & Life Sciences, Healthcare, B2B SaaS, E-commerce, Manufacturing, Technology, Professional Services and Education.'],
        ['How do I start working with Reinforce Lab?', 'Start with the free Search Authority Diagnostic. It reviews your search visibility, content and AI search presence and shows what to fix first. From there we recommend the smallest system that solves the problem.'],
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
.rl-about .sub{font-family:var(--f-display);font-weight:600;text-transform:uppercase;letter-spacing:.03em;color:var(--ink);font-size:clamp(20px,2.2vw,26px);margin:clamp(34px,4vw,48px) 0 18px}
.rl-about .story{display:grid;grid-template-columns:1.05fr .95fr;gap:clamp(24px,4vw,64px);align-items:stretch}
.rl-about .story .head{margin-bottom:clamp(24px,3vw,34px)}
.rl-about .ms{border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:clamp(22px,2.6vw,32px);box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-about .story .txt p{color:var(--ink-dim);font-size:16.5px;margin:0 0 16px}
.rl-about .story .txt p:first-child{color:var(--ink)}
.rl-about .story .sub{margin-top:0}
.rl-about .tl{list-style:none;margin:0;padding:0;border-left:1px solid var(--red-line)}
.rl-about .tl li{position:relative;padding:0 0 20px 26px}
.rl-about .tl li:last-child{padding-bottom:0}
.rl-about .tl li::before{content:"";position:absolute;left:-5px;top:5px;width:9px;height:9px;background:var(--red);box-shadow:0 0 12px var(--red-glow)}
.rl-about .tl .y{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--red-3);text-transform:uppercase}
.rl-about .tl p{margin:4px 0 0;color:var(--ink);font-size:15.5px}
.rl-about .c4{grid-template-columns:repeat(4,1fr)}
.rl-about .note{color:var(--ink-dim);font-size:16px;max-width:80ch;margin:22px 0 0}
.rl-about .links{margin-top:22px;display:flex;flex-wrap:wrap;gap:12px}
.rl-about .reg{margin-top:16px;border:1px solid var(--red-line);background:linear-gradient(180deg,rgba(153,0,0,.08),var(--glass));padding:clamp(20px,3vw,30px)}
.rl-about .reg h3{margin:0 0 10px}
.rl-about .reg p{margin:0;color:var(--ink-dim);font-size:15.5px;max-width:80ch}
.rl-about a.cell{color:inherit;text-decoration:none;display:flex;flex-direction:column;gap:8px}
@media(max-width:1000px){.rl-about .c4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){.rl-about .story{grid-template-columns:1fr}}
@media(max-width:600px){.rl-about .c4{grid-template-columns:1fr}.rl-about .glance dl{grid-template-columns:minmax(0,36%) 1fr}}
.rl-about .founder .card .ph{display:block;width:100%;height:auto;aspect-ratio:4/5;object-fit:cover;margin:0 0 20px;border:1px solid var(--line-2)}
.rl-about .cred{margin:0 0 20px;display:grid;grid-template-columns:auto 1fr;column-gap:18px}
.rl-about .cred dt,.rl-about .cred dd{margin:0;padding:12px 0;border-top:1px solid var(--line)}
.rl-about .cred dt{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);padding-top:15px}
.rl-about .cred dd{color:var(--ink);font-size:15px}
.rl-about .founder .card .links{margin-top:0}
.rl-about .founder .txt .sub{margin-top:0}
.rl-about .founder blockquote small{color:var(--ink-faint);font-size:13px}
.rl-about .path{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:var(--line);border:1px solid var(--line)}
.rl-about .path li{background:var(--bg-2);padding:20px 22px}
.rl-about .path .y{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--red-3);text-transform:uppercase}
.rl-about .path h4{font-family:var(--f-display);text-transform:uppercase;letter-spacing:.03em;font-size:17px;color:var(--ink);margin:8px 0 6px}
.rl-about .path p{margin:0;color:var(--ink-dim);font-size:14.5px}
@media(max-width:1000px){.rl-about .path{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rl-about .path{grid-template-columns:1fr}.rl-about .cred{grid-template-columns:minmax(0,36%) 1fr}}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_about()) return $graph;
    $url = get_permalink(get_queried_object_id());
    $org = home_url('/#organization');
    $ju = get_user_by('login', 'jamilahmed');
    $pid = ($ju && function_exists('rl_person_schema_id')) ? rl_person_schema_id($ju->ID) : home_url('/#/schema/person/jamil-ahmed'); // same @id Yoast gives Jamil on posts
    $f = rl_about_person();
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        $t = (array) $n['@type'];
        if (in_array('WebPage', $t, true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) { $n['@type'] = ['WebPage', 'AboutPage']; $n['about'] = ['@id' => $org]; $n['mainEntity'] = ['@id' => $org]; }
        if (in_array('Organization', $t, true)) {
            $n['founder'] = ['@id' => $pid];
            $n['foundingDate'] = '2021-04-01';
            $n['foundingLocation'] = ['@type' => 'Place', 'name' => 'Bangladesh'];
            $n['areaServed'] = 'Worldwide';
            $n['knowsAbout'] = ['Search engine optimization', 'AI search optimization', 'Generative engine optimization', 'Content systems', 'AI workflow automation', 'Marketing automation', 'Lead generation', 'Executive AI consulting', 'WordPress website design'];
            if (function_exists('rl_awards_schema_list')) $n['award'] = rl_awards_schema_list();
        }
    }
    unset($n);
    $graph[] = [
        '@type' => 'Person', '@id' => $pid, 'name' => $f['name'], 'url' => $url,
        'jobTitle' => $f['job'], 'worksFor' => ['@id' => $org],
        'description' => 'Founder and CEO of Reinforce Lab. Pharmacist, SEO and AI search consultant, and Semrush Ambassador.',
        'knowsAbout' => ['Search engine optimization', 'AI search optimization', 'AI automation', 'Pharmacy', 'Pharmaceutical marketing'],
        'alumniOf' => ['@type' => 'CollegeOrUniversity', 'name' => 'East West University', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Dhaka', 'addressCountry' => 'BD']],
        'subjectOf' => ['@type' => 'Article', 'headline' => 'Interview with Jamil Ahmed', 'url' => $f['interview'], 'datePublished' => '2018-09-07', 'publisher' => ['@type' => 'Organization', 'name' => 'Onalytica']],
        'sameAs' => [$f['linkedin']],
    ];
    if ($ph = get_option('rl_about_founder_photo')) $graph[count($graph) - 1]['image'] = $ph;
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
    $timeline = [
        ['2020', 'Reinforce Lab starts in Tallinn, Estonia, as a full-service digital marketing agency.'],
        ['2021', 'Expands to Bangladesh: Reinforce Lab Limited is founded on 1 April 2021.'],
        ['2024', 'Winner in Dhaka, HackerNoon Startups of The Year 2024, and 11th of about 8,000 startups in Marketing.'],
        ['2025', 'Named in DesignRush\'s Best Digital Marketing Agencies of June 2025.'],
        ['2026', 'Ranked 8th of 442 SEO agencies in Bangladesh on GoodFirms (October).'],
        ['Today', 'Builds AI Growth Systems: search, content and automation as one system, with Search Authority OS as the flagship.'],
    ];
    $groups = [
        ['01', 'Search', 'Rankings and clicks in Google and Bing, built on technical health, strategy and authority.'],
        ['02', 'AI Search and Content', 'Being the source AI engines find, trust and cite, with content produced as a system.'],
        ['03', 'Automation and Growth', 'Less manual work, and search demand turned into qualified pipeline.'],
        ['04', 'Advisory and Web', 'Leadership direction on AI, and websites built to rank and convert.'],
    ];
    $engage = [
        ['Diagnostic', 'The free Search Authority Diagnostic sets your real baseline and shows what to fix first.'],
        ['Scope and proposal', 'A plan and price fitted to your goals. No template retainer.'],
        ['Build and onboard', 'The system is set up for your market, your buyers and your evidence sources.'],
        ['Run and improve', 'Work ships, performance is monitored, and the system is adjusted as results come in.'],
    ];
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
    $principles = [
        ['Evidence before claims', 'We cite our sources and never invent metrics, rankings or results, for our clients or for ourselves.'],
        ['Preserve what already works', 'Pages that earn traffic, links or trust are protected before anything is redesigned, moved or merged.'],
        ['One system, not separate tactics', 'Website, content, search and automation are planned together so each one strengthens the others.'],
        ['People review the AI', 'AI speeds up the work; a person checks what it produces before anything is published or delivered.'],
        ['Measured on business results', 'We report enquiries, pipeline and revenue next to rankings and traffic.'],
        ['You own the work', 'Everything we produce for you is yours.'],
    ];
    $recognition = [
        ['HackerNoon', 'Startups of The Year 2024', 'Winner, Dhaka.', 'https://hackernoon.com/startups-of-the-year-2024-winners-asia'],
        ['DesignRush', 'Best Digital Marketing Agencies', 'June 2025.', 'https://www.newsfilecorp.com/release/255349/DesignRush-Names-the-Best-Digital-Marketing-Agencies-of-June-2025'],
        ['GoodFirms', 'Top SEO Agencies in Bangladesh', '8th of 442 (October 2026).', 'https://www.goodfirms.co/seo-agencies/bangladesh'],
        ['Semrush', 'Agency Partner', 'Listed in the Semrush Agency Partners directory.', 'https://agencies.semrush.com/reinforce-lab-ltd'],
        ['Google', 'Reviews', '4.6 from 8 reviews.', 'https://www.google.com/maps/search/?api=1&query=Reinforce+Lab+Limited+Concord+Tower+Dhaka'],
    ];
    $inds = function_exists('rl_ind_data') ? rl_ind_data() : [];
    $photo = get_option('rl_about_founder_photo'); // headshot URL; the photo shows once Jamil supplies one
    $career = [
        ['2012', 'International business, oncology pharma', 'Country manager for markets in South Asia, West Africa and Latin America.'],
        ['2016', 'International marketing, Square Group', 'New business, product registration and brand positioning.'],
        ['2017', 'Product Manager, Janssen', 'Immunology, at the pharmaceutical companies of Johnson & Johnson.'],
        ['2018', 'Interviewed by Onalytica', 'On business intelligence, data and digital marketing.'],
        ['2020', 'Starts Reinforce Lab', 'A full-service digital marketing agency in Tallinn, Estonia.'],
        ['2021', 'Reinforce Lab Limited', 'Founded in Bangladesh on 1 April 2021.'],
        ['2025', 'Semrush Ambassador', 'Named a Semrush Ambassador in May 2025.'],
        ['Today', 'CEO, AI Growth Systems', 'Leads the shift to search, content and automation as one system.'],
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
      <h1 class="h1">We build the system that gets a company <span class="r">found, trusted and chosen.</span></h1>
      <p class="lede"><strong>Reinforce Lab</strong> started in Tallinn, Estonia in 2020 as a full-service digital marketing agency and expanded to Bangladesh in 2021. Today we build <strong>AI Growth Systems</strong>: a company's website, content and search visibility connected into one engine, with AI automation taking over the repetitive work so the business can grow without adding headcount for every task.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#story">Our story</a>
      </div>
    </div>
    <aside class="glance" aria-label="Reinforce Lab at a glance">
      <p class="cap">At a glance</p>
      <dl>
        <dt>Started</dt><dd>2020, Tallinn, Estonia</dd>
        <dt>Founded</dt><dd>1 April 2021, Bangladesh (Reinforce Lab Limited)</dd>
        <dt>Founder and CEO</dt><dd><a href="#founder"><?php echo esc_html($f['name']); ?></a></dd>
        <dt>What we build</dt><dd>AI Growth Systems: search, content and automation as one system</dd>
        <dt>Offices</dt><dd>Dhaka, Bangladesh · Katy, Texas, USA</dd>
        <dt>Clients</dt><dd>Worldwide, working remotely</dd>
        <dt>Industries</dt><dd>8, from pharmaceutical to education</dd>
        <dt>Recognition</dt><dd>HackerNoon Startups of The Year 2024, winner in Dhaka (<a href="<?php echo $u('awards'); ?>">Awards</a>)</dd>
      </dl>
    </aside>
  </div>
</section>

<section class="band alt" id="story">
  <div class="wrap">
    <div class="story">
      <div class="txt">
        <div class="head"><span class="ey"><b>[</b>&nbsp;Our story&nbsp;<b>]</b></span><h2>How did Reinforce Lab start?</h2></div>
        <p>Reinforce Lab started in 2020 in Tallinn, Estonia, as a full-service digital marketing agency. In 2021 we expanded to Bangladesh, where Reinforce Lab Limited was founded on 1 April 2021, and built our team in Dhaka.</p>
        <p>Years of running search, content and marketing for clients showed us the same problem again and again: the work was split across separate tools, separate agencies and a lot of manual effort, and nobody connected the pieces.</p>
        <p>So we changed what we sell. Today Reinforce Lab helps businesses scale with automation: we connect the website, content and search visibility into one system and let AI take over the repetitive work, with a person checking what matters.</p>
      </div>
      <aside class="ms" aria-label="Milestones">
        <h3 class="sub">Milestones</h3>
        <ol class="tl">
          <?php foreach ($timeline as $t) { ?>
          <li><span class="y"><?php echo esc_html($t[0]); ?></span><p><?php echo esc_html($t[1]); ?></p></li>
          <?php } ?>
        </ol>
      </aside>
    </div>
  </div>
</section>

<section id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What we build&nbsp;<b>]</b></span><h2>What is an AI Growth System?</h2><p class="lede">One connected system instead of separate tactics, built to do three jobs.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01</span><h3>Automate operations</h3><p>AI workflows take over repetitive research, content and reporting work, with a person reviewing what matters.</p></div>
      <div class="cell"><span class="n">02</span><h3>Improve search visibility</h3><p>Technical SEO, content and AI search work help the right buyers find you, in Google and in AI answers.</p></div>
      <div class="cell"><span class="n">03</span><h3>Increase revenue</h3><p>Visibility is connected to enquiries and pipeline, so success is counted in customers.</p></div>
    </div>
    <h3 class="sub">Four groups of services, one strategy</h3>
    <div class="cols c4">
      <?php foreach ($groups as $g) { ?>
      <div class="cell"><span class="n"><?php echo esc_html($g[0]); ?></span><h3><?php echo esc_html($g[1]); ?></h3><p><?php echo esc_html($g[2]); ?></p></div>
      <?php } ?>
    </div>
    <p class="note">Our flagship, <a href="<?php echo $u('search-authority-os'); ?>">Search Authority OS</a>, runs search authority as one loop: research, verify, write, audit, monitor.</p>
    <div class="links">
      <a class="btn g" href="<?php echo $u('services'); ?>">See all services</a>
      <a class="btn g" href="<?php echo $u('search-authority-os'); ?>">Search Authority OS</a>
      <a class="btn g" href="<?php echo $u('packages'); ?>">Packages and pricing</a>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who we work with&nbsp;<b>]</b></span><h2>Who is Reinforce Lab for?</h2><p class="lede">Growth-stage founders and B2B companies that need search to produce customers, not only traffic, and want less manual work behind it. Most fit one of three situations.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01</span><h3>Search has stopped producing leads</h3><p>Traffic is falling, or the leads have dried up, and nobody can say why.</p></div>
      <div class="cell"><span class="n">02</span><h3>Missing from AI answers</h3><p>They rank on Google but not in ChatGPT, Perplexity or AI Overviews, or AI tools describe them wrongly.</p></div>
      <div class="cell"><span class="n">03</span><h3>Too much repetitive work</h3><p>Their team spends hours on marketing and reporting work that a system could do.</p></div>
    </div>
    <?php if ($inds) { ?>
    <h3 class="sub">Eight industries</h3>
    <ul class="chips">
      <?php foreach ($inds as $slug => $d) { $l = $ex('industries/' . $slug); ?>
      <li><?php echo $l ? '<a href="' . $l . '">' . esc_html($d['name']) . '</a>' : '<span>' . esc_html($d['name']) . '</span>'; ?></li>
      <?php } ?>
    </ul>
    <?php } ?>
    <div class="reg">
      <h3>Why regulated fields come naturally to us</h3>
      <p>Our founder is a pharmacist. In pharmaceuticals and healthcare a wrong claim can do harm, so evidence checking is built into how we write for every client: claims carry a source, conflicting sources are investigated, and anything unverified goes to a person before it is published.</p>
    </div>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How we work&nbsp;<b>]</b></span><h2>How does an engagement with Reinforce Lab work?</h2><p class="lede">It starts with a diagnostic, not a proposal.</p></div>
    <div class="cols c4">
      <?php foreach ($engage as $i => $e) { ?>
      <div class="cell"><span class="n"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo esc_html($e[0]); ?></h3><p><?php echo esc_html($e[1]); ?></p></div>
      <?php } ?>
    </div>
    <p class="note">There is no cart and no self-checkout: work at this level is scoped on a call after the diagnostic.</p>
    <h3 class="sub">The nine-stage method behind every project</h3>
    <ol class="steps9">
      <?php foreach ($method as $i => $m) { ?>
      <li><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo esc_html($m[0]); ?></h3><p><?php echo esc_html($m[1]); ?></p></li>
      <?php } ?>
    </ol>
  </div>
</section>

<section class="band alt" id="principles">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Principles&nbsp;<b>]</b></span><h2>What do we stand for?</h2><p class="lede">Six rules we work by.</p></div>
    <div class="cols c3">
      <?php foreach ($principles as $i => $p) { ?>
      <div class="cell"><span class="n"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo esc_html($p[0]); ?></h3><p><?php echo esc_html($p[1]); ?></p></div>
      <?php } ?>
    </div>
  </div>
</section>

<section id="founder">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Leadership&nbsp;<b>]</b></span><h2>Who leads Reinforce Lab?</h2></div>
    <div class="founder">
      <div class="card">
        <?php if ($photo) { ?><img class="ph" src="<?php echo esc_url($photo); ?>" alt="Jamil Ahmed, Founder and CEO of Reinforce Lab" width="600" height="750" loading="lazy"><?php } ?>
        <p class="nm"><?php echo esc_html($f['name']); ?></p>
        <p class="role"><?php echo esc_html($f['job']); ?>, Reinforce Lab</p>
        <dl class="cred">
          <dt>Education</dt><dd>B.Pharm, East West University, Dhaka</dd>
          <dt>Pharma career</dt><dd>From 2012: international business, Square Group, Janssen (Johnson &amp; Johnson)</dd>
          <dt>Markets</dt><dd>Sri Lanka, Ghana, Kenya, Mauritania, Puerto Rico, Cuba</dd>
          <dt>Today</dt><dd>SEO and AI search consultant · Semrush Ambassador</dd>
        </dl>
        <div class="links">
          <a class="btn g" href="<?php echo esc_url($f['linkedin']); ?>" rel="noopener" target="_blank">Jamil on LinkedIn <span class="ar">&rarr;</span></a>
          <a class="btn g" href="<?php echo esc_url($f['interview']); ?>" rel="noopener" target="_blank">2018 interview <span class="ar">&rarr;</span></a>
        </div>
      </div>
      <div class="txt">
        <h3 class="sub">From pharmaceutical marketing to AI Growth Systems</h3>
        <p><strong>Jamil Ahmed</strong> founded Reinforce Lab and leads it as CEO. He is an SEO and AI search consultant, a pharmacist and a Semrush Ambassador, and his whole career has been about one job: putting the right product in front of the right people, with claims that stand up.</p>
        <p>He trained as a pharmacist at East West University in Dhaka and started in pharmaceutical international business in 2012, at an oncology company in Bangladesh. As country manager for markets including Sri Lanka, Ghana, Kenya, Mauritania, Puerto Rico and Cuba, he registered and marketed more than 16 oncology brands and 5 general medicine brands in Sri Lanka, and helped bring the antibiotic ciprofloxacin (brand Xbac) onto Ghana's Essential Medicines List through the Ghana National Drugs Program.</p>
        <p>He went on to international marketing at Square Group in 2016 and, in 2017, to Product Manager for Immunology at Janssen, the pharmaceutical companies of Johnson &amp; Johnson, where he ran promotional plans, trained sales teams and worked with key opinion leaders.</p>
        <p>Regulated marketing taught him that every claim needs evidence and every message has to survive medical and legal review. He brought that discipline to digital marketing, started Reinforce Lab in Tallinn in 2020 and took it to Bangladesh in 2021. Today he leads the company's shift to AI Growth Systems: the website, content and search visibility built as one system, connected with AI automation, and measured against revenue.</p>
        <blockquote>“I build AI Growth Systems for businesses with AI Automation, AI Search &amp; SEO.”<br><small>Jamil Ahmed, LinkedIn</small></blockquote>
      </div>
    </div>
    <h3 class="sub">Career path</h3>
    <ol class="path">
      <?php foreach ($career as $c) { ?>
      <li><span class="y"><?php echo esc_html($c[0]); ?></span><h4><?php echo esc_html($c[1]); ?></h4><p><?php echo esc_html($c[2]); ?></p></li>
      <?php } ?>
    </ol>
  </div>
</section>

<section class="band alt" id="recognition">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Recognition&nbsp;<b>]</b></span><h2>What has Reinforce Lab been recognised for?</h2><p class="lede">Every item links to the page that confirms it.</p></div>
    <div class="cols c3">
      <?php foreach ($recognition as $r) { ?>
      <a class="cell" href="<?php echo esc_url($r[3]); ?>" rel="noopener" target="_blank"><span class="n"><?php echo esc_html($r[0]); ?></span><h3><?php echo esc_html($r[1]); ?></h3><p><?php echo esc_html($r[2]); ?></p><span class="more">See the source &rarr;</span></a>
      <?php } ?>
      <a class="cell" href="<?php echo $u('awards'); ?>"><span class="n">All of it</span><h3>Awards and recognition</h3><p>Every award, ranking, partner listing and mention, with dates and sources.</p><span class="more">See all awards &rarr;</span></a>
    </div>
  </div>
</section>

<section id="offices">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Offices&nbsp;<b>]</b></span><h2>Where is Reinforce Lab based?</h2><p class="lede">Two offices, clients worldwide. Email <a href="mailto:hello@reinforcelab.com">hello@reinforcelab.com</a>.</p></div>
    <div class="cols c2">
      <div class="cell office"><span class="n">Bangladesh</span><h3>Dhaka</h3><p>Suite #1402, Level-13, Concord Tower,<br>113 Kazi Nazrul Islam Avenue, Dhaka 1000, Bangladesh.<br><a href="tel:+8801329657096">+880 1329-657096</a></p></div>
      <div class="cell office"><span class="n">United States</span><h3>Katy, Texas</h3><p>2511 Pines Pointe Dr, Katy, TX 77493, USA.<br><a href="tel:+18325484553">+1 832 548 4553</a></p></div>
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
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI search presence, and shows what to fix first.</p>
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
