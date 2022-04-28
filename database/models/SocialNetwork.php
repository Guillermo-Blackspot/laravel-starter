<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    /** 
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'social_networks';
    public const TABLE_NAME = 'social_networks';

    public function owner()
    {
        return $this->morphTo();
    }
}
