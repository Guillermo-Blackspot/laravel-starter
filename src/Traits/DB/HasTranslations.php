<?php

namespace BlackSpot\Starter\Traits\DB;

use Exception;

trait HasTranslations
{
    /**
     * Set an model attribute translation
     * 
     * @param string $attr
     * @param string $lang
     * @param string|null $translation
     * @throws \Exception
     * @return void
     */
    public function setTranslation($attr, $lang, $value = null)
    {
        if ($this->id == null) {
            throw new Exception('The '.__FUNCTION__.' must be called after create the '.self::class, 1);
        }        

        $model = config('laravel-starter.table_namespaces.translation');

        (new $model)->where('lang', $lang)->updateOrCreate(
            [
                'attribute'  => $attr,
                'model_type' => self::class,
                'model_id'   => $this->id
            ],
            [
                'lang'        => $lang,
                'translation' => $value,
                'attribute'   => $attr
            ]
        );
    }    

    /**
     * Get the translation of attribute previously loaded from the db
     * 
     * @param string $lang
     * @param string $attribute
     * @param string|nullable $default
     * 
     * @return string
     */
    public function getTranslation($lang, $attribute, $default = null)
    {
        if ($this->relationLoaded('translations') && $this->translations->isNotEmpty()) {        
            return optional($this->translations->where('attribute', $attribute)->firstWhere('lang', $lang))->translation ?? $default ?? $this->{$attribute};
        }
        return $default ?? $this->{$attribute};
    }

    /**
     * Get the translation of attribute previously loaded from the db with the current appLocale
     * 
     * @param string $attribute
     * @param string|nullable $default
     * 
     * @return string
     */
    public function getTranslationWithLocale($attribute, $default = null)
    {
        $lang = app()->getLocale();

        return $this->getTranslation($lang, $attribute, $default);
    }    

    /**
     * The eager loading for translations
     * 
     */
    private function eagerLoadingTranslationsQuery($lang, $whereAttribute = '*', $eagerLoading = 'id,lang,model_type,model_id,attribute,translation')
    {
        return [
            'translations' => function($query) use($lang, $eagerLoading, $whereAttribute){
                $select = explode(',', $eagerLoading);
                $query->select(...$select)
                    ->when($whereAttribute != '*', function($query) use($whereAttribute){
                        $query->where('attribute', $whereAttribute);
                    })
                    ->where('lang', $lang);
            }
        ];
    }

    /**
     * Load translations in a model instance
     */
    public function loadTranslations($lang, $whereAttribute = '*', $eagerLoading = 'id,lang,model_type,model_id,attribute,translation')
    {
        $this->load($this->eagerLoadingTranslationsQuery($lang, $whereAttribute, $eagerLoading));
    }
    
    /**
     * Scope translations
     */
    public function scopeWithTranslations($query, $lang, $whereAttribute = '*', $eagerLoading = 'id,lang,model_type,model_id,attribute,translation')
    {
        return $query->with($this->eagerLoadingTranslationsQuery($lang, $whereAttribute, $eagerLoading));
    }

    /**
     * The translations that belongs to model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function translations()
    {
        return $this->morphMany(config('laravel-starter.table_namespaces.translation'), 'model');
    }
}