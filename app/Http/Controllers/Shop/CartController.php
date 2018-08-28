<?php

namespace App\Http\Controllers\Shop;

use Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Requests\CartRequest;
use App\Http\Resources\PromoCodeResource;

use App\Http\Requests\PromoCodeRequest;
use MosseboShopCore\Contracts\Shop\Cart\Promo\PromoCode;

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

        if ($request->input('time') >= $lastUpdatedTime) {
            Cart::clearProducts();
            Cart::setMany($request->input('items'));
        }

        return $this->_makeResponse();
    }

    public function add(CartRequest $request, $key)
    {
        Cart::add($key, $request->input('qty') ?: 1);

        return $this->_makeResponse();
    }

    protected function _makeResponse()
    {
        $cart = Cart::get();

        $data = [
            'status' => 'success',
            'cart'   => new CartResource($cart),
            'time'   => Cart::getUpdatedAt()
        ];

        if ($lastPromo = $cart->getLastPromoCodeInfo()) {
            $data['errors'] = [
                'promo_code' => $lastPromo['error']
            ];
        }

        return response()->json($data);
    }

    public function promo(PromoCodeRequest $request)
    {
        $promoCode = app()->makeWith(PromoCode::class, [
            'codeName' => $request->input('promo_code')
        ]);

        Cart::setPromoCode($promoCode);

        $promoCodeResource = new PromoCodeResource($promoCode);
        $promoCodeResource->setStatus('confirmed');

        return $this->_makeResponse();
    }
}
