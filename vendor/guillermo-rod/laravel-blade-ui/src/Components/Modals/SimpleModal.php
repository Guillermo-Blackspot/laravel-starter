<?php

namespace GuillermoRod\BladeUi\Components\Modals;

use GuillermoRod\BladeUi\Components\BladeUiComponent;

class SimpleModal extends BladeUiComponent
{
    protected $subFolders = 'modals';

    /** @var string */
    public $id;

    /** @var string */
    public $type;

    /** @var string */
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $theme = 'bootstrap4')
    {      
      $this->id  = $id;
      $this->theme = $theme;
      
      $this->addSameTraitCastingsToAttributes('JsonAttributeCastings',[
        'container-jattributes',
        'dialog-jattributes',
        'content-jattributes',
        'header-jattributes',
        'title-jattributes',
        'close-jattributes',
        'body-jattributes',
        'footer-jattributes'
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
