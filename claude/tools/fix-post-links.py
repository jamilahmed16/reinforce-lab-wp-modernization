#!/usr/bin/env python3
"""Fix the internal links inside the old posts carried from production (F-049; Jamil, 23 Oct: "1 yes").

  python3 claude/tools/fix-post-links.py plan     # dry run: what would change, per post (no writes)
  python3 claude/tools/fix-post-links.py apply    # one post at a time, each backed up first
  python3 claude/tools/fix-post-links.py unlink /path/ [/path/ ...]   # make links to these addresses plain text (words kept)

Input: the latest claude/research/link-scan/<date>.json (run claude/tools/link-scan.py first).
Only where each link points changes; the words and the post dates do not:
  * a link to an address that redirects now points straight at the page it ends on (checked to answer 200)
  * a link to an address that is gone (410) is removed; its words stay in the sentence
  * links to the 3 kept posts that are not published yet (404) are left alone
Every post's content is saved to wp-content/novamira-sandbox/_backups/post-links-<date>/<id>.html on the server
before it is changed. Written straight to the database, so the modified date stays as carried (D-178, F-003).
Log: claude/research/link-scan/fixes-<date>.json
"""
import base64
import datetime
import glob
import json
import os
import sys
import urllib.error
import urllib.request

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import rl  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
SCANS = os.path.join(ROOT, 'claude', 'research', 'link-scan')
SITE = 'https://reinforcelab.online'


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *a, **k):
        return None


def status(path):
    try:
        return urllib.request.build_opener(NoRedirect).open(urllib.request.Request(SITE + path, headers={'User-Agent': 'Mozilla/5.0 (rl-fix-links)'}), timeout=60).status
    except urllib.error.HTTPError as e:
        return e.code


def build_map():
    scan = sorted(f for f in glob.glob(os.path.join(SCANS, '20*.json')))[-1]
    d = json.load(open(scan))
    m, left = {}, []
    for r in d['bad_links']:
        if r['status'] == '301' and r['location'] and status(r['location']) == 200:
            m[r['link']] = r['location']
        elif r['status'] == '410':
            m[r['link']] = ''
        else:
            left.append(r['link'])
    return scan, m, left


PHP = r'''
$map = json_decode(base64_decode('%s'), true);
$only = %d;
$apply = %d;
$norm = function ($href) {
    $h = html_entity_decode(trim($href), ENT_QUOTES);
    $h = preg_replace('#^(https?:)?//(www\.)?reinforcelab\.(online|com)#i', '', $h);
    if ($h === '' || $h[0] !== '/') return [null, ''];
    $frag = '';
    if (($p = strpos($h, '#')) !== false) { $frag = substr($h, $p); $h = substr($h, 0, $p); }
    return [$h, $frag];
};
$ids = $only ? [$only] : get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids']);
$out = [];
foreach ($ids as $id) {
    $c = get_post_field('post_content', $id);
    $log = [];
    $new = preg_replace_callback('#<a\b([^>]*?)\bhref=(["\'])(.*?)\2([^>]*)>(.*?)</a>#is', function ($m) use ($map, $norm, &$log) {
        list($path, $frag) = $norm($m[3]);
        if ($path === null || !array_key_exists($path, $map)) return $m[0];
        if ($map[$path] === '') { $log[] = ['unlink', $path, wp_strip_all_tags($m[5])]; return $m[5]; }
        $log[] = ['repoint', $path, $map[$path]];
        return '<a' . $m[1] . 'href=' . $m[2] . esc_attr($map[$path] . $frag) . $m[2] . $m[4] . '>' . $m[5] . '</a>';
    }, $c);
    if (!$log) continue;
    $row = ['id' => $id, 'slug' => get_post_field('post_name', $id), 'changes' => $log];
    if ($apply) {
        global $wpdb;
        $dir = WP_CONTENT_DIR . '/novamira-sandbox/_backups/post-links-' . date('Ymd');
        wp_mkdir_p($dir);
        if (!file_exists($dir . '/' . $id . '.html')) file_put_contents($dir . '/' . $id . '.html', $c);
        $before = get_post_field('post_modified', $id);
        $wpdb->update($wpdb->posts, ['post_content' => $new], ['ID' => $id]);
        clean_post_cache($id);
        do_action('litespeed_purge_post', $id);
        $row['modified_unchanged'] = get_post_field('post_modified', $id) === $before;
        $row['backup'] = $dir . '/' . $id . '.html';
    }
    $out[] = $row;
}
return $out;
'''


def run(only=0, apply=False):
    _, m, _ = MAP
    r, err = rl.php(PHP % (base64.b64encode(json.dumps(m).encode()).decode(), only, 1 if apply else 0), 240)
    if err:
        print('PHP notices:', err)
    return r


def main():
    global MAP
    cmd = sys.argv[1] if len(sys.argv) > 1 else 'plan'
    if cmd == 'unlink':
        paths = sys.argv[2:]
        if not paths:
            raise SystemExit('give the addresses to unlink')
        MAP = ('(command line)', {p: '' for p in paths}, [])
        cmd = 'apply'
    else:
        MAP = build_map()
    scan, m, left = MAP
    print('from', os.path.relpath(scan, ROOT), '|', sum(1 for v in m.values() if v), 'to repoint,', sum(1 for v in m.values() if not v), 'to unlink | left alone (not published yet):', left)
    plan = run()
    n = sum(len(p['changes']) for p in plan)
    print(len(plan), 'posts,', n, 'links')
    if cmd == 'plan':
        for p in plan:
            print(' ', p['id'], p['slug'], len(p['changes']))
        return
    done = []
    for p in plan:
        r = run(p['id'], True)
        row = r[0] if r else {'id': p['id'], 'error': 'nothing changed'}
        code = status('/' + p['slug'] + '/')
        row['status_after'] = code
        done.append(row)
        print(' ', p['id'], p['slug'], len(row.get('changes', [])), 'links | page', code, '| date unchanged', row.get('modified_unchanged'))
        if code != 200 or not row.get('modified_unchanged'):
            print('STOP: check this post before going on')
            break
    day = datetime.date.today().isoformat()
    json.dump(done, open(os.path.join(SCANS, 'fixes-%s.json' % day), 'w'), indent=1)


if __name__ == '__main__':
    main()
