<?php
namespace BlackSpot\Starter\BladeComponents;

use Illuminate\View\Component;
use BlackSpot\Starter\BladeComponents\BaseComponent;
use BlackSpot\Starter\Traits\View\HasFormAttributes;

class InlineInput extends BaseComponent
{
  use HasFormAttributes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $label = null, $enableError = false, $condensed = true, $condensedSize = null, $theme = 'bootstrap4')
    {
      
      parent::__construct(compact('type','label','enableError','condensed','condensedSize','theme'));

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
