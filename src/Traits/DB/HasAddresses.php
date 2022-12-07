<?php

namespace BlackSpot\Starter\Traits\DB;

trait HasAddresses
{
    /**
     * Boot on delete method
     */
    public static function bootHasAddresses()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }
            $model->addresses()->delete();
        });
    }

    public function addresses(){
        return $this->morphMany(config('laravel-starter.table_namespaces.address'), 'addressable');
    }

    public function main_address()
    {
        return $this->morphOne(config('laravel-starter.table_namespaces.address'), 'addressable')->where('main',true);
    }
}

