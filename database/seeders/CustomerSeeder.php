<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customerData = [
            [
                'sap_cust_code' => '001',
                'sap_cust_grp_code' => 'GRP001',
                'CostCenter' => 'CC001',
                'CustName' => 'Customer ABC',
                'Category' => 'Category A',
                'MobileNo' => '1234567890',
                'PAN' => 'ABCDE1234F',
                'GST_No' => 'GST123456789',
                'City' => 'City XYZ',
                'Pincode' => '123456',
                'Location' => 'Location XYZ',
                'TelNo' => '9876543210',
                'Address' => 'Address XYZ',
                'CustNameMar' => 'ग्राहक एबीसी',
                'AddressMar' => 'पता एक्सवायजेड',
                'BillAddressMar' => 'बिलिंग पता एक्सवायजेड',
                'BillingMail' => 'billing@example.com',
                'BillingMobileNo' => '9876543210',
                'BiillingPerson' => 'Billing Person ABC',
                'Status' => 'ACTIVE',
                'sap_depot_name' => 'Depot XYZ',
                'sap_create_date' => '2023-02-20',
                'created_at' => '2024-02-01 12:00:00',
                'updated_at' => '2024-02-01 12:00:00'
            ],
            // Add more customer data as needed
        ];

        // Insert data using DB facade
        DB::table('customers')->insert($customerData);
    }
}
