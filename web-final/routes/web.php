<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'handleRegister'])->name('handleRegister');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('handleLogin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'handleEditProfile'])->name('profile.handleEdit');
    Route::post('/logout', [AuthController::class, 'handleLogout'])->name('handleLogout');

    Route::prefix('/post')->group(function () {
        Route::get('/', [PostController::class, 'showList'])->name('posts.list');
        Route::get('/show/{id}', [PostController::class, 'showDetail'])->name('posts.detail');
        Route::get('/create', [PostController::class, 'showCreate'])->name('posts.create');
        Route::post('/create', [PostController::class, 'handleCreate'])->name('posts.handleCreate');
        Route::delete('/delete/{id}', [PostController::class, 'handleDelete'])->name('posts.handleDelete');
    });

    Route::prefix('/playlist')->group(function () {
        Route::get('/', [PlaylistController::class, 'showList'])->name('playlists.list');
        Route::get('/show/{id}', [PlaylistController::class, 'showDetail'])->name('playlists.detail');
        Route::post('/create', [PlaylistController::class, 'handleCreate'])->name('playlists.handleCreate');
        Route::delete('/delete/{id}', [PlaylistController::class, 'handleDelete'])->name('playlists.handleDelete');
        Route::post('/add-song/{id}', [PlaylistController::class, 'handleAddSong'])->name('playlists.handleAddSong');
        Route::delete('/delete/song/{playlist}/{song}', [PlaylistController::class, 'handleDeleteSong'])->name('playlists.handleDeleteSong');
    });
});

Route::get('/search', [MusicController::class, 'showSearch'])->name('music.search');
Route::get('/', [MusicController::class, 'showHome'])->name('home');
