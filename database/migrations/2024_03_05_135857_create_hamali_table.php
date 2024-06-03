<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHamaliTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hamali', function (Blueprint $table) {
            $table->id();
            $table->string('VendorCode');
            $table->string('Hvendor');
            $table->string('DEPOT');
            $table->string('HAccountNO');
            $table->string('HIFSC');
            $table->string('Hbank');
            $table->string('Hbranch');
            $table->string('Category');
            $table->string('U_Location');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hamali');
    }
};
