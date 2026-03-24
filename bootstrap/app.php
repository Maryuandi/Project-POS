<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Force Laravel Caches to the Vercel writable lambda layer natively before booting, dodging server environment sync bugs!
$tmp = '/tmp/framework';
if (!is_dir($tmp)) mkdir($tmp, 0777, true);

foreach (['CONFIG', 'ROUTES', 'EVENTS', 'PACKAGES', 'SERVICES'] as $cache) {
    $_ENV["APP_{$cache}_CACHE"] = "$tmp/".strtolower($cache).".php";
    putenv("APP_{$cache}_CACHE=$tmp/".strtolower($cache).".php");
}
$_ENV['VIEW_COMPILED_PATH'] = $tmp;
putenv("VIEW_COMPILED_PATH=$tmp");

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

$app->useStoragePath($tmp);
return $app;
