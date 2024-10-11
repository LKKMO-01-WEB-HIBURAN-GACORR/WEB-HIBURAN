<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id');
            $table->string('name');
            $table->string('artist');
            $table->string('album');
            $table->string('image_url');
            $table->string('spotify_url');
            $table->timestamps();
        });

        Schema::create('playlist_song', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->references('id')->on('playlists')->onDelete('cascade');
            $table->foreignId('song_id')->references('id')->on('songs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
        Schema::dropIfExists('playlist_song');
    }
};
