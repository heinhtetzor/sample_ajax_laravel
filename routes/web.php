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

Route::get('/','CategoryController@home');
Route::resource('/categories', 'CategoryController');
Route::post('/categories/load', 'CategoryController@load');
Route::get('/welcome', 'CategoryController@load');

Route::get('/batch', 'TestController@batchSave');

Route::resource('/items', 'ItemController');
Route::resource('/warehouses', 'WarehouseController');
Route::resource('/receives', 'ReceiveController');
Route::get('/getCategories', 'ItemController@getCategories');
Route::get('/getItems/{id}', 'ReceiveController@getItems');
