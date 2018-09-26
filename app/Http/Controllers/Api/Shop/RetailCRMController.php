<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use Categories;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Supplier\Supplier;


class RetailCRMController extends Controller
{
    //
    public function catalog()
    {
        $categories = Categories::getCollection();

        $suppliers = Supplier::all();

        $products = Product::with([
            'currentPrice',
            'categories',
            'attributes',
            'attributeOptions',
            'image'
        ])
            ->get();


        return response()->view('shop.api.catalog-xml', [
            'categories' => json_decode($categories),
            'products' => json_decode($products),
            'suppliers' => json_decode($suppliers),
        ])
            ->header('Content-Type', 'text/xml');

    }
}
