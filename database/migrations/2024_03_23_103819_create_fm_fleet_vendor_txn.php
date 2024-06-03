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
        Schema::create('fm_fleet_vendor_txn', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->unsignedBigInteger('fleet_vendor_id')->nullable();
            $table->foreign('fleet_vendor_id')->references('id')->on('vendor')->onDelete('set null');
            $table->enum('trip_type', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');
            $table->enum('trip_id', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');// id (data will come from respective tables)
            $table->string('office_depot_id')->nullable();
            $table->foreign('office_depot_id')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->float('freight_rate')->nullable();
            $table->float('trip_distance_km')->nullable();
            $table->float('trip_duration_hrs')->nullable();
            $table->enum('txn_details', ['freight_charges', 'topay_coll', 'BAL_RECOVERY', 'BAL_PAY_TP', 'NONE'])->default('NONE');
            $table->string('txn_remark', 128)->nullable();
            $table->float('txn_amount')->nullable();
            $table->string('bal_recovery_txn_id', 24)->nullable();
            $table->string('txn_proof_url', 255)->nullable();
            $table->dateTime('expense_datetime')->nullable();
            $table->boolean('voucher_issued')->nullable();
           
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_fleet_vendor_txn');
    }
};
