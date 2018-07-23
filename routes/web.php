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

Route::redirect('/', '/ru', 301);

Route::prefix('ru')->group(function () {

    // Маршруты Авторизации
    Auth::routes();

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
    Route::get('/cabinet', 'ContentController@cabinet')->name('cabinet');


    /*
     * Личный кабинет
     */
//    Route::prefix('lk')->group(function () {
//        Route::get('/', 'Shop\HomeController@index')
//            ->name('lk');
//    });

    // Корзина
    Route::get('/cart', 'Shop\CartController@index')->name('cart');
    Route::post('/cart', 'Shop\CartController@get');
    Route::put('/cart', 'Shop\CartController@sync');
    Route::put('/cart/{key}', 'Shop\CartController@add');

    // Оформление заказа
    Route::post('/checkout', 'Shop\CheckoutController@index');
    Route::post('/checkout/email', 'Shop\CheckoutController@email');
    Route::post('/checkout/phone', 'Shop\CheckoutController@phone');

    // Получение различных данных с сервера
    Route::get('/data', 'Shop\DataController@get');

    // Поиск
    Route::get('/search', 'Shop\SearchController@index');


//    Route::get('/test', 'Controller@test');

    Route::post('/forms/callback', 'FormController@callback');
    Route::post('/forms/feedback', 'FormController@feedback');
    Route::post('/forms/one-click', 'FormController@oneClick');

    /*
     * Лайки
     */

    Route::post('/like/review/{review}', 'LikeController@review');
});

// Маршруты для Авторизации через Соцсети
Route::get('login/{provider}', 'Auth\SocialAuthController@redirect');
Route::get('login/{provider}/callback', 'Auth\SocialAuthController@callback');
