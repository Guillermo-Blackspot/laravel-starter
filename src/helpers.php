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
}

/**
 * Retrieve the website favicon with google api
 * 
 * @param string $link
 * @return string
 */
function get_icon_url(string $link){
  if($link != ''){
    $link = preg_replace('/^https?:\\/\\//', '', $link);
    $link = explode('/', $link)[0];
    if ($link != '') {
        return "https://www.google.com/s2/favicons?domain=" . $link;
    }
  }
  return asset('/img/favicon.ico');
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

  if ($quantity == 0 || $quantity == null || $quantity == '') {
    return 0;
  }

  return number_format(
    $quantity,
    (int)    $decimals,
    (string) $sepDecimals,
    (string) $sepThousands
  );
}

/**
 * Converts an input into array 
 * @param mixed $mixed
 * @return array
 */
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