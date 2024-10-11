@extends('_components.template')

@php
    $page_title = 'Search for "' . $query . '"';
    $enable_footer = true;
@endphp

@section('content')
    @include('_components.header')

    @if ($query && isset($songs['tracks']['items']) && count($songs['tracks']['items']) > 0)
        <h2 class="heading">KEYWORD: "{{ $query }}"</h2>
        <div class="track">
            @foreach ($songs['tracks']['items'] as $song)
                <a class="track-item" href="{{ $song['external_urls']['spotify'] }}">
                    <img src="{{ $song['album']['images'][0]['url'] }}" alt="{{ $song['name'] }}" class="track-img">
                    <div class="track-wrap">
                        <h2 class="track-title">{{ $song['name'] }}</h2>
                        <p class="track-subtitle">by {{ $song['artists'][0]['name'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @elseif ($query)
        <p>No results found for "{{ $query }}".</p>
    @endif
@endsection
