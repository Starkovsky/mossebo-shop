<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use App\Http\Resources\ProductResource;
use Rooms;
use Categories;
use App\Models\Shop\Product;

class RoomController extends ApiController
{
    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($slug)
    {
        $style = Rooms::enabled()->where('slug', $slug)->first();

        if (! $style) {
            return abort(404);
        }

        $products = \Cache::remember('room::' . $slug, 60, function() use($rooms) {
            return $this->getProducts($rooms);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    public function catalog($slug, $categorySlug)
    {
        $room = Rooms::enabled()->where('slug', $slug)->first();
        $category = Categories::enabled()->where('slug', $categorySlug)->first();

        if (! ($room && $category)) {
            return abort(404);
        }

        $products = \Cache::remember('room::' . $slug . '::' . $categorySlug, 60, function() use($room, $category) {
            return static::prepareProducts(
                Product::enabled()
                    ->whereRoom($room->id)
                    ->whereCategory($category->id)
                    ->with([
                        'currentI18n',
                        'image',
                        'currentPrice',
                        'oldPrice',
                        'attributeOptionRelations',
                        'supplier'
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
                ->products()->with([
                    'currentI18n',
                    'image',
                    'currentPrice',
                    'oldPrice',
                    'attributeOptionRelations',
                    'supplier'
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

