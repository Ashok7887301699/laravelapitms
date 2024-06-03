<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'PNA0000000001',
                'custom_lr_num' => '',
                'lr_ref_num' => '123',
                'tenant_id' => 1,
                'booking_office_id' => 'TST',
                'booking_date_time' => now(),
                'booking_user_id' => 1,
                'consignor_type' => 'CONTRACTUAL',
                'consignor_group_id' => '123',
                'consignor_id' => 'CBAS001',
                'consignor_name' => 'BASF',
                'consignor_addr' => 'PUNE',
                'consignor_mobile' => '1234567890',
                'consignor_email' => 'consignor1@example.com',
                'consignor_gst' => 'GST123',
                'consignor_name_mar' => 'BASF',
                'consignor_addr_mar' => 'PUNE',
                'payment_type' => 'TBB',
                'consignee_type' => 'REGISTERED',
                'consignee_id' => 'ABC01',
                'consignee_name' => 'ABC',
                'consignee_addr' => 'Fursungi',
                'consignee_mobile' => '9876543210',
                'consignee_email' => 'consignee1@example.com',
                'consignee_gst' => 'GST456',
                'consignee_name_mar' => 'Consignee Name Marathi 1',
                'consignee_addr_mar' => 'Consignee Address Marathi 1',
                'billing_party_id' => 'CBAS001',
                'cost_center_id' => 'CMHBAS01',
                'from_place' => 'Fursungi',
                'to_place_type' => 'WITHINCOVERAGE',
                'to_place' => 'Solapur',
                'truck_load_type' => 'FTL',
                'del_speed' => 'REGULAR',
                'pickup_del_type' => 'DPTODD',
                'expected_del_date' => now(),
                'total_num_of_invoices' => 5,
                'total_value_of_invoices' => 1000.00,
                'total_num_of_pkgs' => 10,
                'total_weight_in_kgs' => 500.00,
                'freight_rate_type' => 'PER_PKG',
                'freight_rate_per_kg' => 5.00,
                'freight_rate_per_pkg' => 50.00,
                'excess_weight_charges' => 20.00,
                'total_freight_charges' => 500.00,
                'total_excess_weight_charges' => 20.00,
                'docu_charges' => 10.00,
                'load_unload_charges' => 15.00,
                'door_del_charges' => 25.00,
                'oda_charges' => 30.00,
                'insurance_rate' => 2.50,
                'other_charges' => 35.00,
                'sgst_rate' => 5.00,
                'cgst_rate' => 5.00,
                'sgst_amnt' => 25.00,
                'cgst_amnt' => 25.00,
                'docket_total_charges' => 700.00,
                'status' => 'ACTIVE',
                'edited_at' => now(),
                'edited_by' => 1,
                'canceled_at' => null,
                'cancellation_reason' => null,
                'canceled_by' => null,
                'return_booked_on' => null,
                'return_lr_id' => null,
                'return_booked_by' => null,
                'delivered_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('fb_lr')->insert($data);
    }
}