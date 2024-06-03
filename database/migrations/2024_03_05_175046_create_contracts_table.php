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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->string('sap_cust_code');
            $table->string('created_by'); // Changed to string type
            $table->foreign('created_by')->references('login_id')->on('users')->onDelete('cascade'); // Changed to string type
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', ['DRAFT', 'ACTIVE', 'INACTIVE']);
            $table->timestamps();

            // Indexes
            $table->index('contract_id');
            $table->index('tenant_id');
            $table->index('sap_cust_code');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
