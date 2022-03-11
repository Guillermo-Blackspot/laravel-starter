<?php

namespace BlackSpot\Starter\BladeComponents;

use Illuminate\View\Component;

class Loading extends Component
{

    public $width, $theme;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($width = '70px', $theme = 'bootstrap4')
    {
        $this->width = $width;
        $this->theme = $theme;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravel-starter::components.'.$this->theme.'.loading');
    }
}
