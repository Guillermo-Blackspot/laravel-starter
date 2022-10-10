<?php

namespace GuillermoRod\BladeUi\Components\Forms;

use GuillermoRod\BladeUi\Components\BladeUiComponent;
use GuillermoRod\BladeUi\Support\Castings\InputCastings;

class LinearInput extends BladeUiComponent
{
    use InputCastings;

    protected $subFolders = 'forms';

    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var string */
    public $value;

    /** @var string */
    public $label;

    /** @var string */
    public $enableErrors;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $name = null, $label = null, $enableErrors = true, $value = null, $theme = 'bootstrap4')
    {      
        $this->type  = $type;
        $this->name  = $name;
        $this->label = $label;
        $this->enableErrors = $enableErrors;
        $this->theme = $theme;
        if ($name != null) {
            $this->value = old($name, $value ?? '');
        }

        $this->addTraitCastings('JsonAttributeCastings', [
            'label-jattributes'     => 'jAttributesRule',
            'error-jattributes'     => 'jAttributesRule',
            'container-jattributes' => 'jAttributesRule',
            'input-jattributes'     => 'jAttributesRule',
        ]);    
        
        // $this->addDefaultAttributes([
        //     'attributes.required' => false
        // ]);
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
