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
        Schema::create('fm_loader_expense', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->unsignedBigInteger('loader_vendor_id')->nullable();
            $table->foreign('loader_vendor_id')->references('id')->on('hamali')->onDelete('set null');
            $table->enum('trip_type', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');
            $table->string('trip_id',16)->nullable();
            //$table->enum('trip_id', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');// id (data will come from respective tables)
            $table->enum('action', ['LOADING', 'UNLOADING', 'CROSS_LOADING', 'NONE'])->default('NONE');

            $table->string('office_depot_id')->nullable();
            $table->foreign('office_depot_id')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->float('loading_unloading_rate_1')->nullable();
            $table->integer('num_of_packages_1')->nullable();
            $table->float('loading_unloading_rate_2')->nullable();
            $table->integer('num_of_packages_2')->nullable();
            $table->float('total_labour_charges')->nullable();

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
        Schema::dropIfExists('fm_loader_expense');
    }
};