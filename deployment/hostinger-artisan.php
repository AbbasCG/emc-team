<?php
/**
 * Hostinger one-time Artisan runner (uses web PHP 8.3 when SSH CLI is PHP 8.2).
 *
 * SETUP:
 *   1. Set DEPLOY_ARTISAN_TOKEN in production .env (long random string).
 *   2. Copy this file to public/hostinger-artisan.php temporarily.
 *   3. Visit: https://your-domain.com/hostinger-artisan.php?token=YOUR_TOKEN&cmd=optimize
 *   4. DELETE public/hostinger-artisan.php immediately after success.
 *
 * Allowed commands: migrate, storage-link, optimize, config-cache, route-cache, view-cache, seed
 *
 * NEVER leave this file on production long-term.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$allowed = [
    'migrate'       => ['migrate', '--force'],
    'storage-link'  => ['storage:link'],
    'optimize'      => ['optimize'],
    'config-cache'  => ['config:cache'],
    'route-cache'   => ['route:cache'],
    'view-cache'    => ['view:cache'],
    'seed'          => ['db:seed', '--force'],
    'about'         => ['about'],
];

header('Content-Type: text/plain; charset=utf-8');

if (PHP_VERSION_ID < 80300) {
    http_response_code(500);
    exit("This script requires PHP 8.3+ (web). Current: " . PHP_VERSION . "\n");
}

if (!is_file($root . '/vendor/autoload.php')) {
    http_response_code(500);
    exit("vendor/autoload.php not found. Upload vendor/ from local build.\n");
}

require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$token = $_GET['token'] ?? '';
$expected = (string) env('DEPLOY_ARTISAN_TOKEN', '');

if ($expected === '' || !hash_equals($expected, $token)) {
    http_response_code(403);
    exit("Forbidden.\n");
}

$cmd = $_GET['cmd'] ?? '';
if (!isset($allowed[$cmd])) {
    http_response_code(400);
    exit("Unknown cmd. Allowed: " . implode(', ', array_keys($allowed)) . "\n");
}

$status = $kernel->call($allowed[$cmd][0], array_slice($allowed[$cmd], 1));
echo $kernel->output();
echo "\nExit code: {$status}\n";
