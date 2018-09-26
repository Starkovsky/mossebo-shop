<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Interior\Interior;
use App\Models\Shop\Product\Product;
use App\Http\Controllers\Controller;

class InteriorController extends Controller
{
    public function iframe($id)
    {
        $interior = Interior::with(
            'points'
        )->findOrFail($id);

        $products = Product::with(
            'image',
            'currentPrice',
            'salePrice'
        )
            ->whereIn('id', array_column($interior->points->toArray(), 'product_id'))
            ->get();

        $points = $products->map(function($product) use ($interior) {
            $point = $interior->points->where('product_id', $product->id)->first();
            $point->setAttribute('product', $product);

            return $point;
        });

        return view('shop.pages.interiors.iframe', [
            'title'  => $interior->title,
            'image'  => $interior->image,
            'points' => $points
        ]);
    }
}
