<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\CategoryProduct as BaseCategoryProduct;

class CategoryProduct extends BaseCategoryProduct
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
