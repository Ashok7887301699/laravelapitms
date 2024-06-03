<?php

namespace Database\Seeders;

use App\Feature\Tenant\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::create([
            'short_name' => 'VTINMHPU',
            'name' => 'VTC 3PL Services Limited',
            'country' => 'India',
            'state' => 'Maharashtra',
            'city' => 'Pune',
            'logo_url' => 'http://localhost:8000/storage/vtc-logo.jpeg',
            'description' => "It's an well established logistics company focused on 3PL & 4PL services.",
            'status' => 'ACTIVE',
        ]);
    }
}
