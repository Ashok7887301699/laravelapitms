<?php

use App\Feature\User\Controllers\RoleController;
use App\Feature\User\Controllers\PrivilegeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    // Add the privilege route here
    Route::get('/names', [RoleController::class,'getAllRoleNames']);
    Route::get('/privileges', [PrivilegeController::class, 'getPrivileges']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::get('/', [RoleController::class, 'index']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::patch('/{id}/deactivate', [RoleController::class, 'deactivate']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);


});
