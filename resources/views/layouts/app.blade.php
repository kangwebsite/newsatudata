<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {!! seo($SEOData ?? null) !!}
        
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/@phosphor-icons/web"></script>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>
    <body class="font-sans text-slate-800 bg-gray-50 overflow-x-hidden flex flex-col min-h-screen">
        <livewire:topbar />
        
        <main class="grow">
            {{ $slot }}
        </main>

        <livewire:logo-sections/>
        <livewire:footer />

        @livewire('notifications')

        @if (config('services.turnstile.enabled'))
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        @endif
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
