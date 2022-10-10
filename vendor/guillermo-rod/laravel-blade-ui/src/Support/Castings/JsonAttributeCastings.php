<?php

namespace GuillermoRod\BladeUi\Support\Castings;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\View\ComponentAttributeBag;

trait JsonAttributeCastings
{

    protected $jsonAttributeCastingsBooted = false;

    protected function bootJsonAttributeCastings(){}

    protected function jsonAttributeCastingsJAttributesRule(&$data, $key, $array)
    {
        if (!is_array($array)) {
            return ;
        }
        
        $array = new ComponentAttributeBag($array);

        // $str = '';        
        // foreach ($array as $arrayKey => $value) {
        //     $str .= ' '.$arrayKey.'="'.str_replace('"', '\\"', trim($value)).'"';
        // }

        $this->resolveCastDataAttributeValue($data, $key, $array);
    }

}