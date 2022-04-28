<?php 
namespace BlackSpot\Starter\Traits\DB;

use App\Models\SocialMedia;

trait HasSocialMedia
{
    public function social_medias(){
        return $this->morphMany(SocialMedia::class, 'owner');
    }
}