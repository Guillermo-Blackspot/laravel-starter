<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Retrieve the currently authenticated user
 * 
 * @return \App\Models\User
 */
function user()
{
    return Auth::user();
}

/**
 * Retrieve the currently authenticated user's ID
 * 
 * @return int
 */
function userId()
{
  return Auth::user()->id;
}

/**
 * Retrieve the youtube video id
 *
 * @param string $youtubeUrl
 */
function get_youtube_video_id($youtubeUrl)
{
  if (Str::contains($youtubeUrl,'/embed/')) {
    return explode('/embed/',$youtubeUrl)[1];
  }elseif (Str::contains($youtubeUrl,'watch?v')){     
    return explode('&',explode('watch?v=',$youtubeUrl)[1])[0];            
  }elseif (Str::contains($youtubeUrl,'youtu.be')) {
    return explode('youtu.be/', $youtubeUrl)[1];
  }

  return $youtubeUrl;
}

/**
 * Retrieve the website favicon with google api
 * 
 * @param string $link
 * @return string
 */
function get_icon_url(string $link, $default = null){
  if($link != ''){
    $link = preg_replace('/^https?:\\/\\//', '', $link);
    $link = explode('/', $link)[0];
    if ($link != '') {
      return "https://www.google.com/s2/favicons?domain=" . $link;
    }
  }
  return $default ?? asset('/utils/images/favicon.ico');
}


/**
 * Parse to money format
 *
 * @param string $quantity
 * @return string
 */
function parse_money($quantity, $decimals = 2, $sepDecimals = '.', $sepThousands = ',')
{
  $quantity = trim($quantity);

  if ($quantity == 0 || $quantity < 0 || $quantity == null || $quantity == '') {
    return 0;
  }

  return number_format(
    $quantity,
    (int)    $decimals,
    (string) $sepDecimals,
    (string) $sepThousands
  );
}

if (!function_exists('parse_number')) {
  function parse_number($quantity, $decimals = 2, $sepDecimals = '.', $sepThousands = ',')
  {
    return parse_money($quantity, $decimals, $sepDecimals, $sepThousands);
  }
}

/**
 * Converts an input into array 
 * @param mixed $mixed
 * @return array
 */
if (!function_exists('to_array')) {  
  function to_array($mixed)
  {
    if (is_array($mixed)) {
      return $mixed;
    }elseif ($mixed instanceof \ArrayAccess) {
      return $mixed->toArray();
    }elseif (is_object($mixed)) {
      return (array)$mixed;
    }elseif (is_string($mixed)) {
      return json_decode($mixed, true);
    }
  }
}

/**
 * For divide permissions by modules
 * 
 * @param object $permission
 * @param \ArrayAccess $permissions
 * @param int $currentKey
 * @return array 
 */
function validate_if_previous_permission_belongs_to_another_module($permission, \ArrayAccess $permissions, int $currentKey){
  
  /**
  * Remove last word where appears dot "."
  */
  $module = substr($permission->name,0,strripos($permission->name,'.'));
  
  if (empty($module)) {
    $action     = $permission->name;
    $sameModule = false;
  }else{
    /**
    * Get the last word where appears dot "."
    */
    $action = strrchr($permission->name,'.');
    /**
     * Evaluate if its a different module from the previous one
     */
    $sameModule = strpos(optional($permissions[$currentKey-1])->name ?? '--no--', $module) !== false;
  }

  return compact('module','action','sameModule');
}

/**
 * Translate an month to language
 */
function translate_month($monthPosition, $lang = 'es', $join = '')
{
    $month = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    if ($monthPosition instanceof \Illuminate\Support\Carbon) {
        $monthPosition = (int) $monthPosition->format('m');
    }elseif (!is_numeric($monthPosition)) {
        $monthPosition = date('m',strtotime($monthPosition));
    }

    if (empty($join)) {
        return  $month[($monthPosition) - 1];
    }

    return str_replace('M', $month[($monthPosition) - 1], $join); 
}

if (!function_exists('phone_number_format')) {  
  function phone_number_format($number, $separator = '-') 
  {
    // Allow only Digits, remove all other characters.
    $number = preg_replace("/[^\d]/","",$number);
   
    // get number length.
    $length = strlen($number);
  
    // if number = 10
    if($length == 10) {
        $number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1{$separator}$2{$separator}$3", $number);
    }
    
    return $number;
  }
}

if (!function_exists('pretty_date')) {
  function pretty_date($date)
  {
      return date('d', strtotime($date)) . ' ' . translate_month(date('m', strtotime($date))) . ' ' . date('Y', strtotime($date));
  }
}


/**
 * array_merge_recursive does indeed merge arrays, but it converts values with duplicate
 * keys to arrays rather than overwriting the value in the first array with the duplicate
 * value in the second array, as array_merge does. I.e., with array_merge_recursive,
 * this happens (documented behavior):
 *
 * array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
 *     => array('key' => array('org value', 'new value'));
 *
 * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
 * Matching keys' values in the second array overwrite those in the first array, as is the
 * case with array_merge, i.e.:
 *
 * array_merge_recursive_distinct(array('key' => 'org value'), array('key' => 'new value'));
 *     => array('key' => array('new value'));
 *
 * Parameters are passed by reference, though only for performance reasons. They're not
 * altered by this function.
 *
 * @param array $array1
 * @param array $array2
 *
 * @return array
 */
if (!function_exists('array_merge_recursive_distinct')) {  
  function array_merge_recursive_distinct(array &$array1, array &$array2)
  {
    $merged = $array1;
    
    foreach ($array2 as $key => &$value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = array_merge_recursive_distinct($merged[$key], $value);
        } else {
            $merged[$key] = $value;
        }
    }

    return $merged;
  }
}