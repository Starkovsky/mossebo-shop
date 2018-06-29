<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Models\Shop\Product;
use App\Http\Resources\ProductResource;

class SaleController extends ApiController
{
    public function random()
    {
        $pricesTableName = config('tables.Prices');
        $productTableName = config('tables.Products');

        $product = Product::enabled()->with([
            'images',
            'currentI18n',
            'currentPrice',
            'oldPrice',
        ])->join("{$pricesTableName}", function($join) use($pricesTableName, $productTableName) {
            $join->on("{$pricesTableName}.item_id", '=', "{$productTableName}.id")
                ->where("{$pricesTableName}.price_type_id", 1)
                ->where("{$pricesTableName}.item_type", 'product');
        })->inRandomOrder()->first();

        $resource = new ProductResource($product);

        return response()->json([
            'product' => $resource,
            'sale_time' => strtotime("tomorrow midnight") - time()
        ], 200);
    }
}


