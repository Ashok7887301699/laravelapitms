<?php

use App\Feature\DriverMaster\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/driverphoto/{id}', [DriverController::class, 'getDriverPhoto']);
    Route::get('/pancard/{id}', [DriverController::class, 'getPanCard']);
    Route::get('/voterid/{id}', [DriverController::class, 'getVoterId']);
    Route::get('/adharcard/{id}', [DriverController::class, 'getAadharCard']);
    Route::get('/License/{id}', [DriverController::class, 'getLicense']);

    Route::post('/', [DriverController::class, 'store']);
    Route::get('/{id}', [DriverController::class, 'show']);
    Route::get('/', [DriverController::class, 'index']);
    Route::put('/{id}', [DriverController::class, 'update']);
    Route::patch('/{id}/deactivate', [DriverController::class, 'deactivate']);
    Route::delete('/{id}', [DriverController::class, 'destroy']);
});
