#!/usr/bin/env python3
"""Reinforce Lab ops helper for reinforcelab.online (DEVELOPMENT ONLY, never production).

Every command talks to .online through the Novamira CLI (`novamira run novamira/execute-php`).
Run from the repository root.

  python3 claude/tools/rl.py deploy <file> [<file> ...]     guarded update of existing sandbox files
  python3 claude/tools/rl.py deploy --create <file>          guarded create of a new sandbox file
  python3 claude/tools/rl.py deploy --changed                 deploy every sandbox file that differs from git HEAD
  python3 claude/tools/rl.py parity                           compare live sandbox files with the repo (md5)
  python3 claude/tools/rl.py snapshot                         export pages, Yoast meta, menus, settings to claude/data/online-snapshot/
  python3 claude/tools/rl.py backups [--prune-days N]         list deploy backups on the server, optionally delete ones older than N days
  python3 claude/tools/rl.py crawl                            fetch every published page: em/en dashes, emoji, PHP errors, noindex
  python3 claude/tools/rl.py preview-post <spec.json> <out.html>   render an in-memory post through the live template (writes nothing)

<file> is a path relative to wp/novamira-sandbox/ (e.g. blog/reinforce-post.php) or a repo path.

Safety rules built in:
  * every write aborts unless blog_public = 0 (the site must stay noindex)
  * updates abort unless the live file still matches git HEAD (no overwriting unknown changes)
  * every new file is parse-checked with token_get_all(TOKEN_PARSE) before it is written
  * every overwritten file is copied to novamira-sandbox/_backups/<stamp>/ first (protected by the sandbox .htaccess)
"""
import base64, hashlib, json, os, re, subprocess, sys, tempfile, time, urllib.request

ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..'))
SANDBOX = os.path.join(ROOT, 'wp', 'novamira-sandbox')
SNAP = os.path.join(ROOT, 'claude', 'data', 'online-snapshot')
SITE = 'https://reinforcelab.online'


def php(code, timeout=300):
    """Run PHP on .online through Novamira and return its return_value. Raises on transport errors."""
    with tempfile.NamedTemporaryFile('w', suffix='.json', delete=False) as f:
        json.dump({'code': code}, f)
        path = f.name
    try:
        out = subprocess.run(['novamira', 'run', 'novamira/execute-php', '--yes', '--json', '--quiet', '--input', '@' + path],
                             capture_output=True, text=True, timeout=timeout)
    finally:
        os.unlink(path)
    try:
        data = json.loads(out.stdout)['data']
    except Exception:
        raise SystemExit('novamira call failed:\n' + out.stdout[-2000:] + out.stderr[-2000:])
    return data.get('return_value'), data.get('errors') or []


def rel(p):
    p = os.path.normpath(p)
    if os.path.isabs(p):
        p = os.path.relpath(p, SANDBOX)
    elif p.startswith(os.path.join('wp', 'novamira-sandbox') + os.sep):
        p = os.path.relpath(p, os.path.join('wp', 'novamira-sandbox'))
    return p.replace(os.sep, '/')


def head_md5(r):
    out = subprocess.run(['git', '-C', ROOT, 'show', 'HEAD:wp/novamira-sandbox/' + r], capture_output=True)
    return hashlib.md5(out.stdout).hexdigest() if out.returncode == 0 else None


def b64(s):
    return base64.b64encode(s if isinstance(s, bytes) else s.encode()).decode()


# ---------------------------------------------------------------- deploy
def cmd_deploy(args):
    create = '--create' in args
    files = [a for a in args if not a.startswith('--')]
    if '--changed' in args:
        out = subprocess.run(['git', '-C', ROOT, 'diff', '--name-only', 'HEAD', '--', 'wp/novamira-sandbox'], capture_output=True, text=True).stdout.split()
        files += [f for f in out if os.path.exists(os.path.join(ROOT, f))]
    if not files:
        raise SystemExit('nothing to deploy')
    items = []
    for f in files:
        r = rel(f)
        body = open(os.path.join(SANDBOX, r), 'rb').read()
        expect = None if create else head_md5(r)
        if not create and expect is None:
            raise SystemExit(f'{r} is not in git HEAD; use --create for a new file')
        items.append([r, expect, b64(body)])
    code = r'''
$root = WP_CONTENT_DIR . "/novamira-sandbox/";
if ((string) get_option("blog_public") !== "0") return ["abort" => "site is not noindex"];
$items = json_decode(base64_decode("%s"), true);
foreach ($items as $it) {
  $f = $root . $it[0];
  if ($it[1] === null && file_exists($f)) return ["abort" => "exists: " . $it[0]];
  if ($it[1] !== null && (!file_exists($f) || md5_file($f) !== $it[1])) return ["abort" => "live differs from git HEAD: " . $it[0], "live" => file_exists($f) ? md5_file($f) : null];
  $new = base64_decode($it[2]);
  if (substr($it[0], -4) === ".php") { try { token_get_all($new, TOKEN_PARSE); } catch (ParseError $e) { return ["abort" => "parse: " . $it[0] . ": " . $e->getMessage()]; } }
}
$stamp = gmdate("Ymd-His"); $out = [];
foreach ($items as $it) { $f = $root . $it[0]; if (file_exists($f)) { $b = $root . "_backups/" . $stamp . "/" . $it[0]; wp_mkdir_p(dirname($b)); if (!copy($f, $b)) return ["abort" => "backup failed: " . $it[0]]; } }
foreach ($items as $it) { $f = $root . $it[0]; wp_mkdir_p(dirname($f)); file_put_contents($f, base64_decode($it[2])); if (function_exists("opcache_invalidate")) opcache_invalidate($f, true); $out[$it[0]] = md5_file($f); }
return ["ok" => true, "backup" => "_backups/" . $stamp, "md5" => $out];
''' % b64(json.dumps(items))
    rv, errs = php(code)
    print(json.dumps(rv, indent=1))
    if not rv or not rv.get('ok'):
        sys.exit(1)
    for r, m in rv['md5'].items():
        local = hashlib.md5(open(os.path.join(SANDBOX, r), 'rb').read()).hexdigest()
        print(('OK  ' if local == m else 'MISMATCH ') + r)


# ---------------------------------------------------------------- parity
def live_manifest():
    rv, _ = php(r'''
$root = WP_CONTENT_DIR . "/novamira-sandbox/"; $o = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
foreach ($it as $f) { $r = substr($f->getPathname(), strlen($root)); if (strpos($r, "_backups/") === 0 || strpos($r, ".bak-") !== false) continue; $o[$r] = md5_file($f->getPathname()); }
return $o;''')
    return rv


def cmd_parity(args):
    live = live_manifest()
    repo = {}
    for d, _, fs in os.walk(SANDBOX):
        for f in fs:
            p = os.path.join(d, f)
            repo[os.path.relpath(p, SANDBOX).replace(os.sep, '/')] = hashlib.md5(open(p, 'rb').read()).hexdigest()
    host_files = {'index.html', 'web.config', '.htaccess'}
    bad = 0
    for k in sorted(set(live) | set(repo)):
        if k in host_files and k not in repo:
            continue
        if live.get(k) != repo.get(k):
            bad += 1
            print('DIFF', k, 'live=', live.get(k), 'repo=', repo.get(k))
    print(f'{len(repo)} repo files, {bad} differences')
    sys.exit(1 if bad else 0)


# ---------------------------------------------------------------- snapshot
def cmd_snapshot(args):
    rv, errs = php(r'''
$keys = ["_yoast_wpseo_title","_yoast_wpseo_metadesc","_yoast_wpseo_schema_page_type","_yoast_wpseo_meta-robots-noindex","_yoast_wpseo_canonical"];
$pages = [];
foreach (get_posts(["post_type" => ["page","post"], "post_status" => ["publish","draft","private","pending","future"], "numberposts" => -1, "orderby" => "ID", "order" => "ASC"]) as $p) {
  $m = []; foreach ($keys as $k) { $v = get_post_meta($p->ID, $k, true); if ($v !== "") $m[$k] = $v; }
  $rl = []; foreach (get_post_meta($p->ID) as $k => $v) if (strpos($k, "rl_") === 0) $rl[$k] = maybe_unserialize($v[0]);
  $pages[] = ["id" => $p->ID, "type" => $p->post_type, "status" => $p->post_status, "title" => $p->post_title, "slug" => $p->post_name, "parent" => $p->post_parent,
    "path" => trim(str_replace(home_url("/"), "/", get_permalink($p)), ""), "template" => get_page_template_slug($p) ?: null,
    "content" => $p->post_content, "excerpt" => $p->post_excerpt, "date" => $p->post_date, "modified" => $p->post_modified, "seo" => $m, "rl_fields" => $rl];
}
$menus = [];
foreach (wp_get_nav_menus() as $mn) { $items = [];
  foreach (wp_get_nav_menu_items($mn->term_id) as $i) $items[] = ["id" => $i->ID, "parent" => (int) $i->menu_item_parent, "order" => (int) $i->menu_order, "title" => $i->title, "type" => $i->type, "object" => $i->object, "object_id" => (int) $i->object_id, "url" => $i->url, "classes" => array_values(array_filter((array) $i->classes))];
  $menus[] = ["id" => $mn->term_id, "name" => $mn->name, "slug" => $mn->slug, "items" => $items]; }
$locations = get_nav_menu_locations();
$opts = []; foreach (["blogname","blogdescription","blog_public","show_on_front","page_on_front","page_for_posts","permalink_structure","category_base","tag_base","posts_per_page","timezone_string","date_format","default_category","template","stylesheet"] as $k) $opts[$k] = get_option($k);
$yoast = []; foreach (["wpseo","wpseo_titles","wpseo_social"] as $k) { $v = get_option($k); if (is_array($v)) $yoast[$k] = $v; }
$terms = []; foreach (["category","post_tag"] as $tx) foreach (get_terms(["taxonomy" => $tx, "hide_empty" => false]) as $t) $terms[] = ["taxonomy" => $tx, "id" => $t->term_id, "slug" => $t->slug, "name" => $t->name, "description" => $t->description, "count" => $t->count];
$plugins = get_option("active_plugins");
$layouts = []; foreach (get_posts(["post_type" => "fl-theme-layout", "post_status" => "any", "numberposts" => -1]) as $l) $layouts[] = ["id" => $l->ID, "title" => $l->post_title, "status" => $l->post_status, "type" => get_post_meta($l->ID, "_fl_theme_layout_type", true), "locations" => get_post_meta($l->ID, "_fl_theme_builder_locations", true)];
$rlopts = []; global $wpdb; foreach ($wpdb->get_col("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'rl\\_%'") as $k) $rlopts[$k] = get_option($k);
return ["pages" => $pages, "menus" => $menus, "menu_locations" => $locations, "options" => $opts, "yoast" => $yoast, "terms" => $terms, "active_plugins" => $plugins, "themer_layouts" => $layouts, "rl_options" => $rlopts];
''')
    secret = re.compile(r'(key|token|secret|pass|licen[cs]e|oauth|auth|webhook)', re.I)
    def redact(o, name=''):
        if isinstance(o, dict):
            return {k: redact(v, k) for k, v in o.items()}
        if isinstance(o, list):
            return [redact(v, name) for v in o]
        if secret.search(name) and isinstance(o, str) and o.strip():
            return '[redacted]'
        return o
    for k in ('yoast', 'rl_options', 'options'):
        rv[k] = redact(rv[k])
    os.makedirs(SNAP, exist_ok=True)
    for k, v in rv.items():
        with open(os.path.join(SNAP, k + '.json'), 'w', encoding='utf8') as f:
            json.dump(v, f, indent=1, ensure_ascii=False, sort_keys=(k != 'pages'))
            f.write('\n')
    with open(os.path.join(SNAP, 'sandbox-md5.json'), 'w') as f:
        json.dump(live_manifest(), f, indent=1, sort_keys=True); f.write('\n')
    print('snapshot written to', os.path.relpath(SNAP, ROOT), '| pages:', len(rv['pages']), '| menus:', len(rv['menus']))


# ---------------------------------------------------------------- backups
def cmd_backups(args):
    days = None
    if '--prune-days' in args:
        days = int(args[args.index('--prune-days') + 1])
    rv, _ = php(r'''
$root = WP_CONTENT_DIR . "/novamira-sandbox/"; $days = %s; $cut = $days === null ? null : gmdate("Ymd-His", time() - $days * 86400);
$all = []; $del = [];
foreach (glob($root . "*.bak-*") ?: [] as $f) { if (!preg_match("/\.bak-(\d{8}-\d{6})$/", $f, $m)) continue; $all[] = [$f, $m[1]]; }
$it = is_dir($root . "_backups") ? glob($root . "_backups/*", GLOB_ONLYDIR) : [];
foreach ($it as $d) $all[] = [$d, basename($d)];
foreach ($all as [$p, $st]) { if ($cut !== null && $st < $cut) { if (is_dir($p)) { $ri = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($p, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST); foreach ($ri as $x) $x->isDir() ? rmdir($x) : unlink($x); rmdir($p); } else unlink($p); $del[] = basename($p); } }
return ["total" => count($all), "deleted" => count($del), "kept" => count($all) - count($del), "cutoff" => $cut];
''' % ('null' if days is None else int(days)))
    print(json.dumps(rv, indent=1))


# ---------------------------------------------------------------- crawl
def cmd_crawl(args):
    urls, _ = php('return array_map("get_permalink", get_posts(["post_type" => ["page","post"], "post_status" => "publish", "numberposts" => -1, "fields" => "ids"]));')
    urls = list(urls) + [SITE + '/category/uncategorized/']
    emo = re.compile('[\U0001F000-\U0001FAFF☀-➿️]')
    bad = 0
    for u in urls:
        h = ''
        for t in range(3):
            try:
                h = urllib.request.urlopen(u + ('&' if '?' in u else '?') + 'nc=' + str(time.time()), timeout=60).read().decode('utf8', 'replace')
            except Exception:
                h = ''
            if len(h) > 1000:
                break
        body = re.sub(r'<script[^>]*>.*?</script>', '', h, flags=re.S)
        em = len(re.findall('—|&mdash;|&#8212;', h)); en = len(re.findall('–|&ndash;|&#8211;', h))
        e = emo.findall(body); err = len(re.findall('Fatal error|Warning:|Notice:', h)); noidx = 'noindex' in h
        if em or en or e or err or not noidx or len(h) < 1000:
            bad += 1
            print('FLAG', u, 'len', len(h), 'em', em, 'en', en, 'emoji', e[:3], 'php', err, 'noindex', noidx)
    print(f'checked {len(urls)} pages, {bad} flagged')
    sys.exit(1 if bad else 0)


# ---------------------------------------------------------------- preview-post
def cmd_preview_post(args):
    """spec.json: {"title": "...", "excerpt": "...", "body_file": "path.html" | "body": "<p>..", "meta": {"rl_type": "guide", ...}}"""
    spec = json.load(open(args[0], encoding='utf8'))
    body = spec.get('body') or open(spec['body_file'], encoding='utf8').read()
    code = r'''
$id = 990001; $s = json_decode(base64_decode("%s"), true); $meta = $s["meta"];
add_filter("wpseo_should_save_indexable", "__return_false"); add_filter("wpseo_frontend_presenters", "__return_empty_array");
$p = new WP_Post((object)["ID"=>$id,"post_author"=>3,"post_date"=>$s["date"] ?? "2026-09-15 10:00:00","post_date_gmt"=>$s["date"] ?? "2026-09-15 10:00:00","post_modified"=>$s["date"] ?? "2026-09-15 10:00:00","post_modified_gmt"=>$s["date"] ?? "2026-09-15 10:00:00","post_title"=>$s["title"],"post_content"=>$s["body"],"post_excerpt"=>$s["excerpt"] ?? "","post_status"=>"publish","post_type"=>"post","post_name"=>"preview","post_parent"=>0,"menu_order"=>0,"comment_status"=>"closed","ping_status"=>"closed","comment_count"=>0,"guid"=>"","post_mime_type"=>"","filter"=>"raw"]);
wp_cache_set($id, $p, "posts");
add_filter("get_post_metadata", function ($v, $oid, $key, $single) use ($id, $meta) { if ((int) $oid !== $id) return $v; if ($key === "") return array_map(function ($x) { return [$x]; }, $meta); if (!isset($meta[$key])) return $single ? "" : []; return [$meta[$key]]; }, 1, 4);
global $wp_query, $wp_the_query, $post;
$wp_query = new WP_Query(); $wp_query->query_vars = $wp_query->fill_query_vars([]); $wp_query->posts = [$p]; $wp_query->post = $p; $wp_query->post_count = 1; $wp_query->found_posts = 1;
$wp_query->is_single = true; $wp_query->is_singular = true; $wp_query->queried_object = $p; $wp_query->queried_object_id = $id; $wp_the_query = $wp_query; $post = $p;
ob_start(); rl_post_output(); $html = ob_get_clean();
$g = apply_filters("wpseo_schema_graph", [["@type"=>"Article","@id"=>"x#article"], ["@type"=>"Person","@id"=>rl_person_schema_id(3),"name"=>"Jamil Ahmed"]], null);
return ["html" => $html, "schema" => $g];
''' % b64(json.dumps({**spec, 'body': body}))
    rv, errs = php(code)
    open(args[1], 'w', encoding='utf8').write(rv['html'])
    print('written', args[1], len(rv['html']), 'bytes')
    print('schema nodes:', [n['@type'] for n in rv['schema']])
    json.dump(rv['schema'], open(args[1] + '.schema.json', 'w', encoding='utf8'), indent=1)
    real = [e['message'] for e in errs if 'update_post_' not in e['message']]
    print('php notices from the template:', real or 'none (in-memory query warnings ignored)')


if __name__ == '__main__':
    cmds = {'deploy': cmd_deploy, 'parity': cmd_parity, 'snapshot': cmd_snapshot, 'backups': cmd_backups, 'crawl': cmd_crawl, 'preview-post': cmd_preview_post}
    if len(sys.argv) < 2 or sys.argv[1] not in cmds:
        print(__doc__); sys.exit(2)
    cmds[sys.argv[1]](sys.argv[2:])
