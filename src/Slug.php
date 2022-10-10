<?php 
namespace BlackSpot\Starter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Slug
{    
    private $table;
    private $column;
    private $maybeOwner;
    private $primaryColumn = 'id';

    public function __construct($table, $column, $maybeOwner = null){
        $this->table  = $table;
        $this->column = $column;
        $this->maybeOwner = $maybeOwner;
    }

    /**
     * Disable the primary comparison
     * 
     * @return $this
     */
    public function disablePrimaryColumnComparison()
    {
        $this->primaryColumn = false;
        return $this;
    }

    /**
     * Create the slug from a model attribute
     * 
     * @param object $modelInstance
     * @param string $attr
     * @param int $maybeOwner
     * @throws \Exception
     * @return string
     */
    public function createSlug(object $modelInstance, string $attr, $maybeOwner = null)
    {           
        if ($modelInstance instanceof Model) {
            if (!isset($modelInstance->attributes[$attr]) && !isset($modelInstance->original[$attr]) && !property_exists($modelInstance,$attr)) {
                throw new \Exception("{$this->table}:{$attr} not exists", 1);
            }
        }else if(!isset($modelInstance->{$attr})){
            throw new \Exception(get_class($modelInstance).":{$attr} not exists", 1);
        }

        if (empty($modelInstance->{$attr}) || $modelInstance->{$attr} == null) {
            //session()->flash('slug-error',"Para usar este método el campo no debe estar vacio.");
            return $this->createRandomSlug(27, $maybeOwner);       
        }else{
            return $this->generateSlugProspect($modelInstance->{$attr}, $maybeOwner);
        }
    }

    /**
     * Create the slug from a input value
     * 
     * @param string $fromString
     * @param int $maybeOwner
     * @return string
     */
    public function createSlugFrom($fromString, $maybeOwner = null)
    {
        return $this->generateSlugProspect($fromString, $maybeOwner);
    }


    /**
     * Create the slug from a random string
     * 
     * @param int $size
     * @param int $maybeOwner
     * @return string
     */
    public function createRandomSlug($size = 23, $maybeOwner = null)
    {
        return $this->generateSlugProspect(Str::random($size), $maybeOwner);
    }


        /**
     * Check if exists the slug prospect
     * 
     * @param string $prospect
     * @param int $maybeOwner
     * @return boolean 
     */
    public function slugProspectExists($prospect, $maybeOwner = null)
    {
        return  DB::table($this->table)
                    ->where($this->column, $prospect)
                    ->when($this->primaryColumn !== false, function($query) use($maybeOwner){
                        $query->where($this->primaryColumn, '!=', (int) $this->maybeOwner ?? ($maybeOwner > 0 ? $maybeOwner : null));   
                    })
                    ->exists();
    }
    
    /**
     * Generate the unique slug
     * 
     * @param string $fromString
     * @param int $maybeOwner
     * @return string
     */
    private function generateSlugProspect($fromString, $maybeOwner = null)
    {   
        if ($this->slugProspectExists($fromString, $maybeOwner)) {
            $diffStr = Str::slug(Str::random(5));
            //session()->flash('slug-info',"El slug ingresado ya existe, se agrego \"{$diffStr}\" para hacerlo único");
            return $this->generateSlugProspect($fromString.'-'.$diffStr, $maybeOwner);
        } 
        return Str::slug($fromString);
    }


}