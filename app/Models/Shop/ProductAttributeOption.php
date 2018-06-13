<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\ProductAttributeOption as BaseProductAttributeOption;

class ProductAttributeOption extends BaseProductAttributeOption
{
    public function attribute()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function option()
    {
        return $this->belongsTo(AttributeOption::class, 'option_id');
    }
}
