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
            'name' => $this->currentI18n->title,
        ];

        if ($this->relationNotEmpty('attributeOptionRelations')) {
            $data['options'] = array_column($this->attributeOptionRelations->toArray(), 'option_id');
        }

        if ($this->relationNotEmpty('image')) {
            if (! empty($this->image->pathes)) {
                $imagePathes = json_decode($this->image->pathes);

                $data['image'] = [
                    'src' => $imagePathes->small->src,
                    'srcset' => $imagePathes->small->srcset
                ];
            }
        }

        if ($this->relationNotEmpty('currentPrice')) {
            $data['price'] = $this->currentPrice->value / 100;
        }

        if ($this->relationNotEmpty('oldPrice')) {
            $data['old_price'] = $this->oldPrice->value / 100;
        }

        return $data;
    }
}
