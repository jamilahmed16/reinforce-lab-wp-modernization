#!/usr/bin/env bash
# Reinforce Lab clean rebuild (Step 2.3, D-196): a fresh WordPress built from trusted sources only.
#
#   bash claude/rebuild/rebuild.sh --path /home/USER/public_html --url https://staging.example.com \
#        --vendor /home/USER/rl-vendor --source https://reinforcelab.online
#
# Run on the NEW hosting over SSH, from a clone of this repository, with WP-CLI installed and an EMPTY database
# whose name, user and password are in the environment (DB_NAME, DB_USER, DB_PASSWORD, DB_HOST) or already in
# wp-config.php. It never touches reinforcelab.com or the old Hostinger account.
#
# Where everything comes from:
#   WordPress core and free plugins  wordpress.org, checked against wordpress.org checksums
#   Paid plugins and the theme       zips Jamil downloads from his vendor accounts (claude/rebuild/plugins.json)
#   Our code                         this git repository (wp/novamira-sandbox/), loaded by a must-use plugin
#   Content and settings             claude/data/site-export/ (data only, scanned, no passwords or keys)
#   Media                            downloaded from --source, each file matched to its recorded sha1 and file type
# Every step prints what it did; the whole run is logged to claude/rebuild/logs/<date>-<host>.log.
set -euo pipefail

HERE="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO="$(cd "$HERE/../.." && pwd)"
EXPORT="$REPO/claude/data/site-export"
WPPATH="" URL="" VENDOR="" SOURCE="https://reinforcelab.online" ADMIN_EMAIL="jadirectives@gmail.com"
while [ $# -gt 0 ]; do
  case "$1" in
    --path) WPPATH="$2"; shift 2;;
    --url) URL="${2%/}"; shift 2;;
    --vendor) VENDOR="$2"; shift 2;;
    --source) SOURCE="${2%/}"; shift 2;;
    --admin-email) ADMIN_EMAIL="$2"; shift 2;;
    *) echo "unknown option $1"; exit 1;;
  esac
done
[ -n "$WPPATH" ] && [ -n "$URL" ] && [ -n "$VENDOR" ] || { sed -n 2,8p "$0"; exit 1; }
case "$URL" in *reinforcelab.com*) [ "${RL_SWITCH:-}" = "approved" ] || { echo "STOP: --url is reinforcelab.com. Build on a staging address first (Step 3); the switch is its own approved runbook (A6)."; exit 1; };; esac

mkdir -p "$HERE/logs"
LOG="$HERE/logs/$(date +%Y%m%d-%H%M)-$(echo "$URL" | sed 's#https\?://##; s#/.*##').log"
exec > >(tee -a "$LOG") 2>&1
step() { echo; echo "== $* ($(date +%H:%M:%S))"; }
wp() { command wp --path="$WPPATH" "$@"; }
ver() { python3 -c "import json;print(json.load(open('$HERE/plugins.json'))['$1'])"; }

step "0. Checks before starting"
command -v wp >/dev/null || { echo "STOP: WP-CLI (wp) not found"; exit 1; }
command -v python3 >/dev/null || { echo "STOP: python3 not found"; exit 1; }
php -r 'exit(version_compare(PHP_VERSION, "8.2", ">=") ? 0 : 1);' || { echo "STOP: PHP 8.2 or newer needed"; exit 1; }
[ -s "$EXPORT/posts.json" ] || { echo "STOP: $EXPORT/posts.json missing"; exit 1; }
[ "$(python3 -c "import json;print(len(json.load(open('$EXPORT/scan.json'))))")" = "0" ] || { echo "STOP: the export scan lists risky fields"; exit 1; }
for slug in $(python3 -c "import json;d=json.load(open('$HERE/plugins.json'));print(' '.join(list(d['vendor_plugins'])+list(d['vendor_theme'])))"); do
  ls "$VENDOR"/"$slug"*.zip >/dev/null 2>&1 || { echo "STOP: vendor zip for $slug not found in $VENDOR"; exit 1; }
done
mkdir -p "$WPPATH"
if [ -f "$WPPATH/wp-config.php" ] && wp core is-installed 2>/dev/null; then
  n=$(wp db query "SELECT COUNT(*) FROM $(wp db prefix)posts" --skip-column-names)
  [ "$n" -le 10 ] || { echo "STOP: $WPPATH already holds a site with $n posts. This script only builds on an empty install."; exit 1; }
fi
echo "ok: WP-CLI $(command wp --version | cut -d' ' -f2), PHP $(php -r 'echo PHP_VERSION;'), export $(python3 -c "import json;print(len(json.load(open('$EXPORT/posts.json'))))") records"

step "1. WordPress core from wordpress.org"
if [ ! -f "$WPPATH/wp-includes/version.php" ]; then
  wp core download --version="$(ver wordpress)" --skip-content
fi
wp core verify-checksums
mkdir -p "$WPPATH/wp-content/plugins" "$WPPATH/wp-content/themes" "$WPPATH/wp-content/mu-plugins" "$WPPATH/wp-content/uploads"

step "2. wp-config.php"
if [ ! -f "$WPPATH/wp-config.php" ]; then
  : "${DB_NAME:?set DB_NAME}" "${DB_USER:?set DB_USER}" "${DB_PASSWORD:?set DB_PASSWORD}"
  wp config create --dbname="$DB_NAME" --dbuser="$DB_USER" --dbpass="$DB_PASSWORD" --dbhost="${DB_HOST:-localhost}" --dbprefix="rl_" --skip-check
fi
wp config set DISALLOW_FILE_EDIT true --raw
wp config set WP_ENVIRONMENT_TYPE staging
wp config set WP_DEBUG false --raw
wp config shuffle-salts

step "3. Fresh install (indexing off)"
if ! wp core is-installed 2>/dev/null; then
  wp core install --url="$URL" --title="Reinforce Lab" --admin_user="$ADMIN_EMAIL" --admin_email="$ADMIN_EMAIL" \
     --admin_password="$(python3 -c 'import secrets;print(secrets.token_urlsafe(24))')" --skip-email
  echo "admin login: $ADMIN_EMAIL. Password: not shown; use 'Lost your password' on $URL/wp-login.php"
fi
wp option update blog_public 0

step "4. Free plugins from wordpress.org, checksum-verified"
for slug in $(python3 -c "import json;print(' '.join(json.load(open('$HERE/plugins.json'))['free']))"); do
  wp plugin is-installed "$slug" || wp plugin install "$slug"
  wp plugin verify-checksums "$slug"
done

step "5. Paid plugins and theme from Jamil's vendor zips"
for slug in $(python3 -c "import json;print(' '.join(json.load(open('$HERE/plugins.json'))['vendor_plugins']))"); do
  zip=$(ls "$VENDOR"/"$slug"*.zip | head -1)
  top=$(unzip -Z1 "$zip" | head -1 | cut -d/ -f1)
  [ "$top" = "$slug" ] || { echo "STOP: $zip does not contain the $slug folder (found '$top')"; exit 1; }
  echo "$slug: $(basename "$zip") sha256 $(sha256sum "$zip" | cut -d' ' -f1)"
  wp plugin is-installed "$slug" || wp plugin install "$zip"
done
for slug in $(python3 -c "import json;print(' '.join(json.load(open('$HERE/plugins.json'))['vendor_theme']))"); do
  zip=$(ls "$VENDOR"/"$slug"*.zip | head -1)
  echo "$slug: $(basename "$zip") sha256 $(sha256sum "$zip" | cut -d' ' -f1)"
  wp theme is-installed "$slug" || wp theme install "$zip"
done
for bad in $(python3 -c "import json;print(' '.join(json.load(open('$HERE/plugins.json'))['never']))"); do
  if wp plugin is-installed "$bad"; then echo "STOP: $bad must not be on this site"; exit 1; fi
done

step "6. Our code from git (no Novamira: a must-use plugin loads it)"
rm -rf "$WPPATH/wp-content/novamira-sandbox"
cp -a "$REPO/wp/novamira-sandbox" "$WPPATH/wp-content/novamira-sandbox"
cp "$HERE/novamira-sandbox.htaccess" "$WPPATH/wp-content/novamira-sandbox/.htaccess"
cp "$HERE/mu-plugins/reinforce-lab.php" "$WPPATH/wp-content/mu-plugins/reinforce-lab.php"
echo "code: $(cd "$REPO" && git rev-parse --short HEAD) ($(find "$WPPATH/wp-content/novamira-sandbox" -name '*.php' | wc -l) PHP files)"

step "7. Activate theme and plugins (before the settings import, so imported settings win)"
wp theme activate bb-theme
wp plugin activate $(python3 -c "import json;d=json.load(open('$HERE/plugins.json'));print(' '.join(d['free']+list(d['vendor_plugins'])))")

step "8. Import content and settings (same IDs)"
wp eval-file "$HERE/import.php" "$EXPORT" wipe-fresh

step "9. Site address in content and settings: $SOURCE -> $URL"
wp search-replace "$SOURCE" "$URL" --all-tables-with-prefix --precise --skip-columns=guid --report-changed-only
wp search-replace "${SOURCE/https:/http:}" "$URL" --all-tables-with-prefix --precise --skip-columns=guid --report-changed-only
ESC_SRC=$(printf '%s' "$SOURCE" | sed 's#/#\\/#g'); ESC_URL=$(printf '%s' "$URL" | sed 's#/#\\/#g')
wp search-replace "$ESC_SRC" "$ESC_URL" --all-tables-with-prefix --precise --skip-columns=guid --report-changed-only
left=$(wp db query "SELECT COUNT(*) FROM $(wp db prefix)posts WHERE post_content LIKE '%${SOURCE#https://}%'" --skip-column-names)
echo "posts still naming ${SOURCE#https://}: $left"

step "10. Media, each file checked (sha1 + file type)"
wp eval-file "$HERE/media.php" "$EXPORT" "$SOURCE"

step "11. Server rules: WordPress permalinks + approved 410s for old files"
wp rewrite structure '/%postname%/' --hard
python3 "$REPO/claude/tools/redirects.py" htaccess >/dev/null
HT="$WPPATH/.htaccess"
touch "$HT"
python3 - "$HT" "$HERE/htaccess-410.conf" <<'PY'
import re, sys
ht, block = sys.argv[1], open(sys.argv[2]).read()
s = open(ht).read()
s = re.sub(r'# BEGIN Reinforce Lab 410.*?# END Reinforce Lab 410\n?', '', s, flags=re.S)
open(ht, 'w').write(block + '\n' + s)  # before the WordPress block, so it is checked first
PY
grep -c "RewriteRule" "$HT" | xargs echo "rewrite rules in .htaccess:"

step "12. Final checks"
wp cache flush
wp option get blog_public | grep -qx 0 && echo "indexing: off (staging)"
wp plugin list --status=active --field=name | sort | tr '\n' ' '; echo
wp core verify-checksums
wp plugin verify-checksums $(python3 -c "import json;print(' '.join(json.load(open('$HERE/plugins.json'))['free']))")
for p in / /blog/ /services/ /about-us/ /contact-us/ /search-authority-diagnostic/ /get-a-free-quote/ /product-sitemap.xml; do
  printf "%-32s %s\n" "$p" "$(curl -s -o /dev/null -w '%{http_code} %{redirect_url}' "$URL$p")"
done
echo
echo "Next (Step 3): from the repository, run"
echo "  python3 claude/tools/redirect-test.py $URL"
echo "  python3 claude/tools/link-scan.py $URL"
echo "and the parity checks in claude/rebuild/README.md. Log: $LOG"
