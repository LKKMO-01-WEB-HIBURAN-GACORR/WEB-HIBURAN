@extends('_components.template')

@php
    $page_title = 'Playlist';
    $enable_footer = true;
@endphp

@section('content')
    @include('_components.header')
    <h2 class="heading">MY OWN</h2>
    <form action="{{ route('playlists.handleCreate') }}" method="post" class="form-group form-inline">
        @csrf
        <input type="text" class="form-control" name="name" placeholder="Playlist name" required>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($userPlaylists->isEmpty())
        <div class="alert alert-danger">
            You have no playlists.
        </div>
    @else
        <div class="playlist">
            @foreach ($userPlaylists as $playlist)
                <div class="playlist-item">
                    <h3 class="playlist-title">{{ $playlist->name }}</h3>
                    @if ($playlist->songs->isEmpty())
                        <div class="alert alert-danger">
                            No songs in this playlist
                        </div>
                    @else
                        <div class="playlist-wrap">
                            @foreach ($playlist->songs->slice(0, 3) as $song)
                                <div class="playlist-song">
                                    <img src="{{ $song->image_url }}" alt="{{ $song->name }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <a class="btn btn-primary" href="{{ route('playlists.detail', $playlist->id) }}">Ubah</a>
                </div>
            @endforeach
        </div>
    @endif
    <h2 class="heading">POPULAR PLAYLISTS</h2>
    @if ($latestPlaylists->isEmpty())
        <div class="alert alert-danger">
            No playlist has been created.
        </div>
    @else
        <div class="playlist">
            @foreach ($latestPlaylists as $playlist)
                <div class="playlist-item">
                    <h3 class="playlist-title">{{ $playlist->name }}</h3>
                    <p class="playlist-subtitle">by {{ $playlist->user->name }}</p>
                    @if ($playlist->songs->isEmpty())
                        <div class="alert alert-danger">
                            No songs in this playlist
                        </div>
                    @else
                        <div class="playlist-wrap">
                            @foreach ($playlist->songs->slice(0, 3) as $song)
                                <div class="playlist-song">
                                    <img src="{{ $song->image_url }}" alt="{{ $song->name }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <a class="btn btn-primary" href="{{ route('playlists.detail', $playlist->id) }}">Lihat</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
