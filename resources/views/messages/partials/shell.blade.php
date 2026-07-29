@php
    $activeConversation = $activeConversation ?? null;
@endphp

<div class="h-full overflow-hidden bg-[#15202b] text-white">
    <div class="grid h-full grid-cols-1 overflow-hidden border-x border-gray-800 md:grid-cols-12">

        <aside class="{{ $activeConversation ? 'hidden md:flex' : 'flex' }} h-full min-h-0 flex-col border-r border-gray-800 md:col-span-5 lg:col-span-4">
            <x-sticky-page-header class="shrink-0 px-5 py-4">
                <h1 class="text-xl font-extrabold text-white">
                    Messages
                </h1>
            </x-sticky-page-header>

            <div class="min-h-0 flex-1 overflow-y-auto">
                @forelse($conversations as $item)
                    @php
                        $user = $item->users->firstWhere('id', '!=', auth()->id());
                        $lastMessage = $item->messages()->latest()->first();
                        $isActive = $activeConversation && $activeConversation->id === $item->id;
                        $hasUnreadIndicator = $lastMessage && $lastMessage->sender_id !== auth()->id() && ! $isActive;
                        $handle = $user?->username ? '@' . ltrim($user->username, '@') : '@username';
                    @endphp

                    <a href="{{ route('messages.show', $item) }}"
                       class="block border-b border-gray-800 px-4 py-3 transition duration-200 {{ $isActive ? 'bg-gray-800/80' : 'hover:bg-white/5' }}">

                        <div class="flex gap-3">
                            @include('messages.partials.avatar', [
                                'user' => $user,
                                'sizeClass' => 'h-12 w-12 shrink-0',
                            ])

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold leading-5 text-white">
                                            {{ $user?->name ?? 'Unknown user' }}
                                        </p>

                                        <p class="truncate text-sm leading-5 text-gray-500">
                                            {{ $handle }}
                                        </p>
                                    </div>

                                    <span class="shrink-0 text-xs leading-5 text-gray-500">
                                        {{ $lastMessage?->created_at?->diffForHumans(null, true) ?? $item->updated_at?->diffForHumans(null, true) }}
                                    </span>
                                </div>

                                <p class="mt-1 truncate text-sm leading-5 text-gray-400">
                                    {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->body, 58) : 'No messages yet' }}
                                </p>
                            </div>

                            <span class="mt-8 h-2 w-2 shrink-0 rounded-full bg-blue-400 {{ $hasUnreadIndicator ? 'opacity-100' : 'opacity-0' }}" aria-hidden="true"></span>
                        </div>
                    </a>
                @empty
                    <div class="px-5 py-10 text-center">
                        <p class="text-base font-bold text-white">
                            No conversations yet
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Messages you start will show up here.
                        </p>
                    </div>
                @endforelse
            </div>
        </aside>

        <section class="{{ $activeConversation ? 'flex' : 'hidden md:flex' }} h-full min-h-0 flex-col md:col-span-7 lg:col-span-8">
            @include($panel)
        </section>

    </div>
</div>
