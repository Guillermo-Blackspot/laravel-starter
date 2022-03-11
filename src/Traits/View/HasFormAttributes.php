<?php
namespace BlackSpot\Starter\Traits\View;

use BlackSpot\Starter\BladeComponents\BaseComponent;
use Exception;

trait HasFormAttributes
{
    public $type       = 'text',
        $label         = null,
        $enableError   = false,
        $condensed     = true,
        $condensedSize = [null, null],
        $labelClass    = null;


    public function hasFormAttributesTraitSettings()
    {
       
        if ($this instanceof BaseComponent) {
            /**
             * No accessible in view
             */
            $this->mergeExceptAttributes([
                'hasFormAttributesTraitSettings',
            ]);

            /**
             * Registering the cast result
             * on the attributes bag and making 
             * non extendible when call the method 
             * 
             * $toHTML($extends($attributesCollection))
             */
            $this->mergeRenderAttributes([
                'isRequired' => 'required',
                'isReadOnly' => 'readonly'
            ]);
            
            /** 
             * Defining the attribute cast rules 
             */
            $this->mergeCastAttributeRules([
                'condensed'     => 'boolean',            
                'condensedSize' => 'fn:castCondensedSize',
                'enableError'   => 'boolean',
                'isRequired'    => 'fn:castIsRequired',
                'isReadOnly'    => 'fn:castIsReadOnly'
            ]);            

            /** 
             * Adding extra validations
             * 
             */
            $this->setOnRenderEvent('trowIfEnableErrorsAndHasNotAName');

            /**
             * Filling and casting all the constructor attributes
             */        
            $this->fillAttributes(
                $this->constructorAttributes
            );
            
        }
    }  


    protected function trowIfEnableErrorsAndHasNotAName($data)
    {        
        if ($data['castedAttributes']['enableError']) {     
            if ($data['attributes']->has('name') == false) {
                throw new Exception("The enable-error attribute requires the name attribute in the target | example: <input enable-error=\"true\" name=\"email\" /> ", 1);                   
            }
        }

    }


}
