<?php

namespace App\Feature\Vehicle\Routes;

use App\Feature\Vehicle\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

 Route::middleware(['jwt.auth'])->group(function () {

    Route::get('/vehcpctmodel', [VehicleController::class, 'fetchAllvehcpctmodel']);
    Route::get('/vehiclecpct', [VehicleController::class, 'fetchVehiclecpct']);


    Route::post('/', [VehicleController::class, 'store']);
    Route::get('/{SrNo}', [VehicleController::class, 'show']);
   Route::get('/', [VehicleController::class, 'index']);
    Route::put('/{SrNo}', [VehicleController::class, 'update']);
    Route::patch('/{SrNo}/deactivate', [VehicleController::class, 'deactivate']);
    Route::delete('/{SrNo}', [VehicleController::class, 'destroy']);




 });
