<?php

namespace BlackSpot\Starter\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class UniqueEmailRule implements Rule
{

    private $model, 
            $columnName,
            $mayBeOwner,
            $value, 
            $lang;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $columnName = 'email', $mayBeOwner = null , $lang = 'es')
    {
        $this->model        = $model;
        $this->columnName   = $columnName;
        $this->mayBeOwner   = $mayBeOwner;
        $this->lang         = $lang;
        $this->value        = '';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $email)
    {
        $this->value = $email;

        return ($this->model::where($this->columnName, $email)->where('id','!=',$this->mayBeOwner)->exists()) == false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $langs = [
            'es' => [
                'este email ya esta registrado',   
            ],
            'en' => [
                'The :attribute was registered yet.',
            ]  
        ];

        return $langs[$this->lang][0];
    }
}
