@extends('layouts.twitter-shell')

@section('title', 'Messages - Twitter Clone')

@section('content')
    <div class="h-screen overflow-hidden bg-[#15202b] text-white">
        <div class="h-full w-screen md:w-[990px]">
            @include('messages.partials.shell', [
                'conversations' => $conversations,
                'activeConversation' => null,
                'panel' => 'messages.partials.empty-selection',
            ])
        </div>
    </div>
@endsection
