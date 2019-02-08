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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/categories', 'CategoryController');
Route::post('/categories/load', 'CategoryController@load');
Route::get('/welcome', 'CategoryController@load');

Route::resource('/items', 'ItemController');
Route::resource('/warehouses', 'WarehouseController');
Route::resource('/receives', 'ReceiveController');
Route::get('/getCategories', 'ItemController@getCategories');
Route::get('/getItems/{id}', 'ReceiveController@getItems');



Route::get('/sendmail', function() 
{
	$data = array('name' => 'Jordan');
	
	Mail::send('/welcome', $data, function($message)
	{
		$message->to('hhz18@icloud.com')
		->subject('New Category created!');
	});
});