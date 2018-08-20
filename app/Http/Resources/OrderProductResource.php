<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $params = json_decode($this->resource->params);

        $data = [
            'id'           => $this->resource->product_id,
            'title'        => $params->currentI18n->title,
            'defaultPrice' => $this->resource->default_price,
            'finalPrice'   => $this->resource->final_price,
            'quantity'     => $this->resource->quantity
        ];

        if (! empty($params->image) && ! empty($params->image->pathes)) {
            $imagePathes = json_decode($params->image->pathes);

            $data['image'] = [
                'src'    => $imagePathes->thumb->src,
                'srcset' => $imagePathes->thumb->srcset
            ];
        }

        if ($this->relationNotEmpty('options')) {
            $data['options'] = array_column($this->resource->options->toArray(), 'option_id');
        }

        return $data;
    }
}
