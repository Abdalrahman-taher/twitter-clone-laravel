<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $user->name }} - Twitter Clone</title>

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
                <div class="flex flex-col w-full border-x border-gray-800">
                    <div class="flex min-h-screen w-full flex-col text-white">
                        <div class="border-b border-gray-800 px-4 py-3">
                            <div class="flex items-center gap-4">
                                <a href="{{ url()->previous() }}"
                                   class="rounded-full p-2 text-blue-400 hover:bg-gray-800 hover:text-blue-300">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path>
                                    </svg>
                                </a>

                                <div>
                                    <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                                    <p class="text-sm text-gray-400">{{ $tweets->count() }} Tweets</p>
                                </div>
                            </div>
                        </div>

                        {{-- ========================================================= --}}
                        {{-- User Cover Image                                          --}}
                        {{-- Get cover image from media collection instead of users   --}}
                        {{-- ========================================================= --}}

                        @php
                            // Get the latest cover file from user's media collection
                            $cover = $user->medias
                                ->where('collection', 'cover')
                                ->first();
                        @endphp


                        <div class="h-52 w-full bg-gray-800 bg-center bg-cover"

                             @if($cover)

                                 {{-- Display cover image from media table --}}
                                 style="background-image: url('{{ asset('storage/' . $cover->path) }}');"

                            @endif>

                        </div>

                        <div class="border-b border-gray-800 px-4 pb-4">
                            <div class="-mt-16 flex items-end justify-between gap-4">
                                <div
                                    class="h-32 w-32 overflow-hidden rounded-full border-4 border-[#15202b] bg-gray-700">


                                    {{-- ========================================================= --}}
                                    {{-- User Avatar Image                                         --}}
                                    {{-- Get avatar image from media collection instead of users --}}
                                    {{-- ========================================================= --}}

                                    @php
                                        // Get the latest avatar file from user's media collection
                                        $avatar = $user->medias
                                            ->where('collection', 'avatar')
                                            ->first();
                                    @endphp

                                    @if($avatar)

                                        {{-- Display avatar image from media table --}}
                                        <img
                                            src="{{ asset('storage/' . $avatar->path) }}"
                                            alt="{{ $user->name }}"
                                            class="h-full w-full object-cover">

                                    @else

                                        {{-- Default avatar when user has no image --}}
                                        <div
                                            class="flex h-full w-full items-center justify-center bg-gray-700 text-gray-400">

                                            <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24">

                                                <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"></path>

                                            </svg>

                                        </div>

                                    @endif


                                </div>
                                {{-- ===================================================== --}}
                                {{-- Profile Action Button                                 --}}
                                {{-- Show Edit button for owner                             --}}
                                {{-- Show Follow / Unfollow for other users                 --}}
                                {{-- ===================================================== --}}

                                @if(auth()->id() === $user->id)

                                    <a href="{{ route('profile.edit') }}"
                                       class="mt-4 rounded-full border border-blue-400 px-4 py-2 text-sm font-bold text-blue-400 hover:bg-blue-400 hover:text-white">
                                        Edit Profile
                                    </a>

                                @elseif($isFollowing)

                                    <form method="POST" action="{{ route('users.unfollow', $user) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="mt-4 rounded-full bg-white px-5 py-2 text-sm font-bold text-black hover:bg-gray-200">
                                            Unfollow
                                        </button>
                                    </form>

                                @else

                                    <form method="POST" action="{{ route('users.follow', $user) }}">
                                        @csrf

                                        <button
                                            class="mt-4 rounded-full bg-blue-500 px-5 py-2 text-sm font-bold text-white hover:bg-blue-600">
                                            Follow
                                        </button>
                                    </form>

                                @endif
                            </div>

                            <div class="mt-3 space-y-3">
                                <div>
                                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                                    <p class="text-sm text-gray-400">{{ $user->username }}</p>
                                </div>

                                @if($user->bio)
                                    <p class="text-white">{{ $user->bio }}</p>
                                @endif

                                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm text-gray-400">
                                    @if($user->location)
                                        <div class="flex items-center gap-1">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C8.14 2 5 5.14 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.86-3.14-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"></path>
                                            </svg>
                                            <span>{{ $user->location }}</span>
                                        </div>
                                    @endif

                                    @if($user->website)
                                        <div class="flex items-center gap-1">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M11.96 14.945c-.067 0-.136-.01-.203-.027-1.13-.318-2.097-.986-2.795-1.932-.832-1.125-1.176-2.508-.968-3.893s.942-2.605 2.068-3.438l3.53-2.608c2.322-1.716 5.61-1.224 7.33 1.1.83 1.127 1.175 2.51.967 3.895s-.943 2.605-2.07 3.438l-1.48 1.094c-.333.246-.804.175-1.05-.158-.246-.334-.176-.804.158-1.05l1.48-1.095c.803-.592 1.327-1.463 1.476-2.45.148-.988-.098-1.975-.69-2.778-1.225-1.656-3.572-2.01-5.23-.784l-3.53 2.608c-.802.593-1.326 1.464-1.475 2.45-.15.99.097 1.975.69 2.778.498.675 1.187 1.15 1.992 1.377.4.114.633.528.52.928-.092.33-.394.547-.722.547z"></path>
                                                <path
                                                    d="M7.27 22.054c-1.61 0-3.197-.735-4.225-2.125-.832-1.127-1.176-2.51-.968-3.894s.943-2.605 2.07-3.438l1.478-1.094c.334-.245.805-.175 1.05.158s.177.804-.157 1.05l-1.48 1.095c-.803.593-1.326 1.464-1.475 2.45-.148.99.097 1.975.69 2.778 1.225 1.657 3.57 2.01 5.23.785l3.528-2.608c1.658-1.225 2.01-3.57.785-5.23-.498-.674-1.187-1.15-1.992-1.376-.4-.113-.633-.527-.52-.927.112-.4.528-.63.926-.522 1.13.318 2.096.986 2.794 1.932 1.717 2.324 1.224 5.612-1.1 7.33l-3.53 2.608c-.933.693-2.023 1.026-3.105 1.026z"></path>
                                            </svg>
                                            <a href="{{ $user->website }}" target="_blank"
                                               class="text-blue-400 hover:underline">{{ $user->website }}</a>
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-1">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292c-.437 0-.792-.355-.792-.792V6.418c0-.437.354-.79.79-.792h15.42c.436 0 .79.355.79.79V19.71z"></path>
                                            <circle cx="7.032" cy="8.75" r="1.285"></circle>
                                            <circle cx="7.032" cy="13.156" r="1.285"></circle>
                                            <circle cx="16.968" cy="8.75" r="1.285"></circle>
                                            <circle cx="16.968" cy="13.156" r="1.285"></circle>
                                            <circle cx="12" cy="8.75" r="1.285"></circle>
                                            <circle cx="12" cy="13.156" r="1.285"></circle>
                                            <circle cx="7.032" cy="17.486" r="1.285"></circle>
                                            <circle cx="12" cy="17.486" r="1.285"></circle>
                                        </svg>
                                        <span>Joined {{ $user->created_at->format('F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===================================================== --}}
                        {{-- Followers / Following Counts                          --}}
                        {{-- Display profile follow statistics                      --}}
                        {{-- ===================================================== --}}

                        <div class="mt-4 flex items-center gap-6 text-sm">


                            <a href="{{ route('profile.following', $user) }}"
                               class="hover:underline">

                                <span class="font-bold text-white">
                                    {{ $user->following_count }}
                                </span>

                                <span class="text-gray-400">
                                    Following
                                </span>
                            </a>


                            <a href="{{ route('profile.followers', $user) }}"
                               class="hover:underline">

                                <span class="font-bold text-white">
                                   {{ $user->followers_count }}
                                 </span>

                                <span class="text-gray-400">
                                      Followers
                                </span>

                            </a>

                        </div>

                        <div class="grid grid-cols-4 border-b border-gray-800 text-sm font-semibold">

                            <a href="{{ route('profile.show', [$user, 'tab' => 'posts']) }}"
                               class="py-4 text-center transition
                                 {{ $tab == 'posts' ? 'border-b-4 border-blue-400 text-white' : 'text-gray-400 hover:bg-gray-800' }}">
                                Posts
                            </a>

                            <a href="{{ route('profile.show', [$user, 'tab' => 'replies']) }}"
                               class="py-4 text-center transition
                              {{ $tab == 'replies' ? 'border-b-4 border-blue-400 text-white' : 'text-gray-400 hover:bg-gray-800' }}">

                                Replies

                            </a>

                            <a href="{{ route('profile.show', [$user, 'tab' => 'media']) }}"
                               class="py-4 text-center transition
                                {{ $tab == 'media' ? 'border-b-4 border-blue-400 text-white' : 'text-gray-400 hover:bg-gray-800' }}">

                                Media

                            </a>

                            <a href="{{ route('profile.show', [$user, 'tab' => 'likes']) }}"
                               class="py-4 text-center transition
                                {{ $tab == 'likes' ? 'border-b-4 border-blue-400 text-white' : 'text-gray-400 hover:bg-gray-800' }}">

                                Likes

                            </a>
                        </div>

                        <div>


                            @if($tweets->count())

                                <ul class="list-none">

                                    @foreach($tweets as $tweet)

                                        <x-tweet-card :tweet="$tweet"/>

                                    @endforeach

                                </ul>

                            @else

                                <div class="px-4 py-10 text-center text-gray-400">

                                    No {{ $tab }} yet.

                                </div>

                            @endif

                        </div>
                    </div>
                </div>

                @include('home.right-sidebar')
            </div>
        </main>
    </div>
</div>

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
</body>
</html>
