<div class="flex w-[600px] flex-none flex-col">

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

        @foreach ($feed as $item)

            @if($item->type === 'tweet')

                <x-tweet-card :tweet="$item" />

            @elseif($item->type === 'retweet')

                <x-retweet-card :retweet="$item" />

            @endif

        @endforeach

    </ul>

</div>
