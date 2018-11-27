<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;

use Categories;
use App\Support\Traits\Cacheable;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Category\CategoryProduct;

class CategoryController extends ApiController
{
    use Cacheable;

    protected static $cacheNamespace = 'category-products';

    /**
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function products($slug)
    {
        $category = Categories::where('slug', $slug)->first();

        if (! $category) {
            return abort(404);
        }

        $products = \Cache::remember(static::makeCacheKey($slug), 30, function() use($category) {
            return $this->getProducts($category);
        });

        return response()->json([
            'products' => $products
        ]);
    }

    protected function getProducts($structureModel)
    {
        $ids = array_column(
            $structureModel->descendants()->get()->toArray(),
            'id'
        );

        $ids[] = $structureModel->id;

        $productTableName = (new Product)->getTable();
        $relationTableName = (new CategoryProduct)->getTable();

        $products = Product::rawQuery()
            ->select(\DB::raw("DISTINCT ON ({$productTableName}.id) {$productTableName}.*"))
            ->join($relationTableName, function ($join) use($productTableName, $relationTableName, $ids) {
                $join->on("{$relationTableName}.product_id", "{$productTableName}.id")
                    ->whereIn("{$relationTableName}.category_id", $ids);
            })
            ->localized()
            ->enabled()
            ->with([
                'previews',
                'currentPrice',
                'salePrice',
                'oldPrice',
                'attributeOptionRelations',
                'supplier',
                'badges',
                'reviews'
            ])
            ->get();

        return productsToResource($products);
    }
}

