<?php

use App\Feature\India\Controllers\IndiaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [IndiaController::class, 'store']); // For creating a india
    Route::get('/{id}', [IndiaController::class, 'show']);
    Route::get('/', [IndiaController::class, 'index']);
    Route::put('/{id}', [IndiaController::class, 'update']);
    Route::patch('/{id}/deactivate', [IndiaController::class, 'deactivate']);
    Route::delete('/{id}', [IndiaController::class, 'destroy']);
});