<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Requests\CartRequest;
use App\Models\Shop\Promo\PromoCode;
use App\Http\Resources\PromoCodeResource;

use App\Http\Requests\PromoCodeRequest;
use Cart;


class CartController extends Controller
{
    public function index()
    {
        return view('shop.pages.cart');
    }

    public function get()
    {
        return $this->_makeResponse();
    }

    public function sync(CartRequest $request)
    {
        $lastUpdatedTime = Cart::getUpdatedAt();

        if ($request->input('time') > $lastUpdatedTime) {
            Cart::clear();
        }

        Cart::setMany($request->input('items'));

        return $this->_makeResponse();
    }

    public function add(CartRequest $request, $key)
    {
        Cart::add($key, $request->input('qty') ?: 1);

        return $this->_makeResponse();
    }

    protected function _makeResponse()
    {
        return response()->json([
            'status' => 'success',
            'cart'   => new CartResource(Cart::get()),
            'time'   => Cart::getUpdatedAt()
        ]);
    }

    public function promo(PromoCodeRequest $request)
    {
        $promoCode = PromoCode::where('name', $request->input('promo_code'))->first();
        Cart::setPromoCode($promoCode);

        return response()->json([
            'status' => 'success',
            'promo-code' => new PromoCodeResource($promoCode)
        ]);
    }
}
