<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TDSController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // TDS Data API
    Route::prefix('tds')->group(function () {
        Route::post('/', [TDSController::class, 'store']);
        Route::get('/current', [TDSController::class, 'current']);
        Route::get('/history', [TDSController::class, 'history']);
    });
});
