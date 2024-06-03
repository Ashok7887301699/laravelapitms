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
        Schema::create('vehiclecapacitymodel', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->string('vehcpctmodel');
            $table->string('vehiclecpct');
            $table->string('modeldesc');
            $table->string('status');
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('vehiclecapacitymodel');
    }
};
