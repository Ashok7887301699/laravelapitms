<?php

namespace App\Feature\Lr\Routes;
use App\Feature\Lr\Controllers\LrController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/selectcont/{consignor_id}', [LrController::class, 'selectcont']);
    Route::get('/selectcontslabrate/{consignor_id}', [LrController::class, 'selectcontslabrate']);
    Route::get('/selectContractSlabDefinition/{contractId}/{Invoicenoofpkg}', [LrController::class, 'selectContractSlabDefinition']); 
    Route::get('/selectContractSlabrate/{consignor_id}', [LrController::class, 'selectContractSlabrate']);

    

    Route::get('/PickDel/{consignor_id}', [LrController::class, 'fetchPickDel']);
    // Route::get('/ratetype/{consignor_id}', [LrController::class, 'fetchratetype']);
    
    Route::post('/', [LrController::class, 'store']);
    Route::get('/lrdata/{customLrNum}', [LrController::class, 'getLrData']);
    Route::get('/fblrdata/{customLrNum}', [LrController::class, 'fblrdata']);
    
    //Route::post('/', [LrController::class, 'store']); 
    // Route::get('/{id}', [LrController::class, 'show']);
    Route::get('/', [LrController::class, 'index']);
    Route::put('/{id}', [LrController::class, 'update']);
    Route::patch('/{id}/deactivate', [LrController::class, 'deactivate']);
    Route::delete('/{id}', [LrController::class, 'destroy']);
    Route::get('/paymodel', [LrController::class, 'show']);
    Route::get('/data/{query}/{paytype}', [LrController::class, 'selectcust']);
    Route::get('/datacity/{query}', [LrController::class, 'selectfromcity']); 
    Route::get('/datatocity/{query}', [LrController::class, 'selecttocity']);
    
    Route::get('/packagetype/getdata', [LrController::class, 'getdata']);
    Route::get('/producttype/getpro', [LrController::class, 'getpro']);

    
    
    
    
});
