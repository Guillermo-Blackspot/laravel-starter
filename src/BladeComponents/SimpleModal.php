<?php

namespace BlackSpot\Starter\BladeComponents;

use Illuminate\View\Component;

class SimpleModal extends BaseComponent
{
    public $id, $title, $size, $bgColor, $theme;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title = null, $size = '', $bgColor = '', $theme = 'bootstrap4')
    {        
        parent::__construct(compact('id','title','size','bgColor','theme'));

        $this->fillAttributes();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravel-starter::components.'.$this->theme.'.simple-modal');
    }
}
