#!/usr/bin/env bash
# =============================================================================
# EMC Volunteer System — post-upload steps on Hostinger (run via SSH)
# Does NOT run Composer. Requires PHP 8.3 CLI or falls back to instructions.
# =============================================================================
set -euo pipefail

APP_DIR="${1:-$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)}"
cd "$APP_DIR"

echo "==> EMC post-deploy (Hostinger)"
echo "    App dir: $APP_DIR"

# Detect PHP 8.3
PHP83=""
for candidate in \
  "${PHP_BIN:-}" \
  /usr/bin/ea-php83 \
  /opt/alt/php83/usr/bin/php \
  "$(command -v php83 2>/dev/null || true)"
do
  [ -z "$candidate" ] && continue
  [ -x "$candidate" ] || continue
  ver=$("$candidate" -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;' 2>/dev/null || echo "0.0")
  major=${ver%%.*}
  minor=${ver#*.}
  if [ "$major" -ge 8 ] && { [ "$major" -gt 8 ] || [ "$minor" -ge 3 ]; }; then
    PHP83="$candidate"
    break
  fi
done

if [ -z "$PHP83" ]; then
  echo ""
  echo "ERROR: PHP 8.3 CLI not found."
  echo "SSH default php is likely 8.2. Options:"
  echo "  1. Try: ls /usr/bin/ea-php*  and export PHP_BIN=/usr/bin/ea-php83"
  echo "  2. Use deployment/hostinger-artisan.php via web (see DEPLOYMENT.md)"
  exit 1
fi

echo "    PHP:     $($PHP83 -v | head -1)"

if [ ! -f .env ]; then
  echo "ERROR: .env missing. Copy deployment/env.production.example to .env and configure."
  exit 1
fi

if [ ! -d vendor ]; then
  echo "ERROR: vendor/ missing. Run deployment/build.ps1 or build.sh locally and upload."
  exit 1
fi

echo "==> Permissions"
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

echo "==> Migrations"
$PHP83 artisan migrate --force

echo "==> Storage link"
if [ ! -L public/storage ] && [ ! -d public/storage ]; then
  $PHP83 artisan storage:link
else
  echo "    public/storage already exists — skipping"
fi

echo "==> Optimize (config + route + view cache)"
$PHP83 artisan optimize

echo ""
echo "==> POST-DEPLOY COMPLETE"
echo "    Run 'db:seed --force' on first deploy only."
echo "    Verify: php artisan about  →  Laravel version, environment production"
