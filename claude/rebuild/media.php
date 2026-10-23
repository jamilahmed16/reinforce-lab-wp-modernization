<?php
/**
 * Reinforce Lab rebuild: bring the media files across, checked one by one (Step 2.3, D-196).
 *
 *   wp eval-file media.php <export-dir> <source-site> [<limit>]
 *   e.g. wp eval-file media.php ./site-export https://reinforcelab.online
 *
 * For every file in <export-dir>/uploads.json (images, PDFs, fonts, two checked SVG badges; nothing executable):
 *   - downloads <source-site>/wp-content/uploads/<path>
 *   - keeps it only if its sha1 equals the one recorded at export AND its first bytes match the file type
 *   - writes it to this site's uploads folder at the same path (so every address in the content stays the same)
 * Files already present with the right sha1 are skipped, so the script can be re-run after a network hiccup.
 * Report: <uploads>/rl-media-report.json (outside the export, not served: the uploads .htaccess denies .json).
 */
if (!defined('ABSPATH')) { fwrite(STDERR, "Run with: wp eval-file media.php <export-dir> <source-site>\n"); exit(1); }

$args = isset($args) ? $args : [];
$dir = rtrim($args[0] ?? '', '/');
$src = rtrim($args[1] ?? '', '/');
$limit = (int) ($args[2] ?? 0);
if (!is_readable("$dir/uploads.json") || !preg_match('#^https://#', $src)) { fwrite(STDERR, "STOP: need <export-dir> with uploads.json and an https source site\n"); exit(1); }

$list = json_decode(file_get_contents("$dir/uploads.json"), true)['files'];
$base = untrailingslashit(wp_upload_dir()['basedir']);
$magic = ['jpg' => ['ffd8ff'], 'jpeg' => ['ffd8ff'], 'png' => ['89504e47'], 'gif' => ['47494638'], 'webp' => ['52494646'], 'pdf' => ['25504446'],
          'ico' => ['00000100'], 'woff2' => ['774f4632'], 'woff' => ['774f4646'], 'ttf' => ['00010000', '74727565'], 'avif' => [''],
          'svg' => ['3c3f786d', '3c737667', '3c212d2d', 'efbbbf3c']];
$out = ['copied' => 0, 'present' => 0, 'failed' => []];
$i = 0;
foreach ($list as $f) {
    if ($limit && $i >= $limit) break;
    $i++;
    $rel = $f['path'];
    $ext = strtolower(pathinfo($rel, PATHINFO_EXTENSION));
    if (preg_match('#(^|/)\.\.(/|$)#', $rel) || !isset($magic[$ext])) { $out['failed'][] = [$rel, 'path or type not allowed']; continue; }
    $dest = $base . '/' . $rel;
    if (is_file($dest) && sha1_file($dest) === $f['sha1']) { $out['present']++; continue; }
    $url = $src . '/wp-content/uploads/' . implode('/', array_map('rawurlencode', explode('/', $rel)));
    $r = wp_remote_get($url, ['timeout' => 60, 'redirection' => 0, 'user-agent' => 'Reinforce Lab rebuild']);
    if (is_wp_error($r)) { $out['failed'][] = [$rel, $r->get_error_message()]; continue; }
    if (wp_remote_retrieve_response_code($r) !== 200) { $out['failed'][] = [$rel, 'HTTP ' . wp_remote_retrieve_response_code($r)]; continue; }
    $body = wp_remote_retrieve_body($r);
    if (sha1($body) !== $f['sha1']) { $out['failed'][] = [$rel, 'sha1 differs from the export']; continue; }
    $sig = bin2hex(substr($body, 0, 4));
    $ok = false;
    foreach ($magic[$ext] as $m) if ($m === '' || strpos($sig, $m) === 0 || ($ext === 'svg' && stripos(substr($body, 0, 200), '<svg') !== false)) $ok = true;
    if (!$ok) { $out['failed'][] = [$rel, "file type check failed ($sig)"]; continue; }
    wp_mkdir_p(dirname($dest));
    if (file_put_contents($dest, $body) === false) { $out['failed'][] = [$rel, 'could not write']; continue; }
    @chmod($dest, 0644);
    $out['copied']++;
    if ($out['copied'] % 100 === 0) echo "   {$out['copied']} copied...\n";
}
// uploads may only ever hold media: no PHP runs from here
$ht = $base . '/.htaccess';
if (!is_file($ht)) file_put_contents($ht, "# Reinforce Lab: no scripts in uploads\n<FilesMatch \"\\.(php[0-9]?|phtml|phar|pl|py|cgi|sh|json)$\">\n  Require all denied\n</FilesMatch>\nOptions -Indexes\n");
file_put_contents($base . '/rl-media-report.json', wp_json_encode($out, JSON_PRETTY_PRINT));
printf("media: %d copied, %d already present, %d failed (of %d listed)\n", $out['copied'], $out['present'], count($out['failed']), count($list));
foreach (array_slice($out['failed'], 0, 30) as $x) echo '   FAILED ' . $x[0] . ': ' . $x[1] . "\n";
if ($out['failed']) exit(2);
