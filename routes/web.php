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
  'prefix' => 'master/floor' 
  // 'middleware' => 'auth'
], function () {
  Route::get('/', 'FloorController@index')->name('master.floor.show');
  Route::post('/', 'FloorController@store')->name('master.floor.store');
  Route::get('/{id}', 'FloorController@show')->name('master.floor.find');
  Route::put('/{id}', 'FloorController@update')->name('master.floor.update');;
  Route::delete('/{id}', 'FloorController@delete')->name('master.floor.delete');
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

Route::get('/master', 'MasterController@index')->name('master');

//route ajax livesearch
Route::get('search', 'FloorController@search')->name('master.floor.search');
