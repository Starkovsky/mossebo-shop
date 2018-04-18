<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'shop_suppliers';

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
