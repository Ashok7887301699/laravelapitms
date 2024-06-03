<?php


use App\Feature\Branch\Controllers\BranchTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/bt', [BranchTypeController::class, 'getBranchTypes']);
    Route::get('/{id}', [BranchTypeController::class, 'show']);
    Route::post('/', [BranchTypeController::class, 'store']);
    Route::get('/', [BranchTypeController::class, 'index']);
    Route::put('/{id}', [BranchTypeController::class, 'update']);
    Route::patch('/{id}/deactivate', [BranchTypeController::class, 'deactivate']);
    Route::delete('/{id}', [BranchTypeController::class, 'destroy']);
});
