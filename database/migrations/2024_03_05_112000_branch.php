<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Branch', function (Blueprint $table) {
            //'BranchCode' primary key, not auto-generated
            $table->string('BranchCode')->primary();
            $table->string('BranchName')->nullable(false);
            $table->integer('GSTStateCode')->nullable(false);
            $table->string('BranchType', 128)->nullable(false);
            $table->decimal('Latitude', 10, 8)->nullable(false);
            $table->decimal('Longitude', 10, 8)->nullable(false);
            $table->string('Country')->nullable(false);
            $table->string('State')->nullable(false);
            $table->string('District')->nullable(false);
            $table->string('Taluka')->nullable(false);
            $table->string('City')->nullable(false);
            $table->enum('Status', ['ACTIVE', 'DEACTIVATED'])->default('ACTIVE');
            // foreign key column
            $table->unsignedBigInteger('CreatedBy')->nullable();
            $table->foreign('CreatedBy')->references('id')->on('users')->onDelete('set null');
            // $table->integer('PinCodes')->nullable(false);
            $table->string('UploadBranch')->nullable();
            $table->string('UploadShopAct')->nullable();
            // $table->string('AssetDeployedList')->nullable(false);
            $table->string('RegionalBranchName')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Branch');
    }
};
