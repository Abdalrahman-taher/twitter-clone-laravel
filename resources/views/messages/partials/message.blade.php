@php
    $isMine = $message->sender_id === auth()->id();
@endphp

<div class="mb-3 flex {{ $isMine ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $message->id }}">
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
