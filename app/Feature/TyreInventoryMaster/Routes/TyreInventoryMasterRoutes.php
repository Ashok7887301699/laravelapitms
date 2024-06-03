<?php

use App\Feature\TyreInventoryMaster\Controllers\TyreInventoryMasterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [TyreInventoryMasterController::class, 'store']); // For creating a packagetype
    Route::get('/{id}', [TyreInventoryMasterController::class, 'show']);
    Route::get('/', [TyreInventoryMasterController::class, 'index']);
    Route::put('/{id}', [TyreInventoryMasterController::class, 'update']);
    Route::patch('/{id}/deactivate', [TyreInventoryMasterController::class, 'deactivate']);
    Route::delete('/{id}', [TyreInventoryMasterController::class, 'destroy']);
});
