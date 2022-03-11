<?php
namespace BlackSpot\Starter\Traits\Vendor\Livewire;

trait InteractsWithInputs
{
    public $inputModifications = [];
    public $exceptInputsForModifications = [
        'modifications' => [],
        'excepting'     => []
    ];

    public function setInputModifications($inputModifications = [])
    {
        $this->inputModifications = $inputModifications;

        foreach ($this->inputModifications as $key => $value) {
            if (is_array($value) == false) {
                $this->inputModifications[$key] = explode('|', $value);
            }
        }
    }

    public function setInputModificationsExcepting($inputModifications, $exceptInputs)
    {
        
        $this->exceptInputsForModifications['modifications'] = $inputModifications;
        $this->exceptInputsForModifications['excepting'] = $exceptInputs;
    }

    public function inputModifierExists($keyName)
    {
        
        if (!empty($this->exceptInputsForModifications['modifications']) && !empty($this->exceptInputsForModifications['excepting']) && !in_array($keyName, $this->exceptInputsForModifications['excepting'])) {
            $this->inputModifications[$keyName] = $this->exceptInputsForModifications['modifications'];
        }

        return isset($this->inputModifications[$keyName]);
    }

    public function parseAttributeAndCustomValue($value)
    {
        $attr = $value;

        if (($offset = strpos($attr, ':')) !== false) {            
            $attr  = substr($value, 0, $offset);
            $value = substr($value,$offset+1, strlen($value));
        }

        return compact('attr','value');
    }

    public function applyModifications($keyName)
    {
        if ($this->inputModifierExists($keyName) == false) {
            return '';
        }

        $rawHTML = '';

        foreach ($this->inputModifications[$keyName] as $key => $value) {
            $parsed = $this->parseAttributeAndCustomValue($value);     
            $rawHTML .= $parsed['attr'] . '=' . "'{$parsed['value']}'";
            $rawHTML .= ' ';
        }

        return $rawHTML;
    }


    public function isTarget($keyName, $hasValidation)
    {
        if ($this->inputModifierExists($keyName) == false) {
            return false;
        }

        if (in_array($hasValidation,$this->inputModifications[$keyName])) {
            return true;
        }

        foreach ($this->inputModifications[$keyName] as $key => $value) {
            $parsed = $this->parseAttributeAndCustomValue($value);            
            if ($parsed['attr'] == $hasValidation) {
                return true;    
            }
        }

        return false;
    }

    public function getModificationValue($keyName, $hasValidation)
    {
        if ($this->inputModifierExists($keyName) == false) {
            return null;
        }

        foreach ($this->inputModifications[$keyName] as $key => $value) {
            $parsed = $this->parseAttributeAndCustomValue($value);            
            if ($parsed['attr'] == $hasValidation) {
                return $parsed['value'];
            }
        }

        return null;
    }


    public function resetDomModifications()
    {
        $this->inputModifications = [];
        $this->exceptInputsForModifications = [
            'modifications' => [],
            'excepting'     => []
        ];
    }


}
