<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
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
     * Выводит весь каталог
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return view('shop.catalog', [
            //'product' => $product,
        ]);
    }
}
