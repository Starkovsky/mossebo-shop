<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\AttributeResource;

class FilterController extends ApiController
{
    /**
     * Отдает все фильтры.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = \Attributes::getCollection(['currentI18n']);

        return response()->json([
            'filters' => AttributeResource::collection($attributes)
        ]);
    }
}
