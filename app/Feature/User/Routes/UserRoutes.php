<?php

use App\Feature\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Feature\Branch\Controllers\BranchController;

Route::middleware(['jwt.auth'])->group(function () {
    // Route::get('/fetchdeponame', [UserController::class, 'fetchdeponame']);
    Route::get('/branchcodes', [BranchController::class, 'getBrancodes']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/profilephoto/{id}', [UserController::class, 'getProfilephoto']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::patch('/{id}/deactivate', [UserController::class, 'deactivate']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});
