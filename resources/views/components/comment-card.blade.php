@props([
    'comment',
    'showComments' => false,
])

@php
    $comment->loadMissing([
        'user.medias',
        'medias',
        'comments.user.medias',
        'comments.medias',
        'quoteTweet.user.medias',
        'quoteTweet.medias',
    ]);

    $commentAvatar = $comment->user->medias
        ->where('collection', 'avatar')
        ->first();

    $commentHandle = $comment->user->username
        ? '@' . ltrim($comment->user->username, '@')
        : '@username';
@endphp

<div class="flex gap-2 py-2.5">

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
                    <path
                        d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>
                </svg>
            </div>

        @endif

    </a>

    <div class="min-w-0 flex-1">
        <p class="truncate text-xs text-gray-500">
            <span
                class="font-semibold text-gray-200">{{ $comment->user->name }}</span>
            <span>{{ $commentHandle }}</span>
            <span>&middot; {{ $comment->created_at->diffForHumans() }}</span>
        </p>

        <p class="mt-0.5 break-words text-sm leading-5 text-gray-200">
            {{ $comment->body }}
        </p>

        {{-- Comment Media --}}
        <x-media-gallery :model="$comment" :compact="true"/>

        {{-- Comment Actions --}}
        <x-tweet-actions
            :tweet="$comment"
            :show-bookmark="false"
            :show-share="false"
            :with-border="false"
            class="mt-2"
        />

        @if(auth()->id() === $comment->user_id)

            <form
                action="{{ route('comments.destroy', $comment) }}"
                method="POST"
                class="mt-2">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm('Delete this comment?')"
                    class="text-xs text-red-500 transition hover:text-red-400">

                    Delete

                </button>

            </form>

        @endif

        @if($showComments && $comment->comments->count())

            <div class="mt-2 divide-y divide-gray-800 border-l border-gray-800 pl-3">

                @foreach($comment->comments as $reply)

                    <x-comment-card
                        :comment="$reply"
                        :show-comments="$showComments"
                    />

                @endforeach

            </div>

        @endif
    </div>

</div>
