<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EwbReqIdSeeder extends Seeder
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
                'req_id' => 'REQ001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more data arrays as needed
        ];

        // Insert the data into the fb_ewb_req_id table
        DB::table('fb_ewb_req_id')->insert($data);
    }
}
