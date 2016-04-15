<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});


Route::group(array('prefix' => 'api', 'middleware' => ['stats', 'api']), function() {
    Route::resource('cities', 'CitiesController');
    Route::resource('categories', 'CategoriesController');
    Route::get('categories/{id}/childrens', 'CategoriesController@childrens');
    Route::get('categories/{id}/events', 'CategoriesController@events');
    Route::get('categories/{id}/shops', 'CategoriesController@shops');

    Route::resource('shops', 'ShopsController');
    Route::resource('events', 'EventsController');
    Route::post('categories/follow', 'CategoriesController@follow');

    Route::resource('users', 'UsersController');

    Route::resource('promos', 'PromosController');

    Route::resource('reviews', 'ReviewsController');

    Route::resource('news', 'NewsController');
});

Route::group(array('prefix' => 'admin', 'middleware' => 'auth.verybasic'), function() {
    Route::get('/', 'AdminController@index');
    Route::get('/shops', 'ShopsController@showAll');
    Route::get('/shop/{id?}', 'ShopsController@edit');

    Route::get('/events', 'EventsController@showAll');
    Route::get('/event/{id?}', 'EventsController@edit');

    Route::get('/categories', 'CategoriesController@showAll');
    Route::get('/category/{id?}', 'CategoriesController@edit');

    Route::get('/reviews', 'ReviewsController@showAll');
    Route::get('/review/{id?}', 'ReviewsController@edit');

    Route::get('/publish/{id}', 'ReviewsController@publish');
    Route::get('/unpublish/{id}', 'ReviewsController@unpublish');

    Route::get('/promos', 'PromosController@showAll');
    Route::get('/promo/{id?}', 'PromosController@edit');
    
    Route::get('/news','NewsController@showAll');
    Route::get('/new/{id?}','NewsController@edit');
});

Route::get('images/{filename}', function ($filename) {
    $path = storage_path() . '/app/public/images/' . $filename;

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
