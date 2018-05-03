<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'is_new' => $this->is_new,
            'is_popular' => $this->is_popular,
            'name' => $this->i18n->title,
            'price' => $this->current_price->value,
            'image' => json_decode($this->images[0]->pathes)->small->src,
        ];

        if(!is_null($this->old_price)) {
            $data['old_price'] = $this->old_price->value;
        }

        return $data;
    }
}
