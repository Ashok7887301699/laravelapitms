<?php

use App\Feature\GroupMaster\Controllers\GroupMasterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [GroupMasterController::class, 'store']);
    Route::get('/{id}', [GroupMasterController::class, 'show']);
    Route::get('/', [GroupMasterController::class, 'index']);
    Route::put('/{id}', [GroupMasterController::class, 'update']);
    Route::patch('/{id}/deactivate', [GroupMasterController::class, 'deactivate']);
    Route::delete('/{id}', [GroupMasterController::class, 'destroy']);
});
