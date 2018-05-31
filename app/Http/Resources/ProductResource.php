<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'new' => $this->is_new,
            'popular' => $this->is_popular,
            'name' => $this->i18n->title,
        ];

        if (! empty($this->productAttributeOptions)) {
            $data['options'] = array_column($this->productAttributeOptions->toArray(), 'option_id');
        }

        if (! empty($this->image)) {
            if (! empty($this->image->pathes)) {
                $imagePathes = json_decode($this->image->pathes);

                $data['image'] = [
                    'src' => $imagePathes->small->src,
                    'srcset' => $imagePathes->small->srcset
                ];
            }
        }

        if (! empty($this->currentPrice)) {
            $data['price'] = $this->currentPrice->value / 100;
        }

        if (! empty($this->oldPrice)) {
            $data['old_price'] = $this->oldPrice->value / 100;
        }

        return $data;
    }
}
