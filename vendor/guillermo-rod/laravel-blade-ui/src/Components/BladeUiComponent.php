<?php

namespace GuillermoRod\BladeUi\Components;

use Closure;
use Exception;
use GuillermoRod\BladeUi\LaravelBladeUiServiceProvider;
use GuillermoRod\BladeUi\Support\Castings\JsonAttributeCastings;
use GuillermoRod\BladeUi\Support\Traits\BootableTraitCastings;
use Illuminate\View\Component;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

class BladeUiComponent extends Component
{
    use BootableTraitCastings, JsonAttributeCastings;

    /**
     * Setting all component prefixes as null
     * 
     * @var string
     */
    public const NULL_PREFIX = '_null-prefix_';

    /**
     * The starter themes directory
     * 
     * @var const 
     */
    public const THEMES_DIRECTORY = 'vendor/laravel-blade-ui/components';    

    /**
     * Default starter themes 
     * 
     * @var array 
     */
    public const BASE_THEMES = [
        'bootstrap4',
    ];

    /** 
     * Component theme
     * 
     * @var string
     */
    protected $theme;

    /**
     * Default blade component theme
     * 
     * @static string
     */
    public static $defaultTheme;
     
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];        

    /**
     * The subfolder where the component is in
     * when prefixing the components the nested folders <x-prefix:subfolder.component />
     * are not allowed
     * 
     * @var string
     */
    protected $subFolders;

    /**
     * The default attributes that should be defined if not exists in the $data attributes, before render.
     *
     * @var array
     */
    protected $defaultAttributesToRender = [];

    
    /**
     * Define the attributes that will be aggregated to the $data attributes if not exists
     * 
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    protected function addDefaultAttributes($attribute, $value = null)
    {             
        if (!is_array($attribute)) {
            $attribute = [$attribute => $value];            
        }

        $this->defaultAttributesToRender = array_merge($this->defaultAttributesToRender, $attribute);
    }    

    /**
     * Add the default attributes to render to array $data
     * 
     * @param array $data
     * @return void
     */
    private function addDefaultAttributesToRenderToData(&$data)
    {
        foreach ($this->defaultAttributesToRender as $property => $value) {
            if (Str::contains($property, '.')) {
                $property = str_replace('attributes.','',$property); //sanitize .
                if (!isset($data['attributes'][$property])) {
                    $data['attributes'][$property] = $value;
                }
            }elseif (!isset($data[$property])) {
                $data[$property] = $value;
            }
        }
    }

    /**
     * Foreach registered cast validates if the property or attribute exits 
     * and apply the casting
     * 
     * @param array $data
     * @return void
     */
    private function castAttributes(&$data)
    {
        foreach ($this->casts as $traitClass => $castSettings) {

            $traitClassLowerCase = lcfirst($traitClass);

            foreach ($castSettings as $attribute => $castRule) { 

                //except : attributes, slot, __laravel_slots
                if (in_array($attribute, ['attributes', 'slot', '__laravel_slots', 'extraAttributes'])) {
                    continue;
                }

                $value = null;
                $key   = null;

                if (isset($data[$attribute])) { // Constructor attribute
                    $key   = $attribute;
                    $value = $data[$attribute];
                }else if (isset($data['attributes'][$attribute])) { // Target attribute
                    $key   = "attributes.{$attribute}";
                    $value = $data['attributes'][$attribute];
                }

                if (isset($value)) {
                    // $result = $value;

                    // if ($castRule instanceof Closure) {
                    //     $result = $castRule($data, $key, $value);
                    // }
                    $methodRule = $traitClassLowerCase.ucfirst($castRule);
                    $this->{$methodRule}($data, $key, $value);
                }
            }                
        }
    }

    /**
     * Determine if an attribute is of data['attributes'] or constructor attributes
     * and set the casted value
     */
    protected function resolveCastDataAttributeValue(&$data, $key, $value)
    {
        if (Str::contains($key, '.')) {
            //data['attributes']
            $exp = explode('.',$key);
            $key = end($exp);
            $data['attributes'][$key] = $value;
        }else{
            //Constructor / public attributes
            $data[$key] = $value;
        }
    }

    /**
     * Render the component view and create the properties object
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {        
        $this->bootTraitCastings();

        foreach (['NULL_PREFIX', 'THEMES_DIRECTORY', 'BASE_THEMES','useTheme'] as $key => $property) {
            $this->except[] = $property;
        }

        return function (array &$data)
        {
            $data['extraAttributes'] = new ComponentAttributeBag();

            $this->addDefaultAttributesToRenderToData($data);

            $this->castAttributes($data);

            return view($this->resolveComponentViewPath(), $data)->render();
        };
    }


    /**
     * Get the view / view contents that represent the component.
     * Resolve if it owns to the laravel starter components or its in the root components directory
     *
     * @param array|\Illuminate\Support\Collection $data
     * @return string
     */
    protected function resolveComponentViewPath()
    { 
        $theme                   = $this->getTheme();
        $unPrefixedComponentName = str_replace(config('blade-ui.prefix','bui').'-','',$this->componentName);
        $fakePath                = self::THEMES_DIRECTORY."/{$theme}/{$this->subFolders}/{$unPrefixedComponentName}"; //raw path
        $fakePath                = str_replace('//','/',str_replace('\\\\','\\',$fakePath)); //sanitize path    
        
        $laravelViews = resource_path("views/{$fakePath}.blade.php");

        if (file_exists($laravelViews)) {
            return $fakePath;
        }

        return str_replace('vendor/'.LaravelBladeUiServiceProvider::PACKAGE_NAME.'/', '', LaravelBladeUiServiceProvider::PACKAGE_NAME.'::'.$fakePath); // sanitize
    }
    
    /**
     * Validate if its a registered theme
     * 
     * @return bool
     */
    protected function isBaseTheme()
    {
        return in_array($this->theme, $this->BASE_THEMES);
    }

    /**
     * Indicate the them styling should be used for all components.
     *
     * @param string $theme
     * @return void
     */
    public static function useTheme($theme)
    {
        static::$defaultTheme = $theme;
    }

    /**
     * Get the component theme, assigned in provider, globally or the constructor theme
     */
    protected function getTheme()
    {
        if (static::$defaultTheme !== null) {
            return static::$defaultTheme;
        }
        return $this->theme;
    }
}
