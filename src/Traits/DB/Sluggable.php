<?php
namespace BlackSpot\Starter\Traits\DB;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Sluggable
{
    private function getSlugColumn()
    {
        if (property_exists($this, 'slugColumn')) {
            return $this->slugColumn;
        }
        return 'slug';
    }

    private function setSlugValue($slug)
    {
        return $this->{$this->getSlugColumn()} = $slug;
    }

    /**
     * Check if exists the slug prospect
     * 
     * @param string $prospect
     * @return boolean 
     */
    public function slugProspectExists($prospect)
    {
        $query = DB::table($this->getTable())
                    ->where($this->getSlugColumn(), $prospect)
                    ->where('id', '!=', $this->id);

        if (method_exists($this, 'sluggableScopeBuilder')) {
            $this->sluggableScopeBuilder($query);
        }

        return $query->exists();
    }
    
    /**
     * Generate the unique slug
     * 
     * @param string $fromString
     * @return string
     */
    public function generateSlugProspect($fromString)
    {   
        if ($this->slugProspectExists($fromString)) {
            $diffStr = Str::slug(Str::random(5));
            //session()->flash('slug-info',"El slug ingresado ya existe, se agrego \"{$diffStr}\" para hacerlo único");
            return $this->generateSlugProspect($fromString.'-'.$diffStr);
        } 

        return Str::slug($fromString);
    }

    /**
     * Create the slug from a model attribute
     * 
     * @param string $attr
     * @throws \Exception
     * @return string
     */
    public function createSlug($attr)
    {        
        if (!isset($this->attributes[$attr]) && !isset($this->original[$attr]) && !property_exists($this,$attr)) {
            throw new \Exception("{$this->table}:{$attr} not exists", 1);
        }

        if (empty($this->{$attr}) || $this->{$attr} == null) {
            session()->flash('slug-error',"Para usar este método el campo no debe estar vacio.");
            return $this->setSlugValue(
                $this->createRandomSlug(27)
            );            
        }else{
            return $this->setSlugValue(
                $this->generateSlugProspect($this->{$attr})
            );
        }
    }

    /**
     * Create the slug from a input value
     * 
     * @param string $fromString
     * @return string
     */
    public function createSlugFrom($fromString)
    {
        return $this->setSlugValue(
            $this->generateSlugProspect($fromString)
        );
    }


    /**
     * Create the slug from a random string
     * 
     * @param int $size
     * @return string
     */
    public function createRandomSlug($size = 23)
    {
        return $this->setSlugValue(
            $this->generateSlugProspect(Str::random($size))
        );
    }

}
