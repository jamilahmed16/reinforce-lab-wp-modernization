#!/usr/bin/env python3
"""Replace post cover (featured) images on reinforcelab.online, in batches. Development only (D-251).

  python3 claude/tools/covers.py list                       every published post: id, type, cover, size
  python3 claude/tools/covers.py render <batch> <id> ...    write the cover JPEGs to claude/design-previews/covers/<batch>/
  python3 claude/tools/covers.py apply  <batch> <id> ...    BACK UP the old covers (zip + manifest into claude/data/backups/),
                                                            upload the new ones, set them as the cover. Post text and dates untouched.
  python3 claude/tools/covers.py delete <batch> <id> ...    delete the OLD cover attachments of a verified batch (never one that is
                                                            also used inside post text or by another post).
Permalinks never change. Nothing here touches reinforcelab.com.
"""
import base64, json, os, re, subprocess, sys
sys.path.insert(0, os.path.dirname(__file__))
import rl

ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..'))
PREV = os.path.join(ROOT, 'claude', 'design-previews', 'covers')
BACK = os.path.join(ROOT, 'claude', 'data', 'backups')
TYPES = {'guide': 'Guide', 'explainer': 'Explainer', 'howto': 'How-to', 'list': 'List', 'industry': 'Industry guide', 'checklist': 'Checklist',
         'comparison': 'Comparison', 'opinion': 'Opinion', 'updates': 'Updates', 'review': 'Review', 'research': 'Research', 'casestudy': 'Case study', 'product': 'Product guide'}
THEMES = {'green': {'c': '#3fae7f', 'e': '#78cfa7', 't': '#23805a', 'g': '35,128,90'}}  # D-266: set COVER_THEME=green
SAFE = r'''if (get_option('blog_public') !== '0' || home_url() !== 'https://reinforcelab.online') return 'ABORT: not the dev site';'''


def clean(t):
    t = re.sub(r'\s*[|\u2013\u2014]\s*Reinforce Lab.*$', '', t)
    t = t.replace('\u2013', ':').replace('\u2014', ':')
    t = re.sub(r'\b(20(2[3-6]))\b', '', t)
    t = re.sub(r'(?:\s+(?:in|for|of|to|on|at|by|with|and|the|a))+\s*$', '', t, flags=re.I)  # a stripped year can leave a dangling word
    t = re.sub(r'\s*:\s*', ': ', t)
    t = re.sub(r'\s+', ' ', t).strip(' :')
    return t


def split(t):
    if ': ' in t:
        a, b = t.split(': ', 1)
        return a.strip(), b.strip()
    w = t.split()
    k = (len(w) + 1) // 2
    return ' '.join(w[:k]), ' '.join(w[k:])


def posts():
    rv, _ = rl.php(r'''
$out = []; $q = new WP_Query(array('post_type'=>'post','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'ID','order'=>'ASC'));
foreach ($q->posts as $p) { $tid = get_post_thumbnail_id($p->ID); $mc = function_exists('rl_post_main_cat') ? rl_post_main_cat($p->ID) : null;
  $out[] = array('id'=>$p->ID,'slug'=>$p->post_name,'title'=>$p->post_title,'type'=>(string) get_post_meta($p->ID,'rl_type',true),'cat'=>$mc ? $mc->name : '','thumb'=>(int) $tid,'modified'=>$p->post_modified,'kw'=>(string) get_post_meta($p->ID,'_yoast_wpseo_focuskw',true)); }
return $out;''')
    return rv


def pick_hl(full, kw):
    f = full.lower()
    if kw and kw.lower() in f and len(kw) <= 0.7 * len(full):
        i = f.index(kw.lower()); return full[i:i + len(kw)]
    if kw and kw.lower() in f:  # the keyword is nearly the whole title: highlight its last three words
        return ' '.join(full.rstrip('?!.').split()[-3:])
    if ': ' in full:
        head = full.split(': ')[0].split()
        return ' '.join(head if len(head) <= 4 else head[-3:])
    w = [x for x in full.split() if not x.isdigit()]
    return ' '.join(w[:3])


def jobs_for(ids):
    by = {p['id']: p for p in posts()}
    jobs = []
    for i in ids:
        p = by[i]
        w, r = split(clean(p['title']))
        eb = TYPES.get(p['type'], 'Article').upper()
        if p['cat'] and p['cat'] != 'Uncategorized':
            eb += ' · ' + p['cat'].upper()
        extra = {}
        if os.environ.get('COVER_THEME') in THEMES:
            extra = {'accent': THEMES[os.environ['COVER_THEME']], 'glow': 0.22, 'hl': pick_hl(clean(p['title']), p.get('kw', '')), 'sep': ': ' if ': ' in clean(p['title']) else ' '}
        jobs.append({**extra, 'id': i, 'eyebrow': eb, 'white': w, 'red': r, 'alt': 'Cover image: ' + clean(p['title']), 'slug': p['slug'], 'old': p['thumb'], 'modified': p['modified']})
    return jobs


def render(batch, ids):
    out = os.path.join(PREV, batch); os.makedirs(out, exist_ok=True)
    jobs = jobs_for(ids)
    jf = os.path.join(out, 'jobs.json'); json.dump(jobs, open(jf, 'w'), indent=1)
    subprocess.run(['node', os.path.join(ROOT, 'claude/tools/covers.mjs'), jf, out], check=True)
    return jobs, out


def apply(batch, ids):
    jobs, out = render(batch, ids)
    # 1) back up the old covers first (zip of every size + manifest), then 2) upload the new ones
    old = [j['old'] for j in jobs if j['old']]
    rv, berr = rl.php(r'''
%s
$ids = json_decode(base64_decode("%s"), true); $man = []; $zipPath = wp_tempnam('covers.zip'); $z = new ZipArchive(); $z->open($zipPath, ZipArchive::OVERWRITE);
$up = wp_get_upload_dir(); $base = trailingslashit($up['basedir']);
foreach ($ids as $aid) { $f = get_attached_file($aid); $m = wp_get_attachment_metadata($aid); $files = array();
  if ($f && file_exists($f)) { $files[] = $f; if (!empty($m['sizes'])) foreach ($m['sizes'] as $s) { $sf = dirname($f) . '/' . $s['file']; if (file_exists($sf)) $files[] = $sf; } }
  foreach ($files as $x) $z->addFile($x, 'uploads/' . ltrim(str_replace($base, '', $x), '/'));
  $a = get_post($aid); $man[] = array('attachment_id'=>$aid,'file'=>$f ? str_replace($base,'',$f) : null,'url'=>wp_get_attachment_url($aid),'title'=>$a ? $a->post_title : '','alt'=>get_post_meta($aid,'_wp_attachment_image_alt',true),'date'=>$a ? $a->post_date : '','parent'=>$a ? $a->post_parent : 0,'files'=>array_map(function($x) use ($base){return str_replace($base,'',$x);}, $files)); }
$z->close(); $b = base64_encode(file_get_contents($zipPath)); unlink($zipPath);
return array('manifest'=>$man,'zip'=>$b);''' % (SAFE, rl.b64(json.dumps(old))))
    if not isinstance(rv, dict):
        raise SystemExit('backup failed: %r %r' % (rv, berr))
    zp = os.path.join(BACK, f'cover-images-{batch}-before-2026-11-13.zip'); open(zp, 'wb').write(base64.b64decode(rv['zip']))
    man = {'batch': batch, 'posts': {j['id']: j['old'] for j in jobs}, 'old_attachments': rv['manifest']}
    json.dump(man, open(os.path.join(BACK, f'cover-images-{batch}-before-2026-11-13.json'), 'w'), indent=1)
    print('backup:', zp, os.path.getsize(zp) // 1024, 'KB;', len(rv['manifest']), 'old attachments')
    payload = [{'id': j['id'], 'slug': j['slug'], 'alt': j['alt'], 'img': base64.b64encode(open(os.path.join(out, f"cover-{j['id']}.jpg"), 'rb').read()).decode()} for j in jobs]
    rv2, _ = rl.php(r'''
%s
require_once ABSPATH.'wp-admin/includes/image.php'; require_once ABSPATH.'wp-admin/includes/file.php'; require_once ABSPATH.'wp-admin/includes/media.php';
$items = json_decode(base64_decode("%s"), true); $res = array();
foreach ($items as $it) { $id = $it['id']; $p = get_post($id); if (!$p) { $res[] = array($id, 'missing'); continue; } $mod = $p->post_modified; $old = get_post_thumbnail_id($id);
  $u = wp_upload_bits('cover-' . $it['slug'] . '.jpg', null, base64_decode($it['img'])); if (!empty($u['error'])) { $res[] = array($id, 'ERR ' . $u['error']); continue; }
  $aid = wp_insert_attachment(array('post_mime_type'=>'image/jpeg','post_title'=>'Cover: ' . $p->post_title,'post_status'=>'inherit'), $u['file'], $id);
  wp_update_attachment_metadata($aid, wp_generate_attachment_metadata($aid, $u['file'])); update_post_meta($aid, '_wp_attachment_image_alt', $it['alt']);
  set_post_thumbnail($id, $aid);
  $og = get_post_meta($id, '_yoast_wpseo_opengraph-image', true); if ($og) { update_post_meta($id, '_yoast_wpseo_opengraph-image', $u['url']); update_post_meta($id, '_yoast_wpseo_opengraph-image-id', $aid); }
  clean_post_cache($id); $res[] = array($id, 'ok', $aid, $old, get_post($id)->post_modified === $mod ? 'modified-unchanged' : 'MODIFIED-CHANGED'); }
do_action('litespeed_purge_all'); return $res;''' % (SAFE, rl.b64(json.dumps(payload))))
    for r in rv2:
        print(r)
    reindex([r[0] for r in rv2 if r[1] == 'ok'])
    man['new'] = {r[0]: r[2] for r in rv2 if r[1] == 'ok'}
    json.dump(man, open(os.path.join(BACK, f'cover-images-{batch}-before-2026-11-13.json'), 'w'), indent=1)


def reindex(ids):
    """Rebuild Yoast's cached indexable of each post, so og:image, twitter:image and the sitemap image follow the new cover.
    Writes only Yoast's own table; post text and dates are untouched."""
    rv, err = rl.php(r'''
%s
$res = array(); foreach (json_decode(base64_decode("%s"), true) as $id) {
  try { $b = YoastSEO()->classes->get(\Yoast\WP\SEO\Builders\Indexable_Builder::class); $r = YoastSEO()->classes->get(\Yoast\WP\SEO\Repositories\Indexable_Repository::class);
    $ind = $r->find_by_id_and_type($id, 'post', false); $ind = $b->build_for_id_and_type($id, 'post', $ind); $ind->save(); $res[] = array($id, $ind->open_graph_image, $ind->twitter_image);
  } catch (\Throwable $e) { $res[] = array($id, 'ERR ' . $e->getMessage()); } }
do_action('litespeed_purge_all'); return $res;''' % (SAFE, rl.b64(json.dumps(ids))))
    for r in rv or []:
        print(r)


def delete(batch, ids):
    man = json.load(open(os.path.join(BACK, f'cover-images-{batch}-before-2026-11-13.json')))
    old = [man['posts'][str(i)] for i in ids if man['posts'].get(str(i))]
    rv, _ = rl.php(r'''
%s
global $wpdb; $res = array(); $olds = json_decode(base64_decode("%s"), true); $pids = json_decode(base64_decode("%s"), true);
foreach ($olds as $aid) { $f = get_attached_file($aid); $base = $f ? pathinfo($f, PATHINFO_FILENAME) : '';
  $cur = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key='_thumbnail_id' AND meta_value=%%d", $aid));
  $body = $base ? (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status IN ('publish','draft','private') AND post_type IN ('post','page') AND post_content LIKE %%s", '%%' . $wpdb->esc_like($base) . '%%')) : 0;
  $og = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key IN ('_yoast_wpseo_opengraph-image-id','_yoast_wpseo_twitter-image-id') AND meta_value=%%d", $aid));
  if ($cur || $body || $og) { $res[] = array($aid, 'KEPT', 'still cover of ' . $cur . ', in text of ' . $body . ', og ' . $og); continue; }
  $res[] = array($aid, wp_delete_attachment($aid, true) ? 'deleted' : 'FAILED'); }
do_action('litespeed_purge_all'); return $res;''' % (SAFE, rl.b64(json.dumps(old)), rl.b64(json.dumps(ids))))
    for r in rv:
        print(r)


if __name__ == '__main__':
    c, a = sys.argv[1], sys.argv[2:]
    if c == 'list':
        for p in posts():
            print(p['id'], p['type'], p['thumb'], p['title'][:70])
    elif c == 'render':
        jobs, out = render(a[0], [int(x) for x in a[1:]]); [print(j['id'], j['eyebrow'], '|', j['white'], '/', j['red']) for j in jobs]
    elif c == 'apply':
        apply(a[0], [int(x) for x in a[1:]])
    elif c == 'reindex':
        reindex([int(x) for x in a])
    elif c == 'delete':
        delete(a[0], [int(x) for x in a[1:]])
    else:
        print(__doc__)
