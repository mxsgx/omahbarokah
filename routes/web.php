<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ProductController@catalog')->name('home');
Route::get('/product/{product}', 'ProductController@show')->name('product');

Auth::routes();

Route::prefix('profile')->group(function () {
    Route::get('/', 'UserController@profile')->name('profile');
    Route::get('/edit', 'UserController@editProfile')->name('profile.edit')->middleware('auth');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', 'AdminController@home')->name('admin.home');
    Route::get('/users', 'UserController@index')->name('admin.user.index');
    Route::get('/products', 'ProductController@index')->name('admin.product.index');

    Route::prefix('user')->group(function () {
        Route::permanentRedirect('/', url('/admin/users'));
        Route::post('/', 'UserController@store')->name('admin.user.store');
        Route::get('/create', 'UserController@create')->name('admin.user.create');
        Route::get('/{user}', 'UserController@show')->name('admin.user.show');
        Route::get('/{user}/edit', 'UserController@edit')->name('admin.user.edit');
        Route::patch('/{user}', 'UserController@update')->name('admin.user.update');
        Route::delete('/{user}', 'UserController@delete')->name('admin.user.delete');
    });

    Route::prefix('product')->group(function () {
        Route::permanentRedirect('/', url('/admin/products'));
        Route::post('/', 'ProductController@store')->name('admin.product.store');
        Route::get('/create', 'ProductController@create')->name('admin.product.create');
        Route::get('/{product}', 'ProductController@detail')->name('admin.product.detail');
        Route::get('/{product}/edit', 'ProductController@edit')->name('admin.product.edit');
        Route::patch('/{product}', 'ProductController@update')->name('admin.product.update');
        Route::delete('/{product}', 'ProductController@delete')->name('admin.product.delete');
    });
});
