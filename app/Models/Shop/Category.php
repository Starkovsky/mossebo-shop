<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\Category as BaseCategory;

class Category extends BaseCategory
{
    public function products()
    {
        return $this
            ->belongsToMany(
                Product::class,
                'shop_category_products',
                'category_id',
                'product_id'
            )
            ->where('enabled','=',true)
            ->orderBy('id', 'desc');
    }
}
