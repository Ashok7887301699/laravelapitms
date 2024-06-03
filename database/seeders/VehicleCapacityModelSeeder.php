<?php

namespace Database\Seeders;

use App\Feature\VehicleCapacityModel\Models\VehicleCapacityModel;
use Illuminate\Database\Seeder;

class VehicleCapacityModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$tenant = Tenant::where('short_name', 'VTINMHPU')->first();
        VehicleCapacityModel::create([
            //'tenant_id' => $tenant->id,
            'vehcpctmodel' => '32 Feet Single Axel Truck ',
            'vehiclecpct' => 'Capacity of 32 Feet',
            'modeldesc' => 'The 32 feet single axle container truck is a widely used heavy commercial vehicle that is suitable for electronics',
            'status' => 'ACTIVE',
        ]);
         // Seed another record for the same tenant
         VehicleCapacityModel::create([
            //'tenant_id' => $tenant->id, // Reuse the same tenant ID
            'vehcpctmodel' => 'Another Model',
            'vehiclecpct' => 'Another Capacity',
            'modeldesc' => 'Description of another model for the same tenant',
            'status' => 'ACTIVE',
        ]);
    }
}
