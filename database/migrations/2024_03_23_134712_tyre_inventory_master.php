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
        Schema::create('tyre_inventory_master', function (Blueprint $table) {
            $table->id();
            $table->string('tyre_code')->nullable();
            $table->string('tyre_number')->unique(); ;
            $table->string('tyre_category');
            $table->string('manufacturer');
            $table->string('tyre_size');
            $table->string('tyre_pattern');
            $table->date('purchase_date');
            $table->integer('qty');
            $table->decimal('price', 10, 2); // Assuming price is in decimal format with precision 10 and scale 2
            $table->string('tyre_type');
            $table->string('tyre_position');
            $table->decimal('tyre_weight', 8, 2); // Assuming weight is in decimal format with precision 8 and scale 2
            $table->enum('tyre_status', ['Brand New', 'In Use', 'Scrap']);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tyre_inventory_master');
    }
};