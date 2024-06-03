<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {

        $vehicleData = [
            [
                'SrNo' => 1,
                'VehicleMake' => 'Vehicle Make A',
                'Model' => 'Model 1',
                'Vehicle_No' => 'VEH001',
                'VendorName' => 'Vendor A',
                'VendorType' => 'OWN',
                'Depot' => 'Depot XYZ',
                'Payload' => 'Payload A',
                'GVW' => 'GVW A',
                'Length' => 'Length A',
                'Width' => 'Width A',
                'Height' => 'Height A',
                'RCBookNo' => 'RC Book No A',
                'RC_Validity' => '2023-01-15', // Example date
                'RegDate' => '2023-02-01', // Example date
                'RegistrationNo' => 'Reg No A',
                'InsuranceNo' => 'Insurance No A',
                'Insurance_Validity' => '2023-03-01', // Example date
                'AttachedDate' => '2023-04-01', // Example date
                'Fitness_Validity' => '2023-05-01', // Example date
                'Permit_validity' => '2023-06-01', // Example date
                'Tax_validdity' => '2023-07-01', // Example date
                'TaxStatus' => 'Tax Status A',
                'PUCC_Validity' => '2023-08-01', // Example date
                'Chassis_No' => 'Chassis No A',
                'Engine_No' => 'Engine No A',
                'FuelTankCapacity' => 'Fuel Tank Capacity A',
                'GPSDeviceEnabled' => 'GPS Device Enabled A',
                'PermitStates' => 'Permit States A',
                'NoOfTyres' => 'No Of Tyres A',
                'FTLType' => 'FTL Type A',
                'RateKm' => 'Rate Km A',
                'StandardMilageKmPerLtr' => 'Standard Milage Km Per Ltr A',
                'ControllingBranch' => 'Controlling Branch A',
                'Capacity' => 'Capacity A',
                'UnloadedWeight' => 'Unloaded Weight A',
                'VehicleBroker' => 'Vehicle Broker A',
                'InsuranceCompany' => 'Insurance Company A',
                'FitnessCertificateDate' => '2023-09-01', // Example date
                'CertNo' => 'Cert No A',
                'RTONo' => 'RTO No A',
                'UploadRc' => 'Upload Rc A',
                'UploadInsuarance' => 'Upload Insuarance A',
                'UploadPermit' => 'Upload Permit A',
                'UploadPUC' => 'Upload PUC A',
                'Permit_No' => 'Permit No A',
                'Fitness_No' => 'Fitness No A',
                'CloseTrip' => 'Close Trip A',
                'ActiveFlag' => 'Active Flag A',
                'MilageKM' => 'Milage KM A',
                'Milage' => 'Milage A',
                'created_at' => now(), // Example date
                'updated_at' => now(), // Example date
            ],
            // Add more vehicle data as needed
        ];

        DB::table('vehicles')->insert($vehicleData);

    }
}
