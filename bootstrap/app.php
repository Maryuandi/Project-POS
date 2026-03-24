<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Intercept the very first crash before the generic Exception Handler calls the View Engine.
        $exceptions->report(function (\Throwable $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'FATAL_CRASH' => $e->getMessage(),
                'FILE' => $e->getFile(),
                'LINE' => $e->getLine(),
                'TRACE' => $e->getTraceAsString()
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            exit(1);
        });
    })->create();
