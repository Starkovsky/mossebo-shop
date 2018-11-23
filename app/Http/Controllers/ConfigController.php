<?php

namespace App\Http\Controllers;

use Cities;
use Auth;
use Shop;
use App\Http\Resources\Cart\PromoCodeResource;
use App\Http\Controllers\Shop\DataController;

class ConfigController extends Controller
{
    protected $user = null;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $lang = \Languages::getCollection()->first();

        $config = [
            'language' => [
                'code' => $lang->code
            ],
            'currency' => [
                'code' => $lang->currency_code
            ],
            'base_time' => time()
        ];

        $this->__connectTranslates($config);
        $this->__connectLocations($config);
        $this->__connectUserData($config);
//        $this->__connectDefaultPromo($config);
        $this->__connectBanners($config);
        $this->__connectFranchisee($config);
        $this->__connectDataTypes($config);
        $this->__connectMetrika($config);

        return json_encode($config, JSON_UNESCAPED_UNICODE);
    }


    protected function __connectMetrika(& $config)
    {
        $config['metrika'] = [
            'yandex' => [
                'id' => env('METRIKA_YANDEX_ID')
            ],
            'facebook' => [
                'id' => env('METRIKA_FACEBOOK_ID')
            ]
        ];
    }

    protected function __connectFranchisee(& $config)
    {
        if (Shop::isFranchiseeDomain() && $this->user && $this->user->isFranchisee()) {
            $config['user']['token'] = $this->user->api_token;
        }
    }


    // todo: Добавлять только нужные для страницы переводы?
    protected function __connectTranslates(& $config)
    {
        $config['translates'] = \Lang::get('js');
    }

    protected function __connectLocations(& $config)
    {
        $userCity = LocationController::getUserCity();

        if ($userCity) {
            $config['location'] = [
                'city' => [
                    'id' => $userCity->id,
                    'name' => $userCity->name,
                ]
            ];
        }
    }

    protected function __connectUserData(& $config)
    {
        if (! $this->user) return;

        $fields = [
            'id',
            'first_name',
            'last_name',
            'phone',
            'email',

            'city',
            'street',
            'house_number',
            'apartment',
            'floor',
            'entrance',
            'intercom',
            'post_code'
        ];

        foreach($fields as $field) {
            if (! empty($value = $this->user->{$field})) {
                $config['user'][$field] = $value;
            }
        }

        if ($this->user->getPriceTypeId() !== Shop::getDefaultPriceTypeId()) {
            $this->user['promoDisabled'] = true;
        }
    }

//    protected function __connectDefaultPromo(& $config)
//    {
//        if ($promoCode = Shop::getDefaultPromoCode()) {
//            $config['defaultPromo'] = new PromoCodeResource($promoCode);
//        }
//    }

    protected function __connectBanners(& $config)
    {
        $bannersController = app()->make(\App\Http\Controllers\BannerController::class);

        if (Shop::isMainPage()) {
            $config['banners']['home'] = $bannersController->random(2, 8);
        }

        if (Shop::isCatalog()) {
            $config['banners']['catalogFilters'] = $bannersController->random(3, 8);
            $config['banners']['catalogList'] = $bannersController->random(4, 8);
        }
    }

    protected function __connectDataTypes(& $config)
    {
        $config['data-types'] = DataController::getDataTypes();
    }
}
