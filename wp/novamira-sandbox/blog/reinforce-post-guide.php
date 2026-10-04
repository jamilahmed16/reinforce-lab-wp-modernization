<?php
/**
 * Plugin Name: Reinforce Lab - Guide post design
 * Description: The approved Guide design (D-077, mockup claude/design-previews/blog-guide-template-mockup.html). Book layout: cover with contents plate, start-here paths, chapter rail with reading progress, chapter openers built from the H2s, one in-article service CTA, A to Z glossary, guide hub, FAQs and sources, author box. reinforce-post.php hands Guide posts to rl_guide_render(); everything else keeps the base layout.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_guide_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'guide'; }

/* ---------- fields (Guide only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'guide']]];
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_guide', 'title' => 'Guide (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            ['key' => 'field_rl_g_start', 'name' => 'rl_g_start', 'label' => 'Start here paths', 'type' => 'textarea', 'rows' => 4, 'conditional_logic' => $show,
             'instructions' => 'Up to 3, one per line: Who it is for | Card text | #heading-id or URL. Example: New to AI search | Start with how AI answers are built | #how-ai-answers-are-built'],
            ['key' => 'field_rl_g_cta_service', 'name' => 'rl_g_cta_service', 'label' => 'In-article CTA: service', 'type' => 'select', 'choices' => $services, 'allow_null' => 1, 'conditional_logic' => $show,
             'instructions' => 'The service that matches the chapter it follows. Leave empty for no in-article CTA.'],
            ['key' => 'field_rl_g_cta_after', 'name' => 'rl_g_cta_after', 'label' => 'In-article CTA: after chapter', 'type' => 'number', 'min' => 1, 'max' => 30, 'default_value' => 2, 'conditional_logic' => $show],
            ['key' => 'field_rl_g_cta_head', 'name' => 'rl_g_cta_head', 'label' => 'In-article CTA: headline', 'type' => 'text', 'conditional_logic' => $show,
             'instructions' => 'A question tied to the chapter just read. Example: Want AI tools to describe your business correctly?'],
            ['key' => 'field_rl_g_cta_sub', 'name' => 'rl_g_cta_sub', 'label' => 'In-article CTA: one line', 'type' => 'text', 'conditional_logic' => $show, 'instructions' => 'What we do, in one sentence.'],
            ['key' => 'field_rl_g_cta_button', 'name' => 'rl_g_cta_button', 'label' => 'In-article CTA: button text', 'type' => 'text', 'default_value' => 'See how it works', 'conditional_logic' => $show],
            ['key' => 'field_rl_g_glossary', 'name' => 'rl_g_glossary', 'label' => 'Glossary', 'type' => 'textarea', 'rows' => 6, 'conditional_logic' => $show,
             'instructions' => 'One per line: Term | Plain definition. Shown A to Z. Link a term in the text to #term-term-name.'],
            ['key' => 'field_rl_g_series', 'name' => 'rl_g_series', 'label' => 'Supporting articles (guide hub)', 'type' => 'textarea', 'rows' => 5, 'conditional_logic' => $show,
             'instructions' => 'One per line: Type | Title | URL. Example: How-To | How to build a prompt set | https://… When empty, related articles show instead.'],
        ],
    ]);
});

/* ---------- body → chapters ---------- */
function rl_guide_chapters($html) {
    $parts = preg_split('#(<h2\b[^>]*>.*?</h2>)#is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
    $intro = array_shift($parts);
    $ch = [];
    for ($i = 0; $i < count($parts); $i += 2) {
        preg_match('#<h2\b([^>]*)>(.*?)</h2>#is', $parts[$i], $m);
        $id = preg_match('/\sid=["\']([^"\']+)["\']/', $m[1] ?? '', $im) ? $im[1] : 'chapter-' . (count($ch) + 1);
        $inner = $parts[$i + 1] ?? '';
        $ch[] = ['id' => $id, 'title' => trim(wp_strip_all_tags($m[2] ?? '')), 'title_html' => $m[2] ?? '', 'html' => $inner,
                 'mins' => max(1, (int) ceil(str_word_count(wp_strip_all_tags($inner)) / 230))];
    }
    return [trim($intro), $ch];
}
function rl_guide_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_guide_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    [$intro, $chapters] = rl_guide_chapters($c['body']);
    $n = count($chapters);
    $nn = function ($i) { return sprintf('%02d', $i); };
    $byid = []; foreach ($chapters as $i => $ch) $byid['#' . $ch['id']] = $i + 1;
    $gloss = rl_guide_rows(get_post_meta($id, 'rl_g_glossary', true), 2);
    usort($gloss, function ($a, $b) { return strcasecmp($a[0], $b[0]); });
    $paths = array_slice(rl_guide_rows(get_post_meta($id, 'rl_g_start', true), 3), 0, 3);
    $series = rl_guide_rows(get_post_meta($id, 'rl_g_series', true), 3);
    $title = get_the_title($id);
    $tparts = explode(':', $title, 2);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    // in-article CTA
    $cta = null; $svc = (string) get_post_meta($id, 'rl_g_cta_service', true);
    $head = trim((string) get_post_meta($id, 'rl_g_cta_head', true));
    if ($svc !== '' && $head !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) {
        $after = max(1, (int) (get_post_meta($id, 'rl_g_cta_after', true) ?: 2));
        $cta = ['after' => min($after, max(1, $n)), 'name' => rl_pt_services()[$svc], 'url' => $u($svc), 'head' => $head,
                'sub' => trim((string) get_post_meta($id, 'rl_g_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_g_cta_button', true)) ?: 'See how it works'];
    }
    $diag = $u('search-authority-diagnostic');
    ?>
<div class="rl-page rl-post rl-guide">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<header class="wrap g-cover">
  <div>
    <div class="g-kicker"><span class="g-kind">Guide</span><?php if ($c['cat']) echo '<a class="g-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
    <h1 class="g-h1"><?php echo count($tparts) === 2 ? esc_html($tparts[0]) . ':<em>' . esc_html($tparts[1]) . '</em>' : esc_html($title); ?></h1>
    <?php if ($standfirst !== '') { ?><p class="g-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
    <div class="g-by">
      <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
      <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
      <?php if ($d['updated'] !== '') { ?><span>Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
    </div>
  </div>
  <?php if ($n) { ?>
  <aside class="g-plate" aria-label="In this guide">
    <div class="g-plate-top<?php echo $gloss ? '' : ' two'; ?>"><div><b><?php echo (int) $n; ?></b><span>Chapters</span></div><div><b><?php echo (int) $c['mins']; ?></b><span>Min read</span></div><?php if ($gloss) { ?><div><b>A to Z</b><span>Glossary</span></div><?php } ?></div>
    <ol><?php foreach ($chapters as $i => $ch) echo '<li><a href="#' . esc_attr($ch['id']) . '"><span class="n">' . $nn($i + 1) . '</span><span>' . esc_html($ch['title']) . '</span><span class="m">' . (int) $ch['mins'] . ' min</span></a></li>'; ?></ol>
  </aside>
  <?php } ?>
</header>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap g-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<?php if ($paths) { ?>
<div class="wrap">
  <div class="g-paths-h"><span>Start here</span><i></i></div>
  <div class="g-paths">
    <?php foreach ($paths as $p) { $go = isset($byid[$p[2]]) ? 'Chapter ' . $nn($byid[$p[2]]) : 'Read'; ?>
    <a class="g-path" href="<?php echo esc_url($p[2]); ?>"><span class="w"><?php echo esc_html($p[0]); ?></span><span class="t"><?php echo esc_html($p[1]); ?></span><span class="go"><?php echo esc_html($go); ?> &rarr;</span></a>
    <?php } ?>
  </div>
</div>
<?php } ?>

<div class="wrap">
  <?php if ($n) { ?><div class="g-mbar" aria-hidden="true"><div class="row"><span data-g="mch">Chapter 01 of <?php echo $nn($n); ?></span><span data-g="mpct">0% read</span></div><div class="bar"><i data-g="mbar"></i></div></div><?php } ?>
  <div class="g-book<?php echo $n ? '' : ' norail'; ?>">
    <?php if ($n) { ?>
    <aside class="g-rail" aria-label="Chapters">
      <div class="lbl"><span>Chapters</span><span data-g="rpct">0%</span></div>
      <ol><span class="fill" data-g="fill"></span><?php foreach ($chapters as $i => $ch) echo '<li><a href="#' . esc_attr($ch['id']) . '"><span class="d">' . $nn($i + 1) . '</span><span>' . esc_html($ch['title']) . '</span></a></li>'; ?></ol>
      <p class="pct">About <?php echo (int) $c['mins']; ?> min in total</p>
    </aside>
    <?php } ?>
    <article class="g-text">
      <?php if ($d['answer'] !== '') { ?><div class="g-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
      <?php if ($d['takeaways']) { ?><div class="g-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . $nn($i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>
      <?php if ($intro !== '') echo '<div class="g-prose g-intro">' . $intro . '</div>'; ?>
      <?php foreach ($chapters as $i => $ch) { $k = $i + 1; ?>
      <section class="g-ch" data-ch="<?php echo (int) $k; ?>" aria-labelledby="<?php echo esc_attr($ch['id']); ?>">
        <div class="g-open"><span class="g-num" aria-hidden="true"><?php echo $nn($k); ?></span><div><p class="g-meta">Chapter <?php echo (int) $k; ?> · <?php echo (int) $ch['mins']; ?> min</p><h2 id="<?php echo esc_attr($ch['id']); ?>"><?php echo wp_kses_post($ch['title_html']); ?></h2></div></div>
        <div class="g-prose"><?php echo $ch['html']; ?></div>
        <?php if ($k < $n) { ?><div class="g-end"><span>End of chapter <?php echo (int) $k; ?></span><a href="#<?php echo esc_attr($chapters[$i + 1]['id']); ?>">Next: <?php echo esc_html($chapters[$i + 1]['title']); ?> <i aria-hidden="true">&rarr;</i></a></div><?php } ?>
      </section>
      <?php if ($cta && $cta['after'] === $k) { ?>
      <aside class="g-icta" aria-label="Reinforce Lab service">
        <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
        <div class="act"><a class="go" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
      </aside>
      <?php } ?>
      <?php } ?>
    </article>
  </div>

  <?php if ($gloss) { ?>
  <section class="g-back" aria-labelledby="g-gl-h">
    <div class="g-back-h"><span>Back matter</span><h2 id="g-gl-h">Glossary A to Z</h2></div>
    <dl class="g-gloss"><?php foreach ($gloss as $g) echo '<div class="gl" id="term-' . esc_attr(sanitize_title($g[0])) . '"><span class="l" aria-hidden="true">' . esc_html(mb_strtoupper(mb_substr($g[0], 0, 1))) . '</span><div><dt>' . esc_html($g[0]) . '</dt><dd>' . esc_html($g[1]) . '</dd></div></div>'; ?></dl>
  </section>
  <?php } ?>

  <?php if ($series) { ?>
  <section class="g-back" aria-labelledby="g-hub-h">
    <div class="g-back-h"><span>Go deeper</span><h2 id="g-hub-h">This guide and its articles</h2></div>
    <div class="g-hub">
      <div class="core"><span>Pillar guide</span><b><?php echo esc_html($title); ?></b><span>You are here</span></div>
      <ul><?php foreach ($series as $s) echo '<li><a href="' . esc_url($s[2]) . '"><span class="ty">' . esc_html($s[0]) . '</span><span>' . esc_html($s[1]) . '</span><span class="ar" aria-hidden="true">&rarr;</span></a></li>'; ?></ul>
    </div>
  </section>
  <?php } ?>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <section class="g-back g-two" aria-label="Questions and sources">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="g-back-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="g-src" id="sources"><div class="g-back-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </section>
  <?php } ?>

  <aside class="g-author" aria-label="About the author">
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
    if (!$series) {
        $rel = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true, 'category__in' => $c['cat'] ? [$c['cat']->term_id] : []]);
        if ($rel->have_posts()) { ?>
<section class="band alt rel" id="related"><div class="wrap"><div class="head"><span class="ey"><b>[</b>&nbsp;Keep reading&nbsp;<b>]</b></span><h2>Related articles</h2></div><ul class="posts">
<?php while ($rel->have_posts()) { $rel->the_post(); $rd = rl_post_data(get_the_ID()); ?>
  <li class="post"><span class="m"><?php echo esc_html($rd['type_label']); ?> · <?php echo esc_html(get_the_date('j M Y')); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read: ' . get_the_title()); ?>">Read article &rarr;</a></li>
<?php } wp_reset_postdata(); ?>
</ul></div></section>
<?php } } ?>

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
<?php if ($n) { ?>
<script>
(function(){
  var art=document.querySelector('.rl-guide .g-text'); if(!art) return;
  var secs=[].slice.call(art.querySelectorAll('.g-ch')), links=[].slice.call(document.querySelectorAll('.rl-guide .g-rail li a'));
  var q=function(k){return document.querySelector('.rl-guide [data-g="'+k+'"]');}, n=secs.length, pad=function(i){return (i<10?'0':'')+i;};
  function up(){
    var r=art.getBoundingClientRect(), h=art.offsetHeight-innerHeight*0.6, p=Math.max(0,Math.min(1,(-r.top+innerHeight*0.25)/Math.max(h,1))), cur=0;
    secs.forEach(function(s,i){ if(s.getBoundingClientRect().top<innerHeight*0.35) cur=i; });
    links.forEach(function(a,i){ a.classList.toggle('on',i===cur); a.classList.toggle('done',i<cur); if(i===cur) a.setAttribute('aria-current','true'); else a.removeAttribute('aria-current'); });
    var pct=Math.round(p*100)+'%', f=q('fill'), l=links[cur];
    if(f&&l) f.style.height=(l.offsetTop+15)+'px';
    if(q('rpct')) q('rpct').textContent=pct; if(q('mpct')) q('mpct').textContent=pct+' read';
    if(q('mbar')) q('mbar').style.width=pct; if(q('mch')) q('mch').textContent='Chapter '+pad(cur+1)+' of '+pad(n);
  }
  addEventListener('scroll',up,{passive:true}); addEventListener('resize',up); up();
})();
</script>
<?php }
}

/* ---------- schema: glossary as a DefinedTermSet ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_guide_view()) return $graph;
    $id = get_queried_object_id(); $url = get_permalink($id);
    $gloss = rl_guide_rows(get_post_meta($id, 'rl_g_glossary', true), 2);
    if ($gloss) $graph[] = ['@type' => 'DefinedTermSet', '@id' => $url . '#glossary', 'name' => 'Glossary: ' . get_the_title($id), 'url' => $url . '#g-gl-h',
        'hasDefinedTerm' => array_map(function ($g) use ($url) { return ['@type' => 'DefinedTerm', 'name' => $g[0], 'description' => $g[1], 'url' => $url . '#term-' . sanitize_title($g[0])]; }, $gloss)];
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_guide_view()) return; ?>
<style id="rl-guide-css">
.rl-guide{color:var(--ink-dim)}
.rl-guide h1,.rl-guide h2,.rl-guide h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.02;letter-spacing:.005em;text-wrap:balance}
.rl-guide .g-cover{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(0,.85fr);gap:clamp(28px,5vw,64px);align-items:end;padding-block:clamp(26px,4vw,48px) clamp(34px,5vw,60px)}
.rl-guide .g-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px}
.rl-guide .g-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-guide .g-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-guide .g-h1{font-size:clamp(40px,6.4vw,84px);line-height:.95;margin:0}
.rl-guide .g-h1 em{font-style:normal;color:var(--red-3)}
.rl-guide .g-stand{font-size:clamp(17px,1.6vw,20px);line-height:1.55;max-width:640px;margin:22px 0 0}
.rl-guide .g-by{display:flex;flex-wrap:wrap;align-items:center;gap:12px 22px;margin-top:26px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-guide .g-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-guide .g-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-guide .g-by b{color:var(--ink-dim);font-weight:500}
.rl-guide .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-guide .g-plate{border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));box-shadow:0 40px 90px -60px var(--red-glow)}
.rl-guide .g-plate-top{display:grid;grid-template-columns:repeat(3,1fr);border-bottom:1px solid var(--line-2)}
.rl-guide .g-plate-top.two{grid-template-columns:repeat(2,1fr)}
.rl-guide .g-plate-top div{padding:16px 18px;border-right:1px solid var(--line)}
.rl-guide .g-plate-top div:last-child{border-right:0}
.rl-guide .g-plate-top b{display:block;font-family:var(--f-display);font-size:30px;font-weight:500;color:var(--ink);line-height:1}
.rl-guide .g-plate-top span{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-guide .g-plate ol{list-style:none;margin:0;padding:8px 0}
.rl-guide .g-plate li a{display:grid;grid-template-columns:44px 1fr auto;gap:8px;align-items:baseline;padding:9px 18px;text-decoration:none;color:var(--ink-dim);font-size:14.5px}
.rl-guide .g-plate li a:hover{background:rgba(255,255,255,.03);color:var(--ink)}
.rl-guide .g-plate .n{font-family:var(--f-mono);font-size:12px;color:var(--red-3)}
.rl-guide .g-plate .m{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint)}
.rl-guide .g-feat{margin-top:0;margin-bottom:clamp(34px,5vw,56px)}
.rl-guide .g-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-guide .g-paths-h{display:flex;align-items:center;gap:14px;margin-bottom:14px}
.rl-guide .g-paths-h span{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:var(--ink)}
.rl-guide .g-paths-h i{flex:1;height:1px;background:var(--line-2)}
.rl-guide .g-paths{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1px;background:var(--line-2);border:1px solid var(--line-2);margin-bottom:clamp(40px,6vw,72px)}
.rl-guide .g-path{background:var(--bg);padding:20px 22px;display:grid;gap:8px;text-decoration:none;transition:background .2s}
.rl-guide .g-path:hover{background:var(--panel)}
.rl-guide .g-path .w{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-guide .g-path .t{font-family:var(--f-display);font-size:21px;text-transform:uppercase;color:var(--ink);line-height:1.1}
.rl-guide .g-path .go{font-family:var(--f-mono);font-size:12px;color:var(--red-3)}
.rl-guide .g-book{display:grid;grid-template-columns:250px minmax(0,1fr);gap:clamp(32px,5vw,72px);align-items:start;padding-bottom:40px}
.rl-guide .g-book.norail{grid-template-columns:minmax(0,1fr)}
.rl-guide .g-rail{position:sticky;top:110px}
.rl-guide .g-rail .lbl{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-faint);display:flex;justify-content:space-between;margin-bottom:12px}
.rl-guide .g-rail ol{list-style:none;margin:0;padding:0;position:relative}
.rl-guide .g-rail ol::before{content:"";position:absolute;left:15px;top:6px;bottom:6px;width:1px;background:var(--line-2)}
.rl-guide .g-rail .fill{position:absolute;left:15px;top:6px;width:1px;background:var(--red-3);height:0;transition:height .15s linear}
.rl-guide .g-rail li a{position:relative;display:grid;grid-template-columns:32px 1fr;gap:10px;padding:8px 0;text-decoration:none;color:var(--ink-faint);font-size:14px;line-height:1.35}
.rl-guide .g-rail .d{width:31px;height:31px;display:grid;place-items:center;font-family:var(--f-mono);font-size:11px;border:1px solid var(--line-2);background:var(--bg);position:relative;z-index:1}
.rl-guide .g-rail li a.on{color:var(--ink)}
.rl-guide .g-rail li a.on .d,.rl-guide .g-rail li a.done .d{border-color:var(--red-2);color:#fff;background:var(--red)}
.rl-guide .g-rail li a.done{color:var(--ink-dim)}
.rl-guide .g-rail .pct{margin-top:16px;font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-guide .g-text{max-width:740px;min-width:0}
.rl-guide .g-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:24px 26px;margin-bottom:22px}
.rl-guide .g-answer .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 10px}
.rl-guide .g-answer p{margin:0;font-size:19px;line-height:1.6;color:var(--ink)}
.rl-guide .g-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:56px}
.rl-guide .g-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-guide .g-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-guide .g-ch{margin-top:64px;padding-block:0}
.rl-guide .g-ch:first-of-type{margin-top:0}
.rl-guide .g-intro + .g-ch{margin-top:48px}
.rl-guide .g-open{display:grid;grid-template-columns:auto minmax(0,1fr);gap:22px;align-items:end;border-bottom:1px solid var(--line-2);padding-bottom:20px;margin-bottom:26px}
.rl-guide .g-num{font-family:var(--f-display);font-weight:700;font-size:clamp(72px,9vw,118px);line-height:.78;color:transparent;-webkit-text-stroke:1.5px var(--red-3)}
.rl-guide .g-meta{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 10px}
.rl-guide .g-open h2{font-size:clamp(28px,3.4vw,40px);margin:0;scroll-margin-top:110px}
.rl-guide .g-prose>*{margin:0 0 1.15em}
.rl-guide .g-prose p,.rl-guide .g-prose li{font-size:17.5px;line-height:1.78}
.rl-guide .g-prose h3{font-size:22px;margin:1.6em 0 .55em;scroll-margin-top:110px}
.rl-guide .g-prose h4{color:var(--ink);font-size:18px;margin:1.4em 0 .4em}
.rl-guide .g-prose strong{color:var(--ink);font-weight:600}
.rl-guide .g-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-guide .g-prose a[href^="#term-"]{border-bottom:1px dotted var(--red-3)}
.rl-guide .g-prose ul,.rl-guide .g-prose ol{padding-left:1.2em}
.rl-guide .g-prose li{margin:.4em 0}
.rl-guide .g-prose li::marker{color:var(--red-3)}
.rl-guide .g-prose blockquote{margin:30px 0;padding:0 0 0 22px;border-left:2px solid var(--red-2);font-family:var(--f-display);font-size:clamp(22px,2.4vw,28px);line-height:1.2;text-transform:uppercase;color:var(--ink)}
.rl-guide .g-prose blockquote p{font-size:inherit;line-height:inherit;margin:0}
.rl-guide .g-prose blockquote cite{display:block;margin-top:10px;font-family:var(--f-mono);font-size:12px;text-transform:none;color:var(--ink-faint);font-style:normal}
.rl-guide .g-prose .tip{border:1px solid var(--line-2);background:var(--panel);padding:16px 18px 16px 70px;position:relative;font-size:15.5px}
.rl-guide .g-prose .tip::before{content:"Tip";position:absolute;left:18px;top:18px;font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-guide .g-prose figure{margin:30px 0;border:1px solid var(--line-2);background:var(--bg-2);padding:20px}
.rl-guide .g-prose figure img{display:block;width:100%;height:auto}
.rl-guide .g-prose figcaption{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);margin-top:12px}
.rl-guide .g-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-guide .g-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-guide .g-prose th,.rl-guide .g-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-guide .g-prose th{color:var(--ink);background:var(--panel)}
.rl-guide .g-end{margin-top:26px;border:1px dashed var(--line-2);padding:14px 18px;display:flex;flex-wrap:wrap;justify-content:space-between;gap:10px;align-items:center}
.rl-guide .g-end span{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-guide .g-end a{font-family:var(--f-display);font-size:15px;text-transform:uppercase;letter-spacing:.04em;text-decoration:none;color:var(--ink)}
.rl-guide .g-end a i{color:var(--red-3);font-style:normal}
.rl-guide .g-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:48px 0 8px;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-guide .g-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-guide .g-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,23px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-guide .g-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-guide .g-icta .act{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-guide .g-icta .go{display:inline-flex;align-items:center;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-guide .g-icta .go:hover{background:var(--red-2)}
.rl-guide .g-icta .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-guide .g-icta .alt:hover{color:var(--ink)}
.rl-guide .g-back{border-top:1px solid var(--line-2);padding-block:56px 20px;margin-top:40px}
.rl-guide .g-back-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 16px;margin-bottom:22px}
.rl-guide .g-back-h span{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3)}
.rl-guide .g-back-h h2{font-size:clamp(26px,3vw,36px);margin:0}
.rl-guide .g-gloss{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1px;background:var(--line);border:1px solid var(--line);margin:0}
.rl-guide .g-gloss .gl{background:var(--bg-2);padding:18px 20px;display:grid;grid-template-columns:34px 1fr;gap:12px;scroll-margin-top:110px}
.rl-guide .g-gloss .l{font-family:var(--f-display);font-size:30px;color:var(--red-3);line-height:1}
.rl-guide .g-gloss dt{font-family:var(--f-display);text-transform:uppercase;font-size:17px;color:var(--ink);margin-bottom:4px}
.rl-guide .g-gloss dd{margin:0;font-size:14.5px}
.rl-guide .g-hub{display:grid;grid-template-columns:minmax(0,.8fr) minmax(0,1.2fr);border:1px solid var(--line-2)}
.rl-guide .g-hub .core{background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:28px;border-right:1px solid var(--line-2);display:grid;align-content:center;gap:10px}
.rl-guide .g-hub .core span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-guide .g-hub .core b{font-family:var(--f-display);font-size:26px;text-transform:uppercase;color:var(--ink);line-height:1.05;font-weight:600}
.rl-guide .g-hub ul{list-style:none;margin:0;padding:0}
.rl-guide .g-hub li a{display:grid;grid-template-columns:110px 1fr 20px;gap:14px;align-items:center;padding:16px 20px;border-bottom:1px solid var(--line);text-decoration:none;color:var(--ink)}
.rl-guide .g-hub li:last-child a{border-bottom:0}
.rl-guide .g-hub li a:hover{background:rgba(255,255,255,.03)}
.rl-guide .g-hub .ty{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-guide .g-hub .ar{color:var(--ink-faint)}
.rl-guide .g-two{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-guide .g-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-guide .g-src li{padding:6px 0;color:var(--ink-faint)}
.rl-guide .g-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-guide .g-author{display:grid;grid-template-columns:84px 1fr;gap:20px;border:1px solid var(--line-2);background:var(--panel);padding:24px;margin:40px 0 56px}
.rl-guide .g-author .av{width:84px;height:84px;font-size:32px}
.rl-guide .g-author .nm{font-family:var(--f-display);font-size:24px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-guide .g-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 10px}
.rl-guide .g-author p{margin:0 0 10px;font-size:15px}
.rl-guide .g-author .links{display:flex;gap:18px;font-size:14px}
.rl-guide .g-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-guide .g-mbar{display:none}
.rl-guide .rel .posts{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--line);border:1px solid var(--line)}
.rl-guide .rel .post{background:var(--bg-2);padding:22px;display:flex;flex-direction:column;gap:10px}
@media(max-width:1000px){
  .rl-guide .g-cover{grid-template-columns:1fr}
  .rl-guide .g-book{grid-template-columns:1fr}
  .rl-guide .g-rail{display:none}
  .rl-guide .g-mbar{display:block;position:sticky;top:64px;z-index:5;background:rgba(18,16,17,.95);backdrop-filter:blur(10px);border-bottom:1px solid var(--line-2);margin-inline:calc(var(--gutter) * -1);padding:10px var(--gutter) 0;margin-bottom:22px}
  .rl-guide .g-mbar .row{display:flex;justify-content:space-between;gap:10px;font-family:var(--f-mono);font-size:11.5px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink);padding-bottom:9px}
  .rl-guide .g-mbar .row span:last-child{color:var(--ink-faint)}
  .rl-guide .g-mbar .bar{height:2px;background:var(--line-2)}
  .rl-guide .g-mbar .bar i{display:block;height:100%;width:0;background:var(--red-3)}
  .rl-guide .rel .posts{grid-template-columns:1fr 1fr}
}
@media(max-width:700px){
  .rl-guide .g-take,.rl-guide .g-gloss,.rl-guide .g-two,.rl-guide .g-hub,.rl-guide .rel .posts{grid-template-columns:1fr}
  .rl-guide .g-hub .core{border-right:0;border-bottom:1px solid var(--line-2)}
  .rl-guide .g-hub li a{grid-template-columns:1fr 20px}.rl-guide .g-hub .ty{grid-column:1/-1}
  .rl-guide .g-plate-top b{font-size:24px}
  .rl-guide .g-open{grid-template-columns:1fr;gap:10px}
  .rl-guide .g-num{font-size:64px}
  .rl-guide .g-prose p,.rl-guide .g-prose li{font-size:16.5px}
  .rl-guide .g-icta{grid-template-columns:1fr;padding-left:16px}.rl-guide .g-icta .act{padding-right:16px}
  .rl-guide .g-author{grid-template-columns:1fr}
}
@media(prefers-reduced-motion:reduce){.rl-guide .g-rail .fill{transition:none}}
</style>
<?php }, 24);
