<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\StyleProduct as BaseStyleProduct;

class StyleProduct extends BaseStyleProduct
{
    public function style()
    {
        return $this->belongsTo(Style::class, 'style_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
