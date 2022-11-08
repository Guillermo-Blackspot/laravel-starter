<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\Traits\View\Helpers;
use Illuminate\View\Component;

class SimpleFilter extends Component
{
    use Helpers;

    public $inSearch, $theme;

    /**
     * Create a new component instance.
     *
     * @param bool $wire
     * @param mixed $columnsToSearch
     * @return void
     */
    public function __construct($inSearch = false, $theme = 'bootstrap4')
    {       
        $this->inSearch = $inSearch;
        $this->theme    = $theme;
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
