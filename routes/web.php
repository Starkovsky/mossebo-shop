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
    Route::get('/', 'Shop\HomeController@index')
        ->name('home');
    // Карточка товара
    Route::get('/goods/{id}', 'Shop\ProductController@index')
        ->name('good');
    // Категория товаров
    Route::get('/catalog/{category_slug}', 'Shop\CatalogController@index')
        ->name('catalog');

    /*
     * Страницы
     */

    // Доставка
    Route::get('/delivery', 'Shop\PageController@delivery')->name('delivery');
    // Оплата
    Route::get('/pay', 'Shop\PageController@pay')->name('pay');
    //Гарантии
    Route::get('/garant', 'Shop\PageController@garant')->name('garant');

    // Политика конфедициальности
    Route::get('/privacy', 'Shop\PageController@privacy')->name('privacy');

    // Комнаты
    Route::prefix('rooms')->group(function () {

        // Все комнаты
        Route::get('/', 'Shop\PageController@rooms')
            ->name('rooms');

        // Комната - Спальня
        Route::get('/bathroom', 'Shop\PageController@bathroom')
            ->name('bathroom');
        // Комната - Гостиная
        Route::get('/livingroom', 'Shop\PageController@livingroom')
            ->name('livingroom');
        // Комната - Детская
        Route::get('/childrenroom', 'Shop\PageController@childrenroom')
            ->name('childrenroom');
        // Комната - Кабинет
        Route::get('/cabinet', 'Shop\PageController@cabinet')
            ->name('cabinet');
        // Комната - Кухня и столовая
        Route::get('/diningroom', 'Shop\PageController@diningroom')
            ->name('diningroom');
        // Комната - Прихожая
        Route::get('/hallway', 'Shop\PageController@hallway')
            ->name('hallway');
        // Комната - Спальня
        Route::get('/bedroom', 'Shop\PageController@bedroom')
            ->name('bedroom');
    });

    /*
     * Личный кабинет
     */
    Route::prefix('lk')->group(function () {

        Route::get('/', 'Shop\HomeController@index')
            ->name('lk');

    });

    // Корзина
    Route::get('/cart', 'Shop\CartController@index')->name('cart');
    Route::post('/cart', 'Shop\CartController@get');
    Route::put('/cart', 'Shop\CartController@sync');
    Route::put('/cart/{key}', 'Shop\CartController@add');

    // Оформление заказа
    Route::post('/checkout', 'Shop\CheckoutController@index');
    Route::post('/checkout/email', 'Shop\CheckoutController@email');
    Route::post('/checkout/phone', 'Shop\CheckoutController@phone');
});

// Маршруты для Авторизации через Соцсети
Route::get('login/{provider}', 'Auth\SocialAuthController@redirect');
Route::get('login/{provider}/callback', 'Auth\SocialAuthController@callback');



// Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/test', function () {
//
//    $provider = 'vkontakte';
//
//    $provider = Config::get("services.{$provider}");
//
//    return $provider;
//});

