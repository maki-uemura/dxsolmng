<?php

namespace App\Services;

use App\Models\FormField;
use App\Models\ErrorMessage;
use Exception;

abstract class BaseService
{
    public static function getAuthModelFromProvider(string $provider)
    {
        $model = config("auth.providers.$provider.model");

        if (!$model) {
            $providers = config('auth.providers');
            $model = $providers[array_key_first($providers)]['model'];
        }

        return $model;
    }

    public function validateCustomerSearchInput(int $searchFormId, array $inputData): array
    {
        $errorMessages = [];
        try {
            $formFields = FormField::where('search_form_id', $searchFormId)->get();

            foreach ($inputData as $item_name => $value) {
                if (is_null($value) || $value === '') {
                    $formField = $formFields->firstWhere('item_name', $item_name);
                    if ($formField) {
                        $errorMessages[$item_name] = $formField->errorMessages()->pluck('message')->toArray();
                    } else {
                        $errorMessages[$item_name] = ['Value cannot be null or empty.'];
                    }
                    continue;
                }

                // Add more validation based on the item_name if necessary
                // Example:
                // if ($item_name === 'customer_id' && !ctype_alnum($value)) {
                //     $formField = $formFields->firstWhere('item_name', $item_name);
                //     if ($formField) {
                //         $errorMessages[$item_name] = $formField->errorMessages()->pluck('message')->toArray();
                //     } else {
                //         $errorMessages[$item_name] = ['Customer ID must be alphanumeric.'];
                //     }
                // }
            }
        } catch (Exception $e) {
            // Handle the exception as needed, for example:
            // Log the exception and return a generic error message
            // Log::error($e->getMessage());
            $errorMessages['general'] = ['An error occurred during validation.'];
        }

        return $errorMessages;
    }
}