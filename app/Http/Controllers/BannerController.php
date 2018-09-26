<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop\Banner\Banner;
use App\Http\Resources\Banner\BannerResource;
use BannerPlaces;
use Illuminate\Support\Collection;

class BannerController extends Controller
{
    protected static $cacheKeyNamespace = 'banners';

    protected function byPosition($placeId)
    {
        $bannersTableName = config('tables.Banners');
        $relationTableName = config('tables.BannerPlaceRelations');

        $query = Banner::enabled();

        $query
            ->join("{$relationTableName}", function($join) use($bannersTableName, $relationTableName, $placeId) {
                $join->on("{$bannersTableName}.id", '=', "{$relationTableName}.banner_id")
                    ->where("{$relationTableName}.place_id", $placeId)
                    ->groupBy(\DB::raw("{$bannersTableName}.id, {$relationTableName}.place_id, {$relationTableName}.banner_id"));
            });

        $request = request();

        return $query->get()->shuffle()->reduce(function($carry, $item) use($request) {
            $carry->push(
                (new BannerResource($item))->toArray($request)
            );

            return $carry;
        }, new Collection);
    }

    public function get($placeId)
    {
        return \Cache::remember(static::makeKey($placeId), 18000, function() use($placeId) {
            return $this->byPosition($placeId);
        });
    }

    public function random($placeId, $quantity = 1)
    {
        $banners = $this->get($placeId);

        $availableQuantity = min($quantity, $banners->count());

        if (! $availableQuantity) {
            return false;
        }

        $banners = $banners->random($availableQuantity);

        if ($quantity === 1) {
            return $banners->first();
        }

        return $banners;
    }

    public static function makeKey($positon)
    {
        return implode('::', [
            self::$cacheKeyNamespace,
            app()->getLocale(),
            $positon
        ]);
    }
}
