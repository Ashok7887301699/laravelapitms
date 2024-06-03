<?php

use App\Feature\VendorFuel\Controllers\VendorFuelController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [VendorFuelController::class, 'store']); // For creating a packagetype
    Route::get('/{id}', [VendorFuelController::class, 'show']);
    Route::get('/', [VendorFuelController::class, 'index']);
    Route::put('/{id}', [VendorFuelController::class, 'update']);
    Route::patch('/{id}/deactivate', [VendorFuelController::class, 'deactivate']);
    Route::delete('/{id}', [VendorFuelController::class, 'destroy']);
});
