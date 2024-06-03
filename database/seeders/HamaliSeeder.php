<?php

namespace Database\Seeders;

use App\Feature\Hamali\Models\Hamali;
use Illuminate\Database\Seeder;

class HamaliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hamali::create([
            'VendorCode' => 'SWA001',
            'Hvendor' => 'PRASHANT UTTAMRAO THORAT',
            'DEPOT' => 'PNA',
            'HAccountNO' => '33533182138',
            'HIFSC' => 'SBIN0000306',
            'Hbank' => 'STATE BANK OF INDIA',
            'Hbranch' => 'AKOLA',
            'Category' => 'hamali',
            'U_Location'=>'PNA',
            'status' => 'ACTIVE',
        ]);
    }
}
