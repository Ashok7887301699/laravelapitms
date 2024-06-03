<?php

use App\Feature\Hamali\Controllers\HamaliController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [HamaliController::class, 'store']); // For creating a packagetype
    Route::get('/{id}', [HamaliController::class, 'show']);
    Route::get('/', [HamaliController::class, 'index']);
    Route::put('/{id}', [HamaliController::class, 'update']);
    Route::patch('/{id}/deactivate', [HamaliController::class, 'deactivate']);
    Route::delete('/{id}', [HamaliController::class, 'destroy']);
});
