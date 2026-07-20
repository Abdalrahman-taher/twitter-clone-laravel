@props(['retweet'])

@php
    $retweeterHandle = $retweet->user->username
        ? '@' . ltrim($retweet->user->username, '@')
        : '@username';

    $retweeterAvatar = $retweet->user->medias
        ->where('collection', 'avatar')
        ->first();
@endphp

<li class="border-b border-gray-800 px-4 py-3">
    <article class="space-y-2.5">
        <a
            href="{{ route('profile.show', $retweet->user) }}"
            class="inline-flex max-w-full items-start gap-2 text-sm text-gray-500 transition duration-200 hover:text-gray-300">

            <span class="mt-1 shrink-0 text-sm leading-none" aria-hidden="true">&#128257;</span>

            <span class="h-8 w-8 shrink-0 overflow-hidden rounded-full">
                @if($retweeterAvatar)
                    <img
                        class="h-full w-full object-cover"
                        src="{{ asset('storage/' . $retweeterAvatar->path) }}"
                        alt="{{ $retweet->user->name }}">
                @else
                    <svg
                        class="h-full w-full bg-gray-700 text-gray-500"
                        fill="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.3 0-9.8 1.6-9.8 4.9v2.5h19.6v-2.5c0-3.3-6.5-4.9-9.8-4.9z"/>

                    </svg>
                @endif
            </span>

            <span class="min-w-0 leading-tight">
                <span class="block truncate font-semibold text-gray-300">{{ $retweet->user->name }}</span>
                <span class="block truncate">{{ $retweeterHandle }} Retweeted</span>
            </span>
        </a>

        <x-tweet-card :tweet="$retweet->tweet" :nested="true" />
    </article>
</li>
