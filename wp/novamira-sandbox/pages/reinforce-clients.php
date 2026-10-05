<?php
/**
 * Plugin Name: Reinforce Lab - Clients
 * Description: /clients/ (production URL kept, D-127). Provides [reinforce_clients]. The 46 client logos shown on reinforcelab.com/clients/, imported into the media library (attachments listed in option rl_client_logos; sources in claude/data/client-logos-2026-10.csv). Jamil confirmed all are real clients and may be shown (5 Oct 2026). Uses the shared kit (D-044). Schema: CollectionPage with an ItemList of Organization, FAQPage.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_clients() { return is_page('clients') && (int) wp_get_post_parent_id(get_queried_object_id()) === 0; }

/* name => slug (the key in option rl_client_logos), in production's order */
function rl_clients_list() {
    return [
        'Accesstel' => 'accesstel', 'Bikroy.com' => 'bikroy-com', 'United International University' => 'united-international-university',
        'IBA Alumni Association' => 'iba-alumni-association', 'Faculty of Business Studies, University of Dhaka' => 'faculty-of-business-studies-university-of-dhaka',
        'Union Properties' => 'union-properties', 'HP' => 'hp', 'INPACE' => 'inpace', 'JA Directives' => 'ja-directives', 'AccessTUTOR' => 'accesstutor',
        'NZ Group' => 'nz-group', 'Beacon Pharmaceuticals' => 'beacon-pharmaceuticals', 'Paperleaf' => 'paperleaf', 'Eco Fast Fashion' => 'eco-fast-fashion',
        'TNT Global Sourcing' => 'tnt-global-sourcing', 'Dipto Health' => 'dipto-health', 'MRCO International' => 'mrco-international',
        'Microinspire' => 'microinspire', 'Thakral Information Systems' => 'thakral-information-systems', 'Pro Tennis Academy Dhaka' => 'pro-tennis-academy-dhaka',
        'Car Finder 360' => 'car-finder-360', 'We Connect' => 'we-connect', 'Mint Bangladesh' => 'mint-bangladesh', 'Sofosvel' => 'sofosvel',
        '3 Wheeler Library' => '3-wheeler-library', 'Crizonix' => 'crizonix', 'Socially Thrive' => 'socially-thrive', 'The Pharma Mag' => 'the-pharma-mag',
        'Digital Learning Land' => 'digital-learning-land', 'Inpace Shop' => 'inpace-shop', 'Advocate Gazi and Associates' => 'advocate-gazi-and-associates',
        'Arroz' => 'arroz', 'Strategic Overdrive' => 'strategic-overdrive', 'MAX Cleaning Services' => 'max-cleaning-services', 'Martinet Goal' => 'martinet-goal',
        'Panorama Property Management' => 'panorama-property-management', 'Mobilelink' => 'mobilelink', 'Pulse Management and HR Consulting' => 'pulse-management-and-hr-consulting',
        'Professional Cooking Academy' => 'professional-cooking-academy', 'Signature Jeans' => 'signature-jeans', 'N.K. Multi Trading' => 'n-k-multi-trading',
        'Mixed Global Series' => 'mixed-global-series', 'Creative Icon Interior' => 'creative-icon-interior', 'BTF Tennis' => 'btf-tennis',
        'THZ Bangladesh' => 'thz-bangladesh', 'Smile Food Corner' => 'smile-food-corner',
    ];
}
/* clients with a project page under /portfolio/ */
function rl_clients_projects() { return ['AccessTUTOR' => 'access-tutor', 'IBA Alumni Association' => 'iba-alumni-lottery', 'Inpace Shop' => 'inpace-shop', 'INPACE' => 'inpace-shop']; }

function rl_clients_faqs() {
    return [
        ['Who are Reinforce Lab\'s clients?', 'Reinforce Lab has worked with ' . count(rl_clients_list()) . ' organisations, including United International University, the Faculty of Business Studies at the University of Dhaka, Beacon Pharmaceuticals, Bikroy.com, HP, Accesstel and Union Properties, as well as online stores, property firms, academies and professional services.'],
        ['Which industries do these clients work in?', 'Education, pharmaceuticals and health, e-commerce and retail, technology and telecoms, property, fashion, food, sport and professional services.'],
        ['Can I speak to one of your clients?', 'Yes. Ask us and we will put you in touch with a client who has agreed to take calls.'],
        ['Where can I see the work?', 'Our Portfolio shows the projects in detail, with what each client needed and what we built.'],
    ];
}

add_filter('body_class', function ($c) { if (rl_is_clients()) $c[] = 'rl-clients-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_clients(); });

/* ---------- schema ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_clients()) return $graph;
    $url = get_permalink(get_queried_object_id());
    $map = (array) get_option('rl_client_logos', []);
    foreach ($graph as &$n) {
        if (!is_array($n) || empty($n['@type'])) continue;
        if (in_array('WebPage', (array) $n['@type'], true) && isset($n['@id']) && strpos($n['@id'], $url) === 0) {
            $n['@type'] = ['WebPage', 'CollectionPage'];
            $n['about'] = ['@id' => home_url('/#organization')];
            $n['mainEntity'] = ['@id' => $url . '#clients'];
        }
    }
    unset($n);
    $items = []; $i = 0;
    foreach (rl_clients_list() as $name => $slug) {
        $o = ['@type' => 'Organization', 'name' => $name];
        if (!empty($map[$slug]) && ($src = wp_get_attachment_url($map[$slug]))) $o['logo'] = $src;
        $items[] = ['@type' => 'ListItem', 'position' => ++$i, 'item' => $o];
    }
    $graph[] = ['@type' => 'ItemList', '@id' => $url . '#clients', 'name' => 'Clients of Reinforce Lab', 'numberOfItems' => count($items), 'itemListElement' => $items];
    $graph[] = ['@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url], 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_clients_faqs())];
    return $graph;
}, 20);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_clients()) return; ?>
<style id="rl-clients-css">
body.rl-clients-page .fl-page-content,body.rl-clients-page .fl-content,body.rl-clients-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-clients .hero-grid{align-items:stretch}
.rl-clients .c-panel{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));display:flex;flex-direction:column;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-clients .c-tally{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1px;background:var(--line-2);border-bottom:1px solid var(--line-2);margin:0}
.rl-clients .c-tally div{background:var(--bg-2);padding:20px 22px;margin:0}
.rl-clients .c-tally dt{font-family:var(--f-display);font-size:44px;line-height:1;color:var(--ink);font-weight:500;margin:0}
.rl-clients .c-tally dd{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin:6px 0 0}
.rl-clients .c-peek{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:var(--line-2);flex:1}
.rl-clients .c-peek span{background:#f4f0eb;display:grid;place-items:center;padding:12px;min-height:72px}
.rl-clients .c-peek img{max-width:100%;max-height:44px;width:auto;height:auto;object-fit:contain}
.rl-clients .c-wall{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2);margin:0;padding:0;list-style:none}
.rl-clients .c-wall li{background:var(--bg-2);display:grid;grid-template-rows:auto auto;margin:0}
.rl-clients .c-logo{background:#f4f0eb;display:grid;place-items:center;height:104px;padding:14px 16px}
.rl-clients .c-logo img{max-width:100%;max-height:68px;width:auto;height:auto;object-fit:contain}
.rl-clients .c-name{font-family:var(--f-mono);font-size:11px;line-height:1.35;color:var(--ink-dim);padding:9px 12px;min-height:44px;display:flex;align-items:center;justify-content:space-between;gap:6px}
.rl-clients .c-name a{color:var(--red-3);text-decoration:none;white-space:nowrap}
.rl-clients .c-note{margin:14px 0 0;font-size:14.5px;color:var(--ink-faint)}
.rl-clients .c-work{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}
.rl-clients .c-work a{border:1px solid var(--line-2);background:var(--bg-2);padding:18px 20px;display:grid;gap:8px;text-decoration:none;color:var(--ink)}
.rl-clients .c-work a:hover{border-color:var(--red-line)}
.rl-clients .c-work b{font-family:var(--f-display);font-weight:500;font-size:19px;text-transform:uppercase;letter-spacing:.02em}
.rl-clients .c-work span{font-size:14.5px;color:var(--ink-dim)}
.rl-clients .c-work em{font-style:normal;font-family:var(--f-mono);font-size:11.5px;color:var(--red-3)}
@media(max-width:1100px){.rl-clients .c-wall{grid-template-columns:repeat(4,minmax(0,1fr))}.rl-clients .c-work{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:760px){.rl-clients .c-wall{grid-template-columns:repeat(2,minmax(0,1fr))}.rl-clients .c-logo{height:88px}.rl-clients .c-work{grid-template-columns:1fr}}
</style>
<?php }, 22);

/* ---------- markup ---------- */
add_shortcode('reinforce_clients', 'rl_render_clients');
function rl_render_clients() {
    if (!rl_is_clients()) return '';
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $map = (array) get_option('rl_client_logos', []);
    $list = rl_clients_list();
    $proj = rl_clients_projects();
    $logo = function ($name, $slug, $lazy = true) use ($map) {
        if (empty($map[$slug])) return '';
        return wp_get_attachment_image((int) $map[$slug], 'full', false, ['alt' => $name . ' logo', 'loading' => $lazy ? 'lazy' : 'eager', 'decoding' => 'async']);
    };
    $purl = function ($slug) { $p = get_page_by_path($slug, OBJECT, 'rl_project'); return ($p && $p->post_status === 'publish') ? get_permalink($p) : ''; };
    $peek = ['United International University', 'Beacon Pharmaceuticals', 'Bikroy.com', 'HP', 'Accesstel', 'Union Properties'];
    ob_start(); ?>
<div class="rl-page rl-clients">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Clients</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Clients&nbsp;<b>]</b></span>
      <h1 class="h1">The businesses<br>we have <span class="r">worked<br>with.</span></h1>
      <p class="lede"><strong>Reinforce Lab has worked with <?php echo count($list); ?> organisations</strong>, from universities and pharmaceutical companies to online stores, property firms, academies and professional services. Below is every client we can name, with links to the projects we describe in our portfolio.</p>
      <div class="cta-row">
        <a class="btn p" href="#clients">See the clients <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('portfolio'); ?>">See the portfolio</a>
      </div>
    </div>
    <aside class="c-panel" aria-label="Clients at a glance">
      <dl class="c-tally">
        <div><dt><?php echo count($list); ?></dt><dd>Clients named</dd></div>
        <div><dt>2021</dt><dd>Working with clients since</dd></div>
      </dl>
      <div class="c-peek"><?php foreach ($peek as $n) echo '<span>' . $logo($n, $list[$n], false) . '</span>'; ?></div>
    </aside>
  </div>
</section>

<section id="clients">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Clients&nbsp;<b>]</b></span><h2>Who has Reinforce Lab worked with?</h2></div>
    <ul class="c-wall">
    <?php foreach ($list as $name => $slug) {
        $link = isset($proj[$name]) ? $purl($proj[$name]) : '';
        echo '<li><span class="c-logo">' . $logo($name, $slug) . '</span><span class="c-name">' . esc_html($name) . ($link ? '<a href="' . esc_url($link) . '">Project &rarr;</a>' : '') . '</span></li>';
    } ?>
    </ul>
    <p class="c-note">Logos are the property of their owners and are shown with the clients' permission.</p>
  </div>
</section>

<section class="band alt" id="work">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;The work&nbsp;<b>]</b></span><h2>Read about the projects</h2></div>
    <div class="c-work">
      <?php foreach (['inpace-shop' => ['Inpace Shop', 'A WooCommerce store for cameras and computer accessories.'], 'access-tutor' => ['AccessTUTOR', 'An online tutoring platform for exam students.'], 'iba-alumni-lottery' => ['IBA Alumni Lottery', 'A reunion website with an alumni database and a fair prize draw.']] as $s => $w) { $l = $purl($s); if ($l) echo '<a href="' . esc_url($l) . '"><b>' . esc_html($w[0]) . '</b><span>' . esc_html($w[1]) . '</span><em>Read the project &rarr;</em></a>'; } ?>
      <a href="<?php echo $u('portfolio'); ?>"><b>All projects</b><span>Stores, web applications and websites we have built.</span><em>Portfolio &rarr;</em></a>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About our clients.</h2></div>
    <?php foreach (rl_clients_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section class="band alt" id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See what we would fix first on your site.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility, content and AI-search presence, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get My Search Authority Diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('contact-us'); ?>">Contact us</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
