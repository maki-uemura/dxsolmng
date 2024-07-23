<?php

namespace App\Services;

use App\Models\FormField;
use App\Http\Resources\SuccessResource;
use Exception;

class FormService
{
    public function resetFormField(int $searchFormId, string $itemName): SuccessResource
    {
        try {
            $formField = FormField::where('search_form_id', $searchFormId)
                                  ->where('item_name', $itemName)
                                  ->firstOrFail();

            $formField->value = ''; // Set to default value if required
            $formField->save();

            return new SuccessResource('Form field has been reset successfully.');
        } catch (Exception $e) {
            // Handle the exception and return an appropriate error response
            // This part depends on how your application handles exceptions
            // For example, you might log the exception and return a generic error message
            // return new ErrorResource('An error occurred while resetting the form field.');
            // Since the exact error handling is not specified, it's left as a comment
            throw $e;
        }
    }
}