<?php
namespace BlackSpot\Starter\Traits\View;

use Illuminate\Support\Arr;

trait Helpers
{

  protected $nonExtendable = [
    'hidden',
    'disabled',
    'value',
    'class',
    'placeholder',
    'required',
    'condensed-size',
    'label-class',
    'raw'
  ];


  public function helpersTraitSettings()
  {
    $this->mergeExceptAttributes([
      'helpersTraitSettings',
      'divideAttributes',      
    ]);

    $this->mergeRenderAttributes([
      'isHidden'   => 'hidden',
      'isDisabled' => 'disabled'
    ]);

    $this->mergeCastAttributeRules([           
      'isHidden'   => 'fn:castIsHidden',
      'isDisabled' => 'fn:castIsDisabled',
    ]);
  }


  /**
   * Divide the value of an attribute in many parts and assign them
   * 
   * @param string $separator
   * @param string $input
   * @param mixed $vars
   * @return void
   */
  public function divideAttribute($separator, $input, &...$vars)
  {
    if (strpos($input, $separator) !== false) {

      foreach (explode($separator, $input) as $key => $value) {
        $vars[$key] = $value;
      }

      extract($vars);

    }else{
      $vars[0] = $input;
    }
  }





  /** 
   * Convert the blade component attributes
   * to collection
   * 
   * @param array $attributes
   * @return \Illuminate\Support\Collection 
   */
  public function attributesToCollect($attributes)
  {
    return collect(array_values((array) $attributes)[0]);
  }  


  /**
   * Convert an array of attributes to html string attributes
   * 
   * @param \ArrayAccess
   * @return string
   */
  public function toHTML($attributes)
  {       
    $html = '';
   
    foreach ($attributes as $key => $value) {
      if (is_array($value) || in_array($key, $this->nonExtendable)) {
        continue;
      }

      $html .= "{$key}=\"{$value}\" ";
    }
    
    return $html;
  }


  /**
   * Get all inheritable attributes
   * 
   * @param \ArrayAccess
   * @return array
   */
  public function extends($attributes)
  {
    $except = [];
    
    foreach ($attributes as $key => $value) {
      if (is_array($value) || in_array($key, $this->nonExtendable)) {
        continue;
      }
      $except[$key] = $value;
    }

    return $except;
  }


}
