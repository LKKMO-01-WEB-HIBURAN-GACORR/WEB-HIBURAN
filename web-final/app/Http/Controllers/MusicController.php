<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\SpotifyService;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function showHome()
    {
        $topSongs = $this->spotifyService->getTopSongs();
        $newSongs = $this->spotifyService->getNewSongs();
        $latestPosts = Post::with('user')->latest()->limit(5)->get();

        return view('music.home', compact('topSongs', 'newSongs', 'latestPosts'));
    }

    public function showSearch(Request $request)
    {
        $query = $request->input('query');

        $songs = null;

        if ($query) {
            $songs = $this->spotifyService->searchTrack($query);
        }

        return view('music.search', compact('songs', 'query'));
    }
}
