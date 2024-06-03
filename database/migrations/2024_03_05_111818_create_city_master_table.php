<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('CityMaster', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('CityNameEng');     
           
            $table->string('Taluka');
            $table->string('District');
            $table->string('DistrictMar')->nullable(true);
            $table->string('Postname')->nullable(true);
            $table->string('Pincode');
            $table->string('Country');
            $table->string('State');
            $table->string('CityNameMar');
            $table->string('CityNameGmap');
            $table->string('Latitude');
            $table->string('Longitude');
             $table->string('Zone');
            $table->string('RouteNo');
            $table->string('RouteSequens');         
            $table->string('DelDepot');
            
            $table->string('Tat');
             $table->string('ODA');
            $table->string('NearStateHighway');
            $table->string('NearestNationalHighway');
            $table->string('status');
            $table->string('AddUser');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CityMaster');
    }
};