<?php

namespace App\Shop\Sale;

use App\Models\Shop\Sale\Sale as SaleModel;
use MosseboShopCore\Contracts\Models\HasMorphRelation;

class Sale
{
    protected $sales = null;

    public function getSales()
    {
        if (is_null($this->sales)) {
            $this->sales = SaleModel::enabled()->get()->reduce(function($carry, $item) {
                if (! isset($carry[$item->item_type])) {
                    $carry[$item->item_type] = [];
                }

                $carry[$item->item_type][$item->item_id] = $item;

                return $carry;
            }, []);
        }

        return $this->sales;
    }

    public function itemHasSale(HasMorphRelation $item)
    {
        $sales = $this->getSales();

        return isset($sales[$item->getMorphTypeName()][$item->id]);
    }

    public function getItemSaleTime(HasMorphRelation $item)
    {
        $sale = $this->getSales()[$item->getMorphTypeName()][$item->id];

        return [
            'start' => strtotime($sale->date_start),
            'finish' => strtotime($sale->date_finish),
        ];
    }
}
