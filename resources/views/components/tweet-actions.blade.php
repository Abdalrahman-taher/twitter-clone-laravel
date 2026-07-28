@props([
    'tweet',
    'showBookmark' => true,
    'showShare' => true,
    'withBorder' => true,
    'borderClass' => 'border-gray-800',
])

@php
    $tweet->loadMissing(['likes']);

    if ($showBookmark) {
        $tweet->loadMissing(['bookmarks']);
    }

    if (! array_key_exists('likes_count', $tweet->getAttributes())) {
        $tweet->loadCount('likes');
    }

    if (! array_key_exists('comments_count', $tweet->getAttributes())) {
        $tweet->loadCount('comments');
    }

    if (
        ! array_key_exists('retweets_count', $tweet->getAttributes()) ||
        ! array_key_exists('quote_tweets_count', $tweet->getAttributes())
    ) {
        $tweet->loadCount([
            'retweets',
            'quotedBy as quote_tweets_count',
        ]);
    }

    $liked = $tweet->isLikedBy(auth()->user());
    $retweeted = $tweet->isRetweetedBy(auth()->user());
    $bookmarked = $showBookmark ? $tweet->isBookmarkedBy(auth()->user()) : false;
    $actionsClass = 'mt-3 flex items-center justify-between text-sm text-gray-500';
    $actionsClass .= $withBorder ? ' border-y ' . $borderClass . ' py-2' : ' py-0';
@endphp

{{-- Tweet Actions --}}
<div {{ $attributes->merge(['class' => $actionsClass]) }}>

    {{-- Comment --}}
    <a
        href="{{ route('tweets.show', $tweet) }}"
        class="inline-flex min-w-0 shrink-0 items-center gap-2 rounded-full pr-2 transition duration-200 hover:text-blue-400 sm:min-w-[72px]">

        <span
            class="inline-flex h-8 w-8 items-center justify-center rounded-full transition duration-200 hover:bg-blue-500/10">

            <svg
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-5 w-5">

                <path
                    d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.043-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788z"/>

            </svg>

        </span>

        <span class="tabular-nums">
            {{ $tweet->comments_count }}
        </span>

    </a>

    {{-- Retweet --}}
    <x-retweet-menu
        :tweet="$tweet"
        :retweeted="$retweeted"
    />

    {{-- Like --}}
    <form
        action="{{ route('tweets.like', $tweet) }}"
        method="POST"
        class="shrink-0">

        @csrf

        <button
            type="submit"
            class="inline-flex min-w-0 items-center gap-2 rounded-full pr-2 transition duration-200 hover:text-red-500 sm:min-w-[72px] {{ $liked ? 'text-red-500' : '' }}">

            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-full transition duration-200 hover:bg-red-500/10">

                <svg
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="h-5 w-5">

                    <path
                        d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"/>

                </svg>

            </span>

            <span class="tabular-nums">{{ $tweet->likes_count }}</span>

        </button>

    </form>

    @if($showBookmark)

        {{-- Bookmark --}}
        <form
            action="{{ route('tweets.bookmark', $tweet) }}"
            method="POST"
            class="shrink-0">

            @csrf

            <button
                type="submit"
                class="inline-flex min-w-0 items-center gap-2 rounded-full pr-2 transition duration-200 hover:text-blue-500 sm:min-w-[72px] {{ $bookmarked ? 'text-blue-500' : '' }}">

                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full transition duration-200 hover:bg-blue-500/10">

                    <svg
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-5 w-5">

                        <path d="M6 3c-1.1 0-2 .9-2 2v16l8-5.5 8 5.5V5c0-1.1-.9-2-2-2H6z"/>

                    </svg>

                </span>

            </button>

        </form>

    @endif

    @if($showShare)

        {{-- Share --}}
        <div
            class="relative shrink-0"
            x-data="tweetShare(@js($tweet->body), @js(url()->current() . '#tweet-' . $tweet->id))">

            <button
                type="button"
                class="inline-flex min-w-0 items-center gap-2 rounded-full pr-2 transition duration-200 hover:text-blue-400 sm:min-w-[72px]"
                x-on:click="share()">

                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full transition duration-200 hover:bg-blue-500/10">

                    <svg
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-5 w-5">

                        <path
                            d="M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06s.767.294 1.06 0l3.72-3.72V15c0 .414.336.75.75.75s.75-.336.75-.75V4.81l3.72 3.72c.146.147.338.22.53.22s.384-.072.53-.22c.293-.293.293-.767 0-1.06z"/>

                    </svg>

                </span>

            </button>

            <span
                x-cloak
                x-show="copied"
                x-transition
                class="absolute bottom-full right-0 mb-2 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-900 shadow-lg">

                Copied

            </span>

        </div>

    @endif

</div>
