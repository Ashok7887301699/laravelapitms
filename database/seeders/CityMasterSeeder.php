<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;



class CityMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $cityMasterData = [
    [
        'CityNameEng' => 'Phursungi',
        'Taluka' => 'Haveli',
        'District' => 'Pune',
        'DistrictMar' => 'पुणे',
        'Postname' => 'Haveli',
        'Pincode' => '411021',
        'Country' => 'India',
        'State' => 'Maharashtra',
        'CityNameMar' => 'फुरसुंगी',
        'CityNameGmap' => 'फुरसुंगी',
        'Latitude' => '10.25.365',
        'Longitude' => '5265.36',
        'Zone' => '1',
        'RouteNo' => '125',
        'RouteSequens' => '125567',
        'DelDepot' => 'pna',
        'Tat' => '15989',
        'ODA' => '15989565',
        'NearStateHighway' => 'NH67',
        'NearestNationalHighway' => 'NH1234',       
        'status' => 'ACTIVE', // Use => for assignment
        'AddUser' => 'PNA2326',
        'created_at' => now(),
        'updated_at' => now(),
    ] // Remove the unnecessary comma here
];

        // Make sure your table name is correct (e.g., 'city_master')
        DB::table('citymaster')->insert($cityMasterData);
    }
}