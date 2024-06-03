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
        // Schema::create('vehicles', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->integer('SrNo');
            $table->string('VehicleMake');
            $table->string('Model');
            $table->string('Vehicle_No')->primary();
            $table->string('VendorName');
            $table->string('VendorType');
            $table->string('Depot')->nullable();
            $table->string('Payload');
            $table->string('GVW');
            $table->string('Length');
            $table->string('Width');
            $table->string('Height');
            $table->string('RCBookNo');
            $table->dateTime('RC_Validity');
            $table->dateTime('RegDate');
            $table->string('RegistrationNo');
            $table->string('InsuranceNo');
            $table->dateTime('Insurance_Validity');
            $table->dateTime('AttachedDate');
            $table->dateTime('Fitness_Validity');
            $table->dateTime('Permit_validity');
            $table->dateTime('Tax_validdity');
            $table->string('TaxStatus');
            $table->dateTime('PUCC_Validity');
            $table->string('Chassis_No');
            $table->string('Engine_No');
            $table->string('FuelTankCapacity');
            $table->string('GPSDeviceEnabled');
            $table->string('PermitStates');
            $table->string('NoOfTyres');
            $table->string('FTLType');
            $table->string('RateKm');
            $table->string('StandardMilageKmPerLtr');
            $table->string('ControllingBranch');
            $table->string('Capacity');
            $table->string('UnloadedWeight');
            $table->string('VehicleBroker');
            $table->string('InsuranceCompany');
            $table->dateTime('FitnessCertificateDate');
            $table->string('CertNo');
            $table->string('RTONo');
            $table->string('UploadRc');
            $table->string('UploadInsuarance');
            $table->string('UploadPermit');
            $table->string('UploadPUC');
            $table->string('Permit_No')->nullable();
            $table->string('Fitness_No')->nullable();
            $table->string('CloseTrip');
            $table->string('ActiveFlag');
            $table->string('MilageKM')->nullable();
            $table->string('Milage');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
