<div class="flex flex-col w-full">

    {{-- ========================================================= --}}
    {{-- Create Tweet Form                                         --}}
    {{-- Rendered using an Anonymous Blade Component.              --}}
    {{-- ========================================================= --}}
    <x-create-tweet-form />

    <hr class="border-gray-800 border-4">

    {{-- ========================================================= --}}
    {{-- Tweets Feed                                               --}}
    {{-- ========================================================= --}}
    <ul class="list-none">
        @foreach ($tweets as $tweet)
            <x-tweet-card :tweet="$tweet" />
        @endforeach
    </ul>

</div>
