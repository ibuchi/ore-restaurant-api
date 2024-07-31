<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticatedSessionController::class)->prefix('/auth')->group(function () {
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->middleware(['auth:sanctum']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    Route::apiResource('menus', MenuController::class);
    Route::get('/menus/discounted', [MenuController::class, 'discountedMenus']);
    Route::get('/menus/drinks', [MenuController::class, 'drinkMenus']);

    Route::apiResource('profile', ProfileController::class)->only(['index']);
});
