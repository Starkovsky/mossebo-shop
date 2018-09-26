<?php

namespace App\Http\Controllers;

use Cities;
use Auth;
use Shop;
use App\Http\Resources\Cart\PromoCodeResource;
use Illuminate\Support\Collection;

class ConfigController extends Controller
{
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
        ];

        $this->__connectTranslates($config);
        $this->__connectLocations($config);
        $this->__connectUserData($config);
        $this->__connectDefaultPromo($config);
        $this->__connectBanners($config);

        return json_encode($config, JSON_UNESCAPED_UNICODE);
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
        $user = Auth::user();

        if (! $user) return;

        $config['user'] = [
            'id'         => $user->id,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'phone'      => $user->phone,
            'email'      => $user->email,
            'city'       => $user->city,
            'address'    => $user->address,
            'post_code'  => $user->post_code,
        ];

        foreach ($config['user'] as $key => $value) {
            if (empty($config['user'][$key])) {
                unset($config['user'][$key]);
            }
        }

        if ($user->getPriceTypeId() !== Shop::getDefaultPriceTypeId()) {
            $user['promoDisabled'] = true;
        }
    }

    protected function __connectDefaultPromo(& $config)
    {
        if ($promoCode = Shop::getDefaultPromoCode()) {
            $config['defaultPromo'] = new PromoCodeResource($promoCode);
        }
    }

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
}
