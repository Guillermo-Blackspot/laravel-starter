<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\ArrayableClass;
use BlackSpot\Starter\Traits\View\CastAttributes;
use BlackSpot\Starter\Traits\View\Helpers;
use Closure;
use Exception;
use Illuminate\View\Component;

class BaseComponent extends Component
{
    use Helpers, CastAttributes;

    public $theme;
    protected $baseThemes;
    protected $constructorAttributes = [];
    protected $renderAttributes = [];
    protected $tempAttributes = [];
    protected $onRenderEvents = [];

    public const CUSTOM_THEMES_FOLDER = 'laravel-starter-themes';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($constructorArguments)
    {
        //$this->except     = $this->except;
        $this->baseThemes = ['bootstrap4'];
        $this->theme      = $constructorArguments['theme'];

        $this->mergeConstructorAttributes($constructorArguments);
        $this->helpersTraitSettings();
        $this->castAttributesTraitSettings();
    }

    /**
     * Validate if its a registered theme
     * 
     * @return boolean
     */
    public function itsABaseTheme()
    {
        return in_array($this->theme, $this->baseThemes);
    }

    /**
     * The render attributes ($renderAttributes) or the constructor attributes ($constructorAttributes)
     */
    protected function mergeNotExtendable($attributes)
    {
        $this->nonExtendable = array_merge($attributes, $this->nonExtendable);
    }

    /**
     * Attributes from the constructor
     * 
     * @param array 
     * @return void
     */
    private function mergeConstructorAttributes($attributes)
    {
        $this->constructorAttributes = array_merge($attributes, $this->constructorAttributes);
    }

    /**
     * ['renderName' => $data['attributes'][the-attribute-name-in-the-dom-target] ]
     *
     * @param array 
     * @return void
     */
    protected function mergeRenderAttributes($attributes)
    {
        $this->renderAttributes = array_merge($attributes, $this->renderAttributes);
        $this->mergeNotExtendable(array_keys($attributes));
        $this->mergeNotExtendable(array_values($attributes));
    }

    /**
     * The attributes that needs to be casted 
     * 
     * @param array
     * @return void
     */
    protected function mergeCastAttributeRules($casts)
    {
        $this->castAttributeRules = array_merge($this->castAttributeRules,$casts);
    }

    /**
     * The attributes and functions that are not 
     * accessible from the view
     * 
     * @param array
     * @return void
     */
    protected function mergeExceptAttributes($attributes)
    {
        $this->except = array_merge($this->except,$attributes);
    }

    /**
     * Events that will be called on render time
     * 
     * @param Closure|Callable|array<Closure></Closure>|array<Callable></Callable>
     * @param string $position 'after' = after render attributes, 'before' = before render attributes
     * @return void
     */
    protected function setOnRenderEvent($event, $position = 'after')
    {
        if (in_array($position,['after','before']) == false) {
            throw new Exception("Position does not exists! {$position}", 1);
        }

        if (is_array($event) == false) {
            $event = [$event];
        }

        if (isset($this->onRenderEvents[$position]) == false) {
            $this->onRenderEvents[$position] = [];
        }

        for ($i=0; $i < count($event) ; $i++) { 
            $this->onRenderEvents[$position][] = $event[$i];
        }
    }

    /**
     * Assign the array of values to the component properties and cast it
     * 
     * @param array $attributes
     * @return void
     */
    protected function fillAttributes(array $attributes = [])
    {
        if (empty($attributes)) {
            $attributes = $this->constructorAttributes;
        }

        foreach ($attributes as $key => $value) {
            $this->castedAttributes[$key] = $this->{$key} = $this->castAttribute($key, $value);
        }
    }

    /**
     * From the $data['attributes'] assign in a new array the alias property name with the original value of the dom element value
     * 
     * then cast it and assign to the attributes bag
     * 
     * @param array $data
     * @return void
     */
    private function fillRenderAttributes(array &$data)
    {
        $toFill = [];

        foreach ($this->renderAttributes as $setAlias => $originalAttribute) {
            if (isset($data['attributes'][$originalAttribute])) {
                $toFill[$originalAttribute] = $toFill[$setAlias] = $data['attributes'][$originalAttribute];
            }else{
                $toFill[$setAlias] = null;
            }
        }

        $this->fillAttributes($toFill);
    }

    /** 
     * Execute the render event listeners
     * 
     * @param array $data
     * @param string $position 'after' = after render attributes, 'before' = before render attributes
     * @return void
     */
    private function executeRenderEvents(&$data = [], $position = 'after')
    {
        if (isset($this->onRenderEvents[$position])) {
            foreach ($this->onRenderEvents[$position] as $event) {
                if ($event instanceof Closure) {
                    $event($data);
                }else {
                    $this->{$event}($data);
                }
            }
        }

    }
    

    /**
     * Inherit
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return function (array &$data)
        {
            $this->executeRenderEvents($data,'before');
            $this->fillRenderAttributes($data);
            $this->executeRenderEvents($data,'after');
            $data['castedAttributes'] = $this->castedAttributes = new ArrayableClass($this->castedAttributes);
            $data['arrayableAttributes'] = new ArrayableClass($data['attributes']);
            return $this->getComponentView($data)->render();
        };
    }

    /**
     * Get the view / view contents that represent the component.
     * Resolve if it owns to the laravel starter components or its in the root components directory
     *
     * @param array|\Illuminate\Support\Collection $data
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    protected function getComponentView($data = [])
    {        
        if ($this->itsABaseTheme()) {
            return $this->getBaseComponentView($data);
        }

        return view('components.'.self::CUSTOM_THEMES_FOLDER.".{$this->theme}.{$this->componentName}", $data);
    }

    /**
     * Get the view from the laravel starter components
     * 
     * @param array|\Illuminate\Support\Collection
     * @return \Illuminate\Contracts\View\View
     */
    protected function getBaseComponentView($data)
    {
        return view("laravel-starter::components.{$this->theme}.{$this->componentName}", $data);
    }


    /**
     * If the property does not exist, such as the rendering attributes: isRequired, isHidden, isSomething
     * is pushed into the attribute bag
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name) == false) {
            $this->attributes[$name] = $value;
        }
    }
}
