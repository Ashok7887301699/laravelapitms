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
        Schema::create('contract_slab_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id'); // Changed to string type
            $table->foreign('contract_id')->references('contract_id')->on('contracts')->onDelete('cascade'); // Changed to string type
            $table->enum('slab_contract_type', ['PER_KG', 'PER_PKG' , 'NONE']);
            $table->enum('slab_number', ['1', '2', '3', '4', '5', '6', '7', '8']);
            $table->integer('slab_lower_limit');
            $table->integer('slab_upper_limit');
            $table->enum('slab_rate_type', ['FLAT', 'RATED', 'NONE']);
            // $table->enum('slab_rate_type', ['PERKG','PERPKG','FLAT','NONE']);
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
        Schema::dropIfExists('contract_slab_definitions');
    }
};
