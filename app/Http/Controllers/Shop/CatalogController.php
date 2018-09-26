<?php

namespace App\Http\Controllers\Shop;

use SeoProxy;
use Categories;
use App\Models\Shop\Product\Product;
use App\Http\Controllers\Shop\BaseStructure\BaseStructureController;

class CatalogController extends BaseStructureController
{
    protected static $repository = Categories::class;

    public function index()
    {
        SeoProxy::setTitle('Категории');
        SeoProxy::setDescription('Товары по категориям');

        return view('shop.pages.catalog.index', [
            'items' => static::all()
        ]);
    }

    public function category($slug)
    {
        $category = static::find($slug);

        $categoryChildren = Categories::where('parent_id', $category->id);

        if ($categoryChildren->count() > 0) {
            return view('shop.pages.catalog.catalog', [
                'category' => $category,
                'categories' => static::makeCategoriesCollection($categoryChildren),
            ]);
        }

        $productsCount = Product::whereCategory($category->id)
            ->count();

        if ($productsCount === 0) {
            abort(404);
        }

        return view('shop.pages.catalog.category', [
            'category' => $category,
        ]);
    }

    public static function all($parentId = 0)
    {
        $categories = static::$repository::where('parent_id', $parentId);

        return static::makeStructureCollection(
            $categories,
            function ($resource) {
                return siteUrl('catalog/' . $resource->slug);
            }
        );
    }

    protected static function makeCategoriesCollection($categories)
    {
        return static::makeStructureCollection(
            $categories,
            function ($resource) {
                return siteUrl('catalog/' . $resource->slug);
            },
            function($resource) {
                $row = $resource
                    ->productCounts
                    ->where('room_id', null)
                    ->where('style_id',null)
                    ->first();

                return $row ? $row->count : 0;
            }
        );
    }
}
