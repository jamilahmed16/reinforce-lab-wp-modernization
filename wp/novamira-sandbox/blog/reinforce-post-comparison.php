<?php
/**
 * Plugin Name: Reinforce Lab - Comparison post design
 * Description: The approved Comparison design (D-077, mockup claude/design-previews/blog-comparison-template-mockup.html). Head-to-head: two options face off across a VS line, a tally of rounds won, round by round with a winner pointer, a "what matters most to you" picker, a side-by-side table, winner by situation, "or use both", one in-article service CTA, our verdict, FAQs and sources, author box. Two options (D-090). reinforce-post.php hands Comparison posts to rl_cmp_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_cmp_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'comparison'; }

/* ---------- fields (Comparison only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'comparison']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_cmp', 'title' => 'Comparison (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_c_a_name', 'Option A: name', 'text', ['instructions' => 'Shown in red throughout the page.']),
            $f('rl_c_a_desc', 'Option A: one line', 'text'),
            $f('rl_c_a_choose', 'Option A: choose it if', 'text'),
            $f('rl_c_b_name', 'Option B: name', 'text', ['instructions' => 'Shown in a pale neutral throughout the page.']),
            $f('rl_c_b_desc', 'Option B: one line', 'text'),
            $f('rl_c_b_choose', 'Option B: choose it if', 'text'),
            $f('rl_c_rounds', 'Rounds', 'textarea', ['rows' => 8, 'instructions' => 'One per line: Round | Winner (A, B or Tie) | What A is like | What B is like. Example: Cost | B | Salaries, tools and training | One monthly retainer']),
            $f('rl_c_rows', 'Side-by-side details', 'textarea', ['rows' => 5, 'instructions' => 'One per line: Row | A | B. Example: Time to first work | 3 to 6 months | 2 to 4 weeks']),
            $f('rl_c_winners', 'Winner by situation', 'textarea', ['rows' => 4, 'instructions' => 'One per line: Situation | A or B | Why. Example: You need results this quarter | B | Starts within weeks.']),
            $f('rl_c_both', 'Or use both', 'textarea', ['rows' => 3, 'instructions' => 'Optional. When combining the two makes sense, and what it costs.']),
            $f('rl_c_verdict', 'Our verdict', 'textarea', ['rows' => 3, 'instructions' => 'Two or three sentences.']),
            $f('rl_c_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Shown before the verdict. Leave empty for none.']),
            $f('rl_c_cta_head', 'In-article CTA: headline', 'text', ['instructions' => 'Example: Not sure which way to go?']),
            $f('rl_c_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_c_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
        ],
    ]);
});

/* ---------- data ---------- */
function rl_cmp_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
/* "A", "B", "Tie" or an option's name → a, b or t */
function rl_cmp_side($v, $a, $b) {
    $v = mb_strtolower(trim((string) $v));
    if ($v === 'a' || ($a !== '' && $v === mb_strtolower($a))) return 'a';
    if ($v === 'b' || ($b !== '' && $v === mb_strtolower($b))) return 'b';
    return 't';
}
function rl_cmp_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $a = $m('rl_c_a_name'); $b = $m('rl_c_b_name');
    $rounds = [];
    foreach (rl_cmp_rows(get_post_meta($id, 'rl_c_rounds', true), 2) as $r) $rounds[] = ['name' => $r[0], 'win' => rl_cmp_side($r[1], $a, $b), 'a' => $r[2] ?? '', 'b' => $r[3] ?? ''];
    $tally = ['a' => 0, 'b' => 0, 't' => 0]; foreach ($rounds as $r) $tally[$r['win']]++;
    $uses = [];
    foreach (rl_cmp_rows(get_post_meta($id, 'rl_c_winners', true), 2) as $u) { $s = rl_cmp_side($u[1], $a, $b); if ($s !== 't') $uses[] = [$u[0], $s, $u[2] ?? '']; }
    return $cache[$id] = ['a' => $a, 'b' => $b, 'a_desc' => $m('rl_c_a_desc'), 'b_desc' => $m('rl_c_b_desc'), 'a_choose' => $m('rl_c_a_choose'), 'b_choose' => $m('rl_c_b_choose'),
        'rounds' => $rounds, 'tally' => $tally, 'rows' => rl_cmp_rows(get_post_meta($id, 'rl_c_rows', true), 2), 'uses' => $uses, 'both' => $m('rl_c_both'), 'verdict' => $m('rl_c_verdict')];
}

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_cmp_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $x = rl_cmp_data($id);
    $ok = $x['a'] !== '' && $x['b'] !== '';
    $nm = ['a' => $x['a'], 'b' => $x['b']];
    $title = get_the_title($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $parts = preg_split('#(?=<h2\b)#i', $c['body'], 2);
    $intro = trim($parts[0]); $more = trim($parts[1] ?? '');
    $cta = null; $svc = (string) get_post_meta($id, 'rl_c_cta_service', true); $head = trim((string) get_post_meta($id, 'rl_c_cta_head', true));
    if ($svc !== '' && $head !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) {
        $cta = ['name' => rl_pt_services()[$svc], 'url' => $u($svc), 'head' => $head, 'sub' => trim((string) get_post_meta($id, 'rl_c_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_c_cta_button', true)) ?: 'See how it works'];
    }
    $diag = $u('search-authority-diagnostic');
    $t = $x['tally'];
    ?>
<div class="rl-page rl-post rl-cmp">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<div class="wrap c-hero">
  <div class="c-kicker"><span class="c-kind">Comparison</span><?php if ($c['cat']) echo '<a class="c-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
  <h1 class="c-h1"><?php echo esc_html($title); ?></h1>
  <?php if ($standfirst !== '') { ?><p class="c-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
  <div class="c-by">
    <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
    <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
    <?php if ($d['updated'] !== '') { ?><span class="fresh">Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
  </div>

  <?php if ($ok) { ?>
  <div class="face">
    <div class="side a"><span class="tagline">Option A</span><h2><?php echo esc_html($x['a']); ?></h2><?php if ($x['a_desc'] !== '') echo '<p>' . esc_html($x['a_desc']) . '</p>'; ?><?php if ($x['a_choose'] !== '') echo '<p class="ch"><b>Choose it if</b>' . esc_html($x['a_choose']) . '</p>'; ?></div>
    <div class="vs" aria-hidden="true"><span>VS</span></div>
    <div class="side b"><span class="tagline">Option B</span><h2><?php echo esc_html($x['b']); ?></h2><?php if ($x['b_desc'] !== '') echo '<p>' . esc_html($x['b_desc']) . '</p>'; ?><?php if ($x['b_choose'] !== '') echo '<p class="ch"><b>Choose it if</b>' . esc_html($x['b_choose']) . '</p>'; ?></div>
  </div>
  <?php if ($x['rounds']) { ?>
  <div class="tally" aria-label="Rounds won">
    <p class="row"><span><?php echo esc_html($x['a']); ?> <b><?php echo (int) $t['a']; ?></b></span><?php if ($t['t']) { ?><span>Tie <b><?php echo (int) $t['t']; ?></b></span><?php } ?><span><b><?php echo (int) $t['b']; ?></b> <?php echo esc_html($x['b']); ?></span></p>
    <div class="tbar" aria-hidden="true"><?php if ($t['a']) echo '<i class="ta" style="flex:' . (int) $t['a'] . '"></i>'; ?><?php if ($t['t']) echo '<i class="tt" style="flex:' . (int) $t['t'] . '"></i>'; ?><?php if ($t['b']) echo '<i class="tb" style="flex:' . (int) $t['b'] . '"></i>'; ?></div>
  </div>
  <?php } ?>
  <?php } ?>
</div>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap c-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="c-main">
    <?php if ($d['answer'] !== '') { ?><div class="c-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
    <?php if ($d['takeaways']) { ?><div class="c-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . sprintf('%02d', $i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>
    <?php if ($intro !== '') echo '<div class="c-prose">' . $intro . '</div>'; ?>

    <?php if ($ok && $x['rounds']) { ?>
    <div class="sec-h" id="rounds"><span>Round by round</span><h2>How they compare</h2></div>
    <div class="rounds">
      <div class="rhead" aria-hidden="true"><span class="ha"><?php echo esc_html($x['a']); ?></span><span class="hc">Round</span><span class="hb"><?php echo esc_html($x['b']); ?></span></div>
      <?php foreach ($x['rounds'] as $r) {
          $ptr = $r['win'] === 'a' ? '<span class="ptr wa">&larr; ' . esc_html($x['a']) . '</span>' : ($r['win'] === 'b' ? '<span class="ptr wb">' . esc_html($x['b']) . ' &rarr;</span>' : '<span class="ptr tie">Tie</span>'); ?>
      <div class="round<?php echo $r['win'] !== 't' ? ' w' . $r['win'] : ''; ?>">
        <div class="pa"><span class="lbl"><?php echo esc_html($x['a']); ?></span><?php echo esc_html($r['a']); ?></div>
        <div class="mid"><h3><?php echo esc_html($r['name']); ?></h3><?php echo $ptr; ?></div>
        <div class="pb"><span class="lbl"><?php echo esc_html($x['b']); ?></span><?php echo esc_html($r['b']); ?></div>
      </div>
      <?php } ?>
    </div>

    <div class="sec-h" id="you"><span>Your call</span><h2>What matters most to you?</h2></div>
    <div class="pick" data-a="<?php echo esc_attr($x['a']); ?>" data-b="<?php echo esc_attr($x['b']); ?>">
      <div class="q"><p>Tick the rounds that matter for your business.</p>
        <div class="chips"><?php foreach ($x['rounds'] as $k => $r) echo '<label for="rl-cmp-' . $k . '"><input type="checkbox" id="rl-cmp-' . $k . '" data-w="' . esc_attr($r['win']) . '">' . esc_html($r['name']) . '</label>'; ?></div>
      </div>
      <div class="res" aria-live="polite"><span class="t" data-c="t">Across all rounds</span><span class="w" data-c="w"><?php echo $t['a'] === $t['b'] ? 'It is a tie' : esc_html($t['a'] > $t['b'] ? $x['a'] : $x['b']); ?></span><span class="s" data-c="s"><?php echo (int) $t['a']; ?> to <?php echo (int) $t['b']; ?><?php echo $t['t'] ? ', ' . (int) $t['t'] . ' tied' : ''; ?>. Tick rounds to see your own result.</span></div>
    </div>
    <?php } ?>

    <?php if ($ok && $x['rows']) { ?>
    <div class="sec-h" id="table"><span>Side by side</span><h2>The details</h2></div>
    <div class="tw"><table class="c-table">
      <thead><tr><th scope="col"><span class="vh">Detail</span></th><th scope="col" class="ca"><?php echo esc_html($x['a']); ?></th><th scope="col" class="cb"><?php echo esc_html($x['b']); ?></th></tr></thead>
      <tbody><?php foreach ($x['rows'] as $r) echo '<tr><th scope="row">' . esc_html($r[0]) . '</th><td>' . esc_html($r[1] ?? '') . '</td><td>' . esc_html($r[2] ?? '') . '</td></tr>'; ?></tbody>
    </table></div>
    <?php } ?>

    <?php if ($ok && $x['uses']) { ?>
    <div class="sec-h"><span>Quick decision</span><h2>Winner by situation</h2></div>
    <div class="uses"><?php foreach ($x['uses'] as $us) echo '<div class="use"><span class="u">' . esc_html($us[0]) . '</span><span class="p c' . $us[1] . '">' . esc_html($nm[$us[1]]) . '</span>' . ($us[2] !== '' ? '<span class="why">' . esc_html($us[2]) . '</span>' : '') . '</div>'; ?></div>
    <?php } ?>
    <?php if ($ok && $x['both'] !== '') { ?>
    <div class="both"><span class="mix" aria-hidden="true"><i></i><i></i></span><div><h3>Or use both</h3><p><?php echo esc_html($x['both']); ?></p></div></div>
    <?php } ?>

    <?php if ($more !== '') echo '<div class="c-prose c-more">' . $more . '</div>'; ?>

    <?php if ($cta) { ?>
    <aside class="c-icta" aria-label="Reinforce Lab service">
      <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
      <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
    </aside>
    <?php } ?>

    <?php if ($x['verdict'] !== '') { ?><div class="c-verdict"><p class="t">Our verdict</p><p><?php echo esc_html($x['verdict']); ?></p></div><?php } ?>
  </div>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <div class="c-back">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="c-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </div>
  <?php } ?>

  <aside class="c-author" aria-label="About the author">
    <span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span>
    <div>
      <p class="nm"><?php echo esc_html($c['aname']); ?></p>
      <?php if ($c['founder']) { ?>
      <p class="role"><?php echo esc_html($c['founder']['job']); ?>, Reinforce Lab</p>
      <p><?php echo $c['bio'] !== '' ? esc_html($c['bio']) : 'Pharmacist, SEO and AI search consultant, and Semrush Ambassador. Jamil builds AI Growth Systems for businesses using AI automation, AI Search Optimization, SEO and intelligent workflows.'; ?></p>
      <div class="links"><a href="<?php echo $c['about']; ?>#founder">About Jamil</a><a href="<?php echo esc_url($c['founder']['linkedin']); ?>" rel="noopener" target="_blank">LinkedIn</a></div>
      <?php } elseif ($c['bio'] !== '') { ?><p><?php echo esc_html($c['bio']); ?></p><?php } ?>
    </div>
  </aside>
</div>

<?php
    $rq = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true, 'category__in' => $c['cat'] ? [$c['cat']->term_id] : []]);
    if ($rq->have_posts()) { ?>
<section class="band alt rel" id="related"><div class="wrap"><div class="head"><span class="ey"><b>[</b>&nbsp;Keep reading&nbsp;<b>]</b></span><h2>Related articles</h2></div><ul class="posts">
<?php while ($rq->have_posts()) { $rq->the_post(); $rd = rl_post_data(get_the_ID()); ?>
  <li class="post"><span class="m"><?php echo esc_html($rd['type_label']); ?> · <?php echo esc_html(get_the_date('j M Y')); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read article: ' . get_the_title()); ?>">Read article &rarr;</a></li>
<?php } wp_reset_postdata(); echo rl_post_rel_pages($id, 3 - $rq->post_count); ?>
</ul></div></section>
<?php } else echo rl_post_rel_section($id); ?>

<section id="start">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
      <h2>See where your search visibility stands.</h2>
      <p class="lede">The free Search Authority Diagnostic reviews your visibility in Google and AI answers, and shows what to fix first.</p>
      <div class="cta-row"><a class="btn p" href="<?php echo esc_url($diag); ?>">Get your free diagnostic <span class="ar">&rarr;</span></a><a class="btn g" href="<?php echo esc_url($c['blog_url']); ?>">More articles</a></div>
    </div>
  </div>
</section>

</div>
<?php if ($ok && $x['rounds']) { ?>
<script>
(function(){
  var pk=document.querySelector('.rl-cmp .pick'); if(!pk) return;
  var boxes=[].slice.call(pk.querySelectorAll('input[data-w]')), q=function(k){return pk.querySelector('[data-c="'+k+'"]');};
  var names={a:pk.getAttribute('data-a'),b:pk.getAttribute('data-b')}, first={t:q('t').textContent,w:q('w').textContent,s:q('s').textContent,c:q('w').className};
  function run(){
    var on=boxes.filter(function(b){return b.checked;}), a=0, b=0, w=q('w');
    if(!on.length){ q('t').textContent=first.t; w.textContent=first.w; w.className=first.c; q('s').textContent=first.s; return; }
    on.forEach(function(x){ var s=x.getAttribute('data-w'); if(s==='a') a++; else if(s==='b') b++; });
    q('t').textContent='For you'; w.className='w';
    if(a===b){ w.textContent='It is a tie'; q('s').textContent='Each side wins '+a+' of the '+on.length+' round'+(on.length>1?'s':'')+' you picked. See the situations below.'; return; }
    var k=a>b?'a':'b'; w.textContent=names[k]; w.classList.add(k==='a'?'ca':'cb');
    q('s').textContent='Wins '+(k==='a'?a:b)+' of the '+on.length+' round'+(on.length>1?'s':'')+' you picked.';
  }
  boxes.forEach(function(b){b.addEventListener('change',run);});
  var w0=q('w'); if(w0.textContent===names.a) w0.classList.add('ca'); else if(w0.textContent===names.b) w0.classList.add('cb'); first.c=w0.className;
})();
</script>
<?php }
}

/* ---------- schema: the two options as an ItemList (no ratings) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_cmp_view()) return $graph;
    $id = get_queried_object_id(); $x = rl_cmp_data($id);
    if ($x['a'] === '' || $x['b'] === '') return $graph;
    $url = get_permalink($id);
    $graph[] = ['@type' => 'ItemList', '@id' => $url . '#options', 'name' => get_the_title($id), 'numberOfItems' => 2,
        'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => $x['a']], ['@type' => 'ListItem', 'position' => 2, 'name' => $x['b']]]];
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_cmp_view()) return; ?>
<style id="rl-cmp-css">
.rl-cmp{color:var(--ink-dim);--a:#e85050;--a-soft:rgba(226,59,59,.14);--a-line:rgba(226,59,59,.45);--b:#d8cfd0;--b-soft:rgba(216,207,208,.08);--b-line:rgba(216,207,208,.4);--ok:#3fa36b}
.rl-cmp h1,.rl-cmp h2,.rl-cmp h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-cmp .vh{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)}
.rl-cmp .c-hero{padding-block:clamp(24px,4vw,40px) 0;text-align:center}
.rl-cmp .c-kicker{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin-bottom:18px}
.rl-cmp .c-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-cmp .c-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-cmp .c-h1{font-size:clamp(32px,4.4vw,56px);max-width:900px;margin:0 auto}
.rl-cmp .c-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;max-width:680px;margin:16px auto 0}
.rl-cmp .c-by{display:flex;flex-wrap:wrap;justify-content:center;align-items:center;gap:10px 22px;margin-top:20px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cmp .c-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-cmp .c-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-cmp .c-by b{color:var(--ink-dim);font-weight:500}
.rl-cmp .c-by .fresh,.rl-cmp .c-by .fresh b{color:var(--ok)}
.rl-cmp .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-cmp .face{display:grid;grid-template-columns:minmax(0,1fr) 88px minmax(0,1fr);margin-top:34px;text-align:left}
.rl-cmp .side{border:1px solid var(--line-2);background:var(--panel);padding:24px 26px;display:grid;gap:10px;align-content:start;min-width:0}
.rl-cmp .side.a{border-color:var(--a-line);background:linear-gradient(135deg,var(--a-soft),transparent 60%),var(--panel);border-right:0}
.rl-cmp .side.b{border-color:var(--b-line);background:linear-gradient(225deg,var(--b-soft),transparent 60%),var(--panel);border-left:0;text-align:right}
.rl-cmp .tagline{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase}
.rl-cmp .a .tagline{color:var(--a)}
.rl-cmp .b .tagline{color:var(--b)}
.rl-cmp .side h2{font-size:clamp(26px,3vw,38px);margin:0;overflow-wrap:anywhere}
.rl-cmp .side p{margin:0;font-size:15.5px}
.rl-cmp .side .ch{border-top:1px solid var(--line);padding-top:10px;font-size:14.5px;color:var(--ink)}
.rl-cmp .side .ch b{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);font-weight:500;display:block;margin-bottom:2px}
.rl-cmp .vs{display:grid;place-items:center;position:relative;border-block:1px solid var(--line-2);background:var(--bg-2)}
.rl-cmp .vs::before{content:"";position:absolute;top:0;bottom:0;left:50%;width:1px;background:linear-gradient(var(--a-line),var(--b-line))}
.rl-cmp .vs span{position:relative;z-index:1;font-family:var(--f-display);font-weight:700;font-size:34px;color:var(--ink);background:var(--bg-2);padding:8px 0;letter-spacing:.04em}
.rl-cmp .tally{margin-top:14px;text-align:left}
.rl-cmp .tally .row{display:flex;justify-content:space-between;gap:10px;font-family:var(--f-mono);font-size:11.5px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 6px}
.rl-cmp .tally .row b{color:var(--ink);font-weight:500}
.rl-cmp .tbar{display:flex;height:12px;gap:2px}
.rl-cmp .tbar i{display:block}
.rl-cmp .tbar .ta{background:var(--a)}
.rl-cmp .tbar .tt{background:var(--line-2)}
.rl-cmp .tbar .tb{background:var(--b)}
.rl-cmp .c-feat{margin:28px auto 0}
.rl-cmp .c-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-cmp .c-main{max-width:900px;margin:0 auto;padding-block:clamp(34px,5vw,52px) 10px}
.rl-cmp .c-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:24px}
.rl-cmp .c-answer .t,.rl-cmp .sec-h span,.rl-cmp .c-verdict .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-cmp .c-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-cmp .c-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:28px}
.rl-cmp .c-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-cmp .c-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-cmp .c-prose>*{margin:0 0 1.1em}
.rl-cmp .c-prose p,.rl-cmp .c-prose li{font-size:17.5px;line-height:1.75}
.rl-cmp .c-prose h2{font-size:clamp(24px,2.8vw,30px);margin:1.8em 0 .6em;scroll-margin-top:110px}
.rl-cmp .c-prose h3{font-size:21px;margin:1.4em 0 .5em;scroll-margin-top:110px}
.rl-cmp .c-prose strong{color:var(--ink);font-weight:600}
.rl-cmp .c-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-cmp .c-prose ul,.rl-cmp .c-prose ol{padding-left:1.2em}
.rl-cmp .c-prose li::marker{color:var(--red-3)}
.rl-cmp .c-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-cmp .c-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-cmp .c-prose th,.rl-cmp .c-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-cmp .c-more{margin-top:36px}
.rl-cmp .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px;scroll-margin-top:96px}
.rl-cmp .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-cmp .rounds{border:1px solid var(--line-2)}
.rl-cmp .rhead{display:grid;grid-template-columns:minmax(0,1fr) 130px minmax(0,1fr);background:var(--panel);border-bottom:1px solid var(--line-2);font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase}
.rl-cmp .rhead span{padding:10px 18px}
.rl-cmp .rhead .ha{color:var(--a)}
.rl-cmp .rhead .hb{color:var(--b);text-align:right}
.rl-cmp .rhead .hc{color:var(--ink-faint);text-align:center}
.rl-cmp .round{display:grid;grid-template-columns:minmax(0,1fr) 130px minmax(0,1fr);border-top:1px solid var(--line)}
.rl-cmp .rhead + .round{border-top:0}
.rl-cmp .round .pa,.rl-cmp .round .pb{padding:16px 18px;font-size:15px;min-width:0}
.rl-cmp .round .pb{text-align:right}
.rl-cmp .round .mid{display:grid;align-content:center;justify-items:center;gap:6px;padding:12px 6px;background:var(--bg-2);border-inline:1px solid var(--line);min-width:0}
.rl-cmp .round .mid h3{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;font-weight:500;color:var(--ink);text-align:center;line-height:1.35;margin:0}
.rl-cmp .ptr{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.08em;text-transform:uppercase;padding:3px 8px;text-align:center;max-width:100%;overflow-wrap:anywhere}
.rl-cmp .ptr.wa{color:#fff;background:var(--red)}
.rl-cmp .ptr.wb{color:var(--bg);background:var(--b)}
.rl-cmp .ptr.tie{color:var(--ink-dim);border:1px solid var(--line-2)}
.rl-cmp .round.wa .pa{background:linear-gradient(90deg,var(--a-soft),transparent);color:var(--ink)}
.rl-cmp .round.wb .pb{background:linear-gradient(270deg,var(--b-soft),transparent);color:var(--ink)}
.rl-cmp .round .lbl{display:none}
.rl-cmp .pick{border:1px solid var(--line-2);background:var(--panel);display:grid;grid-template-columns:minmax(0,1.2fr) minmax(0,1fr)}
.rl-cmp .pick .q{padding:20px 22px;border-right:1px solid var(--line-2)}
.rl-cmp .pick .q p{margin:0 0 12px;font-size:15px;color:var(--ink)}
.rl-cmp .chips{display:flex;flex-wrap:wrap;gap:8px}
.rl-cmp .chips label{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--line-2);background:var(--bg-2);padding:8px 12px;font-size:14px;cursor:pointer;color:var(--ink-dim);margin:0}
.rl-cmp .chips input{appearance:none;-webkit-appearance:none;width:14px;height:14px;border:1px solid var(--line-2);border-radius:0;margin:0;display:grid;place-items:center;cursor:pointer;background:var(--bg)}
.rl-cmp .chips input:checked{background:var(--red);border-color:var(--red-2)}
.rl-cmp .chips input:checked::after{content:"";width:7px;height:4px;border-left:2px solid #fff;border-bottom:2px solid #fff;transform:rotate(-45deg) translate(1px,-1px)}
.rl-cmp .chips label:has(input:checked){border-color:var(--red-line);color:var(--ink)}
.rl-cmp .pick .res{padding:20px 22px;display:grid;align-content:center;gap:8px;background:var(--bg-2)}
.rl-cmp .pick .res .t{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-cmp .pick .res .w{font-family:var(--f-display);text-transform:uppercase;font-size:30px;line-height:1.05;color:var(--ink)}
.rl-cmp .pick .res .w.ca{color:var(--a)}
.rl-cmp .pick .res .w.cb{color:var(--b)}
.rl-cmp .pick .res .s{font-size:14px}
.rl-cmp .tw{overflow-x:auto;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-cmp .c-table{width:100%;border-collapse:collapse;min-width:600px;font-size:14.5px;margin:0}
.rl-cmp .c-table th,.rl-cmp .c-table td{padding:12px 14px;text-align:left;border:0;border-bottom:1px solid var(--line);vertical-align:top;background:none}
.rl-cmp .c-table thead th{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);font-weight:500;background:var(--panel)}
.rl-cmp .c-table thead th.ca{color:var(--a);box-shadow:inset 0 -2px 0 var(--a)}
.rl-cmp .c-table thead th.cb{color:var(--b);box-shadow:inset 0 -2px 0 var(--b)}
.rl-cmp .c-table tbody th{color:var(--ink);font-family:var(--f-body);font-size:15px;font-weight:600;letter-spacing:0;text-transform:none;width:24%}
.rl-cmp .c-table tbody tr:last-child>*{border-bottom:0}
.rl-cmp .uses{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-cmp .use{background:var(--bg);padding:18px 20px;display:grid;gap:6px;align-content:start}
.rl-cmp .use .u{font-size:15.5px;color:var(--ink)}
.rl-cmp .use .p{font-family:var(--f-display);text-transform:uppercase;font-size:18px}
.rl-cmp .use .p.ca{color:var(--a)}
.rl-cmp .use .p.cb{color:var(--b)}
.rl-cmp .use .why{font-size:13.5px;color:var(--ink-faint)}
.rl-cmp .both{display:grid;grid-template-columns:auto minmax(0,1fr);gap:20px;align-items:center;border:1px dashed var(--line-2);padding:22px 24px;margin-top:22px}
.rl-cmp .both .mix{width:64px;height:64px;display:grid;grid-template-columns:1fr 1fr}
.rl-cmp .both .mix i:first-child{background:var(--a)}
.rl-cmp .both .mix i:last-child{background:var(--b)}
.rl-cmp .both h3{font-size:19px;margin:0 0 6px}
.rl-cmp .both p{margin:0;font-size:15.5px}
.rl-cmp .c-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-cmp .c-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-cmp .c-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-cmp .c-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-cmp .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-cmp .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-cmp .go2:hover{background:var(--red-2)}
.rl-cmp .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-cmp .c-verdict{border:1px solid var(--red-line);background:var(--panel);padding:24px 26px;margin-top:46px}
.rl-cmp .c-verdict .t{margin-bottom:10px}
.rl-cmp .c-verdict p:not(.t){margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-cmp .c-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-cmp .c-back .sec-h{margin-top:0}
.rl-cmp .c-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-cmp .c-src li{padding:6px 0;color:var(--ink-faint)}
.rl-cmp .c-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-cmp .c-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-cmp .c-author .av{width:72px;height:72px;font-size:28px}
.rl-cmp .c-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-cmp .c-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-cmp .c-author p{margin:0 0 8px;font-size:15px}
.rl-cmp .c-author .links{display:flex;gap:18px;font-size:14px}
.rl-cmp .c-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:760px){
  .rl-cmp .face{grid-template-columns:minmax(0,1fr)}
  .rl-cmp .side.a{border-right:1px solid var(--a-line);border-bottom:0}
  .rl-cmp .side.b{border-left:1px solid var(--b-line);border-top:0;text-align:left}
  .rl-cmp .vs{border-block:0;border-inline:1px solid var(--line-2);height:56px}
  .rl-cmp .vs::before{top:50%;bottom:auto;left:0;right:0;width:auto;height:1px;background:linear-gradient(90deg,var(--a-line),var(--b-line))}
  .rl-cmp .vs span{padding:0 12px}
  .rl-cmp .rhead{display:none}
  .rl-cmp .round{grid-template-columns:minmax(0,1fr)}
  .rl-cmp .round .mid{grid-row:1;border-inline:0;border-bottom:1px solid var(--line);grid-auto-flow:column;justify-content:space-between;padding:10px 16px}
  .rl-cmp .round .mid h3{text-align:left}
  .rl-cmp .round .pb{text-align:left}
  .rl-cmp .round .lbl{display:block;font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;text-transform:uppercase;margin-bottom:4px}
  .rl-cmp .round .pa .lbl{color:var(--a)}
  .rl-cmp .round .pb .lbl{color:var(--b)}
  .rl-cmp .round .pa{border-bottom:1px solid var(--line)}
  .rl-cmp .pick{grid-template-columns:minmax(0,1fr)}
  .rl-cmp .pick .q{border-right:0;border-bottom:1px solid var(--line-2)}
  .rl-cmp .uses,.rl-cmp .c-back,.rl-cmp .c-take{grid-template-columns:minmax(0,1fr)}
  .rl-cmp .both{grid-template-columns:minmax(0,1fr)}
  .rl-cmp .c-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-cmp .cact{padding-right:16px}
  .rl-cmp .c-author{grid-template-columns:1fr}
  .rl-cmp .c-prose p,.rl-cmp .c-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-cmp .go2{transition:none}}
</style>
<?php }, 24);
