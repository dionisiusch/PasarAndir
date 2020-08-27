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

Route::post('/employer/login', 'Auth\EmployerLoginController@login')->name('employer.login');

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
        Route::put('/{id}', 'FloorController@update')->name('master.floor.update');
        Route::delete('/{id}', 'FloorController@destroy')->name('master.floor.delete');
    });
    
    Route::group([
        'prefix' => '/category' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'CategoryController@index')->name('master.category.show');
        Route::post('/', 'CategoryController@store')->name('master.category.store');
        Route::get('/{id}', 'CategoryController@show')->name('master.category.find');
        Route::put('/{id}', 'CategoryController@update')->name('master.category.update');
        Route::delete('/{id}', 'CategoryController@destroy')->name('master.category.delete');
    });

    Route::group([
        'prefix' => '/area' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'AreaController@index')->name('master.area.index');
        Route::post('/', 'AreaController@store')->name('master.area.store');
        Route::get('/{id}', 'AreaController@show')->name('master.area.show');
        Route::put('/{id}', 'AreaController@update')->name('master.area.update');;
        Route::delete('/{id}', 'AreaController@destroy')->name('master.area.delete');
    });

    Route::group([
        'prefix' => '/stall' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'StallController@index')->name('master.stall.index');
        Route::post('/', 'StallController@store')->name('master.stall.store');
        Route::get('/{id}', 'StallController@show')->name('master.stall.show');
        Route::put('/{id}', 'StallController@update')->name('master.stall.update');;
        Route::delete('/{id}', 'StallController@destroy')->name('master.stall.delete');
    });

    Route::group([
        'prefix' => '/electricity' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'ElectricityController@index')->name('master.electricity.index');
        Route::post('/', 'ElectricityController@store')->name('master.electricity.store');;
        Route::get('/{id}', 'ElectricityController@show')->name('master.electricity.show');;
        Route::put('/{id}', 'ElectricityController@update')->name('master.electricity.update');;
        Route::delete('/{id}', 'ElectricityController@destroy')->name('master.electricity.delete');;
    });

      Route::group([
        'prefix' => '/user' 
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'UserController@index')->name('master.user.index');
        Route::get('/{id}', 'UserController@show')->name('master.user.show');
        Route::put('/{id}/pic', 'UserController@updatePIC')->name('master.user.store');
        Route::put('/{id}/auth', 'UserController@updateAuth')->name('master.user.update');
        Route::put('/{id}/password/reset', 'UserController@resetPassword')->name('master.user.reset');
        Route::delete('/{id}', 'UserController@resetToDefault')->name('master.user.delete');
    });
});

Route::get('/home', 'HomeController@index')->name('home');

//route ajax livesearch
Route::get('/floorsearch', 'FloorController@search')->name('master.floor.search');
Route::get('/areasearch', 'AreaController@search')->name('master.area.search');
Route::get('/categorysearch', 'CategoryController@search')->name('master.category.search');
Route::get('/electricitysearch', 'ElectricityController@search')->name('master.electricity.search');
Route::get('/stallsearch', 'StallController@search')->name('master.stall.search');
Route::get('/usersearch', 'UserController@search')->name('master.user.search');

//route aax select2
Route::get('/floorselect2', 'floorController@select2')->name('master.floor.select2');
Route::get('/areaselect2', 'areaController@select2')->name('master.area.select2');
Route::get('/userselect2', 'userController@select2')->name('master.user.select2');
Route::get('/categoryselect2', 'categoryController@select2')->name('master.category.select2');