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
    public function index($category_slug)
    {
        try {

            $category = Category::with(['i18n','ancestors' => function($query) {
                $query->with('i18n')->defaultOrder()->get();
            }])
                ->where('slug', '=', $category_slug)
                ->where('enabled', '=', 'true')
                ->firstOrFail();

            // Проверка доступности категории
            if ($category->enabled) {

                return view('shop.pages.catalog', [
                    'category' => $category,
                ]);
            } else {
                return abort(404);
            }
        } catch (\Exception $e) {
            // TODO: Временно закоментировано, надо куда то складывать ошибки
            return $e->getMessage();
            //return abort(404);
        }
    }
}
