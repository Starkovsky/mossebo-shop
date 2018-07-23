<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('ru')->group(function () {
    Route::get('/catalog/{slug}', 'Api\Shop\CategoryController@products');
    Route::get('/rooms/{slug}', 'Api\Shop\RoomController@products');
    Route::get('/rooms/{slug}/{category}', 'Api\Shop\RoomController@catalog');
    Route::get('/styles/{slug}', 'Api\Shop\StyleController@products');
    Route::get('/styles/{slug}/{category}', 'Api\Shop\StyleController@catalog');
    Route::get('/search', 'Api\Shop\SearchController@index');

    Route::get('/filters', 'Api\Shop\FilterController@index');

    Route::get('/sale', 'Api\Shop\SaleController@random');

    Route::get('/goods/popular', 'Api\Shop\ProductController@popular');
    Route::get('/goods/new', 'Api\Shop\ProductController@new');
});



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
