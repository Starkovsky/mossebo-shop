<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StructureCardResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id'             => $this->id,
            'title'          => $this->title,
            'url'            => $this->getUrl(),
            'products_count' => $this->getProductsCount()
        ];

        if ($this->relationNotEmpty('image')) {
            $data['image'] = json_decode($this->image->pathes, true);
        }

        if (! $data['products_count']) {
            $data['more'] = \Lang::get('content.more.empty');
        }
        elseif ($data['products_count'] < 11) {
            $data['more'] = $data['products_count'] . ' ' . \Lang::choice(\Lang::get('content.more.choice'), $data['products_count']);
        }
        else {
            if ($data['products_count'] >= 10000) {
                $count = floor($data['products_count'] / 1000) * 1000;
            }
            elseif ($data['products_count'] >= 1000) {
                $count = floor($data['products_count'] / 100) * 100;
            }
            else {
                $count = floor($data['products_count'] / 10) * 10;
            }

            $count = (int) $count;

            $data['more'] = \Lang::get('content.more.phraze', [
                'products' => $count . ' ' . \Lang::choice(\Lang::get('content.more.choice'), $count)
            ]);
        }

        return $data;
    }

    protected function getProductsCount()
    {
        if (isset($this->additional['getProductCountFunc'])) {
            return call_user_func($this->additional['getProductCountFunc'], $this->resource);
        }

        return $this->resource->products_count;
    }

    protected function getUrl()
    {
        if (isset($this->additional['getUrlFunc'])) {
            return call_user_func($this->additional['getUrlFunc'], $this->resource);
        }

        return '';
    }
}
