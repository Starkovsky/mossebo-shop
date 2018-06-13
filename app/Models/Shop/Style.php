<?php

namespace App\Models\Shop;

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
}
