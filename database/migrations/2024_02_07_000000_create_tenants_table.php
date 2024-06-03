<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name', 128); // Tenant's name
            $table->string('country', 64); // Tenant's country
            $table->string('state', 64); // Tenant's state
            $table->string('city', 64); // Tenant's city
            $table->string('short_name', 10)->unique(); // Unique short name for the tenant
            $table->string('logo_url'); // logo of the tenant
            $table->text('description')->nullable(); // Description of the tenant, nullable
            $table->enum('status', ['REGISTERED', 'ACTIVE', 'DEACTIVATED']); // Status of the tenant
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
