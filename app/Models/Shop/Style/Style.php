<?php

namespace App\Models\Shop;

use App\Models\Media;

use MosseboShopCore\Models\Shop\Style as BaseStyle;

class Style extends BaseStyle
{
    public function productsRelations()
    {
        return $this->hasMany(StyleProduct::class, $this->relationFieldName);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class, StyleProduct::class,
            $this->relationFieldName, 'id', 'id', 'product_id'
        );
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image')
            ->orderBy('order_column', 'asc');
    }

    protected function productCounts()
    {
        return $this->hasMany(ProductCount::class, $this->relationFieldName);
    }
}
