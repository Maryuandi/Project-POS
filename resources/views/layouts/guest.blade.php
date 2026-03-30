<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Victory Toys') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .auth-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dot-pattern {
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .glow {
            box-shadow: 0 0 60px rgba(59, 130, 246, 0.15), 0 0 120px rgba(59, 130, 246, 0.05);
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen auth-gradient dot-pattern flex items-center justify-center p-4">

        <div class="w-full sm:max-w-md relative z-10">

            <!-- Card -->
            <div class="mb-1">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="text-center text-xs text-gray-500 mt-6">
                &copy; {{ date('Y') }} {{ config('app.name', 'Victory Toys') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>