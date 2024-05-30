<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="/favicon.svg" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="theme-color" content="#000000" />
        <title>Sqword</title>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-DJM6J1D7T7"></script>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script>
            (window.dataLayer = window.dataLayer || []),
            (window.gtag = function() {
                dataLayer.push(arguments);
            }),
            window.gtag("js", new Date()),
                window.gtag("config", "G-DJM6J1D7T7");
        </script>
        @vite(['resources/css/sqword.css', 'resources/js/sqword.js'])
    </head>

    <body>
        {{-- @include('layouts.navigation') --}}
        <noscript>Es necesita JavaScript per a poder jugar</noscript>
        <div id="sqword-root">
            <div id="root"></div>
        </div>
    </body>

    </html>

</x-app-layout>
