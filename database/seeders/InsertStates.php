<?php

namespace Database\Seeders;

use App\Models\State;
use App\Services\EstadosMunicipiosMexico\EstadosMunicipiosMexico;
use Illuminate\Database\Seeder;

class InsertStates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //State::insert(EstadosMunicipiosMexico::getCountries());
    }
}
