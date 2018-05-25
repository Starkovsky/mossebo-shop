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
        return response()->json([
            'status' => 'success',
            'items' => CartResource::collection(CartProxy::get()),
            'time' => CartProxy::getSyncTime()
        ]);
    }

    /*
     * 1. Приходит запрос.
     * 2. Проверяем дату синхронизации. Если она больше текущей - ищем предметы. Иначе - возвращаем стандартные с пометкой.
     * 3. Проверка товаров на существование - оставляем только существующие с правильными опциями.
     * 4. Если есть расхождения - помечаем в ответе.
     */

    public function sync(CartRequest $request)
    {
        try {
            CartProxy::set($request->input('items'), $request->input('time'));
        }
        catch(\Exception $e) {

        }

        return response()->json([
           'status' => 'success',
           'items' => CartResource::collection(CartProxy::get()),
            'time' => CartProxy::getSyncTime()
        ]);
    }

    public function test()
    {
        CartProxy::add([
            'key' => random_int(100003, 100200),
            'qty' => 1
        ]);
    }
}
