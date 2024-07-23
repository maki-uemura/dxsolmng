<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function searchCustomers(Request $request): JsonResponse
    {
        $searchFormId = $request->input('search_form_id');
        $itemName = $request->input('item_name');
        $value = $request->input('value');

        $results = $this->searchService->executeCustomerSearch($searchFormId, $itemName, $value);

        return response()->json(new SuccessResource($results));
    }
}