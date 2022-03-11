<?php
namespace BlackSpot\Starter\BladeComponents;

use Illuminate\View\Component;
use BlackSpot\Starter\Traits\View\Helpers;

class InlineTextarea extends Component
{
    use Helpers;

    public $label,
          $enableError,
          $condensed,
          $condensedSize,
          $theme;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, $enableError = false, $condensed = true, $condensedSize = null, $theme = 'bootstrap4')
    {
      $this->label       = $label;
      $this->enableError = $this->filterBoolean($enableError);
      $this->condensed   = $this->filterBoolean($condensed);
      $this->condensedSize = [null,null];
      $this->theme = $theme;
      if ($condensedSize != null) {
        $this->condensedSize = explode(',',$condensedSize);
        if (count($this->condensedSize) < 2) {
          throw new \Exception("condensed-size expects two sizes: condensed-size='col-4,col-8'", 1);
        }
      }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('laravel-starter::components.'.$this->theme.'.inline-textarea');
    }
}
