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
            'is_new' => $this->is_new,
            'is_popular' => $this->is_popular,
            'name' => $this->i18n->title,
        ];

        if (! empty($this->productAttributeOptions)) {
            $data['options'] = array_column($this->productAttributeOptions->toArray(), 'option_id');
        }

        if (! empty($this->images)) {
            foreach ($this->images as $image) {
                if (! empty($image->pathes)) {
                    $imagePathes = json_decode($image->pathes);

                    $data['image'] = [
                        'src' => $imagePathes->small->src,
                        'srcset' => $imagePathes->small->srcset
                    ];

                    break;
                }
            }
        }

        if (! empty($this->prices)) {
            foreach ($this->prices as $price) {
                switch ($price->price_type_id) {
                    case 1:
                        $data['old_price'] = $price->value;
                        break;

                    case 2:
                        $data['price'] = $price->value;
                        break;
                }
            }
        }

        return $data;
    }
}
