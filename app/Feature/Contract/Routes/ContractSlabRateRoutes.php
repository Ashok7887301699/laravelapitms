<?php

use App\Feature\Contract\Controllers\ContractSlabRateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [ContractSlabRateController::class, 'store']);
    Route::get('/{id}', [ContractSlabRateController::class, 'show']);
    Route::get('/', [ContractSlabRateController::class, 'index']);
    Route::put('/{id}', [ContractSlabRateController::class, 'update']);
    Route::delete('/{id}', [ContractSlabRateController::class, 'destroy']);
});
