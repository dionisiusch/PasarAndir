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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group([
    'prefix' => '/floors' 
    // 'middleware' => 'auth'
], function () {
    Route::get('/', 'FloorController@index');
    Route::post('/', 'FloorControllerr@store');
    Route::get('/{id}', 'FloorController@show');
    Route::put('/{id}', 'FloorController@update');
    Route::delete('/{id}', 'FloorController@delete');
});

Route::group([
    'prefix' => '/categories' 
    // 'middleware' => 'auth'
], function () {
    Route::get('/', 'CategoryController@index');
    Route::post('/', 'CategoryController@store');
    Route::get('/{id}', 'CategoryController@show');
    Route::put('/{id}', 'CategoryController@update');
    Route::delete('/{id}', 'CategoryController@delete');
});

Route::get('/home', 'HomeController@index')->name('home');
