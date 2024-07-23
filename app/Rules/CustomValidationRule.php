<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\ErrorMessage;
use Illuminate\Support\Facades\DB;

class CustomValidationRule implements Rule
{
    protected $formFieldId;
    protected $validationType;
    protected $errorMessage;

    /**
     * Create a new rule instance.
     *
     * @param int $formFieldId
     * @param string $validationType
     * @return void
     */
    public function __construct($formFieldId, $validationType)
    {
        $this->formFieldId = $formFieldId;
        $this->validationType = $validationType;
        $this->errorMessage = $this->getErrorMessage();
    }

    /**
     * Retrieve the error message for the form field.
     *
     * @return string
     */
    protected function getErrorMessage()
    {
        return ErrorMessage::where('form_field_id', $this->formFieldId)->value('message') ?? 'Invalid value provided.';
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
        switch ($this->validationType) {
            case 'string':
                return is_string($value);
            case 'integer':
                return filter_var($value, FILTER_VALIDATE_INT) !== false;
            // Add more validation types as needed
            default:
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}