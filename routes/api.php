<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TDSController;

// Public routes
Route::prefix('tds')->group(function () {
    Route::post('/', [TDSController::class, 'store']); 
});

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('tds')->group(function () {
        Route::get('/current', [TDSController::class, 'current']);
        Route::get('/history', [TDSController::class, 'history']);
    });
});
