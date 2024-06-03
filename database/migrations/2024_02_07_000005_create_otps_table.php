<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->string('otp_hash', 255); // Hashed OTP value
            $table->timestamps(); // Updated_at and expires_at
            $table->dateTime('expires_at'); // OTP expiry time
            $table->integer('failed_otp_login_attempts')->default(0); // Count of failed OTP attempts
            $table->dateTime('otp_login_blocked_till')->nullable(); // Time till OTP login is blocked

            // Setting the primary key
            $table->primary(['user_id', 'otp_hash']);

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otps');
    }
}
