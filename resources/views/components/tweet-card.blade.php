{{-- ========================================================= --}}
{{-- Anonymous Blade Component                                 --}}
{{-- This component is responsible for rendering a single      --}}
{{-- tweet card.                                               --}}
{{--                                                           --}}
{{-- We use an Anonymous Component because it only contains    --}}
{{-- presentation (Blade/HTML) without any complex PHP logic.  --}}
{{-- This makes the view reusable across multiple pages while  --}}
{{-- keeping the code clean and maintainable.                  --}}
{{-- ========================================================= --}}

@props(['tweet'])


<li class="mb-4">

    <article
        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 transition duration-300 hover:bg-gray-100/50 dark:hover:bg-gray-700/50">

        <div class="flex justify-between items-center">
            {{-- User Profile Link --}}
            <a href="{{ route('profile.show', $tweet->user->username) }}"
               class="flex-shrink-0 group block">

                <div class="flex items-center">

                    <div>

                        {{-- ========================================================= --}}
                        {{-- User Avatar                                                 --}}
                        {{-- Avatar is loaded from User Media collection                 --}}
                        {{-- ========================================================= --}}

                        @php
                            $avatar = $tweet->user->medias
                                ->where('collection', 'avatar')
                                ->first();
                        @endphp

                        @if($avatar)

                            <img
                                class="h-11 w-11 rounded-full object-cover"
                                src="{{ asset('storage/' . $avatar->path) }}"
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

                    <div class="ml-1.5 text-sm leading-tight">

                        <p class="text-black dark:text-white font-bold block">

                            {{ $tweet->user->name }}

                            <span class="text-gray-500 dark:text-gray-400 font-normal block">
                                {{ $tweet->user->username }}
                            </span>

                            <span class="text-gray-500 dark:text-gray-400 text-base">
                                · {{ $tweet->created_at->diffForHumans() }}
                            </span>

                        </p>

                    </div>

                </div>

            </a>

        </div>

        <div class="mt-3">

            <p class="text-black dark:text-white block text-xl leading-snug">
                {{ $tweet->body }}
            </p>

            {{-- ========================================================= --}}
            {{-- Tweet Media                                               --}}
            {{-- Display all images and videos attached to the tweet       --}}
            {{-- ========================================================= --}}

            @foreach($tweet->medias as $media)

                @if(str_starts_with($media->mime_type, 'image/'))

                    <img
                        src="{{ asset('storage/' . $media->path) }}"
                        class="mt-2 rounded-2xl border border-gray-100 dark:border-gray-700 w-full max-h-[500px] object-cover"
                        alt="Tweet Image">

                @endif

                @if(str_starts_with($media->mime_type, 'video/'))

                    <video
                        controls
                        class="mt-2 rounded-2xl border border-gray-100 dark:border-gray-700 w-full max-h-[500px]">

                        <source
                            src="{{ asset('storage/' . $media->path) }}"
                            type="{{ $media->mime_type }}">

                        Your browser does not support the video tag.

                    </video>

                @endif

            @endforeach

            <p class="text-gray-500 dark:text-gray-400 text-base py-1 my-0.5">
                {{ $tweet->created_at->format('h:i A · M d, Y') }}
            </p>

            <div class="border-gray-200 dark:border-gray-600 border border-b-0 my-1"></div>

            {{-- ========================================================= --}}
            {{-- Tweet Actions                                             --}}
            {{-- Like / Comment / Share buttons                            --}}
            {{-- ========================================================= --}}

            <div class="text-gray-500 dark:text-gray-400 flex items-center mt-4">

                {{-- Comment --}}
                <div
                    class="flex items-center mr-8 hover:text-blue-400 transition duration-300 cursor-pointer">

                    <svg
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-5 h-5 mr-2">

                        <path
                            d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.043-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788z"/>

                    </svg>


                    <span>
        {{ $tweet->comments_count }}

                    </span>

                </div>

                {{-- Like Button --}}
                <form
                    action="{{ route('tweets.like', $tweet) }}"
                    method="POST"
                    class="mr-8">

                    @csrf

                    @php($liked = $tweet->isLikedBy(auth()->user()))

                    <button
                        type="submit"
                        class="flex items-center hover:text-red-500 transition duration-300 cursor-pointer">


                        <svg
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-5 h-5 mr-2 {{ $liked ? 'text-red-500' : '' }}">

                            <path
                                d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"/>

                        </svg>


                        <span>
                            {{ $tweet->likes_count }}
                        </span>


                    </button>

                </form>


                {{-- Share --}}
                <div
                    class="flex items-center hover:text-blue-400 transition duration-300 cursor-pointer">


                    <svg
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-5 h-5 mr-2">

                        <path
                            d="M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06l5 5c.293.293.768.293 1.06 0l5-5c.294-.292.294-.767 0-1.06z"/>

                    </svg>


                </div>


            </div>


            {{-- ========================================================= --}}
            {{-- Comments List                                             --}}
            {{-- Display comments attached to this tweet                   --}}
            {{-- ========================================================= --}}

            <div class="mt-4 space-y-3">


                @foreach($tweet->comments as $comment)

                    <div class="flex items-start">

                        <div class="ml-3">

                            <p class="text-sm text-white font-medium">
                                {{ $comment->user->name }}

                                <span class="text-gray-500">
                        {{ $comment->user->username }}
                    </span>
                            </p>


                            <p class="text-sm text-gray-300">
                                {{ $comment->body }}
                            </p>


                        </div>

                    </div>

                @endforeach


            </div>


            {{-- Add Comment Form --}}

            <form
                action="{{ route('comments.store', $tweet) }}"
                method="POST"
                class="mt-4 flex">

                @csrf


                <input
                    type="text"
                    name="body"
                    placeholder="Post your reply"
                    class="flex-1 bg-gray-700 rounded-full px-4 py-2 text-sm text-white focus:outline-none">


                <button
                    type="submit"
                    class="ml-3 px-4 rounded-full bg-blue-500 text-white text-sm">

                    Reply

                </button>


            </form>


            @if(auth()->id() == $tweet->user_id)

                <form
                    action="{{ route('tweets.destroy', $tweet) }}"
                    method="POST"
                    class="mt-3">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="text-red-500 hover:text-red-700 text-sm">

                        Delete Tweet

                    </button>

                </form>

            @endif

        </div>

    </article>
</li>
