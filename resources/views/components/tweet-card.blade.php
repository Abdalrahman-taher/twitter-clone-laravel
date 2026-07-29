@props([
    'tweet',
    'nested' => false,
    'compact' => false,
    'showComments' => false,

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
                <a href="{{ route('profile.show', $tweet->user) }}">
                    <x-user-avatar
                        :user="$tweet->user"
                        :class="$avatarClass"
                    />
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


                    {{-- Quote Tweet Preview --}}
                    @if($tweet->quoteTweet)

                        <div class="mt-3">

                            <x-tweet-preview :tweet="$tweet->quoteTweet" />

                        </div>

                    @endif

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
                        <x-tweet-actions
                            :tweet="$tweet"
                            :border-class="$actionsBorderClass"
                        />

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
                        @if($showComments && $tweet->comments->count())

                            <div class="mt-3 divide-y divide-gray-800">

                                @foreach($tweet->comments as $comment)

                                    <x-comment-card
                                        :comment="$comment"
                                        :show-comments="$showComments"
                                    />

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
