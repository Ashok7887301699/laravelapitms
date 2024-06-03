<?php


use App\Feature\Drs\Controllers\DrsController;
use Illuminate\Support\Facades\Route;


Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/savedrs', [DrsController::class, 'store']); 
    // Route::get('/{id}', [DrsController::class, 'show']);
    // Route::get('/', [DrsController::class, 'index']);
    // Route::put('/{id}', [DrsController::class, 'update']);
    // Route::patch('/{id}/deactivate', [DrsController::class, 'deactivate']);
    // Route::delete('/{id}', [DrsController::class, 'destroy']);
    Route::get('/vendors/attached', [DrsController::class, 'getAttachedVendors']);
    Route::get('/vendornames', [DrsController::class, 'show']);
    Route::get('/hamali', [DrsController::class, 'gethamali']);
    Route::get('/fuel', [DrsController::class, 'getfuelname']);
    Route::get('/vehiclenumbers/{vendorName}', [DrsController::class, 'getVehicleNos']);
    Route::get('/data/drivernames', [DrsController::class, 'getdata']);
    Route::get('datacm/capacity', [DrsController::class, 'getcapacity']);
    Route::get('lsdata/{query}', [DrsController::class, 'getlsdata']);
    Route::get('custom-ls/{query}', [DrsController::class, 'fetchByNumber']);
    
    Route::get('/drsnoautoco/{query}', [DrsController::class, 'autocomplete']);
    Route::get('/fetch-drs-data/{id}', [DrsController::class, 'getdrsdata'])->where('id', '.*');

});
