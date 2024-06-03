<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EwayBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define your dummy data here
        $data = [
            [
                'tenant_id' => 1,
                'lr_id' => 1,
                'ewb_num' => 'EWB001',
                'ewb_datetime' => now(),
                'ewb_by_gst_num' => 'GST001',
                'doc_num' => 'DOC001',
                'doc_date' => now(),
                'goods_value' => 1000.00,
                'from_pincode' => '123456',
                'from_place' => 'Source Place',
                'from_state' => 'State1',
                'to_pincode' => '654321',
                'to_place' => 'Destination Place',
                'to_state' => 'State2',
                'distance' => 500.00,
                'last_location' => 'Last Location',
                'last_vehicle_num' => 'VEH001',
                'valid_till' => now()->addDays(30),
                'num_of_times_extended' => 1,
                'consignment_out_for_delivery_on' => now()->addDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more data arrays as needed
        ];

        // Insert the data into the fb_ewaybill table
        DB::table('fb_ewaybill')->insert($data);
    }
}
