<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 viewBox%3D%220 0 24 24%22 class%3D%22size-6%22 fill%3D%22none%22 stroke%3D%22currentColor%22 stroke-width%3D%221.8%22 aria-hidden%3D%22true%22%3E%3Cpath stroke-linecap%3D%22round%22 stroke-linejoin%3D%22round%22 d%3D%22M4 13v-2a8 8 0 0 1 16 0v2%22 %2F%3E%3Cpath stroke-linecap%3D%22round%22 stroke-linejoin%3D%22round%22 d%3D%22M4 13h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4Zm16 0h-2a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-4Z%22 %2F%3E%3C%2Fsvg%3E" sizes="any" />
        {{-- <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 viewBox%3D%220 0 24 24%22 class%3D%22size-6%22 fill%3D%22none%22 stroke%3D%22currentColor%22 stroke-width%3D%221.8%22 aria-hidden%3D%22true%22%3E%3Cpath stroke-linecap%3D%22round%22 stroke-linejoin%3D%22round%22 d%3D%22M4 13v-2a8 8 0 0 1 16 0v2%22 %2F%3E%3Cpath stroke-linecap%3D%22round%22 stroke-linejoin%3D%22round%22 d%3D%22M4 13h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4Zm16 0h-2a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-4Z%22 %2F%3E%3C%2Fsvg%3E" sizes="any" />
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png"> --}}

        @fonts

        @if(config('services.google.analytics_id'))
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ config('services.google.analytics_id') }}');
            </script>
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.ts'])
        <x-inertia::head>
            <title>{{ config('app.name', "'نغمة انتظار المتصل السودان RBT Sudan'") }}</title>

        </x-inertia::head>
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
