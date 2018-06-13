<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = $this->resource->info;

        $data = [
            'id' => $product->id,
            'title' => $product->currentI18n->title,
            'payable' => $product->is_payable
        ];

        if (!empty($product->options)) {
            $data['options'] = $product->options;
        }

        if ($product->relationNotEmpty('image')) {
            if (! empty($product->image->pathes)) {
                $imagePathes = json_decode($product->image->pathes);

                $data['image'] = [
                    'src' => $imagePathes->thumb->src,
                    'srcset' => $imagePathes->thumb->srcset
                ];
            }
        }

        // todo: убрать деление на 100 - привести к формированию с использованием валюты
        if ($product->relationNotEmpty('prices')) {
            foreach ($product->prices as $price) {
                switch ($price->price_type_id) {
                    case 1:
                        $data['old_price'] = $price->value / 100;
                        break;

                    case 2:
                        $data['price'] = $price->value / 100;
                        break;
                }
            }
        }

        return [
            'key' => $this->key,
            'qty' => $this->qty,
            'info' => $data,
        ];
    }
}


/***
 *  key: '100120',
    qty: 2,
    info: {
        id: '100120',
        title: 'Светильник подвесной Twister 30',
        image: {
            src: '/uploads/media/product/658/responsive-images/5afad84bf39a8928923862___thumb_80_80.jpg',
            srcset: '/uploads/media/product/658/responsive-images/5afad84bf39a8928923862___thumb_160_160.jpg',
        },
        price: '5500',
        category: 'Освещение',
    }
 */
