<div class="flex flex-col w-full">

    {{-- ========================================================= --}}
    {{-- Create Tweet Form                                         --}}
    {{-- Sends tweet text + image/video to the backend.   --}}
    {{-- ========================================================= --}}

    <form method="POST"
          action="{{ route('tweets.store') }}"
          enctype="multipart/form-data">

        {{-- CSRF protection (Required for every POST form) --}}
        @csrf


        {{-- ========================================================= --}}
        {{-- Hidden File Inputs                                        --}}
        {{-- These inputs are hidden from the user.                    --}}
        {{-- Clicking the image/video icons will open them instead.    --}}
        {{-- ========================================================= --}}

        <input
            type="file"
            id="imageInput"
            name="image"
            accept="image/*"
            class="hidden">

        <input
            type="file"
            id="videoInput"
            name="video"
            accept="video/*"
            class="hidden">

        {{-- ========================================= --}}
        {{-- User Avatar + Tweet Input --}}
        {{-- ========================================= --}}
        <div class="flex">

            {{-- User Profile Image --}}
            <div class="m-2 w-10 py-1">

                @if(auth()->user()->avatar)
                    <img
                        class="inline-block h-10 w-10 rounded-full object-cover"
                        src="{{ asset('storage/' . auth()->user()->avatar) }}"
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
        {{-- (Not working yet !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!) --}}
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

    {{-- ========================================= --}}
    {{-- End Create Tweet Form --}}
    {{-- ========================================= --}}

    <hr class="border-gray-800 border-4">

    {{-- ========================================= --}}
    {{-- Tweets Feed --}}
    {{-- ========================================= --}}

    <ul class="list-none">
        @foreach ($tweets as $tweet)
            <li>
                <article class="hover:bg-gray-800 transition duration-350 ease-in-out">

                    <div class="flex flex-shrink-0 p-4 pb-0">

                        <a href="{{ route('profile.show', $tweet->user->username) }}"
                           class="flex-shrink-0 group block">

                            <div class="flex items-center">

                                <div>

                                    @if($tweet->user->avatar)
                                        <img
                                            class="inline-block h-10 w-10 rounded-full object-cover"
                                            src="{{ asset('storage/' . $tweet->user->avatar) }}"
                                            alt="{{ $tweet->user->name }}">
                                    @else
                                        <svg
                                            class="inline-block h-10 w-10 rounded-full bg-gray-700 text-gray-500"
                                            fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.3 0-9.8 1.6-9.8 4.9v2.5h19.6v-2.5c0-3.3-6.5-4.9-9.8-4.9z"/>
                                        </svg>
                                    @endif

                                </div>

                                <div class="ml-3">

                                    <p class="text-base leading-6 font-medium text-white">

                                        {{ $tweet->user->name }}

                                        <span class="text-gray-500 font-normal">
                                        {{ $tweet->user->username }}
                                    </span>

                                        <span class="text-sm leading-5 font-medium text-gray-400">
                                        · {{ $tweet->created_at->diffForHumans() }}
                                    </span>

                                    </p>

                                </div>

                            </div>

                        </a>

                    </div>

                    <div class="pl-16">

                        <p class="text-base width-auto font-medium text-white flex-shrink">
                            {{ $tweet->body }}
                        </p>

                        @if($tweet->image)
                            <img
                                src="{{ asset('storage/' . $tweet->image) }}"
                                class="mt-3 rounded-2xl border border-gray-700 w-full max-h-[500px] object-cover"
                                alt="Tweet Image">
                        @endif

                        @if($tweet->video)
                            <video
                                controls
                                class="mt-3 rounded-2xl border border-gray-700 w-full max-h-[500px]">

                                <source
                                    src="{{ asset('storage/' . $tweet->video) }}"
                                    type="video/mp4">

                                Your browser does not support the video tag.

                            </video>
                        @endif

                        <div class="flex items-center py-4">

                            <div
                                class="flex-1 flex items-center text-white text-xs hover:text-blue-400 transition duration-350 ease-in-out">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                    <g>
                                        <path
                                            d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"></path>
                                    </g>
                                </svg>
                                12.3 k
                            </div>

                            <form
                                action="{{ route('tweets.like', $tweet) }}"
                                method="POST"
                                class="flex-1">

                                @csrf

                                {{-- ===================================================== --}}
                                {{-- Check if the logged in user already liked this tweet  --}}
                                {{-- If true  => heart will be red                         --}}
                                {{-- If false => heart will stay white                     --}}
                                {{-- ===================================================== --}}


                            <div
                                class="flex-1 flex items-center text-white text-xs hover:text-red-600 transition duration-350 ease-in-out">

                                <form
                                    action="{{ route('tweets.like', $tweet) }}"
                                    method="POST">

                                    @csrf

                                    {{-- Check if the current user already liked this tweet --}}
                                    @php($liked = $tweet->isLikedBy(auth()->user()))

                                    <button type="submit">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                            class="w-5 h-5 mr-2 {{ $liked ? 'text-red-500' : 'text-white' }}">

                                            <g>
                                                <path
                                                    d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z">
                                                </path>
                                            </g>

                                        </svg>

                                    </button>

                                </form>

                                {{-- Show how many users liked this tweet --}}
                                {{ $tweet->likes->count() }}

                            </div>

                            <div
                                class="flex-1 flex items-center text-white text-xs hover:text-blue-400 transition duration-350 ease-in-out">

                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                    <g>
                                        <path
                                            d="M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06z">
                                        </path>
                                    </g>
                                </svg>

                            </div>

                        </div>

                    </div>

                    <hr class="border-gray-800">

                </article>
            </li>
        @endforeach
    </ul>
</div>
