<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use Cache;
use App\Models\Shop\Product;

class ProductController extends ApiController
{
    public function popular()
    {
        $products = Cache::remember('products::popular', 5, function () {
            $products = Product::enabled()->inRandomOrder()->where('is_popular', 1)->take(8)->with(
                'currentI18n',
                'image',
                'currentPrice',
                'oldPrice',
                'attributeOptionRelations'
            )->get();

            return ProductResource::collection($products);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    public function new()
    {
        $products = Cache::remember('products::new', 5, function () {
            $products = Product::enabled()->inRandomOrder()->where('is_new', 1)->take(8)->with(
                'currentI18n',
                'image',
                'currentPrice',
                'oldPrice',
                'attributeOptionRelations'
            )->get();

            return ProductResource::collection($products);
        });

        return response()->json([
            'products' => $products
        ]);
    }
}
