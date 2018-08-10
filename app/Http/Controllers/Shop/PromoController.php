<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Requests\CartRequest;
use App\Cart\CartProxy;


class PromoController extends Controller
{
//    public function index(Cart $cart, $promoCodeName)
//    {
//        $promoCode = new PromoCode($promoCodeName); // это модель или отдельная сущность??
//
//        /**
//         * Промокод не существует
//         */
//        if ($promoCode->notExist()) {
//            return response()->json([
//                'status' => 'error',
//                'message' => trans('shop.promo.not_exists')
//            ], 422);
//        }
//
//        /**
//         * Промокод устрарел
//         */
//        if ($promoCode->notActual()) {
//            return response()->json([
//                'status' => 'error',
//                'message' => trans('shop.promo.is_old')
//            ], 422);
//        }
//
//        /**
//         * Проверка на то, что промокод подходит к заказу
//         */
//        $checkResult = $cart->checkPromo($promoCode);
//
//        if ($checkResult->hasError()) {
//            return response()->json([
//                'status' => 'error',
//                'message' => $checkResult->getMessage()
//            ], 422);
//        }
//
//        $cart->applyPromoCode($promoCode);
//
//        return response()->json([
//            'status' => 'success',
//        ], 200);
//    }
}
