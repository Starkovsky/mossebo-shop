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

        if (isset($result['hits']['hits'])) {
            $cities = $result['hits']['hits'];

            usort($cities, function($a, $b) {
                if ($a['_score'] !== $b['_score']) {
                    return $a['_score'] < $b['_score'];
                }

                $okatoA = empty($a['_source']['okato_code']) ? 0 : $a['_source']['okato_code'];
                $okatoB = empty($b['_source']['okato_code']) ? 0 : $b['_source']['okato_code'];

                return $okatoA > $okatoB;
            });

            foreach($cities as $key => $hit) {
                $city = [
                    'id' => $hit['_source']['id'],
                    'name' => $hit['_source']['name'],
                ];

                if (!empty($hit['_source']['region'])) {
                    $city['region'] = $hit['_source']['region'];
                }

                $cities[$key] = $city;
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
