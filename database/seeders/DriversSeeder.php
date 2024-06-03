<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DriversSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('drivers')->insert([
                'FirstName' => Str::random(8),
                'MiddleName' => Str::random(8),
                'LastName' => Str::random(8),
                'SAPId' => Str::random(10),
                'UserId' => 1, 
                'BranchCode' => "MUM", 
                'DriverCode' => Str::random(6),
                'Location' => Str::random(10),
                'MobileNumber' => rand(1000000000, 9999999999),
                'PermanentAddress' => Str::random(20),
                'CurrentAdddress' => Str::random(20),
                'LicenseNumber' => Str::random(12),
                'LicenseValidity' => now()->addYears(rand(1, 10))->format('Y-m-d'),
                'IssuedByRTO' => Str::random(10),
                'Guarantor' => Str::random(8),
                'FirstLiceseIssueDate' => now()->subYears(rand(1, 10))->format('Y-m-d'),
                'CloseTrip' => rand(0, 1),
                'MannualDriverCode' => rand(1000, 9999),
                'DriverFatherName' => Str::random(10),
                'VehicleNumber' => Str::random(8),
                'PermanantCity' => Str::random(10),
                'PermanantPincode' => rand(100000, 999999),
                'CurrentCity' => Str::random(10),
                'CurrentPincode' => rand(100000, 999999),
                'GaurantorName' => Str::random(10),
                'Status' => 'ACTIVE',
                'DriverCategory' => Str::random(10),
                'DOB' => now()->subYears(rand(20, 60))->format('Y-m-d'),
                'DOJ' => now()->subYears(rand(1, 5))->format('Y-m-d'),
                'Ethinicity' => Str::random(10),
                'CurrentLicenceIssueDate' => now()->subYears(rand(1, 10))->format('Y-m-d'),
                'LicenceVerifiedDate' => now()->subYears(rand(1, 5))->format('Y-m-d'),
                'LicenceVerified' => rand(0, 1),
                'VerifiedByUserId' => 1, // Assuming there are users in the users table with ids from 1 to 10
                'AddressVerified' => rand(0, 1),
                'DriverPhoto' => Str::random(10),
                'PanCard' => Str::random(10),
                'VoterId' => Str::random(10),
                'AdharCard' => Str::random(10),
                'Licence' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}