<?php

namespace App\Services;

use App\Models\FormField;
use App\Models\ErrorMessage;
use Illuminate\Support\Facades\Validator;

class ValidationService
{
    public function validateFormData(array $data, int $search_form_id)
    {
        $errors = [];
        $isValid = true;

        foreach ($data as $item_name => $value) {
            // Assuming there's a method to get validation rules for a given item_name
            $rules = $this->getValidationRulesForItem($item_name);

            $validator = Validator::make([$item_name => $value], [$item_name => $rules]);

            if ($validator->fails()) {
                $isValid = false;
                $formField = FormField::where('item_name', $item_name)->where('search_form_id', $search_form_id)->first();
                if ($formField) {
                    $errorMessage = $formField->errorMessages()->first();
                    $errors[$item_name] = $errorMessage ? $errorMessage->message : 'Invalid value';
                } else {
                    $errors[$item_name] = 'Invalid value';
                }
            }
        }

        if ($isValid) {
            return ['status' => 'success', 'message' => 'Form data is valid'];
        }

        return ['status' => 'failure', 'errors' => $errors];
    }

    // Placeholder for the method to get validation rules, should be implemented based on actual requirements
    private function getValidationRulesForItem($item_name)
    {
        // This should return validation rules based on the item_name
        // For example: return 'required|string|max:255';
        // This is just a placeholder, actual implementation needed
        return '';
    }
}