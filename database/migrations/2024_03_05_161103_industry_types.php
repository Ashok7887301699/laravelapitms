<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up(): void
    // {
    //     Schema::create('industry_types', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }


    // public function down(): void
    // {
    //     Schema::dropIfExists('industry_types');
    // }

    public function up(): void
    {
        Schema::create('industry_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('description', 255)->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }


   public function down(): void
    {
        Schema::dropIfExists('industry_types');
    }
};
