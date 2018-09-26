<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\ProductResource;
use Styles;
use Categories;
use App\Models\Shop\Product\Product;
use App\Support\Traits\Cacheable;

class StyleController extends ApiController
{
    use Cacheable;

    protected static $cacheNamespace = 'style-products';

    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($slug)
    {
        $style = Styles::where('slug', $slug)->first();

        if (! $style) {
            return abort(404);
        }

        $products = \Cache::remember(static::makeCacheKey($slug), 60, function() use($style) {
            return $this->getProducts($style);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    public function catalog($slug, $categorySlug)
    {
        $style = Styles::where('slug', $slug)->first();
        $category = Categories::where('slug', $categorySlug)->first();

        if (! ($style && $category)) {
            return abort(404);
        }

        $products = \Cache::remember(static::makeCacheKey($slug) . '::' . $categorySlug, 60, function() use($style, $category) {
            return static::prepareProducts(
                Product::enabled()
                    ->whereStyle($style->id)
                    ->whereCategory($category->id)
                    ->with([
                        'currentPrice',
                        'salePrice',
                        'oldPrice',
                        'attributeOptionRelations',
                        'supplier',
                        'previews',
                    ])
                    ->get()
            );
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getProducts($structureModel)
    {
        return static::prepareProducts(
            $structureModel
                ->products()
                ->with([
                    'currentPrice',
                    'salePrice',
                    'oldPrice',
                    'attributeOptionRelations',
                    'supplier',
                    'previews',
                ])
                ->where('enabled', true)
                ->get()
        );
    }

    protected static function prepareProducts($products)
    {
        return $products->reduce(function ($carry, $product) {
            if ($product->canBeShowed()) {
                $carry[] = new ProductResource($product);
            }

            return $carry;
        }, []);
    }
}

