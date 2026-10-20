#!/usr/bin/env python3
"""Security clean-up of reinforcelab.online (D-197, findings F-035 and F-036).

Runs on .online only, through Novamira (rl.php). Never touches reinforcelab.com.

Steps, run one at a time, each followed by its own check:
  users     delete the 5 attacker admin accounts, give their content to jamilahmed (ID 3),
            then log every user out (all sessions destroyed)
  files     move the planted plugins, mu-plugin, cache file, zip and theme into quarantine
  wpconfig  remove the planted include line, rotate the 8 salts (logs everyone out again)
  cron      remove the 5 planted scheduled tasks
  verify    re-run the full sweep and check the site answers 200

Without --apply a step only reports what it would do. Nothing secret is ever printed.
Everything moved or replaced is kept in the quarantine folder, outside public_html.

  python3 claude/tools/cleanup-online.py users            # dry run
  python3 claude/tools/cleanup-online.py users --apply    # do it
"""
import argparse
import importlib.util
import json
import os
import sys
import urllib.request

HERE = os.path.dirname(os.path.abspath(__file__))
spec = importlib.util.spec_from_file_location('rl', os.path.join(HERE, 'rl.py'))
rl = importlib.util.module_from_spec(spec)
spec.loader.exec_module(rl)

SITE = 'https://reinforcelab.online'
Q = '/home/u256952650/quarantine-reinforcelab-online-2026-10-18'

# Attacker accounts: ID, login and email must all match before anything is deleted.
ROGUE = [
    (4, 'WordPress Support', 'support@wordpless.org'),
    (5, 'reinforcelab', 'reinforcelab@wp-ads.net'),
    (6, 'd6bvip8jhrd', 'd6bvip8jhrd@reinforcelab.online'),
    (7, 'ogbn0f5ynf', 'ogbn0f5ynf@reinforcelab.online'),
    (10, 'root', 'admin@wordpress.com'),
]
KEEP = {1: 'jadirectives@gmail.com', 3: 'jamilahmed', 9: 'reinforcelab-team'}
REASSIGN_TO = 3

# Paths relative to wp-content.
PLANTED = [
    'mu-plugins/health-check-api.php',
    'plugins/lunar-profiler-ink',
    'plugins/nimble-router-mod',
    'plugins/onyx-store-tag',
    'plugins/pulse-cache-ink',
    'plugins/event',
    'cache/2704f406.php',
    'uploads/2026/08/ab5c7c9b.zip',
    'themes/wise-news',
]

BAD_LINE = '@include_once(__DIR__ . "/wp-includes/class-wp-cache.php");'
SALTS = ['AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY',
         'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT']

BAD_CRON = ['_1sgjdxjsuyxct0tzy8', 'h072tqv7v631md8u', 'fxuh8e_9aidtaz1m',
            'run_weekly_partner_astra', 'puc_cron_check_updates-hostinger-ai-assistant']


def run(code):
    r, errors = rl.php(code)
    if errors:
        sys.exit('PHP errors:\n' + json.dumps(errors, indent=1))
    return r


def php_str(s):
    return "'" + s.replace('\\', '\\\\').replace("'", "\\'") + "'"


def php_arr(items):
    return '[' + ','.join(php_str(i) for i in items) + ']'


def show(title, data):
    print('\n== ' + title)
    print(json.dumps(data, indent=1))


# ---------- users ----------

def users(apply):
    rogue = '[' + ','.join('[%d,%s,%s]' % (i, php_str(l), php_str(e)) for i, l, e in ROGUE) + ']'
    keep = '[' + ','.join('%d=>%s' % (i, php_str(l)) for i, l in KEEP.items()) + ']'
    code = r'''
require_once ABSPATH . 'wp-admin/includes/user.php';
$apply = %s; $rogue = %s; $keep = %s; $to = %d; $q = %s;
$out = ['plan' => [], 'refused' => []];
if (!is_dir($q) || !file_exists($q . '/db-users.json') || !file_exists($q . '/db-usermeta.json')) return ['abort' => 'user backup missing in quarantine'];
foreach ($keep as $id => $login) { $u = get_userdata($id); if (!$u || $u->user_login !== $login) return ['abort' => "keep account $id ($login) not found as expected"]; }
foreach ($rogue as [$id, $login, $email]) {
  $u = get_userdata($id);
  if (!$u) { $out['plan'][] = [$id, $login, 'already gone']; continue; }
  if ($u->user_login !== $login || $u->user_email !== $email || isset($keep[$id])) { $out['refused'][] = [$id, $u->user_login, 'login or email does not match, left alone']; continue; }
  $posts = (int) $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT COUNT(*) FROM {$GLOBALS['wpdb']->posts} WHERE post_author=%%d", $id));
  $out['plan'][] = [$id, $login, "delete, $posts posts/attachments to user $to"];
  if ($apply) {
    WP_Session_Tokens::get_instance($id)->destroy_all();
    $ok = wp_delete_user($id, $to);
    $out['done'][] = [$id, $login, $ok ? 'deleted' : 'FAILED'];
  }
}
if ($apply) { WP_Session_Tokens::destroy_all_for_all_users(); $out['sessions'] = 'all sessions destroyed (everyone logged out)'; }
$check = [];
foreach (get_users(['fields' => ['ID', 'user_login', 'user_email']]) as $x) { $u = get_userdata($x->ID); $check[] = [$x->ID, $x->user_login, implode(',', $u->roles)]; }
$out['users_now'] = $check;
$out['admins_now'] = count(get_users(['role' => 'administrator']));
return $out;
''' % ('true' if apply else 'false', rogue, keep, REASSIGN_TO, php_str(Q))
    r = run(code)
    show('users' + ('' if apply else ' (dry run)'), r)
    if apply and isinstance(r, dict):
        left = [u for u in r.get('users_now', []) if int(u[0]) in [x[0] for x in ROGUE]]
        print('\nCHECK:', 'PASS, no attacker account left' if not left else 'FAIL, still present: %s' % left)


# ---------- files ----------

def files(apply):
    code = r'''
$apply = %s; $paths = %s; $q = %s; $wc = WP_CONTENT_DIR;
if (!is_dir($q) || !file_exists($q . '/.htaccess')) return ['abort' => 'quarantine folder missing'];
$active = get_option('active_plugins'); $out = ['plan' => []];
foreach ($paths as $p) {
  $src = $wc . '/' . $p; $dst = $q . '/files/wp-content/' . $p;
  if (strpos($p, 'plugins/') === 0) { foreach ($active as $a) { if (strpos($a, substr($p, 8) . '/') === 0) return ['abort' => "$p is an active plugin, not moving"]; } }
  if ($p === 'themes/wise-news' && in_array(get_stylesheet(), ['wise-news'], true)) return ['abort' => 'wise-news is the active theme'];
  if (!file_exists($src)) { $out['plan'][] = [$p, file_exists($dst) ? 'already in quarantine' : 'not found']; continue; }
  if (file_exists($dst)) { $out['plan'][] = [$p, 'REFUSED, quarantine copy already exists']; continue; }
  $out['plan'][] = [$p, 'move to quarantine'];
  if ($apply) { if (!is_dir(dirname($dst))) mkdir(dirname($dst), 0700, true); $out['done'][] = [$p, rename($src, $dst) ? 'moved' : 'FAILED']; }
}
$check = []; foreach ($paths as $p) { $check[$p] = ['in_site' => file_exists($wc . '/' . $p), 'in_quarantine' => file_exists($q . '/files/wp-content/' . $p)]; }
$out['check'] = $check;
return $out;
''' % ('true' if apply else 'false', php_arr(PLANTED), php_str(Q))
    r = run(code)
    show('files' + ('' if apply else ' (dry run)'), r)
    if apply and isinstance(r, dict) and 'check' in r:
        bad = [p for p, c in r['check'].items() if c['in_site']]
        print('\nCHECK:', 'PASS, nothing left in wp-content' if not bad else 'FAIL, still in site: %s' % bad)


# ---------- wp-config ----------

def wpconfig(apply, no_file_edit):
    code = r'''
$apply = %s; $bad = %s; $salts = %s; $q = %s; $nfe = %s;
$f = ABSPATH . 'wp-config.php'; $old = file_get_contents($f);
if ($old === false) return ['abort' => 'cannot read wp-config.php'];
$out = ['sha1_before' => sha1($old), 'plan' => []];
$lines = preg_split("/(?<=\n)/", $old); $new = ''; $removed = 0;
foreach ($lines as $l) { if (trim($l) === $bad) { $removed++; continue; } $new .= $l; }
$out['plan'][] = "remove planted include line: found $removed time(s)";
foreach ($salts as $k) {
  $n = 0;
  $new = preg_replace_callback("/define\(\s*(['\"])" . $k . "\\1\s*,\s*(['\"])[^'\"]*\\2\s*\)\s*;/", function ($m) use ($k) {
    return "define( '" . $k . "', '" . wp_generate_password(64, true, true) . "' );";
  }, $new, -1, $n);
  if ($n !== 1) return ['abort' => "$k found $n times, expected 1. Nothing changed."];
}
$out['plan'][] = 'rotate 8 salts (values not shown)';
if ($nfe && strpos($new, 'DISALLOW_FILE_EDIT') === false) {
  $marker = "/* That's all, stop editing!";
  $pos = strpos($new, $marker);
  if ($pos === false) $pos = strpos($new, "require_once ABSPATH . 'wp-settings.php'");
  if ($pos === false) return ['abort' => 'no place found for DISALLOW_FILE_EDIT'];
  $new = substr($new, 0, $pos) . "define( 'DISALLOW_FILE_EDIT', true );\n\n" . substr($new, $pos);
  $out['plan'][] = 'add DISALLOW_FILE_EDIT';
}
try { token_get_all($new, TOKEN_PARSE); } catch (ParseError $e) { return ['abort' => 'new file would not parse: ' . $e->getMessage()]; }
$out['parses'] = true;
if ($apply) {
  $bk = $q . '/wp-config.php.pre-cleanup-' . gmdate('Ymd-His');
  if (file_put_contents($bk, $old) === false) return ['abort' => 'backup failed, nothing changed'];
  @chmod($bk, 0600);
  $tmp = $f . '.rl-tmp'; $perm = fileperms($f) & 0777;
  if (file_put_contents($tmp, $new) === false) return ['abort' => 'temp write failed, nothing changed'];
  @chmod($tmp, $perm);
  if (!rename($tmp, $f)) { @unlink($tmp); return ['abort' => 'swap failed, nothing changed']; }
  $out['backup'] = basename($bk);
  $now = file_get_contents($f);
  $out['sha1_after'] = sha1($now);
  $out['check'] = ['bad_line_left' => strpos($now, 'class-wp-cache.php') !== false, 'parses' => true, 'salts_changed' => $now !== $old];
}
return $out;
''' % ('true' if apply else 'false', php_str(BAD_LINE), php_arr(SALTS), php_str(Q), 'true' if no_file_edit else 'false')
    r = run(code)
    show('wpconfig' + ('' if apply else ' (dry run)'), r)
    if apply and isinstance(r, dict) and 'check' in r:
        # The site must still load and Novamira must still answer after the swap.
        code2 = "return ['ok' => true, 'line_left' => strpos(file_get_contents(ABSPATH.'wp-config.php'), 'class-wp-cache.php') !== false];"
        r2 = run(code2)
        st = http_status(SITE + '/')
        ok = r2.get('ok') and not r2.get('line_left') and st == 200
        print('\nCHECK:', 'PASS, Novamira still connected, line gone, site answers %s' % st if ok else 'FAIL: %s, site %s' % (r2, st))


# ---------- cron ----------

def cron(apply):
    code = r'''
$apply = %s; $hooks = %s; $out = ['plan' => []];
$c = _get_cron_array(); $found = [];
foreach ($c as $t => $h) { foreach ($h as $k => $v) { if (in_array($k, $hooks, true)) { $found[$k] = ($found[$k] ?? 0) + count($v); } } }
foreach ($hooks as $k) {
  $n = $found[$k] ?? 0;
  $out['plan'][] = [$k, $n ? "remove $n scheduled event(s)" : 'not scheduled'];
  if ($apply && $n) { $out['done'][] = [$k, wp_clear_scheduled_hook($k)]; }
}
$c = _get_cron_array(); $left = [];
foreach ($c as $t => $h) { foreach ($h as $k => $v) { if (in_array($k, $hooks, true)) $left[] = $k; } }
$out['check_left'] = array_values(array_unique($left));
return $out;
''' % ('true' if apply else 'false', php_arr(BAD_CRON))
    r = run(code)
    show('cron' + ('' if apply else ' (dry run)'), r)
    if apply and isinstance(r, dict):
        print('\nCHECK:', 'PASS, none of the 5 tasks left' if not r.get('check_left') else 'FAIL, still scheduled: %s' % r['check_left'])
        print('Note: a planted task comes back if code that schedules it still exists. verify re-checks this.')


# ---------- verify ----------

def http_status(url):
    try:
        req = urllib.request.Request(url, headers={'User-Agent': 'rl-cleanup-check'})
        with urllib.request.urlopen(req, timeout=30) as resp:
            return resp.status
    except urllib.error.HTTPError as e:
        return e.code
    except Exception as e:
        return 'error: %s' % e.__class__.__name__


def verify(_apply=False):
    rogue_ids = ','.join(str(i) for i, _, _ in ROGUE)
    code = r'''
$wc = WP_CONTENT_DIR; $paths = %s; $hooks = %s;
$admins = []; foreach (get_users(['role' => 'administrator']) as $u) $admins[] = $u->user_login;
$ghost = []; foreach ([%s] as $id) if (get_userdata($id)) $ghost[] = $id;
$files = []; foreach ($paths as $p) if (file_exists($wc . '/' . $p)) $files[] = $p;
$plugins = array_values(array_diff(scandir($wc . '/plugins'), ['.', '..', 'index.php']));
$mu = is_dir($wc . '/mu-plugins') ? array_values(array_diff(scandir($wc . '/mu-plugins'), ['.', '..'])) : [];
$themes = array_values(array_diff(scandir($wc . '/themes'), ['.', '..', 'index.php']));
$c = _get_cron_array(); $left = []; foreach ($c as $t => $h) foreach ($h as $k => $v) if (in_array($k, $hooks, true)) $left[] = $k;
$cfg = file_get_contents(ABSPATH . 'wp-config.php');
$inc = []; foreach (preg_split("/\n/", $cfg) as $i => $l) if (preg_match('/^\s*@?(include|require)(_once)?\b/', $l)) $inc[] = [$i + 1, trim($l)];
$q = %s;
return ['admins' => $admins, 'attacker_ids_present' => $ghost, 'planted_files_present' => $files,
  'plugin_folders' => $plugins, 'mu_plugins' => $mu, 'themes' => $themes,
  'planted_cron_present' => array_values(array_unique($left)),
  'wpconfig_includes' => $inc, 'wpconfig_bad_line' => strpos($cfg, 'class-wp-cache.php') !== false,
  'disallow_file_edit' => defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT,
  'blog_public' => get_option('blog_public'),
  'quarantine' => array_values(array_diff(scandir($q), ['.', '..']))];
''' % (php_arr(PLANTED), php_arr(BAD_CRON), rogue_ids, php_str(Q))
    r = run(code)
    r['home_status'] = http_status(SITE + '/')
    r['admin_status'] = http_status(SITE + '/wp-login.php')
    show('verify', r)
    problems = []
    if r['attacker_ids_present']:
        problems.append('attacker accounts present')
    if r['planted_files_present']:
        problems.append('planted files present')
    if r['planted_cron_present']:
        problems.append('planted cron present')
    if r['wpconfig_bad_line']:
        problems.append('wp-config include line present')
    if r['home_status'] != 200:
        problems.append('home page status %s' % r['home_status'])
    if str(r['blog_public']) != '0':
        problems.append('site is not set to noindex (blog_public=%s)' % r['blog_public'])
    print('\nCHECK:', 'PASS, all clean-up checks hold' if not problems else 'OPEN: ' + '; '.join(problems))


def main():
    ap = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument('step', choices=['users', 'files', 'wpconfig', 'cron', 'verify'])
    ap.add_argument('--apply', action='store_true', help='make the change (default is a dry run)')
    ap.add_argument('--disallow-file-edit', action='store_true', help='wpconfig: also turn off the wp-admin code editor')
    a = ap.parse_args()
    print('Target: %s (development). reinforcelab.com is never touched by this script.' % SITE)
    if a.step == 'wpconfig':
        wpconfig(a.apply, a.disallow_file_edit)
    else:
        {'users': users, 'files': files, 'cron': cron, 'verify': verify}[a.step](a.apply)


if __name__ == '__main__':
    main()
