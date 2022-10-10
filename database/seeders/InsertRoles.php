<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class InsertRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( 
            [
                ['id' => 1, 'name' => 'super admin'],
                ['id' => 2, 'name' => 'customer'],
            ]  
            as $role
        ) {
            Role::create($role);
        }
    }
}
