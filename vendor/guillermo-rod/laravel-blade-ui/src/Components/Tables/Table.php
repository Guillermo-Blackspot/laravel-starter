<?php

namespace GuillermoRod\BladeUi\Components\Tables;

use GuillermoRod\BladeUi\Components\BladeUiComponent;

class Table extends BladeUiComponent
{
    protected $subFolders = 'tables';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($theme = 'bootstrap4')
    {      
        $this->theme = $theme;

        $this->addSameTraitCastingsToAttributes('JsonAttributeCastings',[
            'container-jattributes',
            'thead-jattributes',
            'tfoot-jattributes',
            'tbody-jattributes',
            'pagination-jattributes',
        ], 'jAttributesRule');
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
