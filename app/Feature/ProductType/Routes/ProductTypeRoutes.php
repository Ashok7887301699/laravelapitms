<?php

use App\Feature\ProductType\Controllers\ProductTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [ProductTypeController::class, 'store']); // For creating a tenant
    Route::get('/{id}', [ProductTypeController::class, 'show']);
    Route::get('/', [ProductTypeController::class, 'index']);
    Route::put('/{id}', [ProductTypeController::class, 'update']);
    Route::patch('/{id}/deactivate', [ProductTypeController::class, 'deactivate']);
    Route::delete('/{id}', [ProductTypeController::class, 'destroy']);
});
