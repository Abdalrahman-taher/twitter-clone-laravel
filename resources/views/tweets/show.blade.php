@extends('layouts.twitter-shell')

@section('title', 'Tweet / Twitter Clone')

@section('content')
    <div class="flex" style="width: 990px;">
        <div class="min-h-screen w-[600px] flex-none border-x border-gray-800">
            <x-sticky-page-header>
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
            </x-sticky-page-header>

            <ul class="list-none">
                <x-tweet-card
                    :tweet="$tweet"
                    :show-comments="true"
                />
            </ul>
        </div>

        @include('home.right-sidebar')
    </div>
@endsection
