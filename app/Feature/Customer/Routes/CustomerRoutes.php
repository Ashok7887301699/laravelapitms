<?php

namespace App\Feature\Customer\Routes;

use Illuminate\Support\Facades\Route;
use App\Feature\Customer\Controllers\CustomerController;

 Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/name', [CustomerController::class, 'fetchindtype']);
    Route::get('/fetchdeponame', [CustomerController::class, 'fetchdeponame']);
    Route::get('/groupcode', [CustomerController::class, 'fetchgroupcode']);
    Route::get('/existing_cust_code', [CustomerController::class, 'getExistingCustomerCodes']);
    Route::get('/PAN', [CustomerController::class, 'checkPANExists']);

    Route::post('/', [CustomerController::class, 'store']);
    Route::get('/{sap_cust_code}', [CustomerController::class, 'show']);
    Route::get('/', [CustomerController::class, 'index']);
    Route::put('/{sap_cust_code}', [CustomerController::class, 'update']);
    Route::patch('/{sap_cust_code}/deactivate', [CustomerController::class, 'deactivate']);
    Route::delete('/{sap_cust_code}', [CustomerController::class, 'destroy']);
    Route::get('/branches/{sap_depot_name}', [CustomerController::class, 'getBranchCodeBySapDepotName']);




 });


// Route::middleware('customers')->group(function () {
//     // Define your customer routes here
//     Route::post('/', [CustomerController::class, 'store']); // For creating a tenant
//     Route::get('/{id}', [CustomerController::class, 'show']);
//     Route::get('/', [CustomerController::class, 'index']);
//     Route::put('/{id}', [CustomerController::class, 'update']);
//     Route::patch('/{id}/deactivate', [CustomerController::class, 'deactivate']);
//     Route::delete('/{id}', [CustomerController::class, 'destroy']);
// });
