<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrnvehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for the prnvehicle table
        DB::table('prnvehicle')->insert([
            'PRNId' => 1,
            'Username' => 'SampleUser',
            'VehicleNo' => 'ABC123',
            'PRNDate' => now(),
            'AVDate' => now(),
            'ArrivalDate' => now(),
            'PrnArrivalDateTime' => now(),
            'LoadingUnloading' => 'Loading',
            'ArrivalUser' => 'ArrivalUser1',
            'LRNO' => 'LR123',
            'CustomerCode' => 'C123',
            'CustomerName' => 'Sample Customer',
            'VendorHamaliName' => 'HamaliVendor',
            'HamaliAmount' => 100.00,
            'Prncreatehamaliname' => 'CreatedHamali',
            'prncreatehamaliamount' => 50.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add more sample data as needed
    }
}