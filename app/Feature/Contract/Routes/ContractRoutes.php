<?php

use App\Feature\Contract\Controllers\ContractController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [ContractController::class, 'store']);
    Route::get('/{contract_id}', [ContractController::class, 'show']);
    Route::get('/', [ContractController::class, 'index']);
    Route::put('/{selectedContractId}', [ContractController::class, 'update']);
    Route::patch('/{contract_id}/deactivate', [ContractController::class, 'deactivate']);
    Route::delete('/{id}', [ContractController::class, 'destroy']);
    Route::get('/data/{query}', [ContractController::class, 'selectcust']);
    Route::get('/fetchbySapCustCode/{data}', [ContractController::class, 'fetchDataBySapCustCode']);
});
