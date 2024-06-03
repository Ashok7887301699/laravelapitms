<?php

use App\Feature\Vendor\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [VendorController::class, 'store']); // For creating a packagetype
    Route::get('/{id}', [VendorController::class, 'show']);
    Route::get('/', [VendorController::class, 'index']);
    Route::put('/{id}', [VendorController::class, 'update']);
    Route::patch('/{id}/deactivate', [VendorController::class, 'deactivate']);
    Route::delete('/{id}', [VendorController::class, 'destroy']);
    Route::post('/vendors/import-excel', [VendorController::class, 'importExcel']);
});
