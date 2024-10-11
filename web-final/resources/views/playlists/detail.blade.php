@extends('_components.template')

@php
    $page_title = 'Playlist "' . $playlist->name . '"';
    $enable_footer = true;
@endphp

@section('content')
    @include('_components.header')
    <div class="hstack">
        <h2 class="heading">{{ $playlist->name }}</h2>
        <a class="btn btn-primary" href="{{ route('playlists.list') }}">Back</a>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($playlist->songs->isEmpty())
        <div class="alert alert-danger">
            No songs in this playlist.
        </div>
    @else
        <div class="track">
            @foreach ($playlist->songs as $song)
                <div class="track-item">
                    <a href="{{ $song->spotify_url }}" class="track-item">
                        <img class="track-img" src="{{ $song->image_url }}" alt="{{ $song['name'] }}">
                        <div class="track-wrap">
                            <h2 class="track-title">{{ $song->name }}</h2>
                            <p class="track-subtitle">by {{ $song->artist }}</p>
                        </div>
                    </a>
                    @if ($owned)
                        <form class="track-action" action="{{ route('playlists.handleDeleteSong', [$playlist->id, $song->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
    @if ($owned)
        <form class="form-group form-inline" action="{{ route('playlists.detail', $playlist->id) }}" method="GET">
            <input type="search" class="form-control" name="query" placeholder="Add song" value="{{ old('query', $query) }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        @if ($songs)
            <div class="track">
                @foreach ($songs['tracks']['items'] as $song)
                    <div class="track-item">
                        <a href="{{ $song['external_urls']['spotify'] }}" class="track-item">
                            <img class="track-img" src="{{ $song['album']['images'][0]['url'] }}" alt="{{ $song['name'] }}">
                            <div class="track-wrap">
                                <h2 class="track-title">{{ $song['name'] }}</h2>
                                <p class="track-subtitle">by {{ $song['artists'][0]['name'] }}</p>
                            </div>
                        </a>
                        <form class="track-action" action="{{ route('playlists.handleAddSong', $playlist->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="spotify_id" value="{{ $song['id'] }}" required>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
        <form action="{{ route('playlists.handleDelete', $playlist->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete playlist</button>
        </form>
    @endif
@endsection
