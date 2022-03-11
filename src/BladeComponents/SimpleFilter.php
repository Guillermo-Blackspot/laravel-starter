<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\Traits\View\Helpers;
use Illuminate\View\Component;

class SimpleFilter extends Component
{
    use Helpers;

    public $wire, $wirePages, $wireSearch, $columnsToSearch, $inSearch, $searchValue, $theme;

    /**
     * Create a new component instance.
     *
     * @param bool $wire
     * @param string $wirePages
     * @param string $wireSearch
     * @param mixed $columnsToSearch
     * @return void
     */
    public function __construct($wire = false, $wirePages = 'perPage', $wireSearch = 'search', $columnsToSearch = null, $inSearch = false, $searchValue = null, $theme = 'bootstrap4')
    {
        if ($columnsToSearch == null) {
            $columnsToSearch = 'Busca y filtra';
        }
        
        $this->wire            = $wire;
        $this->wirePages       = $wirePages;
        $this->wireSearch      = $wireSearch;
        $this->columnsToSearch = $columnsToSearch;
        $this->inSearch        = $inSearch;
        $this->searchValue     = $searchValue;
        $this->theme = $theme;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravel-starter::components.'.$this->theme.'.simple-filter');
    }
}
