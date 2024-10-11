@extends('_components.template')

@php
    $page_title = 'Post';
    $enable_footer = true;
@endphp

@section('content')
    @include('_components.header')
    <div class="hstack">
        <h2 class="heading">ALL POSTS</h2>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="post">
        @foreach ($posts as $post)
            <a href="{{ route('posts.detail', $post->id) }}" class="post-item">
                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="post-img">
                <h2 class="post-title">{{ $post->title }}</h2>
                <p class="post-subtitle">by {{ $post->user->name }}</p>
                @if (Auth::user()->email === $post->user->email)
                    <div class="post-action">
                        <form action="{{ route('posts.handleDelete', $post->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </form>
                    </div>
                @endif
            </a>
        @endforeach
    </div>
@endsection
