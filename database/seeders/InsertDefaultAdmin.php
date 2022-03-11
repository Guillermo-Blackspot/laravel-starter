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
            'surname'       => 'Super Admin',
            'photo'         => null, //by default
            'phone_code'    => null,
            'phone'         => null,
            'gender'        => null,
            'email'         => 'demo@admin.com',
            'password'      => bcrypt('secret'),
            'birthday_date' => null,
            'VIP'           => 1,
            'slug'          => 'demo-super-admin',
        ]);

        $user->syncRoles(['super admin']);
    }
}
