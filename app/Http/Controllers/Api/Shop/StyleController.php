<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\Product\ProductResource;
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

        $products = \Cache::remember(static::makeCacheKey($slug), 30, function() use($style) {
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

        $products = \Cache::remember(static::makeCacheKey($slug) . '::' . $categorySlug, 30, function() use($style, $category) {
            return $this->getProducts($style, $category);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getProducts($structureModel, $category = null)
    {
        if ($category) {
            $query = Product::byCategory($category->id)
                ->localized()
                ->enabled();
        }
        else {
            $query = Product::query();
        }

        $query
            ->whereStyle($structureModel->id)
            ->with([
                'previews',
                'currentPrice',
                'salePrice',
                'oldPrice',
                'attributeOptionRelations',
                'supplier',
                'badges',
                'reviews'
            ]);

        return productsToResource($query->get());
    }
}

