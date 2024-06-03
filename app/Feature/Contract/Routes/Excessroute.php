<?php

use App\Feature\Contract\Controllers\ExcessController;
use Illuminate\Support\Facades\Route;
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [Excesscontroller::class, 'insert']);
    Route::get('/', [Excesscontroller::class, 'index']);
    Route::get('/{contract_id}', [Excesscontroller::class, 'getbyid']);
    Route::put('/{id}', [Excesscontroller::class, 'update']);
    Route::delete('/{id}', [Excesscontroller::class, 'destroy']);
    // Add other routes as needed
});
