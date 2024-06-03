<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_privileges', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id'); // Foreign key to roles
            $table->unsignedBigInteger('privilege_id'); // Foreign key to privileges
            $table->string('status');
            $table->timestamps(); // Created_at and updated_at timestamps

            // Primary key for the combination of role_id and privilege_id
            $table->primary(['role_id', 'privilege_id']);

            // Foreign key constraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('privilege_id')->references('id')->on('privileges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_privileges');
    }
}
