<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Alphanumeric implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if the value is alphanumeric
        return ctype_alnum($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be alphanumeric.';
    }
}