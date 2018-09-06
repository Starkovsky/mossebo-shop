<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\AttributeRepository as BaseAttributeRepository;
use App\Models\Shop\Attribute;

class AttributeRepository extends BaseAttributeRepository
{
    public function getCollectionRaw(): Collection
    {
        return Attribute::enabled()
            ->localized()
            ->orderBy('position', 'asc')
            ->with([
                'options' => function ($query) {
                    $query->enabled()
                        ->localized()
                        ->orderBy('position', 'asc');
                }
            ])->get();
    }
}
