<?php

namespace Database\Seeders;

use App\Feature\GroupMaster\Models\GroupMaster;
use Illuminate\Database\Seeder;

class GroupMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupMaster::create([
            'groupcode' => '123',
            'groupname' =>  'Administrator',
            'status' => 'ACTIVE',
        ]);
    }
}
