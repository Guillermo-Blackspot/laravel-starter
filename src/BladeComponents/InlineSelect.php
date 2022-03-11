<?php
namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\Traits\View\HasFormAttributes;
use Illuminate\View\Component;
use BlackSpot\Starter\Traits\View\Helpers;

class InlineSelect extends BaseComponent
{
  use HasFormAttributes;

  /**
   * Create a new component instance.
   *
   * @return void
   */
    public function __construct($label = null, $enableError = false, $condensed = true, $condensedSize = null, $theme = 'bootstrap4')
    {

      parent::__construct(compact('label','enableError','condensed','condensedSize','theme'));

      $this->hasFormAttributesTraitSettings();
    }


  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return parent::render();
  }
}
