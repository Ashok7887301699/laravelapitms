<?php

namespace Database\Seeders;

use App\Feature\VendorFuel\Models\VendorFuel;
use Illuminate\Database\Seeder;

class VendorFuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorFuel::create([
            'PetrolPumpName' => 'HP PETROLPUMP',
            'Vendorname' => 'JAY',
            'DVendorCode' => 'India',
            'Depot' => 'Maharashtra',
            'status' => 'ACTIVE',
        ]);
    }
}
