#!/usr/bin/env python3
"""Export everything we built on reinforcelab.online AS DATA ONLY, for the clean rebuild (F-035, launch plan 18 Oct 2026).

Writes claude/data/site-export/:
  posts.json        pages, posts, projects, attachments, menu items, Themer layout, ACF field setup, custom CSS (rows + filtered meta)
  terms.json        categories and menus, with which post is in which
  options.json      the settings the site needs (allowlist; no licence keys, tokens or secrets)
  option-names.json every option name on .online (names only), so nothing is missed by the allowlist
  users.json        the authors posts point at (no passwords, no sessions, no application passwords)
  uploads.json      manifest of media files safe to bring across (images, PDFs, fonts) with size and sha1
  scan.json         every exported field that contains script, iframe, PHP or obfuscation patterns, for review
  README.md         what is here and what was deliberately left out

Read-only on .online: only SELECTs and file reads run through Novamira.
Usage: python3 claude/tools/export-site.py
"""
import base64, hashlib, importlib.util, json, os, re, sys

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
OUT = os.path.join(ROOT, 'claude', 'data', 'site-export')
spec = importlib.util.spec_from_file_location('rl', os.path.join(ROOT, 'claude', 'tools', 'rl.py'))
rl = importlib.util.module_from_spec(spec); spec.loader.exec_module(rl)

TYPES = ['page', 'post', 'rl_project', 'attachment', 'nav_menu_item', 'fl-theme-layout', 'acf-field-group', 'acf-field', 'acf-post-type', 'custom_css']
STATUSES = ['publish', 'draft', 'inherit', 'private']
SKIP_META = r'^(_edit_lock|_edit_last|_wp_trash_meta_.*|_yoast_indexnow_.*|_jetpack_.*|_fl_builder_draft.*|_design_last_actor|_wp_old_date|_encloseme|_pingme)$'


def php(code, timeout=600):
    r, err = rl.php(code, timeout=timeout)
    if err: raise SystemExit('PHP errors: %r' % (err,))
    return r


def ids():
    t = "','".join(TYPES); s = "','".join(STATUSES)
    return php("global $wpdb; return array_map('intval', $wpdb->get_col(\"SELECT ID FROM $wpdb->posts WHERE post_type IN ('%s') AND post_status IN ('%s') ORDER BY ID\"));" % (t, s))


def posts(all_ids):
    out = []
    for i in range(0, len(all_ids), 25):
        batch = all_ids[i:i + 25]
        code = r'''global $wpdb; $out = [];
foreach (%s as $id) { $p = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID=%%d", $id), ARRAY_A);
  $m = []; foreach ($wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%%d ORDER BY meta_id", $id), ARRAY_A) as $r) {
    if (preg_match('/%s/', $r['meta_key'])) continue; $m[] = [$r['meta_key'], $r['meta_value']]; }
  $p['meta'] = $m; $out[] = $p; }
return base64_encode(gzcompress(json_encode($out)));''' % (json.dumps(batch), SKIP_META.replace('/', '\\/'))
        import zlib
        out += json.loads(zlib.decompress(base64.b64decode(php(code))))
        print('  posts', min(i + 25, len(all_ids)), '/', len(all_ids), file=sys.stderr)
    for p in out:  # drop fields that are per-install noise
        for k in ('guid', 'ping_status', 'to_ping', 'pinged', 'post_content_filtered', 'post_password'): p.pop(k, None)
    return out


def terms():
    return php(r'''global $wpdb; $o = [];
$o['terms'] = $wpdb->get_results("SELECT t.term_id, t.name, t.slug, tt.term_taxonomy_id, tt.taxonomy, tt.description, tt.parent FROM $wpdb->terms t JOIN $wpdb->term_taxonomy tt ON tt.term_id=t.term_id WHERE tt.taxonomy IN ('category','post_tag','nav_menu') ORDER BY t.term_id", ARRAY_A);
$o['relationships'] = $wpdb->get_results("SELECT tr.object_id, tr.term_taxonomy_id, tr.term_order FROM $wpdb->term_relationships tr JOIN $wpdb->term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id WHERE tt.taxonomy IN ('category','post_tag','nav_menu')", ARRAY_A);
$o['termmeta'] = $wpdb->get_results("SELECT term_id, meta_key, meta_value FROM $wpdb->termmeta", ARRAY_A);
$o['nav_menu_locations'] = get_theme_mod('nav_menu_locations');
return $o;''')


ALLOW = [r'^(blogname|blogdescription|permalink_structure|category_base|tag_base|show_on_front|page_on_front|page_for_posts|posts_per_page|posts_per_rss|rss_use_excerpt|timezone_string|gmt_offset|date_format|time_format|start_of_week|site_icon|wp_page_for_privacy_policy|sticky_posts|default_category|thumbnail_size_w|thumbnail_size_h|thumbnail_crop|medium_size_w|medium_size_h|medium_large_size_w|medium_large_size_h|large_size_w|large_size_h|uploads_use_yearmonth_folders|default_comment_status|default_ping_status|comment_registration|close_comments_for_old_posts|show_avatars|blog_public|nav_menu_options|template|stylesheet|WPLANG)$',
         r'^theme_mods_', r'^rl_(?!menu_backup|metadesc_backup|reading_backup)', r'^reinforcelab_', r'^wpseo(_titles|_social|_premium|-premium-redirects-base|-premium-redirects-export-plain|-premium-redirects-export-regex)?$',
         r'^_fl_builder_(?!.*license)', r'^fl_builder_(?!.*license)', r'^fl_theme_builder_(?!.*license)', r'^bbpowerpack_(?!.*license)', r'^pp_(?!.*license)', r'^litespeed\.conf\.', r'^acf_(version|first_activated_version)$']
DENY = r'(\.hash$|license|licence|_key$|api_key|token|secret|password|passwd|auth|nonce|salt|private|jetpack|novamira|mcp|hostinger|cloudflare|session|transient|cron|recently_|_backup_|wpseo_ms|indexnow)'


def options():
    names = php("global $wpdb; return $wpdb->get_col(\"SELECT option_name FROM $wpdb->options WHERE option_name NOT LIKE '\\\\_transient%' AND option_name NOT LIKE '\\\\_site\\\\_transient%' ORDER BY option_name\");")
    keep = [n for n in names if any(re.search(a, n) for a in ALLOW) and not re.search(DENY, n, re.I)]
    vals = php("$o = []; foreach (%s as $n) $o[$n] = get_option($n); return $o;" % json.dumps(keep))
    # second guard: scrub any nested key that looks like a credential
    def scrub(v):
        if isinstance(v, dict): return {k: ('[removed]' if re.search(DENY, str(k), re.I) and k not in ('stripcategorybase',) else scrub(x)) for k, x in v.items()}
        if isinstance(v, list): return [scrub(x) for x in v]
        return v
    return names, {k: scrub(v) for k, v in vals.items()}


def users(post_rows):
    authors = sorted({int(p['post_author']) for p in post_rows if int(p['post_author'] or 0)})
    return php(r'''$o = []; foreach (%s as $id) { $u = get_userdata($id); if (!$u) continue;
  $o[] = ['ID' => $u->ID, 'user_login' => $u->user_login, 'user_nicename' => $u->user_nicename, 'display_name' => $u->display_name, 'user_email' => $u->user_email, 'roles' => $u->roles,
          'first_name' => $u->first_name, 'last_name' => $u->last_name, 'description' => $u->description, 'user_url' => $u->user_url]; } return $o;''' % json.dumps(authors))


SAFE_EXT = r'\.(jpe?g|png|gif|webp|avif|ico|pdf|woff2?|ttf)$'


def uploads():
    return php(r'''$b = wp_upload_dir()['basedir']; $o = []; $skipped = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($b, FilesystemIterator::SKIP_DOTS));
foreach ($it as $f) { if (!$f->isFile()) continue; $rel = ltrim(str_replace('\\', '/', substr($f->getPathname(), strlen($b))), '/');
  if (preg_match('#^(bb-plugin|bb-theme|bbpowerpack|wpseo-redirects|litespeed)/#', $rel)) { $skipped[] = $rel . ' (generated by a plugin, rebuilt on the new site)'; continue; }
  if (preg_match('/\\.svg$/i', $rel)) { $c = file_get_contents($f->getPathname()); if (preg_match('/<script|javascript:|\\son[a-z]+\\s*=|<foreignObject|<iframe|xlink:href\\s*=\\s*["\']\\s*(?!#|data:image)/i', $c)) { $skipped[] = $rel . ' (svg with script or external reference)'; continue; } }
  elseif (!preg_match('/%s/i', $rel)) { $skipped[] = $rel; continue; }
  $h = file_get_contents($f->getPathname(), false, null, 0, 16); $sig = bin2hex(substr($h, 0, 4));
  $o[] = ['path' => $rel, 'bytes' => $f->getSize(), 'sha1' => sha1_file($f->getPathname()), 'magic' => $sig]; }
usort($o, function ($a, $b) { return strcmp($a['path'], $b['path']); });
return ['files' => $o, 'skipped' => $skipped];''' % SAFE_EXT.replace('/', '\\/'), timeout=900)


MAGIC = {'jpg': ('ffd8ff',), 'jpeg': ('ffd8ff',), 'png': ('89504e47',), 'gif': ('47494638',), 'webp': ('52494646',), 'pdf': ('25504446',), 'ico': ('00000100',), 'woff2': ('774f4632',), 'woff': ('774f4646',), 'ttf': ('00010000', '74727565'), 'avif': ('',), 'svg': ('3c3f786d', '3c737667', '3c212d2d', 'efbbbf3c')}
RISK = re.compile(r'<\?php|<script\b|javascript:|\bon(load|error|click|mouseover)\s*=|<iframe\b|eval\s*\(|base64_decode|gzinflate|str_rot13|document\.write|unyu168|gacoan|wordpless|wp-ads\.net', re.I)


def scan(post_rows, opts):
    hits = []
    def check(where, text):
        if not isinstance(text, str): text = json.dumps(text, ensure_ascii=False)
        for m in RISK.finditer(text):
            hits.append({'where': where, 'match': m.group(0), 'context': text[max(0, m.start() - 80):m.end() + 80]})
    for p in post_rows:
        check('%s %s %s content' % (p['post_type'], p['ID'], p['post_name']), p['post_content'])
        check('%s %s excerpt' % (p['post_type'], p['ID']), p['post_excerpt'])
        for k, v in p['meta']: check('%s %s meta %s' % (p['post_type'], p['ID'], k), v)
    for k, v in opts.items(): check('option ' + k, v)
    return hits


def main():
    os.makedirs(OUT, exist_ok=True)
    w = lambda name, data: json.dump(data, open(os.path.join(OUT, name), 'w'), indent=1, ensure_ascii=False, sort_keys=False)
    all_ids = ids(); print('rows:', len(all_ids), file=sys.stderr)
    P = posts(all_ids); w('posts.json', P)
    T = terms(); w('terms.json', T)
    names, O = options(); w('options.json', O); w('option-names.json', names)
    U = users(P); w('users.json', U)
    up = uploads()
    bad_magic = [f['path'] for f in up['files'] if not any(f['magic'].startswith(m) for m in MAGIC.get(f['path'].rsplit('.', 1)[-1].lower(), ('',)))]
    up['wrong_type'] = bad_magic; w('uploads.json', up)
    S = scan(P, O); w('scan.json', S)
    by = {}
    for p in P: by[p['post_type']] = by.get(p['post_type'], 0) + 1
    print(json.dumps({'posts_by_type': by, 'terms': len(T['terms']), 'options': len(O), 'option_names': len(names), 'users': [u['user_login'] for u in U],
                      'upload_files': len(up['files']), 'upload_mb': round(sum(f['bytes'] for f in up['files']) / 1048576, 1), 'uploads_skipped': len(up['skipped']),
                      'wrong_type': bad_magic, 'scan_hits': len(S)}, indent=1))


if __name__ == '__main__':
    main()
