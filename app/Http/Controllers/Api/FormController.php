<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Services\FormService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
{
    protected FormService $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    public function resetFormField(Request $request): SuccessResource
    {
        $validatedData = $request->validate([
            'search_form_id' => 'required|integer',
            'item_name' => 'required|string',
        ]);

        try {
            $result = $this->formService->resetFormField($validatedData['search_form_id'], $validatedData['item_name']);
            return new SuccessResource($result);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}