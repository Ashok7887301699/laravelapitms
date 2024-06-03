<?php

namespace Database\Seeders;

use App\Feature\Tenant\Models\Tenant;
use App\Feature\User\Models\Role;
use App\Feature\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant = Tenant::where('short_name', 'VTINMHPU')->first();
        $role = Role::where('name', 'SUPERADMIN')->first();

        User::create([
            'tenant_id' => $tenant->id,
            'login_id' => 'sa',
            'mobile_no' => '9876543210',
            'email_id' => 'sa@swatpro.co',
            'password_hash' => Hash::make('0007'), // Hashing the password
            'displayname' => 'Super Admin',
            'profile_pic_url' => 'http://localhost:8000/storage/user.jpg',
            'user_type' => 'S_OWNER',
            'role_id' => $role->id,
            'status' => 'ACTIVE',
        ]);
    }
}
