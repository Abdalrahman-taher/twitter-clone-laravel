<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tweet / Twitter Clone</title>

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
                                <a
                                    href="{{ url()->previous() }}"
                                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-white transition duration-200 hover:bg-gray-800"
                                    aria-label="Back">

                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                    </svg>

                                </a>

                                <div class="min-w-0">
                                    <h1 class="text-xl font-bold leading-6 text-white">
                                        Tweet
                                    </h1>

                                    <p class="truncate text-sm leading-5 text-gray-400">
                                        {{ $tweet->comments_count }} {{ \Illuminate\Support\Str::plural('reply', $tweet->comments_count) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <ul class="list-none">
                            <x-tweet-card
                                :tweet="$tweet"
                                :show-comments="true"
                            />
                        </ul>

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
