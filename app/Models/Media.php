<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    protected $table = 'media';

    public const TYPES = ['anime', 'drama', 'manga', 'light_novel'];

    protected $fillable = [
        'title', 'type', 'release_year', 'rating', 'genres',
        'episodes', 'minutes_per_episode', 'studio', 'country',
        'author', 'chapters', 'is_ongoing', 'volumes',
    ];

    protected function casts(): array
    {
        return [
            'genres'     => 'array',
            'rating'     => 'float',
            'is_ongoing' => 'boolean',
        ];
    }

    // Default dari constructor Anime (24 menit) dan Drama (60 menit)
    protected static function booted(): void
    {
        static::saving(function (Media $media) {
            if ($media->isVideo() && empty($media->minutes_per_episode)) {
                $media->minutes_per_episode = $media->type === 'anime' ? 24 : 60;
            }
        });
    }

    // RELASI many-to-many: pengguna yang mengoleksi media ini
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'collections')
            ->withPivot('progress')
            ->withTimestamps();
    }

    // ===== Method yang dipindahkan dari Modul 3 =====

    public function isVideo(): bool
    {
        return in_array($this->type, ['anime', 'drama'], true);
    }

    // Media::getType()
    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'anime'       => 'Anime',
            'drama'       => 'Drama',
            'manga'       => 'Manga',
            'light_novel' => 'Light Novel',
            default       => (string) $this->type,
        };
    }

    // VideoMedia::getTotalUnits() / ReadingMedia::getTotalUnits()
    public function getTotalUnits(): int
    {
        return (int) ($this->isVideo() ? $this->episodes : $this->chapters);
    }

    // getUnitLabel()
    public function getUnitLabel(): string
    {
        return $this->isVideo() ? 'episode' : 'chapter';
    }

    // getActionVerb()
    public function getActionVerb(): string
    {
        return $this->isVideo() ? 'Tonton' : 'Baca';
    }

    // VideoMedia::getTotalDurationHours()
    public function getTotalDurationHours(): ?float
    {
        if (! $this->isVideo()) {
            return null;
        }

        return round(($this->episodes * $this->minutes_per_episode) / 60, 1);
    }
}
