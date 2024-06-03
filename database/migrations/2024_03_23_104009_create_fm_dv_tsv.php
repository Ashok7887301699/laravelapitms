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
        Schema::create('fm_dv_tsv', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->unsignedBigInteger('fleet_vendor_id')->nullable();
            $table->foreign('fleet_vendor_id')->references('id')->on('vendor')->onDelete('set null');

            $table->enum('trip_type', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');//This is the column of join
            $table->enum('trip_id', ['PRN', 'THC', 'DRS', 'MANIFEST', 'NONE'])->default('NONE');// id (data will come from respective tables)
            $table->float('total_credit')->nullable();//freight_charge
            $table->float('total_debit')->nullable();//total to_pay_coll amount
            $table->float('balance')->nullable();//total_credit - total_debit

            $table->enum('state', ['TP_PAYMENT_BOOKING_PENDING', 'BAL_RECOVERY_PENDING', 'CLOSE', 'NONE'])->default('NONE');
          
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_dv_tsv');
    }
};
