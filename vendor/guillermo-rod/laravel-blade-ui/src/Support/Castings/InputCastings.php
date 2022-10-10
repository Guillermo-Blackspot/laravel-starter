<?php

namespace GuillermoRod\BladeUi\Support\Castings;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait InputCastings
{
    protected $inputCastingsBooted = false;

    protected function bootInputCastings()
    {
        $this->addTraitCastings('InputCastings', [
            'required' => 'requiredRule'
        ]);
    }


    protected function inputCastingsRequiredRule(&$data, $key, $value)
    {
        $booleanValue = $value;

        if (Str::contains((string) $value, ':text-only')) {            
            $booleanValue = explode(':text-only', $value)[0];
            $data['extraAttributes']['requiredTextOnly'] = true;
            $value = false;
        }else{
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        $data['extraAttributes']['requiredPlaceholder'] = filter_var($booleanValue, FILTER_VALIDATE_BOOLEAN)
                                                            ? 'requerido'
                                                            : 'opcional';

        $this->resolveCastDataAttributeValue($data, $key, $value);
    }
}
