<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    // Маршруты для Авторизации через Соцсети
    Route::get('login/{provider}', 'Auth\SocialAuthController@redirect');
    Route::get('login/{provider}/callback', 'Auth\SocialAuthController@callback');

    Route::group(['prefix' => 'ru'], function () {
        Route::get('/test', 'LocationController@test');

        // Маршруты Авторизации
        Auth::routes();
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        // Главная страница
        Route::get('/', 'ContentController@index')
            ->name('home');

        // Каталог товаров
        Route::get('/catalog', 'Shop\CatalogController@index')->name('catalog');
        // Категория товаров
        Route::get('/catalog/{categorySlug}', 'Shop\CatalogController@category')->name('catalog-category');
        // Карточка товара
        Route::get('/goods/{id}', 'Shop\ProductController@index')->name('good');

        Route::get('/goods/{product}/reviews', 'Shop\ProductController@reviews');
        Route::put('/goods/{product}/reviews', 'ReviewController@product');

        Route::post('/reviews/{review}', 'ReviewController@edit');
        Route::delete('/reviews/{review}', 'ReviewController@delete');

        /*
         * Комнаты
         */
        Route::get('/rooms', 'Shop\RoomController@index')->name('rooms');
        Route::get('/rooms/{slug}', 'Shop\RoomController@catalog')->name('room-catalog');
        Route::get('/rooms/{slug}/{categorySlug}', 'Shop\RoomController@category')->name('room-category');

        /*
         * Стили
         */
        Route::get('/styles', 'Shop\StyleController@index')->name('styles');
        Route::get('/styles/{slug}', 'Shop\StyleController@catalog')->name('style-catalog');
        Route::get('/styles/{slug}/{categorySlug}', 'Shop\StyleController@category')->name('style-category');

        /*
         * Страницы
         */
        Route::get('/help', 'ContentController@help')->name('help');
        Route::get('/help/{slug}', 'ContentController@helpArticle')->name('help-article');

        Route::get('/privacy', 'ContentController@privacy')->name('privacy');
        Route::get('/about-us', 'ContentController@aboutUs')->name('about-us');
        Route::get('/contacts', function() {
            return view('shop.pages.contacts');
        })->name('contacts');


        Route::get('/privat-policy', 'ContentController@privat_policy')->name('privat_policy');
        Route::get('/use-policy', 'ContentController@use_policy')->name('use_policy');


        // Корзина
        Route::get('/cart', 'Shop\CartController@index')->name('cart');
        Route::post('/cart', 'Shop\CartController@get');
        Route::put('/cart', 'Shop\CartController@sync');
        Route::put('/cart/{key}', 'Shop\CartController@add');
        Route::post('/cart/promo', 'Shop\CartController@promo');

        // Оформление заказа
        Route::post('/checkout', 'Shop\CheckoutController@index');

        // Получение различных данных с сервера
        Route::get('/data', 'Shop\DataController@get');

        // Поиск
        Route::get('/search', 'Shop\SearchController@index');


        Route::get('/interior/iframe/{interior}', 'Shop\InteriorController@iframe');


//    Route::get('/test', 'Controller@test');

        Route::post('/forms/callback', 'FormController@callback');
        Route::post('/forms/feedback', 'FormController@feedback');
        Route::post('/forms/one-click', 'FormController@oneClick');

        /*
         * Лайки
         */
        Route::post('/like/review/{review}', 'LikeController@review');

        /*
         * Кабинетус
         */
        Route::group(['middleware' => 'ErrorIfNotAuthenticated'], function() {
            /*
             * История заказов
             */
            Route::get('/cabinet/orders', 'Cabinet\OrdersController@index')->middleware('OnlyAjax');

            /*
             * Профиль
             */
            Route::get('/cabinet', 'Cabinet\CabinetController@index')->name('cabinet');
            Route::get('/cabinet/profile', 'Cabinet\ProfileController@index')->middleware('OnlyAjax');
            Route::post('/cabinet/profile', 'Cabinet\ProfileController@save')->middleware('OnlyAjax');
            Route::post('/cabinet/profile/password', 'Cabinet\ProfileController@password')->middleware('OnlyAjax');
            Route::get('/cabinet/reviews', 'Cabinet\ReviewController@index')->middleware('OnlyAjax');

            /*
             * Социальные сети
             */
            Route::get('/cabinet/socials', 'Cabinet\SocialController@index')->middleware('OnlyAjax');
            Route::delete('/cabinet/socials', 'Cabinet\SocialController@detach')->middleware('OnlyAjax');
        });


        /**
         * Серверная валидация полей
         */
        Route::post('/validate/email', 'ValidationController@email');
        Route::post('/validate/phone', 'ValidationController@phone');


        /**
         * Поиск города
         */

        Route::get('/location', 'LocationController@search');
    });
});

Route::middleware('CheckLanguageCode')->get('{any}', 'ContentController@notFound')->where('any', '.*');
