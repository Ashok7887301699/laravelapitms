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
        Schema::create('fm_fuel_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->unsignedBigInteger('fuel_vendor_id')->nullable();
            $table->foreign('fuel_vendor_id')->references('id')->on('vendorfuel')->onDelete('set null');
            $table->enum('trip_type', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');
            $table->enum('trip_id', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');// id (data will come from respective tables)
            $table->string('office_depot_id')->nullable();
            $table->foreign('office_depot_id')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->string('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('Vehicle_No')->on('vehicles')->onDelete('cascade');

            $table->string('vehicle_num', 16)->nullable();
            $table->string('vehicle_meter_reading', 16)->nullable();
            $table->enum('fuel_type', ['Diesel', 'CNG', 'Petrol', 'NONE'])->default('NONE');
            $table->float('fuel_quantity')->nullable();
            $table->float('fuel_rate')->nullable();
            $table->float('fuel_amount')->nullable();
            $table->string('fuel_bill_url', 255)->nullable();

            $table->dateTime('expense_datetime')->nullable();
            $table->boolean('expense_booked_in_tp')->nullable();
            $table->string('payment_txn_id_from_tp', 24)->nullable();
            $table->dateTime('payment_datetime_from_tp')->nullable();
           
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_fuel_log');
    }
};
