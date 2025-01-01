<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <meta property="og:image" content="{{ asset("images/og-image.jpg") }}" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:title" content="ghostyy.town" />
        <meta property="og:description" content="share your ghostty terminal configs and find new ideas from others" />

        <title>ghostyy.town – share your spooky configs</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @fluxStyles
    </head>

    <body class="flex items-center justify-center max-w-md min-h-screen m-auto bg-white dark dark:bg-zinc-800">
        <div class="w-full">
            {{ $slot }}
        </div>
        @persist("toast")
            <flux:toast />
        @endpersist

        @fluxScripts
    </body>
</html>
