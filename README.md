﻿# WEB-HIBURAN

Pastikan semua environment variable sudah diatur pada `.env` dengan juga menambahkan credential dari spotify

```
SPOTIFY_CLIENT_ID=<SPOTIFY_CLIENT_ID>
SPOTIFY_CLIENT_SECRET=<SPOTIFY_CLIENT_SECRET>
SPOTIFY_API_URL=https://api.spotify.com/v1
SPOTIFY_AUTH_URL=https://accounts.spotify.com/api/token
```

Jalankan seeder untuk mengisi dengan menjalankan

```
php artisan migrate:fresh --seed
```
