<?php
namespace BlackSpot\Starter\Traits\Vendor\MediaLibrary;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;

trait DynamicMediaConversions 
{
    /**
     * Register the media collections dynamically
     * 
     * @param boolean $single
     * @return void
     */
    public function ___registerMediaCollections($single = true): void
    {
        $collections = $this->getFilesManagerMediaConversions();

        foreach ($collections as $collection => $conversions) {            

            $mediaCollection = MediaCollection::create($collection);

            if ($single) {
                $mediaCollection = $mediaCollection->singleFile();
            }

            $this->mediaCollections[] = $mediaCollection;
        }
    }                                                           

    /**
     * Register the media conversions dynamically
     * 
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media $media
     * @return void
     */
    public function ___registerMediaConversions(Media $media = null): void
    {
        $collections = $this->getFilesManagerMediaConversions();

        foreach ($collections as $collection => $conversions) {

            foreach ($conversions as $conversionName => $dynamicFunctions) {                                

                $conversion = Conversion::create($conversionName)
                                    ->performOnCollections($collection);
             
                foreach ($dynamicFunctions as $fn => $value) {                    
                    $conversion = is_array($value)
                                    ? $conversion->{$fn}(...$value)
                                    : $conversion->{$fn}($value);
                }

                $this->mediaConversions[] = $conversion;
            }

        }
    }

    /**
     * Get the media default image url
     * 
     * Take from the model mutator getter attribute with the suffix _link
     * if not exists take from the placeholder web site
     * 
     * @param string $collection 
     * @param string $dimension
     * @param string $default
     * @return string
     */
    public function getMediaDefaultUrl($collection, $dimension, $default = '')
    {
        if (blank($default)) {        
            $conversions           = $this->getFilesManagerMediaConversions(Str::firstWhereStrpos('.', $collection),$dimension);
            $modelMutatorAttribute = $this->getFilesManagerMediaFacadeCollectionFiles($collection); 
            $width                 = Arr::get($conversions, 'width', 1080);
            $height                = Arr::get($conversions, 'height', 720);

            if ($modelMutatorAttribute != null && ($url = $this->{$modelMutatorAttribute.'_link'}) != null) return $url;

            $imagePlaceHolder = config('filesmanager.model_settings.shared.image_placeholder') ?? [];

            $url        = rtrim(Arr::get($imagePlaceHolder, 'url', 'https://via.placeholder.com/'),'/');
            $color      = Arr::get($imagePlaceHolder, 'color', 'ffffff');
            $background = Arr::get($imagePlaceHolder, 'background', '000000');
            $text       = Arr::get($imagePlaceHolder, 'text', 'Sin+{:attr}+o+procesando');
            $width      = Arr::get($imagePlaceHolder, 'width', $width);
            $height     = Arr::get($imagePlaceHolder, 'height', $height);            
            return str_replace('{:attr}', $modelMutatorAttribute, "{$url}/{$width}x{$height}.jpg/{$background}/{$color}?text={$text}");
        }

        return $default;
    }

    /**
     * Get the converted thumbnail from spatie media library
     * 
     * @param string $collection 
     * @param string $dimension
     * @param string|null $default
     * @return string
     */
    public function getMediaUrl(string $collection, string $conversion, $default = null)
    {
        $keys = null;

        // For retrieves an item from a nested collection

        if (($index = strpos($collection,'.')) !== false) {
            $keys       = substr($collection,$index + 1, strlen($collection));
            $collection = substr($collection,0,$index);
        }
        
        $attribute = 'media_'.$collection;    

        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection */
        $mediaCollection = $this->{$attribute};
        
        if ($mediaCollection != null && $mediaCollection->isNotEmpty()) {            
            try { 
                $concreteMedia = ($keys != null) 
                                    ? $mediaCollection->firstWhere('name',$keys)
                                    : $mediaCollection->first();

                if (isset($concreteMedia->generated_conversions[$conversion]) && $concreteMedia->generated_conversions[$conversion] == true) {
                    return $concreteMedia->getUrl($conversion);
                }
            } catch (\Exception $th) { }
        }

        if ($keys != null) {
            $collection .= '.'.$keys;
        }

        return $this->getMediaDefaultUrl($collection, $conversion, $default);
    }



    /**
     * Get the media conversions (width and height)
     * 
     * @throws \Exception
     * @return array 
     */
    public function getFilesManagerMediaConversions(...$args)
    {
        if (method_exists($this, 'getConversions')) {
            return $this->getConversions(...$args);
        }else if (config()->has('filesmanager.model_settings.'.get_class($this).'.conversions')) {
            $conversions = config('filesmanager.model_settings.'.get_class($this).'.conversions');
            if (!isset($args[0]) && !isset($args[1])) {
                return $conversions;
            }
            return $conversions[$args[0]][$args[1]];
        }else{
            throw new Exception(__FUNCTION__.' no dimensions found '.get_class($this), 1);
        }
    }

    /**
     * Get the media facade files 
     * 
     * @throws \Exception
     * @return string 
     */
    public function getFilesManagerMediaFacadeCollectionFiles($collection)
    {
        return Str::lastWhereStrpos('.', $collection);

        // $facadeFiles = [];

        // if (method_exists($this,'getFacadeCollectionFiles')) {            
        //     $facadeFiles = $this->getFacadeCollectionFiles($collection);             
        // }else if (config()->has('filesmanager.model_settings.'.get_class($this))) {
        //     $facadeFiles = config('filesmanager.model_settings.'.get_class($this).'.facade_collections');
        // }

        // dd(
        //    $facadeFiles , $collection
        // );        
        // return Arr::get($facadeFiles, $collection);
    }

}
