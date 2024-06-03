<?php
use App\Feature\CityMaster\Controllers\CityMasterController;
use Illuminate\Support\Facades\Route;



Route::middleware(['jwt.auth'])->group(function () {

   Route::get('/Alldata', [CityMasterController::class, 'getalldata']);
  
   Route::get('/states', [CityMasterController::class, 'fetchAllStates']);
    Route::get('/districts/{state?}', [CityMasterController::class, 'fetchDistricts']);

    Route::get('/talukas/{district?}', [CityMasterController::class, 'fetchTalukas']);
    
    Route::get('/postnames/{taluka?}', [CityMasterController::class, 'fetchPostnames']);
    
    Route::get('/pincodes/{postname?}', [CityMasterController::class, 'fetchPincodes']);

    Route::post('/saveform', [CityMasterController::class, 'storeform']);

    


    Route::post('/', [CityMasterController::class, 'store']);
    Route::get('/{id}', [CityMasterController::class, 'show']);
    Route::get('/', [CityMasterController::class, 'index']); 
    Route::get('/export', [CityMasterController::class, '']);    
    Route::put('/{id}', [CityMasterController::class, 'update']);
    Route::patch('/{id}/deactivate', [CityMasterController::class, 'deactivate']);
    Route::delete('/{id}', [CityMasterController::class, 'destroy']);  
    

});
    