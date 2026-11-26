<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCollectionRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Http\Resources\CollectionItemResource;
use App\Models\Media;
use App\Models\User;

class CollectionController extends Controller
{
    // GET /api/users/{user}/collection  -> menu 5: getCollection()
    public function index(User $user)
    {
        return CollectionItemResource::collection($user->collection);
    }

    // POST /api/users/{user}/collection  -> menu 5a: addToCollection()
    public function store(AddToCollectionRequest $request, User $user)
    {
        $media = Media::findOrFail($request->validated('media_id'));

        if ($user->hasInCollection($media)) {
            return response()->json([
                'message' => "\"{$media->title}\" sudah ada di koleksi {$user->username}",
            ], 409);
        }

        $user->collection()->attach($media->id, ['progress' => 0]);

        return (new CollectionItemResource($user->findInCollection($media)))
            ->additional(['message' => "\"{$media->title}\" masuk ke koleksi {$user->username}"])
            ->response()
            ->setStatusCode(201);
    }

    // PATCH /api/users/{user}/collection/{media}  -> menu 5b: updateProgress()
    public function update(UpdateProgressRequest $request, User $user, Media $media)
    {
        if (! $user->hasInCollection($media)) {
            return response()->json([
                'message' => "\"{$media->title}\" belum ada di koleksi {$user->username}",
            ], 404);
        }

        $user->collection()->updateExistingPivot($media->id, [
            'progress' => $request->validated('progress'),
        ]);

        return (new CollectionItemResource($user->findInCollection($media)))
            ->additional(['message' => "Progres \"{$media->title}\" diperbarui"]);
    }

    // DELETE /api/users/{user}/collection/{media}  -> removeFromCollection()
    public function destroy(User $user, Media $media)
    {
        if (! $user->hasInCollection($media)) {
            return response()->json([
                'message' => "\"{$media->title}\" belum ada di koleksi {$user->username}",
            ], 404);
        }

        $user->collection()->detach($media->id);

        return response()->json([
            'message' => "\"{$media->title}\" dihapus dari koleksi {$user->username}",
        ]);
    }
}
