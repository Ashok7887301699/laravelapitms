<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrnappTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for the prnapp table
        DB::table('prnapp')->insert([
            'PRNId' => "PNA0001",
            'Username' => 'SampleUser',
            'ADate' => now(),
            'LRNO' => 'LR123',
            'RecievedQty' => 50,
            'Reason' => 'Sample reason',
            'PRNDate' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add more sample data as needed
    }
}