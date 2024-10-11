<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpotifyService
{
    private $clientId;
    private $clientSecret;
    private $token;

    public function __construct()
    {
        $this->clientId = env('SPOTIFY_CLIENT_ID');
        $this->clientSecret = env('SPOTIFY_CLIENT_SECRET');
    }

    private function authenticate()
    {
        $response = Http::asForm()->post(env('SPOTIFY_AUTH_URL'), [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        $this->token = $response->json()['access_token'];
    }

    public function searchTrack($query)
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get(env('SPOTIFY_API_URL') . '/search', [
            'q' => $query,
            'type' => 'track',
            'limit' => 20,
        ]);

        return $response->json();
    }

    public function getArtistGenres($artistId)
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get(env('SPOTIFY_API_URL') . '/artists/' . $artistId);

        return $response->json()['genres'] ?? [];
    }


    public function getTopSongs()
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get(env('SPOTIFY_API_URL') . '/browse/categories/toplists/playlists', [
            'limit' => 12,
        ]);

        $playlists = $response->json();

        if (isset($playlists['playlists']['items'][0]['id'])) {
            $playlistId = $playlists['playlists']['items'][0]['id'];

            $tracksResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get(env('SPOTIFY_API_URL') . "/playlists/{$playlistId}/tracks", [
                'limit' => 12,
            ]);

            return $tracksResponse->json();
        }

        return [];
    }


    public function getNewSongs()
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get(env('SPOTIFY_API_URL') . '/browse/new-releases', [
            'limit' => 12,
        ]);

        return $response->json();
    }

    public function getTrackById($spotifyId)
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get(env('SPOTIFY_API_URL') . "/tracks/{$spotifyId}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
