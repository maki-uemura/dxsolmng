<?php

namespace App\Services;

use App\Models\SearchForm;
use App\Http\Requests\ValidateResetFormRequest;
use Illuminate\Validation\ValidationException;

class SearchFormService
{
    /**
     * Reset the search form with the given ID.
     *
     * @param  ValidateResetFormRequest  $request
     * @return void
     * @throws ValidationException
     */
    public function resetSearchForm(ValidateResetFormRequest $request)
    {
        $searchFormId = $request->input('search_form_id');
        if (!is_int($searchFormId) || $searchFormId <= 0) {
            throw ValidationException::withMessages([
                'search_form_id' => 'The search form ID must be a valid integer.',
            ]);
        }

        $searchForm = SearchForm::find($searchFormId);

        if (!$searchForm) {
            throw ValidationException::withMessages([
                'search_form_id' => 'The selected search form is invalid or does not exist.',
            ]);
        }

        // Proceed with the reset logic for the search form
        // ...
    }
}