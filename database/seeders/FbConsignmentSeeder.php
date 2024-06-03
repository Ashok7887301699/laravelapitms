<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FbConsignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tenant_id' => 1, // Replace with appropriate tenant ID
                'lr_id' => 1, // Replace with appropriate lr ID
                'consignment_type_volumetric' => true, // Replace with appropriate value
                'invoice_num' => 'INV123', // Replace with appropriate invoice number
                'invoice_date' => now(), // Replace with appropriate invoice date
                'pkg_type' => 'BOX', // Replace with appropriate package type
                'product_type' => 'AUTO PARTS', // Replace with appropriate product type
                'invoice_value' => 1000.00, // Replace with appropriate invoice value
                'num_of_pkgs' => 5, // Replace with appropriate number of packages
                'length' => 10.5, // Replace with appropriate length
                'width' => 5.2, // Replace with appropriate width
                'height' => 8.0, // Replace with appropriate height
                'av_weight_per_pkg' => 2.5, // Replace with appropriate average weight per package
                'total_av_weight' => 12.5, // Replace with appropriate total average weight
                'actual_weight_per_pkg' => 3.0, // Replace with appropriate actual weight per package
                'total_actual_weight' => 15.0, // Replace with appropriate total actual weight
                'ewb_a_num' => 'EWB123', // Replace with appropriate EWB number
                'ewb_expiry_datetime' => now()->addDays(30), // Replace with appropriate EWB expiry date
                'siddar' => 'dummy_data_1', // New column added, replace with appropriate data
            ],
            [
                // Add more data as needed
            ],
        ];

        DB::table('fb_consignment')->insert($data);
    }
}
