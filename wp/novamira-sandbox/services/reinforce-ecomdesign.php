<?php
/**
 * Plugin Name: Reinforce Lab - E-commerce Website Design
 * Description: /services/ecommerce-website-design-service/ (production URL kept, D-023; no measurable search equity) - E-commerce Website Design service page. Provides [reinforce_ecomdesign]. Uses the shared kit (D-044). Hero animation "Found to ordered" (D-039 Step 3).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_ecd() { return is_page('ecommerce-website-design-service'); }

/* ---------- single source: FAQ (markup + FAQPage schema) ---------- */
function rl_ecd_faqs() {
    return [
        ['What do e-commerce website design services include?', 'E-commerce website design plans, designs and builds an online store: category and navigation structure, product pages, search and filters, cart and checkout, payments, shipping and tax, integrations with stock, ERP and email systems, product structured data, speed, accessibility and analytics, then launch and support.'],
        ['Which platform should we use?', 'For most businesses already on WordPress, WooCommerce keeps your store, content and SEO in one place and avoids platform lock-in. If a hosted platform fits your catalogue, team or budget better, we will say so before any design work starts.'],
        ['Why do shoppers abandon their carts?', 'Baymard Institute puts the average documented cart abandonment rate at 70.22%. Leaving aside people who were just browsing, the top reasons are extra costs such as shipping, tax and fees (40%), slow delivery (20%), not trusting the site with card details (19%), being forced to create an account (18%) and a long or complicated checkout (17%). Most of these can be fixed through design.'],
        ['How do our products show up in Google?', 'Google can show price, availability, ratings, shipping and returns directly in results when product pages carry product structured data (merchant listings markup for pages where people can buy) and when product data is shared through Google Merchant Center feeds. We set up both, and keep filter pages from wasting Google’s crawl.'],
        ['Does our store have to be accessible?', 'If you sell to consumers in the EU, the European Accessibility Act covers e-commerce services and has applied since 28 June 2025. We design and test to WCAG 2.2 level AA. This is not legal advice.'],
        ['How much does an online store cost?', 'It depends on the size of the catalogue, the number of templates, integrations such as ERP, stock and shipping, and whether products are being migrated from another platform. After a discovery call you get a written scope and quote.'],
    ];
}

/* industries: the 8 locked verticals (D-022), each with e-commerce points (D-047) */
function rl_ecd_industries() {
    return [
        ['pharmaceutical', 'Pharmaceutical & Life Sciences', ['Lab supplies and consumables stores for professional buyers', 'Account-based pricing and approval workflows', 'Regulated product information kept accurate']],
        ['healthcare', 'Healthcare', ['Clinic and wellness product stores', 'Clear product information and safe checkout', 'Accessibility for every customer']],
        ['b2b-saas', 'B2B SaaS', ['Self-serve plans, add-ons and upgrades', 'Checkout connected to billing and CRM', 'Pricing pages that convert without a sales call']],
        ['ecommerce', 'E-commerce', ['Category and product templates that rank', 'Faster, shorter checkout', 'Merchant listings and Merchant Center feeds']],
        ['manufacturing', 'Manufacturing', ['B2B ordering with customer-specific pricing', 'Spare parts catalogues with search and filters', 'Stores connected to ERP and stock levels']],
        ['technology', 'Technology', ['Hardware, licences and accessories in one store', 'Product comparisons and specifications', 'Integrations with fulfilment and support']],
        ['professional-services', 'Professional Services', ['Bookable packages and fixed-price services', 'Online payment for courses and resources', 'Invoicing and account integration']],
        ['education', 'Education', ['Course, event and resource stores', 'Student and institution checkout options', 'Accessible design for every learner']],
    ];
}

/* ---------- hero animation: Found to ordered ----------
   A product appears in search with price, stock and rating; the shopper browses the product grid and
   picks one; the checkout drops the fields it doesn't need, shows the total up front and offers guest
   checkout; the order is placed; found · browse · checkout · order light in turn. 10 s loop, soft
   fade, reset. */
function rl_ec_svg() {
    $s = '<svg viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="rlEcT"><title id="rlEcT">A shopper finds a product in search with price, stock and rating, browses the store, and completes a short checkout with the total shown up front and guest checkout available.</title>';
    $s .= '<text class="c-lab" x="0" y="12">IN SEARCH</text>';
    $s .= '<rect class="c-b" x="0" y="20" width="240" height="62"/><rect class="c-on c-rr" x="0" y="20" width="240" height="62"/><rect class="c-img" x="10" y="30" width="42" height="42"/>'
        . '<rect class="c-bar" x="62" y="32" width="140" height="6"/><text class="c-rt" x="62" y="54">$49 · IN STOCK</text><g class="c-stars">';
    for ($i = 0; $i < 5; $i++) $s .= '<rect class="c-star' . ($i < 4 ? ' c-sf' : '') . '" x="' . (62 + $i * 11) . '" y="62" width="8" height="8"/>';
    $s .= '</g>';
    $s .= '<text class="c-lab" x="0" y="106">THE STORE</text>';
    foreach ([[0, 114], [124, 114], [0, 200], [124, 200]] as $i => $p) {
        $s .= '<rect class="c-b c-tile c-t' . $i . '" x="' . $p[0] . '" y="' . $p[1] . '" width="116" height="78"/><rect class="c-img" x="' . ($p[0] + 10) . '" y="' . ($p[1] + 10) . '" width="96" height="36"/><rect class="c-bar" x="' . ($p[0] + 10) . '" y="' . ($p[1] + 54) . '" width="70" height="5"/><rect class="c-bar" x="' . ($p[0] + 10) . '" y="' . ($p[1] + 64) . '" width="40" height="5"/>';
    }
    $s .= '<rect class="c-pick" x="124" y="114" width="116" height="78"/>';
    $s .= '<path class="c-e" d="M240 153 H280"/><path class="c-p" pathLength="100" d="M240 153 H280"/>';
    $s .= '<text class="c-lab" x="280" y="12">CHECKOUT</text><rect class="c-b" x="280" y="20" width="240" height="258"/>';
    for ($i = 0; $i < 8; $i++) $s .= '<rect class="c-f' . ($i >= 4 ? ' c-drop c-d' . ($i - 4) : '') . '" x="294" y="' . (34 + $i * 18) . '" width="' . [212, 150, 212, 100, 180, 130, 212, 90][$i] . '" height="10"/>';
    $s .= '<text class="c-note" x="506" y="120" text-anchor="end">FEWER FIELDS</text>';
    foreach (['TOTAL SHOWN UP FRONT', 'GUEST CHECKOUT', 'PAYMENT OPTIONS'] as $i => $t) {
        $y = 192 + $i * 20;
        $s .= '<rect class="c-sq" x="294" y="' . ($y - 8) . '" width="9" height="9"/><rect class="c-sqon c-k' . $i . '" x="294" y="' . ($y - 8) . '" width="9" height="9"/><text class="c-ct" x="310" y="' . $y . '">' . $t . '</text>';
    }
    $s .= '<rect class="c-btn" x="294" y="250" width="212" height="24"/><rect class="c-btnon" x="294" y="250" width="212" height="24"/><text class="c-bt" x="400" y="265.5" text-anchor="middle">PLACE ORDER</text><text class="c-bt c-okt" x="400" y="265.5" text-anchor="middle">ORDER PLACED</text>';
    $s .= '<line class="c-rule" x1="0" y1="352" x2="520" y2="352"/>';
    foreach (['FOUND', 'BROWSE', 'CHECKOUT', 'ORDER'] as $i => $f) {
        $x = $i * 136;
        $s .= '<text class="c-ft" x="' . $x . '" y="372">' . $f . '</text><text class="c-ft c-fton c-fx' . $i . '" x="' . $x . '" y="372">' . $f . '</text>'
            . '<rect class="c-fb" x="' . $x . '" y="382" width="112" height="3"/><rect class="c-fbon c-fbx' . $i . '" x="' . $x . '" y="382" width="112" height="3"/>';
    }
    return $s . '</svg>';
}
function rl_ec_kf() {
    $lit = function ($n, $s, $r) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,92%{opacity:1}97%,100%{opacity:0}}\n"; };
    $k = $lit('rlecRr', 2, 5);
    $k .= "@keyframes rlecPick{0%,20%{opacity:0}22%,92%{opacity:1}97%,100%{opacity:0}}\n";
    $k .= "@keyframes rlecP{0%,24%{stroke-dashoffset:10;opacity:0}25%{opacity:1}29%{opacity:1}30%,100%{stroke-dashoffset:-100;opacity:0}}\n";
    for ($i = 0; $i < 4; $i++) { $s = 34 + $i * 2; $k .= "@keyframes rlecD$i{0%,{$s}%{opacity:1;transform:scaleX(1)}" . ($s + 4) . "%,97%{opacity:0;transform:scaleX(.2)}100%{opacity:1;transform:scaleX(1)}}\n.rl-ec .c-d$i{animation-name:rlecD$i}\n"; }
    $k .= $lit('rlecNote', 36, 39);
    for ($i = 0; $i < 3; $i++) { $s = 46 + $i * 4; $k .= $lit("rlecK$i", $s, $s + 2) . ".rl-ec .c-k$i{animation-name:rlecK$i}\n"; }
    $k .= $lit('rlecOk', 62, 65) . "@keyframes rlecPo{0%,62%{opacity:1}65%,97%{opacity:0}100%{opacity:1}}\n";
    foreach ([2, 12, 34, 62] as $i => $s) $k .= $lit("rlecF$i", $s, $s + 3) . "@keyframes rlecFb$i{0%,{$s}%{transform:scaleX(0);opacity:1}" . ($s + 6) . "%,92%{transform:scaleX(1);opacity:1}97%,100%{transform:scaleX(1);opacity:0}}\n.rl-ec .c-fx$i{animation-name:rlecF$i}.rl-ec .c-fbx$i{animation-name:rlecFb$i}\n";
    for ($i = 0; $i < 4; $i++) { $s = 10 + $i * 2; $k .= $lit("rlecT$i", $s, $s + 2) . ".rl-ec .c-t$i{animation-name:rlecT$i}\n"; }
    return $k;
}

/* ---------- CSS (page-specific only; shared rules live in reinforce-kit.css, D-044) ---------- */
add_filter('body_class', function ($c) { if (rl_is_ecd()) $c[] = 'rl-ec-page'; return $c; });
add_filter('rl_kit_active', function ($on) { return $on || rl_is_ecd(); });
add_action('wp_head', 'rl_ecd_css', 22);
function rl_ecd_css() {
    if (!rl_is_ecd()) return; ?>
<style id="rl-ec-css">
body.rl-ec-page .fl-page-content,body.rl-ec-page .fl-content,body.rl-ec-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-ec .ecf{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 14px;box-shadow:0 30px 80px -50px var(--red-glow)}
.rl-ec .ecf .cap{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px}
.rl-ec .ecf .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-ec .ecf svg{display:block;width:100%;height:auto;overflow:visible}
.rl-ec .c-b{fill:var(--bg);stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ec .c-on{fill:rgba(153,0,0,.09);stroke:rgba(226,59,59,.65);stroke-width:.8;opacity:0}
.rl-ec .c-rr{animation-name:rlecRr}
.rl-ec .c-img{fill:rgba(255,255,255,.07)}
.rl-ec .c-bar{fill:rgba(243,237,230,.22)}
.rl-ec .c-rt{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--red-3)}
.rl-ec .c-star{fill:none;stroke:rgba(243,237,230,.4);stroke-width:.8}.rl-ec .c-sf{fill:var(--red-2);stroke:var(--red-3)}
.rl-ec .c-lab{font-family:var(--f-mono);font-size:8px;letter-spacing:.2em;fill:var(--ink-faint)}
.rl-ec .c-tile{opacity:0}
.rl-ec .c-pick{fill:none;stroke:#fff;stroke-width:1.2;opacity:0;animation-name:rlecPick}
.rl-ec .c-e{fill:none;stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-ec .c-p{fill:none;stroke:var(--red-3);stroke-width:1.3;stroke-linecap:round;stroke-dasharray:8 100;stroke-dashoffset:8;opacity:0;animation-name:rlecP;animation-timing-function:ease-in-out}
.rl-ec .c-f{fill:rgba(255,255,255,.07);stroke:rgba(243,237,230,.12);stroke-width:.6;transform-box:fill-box;transform-origin:0 50%}
.rl-ec .c-note{font-family:var(--f-mono);font-size:8px;letter-spacing:.16em;fill:var(--red-3);opacity:0;animation-name:rlecNote}
.rl-ec .c-sq{fill:none;stroke:rgba(243,237,230,.25);stroke-width:.8}
.rl-ec .c-sqon{fill:var(--red-2);opacity:0}
.rl-ec .c-ct{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-ec .c-btn{fill:rgba(255,255,255,.05);stroke:rgba(243,237,230,.2);stroke-width:.8}
.rl-ec .c-btnon{fill:var(--red-2);opacity:0;animation-name:rlecOk}
.rl-ec .c-bt{font-family:var(--f-mono);font-size:9px;letter-spacing:.16em;fill:var(--ink);animation-name:rlecPo}
.rl-ec .c-okt{fill:#fff;opacity:0;animation-name:rlecOk}
.rl-ec .c-rule{stroke:var(--line-2);stroke-width:1}
.rl-ec .c-ft{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-ec .c-fton{fill:var(--ink);opacity:0}
.rl-ec .c-fb{fill:rgba(255,255,255,.08)}
.rl-ec .c-fbon{fill:var(--red-2);transform-box:fill-box;transform-origin:0 50%;transform:scaleX(0)}
.rl-ec .c-on,.rl-ec .c-tile,.rl-ec .c-pick,.rl-ec .c-p,.rl-ec .c-drop,.rl-ec .c-note,.rl-ec .c-sqon,.rl-ec .c-btnon,.rl-ec .c-bt,.rl-ec .c-fton,.rl-ec .c-fbon{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
@media(max-width:560px){.rl-ec .c-ct,.rl-ec .c-rt{font-size:9.5px;letter-spacing:.02em}.rl-ec .c-lab,.rl-ec .c-note{font-size:9.5px;letter-spacing:.06em}.rl-ec .c-bt{font-size:10.5px;letter-spacing:.06em}.rl-ec .c-ft{font-size:11px;letter-spacing:.04em}.rl-ec .ecf .cap span+span{display:none}.rl-ec .ecf{padding:16px 10px 10px}}
<?php echo rl_ec_kf(); ?>
.rl-ec .quote{margin-top:22px;border-left:2px solid var(--red-2);padding:6px 0 6px 20px;font-size:17px;color:var(--ink);max-width:70ch}
.rl-ec .metric .num{display:block;font-family:var(--f-display);font-weight:600;font-size:46px;line-height:1;color:var(--red-3);margin-bottom:12px}
</style>
<?php }

/* ---------- schema: extend Yoast's graph ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_ecd() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $graph[] = [
        '@type' => 'Service', '@id' => $url . '#service', 'name' => 'E-commerce Website Design', 'alternateName' => ['E-commerce website design services', 'WooCommerce website design', 'Online store design'],
        'serviceType' => 'E-commerce website design and development', 'url' => $url, 'mainEntityOfPage' => ['@id' => $url],
        'description' => 'E-commerce website design and development: store structure, product pages, search and filters, a shorter checkout, payments and integrations, product structured data and Merchant Center feeds, speed and WCAG 2.2 AA accessibility.',
        'provider' => ['@id' => home_url('/#organization')], 'areaServed' => 'Worldwide',
    ];
    $graph[] = [
        '@type' => 'FAQPage', '@id' => $url . '#faq', 'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, rl_ecd_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_ecomdesign', 'rl_render_ecomdesign');
function rl_render_ecomdesign() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $ex = function ($path) { $l = function_exists('rl_url_by_path') ? rl_url_by_path($path, '') : ''; return $l ? esc_url($l) : ''; };
    $bay = esc_url('https://baymard.com/lists/cart-abandonment-rate');
    $gd = function ($p) { return esc_url('https://developers.google.com/search/docs/' . $p); };
    $eaa = esc_url('https://commission.europa.eu/strategy-and-policy/policies/justice-and-fundamental-rights/disability/union-equality-strategy-rights-persons-disabilities-2021-2030/european-accessibility-act_en');
    $diag = $u('search-authority-diagnostic');
    ob_start(); ?>
<div class="rl-page rl-ec">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo $u('services'); ?>">Services</a></li>
  <li><span aria-current="page">E-commerce Website Design</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;Services&nbsp;<b>/</b>&nbsp;E-commerce Website Design&nbsp;<b>]</b></span>
      <h1 class="h1">Online stores<br>built to be found<br><span class="r">and bought from.</span></h1>
      <p class="lede"><strong>E-commerce website design services</strong> from Reinforce Lab plan, design and build online stores that show up in Google with price, stock and ratings, make products easy to find, and get shoppers through checkout without friction. We build on WooCommerce by default, with product data, speed and accessibility built in from the start.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#checkout">Fix checkout</a>
      </div>
    </div>
    <figure class="ecf rl-anim">
      <div class="cap" aria-hidden="true"><span>Online store</span><span>Found · browse · checkout · order</span></div>
      <?php echo rl_ec_svg(); ?>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Found', 'kind' => 'rows', 'items' => ['In search · price and stock shown']], ['label' => 'Checkout', 'kind' => 'rows', 'items' => [['Fewer fields', 'ok'], ['Total shown up front', 'ok'], ['Guest checkout', 'ok'], ['Payment options', 'ok']]], ['label' => '', 'kind' => 'rows', 'items' => [['Order placed', 'hi']]]], 'Found · browse · checkout · order'); ?></figure>
  </div>
</section>

<section class="band alt" id="what">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;What's included&nbsp;<b>]</b></span><h2>What do our e-commerce website design services include?</h2><p class="lede">Everything a store needs to be found, browsed and bought from, designed around your catalogue and your customers.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">01 · Structure</span><h3>Categories &amp; navigation</h3><p>A catalogue structure that matches how customers shop and search.</p></div>
      <div class="cell"><span class="n">02 · Products</span><h3>Product pages</h3><p>Clear photos, specs, prices, stock, delivery and returns: the answers that close the sale.</p></div>
      <div class="cell"><span class="n">03 · Find</span><h3>Search &amp; filters</h3><p>On-site search and filters that help shoppers, without flooding Google with filter URLs.</p></div>
      <div class="cell"><span class="n">04 · Checkout</span><h3>Cart &amp; checkout</h3><p>Fewer fields, costs shown up front, guest checkout and the payment methods customers expect.</p></div>
      <div class="cell"><span class="n">05 · Google</span><h3>Product data for Google</h3><p>Merchant listings markup and Merchant Center feeds for price, stock, shipping and returns.</p></div>
      <div class="cell"><span class="n">06 · Speed</span><h3>Fast pages</h3><p>Category and product templates built to Google's Core Web Vitals thresholds.</p></div>
      <div class="cell"><span class="n">07 · Access</span><h3>Accessibility</h3><p>Designed and tested to WCAG 2.2 level AA, with the European Accessibility Act in mind.</p></div>
      <div class="cell"><span class="n">08 · Connect</span><h3>Integrations</h3><p>Payments, shipping, tax, stock, ERP, email and analytics connected and tested.</p></div>
      <div class="cell"><span class="n">09 · Measure</span><h3>E-commerce analytics</h3><p>Funnel tracking from product view to purchase, so you can see where sales are lost.</p></div>
    </div>
  </div>
</section>

<section id="checkout">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Checkout&nbsp;<b>]</b></span><h2>Why do shoppers abandon their carts?</h2><p class="lede">Most carts are abandoned. Many of the reasons are design problems you can fix. Baymard Institute's research shows where.</p></div>
    <div class="cols c3">
      <div class="metric"><span class="num">70.22%</span><h3>Average abandonment</h3><p>The average documented cart abandonment rate, across 50 studies.</p></div>
      <div class="metric"><span class="num">40%</span><h3>Extra costs too high</h3><p>abandoned because shipping, tax or fees were too high.</p></div>
      <div class="metric"><span class="num">20%</span><h3>Delivery too slow</h3><p>left because delivery would take too long.</p></div>
      <div class="metric"><span class="num">19%</span><h3>Didn't trust the site</h3><p>didn't trust the site with their card details.</p></div>
      <div class="metric"><span class="num">18%</span><h3>Forced to register</h3><p>left because the site wanted them to create an account.</p></div>
      <div class="metric"><span class="num">17%</span><h3>Checkout too long</h3><p>abandoned because the checkout was too long or complicated.</p></div>
    </div>
    <p class="quote">An ideal checkout can be as short as 12 to 14 form elements. Baymard's benchmark puts the average US checkout at 23.48. That gap is where we start.</p>
    <p class="src">Source: Baymard Institute, <a href="<?php echo $bay; ?>" rel="noopener" target="_blank">Cart abandonment rate statistics</a> (updated 22 September 2025; reasons exclude shoppers who were "just browsing")</p>
  </div>
</section>

<section class="band alt" id="google">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Found in Google&nbsp;<b>]</b></span><h2>How do products get found in Google?</h2><p class="lede">Google can show price, availability, ratings, shipping and returns right in search results, when your store gives it the data.</p></div>
    <div class="cols c3">
      <div class="cell"><span class="n">Markup</span><h3>Merchant listings</h3><p>Product structured data on every page where customers can buy: price, stock, shipping and returns.</p></div>
      <div class="cell"><span class="n">Feeds</span><h3>Merchant Center</h3><p>Product data shared with Google through Merchant Center feeds, kept in sync with your store.</p></div>
      <div class="cell"><span class="n">Crawl</span><h3>Controlled filters</h3><p>Filter and sort URLs kept out of the crawl, so Google spends its time on the pages that sell.</p></div>
    </div>
    <p class="src">Sources: Google, <a href="<?php echo $gd('appearance/structured-data/product'); ?>" rel="noopener" target="_blank">Product structured data</a> · <a href="<?php echo $gd('specialty/ecommerce'); ?>" rel="noopener" target="_blank">Best practices for ecommerce sites</a></p>
  </div>
</section>

<section id="how">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Process&nbsp;<b>]</b></span><h2>How does an e-commerce project run?</h2><p class="lede">Catalogue and checkout first: they decide whether the store sells.</p></div>
    <ol class="steps">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Discover</h3><p>Products, customers, margins, fulfilment and any existing store's data.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Structure</h3><p>Categories, filters, URLs and templates, and a redirect map if you're moving.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Design</h3><p>Product, category, cart and checkout designs, tested with real tasks.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Build &amp; integrate</h3><p>Store, payments, shipping, stock and feeds built and tested on staging.</p></li>
      <li class="step"><div class="k" aria-hidden="true">05</div><h3>Launch &amp; improve</h3><p>Go-live, monitoring, then checkout and conversion improvements.</p></li>
    </ol>
  </div>
</section>

<section class="band alt" id="get">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Deliverables&nbsp;<b>]</b></span><h2>What you get.</h2></div>
    <ul class="ticks">
      <li><b>Catalogue &amp; URL plan</b>: categories, filters and a redirect map for migrations.</li>
      <li><b>Store design</b>: home, category, product, cart and checkout templates.</li>
      <li><b>Store build</b>: WooCommerce set up with your products, payments, shipping and tax.</li>
      <li><b>Product data</b>: merchant listings markup and a Merchant Center feed.</li>
      <li><b>Integrations</b>: stock, ERP, email and analytics connected.</li>
      <li><b>Speed &amp; accessibility report</b>: Core Web Vitals and WCAG 2.2 AA checks.</li>
      <li><b>Training</b>: adding products, running offers and managing orders.</li>
      <li><b>Launch support</b>: monitoring and fixes after go-live.</li>
    </ul>
  </div>
</section>

<section id="honest">
  <div class="wrap">
    <div class="honest">
      <span class="ey"><b>[</b>&nbsp;Straight answer&nbsp;<b>]</b></span>
      <h2>Most lost sales happen at checkout, not in the design review.</h2>
      <p>A store can look beautiful and still lose most of its buyers between the cart and the confirmation page. Surprise costs, forced accounts and long forms do more damage than any colour choice. We design the checkout with the same care as the home page, and measure where shoppers drop out after launch.</p>
    </div>
  </div>
</section>

<section class="band alt" id="who">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Who it's for&nbsp;<b>]</b></span><h2>Who are our online stores for?</h2><p class="lede">Retail and B2B businesses selling online, from a focused catalogue to trade ordering with customer-specific pricing.</p></div>
    <ul class="inds8">
      <?php foreach (rl_ecd_industries() as $i => $d) { $l = $ex('industries/' . $d[0]); ?>
      <li class="ind"><span class="k"><?php echo sprintf('%02d', $i + 1); ?></span><h3><?php echo $l ? '<a href="' . $l . '">' . esc_html($d[1]) . '</a>' : esc_html($d[1]); ?></h3><ul><?php foreach ($d[2] as $pt) echo '<li>' . esc_html($pt) . '</li>'; ?></ul><?php if ($l) echo '<a class="more" href="' . $l . '" aria-label="' . esc_attr('Explore: Online stores for ' . $d[1]) . '">Explore &rarr;</a>'; ?></li>
      <?php } ?>
    </ul>
  </div>
</section>

<section id="related">
  <div class="wrap">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Related services&nbsp;<b>]</b></span><h2>What works with a new online store?</h2><p class="lede">A store is the start. These services bring shoppers in and keep it running.</p></div>
    <div class="cols c3">
      <?php foreach ([
          ['services/wordpress-website-design-service', 'Websites', 'WordPress Website Design', 'Brand and content sites that sit alongside your store.'],
          ['services/website-maintenance-services', 'After launch', 'Website Maintenance', 'Updates, backups, security and speed, month after month.'],
          ['services/technical-seo-services', 'Foundation', 'Technical SEO', 'Crawl control for filters, pagination and large catalogues.'],
          ['services/seo-content-systems', 'Content', 'SEO Content Systems', 'Category copy and buying guides that help shoppers choose.'],
          ['services/marketing-automation', 'Retention', 'Marketing Automation', 'Welcome, abandoned-basket and post-purchase journeys.'],
          ['services/lead-generation-systems', 'Paid', 'Lead Generation Systems', 'Shopping and search campaigns bid on real revenue.'],
      ] as $r) { $l = $ex($r[0]); $in = '<span class="n">' . esc_html($r[1]) . '</span><h3>' . esc_html($r[2]) . '</h3><p>' . esc_html($r[3]) . '</p>';
          echo $l ? '<a class="cell" href="' . $l . '">' . $in . '<span class="more">Explore &rarr;</span></a>' : '<div class="cell">' . $in . '</div>'; } ?>
    </div>
  </div>
</section>

<section class="faq band alt" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>About e-commerce website design.</h2></div>
    <?php foreach (rl_ecd_faqs() as $k => $q) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>Where is your store losing sales?</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your store's visibility in Google, its speed and its path to purchase, and shows what to fix first.</p>
      <div class="cta-row">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $u('services'); ?>">All services</a>
      </div>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
