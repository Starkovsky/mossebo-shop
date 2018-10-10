<?php

namespace App\Http\Controllers;

use Cart;
use Cookie;
use App\Models\PostalCode;
use App\Models\City;
use App\Models\Region;

use App\Models\Shop\Category\CategoryProduct;
use App\Models\Shop\Category\Category;

class LocationController extends Controller
{
    protected static $cityIdCookieKey = '__city::id';

//    public function test()
//    {
////        return;
//        ini_set("memory_limit","2048M");
//        ini_set('max_execution_time', 3000);
//
//
////        $this->saveRegions();
//        \DB::transaction(function () {
//            $this->saveCities();
//            $this->savePostalCodes();
//        });
//
//        dd('done', array_diff(
//            scandir(app_path('Geo')),
//            array('.', '..', '.DS_Store')
//        ));
//    }

//    protected function saveRegions()
//    {
//        $path = app_path('Geo');
//        $files = array_diff(scandir($path), array('.', '..', '.DS_Store'));
//
////        $regions = Region::get();
//
//        foreach ($files as $file) {
//            $addresses = file_get_contents($path . '/' . $file);
//            $addresses = json_decode($addresses, true);
//
//            $this->parseFile($addresses);
//        }
//    }

//    protected function parseFile($addresses)
//    {
//        foreach ($addresses as $address) {
//            if (empty($address['POSTALCODE'])) continue;
//
//            dd($address);
//        }
//
//        dd($addresses);
//    }
//
//    protected function saveRegions()
//    {
//        $path = app_path('Geo');
//        $files = array_diff(scandir($path), array('.', '..', '.DS_Store'));
//
////        $regions = Region::get();
//
//        foreach ($files as $file) {
//            $cities = file_get_contents($path . '/' . $file);
//            $cities = json_decode($cities, true);
//
//            $cities = array_filter($cities, function ($city) {
//                return $city['CURRSTATUS'] == 0;
//            });
//
//            foreach ($cities as $city) {
//                if ($city['AOLEVEL'] == 1) {
////                    $exist = $regions->where('region_code', $city['REGIONCODE'])
////                        ->where('area_code', $city['AREACODE'])
////                        ->exists();
////
////                    if ($exist) {
////                        continue;
////                    }
//
//                    $region = new Region([
//                        'country_code' => 'Ru',
//                        'name'         => empty($city['OFFNAME']) ? $city['FORMALNAME'] : $city['OFFNAME'],
//                        'short_name'   => $city['SHORTNAME'],
//                        'fias_code'    => $city['CODE'],
//                        'okato_code'   => $city['OKATO'],
//                        'aoguid'       => $city['AOGUID'],
//                        'parent_id'    => 0,
//                        'enabled'      => 1,
//
//                    ]);
//
//                    $region->save();
//                }
//            }
//
////            $regions = Region::get();
//
//            foreach ($cities as $city) {
////                if ($region->region_code !== $city['REGIONCODE']) {
////                    dd('a', $city);
////                }
//
//                if ($city['AOLEVEL'] == 3) {
//                    $city = new Region([
//                        'country_code' => 'Ru',
//                        'name'         => empty($city['OFFNAME']) ? $city['FORMALNAME'] : $city['OFFNAME'],
//                        'short_name'   => $city['SHORTNAME'],
//                        'fias_code'    => $city['CODE'],
//                        'okato_code'   => $city['OKATO'],
//                        'aoguid'       => $city['AOGUID'],
//                        'parent_id'    => $region->id,
//                        'enabled'      => 1,
//                    ]);
//
//                    $city->save();
//                }
//            }
//        }
//    }

    protected function saveCities()
    {
        $path = app_path('Geo');
        $files = array_diff(scandir($path), array('.', '..', '.DS_Store'));

        $regions = Region::get();

        foreach ($files as $file) {
            $cities = file_get_contents($path . '/' . $file);
            $cities = json_decode($cities, true);

            $cities = array_filter($cities, function ($city) {
                return $city['CURRSTATUS'] == 0;
            });

            foreach ($cities as $city) {
                if ($city['AOLEVEL'] != 4 && $city['AOLEVEL'] != 6 ) {
                    continue;
                }

                if (! in_array($city['SHORTNAME'], ["п/ст", "с", "п", "высел", "у", "дп", "рп", "х", "гп", "с/мо", "кп", "г", "г.", "д", "аал", "ст-ца", "ст", "с/п", "снт", "м", "заимка", "нп", "пгт", "арбан", "городок", "аул", "массив", "сл", "починок"])) {
                    continue;
                }

                $parent = $regions
                    ->where('fias_code', $city['REGIONCODE'] . $city['AREACODE'] . '00000000')
                    ->first();

                $city = new City([
                    'region_id'  => $parent->id,
                    'name'       => empty($city['OFFNAME']) ? $city['FORMALNAME'] : $city['OFFNAME'],
                    'short_name' => str_replace('г.', 'г', $city['SHORTNAME']),
                    'fias_code'  => $city['CODE'],
                    'okato_code' => $city['OKATO'],
                    'aoguid'     => $city['AOGUID'],
                    'parent_id'  => $parent->id,
                    'enabled'    => 1,
                ]);

                $city->save();
            }
        }
    }

    protected function savePostalCodes()
    {
        $path = app_path('Geo');
        $files = array_diff(scandir($path), array('.', '..', '.DS_Store'));

        $codes = [];
//$c = [];
        foreach ($files as $file) {
            $places = file_get_contents($path . '/' . $file);
            $places = json_decode($places, true);

            $places = array_filter($places, function ($city) {
                return $city['CURRSTATUS'] == 0;
            });

            foreach ($places as $place) {
                if (empty($place['POSTALCODE'])) {
                    continue;
                }

                $code = implode('', [
                    $place['REGIONCODE'],
                    $place['AREACODE'],
                    $place['CITYCODE'],
                    $place['PLACECODE'],
//                    '000',
                    '00'
                ]);

                if ($place['CODE'] === $code) {
                    continue;
                }

                if (! isset($city) || $city->fias_code !== $code) {
                    $city = City::where('fias_code', $code)->first();
                }

                if ($city) {
                    $codes[$place['POSTALCODE']] = [
                        'type' => 'city',
                        'id' => $city->id,
                    ];
                }
                else {
                    if (! isset($region) || $region->fias_code !== $code) {
                        $region = Region::where('fias_code', $code)->first();
                    }

                    if ($region) {
                        $codes[$place['POSTALCODE']] = [
                            'type' => 'region',
                            'id' => $region->id,
                        ];
                    }
                    else {
//                        $c[] = array_filter($places, function ($city) use($code) {
//                            return strpos($city['CODE'], $code) === 0;
//                        });
                    }
                }
            }
        }

//        $a = [];
//
//        foreach ($c as $b) {
//            $a[$b[0]['SHORTNAME']] = 1;
//        }
//
//        if (! empty($c)) {
//            dd($a);
//        }

        foreach ($codes as $code => $data) {
            $postalCode = new PostalCode([
                'item_id'   => $data['id'],
                'item_type' => $data['type'],
                'code'      => $code,
            ]);

            $postalCode->save();
        }

//        dd($codes);
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

        if ($city) {
            Cookie::queue(
            // Разрешаем использовать эту куку в js флагом $httpOnly
                static::$cityIdCookieKey, $city->id, 60, null, null, false, false
            );
        }

        return $city;
    }

    /**
     * Ищем город в кукисах.
     *
     * @return mixed
     */
    public static function getUserCityFromCookies()
    {
        $cityId = Cookie::get(static::$cityIdCookieKey);

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
            $code = PostalCode::where('code', $requestLocationData->postal_code)->with('item')->first();

            if ($code) {
                return $code->item;
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
        return City::where('id', config('location.default_city_id'))->first() ?: false;
    }
}
