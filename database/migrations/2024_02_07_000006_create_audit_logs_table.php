<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('table_name', 128); // Name of the table being audited
            $table->enum('action', ['CREATE', 'UPDATE', 'DELETE']); // Type of action performed
            $table->text('original_data')->nullable(); // Original data before the action
            $table->text('new_data')->nullable(); // New data after the action
            $table->unsignedBigInteger('performed_by')->nullable(); // User who performed the action
            $table->dateTime('performed_at'); // When the action was performed
            $table->timestamps(); // Timestamps

            // Foreign key constraints
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('performed_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
