@props([
    'tweet',
    'nested' => false,
    'compact' => false,

])

@php
    $userHandle = $tweet->user->username
        ? '@' . ltrim($tweet->user->username, '@')
        : '@username';

$articleClass = $nested
    ? 'relative rounded-2xl border border-gray-700 bg-gray-950/70 p-3 sm:p-4'
    : ($compact
        ? 'relative px-2.5 py-2 transition duration-200 hover:bg-white/5'
        : 'relative px-4 py-3 transition duration-200 hover:bg-white/5');

$avatarClass = $nested
    ? 'h-10 w-10 shrink-0 overflow-hidden rounded-full'
    : ($compact
        ? 'h-8 w-8 shrink-0 overflow-hidden rounded-full'
        : 'h-11 w-11 shrink-0 overflow-hidden rounded-full');
    $rowGapClass = $compact ? 'gap-2' : 'gap-3';
    $profileLinkClass = $compact ? 'min-w-0 text-xs leading-tight' : 'min-w-0 text-sm leading-tight';
    $bodyClass = $compact ? 'mt-0.5 text-[13px] leading-4' : 'mt-2 text-[15px] leading-5';
    $actionsBorderClass = $nested ? 'border-gray-700' : 'border-gray-800';
@endphp

@if(! $nested)
    <li class="border-b border-gray-800">
        @endif

        <article
            id="tweet-{{ $tweet->id }}"
            x-data="{ ownerMenuOpen: false }"
            class="{{ $articleClass }}">

            <div class="flex {{ $rowGapClass }}">
                {{-- User Avatar --}}
                <a href="{{ route('profile.show', $tweet->user) }}"
                   class="{{ $avatarClass }}">

                    @php
                        $avatar = $tweet->user->medias
                            ->where('collection', 'avatar')
                            ->first();
                    @endphp

                    @if($avatar)

                        <img
                            class="h-full w-full object-cover"
                            src="{{ asset('storage/' . $avatar->path) }}"
                            alt="{{ $tweet->user->name }}">

                    @else

                        <svg
                            class="h-full w-full bg-gray-700 text-gray-500"
                            fill="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.3 0-9.8 1.6-9.8 4.9v2.5h19.6v-2.5c0-3.3-6.5-4.9-9.8-4.9z"/>

                        </svg>

                    @endif

                </a>

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        {{-- User Profile Link --}}
                        <a href="{{ route('profile.show', $tweet->user) }}"
                           class="{{ $profileLinkClass }}">

                        <span class="block truncate font-bold text-white hover:underline">
                            {{ $tweet->user->name }}
                        </span>

                            <span class="block truncate text-gray-500">
                            {{ $userHandle }} &middot; {{ $tweet->created_at->diffForHumans() }}
                        </span>

                        </a>

                        {{-- Tweet Owner Menu --}}
                        @if(! $compact && auth()->id() === $tweet->user_id)

                            <div class="relative shrink-0">
                                <button
                                    type="button"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-full text-gray-500 transition duration-200 hover:bg-blue-500/10 hover:text-blue-400"
                                    aria-label="Tweet options"
                                    x-on:click="ownerMenuOpen = ! ownerMenuOpen"
                                    x-on:click.outside="ownerMenuOpen = false">

                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M3 12a2 2 0 114 0 2 2 0 01-4 0zm7 0a2 2 0 114 0 2 2 0 01-4 0zm7 0a2 2 0 114 0 2 2 0 01-4 0z"/>
                                    </svg>

                                </button>

                                <div
                                    x-cloak
                                    x-show="ownerMenuOpen"
                                    x-transition.origin.top.right
                                    class="absolute right-0 z-20 mt-1 w-44 overflow-hidden rounded-xl border border-gray-700 bg-gray-900 py-1 text-sm shadow-xl">

                                    <a
                                        href="{{ route('tweets.edit', $tweet) }}"
                                        class="block px-4 py-2 font-medium text-gray-100 transition duration-200 hover:bg-gray-800">

                                        Edit

                                    </a>

                                    <form
                                        action="{{ route('tweets.destroy', $tweet) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="block w-full px-4 py-2 text-left font-medium text-red-400 transition duration-200 hover:bg-gray-800">

                                            Delete

                                        </button>

                                    </form>

                                </div>
                            </div>

                        @endif
                    </div>

                    <p class="{{ $bodyClass }} whitespace-pre-line break-words text-white">
                        {{ $tweet->body }}
                    </p>

                    {{-- Tweet Media --}}
                    <x-media-gallery
                        :model="$tweet"
                        :compact="$nested || $compact"
                    />

                    @unless($compact)
                        <p class="mt-3 text-xs text-gray-500">
                            {{ $tweet->created_at->format('h:i A') }} &middot; {{ $tweet->created_at->format('M d, Y') }}
                        </p>
                    @endunless

                    {{-- Tweet Actions --}}
                    @unless($compact)
                        @php
                            $liked = $tweet->isLikedBy(auth()->user());
                            $retweeted = $tweet->isRetweetedBy(auth()->user());
                        @endphp

                        <div
                            class="mt-3 flex items-center justify-between border-y {{ $actionsBorderClass }} py-2 text-sm text-gray-500">

                        {{-- Comment --}}
                        <button
                            type="button"
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

                            <span class="tabular-nums">{{ $tweet->comments_count }}</span>

                        </button>

                        {{-- Retweet --}}
                        <form
                            action="{{ route('tweets.retweet', $tweet) }}"
                            method="POST"
                            class="shrink-0">

                            @csrf

                            <button
                                type="submit"
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

                                <span class="tabular-nums">{{ $tweet->retweets_count ?? 0 }}</span>

                            </button>

                        </form>

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

                        </div>

                        {{-- Add Comment Form --}}
                        <form
                            action="{{ route('comments.store', $tweet) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="mt-3">

                        @csrf

                        <input
                            type="text"
                            name="body"
                            placeholder="Post your reply"
                            class="block w-full rounded-2xl border border-gray-700 bg-transparent px-4 py-2.5 text-sm text-white placeholder-gray-500 transition duration-200 focus:border-blue-500 focus:ring-blue-500">

                        <div class="mt-2 flex items-center justify-between">
                            <x-media-picker
                                imageInput="comment_images"
                                videoInput="comment_videos"
                                :inputSuffix="$tweet->id"/>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-full bg-blue-500 px-5 py-2 text-sm font-bold text-white transition duration-200 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">

                                Reply

                            </button>
                        </div>

                        </form>

                        {{-- Comments List --}}
                        @if($tweet->comments->count())

                        <div class="mt-3 divide-y divide-gray-800">

                            @foreach($tweet->comments as $comment)

                                <div class="flex gap-2 py-2.5">

                                    @php
                                        $commentAvatar = $comment->user->medias
                                            ->where('collection', 'avatar')
                                            ->first();
                                    @endphp

                                    <a href="{{ route('profile.show', $comment->user) }}"
                                       class="h-8 w-8 shrink-0 overflow-hidden rounded-full">

                                        @if($commentAvatar)

                                            <img
                                                class="h-full w-full object-cover"
                                                src="{{ asset('storage/' . $commentAvatar->path) }}"
                                                alt="{{ $comment->user->name }}">

                                        @else

                                            <div
                                                class="flex h-full w-full items-center justify-center bg-gray-700 text-gray-500">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>
                                                </svg>
                                            </div>

                                        @endif

                                    </a>

                                    <div class="min-w-0 flex-1">
                                        @php
                                            $commentHandle = $comment->user->username
                                                ? '@' . ltrim($comment->user->username, '@')
                                                : '@username';
                                        @endphp

                                        <p class="truncate text-xs text-gray-500">
                                            <span class="font-semibold text-gray-200">{{ $comment->user->name }}</span>
                                            <span>{{ $commentHandle }}</span>
                                            <span>&middot; {{ $comment->created_at->diffForHumans() }}</span>
                                        </p>

                                        <p class="mt-0.5 break-words text-sm leading-5 text-gray-200">
                                            {{ $comment->body }}
                                        </p>

                                        {{-- Comment Media --}}
                                        <x-media-gallery :model="$comment" :compact="true"/>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                        @endif
                    @endunless
                </div>
            </div>

        </article>

        @if(! $nested)
    </li>
@endif
