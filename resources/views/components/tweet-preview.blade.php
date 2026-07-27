@props([
    'tweet',
])

@php
    $avatar = $tweet->user->medias
        ->where('collection', 'avatar')
        ->first();

    $handle = $tweet->user->username
        ? '@' . ltrim($tweet->user->username, '@')
        : '@username';
@endphp

<div
    class="mt-3 block overflow-hidden rounded-2xl border border-gray-700 p-3 text-left transition hover:bg-white/[0.03]">

    <div class="flex min-w-0 items-center gap-2">

        <span class="h-5 w-5 shrink-0 overflow-hidden rounded-full bg-gray-700">

            @if($avatar)
                <img
                    src="{{ asset('storage/' . $avatar->path) }}"
                    alt="{{ $tweet->user->name }}"
                    class="h-full w-full object-cover">
            @else
                <span class="flex h-full w-full items-center justify-center text-gray-500">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>
                    </svg>
                </span>
            @endif

        </span>

        <a
            href="{{ route('tweets.show', $tweet) }}"
            class="min-w-0 truncate text-sm leading-5">

            <span class="font-bold text-white hover:underline">
                {{ $tweet->user->name }}
            </span>

            <span class="text-gray-500">
                {{ $handle }} &middot; {{ $tweet->created_at->diffForHumans() }}
            </span>

        </a>

    </div>

    @if(filled($tweet->body))
        <a
            href="{{ route('tweets.show', $tweet) }}"
            class="mt-2 block whitespace-pre-line break-words text-[15px] leading-5 text-gray-100">

            {{ $tweet->body }}

        </a>
    @endif

    <x-media-gallery
        :model="$tweet"
        :compact="true"
    />

</div>
