<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Search / Twitter Clone</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen" style="background-color: #15202b">
        <div class="flex justify-center">

            <header class="text-white h-12 py-4 h-auto">
                @include('home.left-sidebar')
            </header>

            <main role="main">
                <div class="flex" style="width: 990px;">
                    <div class="min-h-screen w-[600px] flex-none border-x border-gray-800">

                {{-- Header --}}
                <div class="sticky top-0 z-20 border-b border-gray-800 bg-[#15202b]/90 px-4 py-3 backdrop-blur">
                    <div class="flex items-center gap-3">
                        <svg viewBox="0 0 24 24" class="h-7 w-7 shrink-0 text-white md:hidden" fill="currentColor">
                            <path
                                d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"/>
                        </svg>

                        <div class="min-w-0">
                            <h1 class="text-xl font-bold leading-6 text-white">
                                Search
                            </h1>

                            @if($query)
                                <p class="truncate text-sm leading-5 text-gray-400">
                                    Results for "{{ $query }}"
                                </p>
                            @else
                                <p class="truncate text-sm leading-5 text-gray-400">
                                    Find people and tweets
                                </p>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('search.index') }}" method="GET" class="mt-3">
                        <label for="search-page-query" class="sr-only">Search</label>

                        <div class="relative">
                            <button
                                type="submit"
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 transition duration-200 hover:text-blue-300"
                                aria-label="Search">

                                <svg class="h-4 w-4 fill-current" viewBox="0 0 56.966 56.966">
                                    <path
                                        d="M55.146 51.887 41.588 37.786C45.074 33.642 46.984 28.428 46.984 23c0-12.682-10.318-23-23-23s-23 10.318-23 23 10.318 23 23 23c4.761 0 9.298-1.436 13.177-4.162l13.661 14.208c.571.593 1.339.92 2.162.92.779 0 1.518-.297 2.079-.837 1.192-1.147 1.23-3.049.083-4.242zM23.984 6c9.374 0 17 7.626 17 17s-7.626 17-17 17-17-7.626-17-17 7.626-17 17-17z"/>
                                </svg>

                            </button>

                            <input
                                id="search-page-query"
                                type="search"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Search Twitter"
                                class="bg-dim-700 h-11 w-full rounded-full border-0 px-11 text-sm text-white placeholder-gray-500 focus:border-blue-400 focus:ring-blue-400">
                        </div>
                    </form>
                </div>

                @if($users->isEmpty() && $tweets->isEmpty())

                    {{-- Empty State --}}
                    <div class="px-8 py-20 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-dim-700 text-gray-400">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10.5 3a7.5 7.5 0 0 1 5.94 12.08l4.24 4.24a.96.96 0 0 1-1.36 1.36l-4.24-4.24A7.5 7.5 0 1 1 10.5 3zm0 1.9a5.6 5.6 0 1 0 0 11.2 5.6 5.6 0 0 0 0-11.2z"/>
                            </svg>
                        </div>

                        <h2 class="mt-5 text-xl font-bold text-white">
                            No results found
                        </h2>

                        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-400">
                            Try searching for another name, username, or tweet.
                        </p>
                    </div>

                @else

                    {{-- People Results --}}
                    <section class="border-b border-gray-800">
                        <div class="flex items-center justify-between px-4 py-3">
                            <h2 class="text-lg font-bold text-white">
                                People
                            </h2>

                            <span class="text-xs font-medium text-gray-500">
                                {{ $users->count() }} {{ \Illuminate\Support\Str::plural('result', $users->count()) }}
                            </span>
                        </div>

                        @if($users->isNotEmpty())
                            <div class="divide-y divide-gray-800">
                                @foreach($users as $user)

                                    @php
                                        $avatar = $user->medias
                                            ->where('collection', 'avatar')
                                            ->first();

                                        $userHandle = $user->username
                                            ? '@' . ltrim($user->username, '@')
                                            : '@username';
                                    @endphp

                                    <a href="{{ route('profile.show', $user) }}"
                                       class="flex gap-3 px-4 py-3 transition duration-200 hover:bg-gray-800/70">

                                        @if($avatar)

                                            <img
                                                src="{{ asset('storage/' . $avatar->path) }}"
                                                class="h-11 w-11 shrink-0 rounded-full object-cover"
                                                alt="{{ $user->name }}">

                                        @else

                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gray-700 text-gray-400">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zM4 22a8 8 0 1 1 16 0H4z"/>
                                                </svg>
                                            </div>

                                        @endif

                                        <div class="min-w-0 flex-1">
                                            <div class="flex min-w-0 flex-wrap items-baseline gap-x-1.5">
                                                <h3 class="truncate text-sm font-bold text-white">
                                                    {{ $user->name }}
                                                </h3>

                                                <p class="truncate text-sm text-gray-500">
                                                    {{ $userHandle }}
                                                </p>
                                            </div>

                                            @if($user->bio)
                                                <p class="mt-1 truncate text-sm leading-5 text-gray-300">
                                                    {{ $user->bio }}
                                                </p>
                                            @endif
                                        </div>

                                    </a>

                                @endforeach
                            </div>
                        @else
                            <div class="px-4 pb-5 text-sm text-gray-500">
                                No people matched your search.
                            </div>
                        @endif
                    </section>

                    {{-- Tweet Results --}}
                    <section>
                        <div class="flex items-center justify-between px-4 py-3">
                            <h2 class="text-lg font-bold text-white">
                                Tweets
                            </h2>

                            <span class="text-xs font-medium text-gray-500">
                                {{ $tweets->count() }} {{ \Illuminate\Support\Str::plural('result', $tweets->count()) }}
                            </span>
                        </div>

                        @if($tweets->isNotEmpty())
                            <ul class="list-none">
                                @foreach($tweets as $tweet)
                                    <x-tweet-card
                                        :tweet="$tweet"
                                        compact
                                    />
                                @endforeach
                            </ul>
                        @else
                            <div class="px-4 pb-5 text-sm text-gray-500">
                                No tweets matched your search.
                            </div>
                        @endif
                    </section>

                @endif

                    </div>

                    @include('home.right-sidebar')
                </div>
            </main>

        </div>
    </div>
</body>

<style>
.overflow-y-auto::-webkit-scrollbar, .overflow-y-scroll::-webkit-scrollbar, .overflow-x-auto::-webkit-scrollbar, .overflow-x::-webkit-scrollbar, .overflow-x-scroll::-webkit-scrollbar, .overflow-y::-webkit-scrollbar, body::-webkit-scrollbar {
  display: none;
}

.overflow-y-auto, .overflow-y-scroll, .overflow-x-auto, .overflow-x, .overflow-x-scroll, .overflow-y, body {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.bg-dim-700 {
  --bg-opacity: 1;
  background-color: #192734;
}

html, body {
  margin: 0;
  background-color: #15202b;
}

svg.paint-icon {
  fill: currentcolor;
}
</style>
