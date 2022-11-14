<?php

namespace BlackSpot\Starter\Traits\Vendor\Livewire;

trait TrimAndNullEmptyStrings
{
    /**
     * @var string[]
     */
    protected $convertEmptyStringsExcept = [];

    public function updatedTrimAndNullEmptyStrings($name, $value)
    {
        if (in_array($name, $this->convertEmptyStringsExcept)) {
            return ;
        }

        if (is_string($value)) {
            $value = trim($value);
            $value = $value === '' ? null : $value;

            data_set($this, $name, $value);
        }
    }
}