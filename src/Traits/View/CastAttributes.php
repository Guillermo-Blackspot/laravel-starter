<?php

namespace BlackSpot\Starter\Traits\View;

use BlackSpot\Starter\BladeComponents\BaseComponent;
use Closure;
use Exception;
use Illuminate\Support\Arr;

trait CastAttributes
{
    /**
     * Constructor attributes and casted attributes from the cast rules
     */
    public $castedAttributes = [];
    public $castAttributeRules = [];

    public function castAttributesTraitSettings()
    {
        if ($this instanceof BaseComponent) {
            $this->mergeExceptAttributes([
                'castAttributeRules'
            ]);
        }
    }

    public function filterBoolean($originalValue)
    {
        return filter_var($originalValue,FILTER_VALIDATE_BOOLEAN);
    }


    /**
     * Execute the casts if the attribute has castRule's
     * or return the original value
     * 
     * @param string $attribute
     * @param mixed $originalValue
     * @param mixed|null $nextCast
     * @param boolean $validateIfAttributeHasCastRule
     */
    public function castAttribute($attribute, $originalValue, $nextCast = null)
    {        

        if ($this->attributeHasCastRule($attribute) == false) {
            return $originalValue;
        }
    
        $castTo = $nextCast ?? $this->castAttributeRules[$attribute];
        
        if (strpos($castTo,'|') !== false) {                
            return $this->recursiveCasts($attribute, $originalValue, explode('|',$castTo));
        }elseif (is_array($castTo)) {
            return $this->recursiveCasts($attribute, $originalValue, $castTo);
        }else if (in_array($castTo,['boolean','bool'])) {
            return filter_var($originalValue,FILTER_VALIDATE_BOOLEAN);            
        }else if (in_array($castTo,['integer','int'])) {
            return filter_var($originalValue,FILTER_VALIDATE_INT);            
        }else if(strpos($castTo, 'FILTER_VALIDATE_') !== false){
            return filter_var($originalValue, $castTo);
        }elseif (strpos($castTo, 'fn:') !== false) {
            return $this->{str_replace('fn:','',$castTo)}($originalValue);
        }elseif ($castTo instanceof Closure) {
            return $castTo($originalValue);
        }else{
            throw new Exception("Cast rule not exists! [{$castTo}]", 1);             
        }
    }

    /**
     * Recursive casts
     * 
     * @param string $attribute
     * @param mixed $originalValue
     * @param array $casts
     * @return mixed
     */
    public function recursiveCasts($attribute, $originalValue, array $casts)
    {
        $previousResult = null;

        foreach ($casts as $nextCast) {
            $previousResult =  $this->castAttribute($attribute, $previousResult ?? $originalValue, $nextCast);
        }

        if ($previousResult == null) {
            return $originalValue;
        }

        return $previousResult;
    }

    /**
     * Validate if attribute has cast rule
     * 
     * @param string $attribute
     * @return boolean
     */
    public function attributeHasCastRule($attribute)
    {
        return isset($this->castAttributeRules[$attribute]);
    }


    /**
     * Validate if an input is required or just must be show the "required message"
     * then return the required attribute or an empty string
     * 
     * @param \Illuminate\Support\Collection 
     * @return string
     */
    public function castIsRequired($rawValue = '')
    {        
        $parsed = [
            'text-only'   => false, 
            'bool'        => true, 
            'placeholder' => null,
            'html'        => ''
        ];

        if (strpos($rawValue,':') !== false) {
            $tokens              = explode(':',$rawValue);
            $parsed['text-only'] = $tokens[1] == 'text-only';
            $parsed['bool']      = $this->filterBoolean($tokens[0]);
        }else{
            $parsed['bool'] = $this->filterBoolean($rawValue);
        }

        if ($parsed['text-only'] == false) {
            $parsed['html'] = $parsed['bool']
                                ? 'required=required'
                                : '';
        }

        $parsed['placeholder'] = ($parsed['bool'])
                                ? 'requerido'
                                : 'opcional';
        return $parsed;
    }


    /**
     * Set the custom column position inside of the row
     * 
     * condensed-size="col-of-the-label,col-of-the-value"
     * 
     * div.row
     *    label.col-of-the-label
     *    input.col-of-the-input
     * 
     * @param boolean $condensed
     * @param array $condensedSize
     * @param mixed $label 
     * @return array ['input => 'col-of-input', 'label' => 'col-of-label']
     */
    public function castCondensedSize($condensedSize)
    {
        $parsed = [
            'label' => ($this->condensed) ? 'col-sm-2'  : 'col-auto',
            'input' => ($this->condensed) ? 'col-sm-10' : 'col-auto'
        ];

        if ($condensedSize == null || empty($condensedSize)) {
            return $parsed;
        }

        if (is_string($condensedSize)) {      
            $condensedSize = explode(',', $condensedSize);
            if (count($condensedSize) < 2) {
                throw new \Exception("condensed-size expects two sizes: condensed-size='col-4,col-8'", 1);
            }
        }

        if ($condensedSize[0] != null) {
            $parsed['label'] = $condensedSize[0];
        }
        if ($condensedSize[1] != null) {
            $parsed['input'] = $condensedSize[1];
        }

        if (is_null($this->label) && $this->condensed) {
            $parsed['input'] = 'col-sm-12';
        }

        return $parsed;  
    }



    /**
     * Validate if an input is hidden
     * then return the hidden attribute or an empty string
     * 
     * @param \Illuminate\Support\Collection 
     * @return string
     */  
    public function castIsHidden($originalValue)
    {              
        return $this->filterBoolean($originalValue)
                ? 'hidden="hidden"'
                : '';
    }

    /**
     * Validate if an input is disabled
     * then return the disabled attribute or an empty string
     * 
     * @param \Illuminate\Support\Collection 
     * @return string
     */  
    public function castIsDisabled($originalValue)
    {
        return $this->filterBoolean($originalValue)
                ? 'disabled="disabled"'
                : '';
    }


    public function castIsReadOnly($originalValue)
    {
        return $this->filterBoolean($originalValue) 
                ? 'readonly="readonly"' 
                : '';
    }

    
    

}

