<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Twitter'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased twitter-shell">
        <div class="min-h-screen bg-[#15202b] text-white">
            <div class="flex justify-center">
                <header class="text-white h-12 py-4 h-auto">
                    @include('home.left-sidebar')
                </header>

                <main role="main">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
