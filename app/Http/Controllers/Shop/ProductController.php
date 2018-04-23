<?php

namespace App\Http\Controllers\Shop;


use App\Models\Shop\Product;
use App\Http\Controllers\Controller;

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
     * Выводит главную страницу
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {

            $product = Product::with('i18n','prices','supplier','images')
                ->where('enabled','=','true')
                ->findOrFail($id);
            //echo $product;

            return view('shop.product', [
                'product' => $product,
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }


    }
}
