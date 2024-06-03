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
        Schema::create('fb_lr_state_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->string('lr_id', 24)->nullable();
            $table->foreign('lr_id')->references('id')->on('fb_lr')->onDelete('set null');
            $table->string('status',24)->nullable();
            $table->string('consignment_location_id', 16)->nullable();
            $table->foreign('consignment_location_id')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->integer('total_num_of_pkgs')->nullable(); 
            $table->integer('num_of_pkgs')->nullable(); 
            $table->string('remarks',136)->nullable();
            $table->dateTime('state_datetime')->nullable();
            $table->unsignedBigInteger('state_change_by')->nullable();
            $table->foreign('state_change_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fb_lr_state_log');
    }
};
