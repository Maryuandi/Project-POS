<?php

// Forward Vercel requests to normal index.php but WRAPPED in a try-catch 
// to prevent the Application from hiding the primary boot error.
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    // This utterly bypasses the 'Target class [view]' crash by intercepting 
    // the original crash *before* Laravel tries to render the HTML screen.
    header('Content-Type: application/json');
    echo json_encode([
        'CRITICAL_ERROR' => $e->getMessage(),
        'FILE' => $e->getFile(),
        'LINE' => $e->getLine(),
        'TRACE' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit(1);
}
