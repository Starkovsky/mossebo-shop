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
            'name' => $this->title,
        ];

        if ($this->relationNotEmpty('image')) {
            if (! empty($this->image->pathes)) {
                $data['image'] = $this->getImagePathes($this->image, 'small');
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

        if ($this->relationNotEmpty('previews')) {
            if (! empty($this->previews)) {
                $data['previews'] = [];

                foreach ($this->previews as $key => $image) {
                    $data['previews'][] = $this->getImagePathes($image, 'small');

                    if ($key === 2) break;
                }
            }
        }

        if ($this->relationNotEmpty('currentPrice')) {
            $data['price'] = $this->currentPrice->value;
        }

        if ($this->relationNotEmpty('oldPrice')) {
            $data['old_price'] = $this->oldPrice->value;
        }

        if ($this->relationNotEmpty('salePrice')) {
            $data['sale_price'] = $this->salePrice->value;
        }

        if ($this->relationNotEmpty('attributeOptionRelations')) {
            $data['attributes'] = array_column($this->attributeOptionRelations->toArray(), 'option_id');
        }
        else if ($this->relationNotEmpty('attributeOptions')) {
            $data['attributes'] = array_column($this->attributeOptions->toArray(), 'id');
        }

        if ($this->relationNotEmpty('categoryRelations')) {
            $data['categories'] = array_column($this->categoryRelations->toArray(), 'category_id');
        }
        else if ($this->relationNotEmpty('categories')) {
            $data['categories'] = array_column($this->categories->toArray(), 'id');
        }

        if ($this->relationNotEmpty('styleRelations')) {
            $data['styles'] = array_column($this->styleRelations->toArray(), 'style_id');
        }
        else if ($this->relationNotEmpty('styles')) {
            $data['styles'] = array_column($this->styles->toArray(), 'id');
        }

        if ($this->relationNotEmpty('roomRelations')) {
            $data['rooms'] = array_column($this->roomRelations->toArray(), 'room_id');
        }
        else if ($this->relationNotEmpty('rooms')) {
            $data['rooms'] = array_column($this->rooms->toArray(), 'id');
        }

        if ($this->relationNotEmpty('badges')) {
            $data['badges'] = array_column($this->badges->toArray(), 'badge_type_id');
        }

        return $data;
    }

    protected function getImagePathes($image, $size)
    {
        $imagePathes = json_decode($image->pathes);

        return [
            'id' => $image->id,
            'src' => $imagePathes->{$size}->src,
            'srcset' => $imagePathes->{$size}->srcset
        ];
    }
}


