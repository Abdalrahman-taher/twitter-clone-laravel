<x-app-layout>

    {{-- ===================================================== --}}
    {{-- Notifications Page                                    --}}
    {{-- Show all notifications for the authenticated user     --}}
    {{-- ===================================================== --}}

    <div class="max-w-3xl mx-auto">

        {{-- ===================================================== --}}
        {{-- Page Header                                           --}}
        {{-- ===================================================== --}}

        <div class="border-b border-gray-800 px-4 py-4">
            <h1 class="text-2xl font-bold text-white">
                Notifications
            </h1>
        </div>

        {{-- ===================================================== --}}
        {{-- Notifications List                                    --}}
        {{-- ===================================================== --}}

        @forelse($notifications as $notification)

            <div class="border-b border-gray-800 px-4 py-4 hover:bg-gray-800 transition">

                <div class="flex gap-3">

                    {{-- ===================================================== --}}
                    {{-- Actor Avatar                                           --}}
                    {{-- ===================================================== --}}

                    @php
                        $avatar = $notification->actor
                            ->medias
                            ->where('collection', 'avatar')
                            ->first();
                    @endphp

                    @if($avatar)

                        <img
                            src="{{ asset('storage/' . $avatar->path) }}"
                            class="h-12 w-12 rounded-full object-cover"
                            alt="{{ $notification->actor->name }}">

                    @else

                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-700">

                            <svg class="h-6 w-6 text-gray-400"
                                 fill="currentColor"
                                 viewBox="0 0 24 24">

                                <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>

                            </svg>

                        </div>

                    @endif


                    {{-- ===================================================== --}}
                    {{-- Notification Content                                  --}}
                    {{-- ===================================================== --}}

                    <div class="flex-1">

                        @if($notification->type === 'follow')

                            <p class="text-white">
                                <span class="font-bold">
                                    {{ $notification->actor->name }}
                                </span>

                                started following you.
                            </p>

                        @elseif($notification->type === 'like')

                            <p class="text-white">
                                <span class="font-bold">
                                    {{ $notification->actor->name }}
                                </span>

                                liked your tweet.
                            </p>

                        @elseif($notification->type === 'comment')

                            <p class="text-white">
                                <span class="font-bold">
                                    {{ $notification->actor->name }}
                                </span>
                                commented on your tweet.
                            </p>

                        @elseif($notification->type === 'retweet')

                            <p class="text-white">
                                    <span class="font-bold">
                                        {{ $notification->actor->name }}
                                    </span>
                                retweeted your tweet.
                            </p>

                        @endif


                        <p class="mt-1 text-sm text-gray-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>

                    </div>

                </div>

            </div>

        @empty

            {{-- ===================================================== --}}
            {{-- Empty State                                           --}}
            {{-- ===================================================== --}}

            <div class="py-16 text-center text-gray-500">

                You don't have any notifications yet.

            </div>

        @endforelse

    </div>

</x-app-layout>
