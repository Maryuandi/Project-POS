<?php

// Track execution start
define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

// Vercel's serverless environment provides a read-only filesystem except for the /tmp directory.
// We must physically map Laravel's storage cache, sessions, and compiled views to the writable /tmp path.
$storagePath = '/tmp/storage';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0777, true);
    mkdir($storagePath.'/framework/cache/data', 0777, true);
    mkdir($storagePath.'/framework/views', 0777, true);
    mkdir($storagePath.'/framework/sessions', 0777, true);
    mkdir($storagePath.'/logs', 0777, true);
}

// Override critical environment variables to function correctly in a Serverless context
$_ENV['VIEW_COMPILED_PATH'] = $storagePath . '/framework/views';
$_ENV['SESSION_DRIVER'] = $_ENV['SESSION_DRIVER'] ?? 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr'; // Route logs to Vercel Console

$app = require_once __DIR__.'/../bootstrap/app.php';

// Instruct the Laravel application to override standard storage paths
$app->useStoragePath($storagePath);

$app->handleRequest(Illuminate\Http\Request::capture());
