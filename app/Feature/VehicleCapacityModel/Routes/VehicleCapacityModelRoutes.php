<?php

use App\Feature\VehicleCapacityModel\Controllers\VehicleCapacityModelController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [VehicleCapacityModelController::class, 'store']);
    Route::get('/{id}', [VehicleCapacityModelController::class, 'show']);
    Route::get('/', [VehicleCapacityModelController::class, 'index']);
    Route::put('/{id}', [VehicleCapacityModelController::class, 'update']);
    Route::patch('/{id}/deactivate', [VehicleCapacityModelController::class, 'deactivate']);
    Route::delete('/{id}', [VehicleCapacityModelController::class, 'destroy']);
});
