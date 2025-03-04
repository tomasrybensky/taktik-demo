<?php

use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RollerCoasterController;
use App\Http\Controllers\ThemeParkController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('manufacturers', ManufacturerController::class);
    Route::apiResource('theme-parks', ThemeParkController::class);
    Route::apiResource('roller-coasters', RollerCoasterController::class);
});

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::post('roller-coasters/{roller_coaster}/ratings', [RatingController::class, 'storeRollerCoasterRating']);
    Route::post('theme-parks/{theme_park}/ratings', [RatingController::class, 'storeThemeParkRating']);
    Route::apiResource('ratings', RatingController::class)->except(['show', 'index', 'store']);
});

Route::apiResource('manufacturers', ManufacturerController::class)->only(['index']);
Route::apiResource('theme-parks', ThemeParkController::class)->only(['index']);
Route::apiResource('roller-coasters', RollerCoasterController::class)->only(['index']);
