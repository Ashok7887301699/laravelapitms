<?php

use App\Feature\Tenant\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [TenantController::class, 'store']); // For creating a tenant
    Route::get('/{id}', [TenantController::class, 'show']);
    Route::get('/', [TenantController::class, 'index']);
    Route::put('/{id}', [TenantController::class, 'update']);
    Route::patch('/{id}/deactivate', [TenantController::class, 'deactivate']);
    Route::delete('/{id}', [TenantController::class, 'destroy']);
});