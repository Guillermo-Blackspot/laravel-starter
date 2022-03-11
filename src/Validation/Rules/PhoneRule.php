<?php

namespace BlackSpot\Starter\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{

    private $value, $lang;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($lang = 'es')
    {
        $this->value = '';
        $this->lang  = $lang;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $this->value = $value;

        return strlen($value) == 10 && is_numeric($value);// (strlen($value) <> 10);
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
                'ingrese 10 dígitos.',
                'ingrese sólo números',
                'ingrese un número telefónico válido'
            ],
            'en' => [
                'The :attribute length must be of 10 characters',
                'The :attribute must be numeric',
                'The :attribute does\'nt a valid phone .'
            ]  
        ];


        if (strlen($this->value) <> 10) {
            return $langs[$this->lang][0];
        }elseif (is_numeric($this->value)) {
            return $langs[$this->lang][1];
        }

        return $langs[$this->lang][2];
    }
}
