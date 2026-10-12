#!/usr/bin/env python3
"""Carry kept production posts across to reinforcelab.online (migration checklist A3, D-178).

Source: the read-only copies in claude/data/production-posts/ (fetched from production's public REST API with
plain GET requests sent from the .online server; nothing on production is changed).

What is kept: slug, title, the words of the post, images at the same /wp-content/uploads/ paths, publish date,
modified date, categories, Yoast title and meta description.
What changes (structure only, never wording):
  * links and images on reinforcelab.com become site-relative ("/path/"), so they work on .online and after the switch
  * <script> blocks in the body are dropped (an old reading-progress script and inline JSON-LD that would duplicate
    and contradict Yoast's schema); the FAQ text itself stays in the post
  * Divi wrappers (<article class="et_pb_post ...">) are unwrapped; WordPress embed iframes (hidden copies of a
    link that is already shown) are removed
Author: the "Reinforce Lab team" user until Jamil rewrites a post (D-145).
Safety: posts are created as drafts and then set to published directly in the database, so WordPress publish
actions (Jetpack social sharing, pings) never run. The site stays noindex. Existing slugs are skipped unless --force.

Usage:
  python3 claude/tools/carry-posts.py media <slug> [<slug> ...]   copy the image files a post uses (skips files present)
  python3 claude/tools/carry-posts.py import <slug> [<slug> ...] [--force]
  python3 claude/tools/carry-posts.py clean <slug>                print the cleaned body (no writes)
  --all in place of slugs = every post in claude/data/production-posts/
"""
import base64, glob, json, os, re, subprocess, sys, tempfile

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
DATA = os.path.join(ROOT, 'claude', 'data', 'production-posts')
PROD = ('https://reinforcelab.com', 'http://reinforcelab.com', 'https://www.reinforcelab.com', 'http://www.reinforcelab.com', '//reinforcelab.com')


def php(code):
    with tempfile.NamedTemporaryFile('w', suffix='.json', delete=False) as f:
        json.dump({'code': code}, f)
        path = f.name
    try:
        out = subprocess.run(['novamira', 'run', 'novamira/execute-php', '--yes', '--json', '--quiet', '--input', '@' + path], capture_output=True, text=True).stdout
    finally:
        os.unlink(path)
    d = json.loads(out)
    if not d.get('ok') or not d['data'].get('success', True):
        raise SystemExit('PHP failed: ' + out[:800])
    return d['data']['return_value']


def load(slug):
    return json.load(open(os.path.join(DATA, slug + '.json')))


def relativise(html):
    for p in PROD:
        html = re.sub(r'(\b(?:href|src|srcset|data-src)=["\'][^"\']*?)' + re.escape(p) + r'/', lambda m: m.group(1) + '/', html)
        html = re.sub(r'(,\s*)' + re.escape(p) + r'/', r'\1/', html)  # later srcset candidates
    return html


def clean(html):
    html = re.sub(r'<script\b[^>]*>.*?</script>', '', html, flags=re.S | re.I)
    html = re.sub(r'<article\b[^>]*\bet_pb_post\b[^>]*>', '', html)
    if '</article>' in html and '<article' not in html:
        html = html.replace('</article>', '')
    html = re.sub(r'<iframe\b[^>]*\bwp-embedded-content\b[^>]*>\s*</iframe>', '', html, flags=re.I)
    html = re.sub(r'<p>\s*</p>', '', html)
    return relativise(html).strip()


def upload_paths(slug):
    p = load(slug)
    paths = set()
    for attr in re.findall(r'(?:src|srcset|href|data-src)=["\']([^"\']+)["\']', p['content']['rendered']):
        for part in attr.split(','):
            u = part.strip().split(' ')[0]
            m = re.match(r'^(?:https?:)?(?://(?:www\.)?reinforcelab\.com)?(/wp-content/uploads/[^?#]+)$', u)
            if m:
                paths.add(m.group(1))
    fm = featured(p)
    if fm:
        for u in [fm['source_url']] + list(fm['media_details']['sizes'].values()):
            m = re.match(r'^https?://(?:www\.)?reinforcelab\.com(/wp-content/uploads/[^?#]+)$', u or '')
            if m:
                paths.add(m.group(1))
    return sorted(paths)


def featured(p):
    if not p.get('featured_media'):
        return None
    for m in json.load(open(os.path.join(DATA, '_featured-media.json'))):
        if m['id'] == p['featured_media']:
            return m
    return None


def copy_media(slug):
    paths = upload_paths(slug)
    done = {'copied': 0, 'present': 0, 'failed': []}
    for i in range(0, len(paths), 25):
        batch = paths[i:i + 25]
        b64 = base64.b64encode(json.dumps(batch).encode()).decode()
        r = php("""require_once ABSPATH . 'wp-admin/includes/file.php';
$out = ['copied' => 0, 'present' => 0, 'failed' => []];
foreach (json_decode(base64_decode('%s'), true) as $path) {
  if (strpos($path, '/wp-content/uploads/') !== 0 || strpos($path, '..') !== false) { $out['failed'][] = $path . ' (bad path)'; continue; }
  $dest = untrailingslashit(ABSPATH) . rawurldecode($path);
  if (file_exists($dest)) { $out['present']++; continue; }
  $tmp = download_url('https://reinforcelab.com' . $path, 60);
  if (is_wp_error($tmp)) { $out['failed'][] = $path . ' (' . $tmp->get_error_message() . ')'; continue; }
  wp_mkdir_p(dirname($dest));
  if (@rename($tmp, $dest) || @copy($tmp, $dest)) { @chmod($dest, 0644); $out['copied']++; } else { $out['failed'][] = $path . ' (write)'; }
  @unlink($tmp);
}
return $out;""" % b64)
        done['copied'] += r['copied']; done['present'] += r['present']; done['failed'] += r['failed']
    return done


def categories_for(p):
    cats = {c['id']: c for c in json.load(open(os.path.join(DATA, '_categories.json')))}
    out = []
    for cid in p['categories']:
        c = cats.get(cid)
        if c:
            parent = cats.get(c['parent'])
            out.append({'slug': c['slug'], 'name': c['name'], 'parent': parent['slug'] if parent else '', 'parent_name': parent['name'] if parent else ''})
    return out


def import_post(slug, force=False):
    p = load(slug)
    y = p.get('yoast_head_json') or {}
    fm = featured(p)
    fm_payload = None
    if fm:
        m = re.match(r'^https?://(?:www\.)?reinforcelab\.com/wp-content/uploads/(.+)$', fm['source_url'])
        if m:
            sizes = {}
            for k, u in fm['media_details']['sizes'].items():
                if u:
                    sizes[k] = os.path.basename(u)
            fm_payload = {'file': m.group(1), 'mime': fm.get('mime_type', ''), 'title': (fm.get('title') or {}).get('rendered', ''),
                          'alt': fm.get('alt_text', ''), 'width': fm['media_details']['width'], 'height': fm['media_details']['height'], 'sizes': sizes}
    payload = {
        'slug': p['slug'], 'title': p['title']['rendered'], 'content': clean(p['content']['rendered']),
        'date': p['date'], 'date_gmt': p['date_gmt'], 'modified': p['modified'], 'modified_gmt': p['modified_gmt'],
        'prod_id': p['id'], 'yoast_title': y.get('title', ''), 'yoast_desc': y.get('description', ''),
        'cats': categories_for(p), 'featured': fm_payload, 'force': force,
    }
    b64 = base64.b64encode(json.dumps(payload).encode()).decode()
    return php("""global $wpdb;
$p = json_decode(base64_decode('%s'), true);
$ex = get_page_by_path($p['slug'], OBJECT, 'post');
if ($ex && !$p['force']) return ['slug' => $p['slug'], 'skipped' => 'exists', 'id' => $ex->ID];
/* author: the "Reinforce Lab team" user (D-145); contributor role, random password nobody holds */
$team = get_user_by('login', 'reinforcelab-team');
if (!$team) {
  $uid = wp_insert_user(['user_login' => 'reinforcelab-team', 'user_pass' => wp_generate_password(48, true, true), 'user_email' => 'reinforcelab-team@reinforcelab.invalid',
    'display_name' => 'Reinforce Lab team', 'nickname' => 'Reinforce Lab team', 'first_name' => 'Reinforce Lab', 'last_name' => 'team', 'role' => 'contributor']);
  if (is_wp_error($uid)) return ['error' => 'user: ' . $uid->get_error_message()];
  $team = get_user_by('id', $uid);
}
/* categories: same slugs and names as production */
$cat_ids = [];
foreach ($p['cats'] as $c) {
  $parent = 0;
  if ($c['parent'] !== '') { $pt = get_term_by('slug', $c['parent'], 'category'); if (!$pt) { $r = wp_insert_term($c['parent_name'], 'category', ['slug' => $c['parent']]); $parent = is_wp_error($r) ? 0 : $r['term_id']; } else $parent = $pt->term_id; }
  $t = get_term_by('slug', $c['slug'], 'category');
  if (!$t) { $r = wp_insert_term($c['name'], 'category', ['slug' => $c['slug'], 'parent' => $parent]); if (!is_wp_error($r)) $cat_ids[] = $r['term_id']; }
  else $cat_ids[] = $t->term_id;
}
/* featured image: attachment pointing at the copied file, metadata from production (no resizing on this server) */
$thumb = 0;
if ($p['featured']) {
  $f = $p['featured'];
  $found = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %%s LIMIT 1", $f['file']));
  if ($found) $thumb = (int) $found;
  elseif (file_exists(wp_upload_dir()['basedir'] . '/' . $f['file'])) {
    $thumb = wp_insert_attachment(['post_mime_type' => $f['mime'], 'post_title' => wp_strip_all_tags(html_entity_decode($f['title'], ENT_QUOTES, 'UTF-8')), 'post_status' => 'inherit', 'post_content' => ''], $f['file']);
    if ($thumb && !is_wp_error($thumb)) {
      $sizes = [];
      foreach ($f['sizes'] as $k => $file) { if (preg_match('/-(\\d+)x(\\d+)\\.[a-z0-9]+$/i', $file, $mm)) $sizes[$k] = ['file' => $file, 'width' => (int) $mm[1], 'height' => (int) $mm[2], 'mime-type' => $f['mime']]; }
      wp_update_attachment_metadata($thumb, ['width' => (int) $f['width'], 'height' => (int) $f['height'], 'file' => $f['file'], 'sizes' => $sizes]);
      if ($f['alt'] !== '') update_post_meta($thumb, '_wp_attachment_image_alt', $f['alt']);
    } else $thumb = 0;
  }
}
/* the post: saved as a draft (no publish actions), then set to published in the database */
kses_remove_filters();
$arr = ['post_type' => 'post', 'post_status' => 'draft', 'post_name' => $p['slug'], 'post_title' => html_entity_decode($p['title'], ENT_QUOTES, 'UTF-8'),
  'post_content' => $p['content'], 'post_author' => $team->ID, 'post_date' => str_replace('T', ' ', $p['date']), 'post_date_gmt' => str_replace('T', ' ', $p['date_gmt']),
  'comment_status' => 'closed', 'ping_status' => 'closed', 'post_category' => $cat_ids];
if ($ex) $arr['ID'] = $ex->ID;
$id = $ex ? wp_update_post($arr, true) : wp_insert_post($arr, true);
kses_init_filters();
if (is_wp_error($id)) return ['slug' => $p['slug'], 'error' => $id->get_error_message()];
$wpdb->update($wpdb->posts, ['post_status' => 'publish', 'post_name' => $p['slug'], 'post_modified' => str_replace('T', ' ', $p['modified']), 'post_modified_gmt' => str_replace('T', ' ', $p['modified_gmt'])], ['ID' => $id]);
clean_post_cache($id);
if ($thumb) set_post_thumbnail($id, $thumb);
update_post_meta($id, '_yoast_wpseo_title', $p['yoast_title']);
update_post_meta($id, '_yoast_wpseo_metadesc', $p['yoast_desc']);
$mod = substr($p['modified'], 0, 10); if ($mod > substr($p['date'], 0, 10)) update_post_meta($id, 'rl_updated', str_replace('-', '', $mod));
update_post_meta($id, '_rl_carried', ['prod_id' => $p['prod_id'], 'from' => 'https://reinforcelab.com/' . $p['slug'] . '/', 'decision' => 'D-178']);
$wpdb->update($wpdb->posts, ['post_modified' => str_replace('T', ' ', $p['modified']), 'post_modified_gmt' => str_replace('T', ' ', $p['modified_gmt'])], ['ID' => $id]);
clean_post_cache($id);
/* Yoast: rebuild this post's indexable so its titles, dates and status match */
if (function_exists('YoastSEO')) { try { $b = YoastSEO()->classes->get(\\Yoast\\WP\\SEO\\Builders\\Indexable_Builder::class); $r = YoastSEO()->classes->get(\\Yoast\\WP\\SEO\\Repositories\\Indexable_Repository::class); $ix = $r->find_by_id_and_type($id, 'post', false); $b->build_for_id_and_type($id, 'post', $ix ?: false); } catch (\\Throwable $e) {} }
$post = get_post($id);
return ['slug' => $p['slug'], 'id' => $id, 'status' => $post->post_status, 'date' => $post->post_date, 'modified' => $post->post_modified, 'author' => get_the_author_meta('display_name', $post->post_author), 'cats' => wp_get_post_categories($id, ['fields' => 'slugs']), 'thumb' => $thumb, 'url' => get_permalink($id)];""" % b64)


def slugs_from(args):
    if '--all' in args:
        return sorted(os.path.basename(f)[:-5] for f in glob.glob(os.path.join(DATA, '*.json')) if not os.path.basename(f).startswith('_'))
    return [a for a in args if not a.startswith('--')]


if __name__ == '__main__':
    if len(sys.argv) < 3:
        raise SystemExit(__doc__)
    cmd, args = sys.argv[1], sys.argv[2:]
    if cmd == 'clean':
        print(clean(load(args[0])['content']['rendered']))
    elif cmd == 'media':
        for s in slugs_from(args):
            print(s, json.dumps(copy_media(s)))
    elif cmd == 'import':
        for s in slugs_from(args):
            print(json.dumps(import_post(s, '--force' in args), ensure_ascii=False))
    else:
        raise SystemExit(__doc__)
