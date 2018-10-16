<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Product\Product;
use App\Http\Controllers\Shop\BaseStructure\BaseStructureController;
use Styles;
use Categories;
use SeoProxy;

class StyleController extends BaseStructureController
{
    protected static $repository = Styles::class;

    public function index()
    {
        SeoProxy::setTitle('Стили');
        SeoProxy::setDescription('Стильные товары');

        return view('shop.pages.styles.index', [
            'items' => static::all()
        ]);
    }

    public function catalog($slug)
    {
        $style = static::find($slug);

        $categories = Categories::where('parent_id', 0);

        return view('shop.pages.styles.catalog', [
            'style' => $style,
            'category' => false,
            'categories' => static::makeCategoriesCollection($style, $categories)
        ]);
    }

    public function category($slug, $categorySlug)
    {
        $style = static::find($slug);

        $category = Categories::where('slug', $categorySlug)->first();

        if (!$category) {
            abort(404);
        }

        $categoryChildren = Categories::where('parent_id', $category->id);

        if ($categoryChildren->count() > 0) {
            return view('shop.pages.styles.catalog', [
                'style' => $style,
                'category' => $category,
                'categories' => static::makeCategoriesCollection($style, $categoryChildren),
            ]);
        }

        $productsCount = Product::whereStyle($style->id)
            ->whereCategory($category->id)
            ->count();

        if ($productsCount === 0) {
            abort(404);
        }

        return view('shop.pages.styles.category', [
            'style' => $style,
            'category' => $category,
        ]);
    }

    public static function all()
    {
        $styles = static::$repository::getCollection()->sortBy('position');

        return static::makeStructureCollection(
            $styles,
            function ($resource) {
                return siteUrl('styles/' . $resource->slug);
            }
        );
    }

    protected static function makeCategoriesCollection($style, $categories)
    {
        return static::makeStructureCollection(
            $categories,
            function ($resource) use($style) {
                return siteUrl('styles/' . $style->slug . '/' . $resource->slug);
            },
            function($resource) use($style) {
                $row = $resource
                    ->productCounts
                    ->where('style_id', $style->id)
                    ->first();

                return $row ? $row->count : 0;
            }
        );
    }
}
