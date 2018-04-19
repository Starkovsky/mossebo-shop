<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductI18n extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'shop_products_i18n';

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
