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
        Schema::create('ff_pod', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->string('lr_id', 24)->nullable();
            $table->foreign('lr_id')->references('id')->on('fb_lr')->onDelete('set null');
            $table->string('drs_id', 24)->nullable();
            $table->foreign('drs_id')->references('id')->on('fm_drs')->onDelete('set null');
            $table->string('thc_id', 24)->nullable();
            $table->foreign('thc_id')->references('id')->on('fm_thc')->onDelete('set null');
            
            $table->string('consignor_id', 16)->nullable();
            $table->foreign('consignor_id')->references('sap_cust_code')->on('customers')->onDelete('set null');
            $table->string('consignee_id', 16)->nullable();
            //$table->foreign('from_depot')->references('DepotCode')->on('depot')->onDelete('set null');
            $table->unsignedBigInteger('consignment_id')->nullable();
            $table->foreign('consignment_id')->references('id')->on('fb_consignment')->onDelete('set null');
            $table->string('invoice_num',24)->nullable();

            $table->float('quantity')->nullable();
            $table->float('weight')->nullable();
            $table->string('pod_artefact_url',255)->nullable();
            

            $table->dateTime('upload_datetime')->nullable();
            $table->boolean('verified')->nullable();
            $table->dateTime('verification_datetime')->nullable();
            $table->boolean('goodquality')->nullable();
            $table->boolean('delivered')->nullable();
            $table->dateTime('del_datetime')->nullable();
            $table->boolean('stmt_prepared')->nullable();
            $table->dateTime('stmt_datetime')->nullable();

            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            
            $table->dateTime('lr_booking_date')->nullable();
            $table->dateTime('thc_date')->nullable();
            $table->dateTime('drs_date')->nullable();
         
            
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ff_pod');
    }
};
