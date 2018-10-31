<?php

namespace App\Http\Resources\Product;

class ProductSearchResource extends ProductResource
{
    public function toArray($request)
    {
        $result = parent::toArray($request);

        $relevance = $this->resource->getAttribute('relevance');

        if (! empty($relevance)) {
            $result['relevance'] = $relevance;
        }

        return $result;
    }
}
