<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function showList()
    {
        $userPlaylists = Playlist::with('songs')->where('user_id', Auth::id())->latest()->get();
        $latestPlaylists = Playlist::with(['songs', 'user'])->latest()->get();

        return view('playlists.list', compact('userPlaylists', 'latestPlaylists'));
    }

    public function handleCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist = new Playlist();
        $playlist->name = $request->input('name');
        $playlist->user_id = Auth::id();
        $playlist->save();

        return redirect()->route('playlists.detail', $playlist->id);
    }


    public function showDetail(Request $request, $id)
    {
        $query = $request->input('query');

        $songs = [];

        if ($query) {
            $songs = $this->spotifyService->searchTrack($query);
        }

        $playlist = Playlist::with('songs')->findOrFail($id);

        $owned = $playlist->user->id == Auth::user()->id;

        return view('playlists.detail', compact('playlist', 'songs', 'query', 'owned'));
    }


    public function handleAddSong(Request $request, $id)
    {
        $request->validate([
            'spotify_id' => 'required|string',
        ]);

        $playlist = Playlist::findOrFail($id);

        $spotifyTrack = $this->spotifyService->getTrackById($request->input('spotify_id'));

        if (!$spotifyTrack) {
            return back()->withErrors(['spotify_id' => 'Song not founded in Spotify']);
        }

        $song = Song::firstOrCreate(
            ['spotify_id' => $spotifyTrack['id']],
            [
                'name' => $spotifyTrack['name'],
                'artist' => $spotifyTrack['artists'][0]['name'],
                'album' => $spotifyTrack['album']['name'],
                'image_url' => $spotifyTrack['album']['images'][0]['url'],
                'spotify_url' => $spotifyTrack['external_urls']['spotify'],
            ]
        );

        $playlist->songs()->syncWithoutDetaching($song->id);

        return redirect()->route('playlists.detail', $id);
    }

    public function handleDeleteSong($playlistId, $songId)
    {
        $playlist = Playlist::findOrFail($playlistId);

        if ($playlist->user_id !== Auth::id()) {
            return redirect()->route('playlists.detail', $playlist->id)->withErrors(['error' => 'You have no permission.']);
        }

        $playlist->songs()->detach($songId);

        return redirect()->route('playlists.detail', $playlist->id);
    }


    public function handleDelete($id)
    {
        $playlist = Playlist::findOrFail($id);
        if ($playlist->user_id !== Auth::id()) {
            return redirect()->route('playlists.detail', $playlist->id)->withErrors(['error' => 'You have no permission.']);
        }

        $playlist->delete();

        return redirect()->route('playlists.list')->with('success', 'Playlist has been deleted.');
    }
}
