<?php

use App\Feature\Branch\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {

    Route::get('/branchphoto/{branchCode}', [BranchController::class, 'getBranchPhoto']);
    Route::get('/shopact/{branchCode}', [BranchController::class, 'getShopAct']);
    Route::get('/codes', [BranchController::class, 'getAllBranchCodes']);
    Route::get('/names', [BranchController::class, 'getAllBranchNames']);
    Route::post('/', [BranchController::class, 'store']);
    Route::get('/{branchCode}', [BranchController::class, 'show']);
    Route::get('/', [BranchController::class, 'index']);
    Route::put('/{branchCode}', [BranchController::class, 'update']);
    Route::patch('/{branchCode}/deactivate', [BranchController::class, 'deactivate']);
    Route::delete('/{branchCode}', [BranchController::class, 'destroy']);
});