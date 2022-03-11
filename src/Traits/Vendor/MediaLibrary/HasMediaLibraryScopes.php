<?php

namespace BlackSpot\Starter\Traits\Vendor\MediaLibrary;

use Closure;

trait HasMediaLibraryScopes 
{
    public $defaultMediaLibraryEagerSelect = 'id,collection_name,model_type,model_id,file_name,name,disk,conversions_disk,generated_conversions';
    
    /**
     * Build a "with" query for load the related media
     * 
     * @param object $query
     * @param string|array $medias
     * @param string $eagerSelect
     * @return $query
     */
    public function scopeLoadMediaFiles($query, $medias, $eagerSelect = null)
    {
        return $query->with(
            $this->buildLoadMediaFiles($medias, $eagerSelect)
        );
    }

    /**
     * Build an array with the eager loading of the related media
     * 
     * @param string|array $medias
     * @param string $eagerSelect
     * @return array
     */
    public function buildLoadMediaFiles($medias, $eagerSelect = null)
    {
        if (is_string($medias)) {
            $medias = [$medias];
        }

        $builded = []; 

        foreach ($medias as $relatable => $relationOrClosure) {
            if ($relationOrClosure instanceof Closure) {
                $builded["media_{$relatable}"] = $relationOrClosure;
                continue;
            }
            $builded[] = "media_{$relationOrClosure}:".($eagerSelect ?? $this->defaultMediaLibraryEagerSelect);
        }

        return $builded;
    }    
}