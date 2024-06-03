<?php

namespace Database\Seeders;

use App\Feature\PackageType\Models\PackageType;
use Illuminate\Database\Seeder;

class PackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackageType::create([
            'package_type' => 'BOX',
            'status' => 'ACTIVE',
        ]);
    }
}
