<?php
namespace BlackSpot\Starter\Traits\DB;

use App\Models\Address;

trait HasAddresses
{
    public function addresses(){
        return $this->morphMany(Address::class, 'addressable');
    }

    public function main_address()
    {
        return $this->morphOne(Address::class,'addressable')->where('main',true);
    }
}

