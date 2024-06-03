<?php

namespace Database\Seeders;

use App\Feature\User\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'SUPERADMIN',
            'description' => 'All inclusive role for S_OWNER type of user',
            'status' => 'ACTIVE',
        ]);
    }
}
