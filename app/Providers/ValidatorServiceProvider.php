<?php

namespace App\Providers;

use App\Rules\Hiragana;
use App\Rules\Katakana;
use App\Rules\PasswordWithPattern;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Models\ErrorMessage; // Import ErrorMessage model
use Illuminate\Support\Arr; // Import Arr helper for array operations

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('in_past', function ($attribute, $value, $parameters) {
            $currentDate = data_get($parameters, '0') == 'datetime' ? Carbon::now() : Carbon::today();

            return Carbon::parse($value)->isBefore($currentDate);
        });

        Validator::extend('in_future', function ($attribute, $value, $parameters) {
            $currentDate = data_get($parameters, '0') == 'datetime' ? Carbon::now() : Carbon::today();

            return Carbon::parse($value)->isAfter($currentDate);
        });

        Validator::extend('hiragana', function ($attribute, $value) {
            return (new Hiragana())->passes($attribute, $value);
        });

        Validator::extend('katakana', function ($attribute, $value) {
            return (new Katakana())->passes($attribute, $value);
        });

        Validator::extend('phone_number', function ($attribute, $value) {
            return (new PhoneNumber())->passes($attribute, $value);
        });

        Validator::extend('password_with_pattern', function ($attribute, $value) {
            return (new PasswordWithPattern())->passes($attribute, $value);
        });

        // Custom validation logic for form data
        Validator::extend('validate_form_data', function ($attribute, $value, $parameters, $validator) {
            $searchFormId = Arr::get($parameters, 0);
            $errors = [];

            foreach ($value as $item_name => $item_value) {
                // Assume there's a method to get the validation rules for the given item_name
                $rules = $this->getValidationRulesForItem($item_name, $searchFormId);

                // Validate the item_value against the rules
                $validationResult = Validator::make([$item_name => $item_value], [$item_name => $rules]);

                if ($validationResult->fails()) {
                    // Retrieve error message from the database
                    $formFieldId = $this->getFormFieldIdByName($item_name, $searchFormId);
                    $errorMessage = ErrorMessage::where('form_field_id', $formFieldId)->first()->message ?? 'Invalid value';

                    // Collect error messages
                    $errors[$item_name] = $errorMessage;
                }
            }

            if (!empty($errors)) {
                $validator->setCustomMessages($errors);
                return false;
            }

            return true;
        });
    }

    /**
     * Get validation rules for a given item name.
     * This is a placeholder method and should be implemented based on actual project requirements.
     *
     * @param string $item_name
     * @param int $searchFormId
     * @return array
     */
    protected function getValidationRulesForItem($item_name, $searchFormId)
    {
        // TODO: Implement logic to retrieve validation rules based on item_name and searchFormId
        return [];
    }

    /**
     * Get form field ID by name.
     * This is a placeholder method and should be implemented based on actual project requirements.
     *
     * @param string $item_name
     * @param int $searchFormId
     * @return int|null
     */
    protected function getFormFieldIdByName($item_name, $searchFormId)
    {
        // TODO: Implement logic to retrieve form field ID based on item_name and searchFormId
        return null;
    }
}