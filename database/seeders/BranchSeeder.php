<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'BranchCode' => 'MUM',
                'BranchName' => 'MUMBAI',
                'GSTStateCode' => 1,
                'BranchType' => 'CP',
                'Latitude' => 19.0726,
                'Longitude' => 72.8845,
                'Country' => 'INDIA',
                'State' => 'MAHARASHTRA',
                'District' => 'MUMBAI SUBURBAN',
                'Taluka' => 'KURLA',
                'City' => 'MUMBAI',
                'Status' => 'ACTIVE',
                // 'CreatedBy' => 1,
                'UploadBranch' => 'public\BranchPhotos\mumbaiBranch.jpg',
                'UploadShopAct' => 'public\BranchPhotos\mumbaiBranchShopAct.jpg',
                'RegionalBranchName' => 'मुंबई',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'BranchCode' => 'PNA',
                'BranchName' => 'PUNE',
                'GSTStateCode' => 2,
                'BranchType' => 'CP',
                'Latitude' => 18.4774569,
                'Longitude' => 73.95956554,
                'Country' => 'INDIA',
                'State' => 'MAHARASHTRA',
                'District' => 'PUNE',
                'Taluka' => 'HAVELI',
                'City' => 'PUNE',
                'Status' => 'ACTIVE',
                // 'CreatedBy' => 1,
                'UploadBranch' => 'public\BranchPhotos\puneBranch.jpg',
                'UploadShopAct' => 'public\BranchPhotos\puneBranchShopAct.jpg',
                'RegionalBranchName' => 'पुणे',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'BranchCode' => 'PUD',
                'BranchName' => 'PUDUCHERRY',
                'GSTStateCode' => 2,
                'BranchType' => 'CP',
                'Latitude' => 18.4774569,
                'Longitude' => 73.95956554,
                'Country' => 'INDIA',
                'State' => 'PUDUCHERRY',
                'District' => 'KARAIKAL',
                'Taluka' => 'THIRUNALLAR',
                'City' => 'PUDUCHERRY',
                'Status' => 'ACTIVE',
                // 'CreatedBy' => 1,
                'UploadBranch' => 'public\BranchPhotos\puneBranch.jpg',
                'UploadShopAct' => 'public\BranchPhotos\puneBranchShopAct.jpg',
                'RegionalBranchName' => 'பாண்டிச்சேரி',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('Branch')->insert($branches);
    }
}