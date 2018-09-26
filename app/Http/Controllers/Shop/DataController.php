<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Attributes;
use Styles;
use Rooms;
use Categories;
use BadgeTypes;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\StyleResource;
use App\Http\Resources\RoomResource;
use App\Http\Resources\BadgeTypeResource;

use App\Models\Shop\Banner\Banner;
use App\Http\Resources\Banner\BannerResource;
use App\Support\Traits\Cacheable;

class DataController extends Controller
{
    use Cacheable;

    protected static $repositories = [
        'attributes' => [
            'repository' => Attributes::class,
            'resource' => AttributeResource::class,
        ],
        'categories' => [
            'repository' => Categories::class,
            'resource' => CategoryResource::class,
        ],
        'styles' => [
            'repository' => Styles::class,
            'resource' => StyleResource::class,
        ],
        'rooms' => [
            'repository' => Rooms::class,
            'resource' => RoomResource::class,
        ],
        'badge-types' => [
            'repository' => BadgeTypes::class,
            'resource' => BadgeTypeResource::class,
        ]
    ];

    protected static $cacheNamespace = 'shop-data';

    /**
     * Получение свежего ключа.
     *
     * @return mixed
     */
    public static function getRelevantKey()
    {
        return \Cache::remember(self::makeCacheKey(), 18000, function () {
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
            \Cache::forget(self::makeCacheKey());
            return;
        }

        $modelClassName = $dataTypeOrModelClassName;

        foreach (self::$repositories as $repo) {
            if ($repo::getModelClassName() === $modelClassName) {
                $repo::clearCache();
                \Cache::forget(self::makeCacheKey());
                return;
            }
        }
    }

    public static function clearAllCache()
    {
        foreach (self::$repositories as $repository) {
            $repository::clearCache();
        }

        \Cache::forget(self::makeCacheKey());
        \Cache::forget(self::makeCacheKey('banners'));
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

    protected static function _connectFromRepository($key, &$data)
    {
        $data[$key] = self::$repositories[$key]['resource']::collection(
            self::$repositories[$key]['repository']::getCollection()
        );
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

    protected static function _getBanners()
    {
        return \Cache::remember(self::makeCacheKey('banners'), 18000, function() {
            $query = Banner::enabled()
                ->with('places')
                ->orderBy('position', 'asc')
                ->orderBy('id', 'desc');

            return BannerResource::collection($query->get());
        });
    }


}
