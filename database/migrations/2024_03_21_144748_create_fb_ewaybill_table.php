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
        Schema::create('fb_ewaybill', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->string('lr_id', 24)->nullable();
            $table->foreign('lr_id')->references('id')->on('fb_lr')->onDelete('set null');
            $table->string('ewb_num',16)->nullable();
            $table->dateTime('ewb_datetime')->nullable();
            $table->string('ewb_by_gst_num',20)->nullable();
            $table->string('doc_num',32)->nullable();
            $table->dateTime('doc_date')->nullable();
            $table->float('goods_value')->nullable();

            $table->string('from_pincode',8)->nullable();
            $table->string('from_place',32)->nullable();
            $table->string('from_state',8)->nullable();//this is a 2 digit number assigned to a state
            $table->string('to_pincode',8)->nullable();
            $table->string('to_place',32)->nullable();
            $table->string('to_state',32)->nullable();//this is a 2 digit number assigned to a state
            $table->float('distance')->nullable();
            $table->string('last_location',32)->nullable();
            $table->string('last_vehicle_num',16)->nullable();
            $table->dateTime('valid_till')->nullable();
            $table->smallInteger('num_of_times_extended')->nullable();
            $table->dateTime('consignment_out_for_delivery_on')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fb_ewaybill');
    }
};
