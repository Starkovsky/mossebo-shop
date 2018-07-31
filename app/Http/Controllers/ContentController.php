<?php

namespace App\Http\Controllers;

use Lang;

class ContentController extends Controller
{
    public function index()
    {
        return view('shop.pages.index');
    }

    public function help()
    {
        return view('shop.pages.help.index');
    }

    public function helpArticle($slug)
    {
        $articles = [
            [
                'title' => Lang::get('content.delivery'),
                'slug' => 'delivery'
            ],

            [
                'title' => Lang::get('content.pay'),
                'slug' => 'pay'
            ],

            [
                'title' => Lang::get('content.garant'),
                'slug' => 'garant'
            ],
        ];

        foreach ($articles as $article) {
            if ($article['slug'] === $slug) {
                return view('shop.pages.help.article', [
                    'article' => (object) $article,
                    'items' => json_decode(file_get_contents(base_path("resources/views/shop/pages/help/{$slug}.json")))
                ]);
            }
        }

        $this->notFound();
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
     * Выводит страницу Политика конфедициальности
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        return view('shop.pages.about-us');
    }

    public function notFound()
    {
        return abort(404);
    }
}
