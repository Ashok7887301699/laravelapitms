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
        Schema::create('fm_prn', function (Blueprint $table) {
            $table->string('id',24)->primary(); //this is system genrated           
             $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->string('booking_office_id', 16)->nullable();
            $table->foreign('booking_office_id')->references('BranchCode')->on('branch')->onDelete('set null');
            $table->string('pickupaddress', 255)->nullable();
            $table->string('contact_person_name', 32);
            $table->string('contact_person_mobile1', 16)->nullable();
            $table->string('contact_person_mobile2')->nullable();
            $table->dateTime('pickup_datetime')->nullable();
            $table->string('receiving_depot_id', 16)->nullable();
            $table->foreign('receiving_depot_id')->references('BranchCode')->on('branch')->onDelete('set null');
            $table->string('vehicle_model_by_capacity', 32)->nullable();
            $table->string('vehicle_num', 16);
            $table->float('trip_distance_km_est')->nullable();
            $table->float('freight_charges')->nullable();
            $table->Integer('vehicle_meter_reading_trip_start')->nullable();
            $table->Integer('vehicle_meter_reading_trip_end')->nullable();
            $table->string('driver_vendor_id', 16)->nullable();
            $table->foreign('driver_vendor_id')->references('DriverCode')->on('drivers')->onDelete('set null');
            $table->string('driver_name', 32)->nullable();
            $table->string('driver_mobile', 16)->nullable();
            $table->string('dl_num', 24)->nullable();
            $table->dateTime('dl_expiry_datetime')->nullable();          
            $table->string('consolidated_ewb_num')->nullable();
            $table->dateTime('trip_start_date')->nullable();
            $table->dateTime('trip_end_date')->nullable();
            $table->string('status')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->dateTime('cancellation_date')->nullable();
            $table->unsignedBigInteger('canceled_by')->nullable();
            $table->foreign('canceled_by')->references('id')->on('users')->onDelete('set null');
            $table->dateTime('depot_arrival_datetime')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->string('depot_received_by', 16)->nullable();
            $table->foreign('depot_received_by')->references('BranchCode')->on('branch')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_prn');
    }
};