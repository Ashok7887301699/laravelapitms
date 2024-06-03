<?php

use App\Feature\User\Controllers\PrivilegeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [PrivilegeController::class, 'store']);
    Route::get('/{id}', [PrivilegeController::class, 'show']);
    Route::get('/', [PrivilegeController::class, 'index']);
    Route::put('/{id}', [PrivilegeController::class, 'update']);
    Route::patch('/{id}/deactivate', [PrivilegeController::class, 'deactivate']);
    Route::delete('/{id}', [PrivilegeController::class, 'destroy']);
});
