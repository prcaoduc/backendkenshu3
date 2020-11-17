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

Route::namespace('Auth')->group(function(){
    Route::get('/login', 'LoginController@show_login')->name('login');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::get('/register', 'LoginController@show_signup')->name('register');
    Route::post('/register', 'LoginController@signup');
    ROute::post('/logout', 'LoginController@logout')->name('logout');
});