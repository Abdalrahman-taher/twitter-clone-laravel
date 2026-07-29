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

    $commentHandle = $comment->user->username
        ? '@' . ltrim($comment->user->username, '@')
        : '@username';
@endphp

<div class="flex gap-2 py-2.5">

    <a href="{{ route('profile.show', $comment->user) }}"
       class="h-8 w-8 shrink-0 overflow-hidden rounded-full">
        <x-user-avatar
            :user="$comment->user"
            class="h-8 w-8 shrink-0 overflow-hidden rounded-full"
        />
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
