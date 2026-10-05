<?php
/**
 * Plugin Name: Reinforce Lab - Explainer post design
 * Description: The approved Explainer design (D-077, mockup claude/design-previews/blog-explainer-template-mockup.html). Reference entry: headword header, quotable definition with copy button, key facts info box, three levels (10 seconds, 1 minute, in depth), how it works flow, what it is and is not, before and after example, one in-article service CTA, related terms map, cite this page, FAQs and sources, author box. reinforce-post.php hands Explainer posts to rl_explainer_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_explainer_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'explainer'; }

/* ---------- fields (Explainer only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'explainer']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_explainer', 'title' => 'Explainer (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_e_question', 'Search question', 'text', ['instructions' => 'Shown small above the term, e.g. What is generative engine optimization?']),
            $f('rl_e_term', 'Term', 'text', ['instructions' => 'The exact term, set large. Example: Generative Engine Optimization']),
            $f('rl_e_abbr', 'Abbreviation', 'text', ['instructions' => 'Optional, e.g. GEO']),
            $f('rl_e_pos', 'Word type', 'text', ['default_value' => 'noun']),
            $f('rl_e_aka', 'Also called', 'text', ['instructions' => 'Other names, separated by commas.']),
            $f('rl_e_field', 'Field', 'text', ['instructions' => 'e.g. Search marketing']),
            $f('rl_e_definition', 'Definition', 'textarea', ['rows' => 3, 'instructions' => 'One or two sentences, written to be quoted. Start with the term.']),
            $f('rl_e_def_note', 'Where the definition comes from', 'text', ['instructions' => 'e.g. Reinforce Lab definition. The term comes from a 2023 research paper by Aggarwal and others.']),
            $f('rl_e_facts', 'Key facts', 'textarea', ['rows' => 5, 'instructions' => 'One per line: Label | Value | URL (URL optional). Example: Builds on | SEO | /services/best-search-engine-optimization-services/']),
            $f('rl_e_tensec', 'In 10 seconds', 'text', ['instructions' => 'One or two short sentences.']),
            $f('rl_e_onemin', 'In 1 minute', 'textarea', ['rows' => 3]),
            $f('rl_e_steps', 'How it works', 'textarea', ['rows' => 5, 'instructions' => 'Up to 5, one per line: Step | What happens']),
            $f('rl_e_is', 'It is', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_e_isnot', 'It is not', 'textarea', ['rows' => 3, 'instructions' => 'One per line.']),
            $f('rl_e_ex_label', 'Example: what it shows', 'text', ['instructions' => 'e.g. Service page, opening paragraph']),
            $f('rl_e_ex_before', 'Example: before', 'textarea', ['rows' => 2, 'instructions' => 'Note | Text. Example: Vague opening | We are passionate about results.']),
            $f('rl_e_ex_after', 'Example: after', 'textarea', ['rows' => 2, 'instructions' => 'Note | Text']),
            $f('rl_e_related', 'Related terms', 'textarea', ['rows' => 4, 'instructions' => 'Up to 4, one per line: Term | One line | Relation (e.g. Foundation, Overlaps) | URL (optional)']),
            $f('rl_e_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'Shown after the example. Leave empty for none.']),
            $f('rl_e_cta_head', 'In-article CTA: headline', 'text'),
            $f('rl_e_cta_sub', 'In-article CTA: one line', 'text'),
            $f('rl_e_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
        ],
    ]);
});

/* ---------- data ---------- */
function rl_explainer_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
function rl_explainer_data($id) {
    static $cache = [];
    if (isset($cache[$id])) return $cache[$id];
    $m = function ($k) use ($id) { return trim((string) get_post_meta($id, $k, true)); };
    $ex = function ($k) use ($m) { $v = $m($k); if ($v === '') return null; $p = array_map('trim', explode('|', $v, 2)); return count($p) === 2 ? ['note' => $p[0], 'text' => $p[1]] : ['note' => '', 'text' => $p[0]]; };
    return $cache[$id] = [
        'question' => $m('rl_e_question'), 'term' => $m('rl_e_term'), 'abbr' => $m('rl_e_abbr'), 'pos' => $m('rl_e_pos'),
        'aka' => array_values(array_filter(array_map('trim', explode(',', $m('rl_e_aka'))))), 'field' => $m('rl_e_field'),
        'def' => $m('rl_e_definition'), 'def_note' => $m('rl_e_def_note'), 'facts' => rl_explainer_rows(get_post_meta($id, 'rl_e_facts', true), 2),
        'ten' => $m('rl_e_tensec'), 'one' => $m('rl_e_onemin'), 'steps' => array_slice(rl_explainer_rows(get_post_meta($id, 'rl_e_steps', true), 1), 0, 5),
        'is' => rl_post_lines(get_post_meta($id, 'rl_e_is', true)), 'isnot' => rl_post_lines(get_post_meta($id, 'rl_e_isnot', true)),
        'ex_label' => $m('rl_e_ex_label'), 'before' => $ex('rl_e_ex_before'), 'after' => $ex('rl_e_ex_after'),
        'related' => array_slice(rl_explainer_rows(get_post_meta($id, 'rl_e_related', true), 1), 0, 4),
    ];
}
function rl_explainer_url($u) { $u = trim((string) $u); if ($u === '') return ''; return strpos($u, '/') === 0 ? home_url($u) : esc_url_raw($u); }

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_explainer_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    $x = rl_explainer_data($id);
    $title = get_the_title($id);
    $term = $x['term'] !== '' ? $x['term'] : $title;
    $short = $x['abbr'] !== '' ? $x['abbr'] : $term;
    $cta = null; $svc = (string) get_post_meta($id, 'rl_e_cta_service', true); $head = trim((string) get_post_meta($id, 'rl_e_cta_head', true));
    if ($svc !== '' && $head !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) {
        $cta = ['name' => rl_pt_services()[$svc], 'url' => $u($svc), 'head' => $head, 'sub' => trim((string) get_post_meta($id, 'rl_e_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_e_cta_button', true)) ?: 'See how it works'];
    }
    $diag = $u('search-authority-diagnostic');
    $ok = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5l3 3 7-7"/></svg>';
    $no = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M4 4l8 8M12 4l-8 8"/></svg>';
    $cp = '<svg class="ic" viewBox="0 0 16 16" aria-hidden="true"><path d="M5 5h8v8H5zM3 11V3h8"/></svg>';
    $toc = [];
    if ($x['steps']) $toc['how'] = 'How it works';
    foreach ($c['toc'] as $t) $toc[$t[0]] = $t[1];
    if ($x['is'] || $x['isnot']) $toc['isnot'] = 'What it is and is not';
    if ($x['before'] || $x['after']) $toc['example'] = 'Example';
    if ($x['related']) $toc['related'] = 'Related terms';
    $levels = $x['ten'] !== '' || $x['one'] !== '';
    $cite = 'Reinforce Lab (' . get_the_date('Y', $id) . '). ' . $title . ' ' . get_permalink($id);
    ?>
<div class="rl-page rl-post rl-exp">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<header class="wrap e-entry">
  <div class="e-kicker"><span class="e-kind">Explainer</span><?php if ($c['cat']) echo '<a class="e-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
  <?php if ($x['question'] !== '') { ?><p class="e-q"><?php echo esc_html($x['question']); ?></p><?php } ?>
  <div class="e-head"><h1 class="e-term"><?php echo esc_html($term); ?><?php if ($x['abbr'] !== '') echo ' <span class="e-abbr">(' . esc_html($x['abbr']) . ')</span>'; ?></h1></div>
  <?php if ($x['pos'] !== '' || $x['aka'] || $x['field'] !== '') { ?>
  <p class="e-gram"><?php if ($x['pos'] !== '') echo '<span><i>' . esc_html($x['pos']) . '</i></span>'; ?><?php if ($x['aka']) echo '<span>Also called ' . implode(', ', array_map(function ($a) { return '<b>' . esc_html($a) . '</b>'; }, $x['aka'])) . '</span>'; ?><?php if ($x['field'] !== '') echo '<span>Field <b>' . esc_html($x['field']) . '</b></span>'; ?></p>
  <?php } ?>
  <div class="e-by">
    <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
    <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
    <?php if ($d['updated'] !== '') { ?><span class="fresh">Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
  </div>
  <?php if ($x['def'] !== '') { ?>
  <div class="e-def">
    <p class="lb">Definition</p>
    <blockquote id="rl-def"><?php echo preg_replace('/^(' . preg_quote(esc_html($term), '/') . '(\s*\(' . preg_quote(esc_html($x['abbr']), '/') . '\))?)/i', '<b>$1</b>', esc_html($x['def']), 1); ?></blockquote>
    <button class="copy" type="button" data-copy="rl-def"><?php echo $cp; ?><span>Copy definition</span></button>
    <?php if ($x['def_note'] !== '') { ?><p class="src"><?php echo esc_html($x['def_note']); ?></p><?php } ?>
  </div>
  <?php } ?>
</header>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap e-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<div class="wrap">
  <div class="e-main<?php echo ($x['facts'] || $toc) ? '' : ' noinfo'; ?>">
    <article class="e-text">
      <?php if ($d['answer'] !== '') { ?><div class="e-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
      <?php if ($d['takeaways']) { ?><div class="e-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . sprintf('%02d', $i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>

      <?php if ($levels) { ?>
      <div class="sec-h"><span>Three levels</span><h2><?php echo esc_html($short); ?> explained</h2></div>
      <div class="depth">
        <?php if ($x['ten'] !== '') { ?><div class="lv"><div class="tag"><b>10 sec</b><span>The idea</span><span class="meter" aria-hidden="true"><i class="on"></i><i></i><i></i></span></div><div class="tx"><p><?php echo esc_html($x['ten']); ?></p></div></div><?php } ?>
        <?php if ($x['one'] !== '') { ?><div class="lv"><div class="tag"><b>1 min</b><span>The basics</span><span class="meter" aria-hidden="true"><i class="on"></i><i class="on"></i><i></i></span></div><div class="tx"><?php echo wpautop(esc_html($x['one'])); ?></div></div><?php } ?>
        <div class="lv deep"><div class="tag"><b>In depth</b><span>The full article</span><span class="meter" aria-hidden="true"><i class="on"></i><i class="on"></i><i class="on"></i></span></div><div class="tx"><p>The sections below go into the detail. <a href="#<?php echo esc_attr(array_key_first($toc) ?: 'faq'); ?>">Read on &darr;</a></p></div></div>
      </div>
      <?php } ?>

      <?php if ($x['steps']) { ?>
      <div class="sec-h" id="how"><span>How it works</span><h2>How <?php echo esc_html($short); ?> works</h2></div>
      <ol class="flow n<?php echo count($x['steps']); ?>"><?php foreach ($x['steps'] as $k => $s) echo '<li class="fs"><span class="n">' . sprintf('%02d', $k + 1) . '</span><h3>' . esc_html($s[0]) . '</h3>' . (!empty($s[1]) ? '<p>' . esc_html($s[1]) . '</p>' : '') . '</li>'; ?></ol>
      <?php } ?>

      <?php if (trim($c['body']) !== '') echo '<div class="e-prose">' . $c['body'] . '</div>'; ?>

      <?php if ($x['is'] || $x['isnot']) { ?>
      <div class="sec-h" id="isnot"><span>Clearing it up</span><h2>What <?php echo esc_html($short); ?> is and is not</h2></div>
      <div class="isnot<?php echo ($x['is'] && $x['isnot']) ? '' : ' one'; ?>">
        <?php if ($x['is']) { ?><div class="is"><p class="h"><?php echo $ok . esc_html($short); ?> is</p><ul><?php foreach ($x['is'] as $i) echo '<li>' . $ok . '<span>' . esc_html($i) . '</span></li>'; ?></ul></div><?php } ?>
        <?php if ($x['isnot']) { ?><div class="not"><p class="h"><?php echo $no . esc_html($short); ?> is not</p><ul><?php foreach ($x['isnot'] as $i) echo '<li>' . $no . '<span>' . esc_html($i) . '</span></li>'; ?></ul></div><?php } ?>
      </div>
      <?php } ?>

      <?php if ($x['before'] || $x['after']) { ?>
      <div class="sec-h" id="example"><span>Example</span><h2><?php echo esc_html($short); ?> in practice</h2></div>
      <div class="ex">
        <div class="eh"><span><?php echo esc_html($x['ex_label']); ?></span><b><?php echo ($x['before'] && $x['after']) ? 'Before and after' : 'Example'; ?></b></div>
        <div class="ba<?php echo ($x['before'] && $x['after']) ? '' : ' one'; ?>">
          <?php foreach (['before' => 'Before', 'after' => 'After'] as $k => $l) { if (!$x[$k]) continue; ?>
          <div class="<?php echo $k; ?>"><p class="l"><?php echo $l; ?></p><?php if ($x[$k]['note'] !== '') echo '<p>' . esc_html($x[$k]['note']) . '</p>'; ?><q><?php echo esc_html($x[$k]['text']); ?></q></div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>

      <?php if ($cta) { ?>
      <aside class="e-icta" aria-label="Reinforce Lab service">
        <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
        <div class="cact"><a class="go2" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
      </aside>
      <?php } ?>

      <?php if ($x['related']) { $pos = ['l1', 'r1', 'l2', 'r2']; ?>
      <div class="sec-h" id="related"><span>Related terms</span><h2>Where <?php echo esc_html($short); ?> sits</h2></div>
      <div class="map n<?php echo count($x['related']); ?>">
        <?php foreach ($x['related'] as $k => $r) { $ru = rl_explainer_url($r[3] ?? ''); $tag = $ru ? 'a' : 'div';
            echo '<' . $tag . ' class="rt ' . $pos[$k] . '"' . ($ru ? ' href="' . esc_url($ru) . '"' : '') . '>' . (!empty($r[2]) ? '<span class="k">' . esc_html($r[2]) . '</span>' : '') . '<b>' . esc_html($r[0]) . '</b>' . (!empty($r[1]) ? '<span>' . esc_html($r[1]) . '</span>' : '') . '</' . $tag . '>'; } ?>
        <div class="core"><?php echo esc_html($short); ?><small>This entry</small></div>
      </div>
      <?php } ?>

      <div class="cite"><p class="lb">Cite this page</p><code id="rl-cite"><?php echo esc_html($cite); ?></code><button class="copy" type="button" data-copy="rl-cite"><?php echo $cp; ?><span>Copy</span></button></div>
    </article>

    <?php if ($x['facts'] || $toc) { ?>
    <aside class="e-info" aria-label="Key facts">
      <div class="ih"><b><?php echo esc_html($short); ?></b><span>Key facts</span></div>
      <?php if ($x['facts']) { ?><dl><?php foreach ($x['facts'] as $f) { $fu = rl_explainer_url($f[2] ?? ''); echo '<div><dt>' . esc_html($f[0]) . '</dt><dd>' . ($fu ? '<a href="' . esc_url($fu) . '">' . esc_html($f[1]) . '</a>' : esc_html($f[1])) . '</dd></div>'; } ?></dl><?php } ?>
      <?php if ($toc) { ?><nav class="toc" aria-label="On this page"><p>On this page</p><ol><?php foreach ($toc as $a => $l) echo '<li><a href="#' . esc_attr($a) . '">' . esc_html($l) . '</a></li>'; ?></ol></nav><?php } ?>
    </aside>
    <?php } ?>
  </div>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <div class="e-back">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="sec-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="e-src" id="sources"><div class="sec-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </div>
  <?php } ?>

  <aside class="e-author" aria-label="About the author">
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
<section class="band alt rel" id="related-articles"><div class="wrap"><div class="head"><span class="ey"><b>[</b>&nbsp;Keep reading&nbsp;<b>]</b></span><h2>Related articles</h2></div><ul class="posts">
<?php while ($rq->have_posts()) { $rq->the_post(); $rd = rl_post_data(get_the_ID()); ?>
  <li class="post"><span class="m"><?php echo esc_html($rd['type_label']); ?> · <?php echo esc_html(get_the_date('j M Y')); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read: ' . get_the_title()); ?>">Read article &rarr;</a></li>
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
<script>
(function(){
  [].slice.call(document.querySelectorAll('.rl-exp [data-copy]')).forEach(function(b){
    b.addEventListener('click',function(){
      var t=document.getElementById(b.getAttribute('data-copy')); if(!t) return;
      var lab=b.querySelector('span'), old=lab.textContent, txt=t.textContent.trim();
      function done(m){ lab.textContent=m; setTimeout(function(){lab.textContent=old;},1600); }
      function sel(){ try{ var r=document.createRange(); r.selectNodeContents(t); var s=getSelection(); s.removeAllRanges(); s.addRange(r); }catch(e){} }
      if(navigator.clipboard&&navigator.clipboard.writeText){ navigator.clipboard.writeText(txt).then(function(){done('Copied');},function(){sel();done('Selected');}); } else { sel(); done('Selected'); }
    });
  });
})();
</script>
<?php
}

/* ---------- schema: the term as a DefinedTerm, and the article is about it ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_explainer_view()) return $graph;
    $id = get_queried_object_id(); $x = rl_explainer_data($id);
    if ($x['term'] === '' || $x['def'] === '') return $graph;
    $url = get_permalink($id);
    $node = ['@type' => 'DefinedTerm', '@id' => $url . '#term', 'name' => $x['term'], 'description' => $x['def'], 'url' => $url];
    $alt = $x['aka']; if ($x['abbr'] !== '') array_unshift($alt, $x['abbr']);
    if ($alt) $node['alternateName'] = $alt;
    foreach ($graph as &$n) {
        if (is_array($n) && !empty($n['@type']) && in_array('Article', (array) $n['@type'], true)) $n['about'] = ['@id' => $url . '#term'];
    }
    unset($n);
    $graph[] = $node;
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_explainer_view()) return; ?>
<style id="rl-explainer-css">
.rl-exp{color:var(--ink-dim);--ok:#3fa36b}
.rl-exp h1,.rl-exp h2,.rl-exp h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-exp .ic{width:14px;height:14px;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:square}
.rl-exp .e-entry{padding-block:clamp(24px,4vw,40px) 0}
.rl-exp .e-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:22px}
.rl-exp .e-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-exp .e-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-exp .e-q{font-family:var(--f-mono);font-size:13px;letter-spacing:.06em;color:var(--ink-faint);margin:0 0 8px}
.rl-exp .e-term{font-size:clamp(46px,8vw,112px);line-height:.9;letter-spacing:-.005em;margin:0;overflow-wrap:anywhere}
.rl-exp .e-abbr{font-size:.42em;color:var(--red-3);font-weight:500;white-space:nowrap}
.rl-exp .e-gram{display:flex;flex-wrap:wrap;gap:8px 18px;margin:16px 0 0;font-family:var(--f-mono);font-size:12.5px;color:var(--ink-faint)}
.rl-exp .e-gram i{font-style:italic;color:var(--ink-dim)}
.rl-exp .e-gram b{color:var(--ink);font-weight:500}
.rl-exp .e-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:18px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-exp .e-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-exp .e-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-exp .e-by b{color:var(--ink-dim);font-weight:500}
.rl-exp .e-by .fresh,.rl-exp .e-by .fresh b{color:var(--ok)}
.rl-exp .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-exp .e-def{margin-top:28px;border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));display:grid;grid-template-columns:minmax(0,1fr) auto;gap:12px 28px;align-items:start;padding:26px 28px}
.rl-exp .e-def .lb{grid-column:1/-1;font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0}
.rl-exp .e-def blockquote{margin:0;padding:0;border:0;color:var(--ink);font-family:var(--f-body);text-transform:none;font-size:clamp(19px,2vw,24px);line-height:1.5;max-width:880px}
.rl-exp .e-def blockquote b{font-weight:600}
.rl-exp .e-def .src{grid-column:1/-1;font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);margin:0}
.rl-exp .copy{display:inline-flex;align-items:center;gap:8px;font-family:var(--f-mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink);background:var(--bg-2);border:1px solid var(--line-2);border-radius:0;padding:9px 12px;cursor:pointer;white-space:nowrap}
.rl-exp .copy:hover{border-color:var(--red-line)}
.rl-exp .copy .ic{stroke-width:1.6}
.rl-exp .e-feat{margin:28px auto 0}
.rl-exp .e-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-exp .e-main{display:grid;grid-template-columns:minmax(0,760px) minmax(0,1fr);gap:clamp(30px,5vw,64px);padding-block:clamp(36px,5vw,52px) 10px;align-items:start}
.rl-exp .e-main.noinfo{grid-template-columns:minmax(0,760px)}
.rl-exp .e-text{min-width:0}
.rl-exp .e-text>.sec-h:first-child,.rl-exp .e-answer + .sec-h,.rl-exp .e-take + .sec-h{margin-top:0}
.rl-exp .e-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:28px}
.rl-exp .e-answer .t,.rl-exp .sec-h span{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-exp .e-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-exp .e-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:28px}
.rl-exp .e-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-exp .e-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-exp .sec-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin:46px 0 16px;scroll-margin-top:96px}
.rl-exp .sec-h h2{font-size:clamp(24px,2.8vw,30px);margin:0}
.rl-exp .e-prose{margin-top:30px}
.rl-exp .e-prose>*{margin:0 0 1.1em}
.rl-exp .e-prose p,.rl-exp .e-prose li{font-size:17.5px;line-height:1.75}
.rl-exp .e-prose h2{font-size:clamp(24px,2.8vw,30px);margin:1.8em 0 .6em;scroll-margin-top:96px}
.rl-exp .e-prose h2:first-child{margin-top:46px}
.rl-exp .e-prose h3{font-size:21px;margin:1.4em 0 .5em;scroll-margin-top:96px}
.rl-exp .e-prose strong{color:var(--ink);font-weight:600}
.rl-exp .e-prose a{color:var(--ink);border-bottom:1px dotted var(--red-3);text-decoration:none}
.rl-exp .e-prose ul,.rl-exp .e-prose ol{padding-left:1.2em}
.rl-exp .e-prose li::marker{color:var(--red-3)}
.rl-exp .e-prose figure{margin:22px 0}
.rl-exp .e-prose figure img{display:block;width:100%;height:auto;border:1px solid var(--line-2)}
.rl-exp .e-prose figcaption{text-align:left;font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);margin-top:8px}
.rl-exp .e-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-exp .e-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-exp .e-prose th,.rl-exp .e-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-exp .depth{border:1px solid var(--line-2)}
.rl-exp .lv{display:grid;grid-template-columns:150px minmax(0,1fr);border-top:1px solid var(--line-2)}
.rl-exp .lv:first-child{border-top:0}
.rl-exp .lv .tag{padding:18px;background:var(--bg-2);border-right:1px solid var(--line-2);display:grid;align-content:start;gap:6px}
.rl-exp .lv .tag b{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);font-weight:500;line-height:1}
.rl-exp .lv .tag span{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-exp .lv .tx{padding:18px 22px;font-size:16.5px;line-height:1.7;color:var(--ink);min-width:0}
.rl-exp .lv .tx p{margin:0 0 .8em}
.rl-exp .lv .tx p:last-child{margin:0}
.rl-exp .lv.deep .tx{color:var(--ink-dim)}
.rl-exp .lv.deep .tx a{color:var(--ink);font-family:var(--f-mono);font-size:12px;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-exp .meter{display:flex;gap:3px;margin-top:4px}
.rl-exp .meter i{width:14px;height:4px;background:var(--line-2)}
.rl-exp .meter i.on{background:var(--red-3)}
.rl-exp .flow{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,minmax(0,1fr))}
.rl-exp .flow.n1{grid-template-columns:minmax(0,1fr)}
.rl-exp .flow.n2{grid-template-columns:repeat(2,minmax(0,1fr))}
.rl-exp .flow.n3{grid-template-columns:repeat(3,minmax(0,1fr))}
.rl-exp .flow.n5{grid-template-columns:repeat(5,minmax(0,1fr))}
.rl-exp .fs{position:relative;border:1px solid var(--line-2);background:var(--panel);padding:18px 16px;margin:0 22px 0 0;min-width:0}
.rl-exp .fs:last-child{margin-right:0}
.rl-exp .fs:not(:last-child)::after{content:"";position:absolute;right:-22px;top:50%;width:22px;height:1px;background:var(--red-3)}
.rl-exp .fs:not(:last-child)::before{content:"";position:absolute;right:-22px;top:calc(50% - 4px);border:4px solid transparent;border-left-color:var(--red-3);border-right:0}
.rl-exp .fs .n{font-family:var(--f-mono);font-size:11px;color:var(--red-3)}
.rl-exp .fs h3{font-size:17px;margin:6px 0}
.rl-exp .fs p{margin:0;font-size:14px}
.rl-exp .isnot{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line-2);border:1px solid var(--line-2)}
.rl-exp .isnot.one{grid-template-columns:minmax(0,1fr)}
.rl-exp .isnot>div{background:var(--panel);padding:18px 20px}
.rl-exp .isnot .h{display:flex;align-items:center;gap:8px;font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;margin:0 0 8px}
.rl-exp .is .h{color:var(--ok)}
.rl-exp .not .h{color:var(--red-3)}
.rl-exp .isnot ul{list-style:none;margin:0;padding:0}
.rl-exp .isnot li{display:grid;grid-template-columns:18px 1fr;gap:8px;padding:8px 0;margin:0;border-top:1px solid var(--line);font-size:15px}
.rl-exp .isnot li:first-child{border-top:0}
.rl-exp .is .ic{color:var(--ok);margin-top:4px}
.rl-exp .not .ic{color:var(--red-3);margin-top:4px}
.rl-exp .ex{border:1px solid var(--line-2);background:var(--bg-2)}
.rl-exp .ex .eh{display:flex;justify-content:space-between;gap:12px;padding:12px 18px;border-bottom:1px dashed var(--line-2);font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-exp .ex .eh b{color:var(--red-3);font-weight:500}
.rl-exp .ex .ba{display:grid;grid-template-columns:1fr 1fr}
.rl-exp .ex .ba.one{grid-template-columns:minmax(0,1fr)}
.rl-exp .ex .ba>div{padding:18px 20px;min-width:0}
.rl-exp .ex .ba .after{border-left:1px solid var(--line-2);background:linear-gradient(180deg,rgba(63,163,107,.06),transparent)}
.rl-exp .ex .ba.one .after{border-left:0}
.rl-exp .ex .ba p{margin:0;font-size:15px}
.rl-exp .ex .ba p.l{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;margin:0 0 8px;color:var(--ink-faint)}
.rl-exp .ex .ba .after p.l{color:var(--ok)}
.rl-exp .ex .ba q{display:block;color:var(--ink);border-left:2px solid var(--line-2);padding-left:12px;margin-top:8px;quotes:none;font-size:15px}
.rl-exp .ex .ba .after q{border-left-color:var(--ok)}
.rl-exp .e-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:40px 0 0;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-exp .e-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-exp .e-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-exp .e-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-exp .cact{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-exp .go2{display:inline-flex;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-exp .go2:hover{background:var(--red-2)}
.rl-exp .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-exp .map{display:grid;grid-template-columns:minmax(0,1fr) auto minmax(0,1fr);gap:14px 0;align-items:center}
.rl-exp .map .core{grid-column:2;grid-row:1/3;border:2px solid var(--red-2);background:var(--red);color:#fff;font-family:var(--f-display);font-size:22px;text-transform:uppercase;padding:18px 22px;text-align:center;margin-inline:22px;position:relative;z-index:1}
.rl-exp .map.n1 .core,.rl-exp .map.n2 .core{grid-row:1}
.rl-exp .map .core small{display:block;font-family:var(--f-mono);font-size:10px;letter-spacing:.14em;opacity:.8}
.rl-exp .rt{border:1px solid var(--line-2);background:var(--panel);padding:14px 16px;text-decoration:none;display:grid;gap:4px;position:relative;min-width:0}
.rl-exp a.rt:hover{border-color:var(--red-line)}
.rl-exp .rt b{font-family:var(--f-display);font-size:17px;text-transform:uppercase;color:var(--ink);font-weight:500}
.rl-exp .rt span{font-size:13.5px;color:var(--ink-dim)}
.rl-exp .rt .k{font-family:var(--f-mono);font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-exp .map .l1{grid-column:1;grid-row:1}
.rl-exp .map .l2{grid-column:1;grid-row:2}
.rl-exp .map .r1{grid-column:3;grid-row:1}
.rl-exp .map .r2{grid-column:3;grid-row:2}
.rl-exp .map .l1::after,.rl-exp .map .l2::after{content:"";position:absolute;right:-22px;top:50%;width:22px;height:1px;background:var(--line-2)}
.rl-exp .map .r1::before,.rl-exp .map .r2::before{content:"";position:absolute;left:-22px;top:50%;width:22px;height:1px;background:var(--line-2)}
.rl-exp .cite{border:1px dashed var(--line-2);padding:16px 18px;margin-top:40px;display:grid;grid-template-columns:minmax(0,1fr) auto;gap:10px 18px;align-items:center}
.rl-exp .cite .lb{grid-column:1/-1;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin:0}
.rl-exp .cite code{font-family:var(--f-mono);font-size:13px;color:var(--ink);background:none;padding:0;word-break:break-word}
.rl-exp .e-info{position:sticky;top:96px;border:1px solid var(--line-2);background:var(--panel)}
.rl-exp .e-info .ih{display:flex;justify-content:space-between;align-items:baseline;gap:10px;padding:14px 18px;border-bottom:1px solid var(--line-2);background:var(--bg-2)}
.rl-exp .e-info .ih b{font-family:var(--f-display);font-size:20px;text-transform:uppercase;color:var(--ink);font-weight:600}
.rl-exp .e-info .ih span{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint)}
.rl-exp .e-info dl{margin:0;padding:4px 18px 8px}
.rl-exp .e-info dl div{display:grid;grid-template-columns:110px minmax(0,1fr);gap:12px;padding:10px 0;border-top:1px solid var(--line);font-size:14px}
.rl-exp .e-info dl div:first-child{border-top:0}
.rl-exp .e-info dt{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint);padding-top:3px}
.rl-exp .e-info dd{margin:0;color:var(--ink)}
.rl-exp .e-info dd a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-exp .e-info .toc{border-top:1px solid var(--line-2);padding:12px 18px 16px}
.rl-exp .e-info .toc p{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 8px}
.rl-exp .e-info .toc ol{margin:0;padding-left:1.3em;font-size:14px}
.rl-exp .e-info .toc li{padding:3px 0}
.rl-exp .e-info .toc a{color:var(--ink-dim);text-decoration:none}
.rl-exp .e-info .toc a:hover{color:var(--ink)}
.rl-exp .e-back{border-top:1px solid var(--line-2);margin-top:50px;padding-block:44px 10px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-exp .e-back .sec-h{margin-top:0}
.rl-exp .e-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-exp .e-src li{padding:6px 0;color:var(--ink-faint)}
.rl-exp .e-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-exp .e-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-exp .e-author .av{width:72px;height:72px;font-size:28px}
.rl-exp .e-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-exp .e-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-exp .e-author p{margin:0 0 8px;font-size:15px}
.rl-exp .e-author .links{display:flex;gap:18px;font-size:14px}
.rl-exp .e-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:1000px){
  .rl-exp .e-main{grid-template-columns:minmax(0,1fr)}
  .rl-exp .e-info{position:static;order:-1}
  .rl-exp .flow,.rl-exp .flow.n3,.rl-exp .flow.n5{grid-template-columns:repeat(2,minmax(0,1fr));gap:22px 0}
  .rl-exp .fs:nth-child(2n){margin-right:0}
  .rl-exp .fs:nth-child(2n)::after,.rl-exp .fs:nth-child(2n)::before{display:none}
}
@media(max-width:700px){
  .rl-exp .e-def{grid-template-columns:minmax(0,1fr);padding:20px 18px}
  .rl-exp .lv{grid-template-columns:minmax(0,1fr)}
  .rl-exp .lv .tag{border-right:0;border-bottom:1px solid var(--line-2);grid-auto-flow:column;justify-content:space-between;align-items:center}
  .rl-exp .flow,.rl-exp .flow.n2,.rl-exp .flow.n3,.rl-exp .flow.n5{grid-template-columns:minmax(0,1fr);gap:22px}
  .rl-exp .fs{margin-right:0}
  .rl-exp .fs::after{right:auto!important;left:24px;top:auto!important;bottom:-22px;width:1px!important;height:22px}
  .rl-exp .fs::before{right:auto!important;left:20px;top:auto!important;bottom:-22px;border:4px solid transparent!important;border-top-color:var(--red-3)!important;border-bottom:0!important}
  .rl-exp .fs:nth-child(2n)::after,.rl-exp .fs:nth-child(2n)::before{display:block}
  .rl-exp .fs:last-child::after,.rl-exp .fs:last-child::before{display:none}
  .rl-exp .isnot,.rl-exp .ex .ba,.rl-exp .e-back,.rl-exp .e-take{grid-template-columns:minmax(0,1fr)}
  .rl-exp .ex .ba .after{border-left:0;border-top:1px solid var(--line-2)}
  .rl-exp .map{grid-template-columns:minmax(0,1fr);gap:8px}
  .rl-exp .map .core{grid-column:1;grid-row:1!important;margin:0 0 6px}
  .rl-exp .map .l1,.rl-exp .map .l2,.rl-exp .map .r1,.rl-exp .map .r2{grid-column:1;grid-row:auto}
  .rl-exp .map .rt::after,.rl-exp .map .rt::before{display:none}
  .rl-exp .e-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-exp .cact{padding-right:16px}
  .rl-exp .cite{grid-template-columns:minmax(0,1fr)}
  .rl-exp .cite .copy{justify-self:start}
  .rl-exp .e-author{grid-template-columns:1fr}
  .rl-exp .e-info dl div{grid-template-columns:100px minmax(0,1fr)}
  .rl-exp .e-prose p,.rl-exp .e-prose li{font-size:16.5px}
}
@media(prefers-reduced-motion:reduce){.rl-exp .go2{transition:none}}
</style>
<?php }, 24);
