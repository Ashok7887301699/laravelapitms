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
        Schema::create('ff_consignor_stmt_pod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
      
            $table->string('ff_consignor_stmt_id', 24)->nullable();
            $table->foreign('ff_consignor_stmt_id')->references('id')->on('ff_consignor_stmt')->onDelete('set null');
            
            $table->string('ff_pod_id', 24)->nullable();
            $table->foreign('ff_pod_id')->references('id')->on('ff_pod')->onDelete('set null');
           
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ff_consignor_stmt_pod');
    }
};
