<?php

namespace GuillermoRod\BladeUi\Components\Forms;

use GuillermoRod\BladeUi\Components\BladeUiComponent;

class Button extends BladeUiComponent
{
    protected $subFolders = 'forms';

    /** @var string */
    public $text;

    /** @var string */
    public $icon;

    /** @var string */
    public $htmlIcon;

    /** @var string */
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'button', $text = null, $icon = null, $htmlIcon = null, $theme = 'bootstrap4')
    {      
        $this->type = $type;
        $this->text = $text;
        $this->icon = $icon;
        $this->theme = $theme;
        $this->htmlIcon = $htmlIcon;
        
        $this->addTraitCastings('JsonAttributeCastings', [
            'jattributes' => 'jAttributesRule'
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
