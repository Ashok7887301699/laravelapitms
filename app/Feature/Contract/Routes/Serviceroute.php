<?php
use App\Feature\Contract\Controllers\Servicecontroller;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [Servicecontroller::class, 'store']);
    Route::get('/', [Servicecontroller::class, 'index']);
    Route::get('/{contract_id}', [Servicecontroller::class, 'show']);
    Route::put('/{contract_id}', [Servicecontroller::class, 'update']);
    Route::delete('/{id}', [Servicecontroller::class, 'destroy']);
    // Add other routes as needed
});
