#Requires -Version 5.1
<#
.SYNOPSIS
  Build a production release package for Hostinger (Composer runs locally on PHP 8.3+).

.EXAMPLE
  .\deployment\build.ps1
  .\deployment\build.ps1 -PhpPath "C:\xampp\php\php.exe"
#>
param(
    [string]$PhpPath = "php"
)

$ErrorActionPreference = "Stop"
$Root = Split-Path -Parent (Split-Path -Parent $MyInvocation.MyCommand.Path)
$Release = Join-Path $Root "deployment\release"

Write-Host "==> EMC Volunteer System - production build" -ForegroundColor Cyan
Write-Host "    Project: $Root"

$phpVersionLine = & $PhpPath -v | Select-Object -First 1
if ($phpVersionLine -notmatch 'PHP 8\.([3-9]|[1-9][0-9]+)') {
    throw ('PHP 8.3+ required. Current: ' + $phpVersionLine)
}
Write-Host ('    PHP:     ' + $phpVersionLine)

Set-Location $Root

Write-Host '==> Composer production no-dev' -ForegroundColor Cyan
if (-not (Get-Command composer -ErrorAction SilentlyContinue)) {
    throw 'composer not found in PATH'
}
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress
if ($LASTEXITCODE -ne 0) { throw 'composer install failed' }

Write-Host '==> NPM build' -ForegroundColor Cyan
$manifest = Join-Path $Root 'public\build\manifest.json'
if (Get-Command npm -ErrorAction SilentlyContinue) {
    $prevEap = $ErrorActionPreference
    $ErrorActionPreference = 'Continue'
    cmd /c "npm ci --ignore-scripts 2>nul || npm install --ignore-scripts"
    cmd /c "npm run build"
    $npmExit = $LASTEXITCODE
    $ErrorActionPreference = $prevEap
    if ($npmExit -ne 0) {
        if (Test-Path $manifest) {
            Write-Warning 'npm run build failed - using existing public/build from a previous build'
        } else {
            throw 'npm run build failed and public/build/manifest.json is missing'
        }
    }
} elseif (Test-Path $manifest) {
    Write-Warning 'npm not found - using existing public/build'
} else {
    throw 'npm not found and public/build/manifest.json is missing'
}

Write-Host '==> Clear local caches' -ForegroundColor Cyan
& $PhpPath artisan config:clear 2>$null
& $PhpPath artisan route:clear 2>$null
& $PhpPath artisan view:clear 2>$null
Remove-Item -Force -ErrorAction SilentlyContinue bootstrap/cache/config.php, bootstrap/cache/routes*.php

Write-Host '==> Staging release directory' -ForegroundColor Cyan
if (Test-Path $Release) { Remove-Item -Recurse -Force $Release }
New-Item -ItemType Directory -Path $Release | Out-Null

$excludePatterns = Get-Content (Join-Path $Root "deployment\rsync-excludes.txt") |
    Where-Object { $_ -and -not $_.StartsWith('#') } |
    ForEach-Object { $_.TrimEnd('/') }

function Should-Exclude([string]$relativePath) {
    foreach ($pattern in $excludePatterns) {
        $p = $pattern.TrimEnd('/').Replace('/', '\')
        if ($relativePath -like ($p + '*') -or $relativePath -eq $p) { return $true }
    }
    return $false
}

Get-ChildItem -Path $Root -Recurse -Force | ForEach-Object {
    $rel = $_.FullName.Substring($Root.Length + 1)
    if ($rel -match '^deployment\\release') { return }
    if (Should-Exclude $rel) { return }

    $dest = Join-Path $Release $rel
    if ($_.PSIsContainer) {
        if (-not (Test-Path $dest)) { New-Item -ItemType Directory -Path $dest -Force | Out-Null }
    } else {
        $destDir = Split-Path $dest -Parent
        if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }
        Copy-Item -Path $_.FullName -Destination $dest -Force
    }
}

@(
    "storage\framework\cache\data",
    "storage\framework\sessions",
    "storage\framework\views",
    "storage\framework\testing",
    "storage\logs",
    "storage\app\public",
    "bootstrap\cache"
) | ForEach-Object {
    $p = Join-Path $Release $_
    if (-not (Test-Path $p)) { New-Item -ItemType Directory -Path $p -Force | Out-Null }
}

$gitHash = 'unknown'
if (Get-Command git -ErrorAction SilentlyContinue) {
    $gitHash = git -C $Root rev-parse --short HEAD 2>$null
    if (-not $gitHash) { $gitHash = 'unknown' }
}

$buildInfo = @(
    ('Built: ' + (Get-Date).ToUniversalTime().ToString('yyyy-MM-ddTHH:mm:ssZ'))
    ('PHP: ' + (& $PhpPath -v | Select-Object -First 1))
    ('Git: ' + $gitHash)
    'Strategy: vendor bundled - Composer NOT required on server'
    'Next: upload to Hostinger, configure .env, run hostinger-artisan.php or ea-php83 artisan'
) -join [Environment]::NewLine
Set-Content -Path (Join-Path $Release 'BUILD_INFO.txt') -Value $buildInfo

Write-Host ''
Write-Host '==> BUILD COMPLETE' -ForegroundColor Green
Write-Host "    Release package: $Release"
Write-Host '    See deployment/DEPLOYMENT.md for upload steps'
