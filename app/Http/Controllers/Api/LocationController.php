<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Resources\CityResource;

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
            $params['body'] = [
                'from' => 0,
                'size' => 20,
                'query' => [
                    'match_phrase_prefix' => [
                        'name' => "*{$query}*"
                    ]
                ]
            ];

            return $client->search($params);
        })->raw();
    }
}
