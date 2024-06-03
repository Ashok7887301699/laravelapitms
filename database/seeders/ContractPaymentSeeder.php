<?php

namespace Database\Seeders;

use App\Feature\ContractPaymentType\Models\ContractPaymentType;
use Illuminate\Database\Seeder;

class ContractPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractPaymentType::create([
            'contract_paymenttype' => 'PAID',
            'status' => 'ACTIVE',
        ]);
    }
}
