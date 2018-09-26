<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\ProductResource;
use Rooms;
use Categories;
use App\Models\Shop\Product\Product;
use App\Support\Traits\Cacheable;

class RoomController extends ApiController
{
    use Cacheable;

    protected static $cacheNamespace = 'room-products';

    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($slug)
    {
        $room = Rooms::where('slug', $slug)->first();

        if (! $room) {
            return abort(404);
        }

        $products = \Cache::remember(static::makeCacheKey($slug), 60, function() use($room) {
            return $this->getProducts($room);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    public function catalog($slug, $categorySlug)
    {
        $room = Rooms::where('slug', $slug)->first();
        $category = Categories::where('slug', $categorySlug)->first();

        if (! ($room && $category)) {
            return abort(404);
        }

        $products = \Cache::remember('room::' . $slug . '::' . $categorySlug, 60, function() use($room, $category) {
            return static::prepareProducts(
                Product::enabled()
                    ->whereRoom($room->id)
                    ->whereCategory($category->id)
                    ->with([
                        'currentPrice',
                        'salePrice',
                        'oldPrice',
                        'attributeOptionRelations',
                        'supplier',
                        'previews',
                    ])
                    ->get()
            );
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getProducts($structureModel)
    {
        return static::prepareProducts(
            $structureModel
                ->products()
                ->with([
                    'currentPrice',
                    'salePrice',
                    'oldPrice',
                    'attributeOptionRelations',
                    'supplier',
                    'previews',
                ])
                ->where('enabled', true)
                ->get()
        );
    }

    protected static function prepareProducts($products)
    {
        return $products->reduce(function ($carry, $product) {
            if ($product->canBeShowed()) {
                $carry[] = new ProductResource($product);
            }

            return $carry;
        }, []);
    }
}

