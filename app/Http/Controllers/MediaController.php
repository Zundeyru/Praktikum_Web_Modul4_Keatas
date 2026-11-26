<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // GET /api/media  -> menu 2 & 3 (search, filter type, top rating)
    public function index(Request $request)
    {
        $media = Media::query()
            ->when($request->filled('search'), fn ($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when(
                $request->input('sort') === 'top',
                fn ($q) => $q->orderByDesc('rating'),
                fn ($q) => $q->orderBy('id')
            )
            ->when($request->filled('limit'), fn ($q) => $q->limit((int) $request->limit))
            ->get();

        return MediaResource::collection($media);
    }

    // POST /api/media  -> menu 1
    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))
            ->additional(['message' => "{$media->getTypeLabel()} \"{$media->title}\" ditambahkan"])
            ->response()
            ->setStatusCode(201);
    }

    // GET /api/media/{media}  -> menu 4 + daftar pengguna yang mengoleksi
    public function show(Media $media)
    {
        return new MediaResource($media->load('users'));
    }

    // PATCH /api/media/{media}
    public function update(UpdateMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return (new MediaResource($media))
            ->additional(['message' => 'Media berhasil diperbarui']);
    }

    // DELETE /api/media/{media}
    public function destroy(Media $media)
    {
        $media->delete();

        return response()->json(['message' => "\"{$media->title}\" berhasil dihapus dari library"]);
    }
}
