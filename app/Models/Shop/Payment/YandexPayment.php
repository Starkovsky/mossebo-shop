<?php

namespace App\Models\Shop\Payment;

use MosseboShopCore\Models\Shop\Payment\YandexPayment as BaseYandexPayment;

class YandexPayment extends BaseYandexPayment
{
    public function payment()
    {
        return $this->morphOne(Payment::class, 'details');
    }
}
