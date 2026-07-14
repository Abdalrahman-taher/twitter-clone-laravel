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
      enctype="multipart/form-data">

    {{-- CSRF protection (Required for every POST form) --}}
    @csrf


    {{-- ========================================================= --}}
    {{-- Hidden File Inputs                                        --}}
    {{-- Clicking the image/video icons will open them instead.    --}}
    {{-- Multiple files can now be selected.                       --}}
    {{-- ========================================================= --}}

    <input
        type="file"
        id="imageInput"
        name="images[]"
        accept="image/*"
        multiple
        class="hidden">

    <input
        type="file"
        id="videoInput"
        name="videos[]"
        accept="video/*"
        multiple
        class="hidden">
    {{-- ========================================= --}}
    {{-- User Avatar + Tweet Input --}}
    {{-- ========================================= --}}
    <div class="flex">

        {{-- User Profile Image --}}
        <div class="m-2 w-10 py-1">

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
        <div class="flex-1 px-2 pt-2 mt-2">

                <textarea
                    name="body"
                    class="bg-transparent text-gray-400 font-medium text-lg w-full"
                    rows="2"
                    cols="50"
                    placeholder="What's happening?">{{ old('body') }}</textarea>

        </div>

    </div>

    {{-- ========================================= --}}
    {{-- Tweet Action Buttons --}}
    {{-- ========================================= --}}
    <div class="flex">

        <div class="w-10"></div>

        <div class="w-64 px-2">

            <div class="flex">

                {{-- ========================================================= --}}
                {{-- Upload Image Button                                       --}}
                {{-- Opens the hidden image input when clicked.                --}}
                {{-- ========================================================= --}}
                <div class="flex-1 text-center px-1 py-1 m-2">

                    <label
                        for="imageInput"
                        class="cursor-pointer mt-1 group flex items-center justify-center text-blue-400 px-2 py-2 rounded-full hover:bg-gray-800 hover:text-blue-300">

                        <svg
                            class="h-7 w-6"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                        </svg>

                    </label>

                </div>

                {{-- ========================================================= --}}
                {{-- Upload Video Button                                       --}}
                {{-- Opens the hidden video input when clicked.                --}}
                {{-- ========================================================= --}}
                <div class="flex-1 text-center py-2 m-2">

                    <label
                        for="videoInput"
                        class="cursor-pointer mt-1 group flex items-center justify-center text-blue-400 px-2 py-2 rounded-full hover:bg-gray-800 hover:text-blue-300">

                        <svg
                            class="h-7 w-6"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>

                            <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                        </svg>

                    </label>

                </div>

            </div>

        </div>

        {{-- ========================================= --}}
        {{-- Submit Tweet Button --}}
        {{-- ========================================= --}}
        <div class="flex-1">

            <button
                type="submit"
                class="bg-blue-400 hover:bg-blue-500 mt-5 text-white font-bold py-2 px-8 rounded-full mr-8 float-right">

                Tweet

            </button>

        </div>

    </div>

</form>
