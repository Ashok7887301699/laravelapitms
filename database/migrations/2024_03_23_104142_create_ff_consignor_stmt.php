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
        Schema::create('ff_consignor_stmt', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->string('consignor_id')->nullable();
            $table->foreign('consignor_id')->references('sap_cust_code')->on('customers')->onDelete('cascade');
            $table->string('stmt_year', 8)->nullable();
            $table->integer('stmt_month')->nullable();
            $table->timestamp('from_date')->default(now()->startOfDay());
            $table->timestamp('to_date')->default(now()->endOfDay());
            // $table->timestamp('from_date')->default(DB::raw('CONCAT(CURRENT_DATE(), " 00:00:00")'));
            // $table->timestamp('to_date')->default(DB::raw('CONCAT(CURRENT_DATE(), " 23:59:59")'));
            $table->dateTime('stmt_datetime')->nullable();
            $table->unsignedBigInteger('stmt_created_by')->nullable();
            $table->foreign('stmt_created_by')->references('id')->on('users')->onDelete('set null');
            $table->dateTime('stmt_dispatched')->nullable();
            $table->dateTime('stmt_dispatch_datetime')->nullable();
            $table->unsignedBigInteger('stmt_dispatched_by')->nullable();
            $table->foreign('stmt_dispatched_by')->references('id')->on('users')->onDelete('set null');
            $table->boolean('stmt_accepted')->nullable();
            $table->dateTime('stmt_acceptance_datetime')->nullable();
            $table->string('stmt_acceptance_proof_artefact_url', 255)->nullable();
            $table->dateTime('acceptance_proof_upload_datetime')->nullable();
            $table->boolean('stmt_acceptance_proof_verified')->nullable();
            $table->dateTime('stmt_acceptance_proof_verification_datetime')->nullable();
            $table->boolean('stmt_acceptance_proof_goodquality')->nullable();
            $table->unsignedBigInteger('stmt_acceptance_proof_verified_by')->nullable();
            $table->foreign('stmt_acceptance_proof_verified_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ff_consignor_stmt');
    }
};
