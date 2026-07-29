@extends('layouts.twitter-shell')

@section('title', $title . ' - ' . $profileUser->name)

@section('content')
    <div class="flex" style="width:990px;">
        <div class="flex w-full flex-col border-x border-gray-800">

                    <x-sticky-page-header>

                        <div class="flex items-center gap-4">

                            <a href="{{ route('profile.show',$profileUser) }}"
                               class="rounded-full p-2 text-blue-400 hover:bg-gray-800">

                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6a1 1 0 000 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293a.999.999 0 000-1.414L7.414 13H20a1 1 0 100-2z"/>
                                </svg>

                            </a>

                            <div>

                                <h1 class="text-xl font-bold text-white">
                                    {{ $title }}
                                </h1>

                                <p class="text-sm text-gray-400">
                                    {{ $profileUser->name }}
                                </p>

                            </div>

                        </div>

                    </x-sticky-page-header>


                    @forelse($users as $user)

                        <div class="flex items-center justify-between border-b border-gray-800 p-4 hover:bg-gray-800 transition">

                            <a href="{{ route('profile.show',$user) }}"
                               class="flex items-center gap-3 flex-1">

                                <x-user-avatar
                                    :user="$user"
                                    class="h-12 w-12 rounded-full"
                                />

                                <div>

                                    <h3 class="font-semibold text-white">
                                        {{ $user->name }}
                                    </h3>

                                    <p class="text-sm text-gray-400">
                                        {{ $user->username }}
                                    </p>

                                </div>

                            </a>


                            @if(auth()->id() !== $user->id)

                                @if(auth()->user()->isFollowing($user))

                                    <form method="POST"
                                          action="{{ route('users.unfollow',$user) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="rounded-full bg-white px-5 py-2 text-sm font-bold text-black hover:bg-gray-200">

                                            Unfollow

                                        </button>

                                    </form>

                                @else

                                    <form method="POST"
                                          action="{{ route('users.follow',$user) }}">

                                        @csrf

                                        <button
                                            class="rounded-full bg-blue-500 px-5 py-2 text-sm font-bold text-white hover:bg-blue-600">

                                            Follow

                                        </button>

                                    </form>

                                @endif

                            @endif

                        </div>

                    @empty

                        <div class="py-12 text-center text-gray-400">

                            No {{ strtolower($title) }} yet.

                        </div>

                    @endforelse

                </div>

                @include('home.right-sidebar')
        </div>
    </div>
@endsection
