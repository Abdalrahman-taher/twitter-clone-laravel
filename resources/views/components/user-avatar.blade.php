@props([
    'user',
    'sizeClass' => 'h-12 w-12',
])

@php
    $avatar = $user?->medias
        ? $user->medias->where('collection', 'avatar')->first()
        : null;
@endphp

@if($avatar)
    <img
        {{ $attributes->merge(['class' => trim($sizeClass . ' rounded-full object-cover')]) }}
        src="{{ asset('storage/' . $avatar->path) }}"
        alt="{{ $user?->name }}">
@else
    <div
        {{ $attributes->merge(['class' => trim($sizeClass . ' flex shrink-0 items-center justify-center overflow-hidden rounded-full bg-gray-700 text-gray-500')]) }}>
        <svg class="h-1/2 w-1/2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>
        </svg>
    </div>
@endif

