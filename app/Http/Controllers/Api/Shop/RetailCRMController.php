<?php

namespace App\Http\Controllers\Api\Shop;

use App\Models\Shop\Category;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\Supplier;

class RetailCRMController extends Controller
{
    //
    public function catalog()
    {
        $categorys = Category::with('currentI18n')
            ->get();

        $suppliers = Supplier::all();

        $products = Product::with([
            'currentI18n',
            'currentPrice',
            'categories',
            'attributes' => function ($query) {
                $query->with('currentI18n');
            },
            'attributeOptions',
            'image'
        ])
            ->get();


        return response()->view('shop.api.catalog-xml', [
            'categorys' => json_decode($categorys),
            'products' => json_decode($products),
            'suppliers' => json_decode($suppliers),
        ])
            ->header('Content-Type', 'text/xml');

    }
}
