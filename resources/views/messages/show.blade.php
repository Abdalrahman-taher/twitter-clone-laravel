@extends('layouts.twitter-shell')

@section('title', 'Messages - Twitter Clone')

@section('content')
    @php
        $conversations = auth()->user()
            ->conversations()
            ->with('users.medias')
            ->latest()
            ->get();

        $otherUser = $conversation->users
            ->firstWhere('id', '!=', auth()->id());
    @endphp

    <div class="h-screen overflow-hidden bg-[#15202b] text-white">
        <div class="h-full w-screen md:w-[990px]">
            @include('messages.partials.shell', [
                'conversations' => $conversations,
                'activeConversation' => $conversation,
                'panel' => 'messages.partials.conversation-panel',
            ])
        </div>
    </div>
@endsection
