<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use MmoAndFriends\Mexico\Mexico;

class InsertStates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::insert(Mexico::getStates('array'));
    }
}
