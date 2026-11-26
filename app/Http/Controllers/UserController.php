<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return UserResource::collection(User::withCount('collection')->get());
    }

    // GET /api/users/{user}
    public function show(User $user)
    {
        return new UserResource($user->load('collection'));
    }
}
