<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->string('login_id', 24);
            $table->string('mobile_no', 16);
            $table->string('email_id', 64);
            $table->string('password_hash');
            $table->string('displayname', 48);
            $table->string('profile_pic_url');
            // $table->string('depot_code')->nullable();
            $table->enum('user_type', ['S_OWNER', 'S_EMPLOYEE', 'S_VENDOR', 'S_PARTNER', 'T_OWNER', 'T_EMPLOYEE', 'T_CHANNEL_PARTNER', 'T_TRANSPORT_AGENT', 'T_FLEET_OWNER', 'T_CUSTOMER', 'T_VENDOR']);
            // Allow role_id to be nullable
            $table->unsignedBigInteger('role_id')->nullable();
            $table->enum('status', ['REGISTERED', 'ACTIVE', 'DEACTIVATED', 'BLOCKED']);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            // $table->foreign('depot_code')->references('BranchCode')->on('Branch')->onDelete('set null');
            // $table->foreign('depot_code')->references('BranchCode')->on('branch')->onDelete('set null');
            // Indexes
            // $table->index('tenant_id');
            $table->index('role_id');
            $table->index('login_id');
            // $table->index('depot_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
