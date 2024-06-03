<?php

use App\Feature\PackageType\Controllers\PackageTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [PackageTypeController::class, 'store']); // For creating a packagetype
    Route::get('/{id}', [PackageTypeController::class, 'show']);
    Route::get('/', [PackageTypeController::class, 'index']);
    Route::put('/{id}', [PackageTypeController::class, 'update']);
    Route::patch('/{id}/deactivate', [PackageTypeController::class, 'deactivate']);
    Route::delete('/{id}', [PackageTypeController::class, 'destroy']);
});
