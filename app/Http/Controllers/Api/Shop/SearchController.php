<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Models\Shop\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class SearchController extends ApiController
{
    public function index(Request $request)
    {



//        dd( $products = Product::with(
//            ['attributeOptions' => function($query) {
//                $query->with('i18n');
//            }],
//            ['categories' => function($query) {
//                $query->with('i18n');
//            }],
//            ['styles' => function($query) {
//                $query->with('i18n');
//            }],
//            ['rooms' => function($query) {
//                $query->with('i18n');
//            }],
//            'i18n'
//        )->get()->take(5));


        $query = $request->input('query');

        if (mb_strlen($query) < 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'query is too short'
            ]);
        }

//        $products = \Cache::remember('search::all' . $query, 5, function() use($query) {
//            return static::getProducts($query);
//        });

        $products = static::getProducts($query);

        return [
            'meta' => '',
            'products' => $products
        ];
    }

    protected static function getProducts($query = null)
    {
        $search = Product::search($query, function($client, $query, $params) {
            $params['body'] = [
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

        $products = Product::with([
            'currentI18n',
            'image',
            'currentPrice',
            'oldPrice',
            'supplier',

            'attributeOptionRelations',

            'styleRelations',
            'roomRelations',
            'categoryRelations'
        ])
            ->whereIn('id', array_column($search->toArray(),'id'))->get();

        return ProductResource::collection($products);
    }
}


