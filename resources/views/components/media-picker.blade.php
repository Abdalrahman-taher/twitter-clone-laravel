@props([
    'imageInput' => 'images',
    'videoInput' => 'videos',
    'inputSuffix' => null,
])

@php
    $imageInputId = $inputSuffix ? "{$imageInput}-{$inputSuffix}" : $imageInput;
    $videoInputId = $inputSuffix ? "{$videoInput}-{$inputSuffix}" : $videoInput;
@endphp

{{-- ========================================= --}}
{{-- Media Picker Component                    --}}
{{-- Reusable for Tweets, Comments, Chats ... --}}
{{-- ========================================= --}}

<div class="flex items-center gap-1">

    {{-- Image Upload --}}
    <label
        for="{{ $imageInputId }}"
        title="Add images"
        class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full text-blue-400 transition duration-200 hover:bg-blue-500/10 hover:text-blue-300 focus-within:bg-blue-500/10">

        <svg
            class="h-5 w-5"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            viewBox="0 0 24 24">

            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>

        </svg>

    </label>

    <input
        id="{{ $imageInputId }}"
        type="file"
        name="{{ $imageInput }}[]"
        class="hidden"
        accept="image/*"
        multiple>

    {{-- Video Upload --}}
    <label
        for="{{ $videoInputId }}"
        title="Add videos"
        class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full text-blue-400 transition duration-200 hover:bg-blue-500/10 hover:text-blue-300 focus-within:bg-blue-500/10">

        <svg
            class="h-5 w-5"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            viewBox="0 0 24 24">

            <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>

            <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

        </svg>

    </label>

    <input
        id="{{ $videoInputId }}"
        type="file"
        name="{{ $videoInput }}[]"
        class="hidden"
        accept="video/*"
        multiple>

    {{-- Preview Placeholder --}}
    <div class="hidden"></div>

</div>
