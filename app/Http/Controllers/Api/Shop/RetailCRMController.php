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
            'categoryRelations',
            'attributes',
            'attributeOptions',
            'image'
        ])
            ->get();

        return response()->view('shop.api.catalog-xml', [
            'categories' => $categories,
            'products' => $products,
            'suppliers' => $suppliers
        ])
            ->header('Content-Type', 'text/xml');

    }
}
