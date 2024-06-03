<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('sap_cust_code')->primary();
            $table->string('sap_cust_grp_code');
            $table->string('cust_grp_code')->nullable();
            $table->string('CostCenter')->nullable();
            $table->string('CustName');
            $table->string('Category');
            $table->string('MobileNo');
            $table->string('PAN');
            $table->string('GST_No');
            $table->string('City');
            $table->string('Pincode');
            $table->string('Location');
            $table->string('TelNo');
            $table->string('Address');
            $table->unsignedBigInteger('ind_type_id')->nullable();
            $table->string('sap_ind_type');
            $table->string('CustNameMar');
            $table->string('AddressMar');
            $table->string('BillAddressMar');
            $table->string('BillingMail');
            $table->string('BillingMobileNo');
            $table->string('BiillingPerson');
            $table->string('Status');
            $table->string('depot_id')->nullable();
            $table->string('sap_depot_name');
            $table->string('CreatedBy');
            $table->string('SalesReference');
            $table->timestamp('sap_create_date')->nullable();
            $table->timestamps();


            // Foreign keys
            $table->foreign('ind_type_id')->references('id')->on('industry_types')->onDelete('cascade');
            $table->foreign('depot_id')->references('BranchCode')->on('branch')->onDelete('cascade');


            // Indexes
            $table->index('cust_grp_code');
            $table->index('ind_type_id');
            $table->index('depot_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }

};
