<?php

namespace App\Http\Controllers\Api\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Product\ProductSearchResource;
use App\Models\Shop\Product\Product;

class SearchController extends ApiController
{
    public function index(Request $request)
    {
//        if (mb_strlen($query) < 3) {
//            return response()->json([
//                'status' => 'error',
//                'message' => 'query is too short'
//            ]);
//        }

//        $products = \Cache::remember('search::all' . $query, 5, function() use($query) {
//            return static::getProducts($query);
//        });
        $query = $request->input('q');

        $ids = $this->searchIds($query);

        $products = Product::with([
            'previews',
            'currentPrice',
            'salePrice',
            'oldPrice',
            'supplier',

            'badges',

            'attributeOptionRelations',

            'styleRelations',
            'roomRelations',
            'categoryRelations',
            'reviews'
        ])->whereIn('id', $ids)->get();

        $ids = array_flip($ids);

        $products->each(function($item) use($ids) {
            $item->setAttribute('relevance', $ids[$item->id] + 1);
        });

        return [
            'status' => 'success',
            'meta' => [
                'title' => trans('search.title.phrase', ['phrase' => $query])
            ],
            'products' => ProductSearchResource::collection($products)
        ];
    }

    public function query(Request $request)
    {
        $ids = $this->searchResultToIds(
            $this->search($request->input('q'))->take(5)
        );

        $products = Product::whereIn('id', $ids)->get();

        return [
            'status' => 'success',
            'products' => ProductSearchResource::collection($products)
        ];
    }

    protected function search($query)
    {
        return Product::search($query, function($client, $query, $params) {
            $query = mb_strtolower($query);

            $params['body'] = [
                'from' => 0,
                'size' => 10000,
                'query' => [
                    'wildcard' => [
                        'index' => "*{$query}*",
                    ]
                ]
            ];

            $result = $client->search($params);

            if (isset($result['hits']['total']) && $result['hits']['total'] > 0) {
                return $result;
            }

            $params['body'] = [
                'from' => 0,
                'size' => 10000,
                'query' => [
                    'match' => [
                        'index' => [
                            'query' => "*{$query}*",
                            //                            'query' => '*',
                            'fuzziness' => 'auto',
                            'operator' => 'and',
                        ]
                    ]
                ]
            ];

            return $client->search($params);
        })->get();
    }

    protected function searchResultToIds($result)
    {
        return array_column($result->toArray(),'id');
    }

    protected function searchIds($query)
    {
        return $this->searchResultToIds($this->search($query));
    }
}


