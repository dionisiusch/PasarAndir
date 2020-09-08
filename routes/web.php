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

Route::get('/', 'HomeController@index')->name('home')->middleware('role:generalmanager');
Route::get('/home', 'HomeController@index')->middleware('role:generalmanager');

Auth::routes();

Route::group([
    'prefix' => '/employer'
], function () {
    Route::post('/login', 'Auth\EmployerLoginController@login')->name('employer.login');
    Route::get('/logout', 'Auth\EmployerLoginController@logout')->name('employer.logout');
});


Route::group([
    'prefix' => '/master',
    'middleware' => 'role:generalmanager'
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
        Route::put('/{id}', 'AreaController@update')->name('master.area.update');
        Route::delete('/{id}', 'AreaController@destroy')->name('master.area.delete');
    });

    Route::group([
        'prefix' => '/stall'
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'StallController@index')->name('master.stall.index');
        Route::post('/', 'StallController@store')->name('master.stall.store');
        Route::get('/{id}', 'StallController@show')->name('master.stall.show');
        Route::put('/{id}', 'StallController@update')->name('master.stall.update');
        Route::delete('/{id}', 'StallController@destroy')->name('master.stall.delete');
    });

    Route::group([
        'prefix' => '/electricity'
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'ElectricityController@index')->name('master.electricity.index');
        Route::post('/', 'ElectricityController@store')->name('master.electricity.store');
        Route::get('/{id}', 'ElectricityController@show')->name('master.electricity.show');
        Route::put('/{id}', 'ElectricityController@update')->name('master.electricity.update');
        Route::delete('/{id}', 'ElectricityController@destroy')->name('master.electricity.delete');
    });

    Route::group([
        'prefix' => '/invoice'
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'InvoiceController@index')->name('master.invoice.index');
        Route::post('/', 'InvoiceController@store')->name('master.invoice.store');
        Route::get('/{id}', 'InvoiceController@show')->name('master.invoice.show');
        Route::get('/{id}/remain', 'InvoiceController@remainCreditInvoice')->name('master.invoice.remain');
        Route::put('/{id}', 'InvoiceController@update')->name('master.invoice.update');
        Route::put('/{id}/status', 'InvoiceController@updateStatus')->name('master.invoice.updateStatus');
        Route::delete('/{id}', 'InvoiceController@destroy')->name('master.invoice.delete');
    });

    Route::group([
        'prefix' => '/receipt'
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'ReceiptController@index')->name('master.receipt.index');
        Route::post('/', 'ReceiptController@store')->name('master.receipt.store');
        Route::get('/{id}', 'ReceiptController@show')->name('master.receipt.show');
        Route::put('/{id}', 'ReceiptController@update')->name('master.receipt.update');
        Route::delete('/{id}', 'ReceiptController@destroy')->name('master.receipt.delete');
    });
    Route::group([
        'prefix' => '/user'
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'UserController@index')->name('master.user.index');
        Route::get('/register', 'UserController@register')->name('master.user.register');
        Route::get('/{id}', 'UserController@show')->name('master.user.show');
        Route::put('/{id}/pic', 'UserController@updatePIC')->name('master.user.store');
        Route::put('/{id}/auth', 'UserController@updateAuth')->name('master.user.update');
        Route::put('/{id}/password/reset', 'UserController@resetPassword')->name('master.user.reset');
        Route::delete('/{id}', 'UserController@resetToDefault')->name('master.user.delete');
    });

    Route::group([
        'prefix' => '/employer'
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'EmployerController@index')->name('master.employer.index');
        Route::get('/{id}', 'EmployerController@show')->name('master.employer.show');
        Route::put('/{id}', 'EmployerController@update')->name('master.employer.update');
        Route::get('/register', 'EmployerController@register')->name('master.employer.register');
        Route::put('/{id}/password', 'EmployerController@updatePassword')->name('master.employer.updatePassword');
        Route::delete('/{id}', 'EmployerController@destroy')->name('master.employer.delete');
        Route::post('/', 'Auth\EmployerRegisterController@register')->name('master.employer.store');
    });
});

Route::group([
    'prefix' => '/user',
    'middleware' => 'auth:web'
], function () {
    Route::get('/', 'HomeController@indexUser')->name('home.user');
    Route::get('/index', 'HomeController@indexUser')->name('user.index');
    Route::get('/billing', 'UserController@billing')->name('user.billing');
    Route::get('/payment/history', 'InvoiceReceiptController@paymentHistory')->name('master.user.history');
    Route::put('/password', 'UserController@updatePassword')->name('master.user.updatePassword');
    Route::get('/{id}', 'UserController@show')->name('master.user.show');
    Route::get('/{id}/stall', 'UserController@getStallByUserId')->name('master.user.stall');
    Route::get('/invoice/{id}', 'InvoiceController@show')->name('master.user.invoice');
    Route::get('/invoice/{id}/stall', 'InvoiceController@showInvoicesByStallId')->name('master.user.stall.invoice');
    Route::get('/receipt/{id}/stall', 'ReceiptController@showReceiptsByStallId')->name('master.user.stall.invoice');
});

//route ajax livesearch
Route::get('/floorsearch', 'FloorController@search')->name('master.floor.search');
Route::get('/areasearch', 'AreaController@search')->name('master.area.search');
Route::get('/categorysearch', 'CategoryController@search')->name('master.category.search');
Route::get('/electricitysearch', 'ElectricityController@search')->name('master.electricity.search');
Route::get('/stallsearch', 'StallController@search')->name('master.stall.search');
Route::get('/usersearch', 'UserController@search')->name('master.user.search');
Route::get('/employersearch', 'EmployerController@search')->name('master.employer.search');
Route::get('/receiptsearch', 'ReceiptController@search')->name('master.receipt.search');
Route::get('/invoicesearch', 'InvoiceController@search')->name('master.invoice.search');
Route::get('/invoicereceiptsearch', 'InvoiceController@searchForReceipt')->name('master.invoice.searchforreceipt');

//route aax select2
Route::get('/floorselect2', 'floorController@select2')->name('master.floor.select2');
Route::get('/areaselect2', 'areaController@select2')->name('master.area.select2');
Route::get('/userselect2', 'userController@select2')->name('master.user.select2');
Route::get('/categoryselect2', 'categoryController@select2')->name('master.category.select2');
Route::get('/employerselect2', 'employerController@select2')->name('master.employer.select2');
Route::get('/stallselect2', 'stallController@select2')->name('master.stall.select2');

//route chart
Route::get('/chartstall', 'ChartController@stall')->name('chart.stall');
Route::get('/chartinvoice', 'ChartController@invoice')->name('chart.invoice');

//route notification
Route::get('/notification/invoices/unpaid/gracedate', 'NotificationController@getUnpaidInvoicesThatPassTheGraceDate');

//route meteran
Route::get('/meteran', 'meteranController@index')->name('meteran.index');
Route::get('/meteranelectricity', 'meteranController@getElectricityName')->name('meteran.electricity.name');
Route::post('/', 'MeteranController@store')->name('meteran.store');
Route::get('/invoicecreate', 'InvoiceController@create')->name('invoice.create');
Route::get('/receiptcreate', 'ReceiptController@create')->name('receipt.create');
