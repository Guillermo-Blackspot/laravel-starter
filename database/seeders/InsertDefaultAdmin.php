<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InsertDefaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id' => 1,
            'name'          => 'Demo',
            'last_name'     => 'Super Admin',
            'email'         => 'demo@admin.com',
            'password'      => bcrypt('secret'),
            'slug'          => 'demo-super-admin',
        ]);

        $user->syncRoles(['super admin']);
    }
}
