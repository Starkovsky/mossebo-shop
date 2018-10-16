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
            'data' => [
                'id'    => $this->resource->product_id,
                'price' => $this->resource->final_price,
            ]
        ];

        $params = json_decode($this->resource->params);

        if(isset($params->titles)) {
            $locale = app()->getLocale();

            if (isset($params->titles->{$locale})) {
                $data['data']['title'] = $params->titles->{$locale};
            }
            else {
                $product = Product::where('id', $this->resource->product_id)
                    ->first();

                $data['data']['title'] = $product->title;
            }
        }

        if (! empty($params->image)) {
            $data['data']['image'] = [
                'src'    => $params->image->thumb->src,
                'srcset' => $params->image->thumb->srcset
            ];
        }

        if ($this->relationNotEmpty('options')) {
            $data['data']['options'] = array_column($this->resource->options->toArray(), 'option_id');
        }

        return $data;
    }
}
