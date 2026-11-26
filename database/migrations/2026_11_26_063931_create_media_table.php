<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Database tidak punya inheritance, jadi Anime/Drama/Manga/LightNovel
        // digabung dalam satu tabel. Pembedanya kolom "type".
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // Dari Media.php
            $table->string('title');
            $table->string('type'); // anime | drama | manga | light_novel
            $table->unsignedSmallInteger('release_year');
            $table->decimal('rating', 3, 1)->default(0);
            $table->json('genres')->nullable();

            // Dari VideoMedia.php, Anime.php, Drama.php
            $table->unsignedInteger('episodes')->nullable();
            $table->unsignedSmallInteger('minutes_per_episode')->nullable();
            $table->string('studio')->nullable();
            $table->string('country')->nullable();

            // Dari ReadingMedia.php, Manga.php, LightNovel.php
            $table->string('author')->nullable();
            $table->unsignedInteger('chapters')->nullable();
            $table->boolean('is_ongoing')->nullable();
            $table->unsignedSmallInteger('volumes')->nullable();

            $table->timestamps();

            // Dari MediaLibrary::addMedia(): judul + jenis tidak boleh dobel
            $table->unique(['title', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
