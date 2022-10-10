<?php

namespace Database\Seeders;

use App\Models\Permission;
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
            [Permission::SUPER_ADMIN_PERMISSION]
        );
    }
}
