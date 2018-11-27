<?php

namespace App\Http\Controllers\Api\Shop;

use Shop;
use App\Support\Traits\Cacheable;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Sale\Sale;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Product\ProductResource;

class SaleController extends ApiController
{
    use Cacheable;

    protected static $cacheNamespace = 'sale';

    public function random()
    {
        $now = \Carbon\Carbon::now();

        $productsToSale = Sale::where('date_start', '<', $now)
            ->where('date_finish', '>', $now)
            ->where('item_type', 'product')
            ->get();

        $product = Product::enabled()
            ->with([
                'previews',
                'currentPrice',
                'salePrice',
                'oldPrice',
                'salePrice',
                'reviews'
            ])
            ->whereIn('shop_products.id', array_column($productsToSale->toArray(), 'item_id'))
            ->inRandomOrder()
            ->first();

        if ($product) {
            return [
                'status' => 'success',
                'product' => new ProductResource($product),
            ];
        }
        else {
            return [
                'status' => 'error',
            ];
        }
    }


//    protected function getProductsToSale()
//    {
//        return \Cache::remember($this->makeCacheKey('products-to-sale'), 5, function() {
//            $pricesTableName = config('tables.Prices');
//            $productTableName = config('tables.Products');
//
//            return Product::enabled()->with([
//                'images',
//                'currentPrice',
//                'salePrice',
//                'oldPrice',
//            ])->join("{$pricesTableName}", function($join) use($pricesTableName, $productTableName) {
//                $join->on("{$pricesTableName}.item_id", '=', "{$productTableName}.id")
//                    ->where("{$pricesTableName}.price_type_id", Shop::getDefaultPriceTypeId())
//                    ->where("{$pricesTableName}.item_type", 'product');
//            })->get();
//        });
//    }
}


