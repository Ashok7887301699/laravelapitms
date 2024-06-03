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
        Schema::create('fb_lr_audit_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->string('lr_id', 24)->nullable();
            $table->foreign('lr_id')->references('id')->on('fb_lr')->onDelete('set null');
            $table->enum('action', ['CREATE', 'UPDATE', 'DELETE', 'NONE'])->default('NONE');
            $table->json('original_data')->nullable();
            $table->json('new_data')->nullable();
           
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fb_lr_audit_log');
    }
};
