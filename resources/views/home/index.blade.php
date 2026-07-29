@extends('layouts.twitter-shell')

@section('title', 'Twitter Clone')

@section('content')
    <div class="flex" style="width: 990px;">
        @include('home.feed')
        @include('home.right-sidebar')
    </div>
@endsection
