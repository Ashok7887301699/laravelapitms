<?php

use App\Feature\UserBranch\Controllers\UserBranchController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [UserBranchController::class, 'store']);
    Route::get('/{user_id}', [UserBranchController::class, 'show']);
    Route::get('/', [UserBranchController::class, 'index']);
    Route::put('/{user_id}', [UserBranchController::class, 'update']);
    Route::patch('/{user_id}/deactivate', [UserBranchController::class, 'deactivate']);
    Route::delete('/{user_id}', [UserBranchController::class, 'destroy']);
});
