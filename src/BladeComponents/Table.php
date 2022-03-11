<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\Traits\View\Helpers;

class Table extends BaseComponent
{    
    public $isReady;
    public $includeTr;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isReady = true, $includeTr = true, $theme = 'bootstrap4')
    {
        parent::__construct(compact('isReady','includeTr','theme'));

        $this->mergeCastAttributeRules([
            'isReady'   => 'boolean',
            'includeTr' => 'boolean'
        ]);

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
