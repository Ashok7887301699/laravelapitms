<?php
use App\Feature\Contract\Controllers\DoordeliverController;
use Illuminate\Support\Facades\Route;
Route::middleware(['jwt.auth'])->group(function () {
Route::post('/', [DoordeliverController::class, 'insert']);
Route::get('/', [DoordeliverController::class, 'index']);
Route::get('/{contract_id}', [DoordeliverController::class, 'getbyid']);
Route::put('/{contract_id}', [DoordeliverController::class, 'update']);
Route::delete('/{id}', [DoordeliverController::class, 'destroy']);
// Add other routes as needed
});