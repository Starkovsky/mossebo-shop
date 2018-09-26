<?php

namespace App\Http\Controllers\Api\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
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
            'image',
            'currentPrice',
            'salePrice',
            'oldPrice',
            'supplier',

            'badges',

            'attributeOptionRelations',

            'styleRelations',
            'roomRelations',
            'categoryRelations',
        ])->whereIn('id', $ids)->get();

        return [
            'status' => 'success',
            'meta' => [
                'title' => trans('search.title.phrase', ['phrase' => $query])
            ],
            'products' => ProductResource::collection($products)
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
            'products' => ProductResource::collection($products)
        ];
    }

    protected function search($query)
    {
        return Product::search($query, function($client, $query, $params) {
            $params['body'] = [
                'from' => 0,
                'size' => 10000,
                'query' => [
                    'match' => [
                        'index' => [
                            'query' => "*{$query}*",
//                            'query' => '*',
                            'fuzziness' => 'auto',
                            'operator' => 'and'
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


