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
        Schema::create('contract_slab_rates', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id'); // Changed to string type
            $table->foreign('contract_id')->references('contract_id')->on('contracts')->onDelete('cascade'); // Changed to string type
            $table->string('zone', 16);
            $table->string('from_place', 64);
            $table->string('to_place', 64);
            $table->smallInteger('transit_tat');
            $table->enum('slab_contract_type', ['PER_KG', 'PER_PKG' ,'NONE']);

            // Slab rates
            for ($i = 1; $i <= 8; $i++) {
                $table->float("slab$i", 8, 2);
            }
            $table->timestamps();

            // Index
            $table->index('contract_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_slab_rates');
    }
};
