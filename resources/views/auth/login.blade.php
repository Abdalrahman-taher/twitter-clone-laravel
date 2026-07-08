<x-guest-layout>

    <div class="flex min-h-screen items-center justify-center">

        <div class="min-h-1/2 bg-gray-900 border border-gray-900 rounded-2xl">

            <div class="mx-4 sm:mx-24 md:mx-34 lg:mx-56 mx-auto flex items-center space-y-4 py-16 font-semibold text-gray-500 flex-col">

                <svg viewBox="0 0 24 24" class="h-12 w-12 text-white" fill="currentColor">
                    <g>
                        <path
                            d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z">
                        </path>
                    </g>
                </svg>

                <h1 class="text-white text-2xl">
                    Log in to Twitter
                </h1>

                <!-- Session Status -->
                <x-auth-session-status class="w-full" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="w-full space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-text-input
                            id="email"
                            class="w-full p-2 bg-gray-900 border border-gray-700 rounded-md focus:border-blue-700"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="Email"
                            required
                            autofocus
                            autocomplete="username" />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-text-input
                            id="password"
                            class="w-full p-2 bg-gray-900 border border-gray-700 rounded-md"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required
                            autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-700 bg-gray-900 text-blue-600">

                        <span class="ml-2 text-sm text-gray-400">
                            Remember me
                        </span>
                    </div>

                    <!-- Login Button -->
                    <x-primary-button
                        class="w-full justify-center rounded-full bg-gray-100 text-gray-900 hover:bg-gray-200">
                        Log in
                    </x-primary-button>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm text-gray-400 hover:text-white">
                                Forgot your password?
                            </a>
                        </div>
                    @endif

                    <!-- Register -->
                    <p class="text-center text-gray-400">
                        Don't have an account?
                        <a
                            href="{{ route('register') }}"
                            class="font-semibold text-sky-500">
                            Register
                        </a>
                    </p>

                </form>

            </div>

        </div>

    </div>

</x-guest-layout>