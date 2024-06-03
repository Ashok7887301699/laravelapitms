<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateVendorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor', function (Blueprint $table) {
            $table->id();
            $table->string('VendorCode')->nullable(); // Provide a default value
            $table->string('VendorName')->nullable();
            $table->string('Type')->nullable();
            $table->string('Address')->nullable();
            $table->string('City')->nullable();
            $table->string('Depot')->nullable();
            $table->string('Vehicle')->nullable();
            $table->string('Pincode')->nullable();
            $table->string('Mobile_No')->nullable();
            $table->string('Email')->nullable();
            $table->string('PAN_No')->nullable();
            $table->string('GSTNO')->nullable();
            $table->string('BankName')->nullable();
            $table->string('AccountNO')->nullable();
            $table->string('IFSC')->nullable();
            $table->string('Category')->nullable();
            $table->string('U_Location')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
    
        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor');
    }
};
