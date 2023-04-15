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

Route::view('/', 'home')->name('index');


// product
Route::get('product', 'ProductController@index')->name('product');
Route::get('product/{id}', 'ProductController@byId');

// cart
Route::get('chart', 'ChartController@index')->name('chart');
Route::post('chart', 'ChartController@store');
Route::delete('chart/{id}', 'ChartController@delete');
Route::post('chart/change_qty', 'ChartController@change_qty');

// checkout
Route::post('checkout', 'TransactionController@store');

// report
Route::get('report/by_user', 'ReportController@byUser')->name('report.by_user');
Route::get('report/all', 'ReportController@all')->name('report.all');

//Route::resource('customers', 'CustomersController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
