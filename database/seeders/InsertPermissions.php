<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class InsertPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            /**
             * Globals
             */

             Permission::SUPER_ADMIN_PERMISSION
        ];

        foreach ($permissions as $key => $permissionName) {
            Permission::create([
                'id'   => $key + 1,
                'name' => $permissionName
            ]);
        }
    }
}
