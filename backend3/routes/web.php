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

Route::get('/haha', function () {
    return view('welcome');
})->name('welcome');

Route::get('/', 'PagesController@home')->name('home');
Route::group([ 'prefix' => 'articles', 'as' => 'articles.' ], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', 'ArticleController@create')->name('create');
        Route::post('/create', 'ArticleController@store')->name('store');
        Route::get('/{id}/edit', 'ArticleController@edit')->name('edit');
        Route::post('/{id}/update', 'ArticleController@update')->name('update');
        Route::post('/{id}/delete', 'ArticleController@delete')->name('delete');
    });
    Route::get('/{id}', 'ArticleController@show')->name('show');
});


Route::group([ 'prefix' => 'me', 'as' => 'profile.', 'middleware' => 'auth' ], function(){
    Route::get('/{id}', 'ProfileController@show')->name('show');
});

Route::group([ 'prefix' => 'images', 'as' => 'images.', 'middleware' => 'auth' ], function (){
    Route::post('/create', 'ImageController@store')->name('store');
});

Route::namespace('Auth')->group(function () {
    Route::get('/login', 'LoginController@show_login')->name('login');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::get('/register', 'RegisterController@signup')->name('register');
    Route::post('/register', 'RegisterController@create')->name('register');
    Route::post('/logout', 'LoginController@logout')->middleware('auth')->name('logout');
});
