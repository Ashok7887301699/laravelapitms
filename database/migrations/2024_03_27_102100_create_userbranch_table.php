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
        Schema::create('userbranch', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); 
            $table->string('branch_code', 50);
            $table->string('status');
            $table->timestamps();

            $table->primary(['user_id', 'branch_code']);

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('branch_code')->references('BranchCode')->on('Branch')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userbranch');
    }
};
