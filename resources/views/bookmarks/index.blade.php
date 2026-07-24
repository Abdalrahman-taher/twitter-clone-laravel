<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bookmarks</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="p-relative min-h-screen" style="background-color: #15202b">

    <div class="flex justify-center">

        <header class="text-white h-12 py-4 h-auto">
            @include('home.left-sidebar')
        </header>

        <main role="main">

            <div class="flex" style="width: 990px;">

                <div class="flex w-[600px] flex-col border-x border-gray-800">

                    {{-- Header --}}
                    <div class="sticky top-0 z-10 border-b border-gray-800 bg-[#15202b]/90 px-4 py-4 backdrop-blur">

                        <h1 class="text-xl font-bold text-white">
                            Bookmarks
                        </h1>

                        <p class="text-sm text-gray-400">
                            Saved Tweets
                        </p>

                    </div>

                    {{-- Tweets --}}
                    @if($tweets->count())

                        <ul class="list-none">

                            @foreach($tweets as $tweet)

                                <x-tweet-card :tweet="$tweet"/>

                            @endforeach

                        </ul>

                    @else

                        <div class="py-20 text-center">

                            <h2 class="text-2xl font-bold text-white">
                                No bookmarks yet
                            </h2>

                            <p class="mt-2 text-gray-400">
                                Tweets you save will appear here.
                            </p>

                        </div>

                    @endif

                </div>

                @include('home.right-sidebar')

            </div>

        </main>

    </div>

</div>

</body>
</html>
