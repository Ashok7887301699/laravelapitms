<?php

namespace Database\Seeders;

use App\Feature\User\Models\Privilege;
use App\Feature\User\Models\Role;
use App\Feature\User\Models\RolePrivilege;
use Illuminate\Database\Seeder;

class RolePrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'SUPERADMIN')->first();
        $privilege = Privilege::where('name', 'SYS_ALL')->first();

        RolePrivilege::create([
            'role_id' => $role->id,
            'privilege_id' => $privilege->id,
            'status' => 'ACTIVE',
        ]);
    }
}
