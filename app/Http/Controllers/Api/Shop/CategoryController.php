<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use Categories;
use App\Support\Traits\Cacheable;
use App\Http\Resources\ProductResource;

class CategoryController extends ApiController
{
    use Cacheable;

    protected static $cacheNamespace = 'category-products';

    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($slug)
    {
        $category = Categories::where('slug', $slug)->first();

        if (! $category) {
            return abort(404);
        }

        $products = \Cache::remember(static::makeCacheKey($slug), 60, function() use($category) {
            return $this->getProducts($category);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getProducts($structureModel)
    {
        $products = $structureModel->products()
            ->with([
                'previews',
                'currentPrice',
                'salePrice',
                'oldPrice',
                'attributeOptionRelations',
                'supplier',
                'badges',
            ])
            ->where('enabled', true)
            ->get();

        return $products->reduce(function ($carry, $product) {
            if ($product->canBeShowed()) {
                $carry[] = new ProductResource($product);
            }

            return $carry;
        }, []);
    }
}

