<!-- Left Sidebar -->

<div style="width: 275px;">
    <div class="overflow-y-auto fixed h-screen pr-3" style="width: 275px;">
        <!-- Logo -->
        <svg viewBox="0 0 24 24" class="h-8 w-8 text-white ml-3" fill="currentColor">
            <g>
                <path
                    d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path>
            </g>
        </svg>

        <!-- Navigation -->
        <nav class="mt-5 px-2">
            <a href="{{ route('home') }}"
               class="group flex items-center px-2 py-2 text-base leading-6 font-semibold rounded-full bg-gray-800 text-blue-300">
                <svg class="mr-4 h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"></path>
                </svg>
                Home
            </a>
            <a href="#"
               class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-semibold rounded-full hover:bg-gray-800 hover:text-blue-300">
                <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                </svg>
                Explore
            </a>
            <a href="{{ route('notifications.index') }}"
               class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-gray-800 hover:text-blue-300">
                <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                Notifications
            </a>
            <a href="#"
               class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-gray-800 hover:text-blue-300">
                <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Messages
            </a>
            <a href="#"
               class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-gray-800 hover:text-blue-300">
                <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
                Bookmarks
            </a>
            <a href="#"
               class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-gray-800 hover:text-blue-300">
                <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Lists
            </a>
            <a href="{{ route('profile.show', auth()->user()) }}"
               class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-gray-800 hover:text-blue-300">
                <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profile
            </a>
            <div x-data="{ moreOpen: false }" class="relative mt-1">
                <button
                    type="button"
                    class="group flex w-full items-center rounded-full px-2 py-2 text-left text-base font-medium leading-6 hover:bg-gray-800 hover:text-blue-300"
                    x-on:click="moreOpen = ! moreOpen"
                    x-on:click.outside="moreOpen = false">

                    <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    More
                </button>

                <div
                    x-cloak
                    x-show="moreOpen"
                    x-transition.origin.bottom.left
                    class="absolute bottom-full left-2 z-30 mb-2 w-56 overflow-hidden rounded-xl border border-gray-700 bg-gray-900 py-1 text-sm text-white shadow-xl">

                    <form
                        method="POST"
                        action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="block w-full px-4 py-3 text-left font-semibold text-red-400 transition duration-200 hover:bg-gray-800">

                            Logout

                        </button>

                    </form>
                </div>
            </div>

            <!-- Tweet Button -->
            <button class="bg-blue-400 hover:bg-blue-500 w-full mt-5 text-white font-bold py-2 px-4 rounded-full">
                Tweet
            </button>
        </nav>

        <!-- User -->
        <!-- Current User -->

        <div class="absolute bottom-8 w-full">

            <div class="flex-shrink-0 flex hover:bg-gray-800 rounded-full px-4 py-3 mr-2">

                <a href="{{ route('profile.show', auth()->user()) }}"
                   class="flex-shrink-0 group block">

                    <div class="flex items-center">

                        <div>

                            {{-- ========================================================= --}}
                            {{-- Current User Avatar                                      --}}
                            {{-- Avatar comes from User Media collection                  --}}
                            {{-- ========================================================= --}}

                            @php
                                $avatar = auth()->user()->medias
                                    ->where('collection', 'avatar')
                                    ->first();
                            @endphp


                            @if($avatar)

                                <img
                                    src="{{ asset('storage/' . $avatar->path) }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="inline-block h-10 w-10 rounded-full object-cover">

                            @else

                                <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">

                                    <svg class="h-6 w-6 text-gray-400"
                                         fill="currentColor"
                                         viewBox="0 0 24 24">

                                        <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>

                                    </svg>

                                </div>

                            @endif

                        </div>


                        <div class="ml-3">

                            <p class="text-base leading-6 font-medium text-white">
                                {{ auth()->user()->name }}
                            </p>


                            <p class="text-sm leading-5 font-medium text-gray-400 group-hover:text-gray-300">

                                @if(auth()->user()->username)

                                    {{ '@' . auth()->user()->username }}

                                @else

                                    {{ '@username' }}

                                @endif

                            </p>

                        </div>


                    </div>

                </a>

            </div>

        </div>
    </div>
</div>
