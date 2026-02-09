<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Talantia') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-obsidian antialiased bg-tactile-bg">
        <div class="min-h-screen flex flex-col items-center pt-10 sm:pt-20 pb-10 p-4 sm:p-6 bg-tactile-bg">
            <div class="w-full flex justify-center mb-8 animate-fade-in-down">
                <a href="/" class="inline-flex items-center justify-center gap-3 md:gap-4 group">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-obsidian rounded-xl md:rounded-2xl flex items-center justify-center shadow-gloss group-hover:shadow-gloss-hover transform group-hover:scale-105 group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-layer-group text-white text-xl md:text-2xl"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-extrabold text-obsidian tracking-tight">Talantia</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 sm:px-10 py-8 sm:py-10 bg-white shadow-tactile overflow-hidden rounded-xl sm:rounded-2xl border border-white/50 relative animate-fade-in-scale" style="animation-delay: 0.1s;">
                <div class="absolute top-0 left-0 w-24 md:w-32 h-24 md:h-32 bg-mono-50 rounded-full -ml-12 md:-ml-16 -mt-12 md:-mt-16 opacity-50 pointer-events-none"></div>
                <div class="absolute bottom-0 right-0 w-20 md:w-24 h-20 md:h-24 bg-mono-50 rounded-full -mr-10 md:-mr-12 -mb-10 md:-mb-12 opacity-50 pointer-events-none"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
