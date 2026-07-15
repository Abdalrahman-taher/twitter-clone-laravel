<x-app-layout>

    <div class="max-w-2xl mx-auto py-8">

        <h2 class="text-2xl font-bold text-white mb-6">
            Edit Tweet
        </h2>

        <form
            action="{{ route('tweets.update', $tweet) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div>

                <textarea
                    name="body"
                    rows="5"
                    class="w-full rounded-lg bg-gray-800 text-white border border-gray-600 p-4 focus:outline-none focus:border-blue-500">{{ old('body', $tweet->body) }}</textarea>

                @error('body')

                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>

                @enderror

            </div>

            <div class="mt-4 flex gap-3">

                <button
                    type="submit"
                    class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">

                    Update

                </button>

                <a
                    href="{{ route('home') }}"
                    class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</x-app-layout>
