<?php

namespace App\Repositories\Shop;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\Shop\DeliveryTypeRepository as BaseDeliveryTypeRepository;
use App\Models\Shop\DeliveryType\DeliveryType;

class DeliveryTypeRepository extends BaseDeliveryTypeRepository
{
    public function getCollectionRaw(): Collection
    {
        return DeliveryType::enabled()
            ->orderBy('position', 'asc')
            ->get();
    }
}
