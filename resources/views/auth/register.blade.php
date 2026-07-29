@extends('layouts.auth')

@section('title', config('app.name', 'Twitter') . ' - Create account')

@section('heading')
    <h1 class="text-2xl font-bold leading-tight text-white sm:text-3xl">
        Create your account
    </h1>
@endsection

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="mb-2 block text-sm font-semibold text-gray-200">
                Name
            </label>
            <input
                id="name"
                class="block w-full rounded-xl border border-gray-700 bg-[#15202b] px-4 py-3 text-base text-white placeholder-gray-500 transition duration-200 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Name"
                required
                autofocus
                autocomplete="name">

            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

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
                autocomplete="new-password">

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-200">
                Confirm password
            </label>
            <input
                id="password_confirmation"
                class="block w-full rounded-xl border border-gray-700 bg-[#15202b] px-4 py-3 text-base text-white placeholder-gray-500 transition duration-200 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                type="password"
                name="password_confirmation"
                placeholder="Confirm password"
                required
                autocomplete="new-password">

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-full bg-blue-500 px-5 py-3 text-base font-bold text-white transition duration-200 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
            Create account
        </button>

        <p class="border-t border-gray-800 pt-5 text-center text-sm text-gray-400">
            Already have an account?
            <a
                href="{{ route('login') }}"
                class="font-semibold text-blue-400 transition duration-200 hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                Sign in
            </a>
        </p>
    </form>
@endsection
