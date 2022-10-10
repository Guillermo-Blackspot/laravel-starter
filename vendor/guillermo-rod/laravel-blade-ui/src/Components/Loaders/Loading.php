<?php

namespace GuillermoRod\BladeUi\Components\Loaders;

use GuillermoRod\BladeUi\Components\BladeUiComponent;

class Loading extends BladeUiComponent
{
    protected $subFolders = 'loaders';

    /** @var string */
    public $text;

    /** @var string */
    public $type;

    /** @var string */
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text = null, $type = 'circle', $color = '#2196f3', $theme = '_utils')
    {      
      $this->text  = $text;
      $this->type  = $type;
      $this->theme = $theme;
      $this->color = $color;
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
