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
        Schema::create('fm_ls', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->dateTime('dated')->nullable();
            $table->string('del_depot', 16)->nullable();
            $table->foreign('del_depot')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->string('from_depot', 16)->nullable();
            $table->foreign('from_depot')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->string('to_depot', 16)->nullable();
            $table->foreign('to_depot')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->float('total_topay')->nullable();
            $table->float('freight_charges')->nullable();
            $table->float('total_box_qty')->nullable();
            $table->float('actual_box_weight')->nullable();
            $table->float('total_bag_qty')->nullable();
            $table->float('actual_bag_weight')->nullable();
            $table->float('total_weight')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('cancel_by')->nullable();
            $table->foreign('cancel_by')->references('id')->on('users')->onDelete('set null');
            $table->string('cancellation_reason',136)->nullable();

            $table->string('status', 32)->nullable();
            
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_ls');
    }
};
