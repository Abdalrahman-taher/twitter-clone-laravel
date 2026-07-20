@props(['retweet'])


<li class="border-b border-gray-800 py-4">


    {{-- ========================================================= --}}
    {{-- Retweet Header                                            --}}
    {{-- Show user who retweeted                                   --}}
    {{-- ========================================================= --}}

    <div class="text-gray-500 text-sm mb-2">

        🔁 {{ $retweet->user->name }} Retweeted

    </div>



    {{-- ========================================================= --}}
    {{-- Original Tweet Card                                       --}}
    {{-- Reuse tweet-card component                                --}}
    {{-- ========================================================= --}}

    <x-tweet-card :tweet="$retweet->tweet" />


</li>
