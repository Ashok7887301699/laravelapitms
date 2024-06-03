<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define sample data
        $drsData = [
            [
                'id' => '1',
                'tenant_id' => 1,
                'dated' => Carbon::now(),
                'del_depot' => 'depot_id_1',
                'fleet_vendor_id' => 'fleet_vendor_id_1',
                'vehicle_model_by_capacity' => 'Sample Vehicle',
                'vehicle_num' => 'ABC123',
                'trip_distance_km_est' => 100,
                'vehicle_meter_reading_trip_start' => 5000,
                'vehicle_meter_reading_trip_end' => 5200,
                'driver_vendor_id' => 'driver_vendor_id_1',
                'driver_name' => 'John Doe',
                'driver_mobile' => '1234567890',
                'dl_num' => 'DL12345',
                'dl_expiry_datetime' => Carbon::now()->addYears(1),
                'consolidated_ewb_num' => 'EWB123',
                'trip_start_date' => Carbon::now()->subDay(),
                'trip_end_date' => Carbon::now(),
                'status' => 'status_value_1',
                'cancellation_reason' => null,
                'pod_datetime' => Carbon::now(),
                'created_by' => 1,
                'pod_received_by' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more sample data as needed
        ];

        // Insert data into the table
        DB::table('fm_drs')->insert($drsData);
    }
}
