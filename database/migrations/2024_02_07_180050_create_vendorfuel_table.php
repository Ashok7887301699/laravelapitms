<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorFuelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendorfuel', function (Blueprint $table) {
            $table->id();
            $table->string('PetrolPumpName');
            $table->string('Vendorname');
            $table->string('DVendorCode');
            $table->string('Depot');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendorfuel');
    }
};
