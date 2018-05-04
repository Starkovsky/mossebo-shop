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

            $product = Product::with(
                'i18n',
                'images',
                'current_price',
                'old_price',
                'attributes',
                'attribute_options'
            )
                ->where('enabled','=','true')
                ->findOrFail($id);

            // Проверка доступности товаров поставщика
            if($product->supplier->enabled) {
                return view('shop.pages.product', [
                    'product' => $product,
                ]);
            }
            else {
                return abort(404);
            }
        }
        catch (\Exception $e) {
            // TODO: Временно закоментировано, надо куда то складывать ошибки
            return $e->getMessage();
            //return abort(404);
        }
    }
}
