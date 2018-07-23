<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Attributes;
use Styles;
use Rooms;
use Categories;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\StyleResource;
use App\Http\Resources\RoomResource;

class DataController extends Controller
{
    protected static $repositories = [];

    protected static $cacheKey = 'interactionData';

    /**
     * Получение свежего ключа.
     *
     * @return mixed
     */
    public static function getRelevantKey()
    {
        return \Cache::remember(self::$cacheKey, 18000, function () {
            return md5(uniqid());
        });
    }

    /**
     * Чистка кэша.
     *
     * @param null $dataType
     */
    public static function clearCache($dataTypeOrModelClassName = false)
    {
        if (! $dataTypeOrModelClassName) {
            self::clearAllCache();
            return;
        }

        if (isset(self::$repositories[$dataTypeOrModelClassName])) {
            self::$repositories[$dataTypeOrModelClassName]::clearCache();
            \Cache::forget(self::$cacheKey);
            return;
        }

        $modelClassName = $dataTypeOrModelClassName;

        foreach (self::$repositories as $repo) {
            if ($repo::getModelClassName() === $modelClassName) {
                $repo::clearCache();
                \Cache::forget(self::$cacheKey);
                return;
            }
        }
    }

    public static function clearAllCache()
    {
        foreach (self::$repositories as $repository) {
            $repository::clearCache();
        }

        \Cache::forget(self::$cacheKey);
    }

    /**
     * Сбор данных.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public static function get(Request $request)
    {
        $keys = $request->input('dataKeys');

        if (empty($keys)) {
            return response(null, 200);
        }

        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $data = [];

        foreach ($keys as $key) {
            if (isset(self::$repositories[$key])) {
                self::_connectFromRepository($key, $data);
            }
            else {
                self::_connectFromMethod($key, $data);
            }
        }

        return response($data, 200);
    }

    /**
     * Получение данных из метода.
     *
     * @param $label
     * @param $data
     */
    protected static function _connectFromMethod($key, &$data)
    {
        $methodName = '_get';

        foreach (explode('-', $key) as $value) {
            $methodName .= ucfirst($value);
        }

        if (method_exists(__CLASS__, $methodName)) {
            try {
                $data[$key] = call_user_func([__CLASS__, $methodName]);
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    /**
     * Получение аттрибутов.
     */
    protected static function _getAttributes()
    {
        return AttributeResource::collection(
            \Attributes::enabled(['currentI18n'])
        );
    }

    /**
     * Получение категорий.
     */
    protected static function _getCategories()
    {
        return CategoryResource::collection(
            \Categories::enabled(['currentI18n'])
        );
    }

    /**
     * Получение стилей.
     */
    protected static function _getStyles()
    {
        return StyleResource::collection(
            \Styles::enabled(['currentI18n'])
        );
    }


    /**
     * Получение комнат.
     */
    protected static function _getRooms()
    {
        return RoomResource::collection(
            \Rooms::enabled(['currentI18n'])
        );
    }
}
