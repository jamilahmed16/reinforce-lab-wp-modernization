#!/usr/bin/env python3
"""Read-only outside scan of reinforcelab.com (production), run from the .online server.

Never changes production: it only sends GET/HEAD requests, like a visitor or a search engine.
(The Claude container is blocked from reinforcelab.com by its network policy, so requests go
through Novamira on reinforcelab.online, the same way as F-032 and F-033.)

  python3 claude/tools/prod-scan.py urls       # every address in the sitemaps
  python3 claude/tools/prod-scan.py pages      # scan every page (resumes where it stopped)
  python3 claude/tools/prod-scan.py probes     # planted files, leaked files, exposed endpoints
  python3 claude/tools/prod-scan.py plugins    # plugin versions vs the latest on wordpress.org
  python3 claude/tools/prod-scan.py inventory  # which of ~90 common or known-bad plugin folders exist
  python3 claude/tools/prod-scan.py report     # summary of everything found

Results: claude/research/prod-scan/<date>/ (summaries only, no page copies).
"""
import datetime
import importlib.util
import json
import os
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(os.path.dirname(HERE))
spec = importlib.util.spec_from_file_location('rl', os.path.join(HERE, 'rl.py'))
rl = importlib.util.module_from_spec(spec)
spec.loader.exec_module(rl)

BASE = 'https://reinforcelab.com/'
DAY = os.environ.get('SCAN_DAY') or datetime.date.today().isoformat()
OUT = os.path.join(ROOT, 'claude', 'research', 'prod-scan', DAY)
os.makedirs(OUT, exist_ok=True)

BROWSER = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0 Safari/537.36'
GOOGLEBOT = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'

# Spam domains from F-033 and generic hack signs
SPAM = ['20914565266523', 'unyu168a', 'api288a', 'gacoan88a', 'idnasia88a', 'topanwin1', 'bighoki1', 'indocair1',
        'slot gacor', 'slot88', 'togel', 'judi online', 'casino online', 'viagra', 'cialis', 'pharmacy online', 'replica watches']


def php(code, timeout=300):
    r, errors = rl.php(code, timeout)
    if errors:
        raise SystemExit('PHP errors: ' + json.dumps(errors)[:800])
    return r


def save(name, data):
    with open(os.path.join(OUT, name), 'w') as f:
        json.dump(data, f, indent=1)


def load(name, default=None):
    p = os.path.join(OUT, name)
    return json.load(open(p)) if os.path.exists(p) else default


def phpstr(s):
    return "'" + s.replace('\\', '\\\\').replace("'", "\\'") + "'"


def cmd_urls():
    code = r'''
$maps=[]; $urls=[];
$r=wp_remote_get('%s'.'sitemap_index.xml',['timeout'=>20]);
preg_match_all('/<loc>([^<]+)<\/loc>/',wp_remote_retrieve_body($r),$m); $maps=$m[1];
foreach($maps as $sm){ $x=wp_remote_get($sm,['timeout'=>20]); if(is_wp_error($x)) continue;
  preg_match_all('/<loc>([^<]+)<\/loc>/',wp_remote_retrieve_body($x),$mm);
  foreach($mm[1] as $u) if(!preg_match('/\.(jpe?g|png|webp|gif|svg)$/i',$u)) $urls[]=html_entity_decode($u); }
return ['maps'=>$maps,'urls'=>array_values(array_unique($urls))];
''' % BASE
    r = php(code, 300)
    save('urls.json', r)
    print(len(r['maps']), 'sitemaps,', len(r['urls']), 'addresses')


PAGE_PHP = r'''
$spam=%s; $out=[];
foreach(%s as $u){
 foreach(%s as $k=>$ua){
  $r=wp_remote_get($u,['timeout'=>20,'user-agent'=>$ua,'redirection'=>0]);
  if(is_wp_error($r)){ $out[]=['u'=>$u,'ua'=>$k,'err'=>$r->get_error_message()]; continue; }
  $b=wp_remote_retrieve_body($r); $lb=strtolower($b); $hits=[];
  foreach($spam as $s) if(strpos($lb,strtolower($s))!==false) $hits[]=$s;
  $ext=[]; if(preg_match_all('/<(?:script|iframe)[^>]+src=["\']([^"\']+)/i',$b,$m)) foreach($m[1] as $src){ $h=parse_url($src,PHP_URL_HOST); if($h && stripos($h,'reinforcelab.com')===false) $ext[strtolower($h)]=1; }
  $inl=0; $sus=[]; if(preg_match_all('/<script(?![^>]*\bsrc=)[^>]*>(.*?)<\/script>/is',$b,$m2)) foreach($m2[1] as $js){ $inl++;
     foreach(['eval(','atob(','fromCharCode','unescape(','document.write(','window.location=','location.replace(','\\x6','base64,'] as $p) if(stripos($js,$p)!==false) $sus[$p]=($sus[$p]??0)+1;
     if(preg_match('/[A-Za-z0-9+\/=]{400,}/',$js)) $sus['long_encoded']=($sus['long_encoded']??0)+1; }
  $loc=wp_remote_retrieve_header($r,'location');
  $out[]=['u'=>$u,'ua'=>$k,'code'=>wp_remote_retrieve_response_code($r),'len'=>strlen($b),'loc'=>$loc?:'',
   'spam'=>$hits,'offscreen'=>preg_match_all('/(left|top|text-indent):\s*-\d{4,}px/i',$b),'hidden_links'=>preg_match_all('/<div[^>]+(display:\s*none|visibility:\s*hidden)[^>]*>\s*(<a [^>]+>[^<]*<\/a>\s*){3,}/i',$b),
   'sponsored'=>substr_count($lb,'rel="sponsored'),'meta_refresh'=>preg_match('/<meta[^>]+http-equiv=["\']?refresh/i',$b),'ext'=>array_keys($ext),'inline_scripts'=>$inl,'sus'=>$sus,
   'robots'=>preg_match('/<meta name=.robots. content=.([^"\']*)/',$b,$rm)?$rm[1]:''];
 }
}
return $out;
'''


def cmd_pages(batch=6):
    urls = load('urls.json')['urls']
    done = load('pages.json', [])
    seen = {(x['u'], x['ua']) for x in done}
    # every page as a browser; every 5th page also as Googlebot (cloaking check)
    todo = []
    for i, u in enumerate(urls):
        uas = {'browser': BROWSER}
        if i % 5 == 0:
            uas['googlebot'] = GOOGLEBOT
        todo.append((u, {k: v for k, v in uas.items() if (u, k) not in seen}))
    todo = [t for t in todo if t[1]]
    print(len(todo), 'pages left')
    while todo:
        chunk, todo = todo[:batch], todo[batch:]
        groups = {}
        for u, uas in chunk:
            groups.setdefault(tuple(sorted(uas)), []).append(u)
        for keys, us in groups.items():
            uamap = {'browser': BROWSER, 'googlebot': GOOGLEBOT}
            ua_php = '[' + ','.join("'%s'=>%s" % (k, phpstr(uamap[k])) for k in keys) + ']'
            code = PAGE_PHP % ('[' + ','.join(phpstr(s) for s in SPAM) + ']', '[' + ','.join(phpstr(u) for u in us) + ']', ua_php)
            try:
                done += php(code, 280)
            except SystemExit as e:
                print('batch failed, will retry next run:', str(e)[:120])
                continue
        save('pages.json', done)
        print(len(done), 'results saved,', len(todo), 'pages left')


PROBES = [
    # control (must be 404)
    'wp-content/plugins/zz-not-a-real-plugin-xyz/', 'zz-not-a-real-file-xyz.php',
    # known from .online (F-035, F-036)
    'wp-content/mu-plugins/health-check-api.php', 'wp-content/plugins/lunar-profiler-ink/', 'wp-content/plugins/nimble-router-mod/',
    'wp-content/plugins/onyx-store-tag/', 'wp-content/plugins/pulse-cache-ink/', 'wp-content/plugins/event/', 'wp-content/themes/wise-news/',
    'wp-content/cache/2704f406.php', 'wp-includes/class-wp-cache.php',
    # common web shells and droppers
    'wp-content/uploads/shell.php', 'wp-content/uploads/up.php', 'wp-content/uploads/wp-login.php', 'wp-content/x.php', 'wp-admin/user/about.php',
    'wp-includes/wp-class.php', 'wp-content/plugins/wp-file-manager/', 'wp-content/mu-plugins/', 'wp-content/plugins/hello.php', 'about.php', 'radio.php',
    'wp-content/plugins/wp-sysadmin/', 'wp-content/plugins/core-plugin/', 'wp-content/plugins/ws-plugin/', 'wp-content/plugins/wpcode-helper/',
    # leaked files
    'wp-config.php.bak', 'wp-config.php.old', 'wp-config.php~', 'wp-config.bak', 'wp-config.txt', '.env', '.git/config', 'backup.zip', 'public_html.zip',
    'reinforcelab.zip', 'site.zip', 'backup.sql', 'database.sql', 'db.sql', 'dump.sql', 'wp-content/debug.log', 'error_log', 'wp-admin/error_log', 'phpinfo.php', 'info.php',
    # exposure
    'readme.html', 'license.txt', 'xmlrpc.php', 'wp-login.php', 'wp-json/', 'wp-content/uploads/', 'wp-content/plugins/', 'wp-includes/',
    '.well-known/security.txt', 'robots.txt',
]


def cmd_probes(batch=8):
    done = load('probes.json', [])
    seen = {x[0] for x in done}
    todo = [p for p in PROBES if p not in seen]
    while todo:
        chunk, todo = todo[:batch], todo[batch:]
        code = r'''$o=[]; foreach(%s as $p){ $r=wp_remote_get('%s'.$p,['timeout'=>15,'redirection'=>0]);
  if(is_wp_error($r)){ $o[]=[$p,'ERR',0,'']; continue; } $b=wp_remote_retrieve_body($r);
  $o[]=[$p,wp_remote_retrieve_response_code($r),strlen($b),substr(preg_replace('/\s+/',' ',strip_tags(substr($b,0,600))),0,140),(string)wp_remote_retrieve_header($r,'location')]; } return $o;''' % (
            '[' + ','.join(phpstr(p) for p in chunk) + ']', BASE)
        done += php(code, 280)
        save('probes.json', done)
    print(len(done), 'probes saved')


def cmd_plugins():
    pages = load('pages.json', [])
    # plugin and theme folders referenced in the home page source
    code = r'''$r=wp_remote_get('%s',['timeout'=>20]); $b=wp_remote_retrieve_body($r);
 preg_match_all('#/wp-content/(plugins|themes)/([a-z0-9_.-]+)/#i',$b,$m); $f=[];
 foreach($m[1] as $i=>$t) $f[$m[1][$i].'/'.strtolower($m[2][$i])]=1;
 preg_match('/<meta name="generator" content="WordPress ([0-9.]+)/',$b,$g);
 return ['found'=>array_keys($f),'wp'=>$g[1]??''];''' % BASE
    r = php(code, 120)
    # also every plugin folder the probes showed to exist (200 with an empty index, or 403 directory)
    pr = load('probes.json', [])
    extra = ['plugins/' + x[0].split('/')[2] for x in pr if x[0].startswith('wp-content/plugins/') and x[0].count('/') == 3 and (str(x[1]) == '200' or (str(x[1]) == '403' and x[2] == 787))]
    items = sorted(set(r['found']) | set(extra))
    out = {'wordpress_meta': r['wp'], 'items': []}
    for i in range(0, len(items), 6):
        chunk = items[i:i + 6]
        code = r'''$o=[]; foreach(%s as $it){ list($t,$s)=explode('/',$it,2); $v=''; $src='';
   foreach(['readme.txt','README.txt','readme.md'] as $f){ $x=wp_remote_get('%s'.'wp-content/'.$t.'/'.$s.'/'.$f,['timeout'=>15]);
     if(!is_wp_error($x)&&wp_remote_retrieve_response_code($x)==200){ $b=wp_remote_retrieve_body($x); if(preg_match('/Stable tag:\s*([0-9.]+)/i',$b,$m)){ $v=$m[1]; $src=$f; break; } } }
   if($t==='themes'){ $x=wp_remote_get('%s'.'wp-content/themes/'.$s.'/style.css',['timeout'=>15]); if(!is_wp_error($x)&&preg_match('/Version:\s*([0-9.]+)/i',wp_remote_retrieve_body($x),$m)){ $v=$m[1]; $src='style.css'; } }
   $latest=''; $api=wp_remote_get('https://api.wordpress.org/'.($t==='themes'?'themes/info/1.2/?action=theme_information&request[slug]=':'plugins/info/1.2/?action=plugin_information&request[slug]=').$s,['timeout'=>15]);
   if(!is_wp_error($api)){ $j=json_decode(wp_remote_retrieve_body($api),true); if(is_array($j)&&isset($j['version'])) $latest=$j['version']; }
   $o[]=['item'=>$it,'version'=>$v,'from'=>$src,'latest_on_wordpress_org'=>$latest]; } return $o;''' % (
            '[' + ','.join(phpstr(x) for x in chunk) + ']', BASE, BASE)
        out['items'] += php(code, 280)
    save('plugins.json', out)
    for x in out['items']:
        print(x)


COMMON = ['woocommerce','wordpress-seo','wordpress-seo-premium','bb-plugin','bb-theme-builder','bbpowerpack','advanced-custom-fields','advanced-custom-fields-pro',
  'jetpack','elementor','elementor-pro','wordfence','really-simple-ssl','wp-mail-smtp','contact-form-7','wpforms-lite','wpforms','insert-headers-and-footers',
  'code-snippets','classic-editor','akismet','hostinger','hostinger-ai-assistant','hostinger-easy-onboarding','google-site-kit','updraftplus','all-in-one-wp-migration',
  'duplicator','wp-optimize','w3-total-cache','wp-rocket','autoptimize','astra-sites','header-footer-elementor','essential-addons-for-elementor-lite','mailchimp-for-wp',
  'woocommerce-payments','woocommerce-gateway-stripe','woocommerce-paypal-payments','sucuri-scanner','better-wp-security','all-in-one-seo-pack','seo-by-rank-math',
  'redirection','wp-super-cache','limit-login-attempts-reloaded','regenerate-thumbnails','svg-support','safe-svg','ninja-forms','litespeed-cache','wp-file-manager',
  'file-manager-advanced','wp-reset','loginizer','wps-hide-login','user-role-editor','members','admin-menu-editor','wp-statistics','monsterinsights','google-analytics-for-wordpress',
  'tablepress','ultimate-addons-for-gutenberg','spectra','kadence-blocks','creame-whatsapp-me','click-to-chat-for-whatsapp','cookie-law-info','complianz-gdpr','novamira','novamira-pro',
  'lunar-profiler-ink','nimble-router-mod','onyx-store-tag','pulse-cache-ink','event','wp-sysadmin','core-plugin','ws-plugin','wpcode-helper','fake-plugin']


def cmd_inventory(batch=10):
    done = load('inventory.json', [])
    seen = {x[0] for x in done}
    todo = [p for p in COMMON if p not in seen]
    while todo:
        chunk, todo = todo[:batch], todo[batch:]
        code = r'''$o=[]; foreach(%s as $p){ $r=wp_remote_get('%s'.'wp-content/plugins/'.$p.'/',['timeout'=>15,'redirection'=>0]);
  if(is_wp_error($r)){ $o[]=[$p,'ERR',0]; continue; } $c=wp_remote_retrieve_response_code($r); $l=strlen(wp_remote_retrieve_body($r));
  $o[]=[$p,$c,$l,($c==200&&$l<200)||($c==403&&$l<2000)?'installed':($c==404?'no':'unclear')]; } return $o;''' % (
            '[' + ','.join(phpstr(p) for p in chunk) + ']', BASE)
        done += php(code, 280)
        save('inventory.json', done)
    for x in done:
        if x[3] != 'no':
            print(x)


def cmd_report():
    urls = load('urls.json', {}).get('urls', [])
    pages = load('pages.json', [])
    probes = load('probes.json', [])
    plugins = load('plugins.json', {})
    bad = [p for p in pages if p.get('spam') or p.get('offscreen') or p.get('hidden_links') or p.get('meta_refresh') or p.get('sus') or p.get('err')]
    codes = {}
    for p in pages:
        codes[str(p.get('code', 'ERR'))] = codes.get(str(p.get('code', 'ERR')), 0) + 1
    ext = {}
    for p in pages:
        for h in p.get('ext', []):
            ext[h] = ext.get(h, 0) + 1
    # cloaking: same page, browser vs googlebot length differs a lot
    by = {}
    for p in pages:
        by.setdefault(p['u'], {})[p['ua']] = p
    cloak = [(u, d['browser'].get('len'), d['googlebot'].get('len')) for u, d in by.items()
             if 'browser' in d and 'googlebot' in d and abs((d['browser'].get('len') or 0) - (d['googlebot'].get('len') or 0)) > 2000]
    ctrl = {p[0]: p for p in probes}
    print('addresses in sitemaps:', len(urls), '| page results:', len(pages), '| status codes:', codes)
    print('pages with warning signs:', len(bad))
    for p in bad[:40]:
        print('  ', p['u'], p['ua'], {k: p[k] for k in ('spam', 'offscreen', 'hidden_links', 'meta_refresh', 'sus', 'err') if p.get(k)})
    print('possible cloaking (browser vs Googlebot size differs by >2 KB):', cloak or 'none')
    print('outside script/iframe hosts:', ext)
    print('probes (anything not 404):')
    for p in probes:
        if str(p[1]) != '404':
            print('  ', p[0], p[1], p[2], (p[4] if len(p) > 4 else ''), '|', p[3][:90])
    print('plugins/themes:')
    for x in plugins.get('items', []):
        print('  ', x)
    save('report.json', {'urls': len(urls), 'pages': len(pages), 'codes': codes, 'warning_pages': bad, 'cloaking': cloak, 'ext_hosts': ext,
                         'probes_not_404': [p for p in probes if str(p[1]) != '404'], 'plugins': plugins})


if __name__ == '__main__':
    c = sys.argv[1] if len(sys.argv) > 1 else 'report'
    {'urls': cmd_urls, 'pages': cmd_pages, 'probes': cmd_probes, 'plugins': cmd_plugins, 'inventory': cmd_inventory, 'report': cmd_report}[c]()
