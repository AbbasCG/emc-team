# EMC Volunteer System — Hostinger Shared Hosting Deployment Guide

This guide deploys **Laravel 13 / PHP 8.3** to Hostinger Shared Hosting when:

- **Web PHP** is 8.3 (correct for Laravel 13)
- **SSH CLI PHP** is only 8.2 (Composer and `php artisan` fail under default `php`)
- **Composer cannot run on the server** — dependencies are built locally and `vendor/` is uploaded

---

## Executive summary

| Question | Answer for this project |
|----------|-------------------------|
| Can we upload `vendor/` from local? | **Yes** — all dependencies are pure PHP (`--prefer-dist`). No native binaries are compiled into `vendor/`. |
| Platform-specific vendor files? | **None** that block Windows → Linux upload. Runtime needs standard PHP extensions (PDO, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo). |
| Post-install Composer scripts on production? | **No** — `package:discover` runs during local `composer install`. Upload includes `bootstrap/cache/packages.php` and `services.php`. |
| Config / route / view cache — where? | **On production** with production `.env` (via PHP 8.3 CLI or temporary web runner). Never cache config locally and upload. |
| Storage symlink | Required: `public/storage` → `storage/app/public` |
| Vite assets | Required: run `npm run build` locally; upload `public/build/` |

---

## Architecture on Hostinger

Recommended layout (document root points at Laravel `public/`):

```
/home/u123456789/
├── domains/your-domain.com/
│   └── laravel/              ← full app (app, vendor, storage, …)
│       └── public/           ← document root (hPanel → Domains → Document root)
```

Alternative: place app outside `public_html` and set document root to `…/laravel/public`.

**Never** expose `vendor/`, `.env`, or project root as the web root.

---

## Prerequisites

### Local machine (build)

- PHP **8.3+** and Composer
- Node.js 18+ and npm
- Git (optional, for version tracking in `BUILD_INFO.txt`)

### Hostinger (runtime)

- PHP **8.3** selected in hPanel → **Advanced → PHP Configuration** for the domain
- MySQL database created in hPanel → **Databases**
- SSH or File Manager / FTP access
- PHP extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo` (Hostinger defaults usually include these)

---

## One-time server setup

### 1. Create MySQL database

In hPanel → **Databases**, create database, user, and password. Note:

- `DB_HOST` is usually `localhost`
- Use the full database name and username Hostinger assigns

### 2. Create production `.env`

On the server, create `.env` in the Laravel root (copy from `deployment/env.production.example`):

```bash
cp deployment/env.production.example .env
# Edit with Hostinger DB credentials, APP_URL, mail, etc.
```

Generate `APP_KEY` (pick one method):

**A — SSH with PHP 8.3** (if available, see below):

```bash
/usr/bin/ea-php83 artisan key:generate --force
```

**B — Locally**, then paste into server `.env`:

```bash
php artisan key:generate --show
```

Set `APP_DEBUG=false`, `APP_ENV=production`, correct `APP_URL`.

Optional (for one-time web Artisan runner):

```env
DEPLOY_ARTISAN_TOKEN=your-long-random-secret-here
```

### 3. Document root

hPanel → **Domains** → your domain → **Document root** → set to:

```
/home/u123456789/domains/your-domain.com/laravel/public
```

(Adjust path to match your upload location.)

---

## Local build (every release)

### Automated (recommended)

**Windows (XAMPP):**

```powershell
cd D:\xampp\htdocs\EMC-Volunteer-System
.\deployment\build.ps1
# Or with explicit PHP:
.\deployment\build.ps1 -PhpPath "D:\xampp\php\php.exe"
```

**Linux / macOS / WSL / Git Bash:**

```bash
cd /path/to/EMC-Volunteer-System
chmod +x deployment/build.sh
./deployment/build.sh
```

Output: **`deployment/release/`** — upload **contents** of this folder to the server.

### Manual steps (equivalent)

```bash
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
npm ci && npm run build
php artisan config:clear && php artisan route:clear && php artisan view:clear
```

Or use the Composer alias:

```bash
composer deploy-build
npm run build
```

---

## What to upload

Upload everything inside `deployment/release/` (or equivalent) via **SFTP, File Manager, or rsync over SSH**.

### Include

| Path | Notes |
|------|--------|
| `app/` | Application code |
| `bootstrap/` | Framework bootstrap; includes `cache/packages.php`, `services.php` from build |
| `config/` | Configuration |
| `database/migrations/` | Required for `migrate` |
| `database/seeders/` | Optional; for initial admin/departments |
| `public/` | **Including `public/build/`** (Vite) |
| `resources/` | Views, lang, CSS source |
| `routes/` | Web routes |
| `storage/` | Directory structure (empty logs/cache/sessions) |
| `vendor/` | **From local `--no-dev` build** |
| `artisan` | CLI entry |
| `composer.json`, `composer.lock` | Reference only; Composer not run on server |

### Do NOT upload

| Path | Reason |
|------|--------|
| `.env` | Create/edit only on server |
| `node_modules/` | Not needed in production |
| `.git/` | Not needed |
| `tests/` | Excluded from release package |
| `deployment/release/` | Build output only |
| `public/hot` | Vite dev server marker |
| `public/storage` | Created by `storage:link` on server |
| `database/database.sqlite` | Local dev only |
| `bootstrap/cache/config.php` | Generated on server with prod `.env` |
| `bootstrap/cache/routes*.php` | Generated on server |
| Local log/session/cache files | Server creates its own |

---

## Post-upload steps on Hostinger

Run these **once per deploy** using PHP **8.3**.

### Finding PHP 8.3 on SSH

Hostinger often installs multiple PHP versions. Try:

```bash
which php
php -v                    # often 8.2 on CLI

/usr/bin/ea-php83 -v      # common on cPanel/Hostinger
/opt/alt/php83/usr/bin/php -v
ls /usr/bin/ea-php*
```

If **8.3 CLI works**, set an alias for the session:

```bash
cd /home/u123456789/domains/your-domain.com/laravel
PHP83=/usr/bin/ea-php83   # adjust path

$PHP83 artisan migrate --force
$PHP83 artisan storage:link
$PHP83 artisan optimize
```

### If SSH is only PHP 8.2 — use web runner (temporary)

1. Ensure `DEPLOY_ARTISAN_TOKEN` is set in server `.env`
2. Copy `deployment/hostinger-artisan.php` → `public/hostinger-artisan.php`
3. Run in browser (replace token and domain):

```
https://your-domain.com/hostinger-artisan.php?token=YOUR_TOKEN&cmd=migrate
https://your-domain.com/hostinger-artisan.php?token=YOUR_TOKEN&cmd=storage-link
https://your-domain.com/hostinger-artisan.php?token=YOUR_TOKEN&cmd=optimize
```

4. **Delete `public/hostinger-artisan.php` immediately**

Allowed `cmd` values: `migrate`, `storage-link`, `optimize`, `config-cache`, `route-cache`, `view-cache`, `seed`, `about`.

### First deploy only — seed admin and departments

```bash
$PHP83 artisan db:seed --force
```

Default admin (change password after login):

- Email: `admin@emc.org`
- Password: `password`

---

## Required Artisan commands (reference)

| Command | When | Why |
|---------|------|-----|
| `migrate --force` | Every release with new migrations | Apply schema changes |
| `storage:link` | First deploy; verify after | Serves uploaded files from `storage/app/public` |
| `config:cache` | After `.env` changes | Production performance |
| `route:cache` | Every deploy | Faster routing |
| `view:cache` | Every deploy | Precompiled Blade |
| `optimize` | Every deploy | Runs config + route + view cache + event cache |
| `config:clear` | Before rollback / debug | Clears bad cached config |
| `db:seed --force` | First deploy only | Admin user + departments |

**Do not** run `composer install` on the server.

---

## Permissions

From Laravel root on server:

```bash
chmod -R ug+rwx storage bootstrap/cache
# If needed:
chmod -R o+rX storage bootstrap/cache
```

Via File Manager: folders `storage/` and `bootstrap/cache/` must be writable by the web server (typically `755` or `775`).

---

## Symlinks

| Link | Target | Created by |
|------|--------|------------|
| `public/storage` | `../storage/app/public` | `php artisan storage:link` |

If symlinks are disabled on shared hosting, create manually via SSH:

```bash
cd public
ln -s ../storage/app/public storage
```

Verify: `https://your-domain.com/storage/` should not 404 if files exist in `storage/app/public`.

---

## Cache strategy (important)

| Cache | Build locally? | Build on production? |
|-------|------------------|----------------------|
| Composer autoloader | **Yes** (`--optimize-autoloader`) | No |
| `bootstrap/cache/packages.php` | **Yes** (via `composer install`) | No |
| `bootstrap/cache/config.php` | **No** | **Yes** (needs prod `.env`) |
| `bootstrap/cache/routes*.php` | **No** | **Yes** |
| Compiled views | **No** | **Yes** (`view:cache` or `optimize`) |
| Application data cache | No | Runtime (database cache driver) |

**Never** upload `bootstrap/cache/config.php` from your local machine — it embeds local DB and `APP_URL`.

---

## Composer scripts (this project)

From `composer.json`:

| Script | Runs when | Required on server? |
|--------|-----------|---------------------|
| `post-autoload-dump` → `package:discover` | Local `composer install` | **No** — output is in uploaded `bootstrap/cache/` |
| `post-update-cmd` → `vendor:publish --tag=laravel-assets` | Local `composer update` | **No** for this Blade app |
| `deploy-build` | Manual local | Convenience alias |

---

## Platform and dependency risks

### Safe for vendor upload

- Laravel framework and all listed packages install as **PHP source/dist archives**
- No `ext-zip` compile step in vendor; no OS-specific binaries in this lock file
- `intervention/image` is declared but **not used in application code** — no GD requirement until you use it

### Windows → Linux

Pure PHP vendor is generally portable. If you hit autoload or line-ending issues, rebuild using **WSL** or Docker with Linux + PHP 8.3.

### PHP version check at runtime

`vendor/composer/platform_check.php` requires PHP 8.3 — satisfied by Hostinger **web** PHP 8.3. Default SSH `php` 8.2 must **not** be used to run the app or Artisan.

### Shared hosting limits

- **No queue worker** — `.env` uses `QUEUE_CONNECTION=sync` in production example (no background jobs in app today)
- **Scheduler** — no custom scheduled tasks in `routes/console.php`; cron optional for now
- **Session/cache** — `database` driver; ensure migrations have run (`sessions`, `cache` tables)

---

## Update procedure (routine releases)

1. **Local:** pull latest code, run `./deployment/build.ps1` or `./deployment/build.sh`
2. **Backup:** Hostinger database + current `storage/app` uploads if any
3. **Upload:** sync `deployment/release/` to server (overwrite files; keep server `.env`)
4. **Server:** maintenance mode optional:

   ```bash
   $PHP83 artisan down --secret="emc-deploy-2026"
   # visit site with ?secret=emc-deploy-2026 to preview
   ```

5. **Server:**

   ```bash
   $PHP83 artisan migrate --force
   $PHP83 artisan optimize
   $PHP83 artisan up
   ```

6. Smoke-test: login, volunteers list, job descriptions, public apply form
7. Remove `public/hostinger-artisan.php` if used

### Files to preserve on server between deploys

- `.env`
- `storage/app/**` (user uploads)
- `storage/logs/` (optional)

---

## Rollback procedure

1. Put site in maintenance: `$PHP83 artisan down`
2. Restore **previous release files** from backup (except `.env` and `storage/app`)
3. Restore database from backup if migrations ran
4. Clear caches:

   ```bash
   $PHP83 artisan config:clear
   $PHP83 artisan route:clear
   $PHP83 artisan view:clear
   $PHP83 artisan optimize
   ```

5. `$PHP83 artisan up`

Keep at least one previous `deployment/release/` zip locally for fast rollback.

---

## Troubleshooting

| Symptom | Likely cause | Fix |
|---------|--------------|-----|
| 500 on every page | Missing `APP_KEY`, bad `.env`, wrong permissions | Set key; `chmod storage bootstrap/cache`; check `storage/logs/laravel.log` |
| `requires php ^8.3` when using SSH | CLI is 8.2 | Use `ea-php83` or web runner |
| White page, no CSS | Missing `public/build/` | Run `npm run build` locally and re-upload |
| `@vite` error | Same as above | Upload `public/build/manifest.json` |
| 419 on login | Session/CSRF; `APP_URL` mismatch | Fix `APP_URL`; ensure `sessions` table exists |
| Storage images 404 | No symlink | `storage:link` |
| Class not found after deploy | Incomplete vendor upload | Re-run local build; re-upload full `vendor/` |
| Dev providers in prod | Built with dev deps | Rebuild with `composer install --no-dev` |

---

## Security checklist

- [ ] `APP_DEBUG=false` in production
- [ ] Strong `APP_KEY` and DB passwords
- [ ] `.env` not web-accessible (root above `public/`)
- [ ] Delete `public/hostinger-artisan.php` after use
- [ ] Change default admin password after first login
- [ ] `SESSION_SECURE_COOKIE=true` when using HTTPS

---

## Quick reference — first deploy checklist

```
[ ] Local:  .\deployment\build.ps1  (or build.sh)
[ ] Server: Create MySQL DB
[ ] Server: Create .env from deployment/env.production.example
[ ] Server: Upload deployment/release/* to laravel root
[ ] Server: chmod storage bootstrap/cache
[ ] Server: migrate --force
[ ] Server: storage:link
[ ] Server: optimize
[ ] Server: db:seed --force (first time only)
[ ] Server: Document root → laravel/public
[ ] Test:   Admin login, RTL layout, forms
[ ] Delete: hostinger-artisan.php if used
```

---

## Files in `deployment/`

| File | Purpose |
|------|---------|
| `DEPLOYMENT.md` | This guide |
| `build.ps1` | Windows build script |
| `build.sh` | Bash build script |
| `rsync-excludes.txt` | Release packaging excludes |
| `env.production.example` | Production `.env` template |
| `hostinger-artisan.php` | Temporary web Artisan runner (PHP 8.3) |

---

*Laravel 13 · PHP ^8.3 · Hostinger Shared Hosting · vendor-upload workflow*
