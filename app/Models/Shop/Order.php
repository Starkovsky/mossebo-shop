<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\Order as BaseOrder;
use App\Models\User;
use App\Models\Language;
use App\Models\Shop\Promo\PromoUse;

class Order extends BaseOrder
{
    protected $fillable = [
        'user_id',
        'language_code',
        'currency_code',
        'order_status_id',
        'pay_type_id',
        'delivery_type_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'city',
        'address',
        'post_code',
        'comment'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function language()
    {
        return $this->hasOne(Language::class, 'code', 'language_code');
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_status_id');
    }

    public function payType()
    {
        return $this->hasOne(PayType::class, 'id', 'pay_type_id');
    }

    public function deliveryType()
    {
        return $this->hasOne(DeliveryType::class, 'id', 'delivery_type_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function promoUse()
    {
        return $this->hasOne(PromoUse::class, 'order_id', 'id');
    }
}
