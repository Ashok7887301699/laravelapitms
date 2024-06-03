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
        Schema::create('contract_excess_weights', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id'); // Changed to string type
            $table->foreign('contract_id')->references('contract_id')->on('contracts')->onDelete('cascade'); // Changed to string type
            $table->integer('lower_slab_limit');
            $table->integer('upper_slab_limit');
            $table->float('rate', 8, 2);
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
        Schema::dropIfExists('contract_excess_weights');
    }
};
