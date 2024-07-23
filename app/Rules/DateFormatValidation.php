<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateFormatValidation implements Rule
{
    protected $format;

    /**
     * Create a new rule instance.
     *
     * @param string $format The date format to validate against.
     * @return void
     */
    public function __construct($format)
    {
        $this->format = $format;
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
        $date = \DateTime::createFromFormat($this->format, $value);
        return $date && $date->format($this->format) === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute does not match the format {$this->format}.";
    }
}