<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::controller(RegisteredUserController::class)->group(function () {
        Route::post('/register', 'store');
    });

    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::post('/login', 'store');
        Route::post('/logout', 'destroy')->middleware(['auth:sanctum']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    Route::get('/menus/discounted', [MenuController::class, 'discountedMenus']);
    Route::get('/menus/drinks', [MenuController::class, 'drinkMenus']);
    Route::apiResource('menus', MenuController::class);
    Route::apiResource('orders', OrderController::class);

    Route::apiResource('profile', ProfileController::class)->only(['index']);
});
