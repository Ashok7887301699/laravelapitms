<?php

use App\Feature\User\Controllers\RolePrivilegeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [RolePrivilegeController::class, 'store']);
    Route::get('/{role_id}', [RolePrivilegeController::class, 'show']);
    Route::get('/', [RolePrivilegeController::class, 'index']);
    Route::put('/{role_id}', [RolePrivilegeController::class, 'update']);
    Route::patch('/{role_id}/deactivate', [RolePrivilegeController::class, 'deactivate']);
    Route::delete('/{role_id}', [RolePrivilegeController::class, 'destroy']);
});
