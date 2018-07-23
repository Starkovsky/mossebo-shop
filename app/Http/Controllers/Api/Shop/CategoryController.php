<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\ProductResource;
use Categories;

class CategoryController extends ApiController
{
    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($slug)
    {
        $category = Categories::enabled()->where('slug', $slug)->first();

        if (! $category) {
            return abort(404);
        }

        $products = \Cache::remember('category::' . $slug, 60, function() use($category) {
            return $this->getProducts($category);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getProducts($structureModel)
    {
        $products = $structureModel->products()->with([
            'currentI18n',
            'image',
            'currentPrice',
            'oldPrice',
            'attributeOptionRelations',
            'supplier',
        ])->where('enabled', true)->get();

        return $products->reduce(function ($carry, $product) {
            if ($product->canBeShowed()) {
                $carry[] = new ProductResource($product);
            }

            return $carry;
        }, []);
    }
}

