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

Route::prefix('/employer')->group(function () {
    // Route::get('/login','Auth\EmployerController@showLoginForm')->name('employerlogin');
    Route::post('/login', 'Auth\EmployerController@login')->name('employer.login');
    // Route::get('/register','Auth\EmployerController@showRegisterPage')->name('employerregister');
    Route::post('/register', 'Auth\EmployerController@register')->name('employer.register');
});

Route::group(['prefix' => '/generalmanager',  'middleware' => 'generalmanager'], function() {

});

Route::group(['prefix' => '/admin',  'middleware' => ['generalmanager', 'admin']], function() {

});

Route::group(['prefix' => '/collector',  'middleware' => ['generalmanager', 'admin', 'collector']], function() {

});

Route::get('/home', 'HomeController@index')->name('home');
