<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ $profileUser->name }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="p-relative min-h-screen" style="background-color:#15202b">

    <div class="flex justify-center">

        <header class="text-white h-12 py-4 h-auto">
            @include('home.left-sidebar')
        </header>

        <main role="main">

            <div class="flex" style="width:990px;">

                <div class="flex w-full flex-col border-x border-gray-800">

                    {{-- Header --}}
                    <div class="border-b border-gray-800 px-4 py-3">

                        <div class="flex items-center gap-4">

                            <a href="{{ route('profile.show',$profileUser) }}"
                               class="rounded-full p-2 text-blue-400 hover:bg-gray-800">

                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6a1 1 0 000 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293a.999.999 0 000-1.414L7.414 13H20a1 1 0 100-2z"/>
                                </svg>

                            </a>

                            <div>

                                <h1 class="text-xl font-bold text-white">
                                    {{ $title }}
                                </h1>

                                <p class="text-sm text-gray-400">
                                    {{ $profileUser->name }}
                                </p>

                            </div>

                        </div>

                    </div>


                    @forelse($users as $user)

                        @php
                            $avatar = $user->medias
                                ->where('collection','avatar')
                                ->first();
                        @endphp

                        <div class="flex items-center justify-between border-b border-gray-800 p-4 hover:bg-gray-800 transition">

                            <a href="{{ route('profile.show',$user) }}"
                               class="flex items-center gap-3 flex-1">

                                @if($avatar)

                                    <img
                                        src="{{ asset('storage/'.$avatar->path) }}"
                                        class="h-12 w-12 rounded-full object-cover">

                                @else

                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-700">

                                        <svg class="h-7 w-7 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>
                                        </svg>

                                    </div>

                                @endif

                                <div>

                                    <h3 class="font-semibold text-white">
                                        {{ $user->name }}
                                    </h3>

                                    <p class="text-sm text-gray-400">
                                        {{ $user->username }}
                                    </p>

                                </div>

                            </a>


                            @if(auth()->id() !== $user->id)

                                @if(auth()->user()->isFollowing($user))

                                    <form method="POST"
                                          action="{{ route('users.unfollow',$user) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="rounded-full bg-white px-5 py-2 text-sm font-bold text-black hover:bg-gray-200">

                                            Unfollow

                                        </button>

                                    </form>

                                @else

                                    <form method="POST"
                                          action="{{ route('users.follow',$user) }}">

                                        @csrf

                                        <button
                                            class="rounded-full bg-blue-500 px-5 py-2 text-sm font-bold text-white hover:bg-blue-600">

                                            Follow

                                        </button>

                                    </form>

                                @endif

                            @endif

                        </div>

                    @empty

                        <div class="py-12 text-center text-gray-400">

                            No {{ strtolower($title) }} yet.

                        </div>

                    @endforelse

                </div>

                @include('home.right-sidebar')

            </div>

        </main>

    </div>

</div>

</body>

</html>
