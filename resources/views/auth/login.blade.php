@extends('layouts.auth')

@section('title', config('app.name', 'Twitter') . ' - Sign in')

@section('heading')
    <h1 class="text-2xl font-bold leading-tight text-white sm:text-3xl">
        Sign in to Twitter
    </h1>
@endsection

@section('content')
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
@endsection
