<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFmDrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fm_drs', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->dateTime('dated')->nullable();
            $table->string('del_depot', 16)->nullable();
            $table->foreign('del_depot')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->unsignedBigInteger('fleet_vendor_id')->nullable();
            $table->foreign('fleet_vendor_id')->references('id')->on('vendor')->onDelete('set null');
            $table->string('vehicle_model_by_capacity', 32)->nullable();
            $table->string('vehicle_num', 16);
            $table->float('trip_distance_km_est')->nullable();
            $table->float('freight_charges')->nullable();
            $table->integer('vehicle_meter_reading_trip_start')->nullable();
            $table->integer('vehicle_meter_reading_trip_end')->nullable();
            $table->unsignedBigInteger('driver_vendor_id')->nullable();
            $table->foreign('driver_vendor_id')->references('id')->on('drivers')->onDelete('set null');
            $table->string('driver_name', 32);
            $table->string('driver_mobile', 16);
            $table->string('dl_num', 24);
            $table->dateTime('dl_expiry_datetime')->nullable(); 
            $table->integer('num_of_lrs')->nullable();
            $table->string('consolidated_ewb_num', 16)->nullable();
            $table->dateTime('trip_start_date')->nullable();
            $table->dateTime('trip_end_date')->nullable();
            $table->enum('status', ['status_value_1', 'status_value_2', 'NONE'])->default('NONE');
            $table->enum('cancellation_reason', ['reason_value_1', 'reason_value_2', 'reason_value_3', 'NONE'])->default('NONE');
            $table->dateTime('pod_datetime')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('pod_received_by')->nullable();
            $table->foreign('pod_received_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
   
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fm_drs');
    }
}
