<?php

namespace App\Http\Controllers\Shop\BaseStructure;

use SeoProxy;
use App\Http\Controllers\Controller;
use App\Http\Resources\StructureCardResource;

class BaseStructureController extends Controller
{
    protected static $repository;

    protected static function find($slug)
    {
        $structureModel = static::$repository::enabled([
            'image',
            'currentI18n',
            'productCount'
        ])->where('slug', $slug)->first();

        if (! $structureModel) {
            abort(404);
        }

        // todo: вынести куда-то
        static::setMeta($structureModel);

        return $structureModel;
    }

    protected static function setMeta($structureModel)
    {
        SeoProxy::setMetaFromI18nModel($structureModel);
        SeoProxy::setImageFromModel($structureModel, 'oneHalf');
    }

    protected static function makeStructureCollection($collection, $getUrlFunction = null, $getProductCountFunction = null)
    {
        $request = request();

        $additional = [];

        if (! is_null($getUrlFunction)) {
            $additional['getUrlFunc'] = $getUrlFunction;
        }

        if (! is_null($getProductCountFunction)) {
            $additional['getProductCountFunc'] = $getProductCountFunction;
        }

        return array_values(StructureCardResource::collection($collection)->collection->map(function($item) use ($request, $additional) {
            return $item->additional($additional)->toArray($request);
        })->toArray($request));
    }
}
