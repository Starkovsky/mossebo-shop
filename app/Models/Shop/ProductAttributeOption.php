<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\ProductAttributeOption as BaseProductAttributeOption;

class ProductAttributeOption extends BaseProductAttributeOption
{
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
