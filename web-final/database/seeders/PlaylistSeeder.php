<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\Song;
use App\Services\SpotifyService;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    private $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function run(): void
    {
        $spotifyIds = [
            '5bY4g7cLyasuuhthJ7Mdlh',
            '2plbrEY59IikOBgBGLjaoe',
            '3zmN19fLAcKeDaajrIdWLB',
            '7zOVh5fGpEwSbZd0g9z80B',
            '2RHm5IDIZ8fYRGzBIo7exV',
            '5eBk8ZXcd0pb0AO4a5PpOg',
            '1PuhA9UXgH4wRnXzYk5S2Z',
            '5l3jhWIfRg1FeKgw7R1jWb',
            '2sD709AK9zRN6SKUmDhGEa',
            '2aDgJHhAbABvdW9NszrAPQ',
            '2JqsSFo6HqOxnmxBtHfNY6'
        ];

        Playlist::factory()
            ->count(20)
            ->create()
            ->each(function ($playlist) use ($spotifyIds) {
                $randomSpotifyIds = collect($spotifyIds)->random(5);

                foreach ($randomSpotifyIds as $spotifyId) {
                    $spotifyTrack = $this->spotifyService->getTrackById($spotifyId);

                    if ($spotifyTrack) {
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

                        $playlist->songs()->attach($song->id);
                    }
                }
            });
    }
}
