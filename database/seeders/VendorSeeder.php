<?php

namespace Database\Seeders;

use App\Feature\Vendor\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
            'VendorCode' => 'HAT7546',
            'VendorName' => 'JAY',
            'Type' => 'ATTACHED',
            'Address' => 'Fursungi pune',
            'City' => 'AKOLA',
            'Depot' => 'PNA',
            'Vehicle' => '20 FT MULTI EXLE 13 TO 21 MT',
            'Pincode' => '416005',
            'Mobile_No' => '9683552645',
            'Email' => 'test@gmail.com',
            'PAN_No' => '65GKjkj65555',
            'GSTNO' => 'HK45T',
            'BankName' => 'State bank of india',
            'AccountNO' => '456656655655',
            'IFSC' => 'IND458',
            'Category' => 'CSUPPLIER',
            'U_Location' => 'PUNE',
            'status' => 'ACTIVE',
        ]);
    }
}
