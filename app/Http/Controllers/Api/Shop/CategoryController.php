<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\ProductResource;
use App\Models\Shop\Category;
use App\Models\Shop\Product;

class CategoryController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        // firstOrFail - бросает ошибку.
        // Ошибка перхватывается в App\Exceptions\Handler - возвращает клиенту 404.

        $products = $category->products()->with(['images', 'prices', 'i18n', 'prices', 'productAttributeOptions'])->get();

        return response()->json([
            'products' => ProductResource::collection($products)
        ]);
    }
}
