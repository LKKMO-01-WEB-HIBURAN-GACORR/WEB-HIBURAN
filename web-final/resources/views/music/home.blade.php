@extends('_components.template')

@php
    $page_title = 'Homepage';
    $enable_footer = true;
@endphp

@section('content')
    @include("_components.header")
    <h2 class="heading">NEW RELEASES</h2>
    <div class="track">
        @foreach ($newSongs['albums']['items'] as $song)
            <a class="track-item" href="{{ $song['external_urls']['spotify'] }}">
                <img class="track-img" src="{{ $song['images'][0]['url'] }}" alt="{{ $song['name'] }}">
                <div class="track-wrap">
                    <h2 class="track-title">{{ $song['name'] }}</h2>
                    <p class="track-subtitle">by {{ $song['artists'][0]['name'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <h2 class="heading">LATEST POST</h2>
    <div class="post">
        @foreach ($latestPosts as $post)
            <a class="post-item" href="{{ route('posts.detail', $post->id) }}">
                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="post-img">
                <h2 class="post-title">{{ $post->title }}</h2>
                <p class="post-subtitle">by {{ $post->user->name }}</p>
            </a>
        @endforeach
    </div>
    <h2 class="heading">TOP TRACKS</h2>
    <div class="track">
        @foreach ($topSongs['items'] as $song)
            <a class="track-item" href="{{ $song['track']['external_urls']['spotify'] }}">
                <img src="{{ $song['track']['album']['images'][0]['url'] }}" alt="{{ $song['track']['name'] }}" class="track-img">
                <div class="track-wrap">
                    <h2 class="track-title">{{ $song['track']['name'] }}</h2>
                    <p class="track-subtitle">by {{ $song['track']['artists'][0]['name'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endsection
