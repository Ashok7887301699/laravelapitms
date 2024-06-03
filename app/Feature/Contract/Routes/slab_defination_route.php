<?php

use App\Feature\Contract\Controllers\slab_definitions_controller;
use Illuminate\Support\Facades\Route;
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/', [slab_definitions_controller::class, 'insert']);
    Route::get('/', [slab_definitions_controller::class, 'index']);
    Route::get('/{id}', [slab_definitions_controller::class, 'show']);
    Route::put('/{id}', [slab_definitions_controller::class, 'update']);
    Route::delete('/{id}', [slab_definitions_controller::class, 'destroy']);
    // Add other routes as needed
});
