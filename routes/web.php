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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::group([
    'prefix' => '/master' 
    // 'middleware' => 'auth'
], function () {
    Route::get('/', 'MasterController@index')->name('master');
    Route::group([
        'prefix' => '/floor' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'FloorController@index')->name('master.floor.show');
        Route::post('/', 'FloorController@store')->name('master.floor.store');
        Route::get('/{id}', 'FloorController@show')->name('master.floor.find');
        Route::put('/{id}', 'FloorController@update')->name('master.floor.update');;
        Route::delete('/{id}', 'FloorController@destroy')->name('master.floor.delete');
    });
    
    Route::group([
        'prefix' => '/categories' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'CategoryController@index');
        Route::post('/', 'CategoryController@store');
        Route::get('/{id}', 'CategoryController@show');
        Route::put('/{id}', 'CategoryController@update');
        Route::delete('/{id}', 'CategoryController@destroy');
    });
    
    Route::group([
        'prefix' => '/nos' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'NoController@index');
        Route::post('/', 'NoController@store');
        Route::get('/{id}', 'NoController@show');
        Route::put('/{id}', 'NoController@update');
        Route::delete('/{id}', 'NoController@destroy');
    });

    Route::group([
        'prefix' => '/areanos' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'AreaNoController@index');
        Route::post('/', 'AreaNoController@store');
        Route::get('/{id}', 'AreaNoController@show');
        Route::put('/{id}', 'AreaNoController@update');
        Route::delete('/{id}', 'AreaNoController@destroy');
    });

    Route::group([
        'prefix' => '/stalls' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'StallController@index');
        Route::post('/', 'StallController@store');
        Route::get('/{id}', 'StallController@show');
        Route::put('/{id}', 'StallController@update');
        Route::delete('/{id}', 'StallController@destroy');
    });

    Route::group([
        'prefix' => '/electricities' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'ElectricityController@index');
        Route::post('/', 'ElectricityController@store');
        Route::get('/{id}', 'ElectricityController@show');
        Route::put('/{id}', 'ElectricityController@update');
        Route::delete('/{id}', 'ElectricityController@destroy');
    });
});

Route::get('/home', 'HomeController@index')->name('home');

//route ajax livesearch
Route::get('/search', 'FloorController@search')->name('master.floor.search');
