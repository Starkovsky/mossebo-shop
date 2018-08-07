<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Shop\AttributeOption;
use Cache;
use App\Models\Shop\Product;
use Illuminate\Http\Request;

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

    public function related(Product $product)
    {
        $products = Cache::remember('products::related::' . $product->id, 5, function () use($product) {
            return $this->getAdditionalProductsResource(
                Product::whereIn('id', $this->getRelatedProductIds($product))
            );
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getRelatedProductIds(Product $product)
    {
        return array_column($product->relatedRelations->toArray(), 'related_id');
    }

    protected function getAdditionalProductsResource($query)
    {
        $products = $query->with(
            'currentI18n',
            'image',
            'currentPrice',
            'oldPrice',
            'attributeOptionRelations'
        )
            ->inRandomOrder()
            ->take(4)
            ->get();

        return ProductResource::collection($products);
    }

    public function similar(Request $request, Product $product)
    {
        $products = Cache::remember('products::similar::' . $product->id, 5, function () use($product, $request) {
            return $this->getAdditionalProductsResource(
                Product::whereIn('id', $this->getSimilarProductIds($product))
            );
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getSimilarProductIds(Product $product)
    {
        $productsTable = config('tables.Products');
        $optionsTable  = config('tables.ProductAttributeOptions');
        $stylesTable   = config('tables.StyleProducts');
        $roomsTable    = config('tables.RoomProducts');

        $options = array_column($product->attributeOptionRelations->toArray(), 'option_id');
        $styles  = array_column($product->styleRelations->toArray(), 'style_id');
        $rooms   = array_column($product->roomRelations->toArray(), 'room_id');

        $query = Product::enabled()
            ->select(\DB::raw("COUNT({$productsTable}.id) as rating, {$productsTable}.id"));

        if (! empty($options)) {
            $availableOptions = AttributeOption::whereIn('attribute_id', [12, 14, 16, 20])->get();
            $availableOptions = array_column($availableOptions->toArray(), 'id');

            $options = array_intersect($options, $availableOptions);

            if (! empty($options)) {
                $query
                    ->leftJoin($optionsTable, function($join) use($productsTable, $optionsTable, $options) {
                        $join->on("{$optionsTable}.product_id", '=', "{$productsTable}.id")
                            ->whereIn("{$optionsTable}.option_id", $options);
                    });
            }
        }

        if (! empty($styles)) {
            $query
                ->leftJoin($stylesTable, function($join) use($productsTable, $stylesTable, $styles) {
                    $join->on("{$stylesTable}.product_id", '=', "{$productsTable}.id")
                        ->whereIn("{$stylesTable}.style_id", $styles);
                });
        }

        if (! empty($rooms)) {
            $query
                ->leftJoin($roomsTable, function($join) use($productsTable, $roomsTable, $rooms) {
                    $join->on("{$roomsTable}.product_id", '=', "{$productsTable}.id")
                        ->whereIn("{$roomsTable}.room_id", $rooms);
                });
        }

        $forbiddenIds = $this->getRelatedProductIds($product);
        $forbiddenIds[] = $product->id;

        $products = $query
            ->whereNotIn("{$productsTable}.id", $forbiddenIds)

            ->groupBy("{$productsTable}.id")
            ->orderBy('rating', 'desc')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return array_column($products->toArray(), 'id');
    }
}
