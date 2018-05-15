<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\FilterResource;
use App\Models\Shop\Attribute;

class FilterController extends ApiController
{
    /**
     * Отдает все фильтры.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::with(['i18n', 'options'])->get();

        return response()->json([
            'filters' => FilterResource::collection($attributes)
        ]);
    }
}
