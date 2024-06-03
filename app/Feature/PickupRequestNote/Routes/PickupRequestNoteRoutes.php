<?php

use App\Feature\PickupRequestNote\Controllers\PickupRequestNoteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
  
      Route::get('/Hname', [PickupRequestNoteController::class, 'fetchHVendor']);
    
      Route::get('/lrNumbers', [PickupRequestNoteController::class, 'fetchLRNumbers']);
      
    Route::post('/', [PickupRequestNoteController::class, 'store']); // For creating a pickup request note
  Route::get('/{id}', [PickupRequestNoteController::class, 'show'])->where('id', 'PR/PNA/\d{4}/\d{6}');
    Route::get('/', [PickupRequestNoteController::class, 'index']);
    Route::put('/{id}', [PickupRequestNoteController::class, 'update']);
    Route::patch('/{id}/deactivate', [PickupRequestNoteController::class, 'deactivate']);
    Route::delete('/{id}', [PickupRequestNoteController::class, 'destroy']);

    Route::get('/data/{query}', [PickupRequestNoteController::class, 'selectcust']);
    Route::get('/vehicledata/{query}', [PickupRequestNoteController::class, 'selectvehicle']); 

    Route::get('/bydate', [PickupRequestNoteController::class, 'searchByDate']); // Route for searching by date
    
     
   Route::get('/byprn/{id}', [PickupRequestNoteController::class, 'searchByPRN'])->where('id', 'PR/PNA/\d{4}/\d{6}');

      Route::get('/prnarrival/{id}', [PickupRequestNoteController::class, 'searchprnarrival'])->where('id', 'PR/PNA/\d{4}/\d{6}');


   

});