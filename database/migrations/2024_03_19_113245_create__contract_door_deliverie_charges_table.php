
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractDoorDeliverieChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_door_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id'); // Changed to string type
            $table->foreign('contract_id')->references('contract_id')->on('contracts')->onDelete('cascade'); // Changed to string type
            $table->string('from_place');
            $table->string('to_place');
            $table->decimal('rate', 10, 2); // Assuming rate is a decimal number, adjust precision and scale as needed
            $table->timestamps();

            // Foreign key constraint
            $table->index('contract_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_door_deliveries');
    }
}
