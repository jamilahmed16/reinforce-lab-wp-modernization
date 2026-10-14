<?php
/**
 * Plugin Name: Reinforce Lab - Reviews hub and pillars
 * Description: /reviews/ (page 67), /reviews/best-wordpress-hosting/ (69), /reviews/best-seo-ai-tools/ (70). Approved new URLs (D-016); the hub that links the 19 carried review and hosting posts and the WP Engine partner page (D-014b, D-145). Provides [reinforce_reviews view="hub|hosting|tools"]. D-191: built without rankings, scores or prices: the posts are rewritten first-hand later (Jamil, 14 Oct: "nothing will be eliminate keep all the posts we will rewrite later"). Card lines are written here (the carried titles keep their old wording until each rewrite).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_reviews_view() {
    if (!is_page()) return '';
    $p = get_queried_object();
    if (!$p || empty($p->post_name)) return '';
    if ($p->post_name === 'reviews' && (int) $p->post_parent === 0) return 'hub';
    $parent = $p->post_parent ? get_post($p->post_parent) : null;
    if (!$parent || $parent->post_name !== 'reviews') return '';
    if ($p->post_name === 'best-wordpress-hosting') return 'hosting';
    if ($p->post_name === 'best-seo-ai-tools') return 'tools';
    return '';
}

/* [post slug, name, kind, card line] */
function rl_reviews_data() {
    return [
        'hosting' => [
            ['a2-wordpress-hosting', 'A2 Hosting', 'Shared and managed WordPress', 'How to build a WordPress site on A2 Hosting, step by step.'],
            ['bluehost-wordpress-hosting', 'Bluehost', 'Shared WordPress hosting', 'How to build a WordPress site on Bluehost, step by step.'],
            ['cloudways-hosting', 'Cloudways', 'Managed cloud hosting', 'How to build a website on Cloudways, step by step.'],
            ['dreamhost-wordpress-hosting', 'DreamHost', 'Shared and managed WordPress', 'How to build a WordPress site on DreamHost, step by step.'],
            ['flywheel-wordpress-hosting', 'Flywheel', 'Managed WordPress hosting', 'How to build a WordPress site on Flywheel, step by step.'],
            ['hostinger-web-hosting', 'Hostinger', 'Shared and cloud hosting', 'How to build a website on Hostinger, step by step.'],
            ['kinsta-wordpress-hosting', 'Kinsta', 'Managed WordPress hosting', 'How to build a WordPress site on Kinsta, step by step.'],
            ['namecheap-wordpress-hosting', 'Namecheap', 'Shared and WordPress hosting', 'How to build a WordPress site on Namecheap, step by step.'],
            ['nexcess-wordpress-hosting', 'Nexcess', 'Managed WordPress and WooCommerce', 'How to build a WordPress site on Nexcess, step by step.'],
        ],
        'hosting_lists' => [
            ['best-web-hosting-services', 'Web hosting services', 'Comparison list', 'A list of 15 web hosts, with what each one offers.'],
            ['best-cloud-web-hosting-services', 'Cloud web hosting', 'Comparison list', 'A list of 13 cloud hosts, with what each one offers.'],
        ],
        'tools' => [
            'SEO tools' => [
                ['semrush-review', 'Semrush', 'SEO and competitor research', 'Keyword research, site audits and competitor research in one suite.'],
                ['surfer-seo-review', 'Surfer SEO', 'On-page content optimisation', 'Scores a page against the pages that rank for the same search.'],
                ['rank-tracker-review', 'Rank Tracker', 'Rank tracking', 'Tracks where your pages rank for the keywords you choose.'],
            ],
            'AI writing tools' => [
                ['copy-ai-review', 'Copy.ai', 'AI writing', 'Drafts marketing copy such as ads, emails and product text.'],
                ['writesonic-review', 'Writesonic', 'AI writing', 'Drafts articles, ads and landing page copy.'],
                ['jasper-review', 'Jasper', 'AI writing', 'Drafts marketing content for teams, with brand voice settings.'],
            ],
            'Work and website tools' => [
                ['clickup-review', 'ClickUp', 'Project management', 'Tasks, docs and project boards for a team in one place.'],
                ['beaver-builder-review', 'Beaver Builder', 'WordPress page builder', 'A drag-and-drop page builder for WordPress. We build with it ourselves.'],
            ],
        ],
    ];
}

function rl_reviews_faqs($view) {
    $f = [
        'hub' => [
            ['Are these reviews independent?', 'No company pays us for a review, a ranking or positive coverage, and no company sees a review before it is published. Some links earn us a commission; each one is marked Ad.'],
            ['Why do some reviews show an older date?', 'We are rewriting each review one at a time, first-hand. A rewritten review says when we used the product, what we tested and whether we paid for it.'],
            ['Can you help me choose?', 'Yes. Tell us what your site needs and we will tell you which host or tool fits, including when a cheaper option is enough.'],
        ],
        'hosting' => [
            ['What is the difference between shared and managed WordPress hosting?', 'Shared hosting puts many sites on one server and leaves updates, speed and security largely to you. Managed WordPress hosting is set up for WordPress only, with the host handling caching, backups, platform updates and WordPress support.'],
            ['Which host do you use for client sites?', 'It depends on the site. For business sites where speed and uptime matter we often recommend WP Engine, where we are an agency partner. For small sites a lower-cost host can be enough.'],
            ['Can you move my site to a new host?', 'Yes. We map every URL first, move the site, and test the redirects before switching, so pages that earn traffic keep their place in search.'],
        ],
        'tools' => [
            ['Which SEO tool should I start with?', 'Start with what you need to answer. An all-in-one suite such as Semrush covers keyword research, audits and competitors; a rank tracker or a content tool does one job in more depth.'],
            ['Can AI writing tools replace a writer?', 'They can speed up drafts. A person still needs to check every claim, add first-hand detail and edit for the reader before anything is published. We review all AI-drafted text before it is used.'],
            ['Do you have a relationship with these companies?', 'We are a Semrush agency partner and affiliate, and our founder is a Semrush Ambassador. Any other paid relationship is stated next to the link and on our FTC and Affiliate Disclosure page.'],
        ],
    ];
    if ($view === 'tools') return []; /* D-193: the page carries the source post's own FAQs */
    return isset($f[$view]) ? $f[$view] : [];
}

/* D-193 (Jamil, 14 Oct, option B): /reviews/best-seo-ai-tools/ shows the text of the post "5 Best AI Content Writing Tools" (/ai-content-writing-tools/, post 358), read live so edits to the post show here too. The post keeps its own address and stays the canonical. Returns [html, toc] or null. */
function rl_reviews_tools_source() {
    static $out = false;
    if ($out !== false) return $out;
    $p = get_page_by_path('ai-content-writing-tools', OBJECT, 'post');
    if (!$p || $p->post_status !== 'publish') return $out = null;
    global $post; $keep = $post; $post = $p; setup_postdata($p);
    $html = apply_filters('the_content', $p->post_content);
    $post = $keep; if ($keep) setup_postdata($keep); else wp_reset_postdata();
    $html = preg_replace('#<h1\b([^>]*)>(.*?)</h1>#is', '', $html, 1); // the page has its own H1
    return $out = function_exists('rl_post_prepare') ? rl_post_prepare($html) : [$html, []];
}
function rl_reviews_tools_source_url() { $p = get_page_by_path('ai-content-writing-tools', OBJECT, 'post'); return $p && $p->post_status === 'publish' ? get_permalink($p) : ''; }
add_filter('wpseo_canonical', function ($c) { return rl_reviews_view() === 'tools' && ($src = rl_reviews_tools_source_url()) ? $src : $c; }, 20);

/* one card per post: the post's own image if it has one, else the brand panel */
function rl_reviews_card($row, $label = 'Read the review') {
    list($slug, $name, $kind, $line) = $row;
    $p = get_page_by_path($slug, OBJECT, 'post');
    if (!$p || $p->post_status !== 'publish') return '';
    $img = get_the_post_thumbnail_url($p, 'medium_large');
    $type = function_exists('rl_post_data') ? rl_post_data($p->ID)['type_label'] : '';
    ob_start(); ?>
<li><a class="rv" href="<?php echo esc_url(get_permalink($p)); ?>">
  <?php if ($img) { ?><span class="th" style="background-image:url(<?php echo esc_url($img); ?>)" aria-hidden="true"></span>
  <?php } else { ?><span class="th ph" aria-hidden="true"><b><?php echo esc_html($name); ?></b></span><?php } ?>
  <span class="bd">
    <span class="k"><?php echo esc_html($kind); ?></span>
    <h3><?php echo esc_html($name); ?></h3>
    <span class="ln"><?php echo esc_html($line); ?></span>
    <span class="mt"><?php echo esc_html(($type ? $type . ' · ' : '') . 'updated ' . get_the_modified_date('j M Y', $p)); ?></span>
    <span class="go"><?php echo esc_html($label); ?> &rarr;</span>
  </span>
</a></li>
<?php return ob_get_clean();
}

add_filter('body_class', function ($c) { if (rl_reviews_view()) $c[] = 'rl-reviews-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_reviews_view() !== ''; });

/* ---------- schema: CollectionPage with an ItemList of the linked posts; FAQPage ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    $v = rl_reviews_view();
    if (!is_array($graph) || !$v) return $graph;
    $url = get_permalink(get_queried_object_id());
    $d = rl_reviews_data();
    if ($v === 'hub') $rows = array_merge($d['hosting'], $d['hosting_lists'], array_merge(...array_values($d['tools'])));
    elseif ($v === 'hosting') $rows = array_merge($d['hosting'], $d['hosting_lists']);
    else $rows = array_merge(...array_values($d['tools']));
    $items = []; $i = 0;
    foreach ($rows as $r) { $p = get_page_by_path($r[0], OBJECT, 'post'); if ($p && $p->post_status === 'publish') $items[] = ['@type' => 'ListItem', 'position' => ++$i, 'url' => get_permalink($p), 'name' => $r[1]]; }
    foreach ($graph as &$n) {
        if (is_array($n) && !empty($n['@type']) && in_array('WebPage', (array) $n['@type'], true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) {
            $n['@type'] = ['WebPage', 'CollectionPage'];
            $n['mainEntity'] = ['@id' => $url . '#list'];
            $n['publisher'] = ['@id' => home_url('/#organization')];
        }
    }
    unset($n);
    $graph[] = ['@type' => 'ItemList', '@id' => $url . '#list', 'numberOfItems' => count($items), 'itemListElement' => $items];
    $faqs = rl_reviews_faqs($v);
    if ($faqs) $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, $faqs)];
    return $graph;
}, 20);

add_action('wp_head', function () {
    if (!rl_reviews_view()) return; ?>
<style id="rl-reviews-css">
body.rl-reviews-page .fl-page-content,body.rl-reviews-page .fl-content,body.rl-reviews-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-reviews .rv-grid{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:clamp(14px,1.6vw,20px)}
.rl-reviews .rv-grid li{margin:0;display:flex}
.rl-reviews .rv{display:flex;flex-direction:column;width:100%;border:1px solid var(--line-2);background:var(--bg-2);color:var(--ink);text-decoration:none;transition:border-color .2s}
.rl-reviews .rv:hover{border-color:var(--red-line)}
.rl-reviews .rv .th{display:block;aspect-ratio:16/9;background-size:cover;background-position:center;background-color:#0f0c0d;border-bottom:1px solid var(--line-2)}
.rl-reviews .rv .th.ph{display:flex;align-items:flex-end;padding:20px;background:radial-gradient(80% 90% at 85% 10%,rgba(153,0,0,.28),transparent 60%),linear-gradient(180deg,var(--panel),var(--bg-2));position:relative}
.rl-reviews .rv .th.ph::before{content:"";position:absolute;left:20px;top:20px;width:40px;height:2px;background:var(--red-2)}
.rl-reviews .rv .th.ph b{font-family:var(--f-display);text-transform:uppercase;font-weight:600;font-size:clamp(22px,2.2vw,28px);line-height:1.05}
.rl-reviews .rv .bd{display:flex;flex-direction:column;gap:8px;padding:20px 22px 22px;flex:1}
.rl-reviews .rv .k{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-reviews .rv h3{margin:0;font-size:20px;line-height:1.15}
.rl-reviews .rv .ln{color:var(--ink-dim);font-size:16px;line-height:1.5}
.rl-reviews .rv .mt{font-family:var(--f-mono);font-size:12px;letter-spacing:.06em;color:var(--ink-faint)}
.rl-reviews .rv .go{margin-top:auto;padding-top:6px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.05em;font-size:14px}
.rl-reviews .rv:hover .go{color:var(--red-3)}
.rl-reviews .grp{font-family:var(--f-display);font-weight:600;text-transform:uppercase;letter-spacing:.03em;font-size:clamp(20px,2.2vw,26px);margin:clamp(34px,4vw,48px) 0 18px}
.rl-reviews .grp:first-of-type{margin-top:0}
.rl-reviews .pill{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:clamp(14px,1.6vw,20px)}
.rl-reviews .pill a{position:relative;display:flex;flex-direction:column;gap:10px;padding:clamp(24px,3vw,34px);border:1px solid var(--red-line);background:linear-gradient(120deg,rgba(153,0,0,.12),transparent 60%),var(--panel);color:var(--ink);text-decoration:none;transition:background .2s}
.rl-reviews .pill a:hover{background:linear-gradient(120deg,rgba(153,0,0,.22),transparent 65%),var(--panel)}
.rl-reviews .pill .n{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;color:var(--red-3);text-transform:uppercase}
.rl-reviews .pill h2{margin:0;font-size:clamp(24px,2.8vw,32px)}
.rl-reviews .pill p{margin:0;color:var(--ink-dim);font-size:16px}
.rl-reviews .pill .go{margin-top:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.05em;font-size:15px}
.rl-reviews .note{margin-top:18px;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.04em}
.rl-reviews .note a{color:var(--ink-dim);border-bottom:1px solid var(--line-2)}
.rl-reviews .rv-art-wrap{display:grid;grid-template-columns:260px minmax(0,1fr);gap:clamp(28px,4vw,56px);align-items:start}
.rl-reviews .rv-toc{position:sticky;top:96px;border:1px solid var(--line-2);background:var(--bg-2);padding:18px 20px}
.rl-reviews .rv-toc .cap{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 10px}
.rl-reviews .rv-toc ol{margin:0;padding:0 0 0 18px;display:grid;gap:8px;color:var(--ink-faint);font-size:14px}
.rl-reviews .rv-toc a{color:var(--ink-dim);text-decoration:none}.rl-reviews .rv-toc a:hover{color:var(--red-3)}
.rl-reviews .rv-art{max-width:780px;color:var(--ink-dim);font-size:17px;line-height:1.7}
.rl-reviews .rv-art>*+*{margin-top:18px}
.rl-reviews .rv-art h2{font-size:clamp(24px,2.8vw,32px);color:var(--ink);margin-top:44px;scroll-margin-top:100px}
.rl-reviews .rv-art h3{font-size:20px;color:var(--ink);margin-top:28px;scroll-margin-top:100px}
.rl-reviews .rv-art h4{font-family:var(--f-display);text-transform:uppercase;font-size:17px;color:var(--ink);margin-top:22px}
.rl-reviews .rv-art p{margin:0}.rl-reviews .rv-art p+p{margin-top:16px}
.rl-reviews .rv-art ul,.rl-reviews .rv-art ol{padding-left:22px}.rl-reviews .rv-art li+li{margin-top:6px}
.rl-reviews .rv-art a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}.rl-reviews .rv-art a:hover{color:var(--red-3)}
.rl-reviews .rv-art img{max-width:100%;height:auto;display:block;border:1px solid var(--line-2)}
.rl-reviews .rv-art figure{margin:24px 0;max-width:100%}
.rl-reviews .rv-art table{width:100%;border-collapse:collapse;font-size:15px}.rl-reviews .rv-art th,.rl-reviews .rv-art td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}.rl-reviews .rv-art th{color:var(--ink)}
.rl-reviews .rv-art .wp-caption{max-width:100%!important}
@media(max-width:1000px){.rl-reviews .rv-art-wrap{grid-template-columns:minmax(0,1fr)}.rl-reviews .rv-toc{position:static}}
@media(max-width:1000px){.rl-reviews .rv-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:760px){.rl-reviews .pill{grid-template-columns:minmax(0,1fr)}}
@media(max-width:600px){.rl-reviews .rv-grid{grid-template-columns:minmax(0,1fr)}}
</style>
<?php }, 22);

add_shortcode('reinforce_reviews', function ($atts) {
    $v = rl_reviews_view();
    if (!$v) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $d = rl_reviews_data();
    $hub = $u('reviews'); $host = $u('reviews/best-wordpress-hosting'); $tools = $u('reviews/best-seo-ai-tools');
    $wpe = get_page_by_path('agency-partner-program-wp-engine-landing');
    $nTools = count(array_merge(...array_values($d['tools'])));
    $nHost = count($d['hosting']) + count($d['hosting_lists']) + ($wpe ? 1 : 0);
    $wpeCard = function () use ($wpe) {
        if (!$wpe || $wpe->post_status !== 'publish') return '';
        return '<li><a class="rv" href="' . esc_url(get_permalink($wpe)) . '"><span class="th ph" aria-hidden="true"><b>WP Engine</b></span><span class="bd"><span class="k">Managed WordPress hosting</span><h3>WP Engine</h3><span class="ln">We are a WP Engine agency partner. What the hosting does, and what we do around it.</span><span class="mt">Partner page</span><span class="go">See the partner page &rarr;</span></span></a></li>';
    };
    ob_start(); ?>
<div class="rl-page rl-reviews">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <?php if ($v === 'hub') { ?><li><span aria-current="page">Reviews</span></li>
  <?php } else { ?><li><a href="<?php echo $hub; ?>">Reviews</a></li><li><span aria-current="page"><?php echo $v === 'hosting' ? 'WordPress hosting' : 'SEO and AI tools'; ?></span></li><?php } ?>
</ol></nav>

<?php if ($v === 'hub') { ?>
<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;Reviews&nbsp;<b>]</b></span>
    <h1 class="h1">Reviews of WordPress hosting<br><span class="r">and SEO tools.</span></h1>
    <p class="lede">Our guides and reviews of the WordPress hosts, SEO tools and AI writing tools that come up in client work. We are rewriting each one first-hand; a rewritten review says when we used the product, what we tested and whether we paid for it.</p>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="pill">
      <a href="<?php echo $host; ?>"><span class="n"><?php echo (int) $nHost; ?> guides</span><h2>WordPress hosting</h2><p>Setup guides for nine hosts, two comparison lists and our WP Engine partner page, with how to choose a host.</p><span class="go">See WordPress hosting &rarr;</span></a>
      <a href="<?php echo $tools; ?>"><span class="n"><?php echo (int) $nTools; ?> reviews</span><h2>SEO and AI tools</h2><p>Reviews of SEO tools, AI writing tools, project management and the page builder we use, with how to choose.</p><span class="go">See SEO and AI tools &rarr;</span></a>
    </div>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How we review&nbsp;<b>]</b></span><h2>What you can expect from a review here.</h2></div>
    <ul class="ticks">
      <li><b>First-hand.</b> We review products we have used or tested for clients, and say when.</li>
      <li><b>Paid or free, stated.</b> Each rewritten review says whether we paid for our own access or the vendor gave it to us.</li>
      <li><b>Affiliate links marked.</b> Links that can earn us a commission carry an Ad label and <code>rel="sponsored"</code>.</li>
      <li><b>No paid placement.</b> We do not accept payment for reviews or rankings, and vendors do not see a review before it is published.</li>
      <li><b>Cheaper when it fits.</b> When a cheaper or free option suits you better, we say so, even if it earns us nothing.</li>
      <li><b>Questions welcome.</b> If a label is missing or a fact is out of date, email <a class="inl" href="mailto:hello@reinforcelab.com">hello@reinforcelab.com</a>.</li>
    </ul>
    <p class="note">Full policy: <a href="<?php echo $u('ftc-disclosure'); ?>">FTC and Affiliate Disclosure</a>.</p>
  </div>
</section>

<section id="all">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Everything&nbsp;<b>]</b></span><h2>All reviews and guides.</h2></div>
    <h3 class="grp">WordPress hosting</h3>
    <ul class="rv-grid"><?php echo $wpeCard(); foreach (array_merge($d['hosting'], $d['hosting_lists']) as $r) echo rl_reviews_card($r, 'Read the guide'); ?></ul>
    <?php foreach ($d['tools'] as $g => $rows) { ?>
    <h3 class="grp"><?php echo esc_html($g); ?></h3>
    <ul class="rv-grid"><?php foreach ($rows as $r) echo rl_reviews_card($r); ?></ul>
    <?php } ?>
  </div>
</section>

<?php } elseif ($v === 'hosting') { ?>
<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;Reviews · WordPress hosting&nbsp;<b>]</b></span>
    <h1 class="h1">WordPress hosting:<br><span class="r">guides and how to choose.</span></h1>
    <p class="lede">Step-by-step setup guides for nine hosts, two comparison lists, and our WP Engine partner page. Hosts change their plans and prices often, so check the host's own site before you buy.</p>
  </div>
</section>

<section class="band alt" id="choose">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;How to choose&nbsp;<b>]</b></span><h2>What matters when you choose a WordPress host?</h2><p class="lede">Six questions that settle most choices.</p></div>
    <ul class="ticks">
      <li><b>Shared or managed?</b> Shared hosting is cheaper and leaves more work to you. Managed WordPress hosting handles caching, backups, updates and WordPress support.</li>
      <li><b>Where are your visitors?</b> Pick a data centre near them, or a host with a content delivery network.</li>
      <li><b>Backups and staging.</b> Daily backups you can restore yourself, and a staging copy to test changes before they go live.</li>
      <li><b>Support that knows WordPress.</b> Ask how fast support answers and whether it can fix WordPress problems, not only server ones.</li>
      <li><b>The renewal price.</b> First-year prices are often much lower than the price you pay after. Compare the renewal price.</li>
      <li><b>Moving in and out.</b> Check whether the host moves your site for you, and how easy it is to leave.</li>
    </ul>
  </div>
</section>

<section id="hosts">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The guides&nbsp;<b>]</b></span><h2>WordPress hosts we have written about.</h2></div>
    <ul class="rv-grid"><?php echo $wpeCard(); foreach ($d['hosting'] as $r) echo rl_reviews_card($r, 'Read the guide'); ?></ul>
    <h3 class="grp">Comparison lists</h3>
    <ul class="rv-grid"><?php foreach ($d['hosting_lists'] as $r) echo rl_reviews_card($r, 'Read the list'); ?></ul>
    <p class="note">The guides are being rewritten one at a time. Some links in them may earn us a commission, each marked Ad. <a href="<?php echo $u('ftc-disclosure'); ?>">How we handle affiliate links</a>.</p>
  </div>
</section>

<?php } else { $src = rl_reviews_tools_source(); ?>
<?php if ($src) { /* D-193: Jamil's "5 Best AI Content Writing Tools" text (post 358), rendered live from the post */
    [$art, $toc] = $src; ?>
<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;Reviews · SEO and AI tools&nbsp;<b>]</b></span>
    <h1 class="h1">The 5 best AI<br><span class="r">content writing tools.</span></h1>
    <p class="lede">Writesonic, Jasper, Rytr, Copy AI and Anyword compared, with the pros and cons of each. Then every SEO and AI tool review on the site.</p>
  </div>
</section>

<section class="band alt" id="list">
  <div class="wrap rv-art-wrap">
    <?php if (count($toc) > 2) { ?><nav class="rv-toc" aria-label="Contents"><p class="cap">Contents</p><ol><?php foreach ($toc as $t) echo '<li><a href="#' . esc_attr($t[0]) . '">' . esc_html($t[1]) . '</a></li>'; ?></ol></nav><?php } ?>
    <article class="rv-art"><?php echo $art; ?></article>
  </div>
</section>
<?php } else { ?>
<section class="hero">
  <div class="wrap">
    <span class="ey"><b>[</b>&nbsp;Reviews · SEO and AI tools&nbsp;<b>]</b></span>
    <h1 class="h1">SEO and AI tools:<br><span class="r">reviews.</span></h1>
  </div>
</section>
<?php } ?>

<section id="tools">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;All tool reviews&nbsp;<b>]</b></span><h2>More SEO and AI tool reviews.</h2></div>
    <?php foreach ($d['tools'] as $g => $rows) { ?>
    <h3 class="grp"><?php echo esc_html($g); ?></h3>
    <ul class="rv-grid"><?php foreach ($rows as $r) echo rl_reviews_card($r); ?></ul>
    <?php } ?>
    <p class="note">The reviews are being rewritten one at a time. We are a Semrush agency partner and affiliate; links that can earn us a commission are marked Ad. <a href="<?php echo $u('ftc-disclosure'); ?>">How we handle affiliate links</a>.</p>
  </div>
</section>
<?php } ?>

<?php if ($v !== 'tools') { ?>
<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2><?php echo $v === 'hub' ? 'About our reviews.' : ($v === 'hosting' ? 'About WordPress hosting.' : 'About SEO and AI tools.'); ?></h2></div>
    <?php foreach (rl_reviews_faqs($v) as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>
<?php } ?>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Need a second opinion?&nbsp;<b>]</b></span>
      <h2><?php echo $v === 'tools' ? 'Not sure which tool you need?' : ($v === 'hosting' ? 'Not sure which host fits your site?' : 'Choosing a host or a tool?'); ?></h2>
      <p class="lede">Tell us what your site and team need, and we will tell you what fits, including when a cheaper option is enough.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $u('contact-us'); ?>">Ask us <span class="ar">&rarr;</span></a>
        <?php if ($v !== 'hub') { ?><a class="btn g" href="<?php echo $hub; ?>">All reviews</a><?php } else { ?><a class="btn g" href="<?php echo $u('blog'); ?>">Read the blog</a><?php } ?>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
});
