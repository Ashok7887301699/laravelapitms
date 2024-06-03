<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Drivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('FirstName')->nullable(false);
            $table->string('MiddleName')->nullable(false);
            $table->string('LastName')->nullable(false);
            $table->string('SAPId');
            $table->unsignedBigInteger('UserId')->nullable();
            $table->foreign('UserId')->references('id')->on('users')->onDelete('set null');
            $table->string('BranchCode')->nullable();
            $table->foreign('BranchCode')->references('BranchCode')->on('Branch')->onDelete('set null');
            $table->string('DriverCode')->unique()->nullable(false);
            $table->string('Location')->nullable(false);
            $table->bigInteger('MobileNumber')->nullable(false);
            $table->string('PermanentAddress')->nullable(false);
            $table->string('CurrentAddress')->nullable(false);
            $table->string('LicenseNumber')->nullable(false);
            $table->string('LicenseValidity')->nullable(false);
            $table->string('IssuedByRTO')->nullable(false);
            $table->string('GuarantorName')->nullable(false);
            $table->string('FirstLicenseIssueDate')->nullable(false);
            $table->tinyInteger('CloseTrip')->nullable(false);
            // $table->integer('MannualDriverCode')->nullable(false);
            $table->string('DriverFatherName')->nullable(false);
            $table->string('VehicleNumber')->nullable(false);
            $table->string('PermanentCity')->nullable(false);
            $table->integer('PermanentPincode')->nullable(false);
            $table->string('CurrentCity')->nullable(false);
            $table->integer('CurrentPincode')->nullable(false);
            $table->enum('Status', ['ACTIVE', 'DEACTIVATED', 'DELETED'])->default('ACTIVE');
            $table->string('DriverCategory')->nullable(false);
            $table->string('DOB')->nullable(false);
            $table->string('DOJ')->nullable(false);
            $table->string('Ethinicity')->nullable(false);
            $table->string('CurrentLicenseIssueDate')->nullable(false);
            $table->string('LicenseVerifiedDate')->nullable(false);
            $table->string('LicenseVerified')->nullable(false);
            // $table->unsignedBigInteger('VerifiedByUserId')->nullable(false);
            $table->string('AddressVerified')->nullable(false);
            $table->string('DriverPhoto')->nullable(false);
            $table->string('PanCard')->nullable(false);
            $table->string('VoterId')->nullable(false);
            $table->string('AadharCard')->nullable(false);
            $table->string('License')->nullable(false);
            $table->index('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
