#!/usr/bin/env python3
"""Apply one hosting draft (post JSON from claude/drafts/hosting/) to an existing post on .online.

Usage: apply-hosting.py <post.json> <post_id> [--list] [--author N] [--dry]
Backs up the live post to claude/data/backups/hosting-rewrite-<today>/, updates content, title, excerpt
and meta in place (post_date, slug and categories untouched, F-003), sets rl_updated to today's real
date, rebuilds the Yoast indexable and purges LiteSpeed. --list: the draft is a list post (rl_l_* meta).
"""
import sys, json, base64, datetime, os, re
sys.path.insert(0, os.path.join(os.path.dirname(__file__)))
import rl
R = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..')) + '/'
a = [x for x in sys.argv[1:] if not x.startswith('--')]
flags = sys.argv[1:]
src, pid = a[0], int(a[1])
author = int(flags[flags.index('--author') + 1]) if '--author' in flags else 0
if author and str(author) == a[-1]: a = a[:-1]
d = json.load(open(R + src if not os.path.isabs(src) else src))
today = datetime.date.today().isoformat()
d['meta']['rl_updated'] = today
body = open(R + d['body_file']).read() if d.get('body_file') else d.get('body', '')
payload = {'id': pid, 'slug': d['slug'], 'title': d['title'], 'excerpt': d['excerpt'], 'content': body, 'meta': d['meta'], 'author': author}
b64 = base64.b64encode(json.dumps(payload).encode()).decode()
bk = R + 'claude/data/backups/hosting-rewrite-%s/' % today
os.makedirs(bk, exist_ok=True)
cur = rl.php("$p=get_post(%d);$m=get_post_meta(%d);return ['post'=>$p,'meta'=>$m];" % (pid, pid))[0]
assert cur['post']['post_name'] == d['slug'], 'slug mismatch'
json.dump(cur, open(bk + 'post-%d-before.json' % pid, 'w'), indent=1, ensure_ascii=False)
if '--dry' in flags:
    print('dry run ok, backup written', bk); sys.exit(0)
code = r'''
global $wpdb; $p=json_decode(base64_decode('%s'),true); $id=$p['id'];
$post=get_post($id); if(!$post||$post->post_name!==$p['slug']||$post->post_status!=='publish') return 'ABORT: slug or status mismatch';
$now=current_time('mysql'); $nowg=current_time('mysql',1);
$row=['post_content'=>$p['content'],'post_title'=>$p['title'],'post_excerpt'=>$p['excerpt'],'post_modified'=>$now,'post_modified_gmt'=>$nowg];
if(!empty($p['author'])) $row['post_author']=$p['author'];
$wpdb->update($wpdb->posts,$row,['ID'=>$id]);
foreach($p['meta'] as $k=>$v) update_post_meta($id,$k,wp_slash($v));
clean_post_cache($id);
try{ $b=YoastSEO()->classes->get(\Yoast\WP\SEO\Builders\Indexable_Builder::class); $i=$b->build_for_id_and_type($id,'post'); if($i) $i->save(); }catch(\Throwable $e){ $y=$e->getMessage(); }
do_action('litespeed_purge_post',$id); do_action('litespeed_purge_all');
return ['ok',$id,get_permalink($id),get_post($id)->post_modified,isset($y)?$y:''];
''' % b64
print(rl.php(code)[0])
