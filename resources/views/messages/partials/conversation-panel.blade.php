@php
    $handle = $otherUser?->username ? '@' . ltrim($otherUser->username, '@') : '@username';
    $messages = $conversation->messages()
        ->with('sender.medias')
        ->oldest()
        ->get();
    $composerId = 'message-composer-' . $conversation->id;
    $imageInputId = 'message_images-' . $composerId;
    $videoInputId = 'message_videos-' . $composerId;
@endphp

<div class="flex h-full min-h-0 flex-col">
    <div class="sticky top-0 z-10 shrink-0 border-b border-gray-800 bg-[#15202b]/95 px-4 py-3 backdrop-blur sm:px-5">
        <div class="flex items-center justify-between gap-4">
            <div class="flex min-w-0 items-center gap-3">
                <a href="{{ route('messages.index') }}"
                   class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-gray-400 transition duration-200 hover:bg-blue-500/10 hover:text-blue-400 md:hidden"
                   aria-label="Back to messages">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.42-1.41L7.83 13H20v-2z"/>
                    </svg>
                </a>

                @include('messages.partials.avatar', [
                    'user' => $otherUser,
                    'sizeClass' => 'h-10 w-10 shrink-0',
                ])

                <div class="min-w-0">
                    <h2 class="truncate text-base font-bold leading-5 text-white">
                        {{ $otherUser?->name ?? 'Unknown user' }}
                    </h2>

                    <p class="truncate text-sm leading-5 text-gray-500">
                        {{ $handle }}
                    </p>
                </div>
            </div>

            @if($otherUser)
                <div class="flex shrink-0 items-center gap-1">
                    <a href="{{ route('profile.show', $otherUser) }}"
                       class="inline-flex items-center justify-center rounded-full border border-gray-600 px-4 py-1.5 text-sm font-bold text-white transition duration-200 hover:bg-white/10">
                        Profile
                    </a>

                    <button type="button"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full text-gray-400 transition duration-200 hover:bg-blue-500/10 hover:text-blue-400"
                            aria-label="Conversation options">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 12a2 2 0 114 0 2 2 0 01-4 0zm7 0a2 2 0 114 0 2 2 0 01-4 0zm7 0a2 2 0 114 0 2 2 0 01-4 0z"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="min-h-0 flex-1 overflow-y-auto px-4 py-5 sm:px-5">
        @forelse($messages as $message)
            @php
                $isMine = $message->sender_id === auth()->id();
            @endphp

            <div class="mb-3 flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[82%] sm:max-w-[72%]">
                    <div class="rounded-2xl px-4 py-2.5 {{ $isMine ? 'rounded-br-md bg-blue-500' : 'rounded-bl-md bg-gray-800' }}">
                        <p class="whitespace-pre-line break-words text-[15px] leading-5 text-white">
                            {{ $message->body }}
                        </p>

                        @if($message->medias->count())

                            <div class="mt-2 space-y-2">

                                @foreach($message->medias as $media)

                                    @if(str_contains($media->mime_type, 'image'))

                                        <img
                                            src="{{ asset('storage/'.$media->path) }}"
                                            class="max-w-xs rounded-xl"
                                        >

                                    @elseif(str_contains($media->mime_type, 'video'))

                                        <video
                                            controls
                                            class="max-w-xs rounded-xl">
                                            <source src="{{ asset('storage/'.$media->path) }}">
                                        </video>

                                    @endif

                                @endforeach

                            </div>

                        @endif

                    </div>

                    <p class="mt-1 px-1 text-xs text-gray-500 {{ $isMine ? 'text-right' : 'text-left' }}">
                        {{ $message->created_at->format('h:i A') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="flex h-full items-center justify-center">
                <div class="max-w-xs text-center">
                    <h3 class="text-2xl font-bold text-white">
                        No messages yet
                    </h3>

                    <p class="mt-2 text-base text-gray-400">
                        Start the conversation.
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    @if($otherUser)
        <form method="POST"
              action="{{ route('messages.send', $conversation) }}"
              enctype="multipart/form-data"
              class="shrink-0 border-t border-gray-800 bg-[#15202b] px-3 py-3 sm:px-4"
              x-data="messageComposer(@js($imageInputId), @js($videoInputId))"
              x-on:change="syncMedia($event)">
            @csrf

            <div x-cloak
                 x-show="previews.length"
                 class="mb-3 grid max-h-64 overflow-hidden rounded-2xl border border-gray-700 bg-gray-900 gap-0.5"
                 x-bind:class="previews.length === 1 ? 'grid-cols-1' : 'grid-cols-2'">
                <template x-for="(preview, index) in previews" :key="preview.id">
                    <div class="group relative min-h-0 overflow-hidden bg-gray-800"
                         x-bind:class="previews.length === 1 ? 'aspect-[16/9]' : (previews.length === 3 && index === 0 ? 'row-span-2 aspect-auto' : 'aspect-square')">
                        <template x-if="preview.type === 'image'">
                            <img x-bind:src="preview.url"
                                 alt="Selected media preview"
                                 class="h-full w-full object-cover">
                        </template>

                        <template x-if="preview.type === 'video'">
                            <video x-bind:src="preview.url"
                                   class="h-full w-full object-cover"
                                   muted
                                   playsinline
                                   controls>
                            </video>
                        </template>

                        <button type="button"
                                class="absolute right-2 top-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-black/70 text-xl leading-none text-white transition duration-200 hover:bg-black"
                                aria-label="Remove selected media"
                                x-on:click="removeMedia(preview)">
                            &times;
                        </button>
                    </div>
                </template>
            </div>

            <div class="flex items-end gap-1 sm:gap-2">
                <div class="flex shrink-0 items-center">
                    <x-media-picker
                        imageInput="message_images"
                        videoInput="message_videos"
                        :inputSuffix="$composerId"
                    />

                    <button type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-full text-blue-400 transition duration-200 hover:bg-blue-500/10 hover:text-blue-300"
                            aria-label="Add GIF">
                        <span class="text-xs font-black tracking-normal">GIF</span>
                    </button>

                    <button type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-full text-blue-400 transition duration-200 hover:bg-blue-500/10 hover:text-blue-300"
                            aria-label="Add emoji">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a10 10 0 100 20 10 10 0 000-20zM8.5 8.25a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5zm7 0a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5zM7.8 14.2a1 1 0 011.4.2A3.5 3.5 0 0012 15.8a3.5 3.5 0 002.8-1.4 1 1 0 111.6 1.2A5.5 5.5 0 0112 17.8a5.5 5.5 0 01-4.4-2.2 1 1 0 01.2-1.4z"/>
                        </svg>
                    </button>
                </div>

                <textarea name="body"
                          rows="1"
                          placeholder="Start a new message"
                          class="max-h-32 min-h-[40px] min-w-0 flex-1 resize-none rounded-3xl border-0 bg-gray-800 px-4 py-2.5 text-[15px] leading-5 text-white placeholder-gray-500 transition duration-200 focus:ring-2 focus:ring-blue-500"
                          x-model="body"
                          x-on:input="resizeMessageInput($event)"></textarea>

                <button type="submit"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-500 text-white transition duration-200 hover:bg-blue-600 disabled:cursor-not-allowed disabled:bg-blue-500/40 disabled:text-white/60"
                        aria-label="Send message"
                        x-bind:disabled="!canSubmit">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2 .01 7z"/>
                    </svg>
                </button>
            </div>
        </form>
    @endif
</div>
