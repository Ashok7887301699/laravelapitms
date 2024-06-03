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
        Schema::create('fb_lr', function (Blueprint $table) {
            //'id' primary key system generated lr number using custom strategy
            $table->string('id', 24)->primary();
            $table->string('custom_lr_num', 24)->nullable(); 
            $table->string('lr_ref_num', 24)->nullable(); 
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');            
            $table->string('booking_office_id', 16)->nullable();
            $table->dateTime('booking_date_time');
            $table->foreignId('booking_user_id')->constrained('users')->onDelete('cascade');
            $table->enum('consignor_type', ['CONTRACTUAL', 'WALKIN', 'NONE'])->default('NONE');
            $table->string('consignor_group_id', 16)->nullable();
            
            $table->string('consignor_id', 16)->nullable();
            $table->foreign('consignor_id')->references('sap_cust_code')->on('customers')->onDelete('set null');
            $table->string('consignor_name');
            $table->string('consignor_addr')->nullable();
            $table->string('consignor_mobile', 16);
            $table->string('consignor_email', 64)->nullable();
            $table->string('consignor_gst', 64)->nullable();
            $table->string('consignor_name_mar')->nullable();
            $table->string('consignor_addr_mar', 512)->nullable();

            $table->enum('payment_type', ['TBB', 'TOPAY', 'PAID', 'NONE'])->default('NONE');
            $table->enum('consignee_type', ['REGISTERED', 'NON-REGISTERED', 'NONE'])->default('NONE');
            $table->string('consignee_id', 16);
            $table->string('consignee_name');
            $table->string('consignee_addr')->nullable();
            $table->string('consignee_mobile', 16);
            $table->string('consignee_email', 64)->nullable();
            $table->string('consignee_gst', 64)->nullable();
            $table->string('consignee_name_mar')->nullable();
            $table->string('consignee_addr_mar', 512)->nullable();

            $table->string('billing_party_id', 16);
            $table->string('cost_center_id', 16);
            $table->string('from_place', 32);
         
            $table->enum('to_place_type', ['WITHINCOVERAGE', 'ODA', 'NONE'])->default('NONE');
            $table->string('to_place', 32);
            $table->string('to_place_zone', 16)->nullable();
            $table->string('origin_depot_id', 16)->nullable();
            $table->string('del_depot_id', 16)->nullable();           
            $table->enum('truck_load_type', ['FTL', 'LTL', 'NONE'])->default('NONE');
            $table->enum('del_speed', ['REGULAR', 'URGENT', 'NONE'])->default('NONE'); // Renamed from truck_load_type
            $table->enum('pickup_del_type', ['DPTODD', 'DPTOGD','GPTODD','GPTOGD'])->default('DPTODD');
            $table->dateTime('expected_del_date')->nullable();
            $table->smallInteger('total_num_of_invoices')->nullable();
            $table->float('total_value_of_invoices')->nullable();
            $table->smallInteger('total_num_of_pkgs')->nullable();
            $table->float('total_weight_in_kgs')->nullable();

            $table->enum('freight_rate_type', ['PER_PKG', 'PER_KG','BOTH', 'NONE'])->default('NONE');
            $table->float('freight_rate_per_kg')->nullable();
            $table->float('freight_rate_per_pkg')->nullable();
            $table->float('excess_weight_charges')->nullable();

            $table->float('total_freight_charges')->nullable();
            $table->float('total_excess_weight_charges')->nullable();
            $table->float('docu_charges')->nullable();
            $table->float('load_unload_charges')->nullable();
            $table->float('door_del_charges')->nullable();
            $table->float('oda_charges')->nullable();
            $table->float('insurance_rate')->nullable();
            $table->float('other_charges')->nullable();
            $table->float('sgst_rate')->nullable();
            $table->float('cgst_rate')->nullable();
            $table->float('sgst_amnt')->nullable();
            $table->float('cgst_amnt')->nullable();
            $table->float('docket_total_charges')->nullable();
            $table->string('status', 32)->nullable();

            $table->dateTime('edited_at')->nullable();
            $table->foreignId('edited_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('canceled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->foreignId('canceled_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('return_booked_on')->nullable();
            $table->string('return_lr_id', 24)->nullable();
            $table->foreignId('return_booked_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fb_lr');
    }
};


      