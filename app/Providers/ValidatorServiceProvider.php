<?php

namespace App\Providers;

use App\Rules\Hiragana;
use App\Rules\Katakana;
use App\Rules\PasswordWithPattern;
use App\Rules\PhoneNumber;
use App\Rules\Alphanumeric; // Import the Alphanumeric rule
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Models\FormField; // Import the FormField model
use App\Models\ErrorMessage; // Import the ErrorMessage model

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

        // Register the "alphanumeric" rule
        Validator::extend('alphanumeric', function ($attribute, $value) {
            return (new Alphanumeric())->passes($attribute, $value);
        });

        // Custom validation logic for customer search input
        Validator::extend('validate_customer_search_input', function ($attribute, $value, $parameters, $validator) {
            $searchFormId = array_shift($parameters);
            $itemNames = FormField::where('search_form_id', $searchFormId)->pluck('item_name');
            $errors = [];

            foreach ($itemNames as $itemName) {
                $fieldValue = $validator->getData()[$itemName] ?? null;
                if (empty($fieldValue)) {
                    $errors[] = "The {$itemName} field is required.";
                    continue;
                }

                // Add specific validation for each field if necessary
                // Example: if ($itemName == 'date_field' && !validateDate($fieldValue)) { ... }

                // If validation fails, get the error message
                if (!$validator->passes()) {
                    $formFieldId = FormField::where('item_name', $itemName)->where('search_form_id', $searchFormId)->value('id');
                    $errorMessage = ErrorMessage::where('form_field_id', $formFieldId)->value('message');
                    $errors[] = $errorMessage;
                }
            }

            if (!empty($errors)) {
                $validator->errors()->add($attribute, implode(' ', $errors));
                return false;
            }

            return true;
        });
    }
}

// You may need to create a new Rule class for Alphanumeric if it doesn't exist