<?php
namespace BlackSpot\Starter\Traits\Vendor\Livewire;

trait InteractsWithDomElements
{
    public $domModifications = [];
    public $exceptDomModifications = [
        'modifications' => [],
        'excepting'     => []
    ];

    public function setdomModifications($domModifications = [])
    {
        $this->domModifications = $domModifications;

        foreach ($this->domModifications as $key => $value) {
            if (is_array($value) == false) {
                $this->domModifications[$key] = explode('|', $value);
            }
        }
    }

    public function setDomModificationsExcepting($domModifications, $exceptInputs)
    {        
        $this->exceptDomModifications['modifications'] = $domModifications;
        $this->exceptDomModifications['excepting']     = $exceptInputs;
    }

    public function domModifierExists($keyName)
    {
        if (!empty($this->exceptDomModifications['modifications']) && !empty($this->exceptDomModifications['excepting']) && !in_array($keyName, $this->exceptDomModifications['excepting'])) {
            $this->domModifications[$keyName] = $this->exceptDomModifications['modifications'];
        }

        return isset($this->domModifications[$keyName]);
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
        if ($this->domModifierExists($keyName) == false) {
            return '';
        }

        $rawHTML = '';

        foreach ($this->domModifications[$keyName] as $key => $value) {
            $parsed = $this->parseAttributeAndCustomValue($value);     
            $rawHTML .= $parsed['attr'] . '=' . "'{$parsed['value']}'";
            $rawHTML .= ' ';
        }

        return $rawHTML;
    }

    public function isTarget($keyName, $hasValidation)
    {
        if ($this->domModifierExists($keyName) == false) {
            return false;
        }

        if (in_array($hasValidation,$this->domModifications[$keyName])) {
            return true;
        }

        foreach ($this->domModifications[$keyName] as $key => $value) {
            $parsed = $this->parseAttributeAndCustomValue($value);            
            if ($parsed['attr'] == $hasValidation) {
                return true;    
            }
        }

        return false;
    }

    public function getModificationValue($keyName, $hasValidation)
    {
        if ($this->domModifierExists($keyName) == false) {
            return null;
        }

        foreach ($this->domModifications[$keyName] as $key => $value) {
            $parsed = $this->parseAttributeAndCustomValue($value);            
            if ($parsed['attr'] == $hasValidation) {
                return $parsed['value'];
            }
        }

        return null;
    }


    public function resetDomModifications()
    {
        $this->domModifications = [];
        $this->exceptDomModifications = [
            'modifications' => [],
            'excepting'     => []
        ];
    }


}
