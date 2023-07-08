<?php 
namespace BlackSpot\Starter\Traits\DB;

use App\Models\SocialMedia;

trait HasSocialMedia
{
    /**
     * Boot on delete method
     */
    public static function bootHasSocialMedia()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }
            $model->social_medias()->delete();
        });
    }

    public function social_medias()
    {
        return $this->morphMany(config('laravel-starter.table_namespaces.social_media','\App\Models\Morphs\SocialMedia'), 'owner');
    }
}