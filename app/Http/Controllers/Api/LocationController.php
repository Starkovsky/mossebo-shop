<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends ApiController
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $result = $this->search($query);

        $cities = [];

        if (isset($result['hits']['hits'])) {
            foreach($result['hits']['hits'] as $hit) {
                $city = [
                    'id' => $hit['_source']['id'],
                    'name' => $hit['_source']['name'],
                ];

                if (!empty($hit['_source']['region'])) {
                    $city['region'] = $hit['_source']['region'];
                }

                $cities[] = $city;
            }
        }

        return [
            'status' => 'success',
            'cities' => $cities
        ];
    }

    protected function search($query)
    {
        return City::search($query, function($client, $query, $params) {
            $query = mb_strtolower($query);

            $params['body'] = [
                'from' => 0,
                'size' => 20,
                'query' => [
                    'wildcard' => [
                        "name" => "*{$query}*",
                    ]
                ]
            ];

            return $client->search($params);
        })->raw();
    }
}
