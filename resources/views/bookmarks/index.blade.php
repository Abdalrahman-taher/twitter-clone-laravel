@extends('layouts.twitter-shell')

@section('title', 'Bookmarks')

@section('content')
    <div class="flex" style="width: 990px;">
        <div class="flex w-[600px] flex-col border-x border-gray-800">
            <x-sticky-page-header>
                <h1 class="text-xl font-bold text-white">
                    Bookmarks
                </h1>

                <p class="text-sm text-gray-400">
                    Saved Tweets
                </p>
            </x-sticky-page-header>

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
@endsection
