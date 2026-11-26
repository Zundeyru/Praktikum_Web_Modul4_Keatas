<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// CRUD Media: index, store, show, update, destroy
Route::apiResource('media', MediaController::class)
    ->parameters(['media' => 'media']);

// Pengguna
Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);

// Custom action: koleksi pengguna (mengubah tabel pivot)
Route::get('users/{user}/collection', [CollectionController::class, 'index']);
Route::post('users/{user}/collection', [CollectionController::class, 'store']);
Route::patch('users/{user}/collection/{media}', [CollectionController::class, 'update']);
Route::delete('users/{user}/collection/{media}', [CollectionController::class, 'destroy']);
