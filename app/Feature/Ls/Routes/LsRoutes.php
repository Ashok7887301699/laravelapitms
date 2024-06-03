<?php

use App\Feature\Ls\Controllers\LsController;
use Illuminate\Support\Facades\Route;
use App\Feature\Customer\Controllers\CustomerController;


Route::middleware(['jwt.auth'])->group(function () {

    Route::get('lrdata/{query}', [LsController::class, 'getlrdata']);
    Route::get('lrdetails/{query}', [LsController::class, 'getLrDetailsById']);
    Route::get('/fetchdeponame', [CustomerController::class, 'fetchdeponame']);

    Route::post('/', [LsController::class, 'store']); // For creating a packagetype
    Route::get('/{id}', [LsController::class, 'show']);
    Route::get('/', [LsController::class, 'index']);
    Route::put('/{id}', [LsController::class, 'update']);
    Route::patch('/{id}/deactivate', [LsController::class, 'deactivate']);
    Route::delete('/{id}', [LsController::class, 'destroy']);



});
