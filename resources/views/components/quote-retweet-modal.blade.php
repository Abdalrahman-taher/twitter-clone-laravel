<div
    x-show="openQuote"
    x-transition.opacity
    x-cloak
    class="fixed inset-0 z-50 flex items-start justify-center bg-black/70 px-4 py-10 sm:items-center">

    <div
        x-show="openQuote"
        x-transition.scale.origin.top
        @click.outside="openQuote = false"
        class="w-full max-w-xl overflow-hidden rounded-2xl border border-gray-700 bg-black text-white shadow-2xl">

        <form
            action="{{ route('tweets.quote', $tweet) }}"
            method="POST">

            @csrf

            <div class="flex items-center justify-between px-4 py-3">

                <button
                    type="button"
                    @click="openQuote = false"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full text-white transition hover:bg-white/10"
                    aria-label="Close quote modal">

                    <span class="text-xl leading-none">&times;</span>

                </button>

                <h2 class="text-base font-bold">
                    Quote
                </h2>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-white px-5 py-1.5 text-sm font-bold text-black transition hover:bg-gray-200">

                    Post

                </button>

            </div>

            <div class="px-4 pb-4">

                <textarea
                    name="body"
                    rows="5"
                    maxlength="280"
                    placeholder="Add a comment"
                    class="block w-full resize-none border-0 bg-transparent px-0 py-3 text-xl leading-6 text-white placeholder-gray-500 focus:border-0 focus:outline-none focus:ring-0"></textarea>

                @error('body')
                    <p class="mb-3 text-sm text-red-400">
                        {{ $message }}
                    </p>
                @enderror

                <x-tweet-preview :tweet="$tweet" />

            </div>

        </form>

    </div>

</div>
