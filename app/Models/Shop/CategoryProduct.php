<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\CategoryProduct as BaseCategoryProduct;

class CategoryProduct extends BaseCategoryProduct
{
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
