<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Requests\CartRequest;
use App\Cart\CartProxy;


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
        try {
            CartProxy::set($request->input('items'), $request->input('time'));
        }
        catch(\Exception $e) {}

        return $this->_makeResponse();
    }

    public function add(CartRequest $request, $key)
    {
        CartProxy::add([
            'key' => $key,
            'qty' => $request->input('qty') ?: 1
        ]);

        return $this->_makeResponse();
    }

    protected function _makeResponse()
    {
        return response()->json([
            'status' => 'success',
            'items' => CartResource::collection(CartProxy::get()),
            'time' => CartProxy::getSyncTime()
        ]);
    }
}
