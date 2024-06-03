<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $indiaData = [
    [
        'State' => 'MAHARASHTRA',
        'District' => 'Pune',
        'Taluka' => 'Haveli',
        'Postoffice' => 'Haveli_PO',
        'Post_Pincode' => '411003',
        'created_at' => now(),
        'updated_at' => now(),
       
    ] 
];

        DB::table('india')->insert($indiaData);
    }
}