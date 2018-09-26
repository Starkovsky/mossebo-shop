<?php

namespace App\Repositories\Shop;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\Shop\OrderStatusRepository as BaseOrderStatusRepository;
use App\Models\Shop\Order\OrderStatus;

class OrderStatusRepository extends BaseOrderStatusRepository
{
    public function getCollectionRaw(): Collection
    {
        return OrderStatus::orderBy('position', 'asc')
            ->get();
    }
}
