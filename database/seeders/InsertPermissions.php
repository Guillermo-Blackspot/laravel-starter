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

            'im-a-super-admin-and-i-have-full-access',
        ];

        foreach ($permissions as $key => $permissionName) {
            Permission::create([
                'id'   => $key + 1,
                'name' => $permissionName
            ]);
        }
    }
}
