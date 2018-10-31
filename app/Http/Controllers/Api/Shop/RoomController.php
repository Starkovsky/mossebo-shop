<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\Product\ProductResource;
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
            return $this->getProducts($room, $category);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getProducts($structureModel, $category = null)
    {
        if ($category) {
            $query = Product::byCategory($category->id)
                ->localized()
                ->enabled();
        }
        else {
            $query = Product::query();
        }

        $query
            ->whereRoom($structureModel->id)
            ->with([
                'previews',
                'currentPrice',
                'salePrice',
                'oldPrice',
                'attributeOptionRelations',
                'supplier',
                'badges',
            ]);

        return productsToResource($query->get());
    }
}

