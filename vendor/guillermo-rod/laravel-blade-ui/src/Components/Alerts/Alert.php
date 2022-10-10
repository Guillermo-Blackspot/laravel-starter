<?php

namespace GuillermoRod\BladeUi\Components\Alerts;

use GuillermoRod\BladeUi\Components\BladeUiComponent;

class Alert extends BladeUiComponent
{
    protected $subFolders = 'alerts';

    /** @var boolean */
    public $closeButton;

    /** @var string */
    public $flash;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($closeButton = true, $flash = null, $theme = 'bootstrap4')
    {      
      $this->closeButton = filter_var($closeButton, FILTER_VALIDATE_BOOLEAN);
      $this->theme       = $theme;
      $this->flash       = $flash;

      $this->addSameTraitCastingsToAttributes('JsonAttributeCastings',[
        'heading-jattributes',
        'close-button-jattributes',
        'jattributes',
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
