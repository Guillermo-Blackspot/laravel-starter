<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\Traits\View\HasFormAttributes;
use Illuminate\View\Component;

class AdvancedMultiSelect extends BaseComponent
{
    use HasFormAttributes;

    public $placeholder, $options, $trackBy, $optionLabel, $fnToggle, $selected, $fnSearch, $key;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Seleccionar 1 o más', $placeholder = 'Por nombre', $options, $trackBy, $optionLabel, $fnToggle = 'toggleMultiSelect', $selected = [], $fnSearch = null, $theme = 'bootstrap4', $key = null)
    {

        parent::__construct(
            compact('label','placeholder','options','trackBy','optionLabel','fnToggle','selected','fnSearch','theme', 'key')
        );


        $this->fillAttributes();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return parent::render();
    }
}
