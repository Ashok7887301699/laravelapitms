<?php

namespace Database\Seeders;

use App\Feature\IndustryType\Models\IndustryType;
use Illuminate\Database\Seeder;

class IndustryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$tenant = Tenant::where('short_name', 'VTINMHPU')->first();
        IndustryType::create([
            //'tenant_id' => $tenant->id,
            'name' => 'AUTOMOBILE',
            'description' => 'THE AUTOMOTIVE INDUSTRY COMPRISES A WIDE RANGE OF COMPANIES AND ORGANIZATIONS INVOLVED IN THE DESIGN, DEVELOPMENT',
            'status' => 'ACTIVE',
        ]);
        
    }
}
