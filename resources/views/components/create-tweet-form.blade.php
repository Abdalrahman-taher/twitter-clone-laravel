{{-- ========================================================= --}}
{{-- Anonymous Blade Component                                 --}}
{{-- This component renders the Create Tweet form.             --}}
{{--                                                           --}}
{{-- I extracted it into its own component because it is      --}}
{{-- reused as a standalone UI section and keeps the feed      --}}
{{-- view clean and easier to maintain.                        --}}
{{-- ========================================================= --}}



<form method="POST"
      action="{{ route('tweets.store') }}"
      enctype="multipart/form-data"
      class="border-b border-gray-800 px-4 py-3"
      x-data="mediaComposer('images', 'videos')"
      x-on:change="syncMedia($event)">

    {{-- CSRF protection (Required for every POST form) --}}
    @csrf

    {{-- ========================================= --}}
    {{-- User Avatar + Tweet Input --}}
    {{-- ========================================= --}}
    <div class="flex gap-3">

        {{-- User Profile Image --}}
        <div class="w-10 shrink-0 py-1">

            {{-- ========================================================= --}}
            {{-- Current User Avatar --}}
            {{-- Avatar comes from User Media collection --}}
            {{-- ========================================================= --}}

            @php
                $avatar = auth()->user()->medias
                    ->where('collection', 'avatar')
                    ->first();
            @endphp


            @if($avatar)

                <img
                    class="inline-block h-10 w-10 rounded-full object-cover"
                    src="{{ asset('storage/' . $avatar->path) }}"
                    alt="{{ auth()->user()->name }}">

            @else

                <img
                    class="inline-block h-10 w-10 rounded-full"
                    src="https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png"
                    alt="Default Avatar">

            @endif
        </div>

        {{-- Tweet Text Area --}}
        <div class="min-w-0 flex-1 pt-1">

                <textarea
                    name="body"
                    class="w-full resize-none border-0 bg-transparent p-0 text-xl font-medium text-gray-100 placeholder-gray-500 focus:border-0 focus:ring-0"
                    rows="2"
                    cols="50"
                    placeholder="What's happening?">{{ old('body') }}</textarea>

            <div
                x-cloak
                x-show="previews.length"
                class="mt-3 grid overflow-hidden rounded-2xl border border-gray-700 bg-gray-900 gap-0.5"
                x-bind:class="previews.length === 1 ? 'grid-cols-1' : 'grid-cols-2'">

                <template x-for="(preview, index) in previews" :key="preview.id">
                    <div
                        class="group relative min-h-0 overflow-hidden bg-gray-800"
                        x-bind:class="previews.length === 1 ? 'aspect-[16/10]' : (previews.length === 3 && index === 0 ? 'row-span-2 aspect-auto' : 'aspect-square')">

                        <template x-if="preview.type === 'image'">
                            <img
                                x-bind:src="preview.url"
                                alt="Selected media preview"
                                class="h-full w-full object-cover">
                        </template>

                        <template x-if="preview.type === 'video'">
                            <video
                                x-bind:src="preview.url"
                                class="h-full w-full object-cover"
                                muted
                                playsinline
                                controls>
                            </video>
                        </template>

                        <button
                            type="button"
                            class="absolute right-2 top-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-black/70 text-xl leading-none text-white transition duration-200 hover:bg-black"
                            aria-label="Remove selected media"
                            x-on:click="removeMedia(preview)">

                            &times;

                        </button>

                    </div>
                </template>

            </div>

        </div>

    </div>

    {{-- ========================================= --}}
    {{-- Tweet Action Buttons --}}
    {{-- ========================================= --}}
    <div class="mt-2 flex items-center gap-3">

        <div class="w-10 shrink-0"></div>

        <div class="flex min-w-0 flex-1 items-center justify-between border-t border-gray-800 pt-2">

            <div class="flex items-center">

                <x-media-picker
                    imageInput="images"
                    videoInput="videos"
                />

            </div>

        {{-- ========================================= --}}
        {{-- Submit Tweet Button --}}
        {{-- ========================================= --}}
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-full bg-blue-500 px-6 py-2 text-sm font-bold text-white transition duration-200 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">

                Tweet

            </button>

        </div>

    </div>

</form>
