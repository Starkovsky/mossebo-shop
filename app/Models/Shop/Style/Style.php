<?php

namespace App\Models\Shop\Style;

use App\Models\Media;

use MosseboShopCore\Models\Shop\Style\Style as BaseStyle;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Product\ProductCount;
use App\Support\Traits\Models\HasI18n;

class Style extends BaseStyle
{
    use HasI18n;

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

    public function link()
    {
        return siteUrl('styles/' . $this->slug);
    }
}
