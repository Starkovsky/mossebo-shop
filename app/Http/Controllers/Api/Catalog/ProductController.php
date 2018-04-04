<?php

namespace App\Http\Controllers\Api\Catalog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
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
     * Show the application Homepage.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        $allproduct = Product::all()->where('id',5);
//        dd($allproduct);
//
//        return view('index');
//    }
    /**
     * Show the application New Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $allproduct = Product::all();

        return json_encode($allproduct);;
    }
}
