<?php
/**
 * Plugin Name: Reinforce Lab - How-To post design
 * Description: The approved How-To design (D-077, mockup claude/design-previews/blog-howto-template-mockup.html). Workbench layout: job-ticket hero (time, level, cost, what you need, what you get), sticky step tracker, steps built from the H2s on a numbered track with "Why", "You should see" and "Mark step done", one in-article service CTA, side panel with progress, mistakes to avoid and troubleshooting, finish card, FAQs and sources, author box. reinforce-post.php hands How-To posts to rl_howto_render().
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_howto_view() { return function_exists('rl_is_post_view') && rl_is_post_view() && rl_post_data(get_queried_object_id())['type'] === 'howto'; }

/* ---------- fields (How-To only) ---------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    $show = [[['field' => 'field_rl_type', 'operator' => '==', 'value' => 'howto']]];
    $f = function ($key, $label, $type, $extra = []) use ($show) { return array_merge(['key' => 'field_' . $key, 'name' => $key, 'label' => $label, 'type' => $type, 'conditional_logic' => $show], $extra); };
    $services = function_exists('rl_pt_services') ? rl_pt_services() : [];
    acf_add_local_field_group([
        'key' => 'group_rl_howto', 'title' => 'How-To (Reinforce Lab)', 'position' => 'normal', 'menu_order' => 4,
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
        'fields' => [
            $f('rl_h_minutes', 'Time needed (minutes)', 'number', ['min' => 1, 'max' => 10000, 'instructions' => 'The whole job. Shown on the job ticket and in the HowTo schema.']),
            $f('rl_h_level', 'Level', 'select', ['choices' => ['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'], 'allow_null' => 1]),
            $f('rl_h_cost', 'Cost', 'text', ['instructions' => 'Short, e.g. "Free" or "From $29 a month". Leave empty to hide.']),
            $f('rl_h_tools', 'Before you start, you need', 'textarea', ['rows' => 4, 'instructions' => 'One per line: tools, access or files.']),
            $f('rl_h_result', 'When you finish', 'textarea', ['rows' => 2, 'instructions' => 'One or two sentences: what the reader will have or know at the end.']),
            $f('rl_h_step_meta', 'Step details', 'textarea', ['rows' => 6,
                'instructions' => 'Every H2 in the article is one step. One line per step, in the same order: Minutes | Why this step matters | You should see. Any part can be left empty. Example: 3 | It is the only check that reads Google\'s own record | A report titled "URL Inspection"']),
            $f('rl_h_mistakes', 'Avoid these', 'textarea', ['rows' => 4, 'instructions' => 'One mistake per line.']),
            $f('rl_h_trouble', 'If something goes wrong', 'textarea', ['rows' => 4, 'instructions' => 'One per line: Problem | Fix']),
            $f('rl_h_finish_head', 'Finish card: headline', 'text', ['instructions' => 'Example: Done: you know where the page stands. Empty = "Done: all steps complete".']),
            $f('rl_h_finish_text', 'Finish card: what to do next', 'textarea', ['rows' => 2]),
            $f('rl_h_cta_service', 'In-article CTA: service', 'select', ['choices' => $services, 'allow_null' => 1, 'instructions' => 'The service that matches the step it follows. Leave empty for no in-article CTA.']),
            $f('rl_h_cta_after', 'In-article CTA: after step', 'number', ['min' => 1, 'max' => 50, 'default_value' => 2]),
            $f('rl_h_cta_head', 'In-article CTA: headline', 'text', ['instructions' => 'A question tied to the step just done. Example: Hundreds of pages not indexed?']),
            $f('rl_h_cta_sub', 'In-article CTA: one line', 'text', ['instructions' => 'What we do, in one sentence.']),
            $f('rl_h_cta_button', 'In-article CTA: button text', 'text', ['default_value' => 'See how it works']),
        ],
    ]);
});

/* ---------- body → steps ---------- */
function rl_howto_rows($v, $min) {
    $o = [];
    foreach (rl_post_lines($v) as $l) { $p = array_map('trim', explode('|', $l)); if (count($p) >= $min && $p[0] !== '') $o[] = $p; }
    return $o;
}
/* Returns [intro html, steps]. Each step: id (step-N), title, title_html, h2 id, html, minutes, why, see, text (plain, for schema). */
function rl_howto_steps($id, $html) {
    $parts = preg_split('#(<h2\b[^>]*>.*?</h2>)#is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
    $intro = array_shift($parts);
    $meta = [];
    foreach (rl_post_lines(get_post_meta($id, 'rl_h_step_meta', true)) as $l) $meta[] = array_map('trim', explode('|', $l));
    $steps = [];
    for ($i = 0; $i < count($parts); $i += 2) {
        preg_match('#<h2\b([^>]*)>(.*?)</h2>#is', $parts[$i], $m);
        $k = count($steps);
        $inner = $parts[$i + 1] ?? '';
        $mt = $meta[$k] ?? [];
        $text = preg_match('#<p\b[^>]*>(.*?)</p>#is', $inner, $pm) ? trim(wp_strip_all_tags($pm[1])) : '';
        $steps[] = ['id' => 'step-' . ($k + 1), 'title' => trim(wp_strip_all_tags($m[2] ?? '')), 'title_html' => $m[2] ?? '',
            'hid' => preg_match('/\sid=["\']([^"\']+)["\']/', $m[1] ?? '', $im) ? $im[1] : '', 'html' => $inner,
            'mins' => (isset($mt[0]) && is_numeric($mt[0])) ? (int) round((float) $mt[0]) : 0,
            'why' => $mt[1] ?? '', 'see' => $mt[2] ?? '', 'text' => $text];
    }
    return [trim($intro), $steps];
}
function rl_howto_level() { return ['beginner' => 1, 'intermediate' => 2, 'advanced' => 3]; }

/* ---------- render (called from rl_post_output inside the loop) ---------- */
function rl_howto_render($c) {
    $id = $c['id']; $d = $c['d']; $u = $c['u'];
    [$intro, $steps] = rl_howto_steps($id, $c['body']);
    $n = count($steps);
    $title = get_the_title($id);
    $standfirst = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    $min = (int) round((float) get_post_meta($id, 'rl_h_minutes', true));
    $lvl = (string) get_post_meta($id, 'rl_h_level', true);
    $cost = trim((string) get_post_meta($id, 'rl_h_cost', true));
    $need = rl_post_lines(get_post_meta($id, 'rl_h_tools', true));
    $result = trim((string) get_post_meta($id, 'rl_h_result', true));
    $avoid = rl_post_lines(get_post_meta($id, 'rl_h_mistakes', true));
    $trouble = rl_howto_rows(get_post_meta($id, 'rl_h_trouble', true), 2);
    $fhead = trim((string) get_post_meta($id, 'rl_h_finish_head', true)) ?: 'Done: all steps complete';
    $ftext = trim((string) get_post_meta($id, 'rl_h_finish_text', true));
    $cta = null; $svc = (string) get_post_meta($id, 'rl_h_cta_service', true);
    $head = trim((string) get_post_meta($id, 'rl_h_cta_head', true));
    if ($svc !== '' && $head !== '' && function_exists('rl_pt_services') && isset(rl_pt_services()[$svc])) {
        $after = max(1, (int) (get_post_meta($id, 'rl_h_cta_after', true) ?: 2));
        $cta = ['after' => min($after, max(1, $n)), 'name' => rl_pt_services()[$svc], 'url' => $u($svc), 'head' => $head,
                'sub' => trim((string) get_post_meta($id, 'rl_h_cta_sub', true)), 'btn' => trim((string) get_post_meta($id, 'rl_h_cta_button', true)) ?: 'See how it works'];
    }
    $diag = $u('search-authority-diagnostic');
    $specs = [];
    if ($min) $specs[] = ['Time', function_exists('rl_pt_minutes_label') && $min >= 60 ? rl_pt_minutes_label($min) : $min . ' min', ''];
    if (isset(rl_howto_level()[$lvl])) $specs[] = ['Level', ucfirst($lvl), rl_howto_level()[$lvl]];
    if ($cost !== '') $specs[] = ['Cost', $cost, ''];
    $h1 = preg_match('/^(How to \S+)(.*)$/is', $title, $tm) ? '<span class="verb">' . esc_html($tm[1]) . '</span>' . esc_html($tm[2]) : esc_html($title);
    ?>
<div class="rl-page rl-post rl-howto" data-post="<?php echo (int) $id; ?>">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><a href="<?php echo esc_url($c['blog_url']); ?>">Blog</a></li>
  <?php if ($c['cat']) { ?><li><a href="<?php echo esc_url(get_category_link($c['cat'])); ?>"><?php echo esc_html($c['cat']->name); ?></a></li><?php } ?>
  <li><span aria-current="page"><?php echo esc_html(wp_trim_words($title, 8)); ?></span></li>
</ol></nav>

<header class="wrap h-hero<?php echo ($specs || $need || $result) ? '' : ' solo'; ?>">
  <div>
    <div class="h-kicker"><span class="h-kind">How-To</span><?php if ($c['cat']) echo '<a class="h-cat" href="' . esc_url(get_category_link($c['cat'])) . '">' . esc_html($c['cat']->name) . '</a>'; ?></div>
    <h1 class="h-h1"><?php echo $h1; ?></h1>
    <?php if ($standfirst !== '') { ?><p class="h-stand"><?php echo esc_html($standfirst); ?></p><?php } ?>
    <div class="h-by">
      <span class="who"><span class="av" aria-hidden="true"><?php echo esc_html(mb_substr($c['aname'], 0, 1)); ?></span><?php echo $c['founder'] ? '<a href="' . $c['about'] . '#founder">' . esc_html($c['aname']) . '</a>' : esc_html($c['aname']); ?></span>
      <span>Published <time datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>"><b><?php echo esc_html(get_the_date('j M Y', $id)); ?></b></time></span>
      <?php if ($d['updated'] !== '') { ?><span>Updated <time datetime="<?php echo esc_attr($d['updated']); ?>"><b><?php echo esc_html(date_i18n('j M Y', strtotime($d['updated']))); ?></b></time></span><?php } ?>
    </div>
  </div>
  <?php if ($specs || $need || $result) { ?>
  <aside class="h-ticket" aria-label="Job ticket">
    <div class="t-head"><span>Job ticket</span><?php if ($n) { ?><b><?php echo (int) $n; ?> step<?php echo $n > 1 ? 's' : ''; ?></b><?php } ?></div>
    <?php if ($specs) { ?>
    <div class="t-specs" style="grid-template-columns:repeat(<?php echo count($specs); ?>,1fr)"><?php foreach ($specs as $s) {
        echo '<div><span>' . esc_html($s[0]) . '</span><b>' . esc_html($s[1]) . '</b>';
        if ($s[2]) { echo '<div class="level" aria-hidden="true">'; for ($i = 1; $i <= 3; $i++) echo '<i' . ($i <= $s[2] ? ' class="on"' : '') . '></i>'; echo '</div>'; }
        echo '</div>';
    } ?></div>
    <?php } ?>
    <?php if ($need) { ?>
    <div class="t-need"><p class="t-label">Before you start, you need</p><ul class="need"><?php foreach ($need as $i => $x) echo '<li><label><input type="checkbox">' . esc_html($x) . '</label></li>'; ?></ul></div>
    <?php } ?>
    <?php if ($result !== '') { ?><div class="t-result"><p class="t-label">When you finish</p><p><?php echo esc_html($result); ?></p></div><?php } ?>
  </aside>
  <?php } ?>
</header>

<?php if (has_post_thumbnail($id)) { ?><figure class="wrap h-feat"><?php echo get_the_post_thumbnail($id, 'full', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></figure><?php } ?>

<?php if ($n) { ?>
<div class="h-tracker" aria-label="Steps">
  <div class="wrap">
    <span class="lbl">Steps</span>
    <ol><?php foreach ($steps as $i => $s) echo '<li><a href="#' . esc_attr($s['id']) . '"><b>' . sprintf('%02d', $i + 1) . '</b>' . esc_html($s['title']) . '</a></li>'; ?></ol>
    <span class="count" data-h="cnt">0 of <?php echo (int) $n; ?> done</span>
  </div>
  <i class="tbar" data-h="tbar" aria-hidden="true"></i>
</div>
<?php } ?>

<div class="wrap">
  <div class="h-main<?php echo $n ? '' : ' noside'; ?>">
    <article class="h-text">
      <?php if ($d['answer'] !== '') { ?><div class="h-answer"><p class="t">Short answer</p><p><?php echo esc_html($d['answer']); ?></p></div><?php } ?>
      <?php if ($d['takeaways']) { ?><div class="h-take"><?php foreach ($d['takeaways'] as $i => $k) echo '<div><b>' . sprintf('%02d', $i + 1) . '</b><span>' . esc_html($k) . '</span></div>'; ?></div><?php } ?>
      <?php if ($intro !== '') echo '<div class="h-prose h-intro">' . $intro . '</div>'; ?>
      <?php if ($n) { ?>
      <div class="h-track">
        <?php foreach ($steps as $i => $s) { $k = $i + 1; ?>
        <section class="h-step" id="<?php echo esc_attr($s['id']); ?>" aria-labelledby="<?php echo esc_attr($s['hid'] ?: $s['id'] . '-h'); ?>">
          <span class="node" aria-hidden="true"><span><?php echo (int) $k; ?></span></span>
          <p class="s-meta">Step <?php echo (int) $k; ?> of <?php echo (int) $n; ?><?php echo $s['mins'] ? ' · ' . (int) $s['mins'] . ' min' : ''; ?></p>
          <h2 id="<?php echo esc_attr($s['hid'] ?: $s['id'] . '-h'); ?>"><?php echo wp_kses_post($s['title_html']); ?></h2>
          <?php if ($s['why'] !== '') { ?><p class="why"><b>Why:</b> <?php echo esc_html($s['why']); ?></p><?php } ?>
          <div class="h-prose"><?php echo $s['html']; ?></div>
          <?php if ($s['see'] !== '') { ?><div class="see"><span class="lb">You should see</span><span><?php echo esc_html($s['see']); ?></span></div><?php } ?>
          <label class="mark"><input type="checkbox" data-step="<?php echo (int) $k; ?>">Mark step <?php echo (int) $k; ?> done</label>
        </section>
        <?php if ($cta && $cta['after'] === $k && $k < $n) { ?>
        <aside class="h-icta" aria-label="Reinforce Lab service">
          <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
          <div class="act"><a class="go" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
        </aside>
        <?php } ?>
        <?php } ?>
      </div>
      <div class="h-finish" id="finish">
        <span class="flag" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24"><path d="M6 3v18M6 4h11l-2 4 2 4H6" stroke="#fff" stroke-width="2" fill="none"/></svg></span>
        <div><h2><?php echo esc_html($fhead); ?></h2><?php if ($ftext !== '') echo '<p>' . esc_html($ftext) . '</p>'; ?></div>
      </div>
      <?php if ($cta && $cta['after'] >= $n) { ?>
      <aside class="h-icta" aria-label="Reinforce Lab service">
        <div><p class="lbl">Reinforce Lab service · <?php echo esc_html($cta['name']); ?></p><p class="hd"><?php echo esc_html($cta['head']); ?></p><?php if ($cta['sub'] !== '') echo '<p class="csub">' . esc_html($cta['sub']) . '</p>'; ?></div>
        <div class="act"><a class="go" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['btn']); ?> <span aria-hidden="true">&rarr;</span></a><a class="alt" href="<?php echo esc_url($diag); ?>">Or get a free diagnostic first</a></div>
      </aside>
      <?php } ?>
      <?php } ?>
    </article>

    <?php if ($n) { ?>
    <aside class="h-side" aria-label="Help while you work">
      <div class="progress"><p class="t">Your progress</p><div class="bar"><i data-h="pbar"></i></div><span data-h="ptxt">0 of <?php echo (int) $n; ?> steps done</span></div>
      <?php if ($avoid) { ?>
      <div class="avoid"><p class="t">Avoid these</p><ul><?php foreach ($avoid as $a) echo '<li><svg class="i" viewBox="0 0 16 16" aria-hidden="true"><path d="M4 4l8 8M12 4l-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="square"/></svg><span>' . esc_html($a) . '</span></li>'; ?></ul></div>
      <?php } ?>
      <?php if ($trouble) { ?>
      <div class="trouble"><p class="t">If something goes wrong</p><?php foreach ($trouble as $t) echo '<details><summary>' . esc_html($t[0]) . '</summary><p>' . esc_html($t[1]) . '</p></details>'; ?></div>
      <?php } ?>
    </aside>
    <?php } ?>
  </div>

  <?php if ($d['faqs'] || $d['sources']) { ?>
  <section class="h-back" aria-label="Questions and sources">
    <?php if ($d['faqs']) { ?>
    <div class="faq" id="faq"><div class="h-back-h"><span>Questions</span><h2>FAQs</h2></div>
      <?php foreach ($d['faqs'] as $k => $q) { ?><details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($q[0]); ?></h3></summary><p><?php echo esc_html($q[1]); ?></p></details><?php } ?>
    </div>
    <?php } ?>
    <?php if ($d['sources']) { ?>
    <div class="h-src" id="sources"><div class="h-back-h"><span>Evidence</span><h2>Sources</h2></div>
      <ol><?php foreach ($d['sources'] as $s) echo '<li><a href="' . esc_url($s[1]) . '" rel="noopener" target="_blank">' . esc_html($s[0]) . '</a></li>'; ?></ol>
    </div>
    <?php } ?>
  </section>
  <?php } ?>

  <aside class="h-author" aria-label="About the author">
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
    $rel = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => [$id], 'no_found_rows' => true, 'ignore_sticky_posts' => true, 'category__in' => $c['cat'] ? [$c['cat']->term_id] : []]);
    if ($rel->have_posts()) { ?>
<section class="band alt rel" id="related"><div class="wrap"><div class="head"><span class="ey"><b>[</b>&nbsp;Keep reading&nbsp;<b>]</b></span><h2>Related articles</h2></div><ul class="posts">
<?php while ($rel->have_posts()) { $rel->the_post(); $rd = rl_post_data(get_the_ID()); ?>
  <li class="post"><span class="m"><?php echo esc_html($rd['type_label']); ?> · <?php echo esc_html(get_the_date('j M Y')); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><a class="more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read: ' . get_the_title()); ?>">Read article &rarr;</a></li>
<?php } wp_reset_postdata(); ?>
</ul></div></section>
<?php } ?>

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
  var root=document.querySelector('.rl-howto'); if(!root) return;
  var steps=[].slice.call(root.querySelectorAll('.h-step')), links=[].slice.call(root.querySelectorAll('.h-tracker li a')), n=steps.length;
  var boxes=steps.map(function(s){return s.querySelector('input[data-step]');});
  var key='rl-howto-'+root.getAttribute('data-post'), q=function(k){return root.querySelector('[data-h="'+k+'"]');};
  try{ var saved=JSON.parse(localStorage.getItem(key)||'[]'); boxes.forEach(function(b,i){ b.checked=saved.indexOf(i+1)>-1; }); }catch(e){}
  function sync(){
    var done=boxes.map(function(b){return b.checked;}), c=done.filter(Boolean).length, pct=Math.round(c/n*100)+'%';
    steps.forEach(function(s,i){ s.classList.toggle('done',done[i]); });
    links.forEach(function(a,i){ a.classList.toggle('done',done[i]); });
    if(q('cnt')) q('cnt').textContent=c+' of '+n+' done'; if(q('ptxt')) q('ptxt').textContent=c+' of '+n+' steps done';
    if(q('pbar')) q('pbar').style.width=pct; if(q('tbar')) q('tbar').style.width=pct;
    try{ localStorage.setItem(key,JSON.stringify(done.map(function(x,i){return x?i+1:0;}).filter(Boolean))); }catch(e){}
  }
  function cur(){ var c=0; steps.forEach(function(s,i){ if(s.getBoundingClientRect().top<innerHeight*0.4) c=i; }); links.forEach(function(a,i){ a.classList.toggle('on',i===c); if(i===c) a.setAttribute('aria-current','step'); else a.removeAttribute('aria-current'); }); }
  boxes.forEach(function(b){ b.addEventListener('change',sync); });
  addEventListener('scroll',cur,{passive:true}); cur(); sync();
})();
</script>
<?php }
}

/* ---------- schema: HowTo built from the steps on the page ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_array($graph) || !rl_is_howto_view()) return $graph;
    $id = get_queried_object_id(); $url = get_permalink($id);
    [$body] = rl_post_prepare(apply_filters('the_content', get_post_field('post_content', $id)));
    [, $steps] = rl_howto_steps($id, $body);
    if (!$steps) return $graph;
    $node = ['@type' => 'HowTo', '@id' => $url . '#howto', 'name' => get_the_title($id), 'mainEntityOfPage' => ['@id' => $url],
        'step' => array_map(function ($s, $i) use ($url) { return ['@type' => 'HowToStep', 'position' => $i + 1, 'name' => $s['title'], 'text' => $s['text'] !== '' ? $s['text'] : ($s['see'] !== '' ? $s['see'] : $s['title']), 'url' => $url . '#' . $s['id']]; }, $steps, array_keys($steps))];
    $min = (int) round((float) get_post_meta($id, 'rl_h_minutes', true));
    if ($min) $node['totalTime'] = 'PT' . ($min >= 60 ? intdiv($min, 60) . 'H' : '') . ($min % 60 ? ($min % 60) . 'M' : '');
    $tools = rl_post_lines(get_post_meta($id, 'rl_h_tools', true));
    if ($tools) $node['tool'] = array_map(function ($t) { return ['@type' => 'HowToTool', 'name' => $t]; }, $tools);
    $ex = has_excerpt($id) ? trim(wp_strip_all_tags(get_the_excerpt($id))) : '';
    if ($ex !== '') $node['description'] = $ex;
    $graph[] = $node;
    return $graph;
}, 35);

/* ---------- CSS ---------- */
add_action('wp_head', function () {
    if (!rl_is_howto_view()) return; ?>
<style id="rl-howto-css">
.rl-howto{color:var(--ink-dim);--ok:#3fa36b}
.rl-howto h1,.rl-howto h2,.rl-howto h3{font-family:var(--f-display);font-weight:600;text-transform:uppercase;color:var(--ink);line-height:1.04;letter-spacing:.005em;text-wrap:balance}
.rl-howto .h-hero{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,.95fr);gap:clamp(28px,5vw,64px);align-items:start;padding-block:clamp(26px,4vw,44px) clamp(30px,4vw,48px)}
.rl-howto .h-hero.solo{grid-template-columns:minmax(0,1fr)}
.rl-howto .h-kicker{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px}
.rl-howto .h-kind{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.2em;text-transform:uppercase;color:#fff;background:var(--red);padding:6px 10px}
.rl-howto .h-cat{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-dim);border:1px solid var(--line-2);padding:5px 10px;text-decoration:none}
.rl-howto .h-h1{font-size:clamp(36px,5.2vw,68px);line-height:.98;margin:0}
.rl-howto .h-h1 .verb{color:var(--red-3)}
.rl-howto .h-stand{font-size:clamp(17px,1.5vw,19px);line-height:1.55;max-width:600px;margin:20px 0 0}
.rl-howto .h-by{display:flex;flex-wrap:wrap;align-items:center;gap:10px 22px;margin-top:24px;font-family:var(--f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-faint)}
.rl-howto .h-by .who{display:flex;align-items:center;gap:10px;color:var(--ink)}
.rl-howto .h-by .who a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--red-line)}
.rl-howto .h-by b{color:var(--ink-dim);font-weight:500}
.rl-howto .av{width:34px;height:34px;border:1px solid var(--red-line);display:grid;place-items:center;font-family:var(--f-display);font-size:15px;color:var(--ink);background:var(--bg-2);flex:none}
.rl-howto .h-ticket{border:1px solid var(--line-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));position:relative}
.rl-howto .h-ticket::before,.rl-howto .h-ticket::after{content:"";position:absolute;width:18px;height:18px;background:var(--bg);border:1px solid var(--line-2);top:calc(50% - 9px);transform:rotate(45deg)}
.rl-howto .h-ticket::before{left:-10px;border-right:0;border-top:0}
.rl-howto .h-ticket::after{right:-10px;border-left:0;border-bottom:0}
.rl-howto .t-head{display:flex;justify-content:space-between;align-items:center;padding:12px 18px;border-bottom:1px dashed var(--line-2);font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint)}
.rl-howto .t-head b{color:var(--red-3);font-weight:500}
.rl-howto .t-specs{display:grid;border-bottom:1px solid var(--line)}
.rl-howto .t-specs>div{padding:16px 18px;border-right:1px solid var(--line);min-width:0}
.rl-howto .t-specs>div:last-child{border-right:0}
.rl-howto .t-specs span{display:block;font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:6px}
.rl-howto .t-specs b{font-family:var(--f-display);font-size:24px;font-weight:500;color:var(--ink);line-height:1.05;overflow-wrap:anywhere}
.rl-howto .level{display:flex;gap:4px;margin-top:8px}
.rl-howto .level i{width:18px;height:4px;background:var(--line-2)}
.rl-howto .level i.on{background:var(--red-3)}
.rl-howto .t-need,.rl-howto .t-result{padding:16px 18px}
.rl-howto .t-need{border-bottom:1px solid var(--line)}
.rl-howto .t-need:last-child{border-bottom:0}
.rl-howto .t-label{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink-faint);margin:0 0 10px}
.rl-howto .need{list-style:none;margin:0;padding:0;display:grid;gap:8px}
.rl-howto .need label{display:flex;gap:10px;align-items:flex-start;cursor:pointer;font-size:14.5px;color:var(--ink-dim)}
.rl-howto input[type=checkbox]{appearance:none;-webkit-appearance:none;width:16px;height:16px;border:1px solid var(--line-2);background:var(--bg);margin:3px 0 0;flex:none;display:grid;place-items:center;cursor:pointer;border-radius:0}
.rl-howto input[type=checkbox]:checked{background:var(--red);border-color:var(--red-2)}
.rl-howto input[type=checkbox]:checked::after{content:"";width:8px;height:4px;border-left:2px solid #fff;border-bottom:2px solid #fff;transform:rotate(-45deg) translate(1px,-1px)}
.rl-howto .t-result p{margin:0;color:var(--ink);font-size:15.5px}
.rl-howto .h-feat{margin-top:0;margin-bottom:clamp(30px,4vw,48px)}
.rl-howto .h-feat img{display:block;width:100%;height:auto;border:1px solid var(--line)}
.rl-howto .h-tracker{position:sticky;top:72px;z-index:6;background:rgba(18,16,17,.94);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-block:1px solid var(--line-2)}
.rl-howto .h-tracker .wrap{display:flex;align-items:center;gap:18px;height:56px}
.rl-howto .h-tracker .lbl{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink);white-space:nowrap}
.rl-howto .h-tracker ol{list-style:none;margin:0;padding:0;display:flex;flex:1;gap:6px;min-width:0}
.rl-howto .h-tracker li{flex:1;min-width:0}
.rl-howto .h-tracker a{display:flex;align-items:center;gap:8px;height:34px;padding:0 10px;border:1px solid var(--line-2);text-decoration:none;color:var(--ink-faint);font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;background:var(--bg-2)}
.rl-howto .h-tracker a b{font-family:var(--f-mono);font-size:11px;font-weight:500;color:var(--ink-faint)}
.rl-howto .h-tracker a.on{border-color:var(--red-2);color:var(--ink)}
.rl-howto .h-tracker a.on b,.rl-howto .h-tracker a.done b{color:var(--red-3)}
.rl-howto .h-tracker a.done{background:rgba(153,0,0,.22);border-color:var(--red-line);color:var(--ink-dim)}
.rl-howto .h-tracker .count{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);white-space:nowrap}
.rl-howto .h-tracker .tbar{position:absolute;left:0;bottom:-1px;height:2px;width:0;background:var(--red-3);transition:width .25s}
.rl-howto .h-main{display:grid;grid-template-columns:minmax(0,760px) minmax(0,1fr);gap:clamp(30px,5vw,64px);align-items:start;padding-block:clamp(34px,5vw,56px) 20px}
.rl-howto .h-main.noside{grid-template-columns:minmax(0,760px)}
.rl-howto .h-text{min-width:0}
.rl-howto .h-answer{border:1px solid var(--red-line);border-left:4px solid var(--red-2);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px 24px;margin-bottom:28px}
.rl-howto .h-answer .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 8px}
.rl-howto .h-answer p{margin:0;color:var(--ink);font-size:18px;line-height:1.6}
.rl-howto .h-take{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border:1px solid var(--line);margin-bottom:32px}
.rl-howto .h-take div{background:var(--bg-2);padding:16px 18px;display:grid;grid-template-columns:28px 1fr;gap:8px;font-size:15px}
.rl-howto .h-take b{font-family:var(--f-mono);font-size:11.5px;color:var(--red-3);font-weight:500;padding-top:2px}
.rl-howto .h-prose>*{margin:0 0 1em}
.rl-howto .h-prose p,.rl-howto .h-prose li{font-size:17px;line-height:1.75}
.rl-howto .h-intro p{font-size:17.5px}
.rl-howto .h-prose h3{font-size:21px;margin:1.4em 0 .5em;scroll-margin-top:150px}
.rl-howto .h-prose strong{color:var(--ink);font-weight:600}
.rl-howto .h-prose a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
.rl-howto .h-prose ul{padding-left:1.2em}
.rl-howto .h-prose ul li::marker{color:var(--red-3)}
.rl-howto .h-prose ol{margin:0 0 1em;padding:0;list-style:none;counter-reset:d}
.rl-howto .h-prose ol>li{counter-increment:d;display:grid;grid-template-columns:30px 1fr;gap:8px;padding:9px 0;margin:0;border-top:1px solid var(--line);font-size:16.5px}
.rl-howto .h-prose ol>li:first-child{border-top:0}
.rl-howto .h-prose ol>li::before{content:counter(d,lower-alpha);font-family:var(--f-mono);font-size:12px;color:var(--red-3);padding-top:3px}
.rl-howto kbd{font-family:var(--f-mono);font-size:.88em;color:var(--ink);background:var(--panel-2,var(--panel));border:1px solid var(--line-2);border-bottom-width:2px;padding:1px 6px}
.rl-howto .h-prose code{font-family:var(--f-mono);font-size:.9em;color:var(--ink);background:var(--panel);padding:1px 5px}
.rl-howto .h-prose figure:not(.wp-block-table){margin:18px 0;border:1px solid var(--line-2);background:var(--bg-2)}
.rl-howto .h-prose figure:not(.wp-block-table)::before{content:"";display:block;height:27px;border-bottom:1px solid var(--line);background-image:linear-gradient(var(--line-2),var(--line-2)),linear-gradient(var(--line-2),var(--line-2)),linear-gradient(var(--line-2),var(--line-2));background-size:8px 8px;background-repeat:no-repeat;background-position:12px 9px,26px 9px,40px 9px}
.rl-howto .h-prose figure img{display:block;width:100%;height:auto}
.rl-howto .h-prose figcaption{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);padding:10px 12px;border-top:1px solid var(--line);margin:0}
.rl-howto .h-prose .tscroll{overflow-x:auto;max-width:100%}
.rl-howto .h-prose table{width:100%;border-collapse:collapse;font-size:15px}
.rl-howto .h-prose th,.rl-howto .h-prose td{border:1px solid var(--line-2);padding:10px 12px;text-align:left;vertical-align:top}
.rl-howto .h-prose th{color:var(--ink);background:var(--panel)}
.rl-howto .h-prose .tip{border:1px solid var(--line-2);background:var(--panel);padding:14px 16px 14px 64px;position:relative;font-size:15.5px}
.rl-howto .h-prose .tip::before{content:"Tip";position:absolute;left:16px;top:16px;font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-howto .h-track{position:relative;margin-top:30px;padding-left:72px}
.rl-howto .h-track::before{content:"";position:absolute;left:23px;top:10px;bottom:30px;width:2px;background:var(--line-2)}
.rl-howto .h-step{position:relative;padding-block:0 46px;scroll-margin-top:150px}
.rl-howto .node{position:absolute;left:-72px;top:0;width:48px;height:48px;display:grid;place-items:center;background:var(--bg);border:2px solid var(--line-2);font-family:var(--f-display);font-size:20px;color:var(--ink);transition:background .2s,border-color .2s}
.rl-howto .h-step.done .node{background:var(--red);border-color:var(--red-2)}
.rl-howto .h-step.done .node span{display:none}
.rl-howto .h-step.done .node::after{content:"";width:16px;height:8px;border-left:3px solid #fff;border-bottom:3px solid #fff;transform:rotate(-45deg) translate(1px,-2px)}
.rl-howto .s-meta{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--ink-faint);margin:2px 0 8px}
.rl-howto .h-step h2{font-size:clamp(24px,2.8vw,32px);margin:0;scroll-margin-top:150px}
.rl-howto .why{margin:10px 0 16px;color:var(--ink);font-size:16px;border-left:2px solid var(--red-2);padding-left:12px}
.rl-howto .why b{font-weight:600}
.rl-howto .see{display:grid;grid-template-columns:auto 1fr;gap:12px;align-items:start;border:1px solid rgba(63,163,107,.45);background:rgba(63,163,107,.07);padding:14px 16px;margin:18px 0 14px;font-size:15.5px;color:var(--ink)}
.rl-howto .see .lb{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--ok);padding-top:3px;white-space:nowrap}
.rl-howto .mark{display:inline-flex;align-items:center;gap:10px;cursor:pointer;font-family:var(--f-mono);font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint);border:1px solid var(--line-2);padding:9px 14px;background:var(--bg-2)}
.rl-howto .mark input{margin:0;width:15px;height:15px}
.rl-howto .mark:has(input:checked){color:var(--ink);border-color:var(--red-line)}
.rl-howto .h-icta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px 28px;align-items:center;margin:0 0 46px;padding:20px 0 20px 20px;border-top:1px solid var(--red-line);border-bottom:1px solid var(--red-line);border-left:3px solid var(--red-2);background:linear-gradient(90deg,rgba(153,0,0,.12),transparent 70%)}
.rl-howto .h-finish + .h-icta{margin:36px 0 0}
.rl-howto .h-icta .lbl{font-family:var(--f-mono);font-size:10.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--red-3);margin:0 0 6px}
.rl-howto .h-icta .hd{font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:clamp(19px,2vw,22px);line-height:1.15;color:var(--ink);margin:0 0 6px}
.rl-howto .h-icta .csub{margin:0;font-size:15px;color:var(--ink-dim)}
.rl-howto .h-icta .act{display:grid;gap:8px;justify-items:start;padding-right:20px}
.rl-howto .h-icta .go{display:inline-flex;align-items:center;gap:8px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.07em;font-size:14px;text-decoration:none;color:#fff;background:var(--red);border:1px solid var(--red-2);padding:12px 18px;white-space:nowrap;transition:background .15s}
.rl-howto .h-icta .go:hover{background:var(--red-2)}
.rl-howto .h-icta .alt{font-size:13.5px;color:var(--ink-faint);text-decoration:none;border-bottom:1px solid var(--line-2)}
.rl-howto .h-icta .alt:hover{color:var(--ink)}
.rl-howto .h-finish{border:1px solid var(--red-line);background:radial-gradient(80% 140% at 0% 0%,rgba(153,0,0,.25),transparent 60%),var(--panel);padding:26px 28px;display:grid;grid-template-columns:auto 1fr;gap:20px;align-items:center;margin-left:72px}
.rl-howto .h-finish .flag{width:56px;height:56px;display:grid;place-items:center;border:2px solid var(--red-2);background:var(--red)}
.rl-howto .h-finish h2{font-size:26px;margin:0 0 6px}
.rl-howto .h-finish p{margin:0;color:var(--ink-dim)}
.rl-howto .h-side{display:grid;gap:22px;align-content:start;align-self:start;position:sticky;top:150px}
.rl-howto .h-side .t{font-family:var(--f-mono);font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3);margin:0 0 12px}
.rl-howto .progress{border:1px solid var(--line-2);background:var(--bg-2);padding:16px 20px}
.rl-howto .progress .bar{height:4px;background:var(--line-2);margin:10px 0 8px}
.rl-howto .progress .bar i{display:block;height:100%;width:0;background:var(--red-3);transition:width .25s}
.rl-howto .progress span{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint)}
.rl-howto .avoid{border:1px solid rgba(226,59,59,.45);background:rgba(153,0,0,.08);padding:18px 20px}
.rl-howto .avoid ul{list-style:none;margin:0;padding:0}
.rl-howto .avoid li{display:grid;grid-template-columns:18px 1fr;gap:10px;padding:9px 0;border-top:1px solid var(--line);font-size:14.5px;color:var(--ink-dim)}
.rl-howto .avoid li:first-child{border-top:0}
.rl-howto .avoid svg{width:14px;height:14px;color:var(--red-3);margin-top:4px}
.rl-howto .trouble{border:1px solid var(--line-2);background:var(--panel);padding:18px 20px}
.rl-howto .trouble details{border-top:1px solid var(--line)}
.rl-howto .trouble details:first-of-type{border-top:0}
.rl-howto .trouble summary{cursor:pointer;list-style:none;padding:11px 0;color:var(--ink);font-size:14.5px;display:flex;justify-content:space-between;gap:10px}
.rl-howto .trouble summary::-webkit-details-marker{display:none}
.rl-howto .trouble summary::after{content:"+";color:var(--red-3);font-family:var(--f-mono)}
.rl-howto .trouble details[open] summary::after{content:"\2212"}
.rl-howto .trouble p{margin:0 0 12px;font-size:14px}
.rl-howto .h-back{border-top:1px solid var(--line-2);padding-block:46px 10px;margin-top:30px;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(24px,4vw,48px)}
.rl-howto .h-back-h{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px 14px;margin-bottom:18px}
.rl-howto .h-back-h span{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.18em;text-transform:uppercase;color:var(--red-3)}
.rl-howto .h-back-h h2{font-size:28px;margin:0}
.rl-howto .h-src ol{margin:0;padding-left:1.4em;font-size:14.5px}
.rl-howto .h-src li{padding:6px 0;color:var(--ink-faint)}
.rl-howto .h-src a{color:var(--ink-dim);text-decoration:none;border-bottom:1px solid var(--red-line);word-break:break-word}
.rl-howto .h-author{display:grid;grid-template-columns:72px 1fr;gap:18px;border:1px solid var(--line-2);background:var(--panel);padding:22px;margin:36px 0 50px}
.rl-howto .h-author .av{width:72px;height:72px;font-size:28px}
.rl-howto .h-author .nm{font-family:var(--f-display);font-size:22px;text-transform:uppercase;color:var(--ink);margin:0}
.rl-howto .h-author .role{font-family:var(--f-mono);font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3);margin:4px 0 8px}
.rl-howto .h-author p{margin:0 0 8px;font-size:15px}
.rl-howto .h-author .links{display:flex;gap:18px;font-size:14px}
.rl-howto .h-author .links a{color:var(--ink);border-bottom:1px solid var(--red-line);text-decoration:none}
@media(max-width:1000px){
  .rl-howto .h-hero,.rl-howto .h-main{grid-template-columns:minmax(0,1fr)}
  .rl-howto .h-side{position:static}
  .rl-howto .h-tracker{top:64px}
  .rl-howto .h-tracker ol{display:none}
  .rl-howto .h-tracker .wrap{justify-content:space-between;height:48px}
  .rl-howto .h-step,.rl-howto .h-step h2{scroll-margin-top:130px}
}
@media(max-width:700px){
  .rl-howto .t-specs b{font-size:20px}
  .rl-howto .t-specs>div{padding:14px 12px}
  .rl-howto .h-ticket::before,.rl-howto .h-ticket::after{display:none}
  .rl-howto .h-track{padding-left:56px}
  .rl-howto .node{left:-56px;width:40px;height:40px;font-size:17px}
  .rl-howto .h-track::before{left:19px}
  .rl-howto .h-finish{margin-left:0;grid-template-columns:1fr}
  .rl-howto .h-icta{grid-template-columns:1fr;padding-left:16px}
  .rl-howto .h-icta .act{padding-right:16px}
  .rl-howto .h-back,.rl-howto .h-take{grid-template-columns:1fr}
  .rl-howto .h-author{grid-template-columns:1fr}
  .rl-howto .h-prose p,.rl-howto .h-prose li,.rl-howto .h-prose ol>li{font-size:16px}
  .rl-howto .see{grid-template-columns:1fr;gap:6px}
}
@media(prefers-reduced-motion:reduce){.rl-howto .progress .bar i,.rl-howto .node,.rl-howto .h-tracker .tbar{transition:none}}
</style>
<?php }, 24);
