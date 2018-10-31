<?php

namespace App\Http\Resources\Cart;

use Shop;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'key'      => $this->resource->getKey(),
            'quantity' => $this->resource->getQuantity(),
            'data' => [
                'id'      => $this->resource->getProductId(),
                'options' => $this->resource->getOptions(),
                'added'   => $this->resource->getAddedAtTimestamp(),
                'updated' => $this->resource->getUpdatedAtTimestamp(),
            ]
        ];

        $this->setPrice($data['data']);
        $this->setTitle($data['data']);
        $this->setImage($data['data']);

        return $data;
    }

    protected function setPrice(& $data)
    {
        $getPrice = function($typeId) {
            return $this->resource->getBasePrice(
                $typeId,
                Shop::getCurrentCurrencyCode()
            );
        };

        if ($price = $getPrice(Shop::getCurrentPriceTypeId())) {
            $data['price'] = $price->getValue();
        }
        else {
            if ($price = $getPrice(Shop::getDefaultPriceTypeId())) {
                $data['price'] = $price->getValue();
            }
        }

        if ($price = $getPrice(Shop::getPriceTypeId('sale'))) {
            $sale = Shop::sales()->getSale('product', $this->resource->getProductId());

            if ($sale) {
                $data['sale'] = [
                    'price' => $price->getValue(),
                    'time' => Shop::sales()->getSaleTime($sale),
                ];
            }
        }
    }

    protected function setTitle(& $data)
    {
        $title = $this->resource->getTitle(app()->getLocale());

        if (empty($title)) {
            // todo: подгрузить заголовок из модели
        }

        $data['title'] = $title;
    }

    protected function setImage(& $data)
    {
        $imagePathes = $this->resource->getImage();

        if ($imagePathes) {
            $data['image'] = [
                'src' => $imagePathes['thumb']['src'],
                'srcset' => $imagePathes['thumb']['srcset']
            ];
        }
    }
}
