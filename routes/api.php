<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticatedSessionController::class)->prefix('/auth')->group(function () {
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->middleware(['auth:sanctum']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('menus', MenuController::class);
});
