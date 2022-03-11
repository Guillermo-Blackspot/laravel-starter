<?php

namespace BlackSpot\Starter\BladeComponents;

class SimpleButton extends BaseComponent
{
    public $type, $icon, $text, $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'button', $icon = null, $text = null, $link = null, $theme = 'bootstrap4')
    {
        parent::__construct(compact('type','icon','text','link','theme'));

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
