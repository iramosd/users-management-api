<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Resources\MeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return new MeResource($request->user());
});

    Route::middleware(['auth:sanctum'])->apiResource('/users', UserController::class);
