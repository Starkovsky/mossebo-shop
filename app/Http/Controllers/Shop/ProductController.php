<?php

namespace App\Http\Controllers\Shop;


use App\Models\Shop\Product;
use App\Models\Shop\Category;
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

    /**
     * Выводит все товары
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        try {

//            $product = Product::with('i18n','prices','supplier','images')
//                ->where('enabled','=','true')
//                ->get();

            $nodes = Category::withDepth()->having('depth', '=', 1)->get();

            $traverse = function ($categories, $prefix = '-') use (&$traverse) {
                    foreach ($categories as $category) {
                        echo PHP_EOL.$prefix.' '.$category->slug.'<br>';

                        $traverse($category->children, $prefix.'-');
                    }
            };
            echo $nodes;
            //$traverse($nodes);
//            return view('shop.product', [
//                'product' => $product,
//            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
