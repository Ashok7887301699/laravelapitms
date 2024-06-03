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
        Schema::create('fb_consignment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->string('lr_id', 24)->nullable();

            $table->boolean('consignment_type_volumetric'); 
            $table->string('invoice_num',24);
            $table->dateTime('invoice_date');
            $table->enum('pkg_type', ['BAGS', 'BOX', 'BUCKETS', 'BUNDAL','CAN','DRUM','PACKET','PIPE','TYRE','MACHINE','NONE'])->default('NONE');
            $table->enum('product_type', ['ADVERTISE MATERIAL', 'AUTO PARTS', 'FERTILIZERS', 'MEDICINE','PALLETS','PESTICIDES','SEEDS','SPRAY PUMP','STATIONERY','E-GOODS','CHEMICAL','PAINT','ELECTRICS','MOTOR','COSMETIC','TYRE','PVC','PACKAGING MATERIAL','WOODEN FRAME','TARPAULIN','ITEM','ROLL','CLOTHES','WOODENSTICKS','INCENSESTICKS','RACK','POT','SUNMICA','PLYWOOD','WIRE','GLASS','PLASTICS','HARDWARE','GLOSORY','FOODS','CERAMIC','POP','ELECTONICS','SPARE PARTS','NONE'])->default('NONE');
           
            $table->float('invoice_value')->nullable();
            $table->smallInteger('num_of_pkgs')->nullable();
            //if ( consignment_type_
                //volumetric == true){
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('av_weight_per_pkg')->nullable();
            $table->float('total_av_weight')->nullable();
            //}
            $table->float('actual_weight_per_pkg');
            $table->float('total_actual_weight');
            $table->string('ewb_a_num',24)->nullable();
            $table->dateTime('ewb_expiry_datetime');

            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fb_consignment');
    }
};
