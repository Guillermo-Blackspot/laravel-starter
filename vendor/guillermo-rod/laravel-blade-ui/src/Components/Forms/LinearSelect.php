<?php

namespace GuillermoRod\BladeUi\Components\Forms;

use GuillermoRod\BladeUi\Components\BladeUiComponent;
use GuillermoRod\BladeUi\Support\Castings\InputCastings;

class LinearSelect extends BladeUiComponent
{
    use InputCastings;

    protected $subFolders = 'forms';

    /** @var string */
    public $name;

    /** @var string */
    public $label;

    /** @var string */
    public $enableErrors;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = null, $label = null, $enableErrors = true, $theme = 'bootstrap4')
    {      
        $this->name         = $name;
        $this->label        = $label;
        $this->enableErrors = $enableErrors;
        $this->theme        = $theme;

        $this->addTraitCastings('JsonAttributeCastings', [
            'label-jattributes'     => 'jAttributesRule',
            'error-jattributes'     => 'jAttributesRule',
            'container-jattributes' => 'jAttributesRule',
            'select-jattributes'  => 'jAttributesRule',
        ]);        
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
