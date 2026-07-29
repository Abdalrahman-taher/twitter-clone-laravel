@props([
    'tweet',
])

@php
    $handle = $tweet->user->username
        ? '@' . ltrim($tweet->user->username, '@')
        : '@username';
@endphp

<div
    class="mt-3 block overflow-hidden rounded-2xl border border-gray-700 p-3 text-left transition hover:bg-white/[0.03]">

    <div class="flex min-w-0 items-center gap-2">

        <x-user-avatar
            :user="$tweet->user"
            class="h-5 w-5 shrink-0 overflow-hidden rounded-full bg-gray-700"
        />

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
