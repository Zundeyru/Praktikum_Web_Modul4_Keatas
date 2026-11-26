<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    protected $fillable = ['username', 'email'];

    // RELASI many-to-many: dulu array $collection berisi CollectionItem
    public function collection(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'collections')
            ->withPivot('progress')
            ->withTimestamps();
    }

    // User::hasInCollection()
    public function hasInCollection(Media $media): bool
    {
        return $this->collection()->where('media.id', $media->id)->exists();
    }

    // Ambil satu media dari koleksi beserta progress-nya
    public function findInCollection(Media $media): ?Media
    {
        return $this->collection()->where('media.id', $media->id)->first();
    }
}
