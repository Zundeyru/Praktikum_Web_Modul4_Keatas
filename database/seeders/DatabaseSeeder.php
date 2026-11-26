<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Dari $catalog di index.php Modul 3
        $catalog = [
            ['type' => 'anime', 'title' => "Frieren: Beyond Journey's End", 'release_year' => 2023, 'rating' => 9.3,
             'genres' => ['Adventure', 'Fantasy', 'Drama'], 'episodes' => 28, 'studio' => 'Madhouse'],
            ['type' => 'anime', 'title' => 'Jujutsu Kaisen', 'release_year' => 2020, 'rating' => 8.6,
             'genres' => ['Action', 'Supernatural'], 'episodes' => 47, 'studio' => 'MAPPA'],
            ['type' => 'anime', 'title' => 'Spy x Family', 'release_year' => 2022, 'rating' => 8.5,
             'genres' => ['Action', 'Comedy', 'Slice of Life'], 'episodes' => 37, 'studio' => 'Wit Studio & CloverWorks'],
            ['type' => 'drama', 'title' => 'Crash Landing on You', 'release_year' => 2019, 'rating' => 8.7,
             'genres' => ['Romance', 'Comedy'], 'episodes' => 16, 'country' => 'Korea Selatan', 'minutes_per_episode' => 80],
            ['type' => 'drama', 'title' => 'Reply 1988', 'release_year' => 2015, 'rating' => 9.2,
             'genres' => ['Slice of Life', 'Family'], 'episodes' => 20, 'country' => 'Korea Selatan', 'minutes_per_episode' => 90],
            ['type' => 'manga', 'title' => 'One Piece', 'release_year' => 1997, 'rating' => 9.2,
             'genres' => ['Adventure', 'Action', 'Fantasy'], 'author' => 'Eiichiro Oda', 'chapters' => 1130, 'is_ongoing' => true],
            ['type' => 'manga', 'title' => 'Spy x Family', 'release_year' => 2019, 'rating' => 8.6,
             'genres' => ['Action', 'Comedy'], 'author' => 'Tatsuya Endo', 'chapters' => 110, 'is_ongoing' => true],
            ['type' => 'manga', 'title' => 'Vagabond', 'release_year' => 1998, 'rating' => 9.3,
             'genres' => ['Action', 'Historical'], 'author' => 'Takehiko Inoue', 'chapters' => 327, 'is_ongoing' => false],
            ['type' => 'light_novel', 'title' => 'Sword Art Online', 'release_year' => 2009, 'rating' => 7.6,
             'genres' => ['Action', 'Sci-Fi'], 'author' => 'Reki Kawahara', 'chapters' => 140, 'volumes' => 27],
            ['type' => 'light_novel', 'title' => 'Mushoku Tensei', 'release_year' => 2014, 'rating' => 8.4,
             'genres' => ['Fantasy', 'Isekai'], 'author' => 'Rifujin na Magonote', 'chapters' => 290, 'volumes' => 26],
        ];

        foreach ($catalog as $data) {
            Media::create($data);
        }

        // Dari $user = new User("habibi", ...) + koleksi awalnya [media_id => progress]
        $habibi = User::create(['username' => 'habibi', 'email' => 'habibi@flipplay.id']);
        $habibi->collection()->attach([
            1  => ['progress' => 28],
            5  => ['progress' => 7],
            8  => ['progress' => 120],
            10 => ['progress' => 0],
        ]);

        // Pengguna kedua (koleksi kosong) untuk pengujian
        User::create(['username' => 'iqbal', 'email' => 'iqbal@flipplay.id']);
    }
}
