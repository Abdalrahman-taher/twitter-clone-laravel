@props([
    'model',
    'compact' => false,
])

@php
    $images = $model->medias->filter(fn ($media) => str_starts_with($media->mime_type, 'image/'))->values();
    $videos = $model->medias->filter(fn ($media) => str_starts_with($media->mime_type, 'video/'))->values();
    $imageCount = $images->count();
    $visibleImages = $images->take(4);
    $remainingImages = max($imageCount - 4, 0);
    $imageUrls = $images->map(fn ($media) => asset('storage/' . $media->path))->values();
    $mediaRadius = $compact ? 'rounded-lg' : 'rounded-2xl';
    $singleImageClass = $compact ? 'h-[220px] max-h-[220px] sm:h-[240px] sm:max-h-[240px]' : 'aspect-[16/10]';
    $multiImageGridClass = $compact && $imageCount >= 2 ? 'h-[180px] max-h-[180px] sm:h-[200px] sm:max-h-[200px]' : '';
    $multiImageRowsClass = $compact && $imageCount >= 2 ? ($imageCount === 2 ? 'grid-rows-1' : 'grid-rows-2') : '';
    $compactTileClass = $compact ? 'h-full max-h-full' : 'aspect-square';
    $threeImageLeadClass = $compact ? 'row-span-2 h-full max-h-full' : 'row-span-2 aspect-auto';
@endphp

@if($model->medias->count())

    <div class="{{ $compact ? 'mt-1.5 space-y-2' : 'mt-3 space-y-3' }} overflow-hidden">

        @if($imageCount)
            <div
                x-data="mediaGallery(@js($imageUrls))"
                x-on:keydown.escape.window="close()"
                x-on:keydown.arrow-right.window="open && next()"
                x-on:keydown.arrow-left.window="open && previous()">

                <div class="grid {{ $multiImageGridClass }} {{ $multiImageRowsClass }} overflow-hidden {{ $mediaRadius }} border border-gray-700 bg-gray-900 gap-0.5
                    {{ $imageCount === 1 ? 'grid-cols-1' : 'grid-cols-2' }}">

                    @foreach($visibleImages as $index => $media)

                        @php
                            $isSingle = $imageCount === 1;
                            $isThreeLead = $imageCount === 3 && $index === 0;
                            $tileClass = $isSingle
                                ? $singleImageClass
                                : ($isThreeLead ? $threeImageLeadClass : $compactTileClass);
                        @endphp

                        <button
                            type="button"
                            class="group relative block min-h-0 overflow-hidden bg-gray-800 {{ $tileClass }}"
                            x-on:click="openAt({{ $index }})">

                            <img
                                src="{{ asset('storage/' . $media->path) }}"
                                alt="Tweet media"
                                class="h-full w-full object-cover transition duration-200 group-hover:brightness-90">

                            @if($index === 3 && $remainingImages > 0)
                                <span class="absolute inset-0 flex items-center justify-center bg-black/55 text-2xl font-bold text-white">
                                    +{{ $remainingImages }} more
                                </span>
                            @endif

                        </button>

                    @endforeach

                </div>

                <div
                    x-cloak
                    x-show="open"
                    x-transition.opacity
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
                    x-on:click.self="close()">

                    <button
                        type="button"
                        class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20"
                        aria-label="Close media viewer"
                        x-on:click="close()">

                        <span class="text-2xl leading-none">&times;</span>

                    </button>

                    <button
                        type="button"
                        class="absolute left-4 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-3xl text-white transition hover:bg-white/20 sm:inline-flex"
                        aria-label="Previous image"
                        x-show="images.length > 1"
                        x-on:click.stop="previous()">

                        &#8249;

                    </button>

                    <img
                        x-bind:src="images[activeIndex]"
                        alt="Expanded tweet media"
                        class="max-h-[88vh] max-w-full rounded-lg object-contain">

                    <button
                        type="button"
                        class="absolute right-4 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-3xl text-white transition hover:bg-white/20 sm:inline-flex"
                        aria-label="Next image"
                        x-show="images.length > 1"
                        x-on:click.stop="next()">

                        &#8250;

                    </button>

                    <div
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-white/10 px-3 py-1 text-sm text-white"
                        x-show="images.length > 1">

                        <span x-text="activeIndex + 1"></span>/<span x-text="images.length"></span>

                    </div>

                </div>
            </div>
        @endif

        @foreach($videos as $media)

            <video
                controls
                class="{{ $compact ? 'max-h-[240px] rounded-lg object-cover' : 'max-h-96 rounded-2xl object-contain' }} w-full border border-gray-700 bg-black">

                <source
                    src="{{ asset('storage/' . $media->path) }}"
                    type="{{ $media->mime_type }}">

            </video>

        @endforeach

    </div>

@endif
