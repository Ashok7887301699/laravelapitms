<?php


use App\Feature\Expenses\Controllers\InRouteExpensesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/{id}', [InRouteExpensesController::class, 'show']);
    Route::post('/', [InRouteExpensesController::class, 'store']);
    Route::get('/', [InRouteExpensesController::class, 'index']);
    Route::put('/{id}', [InRouteExpensesController::class, 'update']);
    Route::patch('/{id}/deactivate', [InRouteExpensesController::class, 'deactivate']);
    Route::delete('/{id}', [InRouteExpensesController::class, 'destroy']);
});
