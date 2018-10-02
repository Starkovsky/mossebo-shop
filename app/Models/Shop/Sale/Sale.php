<?php

namespace App\Models\Shop\Sale;

use MosseboShopCore\Models\Shop\Sale\Sale as BaseSale;

class Sale extends BaseSale
{
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'item_id')
            ->where('item_type', 'product');
    }
}
