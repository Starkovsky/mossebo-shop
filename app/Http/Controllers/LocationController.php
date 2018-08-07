<?php

namespace App\Http\Controllers;

use Cookie;
use Countries;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function search(Request $request)
    {
        return response()->json([
            'cities' => [
                [
                    'id' => 1,
                    'name' => 'Санкт-Петербург'
                ],
                [
                    'id' => 2,
                    'name' => 'Москва'
                ],
                [
                    'id' => 3,
                    'name' => 'Выборг',
                    'region' => 'Ленинградская обл'
                ],
                [
                    'id' => 1,
                    'name' => 'Санкт-Петербург'
                ],
                [
                    'id' => 2,
                    'name' => 'Москва'
                ],
                [
                    'id' => 3,
                    'name' => 'Выборг',
                    'region' => 'Ленинградская обл'
                ],
                [
                    'id' => 1,
                    'name' => 'Санкт-Петербург'
                ],
                [
                    'id' => 2,
                    'name' => 'Москва'
                ],
                [
                    'id' => 3,
                    'name' => 'Выборг',
                    'region' => 'Ленинградская обл'
                ],
            ]
        ], 200);
    }

    public function test()
    {
        ini_set("memory_limit","2048M");
        ini_set('max_execution_time', 1200);

//        dd(Region::where('id', 1327)->first()->toArray());
//
//
//        $cities = City::get();
//
//        $list = [];
//
//        foreach ($cities as $city) {
//            $key = $city->name . $city->postal_code . $city->region_id;
//
//            if (! isset($list[$key])) {
//                $list[$key] = [];
//            }
//
//            $list[$key][] = $city->toArray();
//        }
//
//        unset($cities);
//
//        $total = [];
//
//        foreach($list as $item) {
//            if (count($item) > 1) {
//                $total[] = $item;
//            }
//        }
//
//        dd($total);


        $path = app_path('Geo');
        $files = array_diff(scandir($path), array('.', '..', '.DS_Store'));

        $regions = Region::get();

        foreach ($files as $file) {
            $cities = file_get_contents($path . '/' . $file);
            $cities = json_decode($cities, true);

            $cities = array_filter($cities, function ($city) {
                return $city['CURRSTATUS'] == 0;
            });

            $empty = [];

            foreach ($cities as $city) {
                if ($city['AOLEVEL'] == 6) {
                    $parent = $regions
                        ->where('region_code', $city['REGIONCODE'])
                        ->where('area_code', $city['AREACODE'])
                        ->first();

                    if (!$parent) {
                        $empty[] = $city;
                    }
                    else {
                        $city = new City([
                            'region_id' => $parent->id,
                            'name' => empty($city['OFFNAME']) ? $city['FORMALNAME'] : $city['OFFNAME'],
                            'short_name' => $city['SHORTNAME'],
                            'postal_code' => empty($city['POSTALCODE']) ? '' : $city['POSTALCODE'],

                            'parent_id' => $parent->id,
                            'enabled' => 1,
                        ]);

                        $city->save();
                    }
                }
            }
        }
    }

    /*
     * Отдает город пользователя из кукисов, или ищет по ip.
     *
     * @return \App\Models\City
     */
    public static function getUserCity()
    {
        $city = static::getUserCityFromCookies();

        if ($city !== false) {
            return $city;
        }

        $city = static::findUserCity();

        Cookie::queue(
            // Разрешаем использовать эту куку в js флагом $httpOnly
            Cookie::make('city', $city->id, 60, null, null, null, $httpOnly = false)
        );

        return $city;
    }

    /**
     * Ищем город в кукисах.
     *
     * @return mixed
     */
    public static function getUserCityFromCookies()
    {
        $cityId = Cookie::get('city');

        $city = City::where('id', $cityId)->first();

        if (!empty($city) && $city->enabled) {
            return $city;
        }

        return false;
    }

    /**
     * Вычисляем подходящий город по ip. Если нет точного совпадения - ищем ближайший.
     *
     * @return \App\Models\City
     */
    public static function findUserCity()
    {
        try {
            $requestLocationData = geoip()->getLocation(
                geoip()->getClientIP()
            );
        }
        catch(\Exception $e) {}

        if (empty($requestLocationData)) {
            return static::getMainCity();
        }

        if (isset($requestLocationData->postal_code)) {
            $city = City::where('postal_code', $requestLocationData->postal_code)->first();

            if ($city) {
                return $city;
            }
        }

//        if (empty($city) && isset($requestLocationData->lat) && isset($requestLocationData->lon)) {
//            $city = static::findClosestCity(
//                $requestLocationData->lat,
//                $requestLocationData->lon
//            );
//        }

        return static::getMainCity();
    }

    /**
     * todo: доделать
     * Вычисляем подходящий город по ip. Если нет точного совпадения - ищем ближайший.
     *
     * @return mixed
     */
    public static function findClosestCity($lat, $lon)
    {
        $cities = Cities::enabled('currentI18n')->filter(function ($city) {
            return ! (empty($city->lat) || empty($city->lon));
        });

        $citiesCount = $cities->count();

        if ($citiesCount === 1) {
            return $cities->first();
        }

        if ($citiesCount === 0) {
            return static::getMainCity();
        }

        $closestCity = $cities->first();
        $shortest = static::getDistanceToCity($closestCity, $lat, $lon);


        foreach ($cities->slice(1) as $city) {
            $len = static::getDistanceToCity($city, $lat, $lon);

            if ($shortest > $len) {
                $shortest = $len;
                $closestCity = $city;
            }
        }

        return $closestCity;
    }

    /**
     * Определение расстояния от города до заданных координат.
     *
     * @param \App\Models\City $city
     * @param $lat
     * @param $lon
     * @return float
     */
    public static function getDistanceToCity($city, $lat, $lon)
    {
        return sqrt( pow($city->lat - $lat, 2) + pow($city->lon - $lon, 2));
    }

    /**
     * Отдает основной город.
     *
     * @return
     */
    public static function getMainCity()
    {
        return City::first() ?: false;
    }
}
