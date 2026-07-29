@extends('layouts.twitter-shell')

@section('title', 'Notifications - Twitter Clone')

@section('content')
<div class="flex" style="width: 990px;">
    <div class="flex w-[600px] flex-none flex-col border-x border-gray-800">
        <x-sticky-page-header>
            <h1 class="text-xl font-bold text-white">
                Notifications
            </h1>

            <p class="text-sm text-gray-400">
                Recent activity on your account
            </p>
        </x-sticky-page-header>

        @if($notifications->count())
            <ul class="list-none">
                @foreach($notifications as $notification)
                    @php
                        $message = data_get($notification->content, 'message');
                        $target = data_get($notification->content, 'target');
                        $actorName = data_get($notification->content, 'actor.name');
                        $actorAvatar = data_get($notification->content, 'actor.avatar');
                    @endphp

                    <li class="border-b border-gray-800 transition hover:bg-white/5">
                        <a href="{{ $target ?? '#' }}" class="flex items-start gap-3 px-4 py-4">
                            <div class="shrink-0">
                                @if($actorAvatar)
                                    <img
                                        src="{{ asset('storage/' . $actorAvatar) }}"
                                        alt="{{ $actorName ?? 'User' }}"
                                        class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-700">
                                        <svg class="h-6 w-6 text-gray-400"
                                             fill="currentColor"
                                             viewBox="0 0 24 24">
                                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm leading-6 text-white">
                                    {{ $message }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="flex flex-1 items-center justify-center px-8 py-20 text-center">
                <div>
                    <h2 class="text-2xl font-bold text-white">
                        No notifications yet
                    </h2>

                    <p class="mt-2 text-gray-400">
                        When people interact with your account, it will appear here.
                    </p>
                </div>
            </div>
        @endif
    </div>

    @include('home.right-sidebar')
</div>
@endsection
