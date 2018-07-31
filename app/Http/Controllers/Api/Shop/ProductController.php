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
            $products = Product::enabled()->with(
                'currentI18n',
                'image',
                'currentPrice',
                'oldPrice',
                'attributeOptionRelations'
            )
                ->where('is_popular', 1)
                ->inRandomOrder()
                ->take(8)
                ->get();

            return ProductResource::collection($products);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    public function new()
    {
        $products = Cache::remember('products::new', 5, function () {
            $products = Product::enabled()->with(
                'currentI18n',
                'image',
                'currentPrice',
                'oldPrice',
                'attributeOptionRelations'
            )
                ->where('is_new', 1)
                ->inRandomOrder()
                ->take(8)
                ->get();

            return ProductResource::collection($products);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    public function similar(Product $product)
    {
        $products = Cache::remember('products::similar::' . $product->id, 5, function () use($product) {
            $products = $product->similar()->with(
                'currentI18n',
                'image',
                'currentPrice',
                'oldPrice',
                'attributeOptionRelations'
            )->take(8)->get();

            return ProductResource::collection($products);
        });

        return response()->json([
            'products' => $products
        ]);
    }
}
