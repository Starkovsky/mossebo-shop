<?php

namespace App\Models\Shop;

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
}
