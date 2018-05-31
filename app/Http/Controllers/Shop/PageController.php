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

    /**
     * Выводит страницу Политика конфедициальности
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view('shop.pages.privacy');
    }

    /**
     * Выводит страницу Комнаты
     *
     * @return \Illuminate\Http\Response
     */
    public function rooms()
    {
        return view('shop.pages.rooms');
    }

    /**
     * Выводит страницу Комнаты - Ванная
     *
     * @return \Illuminate\Http\Response
     */
    public function bathroom()
    {
        return view('shop.pages.rooms__bathroom');
    }

    /**
     * Выводит страницу Комнаты - Спальня
     *
     * @return \Illuminate\Http\Response
     */
    public function livingroom()
    {
        return view('shop.pages.rooms__livingroom');
    }

    /**
     * Выводит страницу Комнаты - Детская
     *
     * @return \Illuminate\Http\Response
     */
    public function childrenroom()
    {
        return view('shop.pages.rooms__childrenroom');
    }

    /**
     * Выводит страницу Комнаты - Кабинет
     *
     * @return \Illuminate\Http\Response
     */
    public function cabinet()
    {
        return view('shop.pages.rooms__cabinet');
    }

    /**
     * Выводит страницу Комнаты - Кухня и столовая
     *
     * @return \Illuminate\Http\Response
     */
    public function diningroom()
    {
        return view('shop.pages.rooms__diningroom');
    }

    /**
     * Выводит страницу Комнаты - Прихожая
     *
     * @return \Illuminate\Http\Response
     */
    public function hallway()
    {
        return view('shop.pages.rooms__hallway');
    }

    /**
     * Выводит страницу Комнаты - Спальня
     *
     * @return \Illuminate\Http\Response
     */
    public function bedroom()
    {
        return view('shop.pages.rooms__bedroom');
    }






}
