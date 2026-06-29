#!/usr/bin/env bash
# =============================================================================
# EMC Volunteer System — local production build (run on PHP 8.3+)
# Output: deployment/release/  (upload this folder contents to Hostinger)
# =============================================================================
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
RELEASE="$ROOT/deployment/release"
PHP_BIN="${PHP_BIN:-php}"

echo "==> EMC Volunteer System — production build"
echo "    Project: $ROOT"
echo "    PHP:     $($PHP_BIN -v | head -1)"

# Require PHP 8.3+
ver=$($PHP_BIN -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
major=${ver%%.*}
minor=${ver#*.}
if [ "$major" -lt 8 ] || { [ "$major" -eq 8 ] && [ "$minor" -lt 3 ]; }; then
  echo "ERROR: PHP 8.3+ required. Current: $ver"
  exit 1
fi

cd "$ROOT"

echo "==> Composer (production, no dev)"
$PHP_BIN "$(which composer 2>/dev/null || echo composer)" install \
  --no-dev \
  --prefer-dist \
  --optimize-autoloader \
  --no-interaction \
  --no-progress

echo "==> NPM build"
if command -v npm >/dev/null 2>&1; then
  npm ci --ignore-scripts 2>/dev/null || npm install --ignore-scripts
  npm run build
else
  echo "WARN: npm not found — run 'npm ci && npm run build' manually before upload"
fi

echo "==> Clear local caches (production caches must be built ON the server)"
$PHP_BIN artisan config:clear --quiet || true
$PHP_BIN artisan route:clear --quiet || true
$PHP_BIN artisan view:clear --quiet || true
rm -f bootstrap/cache/config.php bootstrap/cache/routes*.php 2>/dev/null || true

echo "==> Staging release directory"
rm -rf "$RELEASE"
mkdir -p "$RELEASE"

RSYNC_EXCLUDES="$ROOT/deployment/rsync-excludes.txt"

if command -v rsync >/dev/null 2>&1; then
  rsync -a --delete \
    --exclude-from="$RSYNC_EXCLUDES" \
    "$ROOT/" "$RELEASE/"
else
  echo "WARN: rsync not found — using tar fallback"
  tar -cf - -X "$RSYNC_EXCLUDES" -C "$ROOT" . | tar -xf - -C "$RELEASE"
fi

# Ensure writable dirs exist
mkdir -p "$RELEASE/storage/framework/"{cache/data,sessions,views,testing}
mkdir -p "$RELEASE/storage/logs"
mkdir -p "$RELEASE/storage/app/public"
mkdir -p "$RELEASE/bootstrap/cache"
touch "$RELEASE/storage/logs/.gitkeep"

# Remove dev-only bootstrap cache if present
rm -f "$RELEASE/bootstrap/cache/config.php" "$RELEASE/bootstrap/cache/routes"*.php 2>/dev/null || true

cat > "$RELEASE/BUILD_INFO.txt" <<EOF
Built: $(date -u +"%Y-%m-%dT%H:%M:%SZ")
PHP: $($PHP_BIN -v | head -1)
Git: $(git -C "$ROOT" rev-parse --short HEAD 2>/dev/null || echo "unknown")
Strategy: vendor bundled — Composer NOT required on server
Next: upload to Hostinger, configure .env, run deployment/hostinger-artisan.php or ea-php83 artisan
EOF

echo ""
echo "==> BUILD COMPLETE"
echo "    Release package: $RELEASE"
echo "    Upload contents to Hostinger (see deployment/DEPLOYMENT.md)"
du -sh "$RELEASE" 2>/dev/null || true
