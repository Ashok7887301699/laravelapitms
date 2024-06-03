<?php

use App\Feature\ContractPaymentType\Controllers\ContractPaymentTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [ContractPaymentTypeController::class, 'store']); // For creating a contractpaymenttype
    Route::get('/{id}', [ContractPaymentTypeController::class, 'show']);
    Route::get('/', [ContractPaymentTypeController::class, 'index']);
    Route::put('/{id}', [ContractPaymentTypeController::class, 'update']);
    Route::patch('/{id}/deactivate', [ContractPaymentTypeController::class, 'deactivate']);
    Route::delete('/{id}', [ContractPaymentTypeController::class, 'destroy']);
});
