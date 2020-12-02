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
Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => ['can:article.create']], function () {
            Route::get('/create', 'ArticleController@create')
                ->name('create');
            Route::post('/create', 'ArticleController@store')
                ->name('store');
        });
        Route::group(['middleware' => ['can:article.update,article']], function () {
            Route::get('/{article}/edit', 'ArticleController@edit')
                ->name('edit');
            Route::post('/{article}/update', 'ArticleController@update')
                ->name('update');
        });
        Route::post('/{article}/publish', 'ArticleController@publish')
            ->name('publish')
            ->middleware('can:article.publish');
        Route::post('/{article}/delete', 'ArticleController@delete')
            ->name('delete')
            ->middleware('can:article.delete,article');
        Route::post('/destroy', 'ArticleController@destroy')
            ->name('destroy')
            ->middleware('can:article.destroy');
    });
    Route::get('/{id}', 'ArticleController@show')->name('show');
});

Route::group(['prefix' => 'me', 'as' => 'account.', 'middleware' => 'auth'], function () {
    Route::get('/', 'AccountController@show')->name('show');
    Route::get('/drafts', 'AccountController@drafts')
        ->name('drafts')
        ->middleware('can:article.draft');
});

Route::group(['prefix' => 'images', 'as' => 'images.', 'middleware' => 'auth'], function () {
    Route::post('/create', 'ImageController@store')->name('store');
});

Route::namespace ('Auth')->group(function () {
    Route::get('/login', 'LoginController@show_login')->name('login');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::get('/register', 'RegisterController@signup')->name('register');
    Route::post('/register', 'RegisterController@create')->name('register');
    Route::post('/logout', 'LoginController@logout')->middleware('auth')->name('logout');
});

Route::get('/democlass', function () {
    $message = app()->make('democlass')->demoMethod();
    $messagefacade = DemoClass::demoMethodFacade();
    echo $message;
    echo $messagefacade;
});
