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

// Overwrite cache paths to be contained within the writable /tmp directory
$_ENV['APP_CONFIG_CACHE'] = $storagePath . '/bootstrap/cache/config.php';
$_ENV['APP_ROUTES_CACHE'] = $storagePath . '/bootstrap/cache/routes-v7.php';
$_ENV['APP_EVENTS_CACHE'] = $storagePath . '/bootstrap/cache/events.php';
$_ENV['APP_PACKAGES_CACHE'] = $storagePath . '/bootstrap/cache/packages.php';
$_ENV['APP_SERVICES_CACHE'] = $storagePath . '/bootstrap/cache/services.php';


$app = require_once __DIR__.'/../bootstrap/app.php';

// Instruct the Laravel application to override standard storage paths
$app->useStoragePath($storagePath);

$request = Illuminate\Http\Request::capture();
// Force JSON temporarily to bypass the crashing Blade View Compiler to see the REAL error
$request->headers->set('Accept', 'application/json');
$app->handleRequest($request);
