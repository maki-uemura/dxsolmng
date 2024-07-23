<?php

namespace App\Services;

use App\Models\FormField;
use App\Models\SearchResult;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;
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

    public function resetSearchForm(int $searchFormId)
    {
        DB::beginTransaction();
        try {
            $formFields = FormField::where('search_form_id', $searchFormId)->get();
            foreach ($formFields as $formField) {
                $formField->update(['value' => '']); // Assuming default value is an empty string
            }

            SearchResult::where('search_form_id', $searchFormId)->delete();

            DB::commit();

            return ['message' => 'Search form and results have been reset successfully.'];
        } catch (Exception $e) {
            DB::rollBack();
            return Handler::renderException($e);
        }
    }
}