<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TenantSeeder::class,
            PrivilegeSeeder::class,
            RoleSeeder::class,
            RolePrivilegeSeeder::class,
            UserSeeder::class,
            BranchSeeder::class,
            PackageTypeSeeder::class,
            ContractPaymentSeeder::class,
            VendorFuelSeeder::class,
            HamaliSeeder::class,
            CityMasterSeeder::class,
            IndiaSeeder::class,
            PrnappTableSeeder::class,
            PrnvehicleTableSeeder::class,
            IndustryTypeSeeder::class,
            GroupMasterSeeder::class,

            
            VehicleCapacityModelSeeder::class,
            VendorSeeder::class,
            DriversSeeder::class,
            DrsSeeder::class,
            LrSeeder::class,
            EwayBillSeeder::class,
            FbConsignmentSeeder::class,
            EwbReqIdSeeder::class,


        ]);
    }
}