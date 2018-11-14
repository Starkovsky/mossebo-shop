<?php

namespace App\Models\Shop\Category;

use App\Models\Media;
use MosseboShopCore\Models\Shop\Category\Category as BaseCategory;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Product\ProductCount;
use App\Support\Traits\Models\HasI18n;

class Category extends BaseCategory
{
    use HasI18n;

    public function productsRelations()
    {
        return $this->hasMany(CategoryProduct::class, $this->relationFieldName);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class, CategoryProduct::class,
            $this->relationFieldName, 'id', 'id', 'product_id'
        )
            ->where('enabled','=',true)
            ->orderBy('id', 'desc');
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image')
            ->orderBy('order_column', 'asc');
    }

    public function productCounts()
    {
        return $this->hasMany(ProductCount::class, $this->relationFieldName);
    }

    public function link()
    {
        return siteUrl('catalog/' . $this->slug);
    }
}
