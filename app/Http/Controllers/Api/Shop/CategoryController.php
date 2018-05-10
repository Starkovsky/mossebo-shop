<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Shop\Attribute;
use App\Models\Shop\Category;

class CategoryController extends Controller
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
    public function products($category_slug)
    {
        try {
            $category = Category::with('products')
                ->where('slug', '=', $category_slug)
                ->where('enabled', '=', 'true')
                ->firstOrFail();
            //dd($category->products);


            return ProductResource::collection($category->products);

        } catch (\Exception $e) {
            // TODO: Временно закоментировано, надо куда то складывать ошибки
            return $e->getMessage();
            //return abort(404);
        }
    }
}
