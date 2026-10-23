<?php
/**
 * Reinforce Lab rebuild: import the data-only export into a FRESH WordPress (Step 2.3, D-196).
 *
 *   wp eval-file import.php <export-dir> [wipe-fresh]
 *
 * Reads claude/data/site-export/ (posts.json, terms.json, options.json, users.json). Writes rows straight into the
 * database with the SAME IDs as on reinforcelab.online, because settings and code refer to IDs (front page 33,
 * blog 220, attachments, menus, the Themer header). Meta values are written exactly as exported (already serialized).
 *
 * Safety:
 *   - refuses to run unless the site is a fresh install (at most 10 posts of any kind) and wipe-fresh is given;
 *     wipe-fresh empties ONLY the default "Hello world" content of the fresh install before the import
 *   - refuses to run on a site whose address is reinforcelab.com before the switch is approved (env RL_SWITCH=approved)
 *   - no passwords are imported: user 1 is the install's admin; other users get a random password nobody knows
 *     (Jamil resets it from wp-admin when needed)
 */
if (!defined('ABSPATH')) { fwrite(STDERR, "Run with: wp eval-file import.php <export-dir> wipe-fresh\n"); exit(1); }

global $wpdb;
$args = isset($args) ? $args : [];
$dir = rtrim($args[0] ?? '', '/');
$wipe = in_array('wipe-fresh', $args, true);
$say = function ($m) { echo $m . "\n"; };
$die = function ($m) { fwrite(STDERR, "STOP: $m\n"); exit(1); };

if (!$dir || !is_readable("$dir/posts.json")) $die("export folder not found: '$dir'");
if (stripos(home_url(), 'reinforcelab.com') !== false && getenv('RL_SWITCH') !== 'approved') $die('this site answers as reinforcelab.com; the import only runs on staging until the switch is approved');
$existing = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts");
if ($existing > 10) $die("this site already has $existing posts: it is not a fresh install, nothing was changed");
if (!$wipe) $die('add wipe-fresh to confirm this is the fresh install made by rebuild.sh');

$posts = json_decode(file_get_contents("$dir/posts.json"), true);
$terms = json_decode(file_get_contents("$dir/terms.json"), true);
$opts = json_decode(file_get_contents("$dir/options.json"), true);
$users = json_decode(file_get_contents("$dir/users.json"), true);
if (!$posts || !$terms || !$opts || !$users) $die('an export file could not be read');

/* 1. empty the fresh install's sample content (Hello world, Sample Page, draft Privacy Policy, Uncategorized) */
foreach (['posts', 'postmeta', 'comments', 'commentmeta', 'terms', 'term_taxonomy', 'term_relationships', 'termmeta'] as $t) {
    $wpdb->query('DELETE FROM ' . $wpdb->$t);
}
$say("1. fresh install's sample content removed ($existing rows)");

/* 2. users: the three authors posts point at, same IDs, no passwords */
$cap = $wpdb->prefix . 'capabilities';
$lvl = $wpdb->prefix . 'user_level';
foreach ($users as $u) {
    $row = ['user_login' => $u['user_login'], 'user_nicename' => $u['user_nicename'], 'user_email' => $u['user_email'],
            'user_url' => $u['user_url'], 'display_name' => $u['display_name']];
    if ($wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE ID=%d", $u['ID']))) {
        $wpdb->update($wpdb->users, $row, ['ID' => $u['ID']]);  // user 1 = the admin made by wp core install
    } else {
        $clash = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_login=%s OR user_email=%s", $u['user_login'], $u['user_email']));
        if ($clash) $die("user '{$u['user_login']}' already exists with ID $clash");
        $wpdb->insert($wpdb->users, $row + ['ID' => $u['ID'], 'user_pass' => wp_hash_password(wp_generate_password(40, true, true)),
                                            'user_registered' => current_time('mysql', true), 'user_status' => 0]);
    }
    $levels = ['administrator' => 10, 'editor' => 7, 'author' => 2, 'contributor' => 1, 'subscriber' => 0];
    update_user_meta($u['ID'], $cap, array_fill_keys($u['roles'], true));
    update_user_meta($u['ID'], $lvl, $levels[$u['roles'][0]] ?? 0);
    foreach (['first_name', 'last_name', 'description'] as $k) update_user_meta($u['ID'], $k, $u[$k]);
}
clean_user_cache(1);
$say('2. users: ' . count($users) . ' (no passwords copied)');

/* 3. posts, pages, projects, media records, menu items, Themer layout, ACF setup, custom CSS: same IDs */
$cols = ['ID', 'post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_excerpt', 'post_status', 'comment_status',
         'post_name', 'post_modified', 'post_modified_gmt', 'post_parent', 'menu_order', 'post_type', 'post_mime_type', 'comment_count'];
$n = 0; $m = 0;
foreach ($posts as $p) {
    $row = array_intersect_key($p, array_flip($cols));
    $row += ['ping_status' => 'closed', 'post_password' => '', 'to_ping' => '', 'pinged' => '', 'post_content_filtered' => '', 'guid' => ''];
    if ($wpdb->insert($wpdb->posts, $row) === false) $die("post {$p['ID']} ({$p['post_type']} {$p['post_name']}): " . $wpdb->last_error);
    $n++;
    foreach ($p['meta'] as $kv) {
        $wpdb->insert($wpdb->postmeta, ['post_id' => $p['ID'], 'meta_key' => $kv[0], 'meta_value' => $kv[1]]);
        $m++;
    }
}
// guid: site address + ?p=ID, or the file address for media (WordPress's own format)
$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET guid = CONCAT(%s, ID) WHERE post_type <> 'attachment'", home_url('/?p=')));
$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET guid = CONCAT(%s, (SELECT pm.meta_value FROM $wpdb->postmeta pm WHERE pm.post_id = $wpdb->posts.ID AND pm.meta_key = '_wp_attached_file' LIMIT 1)) WHERE post_type = 'attachment'", trailingslashit(wp_upload_dir()['baseurl'])));
$say("3. posts: $n rows, $m meta rows");

/* 4. categories, menus and which post is in which */
foreach ($terms['terms'] as $t) {
    $wpdb->insert($wpdb->terms, ['term_id' => $t['term_id'], 'name' => $t['name'], 'slug' => $t['slug'], 'term_group' => 0]);
    $wpdb->insert($wpdb->term_taxonomy, ['term_taxonomy_id' => $t['term_taxonomy_id'], 'term_id' => $t['term_id'], 'taxonomy' => $t['taxonomy'],
                                         'description' => $t['description'], 'parent' => $t['parent'], 'count' => 0]);
}
foreach ($terms['relationships'] as $r) $wpdb->insert($wpdb->term_relationships, $r);
foreach ($terms['termmeta'] as $r) $wpdb->insert($wpdb->termmeta, $r);
$tts = $wpdb->get_results("SELECT term_taxonomy_id, taxonomy FROM $wpdb->term_taxonomy");
$by = [];
foreach ($tts as $t) $by[$t->taxonomy][] = (int) $t->term_taxonomy_id;
foreach ($by as $tax => $ids) wp_update_term_count_now($ids, $tax);
$say('4. terms: ' . count($terms['terms']) . ', links to posts: ' . count($terms['relationships']));

/* 5. settings (licence keys, tokens and passwords were never exported; their placeholders are left empty) */
$clean = function ($v) use (&$clean) {
    if (is_array($v)) { foreach ($v as $k => $x) $v[$k] = $clean($x); return $v; }
    return $v === '[removed]' ? '' : $v;
};
$skip = ['siteurl', 'home', 'blog_public'];  // address comes from the install; indexing stays off until the switch
$o = 0;
foreach ($opts as $name => $value) {
    if (in_array($name, $skip, true)) continue;
    update_option($name, $clean($value));
    $o++;
}
update_option('blog_public', 0);  // staging: noindex (turned on only in the switch runbook, A6)
if (!empty($terms['nav_menu_locations'])) set_theme_mod('nav_menu_locations', $terms['nav_menu_locations']);
$say("5. settings: $o (indexing off)");

/* 6. reset caches and permalinks */
wp_cache_flush();
flush_rewrite_rules(false);
$c = $wpdb->get_results("SELECT post_type, post_status, COUNT(*) n FROM $wpdb->posts GROUP BY post_type, post_status ORDER BY post_type", ARRAY_A);
$say('6. done. Now in the database:');
foreach ($c as $r) $say(sprintf('   %-20s %-8s %d', $r['post_type'], $r['post_status'], $r['n']));
$say('   front page: ' . get_option('page_on_front') . ' "' . get_the_title((int) get_option('page_on_front')) . '", blog: ' . get_option('page_for_posts') . ' "' . get_the_title((int) get_option('page_for_posts')) . '"');
