<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'shop_category_products';

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
