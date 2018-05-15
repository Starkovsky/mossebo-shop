<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    protected $table = 'shop_product_attribute_options';

    public function attributes()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function options()
    {
        return $this->belongsTo(AttributeOption::class, 'option_id');
    }
}
