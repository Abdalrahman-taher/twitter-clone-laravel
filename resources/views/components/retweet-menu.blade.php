<div
    x-data="{
        open: false,
        openQuote: false
        }"

    class="relative shrink-0">

    <button
        type="button"
        @click="open = !open"
        class="inline-flex min-w-0 items-center gap-2 rounded-full pr-2 transition duration-200 hover:text-green-500 sm:min-w-[72px] {{ $retweeted ? 'text-green-500' : '' }}">

        <span
            class="inline-flex h-8 w-8 items-center justify-center rounded-full transition duration-200 hover:bg-green-500/10">

            <svg
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-5 w-5">

                <path
                    d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"/>

            </svg>

        </span>

        <span class="tabular-nums">
            {{ $tweet->retweets_count ?? 0 }}
        </span>

    </button>

    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute bottom-full mb-2 w-52 overflow-hidden rounded-2xl border border-gray-700 bg-black shadow-xl">

        <form
            action="{{ route('tweets.retweet', $tweet) }}"
            method="POST">

            @csrf

            <button
                type="submit"
                class="flex w-full px-4 py-3 text-left hover:bg-gray-900">

                🔁 Retweet

            </button>

        </form>

        <button
            type="button"
            @click="
        open = false;
        openQuote = true;

              "
            class="flex w-full px-4 py-3 text-left hover:bg-gray-900">

            💬 Quote

        </button>

    </div>

    <x-quote-retweet-modal :tweet="$tweet" />

</div>

