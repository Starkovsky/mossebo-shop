<?php

namespace App\Http\Controllers;

use Cookie;
use Countries;
use App\Models\City;
use App\Models\PostCode;

class LocationController extends Controller
{
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
            $code = PostCode::with('city')->where('code', $requestLocationData->postal_code)->first();

            if ($code && $code->relationNotEmpty('city')) {
                return $code->city;
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
        return City::where('sdek_code', 137)->first() ?: false;
    }
}
