<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Twitter'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#15202b] font-sans text-white antialiased">
        <main class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <section class="w-full max-w-[440px] rounded-2xl border border-gray-800 bg-gray-900/95 px-6 py-8 shadow-2xl shadow-black/30 sm:px-10 sm:py-10">
                <div class="mb-8 flex flex-col items-center text-center">
                    <a
                        href="/"
                        class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full text-white transition duration-200 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900"
                        aria-label="Twitter home">
                        <svg viewBox="0 0 24 24" class="h-12 w-12" fill="currentColor" aria-hidden="true">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817-5.966 6.817H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z" />
                        </svg>
                    </a>

                    @yield('heading')
                </div>

                @yield('content')
            </section>
        </main>
    </body>
</html>
