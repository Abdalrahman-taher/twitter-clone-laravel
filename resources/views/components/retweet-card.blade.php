@props(['retweet'])

@php
    $retweeterHandle = $retweet->user->username
        ? '@' . ltrim($retweet->user->username, '@')
        : '@username';
@endphp

<li class="border-b border-gray-800 px-4 py-3">
    <article class="space-y-2.5">
        <a
            href="{{ route('profile.show', $retweet->user) }}"
            class="inline-flex max-w-full items-start gap-2 text-sm text-gray-500 transition duration-200 hover:text-gray-300">

            <span class="mt-1 shrink-0 text-sm leading-none" aria-hidden="true">&#128257;</span>

            <x-user-avatar
                :user="$retweet->user"
                class="h-8 w-8 shrink-0 overflow-hidden rounded-full"
            />

            <span class="min-w-0 leading-tight">
                <span class="block truncate font-semibold text-gray-300">{{ $retweet->user->name }}</span>
                <span class="block truncate">{{ $retweeterHandle }} Retweeted</span>
            </span>
        </a>

        <x-tweet-card :tweet="$retweet->tweet" :nested="true" />
    </article>
</li>
