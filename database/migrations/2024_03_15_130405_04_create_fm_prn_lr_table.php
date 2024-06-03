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
        Schema::create('fm_prn_lr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable(); 
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
         
           $table->string('prn_id', 24)->nullable();
            $table->foreign('prn_id')->references('id')->on('fm_prn')->onDelete('cascade');
            
            $table->string('lr_id', 24)->nullable();
           $table->foreign('lr_id')->references('id')->on('fb_lr')->onDelete('cascade');
           
        $table->smallInteger('seq_num')->nullable();
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_prn_lr');
    }
};