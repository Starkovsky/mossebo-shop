<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Выводит страницу Доставка
     *
     * @return \Illuminate\Http\Response
     */
    public function delivery()
    {
        return view('shop.pages.delivery');
    }

    /**
     * Выводит страницу Оплата
     *
     * @return \Illuminate\Http\Response
     */
    public function pay()
    {
        return view('shop.pages.pay');
    }

    /**
     * Выводит страницу Гарантии
     *
     * @return \Illuminate\Http\Response
     */
    public function garant()
    {
        return view('shop.pages.garant');
    }
}
