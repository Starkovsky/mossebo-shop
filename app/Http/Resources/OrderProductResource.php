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
        $data = [
            'quantity' => $this->resource->quantity,
            'info' => [
                'id'    => $this->resource->product_id,
                'price' => $this->resource->final_price,
            ]
        ];

        $params = json_decode($this->resource->params);

        if(isset($params->titles)) {
            $locale = app()->getLocale();

            if (isset($params->titles->{$locale})) {
                $data['info']['title'] = $params->titles->{$locale};
            }
            else {
                $product = Product::where('id', $this->resource->product_id)
                    ->first();

                $data['info']['title'] = $product->title;
            }
        }

        if (! empty($params->image)) {
            $data['info']['image'] = [
                'src'    => $params->image->thumb->src,
                'srcset' => $params->image->thumb->srcset
            ];
        }

        if ($this->relationNotEmpty('options')) {
            $data['info']['options'] = array_column($this->resource->options->toArray(), 'option_id');
        }

        return $data;
    }
}
