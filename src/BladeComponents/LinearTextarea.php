<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\Traits\View\HasFormAttributes;
use BlackSpot\Starter\Traits\View\Helpers;
use Illuminate\View\Component;

class LinearTextarea extends BaseComponent
{
  use HasFormAttributes;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($label = null, $enableError = false, $theme = 'bootstrap4')
  {
    parent::__construct(compact('label','enableError','theme'));

    $this->hasFormAttributesTraitSettings();
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
