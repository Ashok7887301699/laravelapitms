<?php

use App\Feature\IndustryType\Controllers\IndustryTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [IndustryTypeController::class, 'store']);
    Route::get('/{id}', [IndustryTypeController::class, 'show']);
    Route::get('/', [IndustryTypeController::class, 'index']);
    Route::put('/{id}', [IndustryTypeController::class, 'update']);
    Route::patch('/{id}/deactivate', [IndustryTypeController::class, 'deactivate']);
    Route::delete('/{id}', [IndustryTypeController::class, 'destroy']);
});
