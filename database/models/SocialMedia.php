<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    /** 
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'social_media';
    public const TABLE_NAME = 'social_media';

    public function owner()
    {
        return $this->morphTo();
    }
}
