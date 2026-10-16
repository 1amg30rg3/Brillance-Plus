<!DOCTYPE html>
<!--
    Designed and built by {{ config('agency.name') }}: custom websites and web applications.
    {{ config('agency.url') }}
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light dark">
        <meta name="theme-color" content="#FFFFFF" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#0A0F1C" media="(prefers-color-scheme: dark)">

        {{-- Apply the saved (or system) theme before the first paint to avoid a flash of the wrong theme. --}}
        <script>
            (function () {
                var preference = 'system';

                try {
                    preference = window.localStorage.getItem('appearance') || 'system';
                } catch (error) {}

                var isDark = preference === 'dark'
                    || (preference !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches);

                document.documentElement.classList.toggle('dark', isDark);
                document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
            })();
        </script>

        <style>
            html { background-color: #FFFFFF; }
            html.dark { background-color: #0A0F1C; }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="32x32">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="author" href="/humans.txt">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])

        <x-inertia::head>
            @include('partials.seo', ['seo' => $page['props']['seo'] ?? null])
        </x-inertia::head>

        @isset($structuredData)
            <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
        @endisset
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
