<?php
use App\Feature\Contract\Controllers\Oda_charge_controller;
use Illuminate\Support\Facades\Route;
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [Oda_charge_controller::class, 'store']);
    Route::get('/', [Oda_charge_controller::class, 'index']);
    Route::get('/{id}', [Oda_charge_controller::class, 'getbyid']);
    Route::put('/{id}', [Oda_charge_controller::class, 'update']);
    Route::delete('/{id}', [Oda_charge_controller::class, 'destroy']);
    // Add other routes as needed
});
