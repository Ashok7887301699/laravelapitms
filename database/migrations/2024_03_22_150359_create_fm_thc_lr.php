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
        Schema::create('fm_thc_lr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
      
            $table->string('thc_id', 16)->nullable();
            $table->foreign('thc_id')->references('id')->on('fm_thc')->onDelete('set null');
            
            $table->string('lr_id', 24)->nullable();
            $table->foreign('lr_id')->references('id')->on('fb_lr')->onDelete('set null');

            $table->smallInteger('seq_num')->nullable();
           
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_thc_lr');
    }
};
