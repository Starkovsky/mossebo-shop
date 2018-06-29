<?php

namespace App\Models\Shop;

use App\Models\Media;
use MosseboShopCore\Models\Shop\Category as BaseCategory;

class Category extends BaseCategory
{
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
}
