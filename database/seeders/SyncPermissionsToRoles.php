<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class SyncPermissionsToRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::select('id')->find(1)->syncPermissions(
            ['im-a-super-admin-and-i-have-full-access']
        );
    }
}
