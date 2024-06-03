<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contract_services', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id'); // Changed to string type
            $table->foreign('contract_id')->references('contract_id')->on('contracts')->onDelete('cascade'); // Changed to string type
            $table->string('load_type');
            $table->string('rate_type');
            $table->string('slab_contract_type');
            $table->enum('matrices_type', ['City-City', 'City-District', 'City-Taluka', 'City-Pincode']);
            $table->string('pickup_delivery_mode');
            $table->float('doc_charges', 8, 2);
            $table->boolean('excess_weight_chargeable');
            $table->boolean('door_delivery_chargeable');
            $table->integer('insurance_chargeable');
            $table->integer('minimum_excess');
            $table->timestamps();

            // Index
            $table->index('contract_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_services');
    }
};
