<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\Traits\View\Helpers;
use Illuminate\View\Component;

class InputFilter extends BaseComponent
{
    
    public $wire, $wirePages, $wireSearch, $columnsToSearch, $inSearch, $searchValue, $disableEnterKey, $theme;

    /**
     * Create a new component instance.
     *
     * @param bool $wire
     * @param string $wirePages
     * @param string $wireSearch
     * @param mixed $columnsToSearch
     * @return void
     */
    public function __construct($wire = false, $wirePages = 'perPage', $wireSearch = 'search', $columnsToSearch = null, $inSearch = false, $searchValue = null, $disableEnterKey = false, $theme = 'bootstrap4')
    {
        if ($columnsToSearch == null) {
            $columnsToSearch = 'Busca y filtra';
        }
        parent::__construct(compact('wire','wirePages','wireSearch','columnsToSearch','inSearch','searchValue','disableEnterKey','theme'));        

        $this->mergeCastAttributeRules([
            'disableEnterKey' => 'boolean'
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
