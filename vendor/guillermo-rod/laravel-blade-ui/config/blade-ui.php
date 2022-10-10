<?php

use GuillermoRod\BladeUi\Components\Alerts\Alert;
use GuillermoRod\BladeUi\Components\BladeUiComponent;
use GuillermoRod\BladeUi\Components\Forms\Button;
use GuillermoRod\BladeUi\Components\Forms\LinearInput;
use GuillermoRod\BladeUi\Components\Forms\LinearSelect;
use GuillermoRod\BladeUi\Components\Forms\LinearTextarea;
use GuillermoRod\BladeUi\Components\Loaders\Loading;
use GuillermoRod\BladeUi\Components\Modals\SimpleModal;
use GuillermoRod\BladeUi\Components\Tables\Table;

return [

    /*
    |--------------------------------------------------------------------------
    | Components Prefix
    |--------------------------------------------------------------------------
    |
    | This value will set a prefix for all Blade UI components.
    | By default it's empty. This is useful if you want to avoid
    | collision with components from other libraries.
    |
    | If set with "star", for example, you can reference components like:
    |
    | <x-star-linear-input />
    |
    | by default is "bui", otherwise if you need disable the prefixing use BladeUiComponent::NULL_PREFIX
    | for
    */    

    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Below you reference all components that should be loaded for your app.
    | By default all components from Blade UI Kit are loaded internally
    |
    */

    'components' => [
        'linear-input'    => LinearInput::class,
        'linear-textarea' => LinearTextarea::class,
        'linear-select'   => LinearSelect::class,
        'loading'         => Loading::class,
        'simple-modal'    => SimpleModal::class,
        'table'           => Table::class,
        'button'          => Button::class,
        'alert'           => Alert::class
    ]
];
