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

    Route::get('/', 'Shop\HomeController@index')
        ->name('home');
    Route::get('/goods/{id}', 'Shop\ProductController@index')
        ->name('good');
    Route::get('/catalog/{category_slug}', 'Shop\CatalogController@index')
        ->name('catalog');

    Route::get('/delivery', 'Shop\PageController@delivery')->name('delivery');
    Route::get('/pay', 'Shop\PageController@pay')->name('pay');
    Route::get('/garant', 'Shop\PageController@garant')->name('garant');

    Route::get('/privacy', 'Shop\PageController@privacy')->name('privacy');

    Auth::routes();

    Route::prefix('lk')->group(function () {

        Route::get('/', 'Shop\HomeController@index')
            ->name('lk');

    });

    Route::get('/cart', 'Shop\CartController@index');
    Route::post('/cart', 'Shop\CartController@get');
    Route::put('/cart', 'Shop\CartController@sync');
    Route::get('/cart/test', 'Shop\CartController@test');
});

Route::get('login/{provider}', 'Auth\SocialAuthController@redirect');
Route::get('login/{provider}/callback', 'Auth\SocialAuthController@callback');

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {

    $provider = 'vkontakte';

    $provider = Config::get("services.{$provider}");

    return $provider;
});

