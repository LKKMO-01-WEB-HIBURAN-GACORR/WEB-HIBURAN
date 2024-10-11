<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['spotify_id', 'name', 'artist', 'album', 'image_url', 'spotify_url'];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }
}
