<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderTemp extends Model
{
    protected $table = 'shop_orders_temp';

    protected $fillable = ['data'];
}
