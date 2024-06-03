<?php

namespace Database\Seeders;

use App\Feature\User\Models\Privilege;
use Illuminate\Database\Seeder;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Privilege::create([
            'name' => 'SYS_ALL',
            'description' => 'All features in the application without any restriction for SYSOWNER type of user',
            'status' => 'ACTIVE',
        ]);
    }
}
