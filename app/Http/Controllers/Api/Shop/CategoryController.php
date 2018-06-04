<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\ProductResource;
use App\Models\Shop\Category;

class CategoryController extends ApiController
{
    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        // firstOrFail - бросает ошибку.
        // Ошибка перхватывается в App\Exceptions\Handler - возвращает клиенту 404.

        $products = \Cache::remember('category::' . $slug, 60, function() use($category) {
            return $this->getCategoryProducts($category);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getCategoryProducts($category)
    {
        $products = $category->products()->with([
            'currentI18n',
            'image',
            'currentPrice',
            'oldPrice',
            'productAttributeOptions',
            'supplier'
        ])->where('enabled', '=', true)->get();

        return $products->reduce(function ($carry, $product) {
            if ($product->canBeShowed()) {
                $carry[] = new ProductResource($product);
            }

            return $carry;
        }, []);
    }
}

