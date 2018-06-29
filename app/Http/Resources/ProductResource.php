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

        if ($this->relationNotEmpty('images')) {
            if (! empty($this->images)) {
                $data['images'] = [];

                foreach ($this->images as $image) {
                    $data['images'][] = array_merge([
                        'id' => $image->id
                    ], json_decode($image->pathes, true));
                }
            }
        }

        if ($this->relationNotEmpty('currentPrice')) {
            $data['price'] = $this->currentPrice->getValue();
        }

        if ($this->relationNotEmpty('oldPrice')) {
            $data['old_price'] = $this->oldPrice->getValue();
        }

        return $data;
    }
}
