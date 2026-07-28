<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Twitter') }} - Sign in</title>

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

                    <h1 class="text-2xl font-bold leading-tight text-white sm:text-3xl">
                        Sign in to Twitter
                    </h1>
                </div>

                <x-auth-session-status class="mb-5 w-full rounded-xl border border-blue-500/30 bg-blue-500/10 px-4 py-3 text-sm font-medium text-blue-100" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-200">
                            Email
                        </label>
                        <input
                            id="email"
                            class="block w-full rounded-xl border border-gray-700 bg-[#15202b] px-4 py-3 text-base text-white placeholder-gray-500 transition duration-200 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email address"
                            required
                            autofocus
                            autocomplete="username">

                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-200">
                            Password
                        </label>
                        <input
                            id="password"
                            class="block w-full rounded-xl border border-gray-700 bg-[#15202b] px-4 py-3 text-base text-white placeholder-gray-500 transition duration-200 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required
                            autocomplete="current-password">

                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                    </div>

                    <div class="flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                        <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2 text-gray-300">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 rounded border-gray-700 bg-[#15202b] text-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-offset-0">
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="font-medium text-blue-400 transition duration-200 hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-full bg-blue-500 px-5 py-3 text-base font-bold text-white transition duration-200 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                        Log in
                    </button>

                    @if (Route::has('register'))
                        <p class="border-t border-gray-800 pt-5 text-center text-sm text-gray-400">
                            Don't have an account?
                            <a
                                href="{{ route('register') }}"
                                class="font-semibold text-blue-400 transition duration-200 hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                                Create account
                            </a>
                        </p>
                    @endif
                </form>
            </section>
        </main>
    </body>
</html>
