@props(['model'])

@if($model->medias->count())

    <div class="mt-3 space-y-3">

        @foreach($model->medias as $media)

            @if(str_starts_with($media->mime_type, 'image/'))

                <img
                    src="{{ asset('storage/' . $media->path) }}"
                    alt="Media"
                    class="rounded-2xl border border-gray-700 max-h-96 w-auto">

            @elseif(str_starts_with($media->mime_type, 'video/'))

                <video
                    controls
                    class="rounded-2xl border border-gray-700 max-h-96 w-full">

                    <source
                        src="{{ asset('storage/' . $media->path) }}"
                        type="{{ $media->mime_type }}">

                </video>

            @endif

        @endforeach

    </div>

@endif
