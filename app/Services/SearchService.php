<?php

namespace App\Services;

use App\Models\SearchForm;
use App\Models\Traits\FilterQueryBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SearchService
{
    use FilterQueryBuilder;

    public function executeCustomerSearch(int $searchFormId, array $searchCriteria): array
    {
        // Validate input data
        if (!is_int($searchFormId) || empty($searchCriteria)) {
            throw new \InvalidArgumentException('Invalid search form ID or search criteria.');
        }

        // Retrieve the search form
        $searchForm = SearchForm::find($searchFormId);
        if (!$searchForm) {
            throw new ModelNotFoundException('Search form not found.');
        }

        // Construct the dynamic SQL query
        $query = $searchForm->formFields()->newQuery();
        foreach ($searchCriteria as $criteria) {
            if (!empty($criteria['item_name']) && !empty($criteria['value'])) {
                $query->where($criteria['item_name'], 'like', '%' . $criteria['value'] . '%');
            }
        }

        // Execute the query and retrieve matching customer records
        $results = $query->get();

        // Prepare the response
        if ($results->isEmpty()) {
            return ['message' => 'No results found.'];
        }

        // Format the retrieved data into a structured JSON response
        $formattedResults = $results->map(function ($result) {
            return [
                'id' => $result->id,
                'item_name' => $result->item_name,
                'value' => $result->value,
            ];
        });

        return ['data' => $formattedResults];
    }
}