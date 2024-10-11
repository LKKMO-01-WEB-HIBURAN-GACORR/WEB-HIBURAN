@extends('_components.template')

@php
    $page_title = 'Post "' . $post->title . '"';
    $enable_footer = true;
@endphp

@section('content')
    <div class="post-item">
        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="post-img">
        <h2 class="post-title">{{ $post->title }}</h2>
        <p class="post-subtitle">by {{ $post->user->name }}</p>
        <div class="post-content">{{ $post->content }}</div>
    </div>
    <a class="btn btn-primary" href="{{ route('posts.list') }}">Back to Posts</a>
@endsection
